<?php

use Classes\PostgresMigration;

class Oc14254 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        UPDATE db_itensmenu SET descricao = 'Emissão de Decreto' WHERE descricao = 'Emissão do Projeto';

        COMMIT;

SQL;
    $this->execute($sql);
  }

}
