SELECT fc_startsession();
begin;
alter table contacorrentedetalhe add column c19_programa varchar(4);
alter table contacorrentedetalhe add column c19_projativ varchar(4);
COMMIT;
