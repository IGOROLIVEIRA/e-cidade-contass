BEGIN;

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values (3000121,'Exclusão','Exclusão','pat1_bensglobal003.php',1,1,'Exclusão','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (3839,3000121,3,439);

COMMIT;
