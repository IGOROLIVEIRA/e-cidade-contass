BEGIN;

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES (
 (SELECT max(id_item)+1 FROM db_itensmenu),'Exclusão','Exclusão','emp1_empautoriza003.php',1,1,'Exclusão','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values 
(2567,(SELECT id_item FROM db_itensmenu WHERE funcao = 'emp1_empautoriza003.php'),3,398);
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values 
(2567,(SELECT id_item FROM db_itensmenu WHERE funcao = 'emp1_empautoriza003.php'),3,28);

COMMIT;
