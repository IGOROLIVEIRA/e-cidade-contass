begin;
select fc_startsession();
alter table dclrf102016 alter column si157_medidascorretivas type varchar(4000);
alter table dclrf102016 alter column si157_dtpublicacaorelatoriolrf drop not null;
commit;
