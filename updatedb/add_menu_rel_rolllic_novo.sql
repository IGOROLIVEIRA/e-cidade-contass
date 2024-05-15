select fc_startsession();
BEGIN;
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values (3000281,'Roll de Licitações' ,'Roll de Licitações' ,'lic2_rolllicita001.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 1797 ,3000281 ,103 ,381 );
commit;