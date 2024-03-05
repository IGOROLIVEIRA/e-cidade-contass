<?php

use Phinx\Migration\AbstractMigration;

class Oc18547 extends AbstractMigration
{

    public function up()
    {
        $sql = "BEGIN;

        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Ata de Registro de Preço','Ata de Registro de Preço','',1,1,'Ata de Registro de Preço','t');
        INSERT INTO db_menu VALUES(1818,(select max(id_item) from db_itensmenu),7,381);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','lic1_licatareg002.php',1,1,'Inclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Ata de Registro%'),(select max(id_item) from db_itensmenu),1,381);

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','lic1_licatareg002.php',1,1,'Alteração','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Ata de Registro%'),(select max(id_item) from db_itensmenu),2,381);

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','lic1_licatareg002.php',1,1,'Exclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Ata de Registro%'),(select max(id_item) from db_itensmenu),3,381);

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Gerar Autorizção','Gerar Autorizção','lic1_licatareg002.php',1,1,'Gerar Autorizção','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Ata de Registro%'),(select max(id_item) from db_itensmenu),4,381);

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Reequilíbrio','Reequilíbrio','lic1_licatareg002.php',1,1,'Reequilíbrio','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Ata de Registro%'),(select max(id_item) from db_itensmenu),5,381);

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Desistência','Desistência','lic1_licatareg002.php',1,1,'Desistência','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Ata de Registro%'),(select max(id_item) from db_itensmenu),6,381);

        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licatareg','cadastro de ata de registro de preco','l221','2022-10-07','cadastro de ata de registro de preco',0,'f','f','f','f');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_sequencial'	 		,'int8' ,'Sequencial'			,'', 'Sequencial'			 ,11	,false, false, false, 1, 'int8', 'Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_licitacao'	 		,'int8' ,'Licitação' ,'', 'Licitação'	 ,11	,false, false, false, 1, 'int8', 'Licitação');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_numata'		,'varchar' ,'N�mero da Ata'		,'', 'N�mero da Ata'		 ,16	,false, false, false, 1, 'varchar', 'N�mero da Ata');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_exercicio'  		,'varchar' ,'Exercício da Ata'				,'', 'Exercício da Ata'				 ,4	,false, false, false, 1, 'varchar', 'Exercício da Ata');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_fornecedor'    		,'int8' ,'Fornecedor'			,'', 'Fornecedor'			 ,11	,false, false, false, 0, 'int8', 'Fornecedor');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_dataini'	,'date' ,'Data Inicio da Ata'		,'', 'Data Inicio da Ata'		 ,16	,false, false, false, 0, 'date', 'Data Inicio da Ata');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_datafinal'	,'date' ,'Data Final da Ata'		,'', 'Data Final da Ata'		 ,16	,false, false, false, 0, 'date', 'Data Final da Ata');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_datapublica'	,'date' ,'Data de Publicação'		,'', 'Data de Publicação'		 ,16	,false, false, false, 0, 'date', 'Data de Publicação');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l221_veiculopublica','text' ,'Veículo de Publicação'	,'', 'Veículo de Publicação'		 ,255	,false, false, false, 1, 'text', 'Veículo de Publicação');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_sequencial')		 	, 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_licitacao')			 	, 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_numata')		 	, 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_exercicio')		 	, 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_fornecedor')		 	, 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_dataini')			 	, 6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_datafinal')	 	, 7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_datapublica')		 	, 8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l221_veiculopublica')		 	, 9, 0);

        CREATE TABLE licatareg(
            l221_sequencial		 int8 NOT NULL default 0,
            l221_licitacao			 int8 NOT NULL default 0,
            l221_numata		 varchar(255) NOT NULL,
            l221_exercicio		 varchar(255) NOT NULL,
            l221_fornecedor			 int8 NOT NULL default 0,
            l221_dataini	 date NOT NULL,
            l221_datafinal		 date NOT NULL,
            l221_datapublica		 date,
            l221_veiculopublica		 text);
        
        ALTER TABLE licatareg ADD PRIMARY KEY (l221_sequencial);

        ALTER TABLE licatareg ADD CONSTRAINT licatareg_liclicita_fk
        FOREIGN KEY (l221_licitacao) REFERENCES liclicita (l20_codigo);

        ALTER TABLE licatareg ADD CONSTRAINT licatareg_cgm_fk
        FOREIGN KEY (l221_fornecedor) REFERENCES cgm (z01_numcgm);

        CREATE SEQUENCE licatareg_l221_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licataregitem','cadastro dos itens ata de registro de preco','l222','2022-10-07','cadastro dos itens ata de registro de preco',0,'f','f','f','f');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_licatareg'	 		,'int8' ,'Sequencial'			,'', 'Sequencial'			 ,11	,false, false, false, 1, 'int8', 'Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_ordem'	 		,'int4' ,'Ordem' ,'', 'Ordem'	 ,11	,false, false, false, 1, 'int4', 'Ordem');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_item'		,'int8' ,'Item'		,'', 'Item'		 ,11	,false, false, false, 0, 'int8', 'Item');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_descricao'  		,'varchar' ,'Descrição Item'				,'', 'Descrição Item'				 ,255	,false, false, false, 1, 'varchar', 'Descrição Item');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_unidade'    		,'varchar' ,'Unidade'			,'', 'Unidade'			 ,255	,false, false, false, 0, 'int8', 'Unidade');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_quantidade'	,'float8' ,'Quatidade'		,'', 'Quatidade'		 ,16	,false, false, false, 0, 'float8', 'Quatidade');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_valorunit'	,'float8' ,'Valor Unitario'		,'', 'Valor Unitario'		 ,16	,false, false, false, 0, 'float8', 'Valor Unitario');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l222_valortot'	,'float8' ,'Valor Total'		,'', 'Valor Total'		 ,16	,false, false, false, 0, 'float8', 'Valor Total');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_licatareg')		 	, 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_ordem')			 	, 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_item')		 	, 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_descricao')		 	, 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_unidade')		 	, 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_quantidade')			 	, 6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_valorunit')	 	, 7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l222_valortot')		 	, 8, 0);

        CREATE TABLE licataregitem(
            l222_licatareg		 int8 NOT NULL default 0,
            l222_ordem			 int4 NOT NULL default 0,
            l222_item		 int8 NOT NULL default 0,
            l222_descricao		 varchar(255) NOT NULL,
            l222_unidade			 varchar(255) NOT NULL,
            l222_quantidade	 float8 NOT NULL default 0,
            l222_valorunit		 float8 NOT NULL default 0,
            l222_valortot		 float8 NOT NULL default 0);

        ALTER TABLE licataregitem ADD CONSTRAINT licataregitem_licatareg_fk
        FOREIGN KEY (l222_licatareg) REFERENCES licatareg (l221_sequencial);

        COMMIT;
        ";

        $this->execute($sql);
    }
}
