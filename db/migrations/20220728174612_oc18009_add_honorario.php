<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18009AddHonorario extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- ADICIONA CAMPO A TABELA DB_CONFIG
        ALTER TABLE configuracoes.db_config ADD COLUMN db21_honorarioadvocaticio int4 null;

        COMMIT;

SQL;
        $this->execute($sql);
    }

}
