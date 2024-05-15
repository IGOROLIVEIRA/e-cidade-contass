begin;
select fc_startsession();
alter table item102016 alter column si43_dscItem type text;
commit;
