
-- Ocorrência 4883
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu
VALUES (
          (SELECT max(id_item) + 1
           FROM db_itensmenu), 'Alteracao de Dotacao',
                               'Alteracao de Dotacao',
                               'ac04_alteradotacao001.php',
                               1,
                               1,
                               'Alteracao de Dotacao',
                               't');


INSERT INTO db_menu
VALUES (8289,
          (SELECT max(id_item)
           FROM db_itensmenu),
          (SELECT max(menusequencia)+1
           FROM db_menu
           WHERE id_item = 8289
             AND modulo = (SELECT id_item
                FROM db_modulos
                WHERE nome_modulo = 'Contratos')), (SELECT id_item
                FROM db_modulos
                WHERE nome_modulo = 'Contratos'));

-- Fim do script

COMMIT;

