begin;
select fc_startsession();
alter table apostilamento add column si03_instit int8;
commit;
