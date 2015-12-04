begin;
select fc_startsession();
update dividaconsolidada set si167_anoreferencia = 2014 where si167_anoreferencia=0;
commit;
