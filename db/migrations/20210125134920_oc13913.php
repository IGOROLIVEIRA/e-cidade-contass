<?php

use Classes\PostgresMigration;

class Oc13913 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        DROP TABLE ctb222021;
        DROP TABLE ctb212021;
        DROP TABLE ctb202021;

        CREATE TABLE ctb202021 (
            si96_sequencial int8 NOT NULL DEFAULT 0,
            si96_tiporegistro int8 NOT NULL DEFAULT 0,
            si96_codorgao varchar(2) NOT NULL,
            si96_codctb int8 NOT NULL DEFAULT 0,
            si96_codfontrecursos int8 NOT NULL DEFAULT 0,
            si96_saldocec int8 NULL DEFAULT 0,
            si96_vlsaldoinicialfonte float8 NOT NULL DEFAULT 0,
            si96_vlsaldofinalfonte float8 NOT NULL DEFAULT 0,
            si96_mes int8 NOT NULL DEFAULT 0,
            si96_instit int8 NULL DEFAULT 0,
            CONSTRAINT ctb202021_sequ_pk PRIMARY KEY (si96_sequencial)
        )
        WITH (
            OIDS=TRUE
        );

        CREATE TABLE ctb212021 (
            si97_sequencial int8 NOT NULL DEFAULT 0,
            si97_tiporegistro int8 NOT NULL DEFAULT 0,
            si97_codctb int8 NOT NULL DEFAULT 0,
            si97_codfontrecursos int8 NOT NULL DEFAULT 0,
            si97_codreduzidomov int8 NOT NULL DEFAULT 0,
            si97_tipomovimentacao int8 NOT NULL DEFAULT 0,
            si97_tipoentrsaida varchar(2) NOT NULL,
            si97_dscoutrasmov varchar(50) NULL,
            si97_saldocec int8 NULL DEFAULT 0,
            si97_valorentrsaida float8 NOT NULL DEFAULT 0,
            si97_codctbtransf int8 NULL DEFAULT 0,
            si97_codfontectbtransf int8 NOT NULL DEFAULT 0,
            si97_saldocectransf int8 NULL DEFAULT 0,
            si97_mes int8 NOT NULL DEFAULT 0,
            si97_reg20 int8 NOT NULL DEFAULT 0,
            si97_instit int8 NULL DEFAULT 0,
            CONSTRAINT ctb212021_sequ_pk PRIMARY KEY (si97_sequencial),
            CONSTRAINT ctb212021_reg20_fk FOREIGN KEY (si97_reg20) REFERENCES ctb202021(si96_sequencial)
        )
        WITH (
            OIDS=TRUE
        );

        CREATE TABLE ctb222021 (
            si98_sequencial int8 NOT NULL DEFAULT 0,
            si98_tiporegistro int8 NOT NULL DEFAULT 0,
            si98_codreduzidomov int8 NOT NULL DEFAULT 0,
            si98_ededucaodereceita int8 NOT NULL DEFAULT 0,
            si98_identificadordeducao int8 NULL DEFAULT 0,
            si98_naturezareceita int8 NOT NULL DEFAULT 0,
            si98_codfontrecursos int8 NOT NULL DEFAULT 0,
            si98_saldocec int8 NULL DEFAULT 0,
            si98_vlrreceitacont float8 NOT NULL DEFAULT 0,
            si98_mes int8 NOT NULL DEFAULT 0,
            si98_reg21 int8 NOT NULL DEFAULT 0,
            si98_instit int8 NULL DEFAULT 0,
            CONSTRAINT ctb222021_sequ_pk PRIMARY KEY (si98_sequencial),
            CONSTRAINT ctb222021_reg21_fk FOREIGN KEY (si98_reg21) REFERENCES ctb212021(si97_sequencial)
        )
        WITH (
            OIDS=TRUE
        );

        COMMIT;

SQL;
    $this->execute($sql);
 	}

}