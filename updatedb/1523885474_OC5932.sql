
-- Ocorrência 5932
BEGIN;
SELECT fc_startsession();

-- Início do script

-- INSERINDO db_sysarquivo
INSERT INTO db_sysarquivo VALUES ((select max(codarq)+1 from db_sysarquivo), 'liclicitaoutrosorgaos', 'licitacoes de outros orgaos', 'l211 ', '2018-03-23', 'licitacoes de outros orgaos', 0, false, false, false, false);

-- INSERINDO db_sysarqmod
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (19, (select max(codarq) from db_sysarquivo));

-- INSERINDO db_syscampo
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_sequencial',		 'int8', 'Sequencial',					'0', 'Sequencial',					8, false, false, false, 1, 'text', 'Sequencial');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_orgao',			 'int8', 'Orgao Responsavel',			'0', 'Orgao Responsavel',			8, false, false, false, 1, 'text', 'Orgao Responsavel');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_processo',		 'int4', 'Numero do Processo',			'0', 'Numero do Processo',			4, false, false, false, 1, 'text', 'Numero do Processo');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_numero',			 'int4', 'Numero da Modalidade',		'0', 'Numedo da Modalidade',		4, false, false, false, 1, 'text', 'Numedo da Modalidade');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_anousu',			 'int4', 'Ano da Licitacao',			'0', 'Ano da Licitacao',			4, false, false, false, 1, 'text', 'Ano da Licitacao');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_tipo',			 'int4', 'Tipo de Licitacao',			'0', 'Tipo de Licitacao',			8, false, false, false, 1, 'text', 'Tipo de Licitacao');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_codorgaoresplicit','int8', 'Cod. Orgao Responsavel pela Licitacao',			'0', 'Cod. Orgao Responsavel pela Licitacao',			8, false, false, false, 1, 'text', 'Cod. Orgao Responsavel pela Licitacao');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'lic211_codunisubres',	 'int8', 'CodUnidSub Responsavel pela Licitacao',			'0', 'CodUnidSub Responsavel pela Licitacao',			9, false, false, false, 1, 'text', 'CodUnidSub Responsavel pela Licitacao');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_licoutroorgao',		 'int8', 'Licitacao de Outro Orgao',	'0', 'Licitacao de Outro Orgao', 	8, false, false, false, 1, 'text', 'Licitacao de Outro Orgao');
INSERT INTO db_syscampo  VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_adesaoregpreco',	 'int8', 'Adesao de Registro de Preco', '0', 'Adesao de Registro de Preco', 8, false, false, false, 1, 'text', 'Adesao de Registro de Preco');

-- INSERINDO db_syssequencia
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'liclicitaoutrosorgaos_lic211_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

-- INSERINDO db_sysarqcamp
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'liclicitaoutrosorgaos_lic211_sequencial_seq'));
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_orgao'), 2, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_processo'), 3, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_numero'), 4, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_anousu'), 5, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_tipo'), 6, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_codorgaoresplicit'), 7, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'lic211_codunisubres'), 8, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'ac16_licoutroorgao'), 38, 0);
INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'ac16_adesaoregpreco'), 39, 0);

--INSERINDO db_itensmenu
--INSERINDO db_menu
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Licitacao de Outros Orgao', 'Licitacao de Outros Orgao', '', 1, 1, 'Licitacao de Outros Orgao', 't');
INSERT INTO db_menu VALUES (3470, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 3470 and modulo = 381), 381);
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Inclusao', 'Inclusao', 'lic1_liclicitaoutrosorgaos001.php', 1, 1, 'Inclusao', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Licitacao de Outros Orgao'), (select max(id_item) from db_itensmenu),1, 381);
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Alteracao', 'Alteracao', 'lic1_liclicitaoutrosorgaos002.php', 1, 1, 'Alteracao', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where descricao = 'Licitacao de Outros Orgao'), (select max(id_item) from db_itensmenu),2, 381);
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Exclusao', 'Exclusao', 'lic1_liclicitaoutrosorgaos003.php', 1, 1, 'Exclusao', 't');

-- Criando  sequences
CREATE SEQUENCE liclicitaoutrosorgaos_lic211_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA

-- Módulo: licitacao
CREATE TABLE liclicitaoutrosorgaos(
lic211_sequencial			int8 NOT NULL default 0,
lic211_orgao				int8 NOT NULL default 0,
lic211_processo				int4 NOT NULL default 0,
lic211_numero				int4 NOT NULL default 0,
lic211_anousu				int4 NOT NULL default 0,
lic211_tipo					int4 default 0,
lic211_codorgaoresplicit	int8,
lic211_codunisubres			int8,
CONSTRAINT liclicitaoutrosorgaos_sequ_pk PRIMARY KEY (lic211_sequencial));

-- Módulo: Contratos
ALTER TABLE acordo ADD ac16_licoutroorgao int8;
ALTER TABLE acordo ADD ac16_adesaoregpreco int8;


--Solicitado por Franciele
UPDATE db_syscampo
SET descricao = 'Assinatura Contrato',
    rotulo= 'Assinatura Contrato',
    rotulorel= 'Assinatura Contrato'
WHERE nomecam LIKE '%si03_dataassinacontrato%';

-- Módulo: Contabilidade

INSERT INTO pctipocompratribunal VALUES (104,6,'Adesão a ata de registro de preços','MG');
INSERT INTO pctipocompratribunal VALUES (105,6,'Licitação realizada por outro orgão','MG');

-- Fim do script

COMMIT;