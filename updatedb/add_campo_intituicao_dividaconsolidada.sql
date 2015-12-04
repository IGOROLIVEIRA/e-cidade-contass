begin;
select fc_startsession();
alter table dividaconsolidada add column si167_instit int8 default 1;
commit;
