SELECT fc_startsession();

BEGIN;

/*  <SQL Tarefa: 50985>  */
DROP TRIGGER IF EXISTS tg_deleta_tipo_controle_fisico_financeiro_lab on lab_controlefisicofinanceiro;
DROP FUNCTION IF EXISTS fc_deleta_tipo_controle_fisico_financeiro_lab();
DROP TRIGGER IF EXISTS tg_impede_delete_controle_com_requisicao ON lab_controlefisicofinanceiro;
ALTER TABLE lab_controlefisicofinanceiro ADD COLUMN la56_i_tipocontrole int4 not null;
ALTER TABLE lab_controlefisicofinanceiro ADD COLUMN la56_i_liberarequisicaosemsaldo int4 not null;
ALTER TABLE lab_controlefisicofinanceiro ADD CONSTRAINT lab_controlefisicofinanceiro_tipocontrole_fk FOREIGN KEY(la56_i_tipocontrole) REFERENCES lab_tipocontrolefisicofinanceiro;
ALTER TABLE lab_tipocontrolefisicofinanceiro ALTER COLUMN la57_i_tipocontrole TYPE varchar(40);
ALTER TABLE lab_tipocontrolefisicofinanceiro RENAME la57_i_tipocontrole TO la57_c_descr;
ALTER TABLE lab_exameproced ADD COLUMN la53_n_acrescimo numeric(10, 2) DEFAULT 0;
DROP TRIGGER IF EXISTS tg_deleta_tipo_controle_fisico_financeiro_lab ON lab_controlefisicofinanceiro;
/*  </SQL Tarefa: 50985>  */


/*  <SQL Tarefa: 50985>  */
INSERT INTO lab_tipocontrolefisicofinanceiro(la57_i_codigo, la57_c_descr) VALUES (1, 'DEPARTAMENTO SOLICITANTE'), 
                                                                                 (2, 'DEPARTAMENTO SOLICITANTE - EXAME'), 
                                                                                 (3, 'DEPARTAMENTO - GRUPO DE EXAMES'), 
                                                                                 (4, 'LABORAT�RIO'), 
                                                                                 (5, 'LABORAT�RIO - EXAME'), 
                                                                                 (6, 'LABORAT�RIO - GRUPO DE EXAMES'), 
                                                                                 (7, 'EXAME'), 
                                                                                 (8, 'GRUPO DE EXAMES'), 
                                                                                 (9, 'DEPARTAMENTO SOLICITANTE - LABORAT�RIO');
/*  </SQL Tarefa: 50985>  */

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,8344,'Alterada layout da rotina permitindo a autoriza��o da requisi��o de exames.','2011-04-05','Realizado testes e a rotina esta funcionando conforme descrito na EF.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5204,50999);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,8354,'Alterado nome do menu de incluir para lan�ar ao clicar no bot�o �Lan�ar� o cursor dever� ser reposicionado no campo �Exame� e a �Data Exame� dever� permanecer com a �ltima informada. No campo \"Profissional\" foi incluido cadasdatro para os profissionais que n�o sejam da rede, e ao procurar tanto pela tela de pesquisa  como pelo googlesugest dever� vir os profissionais da rede e fora. No campo Exame na tela de pesquisa dever� aparecer somente os exames que estejam relacionados com um Laborat�rio.','2011-04-05','Realizado testes e a rotina esta funcionando conforme descrito na EF.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5202,50999);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,3407,'A partir desta vers�o, o relat�rio contar� com:
   - filtro por Institui��o;
   - possibilidade de edi��o de dados do relat�rio tamb�m por Institui��o. Para fazer isto, basta editar o relat�rio acessando a Institui��o desejada.','2011-04-05','Mensagem para usu�rios.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5197,50449);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,4831,'Apartir desta vers�o o sistema bloqueia lan�amentos cont�beis como liquida��o, pagamento, lan�amentos manuais, ap�s efetuar o encerramento do exerc�cio.  ','2011-03-30','Apartir desta vers�o o sistema n�o permite efetuar lan�amentos cont�beis como liquida��o, pagamento, lan�amentos manuais, ap�s efetuar o encerramento do exerc�cio.  ');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5194,43592);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,3396,'Esta vers�o contempla melhoria no relat�rio, que consiste em:

 1. implementar no formul�rio de emiss�o do relat�rio um campo contendo duas op��es de impress�o chamado �Previs�o/Fixa��o:� onde as op��es s�o:
      a)Inicial (padr�o);
      b)Atualizada;
 2. se o usu�rio escolher a primeira op��o, o relat�rio dever� ser emitido da forma atual;

 3. se a op��o escolhida for a segunda, o relat�rio retornar� os seguintes valores:
      a) na coluna RECEITA OR�AMENT�RIA / PREVIS�O, ser� impresso o valor da Previs�o Inicial somado ao valor da Previs�o Adicional da Receita. Estes valores tem origem no Balancete da Receita (menu: CONTABILIDADE > RELAT�RIOS > BALANCETES > BALANCETE DA RECEITA);
      b) na coluna DESPESA OR�AMENT�RIA / FIXA��O, ser� impresso o valor da Previs�o Atualizada da Despesa. Este valor corresponde a Previs�o Inicial, mais as Suplementa��es menos as Redu��es Or�ament�rias. Estes valores tem origem no Balancete da Despesa (menu: CONTABILIDADE > RELAT�RIOS > BALANCETES > BALANCETE DA DESPESA).

