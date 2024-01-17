<?php

use Phinx\Migration\AbstractMigration;

class SicomAberlic2024 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            ALTER TABLE aberlic102024 add column si46_codunidadesubedital int8;
        ";

        $this->execute($sql);
    }
}
