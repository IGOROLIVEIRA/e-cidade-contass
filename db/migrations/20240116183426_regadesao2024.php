<?php

use Phinx\Migration\AbstractMigration;

class Regadesao2024 extends AbstractMigration
{

    public function up()
    {
        $sql = "
                DROP TABLE public.regadesao102024 CASCADE;

                CREATE TABLE public.regadesao102024 (
                    si67_sequencial int8 NOT NULL DEFAULT 0,
                    si67_tiporegistro int8 NOT NULL DEFAULT 0,
                    si67_tipocadastro int4 NOT NULL,
                    si67_codorgao varchar(2) NOT NULL,
                    si67_codunidadesub varchar(8) NOT NULL,
                    si67_nroprocadesao varchar(12) NOT NULL,
                    si63_exercicioadesao int8 NOT NULL DEFAULT 0,
                    si67_dtabertura date NOT NULL,
                    si67_cnpjorgaogerenciador varchar(14) NOT NULL,
                    si67_exerciciolicitacao int8 NOT NULL DEFAULT 0,
                    si67_nroprocessolicitatorio varchar(20) NOT NULL,
                    si67_codmodalidadelicitacao int8 NOT NULL DEFAULT 0,
                    si67_regimecontratacao int8 NOT NULL,
                    si67_tipocriterio int8 not null,
                    si67_nroedital int4,
                    si67_exercicioedital int4,
                    si67_dtataregpreco date NOT NULL,
                    si67_dtvalidade date NOT NULL,
                    si67_naturezaprocedimento int8 NOT NULL DEFAULT 0,
                    si67_dtpublicacaoavisointencao date NULL,
                    si67_objetoadesao varchar(500) NOT NULL,
                    si67_cpfresponsavel varchar(11) NOT NULL,
                    si67_processoporlote int8 NOT NULL DEFAULT 0,
                    si67_mes int8 NOT NULL DEFAULT 0,
                    si67_instit int8 NULL DEFAULT 0,
                    si67_leidalicitacao int4 NULL,
                    CONSTRAINT regadesao102024_sequ_pk PRIMARY KEY (si67_sequencial)
                );

                DROP TABLE public.regadesao152024;
                DROP TABLE public.regadesao202024;

                CREATE TABLE public.regadesao202024 (
                    si72_sequencial int8 NOT NULL DEFAULT 0,
                    si72_tiporegistro int8 NOT NULL DEFAULT 0,
                    si72_codorgao varchar(2) NOT NULL,
                    si72_codunidadesub varchar(8) NOT NULL,
                    si72_nroprocadesao varchar(12) NOT NULL,
                    si72_exercicioadesao int8 NOT NULL DEFAULT 0,
                    si72_nrolote int8 NULL DEFAULT 0,
                    si72_coditem int8 NOT NULL DEFAULT 0,
                    si72_precounitario float8 NOT NULL DEFAULT 0,
                    si72_quantidadelicitada float8 NOT NULL DEFAULT 0,
                    si72_quantidadeaderida float8 NOT NULL DEFAULT 0,
                    si72_tipodocumento int8 NOT NULL DEFAULT 0,
                    si72_nrodocumento varchar(14) NOT NULL,
                    si72_mes int8 NOT NULL DEFAULT 0,
                    si72_reg10 int8 NOT NULL DEFAULT 0,
                    si72_instit int8 NULL DEFAULT 0,
                    CONSTRAINT regadesao202024_sequ_pk PRIMARY KEY (si72_sequencial)
                );

                DROP SEQUENCE regadesao152024_si72_sequencial_seq;

                CREATE SEQUENCE regadesao202024_si72_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                CREATE TABLE public.regadesao402024 (
                    si73_sequencial int8 NOT NULL DEFAULT 0,
                    si73_tiporegistro int8 NOT NULL DEFAULT 0,
                    si73_codorgao varchar(2) NOT NULL,
                    si73_codunidadesub varchar(8) NOT NULL,
                    si73_nroprocadesao varchar(12) NOT NULL,
                    si73_exercicioadesao int8 NOT NULL DEFAULT 0,
                    si73_nrolote int8 NULL DEFAULT 0,
                    si73_coditem int8 NULL DEFAULT 0,
                    si73_percdesconto float8 NOT NULL DEFAULT 0,
                    si73_tipodocumento int8 NOT NULL DEFAULT 0,
                    si73_nrodocumento varchar(14) NOT NULL,
                    si73_mes int8 NOT NULL DEFAULT 0,
                    si73_instit int8 NULL DEFAULT 0,
                    CONSTRAINT regadesao402024_sequ_pk PRIMARY KEY (si73_sequencial)
                );

                DROP SEQUENCE regadesao202024_si73_sequencial_seq;

                CREATE SEQUENCE regadesao402024_si72_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
        ";

        $this->execute($sql);
    }
}
