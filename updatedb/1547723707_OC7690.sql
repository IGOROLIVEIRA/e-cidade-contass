
-- Ocorrência 7690
BEGIN;
SELECT fc_startsession();

-- Início do script

ALTER TABLE orctiporec ADD COLUMN o15_codstn integer;
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
  VALUES ((select max(codcam)+1 from db_syscampo), 'o15_codstn', 'integer', 'Código STN', '', 'Código STN', 10, false, true, false, 0, 'integer', 'Código STN');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
  VALUES (
    (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o15_codigo') limit 1) order by codarq limit 1)
    , (select codcam from db_syscampo where nomecam = 'o15_codstn')
    , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o15_codigo') limit 1) order by codarq limit 1))
    , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o15_codigo') limit 1) order by codarq limit 1)));

UPDATE atendcadarea
  SET at25_descr = 'DB:PRESTAÇÃO DE CONTAS'
    WHERE at26_sequencial = (
      SELECT DISTINCT at26_sequencial
        FROM atendcadarea
        INNER JOIN atendcadareamod ON at26_sequencial = at26_codarea
        WHERE at26_sequencial = 2000000 AND at25_descr = 'DB:TCE/MG'
    );

UPDATE db_modulos
  SET nome_modulo = 'STN', descr_modulo = 'STN'
    WHERE id_item = 2000025;

UPDATE db_modulos
  SET nome_modulo = 'TCE/MG', descr_modulo = 'TCE/MG'
    WHERE id_item = 2000018;

--STN
CREATE TEMPORARY TABLE temp_stn ON COMMIT DROP AS
SELECT db_itensmenu.id_item AS dbitenmenu
      ,db_menu.id_item      AS dbmenu
      ,db_modulos.id_item   AS modulo
  FROM db_modulos
   INNER JOIN db_menu on db_menu.modulo = db_modulos.id_item
   INNER JOIN db_itensmenu on db_itensmenu.id_item = db_menu.id_item_filho
    WHERE db_modulos.id_item = 2000025 AND db_menu.id_item_filho NOT IN (3962, 32, 31, 30);

DELETE
  FROM db_menu
    WHERE id_item IN (SELECT dbmenu FROM temp_stn)
     AND id_item_filho IN (SELECT dbitenmenu FROM temp_stn)
     AND modulo IN (SELECT modulo FROM temp_stn);

--CADASTROS
INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'De/Para Pcasp MSC','De/Para Pcasp MSC','',1,1,'De/Para Pcasp MSC','t');
INSERT INTO db_menu values (3962,(select id_item from db_itensmenu where descricao = 'De/Para Pcasp MSC'),1,2000025);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Incluir De/Para Pcasp MSC.','con1_vinculopcaspmsc001.php',1,1,'Incluir De/Para Pcasp MSC','t');
INSERT INTO db_menu values ((select id_item from db_itensmenu where descricao = 'De/Para Pcasp MSC'),(select id_item from db_itensmenu where help = 'Incluir De/Para Pcasp MSC.'),1,2000025);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alterar De/Para Pcasp MSC.','con1_vinculopcaspmsc002.php',1,1,'Alterar De/Para Pcasp MSC','t');
INSERT INTO db_menu values ((select id_item from db_itensmenu where descricao = 'De/Para Pcasp MSC'),(select id_item from db_itensmenu where help = 'Alterar De/Para Pcasp MSC.'),2,2000025);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Excluir De/Para Pcasp MSC.','con1_vinculopcaspmsc003.php',1,1,'Excluir De/Para Pcasp MSC','t');
INSERT INTO db_menu values ((select id_item from db_itensmenu where descricao = 'De/Para Pcasp MSC'),(select id_item from db_itensmenu where help = 'Excluir De/Para Pcasp MSC.'),3,2000025);

INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'De/Para Orcamento MSC','De/Para Orcamento MSC.','con4_sicominfocomplementarmsc.php',1,1,'De/Para Orcamento MSC','t');
INSERT INTO db_menu values (3962,(select id_item from db_itensmenu where descricao = 'De/Para Orcamento MSC' limit 1),2,2000025);

--RELATÓRIOS
INSERT INTO db_menu values (2000025,30,3,2000025);
INSERT INTO db_menu values (30,(select id_item from db_itensmenu where descricao = 'Balancete de Verificação'),1,2000025);

