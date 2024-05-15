
-- Ocorrência 4298
BEGIN;
SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Dispensa de Tombamento', 'Dispensa de Tombamento', 'pat2_dispensatombamento001.php', 1, 1, 'Dispensa de Tombamento', 't');

INSERT INTO db_menu VALUES (30, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 30 and modulo = 439), 439);

COMMIT;

