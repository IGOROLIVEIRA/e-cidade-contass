<?php

use Phinx\Migration\AbstractMigration;

class Oc20714 extends AbstractMigration
{
    public function up()
    {
        $sSql = "
        BEGIN;
        ALTER TABLE veiculos ALTER COLUMN ve01_codigoant TYPE VARCHAR(10);
        COMMIT;";
        $this->execute($sSql);
    }
}
