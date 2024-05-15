BEGIN;

select fc_startsession();

DROP TABLE IF EXISTS flpgo102013 CASCADE;
DROP TABLE IF EXISTS flpgo112013 CASCADE;

DROP TABLE IF EXISTS flpgo102014 CASCADE;
DROP TABLE IF EXISTS flpgo112014 CASCADE;

DROP TABLE IF EXISTS flpgo102015 CASCADE;
DROP TABLE IF EXISTS flpgo112015 CASCADE;

DROP TABLE IF EXISTS flpgo102016 CASCADE;
DROP TABLE IF EXISTS flpgo112016 CASCADE;


DROP SEQUENCE IF EXISTS flpgo102013_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112013_si196_sequencial_seq;

DROP SEQUENCE IF EXISTS flpgo102014_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112014_si196_sequencial_seq;

DROP SEQUENCE IF EXISTS flpgo102015_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112015_si196_sequencial_seq;

DROP SEQUENCE IF EXISTS flpgo102016_si195_sequencial_seq;
DROP SEQUENCE IF EXISTS flpgo112016_si196_sequencial_seq;


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


CREATE TABLE flpgo102013(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_numcpf		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
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



CREATE TABLE flpgo112013(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_numcpf		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_descoutros		varchar(150)  ,
si196_natsaldodetalhe		varchar(1) NOT NULL ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112013_sequ_pk PRIMARY KEY (si196_sequencial));


CREATE TABLE flpgo102014(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_numcpf		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
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
CONSTRAINT flpgo102014_sequ_pk PRIMARY KEY (si195_sequencial));



CREATE TABLE flpgo112014(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_numcpf		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_descoutros		varchar(150)  ,
si196_natsaldodetalhe		varchar(1) NOT NULL ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112014_sequ_pk PRIMARY KEY (si196_sequencial));


CREATE TABLE flpgo102015(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_numcpf		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
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
CONSTRAINT flpgo102015_sequ_pk PRIMARY KEY (si195_sequencial));



CREATE TABLE flpgo112015(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_numcpf		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_descoutros		varchar(150)  ,
si196_natsaldodetalhe		varchar(1) NOT NULL ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112015_sequ_pk PRIMARY KEY (si196_sequencial));


CREATE TABLE flpgo102016(
si195_sequencial		int8 NOT NULL default 0,
si195_tiporegistro		int8 NOT NULL default 0,
si195_numcpf		int8 NOT NULL default 0,
si195_codreduzidopessoa int8 NOT NULL default 0, 
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
CONSTRAINT flpgo102016_sequ_pk PRIMARY KEY (si195_sequencial));


CREATE TABLE flpgo112016(
si196_sequencial		int8 NOT NULL default 0,
si196_tiporegistro		int8 NOT NULL default 0,
si196_numcpf		int8 NOT NULL default 0,
si196_codreduzidopessoa int8 NOT NULL default 0, 
si196_tiporemuneracao		int8 NOT NULL default 0,
si196_descoutros		varchar(150)  ,
si196_natsaldodetalhe		varchar(1) NOT NULL ,
si196_vlrremuneracaodetalhada		float8 NOT NULL default 0,
si196_mes		int8 NOT NULL default 0,
si196_inst		int8 NOT NULL default 0,
si196_reg10		int8 default 0,
CONSTRAINT flpgo112016_sequ_pk PRIMARY KEY (si196_sequencial));


-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112013
ADD CONSTRAINT flpgo112013_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102013;




-- INDICES


CREATE  INDEX flpgo112013_si196_reg10_index ON flpgo112013(si196_reg10);



-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112014
ADD CONSTRAINT flpgo112014_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102014;




-- INDICES


CREATE  INDEX flpgo112014_si196_reg10_index ON flpgo112014(si196_reg10);


-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112015
ADD CONSTRAINT flpgo112015_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102015;




-- INDICES


CREATE  INDEX flpgo112015_si196_reg10_index ON flpgo112015(si196_reg10);


-- CHAVE ESTRANGEIRA


ALTER TABLE flpgo112016
ADD CONSTRAINT flpgo112016_reg10_fk FOREIGN KEY (si196_reg10)
REFERENCES flpgo102016;




-- INDICES


CREATE  INDEX flpgo112016_si196_reg10_index ON flpgo112016(si196_reg10);

COMMIT;