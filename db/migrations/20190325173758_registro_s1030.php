<?php

use Classes\PostgresMigration;

class RegistroS1030 extends PostgresMigration
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
            'Tabela de Cargos - S1030',
            'Tabela de Cargos - S1030',
            'con4_manutencaoformulario001.php?esocial=5',
            1,
            1,
            'Tabela de Cargos - S1030',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            5,
            10216);

SQL;
        $this->execute($sql);
    }

    private function insertLayout() 
    {
        $sql = <<<SQL
        SELECT fc_startsession();

        /* INSERIR TIPO DO FORMULARIO */
        INSERT INTO esocialformulariotipo
        VALUES(5,
         'Tabela de Cargos');

        /* INSERIR FORMULARIO */
        INSERT INTO avaliacao(db101_sequencial,db101_avaliacaotipo,db101_descricao,db101_identificador,db101_obs,db101_ativo,db101_cargadados,db101_permiteedicao)
        VALUES (4000016,
            5,
            'Formulário S1030 - TABELA DE CARGOS v2.4.02',
            'formulario-s1030-v2402',
            'Versão 2.4.02 do formulario S1030 do eSocial',
            'true',
            'select rh37_funcao as codigocargo, rh37_instit as instituicao, rh37_descr as nomecargo, rh37_cbo as codigocbo from rhfuncao where rh37_instit = fc_getsession(\'DB_instit\')::int and rh37_ativo = \'t\'',
            'true');

        /* VINCULAR FORMULARIO A VERSAO */
        INSERT INTO esocialversaoformulario
        VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),
         '2.4',
         4000016,
         5);

        /* INSERIR GRUPO IDECARGO */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000017,
            4000016,
            'Informações de identificação do cargo',
            'informacoes-de-identificacao-do-cargo-4000017',
            'ideCargo');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000018,
            2,
            4000017,
            'Preencher com o código do cargo.',
            'preencher-com-o-codigo-do-cargo-4000018',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'true',/* Chave do registro */
            'codigocargo',
            'codCargo');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000019,
            4000018,
            '',
            'codCargo-4000019',
            'true',/* Aceita Texto */
            0,
            '',
            'codCargo');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000020,
            2,
            4000017,
            'Preencher com o mês e ano de início da validade das informações prestadas no evento, no formato AAAA-MM.',
            'preencher-com-o-mes-e-ano-de-inicio-4000020',
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
        VALUES (4000021,
            4000020,
            '',
            'iniValid-4000021',
            'true',
            0,
            '',
            'iniValid');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000022,
            2,
            4000017,
            'Preencher com o mês e ano de término da validade das informações, se houver, no formato AAAA-MM.',
            'preencher-com-o-mes-e-ano-de-termino-4000022',
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
        VALUES (4000023,
            4000022,
            '',
            'fimValid-4000023',
            'true',
            0,
            '',
            'fimValid');

        /* INSERIR GRUPO DADOSCARGO */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000024,
            4000016,
            'Detalhamento das informações do cargo',
            'detalhamento-das-informacoes-do-cargo-4000024',
            'dadosCargo');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000083,
            2,
            4000024,
            'Instituição no e-Cidade:',
            'instituicao-no-ecidade-4000083',
            'true',
            'true',
            1,
            6,
            '',
            0,
            'true',
            'instituicao',
            'instituicao');


        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000084,
            4000083,
            '',
            'instituicao-4000084',
            'true',
            0,
            '',
            'instituicao');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000025,
            2,
            4000024,
            'Preencher com o nome do cargo.',
            'preencher-com-o-nome-do-cargo-4000025',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            'nomecargo',
            'nmCargo');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000026,
            4000025,
            '',
            'nmCargo-4000026',
            'true',/* Aceita Texto */
            0,
            '',
            'nmCargo');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000027,
            2,
            4000024,
            'Classificação Brasileira de Ocupação - CBO.',
            'classificacao-brasileira-de-ocupacao-cbo-4000027',
            'true',/* Obrigatorio */
            'true',
            2,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            'codigocbo',
            'codCBO');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000028,
            4000027,
            '',
            'codCBO-4000028',
            'true',/* Aceita Texto */
            0,
            '',
            'codCBO');

        /* INSERIR GRUPO CARGOPUBLICO */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000029,
            4000016,
            'Detalhamento de informações exclusivas para Cargos e Empregos Públicos',
            'dados-cargos-e-empregos-publicos-4000029',
            'cargoPublico');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000030,
            1,
            4000029,
            'Preencher com o código correspondente à possibilidade de acumulação de cargos.',
            'codigo-correspondente-acumulacao-de-cargos-4000030',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'acumCargo');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000031,
            4000030,
            'Não acumulável',
            'acumCargo-1-4000031',
            'false',/* Aceita Texto */
            0,
            '1',
            'acumCargo-1');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000032,
            4000030,
            'Profissional de Saúde',
            'acumCargo-2-4000032',
            'false',
            0,
            '2',
            'acumCargo-2');


        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000033,
            4000030,
            'Professor',
            'acumCargo-3-4000033',
            'false',
            0,
            '3',
            'acumCargo-3');


        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000034,
            4000030,
            'Técnico/Científico',
            'acumCargo-4-4000034',
            'false',
            0,
            '4',
            'acumCargo-4');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000035,
            1,
            4000029,
            'Preencher com o código correspondente a possibilidade de contagem de tempo especial.',
            'codigo-contagem-de-tempo especial-4000035',
            'true',/* Obrigatorio */
            'true',
            2,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'contagemEsp');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000036,
            4000035,
            'Não',
            'contagemEsp-1-4000036',
            'false',/* Aceita Texto */
            0,
            '1',
            'contagemEsp-1');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000037,
            4000035,
            'Professor (Infantil, Fundamental e Médio)',
            'contagemEsp-2-4000037',
            'false',
            0,
            '2',
            'contagemEsp-2');


        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000038,
            4000035,
            'Professor de Ensino Superior, Magistrado, Membro de Ministério Público, Membro do Tribunal de Contas (com ingresso anterior a 16/12/1998 EC nr. 20/98)',
            'contagemEsp-3-4000038',
            'false',
            0,
            '3',
            'contagemEsp-3');


        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000039,
            4000035,
            'Atividade de risco',
            'contagemEsp-4-4000039',
            'false',
            0,
            '4',
            'contagemEsp-4');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000040,
            1,
            4000029,
            'Indicar se é cargo de dedicação exclusiva.',
            'cargo-de-dedicacao-exclusiva-4000040',
            'true',/* Obrigatorio */
            'true',
            3,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'dedicExcl');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000041,
            4000040,
            'Sim',
            'dedicExcl-1-4000041',
            'false',/* Aceita Texto */
            0,
            'S',
            'dedicExcl-1');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000042,
            4000040,
            'Não',
            'dedicExcl-2-4000042',
            'false',
            0,
            'N',
            'dedicExcl-2');

        /* INSERIR GRUPO LEICARGO */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000043,
            4000016,
            'Lei que criou/extinguiu/reestruturou o cargo',
            'lei-que-criou-extinguiu-reestruturou-o-cargo-4000043',
            'leiCargo');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000044,
            2,
            4000043,
            'Número da Lei.',
            'numero-da-lei-4000044',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'nrLei');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000045,
            4000044,
            '',
            'nrLei-4000045',
            'true',
            0,
            '',
            'nrLei');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000046,
            2,
            4000043,
            'Data da Lei.',
            'data-da-lei-4000046',
            'true',/* Obrigatorio */
            'true',
            2,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'dtLei');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000047,
            4000046,
            '',
            'dtLei-4000047',
            'true',
            0,
            '',
            'dtLei');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000048,
            1,
            4000043,
            'Situação gerada pela Lei. Preencher com uma das opções.',
            'situacao-gerada-pela-lei-4000048',
            'true',/* Obrigatorio */
            'true',
            3,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            '',
            'sitCargo');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000049,
            4000048,
            'Criação',
            'sitCargo-1-4000049',
            'false',/* Aceita Texto */
            0,
            '1',
            'sitCargo-1');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000050,
            4000048,
            'Extinção',
            'sitCargo-2-4000050',
            'false',
            0,
            '2',
            'sitCargo-2');


        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000051,
            4000048,
            'Reestruturação',
            'sitCargo-3-4000051',
            'false',
            0,
            '3',
            'sitCargo-3');
SQL;
        $this->execute($sql);
    }
}
