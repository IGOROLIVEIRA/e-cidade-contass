<?php

use Classes\PostgresMigration;

class Oc14254 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL

        UPDATE db_itensmenu SET descricao = 'Emissão de Decreto' WHERE descricao = 'Emissão do Projeto';
  
        BEGIN;
        SELECT fc_startsession();

COMMIT;

SQL;
    $this->execute($sql);
  }

}
