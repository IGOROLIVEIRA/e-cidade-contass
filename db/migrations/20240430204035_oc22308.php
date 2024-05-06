<?php

use Phinx\Migration\AbstractMigration;

class Oc22308 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE empenho.empagegera ALTER COLUMN e87_descgera TYPE varchar(100) USING e87_descgera::varchar(100) ;
        
        COMMIT;

SQL;
        $this->execute($sql);
    }
}