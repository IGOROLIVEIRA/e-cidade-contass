<?php

use Phinx\Migration\AbstractMigration;

class Oc21128 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;
        
        ALTER TABLE precoreferencia ADD si01_casasdecimais INT;

        UPDATE precoreferencia SET si01_casasdecimais = 2;

        COMMIT;
        ";
        $this->execute($sql);

    }
}
