-- Ocorrência 6650
BEGIN;

SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Processamento de Inventário',
                                 'Processamento de Inventário',
                                 'mat2_processamentoinventario001.php',
                                 1,
                                 1,
                                 'Processamento de Inventário',
                                 't');


INSERT INTO db_menu
VALUES (
            (SELECT id_item_filho
             FROM db_menu
             JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item
             WHERE modulo =
                     (SELECT id_item
                      FROM db_modulos
                      WHERE nome_modulo = 'Material')
                 AND descricao LIKE 'Conferência'),
            (SELECT max(id_item)
             FROM db_itensmenu),
            (SELECT max(menusequencia)+1
             FROM db_menu
             WHERE id_item =
                     (SELECT id_item_filho
                      FROM db_menu
                      JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item
                      WHERE modulo =
                              (SELECT id_item
                               FROM db_modulos
                               WHERE nome_modulo = 'Material')
                          AND descricao LIKE 'Conferência')
                 AND modulo = 480), 480);

-- Fim do script

COMMIT;

