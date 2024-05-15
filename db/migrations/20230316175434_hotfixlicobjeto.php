<?php

use Phinx\Migration\AbstractMigration;

class Hotfixlicobjeto extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;

        ALTER TABLE dispensa102023 ALTER COLUMN si74_objeto TYPE varchar(1000);

        ALTER TABLE aberlic102023 ALTER COLUMN si46_objeto TYPE varchar(1000);

        COMMIT;
        ";

        $this->execute($sql);
    }
}
