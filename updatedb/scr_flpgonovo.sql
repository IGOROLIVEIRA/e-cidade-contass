BEGIN;

select fc_startsession();

DROP TABLE IF EXISTS terem102013 CASCADE;
DROP TABLE IF EXISTS terem102014 CASCADE;
DROP TABLE IF EXISTS terem102015 CASCADE;
DROP TABLE IF EXISTS terem102016 CASCADE;

DROP TABLE IF EXISTS flpgo102013 CASCADE;
DROP TABLE IF EXISTS flpgo112013 CASCADE;
DROP TABLE IF EXISTS flpgo122013 CASCADE;

DROP TABLE IF EXISTS flpgo102014 CASCADE;
DROP TABLE IF EXISTS flpgo112014 CASCADE;
DROP TABLE IF EXISTS flpgo122014 CASCADE;

DROP TABLE IF EXISTS flpgo102015 CASCADE;
DROP TABLE IF EXISTS flpgo112015 CASCADE;
DROP TABLE IF EXISTS flpgo122015 CASCADE;

DROP TABLE IF EXISTS flpgo102016 CASCADE;
DROP TABLE IF EXISTS flpgo112016 CASCADE;
DROP TABLE IF EXISTS flpgo122016 CASCADE;

DROP SEQUENCE IF EXISTS terem102013_si194_sequencial_seq;
DROP SEQUENCE IF EXISTS terem102014_si194_sequencial_seq;
DROP SEQUENCE IF EXISTS terem102015_si194_sequencial_seq;
DROP SEQUENCE IF EXISTS terem102016_si194_sequencial_seq;

DROP SEQUENCE IF EXISTS flpgo102013_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112013_si196_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo122013_si197_sequencial_seq;

DROP SEQUENCE IF EXISTS flpgo102014_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112014_si196_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo122014_si197_sequencial_seq;

DROP SEQUENCE IF EXISTS flpgo102015_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112015_si196_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo122015_si197_sequencial_seq;

DROP SEQUENCE IF EXISTS flpgo102016_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112016_si196_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo122016_si197_sequencial_seq;

CREATE SEQUENCE terem102013_si194_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
CREATE SEQUENCE terem102014_si194_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
CREATE SEQUENCE terem102015_si194_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
CREATE SEQUENCE terem102016_si194_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


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

CREATE SEQUENCE flpgo122013_si197_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE flpgo102014_si195_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo112014_si196_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE flpgo122014_si197_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo102015_si195_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo112015_si196_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE flpgo122015_si197_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo102016_si195_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE flpgo112016_si196_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE flpgo122016_si197_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- Módulo: sicom
CREATE TABLE terem102013(
si194_sequencial		int8 NOT NULL default 0,
si194_tiporegistro	int8 NOT NULL default 0,
si194_cnpj		      varchar(14),
si194_vlrparateto		float8 NOT NULL default 0,
si194_tipocadastro	int8 NOT NULL default 0,
si194_dtinicial  date NOT NULL default null,
si194_dtfinal  date NOT NULL default null,
si194_justalteracao		varchar(100)  ,
si194_mes		int8 NOT NULL default 0,
si194_inst		int8 default 0,
CONSTRAINT terem102013_sequ_pk PRIMARY KEY (si194_sequencial));

-- Módulo: sicom
CREATE TABLE terem102014(
si194_sequencial		int8 NOT NULL default 0,
si194_tiporegistro	int8 NOT NULL default 0,
si194_cnpj		      varchar(14),
si194_vlrparateto		float8 NOT NULL default 0,
si194_tipocadastro	int8 NOT NULL default 0,
si194_dtinicial  date NOT NULL default null,
si194_dtfinal  date NOT NULL default null,
si194_justalteracao		varchar(100)  ,
si194_mes		int8 NOT NULL default 0,
si194_inst		int8 default 0,
CONSTRAINT terem102014_sequ_pk PRIMARY KEY (si194_sequencial));

