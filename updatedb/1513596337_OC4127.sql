
-- Ocorrência 4127
BEGIN;
SELECT fc_startsession();

-- Início do script
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Servidor por Lotacao', 'Servidor por Lotacao', 'pes4_servidorlotacao001.php', 1, 1, 'Servidor por Lotacao', 't');

INSERT INTO db_menu VALUES (5204, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 5204 and modulo = 952), 952);

-- Fim do script

COMMIT;

