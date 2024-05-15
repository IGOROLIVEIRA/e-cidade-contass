<?php

use Phinx\Migration\AbstractMigration;

class Oc15722 extends AbstractMigration
{
    
    public function up()
    {
        $this->execute("ALTER TABLE manutencaolicitacao ALTER COLUMN manutlic_codunidsubanterior TYPE varchar(8)");
        $this->execute("ALTER TABLE manutencaoacordo ALTER COLUMN manutac_codunidsubanterior TYPE varchar(8)");
       
    }
}
