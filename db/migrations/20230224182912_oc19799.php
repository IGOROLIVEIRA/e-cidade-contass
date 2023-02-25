<?php

use Phinx\Migration\AbstractMigration;

class Oc19799 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        DROP TABLE ddc102023;
        DROP TABLE ddc202023;
        DROP TABLE ddc302023;
        DROP TABLE ddc402023;

        CREATE TABLE public.ddc102023 (
                si153_sequencial int8 NOT NULL DEFAULT 0,
                si153_tiporegistro int8 NOT NULL DEFAULT 0,
                si153_codorgao varchar(2) NOT NULL,
                si153_nrocontratodivida varchar(30) NOT NULL,
                si153_dtassinatura date NOT NULL,
                si153_nroleiautorizacao varchar(6) NULL,
                si153_dtleiautorizacao date NULL,
                si153_objetocontratodivida varchar(1000) NOT NULL,
                si153_especificacaocontratodivida varchar(500) NOT NULL,
                si153_mes int8 NOT NULL DEFAULT 0,
                si153_instit int8 NULL DEFAULT 0,
                CONSTRAINT ddc202023_sequ_pk PRIMARY KEY (si153_sequencial)
        );

        CREATE TABLE public.ddc202023 (
                si154_sequencial int8 NOT NULL DEFAULT 0,
                si154_tiporegistro int8 NOT NULL DEFAULT 0,
                si154_codorgao varchar(2) NOT NULL,
                si154_nrocontratodivida varchar(30) NOT NULL DEFAULT '0'::character varying,
                si154_dtassinatura date NOT NULL,
                si154_tipolancamento varchar(2) NOT NULL,
                si154_subtipo varchar(1) NULL,
                si154_tipodocumentocredor int8 NOT NULL DEFAULT 0,
                si154_nrodocumentocredor varchar(14) NOT NULL,
                si154_justificativacancelamento varchar(500) NULL,
                si154_vlsaldoanterior float8 NOT NULL DEFAULT 0,
                si154_vlcontratacao float8 NOT NULL DEFAULT 0,
                si154_vlamortizacao float8 NOT NULL DEFAULT 0,
                si154_vlcancelamento float8 NOT NULL DEFAULT 0,
                si154_vlencampacao float8 NOT NULL DEFAULT 0,
                si154_vlatualizacao float8 NOT NULL DEFAULT 0,
                si154_vlsaldoatual float8 NOT NULL DEFAULT 0,
                si154_mes int8 NOT NULL DEFAULT 0,
                si154_instit int8 NULL DEFAULT 0,
                CONSTRAINT ddc302023_sequ_pk PRIMARY KEY (si154_sequencial)
        );

        CREATE TABLE public.ddc302023 (
                si178_sequencial int8 NOT NULL DEFAULT 0,
                si178_tiporegistro int8 NOT NULL DEFAULT 0,
                si178_codorgao varchar(2) NOT NULL,
                si178_passivoatuarial int8 NOT NULL DEFAULT 0,
                si178_vlsaldoanterior float8 NOT NULL DEFAULT 0,
                si178_vlsaldoatual float8 NULL DEFAULT 0,
                si178_mes int8 NOT NULL DEFAULT 0,
                si178_instit int8 NULL DEFAULT 0,
                CONSTRAINT ddc402023_sequ_pk PRIMARY KEY (si178_sequencial)
        );

        DROP SEQUENCE IF EXISTS public.ddc102023_si153_sequencial_seq CASCADE;

        CREATE SEQUENCE public.ddc102023_si153_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;


        -- public.ddc202023_si154_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.ddc202023_si154_sequencial_seq CASCADE;

        CREATE SEQUENCE public.ddc202023_si154_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;


        -- public.ddc402023_si178_sequencial_seq definition

        DROP SEQUENCE IF EXISTS public.ddc302023_si178_sequencial_seq CASCADE;

        CREATE SEQUENCE public.ddc302023_si178_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1;

        COMMIT;

SQL;
        $this->execute($sql);
 	}
}
