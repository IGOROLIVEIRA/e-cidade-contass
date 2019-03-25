BEGIN;

SELECT fc_startsession();

ALTER TABLE caixa132019 ADD COLUMN si105_codfontcaixa INTEGER default(0);

COMMIT;