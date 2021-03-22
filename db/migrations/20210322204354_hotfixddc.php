<?php

use Phinx\Migration\AbstractMigration;

class Hotfixddc extends AbstractMigration
{
  public function up()
  {
    $sql = <<<SQL

        BEGIN;

        SELECT setval('ddc102021_si150_sequencial_seq',
                  (SELECT max(si150_sequencial)
                   FROM ddc102021));

      COMMIT;
SQL;
    $this->execute($sql);
  }
}
