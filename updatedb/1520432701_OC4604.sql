
-- Ocorrência 4604
BEGIN;
SELECT fc_startsession();

-- Início do script

alter table flpgo102018 drop column si195_nrodocumento;
alter table flpgo102018 drop column si195_codreduzidopessoa;

alter table flpgo112018 drop column si196_nrodocumento;
alter table flpgo112018 drop column si196_codreduzidopessoa;

alter table flpgo122018 drop column si197_nrodocumento;
alter table flpgo122018 drop column si197_codreduzidopessoa;

-- Fim do script

COMMIT;
