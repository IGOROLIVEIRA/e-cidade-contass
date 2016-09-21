select fc_startsession();
begin;
alter table aditivoscontratos DROP CONSTRAINT aditivoscontratos_nrocontrato_fk;
commit;
