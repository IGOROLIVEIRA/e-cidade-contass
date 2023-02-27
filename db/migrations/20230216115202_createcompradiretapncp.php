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

        ALTER TABLE liccontrolepncp DROP CONSTRAINT liccontrolepncp_l213_licitacao_fkey;
        ALTER TABLE anexocomprapncp DROP CONSTRAINT anexocomprapncp_liclicita_fk;
        ALTER TABLE liccontrolepncp ALTER COLUMN l213_licitacao DROP NOT NULL;
        ";
        $this->execute($sql);
    }
}
