<?php

use Classes\PostgresMigration;

class RegistroS1060 extends PostgresMigration
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
            'Tabela de Ambientes de Trabalho - S1060',
            'Tabela de Ambientes de Trabalho - S1060',
            'con4_manutencaoformulario001.php?esocial=9',
            1,
            1,
            'Tabela de Ambientes de Trabalho - S1060',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            9,
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
        VALUES(9,'Tabela de Ambientes de Trabalho');

        -- INSERIR FORMULARIO 
        INSERT INTO avaliacao (db101_sequencial, db101_avaliacaotipo, db101_descricao, db101_identificador, db101_obs, db101_ativo, db101_cargadados, db101_permiteedicao) VALUES (4000087, 5, 'FORMULÁRIO S1060 - TABELA DE AMBIENTES DE TRABALHO V2.5', 'formulario-s1060-v25', 'Versão 2.5 do formulario S1060 do eSocial', true, 'SELECT rh55_instit AS instituicao, rh55_codigo AS codigoambiente, rh55_descr AS nomeambiente, rh55_descr AS descambiente
            FROM rhlocaltrab WHERE rh55_instit = fc_getsession(\'DB_instit\')::int', false);

        INSERT INTO esocialversaoformulario
        VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),'2.4',4000087,9);

        -- INSERIR GRUPOS DO REGISTRO 1060
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000084, 4000087, 'Informações do ambiente de trabalho.', 'informacoes-do-ambiente-de-trabalho-4000084', 'dadosAmbiente');
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000083, 4000087, 'Informações de identificação do ambiente de trabalho do empregador e de validade das informações.', 'informacoes-de-identificacao-do-ambiente-de-trabalho-do-empregador-4000083', 'ideAmbiente');

        -- INSERIR PERGUNTAS DO REGISTRO 1060
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000097, 2, 4000083, 'Preencher com o código atribuído pela empresa ao Ambiente de Trabalho.', 'preencher-com-o-codigo-do-ambiente-4000097', true, true, 2, 1, '', 0, true, 'codigoambiente', 'codAmb');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000100, 2, 4000083, 'Instituição no e-Cidade:', 'instituicao-no-ecidade-4000100', false, true, 1, 1, '', 0, true, 'instituicao', 'instituicao');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000101, 2, 4000083, 'Preencher com o mês e ano de início da validade das informações prestadas no evento, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-inicio-4000101', true, true, 3, 1, '', 0, false, '', 'iniValid');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000102, 2, 4000083, 'Preencher com o mês e ano de término da validade das informações, se houver, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-termino-4000102', false, true, 4, 1, '', 0, false, '', 'fimValid');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000103, 2, 4000084, 'Informar o nome do ambiente de trabalho.', 'informar-o-nome-do-ambiente-de-trabalho-4000103', true, true, 1, 1, '', 0, false, 'nomeambiente', 'nmAmb');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000104, 2, 4000084, 'Descrição do ambiente de trabalho.', 'descricao-do-ambiente-de-trabalho-4000104', true, true, 2, 1, '', 0, false, 'descambiente', 'dscAmb');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000105, 1, 4000084, 'Preencher com uma das opções:', 'preencher-com-uma-das-opcoes-4000105', false, true, 3, 1, '', 0, false, '', 'localAmb');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000106, 2, 4000084, 'Preencher com o código correspondente ao tipo de inscrição, conforme Tabela 05. Preenchimento obrigatório e exclusivo se {localAmb} = [1, 3].', 'codigo-tipo-de-inscricao-4000106', false, true, 4, 1, '', 0, false, '', 'tpInsc');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000107, 2, 4000084, 'Número de inscrição onde está localizado o ambiente.', 'numero-de-inscricao-onde-esta-localizado-4000107', false, true, 5, 1, '', 0, false, '', 'nrInsc');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000108, 2, 4000084, 'Informar o código atribuído pela empresa para a lotação tributária. Preenchimento obrigatório e exclusivo se {localAmb} = [2].', 'informar-o-codigo-lotacao-tributaria-4000108', false, true, 6, 1, '', 0, false, '', 'codLotacao');

        -- INSERIR PERGUNTAS/OPCOES DO REGISTRO 1060
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000133, 4000097, '', 'codAmb-4000133', true, 0, '', 'codAmb');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000135, 4000100, '', 'instituicao-4000135', true, 0, '', 'instituicao');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000136, 4000101, '', 'iniValid-4000136', true, 0, '', 'iniValid');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000137, 4000102, '', 'fimValid-4000137', true, 0, '', 'fimValid');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000138, 4000103, '', 'nmAmb-4000138', true, 0, '', 'nmAmb');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000139, 4000104, '', 'dscAmb-4000139', true, 0, '', 'dscAmb');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000140, 4000105, '1 - Estabelecimento do próprio empregador;', 'localAmb-1-4000140', false, 0, '1', 'localAmb-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000141, 4000105, '2 - Estabelecimento de terceiros;', 'localAmb-2-4000141', false, 0, '2', 'localAmb-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000142, 4000105, '3 - Prestação de serviços em instalações de terceiros não consideradas como lotações dos tipos 03 a 09 da Tabela 10.', 'localAmb-3-4000142', false, 0, '3', 'localAmb-3');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000144, 4000107, '', 'nrInsc-4000144', true, 0, '', 'nrInsc');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000145, 4000108, '', 'codLotacao-4000145', true, 0, '', 'codLotacao');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000146, 4000106, '', 'tpInsc-4000146', true, 0, '', 'tpInsc');

SQL;
        $this->execute($sql);
    }
}
