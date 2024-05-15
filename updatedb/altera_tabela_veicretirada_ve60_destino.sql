SELECT fc_startsession();
BEGIN;
ALTER TABLE veicretirada ALTER COLUMN ve60_destino TYPE character varying(100);
COMMIT;