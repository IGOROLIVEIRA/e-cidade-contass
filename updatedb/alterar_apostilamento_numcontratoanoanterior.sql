begin;
select fc_startsession();
alter table apostilamento alter column si03_numcontrato  set default null;
alter table apostilamento add column si03_numcontratoanosanteriores int8 default 0;
commit;
