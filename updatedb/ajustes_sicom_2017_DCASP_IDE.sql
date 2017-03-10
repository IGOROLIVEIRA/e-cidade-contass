BEGIN;
SELECT fc_startsession();

-- Deletando  sequences
DROP SEQUENCE IF EXISTS idedcasp2017_si200_sequencial_seq;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

-- Criando sequences
CREATE SEQUENCE idedcasp2017_si200_sequencial_seq
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
ALTER TABLE idedcasp2017 ADD COLUMN si200_anousu int4 NOT NULL default 0;
ALTER TABLE idedcasp2017 ADD COLUMN si200_instit int4 NOT NULL default 0;

COMMIT;
