<?php

use Phinx\Migration\AbstractMigration;

class Addjustificativa extends AbstractMigration
{

    public function up()
    {
        $sqltabela = "
        alter table cflicita add column l03_presencial bool;
        alter table liclicita add column l20_justificativapncp text;
        ";
        $this->execute($sqltabela);

        $sSql = "";
        $aRowsInstit = $this->getInstit();
        foreach ($aRowsInstit as $aInstit) {
            $sSql .= "
                update cflicita set l03_presencial='t' where l03_pctipocompratribunal = 53;
                update cflicita set l03_presencial='t' where l03_pctipocompratribunal = 54;
                insert into cflicita values(nextval('cflicita_l03_codigo_seq'),'LEILAO ELETRONICO','H',(select max(pc50_codcom) from pctipocompra),'{$aInstit['codigo']}','f',54,'f');
                update cflicita set l03_presencial='t' where l03_pctipocompratribunal = 50;
                insert into cflicita values(nextval('cflicita_l03_codigo_seq'),'CONCORRENCIA ELETRONICO','H',(select max(pc50_codcom) from pctipocompra),'{$aInstit['codigo']}','f',50,'f');";
        }
        $this->execute($sSql);
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }
}
