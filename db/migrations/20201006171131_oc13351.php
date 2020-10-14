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
        ci01_instit		int4 not null default null);

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
          
        COMMIT;

SQL;
    $this->execute($sql);
  }

}