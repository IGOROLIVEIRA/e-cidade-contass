<?php

use Phinx\Migration\AbstractMigration;

class Oc18413 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        UPDATE pagordem
        SET
        e50_contribuicaoprev = ''
        WHERE
        e50_contribuicaoprev like '1';

        COMMIT;

SQL;
        $this->execute($sql);
    } 
}