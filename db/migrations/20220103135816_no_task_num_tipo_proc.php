<?php

use Phinx\Migration\AbstractMigration;

class NoTaskNumTipoProc extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO numeracaotipoproc
        SELECT nextval('numeracaotipoproc_p200_codigo_seq') AS p200_codigo,
               2022 AS p200_ano,
               0 AS p200_numeracao,
               p200_tipoproc
        FROM numeracaotipoproc
        WHERE p200_ano = 2021;

        COMMIT;

SQL;

        $this->execute($sql);
    }
}
