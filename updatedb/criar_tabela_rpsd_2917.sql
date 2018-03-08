--DROP TABLE:
DROP TABLE IF EXISTS rpsd102017 CASCADE;
DROP TABLE IF EXISTS rpsd112017 CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS rpsd102017_si189_sequencial_seq;
DROP SEQUENCE IF EXISTS rpsd112017_si190_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE rpsd102017_si189_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE rpsd112017_si190_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: sicom
CREATE TABLE rpsd102017(
  si189_sequencial  int8 NOT NULL default 0,
  si189_tiporegistro		int8 NOT NULL default 0,
  si189_codreduzidorsp		int8 NOT NULL default 0,
  si189_codorgao		varchar(2) NOT NULL ,
  si189_codunidadesub		varchar(8) NOT NULL ,
  si189_codunidadesuborig		varchar(8) NOT NULL ,
  si189_nroempenho		int8 NOT NULL default 0,
  si189_exercicioempenho		int8 NOT NULL default 0,
  si189_dtempenho		date NOT NULL default null,
  si189_tipopagamentorsp		int8 NOT NULL default 0,
  si189_vlpagorsp		float8 NOT NULL default 0,
  si189_mes		int8 NOT NULL default 0,
  si189_instit		int8 default 0,
  CONSTRAINT rpsd102017_sequ_pk PRIMARY KEY (si189_sequencial));


-- Módulo: sicom
CREATE TABLE rpsd112017(
  si190_sequencial		int8 NOT NULL default 0,
  si190_tiporegistro		int8 NOT NULL default 0,
  si190_codreduzidorsp		int8 NOT NULL default 0,
  si190_codfontrecursos		int8 NOT NULL default 0,
  si190_vlpagofontersp		float8 NOT NULL default 0,
  si190_reg10		int8 NOT NULL default 0,
  si190_mes		int8 NOT NULL default 0,
  si190_instit		int8 default 0,
  CONSTRAINT rpsd112017_sequ_pk PRIMARY KEY (si190_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE rpsd112017
  ADD CONSTRAINT rpsd112017_reg10_fk FOREIGN KEY (si190_reg10)
REFERENCES rpsd102017;




-- INDICES


