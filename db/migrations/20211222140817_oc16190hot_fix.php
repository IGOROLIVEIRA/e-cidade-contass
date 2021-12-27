<?php

use Phinx\Migration\AbstractMigration;

class Oc16190hotFix extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        ALTER TABLE contabancaria
        DROP COLUMN db83_numerocontratooc;

        ALTER TABLE contabancaria
        DROP COLUMN db83_dataassinaturacop;

        ALTER TABLE contabancaria ADD COLUMN db83_numerocontratooc varchar(30);
        ALTER TABLE contabancaria ADD COLUMN db83_dataassinaturacop  date; 

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
