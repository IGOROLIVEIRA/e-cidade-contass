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
          
        COMMIT;

SQL;
    $this->execute($sql);
  }

}