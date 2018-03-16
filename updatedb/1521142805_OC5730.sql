
-- Ocorrência 5730
BEGIN;
SELECT fc_startsession();

-- Início do script

UPDATE db_menu
SET id_item = 3331,
    menusequencia =
  (SELECT (max(menusequencia)+1)
   FROM db_menu
   JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho
   WHERE db_menu.id_item = 3331
     AND modulo = 209)
WHERE id_item_filho =
    (SELECT id_item_filho
     FROM db_menu
     JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho
     WHERE descricao LIKE 'Demonstrativo Extra-%');

-- Fim do script

COMMIT;

