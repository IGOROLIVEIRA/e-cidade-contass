
-- Ocorrência 4539
BEGIN;                   
SELECT fc_startsession();

-- Início do script

ALTER TABLE ordembancariapagamento ADD COLUMN k00_ordemauxiliar bigint;

-- Fim do script

COMMIT;