-- Módulo: sicom
CREATE TABLE terem102015(
si194_sequencial		int8 NOT NULL default 0,
si194_tiporegistro	int8 NOT NULL default 0,
si194_cnpj		      varchar(14),
si194_vlrparateto		float8 NOT NULL default 0,
si194_tipocadastro	int8 NOT NULL default 0,
si194_dtinicial  date NOT NULL default null,
si194_dtfinal  date NOT NULL default null,
si194_justalteracao		varchar(100)  ,
si194_mes		int8 NOT NULL default 0,
si194_inst		int8 default 0,
CONSTRAINT terem102015_sequ_pk PRIMARY KEY (si194_sequencial));

-- Módulo: sicom
CREATE TABLE terem102016(
si194_sequencial		int8 NOT NULL default 0,
si194_tiporegistro	int8 NOT NULL default 0,
si194_cnpj		      varchar(14),
si194_vlrparateto		float8 NOT NULL default 0,
si194_tipocadastro	int8 NOT NULL default 0,
si194_dtinicial  date NOT NULL default null,
si194_dtfinal  date NOT NULL default null,
si194_justalteracao		varchar(100)  ,
si194_mes		int8 NOT NULL default 0,
si194_inst		int8 default 0,
CONSTRAINT terem102016_sequ_pk PRIMARY KEY (si194_sequencial));

CREATE TABLE flpgo102013(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_nrodocumento		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
si195_regime		varchar(1) NOT NULL ,
si195_indtipopagamento		varchar(1) NOT NULL ,
si195_indsituacaoservidorpensionista		varchar(1) NOT NULL ,
si195_dscsituacao varchar(150) ,
si195_datconcessaoaposentadoriapensao		date  default null,
si195_dsccargo		varchar(120) NOT NULL ,
si195_sglcargo		varchar(3) NOT NULL ,
si195_dscsiglacargo varchar(150) ,
si195_reqcargo		int8 NOT NULL default 0,
si195_indcessao		varchar(3)  ,
si195_dsclotacao		varchar(120)  ,
si195_vlrcargahorariasemanal		int8  default 0,
si195_datefetexercicio		date NOT NULL default null,
si195_datexclusao		date  default null,
si195_vlrremuneracaobruta		float8 NOT NULL default 0,
si195_natsaldoliquido		varchar(1) NOT NULL ,
si195_vlrremuneracaoliquida		float8 NOT NULL default 0,
si195_vlrdeducoes		float8 NOT NULL default 0,
si195_mes		int8 NOT NULL default 0,
si195_inst		int8 default 0,
CONSTRAINT flpgo102013_sequ_pk PRIMARY KEY (si195_sequencial));



CREATE TABLE flpgo112013(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_nrodocumento		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_desctiporemuneracao		varchar(150)  ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112013_sequ_pk PRIMARY KEY (si196_sequencial));

CREATE TABLE flpgo122013(
si197_sequencial		int8 NOT NULL default 0,
si197_tiporegistro		int8 NOT NULL default 0,
si197_nrodocumento		int8 NOT NULL default 0,
si197_codreduzidopessoa int8 NOT NULL default 0,
si197_tipodesconto		int8 NOT NULL default 0,
si197_vlrdescontodetalhado		float8 NOT NULL default 0,
si197_mes		int8 NOT NULL default 0,
si197_inst		int8 NOT NULL default 0,
si197_reg10		int8 default 0,
CONSTRAINT flpgo122013_sequ_pk PRIMARY KEY (si197_sequencial));


