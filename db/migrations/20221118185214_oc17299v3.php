<?php

use Phinx\Migration\AbstractMigration;

class Oc17299v3 extends AbstractMigration
{

    public function up()
    {
        $sql = "UPDATE protprocessodocumento SET p01_nivelacesso = 1;";
        $this->execute($sql);
    }
}
