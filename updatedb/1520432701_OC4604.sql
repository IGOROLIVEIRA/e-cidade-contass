
-- Ocorrência 4604
BEGIN;
SELECT fc_startsession();

-- Início do script

alter table flpgo102018 drop column IF EXISTS si195_nrodocumento;
alter table flpgo102018 drop column IF EXISTS si195_codreduzidopessoa;

alter table flpgo112018 drop column IF EXISTS si196_nrodocumento;
alter table flpgo112018 drop column IF EXISTS si196_codreduzidopessoa;

alter table flpgo122018 drop column IF EXISTS si197_nrodocumento;
alter table flpgo122018 drop column IF EXISTS si197_codreduzidopessoa;

-- Fim do script

COMMIT;
