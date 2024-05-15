begin;
update db_itensmenu set libcliente = false where id_item in (7055);

update db_itensmenu set libcliente = true where id_item = 55;
commit;

/*
Acerto relativo a OC 2445.
Menu 55 foi inativado equivocadamente.
Ajustado, sendo inativado o menu 7055, e reativado o menu 55.
*/