<?php

use Phinx\Migration\AbstractMigration;

class Createcompradiretapncp extends AbstractMigration
{
    public function up()
    {
        $sql = "
            alter table pcproc add column pc80_numdispensa int8;
            alter table pcproc add column pc80_dispvalor bool;
            alter table pcproc add column pc80_orcsigiloso bool;
            alter table pcproc add column pc80_subcontratacao bool;
            alter table pcproc add column pc80_dadoscomplementares text;        
            alter table pcproc add column pc80_amparolegal int8;

            INSERT INTO db_menu VALUES(32,(select id_item from db_itensmenu where descricao='PNCP'),51,28);

            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Dispensa por Valor', 'Dispensa por Valor', 'com1_pncpdispensaporvalor001.php', 1, 1, 'Dispensa por Valor', 't');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),1,28);

            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Anexos PNCP', 'Anexos PNCP', 'com1_pncpanexosdispensaporvalor001.php', 1, 1, 'Anexos PNCP', 't');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Processo de compras'),(select max(id_item) from db_itensmenu),5,28);

            alter table liccontrolepncp add column l213_processodecompras int8;   
            
            INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'anexocomprapncp','cadastro de anexos pncp','l216','2022-08-22','cadastro de anexos pncp',0,'f','f','f','f');

            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_sequencial','int8' ,'Cd. Sequencial','', 'Cd. Sequencial',8,false, false, false, 1, 'int8', 'Cd. Sequencial');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_codproc','int8' ,'Processo de Compras','', 'Processo de Compras',8   ,false, false, false, 1, 'int8', 'Processo de Compras');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_dataanexo','date' ,'data do anexo','', 'data do anexo',16    ,false, false, false, 0, 'date', 'data do anexo');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_id_usuario','int8' ,'Usuario','', 'Usuario',16   ,false, false, false, 0, 'int8', 'Usuario');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_hora','varchar' ,'hora','', 'hora',5 ,false, false, false, 0, 'varchar', 'hora');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l216_instit','int8' ,'Instituição','', 'Instituição',16   ,false, false, false, 0, 'int8', 'Instituição');


            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_sequencial')            , 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_codproc')             , 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_dataanexo')         , 3, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_id_usuario')            , 4, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_hora')          , 5, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l216_instit')            , 6, 0);


            CREATE TABLE anexocomprapncp(
            l216_sequencial         int8 NOT NULL default 0,
            l216_codproc            int8 NOT NULL default 0,
            l216_dataanexo          date NOT NULL,
            l216_id_usuario         int8 NOT NULL default 0,
            l216_hora               varchar(5) NOT NULL default 0,
            l216_instit             int8 NOT NULL default 0);


            CREATE SEQUENCE anexocomprapncp_l216_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;


            ALTER TABLE anexocomprapncp ADD PRIMARY KEY (l216_sequencial);

            ALTER TABLE anexocomprapncp ADD CONSTRAINT anexocomprapncp_liclicita_fk
            FOREIGN KEY (l216_codproc) REFERENCES pcproc (pc80_codproc);


            INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'comanexopncpdocumento','cadastro dos documentos de anexos pncp','l216','2022-08-22','cadastro dos documentosde anexos pncp',0,'f','f','f','f');

            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_sequencial','int8' ,'Cd. Sequencial','', 'Cd. Sequencial',8,false, false, false, 1, 'int8', 'Cd. Sequencial');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_licanexospncp','int8' ,'Processo Licitatorio','', 'Processo Licitatorio',8   ,false, false, false, 1, 'int8', 'Processo Licitatorio');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_documento','oid' ,'identificao documento','', 'identificao documento',255    ,false, false, false, 1, 'oid', 'identificao documento');
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_nomedocumento','varchar' ,'Nome documento','', 'Nome documento',255  ,false, false, false, 0, 'varchar', 'Nome documento');

            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_tipoanexo','int8' ,'Tipo do anexo','', 'Tipo do anexo',8 ,false, false, false, 1, 'int8', 'Tipo do anexo');



            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_sequencial')            , 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_licanexospncp')             , 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_documento')         , 3, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_nomedocumento')         , 4, 0);

            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_tipoanexo')         , 5, 0);


            CREATE TABLE comanexopncpdocumento(
            l217_sequencial         int8 NOT NULL default 0,
            l217_licanexospncp          int8 NOT NULL default 0,
            l217_documento               varchar(255) NOT NULL default 0,
            l217_nomedocumento                varchar(255) NOT NULL default 0,
            l217_tipoanexo                      int8 NOT NULL default 0);


            CREATE SEQUENCE comanexopncpdocumento_l217_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;


            ALTER TABLE comanexopncpdocumento ADD PRIMARY KEY (l217_sequencial);

            ALTER TABLE comanexopncpdocumento ADD CONSTRAINT comanexopncpdocumento_pcproc_fk
            FOREIGN KEY (l217_licanexospncp) REFERENCES anexocomprapncp (l216_sequencial);

            ALTER TABLE comanexopncpdocumento ADD CONSTRAINT comanexopncpdocumento_tipoanexo_fk
            FOREIGN KEY (l217_tipoanexo) REFERENCES tipoanexo (l213_sequencial);

        ";
        $this->execute($sql);
    }
}
