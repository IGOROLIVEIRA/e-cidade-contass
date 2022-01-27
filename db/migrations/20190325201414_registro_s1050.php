<?php

use Classes\PostgresMigration;

class RegistroS1050 extends PostgresMigration
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
            'Tabela de Horários/Turnos de Trabalho - S1050',
            'Tabela de Horários/Turnos de Trabalho - S1050',
            'con4_manutencaoformulario001.php?esocial=8',
            1,
            1,
            'Tabela de Horários/Turnos de Trabalho - S1050',
            't');

        INSERT INTO db_menu 
        VALUES (10466,
            (SELECT MAX(id_item) FROM db_itensmenu),
            8,
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
        VALUES(8,'Tabela de Horarios/Turnos de Trabalho');

        -- INSERIR FORMULARIO 
        INSERT INTO avaliacao (db101_sequencial, db101_avaliacaotipo, db101_descricao, db101_identificador, db101_obs, db101_ativo, db101_cargadados, db101_permiteedicao) VALUES (4000086, 5, 'FORMULÁRIO S1050 - TABELA DE HORÁRIOS/TURNOS DE TRABALHO V2.4.02', 'formulario-s1050-v2402', 'Versão 2.4.02 do formulario S1050 do eSocial', true, 'SELECT rh188_sequencial AS codigohorario,

            (SELECT replace(rh189_hora::varchar,\':\',\'\')
            FROM jornadahoras
            WHERE rh189_tiporegistro = 1
            AND jornadahoras.rh189_jornada = jornada.rh188_sequencial) AS horarioentrada,

            (SELECT replace(rh189_hora::varchar,\':\',\'\')
            FROM jornadahoras
            WHERE (rh189_tiporegistro = 4 OR rh189_tiporegistro = 2)
            AND jornadahoras.rh189_jornada = jornada.rh188_sequencial
            ORDER BY rh189_tiporegistro DESC LIMIT 1) AS horariosaida,

            (SELECT split_part(((horatotal-horaintevalo)*60)::varchar,\':\',1) AS duracao
            FROM
            (SELECT sum(CASE
            WHEN rh189_tiporegistro = 4 THEN rh189_hora::interval
            WHEN rh189_tiporegistro = 1 THEN rh189_hora::interval*-1
            END) AS horatotal,
            sum(CASE
            WHEN rh189_tiporegistro = 3 THEN rh189_hora::interval
            WHEN rh189_tiporegistro = 2 THEN rh189_hora::interval*-1
            END) AS horaintevalo
            FROM jornadahoras
            WHERE jornadahoras.rh189_jornada = jornada.rh188_sequencial) AS x) AS duracaojornada,

            (SELECT split_part((sum(CASE
            WHEN rh189_tiporegistro = 3 THEN rh189_hora::interval
            WHEN rh189_tiporegistro = 2 THEN rh189_hora::interval*-1
            END)*60)::varchar,\':\',1) AS horaintevalo
            FROM jornadahoras
            WHERE EXISTS (SELECT * FROM jornadahoras jh 
            WHERE jh.rh189_jornada = jornada.rh188_sequencial 
            AND jh.rh189_tiporegistro = 3)
            AND jornadahoras.rh189_jornada = jornada.rh188_sequencial) AS duracaointervalo,

            (SELECT replace(rh189_hora::varchar,\':\',\'\')
            FROM jornadahoras
            WHERE rh189_tiporegistro = 2
            AND EXISTS (SELECT * FROM jornadahoras jh 
            WHERE jh.rh189_jornada = jornada.rh188_sequencial 
            AND jh.rh189_tiporegistro = 3)
            AND jornadahoras.rh189_jornada = jornada.rh188_sequencial) AS iniciointerv,

            (SELECT replace(rh189_hora::varchar,\':\',\'\')
            FROM jornadahoras
            WHERE rh189_tiporegistro = 3 
            AND EXISTS (SELECT * FROM jornadahoras jh 
            WHERE jh.rh189_jornada = jornada.rh188_sequencial 
            AND jh.rh189_tiporegistro = 2)
            AND jornadahoras.rh189_jornada = jornada.rh188_sequencial) AS terminointerv
            FROM jornada
            WHERE
            (SELECT count(*)
            FROM jornadahoras
            WHERE jornadahoras.rh189_jornada = jornada.rh188_sequencial) >= 2', true);

        INSERT INTO esocialversaoformulario
        VALUES(nextval('esocialversaoformulario_rh211_sequencial_seq'),'2.4',4000086,8);

        -- INSERIR GRUPOS DO REGISTRO 1050
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000080, 4000086, 'Grupo de informações de identificação do horário contratual', 'grupo-de-informacoes-de-identificacao-do-horario-contratual-4000080', 'ideHorContratual');
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000082, 4000086, 'Registro que detalha os intervalos para a jornada. Obrigatório se existir ao menos um intervalo.', 'registro-que-detalha-os-intervalos-para-a-jornada-4000082', 'horarioIntervalo');
        INSERT INTO avaliacaogrupopergunta (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo) VALUES (4000081, 4000086, 'Detalhamento das informações do horário contratual que está sendo incluído.', 'detalhamento-informacoes-do-horario-contratual-que-esta-sendo-incluido-4000081', 'dadosHorContratual');

        -- INSERIR PERGUNTAS DO REGISTRO 1050
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000087, 2, 4000080, 'Preencher com o mês e ano de início da validade das informações prestadas no evento, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-inicio-4000087', true, true, 2, 1, '', 0, false, '', 'iniValid');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000093, 1, 4000082, 'Tipo de Intervalo da Jornada:', 'tipo-de-intervalo-da-jornada-4000093', true, true, 1, 1, '', 0, false, '', 'tpInterv');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000092, 1, 4000081, 'Indicar se é permitida a flexibilidade:', 'indicar-se-e-permitida-a-flexibilidade-4000092', true, true, 4, 1, '', 0, false, '', 'perHorFlexivel');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000090, 2, 4000081, 'Informar hora da saída, no formato HHMM.', 'informar-hora-da-saida-no-formato-hhmm-4000090', true, true, 2, 1, '', 0, false, 'horariosaida', 'hrSaida');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000091, 2, 4000081, 'Preencher com o tempo de duração da jornada, em minutos.', 'preencher-tempo-de-duracao-da-jornada-4000091', true, true, 3, 1, '', 0, false, 'duracaojornada', 'durJornada');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000088, 2, 4000080, 'Preencher com o mês e ano de término da validade das informações, se houver, no formato AAAA-MM.', 'preencher-com-o-mes-e-ano-de-termino-4000088', false, true, 3, 1, '', 0, false, '', 'fimValid');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000085, 2, 4000080, 'Preencher com o código atribuído pela empresa para o Horário Contratual.', 'cod-atribuido-empresa-horario-contratual-4000085', true, true, 1, 1, '', 0, true, 'codigohorario', 'codHorContrat');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000089, 2, 4000081, 'Informar hora da entrada, no formato HHMM.', 'informar-hora-da-entrada-no-formato-hhmm-4000089', true, true, 1, 1, '', 0, false, 'horarioentrada', 'hrEntr');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000094, 2, 4000082, 'Preencher com o tempo de duração do intervalo, em minutos.', 'preencher-tempo-de-duracao-do-intervalo-4000094', true, true, 2, 6, '', 0, false, 'duracaointervalo', 'durInterv');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000095, 2, 4000082, 'informar a hora de início do intervalo, no formato HHMM.', 'informar-a-hora-de-inicio-do-intervalo-4000095', false, true, 3, 1, '', 0, false, 'iniciointerv', 'iniInterv');
        INSERT INTO avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_identificador, db103_obrigatoria, db103_ativo, db103_ordem, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES (4000096, 2, 4000082, 'Informar a hora de termino do intervalo, no formato HHMM.', 'informar-a-hora-de-termino-do-intervalo-4000096', false, true, 4, 1, '', 0, false, 'terminointerv', 'termInterv');

        -- INSERIR PERGUNTAS/OPCOES DO REGISTRO 1050
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000108, 4000087, '', 'iniValid-4000108', true, 0, NULL, 'iniValid');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000109, 4000088, '', 'fimValid-4000109', true, 0, NULL, 'fimValid');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000113, 4000092, 'Sim', 'perHorFlexivel-1-4000113', false, 0, 'S', 'perHorFlexivel-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000114, 4000092, 'Não', 'perHorFlexivel-2-4000114', false, 0, 'N', 'perHorFlexivel-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000115, 4000093, 'Intervalo em Horário Fixo', 'tpInterv-1-4000115', false, 0, '1', 'tpInterv-1');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000116, 4000093, 'Intervalo em Horário Variável', 'tpInterv-2-4000116', false, 0, '2', 'tpInterv-2');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000125, 4000085, '', 'codHorContrat-4000125', true, 0, '', 'codHorContrat');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000126, 4000089, '', 'hrEntr-4000126', true, 0, '', 'hrEntr');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000127, 4000090, '', 'hrSaida-4000127', true, 0, '', 'hrSaida');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000128, 4000091, '', 'durJornada-4000128', true, 0, '', 'durJornada');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000129, 4000094, '', 'durInterv-4000129', true, 0, '', 'durInterv');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000130, 4000095, '', 'iniInterv-4000130', true, 0, '', 'iniInterv');
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_identificador, db104_aceitatexto, db104_peso, db104_valorresposta, db104_identificadorcampo) VALUES (4000131, 4000096, '', 'termInterv-4000131', true, 0, '', 'termInterv');
SQL;

        $this->execute($sql);
    }
}
