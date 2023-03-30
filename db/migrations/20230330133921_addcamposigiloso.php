<?php

use Phinx\Migration\AbstractMigration;

class Addcamposigiloso extends AbstractMigration
{
    public function up()
    {
        $sql = "alter table liclicitem add column l21_sigilo bool";
        $this->execute($sql);
    }
}
