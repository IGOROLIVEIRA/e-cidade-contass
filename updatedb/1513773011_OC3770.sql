
-- Ocorrência 3770

-- Tabela pctabela
BEGIN;

SELECT fc_startsession();

-- Início do script

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'pctabela', 'pctabela', 'pc94 ', '2017-12-20', 'pctabela', 0, false, false, false, false);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (12, (select max(codarq) from db_sysarquivo));

--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc94_sequencial', 'int4', 'Cod. Tabela', '0', 'Cod. Tabela', 10, false, false, true, 1, 'text', 'Cod. Tabela');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc94_codmater', 'int4', 'Codigo do Material', '0', 'Codigo do Material', 10, true, false, false, 1, 'text', 'Material');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc94_dt_cadastro', 'date', 'Data de Cadastro da Tabela', 'null', 'Data de Cadastro', 10, false, false, false, 1, 'text', 'Data de Cadastro');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc94_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc94_codmater'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc94_dt_cadastro'), 3, 0);


--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'pctabela_pc94_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc94_codmater'), 1, 855, 0);

-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'pctabela_pc94_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

-- Fim do script

COMMIT;


-- Tabela pctabelaitem
BEGIN;

SELECT fc_startsession();

-- Início do script

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'pctabelaitem', 'pctabelaitem', 'pc95 ', '2017-12-20', 'pctabelaitem', 0, false, false, false, false);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (12, (select max(codarq) from db_sysarquivo));

--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc95_sequencial', 'int4', 'Item Tabela', '0', 'Item Tabela', 10, false, false, true, 1, 'text', 'Item Tabela');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc95_codtabela', 'int4', 'Cod. Tabela', '0', 'Cod. Tabela', 10, false, false, false, 1, 'text', 'Cod. Tabela');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc95_codmater', 'int4', 'Codigo do Material', '0', 'Codigo do Material', 10, false, false, false, 1, 'text', 'Material');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc95_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc95_codtabela'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc95_codmater'), 3, 0);

--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'pctabelaitem_pc95_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc95_codtabela'), 1, 1010203, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc95_codmater'), 1, 855, 0);


-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'pctabelaitem_pc95_sequencia_index', (select max(codarq) from db_sysarquivo), '1');

-- Fim do script

COMMIT;


