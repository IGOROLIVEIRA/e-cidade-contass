
-- Ocorrência 7029
BEGIN;
SELECT fc_startsession();

-- Início do script
BEGIN;

SELECT fc_startsession();

-- INSERINDO db_sysarquivo
INSERT INTO db_sysarquivo VALUES ((select max(codarq)+1 from db_sysarquivo), 'despachopadrao', 'Despachos Padronizados', 'p201', '2018-08-08', 'Despachos Padronizados', 0, false, false, false, false);

-- INSERINDO db_sysarqmod
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));

-- INSERINDO db_syscampo
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo),'p201_sequencial','int8','Sequencial','0','Sequencial',8,false,false,false,1,'text','Sequencial');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo),'p201_descricao','int8','Descrição','0','Descrição',255,false,true,false,0,'text','Descrição');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo),'p201_textopadrao','int8','Texto Padrão','0','Texto Padrão',2500,false,false,false,0,'text','Texto Padrão');

-- INSERINDO db_sysarqcamp
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p201_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'despachopadrao_p201_sequencial_seq'));
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p201_descricao'), 2, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p201_textopadrao'), 3, 0);

-- CRIANDO A TABELA
CREATE TABLE despachopadrao
(
  p201_sequencial bigint NOT NULL DEFAULT 0,
  p201_descricao text NOT NULL DEFAULT 0,
  p201_textopadrao text NOT NULL DEFAULT 0,
  CONSTRAINT despachopadrao_sequ_pk PRIMARY KEY (p201_sequencial)
);

-- CRIANDO SEQUENCIA DA TABELA
CREATE SEQUENCE despachopadrao_p201_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- INSERINDO db_syssequencia
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'despachopadrao_p201_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

--INSERINDO db_itensmenu
--INSERINDO db_menu
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Despachos Padronizados', 'Despachos Padronizados', '', 1, 1, 'Despachos Padronizados', 't');
INSERT INTO db_menu VALUES (29, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 29 and modulo = 604), 604);
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Inclusão', 'Inclusão', 'pro1_despachopadrao001.php', 1, 1, 'Inclusão', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Despachos Padronizados'), (select max(id_item) from db_itensmenu),1, 604);
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Alteração', 'Alteração', 'pro1_despachopadrao002.php', 1, 1, 'Alteração', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Despachos Padronizados'), (select max(id_item) from db_itensmenu),2, 604);
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Exclusão', 'Exclusão', 'pro1_despachopadrao003.php', 1, 1, 'Exclusão', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Despachos Padronizados'), (select max(id_item) from db_itensmenu),3, 604);

-- Fim do script

COMMIT;

