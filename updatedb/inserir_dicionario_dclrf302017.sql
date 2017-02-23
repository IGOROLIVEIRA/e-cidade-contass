BEGIN;
SELECT fc_startsession();


/* INSERIR TABELA */
INSERT INTO db_sysarquivo
  (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform)
VALUES
  ((SELECT max(codarq)+1 FROM db_sysarquivo), 'dclrf302017', 'Cadastro DCLFR30', 'si178 ', '2017-02-22', 'Cadastro DCLFR30', 0, false, false, false, false);


/* INSERIR VINCULO TABELA COM SCHEMA */
INSERT INTO db_sysarqmod
  (codmod, codarq)
VALUES
  (2008005, (SELECT max(codarq) FROM db_sysarquivo));
-- 2008005: módulo sicom


/* INSERIR CAMPOS */
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_sequencial', 'int8', 'Sequencial', '', 'Sequencial', 11, false, true, false, 1, 'text', 'Sequencial');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_tiporegistro', 'int4', 'Tipo Registro', '', 'Tipo Registro', 30, false, true, false, 1, 'text', 'Tipo Registro');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_publiclrf', 'int4', 'Publicar relatório LRF', '', 'Publicar relatório LRF', 11, false, true, false, 1, 'text', 'Publicar relatório LRF');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_dtpublicacaorelatoriolrf', 'date', 'Data publicação de relatórios', '', 'Data publicação de relatórios', 10, false, true, false, 1, 'text', 'Data publicação de relatórios');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_localpublicacao', 'varchar(1000)', 'Onde foi dada a publicidade do RGF/RREO', '', 'Onde foi dada a publicidade do RGF/RREO', 1000, false, true, false, 1, 'textarea', 'Onde foi dada a publicidade do RGF/RREO');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_tpbimestre', 'int4', 'Periodo data de publicação da LRF', '', 'Periodo data de publicação da LRF',  11, false, true, false, 1, 'text', 'Periodo data de publicação da LRF');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_mes', 'int8', 'Mês', '', 'Mês', 11, false, true, false, 1, 'text', 'Mês');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si178_instit', 'int8', 'Instituição', '', 'Instituição', 11, false, true, false, 1, 'text', 'Instituição');


/* INSERIR VINCULO TABELA COM CAMPOS */
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_sequencial'),               1, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_tiporegistro'),             2, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_publiclrf'),                3, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_dtpublicacaorelatoriolrf'), 4, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_localpublicacao'),          5, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_tpbimestre'),               6, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_mes'),                      7, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES
((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si178_instit'),                   8, 0);


--DROP TABLE:
DROP TABLE IF EXISTS dclrf302017 CASCADE;
--Criando drop sequences


-- Criando  sequences
-- TABELAS E ESTRUTURA

-- M�dulo: sicom
CREATE TABLE dclrf302017(
si178_sequencial    int8 NOT NULL ,
si178_tiporegistro    int4 NOT NULL ,
si178_publiclrf   int4 NOT NULL ,
si178_dtpublicacaorelatoriolrf    date NOT NULL ,
si178_localpublicacao   varchar(1000) NOT NULL ,
si178_tpbimestre    int4 NOT NULL ,
si178_mes   int8 NOT NULL ,
si178_instit    int8 ,
CONSTRAINT dclrf302017_sequ_pk PRIMARY KEY (si178_sequencial));

CREATE SEQUENCE dclrf302017_si178_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


COMMIT;
