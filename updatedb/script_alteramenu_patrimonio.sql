BEGIN;

select fc_startsession();

update db_menu set id_item = 30, menusequencia = 601 where id_item_filho = 2000041;

COMMIT;
