<?php

use Phinx\Migration\AbstractMigration;

class Oc21031att extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table liccontrolepncpitens add column l214_fornecedor int8;
            alter table liccontrolepncpitens add column l214_sequencialresultado int8;
        ";
        $this->execute($sql);
    }
}
