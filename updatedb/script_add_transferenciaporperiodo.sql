BEGIN;

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values (3000182,'Transferência de bens por periodo','Transferência de bens por periodo','func_periodobenstrans001.php',1,1,'Transferência de bens por periodo','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (30,3000182,445,439);

COMMIT;
