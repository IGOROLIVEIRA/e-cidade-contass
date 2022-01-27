<?php 

use Phinx\Migration\AbstractMigration;

class Oc14995 extends AbstractMigration 
{ 
    PUBLIC FUNCTION up() 
    { 
        $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

    ALTER TABLE lqd102021 ADD COLUMN si118_dtsentenca DATE;

    COMMIT;

SQL;

        $this->execute($sql);
    }
}
