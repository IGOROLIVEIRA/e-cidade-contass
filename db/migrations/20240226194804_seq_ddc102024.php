<?php

use Phinx\Migration\AbstractMigration;

class SeqDdc102024 extends AbstractMigration
{
    public function up()
    {
        $this->execute("DROP SEQUENCE IF EXISTS public.ddc102024_si153_sequencial_seq CASCADE;

        CREATE SEQUENCE public.ddc102024_si153_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1");
    }

}
