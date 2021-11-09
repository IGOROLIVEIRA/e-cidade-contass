<?php

use Classes\PostgresMigration;

class RegistroS1040 extends PostgresMigration
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
            'Tabela de Funções/Cargos em Comissão - S1040',
            'Tabela de Funções/Cargos em Comissão - S1040',
            'con4_manutencaoformulario001.php?esocial=7',
            1,
            1,
            'Tabela de Funções/Cargos em Comissão - S1040',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            7,
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
        VALUES(7,
         'Tabela de Funções/Cargos em Comissão');

        /* INSERIR FORMULARIO */
        INSERT INTO avaliacao(db101_sequencial,db101_avaliacaotipo,db101_descricao,db101_identificador,db101_obs,db101_ativo,db101_cargadados,db101_permiteedicao)
        VALUES (4000084,
            5,
            'Formulário S1040 - TABELA DE FUNÇÕES/CARGOS EM COMISSÃO v2.4.02',
            'formulario-s1040-v2402',
            'Versão 2.4.02 do formulario S1040 do eSocial',
            'true',
            'select rh04_codigo as codigofuncao, rh04_descr as descricaofuncao,rh04_cbo as codigocbo from rhcargo',
            'true');

        /* VINCULAR FORMULARIO A VERSAO */
        INSERT INTO esocialversaoformulario
        VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),
         '2.4',
         4000084,
         7);

        /* INSERIR GRUPO IDEFUNCAO DO REGISTRO 1040 */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000071,
            4000084,
            'Informações de identificação da função e validade das informações que estão sendo incluídas',
            'identificacao-da-funcao-e-validade-das-informacoes-que-estao
            sendo-incluidas-4000071',
            'ideFuncao');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000072,
            2,
            4000071,
            'Preencher com o código da função, se utilizado pelo empregador.',
            'codigo-funcao-se-utilizado-pelo-empregador-4000072',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'true',/* Chave do registro */
            'codigofuncao',
            'codFuncao');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000073,
            4000072,
            '',
            'codFuncao-4000073',
            'true',/* Aceita Texto */
            0,
            '',
            'codFuncao');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000074,
            2,
            4000071,
            'Preencher com o mês e ano de início da validade das informações prestadas no evento, no formato AAAA-MM.',
            'preencher-com-o-mes-e-ano-de-inicio-4000074',
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
        VALUES (4000075,
            4000074,
            '',
            'iniValid-4000075',
            'true',
            0,
            '',
            'iniValid');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000076,
            2,
            4000071,
            'Preencher com o mês e ano de término da validade das informações, se houver, no formato AAAA-MM.',
            'preencher-com-o-mes-e-ano-de-termino-4000076',
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
        VALUES (4000077,
            4000076,
            '',
            'fimValid-4000077',
            'true',
            0,
            '',
            'fimValid');

        /* INSERIR GRUPO DADOSFUNCAO DO REGISTRO 1040 */
        INSERT INTO avaliacaogrupopergunta(db102_sequencial,db102_avaliacao,db102_descricao,db102_identificador,db102_identificadorcampo)
        VALUES (4000078,
            4000084,
            'Detalhamento das informações da função que está sendo incluída',
            'detalhamento-das-informacoes-da-funcao-que-esta-sendo-incluida-4000078',
            'dadosFuncao');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000079,
            2,
            4000078,
            'Nome da Função de confiança/Cargo em Comissão.',
            'funcao-de-confianca-cargo-em-comissao-4000079',
            'true',/* Obrigatorio */
            'true',
            1,/* Ordem */
            1,/* Tipo */
            '',/* Mascara */
            0,
            'false',/* Chave do registro */
            'descricaofuncao',
            'dscFuncao');

        INSERT INTO avaliacaoperguntaopcao(db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_identificador,db104_aceitatexto,db104_peso,db104_valorresposta,db104_identificadorcampo)
        VALUES (4000080,
            4000079,
            '',
            'dscFuncao-4000080',
            'true',/* Aceita Texto */
            0,
            '',
            'dscFuncao');

        INSERT INTO avaliacaopergunta(db103_sequencial,db103_avaliacaotiporesposta,db103_avaliacaogrupopergunta,db103_descricao,db103_identificador,db103_obrigatoria,db103_ativo,db103_ordem,db103_tipo,db103_mascara,db103_dblayoutcampo,db103_perguntaidentificadora,db103_camposql,db103_identificadorcampo)
        VALUES (4000081,
            2,
            4000078,
            'Classificação Brasileira de Ocupação - CBO.',
            'classificacao-brasileira-de-ocupacao-cbo-4000081',
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
        VALUES (4000082,
            4000081,
            '',
            'codCBO-4000082',
            'true',/* Aceita Texto */
            0,
            '',
            'codCBO');
SQL;

        $this->execute($sql);
    }
}
