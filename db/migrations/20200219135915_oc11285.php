<?php

use Phinx\Migration\AbstractMigration;

class Oc11285 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        
        ALTER TABLE dadoscomplementareslrf ADD column ve81_codigonovo int4;

      COMMIT;
SQL;
        $this->execute($sql);
    }
}
