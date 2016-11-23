select fc_startsession();
begin;
alter table veiculos add column ve01_instit integer;
commit;