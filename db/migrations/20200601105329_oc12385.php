<?php

use Phinx\Migration\AbstractMigration;

class Oc12385 extends AbstractMigration
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
        BEGIN;
        
            SELECT fc_startsession();
            
            ALTER TABLE licobras DROP CONSTRAINT "licobras_liclicita_fk" ;
    
            -- INSERE db_sysarquivo
            INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licobraslicitacao','cadastro de licitacao obras','obr06','2019-12-21','cadastro de licitacao obras',0,'f','f','f','f');
            
            -- INSERE db_sysarqmod
            INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%Obras%'), (select max(codarq) from db_sysarquivo));
            
             -- INSERE db_syscampo
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr07_sequencial'	 		,'int8' ,'Cód. Sequencial'		,'', 'Cód. Sequencial'	 	 ,11	,false, false, false, 1, 'int8', 'Cód. Sequencial');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr07_processo'	 		,'int8' ,'Processo Licitatório' ,'', 'Processo Licitatório'	 ,11	,false, false, false, 1, 'int8', 'Processo Licitatório');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr07_exercicio'		    ,'int8' ,'Exercicio'			,'', 'Exercicio'		 	 ,11	,false, false, false, 0, 'int8', 'Exercicio');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr07_objeto'  			,'text' ,'Objeto'				,'', 'Objeto'				 ,1000	,false, false, false, 1, 'text', 'Objeto');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr07_tipoprocesso'    	,'int8' ,'Tipo Processo'		,'', 'Tipo Processo'		 ,11	,false, false, false, 0, 'int8', 'Tipo Processo');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr07_instit'    			,'int8' ,'instit'				,'', 'instit'		 		 ,11	,false, false, false, 0, 'int8', 'instit');
            
              -- INSERE db_sysarqcamp
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr07_sequencial')		, 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr07_processo')			, 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr07_exercicio')		, 3, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr07_objeto')			, 4, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr07_tipoprocesso')		, 5, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr07_instit')			, 6, 0);
            
             --DROP TABLE:
            DROP TABLE IF EXISTS licobraslicitacao CASCADE;
            --Criando drop sequences
            
            
            -- TABELAS E ESTRUTURA
            
            -- Módulo: licobraslicitacao
            CREATE TABLE licobraslicitacao(
            obr07_sequencial		 int8 NOT NULL ,
            obr07_processo			 int8 NOT NULL ,
            obr07_exercicio		 	 int8 NOT NULL ,
            obr07_objeto		 	 text NOT NULL ,
            obr07_tipoprocesso		 int8 NOT NULL ,
            obr07_instit	 		 int8 NOT NULL 
            );
            
            -- Criando  sequences
            CREATE SEQUENCE licobraslicitacao_obr07_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
            
             -- MENUS
            
            --inserindo menu cadastro
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Licitação Obras','Licitação Obras','',1,1,'Licitação Obras','t');
            INSERT INTO db_menu VALUES(29,(select max(id_item) from db_itensmenu),2,(select id_item from db_modulos where nome_modulo like '%Obras%'));
            
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','obr6_licobraslicitacao001.php',1,1,'Inclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Licitação Obras%'),(select max(id_item) from db_itensmenu),1,(select id_item from db_modulos where nome_modulo like '%Obras%'));
            
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','obr6_licobraslicitacao002.php',1,1,'Alteração','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Licitação Obras%'),(select max(id_item) from db_itensmenu),2,(select id_item from db_modulos where nome_modulo like '%Obras%'));
            
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','obr6_licobraslicitacao003.php',1,1,'Exclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Licitação Obras%'),(select max(id_item) from db_itensmenu),3,(select id_item from db_modulos where nome_modulo like '%Obras%'));
            
            -- adicionando campo tipo de licitacao na tabela licobras
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'obr01_licitacaosistema','int8','Licitação do Sistema','','Licitação do Sistema',11,false, false, false,0,'int8','Licitação do Sistema');
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'obr01_licitacaosistema'),8,0);
            ALTER TABLE licobras ADD column obr01_licitacaosistema int8;
        
        COMMIT;
SQL;
        $this->execute($sql);
    }
}
