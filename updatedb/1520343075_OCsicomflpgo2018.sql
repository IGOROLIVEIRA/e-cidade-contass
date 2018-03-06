BEGIN;

SELECT fc_startsession();

--DROP TABLE:
DROP TABLE IF EXISTS flpgo102018 CASCADE;
DROP TABLE IF EXISTS flpgo112018 CASCADE;
DROP TABLE IF EXISTS flpgo122018 CASCADE;
DROP TABLE IF EXISTS pessoaflpgo102018 CASCADE;
DROP TABLE IF EXISTS respinf102018 CASCADE;
DROP TABLE IF EXISTS terem102018 CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS flpgo102018_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112018_si196_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo122018_si197_sequencial_seq;
DROP SEQUENCE IF EXISTS pessoaflpgo102018_si193_sequencial_seq;
DROP SEQUENCE IF EXISTS respinf102018_si197_sequencial_seq;
DROP SEQUENCE IF EXISTS terem102018_si194_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE flpgo102018_si195_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo112018_si196_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo122018_si197_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE pessoaflpgo102018_si193_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE respinf102018_si197_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE terem102018_si194_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE flpgo102018
(
    si195_sequencial BIGINT DEFAULT 0 NOT NULL,
    si195_tiporegistro BIGINT DEFAULT 0 NOT NULL,
    si195_codvinculopessoa BIGINT DEFAULT 0 NOT NULL,
    si195_regime VARCHAR(1) NOT NULL,
    si195_indtipopagamento VARCHAR(1) NOT NULL,
    si195_desctipopagextra VARCHAR(150),
    si195_indsituacaoservidorpensionista VARCHAR(1) NOT NULL,
    si195_dscsituacao VARCHAR(120),
    si195_datconcessaoaposentadoriapensao DATE,
    si195_dsccargo VARCHAR(150) NOT NULL,
    si195_codcargo BIGINT DEFAULT 0 NOT NULL,
    si195_sglcargo VARCHAR(3) NOT NULL,
    si195_dscsiglacargo VARCHAR(150),
    si195_dscapo VARCHAR(3),
    si195_reqcargo BIGINT DEFAULT 0 NOT NULL,
    si195_dscreqcargo VARCHAR(150),
    si195_indcessao VARCHAR(3),
    si195_dsclotacao VARCHAR(120),
    si195_vlrcargahorariasemanal BIGINT DEFAULT 0,
    si195_datefetexercicio DATE NOT NULL,
    si195_datcomissionado DATE,
    si195_datexclusao DATE,
    si195_datcomissionadoexclusao DATE,
    si195_vlrremuneracaobruta DOUBLE PRECISION DEFAULT 0 NOT NULL,
    si195_vlrdescontos DOUBLE PRECISION DEFAULT 0 NOT NULL,
    si195_vlrremuneracaoliquida DOUBLE PRECISION DEFAULT 0 NOT NULL,
    si195_natsaldoliquido VARCHAR(1),
    si195_mes BIGINT DEFAULT 0 NOT NULL,
    si195_inst BIGINT DEFAULT 0,
    CONSTRAINT flpgo102018_sequ_pk PRIMARY KEY (si195_sequencial));

CREATE TABLE flpgo112018
(
    si196_sequencial BIGINT DEFAULT 0 NOT NULL,
    si196_tiporegistro BIGINT DEFAULT 0 NOT NULL,
    si196_indTipoPagamento VARCHAR(1) DEFAULT 0 NOT NULL,
    si196_codvinculopessoa BIGINT DEFAULT 0 NOT NULL,
    si196_codrubricaremuneracao BIGINT DEFAULT 0 NOT NULL,
    si196_desctiporubrica VARCHAR(150),
    si196_vlrremuneracaodetalhada DOUBLE PRECISION DEFAULT 0 NOT NULL,
    si196_mes BIGINT DEFAULT 0 NOT NULL,
    si196_inst BIGINT DEFAULT 0 NOT NULL,
    si196_reg10 BIGINT DEFAULT 0,
    CONSTRAINT flpgo112018_sequ_pk PRIMARY KEY (si196_sequencial));

CREATE TABLE flpgo122018
(
    si197_sequencial BIGINT DEFAULT 0 NOT NULL,
    si197_tiporegistro BIGINT DEFAULT 0 NOT NULL,
    si197_codvinculopessoa BIGINT DEFAULT 0 NOT NULL,
    si197_codrubricadesconto BIGINT DEFAULT 0 NOT NULL,
    si197_desctiporubricadesconto VARCHAR(150),
    si197_vlrdescontodetalhado DOUBLE PRECISION DEFAULT 0 NOT NULL,
    si197_mes BIGINT DEFAULT 0 NOT NULL,
    si197_inst BIGINT DEFAULT 0 NOT NULL,
    si197_reg10 BIGINT DEFAULT 0,
    CONSTRAINT flpgo122018_sequ_pk PRIMARY KEY (si197_sequencial));

CREATE TABLE pessoaflpgo102018
(
    si193_sequencial BIGINT DEFAULT 0 NOT NULL,
    si193_tiporegistro BIGINT DEFAULT 0 NOT NULL,
    si193_tipodocumento BIGINT DEFAULT 0 NOT NULL,
    si193_nrodocumento VARCHAR(14) NOT NULL,
    si193_nome VARCHAR(120) NOT NULL,
    si193_indsexo VARCHAR(1),
    si193_datanascimento DATE,
    si193_tipocadastro BIGINT DEFAULT 0 NOT NULL,
    si193_justalteracao VARCHAR(100),
    si193_mes BIGINT DEFAULT 0 NOT NULL,
    si193_inst BIGINT DEFAULT 0,
    CONSTRAINT pessoaflpgo102018_sequ_pk PRIMARY KEY (si193_sequencial));