CREATE TABLE flpgo102014(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_nrodocumento		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
si195_regime		varchar(1) NOT NULL ,
si195_indtipopagamento		varchar(1) NOT NULL ,
si195_indsituacaoservidorpensionista		varchar(1) NOT NULL ,
si195_dscsituacao varchar(120) ,
si195_datconcessaoaposentadoriapensao		date  default null,
si195_dsccargo		varchar(120) NOT NULL ,
si195_sglcargo		varchar(3) NOT NULL ,
si195_dscsiglacargo varchar(150) ,
si195_reqcargo		int8 NOT NULL default 0,
si195_indcessao		varchar(3)  ,
si195_dsclotacao		varchar(120)  ,
si195_vlrcargahorariasemanal		int8  default 0,
si195_datefetexercicio		date NOT NULL default null,
si195_datexclusao		date  default null,
si195_vlrremuneracaobruta		float8 NOT NULL default 0,
si195_natsaldoliquido		varchar(1) NOT NULL ,
si195_vlrremuneracaoliquida		float8 NOT NULL default 0,
si195_vlrdeducoes		float8 NOT NULL default 0,
si195_mes		int8 NOT NULL default 0,
si195_inst		int8 default 0,
CONSTRAINT flpgo102014_sequ_pk PRIMARY KEY (si195_sequencial));



CREATE TABLE flpgo112014(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_nrodocumento		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_destiporemuneracao		varchar(150)  ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112014_sequ_pk PRIMARY KEY (si196_sequencial));

CREATE TABLE flpgo122014(
si197_sequencial		int8 NOT NULL default 0,
si197_tiporegistro		int8 NOT NULL default 0,
si197_nrodocumento		int8 NOT NULL default 0,
si197_codreduzidopessoa int8 NOT NULL default 0,
si197_tipodesconto		int8 NOT NULL default 0,
si197_vlrdescontodetalhado		float8 NOT NULL default 0,
si197_mes		int8 NOT NULL default 0,
si197_inst		int8 NOT NULL default 0,
si197_reg10		int8 default 0,
CONSTRAINT flpgo122014_sequ_pk PRIMARY KEY (si197_sequencial));


CREATE TABLE flpgo102015(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_nrodocumento		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
si195_regime		varchar(1) NOT NULL ,
si195_indtipopagamento		varchar(1) NOT NULL ,
si195_indsituacaoservidorpensionista		varchar(1) NOT NULL ,
si195_dscsituacao varchar(120) ,
si195_datconcessaoaposentadoriapensao		date  default null,
si195_dsccargo		varchar(120) NOT NULL ,
si195_sglcargo		varchar(3) NOT NULL ,
si195_dscsiglacargo varchar(150) ,
si195_reqcargo		int8 NOT NULL default 0,
si195_indcessao		varchar(3)  ,
si195_dsclotacao		varchar(120)  ,
si195_vlrcargahorariasemanal		int8  default 0,
si195_datefetexercicio		date NOT NULL default null,
si195_datexclusao		date  default null,
si195_vlrremuneracaobruta		float8 NOT NULL default 0,
si195_natsaldoliquido		varchar(1) NOT NULL ,
si195_vlrremuneracaoliquida		float8 NOT NULL default 0,
si195_vlrdeducoes		float8 NOT NULL default 0,
si195_mes		int8 NOT NULL default 0,
si195_inst		int8 default 0,
CONSTRAINT flpgo102015_sequ_pk PRIMARY KEY (si195_sequencial));



CREATE TABLE flpgo112015(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_nrodocumento		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_destiporemuneracao		varchar(150)  ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112015_sequ_pk PRIMARY KEY (si196_sequencial));

CREATE TABLE flpgo122015(
si197_sequencial		int8 NOT NULL default 0,
si197_tiporegistro		int8 NOT NULL default 0,
si197_nrodocumento		int8 NOT NULL default 0,
si197_codreduzidopessoa int8 NOT NULL default 0,
si197_tipodesconto		int8 NOT NULL default 0,
si197_vlrdescontodetalhado		float8 NOT NULL default 0,
si197_mes		int8 NOT NULL default 0,
si197_inst		int8 NOT NULL default 0,
si197_reg10		int8 default 0,
CONSTRAINT flpgo122015_sequ_pk PRIMARY KEY (si197_sequencial));


