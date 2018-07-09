
-- Ocorrência 6860
BEGIN;                   
SELECT fc_startsession();

-- Início do script

ALTER TABLE inventariomaterial ALTER COLUMN i77_estoqueinicial TYPE double precision;
ALTER TABLE inventariomaterial ALTER COLUMN i77_contagem TYPE double precision;

-- Fim do script

COMMIT;

