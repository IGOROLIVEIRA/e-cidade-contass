begin;
select fc_startsession();
alter table cgmalt alter column z05_nome type varchar(100);
commit;