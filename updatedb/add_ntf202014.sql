begin;
select fc_startsession();
DROP TABLE IF EXISTS ntf122015 CASCADE;
DROP TABLE IF EXISTS ntf202015 CASCADE;
DROP SEQUENCE IF EXISTS ntf202015_si145_sequencial_seq;
CREATE SEQUENCE ntf202015_si145_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE ntf202015(
si145_sequencial	int8 NOT NULL default 0,
si145_tiporegistro	int8 NOT NULL default 0,

si145_nfnumero		int8 NOT NULL default 0,
si145_nfserie		varchar(8)  NULL default 0,
si145_tipodocumento	int8 NOT NULL default 0,
si145_nrodocumento	varchar(14) NOT NULL default 0,
si145_chaveacesso	int8 NULL default 0,
si145_dtemissaonf	date NOT NULL default null,

si145_codunidadesub	varchar(8) NOT NULL  ,
si145_dtempenho		date NOT NULL default null,
si145_nroempenho	int8 NOT NULL default 0,
si145_dtliquidacao	date NOT NULL default null,
si145_nroliquidacao	int8 NOT NULL default 0,
si145_mes		int8 NOT NULL default 0,
si145_reg10		int8 NOT NULL default 0,
si145_instit		int8 default 0,
CONSTRAINT ntf202015_sequ_pk PRIMARY KEY (si145_sequencial));

commit;
