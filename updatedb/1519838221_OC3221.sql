
-- Ocorrência 3221
BEGIN;
SELECT fc_startsession();

-- Início do script

DELETE
FROM db_menu
WHERE modulo = 28
  AND id_item_filho IN
    (SELECT id_item
     FROM db_itensmenu
     WHERE descricao LIKE 'Controle de Ordens de Compra');


DELETE
FROM db_itensmenu
WHERE descricao LIKE 'Controle de Ordens de Compra'
  AND funcao LIKE 'sys4_geradorteladinamica001.php%';

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Controle de Ordens de Compra', 'Controle de Ordens de Compra', 'com2_conordemcom001.php', 1, 1, 'Controle de Ordens de Compra', 't');

INSERT INTO db_menu VALUES (30, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 30 and modulo = 28), 28);


-- Fim do script

COMMIT;
