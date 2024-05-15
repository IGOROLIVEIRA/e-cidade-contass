
-- Ocorrência 3770
BEGIN;
SELECT fc_startsession();

-- Início do script

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Tabela','Tabela','',1,1,'Tabela','t');
insert into db_menu values (29,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 29),28);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inculir Tabela','com1_pctabela001.php',1,1,'Incluir Tabela','t');
insert into db_menu values ((select max(id_item)-1 from db_itensmenu),(select max(id_item) from db_itensmenu),1,28);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alterar Tabela','com1_pctabela002.php',1,1,'Alterar Tabela','t');
insert into db_menu values ((select max(id_item)-2 from db_itensmenu),(select max(id_item) from db_itensmenu),2,28);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Excluir Tabela','com1_pctabela003.php',1,1,'Excluir Tabela','t');
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item) from db_itensmenu),3,28);


insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Tabela/Taxa','Processo Critério de Adjudicação','',1,1,'Processo Critério de Adjudicação','t');
insert into db_menu values (2567,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 2567),28);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Incluir','Processo Critério de Adjudicação','emp1_empautorizataxatabela001.php',1,1,'Incluir Autorização','t');
insert into db_menu values ((select max(id_item)-1 from db_itensmenu),(select max(id_item) from db_itensmenu),1,28);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alterar','Processo Critério de Adjudicação','emp1_empautorizataxatabela002.php',1,1,'Alterar Autorização','t');
insert into db_menu values ((select max(id_item)-2 from db_itensmenu),(select max(id_item) from db_itensmenu),2,28);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Excluir','Processo Critério de Adjudicação','emp1_empautorizataxatabela003.php',1,1,'Excluir Autorização','t');
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item) from db_itensmenu),3,28);
-- Fim do script

COMMIT;



