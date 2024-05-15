BEGIN;
select fc_startsession();
ALTER TABLE aoc122015 ADD COLUMN si40_valorabertolei float8 NOT NULL default 0;
COMMIT;