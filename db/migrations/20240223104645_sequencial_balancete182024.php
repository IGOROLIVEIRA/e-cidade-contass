<?php

use Phinx\Migration\AbstractMigration;

class SequencialBalancete182024 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            -- public.balancete182024_si185_sequencial_seq definition

            -- DROP SEQUENCE public.balancete182024_si185_sequencial_seq;

            CREATE SEQUENCE public.balancete182024_si185_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.ddc202024_si154_sequencial_seq definition

            -- DROP SEQUENCE public.ddc202024_si154_sequencial_seq;

            CREATE SEQUENCE public.ddc202024_si154_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;
        ";
        $this->execute($sql);
    }
}
