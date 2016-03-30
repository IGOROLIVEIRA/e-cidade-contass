select fc_startsession();
begin;
alter table ntf102016 alter column si143_nfnumero type varchar(20);
alter table ntf202016 alter column si145_nfnumero type varchar(20);
commit;
