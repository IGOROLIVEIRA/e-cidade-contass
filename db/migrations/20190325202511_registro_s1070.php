<?php

use Classes\PostgresMigration;

class RegistroS1070 extends PostgresMigration
{

    public function up()
    {
        $this->insertLayout();
        $this->insertMenu();

    }

    private function insertMenu() 
    {
        $sql = <<<SQL

        SELECT fc_startsession();

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Tabela de Processos Administrativos/Judiciais - S1070',
            'Tabela de Processos Administrativos/Judiciais - S1070',
            'con4_manutencaoformulario001.php?esocial=10',
            1,
            1,
            'Tabela de Processos Administrativos/Judiciais - S1070',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            10,
            10216);

SQL;
        $this->execute($sql);
    }

    private function insertLayout() 
    {
        $sql = <<<SQL

        SELECT fc_startsession();

        -- INSERIR TIPO DO FORMULARIO
        INSERT INTO esocialformulariotipo
        VALUES(10,'Tabela de Processos Administrativos');

        -- INSERIR FORMULARIO 
        INSERT INTO avaliacao (db101_sequencial, db101_avaliacaotipo, db101_descricao, db101_identificador, db101_obs, db101_ativo, db101_cargadados, db101_permiteedicao) VALUES (4000088, 5, 'FORMULÁRIO S1070 - TABELA DE PROCESSOS ADMINISTRATIVOS/JUDICIAIS V2.5', 'formulario-s1070-v25', 'Versão 2.5 do formulario S1070 do eSocial', true, NULL, false);

        INSERT INTO esocialversaoformulario
        VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),'2.4',4000088,10);

        -- INSERIR GRUPOS DO REGISTRO 1070
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000085, 4000088, 'Informações de identificação do Processo e validade das informações que estão sendo incluídas.', 'informacoes-de-identificacao-do-processo-4000085', 'ideProcesso');
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000086, 4000088, 'Dados do processo.', 'dados-do-processo-4000086', 'dadosProc');
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000087, 4000088, 'Informações Complementares do Processo Judicial.', 'informacoes-complementares-do-processo-judicial-4000087', 'dadosProcJud');
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000088, 4000088, 'informações de suspensão de exigibilidade de tributos em virtude de processo administrativo/judicial', 'informacoes-suspensao-exigibilidade-4000088', 'infoSusp');

        -- INSERIR PERGUNTAS DO REGISTRO 1070
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000109, 1, 4000085, 'Preencher com o código correspondente ao tipo de processo:', 'preencher-com-o-codigo-tipo-processo-4000109', true, true, 1, 1, '', 0, true, '', 'tpProc');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000112, 2, 4000085, 'Preencher com o mês e ano de término da validade das informações, se houver, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-termino-4000112', false, true, 4, 1, '', 0, false, '', 'fimValid');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000113, 1, 4000086, 'Indicativo da autoria da ação judicial:', 'indicativo-da-autoria-da-acao-judicial-4000113', false, true, 1, 1, '', 0, false, '', 'indAutoria');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000114, 1, 4000086, 'Indicativo da matéria do processo ou alvará judicial:', 'indicativo-da-materia-do-processo-4000114', false, true, 2, 1, '', 0, false, '', 'indMatProc');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000115, 2, 4000086, 'Observações relacionadas ao processo', 'observacoes-relacionadas-ao-processo-4000115', false, true, 3, 1, '', 0, false, '', 'observacao');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000116, 2, 4000087, 'Identificação da UF da Seção Judiciária.', 'identificacao-da-uf-da-secao-judiciaria-4000116', true, true, 1, 1, '', 0, false, '', 'ufVara');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000117, 2, 4000087, 'Preencher com o código do município, conforme tabela do IBGE.', 'preencher-com-o-codigo-do-municipio-ibge-4000117', true, true, 2, 1, '', 0, false, '', 'codMunic');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000118, 2, 4000087, 'Código de Identificação da Vara.', 'codigo-de-identificacao-da-vara-4000118', true, true, 3, 1, '', 0, false, '', 'idVara');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000120, 2, 4000088, 'Código do Indicativo da Suspensão, atribuído pelo empregador.', 'codigo-do-indicativo-suspensao-4000120', true, true, 1, 1, '', 0, false, '', 'codSusp');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000121, 1, 4000088, 'indicativo de suspensão da exigibilidade:', 'indicativo-de-suspensao-da-exigibilidade-4000121', true, true, 2, 1, '', 0, false, '', 'indSusp');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000122, 2, 4000088, 'Data da decisão, sentença ou despacho administrativo', 'data-da-decisao-sentenca-ou-despacho-adm-4000122', true, true, 3, 1, '', 0, false, '', 'dtDecisao');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000123, 1, 4000088, 'Indicativo de Depósito do Montante Integral:', 'indicativo-de-deposito-do-montante-integ-4000123', true, true, 4, 1, '', 0, false, '', 'indDeposito');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000110, 2, 4000085, 'Informar o número do processo administrativo/judicial ou do benefício de acordo com o tipo informado em {tpProc}', 'numero-do-processo-administrativo-4000110', true, true, 2, 1, '', 0, true, '', 'nrProc');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000111, 2, 4000085, 'Preencher com o mês e ano de início da validade das informações prestadas no evento, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-inicio-4000111', true, true, 3, 1, '', 0, false, '', 'iniValid');

        -- INSERIR PERGUNTAS/OPCOES DO REGISTRO 1070
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000147, 4000109, 'Administrativo', 'tpProc-1-4000147', false, 0, '1', 'tpProc-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000148, 4000109, 'Judicial', 'tpProc-2-4000148', false, 0, '2', 'tpProc-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000150, 4000109, 'Processo FAP', 'tpProc-4-4000150', false, 0, '4', 'tpProc-4');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000149, 4000109, 'Número de Benefício (NB) do INSS', 'tpProc-3-4000149', false, 0, '3', 'tpProc-3');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000153, 4000112, '', 'fimValid-4000153', true, 0, '', 'fimValid');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000154, 4000113, 'Próprio contribuinte', 'indAutoria-1-4000154', false, 0, '1', 'indAutoria-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000155, 4000113, 'Outra entidade, empresa ou empregado', 'indAutoria-2-4000155', false, 0, '2', 'indAutoria-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000156, 4000114, 'Exclusivamente tributária ou tributária e FGTS', 'indMatProc-1-4000156', false, 0, '1', 'indMatProc-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000157, 4000114, 'Autorização de trabalho de menor', 'indMatProc-2-4000157', false, 0, '2', 'indMatProc-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000158, 4000114, 'Dispensa, ainda que parcial, de contratação de pessoa com deficiência (PCD)', 'indMatProc-3-4000158', false, 0, '3', 'indMatProc-3');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000159, 4000114, 'Dispensa, ainda que parcial, de contratação de aprendiz', 'indMatProc-4-4000159', false, 0, '4', 'indMatProc-4');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000160, 4000114, 'Segurança e Saúde no Trabalho', 'indMatProc-5-4000160', false, 0, '5', 'indMatProc-5');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000161, 4000114, 'Conversão de Licença Saúde em Acidente de Trabalho', 'indMatProc-6-4000161', false, 0, '6', 'indMatProc-6');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000162, 4000114, 'Exclusivamente FGTS e/ou Contribuição Social Rescisória (Lei Complementar 110/2001)', 'indMatProc-7-4000162', false, 0, '7', 'indMatProc-7');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000163, 4000114, 'Contribuição sindical', 'indMatProc-8-4000163', false, 0, '8', 'indMatProc-8');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000164, 4000114, 'Outros assuntos', 'indMatProc-99-4000164', false, 0, '99', 'indMatProc-99');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000165, 4000115, '', 'observacao-4000165', true, 0, '', 'observacao');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000166, 4000116, '', 'ufVara-4000166', true, 0, '', 'ufVara');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000167, 4000117, '', 'codMunic-4000167', true, 0, '', 'codMunic');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000168, 4000118, '', 'idVara-4000168', true, 0, '', 'idVara');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000169, 4000120, '', 'codSusp-4000169', true, 0, '', 'codSusp');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000170, 4000121, 'Liminar em Mandado de Segurança', 'indSusp-1-4000170', false, 0, '1', 'indSusp-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000171, 4000121, 'Depósito Judicial do Montante Integral', 'indSusp-2-4000171', false, 0, '2', 'indSusp-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000172, 4000121, 'Depósito Administrativo do Montante Integral', 'indSusp-3-4000172', false, 0, '3', 'indSusp-3');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000173, 4000121, 'Antecipação de Tutela', 'indSusp-4-4000173', false, 0, '4', 'indSusp-4');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000174, 4000121, 'Liminar em Medida Cautelar', 'indSusp-5-4000174', false, 0, '5', 'indSusp-5');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000175, 4000121, 'Sentença em Mandado de Segurança Favorável ao Contribuinte', 'indSusp-8-4000175', false, 0, '8', 'indSusp-8');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000177, 4000121, 'Acórdão do TRF Favorável ao Contribuinte', 'indSusp-10-4000177', false, 0, '10', 'indSusp-10');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000176, 4000121, 'Sentença em Ação Ordinária Favorável ao Contribuinte e ConfirmadA pelo TRF', 'indSusp-9-4000176', false, 0, '9', 'indSusp-9');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000178, 4000121, 'Acórdão do STJ em Recurso Especial Favorável ao Contribuinte', 'indSusp-11-4000178', false, 0, '11', 'indSusp-11');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000179, 4000121, 'Acórdão do STF em Recurso Extraordinário Favorável ao Contribuinte', 'indSusp-12-4000179', false, 0, '12', 'indSusp-12');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000180, 4000121, 'Sentença 1a instância não transitada em julgado com efeito suspensivo', 'indSusp-13-4000180', false, 0, '13', 'indSusp-13');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000181, 4000121, 'Contestação Administrativa FAP', 'indSusp-14-4000181', false, 0, '14', 'indSusp-14');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000182, 4000121, 'Decisão Definitiva a favor do contribuinte', 'indSusp-90-4000182', false, 0, '90', 'indSusp-90');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000183, 4000121, 'Sem suspensão da exigibilidade', 'indSusp-92-4000183', false, 0, '92', 'indSusp-92');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000184, 4000122, '', 'dtDecisao-4000184', true, 0, '', 'dtDecisao');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000185, 4000123, 'Sim', 'indDeposito-1-4000185', false, 0, 'S', 'indDeposito-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000186, 4000123, 'Não', 'indDeposito-2-4000186', false, 0, 'N', 'indDeposito-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000187, 4000110, '', 'nrProc-4000187', true, 0, '', 'nrProc');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000188, 4000111, '', 'iniValid-4000188', true, 0, '', 'iniValid');
 
SQL;

        $this->execute($sql);
    }
}
