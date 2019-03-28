BEGIN;
select fc_startsession();
ALTER TABLE cronem102019 ADD COLUMN si170_mes bigint;
COMMIT;
