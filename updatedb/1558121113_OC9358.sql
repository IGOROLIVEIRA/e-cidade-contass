-- Ocorrência 9358
/*BEGIN;                   
SELECT fc_startsession();

-- Início do script

INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Controle Interno','Controle Interno','',2,1,'','t');

INSERT INTO db_modulos (id_item,nome_modulo,descr_modulo,imagem,temexerc,nome_manual) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'),'Controle Interno','Controle Interno','','t','Controle Interno');

-- VINCULAR MODULO A AREA
INSERT INTO atendcadareamod (at26_sequencia,at26_codarea,at26_id_item) VALUES 
((SELECT MAX(at26_sequencia)+1 FROM atendcadareamod),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
-- RELATORIOS
((SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'),3331,2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
-- CONSULTAS
((SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'),3333,3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- CONSULTAS > COMPRAS
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3333,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Compras' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao = 'Compras' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Solicita%es' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao = 'Compras' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao = 'Ordens de Compra' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao = 'Compras' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao = 'Consulta Processo de Compras' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao = 'Compras' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Abertura Registro de pre%o' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- CONSULTAS > LICITACOES
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3333,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Licita%es' ORDER BY id_item DESC LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Licita%es' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Licita%o (Novo)' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- CONSULTA > CONTRATOS
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3333,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contratos' ORDER BY id_item DESC LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contratos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Acordos' AND help LIKE 'Consulta%' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- CONSULTA > MATERIAL
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3333,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Material' ORDER BY id_item DESC LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Material' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Material (novo)' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- CONSULTA > PATRIMONIO
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3333,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Patrim%nio' ORDER BY id_item DESC LIMIT 1),5,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Patrim%nio' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Bens (novo)' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Patrim%nio' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Bens baixados' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Patrim%nio' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Transfer%ncia de Bens' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- CONSULTA > VEICULOS
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3333,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Ve%culos' ORDER BY id_item DESC LIMIT 1),6,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Ve%culos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Ve%culos' AND help LIKE 'Consulta%' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- CONSULTA > FINANCEIRO
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3333,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),7,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Autoriza%o de Empenho' AND funcao = 'emp1_empconsultaaut001.php' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Consulta de Notas Fiscais' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Consulta  Empenho' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Consulta de Slips' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Saldo da Tesouraria' LIMIT 1),5,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Saldo da Despesa' LIMIT 1),6,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Saldo da Receita' LIMIT 1),7,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > COMPRAS
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Compras','Relatórios Compras','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Compras' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Compras' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Posi%o do Registro de Pre%o' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Compras' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Mapa das propostas do or%amento' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Mapa das propostas do or%amento' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Por Item' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Mapa das propostas do or%amento' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Por Lote' AND funcao = 'com2_mapaorcamentolote001.php' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Compras' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Controle de Ordens de Compra' AND funcao = 'com2_conordemcom001.php' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > LICITACOES
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Licitações','Relatórios Licitações','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Licita%es' ORDER BY id_item DESC LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Licita%es' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Mapa das Propostas' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Licita%es' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Roll de Licita%es' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Licita%es' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Vencedores da Licita%o' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > CONTRATOS
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Contratos','Relatórios Contratos','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Contratos' ORDER BY id_item DESC LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Contratos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Acordos a Vencer' AND funcao LIKE 'con2_relatorioacordosavencer001.php' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Contratos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Saldo de Contratos' AND funcao LIKE 'con2_saldocontratos001.php' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Contratos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Execu%o de Contratos' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > MATERIAL
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Material','Relatórios Material','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Material' ORDER BY id_item DESC LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Material' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Estoque por Item (Novo)' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Material' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Entrada de Materiais por Departamentos' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Material' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Controle de Estoque (Novo)' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Material' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Atendimento de Requisi%es por Departamento' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Material' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Processamento de Invent%rio' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > PATRIMONIO
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Patrimônio','Relatórios Patrimônio','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Patrim%nio' ORDER BY id_item DESC LIMIT 1),5,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Patrim%nio' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Geral de bens' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Patrim%nio' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Baixa de bens' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Patrim%nio' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rio da Baixa' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Patrim%nio' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Transfer%ncia de bens por periodo' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > VEICULOS
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Veículos','Relatórios Veículos','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Ve%culos' ORDER BY id_item DESC LIMIT 1),6,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Ve%culos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Abastecimento (Novo)' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Ve%culos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Manuten%o de ve%culos' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Ve%culos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Movimenta%o de Ve%culos' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Ve%culos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Manuten%o por Per%odo' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));
UPDATE db_itensmenu SET libcliente = 't' WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Manuten%o por Per%odo' LIMIT 1);

-- RELATORIOS > EMPENHOS
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),7,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenhos' AND funcao = 'emp2_relempenho001.php' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenhos Emp/Liq/Pag' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Execu%o de Restos a Pagar' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenhos Pagos (novo)' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reten%es' AND funcao = 'emp2_confereretencoes001.php' LIMIT 1),5,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Notas ( Liquida%o por Notas )' LIMIT 1),6,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Notas ( Pagamento de notas )' LIMIT 1),7,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Ordens de Pagamento' LIMIT 1),8,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Ordens de Compra' AND funcao LIKE 'emp2_relordemcompra001.php%' LIMIT 1),9,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Empenho' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Itens por empenho' LIMIT 1),10,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > FINANCEIRO
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Financeiro','Relatórios Financeiro','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),8,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Extrato Banc%rio novo' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Slip por Conta' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Pagamento de Despesa Extra-Or%ament%ria' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Slip' AND funcao = 'cai2_relslip001.php' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Emiss%o de Boletim' AND funcao = 'cai2_emissbol001.php' LIMIT 1),5,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Demonstrativo de Pagamento a Fornecedor' LIMIT 1),6,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Receitas Pagas por Per%odo' LIMIT 1),7,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE help LIKE 'Relat%rios Financeiro' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Concilia%o Banc%ria' ORDER BY id_item DESC LIMIT 1),8,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Concilia%o Banc%ria' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemissao de Concilia%o' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Concilia%o Banc%ria' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o da Concilia%o Dia' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > ORCAMENTO
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Or%amento' ORDER BY id_item DESC LIMIT 1),9,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Or%amento' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'QUADRO DETAL. DESPESAS - QDD' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Or%amento' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Saldo de verbas da despesa' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Or%amento' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Receita Or%ada por Recurso' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Or%amento' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Suplementa%es' AND desctec LIKE 'Agrupa%' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Suplementa%es' AND desctec LIKE 'Agrupa%' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Emiss%o do Projeto' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Suplementa%es' AND desctec LIKE 'Agrupa%' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relatorio de Projetos' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Suplementa%es' AND desctec LIKE 'Agrupa%' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rio de Suplementa%es' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > CONTABILIDADE
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),10,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Balancetes' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) SELECT id_item,id_item_filho,menusequencia,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno') AS modulo FROM db_menu 
	WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Balancetes' LIMIT 1) AND modulo = 209;

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Raz%o' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) SELECT id_item,id_item_filho,menusequencia,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno') AS modulo FROM db_menu 
	WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Raz%o' LIMIT 1) AND modulo = 209;

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Extratos' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) SELECT id_item,id_item_filho,menusequencia,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno') AS modulo FROM db_menu 
	WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Extratos' LIMIT 1) AND modulo = 209;

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rios de Confer%ncia' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rios de Confer%ncia' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Di%rio de Caixa/Bancos' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rios de Confer%ncia' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Despesa por Desdobramento' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rios de Confer%ncia' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Despesa por Item/Desdobramento' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Demonstra%es cont%beis do DCASP' LIMIT 1),5,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) SELECT id_item,id_item_filho,menusequencia,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno') AS modulo FROM db_menu 
	WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Demonstra%es cont%beis do DCASP' LIMIT 1) AND modulo = 209;
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Balan%o Or%ament%rio' AND funcao = '' LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Exerc%cio 2015' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Demonstrativo Extra-Or%ament%rio' LIMIT 1),6,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rios de Acompanhamento' LIMIT 1),7,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) SELECT id_item,id_item_filho,menusequencia,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno' LIMIT 1) AS modulo FROM db_menu 
	WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rios de Acompanhamento' LIMIT 1) AND modulo = 209;

INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Contabilidade' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relat%rio Rateio' LIMIT 1),8,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

-- RELATORIOS > REEMISSAO DE DOCUMENTOS
INSERT INTO db_itensmenu (id_item,descricao,help,funcao,itemativo,manutencao,desctec,libcliente) VALUES
((SELECT MAX(id_item)+1 FROM db_itensmenu),'Reemissão de Documentos','Reemissão de Documentos','',1,1,'','t');
INSERT INTO db_menu (id_item,id_item_filho,menusequencia,modulo) VALUES 
(3331,(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Documentos' ORDER BY id_item DESC LIMIT 1),11,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Documentos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Emite Empenho' LIMIT 1),1,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Documentos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemite anula%o' LIMIT 1),2,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Documentos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE funcao = 'emp2_reemiteslip001.php' LIMIT 1),3,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Documentos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Emite Ordem de Compra' LIMIT 1),4,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Documentos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Emite Autoriza%o de Empenho' LIMIT 1),5,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')),
((SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Documentos' ORDER BY id_item DESC LIMIT 1),(SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Reemiss%o de Planilha' LIMIT 1),6,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));


-- Fim do script

COMMIT;*/

