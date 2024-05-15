
-- Ocorrência 7285
BEGIN;                   
SELECT fc_startsession();

-- Início do script

UPDATE db_itensmenu SET descricao='Liberar Empenhos para OC e Liquidação', help = 'Liberar Empenhos para OC e Liquidação' WHERE id_item = 8004;

-- Fim do script

COMMIT;

