<?php

use Phinx\Migration\AbstractMigration;

class Oc11331 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
      $sql = <<<SQL
                    BEGIN;

                        SELECT fc_startsession();

                          -- INSERE db_sysmodulo
                          INSERT INTO db_sysmodulo VALUES((select max(codmod)+1 from db_sysmodulo),'Obras','Obras','2019-12-21','t');

                          -- INSERE db_modulos
                          INSERT INTO db_modulos VALUES((select max(id_item)+1 from db_modulos),'Obras','Obras','','t','obras');

                          --INSERE atendcadareamod
                          INSERT INTO atendcadareamod VALUES ((SELECT max(at26_sequencia)+1 from atendcadareamod),4,(select max(id_item) from db_modulos));

                          --INSERE db_usermod

                          INSERT INTO db_usermod VALUES(1,1,4001223);

                          -- INSERE db_sysarquivo
                          INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licobras','cadastro de obras','obr01','2019-12-21','cadastro de obras',0,'f','f','f','f');

                          -- INSERE db_sysarqmod
                          INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%Obras%'), (select max(codarq) from db_sysarquivo));

                          -- INSERE db_syscampo
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_sequencial'	 		,'int8' ,'Cуd. Sequencial'			,'', 'Cуd. Sequencial'			 ,11	,false, false, false, 1, 'int8', 'Cуd. Sequencial');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_processo'	 		,'int8' ,'Processo Licitatуrio' ,'', 'Processo Licitatуrio'	 ,11	,false, false, false, 1, 'int8', 'Processo Licitatуrio');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_dtlancamento'		,'date' ,'Data Lanзamento'		,'', 'Data Lanзamento'		 ,16	,false, false, false, 0, 'date', 'Data Lanзamento');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_numeroobra'  		,'int8' ,'Nє Obra'				,'', 'Nє Obra'				 ,16	,false, false, false, 1, 'int8', 'Nє Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_linkobra'    		,'text' ,'Link da Obra'			,'', 'Link da Obra'			 ,200	,false, false, false, 0, 'text', 'Link da Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_tiporesponsavel'	,'int8' ,'Tipo Responsбvel'		,'', 'Tipo Responsбvel'		 ,16	,false, false, false, 1, 'int8', 'Tipo Responsбvel');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_responsavel'		,'int8' ,'Responsбvel'			,'', 'Responsбvel'			 ,16	,false, false, false, 1, 'int8', 'Responsбvel');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_tiporegistro'		,'int8' ,'Tipo Registro'		,'', 'Tipo Registro'		 ,16	,false, false, false, 1, 'int8', 'Tipo Registro');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_numregistro'		,'text' ,'Numero Registro'		,'', 'Numero Registro'		 ,10	,false, false, false, 0, 'int8', 'Numero Registro');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_numartourrt'		,'int8' ,'Nъmero da anotaзгo de responsabilidade tйcnica ou registro de responsabilidade tйcnica.' ,'', 'Numero da ART ou RRT'	 ,16	,false, false, false, 1, 'int8', 'Numero da ART ou RRT');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_dtinicioatividades'	,'date' ,'Data Inicio das Ativ. do Eng na Obra'		,'', 'Data Inicio das Ativ. do Eng na Obra'		 ,16	,false, false, false, 0, 'date', 'Data Inicio das Ativ. do Eng na Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_vinculoprofissional','int8' ,'Vinculo do Prof. com a Adm. Pъblica'	,'', 'Vinculo do Prof. com a Adm. Pъblica'		 ,16	,false, false, false, 1, 'int8', 'Vinculo do Prof. com a Adm. Pъblica');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_instit'				,'int8' ,'Instituiзгo'	,'', 'Instituiзгo'		 ,16	,false, false, false, 1, 'int8', 'Instituiзгo');

                          -- INSERE db_sysarqcamp
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_sequencial')		 	, 1, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_processo')			 	, 2, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_modalidade')		 	, 3, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_dtlancamento')		 	, 4, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_numeroobra')		 	, 5, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_linkobra')			 	, 6, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_tiporesponsavel')	 	, 7, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_responsavel')		 	, 8, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_tiporegistro')		 	, 9, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_numregistro')		 	, 10, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_numartourrt')		 	, 11, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_dtinicioatividades')	, 12, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_vinculoprofissional')	, 13, 0);

                          --DROP TABLE:
                          DROP TABLE IF EXISTS licobras CASCADE;
                          --Criando drop sequences


                          -- TABELAS E ESTRUTURA

                          -- Mуdulo: Obras
                          CREATE TABLE licobras(
                          obr01_sequencial		 int8 NOT NULL default 0,
                          obr01_licitacao			 int8 NOT NULL default 0,
                          obr01_dtlancamento		 date NOT NULL default null,
                          obr01_numeroobra		 int8 NOT NULL default 0,
                          obr01_linkobra			 text NOT NULL ,
                          obr01_tiporesponsavel	 int8 NOT NULL default 0,
                          obr01_responsavel		 int8 NOT NULL default 0,
                          obr01_tiporegistro		 int8 NOT NULL default 0,
                          obr01_numregistro		 text NOT NULL ,
                          obr01_numartourrt		 int8 NOT NULL default 0,
                          obr01_dtinicioatividades date NOT NULL default null,
                          obr01_vinculoprofissional int8 NOT NULL default 0,
                          obr01_instit			  int8 NOT NULL default 0);


                          -- Criando  sequences
                          CREATE SEQUENCE licobras_obr01_sequencial_seq
                          INCREMENT 1
                          MINVALUE 1
                          MAXVALUE 9223372036854775807
                          START 1
                          CACHE 1;

                          -- CHAVE ESTRANGEIRA
                          ALTER TABLE licobras ADD PRIMARY KEY (obr01_sequencial);

                          ALTER TABLE licobras ADD CONSTRAINT licobras_liclicita_fk
                          FOREIGN KEY (obr01_licitacao) REFERENCES liclicita (l20_codigo);

                          -- MENUS

                          --inserindo menu procedimentos
                          INSERT INTO db_menu values(4001223,32,1,4001223);

                          --inserindo menu cadastro de obras
                          INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Obras','Cadastro de Obras','',1,1,'Cdastro de Obras','t');
                          INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),1,4001223)

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusгo','Inclusгo','obr1_licobras001.php',1,1,'Inclusгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Obras%'),(select max(id_item) from db_itensmenu),1,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteraзгo','Alteraзгo','obr1_licobras002.php',1,1,'Alteraзгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Obras%'),(select max(id_item) from db_itensmenu),2,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusгo','Exclusгo','obr1_licobras003.php',1,1,'Exclusгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Obras%'),(select max(id_item) from db_itensmenu),3,4001223);


                          -- TABELAS E ESTRUTURA licobrasituacao

                          -- INSERE db_sysarquivo
                          INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licobrasituacao','cadastro de situacao de obras','obr02','2019-12-21','cadastro de situacao de obras',0,'f','f','f','f');

                          -- INSERE db_sysarqmod
                          INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%Obras%'), (select max(codarq) from db_sysarquivo));

                          -- INSERE db_syscampo
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_sequencial'	 		,'int8' ,'Cуd. Sequencial'				,'', 'Cуd. Sequencial'			 	,11	,false, false, false, 1, 'int8', 'Cуd. Sequencial');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_seqobra'	 		,'int8' ,'Nє Obra' 					,'', 'Nє Obra'	 			 	,11	,false, false, false, 1, 'int8', 'Nє Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_dtlancamento'		,'date' ,'Data Lanзamento'			,'', 'Data Lanзamento'		 	,10	,false, false, false, 0, 'date', 'Data Lanзamento');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_situacao'  			,'int8' ,'Situaзгo'					,'', 'Situaзгo'				 	,16	,false, false, false, 1, 'int8', 'Situaзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_dtsituacao'			,'date' ,'Data Situaзгo'			,'', 'Data Situaзгo'		 	,10	,false, false, false, 0, 'date', 'Data Situaзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_veiculopublicacao'  ,'text' ,'Veнculo Publicaзгo'		,'', 'Veнculo Publicaзгo'	 	,20	,false, false, false, 0, 'text', 'Veнculo Publicaзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_dtpublicacao'			,'date' ,'Data Public. Veic.'			,'', 'Data Public. Veic.'		 	,10	,false, false, false, 0, 'date', 'Data Public. Veic.');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_descrisituacao'  	,'text' ,'Desc. Situaзгo da Obra'	,'', 'Desc. Situaзгo da Obra'	,500,false, false, false, 0, 'text', 'Desc. Situaзгo da Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_motivoparalisacao'  ,'int8' ,'Motivo Paralizaзгo'		,'', 'Motivo Paralizaзгo'		,11	,false, false, false, 1, 'int8', 'Motivo Paralizaзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_dtparalizacao'		,'date' ,'Data Paralizaзгo'			,'', 'Data Paralizaзгo'		 	,10	,false, false, false, 0, 'date', 'Data Paralizaзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_outrosmotivos'  	,'text' ,'Outros Motivos'			,'', 'Outros Motivos'			,500,false, false, false, 0, 'text', 'Outros Motivos');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_dtretomada'			,'date' ,'Data Retomada'			,'', 'Data Retomada'		 	,10	,false, false, false, 0, 'date', 'Data Retomada');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr02_instit'		 		,'int8' ,'Instituiзгo'				,'', 'Instituiзгo'			 	,11	,false, false, false, 1, 'int8', 'Instituiзгo');

                          -- INSERE db_sysarqcamp
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_sequencial')		 , 1, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_seqobra')			 , 2, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_dtlancamento')		 , 3, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_situacao')		 	 , 4, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_dtsituacao')		 , 5, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_veiculopublicacao') , 6, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_dtpublicacao') , 7, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_descrisituacao')	 , 8, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_motivoparalisacao') , 9, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_dtparalizacao')	 , 10, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_outrosmotivos')	 , 11, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_dtretomada')		 , 12, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr02_instit')			 , 13, 0);

                          -- DROP DA TABELA

                          DROP TABLE IF EXISTS licobrasituacao CASCADE;

                          -- Mуdulo: Obras
                          CREATE TABLE licobrasituacao(
                          obr02_sequencial                int8 NOT NULL ,
                          obr02_seqobra           		    int8 NOT NULL ,
                          obr02_dtlancamento              date NOT NULL ,
                          obr02_situacao          		    int8 NOT NULL ,
                          obr02_dtsituacao                date NOT NULL ,
                          obr02_veiculopublicacao         text NOT NULL ,
                          obr02_dtpublicacao              date NOT NULL ,
                          obr02_descrisituacao            text NOT NULL ,
                          obr02_motivoparalisacao         int8 NOT NULL ,
                          obr02_dtparalizacao             date NOT NULL ,
                          obr02_outrosmotivos             text NOT NULL ,
                          obr02_dtretomada                date NOT NULL ,
                          obr02_instit            		    int8 NOT NULL );



                          -- Criando  sequences

                          CREATE SEQUENCE licobrasituacao_obr02_sequencial_seq
                          INCREMENT 1
                          MINVALUE 1
                          MAXVALUE 9223372036854775807
                          START 1
                          CACHE 1;


                          -- CHAVE ESTRANGEIRA
                          ALTER TABLE licobrasituacao ADD PRIMARY KEY (obr02_sequencial);

                          ALTER TABLE licobrasituacao ADD CONSTRAINT licobrasituacao_licobras_fk
                          FOREIGN KEY (obr02_seqobra) REFERENCES licobras (obr01_sequencial);


                          -- MENUS

                          --inserindo menu situacao da obra
                          INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Situaзгo da Obra','Situaзгo da Obra','',1,1,'Situaзгo da Obra','t');
                          INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),2,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusгo','Inclusгo','obr1_licobrasituacao001.php',1,1,'Inclusгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Situaзгo da Obra%'),(select max(id_item) from db_itensmenu),1,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteraзгo','Alteraзгo','obr1_licobrasituacao002.php',1,1,'Alteraзгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Situaзгo da Obra%'),(select max(id_item) from db_itensmenu),2,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusгo','Exclusгo','obr1_licobrasituacao003.php',1,1,'Exclusгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Situaзгo da Obra%'),(select max(id_item) from db_itensmenu),3,4001223);

                          -- TABELAS E ESTRUTURA licobrasmedicao

					                -- INSERE db_sysarquivo
                          INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licobrasmedicao','cadastro medicao de obras','obr03','2020-01-03','cadastro medicao de obras',0,'f','f','f','f');

                    	    -- INSERE db_sysarqmod
                          INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%Obras%'), (select max(codarq) from db_sysarquivo));

  						            -- INSERE db_syscampo
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_sequencial'	 		,'int8' ,'Cуd. Sequencial'			,'', 'Cуd. Sequencial'			,11	,false, false, false, 1, 'int8', 'Cуd. Sequencial');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_seqobra'	 	 		,'int8' ,'Nє Obra' 					,'', 'Nє Obra'	 				,11	,false, false, false, 1, 'int8', 'Nє Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_dtlancamento'	 		,'date' ,'Data Lanзamento'			,'', 'Data Lanзamento'			,10	,false, false, false, 0, 'date', 'Data Lanзamento');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_nummedicao'	 		,'int8' ,'Nє Mediзгo' 				,'', 'Nє Mediзгo' 				,11	,false, false, false, 1, 'int8', 'Nє Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_tipomedicao'	 		,'int8' ,'Tipo de Mediзгo' 			,'', 'Tipo de Mediзгo' 			,11	,false, false, false, 1, 'int8', 'Tipo de Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_dtiniciomedicao'	    ,'date' ,'Inнcio da Mediзгo'		,'', 'Inнcio da Mediзгo'		,10	,false, false, false, 0, 'date', 'Inнcio da Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_outrostiposmedicao'  	,'text' ,'Outros tipos de Mediзгo'	,'', 'Outros tipos de Mediзгo'	,500,false, false, false, 0, 'text', 'Outros tipos de Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_descmedicao'  		,'text' ,'Desc. Mediзгo'			,'', 'Desc. Mediзгo'			,500,false, false, false, 0, 'text', 'Desc. Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_dtfimmedicao'	 		,'date' ,'Fim da Mediзгo'			,'', 'Fim da Mediзгo'			,10	,false, false, false, 0, 'date', 'Fim da Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_dtentregamedicao'	 	,'date' ,'Entrega da Mediзгo'		,'', 'Entrega da Mediзгo'		,10	,false, false, false, 0, 'date', 'Entrega da Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_vlrmedicao'	 		,'float8' ,'Valor Mediзгo' 			,'', 'Valor Mediзгo' 			,11	,false, false, false, 1, 'float8', 'Valor Mediзгo');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr03_instit'		 		,'int8' ,'Instituiзгo'				,'', 'Instituiзгo'			 	,11	,false, false, false, 1, 'int8', 'Instituiзгo');

						              -- INSERE db_sysarqcamp
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_sequencial')		 , 1, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_seqobra')			 , 2, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_dtlancamento')		 , 3, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_nummedicao')		 	 , 4, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_tipomedicao')		 , 5, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_dtiniciomedicao') , 6, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_outrostiposmedicao') , 7, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_descmedicao')	 , 8, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_dtfimmedicao') , 9, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_dtentregamedicao')	 , 10, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_vlrmedicao')	 , 11, 0);
                          INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr03_instit')		 , 12, 0);

                          -- DROP DA TABELA

                          DROP TABLE IF EXISTS licobrasmedicao CASCADE;

                          -- Mуdulo: Obras
                          CREATE TABLE licobrasmedicao(
                          obr03_sequencial                int8 NOT NULL ,
                          obr03_seqobra           		  int8 NOT NULL ,
                          obr03_dtlancamento              date NOT NULL ,
                          obr03_nummedicao          	  int8 NOT NULL ,
                          obr03_tipomedicao          	  int8 NOT NULL ,
                          obr03_dtiniciomedicao           date NOT NULL ,
                          obr03_outrostiposmedicao        text NOT NULL ,
                          obr03_descmedicao 	          text NOT NULL ,
                          obr03_dtfimmedicao              date NOT NULL ,
                          obr03_dtentregamedicao          date NOT NULL ,
                          obr03_vlrmedicao		          float8 NOT NULL ,
                          obr03_instit          		  int8 NOT NULL );

                          -- Criando  sequences

                          CREATE SEQUENCE licobrasmedicao_obr03_sequencial_seq
                          INCREMENT 1
                          MINVALUE 1
                          MAXVALUE 9223372036854775807
                          START 1
                          CACHE 1;

                          -- CHAVE ESTRANGEIRA
                          ALTER TABLE licobrasmedicao ADD PRIMARY KEY (obr03_sequencial);

                          ALTER TABLE licobrasmedicao ADD CONSTRAINT licobrasmedicao_licobras_fk
                          FOREIGN KEY (obr03_seqobra) REFERENCES licobras (obr01_sequencial);

                           -- MENUS

                          --inserindo menu medicao da obra
                          INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Mediзгo da Obra','Mediзгo da Obra','',1,1,'Mediзгo da Obra','t');
                          INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),3,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusгo','Inclusгo','obr1_licobrasmedicao001.php',1,1,'Inclusгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Mediзгo da Obra%'),(select max(id_item) from db_itensmenu),1,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteraзгo','Alteraзгo','obr1_licobrasmedicao002.php',1,1,'Alteraзгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Mediзгo da Obra%'),(select max(id_item) from db_itensmenu),2,4001223);

                          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusгo','Exclusгo','obr1_licobrasmedicao003.php',1,1,'Exclusгo','t');
                          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Mediзгo da Obra%'),(select max(id_item) from db_itensmenu),3,4001223);


                    COMMIT;
SQL;

    }
}
