
-- Ocorrência CRONEM
BEGIN;                   
SELECT fc_startsession();

-- Início do script

-- Inserindo Menu
INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Cronograma Mensal de Desembolso', 'Cronograma Mensal de Desembolso','orc4_cronogramamesdesembolso004.php',1,1,'Cronograma Mensal de Desembolso','t');
INSERT INTO db_menu VALUES (32,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where modulo=116 and id_item=32),116);


-- Criando  sequences
CREATE SEQUENCE cronogramamesdesembolso_o202_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: orcamento
CREATE TABLE cronogramamesdesembolso(
o202_sequencial		int8 NOT NULL default 0,
o202_unidade		int8 NOT NULL default 0,
o202_orgao		int8 NOT NULL default 0,
o202_anousu		int8 NOT NULL default 0,
o202_elemento		varchar(13) NOT NULL,
o202_janeiro		float8 NOT NULL default 0,
o202_fevereiro		float8 NOT NULL default 0,
o202_marco		float8 NOT NULL default 0,
o202_abril		float8 NOT NULL default 0,
o202_maio		float8 NOT NULL default 0,
o202_junho		float8 NOT NULL default 0,
o202_julho		float8 NOT NULL default 0,
o202_agosto		float8 NOT NULL default 0,
o202_setembro		float8 NOT NULL default 0,
o202_outubro		float8 NOT NULL default 0,
o202_novembro		float8 NOT NULL default 0,
o202_dezembro		float8 NOT NULL default 0,
o202_instit		int8 default 0,
CONSTRAINT cronogramamesdesembolso_sequ_pk PRIMARY KEY (o202_sequencial));


-- CHAVE ESTRANGEIRA

ALTER TABLE cronogramamesdesembolso
ADD CONSTRAINT cronogramamesdesembolso_ae_orgao_fk FOREIGN KEY (o202_anousu,o202_orgao)
REFERENCES orcorgao;

ALTER TABLE cronogramamesdesembolso
ADD CONSTRAINT cronogramamesdesembolso_ae_orgao_unidade_fk FOREIGN KEY (o202_anousu,o202_orgao,o202_unidade)
REFERENCES orcunidade;

-- Campo tabela sicom
ALTER TABLE cronem102018 ADD COLUMN si170_mes int8 DEFAULT 0;
ALTER TABLE cronem102017 ADD COLUMN si170_mes int8 DEFAULT 0;


-- Inserindo dicionario de dados
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo),'cronogramamesdesembolso','Cronograma Mensal de Desembolso','o202 ','2017-12-13','Cronograma Mensal de Desembolso',0,FALSE,FALSE,FALSE,FALSE);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (35, (select max(codarq) from db_sysarquivo));

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_sequencial', 'int8', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_unidade', 'int8', 'Unidade', '0', 'Unidade', 11, false, false, false, 1, 'text', 'Unidade');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_orgao', 'int8', 'Orgão', '0', 'Orgão', 11, false, false, false, 1, 'text', 'Orgão');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_anousu', 'int8', 'Ano', '0', 'Ano', 11, false, false, false, 1, 'text', 'Ano');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_janeiro', 'float8', 'Janeiro', '0', 'Janeiro', 11, false, false, false, 4, 'text', 'Janeiro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_fevereiro', 'float8', 'Fevereiro', '0', 'Fevereiro', 11, false, false, false, 4, 'text', 'Fevereiro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_marco', 'float8', 'Março', '0', 'Março', 11, false, false, false, 4, 'text', 'Março');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_abril', 'float8', 'Abril', '0', 'Abril', 11, false, false, false, 4, 'text', 'Abril');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_maio', 'float8', 'Maio', '0', 'Maio', 11, false, false, false, 4, 'text', 'Maio');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_junho', 'float8', 'Junho', '0', 'Junho', 11, false, false, false, 4, 'text', 'Junho');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_julho', 'float8', 'Julho', '0', 'Julho', 11, false, false, false, 4, 'text', 'Julho');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_agosto', 'float8', 'Agosto', '0', 'Agosto', 11, false, false, false, 4, 'text', 'Agosto');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_setembro', 'float8', 'Setembro', '0', 'Setembro', 11, false, false, false, 4, 'text', 'Setembro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_outubro', 'float8', 'Outubro', '0', 'Outubro', 11, false, false, false, 4, 'text', 'Outubro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_novembro', 'float8', 'Novembro', '0', 'Novembro', 11, false, false, false, 4, 'text', 'Novembro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_dezembro', 'float8', 'Dezembro', '0', 'Dezembro', 11, false, false, false, 4, 'text', 'Dezembro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_instit', 'int8', 'Instituição', '0', 'Instituição', 11, false, false, false, 1, 'text', 'Instituição');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o202_elemento', 'varchar(13)', 'Elemento', '', 'Elemento', 13, false, true, false, 0, 'text', 'Elemento');

INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'cronogramamesdesembolso_o202_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'cronogramamesdesembolso_o202_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_unidade'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_orgao'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_anousu'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_janeiro'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_fevereiro'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_marco'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_abril'), 9, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_maio'), 10, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_junho'), 11, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_julho'), 12, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_agosto'), 13, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_setembro'), 14, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_outubro'), 15, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_novembro'), 16, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_dezembro'), 17, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_instit'), 18, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_elemento'), 5, 0);

INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_anousu'), 1, 756, 1);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_orgao'), 2, 756, 1);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_anousu'), 1, 757, 1);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_orgao'), 2, 757, 1);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o202_unidade'), 3, 757, 1);

-- Fim do script

COMMIT;

