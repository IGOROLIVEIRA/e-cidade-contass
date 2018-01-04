
-- Ocorrência 4995
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table pcfornecertifdoc alter column pc75_numdocumento type varchar(30);

-- Fim do script

COMMIT;

