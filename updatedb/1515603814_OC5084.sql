
-- Ocorrência 5084
BEGIN;                   
SELECT fc_startsession();

-- Início do script
ALTER TABLE cvc102017 ALTER COLUMN si146_numerorenavam DROP DEFAULT;
ALTER TABLE cvc102017 ALTER COLUMN si146_numerorenavam TYPE varchar(14);
ALTER TABLE cvc102018 ALTER COLUMN si146_numerorenavam DROP DEFAULT;
ALTER TABLE cvc102018 ALTER COLUMN si146_numerorenavam TYPE varchar(14);

-- Fim do script

COMMIT;

