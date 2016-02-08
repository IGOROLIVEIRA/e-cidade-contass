BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES (3000255, 'Legislação Caráter Financeiro', '','con4_gerarlcf.php',1,1,'','t');

INSERT INTO db_menu VALUES (8987,3000255,(select max(menusequencia)+1 from db_menu where id_item = 8987),2000018);

COMMIT;