begin;
select fc_startsession();
alter table dividaconsolidada add column si167_anoreferencia int8 default 0;
commit;
