<?php

use Phinx\Migration\AbstractMigration;

class Oc19786 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        DROP TABLE ctb222022;
        DROP TABLE ctb212022;
        DROP TABLE ctb202022;

        CREATE TABLE ctb202022 (
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
            CONSTRAINT ctb202022_sequ_pk PRIMARY KEY (si96_sequencial)
        );

        CREATE TABLE ctb212022 (
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
            CONSTRAINT ctb212022_sequ_pk PRIMARY KEY (si97_sequencial),
            CONSTRAINT ctb212022_reg20_fk FOREIGN KEY (si97_reg20) REFERENCES ctb202022(si96_sequencial)
        );

        CREATE TABLE ctb222022 (
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
            CONSTRAINT ctb222022_sequ_pk PRIMARY KEY (si98_sequencial),
            CONSTRAINT ctb222022_reg21_fk FOREIGN KEY (si98_reg21) REFERENCES ctb212022(si97_sequencial)
        );

        DROP TABLE ext202022;

        CREATE TABLE ext202022 (
            si165_sequencial int8 NOT NULL DEFAULT 0,
            si165_tiporegistro int8 NOT NULL DEFAULT 0,
            si165_codorgao varchar(2) NOT NULL,
            si165_codext int8 NOT NULL DEFAULT 0,
            si165_codfontrecursos int8 NOT NULL DEFAULT 0,
            si165_exerciciocompdevo int4 NULL DEFAULT 0,
            si165_vlsaldoanteriorfonte float8 NOT NULL DEFAULT 0,
            si165_natsaldoanteriorfonte varchar(1) NOT NULL,
            si165_totaldebitos float8 NOT NULL DEFAULT 0,
            si165_totalcreditos float8 NOT NULL DEFAULT 0,
            si165_vlsaldoatualfonte float8 NOT NULL DEFAULT 0,
            si165_natsaldoatualfonte varchar(1) NOT NULL,
            si165_mes int8 NOT NULL DEFAULT 0,
            si165_instit int8 NULL DEFAULT 0,
            CONSTRAINT ext202022_sequ_pk PRIMARY KEY (si165_sequencial)
        );

        COMMIT;

SQL;
        $this->execute($sql);
 	}
}
