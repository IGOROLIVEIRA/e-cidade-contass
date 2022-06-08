<?php

use Phinx\Migration\AbstractMigration;

class Oc16314Hotflix extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        ALTER TABLE configuracoes.contabancaria ALTER COLUMN db83_codigoopcredito TYPE varchar(11) USING db83_numerocontratooc::varchar;
       
        COMMIT;

SQL;
        $this->execute($sql);
    }
}
