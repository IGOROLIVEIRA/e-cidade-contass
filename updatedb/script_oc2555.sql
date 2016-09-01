select fc_startsession();
begin;
update db_itensmenu set libcliente = true where id_item = 3507;
delete from db_menu where id_item_filho = 3507 and modulo = 398;
commit;