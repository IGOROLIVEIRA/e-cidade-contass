begin;
select fc_startsession();
create table caixa.ordembancaria (
 k00_codigo int8 not null,
 k00_ctpagadora int8, 
 k00_dtpagamento date, 
CONSTRAINT ordembancaria_pkey PRIMARY KEY (k00_codigo));

create table caixa.ordembancariapagamento (
 k00_sequencial int8 not null,
 k00_codordembancaria int8 not null,
 k00_codord  int8,
 k00_cgmfornec int8,
 k00_valorpag double precision, 
 k00_contabanco int8,
 k00_slip int8,
 k00_formapag  varchar(50),
CONSTRAINT ordembancariapagamento_pkey PRIMARY KEY (k00_sequencial),
CONSTRAINT ordembancariapagamento_k00_codord_key UNIQUE(k00_codord)
);

CREATE SEQUENCE ordembancaria_k00_codigo_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE ordembancariapagamento_k00_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
commit;
