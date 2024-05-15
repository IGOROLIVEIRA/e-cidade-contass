	BEGIN;

	INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values (
	3000116,'Consulta TFD','Consulta TFD','sau3_consultatfd.php',1,1,'Consulta TFD','t');
	INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) values (8172,3000116,3,8322);

	COMMIT;