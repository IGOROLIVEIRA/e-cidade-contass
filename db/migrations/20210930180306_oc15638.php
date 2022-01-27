<?php

use Phinx\Migration\AbstractMigration;

class Oc15638 extends AbstractMigration
{
   
    public function up()
    {
        $this->execute("ALTER TABLE veicmanutitem ALTER COLUMN ve63_descr TYPE VARCHAR(50)");
       
    }
}
