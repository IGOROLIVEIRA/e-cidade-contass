<?php

use Classes\PostgresMigration;

class Oc14171 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();
                 
        ALTER TABLE balancete112021 DROP COLUMN si242_subelemento;

        ALTER TABLE balancete162021 ALTER COLUMN si183_codfontrecursos DROP NOT NULL;

        CREATE TABLE balancete292021 (
            si241_sequencial int8 NOT NULL DEFAULT 0,
            si241_tiporegistro int8 NOT NULL DEFAULT 0,
            si241_contacontabil int8 NOT NULL DEFAULT 0,
            si241_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
            si241_atributosf varchar(1) NOT NULL,
            si241_codfontrecursos int8 NOT NULL DEFAULT 0,
            si241_dividaconsolidada int4 NOT NULL DEFAULT 0,
            si241_saldoinicialfontsf float8 NOT NULL DEFAULT 0,
            si241_naturezasaldoinicialfontsf varchar(1) NOT NULL,
            si241_totaldebitosfontsf float8 NOT NULL DEFAULT 0,
            si241_totalcreditosfontsf float8 NOT NULL DEFAULT 0,
            si241_saldofinalfontsf float8 NOT NULL DEFAULT 0,
            si241_naturezasaldofinalfontsf varchar(1) NOT NULL,
            si241_mes int8 NOT NULL DEFAULT 0,
            si241_instit int8 NULL DEFAULT 0,
            si241_reg10 int8 NOT NULL,
            CONSTRAINT balancete292021_sequ_pk PRIMARY KEY (si241_sequencial),
            CONSTRAINT fk_balancete292021_reg10_fk FOREIGN KEY (si241_reg10) REFERENCES balancete102021(si177_sequencial)
        )
        WITH (
            OIDS=TRUE
        );

        CREATE SEQUENCE balancete292021_si241_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807;

        CREATE TABLE balancete302021 (
            si242_sequencial int8 NOT NULL DEFAULT 0,
            si242_tiporegistro int8 NOT NULL DEFAULT 0,
            si242_contacontaabil int8 NOT NULL DEFAULT 0,
            si242_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
            si242_codorgao varchar(2) NOT NULL,
            si242_codunidadesub varchar(8) NOT NULL,
            si242_codfuncao varchar(2) NOT NULL,
            si242_codsubfuncao varchar(3) NOT NULL,
            si242_codprograma varchar(4) NULL,
            si242_idacao varchar(4) NOT NULL,
            si242_idsubacao varchar(4) NOT NULL,
            si242_naturezadespesa int8 NOT NULL DEFAULT 0,
            si242_subelemento varchar(2) NOT NULL,
            si242_codfontrecursos int8 NOT NULL DEFAULT 0,
            si242_saldoinicialcd float8 NOT NULL DEFAULT 0,
            si242_naturezasaldoinicialcd varchar(1) NOT NULL,
            si242_totaldebitoscd float8 NOT NULL DEFAULT 0,
            si242_totalcreditoscd float8 NOT NULL DEFAULT 0,
            si242_saldofinalcd float8 NOT NULL DEFAULT 0,
            si242_naturezasaldofinalcd varchar(1) NOT NULL,
            si242_mes int8 NOT NULL DEFAULT 0,
            si242_instit int8 NULL DEFAULT 0,
            si242_reg10 int8 NOT NULL,
            CONSTRAINT balancete302021_sequ_pk PRIMARY KEY (si242_sequencial),
            CONSTRAINT fk_balancete302021_reg10_fk FOREIGN KEY (si242_reg10) REFERENCES balancete102021(si177_sequencial)
        )
        WITH (
            OIDS=TRUE
        );    

        CREATE SEQUENCE balancete302021_si242_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807;    

        CREATE TABLE balancete312021 (
            si243_sequencial int8 NOT NULL DEFAULT 0,
            si243_tiporegistro int8 NOT NULL DEFAULT 0,
            si243_contacontabil int8 NOT NULL DEFAULT 0,
            si243_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
            si243_naturezareceita int8 NOT NULL DEFAULT 0,
            si243_codfontrecursos int8 NOT NULL DEFAULT 0,
            si243_emendaparlamentar int4 NOT NULL DEFAULT 0,
            si243_saldoinicialcr float8 NOT NULL DEFAULT 0,
            si243_naturezasaldoinicialcr varchar(1) NOT NULL,
            si243_totaldebitoscr float8 NOT NULL DEFAULT 0,
            si243_totalcreditoscr float8 NOT NULL DEFAULT 0,
            si243_saldofinalcr float8 NOT NULL DEFAULT 0,
            si243_naturezasaldofinalcr varchar(1) NOT NULL,
            si243_mes int8 NOT NULL DEFAULT 0,
            si243_instit int8 NULL DEFAULT 0,
            si243_reg10 int8 NOT NULL,
            CONSTRAINT balancete312021_sequ_pk PRIMARY KEY (si243_sequencial),
            CONSTRAINT fk_balancete312021_reg10_fk FOREIGN KEY (si243_reg10) REFERENCES balancete102021(si177_sequencial)
        )
        WITH (
            OIDS=TRUE
        );

        CREATE SEQUENCE balancete312021_si243_sequencial_seq
            INCREMENT BY 1
            MINVALUE 1
            MAXVALUE 9223372036854775807;


        COMMIT;

SQL;
    $this->execute($sql);
 	}

}