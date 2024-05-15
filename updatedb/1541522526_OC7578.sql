
-- Ocorrência 7578
BEGIN;                   
SELECT fc_startsession();

-- Início do script
INSERT INTO db_itensmenu VALUES((select max(id_item)+1 FROM db_itensmenu), 'Solicitação de Compras','Solicitação de Compras','com2_emitesolicitacao001.php',1,1,'Solicitação de Compras','t');
INSERT INTO db_menu VALUES(9153,(SELECT max(id_item) FROM db_itensmenu),10,28);

-- Fim do script

COMMIT;

