<?php

use Phinx\Migration\AbstractMigration;

class Oc18251 extends AbstractMigration
{
    
    public function up()
    {

        $sql= "INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'tipoanexo','cadastro de tipo de anexos pncp','l213','2022-08-22','cadastro de tipo de anexos pncp',0,'f','f','f','f');


        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l213_sequencial','int8' ,'C�d. Sequencial','', 'C�d. Sequencial',8,false, false, false, 1, 'int8', 'C�d. Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l213_descricao','varchar' ,'Descricao do tipo do anexo pncp','', 'Descricao do tipo do anexo pncp',255 ,false, false, false, 0, 'varchar', 'Descricao do tipo do anexo pncp');


        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l213_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l213_descricao'), 2, 0);


        CREATE TABLE tipoanexo(
        l213_sequencial int8 NOT NULL default 0,
        l213_descricao varchar(150) NOT NULL );


        CREATE SEQUENCE tipoanexo_l213_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        ALTER TABLE tipoanexo ADD PRIMARY KEY (l213_sequencial);


        INSERT INTO licitacao.tipoanexo VALUES (1,'Aviso de Contrata��o Direta');

        INSERT INTO licitacao.tipoanexo VALUES (2,'Edital');

        INSERT INTO licitacao.tipoanexo VALUES (3,'Minuta do Contrato');

        INSERT INTO licitacao.tipoanexo VALUES (4,'Termo de Refer�ncia');

        INSERT INTO licitacao.tipoanexo VALUES (5,'Anteprojeto');

        INSERT INTO licitacao.tipoanexo VALUES (6,'Projeto B�sico');

        INSERT INTO licitacao.tipoanexo VALUES (7,'Estudo T�cnico Preliminar');

        INSERT INTO licitacao.tipoanexo VALUES (8,'Projeto Executivo');

        INSERT INTO licitacao.tipoanexo VALUES (9,'Mapa de Riscos');

        INSERT INTO licitacao.tipoanexo VALUES (10,'DOD');

        INSERT INTO licitacao.tipoanexo VALUES (11,'Ata de Registro de Pre�o');

        INSERT INTO licitacao.tipoanexo VALUES (12,'Contrato');

        INSERT INTO licitacao.tipoanexo VALUES (13,'Termo de Rescis�o');

        INSERT INTO licitacao.tipoanexo VALUES (14,'Termo Aditivo');

        INSERT INTO licitacao.tipoanexo VALUES (15,'Termo de Apostilamento');

        INSERT INTO licitacao.tipoanexo VALUES (16,'Outros');

        INSERT INTO licitacao.tipoanexo VALUES (17,'Nota de Empenho');
        
        
        
        
        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licanexopncp','cadastro de anexos pncp','l215','2022-08-22','cadastro de anexos pncp',0,'f','f','f','f');


        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l215_sequencial','int8' ,'C�d. Sequencial','', 'C�d. Sequencial',8,false, false, false, 1, 'int8', 'C�d. Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l215_liclicita','int8' ,'Processo Licitat�rio','', 'Processo Licitat�rio',8	,false, false, false, 1, 'int8', 'Processo Licitat�rio');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l215_dataanexo','date' ,'data do anexo','', 'data do anexo',16	,false, false, false, 0, 'date', 'data do anexo');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l215_id_usuario','int8' ,'Usuario','', 'Usuario',16	,false, false, false, 0, 'int8', 'Usuario');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l215_hora','varchar' ,'hora','', 'hora',5	,false, false, false, 0, 'varchar', 'hora');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l215_instit','int8' ,'Institui��o','', 'Institui��o',16	,false, false, false, 0, 'int8', 'Institui��o');


        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l215_sequencial')		 	, 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l215_liclicita')			 	, 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l215_dataanexo')		 	, 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l215_id_usuario')		 	, 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l215_hora')		 	, 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l215_instit')		 	, 6, 0);


        CREATE TABLE licanexopncp(
        l215_sequencial         int8 NOT NULL default 0,
        l215_liclicita          int8 NOT NULL default 0,
        l215_dataanexo                date NOT NULL default 0,
        l215_id_usuario                int8 NOT NULL default 0,
        l215_hora                varchar(5) NOT NULL default 0,
        l215_instit                int8 NOT NULL default 0);


        CREATE SEQUENCE licanexopncp_l215_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        ALTER TABLE licanexopncp ADD PRIMARY KEY (l215_sequencial);

        ALTER TABLE licanexopncp ADD CONSTRAINT licanexopncp_liclicita_fk
        FOREIGN KEY (l215_liclicita) REFERENCES liclicita (l20_codigo);
        
        
        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'licanexopncpdocumento','cadastro dos documentos de anexos pncp','l216','2022-08-22','cadastro dos documentosde anexos pncp',0,'f','f','f','f');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_sequencial','int8' ,'C�d. Sequencial','', 'C�d. Sequencial',8,false, false, false, 1, 'int8', 'C�d. Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_licanexospncp','int8' ,'Processo Licitat�rio','', 'Processo Licitat�rio',8	,false, false, false, 1, 'int8', 'Processo Licitat�rio');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_documento','oid' ,'identifica��o documento','', 'identifica��o documento',255	,false, false, false, 1, 'oid', 'identifica��o documento');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_nomedocumento','varchar' ,'Nome documento','', 'Nome documento',255	,false, false, false, 0, 'varchar', 'Nome documento');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_tipoanexo','int8' ,'Tipo do anexo','', 'Tipo do anexo',8	,false, false, false, 1, 'int8', 'Tipo do anexo');



        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_sequencial')		 	, 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_licanexospncp')			 	, 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_documento')		 	, 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_nomedocumento')		 	, 4, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_tipoanexo')		 	, 5, 0);



        CREATE TABLE licanexopncpdocumento(
        l216_sequencial         int8 NOT NULL default 0,
        l216_licanexospncp          int8 NOT NULL default 0,
        l216_documento               varchar(255) NOT NULL default 0,
        l216_nomedocumento                varchar(255) NOT NULL default 0,
        l216_tipoanexo                      int8 NOT NULL default 0);


        CREATE SEQUENCE licanexopncpdocumento_l216_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        ALTER TABLE licanexopncpdocumento ADD PRIMARY KEY (l216_sequencial);

        ALTER TABLE licanexopncpdocumento ADD CONSTRAINT licanexopncpdocumento_liclicita_fk
        FOREIGN KEY (l216_licanexospncp) REFERENCES licanexopncp (l215_sequencial);

        ALTER TABLE licanexopncpdocumento ADD CONSTRAINT licanexopncpdocumento_tipoanexo_fk
        FOREIGN KEY (l216_tipoanexo) REFERENCES tipoanexo (l213_sequencial);";

        $this->execute($sql);




    }
}
