begin;
select fc_startsession();
insert into db_itensmenu values (3000109,'Geral TFD' ,'Geral TFD','tfd2_geraltfd001.php',1,1,'','t');
insert into db_menu values (8324,3000109,100,8322);
commit;
