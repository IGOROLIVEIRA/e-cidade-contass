<?php

use Phinx\Migration\AbstractMigration;

class SicomCvc2024 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            -- Drop table

                DROP TABLE public.cvc102024;

                CREATE TABLE public.cvc102024 (
                    si146_sequencial int8 NOT NULL DEFAULT 0,
                    si146_tiporegistro int8 NOT NULL DEFAULT 0,
                    si146_codorgao varchar(2) NOT NULL,
                    si146_codveiculo varchar(10) NOT NULL,
                    si146_tpveiculo varchar(2) NOT NULL,
                    si146_subtipoveiculo varchar(2) NOT NULL,
                    si146_descveiculo varchar(100) NOT NULL,
                    si146_marca varchar(50) NOT NULL,
                    si146_modelo varchar(50) NOT NULL,
                    si146_ano int8 NOT NULL DEFAULT 0,
                    si146_placa varchar(8) NULL,
                    si146_chassi varchar(30) NULL,
                    si146_numerorenavam int8 NULL DEFAULT 0,
                    si146_nroserie varchar(20) NULL,
                    si146_situacao varchar(2) NOT NULL,
                    si146_tipodocumento int8 NULL DEFAULT 0,
                    si146_nrodocumento varchar(14) NULL,
                    si146_tpdeslocamento varchar(2) NOT NULL,
                    si146_mes int8 NOT NULL DEFAULT 0,
                    si146_instit int8 NULL DEFAULT 0,
                    CONSTRAINT cvc102024_sequ_pk PRIMARY KEY (si146_sequencial)
                );

                -- Drop table

                DROP TABLE public.cvc202024;

                CREATE TABLE public.cvc202024 (
                    si147_sequencial int8 NOT NULL DEFAULT 0,
                    si147_tiporegistro int8 NOT NULL DEFAULT 0,
                    si147_codorgao varchar(2) NOT NULL,
                    si147_codveiculo varchar(10) NOT NULL,
                    si147_origemgasto int8 NOT NULL DEFAULT 0,
                    si147_codunidadesubempenho varchar(8) NULL,
                    si147_nroempenho int8 NULL DEFAULT 0,
                    si147_dtempenho date NULL,
                    si147_marcacaoinicial int8 NOT NULL DEFAULT 0,
                    si147_marcacaofinal int8 NOT NULL DEFAULT 0,
                    si147_tipogasto varchar(2) NOT NULL,
                    si147_qtdeutilizada float8 NOT NULL DEFAULT 0,
                    si147_vlgasto float8 NOT NULL DEFAULT 0,
                    si147_dscpecasservicos varchar(50) NULL,
                    si147_mes int8 NOT NULL DEFAULT 0,
                    si147_instit int8 NULL DEFAULT 0,
                    CONSTRAINT cvc202024_sequ_pk PRIMARY KEY (si147_sequencial)
                );

                -- Drop table

                DROP TABLE public.cvc302024;

                CREATE TABLE public.cvc302024 (
                    si148_sequencial int8 NOT NULL DEFAULT 0,
                    si148_tiporegistro int8 NOT NULL DEFAULT 0,
                    si148_codorgao varchar(2) NOT NULL,
                    si148_codveiculo varchar(10) NOT NULL,
                    si148_nomeestabelecimento varchar(250) NOT NULL,
                    si148_localidade varchar(250) NOT NULL,
                    si148_qtdediasrodados int8 NOT NULL DEFAULT 0,
                    si148_distanciaestabelecimento float8 NOT NULL DEFAULT 0,
                    si148_numeropassageiros int8 NOT NULL DEFAULT 0,
                    si148_turnos varchar(2) NOT NULL,
                    si148_mes int8 NOT NULL DEFAULT 0,
                    si148_instit int8 NULL DEFAULT 0,
                    CONSTRAINT cvc302024_sequ_pk PRIMARY KEY (si148_sequencial)
                );

                -- Drop table

                DROP TABLE public.cvc402024;

                DROP SEQUENCE cvc402024_si149_sequencial_seq;

                CREATE TABLE public.cvc502024 (
                    si149_sequencial int8 NOT NULL DEFAULT 0,
                    si149_tiporegistro int8 NOT NULL DEFAULT 0,
                    si149_codorgao varchar(2) NOT NULL,
                    si149_codveiculo varchar(10) NOT NULL,
                    si149_situacaoveiculoequip int8 NULL,
                    si149_tipobaixa int8 NOT NULL DEFAULT 0,
                    si149_descbaixa varchar(50) NULL,
                    si149_dtbaixa date NOT NULL,
                    si149_mes int8 NOT NULL DEFAULT 0,
                    si149_instit int8 NULL DEFAULT 0,
                    CONSTRAINT cvc502024_sequ_pk PRIMARY KEY (si149_sequencial)
                );

                CREATE SEQUENCE cvc502024_si149_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                CREATE TABLE public.cvc402024 (
                    si150_sequencial int8 NOT NULL DEFAULT 0,
                    si150_tiporegistro int8 NOT NULL DEFAULT 0,
                    si150_codorgao varchar(2) NOT NULL,
                    si150_codveiculo varchar(10) NOT NULL,
                    si150_placaatual varchar (7) NULL,
                    si150_mes int8 NOT NULL DEFAULT 0,
                    si150_instit int8 NULL DEFAULT 0,
                    CONSTRAINT cvc402024_sequ_pk PRIMARY KEY (si150_sequencial)
                );


                CREATE SEQUENCE cvc402024_si150_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
        ";
        $this->execute($sql);
    }
}
