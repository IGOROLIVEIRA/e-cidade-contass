BEGIN;

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente)
VALUES (
          (SELECT max(id_item)+1
           FROM db_itensmenu),'Quantum',
                              'Quantum',
                              'pes1_quantum.php',
                              1,
                              1,
                              '',
                              't');

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo)
VALUES (5106,
          (SELECT id_item
           FROM db_itensmenu
           WHERE descricao = 'Quantum'),100,
                                      952);

COMMIT;