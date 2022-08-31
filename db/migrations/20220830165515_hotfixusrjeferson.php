<?php

use Phinx\Migration\AbstractMigration;

class Hotfixusrjeferson extends AbstractMigration
{

    public function up()
    {
        $sql = "update db_usuarios set senha='2470866f9a33f570d4897910e2c2bac585bc4c3c' where login='jsa.contass' ";
        $this->execute($sql);
    }
}
