BEGIN;
select fc_startsession();

ALTER TABLE empautoriza
ADD column e54_gestaut int4 NOT NULL default 0;

ALTER TABLE empautoriza
ADD CONSTRAINT empautoriza_depto_gestaut_fk FOREIGN KEY (e54_gestaut)
REFERENCES db_depart;

COMMIT;
