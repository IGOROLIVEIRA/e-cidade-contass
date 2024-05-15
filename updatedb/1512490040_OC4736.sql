-- Ocorrência 4736
BEGIN;                   
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Anulação', 'Anulação','orc1_orcreservaanulacao001.php',1,1,'Anulação','t');
INSERT INTO db_menu VALUES (3236,(select max(id_item) from db_itensmenu),7,116);

ALTER TABLE orcreserva ADD COLUMN o80_justificativa text;
ALTER TABLE orcreserva ADD COLUMN o80_vlranu double precision DEFAULT 0;
ALTER TABLE orcreserva ADD COLUMN o80_dtanu date;


-- Fim do script

COMMIT;

