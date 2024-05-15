BEGIN;
SELECT fc_startsession();

ALTER TABLE empempenho ALTER COLUMN e60_numerol TYPE character(16);
ALTER TABLE empautoriza ALTER COLUMN e54_numerl TYPE character varying(16);
ALTER TABLE empautoriza ALTER COLUMN e54_nummodalidade TYPE bigint;

COMMIT;
