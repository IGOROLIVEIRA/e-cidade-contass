<?php

use Classes\PostgresMigration;

class Oc13886 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        UPDATE db_syscampo
        SET tamanho = '15'
        WHERE nomecam = 'si53_valorisco';


        UPDATE db_syscampo
        SET tamanho = '15'
        WHERE nomecam = 'si54_valorassociado';

        COMMIT;

SQL;
    $this->execute($sql);
 	}

}
