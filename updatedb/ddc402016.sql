begin;
select fc_startsession();
CREATE SEQUENCE ddc402016_si178_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE ddc402016(
si178_sequencial		int8 NOT NULL default 0,
si178_tiporegistro		int8 NOT NULL default 0,
si178_codorgao		int8 NOT NULL default 0,
si178_passivoatuarial		int8 NOT NULL default 0,
si178_vlsaldoanterior		float8 NOT NULL default 0,
si178_vlsaldoatual		float8 default 0,
si178_mes		int8 NOT NULL default 0,
si178_instit		int8 default 0,
CONSTRAINT ddc402016_sequ_pk PRIMARY KEY (si178_sequencial));
commit;
