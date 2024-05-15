<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class AcertaSequenciaDbItensmenu extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
          SELECT setval('db_itensmenu_id_item_seq', (select max(id_item) from db_itensmenu), FALSE);
        COMMIT;

SQL;
        $this->execute($sql);
    }

}
