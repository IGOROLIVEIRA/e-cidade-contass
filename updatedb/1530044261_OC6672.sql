
-- Ocorrência 6672
BEGIN;
SELECT fc_startsession();

-- Início do script

-- CAMPO PARA IDENTIFICAR O ITEM EM pcmater
ALTER TABLE protparam ADD COLUMN p90_autprotocolo BOOLEAN DEFAULT FALSE;

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'p90_autprotocolo', 'boolean', 'Autorização Automática de Protocolo', '', 'Autorização Automática de Protocolo', 1, false, true, false, 0, 'boolean', 'Autorização Automática de Protocolo');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('p90_instit')))
    , (select codcam from db_syscampo where nomecam = 'p90_autprotocolo')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('p90_instit'))))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('p90_instit')))));


-- Fim do script
COMMIT;


BEGIN;
SELECT fc_startsession();
--DROP TABLE:
DROP TABLE IF EXISTS protconfigdepartaut CASCADE;
--Criando drop sequences
DROP SEQUENCE IF EXISTS protconfigdepartaut_p109_sequencial_seq;

-- Criando  sequences
CREATE SEQUENCE protconfigdepartaut_p109_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA
-- Modulo: protocolo
CREATE TABLE protconfigdepartaut(
p109_sequencial   int4 NOT NULL default 0,
p109_coddeptoorigem   int4 NOT NULL default 0,
p109_coddeptodestino    int4 NOT NULL default 0,
p109_instit   int4 NOT NULL default 0,
p109_id_usuario   int4 NOT NULL default 0,
p109_dt_config    date default null,
CONSTRAINT protconfigdepartaut_sequ_pk PRIMARY KEY (p109_sequencial));

-- CHAVE ESTRANGEIRA

ALTER TABLE protconfigdepartaut
ADD CONSTRAINT protconfigdepartaut_instit_fk FOREIGN KEY (p109_instit)
REFERENCES db_config;

ALTER TABLE protconfigdepartaut
ADD CONSTRAINT protconfigdepartaut_coddeptodestino_fk FOREIGN KEY (p109_coddeptodestino)
REFERENCES db_depart;

ALTER TABLE protconfigdepartaut
ADD CONSTRAINT protconfigdepartaut_coddeptoorigem_fk FOREIGN KEY (p109_coddeptoorigem)
REFERENCES db_depart;

ALTER TABLE protconfigdepartaut
ADD CONSTRAINT protconfigdepartaut_usuario_fk FOREIGN KEY (p109_id_usuario)
REFERENCES db_usuarios;

-- INDICES
CREATE UNIQUE INDEX p109_sequencial_index ON protconfigdepartaut(p109_sequencial);
COMMIT;

BEGIN;
SELECT fc_startsession();

--Casdastro da tabela
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'protconfigdepartaut', 'Tabela para configuracao de ordens de pagamentos e slips automatica.', 'p109 ', '2018-07-12', 'protconfigdepartaut', 0, false, false, false, false);
--Vínculo da tabela com o módulo
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));

--Cadastro dos campos da tabela
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p109_sequencial', 'int4', 'p109_sequencial', '0', 'p109_sequencial', 10, false, false, true, 1, 'text', 'p109_sequencial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p109_coddeptodestino', 'int4', 'Departamento Destino', '0', 'Dept. Destino', 10, false, false, false, 1, 'text', 'Dept. Destino');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p109_coddeptoorigem', 'int4', 'Departamento Origem', '0', 'Dept. Origem', 10, false, false, false, 1, 'text', 'Dept. Origem');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p109_instit', 'int4', 'Instituicao', '0', 'Instituicao', 10, false, false, false, 1, 'text', 'Instituicao');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p109_id_usuario', 'int4', 'Usuario', '0', 'Usuario', 10, false, false, false, 1, 'text', 'Usuario');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p109_dt_config', 'date', 'Data Configuracao', 'null', 'Data Configuracao', 10, false, false, false, 1, 'text', 'Data Configuracao');

--Vículo dos campos com a tabela
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_sequencial'), 1, 1);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_coddeptodestino'), 2, 2);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_coddeptoorigem'), 3, 3);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_instit'), 4, 4);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_id_usuario'), 5, 5);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_dt_config'), 6, 6);

-- Chaves estrangeiras
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_coddeptodestino'), 1, 154, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_coddeptoorigem'), 1, 154, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_instit'), 1, 83, 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p109_id_usuario'), 1, 109, 0);

--Sequenciais
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'protconfigdepartaut_p109_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

-- Indices
INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p109_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

COMMIT;

