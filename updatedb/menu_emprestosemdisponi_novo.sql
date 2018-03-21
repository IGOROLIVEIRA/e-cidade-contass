BEGIN;


SELECT fc_startsession();


UPDATE db_itensmenu
SET funcao = ''
WHERE descricao = 'RP Sem Disponiblidade';


INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente)
VALUES (
            (SELECT max(id_item)+1
             FROM db_itensmenu), 'Incluir',
                                 'Incluir',
                                 'con1_emprestosemdesponi001.php',
                                 1,
                                 1,
                                 'Incluir',
                                 't');


INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo)
VALUES (
            (SELECT id_item
             FROM db_itensmenu
             WHERE descricao = 'RP Sem Disponiblidade'),
            (SELECT max(id_item)
             FROM db_itensmenu),1,
                                209);


INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente)
VALUES (
            (SELECT max(id_item)+1
             FROM db_itensmenu), 'Alterar',
                                 'Alterar',
                                 'con1_emprestosemdesponi002.php',
                                 1,
                                 1,
                                 'Alterar',
                                 't');


INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo)
VALUES (
            (SELECT id_item
             FROM db_itensmenu
             WHERE descricao = 'RP Sem Disponiblidade'),
            (SELECT max(id_item)
             FROM db_itensmenu),2,
                                209);


INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente)
VALUES (
            (SELECT max(id_item)+1
             FROM db_itensmenu), 'Excluir',
                                 'Excluir',
                                 'con1_emprestosemdesponi003.php',
                                 1,
                                 1,
                                 'Excluir',
                                 't');


INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo)
VALUES (
            (SELECT id_item
             FROM db_itensmenu
             WHERE descricao = 'RP Sem Disponiblidade'),
            (SELECT max(id_item)
             FROM db_itensmenu),3,
                                209);
COMMIT;