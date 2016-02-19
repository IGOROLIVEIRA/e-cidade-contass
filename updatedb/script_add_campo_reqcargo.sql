BEGIN;
select fc_startsession();
ALTER TABLE rhfuncao ADD COLUMN rh37_reqcargo int4 NOT NULL default 0;
COMMIT;