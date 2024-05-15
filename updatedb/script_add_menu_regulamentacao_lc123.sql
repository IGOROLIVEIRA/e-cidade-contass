select fc_startsession();
BEGIN;
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
     values (3000265,'Regulamentacao LC 123/2006' ,'Regulamentacao LC 123/2006' ,'' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 3470 ,3000265 ,106 ,381 );
--inclusao
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
     values (3000266,'Inclusão' ,'Inclusão Regulamentacao LC 123/2006' ,'lic1_regulamentalc123001.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 3000265 ,3000266, 1, 381 );
--exclusao
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
     values (3000267,'Exclusão' ,'Exclusão Regulamentacao LC 123/2006' ,'lic1_regulamentalc123003.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 3000265 ,3000267, 2, 381 );
COMMIT;