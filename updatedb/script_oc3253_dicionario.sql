SELECT fc_startsession();

BEGIN;

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'controleext', 'Controle de Recebimentos Extra-Orçamentários', 'k167', '2017-03-16', 'controleext', 0, FALSE, FALSE, FALSE, FALSE);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (5, (SELECT max(codarq) FROM db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k167_sequencial                         ','int4                                    ','Sequencial', 0, 'Sequencial', 11, FALSE, FALSE, TRUE, 1, 'text', 'Sequencial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k167_codcon                             ','int4                                    ','Código da Conta', 0,'Código da Conta', 11, FALSE, FALSE, FALSE, 1, 'text', 'Código da Conta');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k167_anousu                             ','int4                                    ','Exercício', 0,'Exercício', 4, TRUE, FALSE, FALSE, 1, 'text', 'Exercício');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k167_prevanu                            ','float8                                  ','Previsão de recebimento anual', 0,'Previsão de recebimento anual', 30, TRUE, FALSE, FALSE, 4, 'text', 'Previsão de recebimento anual');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k167_dtcad                              ','date                                    ','Data de cadastro', null, 'Data de cadastro', 10, TRUE, FALSE, FALSE, 1, 'text', 'Data de cadastro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k167_anocad                             ','int4                                    ','Ano de cadastro', 0, 'Ano de cadastro', 4, FALSE, FALSE, FALSE, 1, 'text', 'Ano de cadastro');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k167_sequencial'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k167_codcon'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k167_anousu'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k167_prevanu'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k167_dtcad'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k167_anocad'), 6, 0);

COMMIT;

--

SELECT fc_startsession();

BEGIN;

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'controleextvlrtransf', 'Controle EXT - Valores Transferidos', 'k168', '2017-03-24', 'controleextvlrtransf', 0, FALSE, FALSE, FALSE, FALSE);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (5, (SELECT max(codarq) FROM db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k168_codprevisao                        ','int4                                    ','Código da Previsão Anual', 0,'Código da Previsão Anual', 11, FALSE, FALSE, FALSE, 1, 'text', 'Código da Previsão Anual');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k168_mescompet                          ','int4                                    ','Mês de competência', 0,'Mês de competência', 2, TRUE, FALSE, FALSE, 1, 'text', 'Mês de competência');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k168_previni                            ','date                                    ','Data de inicial', null, 'Data de inicial', 10, TRUE, FALSE, FALSE, 1, 'text', 'Data de inicial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k168_prevfim                            ','date                                    ','Data de final', null, 'Data de final', 10, TRUE, FALSE, FALSE, 1, 'text', 'Data de final');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k168_vlrprev                            ','float8                                  ','Valor previsto para período', 0, 'Valor previsto para período', 22, FALSE, FALSE, FALSE, 4, 'text', 'Valor previsto para período');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k168_codprevisao'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k168_mescompet'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k168_previni'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k168_prevfim'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k168_vlrprev'), 5, 0);

COMMIT;
