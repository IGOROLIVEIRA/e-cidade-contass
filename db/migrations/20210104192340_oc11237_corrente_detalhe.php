<?php

use Classes\PostgresMigration;

class Oc11237CorrenteDetalhe extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE contacorrentedetalhe ADD column c19_emparlamentar int4;

        COMMIT;

SQL;
    $this->execute($sql);
 	}

}
