SELECT fc_startsession();
BEGIN;
alter table recibounica add column k00_receit integer DEFAULT 0;
commit;
