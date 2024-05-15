BEGIN;

select fc_startsession();

INSERT INTO db_itensmenu VALUES (4000290,'E-social', '','',1,1,'','t');

INSERT INTO db_itensmenu VALUES (4000291,'Qualificação cadastral', '','pes4_gerarqualificacaocad.php',1,1,'','t');

INSERT INTO db_menu VALUES (5106,4000290,101,952);

INSERT INTO db_menu VALUES (4000290,4000291,1,952);

COMMIT;