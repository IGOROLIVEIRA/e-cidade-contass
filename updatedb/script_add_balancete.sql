BEGIN;

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values (3000093,'Balancete','Balancete','con4_gerarbalancete.php',1,1,'Balancete','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (8987,3000093,4,2000018);

COMMIT;
