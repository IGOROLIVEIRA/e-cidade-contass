begin;
select fc_startsession();
update db_itensmenu set libcliente='t' where id_item=9046;
update db_menu set id_item=3962 where id_item_filho =9046;
update db_menu set modulo=2000018 where id_item_filho =9046;
commit;
