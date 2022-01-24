<?php

use Phinx\Migration\AbstractMigration;

class Oc16350 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        ALTER TABLE slip ADD COLUMN k17_devolucao int4;

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
