<?php

use Phinx\Migration\AbstractMigration;

class Oc20603 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            ALTER table emp102023 alter COLUMN si106_nrocontrato type varchar(14);
            ALTER table contratos202023 alter COLUMN si87_nrocontrato type varchar(14);
            ALTER table contratos302023 alter COLUMN si89_nrocontrato type varchar(14);
            ALTER table contratos402023 alter COLUMN si91_nrocontrato type varchar(14);
            ALTER TABLE manutencaolicitacao ADD COLUMN manutlic_editalant varchar(16);
            ALTER TABLE manutencaoacordo ADD COLUMN manutac_numeroant varchar(14);
        ";

        $this->execute($sql);
    }
}
