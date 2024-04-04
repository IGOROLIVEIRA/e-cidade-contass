<?php

use Phinx\Migration\AbstractMigration;

class Oc22166 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        BEGIN;

        ALTER TABLE regadesao302024 ADD COLUMN si74_reg10 int;
        ALTER TABLE regadesao402024 ADD COLUMN si73_reg10 int;
        
        COMMIT;";
        $this->execute($sSql);
    }
}
