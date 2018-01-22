SELECT fc_startsession();
BEGIN;
ALTER TABLE confvencissqnvariavel ADD COLUMN q144_codvenc_desconto integer NOT NULL DEFAULT 0;
commit;
