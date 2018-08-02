
-- Ocorrência 3770
BEGIN;
SELECT fc_startsession();

-- Início do script

--DROP TABLE:
DROP TABLE IF EXISTS pctabela CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS pctabela_pc94_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE pctabela_pc94_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Modulo: compras
CREATE TABLE pctabela(
pc94_sequencial   int4 NOT NULL default 0,
pc94_codmater   int4 default 0,
pc94_dt_cadastro    date default null,
CONSTRAINT pctabela_sequ_pk PRIMARY KEY (pc94_sequencial));


-- CHAVE ESTRANGEIRA


ALTER TABLE pctabela
ADD CONSTRAINT pctabela_codmater_fk FOREIGN KEY (pc94_codmater)
REFERENCES pcmater;


-- INDICES


CREATE UNIQUE INDEX pctabela_pc94_sequencial_index ON pctabela(pc94_sequencial);

----------------------------------------------------------------------------------

--DROP TABLE:
DROP TABLE IF EXISTS pctabelaitem CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS pctabelaitem_pc95_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE pctabelaitem_pc95_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Modulo: compras
CREATE TABLE pctabelaitem(
pc95_sequencial   int4 NOT NULL default 0,
pc95_codtabela    int4 NOT NULL default 0,
pc95_codmater   int4 default 0,
CONSTRAINT pctabelaitem_sequ_pk PRIMARY KEY (pc95_sequencial));


-- CHAVE ESTRANGEIRA


ALTER TABLE pctabelaitem
ADD CONSTRAINT pctabelaitem_codmater_fk FOREIGN KEY (pc95_codmater)
REFERENCES pcmater;

ALTER TABLE pctabelaitem
ADD CONSTRAINT pctabelaitem_codtabela_fk FOREIGN KEY (pc95_codtabela)
REFERENCES pctabela;


-- INDICES


CREATE UNIQUE INDEX pctabelaitem_pc95_sequencia_index ON pctabelaitem(pc95_sequencial);


-- Fim do script

COMMIT;



