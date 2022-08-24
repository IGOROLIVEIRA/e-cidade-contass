<?php

use Phinx\Migration\AbstractMigration;

class Oc18222 extends AbstractMigration
{

    public function up()
    {
        $sql = "ALTER TABLE precoreferencia ADD si01_valorestimado bool default false;";

        $this->execute($sql);
    }
}
