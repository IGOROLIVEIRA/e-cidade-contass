select fc_startsession();
BEGIN;
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values (3000279,'Despesa por Item/Desdobramento' ,'Despesa por Item/Desdobramento' ,'orc2_despitemdesdobramento001.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4189 ,3000279 ,16 ,209 );
commit;