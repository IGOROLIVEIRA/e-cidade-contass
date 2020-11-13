<?php

use Phinx\Migration\AbstractMigration;

class Oc13500 extends AbstractMigration
{
    public function up()
    {
        $rsResult = db_query($sSql = "SELECT * FROM orcsuplemtipo WHERE o48_tiposup IN (1018, 1019)");

        if(pg_num_rows($rsResult) == 0)
        {
            $sql = "
                BEGIN;

                INSERT INTO orcsuplemtipo
                SELECT 1018 AS o48_tiposup,
                       'CREDITOS EXTRAORDINARIOS - ANULACOES DE DOTACOES' AS o48_descr,
                       63 AS o48_coddocsup,
                       51 AS o48_coddocred,
                       0 AS o48_arrecadmaior,
                       'f' AS o48_superavit,
                       63 AS o48_suplcreditoespecial,
                       51 AS o48_redcreditoespecial;

                INSERT INTO orcsuplemtipo
                SELECT 1019 AS o48_tiposup,
                       'CREDITOS EXTRAORDINARIOS - EXCESSO DE ARRECADACOES' AS o48_descr,
                       63 AS o48_coddocsup,
                       51 AS o48_coddocred,
                       0 AS o48_arrecadmaior,
                       'f' AS o48_superavit,
                       63 AS o48_suplcreditoespecial,
                       51 AS o48_redcreditoespecial;

                COMMIT
                ";

            $this->execute($sql);
        }
    }
}
