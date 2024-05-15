begin;
select fc_startsession();
insert into db_itensmenu values (4000285,'Destinos','Destinos','',1,1,'Destino      ','t');
insert into db_itensmenu values (4000286,'Inclusão','Inculir Destino','vei1_veiccaddestino001.php',1,1,'Incluir Destino','t');
insert into db_itensmenu values (4000287,'Alteração','Alterar Destino','vei1_veiccaddestino002.php',1,1,'Alterar Destino','t');
insert into db_itensmenu values (4000288,'Exclusão','Excluir Destino','vei1_veiccaddestino003.php',1,1,'Excluir Destino','t');

insert into db_menu values (5335,4000285,14,633);
insert into db_menu values (4000285,4000286,1,633);
insert into db_menu values (4000285,4000287,2,633);
insert into db_menu values (4000285,4000288,3,633);
commit;