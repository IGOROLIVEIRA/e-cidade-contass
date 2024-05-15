BEGIN;
SELECT fc_startsession();
-- Ocorrência

-- Alter table
ALTER TABLE empempenho ADD COLUMN e60_tipodespesa int8;

COMMIT;
