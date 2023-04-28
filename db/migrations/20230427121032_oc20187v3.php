<?php

use Phinx\Migration\AbstractMigration;

class Oc20187v3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        ALTER TABLE dipr ADD c236_numcgmautarquia int8 NULL;

        INSERT INTO db_syscampo VALUES ((select max(codcam) + 1 from db_syscampo), 'c236_numcgmautarquia', 'int8', 'Autarquia', '0', 'Autarquia', 11, false, false, false, 1, 'text', 'Autarquia');


    COMMIT;

SQL;
        $this->execute($sql);
    } 
}