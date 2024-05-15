BEGIN;

SELECT fc_startsession();

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'numeracaotipoproc                       ', 'numeracaotipoproc', 'p200 ', '2015-12-02', 'numeracaotipoproc', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p200_tipoproc                           ', 'int4                                    ', 'Tipo Proc', '0', 'Tipo Proc', 10, false, false, false, 1, 'text', 'Tipo Proc');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p200_codigo                             ', 'int4                                    ', 'Código', '0', 'Código', 8, false, false, false, 1, 'text', 'Código');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p200_ano                                ', 'int4                                    ', 'Ano', '0', 'Ano', 4, false, false, false, 1, 'text', 'Ano');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p200_numeracao                          ', 'int4                                    ', 'Numeração', '0', 'Numeração', 10, false, false, false, 1, 'text', 'Numeração');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c209_pcaspestrut'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c209_pcaspestrut'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c209_pcaspestrut'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c209_pcaspestrut'), 4, 0);

COMMIT;
