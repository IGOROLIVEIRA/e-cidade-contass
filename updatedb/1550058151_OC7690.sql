
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Importação saldo CTB/EXT','Importação saldo CTB/EXT','con4_importacaosaldoctbext001.php',1,1,'Importação saldo CTB/EXT','t');
INSERT INTO db_menu values (9492,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 9492 and modulo = 209),209);


-- Fim do script

COMMIT;

