begin;
select fc_startsession();
insert into db_itensmenu values (3000095,'Saldo da Licitação','Saldo da Licitação','lic2_saldolicitacao001.php',1,1,'Saldo da Licitação','t');
insert into db_menu values (1797,3000095,100,381);

insert into db_itensmenu values (3000096,'Vencedores da Licitação','Vencedores da Licitação','lic2_venclicitacao001.php',1,1,'Vencedores da Licitação','t');
insert into db_menu values (1797,3000096,101,381);

insert into db_itensmenu values (3000097,'Empenhos por Licitação','Empenhos por Licitação','lic2_emplicitacao001.php',1,1,'Empenhos por Licitação','t');
insert into db_menu values (1797,3000097,102,381);
commit;
