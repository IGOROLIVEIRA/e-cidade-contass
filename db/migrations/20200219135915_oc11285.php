<?php

use Phinx\Migration\AbstractMigration;

class Oc11285 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        
        DROP TABLE dfcdcasp102019;
        
        alter table dadoscomplementareslrf add column;

      COMMIT;
SQL;
        $this->execute($sql);
    }
}
