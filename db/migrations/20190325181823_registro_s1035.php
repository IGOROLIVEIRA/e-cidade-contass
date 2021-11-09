<?php

use Classes\PostgresMigration;

class RegistroS1035 extends PostgresMigration
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
            'Tabela de Carreiras Públicas - S1035',
            'Tabela de Carreiras Públicas - S1035',
            'con4_manutencaoformulario001.php?esocial=6',
            1,
            1,
            'Tabela de Carreiras Públicas - S1035',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            6,
            10216);

SQL;
        $this->execute($sql);
    }

    private function insertLayout() 
    {
        $sql = <<< SQL

        SELECT fc_startsession();

        /* INSERIR TIPO DO FORMULARIO */
        INSERT INTO esocialformulariotipo
        VALUES(6,
         'Tabela de Carreiras Públicas');

        /* INSERIR FORMULARIO */
        INSERT INTO avaliacao(db101_sequencial,db101_avaliacaotipo,db101_descricao,db101_identificador,db101_obs,db101_ativo,db101_cargadados,db101_permiteedicao)
        VALUES (4000083,
            5,
            'Formulário S1035 - TABELA DE CARREIRAS PÚBLICAS v2.4.02',
            'formulario-s1035-v2402',
            'Versão 2.4.02 do formulario S1035 do eSocial',
            'true',
            '',
            'true');

        /* VINCULAR FORMULARIO A VERSAO */
        INSERT INTO esocialversaoformulario
        VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),
         '2.4',
         4000083,
         6);

        /* INSERIR GRUPO IDECARREIRA DO REGISTRO 1035 */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000052,
            4000083,
            'Informações de identificação da Carreira e validade das informações que estão sendo incluídas',
            'identificacao-da-carreira-e-validade-das-informacoes-que estao-sendo-incluidas-4000052',
            'ideCarreira');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000053,
            2,
            4000052,
            'Preencher com o código carreira pública.',
            'preencher-com-o-codigo-carreira-publica-4000053',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'codCarreira');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000054,
            4000053,
            '',
            'codCarreira-4000054',
            'true',/* Aceita Texto */
            0,
            '',
            'codCarreira');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000055,
            2,
            4000052,
            'Preencher com o mês e ano de início da validade das informações prestadas no evento, no formato AAAA-MM.',
            'preencher-com-o-mes-e-ano-de-inicio-4000055',
            'true',
            'true',
            2,
            1,
            '',
            0,
            'false',
            '',
            'iniValid');
        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000056,
            4000055,
            '',
            'iniValid-4000056',
            'true',
            0,
            '',
            'iniValid');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000057,
            2,
            4000052,
            'Preencher com o mês e ano de término da validade das informações, se houver, no formato AAAA-MM.',
            'preencher-com-o-mes-e-ano-de-termino-4000057',
            'false',
            'true',
            3,
            1,
            '',
            0,
            'false',
            '',
            'fimValid');


        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000058,
            4000057,
            '',
            'fimValid-4000058',
            'true',
            0,
            '',
            'fimValid');

        /* INSERIR GRUPO DADOSCARREIRA DO REGISTRO 1035 */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000059,
            4000083,
            'Detalhamento das informações da Carreira que está sendo incluída',
            'detalhamento-das-informacoes-da-carreira-que-esta-sendo-incluida-4000059',
            'dadosCarreira');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000060,
            2,
            4000059,
            'Descrição da Carreira Pública.',
            'descricao-da-carreira-publica-4000060',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'dscCarreira');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000062,
            4000060,
            '',
            'dscCarreira-4000062',
            'true',/* Aceita Texto */
            0,
            '',
            'dscCarreira');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000063,
            2,
            4000059,
            'Lei que criou a Carreira.',
            'lei-que-criou-a-carreira-4000063',
            'false',/* Obrigatorio */
            'true',
            2,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'leiCarr');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000064,
            4000063,
            '',
            'leiCarr-4000064',
            'true',
            0,
            '',
            'leiCarr');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000065,
            2,
            4000059,
            'Data da Lei que criou a Carreira.',
            'data-da-lei-que-criou-a-carreira-4000065',
            'true',/* Obrigatorio */
            'true',
            3,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'dtLeiCarr');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000066,
            4000065,
            '',
            'dtLeiCarr-4000066',
            'true',
            0,
            '',
            'dtLeiCarr');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000067,
            1,
            4000059,
            'Situação gerada pela Lei. Preencher com uma das opções.',
            'situacao-gerada-pela-lei-4000067',
            'true',/* Obrigatorio */
            'true',
            4,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'sitCarr');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000068,
            4000067,
            'Criação',
            'sitCarr-1-4000068',
            'false',/* Aceita Texto */
            0,
            '1',
            'sitCarr-1');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000069,
            4000067,
            'Extinção',
            'sitCarr-2-4000069',
            'false',
            0,
            '2',
            'sitCarr-2');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000070,
            4000067,
            'Reestruturação',
            'sitCarr-3-4000070',
            'false',
            0,
            '3',
            'sitCarr-3');
SQL;

        $this->execute($sql);
    }
}
