<?php

use Classes\PostgresMigration;

class Oc14254 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL

        UPDATE db_itensmenu SET descricao = 'Emiss�o de Decreto' WHERE descricao = 'Emiss�o do Projeto';
  
        BEGIN;
        SELECT fc_startsession();

COMMIT;

SQL;
    $this->execute($sql);
  }

}
