select fc_startsession();
begin;
alter table acordo add column ac16_formafornecimento varchar(50);
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_formafornecimento', 'varchar(50)', 'Descrição da forma de fornecimento ou regime de execução', '0', 'Forma de Fornecimento', 50, false, false, false, 0, 'text', 'Forma de Fornecimento');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2828, (select codcam from db_syscampo where nomecam = 'ac16_formafornecimento'), 1, 0);

alter table acordo add column ac16_formapagamento varchar(100);
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_formapagamento', 'varchar(100)', 'Descrever o preço e as condições de pagamento, os critérios, data-base e periodicidade do reajustamento de preços, os critérios de atualização monetária entre a data do adimplemento das obrigações e a do efetivo pagamento', '0', 'Forma de Pagamento', 100, false, false, false, 0, 'text', 'Forma de Pagamento');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2828, (select codcam from db_syscampo where nomecam = 'ac16_formapagamento'), 1, 0);

alter table acordo add column ac16_cpfsignatariocontratante varchar(11);
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_cpfsignatariocontratante', 'varchar(11)', 'Número do CPF do signatário da contratante.', '0', 'CPF do signatário', 11, false, false, false, 1, 'text', 'CPF do signatário');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2828, (select codcam from db_syscampo where nomecam = 'ac16_cpfsignatariocontratante'), 1, 0);

alter table acordo add column ac16_datapublicacao date;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_datapublicacao', 'date', 'Data da publicação do contrato ou termo de pareceria.', '0', 'Data da publicação', 10, false, false, false, 1, 'text', 'Data da publicação');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2828, (select codcam from db_syscampo where nomecam = 'ac16_datapublicacao'), 1, 0);

alter table acordo add column ac16_datainclusao date;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_datainclusao', 'date', 'Data da inclusao do contrato ou termo de pareceria.', '0', 'Data da Inclusão', 10, false, false, false, 1, 'text', 'Data da Inclusão');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2828, (select codcam from db_syscampo where nomecam = 'ac16_datainclusao'), 1, 0);

alter table acordo add column ac16_veiculodivulgacao varchar(50);
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_veiculodivulgacao', 'varchar(50)', 'Veículo de divulgação onde o contrato ou termo de parceria foi publicado.', '0', 'Veículo de Divulgação', 50, false, false, false, 0, 'text', 'Veículo de Divulgação');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2828, (select codcam from db_syscampo where nomecam = 'ac16_veiculodivulgacao'), 1, 0);

alter table acordoposicaoaditamento add column ac35_dataassinaturatermoaditivo date;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac35_dataassinaturatermoaditivo', 'date', 'Data da Assinatura do Termo Aditivo.', '0', 'Data da Assinatura', 10, false, false, false, 1, 'text', 'Data da Assinatura');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (3041, (select codcam from db_syscampo where nomecam = 'ac35_dataassinaturatermoaditivo'), 1, 0);

alter table acordoposicaoaditamento add column ac35_descricaoalteracao varchar(250);
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac35_descricaoalteracao', 'varchar(250)', 'Descrição da alteração do termo aditivo', '0', 'Descrição da Alteração', 250, false, false, false, 1, 'text', 'Descrição da Alteração');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (3041, (select codcam from db_syscampo where nomecam = 'ac35_descricaoalteracao'), 1, 0);

