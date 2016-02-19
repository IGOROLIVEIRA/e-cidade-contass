BEGIN;

SELECT fc_startsession();

--DROP TABLE:
DROP TABLE IF EXISTS flpgo102013 CASCADE;
DROP TABLE IF EXISTS flpgo112013 CASCADE;
DROP TABLE IF EXISTS pessoaflpgo102013 CASCADE;
DROP TABLE IF EXISTS respinf102013 CASCADE;
DROP TABLE IF EXISTS terem102013 CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS flpgo102013_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112013_si196_sequencial_seq;
DROP SEQUENCE IF EXISTS pessoaflpgo102013_si193_sequencial_seq;
DROP SEQUENCE IF EXISTS respinf102013_si197_sequencial_seq;
DROP SEQUENCE IF EXISTS terem102013_si194_sequencial_seq;


-- Criando  sequences
CREATE SEQUENCE flpgo102013_si195_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo112013_si196_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE pessoaflpgo102013_si193_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE respinf102013_si197_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE terem102013_si194_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: sicom
CREATE TABLE flpgo102013(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_numcpf		int8 NOT NULL default 0,
si195_regime		varchar(1) NOT NULL ,
si195_indtipopagamento		varchar(1) NOT NULL ,
si195_indsituacaoservidorpensionista		varchar(1) NOT NULL ,
si195_datconcessaoaposentadoriapensao		date  default null,
si195_dsccargo		varchar(120) NOT NULL ,
si195_sglcargo		varchar(3) NOT NULL ,
si195_reqcargo		int8 NOT NULL default 0,
si195_indcessao		varchar(3)  ,
si195_dsclotacao		varchar(120)  ,
si195_vlrcargahorariasemanal		int8  default 0,
si195_datefetexercicio		date NOT NULL default null,
si195_datexclusao		date  default null,
si195_natsaldobruto		varchar(1) NOT NULL ,
si195_vlrremuneracaobruta		float8 NOT NULL default 0,
si195_natsaldoliquido		varchar(1) NOT NULL ,
si195_vlrremuneracaoliquida		float8 NOT NULL default 0,
si195_vlrdeducoesobrigatorias		float8 NOT NULL default 0,
si195_vlrabateteto		float8 NOT NULL default 0,
si195_mes		int8 NOT NULL default 0,
si195_inst		int8 default 0,
CONSTRAINT flpgo102013_sequ_pk PRIMARY KEY (si195_sequencial));


-- Módulo: sicom
CREATE TABLE flpgo112013(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_numcpf		int8 NOT NULL default 0,
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_descoutros		varchar(150)  ,
si196_natsaldodetalhe		varchar(1) NOT NULL ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112013_sequ_pk PRIMARY KEY (si196_sequencial));


-- Módulo: sicom
CREATE TABLE pessoaflpgo102013(
si193_sequencial		int8 NOT NULL default 0,
si193_tiporegistro		int8 NOT NULL default 0,
si193_tipodocumento		int8 NOT NULL default 0,
si193_nrodocumento		varchar(14) NOT NULL ,
si193_nome		varchar(120) NOT NULL ,
si193_indsexo		varchar(1) NOT NULL ,
si193_datanascimento		date NOT NULL default null,
si193_tipocadastro		int8 NOT NULL default 0,
si193_justalteracao		varchar(100)  ,
si193_mes		int8 NOT NULL default 0,
si193_inst		int8 default 0,
CONSTRAINT pessoaflpgo102013_sequ_pk PRIMARY KEY (si193_sequencial));


-- Módulo: sicom
CREATE TABLE respinf102013(
si197_sequencial		int8 NOT NULL default 0,
si197_nomeresponsavel		varchar(120) NOT NULL ,
si197_cartident		varchar(10) NOT NULL ,
si197_orgemissorci		varchar(10) NOT NULL ,
si197_cpf		varchar(11) NOT NULL ,
si197_dtinicio		date NOT NULL default null,
si197_dtfinal		date NOT NULL default null,
si197_mes		int8 NOT NULL default 0,
si197_inst		int8 default 0,
CONSTRAINT respinf102013_sequ_pk PRIMARY KEY (si197_sequencial));


-- Módulo: sicom
CREATE TABLE terem102013(
si194_sequencial		int8 NOT NULL default 0,
si194_tiporegistro		int8 NOT NULL default 0,
si194_vlrparateto		float8 NOT NULL default 0,
si194_tipocadastro		int8 NOT NULL default 0,
si194_justalteracao		varchar(100)  ,
si194_mes		int8 NOT NULL default 0,
si194_inst		int8 default 0,
CONSTRAINT terem102013_sequ_pk PRIMARY KEY (si194_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112013
ADD CONSTRAINT flpgo112013_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102013;




-- INDICES


CREATE  INDEX flpgo112013_si196_reg10_index ON flpgo112013(si196_reg10);

COMMIT;