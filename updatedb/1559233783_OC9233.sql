
-- Ocorrência 9233
BEGIN;                   
SELECT fc_startsession();

-- Início do script
UPDATE db_syscampo SET rotulo = 'Nº Processo',rotulorel='Nº Processo' WHERE codcam = (select codcam from db_syscampo where nomecam like '%e54_numerl%');


-- Fim do script

COMMIT;

