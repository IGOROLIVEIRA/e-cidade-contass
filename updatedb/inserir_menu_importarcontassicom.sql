begin;
select fc_startsession();
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Importar Contas Sicom','Importar Contas Sicom','con4_importarcontassicom.php',1,1,'Importar Contas Sicom','t');
insert into db_menu values (32,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 32 and modulo = 1),1);
commit;