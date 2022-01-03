<?php

use Phinx\Migration\AbstractMigration;

class NoTaskNumTipoProc extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO acordogruponumeracao
        SELECT nextval('acordogruponumeracao_ac03_sequencial_seq') AS ac03_sequencial,
              ac03_acordogrupo,
              2022 AS ac03_anousu,
              0 AS ac03_numero,
              ac03_instit
        FROM acordogruponumeracao
        WHERE ac03_anousu = 2021;

        COMMIT;

SQL;

        $this->execute($sql);
    }
}
