begin;
select fc_startsession();
insert into db_itensmenu values (3000258,'Importar Sicom','Importar Sicom','con4_importasicom.php',1,1,'Importar Sicom','t');
insert into db_menu values (32,3000258,455,2000018);
commit;
