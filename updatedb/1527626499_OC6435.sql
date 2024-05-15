
-- Ocorrência 6435
BEGIN;                   
SELECT fc_startsession();

-- Início do script

ALTER TABLE bens ALTER COLUMN t52_descr TYPE varchar(250);

-- Fim do script

COMMIT;

