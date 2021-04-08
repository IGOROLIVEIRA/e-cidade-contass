<?php

use Phinx\Migration\AbstractMigration;

class Hotfixddc extends AbstractMigration
{
  public function up()
  {
    $sql = <<<SQL

        BEGIN;

        CREATE SEQUENCE ddc102021_si150_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        SELECT setval('ddc102021_si150_sequencial_seq',
                  (SELECT max(si150_sequencial)
                   FROM ddc102021));

      COMMIT;
SQL;
    $this->execute($sql);
  }
}
