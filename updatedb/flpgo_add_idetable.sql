BEGIN;

CREATE SEQUENCE ide2013_si11_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- M\F3dulo: sicom
CREATE TABLE ide2013(
si11_sequencial		int8 NOT NULL default 0,
si11_codmunicipio		varchar(5) NOT NULL  ,
si11_cnpjmunicipio		varchar(14) NOT NULL  ,
si11_codorgao		varchar(2) NOT NULL  ,
si11_tipoorgao		varchar(2) NOT NULL  ,
si11_exercicioreferencia		int8 NOT NULL default 0,
si11_mesreferencia		varchar(2) NOT NULL  ,
si11_datageracao		date NOT NULL default null,
si11_codcontroleremessa		varchar(20)   ,
si11_mes		int8 NOT NULL default 0,
si11_instit		int8 default 0,
CONSTRAINT ide2013_sequ_pk PRIMARY KEY (si11_sequencial));

COMMIT;