--DROP TABLE:
DROP TABLE IF EXISTS despesarateioconsorcio CASCADE;
DROP TABLE IF EXISTS entesconsorciados CASCADE;
DROP TABLE IF EXISTS entesconsorciadosreceitas CASCADE;
DROP TABLE IF EXISTS tipodereceitarateio CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS despesarateioconsorcio_c217_sequencial_seq;
DROP SEQUENCE IF EXISTS entesconsorciados_c215_sequencial_seq;
DROP SEQUENCE IF EXISTS entesconsorciadosreceitas_c216_sequencial_seq;
DROP SEQUENCE IF EXISTS tipodereceitarateio_c218_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE despesarateioconsorcio_c217_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE entesconsorciados_c215_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE entesconsorciadosreceitas_c216_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE tipodereceitarateio_c218_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: contabilidade
CREATE TABLE despesarateioconsorcio(
c217_sequencial		int4 NOT NULL default 0,
c217_enteconsorciado		int4 NOT NULL default 0,
c217_funcao		int4 NOT NULL default 0,
c217_subfuncao		int4 NOT NULL default 0,
c217_natureza		varchar(6) NOT NULL ,
c217_subelemento		varchar(2) NOT NULL ,
c217_fonte		int4 NOT NULL default 0,
c217_mes		int4 NOT NULL default 0,
c217_anousu		int4 NOT NULL default 0,
c217_valorempenhado		float4 NOT NULL default 0,
c217_valorempenhadoanulado		float4 NOT NULL default 0,
c217_valorliquidado		float4 NOT NULL default 0,
c217_valorliquidadoanulado		float4 NOT NULL default 0,
c217_valorpago		float4 NOT NULL default 0,
c217_valorpagoanulado		float4 NOT NULL default 0,
c217_percentualrateio		float4 default 0,
CONSTRAINT despesarateioconsorcio_sequ_pk PRIMARY KEY (c217_sequencial));


-- Módulo: contabilidade
CREATE TABLE entesconsorciados(
c215_sequencial		int4 NOT NULL default 0,
c215_cgm		int4 NOT NULL default 0,
c215_percentualrateio		float4 NOT NULL default 0,
c215_datainicioparticipacao		date NOT NULL default null,
c215_datafimparticipacao		date default null,
CONSTRAINT entesconsorciados_sequ_pk PRIMARY KEY (c215_sequencial));


-- Módulo: contabilidade
CREATE TABLE entesconsorciadosreceitas(
c216_sequencial		int4 NOT NULL default 0,
c216_enteconsorciado		int4 NOT NULL default 0,
c216_tiporeceita		int4 NOT NULL default 0,
c216_receita		int4 NOT NULL default 0,
c216_saldo3112		float4 default 0,
CONSTRAINT entesconsorciadosreceitas_sequ_pk PRIMARY KEY (c216_sequencial));


-- Módulo: contabilidade
CREATE TABLE tipodereceitarateio(
c218_sequencial		int4 NOT NULL default 0,
c218_codigo		int4 NOT NULL default 0,
c218_descricao		varchar(50) ,
CONSTRAINT tipodereceitarateio_sequ_pk PRIMARY KEY (c218_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE despesarateioconsorcio
ADD CONSTRAINT despesarateioconsorcio_enteconsorciado_fk FOREIGN KEY (c217_enteconsorciado)
REFERENCES entesconsorciados;

ALTER TABLE entesconsorciados
ADD CONSTRAINT entesconsorciados_cgm_fk FOREIGN KEY (c215_cgm)
REFERENCES cgm;

ALTER TABLE entesconsorciadosreceitas
ADD CONSTRAINT entesconsorciadosreceitas_enteconsorciado_fk FOREIGN KEY (c216_enteconsorciado)
REFERENCES entesconsorciados;




-- INDICES


