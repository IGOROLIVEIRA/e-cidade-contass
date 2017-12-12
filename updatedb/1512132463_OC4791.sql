
-- Ocorrência 4791
BEGIN;
SELECT fc_startsession();

-- Início do script
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Folha de Ponto Manual', 'Folha de Ponto Manual', 'pes2_folhaponto001.php', 1, 1, 'Folha de Ponto Manual', 't');
INSERT INTO db_menu VALUES (4815, (select max(id_item) from db_itensmenu), 4, 952);
-- Fim do script

COMMIT;
