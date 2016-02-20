begin;
select fc_startsession();
alter table  ntf102016 alter column si143_chaveacesso type varchar(44);
alter table  ntf202016 alter column si145_chaveacesso type varchar(44);
commit;
