begin;
select fc_startsession();
insert into db_itensmenu values (3000259,'Relatórios Gerais','Relatórios Gerais','con4_relatoriossicom.php',1,1,'Relatórios Gerais','t');
insert into db_menu values (30,3000259,1,2000018);
commit;
