begin;
select fc_startsession();
insert into db_itensmenu values (3000184,'Vínculo Pcasp TCE','Vínculo Pcasp TCE','',1,1,'Vínculo Pcasp TCE      ','t');
insert into db_itensmenu values (3000185,'Inclusão','Inculir Vínculo Pcasp TCE','con1_vinculopcasptce001.php',1,1,'Incluir Vínculo Pcasp TCE','t');
insert into db_itensmenu values (3000186,'Alteração','Alterar Vínculo Pcasp TCE','con1_vinculopcasptce002.php',1,1,'Alterar Vínculo Pcasp TCE','t');
insert into db_itensmenu values (3000187,'Exclusão','Excluir Vínculo Pcasp TCE','con1_vinculopcasptce003.php',1,1,'Excluir Vínculo Pcasp TCE','t');

insert into db_menu values (3962,3000184,34,2000018);
insert into db_menu values (3000184,3000185,1,2000018);
insert into db_menu values (3000184,3000186,2,2000018);
insert into db_menu values (3000184,3000187,3,2000018);
commit;