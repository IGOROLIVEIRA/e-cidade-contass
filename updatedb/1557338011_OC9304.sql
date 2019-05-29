
-- Ocorrência 9304
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE bensdepreciacao ALTER COLUMN t44_vidautil TYPE NUMERIC;
UPDATE db_syscampo SET conteudo = 'numeric(10)', aceitatipo = 4 WHERE nomecam = 't44_vidautil';
ALTER TABLE inventariobem ALTER COLUMN t77_vidautil TYPE NUMERIC;
UPDATE db_syscampo SET conteudo = 'numeric(10)', aceitatipo = 4 WHERE nomecam = 't77_vidautil';

-- Fim do script

COMMIT;

