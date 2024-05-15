SELECT fc_startsession();
BEGIN;
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ((select max(id_item)+1 from db_itensmenu),'Capa de Processo' ,'Capa de Processo' ,'lic2_capaprocesso001.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 1797 ,(select max(id_item) from db_itensmenu) ,104 ,381 );
commit;