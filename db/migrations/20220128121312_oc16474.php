<?php

use Phinx\Migration\AbstractMigration;

class Oc16474 extends AbstractMigration
{

    public function up()
    {
        $sql = "ALTER TABLE precoreferencia ADD COLUMN si01_impjustificativa bool NULL DEFAULT false;";
        $this->execute($sql);
    }
}
