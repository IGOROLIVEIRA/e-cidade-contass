<?php

use Phinx\Migration\AbstractMigration;

class Oc16738 extends AbstractMigration
{
    public function up()
    {
        $sSql = "
        ALTER TABLE empempenho ADD COLUMN e60_vlrutilizado float;
        ";
        $this->execute($sSql);
    }
}
