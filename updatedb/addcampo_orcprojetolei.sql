begin;
select fc_startsession();
alter table orcprojetolei add column o138_altpercsuplementacao int8 default 0;
commit;
