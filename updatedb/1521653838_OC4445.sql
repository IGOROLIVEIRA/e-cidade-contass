-- Ocorrência 4445
BEGIN;


SELECT fc_startsession();

-- Início do script

INSERT INTO db_menu
VALUES (
            (SELECT db_menu.id_item
             FROM db_menu
             JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item
             WHERE modulo =
                     (SELECT id_item
                      FROM db_modulos
                      WHERE nome_modulo = 'Material')
                 AND descricao LIKE 'Cadastro de Unidades'
                 AND menusequencia = 1), 3602,
            (SELECT max(menusequencia)+1
             FROM db_menu
             WHERE id_item =
                     (SELECT db_menu.id_item
                      FROM db_menu
                      JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item
                      WHERE modulo =
                              (SELECT id_item
                               FROM db_modulos
                               WHERE nome_modulo = 'Material')
                          AND descricao LIKE 'Cadastro de Unidades'
                          AND menusequencia = 1)
                 AND modulo =
                     (SELECT id_item
                      FROM db_modulos
                      WHERE nome_modulo = 'Material')),
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));


INSERT INTO db_menu
VALUES (3602,
        3603,
        1,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));


INSERT INTO db_menu
VALUES (3602,
        3604,
        2,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));


INSERT INTO db_menu
VALUES (3602,
        3605,
        3,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- Fim do script


COMMIT;
