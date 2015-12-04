begin;
select fc_startsession();
insert into db_itensmenu values (3000120,'Demonstrativo mensal por desdobramento','Demonstrativo mensal por desdobramento','emp2_demdesdobramento001.php',1,1,'','t');
insert into db_menu values (30,3000120,100,398);
commit;
