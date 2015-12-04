begin;
select fc_startsession();
alter table ntf102015 alter column si143_nfnumero type varchar(20);
alter table ntf202015 alter column si145_nfnumero type varchar(20);
commit;
