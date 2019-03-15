BEGIN;
select fc_startsession();
ALTER TABLE contratos202019 ALTER si87_dtassinaturacontoriginal DROP NOT NULL;
COMMIT;
