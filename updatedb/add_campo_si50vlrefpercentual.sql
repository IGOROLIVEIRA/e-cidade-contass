BEGIN;
SELECT fc_startsession();

-- Operações nas tabelas
ALTER TABLE aberlic142017 ADD COLUMN si50_vlrefpercentual   float4 NOT NULL default 0;

COMMIT;
