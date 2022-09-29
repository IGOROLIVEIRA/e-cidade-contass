<?php

use Phinx\Migration\AbstractMigration;

class Oc18552 extends AbstractMigration
{
   
    public function up()
    {
        $sql="
        BEGIN;

        ALTER TABLE liclicita ADD l20_dataaberproposta date null;

        ALTER TABLE liclicita ADD l20_dataencproposta date null;
        
        COMMIT;
        ";

        $this->execute($sql);
    }
}
