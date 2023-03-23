<?php

use Phinx\Migration\AbstractMigration;

class Addjustificativa extends AbstractMigration
{

    public function up()
    {
        $sSql = "";
        $aRowsInstit = $this->getInstit();
        foreach ($aRowsInstit as $aInstit) {
            $sSql .= "
            update cflicita set l03_presencial='f';
            update cflicita set l03_presencial='t' where l03_pctipocompratribunal = 53;
            update cflicita set l03_presencial='t' where l03_pctipocompratribunal = 54;
            update cflicita set l03_presencial='t' where l03_pctipocompratribunal = 50;
            insert into cflicita values(nextval('cflicita_l03_codigo_seq'),'LEILAO ELETRONICO','A',(select max(pc50_codcom) from pctipocompra),'{$aInstit['codigo']}','f',54,'f');
            insert into pccflicitapar values(nextval('pccflicitapar_l25_codigo_seq'),(select l03_codigo from cflicita where l03_descr='LEILAO ELETRONICO'),2023,0);
            insert into cflicita values(nextval('cflicita_l03_codigo_seq'),'CONCORRENCIA ELETRONICA','B',(select max(pc50_codcom) from pctipocompra),'{$aInstit['codigo']}','f',50,'f');
            insert into pccflicitapar values(nextval('pccflicitapar_l25_codigo_seq'),(select l03_codigo from cflicita where l03_descr='CONCORRENCIA ELETRONICA'),2023,0);
            
                ";
        }
        $this->execute($sSql);
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }
}
