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
                                                                                 (4, 'LABORATÓRIO'), 
                                                                                 (5, 'LABORATÓRIO - EXAME'), 
                                                                                 (6, 'LABORATÓRIO - GRUPO DE EXAMES'), 
                                                                                 (7, 'EXAME'), 
                                                                                 (8, 'GRUPO DE EXAMES'), 
                                                                                 (9, 'DEPARTAMENTO SOLICITANTE - LABORATÓRIO');
/*  </SQL Tarefa: 50985>  */

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,8344,'Alterada layout da rotina permitindo a autorização da requisição de exames.','2011-04-05','Realizado testes e a rotina esta funcionando conforme descrito na EF.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5204,50999);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,8354,'Alterado nome do menu de incluir para lançar ao clicar no botão “Lançar” o cursor deverá ser reposicionado no campo “Exame” e a “Data Exame” deverá permanecer com a última informada. No campo \"Profissional\" foi incluido cadasdatro para os profissionais que não sejam da rede, e ao procurar tanto pela tela de pesquisa  como pelo googlesugest deverá vir os profissionais da rede e fora. No campo Exame na tela de pesquisa deverá aparecer somente os exames que estejam relacionados com um Laboratório.','2011-04-05','Realizado testes e a rotina esta funcionando conforme descrito na EF.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5202,50999);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,3407,'A partir desta versão, o relatório contará com:
   - filtro por Instituição;
   - possibilidade de edição de dados do relatório também por Instituição. Para fazer isto, basta editar o relatório acessando a Instituição desejada.','2011-04-05','Mensagem para usuários.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5197,50449);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,4831,'Apartir desta versão o sistema bloqueia lançamentos contábeis como liquidação, pagamento, lançamentos manuais, após efetuar o encerramento do exercício.  ','2011-03-30','Apartir desta versão o sistema não permite efetuar lançamentos contábeis como liquidação, pagamento, lançamentos manuais, após efetuar o encerramento do exercício.  ');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5194,43592);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,3396,'Esta versão contempla melhoria no relatório, que consiste em:

 1. implementar no formulário de emissão do relatório um campo contendo duas opções de impressão chamado “Previsão/Fixação:” onde as opções são:
      a)Inicial (padrão);
      b)Atualizada;
 2. se o usuário escolher a primeira opção, o relatório deverá ser emitido da forma atual;

 3. se a opção escolhida for a segunda, o relatório retornará os seguintes valores:
      a) na coluna RECEITA ORÇAMENTÁRIA / PREVISÃO, será impresso o valor da Previsão Inicial somado ao valor da Previsão Adicional da Receita. Estes valores tem origem no Balancete da Receita (menu: CONTABILIDADE > RELATÓRIOS > BALANCETES > BALANCETE DA RECEITA);
      b) na coluna DESPESA ORÇAMENTÁRIA / FIXAÇÃO, será impresso o valor da Previsão Atualizada da Despesa. Este valor corresponde a Previsão Inicial, mais as Suplementações menos as Reduções Orçamentárias. Estes valores tem origem no Balancete da Despesa (menu: CONTABILIDADE > RELATÓRIOS > BALANCETES > BALANCETE DA DESPESA).

As demais características do relatório permanecem inalteradas.','2011-04-05','Mensagem para usuários.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5200,50532);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,3411,'Esta versão implementa melhoria na configuração customizada do relatório, permitindo que o usuário exiba de forma mais analítica algumas linhas do Demonstrativo.

Esta possibilidade poderá ser identificada acessando a aba \"Parâmetros\", na coluna \"Customizar Configuração\". Ao entrar na tela, o sistema exibirá uma opção adicional chamada \"Detalhamento Analítico\". Se a caixa de seleção for marcada, o relatório:
   - tornará sintética a linha original em edição;
   - exibirá no relatório como linha analítica a descrição no Plano de Contas e o saldo final no Balancete de Verificação da conta correspondente ao código estrutural digitado na configuração.','2011-04-05','Mensagem para usuários.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5198,50450);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,8735,'Incluido rotina para Controle Físico/Financeiro poderá ser feito por departamento, exame, laboratório, grupo e ao selecionar a opção departameto solicitante poderá ser feita validação do Saldo, aonde poderá  liberar  o saldo se estiver negativo ou bloquear saldo.','2011-04-05','Realizado testes e a rotina esta funcionando conforme descrito na EF.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5201,50985);

insert into db_versaousu (db32_codusu,db32_codver,db32_id_item,db32_obs,db32_data,db32_obsdb) values (nextval ('db_versaousu_db32_codusu_seq'),218,7761,'O sistema foi ajustado para gerar de forma consolidada os registros da Folha de Pagamento e Contabilidade.','2011-03-31','O sistema foi ajustado para gerar de forma consolidada os registros da Folha de Pagamento e Contabilidade.');
insert into db_versaousutarefa (db28_sequencial,db28_codusu,db28_tarefa) values (nextval ('db_versaousutarefa_db28_sequencial_seq'),5193,37052);

insert into db_versaocpd (db33_codcpd,db33_codver,db33_obs,db33_obscpd,db33_data) values (nextval ('db_versaocpd_db33_codcpd_seq'),218,'Tarefa: 50985','Implementar o controle físico/financeiro por departamento verso laboratório.','2011-04-01');
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

insert into db_versaocpd (db33_codcpd,db33_codver,db33_obs,db33_obscpd,db33_data) values (nextval ('db_versaocpd_db33_codcpd_seq'),218,'Tarefa: 50985','Implementar o controle físico/financeiro por departamento verso laboratório.','2011-04-04');
insert into db_versaocpdarq (db34_codarq,db34_codcpd,db34_descr,db34_obs,db34_arq) values (nextval ('db_versaocpdarq_db34_codarq_seq '),3463,'SQL','Rodar SQL.','INSERT INTO lab_tipocontrolefisicofinanceiro(la57_i_codigo, la57_c_descr) VALUES (1, \'DEPARTAMENTO SOLICITANTE\'), 
                                                                                 (2, \'DEPARTAMENTO SOLICITANTE - EXAME\'), 
                                                                                 (3, \'DEPARTAMENTO - GRUPO DE EXAMES\'), 
                                                                                 (4, \'LABORATÓRIO\'), 
                                                                                 (5, \'LABORATÓRIO - EXAME\'), 
                                                                                 (6, \'LABORATÓRIO - GRUPO DE EXAMES\'), 
                                                                                 (7, \'EXAME\'), 
                                                                                 (8, \'GRUPO DE EXAMES\'), 
                                                                                 (9, \'DEPARTAMENTO SOLICITANTE - LABORATÓRIO\');');



SELECT fc_schemas_dbportal();
SELECT fc_grant('dbseller', 'select', '%', '%');
COMMIT;
