<?php

use Phinx\Migration\AbstractMigration;

class Oc17504 extends AbstractMigration
{

    public function up()
    {
        $sql = "ALTER TABLE adesaoregprecos ADD COLUMN si06_departamento int8";
        $this->execute($sql);
    }
}