CREATE TABLE respinf102018
(
    si197_sequencial BIGINT DEFAULT 0 NOT NULL,
    si197_nomeresponsavel VARCHAR(120) NOT NULL,
    si197_cartident VARCHAR(10) NOT NULL,
    si197_orgemissorci VARCHAR(10) NOT NULL,
    si197_cpf VARCHAR(11) NOT NULL,
    si197_dtinicio DATE NOT NULL,
    si197_dtfinal DATE NOT NULL,
    si197_mes BIGINT DEFAULT 0 NOT NULL,
    si197_inst BIGINT DEFAULT 0,
    CONSTRAINT respinf102018_sequ_pk PRIMARY KEY (si197_sequencial));


CREATE TABLE terem102018
(
    si194_sequencial BIGINT DEFAULT 0 NOT NULL,
    si194_tiporegistro BIGINT DEFAULT 0 NOT NULL,
    si194_cnpj VARCHAR(14),
    si194_vlrparateto DOUBLE PRECISION DEFAULT 0 NOT NULL,
    si194_tipocadastro BIGINT DEFAULT 0 NOT NULL,
    si194_dtinicial DATE NOT NULL,
    si194_nrleiteto BIGINT DEFAULT 0 NOT NULL,
    si194_dtpublicacaolei DATE NOT NULL,
    si194_dtfinal DATE NOT NULL,
    si194_justalteracao VARCHAR(100),
    si194_mes BIGINT DEFAULT 0 NOT NULL,
    si194_inst BIGINT DEFAULT 0,
    CONSTRAINT terem102018_sequ_pk PRIMARY KEY (si194_sequencial));


-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112018
ADD CONSTRAINT flpgo112018_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102018;

ALTER TABLE flpgo122018
ADD CONSTRAINT flpgo122018_reg10_fk FOREIGN KEY (si197_reg10)
REFERENCES flpgo102018;




-- INDICES


CREATE  INDEX flpgo112018_si196_reg10_index ON flpgo112018(si196_reg10);
CREATE  INDEX flpgo122018_si197_reg10_index ON flpgo122018(si197_reg10);

COMMIT;


BEGIN;

DROP SEQUENCE IF EXISTS afast102018_si199_sequencial_seq;
DROP SEQUENCE IF EXISTS afast202018_si200_sequencial_seq;

--DROP TABLE:
DROP TABLE IF EXISTS afast102018 CASCADE;
DROP TABLE IF EXISTS afast202018 CASCADE;
--Criando drop sequences


-- Criando  sequences
CREATE SEQUENCE afast102018_si199_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE afast202018_si200_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;




-- TABELAS E ESTRUTURA

-- Módulo: sicom
CREATE TABLE afast102018(
si199_sequencial		int4 NOT NULL default 0,
si199_tiporegistro		int4 NOT NULL default 0,
si199_codvinculopessoa		int4 NOT NULL default 0,
si199_codafastamento		int4 NOT NULL default 0,
si199_dtinicioafastamento		date NOT NULL default null,
si199_dtretornoafastamento		date NOT NULL default null,
si199_tipoafastamento		int4 NOT NULL default 0,
si199_dscoutrosafastamentos		varchar(500),
si199_mes		int4 NOT NULL default 0,
si199_inst		int4 default 0,
CONSTRAINT afast102018_sequ_pk PRIMARY KEY (si199_sequencial));


-- Módulo: sicom
CREATE TABLE afast202018(
si200_sequencial		int4 NOT NULL default 0,
si200_tiporegistro		int4 NOT NULL default 0,
si200_codvinculopessoa		int4 NOT NULL default 0,
si200_codafastamento		int4 NOT NULL default 0,
si200_dtterminoafastamento		date NOT NULL default null,
si200_mes		int4 NOT NULL default 0,
si200_inst		int4 default 0,
CONSTRAINT afast202018_sequ_pk PRIMARY KEY (si200_sequencial));




-- CHAVE ESTRANGEIRA





-- INDICES


COMMIT;



BEGIN;

DROP SEQUENCE IF EXISTS viap102018_si198_sequencial_seq;

--DROP TABLE:
DROP TABLE IF EXISTS viap102018 CASCADE;
--Criando drop sequences

-- Criando  sequences
CREATE SEQUENCE viap102018_si198_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- Criando  sequences
-- TABELAS E ESTRUTURA

-- Módulo: sicom
CREATE TABLE viap102018(
si198_sequencial                int4 NOT NULL default 0,
si198_tiporegistro              int4 NOT NULL default 0,
si198_nrocpfagentepublico               varchar(11) NOT NULL ,
si198_codmatriculapessoa                int4 NOT NULL default 0,
si198_codvinculopessoa          int4 NOT NULL default 0,
si198_mes               int4 NOT NULL default 0,
si198_inst              int4 default 0,
CONSTRAINT viap102018_sequ_pk PRIMARY KEY (si198_sequencial));




-- CHAVE ESTRANGEIRA





-- INDICES

COMMIT;