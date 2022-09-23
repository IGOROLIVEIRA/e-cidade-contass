<?php

use Phinx\Migration\AbstractMigration;

class Oc18251at extends AbstractMigration
{
    
    public function up()
    {

        $sql="
        BEGIN;
        ALTER TABLE licitaparam ADD l12_pncp bool;
        UPDATE licitaparam SET l12_pncp = false;
        COMMIT;
        ";

    }
}
