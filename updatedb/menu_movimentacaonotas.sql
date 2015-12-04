begin;
select fc_startsession();
insert into db_itensmenu values (3000114,'Movimentação de Notas','Movimentação de Notas','emp2_movimentacaonotas001.php',1,1,'Movimentação de Notas','t');
insert into db_menu values (30,3000114,443,398);
commit;
