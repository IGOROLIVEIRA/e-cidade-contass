<?php

use Phinx\Migration\AbstractMigration;

class Addmenunperiodicos extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Não Periodicos','Carga de dados Não Periodicos','con4_cargaformularioseventosnaoperiodicos.php',1,1,'Não Periodicos','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao = 'Carga de Dados'),(select max(id_item) from db_itensmenu),2,10216);

            update avaliacaopergunta ap set  db103_camposql = (select lower(db103_identificadorcampo) from avaliacao
            left join avaliacaogrupopergunta               on  db102_avaliacao    = db101_sequencial
            left join avaliacaopergunta  on  db103_avaliacaogrupopergunta = db102_sequencial
            where db102_avaliacao = '4000102' and avaliacaopergunta.db103_sequencial = ap.db103_sequencial);

        -- Auto-generated SQL script #202201060809
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_identificador='dependente-1',db102_identificadorcampo='dependente 1',db102_descricao='Dependente 1'
            WHERE db102_sequencial=4000194;

        -- Auto-generated SQL script #202201060855
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='informar-se-o-dependente-tem-incapacidad-1'
            WHERE db103_sequencial=4000595;
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='informar-se-e-dependente-para-fins-de-re-1'
            WHERE db103_sequencial=4000594;
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='informar-se-e-dependente-do-trabalhador--1'
            WHERE db103_sequencial=4000593;
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='sexo-do-dependente-1'
            WHERE db103_sequencial=4000592;
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='numero-de-inscricao-no-cpf-1'
            WHERE db103_sequencial=4000591;
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='preencher-com-data-de-nascimento-1'
            WHERE db103_sequencial=4000590;
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='nome-do-dependente-1'
            WHERE db103_sequencial=4000589;
        UPDATE habitacao.avaliacaopergunta
            SET db103_identificador='tipo-de-dependente-1'
            WHERE db103_sequencial=4000588;


        -- Auto-generated SQL script #202201060824
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='inctrab1'
            WHERE db103_sequencial=4000595;
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='depsf1'
            WHERE db103_sequencial=4000594;
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='depirrf1'
            WHERE db103_sequencial=4000593;
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='sexodep1'
            WHERE db103_sequencial=4000592;
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='cpfdep1'
            WHERE db103_sequencial=4000591;
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='dtnascto1'
            WHERE db103_sequencial=4000590;
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='nmdep1'
            WHERE db103_sequencial=4000589;
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='tpdep1'
            WHERE db103_sequencial=4000588;


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 2', 'dependente-2', 'dependente 2', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-2', 1, '', 0, false, 'inctrab2', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-2', 1, '', 0, false, 'depsf2', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--2', 1, '', 0, false, 'depirrf2', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-2', 1, '', 0, false, 'sexodep2', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-2', 4, '', 0, false, 'cpfdep2', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-2', 5, '', 0, false, 'dtnascto2', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-2', 1, '', 0, false, 'nmdep2', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-2', 1, '', 0, false, 'tpdep2', 'tpDep');


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 3', 'dependente-3', 'dependente 3', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-3', 1, '', 0, false, 'inctrab3', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-3', 1, '', 0, false, 'depsf3', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--3', 1, '', 0, false, 'depirrf3', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-3', 1, '', 0, false, 'sexodep3', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-3', 4, '', 0, false, 'cpfdep3', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-3', 5, '', 0, false, 'dtnascto3', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-3', 1, '', 0, false, 'nmdep3', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-3', 1, '', 0, false, 'tpdep3', 'tpDep');


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 4', 'dependente-4', 'dependente 4', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-4', 1, '', 0, false, 'inctrab4', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-4', 1, '', 0, false, 'depsf4', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--4', 1, '', 0, false, 'depirrf4', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-4', 1, '', 0, false, 'sexodep4', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-4', 4, '', 0, false, 'cpfdep4', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-4', 5, '', 0, false, 'dtnascto4', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-4', 1, '', 0, false, 'nmdep4', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-4', 1, '', 0, false, 'tpdep4', 'tpDep');

        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 5', 'dependente-5', 'dependente 5', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-5', 1, '', 0, false, 'inctrab5', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-5', 1, '', 0, false, 'depsf5', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--5', 1, '', 0, false, 'depirrf5', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-5', 1, '', 0, false, 'sexodep5', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-5', 4, '', 0, false, 'cpfdep5', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-5', 5, '', 0, false, 'dtnascto5', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-5', 1, '', 0, false, 'nmdep5', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-5', 1, '', 0, false, 'tpdep5', 'tpDep');


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 6', 'dependente-6', 'dependente 6', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-6', 1, '', 0, false, 'inctrab6', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-6', 1, '', 0, false, 'depsf6', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--6', 1, '', 0, false, 'depirrf6', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-6', 1, '', 0, false, 'sexodep6', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-6', 4, '', 0, false, 'cpfdep6', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-6', 5, '', 0, false, 'dtnascto6', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-6', 1, '', 0, false, 'nmdep6', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-6', 1, '', 0, false, 'tpdep6', 'tpDep');


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 7', 'dependente-7', 'dependente 7', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-7', 1, '', 0, false, 'inctrab7', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-7', 1, '', 0, false, 'depsf7', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--7', 1, '', 0, false, 'depirrf7', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-7', 1, '', 0, false, 'sexodep7', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-7', 4, '', 0, false, 'cpfdep7', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-7', 5, '', 0, false, 'dtnascto7', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-7', 1, '', 0, false, 'nmdep7', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-7', 1, '', 0, false, 'tpdep7', 'tpDep');


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 8', 'dependente-8', 'dependente 8', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-8', 1, '', 0, false, 'inctrab8', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-8', 1, '', 0, false, 'depsf8', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--8', 1, '', 0, false, 'depirrf8', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-8', 1, '', 0, false, 'sexodep8', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-8', 4, '', 0, false, 'cpfdep8', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-8', 5, '', 0, false, 'dtnascto8', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-8', 1, '', 0, false, 'nmdep8', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-8', 1, '', 0, false, 'tpdep8', 'tpDep');


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 9', 'dependente-9', 'dependente 9', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-9', 1, '', 0, false, 'inctrab9', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-9', 1, '', 0, false, 'depsf9', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--9', 1, '', 0, false, 'depirrf9', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-9', 1, '', 0, false, 'sexodep9', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-9', 4, '', 0, false, 'cpfdep9', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-9', 5, '', 0, false, 'dtnascto9', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-9', 1, '', 0, false, 'nmdep9', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-9', 1, '', 0, false, 'tpdep9', 'tpDep');


        INSERT INTO habitacao.avaliacaogrupopergunta
        (db102_sequencial, db102_avaliacao, db102_descricao, db102_identificador, db102_identificadorcampo, db102_ordem)
        VALUES((select max(db102_sequencial)+1 from habitacao.avaliacaogrupopergunta), 4000102, 'Dependente 10', 'dependente-10', 'dependente 10', 0);

        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se o dependente tem incapacidade física ou mental para o trabalho:', true, true, 8, 'informar-se-o-dependente-tem-incapacidad-10', 1, '', 0, false, 'inctrab10', 'incTrab');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente para fins de recebimento do benefício de salário-família:', true, true, 7, 'informar-se-e-dependente-para-fins-de-re-10', 1, '', 0, false, 'depsf10', 'depSF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda:', true, true, 6, 'informar-se-e-dependente-do-trabalhador--10', 1, '', 0, false, 'depirrf10', 'depIRRF');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Sexo do dependente:', false, true, 5, 'sexo-do-dependente-10', 1, '', 0, false, 'sexodep10', 'sexoDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Número de Inscrição no CPF', false, true, 4, 'numero-de-inscricao-no-cpf-10', 4, '', 0, false, 'cpfdep10', 'cpfDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Preencher com a data de nascimento', true, true, 3, 'preencher-com-data-de-nascimento-10', 5, '', 0, false, 'dtnascto10', 'dtNascto');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 2, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Nome do dependente', true, true, 2, 'nome-do-dependente-10', 1, '', 0, false, 'nmdep10', 'nmDep');
        INSERT INTO habitacao.avaliacaopergunta
        (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES((select max(db103_sequencial)+1 from habitacao.avaliacaopergunta), 1, (select max(db102_sequencial) from habitacao.avaliacaogrupopergunta), 'Tipo de dependente', true, true, 1, 'tipo-de-dependente-10', 1, '', 0, false, 'tpdep10', 'tpDep');



        -- Auto-generated SQL script #202201041557
        UPDATE habitacao.avaliacaopergunta
            SET db103_tipo=2
            WHERE db103_sequencial=4000645;

        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='tplograd2'
            WHERE db103_sequencial=4000645;

        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='codmunic2'
            WHERE db103_sequencial=4000651;

        -- Auto-generated SQL script #202201041742
        UPDATE habitacao.avaliacaopergunta
            SET db103_obrigatoria=false
            WHERE db103_sequencial=4000651;

        -- Auto-generated SQL script #202201041809
        UPDATE habitacao.avaliacaopergunta
            SET db103_avaliacaotiporesposta=2,db103_tipo=8
            WHERE db103_sequencial=4000632;

        -- Auto-generated SQL script #202201041810
        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='uf2'
            WHERE db103_sequencial=4000652;

        -- Auto-generated SQL script #202201041814
        UPDATE habitacao.avaliacaopergunta
            SET db103_obrigatoria=false
            WHERE db103_sequencial=4000652;

        -- Auto-generated SQL script #202201061009
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=1
            WHERE db102_sequencial=4000201;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=2
            WHERE db102_sequencial=4000202;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=3
            WHERE db102_sequencial=4000203;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=4
            WHERE db102_sequencial=4000204;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=5
            WHERE db102_sequencial=4000205;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=6
            WHERE db102_sequencial=4000206;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=7
            WHERE db102_sequencial=4000207;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=8
            WHERE db102_sequencial=4000208;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=9
            WHERE db102_sequencial=4000209;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=10
            WHERE db102_sequencial=4000210;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=11
            WHERE db102_sequencial=4000211;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=12
            WHERE db102_sequencial=4000212;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=13
            WHERE db102_sequencial=4000213;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=35
            WHERE db102_sequencial=4000447;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=14
            WHERE db102_sequencial=4000214;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=15
            WHERE db102_sequencial=4000215;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=16
            WHERE db102_sequencial=4000216;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=17
            WHERE db102_sequencial=4000217;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=18
            WHERE db102_sequencial=4000218;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=19
            WHERE db102_sequencial=4000190;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=20
            WHERE db102_sequencial=4000191;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=21
            WHERE db102_sequencial=4000192;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=22
            WHERE db102_sequencial=4000193;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=23
            WHERE db102_sequencial=4000195;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=24
            WHERE db102_sequencial=4000196;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=25
            WHERE db102_sequencial=4000197;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=26
            WHERE db102_sequencial=4000194;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=36
            WHERE db102_sequencial=4000198;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=37
            WHERE db102_sequencial=4000199;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=38
            WHERE db102_sequencial=4000200;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=27
            WHERE db102_sequencial=4000439;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=28
            WHERE db102_sequencial=4000440;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=29
            WHERE db102_sequencial=4000441;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=30
            WHERE db102_sequencial=4000442;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=31
            WHERE db102_sequencial=4000443;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=32
            WHERE db102_sequencial=4000444;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=33
            WHERE db102_sequencial=4000445;
        UPDATE habitacao.avaliacaogrupopergunta
            SET db102_ordem=34
            WHERE db102_sequencial=4000446;


        -- Auto-generated SQL script #202201061017
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 2'
            WHERE db103_sequencial=4001516;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 2'
            WHERE db103_sequencial=4001515;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 2'
            WHERE db103_sequencial=4001514;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 2'
            WHERE db103_sequencial=4001513;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 2:'
            WHERE db103_sequencial=4001512;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 2:'
            WHERE db103_sequencial=4001511;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 2:'
            WHERE db103_sequencial=4001510;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 2:'
            WHERE db103_sequencial=4001509;

        -- Auto-generated SQL script #202201061019
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 3'
            WHERE db103_sequencial=4001524;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 3'
            WHERE db103_sequencial=4001523;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 3'
            WHERE db103_sequencial=4001522;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 3'
            WHERE db103_sequencial=4001521;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 3:'
            WHERE db103_sequencial=4001520;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 3:'
            WHERE db103_sequencial=4001519;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 3:'
            WHERE db103_sequencial=4001518;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 3:'
            WHERE db103_sequencial=4001517;

        -- Auto-generated SQL script #202201061020
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 4'
            WHERE db103_sequencial=4001532;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 4'
            WHERE db103_sequencial=4001531;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 4'
            WHERE db103_sequencial=4001530;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 4'
            WHERE db103_sequencial=4001529;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 4:'
            WHERE db103_sequencial=4001528;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 4:'
            WHERE db103_sequencial=4001527;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 4:'
            WHERE db103_sequencial=4001526;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 4:'
            WHERE db103_sequencial=4001525;

        -- Auto-generated SQL script #202201061021
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 5'
            WHERE db103_sequencial=4001540;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 5'
            WHERE db103_sequencial=4001539;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 5'
            WHERE db103_sequencial=4001538;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 5'
            WHERE db103_sequencial=4001537;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 5:'
            WHERE db103_sequencial=4001536;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 5:'
            WHERE db103_sequencial=4001535;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 5:'
            WHERE db103_sequencial=4001534;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 5:'
            WHERE db103_sequencial=4001533;

        -- Auto-generated SQL script #202201061022
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 6'
            WHERE db103_sequencial=4001548;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 6'
            WHERE db103_sequencial=4001547;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 6'
            WHERE db103_sequencial=4001546;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 6'
            WHERE db103_sequencial=4001545;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 6:'
            WHERE db103_sequencial=4001544;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 6:'
            WHERE db103_sequencial=4001543;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 6:'
            WHERE db103_sequencial=4001542;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 6:'
            WHERE db103_sequencial=4001541;

        -- Auto-generated SQL script #202201061027
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 7'
            WHERE db103_sequencial=4001556;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 7'
            WHERE db103_sequencial=4001555;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 7'
            WHERE db103_sequencial=4001554;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 7'
            WHERE db103_sequencial=4001553;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 7:'
            WHERE db103_sequencial=4001552;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 7:'
            WHERE db103_sequencial=4001551;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 7:'
            WHERE db103_sequencial=4001550;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 7:'
            WHERE db103_sequencial=4001549;

        -- Auto-generated SQL script #202201061028
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 8'
            WHERE db103_sequencial=4001564;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 8'
            WHERE db103_sequencial=4001563;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 8'
            WHERE db103_sequencial=4001562;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 8'
            WHERE db103_sequencial=4001561;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 8:'
            WHERE db103_sequencial=4001560;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 8:'
            WHERE db103_sequencial=4001559;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 8:'
            WHERE db103_sequencial=4001558;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 8:'
            WHERE db103_sequencial=4001557;

        -- Auto-generated SQL script #202201061029
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 9'
            WHERE db103_sequencial=4001572;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 9'
            WHERE db103_sequencial=4001571;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 9'
            WHERE db103_sequencial=4001570;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 9'
            WHERE db103_sequencial=4001569;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 9:'
            WHERE db103_sequencial=4001568;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 9:'
            WHERE db103_sequencial=4001567;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 9:'
            WHERE db103_sequencial=4001566;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 9:'
            WHERE db103_sequencial=4001565;

        -- Auto-generated SQL script #202201061030
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Tipo de dependente 10'
            WHERE db103_sequencial=4001580;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Nome do dependente 10'
            WHERE db103_sequencial=4001579;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Preencher com a data de nascimento 10'
            WHERE db103_sequencial=4001578;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Número de Inscrição no CPF 10'
            WHERE db103_sequencial=4001577;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Sexo do dependente 10:'
            WHERE db103_sequencial=4001576;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente do trabalhador para fins de dedução de seu rendimento tributável pelo Imposto de Renda 10:'
            WHERE db103_sequencial=4001575;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se é dependente para fins de recebimento do benefício de salário-família 10:'
            WHERE db103_sequencial=4001574;
        UPDATE habitacao.avaliacaopergunta
            SET db103_descricao='Informar se o dependente tem incapacidade física ou mental para o trabalho 10:'
            WHERE db103_sequencial=4001573;

        --2
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002808, 4001516, '01 - Cônjuge', false, '01-conjuge-4002808', 0, '01', 'tpDep_01'),
            (4002809, 4001516, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002809', 0, '02', 'tpDep_02'),
            (4002810, 4001516, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002810',0,'03','tpDep_03'),
            (4002811, 4001516, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002811', 0, '04', 'tpDep_04'),
            (4002812, 4001516, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002812', 0, '06', 'tpDep_06'),
            (4002813, 4001516, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002813', 0, '07', 'tpDep_07'),
            (4002814, 4001516, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002814', 0, '09', 'tpDep_09'),
            (4002815, 4001516, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002815', 0, '10', 'tpDep_10'),
            (4002816, 4001516, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002816', 0, '11', 'tpDep_11'),
            (4002817, 4001516, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002817', 0, '12', 'tpDep_12'),
            (4002818, 4001516, '99 - Agregado/Outros', false, '99-outros-4002818', 0, '99', 'tpDep_99'),
            (4002819, 4001515, '', true, 'nmDep-4002819', 0, '', 'nmDep'),
            (4002820, 4001514, '', true, 'dtNascto-4002820', 0, '', 'dtNascto'),
            (4002821, 4001513, '', true, 'cpfDep-4002821', 0, '', 'cpfDep'),
            (4002822, 4001512, 'M - Masculino',false,'m-masculino-4002822',0,'M','sexoDep_m'),
            (4002823, 4001512, 'F - Feminino', false, 'f-feminino-4002823', 0, 'F', 'sexoDep_f'),
            (4002824, 4001511, 'S - Sim',false,'s-sim-4002824',0,'S','depIRRF_s'),
            (4002825, 4001511, 'N - Não', false, 'n-nao-4002825', 0, 'N', 'depIRRF_n'),
            (4002826, 4001510, 'S - Sim',false,'s-sim-4002826',0,'S','depSF_s'),
            (4002827, 4001510, 'N - Não', false, 'n-nao-4002827', 0, 'N', 'depSF_n'),
            (4002828, 4001509, 'N - Não',false,'n-nao-4002828',0,'N','incTrab_n'),
            (4002829, 4001509, 'S - Sim', false, 's-sim-4002829', 0, 'S', 'incTrab_s');

        --3
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002830, 4001524, '01 - Cônjuge', false, '01-conjuge-4002830', 0, '01', 'tpDep_01'),
            (4002831, 4001524, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002831', 0, '02', 'tpDep_02'),
            (4002832, 4001524, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002832',0,'03','tpDep_03'),
            (4002833, 4001524, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002833', 0, '04', 'tpDep_04'),
            (4002834, 4001524, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002834', 0, '06', 'tpDep_06'),
            (4002835, 4001524, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002835', 0, '07', 'tpDep_07'),
            (4002836, 4001524, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002836', 0, '09', 'tpDep_09'),
            (4002837, 4001524, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002837', 0, '10', 'tpDep_10'),
            (4002838, 4001524, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002838', 0, '11', 'tpDep_11'),
            (4002839, 4001524, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002839', 0, '12', 'tpDep_12'),
            (4002840, 4001524, '99 - Agregado/Outros', false, '99-outros-4002840', 0, '99', 'tpDep_99'),
            (4002841, 4001523, '', true, 'nmDep-4002841', 0, '', 'nmDep'),
            (4002842, 4001522, '', true, 'dtNascto-4002842', 0, '', 'dtNascto'),
            (4002843, 4001521, '', true, 'cpfDep-4002843', 0, '', 'cpfDep'),
            (4002844, 4001520, 'M - Masculino',false,'m-masculino-4002844',0,'M','sexoDep_m'),
            (4002845, 4001520, 'F - Feminino', false, 'f-feminino-4002845', 0, 'F', 'sexoDep_f'),
            (4002846, 4001519, 'S - Sim',false,'s-sim-4002846',0,'S','depIRRF_s'),
            (4002847, 4001519, 'N - Não', false, 'n-nao-4002847', 0, 'N', 'depIRRF_n'),
            (4002848, 4001518, 'S - Sim',false,'s-sim-4002848',0,'S','depSF_s'),
            (4002849, 4001518, 'N - Não', false, 'n-nao-4002849', 0, 'N', 'depSF_n'),
            (4002850, 4001517, 'N - Não',false,'n-nao-4002850',0,'N','incTrab_n'),
            (4002851, 4001517, 'S - Sim', false, 's-sim-4002851', 0, 'S', 'incTrab_s');

        --4
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002852, 4001532, '01 - Cônjuge', false, '01-conjuge-40028252', 0, '01', 'tpDep_01'),
            (4002853, 4001532, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002853', 0, '02', 'tpDep_02'),
            (4002854, 4001532, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002854',0,'03','tpDep_03'),
            (4002855, 4001532, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002855', 0, '04', 'tpDep_04'),
            (4002856, 4001532, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002856', 0, '06', 'tpDep_06'),
            (4002857, 4001532, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002857', 0, '07', 'tpDep_07'),
            (4002858, 4001532, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002858', 0, '09', 'tpDep_09'),
            (4002859, 4001532, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002859', 0, '10', 'tpDep_10'),
            (4002860, 4001532, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002860', 0, '11', 'tpDep_11'),
            (4002861, 4001532, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002861', 0, '12', 'tpDep_12'),
            (4002862, 4001532, '99 - Agregado/Outros', false, '99-outros-4002862', 0, '99', 'tpDep_99'),
            (4002863, 4001531, '', true, 'nmDep-4002863', 0, '', 'nmDep'),
            (4002864, 4001530, '', true, 'dtNascto-4002864', 0, '', 'dtNascto'),
            (4002865, 4001529, '', true, 'cpfDep-4002865', 0, '', 'cpfDep'),
            (4002866, 4001528, 'M - Masculino',false,'m-masculino-4002866',0,'M','sexoDep_m'),
            (4002867, 4001528, 'F - Feminino', false, 'f-feminino-4002867', 0, 'F', 'sexoDep_f'),
            (4002868, 4001527, 'S - Sim',false,'s-sim-4002868',0,'S','depIRRF_s'),
            (4002869, 4001527, 'N - Não', false, 'n-nao-4002869', 0, 'N', 'depIRRF_n'),
            (4002870, 4001526, 'S - Sim',false,'s-sim-4002870',0,'S','depSF_s'),
            (4002871, 4001526, 'N - Não', false, 'n-nao-4002871', 0, 'N', 'depSF_n'),
            (4002872, 4001525, 'N - Não',false,'n-nao-4002872',0,'N','incTrab_n'),
            (4002873, 4001525, 'S - Sim', false, 's-sim-4002873', 0, 'S', 'incTrab_s');
        --5
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002874, 4001540, '01 - Cônjuge', false, '01-conjuge-4002874', 0, '01', 'tpDep_01'),
            (4002875, 4001540, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002875', 0, '02', 'tpDep_02'),
            (4002876, 4001540, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002876',0,'03','tpDep_03'),
            (4002877, 4001540, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002877', 0, '04', 'tpDep_04'),
            (4002878, 4001540, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002878', 0, '06', 'tpDep_06'),
            (4002879, 4001540, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002879', 0, '07', 'tpDep_07'),
            (4002880, 4001540, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002880', 0, '09', 'tpDep_09'),
            (4002881, 4001540, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002881', 0, '10', 'tpDep_10'),
            (4002882, 4001540, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002882', 0, '11', 'tpDep_11'),
            (4002883, 4001540, '12 - Ex-cônjuge', false, '12-ex-conjuge-4000883', 0, '12', 'tpDep_12'),
            (4002884, 4001540, '99 - Agregado/Outros', false, '99-outros-4002884', 0, '99', 'tpDep_99'),
            (4002885, 4001539, '', true, 'nmDep-4002885', 0, '', 'nmDep'),
            (4002886, 4001538, '', true, 'dtNascto-4002886', 0, '', 'dtNascto'),
            (4002887, 4001537, '', true, 'cpfDep-4002887', 0, '', 'cpfDep'),
            (4002888, 4001536, 'M - Masculino',false,'m-masculino-4002888',0,'M','sexoDep_m'),
            (4002889, 4001536, 'F - Feminino', false, 'f-feminino-4002889', 0, 'F', 'sexoDep_f'),
            (4002890, 4001535, 'S - Sim',false,'s-sim-4002890',0,'S','depIRRF_s'),
            (4002891, 4001535, 'N - Não', false, 'n-nao-400891', 0, 'N', 'depIRRF_n'),
            (4002892, 4001534, 'S - Sim',false,'s-sim-4002892',0,'S','depSF_s'),
            (4002893, 4001534, 'N - Não', false, 'n-nao-4002893', 0, 'N', 'depSF_n'),
            (4002894, 4001533, 'N - Não',false,'n-nao-4002894',0,'N','incTrab_n'),
            (4002895, 4001533, 'S - Sim', false, 's-sim-4002895', 0, 'S', 'incTrab_s');
        --6
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002896, 4001548, '01 - Cônjuge', false, '01-conjuge-4002896', 0, '01', 'tpDep_01'),
            (4002897, 4001548, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002897', 0, '02', 'tpDep_02'),
            (4002898, 4001548, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002898',0,'03','tpDep_03'),
            (4002899, 4001548, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002899', 0, '04', 'tpDep_04'),
            (4002900, 4001548, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002900', 0, '06', 'tpDep_06'),
            (4002901, 4001548, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002901', 0, '07', 'tpDep_07'),
            (4002902, 4001548, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002902', 0, '09', 'tpDep_09'),
            (4002903, 4001548, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002903', 0, '10', 'tpDep_10'),
            (4002904, 4001548, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002904', 0, '11', 'tpDep_11'),
            (4002905, 4001548, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002905', 0, '12', 'tpDep_12'),
            (4002906, 4001548, '99 - Agregado/Outros', false, '99-outros-4002906', 0, '99', 'tpDep_99'),
            (4002907, 4001547, '', true, 'nmDep-4002907', 0, '', 'nmDep'),
            (4002908, 4001546, '', true, 'dtNascto-4002908', 0, '', 'dtNascto'),
            (4002909, 4001545, '', true, 'cpfDep-4002909', 0, '', 'cpfDep'),
            (4002910, 4001544, 'M - Masculino',false,'m-masculino-4002910',0,'M','sexoDep_m'),
            (4002911, 4001544, 'F - Feminino', false, 'f-feminino-4002911', 0, 'F', 'sexoDep_f'),
            (4002912, 4001543, 'S - Sim',false,'s-sim-4002912',0,'S','depIRRF_s'),
            (4002913, 4001543, 'N - Não', false, 'n-nao-4002913', 0, 'N', 'depIRRF_n'),
            (4002914, 4001542, 'S - Sim',false,'s-sim-4002914',0,'S','depSF_s'),
            (4002915, 4001542, 'N - Não', false, 'n-nao-4002915', 0, 'N', 'depSF_n'),
            (4002916, 4001541, 'N - Não',false,'n-nao-4002916',0,'N','incTrab_n'),
            (4002917, 4001541, 'S - Sim', false, 's-sim-4002917', 0, 'S', 'incTrab_s');
        --7
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002918, 4001556, '01 - Cônjuge', false, '01-conjuge-4002918', 0, '01', 'tpDep_01'),
            (4002919, 4001556, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002919', 0, '02', 'tpDep_02'),
            (4002920, 4001556, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002920',0,'03','tpDep_03'),
            (4002921, 4001556, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002921', 0, '04', 'tpDep_04'),
            (4002922, 4001556, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002922', 0, '06', 'tpDep_06'),
            (4002923, 4001556, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002923', 0, '07', 'tpDep_07'),
            (4002924, 4001556, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002924', 0, '09', 'tpDep_09'),
            (4002925, 4001556, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002925', 0, '10', 'tpDep_10'),
            (4002926, 4001556, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002926', 0, '11', 'tpDep_11'),
            (4002927, 4001556, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002927', 0, '12', 'tpDep_12'),
            (4002928, 4001556, '99 - Agregado/Outros', false, '99-outros-4002928', 0, '99', 'tpDep_99'),
            (4002929, 4001555, '', true, 'nmDep-4002929', 0, '', 'nmDep'),
            (4002930, 4001554, '', true, 'dtNascto-4002930', 0, '', 'dtNascto'),
            (4002931, 4001553, '', true, 'cpfDep-4002931', 0, '', 'cpfDep'),
            (4002932, 4001552, 'M - Masculino',false,'m-masculino-40028932',0,'M','sexoDep_m'),
            (4002933, 4001552, 'F - Feminino', false, 'f-feminino-40028933', 0, 'F', 'sexoDep_f'),
            (4002934, 4001551, 'S - Sim',false,'s-sim-40028934',0,'S','depIRRF_s'),
            (4002935, 4001551, 'N - Não', false, 'n-nao-4002935', 0, 'N', 'depIRRF_n'),
            (4002936, 4001550, 'S - Sim',false,'s-sim-4002936',0,'S','depSF_s'),
            (4002937, 4001550, 'N - Não', false, 'n-nao-4002937', 0, 'N', 'depSF_n'),
            (4002938, 4001549, 'N - Não',false,'n-nao-4002938',0,'N','incTrab_n'),
            (4002939, 4001549, 'S - Sim', false, 's-sim-4002939', 0, 'S', 'incTrab_s');
        --8
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002940, 4001564, '01 - Cônjuge', false, '01-conjuge-4002940', 0, '01', 'tpDep_01'),
            (4002941, 4001564, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002941', 0, '02', 'tpDep_02'),
            (4002942, 4001564, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002942',0,'03','tpDep_03'),
            (4002943, 4001564, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002943', 0, '04', 'tpDep_04'),
            (4002944, 4001564, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002944', 0, '06', 'tpDep_06'),
            (4002945, 4001564, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002945', 0, '07', 'tpDep_07'),
            (4002946, 4001564, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002946', 0, '09', 'tpDep_09'),
            (4002947, 4001564, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002947', 0, '10', 'tpDep_10'),
            (4002948, 4001564, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002948', 0, '11', 'tpDep_11'),
            (4002949, 4001564, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002949', 0, '12', 'tpDep_12'),
            (4002950, 4001564, '99 - Agregado/Outros', false, '99-outros-4002950', 0, '99', 'tpDep_99'),
            (4002951, 4001563, '', true, 'nmDep-4002951', 0, '', 'nmDep'),
            (4002952, 4001562, '', true, 'dtNascto-4002952', 0, '', 'dtNascto'),
            (4002953, 4001561, '', true, 'cpfDep-4002953', 0, '', 'cpfDep'),
            (4002954, 4001560, 'M - Masculino',false,'m-masculino-4002954',0,'M','sexoDep_m'),
            (4002955, 4001560, 'F - Feminino', false, 'f-feminino-4002955', 0, 'F', 'sexoDep_f'),
            (4002956, 4001559, 'S - Sim',false,'s-sim-4002956',0,'S','depIRRF_s'),
            (4002957, 4001559, 'N - Não', false, 'n-nao-4002957', 0, 'N', 'depIRRF_n'),
            (4002958, 4001558, 'S - Sim',false,'s-sim-4002958',0,'S','depSF_s'),
            (4002959, 4001558, 'N - Não', false, 'n-nao-4002959', 0, 'N', 'depSF_n'),
            (4002960, 4001557, 'N - Não',false,'n-nao-4002960',0,'N','incTrab_n'),
            (4002961, 4001557, 'S - Sim', false, 's-sim-4002961', 0, 'S', 'incTrab_s');
        --9
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002962, 4001572, '01 - Cônjuge', false, '01-conjuge-4002962', 0, '01', 'tpDep_01'),
            (4002963, 4001572, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002963', 0, '02', 'tpDep_02'),
            (4002964, 4001572, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002964',0,'03','tpDep_03'),
            (4002965, 4001572, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002965', 0, '04', 'tpDep_04'),
            (4002966, 4001572, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002966', 0, '06', 'tpDep_06'),
            (4002967, 4001572, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002967', 0, '07', 'tpDep_07'),
            (4002968, 4001572, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002968', 0, '09', 'tpDep_09'),
            (4002969, 4001572, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002969', 0, '10', 'tpDep_10'),
            (4002970, 4001572, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002970', 0, '11', 'tpDep_11'),
            (4002971, 4001572, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002971', 0, '12', 'tpDep_12'),
            (4002972, 4001572, '99 - Agregado/Outros', false, '99-outros-4002972', 0, '99', 'tpDep_99'),
            (4002973, 4001571, '', true, 'nmDep-4002973', 0, '', 'nmDep'),
            (4002974, 4001570, '', true, 'dtNascto-4002974', 0, '', 'dtNascto'),
            (4002975, 4001569, '', true, 'cpfDep-4002975', 0, '', 'cpfDep'),
            (4002976, 4001568, 'M - Masculino',false,'m-masculino-40029076',0,'M','sexoDep_m'),
            (4002977, 4001568, 'F - Feminino', false, 'f-feminino-40029077', 0, 'F', 'sexoDep_f'),
            (4002978, 4001567, 'S - Sim',false,'s-sim-40028978',0,'S','depIRRF_s'),
            (4002979, 4001567, 'N - Não', false, 'n-nao-4002979', 0, 'N', 'depIRRF_n'),
            (4002980, 4001566, 'S - Sim',false,'s-sim-4002980',0,'S','depSF_s'),
            (4002981, 4001566, 'N - Não', false, 'n-nao-4002981', 0, 'N', 'depSF_n'),
            (4002982, 4001565, 'N - Não',false,'n-nao-4002982',0,'N','incTrab_n'),
            (4002983, 4001565, 'S - Sim', false, 's-sim-4002983', 0, 'S', 'incTrab_s');
        --10
        INSERT INTO avaliacaoperguntaopcao (db104_sequencial,db104_avaliacaopergunta,db104_descricao,db104_aceitatexto,db104_identificador,db104_peso,db104_valorresposta,db104_identificadorcampo) VALUES
            (4002984, 4001580, '01 - Cônjuge', false, '01-conjuge-4002984', 0, '01', 'tpDep_01'),
            (4002985, 4001580, '02 - Companheiro(a) com o(a) qual tenha filho ou viva há mais de 5 (cinco) anos ou possua Declaração de União Estável', false, '02-companheiro-4002985', 0, '02', 'tpDep_02'),
            (4002986, 4001580, '03 - Filho(a) ou enteado(a)',false,'03-filho-enteado-4002986',0,'03','tpDep_03'),
            (4002987, 4001580, '04 - Filho(a) ou enteado(a), universitário(a) ou cursando escola técnica de 2º grau', false, '04-filho-enteado-univ-4002987', 0, '04', 'tpDep_04'),
            (4002988, 4001580, '06 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, do(a) qual detenha a guarda judicial', false, '06-irmao-neto-bis-4002988', 0, '06', 'tpDep_06'),
            (4002989, 4001580, '07 - Irmão(ã), neto(a) ou bisneto(a) sem arrimo dos pais, universitário(a) ou cursando escola técnica de 2o grau, do(a) qual detenha a guarda judicial', false, '07-irmao-neto-bis-4002989', 0, '07', 'tpDep_07'),
            (4002990, 4001580, '09 - Pais, avós e bisavós', false, '09-pais-avos-bis-4002990', 0, '09', 'tpDep_09'),
            (4002991, 4001580, '10 - Menor pobre do qual detenha a guarda judicial', false, '10-menor-pobre-4002991', 0, '10', 'tpDep_10'),
            (4002992, 4001580, '11 - A pessoa absolutamente incapaz, da qual seja tutor ou curador', false, '11-absolutamente-incapaz-4002992', 0, '11', 'tpDep_11'),
            (4002993, 4001580, '12 - Ex-cônjuge', false, '12-ex-conjuge-4002993', 0, '12', 'tpDep_12'),
            (4002994, 4001580, '99 - Agregado/Outros', false, '99-outros-4002994', 0, '99', 'tpDep_99'),
            (4002995, 4001579, '', true, 'nmDep-4002995', 0, '', 'nmDep'),
            (4002996, 4001578, '', true, 'dtNascto-4002996', 0, '', 'dtNascto'),
            (4002997, 4001577, '', true, 'cpfDep-4002997', 0, '', 'cpfDep'),
            (4002998, 4001576, 'M - Masculino',false,'m-masculino-4002998',0,'M','sexoDep_m'),
            (4002999, 4001576, 'F - Feminino', false, 'f-feminino-4002999', 0, 'F', 'sexoDep_f'),
            (4003000, 4001575, 'S - Sim',false,'s-sim-4003000',0,'S','depIRRF_s'),
            (4003001, 4001575, 'N - Não', false, 'n-nao-4003001', 0, 'N', 'depIRRF_n'),
            (4003002, 4001574, 'S - Sim',false,'s-sim-4003002',0,'S','depSF_s'),
            (4003003, 4001574, 'N - Não', false, 'n-nao-4003003', 0, 'N', 'depSF_n'),
            (4003004, 4001573, 'N - Não',false,'n-nao-4003004',0,'N','incTrab_n'),
            (4003005, 4001573, 'S - Sim', false, 's-sim-4003005', 0, 'S', 'incTrab_s');


            INSERT INTO habitacao.avaliacaoperguntaopcao
            (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_aceitatexto, db104_identificador, db104_peso, db104_valorresposta, db104_identificadorcampo)
            VALUES(4000992, 4000589, '', true, 'nmDep-4000992', 0, '', 'nmDep');
            INSERT INTO habitacao.avaliacaoperguntaopcao
            (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_aceitatexto, db104_identificador, db104_peso, db104_valorresposta, db104_identificadorcampo)
            VALUES(4000993, 4000590, '', true, 'dtNascto-4000993', 0, '', 'dtNascto');
            INSERT INTO habitacao.avaliacaoperguntaopcao
            (db104_sequencial, db104_avaliacaopergunta, db104_descricao, db104_aceitatexto, db104_identificador, db104_peso, db104_valorresposta, db104_identificadorcampo)
            VALUES(4000994, 4000591, '', true, 'cpfDep-4000994', 0, '', 'cpfDep');

            -- Auto-generated SQL script #202201071402
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=26
                WHERE db102_sequencial=4000204;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=27
                WHERE db102_sequencial=4000205;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=28
                WHERE db102_sequencial=4000206;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=29
                WHERE db102_sequencial=4000207;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=21
                WHERE db102_sequencial=4000208;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=30
                WHERE db102_sequencial=4000209;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=31
                WHERE db102_sequencial=4000210;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=32
                WHERE db102_sequencial=4000211;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=33
                WHERE db102_sequencial=4000212;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=34
                WHERE db102_sequencial=4000213;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=16
                WHERE db102_sequencial=4000447;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=25
                WHERE db102_sequencial=4000203;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=35
                WHERE db102_sequencial=4000214;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=36
                WHERE db102_sequencial=4000215;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=37
                WHERE db102_sequencial=4000216;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=38
                WHERE db102_sequencial=4000217;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=39
                WHERE db102_sequencial=4000218;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=3
                WHERE db102_sequencial=4000190;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=4
                WHERE db102_sequencial=4000191;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=5
                WHERE db102_sequencial=4000192;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=6
                WHERE db102_sequencial=4000193;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=17
                WHERE db102_sequencial=4000195;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=18
                WHERE db102_sequencial=4000196;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=19
                WHERE db102_sequencial=4000197;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=7
                WHERE db102_sequencial=4000194;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=22
                WHERE db102_sequencial=4000199;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=10
                WHERE db102_sequencial=4000441;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=11
                WHERE db102_sequencial=4000442;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=12
                WHERE db102_sequencial=4000443;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=13
                WHERE db102_sequencial=4000444;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=14
                WHERE db102_sequencial=4000445;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=15
                WHERE db102_sequencial=4000446;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=9
                WHERE db102_sequencial=4000440;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=23
                WHERE db102_sequencial=4000201;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=24
                WHERE db102_sequencial=4000202;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=20
                WHERE db102_sequencial=4000198;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=22
                WHERE db102_sequencial=4000200;
            UPDATE habitacao.avaliacaogrupopergunta
                SET db102_ordem=8
                WHERE db102_sequencial=4000439;

            -- Auto-generated SQL script #202201071429
            UPDATE habitacao.avaliacaopergunta
                SET db103_perguntaidentificadora=false
                WHERE db103_sequencial=4000554;
            UPDATE habitacao.avaliacaopergunta
                SET db103_perguntaidentificadora=false
                WHERE db103_sequencial=4000553;
            UPDATE habitacao.avaliacaopergunta
                SET db103_perguntaidentificadora=false
                WHERE db103_sequencial=4000559;

                -- Auto-generated SQL script #202201071433
                UPDATE habitacao.avaliacaopergunta
                    SET db103_perguntaidentificadora=true
                    WHERE db103_sequencial=4000599;

                    -- Auto-generated SQL script #202201071606
                    UPDATE habitacao.avaliacaopergunta
                        SET db103_camposql='dsclograd2'
                        WHERE db103_sequencial=4000571;
                    UPDATE habitacao.avaliacaopergunta
                        SET db103_camposql='nrlograd2'
                        WHERE db103_sequencial=4000572;
                    UPDATE habitacao.avaliacaopergunta
                        SET db103_camposql='bairro2'
                        WHERE db103_sequencial=4000574;

                        -- Auto-generated SQL script #202201071857
                        UPDATE habitacao.avaliacaopergunta
                            SET db103_camposql='tpinscestab'
                            WHERE db103_sequencial=4000642;

                        -- Auto-generated SQL script #202201071858
                        UPDATE habitacao.avaliacaopergunta
                            SET db103_camposql='nrinscestab'
                            WHERE db103_sequencial=4000643;

                            -- Auto-generated SQL script #202201122204
                            UPDATE habitacao.avaliacaopergunta
                                SET db103_camposql='ceptemp'
                                WHERE db103_sequencial=4000650;
                            UPDATE habitacao.avaliacaopergunta
                                SET db103_camposql='bairrotemp'
                                WHERE db103_sequencial=4000649;
                            UPDATE habitacao.avaliacaopergunta
                                SET db103_camposql='complementotemp'
                                WHERE db103_sequencial=4000648;
                            UPDATE habitacao.avaliacaopergunta
                                SET db103_camposql='nrlogradtemp'
                                WHERE db103_sequencial=4000647;
                            UPDATE habitacao.avaliacaopergunta
                                SET db103_camposql='dsclogradtemp'
                                WHERE db103_sequencial=4000646;

        COMMIT;
        ";
        $this->execute($sql);
    }
}
