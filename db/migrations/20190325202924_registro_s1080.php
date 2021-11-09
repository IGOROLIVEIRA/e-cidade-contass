<?php

use Classes\PostgresMigration;

class RegistroS1080 extends PostgresMigration
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
            'Tabela de Operadores Portuários - S1080',
            'Tabela de Operadores Portuários - S1080',
            'con4_manutencaoformulario001.php?esocial=11',
            1,
            1,
            'Tabela de Operadores Portuários - S1080',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            11,
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
        VALUES(11,'Tabela de Operadores Portuários');

        -- INSERIR FORMULARIO 
        INSERT INTO avaliacao (db101_sequencial, db101_avaliacaotipo, db101_descricao, db101_identificador, db101_obs, db101_ativo, db101_cargadados, db101_permiteedicao) VALUES (4000090, 5, 'FORMULÁRIO S1080 - TABELA DE OPERADORES PORTUÁRIOS V2.5', 'formulario-s1080-v25', 'Versão 2.5 do formulario S1080 do eSocial', true, NULL, false);

        INSERT INTO esocialversaoformulario
        VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),'2.4',4000090,11);

        -- INSERIR GRUPOS DO REGISTRO 1080
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000089, 4000090, 'Informações de identificação do Operador Portuário e validade das informações que estão sendo incluí', 'informacoes-de-identificacao-do-operador-portuario-e-validade-das-informacoes-4000089', 'ideOperPortuario');
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000090, 4000090, 'Detalhamento das informações do Operador Portuário que está sendo incluído.', 'detalhamento-das-informacoes-do-operador-portuario-que-esta-sendo-incluido-4000090', 'dadosOperPortuario');

        -- INSERIR PERGUNTAS DO REGISTRO 1080
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000124, 2, 4000089, 'Preencher com o CNPJ do operador portuário.', 'preencher-o-cnpj-do-operador-portuarario-4000124', true, true, 1, 1, '', 0, true, '', 'cnpjOpPortuario');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000127, 2, 4000090, 'Preencher com a alíquota definida na legislação vigente para a atividade (CNAE) preponderante.', 'aliquota-definida-na-legislacao-CNAE', true, true, 1, 1, '', 0, false, '', 'aliqRat');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000128, 2, 4000090, 'Fator Acidentário de Prevenção - FAP.', 'fator-acidentario-de-prevencao--fap-4000128', true, true, 2, 1, '', 0, false, '', 'fap');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000125, 2, 4000089, 'Preencher com o mês e ano de início da validade das informações prestadas no evento, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-inicio-4000125', true, true, 2, 1, '', 0, false, '', 'iniValid');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000126, 2, 4000089, 'Preencher com o mês e ano de término da validade das informações, se houver, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-termino-4000126', false, true, 3, 1, '', 0, false, '', 'fimValid');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000130, 2, 4000090, 'Alíquota do RAT após ajuste pelo FAP.', 'aliquota-rat-apos-ajuste-pelo-fap-4000130', true, true, 3, 1, '', 0, false, '', 'aliqRatAjust');

        -- INSERIR PERGUNTAS/OPCOES DO REGISTRO 1080
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000189, 4000124, '', 'cnpjOpPortuario-4000189', true, 0, '', 'cnpjOpPortuario');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000193, 4000127, '', 'aliqRat-4000193', true, 0, '', 'aliqRat');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000194, 4000128, '', 'fap-4000194', true, 0, '', 'fap');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000195, 4000130, '', 'aliqRatAjust-4000195', true, 0, '', 'aliqRatAjust');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000196, 4000125, '', 'iniValid-4000196', true, 0, '', 'iniValid');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000197, 4000126, '', 'fimValid-4000197', true, 0, '', 'fimValid');
 
SQL;
        $this->execute($sql);

    }
}
