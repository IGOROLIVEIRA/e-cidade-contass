
-- Ocorrência 4604
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table flpgo102016 alter column si195_nrodocumento TYPE varchar(11);
alter table flpgo102015 alter column si195_nrodocumento TYPE varchar(11);
alter table flpgo102014 alter column si195_nrodocumento TYPE varchar(11);
alter table flpgo102013 alter column si195_nrodocumento TYPE varchar(11);

-- Fim do script

COMMIT;

