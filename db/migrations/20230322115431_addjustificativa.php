<?php

use Phinx\Migration\AbstractMigration;

class Addjustificativa extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table cflicita add column l03_presencial bool;

            
        ";
    }
}
