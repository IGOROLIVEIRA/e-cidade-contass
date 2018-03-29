
-- Ocorrência ajusteIDE
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table ide2017 alter column si11_codorgao type varchar(3);
alter table ide2016 alter column si11_codorgao type varchar(3);
alter table ide2015 alter column si11_codorgao type varchar(3);

-- Fim do script

COMMIT;

