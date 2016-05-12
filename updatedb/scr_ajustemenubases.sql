begin;
select fc_startsession();

update db_itensmenu set descricao = 'Proventos', help = 'Proventos', funcao = 'pes1_rhbasesproventos006.php' where id_item = 3000269;
insert into db_itensmenu values (3000274,'Descontos','Descontos','pes1_rhbasesdescontos006.php',1,1,'','t');
insert into db_menu values (3000268,3000274,2,952);

commit;