<?php

use Phinx\Migration\AbstractMigration;

class Oc11315 extends AbstractMigration
{
    public function up(){
        $this->execute("ALTER TABLE processocompralote ALTER COLUMN pc68_nome TYPE varchar(250)");
        $this->execute("ALTER TABLE liclicitemlote ALTER COLUMN l04_descricao TYPE varchar(250)");
        
    }
}
