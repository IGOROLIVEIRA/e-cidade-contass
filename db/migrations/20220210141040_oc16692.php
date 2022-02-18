<?php

use Phinx\Migration\AbstractMigration;

class Oc16692 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        UPDATE contabancaria
                SET db83_numerocontratooc = null
                WHERE db83_numerocontratooc = ''; 
       
        COMMIT;

SQL;
        $this->execute($sql);
    }
}
