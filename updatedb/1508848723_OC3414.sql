
-- Ocorrência 3414

BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Excluir Empenhos', 'Excluir Empenhos', 'emp1_exclusaoempenho003.php', 1, 1, 'Excluir Empenhos', 't');
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Empenhos Excluídos', 'Empenhos Excluídos', 'emp2_empenhosexcluidos001.php', 1, 1, 'Empenhos Excluídos', 't');

INSERT INTO db_menu VALUES (4021, (select max(id_item) - 1 from db_itensmenu), 110, 398);
INSERT INTO db_menu VALUES (5603, (select max(id_item) from db_itensmenu), 111, 398);

COMMIT;
