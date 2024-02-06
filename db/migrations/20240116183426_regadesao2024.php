<?php

use Phinx\Migration\AbstractMigration;

class Regadesao2024 extends AbstractMigration
{

    public function up()
    {
        $sql = "
                DROP TABLE public.regadesao102024 CASCADE;

                CREATE TABLE public.regadesao102024 (
                    si67_sequencial int8,
                    si67_tiporegistro int8 ,
                    si67_tipocadastro int4 ,
                    si67_codorgao varchar(2) ,
                    si67_codunidadesub varchar(8) ,
                    si67_nroprocadesao varchar(12) ,
                    si63_exercicioadesao int8  ,
                    si67_dtabertura date ,
                    si67_cnpjorgaogerenciador varchar(14) ,
                    si67_exerciciolicitacao int8  ,
                    si67_nroprocessolicitatorio varchar(20) ,
                    si67_codmodalidadelicitacao int8  ,
                    si67_regimecontratacao int8 ,
                    si67_tipocriterio int8,
                    si67_nroedital int4,
                    si67_exercicioedital int4,
                    si67_dtataregpreco date ,
                    si67_dtvalidade date ,
                    si67_naturezaprocedimento int8  ,
                    si67_dtpublicacaoavisointencao date NULL,
                    si67_objetoadesao varchar(500) ,
                    si67_cpfresponsavel varchar(11) ,
                    si67_processoporlote int8  ,
                    si67_mes int8  ,
                    si67_instit int8 NULL ,
                    si67_leidalicitacao int4 NULL,
                    CONSTRAINT regadesao102024_sequ_pk PRIMARY KEY (si67_sequencial)
                );

                DROP TABLE public.regadesao152024;
                DROP TABLE public.regadesao202024;

                CREATE TABLE public.regadesao202024 (
                    si72_sequencial int8  DEFAULT 0,
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

                CREATE SEQUENCE regadesao402024_si73_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                CREATE TABLE public.regadesao302024 (
                    si74_sequencial int8 NOT NULL DEFAULT 0,
                    si74_tiporegistro int8 NOT NULL DEFAULT 0,
                    si74_codorgao varchar(2) NOT NULL,
                    si74_codunidadesub varchar(8) NOT NULL,
                    si74_nroprocadesao varchar(12) NOT NULL,
                    si74_exercicioadesao int8 NOT NULL DEFAULT 0,
                    si74_nrolote int8 NULL DEFAULT 0,
                    si74_coditem int8 NULL DEFAULT 0,
                    si74_percdesconto float8 NOT NULL DEFAULT 0,
                    si74_tipodocumento int8 NOT NULL DEFAULT 0,
                    si74_nrodocumento varchar(14) NOT NULL,
                    si74_mes int8 NOT NULL DEFAULT 0,
                    si74_instit int8 NULL DEFAULT 0,
                    CONSTRAINT regadesao302024_sequ_pk PRIMARY KEY (si74_sequencial)
                );

                CREATE SEQUENCE regadesao302024_si74_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
        ";

        $this->execute($sql);
    }
}
