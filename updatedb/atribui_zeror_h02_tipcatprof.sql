begin;
update rhpessoalmov set rh02_tipcatprof = 0 where rh02_anousu = 2017 and rh02_mesusu in (7,8);
commit;