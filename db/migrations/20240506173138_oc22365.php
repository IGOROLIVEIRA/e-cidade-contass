<?php

use Phinx\Migration\AbstractMigration;

class Oc22365 extends AbstractMigration
{
    public function up()
    {
        $sSql = "ALTER TABLE ralic102024 ALTER COLUMN si180_vlcontratacao TYPE float8;";
        $this->execute($sSql);
    }
}
