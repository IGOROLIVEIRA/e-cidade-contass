<?php

use Phinx\Migration\AbstractMigration;

class Oc14339 extends AbstractMigration
{
    public function up()
    {
      $sql = <<<SQL
      UPDATE configuracoes.db_itensmenu
      SET descricao='Protocolo Financeiro'
      WHERE id_item=4001103;
SQL;
      $this->execute($sql);
    }
}
