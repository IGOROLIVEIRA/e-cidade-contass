BEGIN;
select fc_startsession();
alter table empautoriza add column e54_tipodespesa int;
COMMIT;