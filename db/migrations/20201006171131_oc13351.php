<?php

use Classes\PostgresMigration;

class Oc13351 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        --ATUALIZA SEQUENCIA DE MENUS DO CONTROLE INTERNO
        UPDATE db_menu SET menusequencia = menusequencia+1 WHERE id_item = 
            (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno') AND EXISTS
                (SELECT 1 FROM db_menu WHERE menusequencia = 1 AND id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'));

        --CRIA OPCAO DE CADASTRO PARA CONTROLE INTERNO
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Cadastros', 'Cadastros', '', 1, 1, 'Cadastros do módulo controle interno', 't');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'), 
                                    (SELECT max(id_item) FROM db_itensmenu), 
                                    1, 
                                    (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));                                

        --CRIA MENU QUESTOES DE AUDITORIA
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Questões de Auditoria', 'Questões de Auditoria', '', 1, 1, 'Questões de Auditoria', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) from db_itensmenu)-1, (SELECT max(id_item) from db_itensmenu), 1, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Inclusão', 'Inclusão', 'cin1_questaoaudit001.php', 1, 1, 'Inclusão', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Questões de Auditoria'), (SELECT max(id_item) from db_itensmenu), 1, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Alteração', 'Alteração', 'cin1_questaoaudit002.php', 1, 1, 'Alteração', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Questões de Auditoria'), (SELECT max(id_item) from db_itensmenu), 2, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclusão', 'Exclusão', 'cin1_questaoaudit003.php', 1, 1, 'Exclusão', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Questões de Auditoria'), (SELECT max(id_item) from db_itensmenu), 3, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        -- CRIA TABELA TIPO QUESTÃO DE AUDITORIA
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'tipoquestaoaudit','Tipo da Auditoria','ci01','2020-10-06','Tipo da Auditoria',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci01_codtipo','int4','Código','', 'Código',11,false,false,false,0,'int4','Código');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci01_tipoaudit','varchar(150)','Identifica a que as questões de auditoria estão relacionadas','','Tipo da Auditoria',150,
                                            false,true,false,0,'text','Tipo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci01_instit','int4','Instituição','','Instituição',11,false,false,false,0,'int4','Instituição');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci01_codtipo'), 	1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci01_tipoaudit'), 	2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci01_instit'), 		3, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS tipoquestaoaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- Módulo: Controle Interno
        CREATE TABLE tipoquestaoaudit(
        ci01_codtipo		int4 not null default 0,
        ci01_tipoaudit		varchar(150) not null,
        ci01_instit		    int4 not null);

        -- Criando  sequences
        CREATE SEQUENCE contint_ci01_codtipo_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- CHAVE ESTRANGEIRA
        ALTER TABLE tipoquestaoaudit ADD PRIMARY KEY (ci01_codtipo);

        -- CRIA TABELA QUESTÃO DE AUDITORIA
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'questaoaudit','Questão de Auditoria','ci02','2020-10-06','Questão de Auditoria',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci02_codquestao','int4','Código','', 'Código',11,false,false,false,1,'int4','Código');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_codtipo','int4','Tipo da Auditoria','','Tipo da Auditoria',11,
                                            false,false,false,1,'int4','Tipo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_numquestao','int4','É número que identificará a questão de auditoria no processo','','Número da Questão',
                                            11,false,false,false,1,'int4','Número da Questão');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_questao','varchar(500)','São as questões a serem respondidas, são vinculadas ao objetivo geral da auditoria e devem ser elaboradas de forma interrogativa, sucintas e sem ambiguidades, factíveis de serem respondidas e priorizadas segundo a relevância da questão para o alcance do objetivo do trabalho','',
                                            'Questão da Auditoria',500,false,false,false,0,'text','Questão da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_inforeq','varchar(500)','É o conjunto de informações que formarão a base para que a questão de auditoria possa ser analisada. Em resumo, é a informação capaz de responder a questão de auditoria proposta','',
                                            'Informações Requeridas',500,false,false,false,0,'text','Informações Requeridas');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_fonteinfo','varchar(500)','Deve-se listar a fonte na qual a informação requerida será obtida. Pode ocorrer de uma informação ter mais de uma fonte','',
                                            'Fonte das Informações',500,false,false,false,0,'text','Fonte das Informações');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_procdetal','varchar(500)','Deve ser especificado como serão coletadas as informações. Exemplos de métodos de coleta: entrevista, sondagem, questionário, formulário, utilização de dados já existentes, inspeção física, exame documental, requisição de informações, extração de dados etc','',
                                            'Procedimento Detalhado',500,false,false,false,0,'text','Procedimento Detalhado');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_objeto','varchar(500)','É o documento (material) produzido e fornecido pela unidade auditada sobre o qual recairá a análise, visando sempre o alcance da resposta à questão de auditoria','',
                                            'Objetos',500,false,false,false,0,'text','Objetos');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_possivachadneg','varchar(500)','Os achados negativos podem identificar que não houve boa gestão, ou houve falhas nos procedimentos, seja de caráter legal, seja de caráter técnico administrativo, tais como: eficiência, eficácia, economicidade e efetividade dos programas, projetos e ações','',
                                            'Possíveis Achados Negativos',500,false,false,false,0,'text','Possíveis Achados Negativos');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci02_instit','int4','Instituição','','Instituição',11,false,false,false,1,'int4','Instituição');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_codquestao'), 		1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_codtipo'), 		    2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_numquestao'), 		3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_questao'), 			4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_inforeq'), 			5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_fonteinfo'), 		6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_procdetal'), 		7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_objeto'), 			8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_possivachadneg'), 	9, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci02_instit'), 			10, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS questaoaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- Módulo: Controle Interno
        CREATE TABLE questaoaudit(
        ci02_codquestao		int4 not null default 0,
        ci02_codtipo		int4 not null,
        ci02_numquestao		int4 not null,
        ci02_questao		varchar(500) not null,
        ci02_inforeq		varchar(500),
        ci02_fonteinfo		varchar(500),
        ci02_procdetal		varchar(500),
        ci02_objeto			varchar(500),
        ci02_possivachadneg	varchar(500),
        ci02_instit		int4 not null);


        -- Criando  sequences
        CREATE SEQUENCE contint_ci02_codquestao_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- CHAVE ESTRANGEIRA
        ALTER TABLE questaoaudit ADD PRIMARY KEY (ci02_codquestao);

        ALTER TABLE questaoaudit ADD CONSTRAINT questaoaudit_tipoquestao_fk FOREIGN KEY (ci02_codtipo) REFERENCES tipoquestaoaudit (ci01_codtipo);

        --Cria menu do relatorio das questões cadastradas
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Auditoria', 'Auditoria', '', 1, 1, 'Auditoria', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relatórios'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relatórios')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relatórios')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Questões de Auditoria', 'Questões de Auditoria', 'cin2_relquestaoaudit001.php', 1, 1, 'Questões de Auditoria', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            1, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        --Cria menu para processo de auditoria
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Processo de Auditoria', 'Processo de Auditoria', '', 1, 1, 'Processo de Auditoria', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Inclusão', 'Inclusão', 'cin4_procaudit001.php', 1, 1, 'Inclusão', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Processo de Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            1, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Alteração', 'Alteração', 'cin4_procaudit002.php', 1, 1, 'Alteração', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Processo de Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            2, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclusão', 'Exclusão', 'cin4_procaudit003.php', 1, 1, 'Exclusão', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Processo de Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            3, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        -- CRIA TABELA PROCESSO DE AUDITORIA
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'processoaudit','Processo de Auditoria','ci03','2020-10-15','Processo de Auditoria',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_codproc','int4','Código','','Código',11,false,false,false,0,'int4','Código');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_numproc','int4','Número do processo da auditoria','','Número do Processo',11,false,false,false,1,'text','Número do Processo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_anoproc','int4','Ano do processo da auditoria','','Ano do Processo',4,false,false,false,1,'text','Ano do Processo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_grupoaudit','int4','Grupo de Auditoria','','Grupo de Auditoria',1,false,false,false,1,'text','Grupo de Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_objaudit','varchar(500)','Descrever qual é o foco da auditoria em questão','','Objetivo da Auditoria',500,false,false,false,0,'text','Objetivo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_dataini','date','Data Inicial','','Data Inicial',10,false,false,false,1,'text','Data Inicial');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_datafim','date','Data Final','','Data Final',10,false,false,false,1,'text','Data Final');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_codtipoquest','int4','Tipo da Auditoria','','Tipo da Auditoria',11,true,false,false,1,'int4','Tipo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_instit','int4','Instituição','','Instituição',11,false,false,false,0,'int4','Instituição');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_codproc'),      1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_numproc'), 	    2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_anoproc'), 		3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_grupoaudit'),   4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_objaudit'),     5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_dataini'),      6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_datafim'),      7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_codtipoquest'), 8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_instit'),       9, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS processoaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- Módulo: Controle Interno
        CREATE TABLE processoaudit(
        ci03_codproc        int4 not null default 0,
        ci03_numproc        int4 not null,
        ci03_anoproc        int4 not null,
        ci03_grupoaudit     int4 not null,
        ci03_objaudit       varchar(500) not null,
        ci03_dataini        date not null,
        ci03_datafim        date not null,
        ci03_codtipoquest   int4 default null,
        ci03_instit         int4 not null);

        -- Criando  sequences
        CREATE SEQUENCE contint_ci03_codproc_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- CHAVE ESTRANGEIRA
        ALTER TABLE processoaudit ADD PRIMARY KEY (ci03_codproc);

        ALTER TABLE processoaudit ADD CONSTRAINT processoaudit_tipoquestao_fk FOREIGN KEY (ci03_codtipoquest) REFERENCES tipoquestaoaudit (ci01_codtipo);

        DROP TABLE IF EXISTS processoauditdepart CASCADE;

        -- CRIA TABELA PROCESSO DE AUDITORIA DEPARTAMENTO
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'processoauditdepart','Processo de Auditoria Departamento','ci04','2020-10-15','Processo de Auditoria Departamento',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci04_codproc','int4','Código do Processo','','Código do Processo',11,false,false,false,0,'int4','Código do Processo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci04_depto','int4','Código do Departamento','','Código do Departamento',11,false,false,false,1,'text','Código do Departamento');

        CREATE TABLE processoauditdepart(
        ci04_codproc    int4 not null,
        ci04_depto     int4 not null
        );

        ALTER TABLE processoauditdepart ADD PRIMARY KEY (ci04_codproc, ci04_depto);

        ALTER TABLE processoauditdepart ADD CONSTRAINT processoauditdepart_codproc_fk FOREIGN KEY (ci04_codproc) REFERENCES processoaudit (ci03_codproc);

        ALTER TABLE processoauditdepart ADD CONSTRAINT processoauditdepart_depto_fk FOREIGN KEY (ci04_depto) REFERENCES db_depart (coddepto);

        --Cria menu para lançamento de verificações
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Lançamento de Verificações', 'Lançamento de Verificações', 'cin4_lancamverifaudit.php', 1, 1, 'Lançamento de Verificações', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        -- CRIA TABELA LANÇAMENTO DE VERIFICAÇÕES
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'lancamverifaudit','Processo de Auditoria','ci05','2020-10-19','Processo de Auditoria',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_codlan','int4','Código','','Código',11,false,false,false,0,'int4','Código');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_codproc','int4','Código do Processo de Auditoria','','Código do Processo de Auditoria',11,false,false,false,1,'text','Código do Processo de Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_codquestao','int4','Código da Questão','','Código da Questão',11,false,false,false,1,'text','Código da Questão');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_inianalise','date','Início Análise','','Início Análise',10,false,false,false,1,'text','Início Análise');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_atendquestaudit','bool','Atende à questão de auditoria','','Atende à questão de auditoria',1,false,false,false,1,'','Atende à questão de auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_achados','varchar(500)','São fatos que resultam da aplicação dos programas elaborados para as diversas áreas em análise, referindo-se às deficiências encontradas durante o exame e suportadas por informações disponíveis no órgão auditado','','Achados',500,true,false,false,0,'text','Achados');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_instit','int4','Instituição','','Instituição',11,false,false,false,0,'int4','Instituição');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_codlan'),               1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_codproc'), 	        2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_codquestao'), 	        3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_inianalise'),           4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_atendquestaudit'),      5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_achados'),              6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_instit'),               7, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS lancamverifaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- Módulo: Controle Interno
        CREATE TABLE lancamverifaudit(
        ci05_codlan             int4 not null default 0,
        ci05_codproc            int4 not null,
        ci05_codquestao         int4 not null,
        ci05_inianalise         date not null,
        ci05_atendquestaudit    boolean not null,
        ci05_achados            varchar(500),
        ci05_instit             int4 not null);

        -- Criando  sequences
        CREATE SEQUENCE contint_ci05_codlan_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- CHAVE ESTRANGEIRA
        ALTER TABLE lancamverifaudit ADD PRIMARY KEY (ci05_codlan);

        ALTER TABLE lancamverifaudit ADD CONSTRAINT lancamverifaudit_codproc_fk FOREIGN KEY (ci05_codproc) REFERENCES processoaudit (ci03_codproc);

        ALTER TABLE lancamverifaudit ADD CONSTRAINT lancamverifaudit_codquestao_fk FOREIGN KEY (ci05_codquestao) REFERENCES questaoaudit (ci02_codquestao);

        --CRIA MENU PARA RELATÓRIO DE VERIFICAÇÕES
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Relatório de Verificações', 'Relatório de Verificações', 'cin2_rellancamverifaudit001.php', 1, 1, 'Relatório de Verificações', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            2, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );		

        -- CRIA MENU PARA MATRIZ DE ACHADOS
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Matriz de Achados', 'Matriz de Achados', 'cin4_matrizachadosaudit.php', 1, 1, 'Matriz de Achados', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        --CRIA TABELA MATRIZ DE ACHADOS 

        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'matrizachadosaudit','Matriz de Achados','ci06','2020-10-27','Matriz de Achados',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_seq','int4','Sequencial','','Sequencial',11,false,false,false,0,'int4','Sequencial');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_codproc','int4','Código do Processo de Auditoria','','Código do Processo de Auditoria',11,false,false,false,1,'text','Código do Processo de Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_codquestao','int4','Código da Questão','','Código da Questão',11,false,false,false,1,'text','Código da Questão');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_situencont','varchar(500)','Descrever toda a situação existente, deixando claro os diversos aspectos do achado','','Situação Encontrada',500,false,false,false,0,'text','Situação Encontrada');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_objetos','varchar(500)','Indicar todos os objetos nos quais o achado foi contatado','','Objetos',500,true,false,false,0,'text','Objetos');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_criterio','varchar(500)','Indicar os critérios que refletem como a gestão deveria ser','','Critério',500,true,false,false,0,'text','Critério');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_evidencia','varchar(500)','Indicar precisamente os documentos que respaldam a opinião da equipe','','Evidência',500,true,false,false,0,'text','Evidência');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_causa','varchar(500)','Deve ser conclusiva e fornecer elementos para a correta responsabilização','','Causa',500,true,false,false,0,'text','Causa');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_efeito','varchar(500)','Avaliar quais foram ou podem ser as consequências para o órgão, erário ou sociedade','','Efeito',500,true,false,false,0,'text','Efeito');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_recomendacoes','varchar(500)','As recomendações decorrem dos achados e consistem em ações que a equipe de auditoria indica às unidades auditadas, visando corrigir desconformidades, a tratar riscos e a aperfeiçoar processos de trabalhos e controles','','Recomendações',500,true,false,false,0,'text','Recomendações');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_instit','int4','Instituição','','Instituição',11,false,false,false,0,'int4','Instituição');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_seq'),              1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_codproc'), 	        2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_codquestao'), 	    3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_situencont'),       4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_objetos'),      	5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_criterio'),         6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_evidencia'),        7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_causa'),            8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_efeito'),           9, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_recomendacoes'),    10, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_instit'),           11, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS matrizachadosaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- Módulo: Controle Interno
        CREATE TABLE matrizachadosaudit(
        ci06_seq             	int4 not null default 0,
        ci06_codproc            int4 not null,
        ci06_codquestao         int4 not null,
        ci06_situencont         varchar(500) not null,
        ci06_objetos            varchar(500),
        ci06_criterio           varchar(500),
        ci06_evidencia          varchar(500),
        ci06_causa            	varchar(500),
        ci06_efeito            	varchar(500),
        ci06_recomendacoes      varchar(500),
        ci06_instit             int4 not null);

        -- Criando  sequences
        CREATE SEQUENCE contint_ci06_seq_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- CHAVE ESTRANGEIRA
        ALTER TABLE matrizachadosaudit ADD PRIMARY KEY (ci06_seq);

        ALTER TABLE matrizachadosaudit ADD CONSTRAINT matrizachadosaudit_codproc_fk FOREIGN KEY (ci06_codproc) REFERENCES processoaudit (ci03_codproc);

        ALTER TABLE matrizachadosaudit ADD CONSTRAINT matrizachadosaudit_codquestao_fk FOREIGN KEY (ci06_codquestao) REFERENCES questaoaudit (ci02_codquestao);        
                        
        COMMIT;

SQL;
    $this->execute($sql);
  }

}