-- Tabela transferenciaveiculos
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'transferenciaveiculos', 'Transferencia Veiculos', 've80 ', '2017-08-04', 'Transferencia Veiculos', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (45, (select max(codarq) from db_sysarquivo));


--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've80_sequencial', 'int4', 'Codigo sequencial da tabela.', '0', 'Codigo da Transferencia', 11, false, false, true, 1, 'text', 'Codigo da Transferencia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've80_motivo', 'varchar(150)', 'Motivo da transferencia', '', 'Motivo', 150, false, true, false, 0, 'text', 'Motivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've80_dt_transferencia', 'date', 'Data da transferencia do veiculo.', 'null', 'Data Transferencia', 10, false, false, false, 1, 'text', 'Data Transferencia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've80_id_usuario', 'int4', 'Codigo do usuario', '0', 've80_id_usuario', 11, false, false, false, 1, 'text', 've80_id_usuario');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've80_coddeptoatual', 'int4', 'Codigo do departamento atual.', '0', 'Codigo do departamento atual', 11, false, false, false, 1, 'text', 'Codigo do departamento atual');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've80_coddeptodestino', 'int4', 'Codigo do departamento destino', '0', 'Codigo do departamento destino', 11, false, false, false, 1, 'text', 'Codigo do departamento destino');


-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_motivo'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_dt_transferencia'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_id_usuario'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_coddeptoatual'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_coddeptodestino'), 6, 0);


--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'transferenciaveiculos_ve80_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);


-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_id_usuario'), 1, 109, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_coddeptoatual'), 1, 154, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've80_coddeptodestino'), 1, 154, 0);



-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 've80_sequencial', (select max(codarq) from db_sysarquivo), '1');

commit;


-- Tabela veiculostransferencia
begin;
select fc_startsession();

--Vínculo das tabelas
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'veiculostransferencia', 'Veiculos Tranferencia', 've81 ', '2017-08-17', 'Veiculos Tranferencia', 0, false, false, false, false);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (45, (select max(codarq) from db_sysarquivo));

--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_sequencial', 'int4', 'Sequencial do veiculo na transferencia', '0', 'Seq. transf. veiculos', 11, false, false, true, 1, 'text', 'Seq. transf. veiculos');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_codigo', 'int4', 'Codigo do veiculo', '0', 'Codigo do Veiculo', 11, false, false, false, 1, 'text', 'Codigo do Veiculo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_codigoant', 'int4', 'Código antigo', '0', 'Codigo Anterior', 11, true, false, false, 1, 'text', 'Codigo Anterior');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_placa', 'varchar(7)', 'Placa do ve�culo', '', 'Placa', 7, false, true, false, 0, 'text', 'Placa');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_codunidadesubatual', 'varchar(8)', 'Código da unidade anterior', '', 'Codigo unidade ant. atual', 8, false, true, false, 0, 'text', 'Codigo unidade ant. atual');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_codunidadesubant', 'varchar(8)', 'Código anterior atual.', '', 'Codigo Anterior', 8, false, true, false, 0, 'text', 'Codigo Anterior');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 've81_transferencia', 'int4', 'Código da transferencia.', '0', 'Código da transferencia', 11, false, false, false, 1, 'text', 'Código da transferencia');

-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_codigo'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_codigoant'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_placa'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_codunidadesubatual'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_codunidadesubant'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_transferencia'), 7, 0);

--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'veiculostransferencia_ve81_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

--Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_codunidadesubatual'), 1, 1010230, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 've81_codunidadesubant'), 1, 1590, 0);

--Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 've81_sequencial', (select max(codarq) from db_sysarquivo), '1');

commit;
