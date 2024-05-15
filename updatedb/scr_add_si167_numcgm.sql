BEGIN;

ALTER TABLE dividaconsolidada ADD COLUMN si167_numcgm int;

ALTER TABLE dividaconsolidada ALTER COLUMN si167_tipodocumentocredor DROP NOT NULL;
ALTER TABLE dividaconsolidada ALTER COLUMN si167_nrodocumentocredor DROP NOT NULL;

COMMIT;