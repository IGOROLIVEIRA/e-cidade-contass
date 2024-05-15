
-- Ocorrência 4604
BEGIN;

SELECT fc_startsession();

-- Início do script

ALTER TABLE tetoremuneratorio add column te01_nrleiteto int4 NOT NULL default 0;
ALTER TABLE tetoremuneratorio add column te01_dtpublicacaolei date;
ALTER TABLE tetoremuneratorio ALTER COLUMN te01_dtfinal DROP NOT NULL;

ALTER TABLE terem102013 ALTER COLUMN si194_dtfinal DROP NOT NULL;
ALTER TABLE terem102014 ALTER COLUMN si194_dtfinal DROP NOT NULL;
ALTER TABLE terem102015 ALTER COLUMN si194_dtfinal DROP NOT NULL;
ALTER TABLE terem102016 ALTER COLUMN si194_dtfinal DROP NOT NULL;
ALTER TABLE terem102017 ALTER COLUMN si194_dtfinal DROP NOT NULL;
ALTER TABLE terem102018 ALTER COLUMN si194_dtfinal DROP NOT NULL;

-- Fim do script

COMMIT;

