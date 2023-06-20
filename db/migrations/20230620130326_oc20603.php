<?php

use Phinx\Migration\AbstractMigration;

class Oc20603 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            ALTER table emp102023 alter COLUMN si106_nrocontrato type varchar(14);
            ALTER TABLE manutencaolicitacao ADD COLUMN manutlic_editalant varchar(16);
            ALTER TABLE manutencaoacordo ADD COLUMN manutac_numeroant varchar(14);
        ";

        $this->execute($sql);
    }
}
