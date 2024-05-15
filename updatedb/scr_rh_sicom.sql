begin;


INSERT INTO db_itensmenu VALUES (3000271, 'Sicom Folha', '','',1,1,'','t');
insert into db_menu values (5106,3000271,103,952);


update db_menu set id_item = 3000271, id_item_filho = 2000001 where id_item = 5106 and id_item_filho = 2000001 and modulo = 952;

update db_menu set id_item = 3000271, id_item_filho = 3000257 where id_item = 5106 and id_item_filho = 3000257 and modulo = 952;

commit;