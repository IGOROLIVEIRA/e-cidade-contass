SELECT fc_startsession();
BEGIN;
ALTER TABLE bensdispensatombamento ADD COLUMN e139_codcla int8;
ALTER TABLE bensdispensatombamento ADD CONSTRAINT bensdispensatombamento_clabens_fk FOREIGN KEY (e139_codcla) REFERENCES clabens(t64_codcla);
commit;