
-- Ocorrência 3414

BEGIN;

SELECT fc_startsession();

INSERT INTO db_itensmenu VALUES (4001010, 'Excluir Empenhos', 'Excluir Empenhos', 'emp1_exclusaoempenho003.php', 1, 1, 'Excluir Empenhos', 't');
INSERT INTO db_itensmenu VALUES (4001011, 'Empenhos Excluídos', 'Empenhos Excluídos', 'emp2_empenhosexcluidos001.php', 1, 1, 'Empenhos Excluídos', 't');

INSERT INTO db_menu VALUES (4021, 4001010, 110, 398);
INSERT INTO db_menu VALUES (5603, 4001011, 111, 398);

COMMIT;
