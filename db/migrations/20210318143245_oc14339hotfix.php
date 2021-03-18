<?php

use Phinx\Migration\AbstractMigration;

class Oc14339hotfix extends AbstractMigration
{
  public function up()
  {
    $sql = <<<SQL
      UPDATE configuracoes.db_itensmenu
      SET descricao='Protocolo Financeiro'
      WHERE descricao ilike 'Protocolo%'
SQL;
    $this->execute($sql);
  }
}
