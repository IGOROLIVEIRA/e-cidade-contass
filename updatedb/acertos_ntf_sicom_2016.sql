begin;
select fc_startsession();
CREATE SEQUENCE ntf202016_si145_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

drop table ntf122016;
drop sequence ntf122016_si145_sequencial_seq;
CREATE TABLE ntf202016(
si145_sequencial		int8 NOT NULL default 0,
si145_tiporegistro		int8 NOT NULL default 0,
si145_nfnumero  		int8 NOT NULL default 0,
si145_nfserie                   varchar(8)  default 0,
si145_tipodocumento  int8 not null default 0,
si145_nrodocumento   varchar(14) not null default 0,
si145_chaveacesso    int8 default 0,
si145_dtemissaonf    date not null,
si145_codunidadesub		varchar(8) NOT NULL  ,
si145_dtempenho		date NOT NULL default null,
si145_nroempenho		int8 NOT NULL default 0,
si145_dtliquidacao		date NOT NULL default null,
si145_nroliquidacao		int8 NOT NULL default 0,
si145_mes		int8 NOT NULL default 0,
si145_reg10		int8 NOT NULL default 0,
si145_instit		int8 default 0,
CONSTRAINT ntf202016_sequ_pk PRIMARY KEY (si145_sequencial));


commit;