--PROCEDIMENTOS
INSERT INTO db_menu values (32,(select id_item from db_itensmenu where descricao = 'Gerar MSC'),1,2000025);

UPDATE db_menu SET menusequencia = 2 WHERE id_item_filho = 30 AND id_item = 2000025 AND modulo = 2000025;
UPDATE db_menu SET menusequencia = 3 WHERE id_item_filho = 31 AND id_item = 2000025 AND modulo = 2000025;
UPDATE db_menu SET menusequencia = 4 WHERE id_item_filho = 32 AND id_item = 2000025 AND modulo = 2000025;


--TCE/MG
CREATE TEMPORARY TABLE temp_tcemg ON COMMIT DROP AS
SELECT db_itensmenu.id_item AS dbitenmenu
      ,db_menu.id_item      AS dbmenu
      ,db_modulos.id_item   AS modulo
  FROM db_modulos
   INNER JOIN db_menu on db_menu.modulo = db_modulos.id_item
   INNER JOIN db_itensmenu on db_itensmenu.id_item = db_menu.id_item_filho
    WHERE db_modulos.id_item = 2000018 AND db_menu.id_item_filho NOT IN (3962, 32, 31, 30)
      AND db_itensmenu.descricao NOT IN ('Informações Complementares','Identificação dos Responsáveis','Considerações','Importa Contratos XML','Vínculo Pcasp TCE','Alterar Dotação RP','Relatórios Gerais','Movimentação de Empenhos Sicom','Conferência de Empenhos','Gerar SICOM', 'Importar Sicom', 'Instrumento de Planejamento', 'Acompanhamento Mensal', 'Balancete', 'Prestação de Contas Anual - PCA', 'Legislação Caráter Financeiro', 'Sicom folha', 'Inclusão de Programas', 'DCASP')
      AND db_itensmenu.help NOT IN ( 'Inculir Vínculo Pcasp TCE', 'Alterar Vínculo Pcasp TCE', 'Excluir Vínculo Pcasp TCE',
                                      'Inculir Alterar Dotação RP', 'Alterar Alterar Dotação RP', 'Excluir Alterar Dotação RP'
                                    )
      AND db_itensmenu.funcao NOT IN ('sic1_consideracoes001.php','sic1_consideracoes002.php','sic1_consideracoes003.php',
                                      'sic1_identificacaoresponsaveis001.php','sic1_identificacaoresponsaveis002.php','sic1_identificacaoresponsaveis003.php'
                                      );

DELETE
  FROM db_menu
    WHERE id_item IN (SELECT dbmenu FROM temp_tcemg)
     AND id_item_filho IN (SELECT dbitenmenu FROM temp_tcemg)
     AND modulo IN (SELECT modulo FROM temp_tcemg);


--RELATÓRIOS
 INSERT INTO db_menu values (30,(select id_item from db_itensmenu where descricao = 'Balancete de Verificação'),1,2000018);

 --CONSULTAS
INSERT INTO db_menu values (2000018,31,0,2000018);
INSERT INTO db_menu values (31,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Acordos' AND help = 'Consulta Acordos'),1,2000018);
INSERT INTO db_menu values (31,(SELECT id_item FROM db_itensmenu WHERE descricao = 'CGM (novo)' AND help = 'Nova consulta do CGM novo'),2,2000018);
INSERT INTO db_menu values (31,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Consulta Empenho'),3,2000018);
INSERT INTO db_menu values (31,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Licitação (Novo)'),4,2000018);
INSERT INTO db_menu values (31,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Saldo da Despesa'),5,2000018);

--PROCEDIMENTOS
INSERT INTO db_menu values (32,(select id_item from db_itensmenu where descricao = 'Gerar Siace-LRF'),3,2000018);

UPDATE db_menu SET menusequencia = 2 WHERE id_item_filho = 30 AND id_item = 2000018 AND modulo = 2000018;
UPDATE db_menu SET menusequencia = 3 WHERE id_item_filho = 31 AND id_item = 2000018 AND modulo = 2000018;
UPDATE db_menu SET menusequencia = 4 WHERE id_item_filho = 32 AND id_item = 2000018 AND modulo = 2000018;


-- Fim do script
COMMIT;
