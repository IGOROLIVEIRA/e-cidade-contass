<?php

use Phinx\Migration\AbstractMigration;

class Oc22231 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE efdreinfr2010 ALTER COLUMN efd05_estabelecimento TYPE varchar(500) USING efd05_estabelecimento::varchar(500);

        COMMIT;

SQL;
        $this->execute($sql);
    }
}