
-- Ocorrência 4474

begin;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS protocolos CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS protocolos_p101_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE protocolos_p101_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- M�dulo: protocolo
CREATE TABLE protocolos(
p101_sequencial   int4 NOT NULL default 0,
p101_id_usuario   int4 NOT NULL default 0,
p101_coddeptoorigem   int4 NOT NULL default 0,
p101_coddeptodestino    int4 NOT NULL default 0,
p101_observacao   varchar(200),
p101_dt_protocolo   date default null,
p101_hora varchar(5),
p101_dt_anulado date default null,
CONSTRAINT protocolos_sequ_pk PRIMARY KEY (p101_sequencial));


ALTER TABLE protocolos
ADD CONSTRAINT protocolos_coddeptoorigem_fk FOREIGN KEY (p101_coddeptoorigem)
REFERENCES db_depart;

ALTER TABLE protocolos
ADD CONSTRAINT protocolos_coddeptodestino_fk FOREIGN KEY (p101_coddeptodestino)
REFERENCES db_depart;

ALTER TABLE protocolos
ADD CONSTRAINT protocolos_usuario_fk FOREIGN KEY (p101_id_usuario)
REFERENCES db_usuarios;

CREATE UNIQUE INDEX p101_sequencial_index ON protocolos(p101_sequencial);

commit;

-----------------------------------------------------------------------------------------------------------------

begin;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS protempautoriza CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS protempautoriza_p102_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE protempautoriza_p102_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- M�dulo: protocolo
CREATE TABLE protempautoriza(
p102_sequencial   int4 NOT NULL default 0,
p102_autorizacao    int4 NOT NULL default 0,
p102_protocolo    int4 default 0,
CONSTRAINT protempautoriza_sequ_pk PRIMARY KEY (p102_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE protempautoriza
ADD CONSTRAINT protempautoriza_protocolo_fk FOREIGN KEY (p102_protocolo)
REFERENCES protocolos;

ALTER TABLE protempautoriza
ADD CONSTRAINT protempautoriza_autorizacao_fk FOREIGN KEY (p102_autorizacao)
REFERENCES empautoriza;


-- INDICES


CREATE UNIQUE INDEX p102_sequencial_index ON protempautoriza(p102_sequencial);

commit;
-----------------------------------------------------------------------------------------------------------------

begin;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS protempenhos CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS protempenhos_p103_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE protempenhos_p103_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- M�dulo: protocolo
CREATE TABLE protempenhos(
p103_sequencial   int4 NOT NULL default 0,
p103_numemp   int4 NOT NULL default 0,
p103_protocolo    int4 default 0,
CONSTRAINT protempenhos_sequ_pk PRIMARY KEY (p103_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE protempenhos
ADD CONSTRAINT protempenhos_protocolo_fk FOREIGN KEY (p103_protocolo)
REFERENCES protocolos;

ALTER TABLE protempenhos
ADD CONSTRAINT protempenhos_numemp_fk FOREIGN KEY (p103_numemp)
REFERENCES empempenho;


-- INDICES


CREATE UNIQUE INDEX p103_sequencial_index ON protempenhos(p103_sequencial);

commit;

-----------------------------------------------------------------------------------------------------------------

begin;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS protmatordem CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS protmatordem_p104_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE protmatordem_p104_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- M�dulo: protocolo
CREATE TABLE protmatordem(
p104_sequencial   int4 NOT NULL default 0,
p104_codordem   int8 NOT NULL default 0,
p104_protocolo    int4 default 0,
CONSTRAINT protmatordem_sequ_pk PRIMARY KEY (p104_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE protmatordem
ADD CONSTRAINT protmatordem_codordem_fk FOREIGN KEY (p104_codordem)
REFERENCES matordem;

ALTER TABLE protmatordem
ADD CONSTRAINT protmatordem_protocolo_fk FOREIGN KEY (p104_protocolo)
REFERENCES protocolos;


-- INDICES


CREATE UNIQUE INDEX p104_sequencial_index ON protmatordem(p104_sequencial);

commit;
-----------------------------------------------------------------------------------------------------------------

begin;
select fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS protpagordem CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS protpagordem_p105_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE protpagordem_p105_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA

-- M�dulo: protocolo
CREATE TABLE protpagordem(
p105_sequencial   int4 NOT NULL default 0,
p105_codord   int4 NOT NULL default 0,
p105_protocolo    int4 NOT NULL default 0,
CONSTRAINT protpagordem_sequ_pk PRIMARY KEY (p105_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE protpagordem
ADD CONSTRAINT protpagordem_protocolo_fk FOREIGN KEY (p105_protocolo)
REFERENCES protocolos;

ALTER TABLE protpagordem
ADD CONSTRAINT protpagordem_codord_codele_fk FOREIGN KEY (p105_codord)
REFERENCES pagordem;


-- INDICES


CREATE UNIQUE INDEX p105_sequencial_index ON protpagordem(p105_sequencial);

commit;

