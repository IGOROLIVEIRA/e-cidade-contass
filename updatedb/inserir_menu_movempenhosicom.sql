begin;
select fc_startsession();
insert into db_itensmenu values (3000260,'Movimentação de Empenhos Sicom','Movimentação de Empenhos Sicom','con4_movempenhossicom001.php',1,1,'Movimentação de Empenhos Sicom','t');
insert into db_menu values (30,3000260,2,2000018);
commit;