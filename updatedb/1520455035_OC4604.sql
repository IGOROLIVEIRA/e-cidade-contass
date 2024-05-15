
-- Ocorrência 4604
BEGIN;                   
SELECT fc_startsession();

-- Início do script

alter table flpgo112016 alter column si196_nrodocumento TYPE varchar(11);
alter table flpgo112015 alter column si196_nrodocumento TYPE varchar(11);
alter table flpgo112014 alter column si196_nrodocumento TYPE varchar(11);
alter table flpgo112013 alter column si196_nrodocumento TYPE varchar(11);

alter table flpgo122016 alter column si197_nrodocumento TYPE varchar(11);
alter table flpgo122015 alter column si197_nrodocumento TYPE varchar(11);
alter table flpgo122014 alter column si197_nrodocumento TYPE varchar(11);
alter table flpgo122013 alter column si197_nrodocumento TYPE varchar(11);

-- Fim do script

COMMIT;

