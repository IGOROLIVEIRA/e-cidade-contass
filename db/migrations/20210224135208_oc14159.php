<?php

use Phinx\Migration\AbstractMigration;

class Oc14159 extends AbstractMigration
{  
    public function up()
    {
        $sSql = "ALTER TABLE arrecadacao.abatimentoutilizacao ADD COLUMN k157_observacao text";

        $this->execute($sSql); 
    } 
}
