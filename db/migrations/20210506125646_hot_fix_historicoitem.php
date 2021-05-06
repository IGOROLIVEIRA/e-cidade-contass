<?php

use Classes\PostgresMigration;

class HotFixHistoricoitem extends PostgresMigration
{
  public function up()
  {
    $sql = <<<SQL

        BEGIN;

        alter table historicoitem alter column pc96_descricaoanterior  type text

        COMMIT;
SQL;
    $this->execute($sql);
  }
}
