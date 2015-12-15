begin;
select fc_startsession();
alter table infocomplementares add column si08_codunidadesub int8 not null default 0;
commit;
