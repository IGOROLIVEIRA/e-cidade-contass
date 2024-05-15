BEGIN;
SELECT fc_startsession();

-- inserção de campo
ALTER TABLE dividaconsolidada
  ADD COLUMN si167_subtipo VARCHAR(1) DEFAULT NULL;



COMMIT;
