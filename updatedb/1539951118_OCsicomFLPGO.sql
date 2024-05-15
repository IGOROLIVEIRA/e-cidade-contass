
-- Ocorrência sicomFLPGO
BEGIN;                   
SELECT fc_startsession();

-- Início do script
ALTER TABLE rhpessoalmov ADD COLUMN rh02_cgminstituidor int4;
ALTER TABLE rhpessoalmov ADD COLUMN rh02_dtobitoinstituidor date;
ALTER TABLE rhpessoalmov ADD COLUMN rh02_tipoparentescoinst int4;
ALTER TABLE rhfuncao ADD COLUMN rh37_exerceatividade boolean;

-- Fim do script

COMMIT;

