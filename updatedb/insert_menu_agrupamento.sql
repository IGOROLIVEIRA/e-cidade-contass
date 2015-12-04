begin;

select fc_startsession();
insert into db_itensmenu values (3000099,'Atendimento de Requisições por Departamento Agrupado','Atendimento de Requisições por Departamento Agrupado','mat2_relsaidaagrup001.php',1,1,'Atendimento de Requisições por Departamento Agrupado','t');
insert into db_menu values (8787,3000099,101,480);	

commit;

