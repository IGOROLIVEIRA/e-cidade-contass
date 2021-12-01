<?php

use Phinx\Migration\AbstractMigration;

class Oc15792 extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE precoreferencia ADD column si01_cotacaoitem int");
       
    }
}
