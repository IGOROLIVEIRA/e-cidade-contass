begin;
select fc_startsession();
drop sequence caixa112016_si103_sequencial_seq;
CREATE SEQUENCE caixa112016_si166_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

alter table caixa112016 add si166_reg10 int8 not null default 0;
alter table caixa112016 add constraint caixa112016_reg10_fk FOREIGN KEY (si166_reg10) REFERENCES caixa102016(si103_sequencial);
commit;
