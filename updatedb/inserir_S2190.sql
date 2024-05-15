BEGIN;
SELECT fc_startsession();
 
-- INSERIR TIPO DO FORMULARIO
INSERT INTO esocialformulariotipo
VALUES(24,'Admissão de Trabalhador - Registro Preliminar');
 
-- INSERIR FORMULARIO 
INSERT INTO avaliacao (db101_sequencial, db101_avaliacaotipo, db101_descricao, db101_identificador, db101_obs, db101_ativo, db101_cargadados, db101_permiteedicao) VALUES (4000092, 5, 'FORMULÁRIO S2190 - ADMISSÃO DE TRABALHADOR - REGISTRO PRELIMINAR V2.5', 'formulario-s2190-v25', 'Versão 2.5 do formulario S2190 do eSocial', true, NULL, false);
 
INSERT INTO esocialversaoformulario
VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),'2.4',4000092,24);
 
-- INSERIR GRUPOS DO REGISTRO 2190
INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000091, 4000092, 'Informações de identificação do empregadorInformações do Registro Preliminar do Trabalhador', 'informacoes-de-identificacao-do-empregadorinformacoes-do-registro-preliminar-do-trabalhado-4000091', 'infoRegPrelim');
 
-- INSERIR PERGUNTAS DO REGISTRO 2190
INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000131, 2, 4000091, 'Preencher com o número do CPF do trabalhador', 'preencher-com-numero-do-cpf-do-trabalhor-4000131', true, true, 1, 4, '', 0, false, '', 'cpfTrab');
INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000132, 2, 4000091, 'Preencher com a data de nascimento', 'preencher-com-a-data-de-nascimento-4000132', true, true, 2, 1, '', 0, false, '', 'dtNascto');
INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000133, 2, 4000091, 'Preencher com a data de admissão do trabalhador', 'preencher-com-a-data-de-admissao-do-trab-4000133', false, true, 3, 1, '', 0, false, '', 'dtAdm');
 
-- INSERIR PERGUNTAS/OPCOES DO REGISTRO 2190
INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000198, 4000131, '', 'cpfTrab-4000198', true, 0, '', 'cpfTrab');
INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000199, 4000132, '', 'dtNascto-4000199', true, 0, '', 'dtNascto');
INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000200, 4000133, '', 'dtAdm-4000200', true, 0, '', 'dtAdm');
 
COMMIT;
