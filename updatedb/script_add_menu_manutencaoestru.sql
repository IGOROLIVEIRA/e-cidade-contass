BEGIN;
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
     values ( 9994 ,'Manutenção Estrutural PCASP' ,'Manutenção Estrutural PCASP' ,'con4_manutencaoEstruturalPCASP.php' ,'1' ,'1' ,'Manutenção Estrutural PCASP' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4197 ,9994 ,13 ,209 );

COMMIT;