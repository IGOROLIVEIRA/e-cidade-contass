<?php

use Phinx\Migration\AbstractMigration;

class Oc19762v3 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            begin;   
 
            ALTER TABLE dclrf102023 DROP COLUMN si157_passivosreconhecidos;

            commit;
SQL;
        $this->execute($sql);
    }
}