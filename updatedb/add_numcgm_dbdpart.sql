begin;
select fc_startsession();
alter table db_depart add column numcgm int8;
commit;
