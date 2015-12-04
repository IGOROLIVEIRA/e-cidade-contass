begin;
select fc_startsession();

/* INSERIR TABELA */
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'vinculopcasptce', 'Vinculo PCASP TCE', 'c209 ', '2015-11-25', 'Vinculo PCASP TCE', 0, false, false, false, false);

/* INSERIR VINCULO TABELA COM SCHEMA */
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));

/* INSERIR CAMPOS */
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c209_pcaspestrut', 'varchar(9)', 'Estrutural Pcasp', '', 'Estrutural Pcasp', 9, false, true, false, 1, 'text', 'Estrutural Pcasp');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c209_tceestrut', 'varchar(9)', 'Estrutural TCE', '', 'Estrutural TCE', 9, false, true, false, 1, 'text', 'Estrutural TCE');

/* INSERIR VINCULO TABELA COM CAMPOS */
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), 
(select codcam from db_syscampo where nomecam = 'c209_pcaspestrut'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c209_tceestrut'), 2, 0);

commit;
