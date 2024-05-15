<?php

use Phinx\Migration\AbstractMigration;

class Oc18302 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        select fc_startsession();

        begin;
        
        alter table atolegal add ed05_i_aparecerelatorio bool default false; 
        
        commit;
        
        ";
        $this->execute($sql);
    }
}
