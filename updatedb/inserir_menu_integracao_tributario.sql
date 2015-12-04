begin;
select fc_startsession();
insert into db_itensmenu values (3000106,'Integração Tributário','Integração Tributário','cai4_integracaotribut001.php',1,1,'','t');
insert into db_menu values (9419,3000106,100,39);
commit;
