
-- Ocorrência 78509
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table acordo alter column ac16_numeroacordo type varchar(14);

-- Fim do script

COMMIT;

