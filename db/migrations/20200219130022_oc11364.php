<?php

use Phinx\Migration\AbstractMigration;

class Oc11364 extends AbstractMigration
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
    public function up()
    {
      $sql = <<<SQL
             BEGIN ;
             SELECT fc_startsession();
                --adicionado campo pc01_obras a tabela pcmater
                ALTER TABLE pcmater ADD column pc01_obras boolean;

                -- TABELAS E ESTRUTURA licitemobra

                -- INSERE db_sysarquivo
                INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licitemobra','cadastro itens da obra','obr06','2019-12-21','cadastro itens da obra',0,'f','f','f','f');

                -- INSERE db_sysarqmod
                INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%Obras%'), (select max(codarq) from db_sysarquivo));

                -- INSERE db_syscampo
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_sequencial'	 		,'int8' ,'Cód. Sequencial'			,'', 'Cód. Sequencial'			,11	,false, false, false, 1, 'int8', 'Cód. Sequencial');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_pcmater'	 		,'int8' ,'Material' 				,'', 'Material'	 			 	,11	,false, false, false, 1, 'int8', 'Material');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_tabela'				,'int4' ,'Tabela'					,'', 'Tabela'		 			,10	,false, false, false, 0, 'int4', 'Tabela');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_descricaotabela'	,'text' ,'Descrição da Tabela'		,'', 'Descrição da Tabela'		,250,false, false, false, 0, 'text', 'Descrição da Tabela');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_codigotabela'		,'text' ,'Código da Tabela'			,'', 'Código da Tabela'			,15	,false, false, false, 0, 'text', 'Código da Tabela');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_versaotabela'		,'text' ,'Versão da Tabela'			,'', 'Versão da Tabela'			,15	,false, false, false, 0, 'text', 'Versão da Tabela');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_dtregistro'			,'date' ,'Data do Registro'			,'', 'Data do Registro'		 	,10	,false, false, false, 0, 'date', 'Data do Registro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_dtcadastro'     ,'date' ,'Data de Cadastro'     ,'', 'Data de Cadastro'     ,10 ,false, false, false, 0, 'date', 'Data de Cadastro');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr06_instit'				,'int4' ,'Instituição'				,'', 'Instituição'		 		,10	,false, false, false, 0, 'int4', 'Instituição');

                -- INSERE db_sysarqcamp
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_sequencial')		 , 1, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_pcmater')			 , 2, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_tabela')		 	 , 3, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_descricaotabela')	 , 4, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_codigotabela')		 , 5, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_versaotabela') 	 , 6, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_dtregistro') 		 , 7, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_instit')	 		 , 8, 0);
                INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr06_dtcadastro')      , 9, 0);

                -- DROP DA TABELA

                DROP TABLE IF EXISTS licitemobra CASCADE;

                -- Módulo: Obras
                CREATE TABLE licitemobra(
                obr06_sequencial                int8  ,
                obr06_pcmater           		int8  ,
                obr06_tabela              		int4  ,
                obr06_descricaotabela          	text  ,
                obr06_codigotabela              varchar(15)  ,
                obr06_versaotabela         		varchar(15)  ,
                obr06_dtregistro              	date  ,
                obr06_dtcadastro            date,
                obr06_instit            		int4);

                -- Criando  sequences

                CREATE SEQUENCE licitemobra_obr06_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

                -- CHAVE ESTRANGEIRA
                ALTER TABLE licitemobra ADD PRIMARY KEY (obr06_sequencial);

                ALTER TABLE licitemobra ADD CONSTRAINT licitemobra_pcmater_fk
                FOREIGN KEY (obr06_pcmater) REFERENCES pcmater (pc01_codmater);

                --inserindo menu cadastros
                INSERT INTO db_menu values(4001223,29,1,4001223);

                --menus
                --inserindo menu cadastros de item obra
                INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Itens Obra','Itens Obra','',1,1,'Itens Obra','t');
                INSERT INTO db_menu VALUES(29,(select max(id_item) from db_itensmenu),1,4001223);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','obr1_licitemobra001.php',1,1,'Inclusão','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Itens Obra%'),(select max(id_item) from db_itensmenu),1,4001223);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','obr1_licitemobra002.php',1,1,'Alteração','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Itens Obra%'),(select max(id_item) from db_itensmenu),2,4001223);

                INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','obr1_licitemobra003.php',1,1,'Exclusão','t');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Itens Obra%'),(select max(id_item) from db_itensmenu),3,4001223);
             COMMIT;
SQL;
      $this->execute($sql);
    }
}