As demais caracter�sticas do relat�rio permanecem inalteradas.','2011-04-05','Mensagem para usu�rios.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5200,50532);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,3411,'Esta vers�o implementa melhoria na configura��o customizada do relat�rio, permitindo que o usu�rio exiba de forma mais anal�tica algumas linhas do Demonstrativo.

Esta possibilidade poder� ser identificada acessando a aba \"Par�metros\", na coluna \"Customizar Configura��o\". Ao entrar na tela, o sistema exibir� uma op��o adicional chamada \"Detalhamento Anal�tico\". Se a caixa de sele��o for marcada, o relat�rio:
   - tornar� sint�tica a linha original em edi��o;
   - exibir� no relat�rio como linha anal�tica a descri��o no Plano de Contas e o saldo final no Balancete de Verifica��o da conta correspondente ao c�digo estrutural digitado na configura��o.','2011-04-05','Mensagem para usu�rios.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5198,50450);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,8735,'Incluido rotina para Controle F�sico/Financeiro poder� ser feito por departamento, exame, laborat�rio, grupo e ao selecionar a op��o departameto solicitante poder� ser feita valida��o do Saldo, aonde poder�  liberar  o saldo se estiver negativo ou bloquear saldo.','2011-04-05','Realizado testes e a rotina esta funcionando conforme descrito na EF.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5201,50985);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,7761,'O sistema foi ajustado para gerar de forma consolidada os registros da Folha de Pagamento e Contabilidade.','2011-03-31','O sistema foi ajustado para gerar de forma consolidada os registros da Folha de Pagamento e Contabilidade.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5193,37052);

insert into db_versaocpd (db33_codcpd,db33_codver,db33_obs,db33_obscpd,db33_data) values (nextval ('db_versaocpd_db33_codcpd_seq'),218,'Tarefa: 50985','Implementar o controle f�sico/financeiro por departamento verso laborat�rio.','2011-04-01');
insert into db_versaocpdarq (db34_codarq,db34_codcpd,db34_descr,db34_obs,db34_arq) values (nextval ('db_versaocpdarq_db34_codarq_seq '),3461,'SQL','Rodar SQL.','DROP TRIGGER IF EXISTS tg_deleta_tipo_controle_fisico_financeiro_lab on lab_controlefisicofinanceiro;
DROP FUNCTION IF EXISTS fc_deleta_tipo_controle_fisico_financeiro_lab();
DROP TRIGGER IF EXISTS tg_impede_delete_controle_com_requisicao ON lab_controlefisicofinanceiro;
ALTER TABLE lab_controlefisicofinanceiro ADD COLUMN la56_i_tipocontrole int4 not null;
ALTER TABLE lab_controlefisicofinanceiro ADD COLUMN la56_i_liberarequisicaosemsaldo int4 not null;
ALTER TABLE lab_controlefisicofinanceiro ADD CONSTRAINT lab_controlefisicofinanceiro_tipocontrole_fk FOREIGN KEY(la56_i_tipocontrole) REFERENCES lab_tipocontrolefisicofinanceiro;
ALTER TABLE lab_tipocontrolefisicofinanceiro ALTER COLUMN la57_i_tipocontrole TYPE varchar(40);
ALTER TABLE lab_tipocontrolefisicofinanceiro RENAME la57_i_tipocontrole TO la57_c_descr;
ALTER TABLE lab_exameproced ADD COLUMN la53_n_acrescimo numeric(10, 2) DEFAULT 0;
DROP TRIGGER IF EXISTS tg_deleta_tipo_controle_fisico_financeiro_lab ON lab_controlefisicofinanceiro;');

insert into db_versaocpd (db33_codcpd,db33_codver,db33_obs,db33_obscpd,db33_data) values (nextval ('db_versaocpd_db33_codcpd_seq'),218,'Tarefa: 50985','Implementar o controle f�sico/financeiro por departamento verso laborat�rio.','2011-04-04');
insert into db_versaocpdarq (db34_codarq,db34_codcpd,db34_descr,db34_obs,db34_arq) values (nextval ('db_versaocpdarq_db34_codarq_seq '),3463,'SQL','Rodar SQL.','INSERT INTO lab_tipocontrolefisicofinanceiro(la57_i_codigo, la57_c_descr) VALUES (1, \'DEPARTAMENTO SOLICITANTE\'), 
                                                                                 (2, \'DEPARTAMENTO SOLICITANTE - EXAME\'), 
                                                                                 (3, \'DEPARTAMENTO - GRUPO DE EXAMES\'), 
                                                                                 (4, \'LABORAT�RIO\'), 
                                                                                 (5, \'LABORAT�RIO - EXAME\'), 
                                                                                 (6, \'LABORAT�RIO - GRUPO DE EXAMES\'), 
                                                                                 (7, \'EXAME\'), 
                                                                                 (8, \'GRUPO DE EXAMES\'), 
                                                                                 (9, \'DEPARTAMENTO SOLICITANTE - LABORAT�RIO\');');



SELECT fc_schemas_dbportal();
SELECT fc_grant('dbseller', 'select', '%', '%');
COMMIT;
