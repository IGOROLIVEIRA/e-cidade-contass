
-- Ocorrência 8551
BEGIN;                   
SELECT fc_startsession();

-- Início do script

ALTER TABLE afast102019 ALTER si199_codafastamento TYPE bigint;
ALTER TABLE afast202019 ALTER si200_codafastamento TYPE bigint;
ALTER TABLE afast302019 ALTER si201_codafastamento TYPE bigint;
-- Fim do script

COMMIT;

