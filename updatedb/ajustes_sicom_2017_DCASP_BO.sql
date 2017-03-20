BEGIN;
SELECT fc_startsession();


-- Deletando  sequences
DROP SEQUENCE IF EXISTS bodcasp202017_si202_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp302017_si203_sequencial_seq;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();


-- Criando sequences
CREATE SEQUENCE bodcasp202017_si202_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- Criando sequences
CREATE SEQUENCE bodcasp302017_si203_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

-- Operações nas tabelas
ALTER TABLE bodcasp202017 ADD COLUMN si202_anousu  int4 NOT NULL default 0;
ALTER TABLE bodcasp202017 ADD COLUMN si202_periodo int4 NOT NULL default 0;
ALTER TABLE bodcasp202017 ADD COLUMN si202_instit  int4 NOT NULL default 0;
ALTER TABLE bodcasp202017 ALTER COLUMN si202_vlsaldoexeantsupfin    SET DATA TYPE float8;
ALTER TABLE bodcasp202017 ALTER COLUMN si202_vlsaldoexeantrecredad  SET DATA TYPE float8;
ALTER TABLE bodcasp202017 ALTER COLUMN si202_vltotalsaldoexeant     SET DATA TYPE float8;


ALTER TABLE bodcasp302017 ADD COLUMN si203_anousu  int4 NOT NULL default 0;
ALTER TABLE bodcasp302017 ADD COLUMN si203_periodo int4 NOT NULL default 0;
ALTER TABLE bodcasp302017 ADD COLUMN si203_instit  int4 NOT NULL default 0;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlpessoalencarsoci       SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vljurosencardividas      SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vloutrasdespcorren       SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlinvestimentos          SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlinverfinanceira        SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlamortizadivida         SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlreservacontingen       SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlreservarpps            SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlamortizadiviintermob   SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlamortizaoutrasdivinter SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlamortizadivextmob      SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlamortizaoutrasdivext   SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vlsuperavit              SET DATA TYPE float8;
ALTER TABLE bodcasp302017 ALTER COLUMN si203_vltotalquadrodespesa     SET DATA TYPE float8;

COMMIT;
