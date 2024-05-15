begin;
select fc_startsession();
update db_menu set modulo=209,id_item=3332,menusequencia=200 where id_item_filho=3000067;
update db_menu set modulo=209 where id_item=3000067;

update db_menu set modulo=209,id_item=3332,menusequencia=201 where id_item_filho=3000059;
update db_menu set modulo=209 where id_item=3000059;

update db_menu set modulo=209,id_item=3332,menusequencia=203 where id_item_filho=3000063;
update db_menu set modulo=209 where id_item=3000063;
commit;
