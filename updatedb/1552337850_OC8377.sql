-- Ocorrência 8377
SELECT fc_startsession();

BEGIN;
INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Termo de Inscrição em DA','Termo de Inscrição em DA','div2_termoinscrdiv001.php',1,1,'Termo de Inscrição em DA','t');
INSERT INTO db_menu values (30,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 30 and modulo = 81),81);
COMMIT;