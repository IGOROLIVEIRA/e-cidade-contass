BEGIN;
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values ((select max(id_item)+1 from db_itensmenu),'SIGAF','SIGAF','mat4_gerarsigaf.php',1,1,'SIGAF','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (32,(select id_item from db_itensmenu where descricao = 'SIGAF'),453,480);

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values ((select max(id_item)+1 from db_itensmenu),'Questionário de Triagem','Questionário de Triagem','',1,1,'Questionário de Triagem','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (3444,(select id_item from db_itensmenu where descricao = 'Questionário de Triagem'),400,6877);

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','far1_qtriagem001.php',1,1,'Inclusão','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values ((select id_item from db_itensmenu where descricao = 'Questionário de Triagem'),(select max(id_item) from db_itensmenu),1,6877);
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','far1_qtriagem002.php',1,1,'Alteração','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values ((select id_item from db_itensmenu where descricao = 'Questionário de Triagem'),(select max(id_item) from db_itensmenu),2,6877);
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','far1_qtriagem003.php',1,1,'Exclusão','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values ((select id_item from db_itensmenu where descricao = 'Questionário de Triagem'),(select max(id_item) from db_itensmenu),3,6877);


COMMIT;