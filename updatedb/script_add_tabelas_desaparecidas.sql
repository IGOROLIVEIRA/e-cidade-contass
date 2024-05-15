BEGIN;
SELECT fc_startsession();

DROP SEQUENCE IF EXISTS orcleialtorcamentaria_o200_sequencial_seq;

CREATE SEQUENCE orcleialtorcamentaria_o200_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE orcleialtorcamentaria(
o200_sequencial		int8 NOT NULL default 0,
o200_orcprojetolei		int8 NOT NULL default 0,
o200_tipoleialteracao		int8 NOT NULL default 0,
o200_artleialteracao		varchar(6) NOT NULL  ,
o200_descrartigo		text NOT NULL  ,
o200_vlautorizado		float8 NOT NULL default 0,
o200_percautorizado		float8 NOT NULL default 0,
CONSTRAINT orcleialtorcamentaria_sequ_pk PRIMARY KEY (o200_sequencial));

CREATE  INDEX orcleialtorcamentaria_o200_orcprojetolei_index ON orcleialtorcamentaria(o200_orcprojetolei);

ALTER TABLE orcleialtorcamentaria
ADD CONSTRAINT orcleialtorcamentaria_orcprojetolei_fk FOREIGN KEY (o200_orcprojetolei)
REFERENCES orcprojetolei;

COMMIT;