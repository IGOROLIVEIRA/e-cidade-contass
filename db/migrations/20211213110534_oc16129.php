<?php

use Phinx\Migration\AbstractMigration;

class Oc16129 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            ALTER TABLE liclicita ADD COLUMN l20_leidalicitacao int8;
            ALTER TABLE liclicita ADD COLUMN l20_dtpulicacaopncp date;
            ALTER TABLE liclicita ADD COLUMN l20_linkpncp varchar(200);
            ALTER TABLE liclicita ADD COLUMN l20_diariooficialdivulgacao int8;
            ALTER TABLE liclicita ADD COLUMN l20_dtpulicacaoedital date;
            ALTER TABLE liclicita ADD COLUMN l20_linkedital varchar(200);
            ALTER TABLE liclicita ADD COLUMN l20_mododisputa int8;
            ALTER TABLE adesaoregprecos ADD COLUMN si06_leidalicitacao int8;
            insert into pctipocompratribunal values(110,8,'Diálogo competitivo','MG');
            insert into pctipocompra values((select max(pc50_codcom) from pctipocompra)+1,'DIALOGO COMPETITIVO',110);
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
            ALTER TABLE liclicita DROP COLUMN l20_leidalicitacao;
            ALTER TABLE liclicita DROP COLUMN l20_dtpulicacaopncp;
            ALTER TABLE liclicita DROP COLUMN l20_linkpncp;
            ALTER TABLE liclicita DROP COLUMN l20_diariooficialdivulgacao;
            ALTER TABLE liclicita DROP COLUMN l20_dtpulicacaoedital;
            ALTER TABLE liclicita DROP COLUMN l20_linkedital;
            ALTER TABLE liclicita DROP COLUMN l20_mododisputa;
            ALTER TABLE adesaoregprecos DROP COLUMN si06_leidalicitacao;
        ";
        $this->execute($sql);
    }
}
