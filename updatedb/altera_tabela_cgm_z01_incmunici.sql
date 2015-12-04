BEGIN;

SELECT fc_startsession();
ALTER TABLE cgm add column z01_incmunici int8  default 0;
COMMIT;