alter table acordoposicaoaditamento add column ac35_datapublicacao date;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac35_datapublicacao', 'date', 'Data da Publicação do Termo Aditivo.', '0', 'Data da Publicação', 10, false, false, false, 1, 'text', 'Data da Publicação');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (3041, (select codcam from db_syscampo where nomecam = 'ac35_datapublicacao'), 1, 0);

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ((select max(id_item)+1 from db_itensmenu),'Outros' ,'Outros' ,'ac04_aditaoutros.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 8568 ,(select max(id_item) from db_itensmenu) ,5 ,8251 );

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ((select max(id_item)+1 from db_itensmenu),'Execução' ,'Execução' ,'ac04_aditaexecucao.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 8568 ,(select max(id_item) from db_itensmenu) ,6 ,8251 );

insert into acordoposicaotipo values(7,'Outros');
insert into acordoposicaotipo values(13,'Vigência/Execução');
insert into acordoposicaotipo values(8,'Alteração de Prazo de Execução');
insert into acordoposicaotipo values(9,'Acréscimo de Item(ns)');
insert into acordoposicaotipo values(10,'Decréscimo de Item(ns)');
insert into acordoposicaotipo values(11,'Acréscimo e Decréscimo de Item(ns)');
insert into acordoposicaotipo values(12,'Alteração de Projeto/Especificação');
insert into acordoposicaotipo values(14,'Acréscimo/Decréscimo de item(ns) conjugado');

alter table acordoposicaoaditamento add column ac35_veiculodivulgacao varchar(50);
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac35_veiculodivulgacao', 'varchar(50)', 'Veículo de divulgação onde o contrato ou termo de parceria foi publicado.', '0', 'Veículo de Divulgação', 50, false, false, false, 0, 'text', 'Veículo de Divulgação');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (3041, (select codcam from db_syscampo where nomecam = 'ac35_veiculodivulgacao'), 1, 0);

update acordocategoria set ac50_descricao = 'Contrato' where ac50_sequencial = 1;
update acordocategoria set ac50_descricao = 'Termos de parceria/OSCIP' where ac50_sequencial = 2;
update acordocategoria set ac50_descricao = 'Contratos de gestão' where ac50_sequencial = 3;
update acordocategoria set ac50_descricao = 'Outros termos de parceria' where ac50_sequencial = 4;
update acordo set ac16_acordocategoria = 1;
delete from acordocategoria where ac50_sequencial in (5,6);

update db_itensmenu set libcliente = false where id_item in (9675,8317,8281);

insert into acordogarantia values(1,'CAUÇÃO EM DINHEIRO','CAUÇÃO EM DINHEIRO','CAUÇÃO EM DINHEIRO','CAUÇÃO EM DINHEIRO','2099-12-01');
insert into acordogarantia values(2,'TÍTULO DA DÍVIDA PÚBLICA','TÍTULO DA DÍVIDA PÚBLICA','TÍTULO DA DÍVIDA PÚBLICA','TÍTULO DA DÍVIDA PÚBLICA','2099-12-01');
insert into acordogarantia values(3,'SEGURO GARANTIA','SEGURO GARANTIA','SEGURO GARANTIA','2099-12-01');
insert into acordogarantia values(4,'FIANÇA BANCÁRIA','FIANÇA BANCÁRIA','FIANÇA BANCÁRIA','2099-12-01');

insert into acordogarantiaacordotipo values(2,3,1);
insert into acordogarantiaacordotipo values(3,3,2);
insert into acordogarantiaacordotipo values(4,3,3);
insert into acordogarantiaacordotipo values(5,3,4);

insert into acordopenalidade values(1,'MULTA RESCISÓRIA','Descrição da previsão de multa rescisória, conforme previsão do art. 55, VII, da Lei Federal n. 8.666/93','Descrição da previsão de multa rescisória, conforme previsão do art. 55, VII, da Lei Federal n. 8.666/93','2099-12-31');
insert into acordopenalidade values(2,'MULTA INADIMPLEMENTO','Descrição da previsão de multa por inadimplemento, conforme previsão do art. 55, VII, da Lei Federal n. 8.666/93','Descrição da previsão de multa por inadimplemento, conforme previsão do art. 55, VII, da Lei Federal n. 8.666/93','2099-12-31');

insert into acordopenalidadeacordotipo values (3,3,1);
insert into acordopenalidadeacordotipo values (4,3,2);

alter table acordoitemperiodo add column ac41_acordoposicao int;
alter table acordoitemperiodo add CONSTRAINT acordoitemperiodo_acordoposicao_fk FOREIGN KEY (ac41_acordoposicao) REFERENCES acordoposicao (ac26_sequencial);

update db_itensmenu set descricao = 'Vigencia/Execucao', help = 'Aditamentos de Prazo de Vigência e/ou Execução' where id_item = 8588;
update db_itensmenu set descricao = 'Reajuste', help = 'Aditamentos do tipo Reajuste' where id_item = 8589;

alter table acordoitem add column ac20_acordoposicaotipo int;
alter table acordoitem add CONSTRAINT acordoitem_acordoposicaotipo_fk FOREIGN KEY (ac20_acordoposicaotipo) REFERENCES acordoposicaotipo (ac27_sequencial);

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ((select max(id_item)+1 from db_itensmenu),'Excluir' ,'Excluir' ,'ac04_excluiaditamento.php' ,'1' ,'1' ,'' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 8568 ,(select max(id_item) from db_itensmenu), 7, 8251 );

--Tabela acordoleis
-- Criando  sequences
CREATE SEQUENCE acordoleis_ac54_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA

-- Módulo: acordos
CREATE TABLE acordos.acordoleis(
ac54_sequencial		int8 NOT NULL default 0,
ac54_descricao		varchar(100) NOT NULL,
CONSTRAINT acordoleis_sequ_pk PRIMARY KEY (ac54_sequencial));

insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 17, I E II DA LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, I DA LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, II, DA LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, II, E ART. 25, I, DA LEI 8666/9');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, VIII, C/C ART. 116, AMBOS DA LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, VIII, DA LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, X, DA LEI 8.666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, XI, DA LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 24, XX, DA LEI N 8.666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 25, "CAPUT", LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 25, I, DA LEI 8666/93');
insert into acordoleis values (nextval('acordoleis_ac54_sequencial_seq'),'ART. 25 I DA LEI 8666/93 C/C ARTIGOS 2(1B)8(CAPUT,II) E 15(1) DA LEI N 6538 DE 22 1978');

-- Discionario

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'acordoleis', 'Leis que regem acordos', 'ac54 ', '2016-03-21', 'acordoleis', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (69, (select max(codarq) from db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac54_sequencial', 'int8', 'Código sequencial da tabela', '0', 'Código Sequencial', 10, false, false, false, 1, 'text', 'Código Sequencial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac54_descricao', 'varchar(100)', 'Descrição da Lei', '', 'Descrição', 100, false, true, false, 0, 'text', 'Descrição');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'ac54_sequencial'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'ac54_descricao'), 2, 0);

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Leis','Leis','',1,1,'Leis','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inculir Leis','aco1_acordoleis001.php',1,1,'Incluir Leis','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alterar Leis','aco1_acordoleis002.php',1,1,'Alterar Leis','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Excluir Leis','aco1_acordoleis003.php',1,1,'Excluir Leis','t');

insert into db_menu values (29,(select max(id_item)-3 from db_itensmenu),7,8251);
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item)-2 from db_itensmenu),1,8251);
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item)-1 from db_itensmenu),2,8251);
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item) from db_itensmenu),3,8251);

