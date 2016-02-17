BEGIN;

select fc_startsession();

ALTER TABLE dividaconsolidada ADD COLUMN si167_justificativacancelamento character varying(500);


COMMIT;
