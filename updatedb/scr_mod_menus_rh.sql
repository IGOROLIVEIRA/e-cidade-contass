 begin;

 update db_menu set id_item = 5106 where id_item_filho = 3000262 and id_item = 268991;

 insert into db_menu values (5106,3000257,101,952);

 update db_itensmenu set descricao = 'Sicom folha' where id_item  = 3000257;

 commit;