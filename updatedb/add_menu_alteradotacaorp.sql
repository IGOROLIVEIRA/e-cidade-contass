begin;
select fc_startsession();
insert into db_itensmenu values (3000247,'Alterar Dotação RP','Alterar Dotação RP','',1,1,'Alterar Dotação RP','t');
insert into db_itensmenu values (3000248,'Inclusão','Inculir Alterar Dotação RP','sic1_dotacaorpsicom001.php',1,1,'Incluir Alterar Dotação RP','t');
insert into db_itensmenu values (3000249,'Alteração','Alterar Alterar Dotação RP','sic1_dotacaorpsicom002.php',1,1,'Alterar Alterar Dotação RP','t');
insert into db_itensmenu values (3000250,'Exclusão','Excluir Alterar Dotação RP','sic1_dotacaorpsicom003.php',1,1,'Excluir Alterar Dotação RP','t');

insert into db_menu values (3962,3000247,35,2000018);
insert into db_menu values (3000247,3000248,1,2000018);
insert into db_menu values (3000247,3000249,2,2000018);
insert into db_menu values (3000247,3000250,3,2000018);
commit;

