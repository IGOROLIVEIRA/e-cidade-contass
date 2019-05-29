-- Ocorrência 9391

-- Tabela paritbi
BEGIN;

SELECT fc_startsession();
ALTER TABLE paritbi ADD COLUMN it24_transfautomatica bool NOT NULL DEFAULT FALSE ;

--Inserção dos campos
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it24_transfautomatica', 'bool', 'Transferência Automática', 'FALSE' , 'Transferência Automática', 1, false, false, false, 5, 'text', 'Cod. Tabela');
-- Vínculo tabelas com campos
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2362, (select codcam from db_syscampo where nomecam = 'it24_transfautomatica'), 14, 0);

CREATE TABLE itbi.transfautomaticas (
it35_guia int8 NOT NULL,
it35_transmitente int8 NOT NULL,
it35_comprador int8 NOT NULL,
it35_data date NOT NULL,
it35_usuario int8 NOT NULL,
it35_numpre int8 NOT NULL,
it35_status int8 NOT NULL DEFAULT 0,
it35_observacao varchar(200)
);

-- Inserindo dicionario de dados
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo),'transfautomaticas','Registra as transferencias automaticas','it35 ','2019-05-28','Registra as transferencias automaticas',0,FALSE,FALSE,FALSE,FALSE);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (36, (select max(codarq) from db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_guia', 'int8', 'Guia de ITBI', '0', 'Guia de ITBI', 11, false, false, false, 1, 'text', 'Guia de ITBI');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_transmitente', 'int8', 'CGM do Transmitente', '0', 'CGM do Transmitente', 11, false, false, false, 1, 'text', 'CGM do Transmitente');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_comprador', 'int8', 'CGM do Comprador', '0', 'CGM do Comprador', 11, false, false, false, 1, 'text', 'CGM do Comprador');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_data', 'date', 'Data da Transferencia', '0', 'Data da Transferencia', 11, false, false, false, 1, 'text', 'Data da Transferencia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_usuario', 'int8', 'Codigo do Usuario', '0', 'Codigo do Usuario', 11, false, false, false, 1, 'text', 'Codigo do Usuario');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_numpre', 'int8', 'Codigo do Numpre', '0', 'Codigo do Numpre', 11, false, false, false, 1, 'text', 'Codigo do Numpre');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_status', 'int8', 'Status da Transferencia', '0', 'Status da Transferencia', 11, false, false, false, 1, 'text', 'Status da Transferencia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it35_observacao', 'text', 'Observacao da Transferencia', '0', 'Observacao da Transferencia', 11, false, false, false, 1, 'text', 'Observacao da Transferencia');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_guia'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_transmitente'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_comprador'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_data'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_usuario'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_numpre'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_status'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'it35_observacao'), 8, 0);

COMMIT;