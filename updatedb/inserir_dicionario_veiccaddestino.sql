begin;
select fc_startsession();

/* INSERIR TABELA */
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'veiccaddestino', 'Cadastro Destino', 've75 ', '2016-08-18', 'Cadastro Destino', 0, false, false, false, false);

/* INSERIR VINCULO TABELA COM SCHEMA */
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (45, (select max(codarq) from db_sysarquivo));

/* INSERIR CAMPOS */
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've75_sequencial', 'int(11)', 'Sequencial', '', 'Sequencial', 9, false, true, false, 1, 'text', 'Sequencial');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've75_destino', 'varchar(145)', 'Destino', '', 'Destino', 30, false, true, false, 0, 'text', 'Destino');

/* INSERIR VINCULO TABELA COM CAMPOS */
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), 
(select codcam from db_syscampo where nomecam = 've75_sequencial'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo),
(select codcam from db_syscampo where nomecam = 've75_destino'), 2, 0);

commit;
