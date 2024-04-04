<?php

use Phinx\Migration\AbstractMigration;

class HotFixSeqDcasp extends AbstractMigration
{
    public function up()
    {
        $sqlSeq = <<<SQL
            -- public.dipr102024_si230_sequencial_seq definition

            DROP SEQUENCE IF EXISTS public.dipr102024_si230_sequencial_seq CASCADE;

            CREATE SEQUENCE public.dipr102024_si230_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1;


            -- public.dipr202024_si231_sequencial_seq definition

            DROP SEQUENCE IF EXISTS public.dipr202024_si231_sequencial_seq CASCADE;

            CREATE SEQUENCE public.dipr202024_si231_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1;


            -- public.dipr302024_si232_sequencial_seq definition

            DROP SEQUENCE IF EXISTS public.dipr302024_si232_sequencial_seq CASCADE;

            CREATE SEQUENCE public.dipr302024_si232_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1;


            -- public.dipr402024_si233_sequencial_seq definition

            DROP SEQUENCE IF EXISTS public.dipr402024_si233_sequencial_seq CASCADE;

            CREATE SEQUENCE public.dipr402024_si233_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1;


            -- public.dipr502024_si234_sequencial_seq definition

            DROP SEQUENCE IF EXISTS public.dipr502024_si234_sequencial_seq CASCADE;

            CREATE SEQUENCE public.dipr502024_si234_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1

SQL;

        $this->execute($sqlSeq);
    }
}
