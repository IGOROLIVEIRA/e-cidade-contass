BEGIN;

select fc_startsession();

INSERT INTO db_itensmenu VALUES (3000268,'Bases sicom', 'Bases sicom','',1,1,'','t');

INSERT INTO db_menu VALUES (4374,3000268,100,952);

INSERT INTO db_itensmenu VALUES (3000269,'Alteração', 'Alteração','pes1_rhbasesrh002.php',1,1,'','t');

INSERT INTO db_menu VALUES (3000268,3000269,1,952);

COMMIT;