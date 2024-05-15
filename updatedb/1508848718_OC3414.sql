
-- Ocorrência 3414


-- Tabela empenhosexcluidos
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'empenhosexcluidos', 'Empenhos anulados por erro na emissao', 'e290 ', '2017-07-26', 'empenhosexcluidos', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (38, (select max(codarq) from db_sysarquivo));

--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_sequencial', 'int4', 'e290_sequencial', '0', 'e290_sequencial', 11, false, false, true, 1, 'text', 'e290_sequencial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_e60_numemp', 'int4', 'Seq. Empenho', '0', 'Seq. Empenho', 10, false, false, false, 1, 'text', 'Seq. Empenho');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_e60_codemp', 'varchar(15)', 'Número do Empenho - não é o sequencial', '', 'Código do Empenho', 15, false, true, false, 0, 'text', 'Código do Empenho');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_e60_anousu', 'int4', 'Exercício da dotação', '0', 'Exercício', 4, false, false, false, 1, 'text', 'Exercício');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_e60_emiss', 'date', 'Data da emissão do empenho', 'null', 'Data Emissão', 10, false, false, false, 1, 'text', 'Data Emissão');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_e60_vlremp', 'float8', 'Valor empenhado', '0', 'Empenho', 16, false, false, false, 4, 'text', 'Valor do empenho');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_z01_numcgm', 'int4', 'Numero de Identificação do Contribuinte ou Empresa no Cadastro geral do Município', '0', 'Numcgm', 10, false, false, false, 1, 'text', 'Numcgm');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_z01_nome', 'varchar(40)', 'Nome da pessoa ou Razão Social se for Empresa', '', 'Nome/Razão social', 40, false, true, false, 0, 'text', 'Nome');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_id_usuario', 'int4', 'Código do usuário que realizou a exclusão do empenho.', '0', 'Código do usuario', 10, false, false, false, 1, 'text', 'Código do usuario');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_nomeusuario', 'varchar(40)', 'Nome do usuário que realizou a exclusão do empenho', '', 'Nome do usuário', 40, false, false, false, 2, 'text', 'Nome do usuário');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e290_dtexclusao', 'date', 'Data Exclusão', 'null', 'Data Exclusão', 10, false, false, false, 1, 'text', 'Data Exclusão');

--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'empenhosexcluidos_e290_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_e60_numemp'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_e60_codemp'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_e60_anousu'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_e60_emiss'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_e60_vlremp'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_z01_numcgm'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_z01_nome'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_id_usuario'), 9, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_nomeusuario'), 10, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_dtexclusao'), 11, 0);

-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_id_usuario'), 1, 109, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'e290_z01_numcgm'), 1, 42, 0);


-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'e290_sequencial', (select max(codarq) from db_sysarquivo), '1');

commit;
