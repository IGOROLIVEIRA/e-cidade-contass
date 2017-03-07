BEGIN;
SELECT fc_startsession();

-- Deletando  sequences
DROP SEQUENCE IF EXISTS bodcasp102017_si201_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp402017_si204_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp502017_si205_sequencial_seq;
DROP SEQUENCE IF EXISTS bfdcasp102017_si206_sequencial_seq;
DROP SEQUENCE IF EXISTS bfdcasp202017_si207_sequencial_seq;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bodcasp102017_si201_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bodcasp402017_si204_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bodcasp502017_si205_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bfdcasp102017_si206_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bfdcasp202017_si207_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

-- Operações nas tabelas
ALTER TABLE bodcasp102017 ADD COLUMN si201_ano      int4 NOT NULL default 0;
ALTER TABLE bodcasp102017 ADD COLUMN si201_periodo  int4 NOT NULL default 0;
ALTER TABLE bodcasp102017 ADD COLUMN si201_institu  int4 NOT NULL default 0;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlrectributaria        SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlreccontribuicoes     SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlrecpatrimonial       SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlrecagropecuaria      SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlrecindustrial        SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlrecservicos          SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vltransfcorrentes      SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vloutrasreccorrentes   SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vloperacoescredito     SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlalienacaobens        SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlamortemprestimo      SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vltransfcapital        SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vloutrasreccapital     SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlrecarrecadaxeant     SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlopcredrefintermob    SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlopcredrefintcontrat  SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlopcredrefextmob      SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vlopcredrefextcontrat  SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vldeficit              SET DATA TYPE float8;
ALTER TABLE bodcasp102017 ALTER COLUMN si201_vltotalquadroreceita   SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bodcasp402017 ADD COLUMN si204_ano      int4 NOT NULL default 0;
ALTER TABLE bodcasp402017 ADD COLUMN si204_periodo  int4 NOT NULL default 0;
ALTER TABLE bodcasp402017 ADD COLUMN si204_institu  int4 NOT NULL default 0;
ALTER TABLE bodcasp402017 ALTER COLUMN si204_vlrspnaoprocpessoalencarsociais  SET DATA TYPE float8;
ALTER TABLE bodcasp402017 ALTER COLUMN si204_vlrspnaoprocjurosencardividas    SET DATA TYPE float8;
ALTER TABLE bodcasp402017 ALTER COLUMN si204_vlrspnaoprocoutrasdespcorrentes  SET DATA TYPE float8;
ALTER TABLE bodcasp402017 ALTER COLUMN si204_vlrspnaoprocinvestimentos        SET DATA TYPE float8;
ALTER TABLE bodcasp402017 ALTER COLUMN si204_vlrspnaoprocinverfinanceira      SET DATA TYPE float8;
ALTER TABLE bodcasp402017 ALTER COLUMN si204_vlrspnaoprocamortizadivida       SET DATA TYPE float8;
ALTER TABLE bodcasp402017 ALTER COLUMN si204_vltotalexecurspnaoprocessado     SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bodcasp502017 ADD COLUMN si205_ano      int4 NOT NULL default 0;
ALTER TABLE bodcasp502017 ADD COLUMN si205_periodo  int4 NOT NULL default 0;
ALTER TABLE bodcasp502017 ADD COLUMN si205_institu  int4 NOT NULL default 0;
ALTER TABLE bodcasp502017 ALTER COLUMN si205_vlrspprocliqpessoalencarsoc      SET DATA TYPE float8;
ALTER TABLE bodcasp502017 ALTER COLUMN si205_vlrspprocliqjurosencardiv        SET DATA TYPE float8;
ALTER TABLE bodcasp502017 ALTER COLUMN si205_vlrspprocliqoutrasdespcorrentes  SET DATA TYPE float8;
ALTER TABLE bodcasp502017 ALTER COLUMN si205_vlrspprocesliqinv                SET DATA TYPE float8;
ALTER TABLE bodcasp502017 ALTER COLUMN si205_vlrspprocliqinverfinan           SET DATA TYPE float8;
ALTER TABLE bodcasp502017 ALTER COLUMN si205_vlrspprocliqamortizadivida       SET DATA TYPE float8;
ALTER TABLE bodcasp502017 ALTER COLUMN si205_vltotalexecrspprocnaoproceli     SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bfdcasp102017 ADD COLUMN si206_ano      int4 NOT NULL default 0;
ALTER TABLE bfdcasp102017 ADD COLUMN si206_periodo  int4 NOT NULL default 0;
ALTER TABLE bfdcasp102017 ADD COLUMN si206_institu  int4 NOT NULL default 0;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlrecorcamenrecurord               SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlrecorcamenrecinceduc             SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlrecorcamenrecurvincusaude        SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlrecorcamenrecurvincurpps         SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlrecorcamenrecurvincuassistsoc    SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlrecorcamenoutrasdestrecursos     SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vltransfinanexecuorcamentaria      SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vltransfinanindepenexecuorc        SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vltransfinanreceaportesrpps        SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlincrirspnaoprocessado            SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlincrirspprocessado               SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vldeporestituvinculados            SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vloutrosrecextraorcamentario       SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlsaldoexeranteriorcaixaequicaixa  SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vlsaldoexerantdeporestvinc         SET DATA TYPE float8;
ALTER TABLE bfdcasp102017 ALTER COLUMN si206_vltotalingresso                    SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bfdcasp202017 ADD COLUMN si207_ano      int4 NOT NULL default 0;
ALTER TABLE bfdcasp202017 ADD COLUMN si207_periodo  int4 NOT NULL default 0;
ALTER TABLE bfdcasp202017 ADD COLUMN si207_institu  int4 NOT NULL default 0;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vldesporcamenrecurordinarios     SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vldesporcamenrecurvincueducacao  SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vldesporcamenrecurvincusaude     SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vldesporcamenrecurvincurpps      SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vldesporcamenrecurvincuassistsoc SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vloutrasdesporcamendestrecursos  SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vltransfinanconcexecorcamentaria SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vltransfinanconcindepenexecorc   SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vltransfinanconcaportesrecurpps  SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vlpagrspnaoprocessado            SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vlpagrspprocessado               SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vldeposrestvinculados            SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vloutrospagextraorcamentarios    SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vlsaldoexeratualcaixaequicaixa   SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vlsaldoexeratualdeporestvinc     SET DATA TYPE float8;
ALTER TABLE bfdcasp202017 ALTER COLUMN si207_vltotaldispendios                SET DATA TYPE float8;

COMMIT;
