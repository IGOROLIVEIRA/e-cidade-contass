<?php

use Phinx\Migration\AbstractMigration;

class Oc17746 extends AbstractMigration
{

    public function up()
    {
        $sql = 'ALTER TABLE acordo
        ADD ac16_datareferencia date null;';
        $this->execute($sql);
    }
}
