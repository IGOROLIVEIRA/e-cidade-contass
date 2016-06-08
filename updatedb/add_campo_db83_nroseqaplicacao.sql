begin;
select fc_startsession();
alter table contabancaria add column db83_nroseqaplicacao int8;
commit;
