begin;
select fc_startsession();
insert into db_itensmenu values (nextval('db_itensmenu_id_item_seq'),'Excluir','Excluir','emp1_emppagamentoexcluirpagamento001.php',1,1,'','t');
insert into db_menu values (8102,(select max(id_item) as id_item from db_itensmenu),100,39);
commit;
