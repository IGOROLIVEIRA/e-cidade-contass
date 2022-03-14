<?php

use Phinx\Migration\AbstractMigration;

class Oc16418Sicom extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        CREATE SEQUENCE dipr202022_si231_sequencial_seq;

        -- Table Definition
        CREATE TABLE "public"."dipr202022" (
        "si231_sequencial" int8 NOT NULL DEFAULT nextval('dipr202022_si231_sequencial_seq'::regclass),
        "si231_tiporegistro" int8 NOT NULL DEFAULT 0,
        "si231_codorgao" varchar(2) NOT NULL,
        "si231_coddipr" int8 NOT NULL DEFAULT 0,
        "si231_tipobasecalculo" int8 NOT NULL DEFAULT 0,
        "si231_mescompetencia" int8 NOT NULL DEFAULT 0,
        "si231_exerciciocompetencia" int8 NOT NULL DEFAULT 0,
        "si231_tipofundo" int8 NOT NULL DEFAULT 0,
        "si231_remuneracaobrutafolhapag" float8 NOT NULL DEFAULT 0,
        "si231_tipobasecalculocontrprevidencia" int8 NOT NULL DEFAULT 0,
        "si231_tipobasecalculocontrseg" int8 NOT NULL DEFAULT 0,
        "si231_valorbasecalculocontr" float8 NOT NULL DEFAULT 0,
        "si231_tipocontribuicao" int8 NOT NULL DEFAULT 0,
        "si231_aliquota" float8 NOT NULL DEFAULT 0,
        "si231_valorcontribdevida" float8 NOT NULL DEFAULT 0,
        "si231_mes" int8 NOT NULL DEFAULT 0,
        "si231_instit" int8 NOT NULL DEFAULT 0,
        PRIMARY KEY ("si231_sequencial")
        );

        CREATE SEQUENCE dipr302022_si232_sequencial_seq;

        -- Table Definition
        CREATE TABLE "public"."dipr302022" (
        "si232_sequencial" int8 NOT NULL DEFAULT nextval('dipr302022_si232_sequencial_seq'::regclass),
        "si232_tiporegistro" int8 NOT NULL DEFAULT 0,
        "si232_codorgao" varchar(2) NOT NULL,
        "si232_coddipr" int8 NOT NULL DEFAULT 0,
        "si232_mescompetencia" int8 NOT NULL DEFAULT 0,
        "si232_exerciciocompetencia" int8 NOT NULL DEFAULT 0,
        "si232_tipofundo" int8 NOT NULL DEFAULT 0,
        "si232_tiporepasse" int8 NOT NULL DEFAULT 0,
        "si232_tipocontripatronal" int8 NOT NULL DEFAULT 0,
        "si232_tipocontrisegurado" int8 NOT NULL DEFAULT 0,
        "si232_tipocontribuicao" int8 NOT NULL DEFAULT 0,
        "si232_datarepasse" date NOT NULL,
        "si232_datavencirepasse" date NOT NULL,
        "si232_valororiginal" float8 NOT NULL DEFAULT 0,
        "si232_valororiginalrepassado" float8 NOT NULL DEFAULT 0,
        "si232_mes" int8 NOT NULL DEFAULT 0,
        "si232_instit" int8 NOT NULL DEFAULT 0,
        PRIMARY KEY ("si232_sequencial")
        );

        CREATE SEQUENCE dipr402022_si233_sequencial_seq;

        -- Table Definition
        CREATE TABLE "public"."dipr402022" (
        "si233_sequencial" int8 NOT NULL DEFAULT nextval('dipr402022_si233_sequencial_seq'::regclass),
        "si233_tiporegistro" int8 NOT NULL DEFAULT 0,
        "si233_codorgao" varchar(2) NOT NULL,
        "si233_coddipr" int8 NOT NULL DEFAULT 0,
        "si233_mescompetencia" int8 NOT NULL DEFAULT 0,
        "si233_exerciciocompetencia" int8 NOT NULL DEFAULT 0,
        "si233_tipofundo" int8 NOT NULL DEFAULT 0,
        "si233_tiporepasse" int8 NOT NULL DEFAULT 0,
        "si233_tipocontripatronal" int8 NOT NULL DEFAULT 0,
        "si233_tipocontrisegurado" int8 NOT NULL DEFAULT 0,
        "si233_tipocontribuicao" int8 NOT NULL DEFAULT 0,
        "si233_tipodeducao" int8 NOT NULL DEFAULT 0,
        "si233_dsctiposdeducoes" text NOT NULL,
        "si233_valordeducao" float8 NOT NULL DEFAULT 0,
        "si233_mes" int8 NOT NULL DEFAULT 0,
        "si233_instit" int8 NOT NULL DEFAULT 0,
        PRIMARY KEY ("si233_sequencial")
        );

        CREATE SEQUENCE dipr502022_si234_sequencial_seq;

        -- Table Definition
        CREATE TABLE "public"."dipr502022" (
        "si234_sequencial" int8 NOT NULL DEFAULT nextval('dipr502022_si234_sequencial_seq'::regclass),
        "si234_tiporegistro" int8 NOT NULL DEFAULT 0,
        "si234_codorgao" varchar(2) NOT NULL,
        "si234_coddipr" int8 NOT NULL DEFAULT 0,
        "si234_mescompetencia" int8 NOT NULL DEFAULT 0,
        "si234_exerciciocompetencia" int8 NOT NULL DEFAULT 0,
        "si234_tipofundo" int8 NOT NULL DEFAULT 0,
        "si234_tipoaportetransf" int8 NOT NULL DEFAULT 0,
        "si234_dscoutrosaportestransf" text NOT NULL,
        "si234_atonormativo" int8 NOT NULL DEFAULT 0,
        "si234_exercicioato" int8 NOT NULL DEFAULT 0,
        "si234_valoraportetransf" float8 NOT NULL DEFAULT 0,
        "si234_mes" int8 NOT NULL DEFAULT 0,
        "si234_instit" int8 NOT NULL DEFAULT 0,
        PRIMARY KEY ("si234_sequencial")
        );
 
        COMMIT;

SQL;
        $this->execute($sql);
    } 
}
