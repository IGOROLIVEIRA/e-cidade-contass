begin;
select fc_startsession();
alter table transporteescolar add column v200_anousu int8;
commit;