<?php

use Phinx\Migration\AbstractMigration;

class Oc18364 extends AbstractMigration
{
    
    public function up()
    {
        $sql = <<<SQL
            begin;    

                alter table matmater add column m60_instit int4;
            commit;
SQL;
        $this->execute($sql);
    }
}
