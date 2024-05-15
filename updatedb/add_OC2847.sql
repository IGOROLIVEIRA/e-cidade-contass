begin;
insert into db_itensmenu(id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) values ( (select max(id_item)+1 from db_itensmenu) ,'Manutenção de veículos','Manutenção de veículos','vei2_manutveic001.php','1','1','Manutenção de veículos','true');
insert into db_menu(id_item,id_item_filho,menusequencia,modulo) values (5336,(select max(id_item) from db_itensmenu),22,633);
commit;