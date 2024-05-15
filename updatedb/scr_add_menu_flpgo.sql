BEGIN;

select fc_startsession();

INSERT INTO db_itensmenu VALUES (3000257, 'Folha', '','con4_gerarflpgo.php',1,1,'','t');

INSERT INTO db_menu VALUES (8987,3000257,(select max(menusequencia)+1 from db_menu where id_item = 8987),2000018);

COMMIT;