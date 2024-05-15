<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc14254 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        UPDATE db_itensmenu SET descricao = 'Emiss�o de Decreto' WHERE descricao = 'Emiss�o do Projeto';

        COMMIT;

SQL;
    $this->execute($sql);
  }

}
