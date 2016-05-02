begin;
select fc_startsession();
update db_menu set modulo=28,menusequencia=456,id_item=32 where id_item_filho = 2000032;
commit;