CREATE TABLE flpgo102016(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_nrodocumento		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
si195_regime		varchar(1) NOT NULL ,
si195_indtipopagamento		varchar(1) NOT NULL ,
si195_indsituacaoservidorpensionista		varchar(1) NOT NULL ,
si195_dscsituacao varchar(120) ,
si195_datconcessaoaposentadoriapensao		date  default null,
si195_dsccargo		varchar(150) NOT NULL ,
si195_sglcargo		varchar(3) NOT NULL ,
si195_dscsiglacargo varchar(150) ,
si195_reqcargo		int8 NOT NULL default 0,
si195_indcessao		varchar(3)  ,
si195_dsclotacao		varchar(120)  ,
si195_vlrcargahorariasemanal		int8  default 0,
si195_datefetexercicio		date NOT NULL default null,
si195_datexclusao		date  default null,
si195_vlrremuneracaobruta		float8 NOT NULL default 0,
si195_natsaldoliquido		varchar(1) NOT NULL ,
si195_vlrremuneracaoliquida		float8 NOT NULL default 0,
si195_vlrdeducoes		float8 NOT NULL default 0,
si195_mes		int8 NOT NULL default 0,
si195_inst		int8 default 0,
CONSTRAINT flpgo102016_sequ_pk PRIMARY KEY (si195_sequencial));


CREATE TABLE flpgo112016(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_nrodocumento		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_destiporemuneracao		varchar(150)  ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112016_sequ_pk PRIMARY KEY (si196_sequencial));

CREATE TABLE flpgo122016(
si197_sequencial		int8 NOT NULL default 0,
si197_tiporegistro		int8 NOT NULL default 0,
si197_nrodocumento		int8 NOT NULL default 0,
si197_codreduzidopessoa int8 NOT NULL default 0,
si197_tipodesconto		int8 NOT NULL default 0,
si197_vlrdescontodetalhado		float8 NOT NULL default 0,
si197_mes		int8 NOT NULL default 0,
si197_inst		int8 NOT NULL default 0,
si197_reg10		int8 default 0,
CONSTRAINT flpgo122016_sequ_pk PRIMARY KEY (si197_sequencial));


-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112013
ADD CONSTRAINT flpgo112013_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102013;

ALTER TABLE flpgo122013
ADD CONSTRAINT flpgo122013_reg10_fk FOREIGN KEY (si197_reg10)
REFERENCES flpgo102013;




-- INDICES


CREATE  INDEX flpgo112013_si196_reg10_index ON flpgo112013(si196_reg10);
CREATE  INDEX flpgo122013_si197_reg10_index ON flpgo122013(si197_reg10);



-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112014
ADD CONSTRAINT flpgo112014_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102014;

ALTER TABLE flpgo122014
ADD CONSTRAINT flpgo122014_reg10_fk FOREIGN KEY (si197_reg10)
REFERENCES flpgo102014;




-- INDICES


CREATE  INDEX flpgo112014_si196_reg10_index ON flpgo112014(si196_reg10);
CREATE  INDEX flpgo122014_si197_reg10_index ON flpgo122014(si197_reg10);


-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112015
ADD CONSTRAINT flpgo112015_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102015;

ALTER TABLE flpgo122015
ADD CONSTRAINT flpgo122015_reg10_fk FOREIGN KEY (si197_reg10)
REFERENCES flpgo102015;




-- INDICES


CREATE  INDEX flpgo112015_si196_reg10_index ON flpgo112015(si196_reg10);
CREATE  INDEX flpgo122015_si197_reg10_index ON flpgo122015(si197_reg10);


-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112016
ADD CONSTRAINT flpgo112016_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102016;

ALTER TABLE flpgo122016
ADD CONSTRAINT flpgo122016_reg10_fk FOREIGN KEY (si197_reg10)
REFERENCES flpgo102016;




-- INDICES


CREATE  INDEX flpgo112016_si196_reg10_index ON flpgo112016(si196_reg10);
CREATE  INDEX flpgo122016_si197_reg10_index ON flpgo122016(si197_reg10);

COMMIT;