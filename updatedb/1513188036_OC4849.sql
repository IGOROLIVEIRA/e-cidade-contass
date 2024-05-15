
-- Ocorrência 4849
BEGIN;                   
SELECT fc_startsession();

-- Início do script

BEGIN;
select nextval('db_itensmenu_id_item_seq');
insert into db_itensmenu( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 4001128 ,'Parâmetros Contratos' ,'Parâmetros Contratos' ,'aco1_parametroscontratos002.php' ,'1' ,'1' ,'Parâmetros Contratos' ,'true' );
select * from db_itensmenu where db_itensmenu.id_item = 4001128;
select nextval('db_acount_id_acount_seq') as acount;
insert into db_acountacesso values(306655,26182);
insert into db_acountkey values(306655,821,'4001128','I');
insert into db_acount values(306655,156,821,'','4001128',1513090720,1);
insert into db_acount values(306655,156,750,'','Parâmetros Contratos',1513090720,1);
insert into db_acount values(306655,156,823,'','Parâmetros Contratos',1513090720,1);
insert into db_acount values(306655,156,824,'','aco1_parametroscontratos002.php',1513090720,1);
insert into db_acount values(306655,156,825,'','1',1513090720,1);
insert into db_acount values(306655,156,826,'','1',1513090720,1);
insert into db_acount values(306655,156,827,'','Parâmetros Contratos',1513090720,1);
insert into db_acount values(306655,156,8923,'','t',1513090720,1);
COMMIT;

BEGIN;


delete from db_menu where id_item_filho = 4001128 AND modulo = 8251;

insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 32 ,4001128 ,459 ,8251 );

-- Fim do script

COMMIT;

