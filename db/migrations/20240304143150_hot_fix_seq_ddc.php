<?php

use Phinx\Migration\AbstractMigration;

class HotFixSeqDdc extends AbstractMigration
{
    public function up()
    {
        $sqlSeq = <<<SQL
        DROP SEQUENCE IF EXISTS public.ddc302024_si154_sequencial_seq CASCADE;

        CREATE SEQUENCE public.ddc302024_si178_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;
SQL;
        $this->execute($sqlSeq);
    }
}
