begin;
select fc_startsession();
insert into db_itensmenu values (3000098,'Excluir','Excluir','emp1_emppagamentoexcluirpagamento001.php',1,1,'','t');
insert into db_menu values (8102,3000098,100,39);
commit;
