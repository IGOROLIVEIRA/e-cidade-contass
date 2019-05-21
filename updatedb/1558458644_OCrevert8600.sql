
-- Ocorrência revert8600
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table cgm drop column z01_ibge;

-- Fim do script

COMMIT;

