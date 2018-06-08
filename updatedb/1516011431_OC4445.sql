-- Ocorrência 4445
BEGIN;


SELECT fc_startsession();

-- Início do script
-- insere item de menu inventario

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Inventario',
                                 'Inventario',
                                 '',
                                 1,
                                 1,
                                 'Inventario',
                                 't');

-- insere NO menu o item inventario

INSERT INTO db_menu
VALUES (32,
            (SELECT max(id_item)
             FROM db_itensmenu),
            (SELECT max(menusequencia)+1
             FROM db_menu
             WHERE id_item = 32
                 AND modulo =
                     (SELECT id_item
                      FROM db_modulos
                      WHERE nome_modulo = 'Material')),
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- insere item de menu abertura

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Abertura',
                                 'Abertura',
                                 '',
                                 1,
                                 1,
                                 'Abertura',
                                 't');

-- insere NO menu o item abertura

INSERT INTO db_menu
VALUES (
            (SELECT max(id_item) - 1
             FROM db_itensmenu),
            (SELECT max(id_item)
             FROM db_itensmenu), 1,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- insere item de menu inclusao

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Inclusao',
                                 'Inclusao',
                                 'pat1_inventario001.php?db_opcao=1',
                                 1,
                                 1,
                                 'Inclusao',
                                 't');

-- insere NO menu o item inclusao

INSERT INTO db_menu
VALUES (
            (SELECT max(id_item) - 1
             FROM db_itensmenu),
            (SELECT max(id_item)
             FROM db_itensmenu), 1,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- insere item de menu anulacao

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Anulacao',
                                 'Anulacao',
                                 'pat1_inventario002.php',
                                 1,
                                 1,
                                 'Anulacao',
                                 't');

-- insere NO menu o item anulacao

INSERT INTO db_menu
VALUES (
            (SELECT max(id_item) - 2
             FROM db_itensmenu),
            (SELECT max(id_item)
             FROM db_itensmenu), 2,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- insere item de menu Manutencao

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Manutencao',
                                 'Manutencao',
                                 'mat4_manutencaoinventario001.php',
                                 1,
                                 1,
                                 'Manutencao',
                                 't');

-- insere NO menu o item Manutencao

INSERT INTO db_menu
VALUES (
            (SELECT max(id_item) - 4
             FROM db_itensmenu),
            (SELECT max(id_item)
             FROM db_itensmenu), 2,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- insere item de menu Desvincular Material

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Desvincular Material',
                                 'Desvincular Material',
                                 'mat4_desvincularmaterial001.php',
                                 1,
                                 1,
                                 'Desvincular Material',
                                 't');

-- insere NO menu o item Desvincular Material

INSERT INTO db_menu
VALUES (
            (SELECT max(id_item) - 5
             FROM db_itensmenu),
            (SELECT max(id_item)
             FROM db_itensmenu), 3,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- insere item de menu Processar Inventario

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Processar Inventario',
                                 'Processar Inventario',
                                 'mat4_processarinventariol001.php',
                                 1,
                                 1,
                                 'Processar Inventario',
                                 't');

-- insere NO menu o item Processar Inventario

INSERT INTO db_menu
VALUES (
            (SELECT max(id_item) - 6
             FROM db_itensmenu),
            (SELECT max(id_item)
             FROM db_itensmenu), 4,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));

-- insere item de menu Desprocessar Inventario

INSERT INTO db_itensmenu
VALUES (
            (SELECT max(id_item) + 1
             FROM db_itensmenu), 'Desprocessar Inventario',
                                 'Desprocessar Inventario',
                                 'mat4_desprocessarinventariol001.php',
                                 1,
                                 1,
                                 'Desprocessar Inventario',
                                 't');

-- insere NO menu o item Desprocessar Inventario

INSERT INTO db_menu
VALUES (
            (SELECT max(id_item) - 7
             FROM db_itensmenu),
            (SELECT max(id_item)
             FROM db_itensmenu), 5,
            (SELECT id_item
             FROM db_modulos
             WHERE nome_modulo = 'Material'));


INSERT INTO acordocomissaotipo
VALUES (3,
        'Material');

-- Fim do script

COMMIT;

