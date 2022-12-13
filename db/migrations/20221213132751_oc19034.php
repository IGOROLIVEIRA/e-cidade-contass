<?php

use Phinx\Migration\AbstractMigration;

class Oc19034 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        BEGIN;
        ALTER TABLE licitaparam ADD l12_numeracaomanual bool default true;
        COMMIT";
        $this->execute($sSql);
    }
}
