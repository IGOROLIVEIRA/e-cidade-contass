BEGIN;

INSERT INTO db_itensmenu values ((select max(id_item) + 1 from db_itensmenu),'Balancete','Balancete','con4_gerarbalancete.php',1,1,'Balancete','t');
INSERT INTO db_menu values (8987,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 8987 and modulo = 2000018),2000018);

COMMIT;
