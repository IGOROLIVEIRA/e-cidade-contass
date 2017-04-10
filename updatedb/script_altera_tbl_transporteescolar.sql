begin;
select fc_startsession();
alter table transporteescolar alter v200_escola TYPE varchar(250);
alter table transporteescolar alter v200_localidade TYPE varchar(250);
commit;
