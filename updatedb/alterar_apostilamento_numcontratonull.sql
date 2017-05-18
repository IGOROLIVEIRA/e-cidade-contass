begin;
select fc_startsession();
alter table apostilamento alter column si03_numcontrato drop not null;
commit;
