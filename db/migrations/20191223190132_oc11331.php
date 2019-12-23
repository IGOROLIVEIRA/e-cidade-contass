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
                          INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licobras','cadastro de obras','obr01','2019-12-21','cadastro de obras',0,'f','f','f','f')
                          
                          -- INSERE db_sysarqmod
                          INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select max(codmod) from db_sysmodulo), (select max(codarq) from db_sysarquivo));
                          
                          -- INSERE db_syscampo
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_sequencial'	 		,'int4' ,'Sequencial'			,'', 'Sequencial'			 ,11	,false, false, false, 1, 'int4', 'Sequencial');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_processo'	 		,'int4' ,'Processo Licitatуrio' ,'', 'Processo Licitatуrio'	 ,11	,false, false, false, 1, 'int4', 'Processo Licitatуrio');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_dtlancamento'		,'date' ,'Data Lanзamento'		,'', 'Data Lanзamento'		 ,16	,false, false, false, 0, 'date', 'Data Lanзamento');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_numeroobra'  		,'int4' ,'Nє Obra'				,'', 'Nє Obra'				 ,16	,false, false, false, 1, 'int4', 'Nє Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_linkobra'    		,'text' ,'Link da Obra'			,'', 'Link da Obra'			 ,200	,false, false, false, 0, 'text', 'Link da Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_tiporesponsavel'	,'int4' ,'Tipo Responsбvel'		,'', 'Tipo Responsбvel'		 ,16	,false, false, false, 1, 'int4', 'Tipo Responsбvel');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_responsavel'		,'int4' ,'Responsбvel'			,'', 'Responsбvel'			 ,16	,false, false, false, 1, 'int4', 'Responsбvel');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_tiporegistro'		,'int4' ,'Tipo Registro'		,'', 'Tipo Registro'		 ,16	,false, false, false, 1, 'int4', 'Tipo Registro');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_numregistro'		,'text' ,'Numero Registro'		,'', 'Numero Registro'		 ,10	,false, false, false, 1, 'int4', 'Numero Registro');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_numartourrt'		,'int4' ,'Numero da ART ou RRT' ,'', 'Numero da ART ou RRT'	 ,16	,false, false, false, 1, 'int4', 'Numero da ART ou RRT');         
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_dtinicioatividades'	,'date' ,'Data Inicio das Ativ. do Eng na Obra'		,'', 'Data Inicio das Ativ. do Eng na Obra'		 ,16	,false, false, false, 0, 'date', 'Data Inicio das Ativ. do Eng na Obra');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_vinculoprofissional','int4' ,'Vinculo do Prof. com a Adm. Pъblica'	,'', 'Vinculo do Prof. com a Adm. Pъblica'		 ,16	,false, false, false, 1, 'int4', 'Vinculo do Prof. com a Adm. Pъblica');
                          INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_instit'				,'int4' ,'Instituiзгo'	,'', 'Instituiзгo'		 ,16	,false, false, false, 1, 'int4', 'Instituiзгo');
                          
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
                          obr01_sequencial		 int4 NOT NULL default 0,
                          obr01_licitacao			 int4 NOT NULL default 0,
                          obr01_dtlancamento		 date NOT NULL default null,
                          obr01_numeroobra		 int4 NOT NULL default 0,
                          obr01_linkobra			 text NOT NULL ,
                          obr01_tiporesponsavel	 int4 NOT NULL default 0,
                          obr01_responsavel		 int4 NOT NULL default 0,
                          obr01_tiporegistro		 int4 NOT NULL default 0,
                          obr01_numregistro		 text NOT NULL ,
                          obr01_numartourrt		 int4 NOT NULL default 0,
                          obr01_dtinicioatividades date NOT NULL default null,
                          obr01_vinculoprofissional int4 NOT NULL default 0,
                          obr01_vinculoprofissional int4 NOT NULL default 0,
                          obr01_instit			  int4 NOT NULL default 0);
                          
                          
                          -- Criando  sequences
                          CREATE SEQUENCE licobras_obr01_sequencial_seq
                          INCREMENT 1
                          MINVALUE 1
                          MAXVALUE 9223372036854775807
                          START 1
                          CACHE 1;
                          
                          
                          -- CHAVE ESTRANGEIRA
                          
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
SQL;

    }
}
