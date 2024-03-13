
-- Ocorrência 4474

-- Tabela protocolos
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'protocolos', 'Protocolos de Pirapora', 'p101 ', '2017-10-03', 'protocolos', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));


--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_sequencial', 'int4', 'Numero do Protocolo', '0', 'Protocolo', 11, false, false, true, 1, 'text', 'Protocolo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_id_usuario', 'int4', 'Codigo do usuario', '0', 'Usuario', 11, false, false, false, 1, 'text', 'Usuario');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_coddeptoorigem', 'int4', 'Departamento de Origem', '0', 'Depart. Origem', 11, false, false, false, 1, 'text', 'Depart. Origem');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_coddeptodestino', 'int4', 'Departamento de Destino', '0', 'Depart. Destino', 11, false, false, false, 1, 'text', 'Depart. Destino');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_observacao', 'varchar(200)', 'Observacao do protocolo', '', 'Observacao', 200, false, true, false, 0, 'text', 'Observacao');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_dt_protocolo', 'date', 'Data do Protocolo', 'null', 'Data ', 10, false, false, false, 1, 'text', 'Data ');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_hora', 'varchar(5)', 'Hora do protocolo', '', 'Hora', 5, false, true, false, 0, 'text', 'Hora');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p101_dt_anulado', 'date', 'Data da anulação', 'null', 'Data ', 10, false, false, false, 1, 'text', 'Data ');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_id_usuario'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_coddeptoorigem'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_coddeptodestino'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_observacao'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_dt_protocolo'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_hora'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_dt_anulado'), 8, 0);


--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'protocolos_p101_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);


-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_id_usuario'), 1, 109, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_coddeptoorigem'), 1, 154, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p101_coddeptodestino'), 1, 154, 0);


-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p101_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

commit;




-- Tabela protempautoriza
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'protempautoriza', 'Protocolos de Pirapora', 'p102 ', '2017-10-03', 'protempautoriza', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));



--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p102_sequencial', 'int4', 'Código da autorizacao do empenho', '0', 'Prot. Aut. Empenho', 11, false, false, true, 1, 'text', 'Prot. Aut. Empenho');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p102_autorizacao', 'int4', 'Autorizacao', '0', 'Autorizacao', 11, false, false, false, 1, 'text', 'Autorizacao');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p102_protocolo', 'int4', 'Codigo do protocolo', '0', 'Protocolo', 11, false, false, false, 1, 'text', 'Protocolo');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p102_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p102_autorizacao'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p102_protocolo'), 3, 0);


--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'protempautoriza_p102_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);


-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p102_autorizacao'), 1, 1010192, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p102_protocolo'), 1, 810, 0);


-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p102_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

commit;



-- Tabela protempenhos
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'protempenhos', 'Protocolos de Pirapora', 'p103 ', '2017-10-03', 'protempenhos', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));


--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p103_sequencial', 'int4', 'Empenhos do Protocolo', '0', 'p103_sequencial', 11, false, false, true, 1, 'text', 'p103_sequencial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p103_numemp', 'int4', 'Empenho do protocolo', '0', 'Empenho', 11, false, false, false, 1, 'text', 'Empenho');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p103_protocolo', 'int4', 'Empenho do protocolo', '0', 'Emp. Protocolo', 11, false, false, false, 1, 'text', 'Emp. Protocolo');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p103_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p103_numemp'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p103_protocolo'), 3, 0);


--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'protempenhos_p103_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);


-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p103_numemp'), 1, 1010192, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p103_protocolo'), 1, 889, 0);


-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p103_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

commit;



-- Tabela protmatordem
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'protmatordem', 'Protocolos de Pirapora', 'p104 ', '2017-10-03', 'protmatordem', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));


--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p104_sequencial', 'int4', 'Ordem de compra do protocolo de Pirapora', '0', 'Prot. Ord. Compra', 11, false, false, true, 1, 'text', 'Prot. Ord. Compra');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p104_codordem', 'int8', 'Código da ordem de compra', '0', 'Codigo', 10, false, false, false, 1, 'text', 'C�digo da ordem de compra');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p104_protocolo', 'int4', 'Autorizacao de Ordem de Compra do Protocolo de Pirapora.', '0', 'Protocolo', 11, false, false, false, 1, 'text', 'Protocolo');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p104_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p104_codordem'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p104_protocolo'), 3, 0);


--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'protmatordem_p104_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);


-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p104_codordem'), 1, 1007, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p104_protocolo'), 1, 1010192, 0);


-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p104_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

commit;



-- Tabela protpagordem
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'protpagordem', 'Ordem de pagamento do protocolo de Pirapora', 'p105 ', '2017-10-03', 'protpagordem', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));


--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p105_sequencial', 'int4', 'Prot. Ord. Pagamento', '0', 'Prot. Ord. Pagamento', 11, false, false, true, 1, 'text', 'Prot. Ord. Pagamento');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p105_codord', 'int4', 'Código da ordem de pagamento.', '0', 'Ordem ', 6, false, false, false, 1, 'text', 'Ordem ');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p105_protocolo', 'int4', 'Protocolos de Pirapora', '0', 'Protocolos', 11, false, false, false, 1, 'text', 'Protocolos');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p105_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p105_codord'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p105_protocolo'), 3, 0);


--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'protpagordem_p105_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);


-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p105_codord'), 1, 911, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p105_protocolo'), 2, 911, 0);


-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p105_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

commit;


