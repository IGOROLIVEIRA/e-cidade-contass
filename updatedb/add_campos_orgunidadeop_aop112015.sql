begin;
select fc_startsession();
alter table aop112015 add column si138_codorgaoempop varchar(2);
alter table aop112015 add column si138_codunidadeempop varchar(8);
commit;

