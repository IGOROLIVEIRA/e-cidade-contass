<?php

use Phinx\Migration\AbstractMigration;

class Oc19047 extends AbstractMigration
{

    public function up()
    {
        $sql= "BEGIN;
        ALTER TABLE liclicita ADD l20_amparolegal INT8;
        COMMIT;
        ";
        
        $this->execute($sql);
    }
}
