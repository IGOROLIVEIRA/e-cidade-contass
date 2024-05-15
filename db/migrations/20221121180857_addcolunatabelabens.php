<?php

use Phinx\Migration\AbstractMigration;

class Addcolunatabelabens extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        ALTER TABLE patrimonio.bens ADD t52_codexterno bigint;

        COMMIT;

SQL;
        $this->execute($sql);
    } 
}
