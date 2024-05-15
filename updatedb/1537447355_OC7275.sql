-- Ocorrência 7275
BEGIN;
SELECT fc_startsession();

-- Início do script

INSERT
INTO  db_itensmenu
VALUES  (  (select max(id_item) + 1 from db_itensmenu),
           'Execução de Contratos',
           'Execução de Contratos',
           'con2_execucaodecontratos001.php',
           1,
           1,
           'Execução de Contratos',
           't'
);

INSERT
INTO  db_menu (id_item, id_item_filho, menusequencia, modulo)
VALUES  ( -- id_item
          (     SELECT  b.id_item
                FROM  db_itensmenu AS a
                  INNER JOIN  db_menu AS b
                    ON  a.id_item = b.id_item_filho
                WHERE  id_item_filho
                       IN  (
                         (SELECT id_item FROM  db_itensmenu WHERE  funcao = 'con2_relatorioacordosavencer001.php' LIMIT 1),
                         (SELECT id_item FROM  db_itensmenu WHERE funcao = 'con2_saldocontratos001.php' LIMIT  1)
                       )
                LIMIT  1
          ),

          -- id_item_filho
          (SELECT  id_item FROM  db_itensmenu WHERE  funcao = 'con2_execucaodecontratos001.php' LIMIT  1),

          -- menusequencia
          (  SELECT  MAX(menusequencia)+1
             FROM  db_menu
             WHERE  db_menu.id_item_filho
                    IN  (
                      (SELECT id_item FROM db_itensmenu WHERE funcao = 'con2_relatorioacordosavencer001.php' LIMIT 1),
                      (SELECT id_item FROM db_itensmenu WHERE funcao = 'con2_saldocontratos001.php' LIMIT  1)
                    )
          ),

          -- modulo
          (     SELECT  b.modulo
                FROM  db_itensmenu
                  AS  a
                  INNER JOIN  db_menu AS b
                    ON  a.id_item = b.id_item_filho
                WHERE  id_item_filho
                       IN  (
                         (SELECT id_item FROM db_itensmenu WHERE funcao = 'con2_relatorioacordosavencer001.php' LIMIT 1),
                         (SELECT id_item FROM db_itensmenu WHERE funcao = 'con2_saldocontratos001.php' LIMIT  1)
                       )
                LIMIT  1
          )
);

-- Fim do script

COMMIT;