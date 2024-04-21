<?php

use ECidade\Suporte\Phinx\PostgresMigration;

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
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Cadastros', 'Cadastros', '', 1, 1, 'Cadastros do m�dulo controle interno', 't');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'), 
                                    (SELECT max(id_item) FROM db_itensmenu), 
                                    1, 
                                    (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));                                

        --CRIA MENU QUESTOES DE AUDITORIA
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Quest�es de Auditoria', 'Quest�es de Auditoria', '', 1, 1, 'Quest�es de Auditoria', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) from db_itensmenu)-1, (SELECT max(id_item) from db_itensmenu), 1, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Inclus�o', 'Inclus�o', 'cin1_questaoaudit001.php', 1, 1, 'Inclus�o', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Quest�es de Auditoria'), (SELECT max(id_item) from db_itensmenu), 1, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Altera��o', 'Altera��o', 'cin1_questaoaudit002.php', 1, 1, 'Altera��o', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Quest�es de Auditoria'), (SELECT max(id_item) from db_itensmenu), 2, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclus�o', 'Exclus�o', 'cin1_questaoaudit003.php', 1, 1, 'Exclus�o', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Quest�es de Auditoria'), (SELECT max(id_item) from db_itensmenu), 3, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        -- CRIA TABELA TIPO QUEST�O DE AUDITORIA
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'tipoquestaoaudit','Tipo da Auditoria','ci01','2020-10-06','Tipo da Auditoria',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci01_codtipo','int4','C�digo','', 'C�digo',11,false,false,false,0,'int4','C�digo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci01_tipoaudit','varchar(150)','Identifica a que as quest�es de auditoria est�o relacionadas','','Tipo da Auditoria',150,
                                            false,true,false,0,'text','Tipo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci01_instit','int4','Institui��o','','Institui��o',11,false,false,false,0,'int4','Institui��o');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci01_codtipo'), 	1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci01_tipoaudit'), 	2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci01_instit'), 		3, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS tipoquestaoaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- M�dulo: Controle Interno
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

        -- CRIA TABELA QUEST�O DE AUDITORIA
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'questaoaudit','Quest�o de Auditoria','ci02','2020-10-06','Quest�o de Auditoria',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci02_codquestao','int4','C�digo','', 'C�digo',11,false,false,false,1,'int4','C�digo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_codtipo','int4','Tipo da Auditoria','','Tipo da Auditoria',11,
                                            false,false,false,1,'int4','Tipo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_numquestao','int4','� n�mero que identificar� a quest�o de auditoria no processo','','N�mero da Quest�o',
                                            11,false,false,false,1,'int4','N�mero da Quest�o');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_questao','varchar(500)','S�o as quest�es a serem respondidas, s�o vinculadas ao objetivo geral da auditoria e devem ser elaboradas de forma interrogativa, sucintas e sem ambiguidades, fact�veis de serem respondidas e priorizadas segundo a relev�ncia da quest�o para o alcance do objetivo do trabalho','',
                                            'Quest�o da Auditoria',500,false,false,false,0,'text','Quest�o da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_inforeq','varchar(500)','� o conjunto de informa��es que formar�o a base para que a quest�o de auditoria possa ser analisada. Em resumo, � a informa��o capaz de responder a quest�o de auditoria proposta','',
                                            'Informa��es Requeridas',500,false,false,false,0,'text','Informa��es Requeridas');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_fonteinfo','varchar(500)','Deve-se listar a fonte na qual a informa��o requerida ser� obtida. Pode ocorrer de uma informa��o ter mais de uma fonte','',
                                            'Fonte das Informa��es',500,false,false,false,0,'text','Fonte das Informa��es');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_procdetal','varchar(500)','Deve ser especificado como ser�o coletadas as informa��es. Exemplos de m�todos de coleta: entrevista, sondagem, question�rio, formul�rio, utiliza��o de dados j� existentes, inspe��o f�sica, exame documental, requisi��o de informa��es, extra��o de dados etc','',
                                            'Procedimento Detalhado',500,false,false,false,0,'text','Procedimento Detalhado');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_objeto','varchar(500)','� o documento (material) produzido e fornecido pela unidade auditada sobre o qual recair� a an�lise, visando sempre o alcance da resposta � quest�o de auditoria','',
                                            'Objetos',500,false,false,false,0,'text','Objetos');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 
                                            'ci02_possivachadneg','varchar(500)','Os achados negativos podem identificar que n�o houve boa gest�o, ou houve falhas nos procedimentos, seja de car�ter legal, seja de car�ter t�cnico administrativo, tais como: efici�ncia, efic�cia, economicidade e efetividade dos programas, projetos e a��es','',
                                            'Poss�veis Achados Negativos',500,false,false,false,0,'text','Poss�veis Achados Negativos');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci02_instit','int4','Institui��o','','Institui��o',11,false,false,false,1,'int4','Institui��o');

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

        -- M�dulo: Controle Interno
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

        --Cria menu do relatorio das quest�es cadastradas
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Auditoria', 'Auditoria', '', 1, 1, 'Auditoria', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relat�rios'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relat�rios')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Relat�rios')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Quest�es de Auditoria', 'Quest�es de Auditoria', 'cin2_relquestaoaudit001.php', 1, 1, 'Quest�es de Auditoria', 't');

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

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Inclus�o', 'Inclus�o', 'cin4_procaudit001.php', 1, 1, 'Inclus�o', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Processo de Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            1, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Altera��o', 'Altera��o', 'cin4_procaudit002.php', 1, 1, 'Altera��o', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Processo de Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            2, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclus�o', 'Exclus�o', 'cin4_procaudit003.php', 1, 1, 'Exclus�o', 't');

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
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_codproc','int4','C�digo','','C�digo',11,false,false,false,0,'int4','C�digo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_numproc','int4','N�mero do processo da auditoria','','N�mero do Processo',11,false,false,false,1,'text','N�mero do Processo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_anoproc','int4','Ano do processo da auditoria','','Ano do Processo',4,false,false,false,1,'text','Ano do Processo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_grupoaudit','int4','Grupo de Auditoria','','Grupo de Auditoria',1,false,false,false,1,'text','Grupo de Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_objaudit','varchar(500)','Descrever qual � o foco da auditoria em quest�o','','Objetivo da Auditoria',500,false,false,false,0,'text','Objetivo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_dataini','date','Data Inicial','','Data Inicial',10,false,false,false,1,'text','Data Inicial');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_datafim','date','Data Final','','Data Final',10,false,false,false,1,'text','Data Final');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_protprocesso','int4','Protocolo','','Protocolo',10,false,false,false,0,'text','Protocolo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_codtipoquest','int4','Tipo da Auditoria','','Tipo da Auditoria',11,true,false,false,1,'int4','Tipo da Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci03_instit','int4','Institui��o','','Institui��o',11,false,false,false,0,'int4','Institui��o');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_codproc'),      1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_numproc'), 	    2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_anoproc'), 		3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_grupoaudit'),   4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_objaudit'),     5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_dataini'),      6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_datafim'),      7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_protprocesso'), 8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_codtipoquest'), 9, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci03_instit'),       10, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS processoaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- M�dulo: Controle Interno
        CREATE TABLE processoaudit(
        ci03_codproc        int4 not null default 0,
        ci03_numproc        int4 not null,
        ci03_anoproc        int4 not null,
        ci03_grupoaudit     int4 not null,
        ci03_objaudit       varchar(500) not null,
        ci03_dataini        date not null,
        ci03_datafim        date not null,
        ci03_protprocesso   int4 default null,
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

        ALTER TABLE processoaudit ADD CONSTRAINT processoaudit_protprocesso_fk FOREIGN KEY (ci03_protprocesso) REFERENCES protprocesso (p58_codproc);

        DROP TABLE IF EXISTS processoauditdepart CASCADE;

        -- CRIA TABELA PROCESSO DE AUDITORIA DEPARTAMENTO
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'processoauditdepart','Processo de Auditoria Departamento','ci04','2020-10-15','Processo de Auditoria Departamento',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci04_codproc','int4','C�digo do Processo','','C�digo do Processo',11,false,false,false,0,'int4','C�digo do Processo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci04_depto','int4','C�digo do Departamento','','C�digo do Departamento',11,false,false,false,1,'text','C�digo do Departamento');

        CREATE TABLE processoauditdepart(
        ci04_codproc    int4 not null,
        ci04_depto     int4 not null
        );

        ALTER TABLE processoauditdepart ADD PRIMARY KEY (ci04_codproc, ci04_depto);

        ALTER TABLE processoauditdepart ADD CONSTRAINT processoauditdepart_codproc_fk FOREIGN KEY (ci04_codproc) REFERENCES processoaudit (ci03_codproc);

        ALTER TABLE processoauditdepart ADD CONSTRAINT processoauditdepart_depto_fk FOREIGN KEY (ci04_depto) REFERENCES db_depart (coddepto);

        --Cria menu para lan�amento de verifica��es
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Lan�amento de Verifica��es', 'Lan�amento de Verifica��es', 'cin4_lancamverifaudit.php', 1, 1, 'Lan�amento de Verifica��es', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Procedimentos')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );

        -- CRIA TABELA LAN�AMENTO DE VERIFICA��ES
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'lancamverifaudit','Processo de Auditoria','ci05','2020-10-19','Processo de Auditoria',0,'f','f','f','f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_codlan','int4','C�digo','','C�digo',11,false,false,false,0,'int4','C�digo');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_codproc','int4','C�digo do Processo de Auditoria','','C�digo do Processo de Auditoria',11,false,false,false,1,'text','C�digo do Processo de Auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_codquestao','int4','C�digo da Quest�o','','C�digo da Quest�o',11,false,false,false,1,'text','C�digo da Quest�o');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_inianalise','date','In�cio An�lise','','In�cio An�lise',10,false,false,false,1,'text','In�cio An�lise');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_atendquestaudit','bool','Atende � quest�o de auditoria','','Atende � quest�o de auditoria',1,false,false,false,1,'','Atende � quest�o de auditoria');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_achados','varchar(500)','S�o fatos que resultam da aplica��o dos programas elaborados para as diversas �reas em an�lise, referindo-se �s defici�ncias encontradas durante o exame e suportadas por informa��es dispon�veis no �rg�o auditado','','Achados',500,true,false,false,0,'text','Achados');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci05_instit','int4','Institui��o','','Institui��o',11,false,false,false,0,'int4','Institui��o');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_codlan'),               1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_codproc'), 	            2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_codquestao'), 	        3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_inianalise'),           4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_atendquestaudit'),      5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_achados'),              6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci05_instit'),               7, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS lancamverifaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- M�dulo: Controle Interno
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

        --CRIA MENU PARA RELAT�RIO DE VERIFICA��ES
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Relat�rio de Verifica��es', 'Relat�rio de Verifica��es', 'cin2_rellancamverifaudit001.php', 1, 1, 'Relat�rio de Verifica��es', 't');

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
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_codlan','int4','C�digo do Lan�amento de Verifica��o','','C�digo do Lan�amento de Verifica��o',11,false,false,false,1,'text','C�digo do Lan�amento de Verifica��o');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_situencont','varchar(500)','Descrever toda a situa��o existente, deixando claro os diversos aspectos do achado','','Situa��o Encontrada',500,false,false,false,0,'text','Situa��o Encontrada');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_objetos','varchar(500)','Indicar todos os objetos nos quais o achado foi contatado','','Objetos',500,false,false,false,0,'text','Objetos');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_criterio','varchar(500)','Indicar os crit�rios que refletem como a gest�o deveria ser','','Crit�rio',500,false,false,false,0,'text','Crit�rio');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_evidencia','varchar(500)','Indicar precisamente os documentos que respaldam a opini�o da equipe','','Evid�ncia',500,false,false,false,0,'text','Evid�ncia');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_causa','varchar(500)','Deve ser conclusiva e fornecer elementos para a correta responsabiliza��o','','Causa',500,false,false,false,0,'text','Causa');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_efeito','varchar(500)','Avaliar quais foram ou podem ser as consequ�ncias para o �rg�o, er�rio ou sociedade','','Efeito',500,false,false,false,0,'text','Efeito');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_recomendacoes','varchar(500)','As recomenda��es decorrem dos achados e consistem em a��es que a equipe de auditoria indica �s unidades auditadas, visando corrigir desconformidades, a tratar riscos e a aperfei�oar processos de trabalhos e controles','','Recomenda��es',500,false,false,false,0,'text','Recomenda��es');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'ci06_instit','int4','Institui��o','','Institui��o',11,false,false,false,0,'int4','Institui��o');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_seq'),              1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_codlan'), 	        2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_situencont'),       3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_objetos'),      	4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_criterio'),         5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_evidencia'),        6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_causa'),            7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_efeito'),           8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_recomendacoes'),    9, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'ci06_instit'),           10, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS matrizachadosaudit CASCADE;
        --Criando drop sequences

        -- TABELAS E ESTRUTURA

        -- M�dulo: Controle Interno
        CREATE TABLE matrizachadosaudit(
        ci06_seq             	int4 not null default 0,
        ci06_codlan             int4 not null,
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

        ALTER TABLE matrizachadosaudit ADD CONSTRAINT matrizachadosaudit_codlan_fk FOREIGN KEY (ci06_codlan) REFERENCES lancamverifaudit (ci05_codlan);

        --CRIA MENU PARA RELAT�RIO DE MATRIZ DE ACHADOS
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Matriz de Achados', 'Matriz de Achados', 'cin2_relmatrizachadosaudit001.php', 1, 1, 'Matriz de Achados', 't'); 

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Auditoria'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            2, 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );	     

        --CRIA ITEM DE MENU PARA CONSULTA
        UPDATE db_menu SET menusequencia = menusequencia+1 WHERE menusequencia > 1 AND id_item = 
            (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno') AND NOT EXISTS
                (SELECT 1 FROM db_menu 
                        inner join db_itensmenu on db_menu.id_item_filho = db_itensmenu.id_item
                    WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')
                        AND descricao = 'Consultas');

        INSERT INTO db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente) 
            SELECT (SELECT max(id_item)+1 FROM db_itensmenu),'Consultas','Consultas','',1,1,'Consultas do m�dulo controle interno','t'
        WHERE NOT EXISTS 
            (SELECT 1 FROM db_menu 
                    INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item
                WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')
                    AND descricao = 'Consultas');

        INSERT INTO db_menu (id_item, id_item_filho, menusequencia, modulo) 
            SELECT  (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'), 
                    (SELECT max(id_item) FROM db_itensmenu), 
                    (SELECT CASE
                        WHEN (SELECT count(*) FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')) = 0 THEN 1 
                        ELSE 2
                    END), 
                    (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
            WHERE NOT EXISTS ( 
                (SELECT 1 FROM db_menu 
                    INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item
                WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')
                    AND descricao = 'Consultas')
            );	

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Processo de Auditoria', 'Processo de Auditoria', 'cin3_procaudit001.php', 1, 1, 'Processo de Auditoria', 't');

        INSERT INTO db_menu VALUES (
            (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Consultas'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT CASE
                WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Consultas')) = 0 THEN 1 
                ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno') AND descricao = 'Consultas')) 
            END), 
            (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Controle Interno')
        );
                        
        COMMIT;

SQL;
    $this->execute($sql);
  }

}