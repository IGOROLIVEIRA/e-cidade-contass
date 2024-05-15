<?php

use Phinx\Migration\AbstractMigration;

class Oc16234 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        BEGIN;
        
        ALTER TABLE acordo ALTER COLUMN ac16_tipomodalidade TYPE varchar(40);
        
        COMMIT;
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        BEGIN;

        ALTER TABLE acordo ALTER COLUMN ac16_tipomodalidade TYPE varchar(30);
        
        COMMIT;
        ";

        $this->execute($sql);
    }
}
