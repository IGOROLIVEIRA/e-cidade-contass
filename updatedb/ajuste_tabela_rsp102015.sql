BEGIN;
SELECT fc_startsession();


DROP TABLE IF EXISTS rsp102015 CASCADE;
DROP SEQUENCE IF EXISTS rsp102015_si112_sequencial_seq;

CREATE SEQUENCE rsp102015_si112_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- Módulo: sicom
CREATE TABLE rsp102015(
si112_sequencial          int8 NOT NULL DEFAULT 0,
si112_tiporegistro        int8 NOT NULL DEFAULT 0,
si112_codreduzidorsp      int8 NOT NULL DEFAULT 0,
si112_codorgao            varchar(2) NOT NULL,
si112_codunidadesub       varchar(8) NOT NULL,
si112_codunidadesuborig   varchar(8) NOT NULL,
si112_nroempenho          int8 NOT NULL DEFAULT 0,
si112_exercicioempenho    int8 NOT NULL DEFAULT 0,
si112_dtempenho           date NOT NULL DEFAULT NULL,
si112_dotorig             varchar(21),
si112_vloriginal          float8 NOT NULL DEFAULT 0,
si112_vlsaldoantproce     float8 NOT NULL DEFAULT 0,
si112_vlsaldoantnaoproc   float8 NOT NULL DEFAULT 0,
si112_mes                 int8 NOT NULL DEFAULT 0,
si112_instit              int8 DEFAULT 0,
CONSTRAINT rsp102015_sequ_pk PRIMARY KEY (si112_sequencial));


COMMIT;