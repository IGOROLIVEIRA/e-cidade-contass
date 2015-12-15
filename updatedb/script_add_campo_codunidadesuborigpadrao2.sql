begin;
select fc_startsession();
update infocomplementares set si08_codunidadesub = 0;
alter table infocomplementares alter column si08_codunidadesub type varchar(8);
commit;
