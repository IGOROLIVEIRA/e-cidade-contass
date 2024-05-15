begin; 
-------1 Criar os documentos e seus estornos e vinculoar um ao outro
insert into conhistdoc
select 2023,'ABERTURA POR REGRAS',2000;
insert into conhistdoc
select 2024,'ESTORNO ABERTURA POR REGRAS',2001;

select setval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial) from vinculoeventoscontabeis));
insert into vinculoeventoscontabeis
select nextval('contabilidade.vinculoeventoscontabeis_c115_sequencial_seq') ,2023,2024;
---------2 Cria a transacao de cada documento
insert into contrans
select nextval('contabilidade.contrans_c45_seqtrans_seq'), 2017, 2023,1;
insert into contranslan
values(nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
(select c45_seqtrans from contrans where c45_coddoc = 2023 and c45_anousu = 2017 limit 1),
2001,'PRIMEIRO LANCAMENTO',0,false,0,'PRIMEIRO LANCAMENTO',1);
commit;

BEGIN;
CREATE TABLE contabilidade.regraaberturaexercicio
(
  c217_sequencial integer NOT NULL DEFAULT 0,
  c217_anousu integer NOT NULL,
  c217_instit integer NOT NULL,
  c217_contadevedora varchar(15) not null,
  c217_contacredora varchar(15) not null,
  c217_contareferencia varchar(1) not null,
  CONSTRAINT regraaberturaexercicio_sequ_pk PRIMARY KEY (c217_sequencial)
);
ALTER TABLE contabilidade.regraaberturaexercicio
  OWNER TO dbportal;

CREATE SEQUENCE regraaberturaexercicio_c217_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE regraaberturaexercicio_c217_sequencial_seq
  OWNER TO dbportal;

COMMIT;