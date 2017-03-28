begin;

insert into licsituacao (l08_sequencial,l08_descr,l08_altera)
	values (12,'Anulada','f');

insert into db_itensmenu values (4000327,'Anula Licitação','Anula Licitação','',1,1,'Anula Licitação','t');
insert into db_menu values (4680,4000327,10,381);

insert into db_itensmenu values (4000328,'Incluir','Incluir','lic4_situacaolicitacao001.php?iCodigoTipoSituacao=12&iOpcao=1',1,1,'Anula Licitação','t');
insert into db_itensmenu values (4000329,'Alterar','Alterar','lic4_situacaolicitacao001.php?iCodigoTipoSituacao=12&iOpcao=2',1,1,'Anula Licitação','t');
insert into db_itensmenu values (4000330,'Cancelar','Alterar','lic4_situacaolicitacao001.php?iCodigoTipoSituacao=12&iOpcao=3',1,1,'Anula Licitação','t');

insert into db_menu values (4000327,4000328,1,381);
insert into db_menu values (4000327,4000329,1,381);
insert into db_menu values (4000327,4000330,1,381);

commit;