alter table acordo alter column ac16_lei type integer using cast(ac16_lei as integer);
alter table acordo add constraint acordo_acordoleis_fk foreign key (ac16_lei) references acordoleis (ac54_sequencial);

update db_syscampo set nulo = true where codcam = 16151;

update db_itensmenu set descricao = 'Finalizar', help = 'Finalizar contrato. Nao e o mesmo que encerrar o contrato.', desctec = 'Finalizar' where id_item = 8409;

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Apostilamento (Novo)','Apostilamento (Novo)','',1,1,'Apostilamento (Novo)','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inculir Apostilamento (Novo)','sic1_apostilamentonovo001.php',1,1,'Incluir Apostilamento (Novo)','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alterar Apostilamento (Novo)','sic1_apostilamentonovo002.php',1,1,'Alterar Apostilamento (Novo)','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Excluir Apostilamento (Novo)','sic1_apostilamentonovo003.php',1,1,'Excluir Apostilamento (Novo)','t');

insert into db_menu values (29,(select max(id_item)-3 from db_itensmenu),8,8251);
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item)-2 from db_itensmenu),1,8251);
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item)-1 from db_itensmenu),2,8251);
insert into db_menu values ((select max(id_item)-3 from db_itensmenu),(select max(id_item) from db_itensmenu),3,8251);

alter table apostilamento add column si03_acordo integer;
alter table apostilamento add constraint apostilamento_acordo_fk foreign key (si03_acordo) references acordo (ac16_sequencial);

alter table acordo add column ac16_tipoorigem integer;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_tipoorigem', 'int8', 'Tipo da Origem Conforme SICOM.', '0', 'Tipo Origem', 8, false, false, false, 1, 'text', 'Tipo Origem');
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2828, (select codcam from db_syscampo where nomecam = 'ac16_tipoorigem'), 1, 0);
commit;