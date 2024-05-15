
-- Ocorrência 6637
BEGIN;
SELECT fc_startsession();

-- Início do script

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Cancelar Finalizacao','Cancelar Finalizacao','',1,1,'Cancelar Finalizacao','t');
insert into db_menu values (4296,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 4296),480);

-- Fim do script

COMMIT;
