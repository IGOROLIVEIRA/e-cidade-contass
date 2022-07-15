<?php

use Phinx\Migration\AbstractMigration;

class Oc17285 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();
        
        --DROP TABLE:
        DROP TABLE IF EXISTS fornemensalemp CASCADE;

        /* TABELAS E ESTRUTURA */
        -- Módulo: empenho
        CREATE TABLE fornemensalemp(
        fm101_sequencial	int4 NOT NULL default 0,
        fm101_numcgm		int4 NOT NULL default 0,
        fm101_datafim		date default null);


        -- Criando  sequences
        CREATE SEQUENCE fornemensalemp_fm101_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1;

        -- CHAVE ESTRANGEIRA
        ALTER TABLE fornemensalemp ADD CONSTRAINT fornemensalemp_numcgm_fk FOREIGN KEY (fm101_numcgm) REFERENCES cgm(z01_numcgm) MATCH FULL DEFERRABLE;

        -- INDICES
        CREATE  INDEX fornemensalemp_fm101_sequencial_index ON fornemensalemp(fm101_sequencial);
        CREATE  INDEX fornemensalemp_fm101_numcgm_index ON fornemensalemp(fm101_numcgm);

        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'fornemensalemp','fornemensalemp','fm101','2022-01-01','Cadastro de Fornecedores Mensais',0,'f','f','f','f');

        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'fm101_sequencial'	,'int8' ,'Cód. Sequencial',         '', 'Cód. Sequencial'		 ,11 , FALSE, FALSE, FALSE, 1, 'int8', 'Cód. Sequencial');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'fm101_numcgm'	 	,'int8' ,'NumCGM Fornecedor',       '', 'NumCGM Fornecedor'	     ,11 , FALSE, FALSE, FALSE, 1, 'int8', 'NumCGM Fornecedor');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'fm101_datafim'	,'date' ,'Data Final Fornecedor',   '', 'Data Final'	         ,16 , FALSE, FALSE, FALSE, 0, 'date', 'Data Final Fornecedor');

        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'fm101_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'fm101_numcgm'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'fm101_datafim'), 3, 0);

        --inserindo menu Cadastro de Fornecedores Mensais
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu),'Fornecedores Mensais','Fornecedores Mensais','',1,1,'Fornecedores Mensais','t');
        INSERT INTO db_menu VALUES(29,(SELECT max(id_item) FROM db_itensmenu),8,398);

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Inclusão','Inclusão','emp1_fornemensalemp001.php',1,1,'Inclusão','t');
        INSERT INTO db_menu VALUES((SELECT id_item FROM db_itensmenu WHERE help LIKE'%Fornecedores Mensais%'),(SELECT max(id_item) FROM db_itensmenu),1,398);

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Alteração','Alteração','emp1_fornemensalemp002.php',1,1,'Alteração','t');
        INSERT INTO db_menu VALUES((SELECT id_item FROM db_itensmenu WHERE help LIKE'%Fornecedores Mensais%'),(SELECT max(id_item) FROM db_itensmenu),2,398);

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Exclusão','Exclusão','emp1_fornemensalemp003.php',1,1,'Exclusão','t');
        INSERT INTO db_menu VALUES((SELECT id_item FROM db_itensmenu WHERE help LIKE'%Fornecedores Mensais%'),(SELECT max(id_item) FROM db_itensmenu),3,398);

        -- Inserindo menu Relatorio de Fornecedores Mensais
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Fornecedores Mensais', 'Fornecedores Mensais','emp2_fornemensalemp001.php',1,1,'','t');

        INSERT INTO db_menu VALUES
       ((SELECT id_item FROM db_itensmenu
         WHERE descricao LIKE 'Relatorio de Conferencia'),

        (SELECT max(id_item) FROM db_itensmenu),

        (SELECT max(menusequencia)+1 FROM db_menu
         WHERE id_item =
               (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'Relatorio de Conferencia')
           AND modulo = 398),

        398);
       
       
        COMMIT;

SQL;
        $this->execute($sql);
    } 
}