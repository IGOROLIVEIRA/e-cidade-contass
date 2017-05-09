begin;
select fc_startsession();
DROP TABLE IF EXISTS rsp202016 CASCADE;
DROP TABLE IF EXISTS rsp212016 CASCADE;
DROP TABLE IF EXISTS rsp222016 CASCADE;

CREATE TABLE rsp202016(
si115_sequencial	int8 NOT NULL default 0,
si115_tiporegistro	int8 NOT NULL default 0,
si115_codreduzidomov	int8 NOT NULL default 0,
si115_codorgao	varchar(2) NOT NULL  ,
si115_codunidadesub varchar(8) NOT NULL  ,
si115_codunidadesuborig varchar(8) NOT NULL  ,
si115_nroempenho	int8 NOT NULL default 0,
si115_exercicioempenho	int8 NOT NULL default 0,
si115_dtempenho	date NOT NULL default null,
si115_tiporestospagar	int8 NOT NULL default 0,
si115_tipomovimento	int8 NOT NULL default 0,
si115_dtmovimentacao	date NOT NULL default null,
si115_dotorig	varchar(21)   ,
si115_vlmovimentacao	float8 NOT NULL default 0,
si115_codorgaoencampatribuic	varchar(2)   ,
si115_codunidadesubencampatribuic	varchar(8)   ,
si115_justificativa varchar(500)   ,
si115_atocancelamento varchar(20)   ,
si115_dataatocancelamento date  default null,
si115_mes	int8 NOT NULL default 0,
si115_instit	int8 default 0,
CONSTRAINT rsp202016_sequ_pk PRIMARY KEY (si115_sequencial));

CREATE TABLE rsp212016(
si116_sequencial		int8 NOT NULL default 0,
si116_tiporegistro		int8 NOT NULL default 0,
si116_codreduzidomov		int8 NOT NULL default 0,
si116_codfontrecursos		int8 NOT NULL default 0,
si116_vlmovimentacaofonte		float8 NOT NULL default 0,
si116_mes		int8 NOT NULL default 0,
si116_reg20		int8 NOT NULL default 0,
si116_instit		int8 default 0,
CONSTRAINT rsp212016_sequ_pk PRIMARY KEY (si116_sequencial));

CREATE TABLE rsp222016(
si117_sequencial		int8 NOT NULL default 0,
si117_tiporegistro		int8 NOT NULL default 0,
si117_codreduzidomov		int8 NOT NULL default 0,
si117_tipodocumento		int8 NOT NULL default 0,
si117_nrodocumento		varchar(14) NOT NULL  ,
si117_mes		int8 NOT NULL default 0,
si117_reg20		int8 NOT NULL default 0,
si117_instit		int8 default 0,
CONSTRAINT rsp222016_sequ_pk PRIMARY KEY (si117_sequencial));

ALTER TABLE rsp212016
ADD CONSTRAINT rsp212016_reg20_fk FOREIGN KEY (si116_reg20)
REFERENCES rsp202016;

ALTER TABLE rsp222016
ADD CONSTRAINT rsp222016_reg20_fk FOREIGN KEY (si117_reg20)
REFERENCES rsp202016;

CREATE  INDEX rsp212016_si116_reg20_index ON rsp212016(si116_reg20);

CREATE  INDEX rsp222016_si117_reg20_index ON rsp222016(si117_reg20);
commit;
