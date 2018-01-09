
-- Ocorrência 5015
BEGIN;                   
SELECT fc_startsession();

-- Início do script

UPDATE db_syscampo
SET rotulo='Descricao do Item',
    rotulorel='Descricao do Item'
WHERE codcam = 9340;

-- Fim do script

COMMIT;

