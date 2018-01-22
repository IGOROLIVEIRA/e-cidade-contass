
-- Ocorrência 4604
BEGIN;                   
SELECT fc_startsession();

-- Início do script

ALTER TABLE infocomplementaresinstit ADD COLUMN si09_assessoriacontabil bigint;
ALTER TABLE infocomplementaresinstit ADD COLUMN si09_cgmassessoriacontabil bigint;

-- Fim do script

COMMIT;

