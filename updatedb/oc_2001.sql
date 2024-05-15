begin;

select fc_startsession();

update db_menu set id_item = 3470, modulo = 381, menusequencia = 201 where modulo = 2000018 and id_item = 3962 and id_item_filho = 3000075;
update db_menu set modulo = 381 where modulo = 2000018 and id_item = 3000075

update db_menu set id_item = 3470, modulo = 381, menusequencia = 202 where modulo = 2000018 and id_item = 3962 and id_item_filho = 2000028;
update db_menu set modulo = 381 where modulo = 2000018 and id_item = 2000028;

update db_menu set id_item = 3470, modulo = 381, menusequencia = 203 where modulo = 2000018 and id_item = 3962 and id_item_filho = 3000079;
update db_menu set modulo = 381 where modulo = 2000018 and id_item = 3000079;

update db_menu set id_item = 3470, modulo = 381, menusequencia = 204 where modulo = 2000018 and id_item = 3962 and id_item_filho = 3000083;
update db_menu set modulo = 381 where modulo = 2000018 and id_item = 3000083;


commit;