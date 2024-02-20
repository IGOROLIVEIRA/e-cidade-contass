<?php

use Phinx\Migration\AbstractMigration;

class SequencialBalancete2024 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            -- public.balancete102024_si177_sequencial_seq definition

            -- DROP SEQUENCE public.balancete102024_si177_sequencial_seq;

            CREATE SEQUENCE public.balancete102024_si177_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete112024_si178_sequencial_seq definition

            -- DROP SEQUENCE public.balancete112024_si178_sequencial_seq;

            CREATE SEQUENCE public.balancete112024_si178_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete122024_si179_sequencial_seq definition

            -- DROP SEQUENCE public.balancete122024_si179_sequencial_seq;

            CREATE SEQUENCE public.balancete122024_si179_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;


            -- public.balancete132024_si180_sequencial_seq definition

            -- DROP SEQUENCE public.balancete132024_si180_sequencial_seq;

            CREATE SEQUENCE public.balancete132024_si180_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete142024_si181_sequencial_seq definition

            -- DROP SEQUENCE public.balancete142024_si181_sequencial_seq;

            CREATE SEQUENCE public.balancete142024_si181_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete152024_si182_sequencial_seq definition

            -- DROP SEQUENCE public.balancete152024_si182_sequencial_seq;

            CREATE SEQUENCE public.balancete152024_si182_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete162024_si183_sequencial_seq definition

            -- DROP SEQUENCE public.balancete162024_si183_sequencial_seq;

            CREATE SEQUENCE public.balancete162024_si183_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete172024_si184_sequencial_seq definition

            -- DROP SEQUENCE public.balancete172024_si184_sequencial_seq;

            CREATE SEQUENCE public.balancete172024_si184_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete182024_si186_sequencial_seq definition

            -- DROP SEQUENCE public.balancete182024_si186_sequencial_seq;

            CREATE SEQUENCE public.balancete182024_si186_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete192024_si186_sequencial_seq definition

            -- DROP SEQUENCE public.balancete192024_si186_sequencial_seq;

            CREATE SEQUENCE public.balancete192024_si186_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete202024_si187_sequencial_seq definition

            -- DROP SEQUENCE public.balancete202024_si187_sequencial_seq;

            CREATE SEQUENCE public.balancete202024_si187_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete212024_si188_sequencial_seq definition

            -- DROP SEQUENCE public.balancete212024_si188_sequencial_seq;

            CREATE SEQUENCE public.balancete212024_si188_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete222024_si189_sequencial_seq definition

            -- DROP SEQUENCE public.balancete222024_si189_sequencial_seq;

            CREATE SEQUENCE public.balancete222024_si189_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete232024_si190_sequencial_seq definition

            -- DROP SEQUENCE public.balancete232024_si190_sequencial_seq;

            CREATE SEQUENCE public.balancete232024_si190_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete242024_si191_sequencial_seq definition

            -- DROP SEQUENCE public.balancete242024_si191_sequencial_seq;

            CREATE SEQUENCE public.balancete242024_si191_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;


            -- public.balancete252024_si195_sequencial_seq definition

            -- DROP SEQUENCE public.balancete252024_si195_sequencial_seq;

            CREATE SEQUENCE public.balancete252024_si195_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete262024_si196_sequencial_seq definition

            -- DROP SEQUENCE public.balancete262024_si196_sequencial_seq;

            CREATE SEQUENCE public.balancete262024_si196_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete272024_si197_sequencial_seq definition

            -- DROP SEQUENCE public.balancete272024_si197_sequencial_seq;

            CREATE SEQUENCE public.balancete272024_si197_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete282024_si198_sequencial_seq definition

            -- DROP SEQUENCE public.balancete282024_si198_sequencial_seq;

            CREATE SEQUENCE public.balancete282024_si198_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete292024_si241_sequencial_seq definition

            -- DROP SEQUENCE public.balancete292024_si241_sequencial_seq;

            CREATE SEQUENCE public.balancete292024_si241_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete302024_si242_sequencial_seq definition

            -- DROP SEQUENCE public.balancete302024_si242_sequencial_seq;

            CREATE SEQUENCE public.balancete302024_si242_sequencial_seq
                INCREMENT BY 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1
                NO CYCLE;

            -- public.balancete312024_si243_sequencial_seq definition

            -- DROP SEQUENCE public.balancete312024_si243_sequencial_seq;

            CREATE SEQUENCE public.balancete312024_si243_sequencial_seq
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
