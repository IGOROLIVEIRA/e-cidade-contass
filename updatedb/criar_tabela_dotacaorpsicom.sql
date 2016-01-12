begin;
-- Criando  sequences
CREATE SEQUENCE dotacaorpsicom_si177_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA

-- Módulo: sicom
CREATE TABLE sicom.dotacaorpsicom(
si177_sequencial		int8 NOT NULL default 0,
si177_numemp		int8 NOT NULL default 0,
si177_codorgaotce		int8 NOT NULL default 0,
si177_codunidadesub		int8 NOT NULL default 0,
si177_codunidadesuborig		int8 NOT NULL default 0,
si177_codfuncao		int8 NOT NULL default 0,
si177_codsubfuncao		int8 NOT NULL default 0,
si177_codprograma		int8 NOT NULL default 0,
si177_idacao		int8 NOT NULL default 0,
si177_idsubacao		int8 NOT NULL default 0,
si177_naturezadespesa		int8 NOT NULL default 0,
si177_subelemento		int8 NOT NULL default 0,
si177_codfontrecursos		int8 default 0,
CONSTRAINT dotacaorpsicom_sequ_pk PRIMARY KEY (si177_sequencial));

-- CHAVE ESTRANGEIRA
ALTER TABLE sicom.dotacaorpsicom
ADD CONSTRAINT dotacaorpsicom_numemp_fk FOREIGN KEY (si177_numemp)
REFERENCES empempenho;

-- INDICES
CREATE  INDEX dotacaorpsicom_si177_numemp_index ON dotacaorpsicom(si177_numemp);
commit;

