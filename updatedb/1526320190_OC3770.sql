
-- Ocorrência 3770
BEGIN;
SELECT fc_startsession();

-- Início do script

DROP TABLE IF EXISTS julglic302018;

CREATE SEQUENCE julglic302018_si62_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE julglic302018(
  si62_sequencial int8 NOT NULL default 0,
  si62_tiporegistro int8 NOT NULL default 0,
  si62_codorgao varchar(2) NOT NULL,
  si62_codunidadesub varchar(8) NOT NULL,
  si62_exerciciolicitacao int8 NOT NULL default 0,
  si62_nroprocessolicitatorio varchar(12) NOT NULL,
  si62_tipodocumento int8 NOT NULL default 0,
  si62_nrodocumento varchar(14) NOT NULL,
  si62_nrolote int8 default 0,
  si62_coditem varchar(14),
  si62_perctaxaadm double precision not null default 0,
  si62_mes int8 NOT NULL default 0,
  si62_instit int4 default 0,
  CONSTRAINT julglic302018_sequ_pk PRIMARY KEY (si62_sequencial)
);

-- Fim do script

COMMIT;

BEGIN;
SELECT fc_startsession();

-- Início do script

DROP TABLE IF EXISTS homolic302018;

CREATE SEQUENCE homolic302018_si65_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE homolic302018(
  si65_sequencial int8 NOT NULL default 0,
  si65_tiporegistro int8 NOT NULL default 0,
  si65_codorgao varchar(2) NOT NULL,
  si65_codunidadesub varchar(8) NOT NULL,
  si65_exerciciolicitacao int8 NOT NULL default 0,
  si65_nroprocessolicitatorio varchar(12) NOT NULL,
  si65_tipodocumento int8 NOT NULL default 0,
  si65_nrodocumento varchar(14) NOT NULL,
  si65_nrolote int8 default 0,
  si65_coditem varchar(14),
  si65_perctaxaadm double precision not null default 0,
  si65_mes int8 NOT NULL default 0,
  si65_instit int4 default 0,
  CONSTRAINT homolic302018_sequ_pk PRIMARY KEY (si65_sequencial)
);

-- Fim do script

COMMIT;
