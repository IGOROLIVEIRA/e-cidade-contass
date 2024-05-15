
-- Ocorrência 8618
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Balancete MSC','Balancete MSC','con2_balancetemsc001.php',1,1,'Balancete MSC','t');
INSERT INTO db_menu values (30,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 30 and modulo = 2000025),2000025);

-- Fim do script

COMMIT;

