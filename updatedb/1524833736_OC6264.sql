
-- Ocorrência 6264
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table public.licpregao add column l45_instit integer;

-- Fim do script

COMMIT;

