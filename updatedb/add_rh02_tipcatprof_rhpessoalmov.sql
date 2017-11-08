BEGIN;

ALTER TABLE rhpessoalmov ADD COLUMN IF NOT EXISTS rh02_tipcatprof integer ;
COMMIT;