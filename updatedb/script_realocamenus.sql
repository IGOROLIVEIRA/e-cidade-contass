BEGIN;

DELETE FROM db_menu WHERE id_item = 29 and id_item_filho = 2000027;
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (32,2000027,455,28);

DELETE FROM db_menu WHERE id_item_filho = 3000013;
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (1818,3000013,107,381);

COMMIT;