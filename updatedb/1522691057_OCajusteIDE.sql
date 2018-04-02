
-- Ocorrência ajusteIDE
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table ide2013 alter column si11_codorgao type varchar(3);
alter table ide2014 alter column si11_codorgao type varchar(3);

-- Fim do script

COMMIT;

