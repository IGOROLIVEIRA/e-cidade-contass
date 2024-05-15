begin;
SELECT fc_startsession();
alter table veicretirada add column ve60_destinonovo integer;
commit;
