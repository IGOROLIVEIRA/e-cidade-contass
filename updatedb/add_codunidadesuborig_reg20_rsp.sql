begin;
select fc_startsession();
alter table rsp202016 add column si115_codunidadesuborig varchar(8);
commit;
