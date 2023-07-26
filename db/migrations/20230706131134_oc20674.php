<?php

use Phinx\Migration\AbstractMigration;

class Oc20674 extends AbstractMigration
{

    public function up()
    {
        $sql = "ALTER table adesaoregprecos alter COLUMN si06_publicacaoaviso DROP NOT NULL;";
        $this->execute($sql);
    }
}
