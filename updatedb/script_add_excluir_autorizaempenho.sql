BEGIN;

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values (
3000115,'Exclus�o','Exclus�o','emp1_empautoriza003.php',1,1,'Exclus�o','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values 
(2567,3000115,3,398);
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values 
(2567,3000115,3,28);

COMMIT;
