<?php

use Phinx\Migration\AbstractMigration;

class Oc21405 extends AbstractMigration
{
  
    public function up()
    {
        
        $sql = "
        begin;
            alter table protocolos alter column p101_observacao type varchar (600);
        commit;
        ";

        $this->execute($sql);
    
    }
}
