<?php

use Phinx\Migration\AbstractMigration;

class Eventos1070 extends AbstractMigration
{

    public function change()
    {
        $sql = <<<SQL
        begin;

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'eventos1070                             ', 'eventos1070', 'eso09', '2021-09-08', 'eventos1070', 0, false, false, false, false);
         
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_sequencial                        ', 'int8                                    ', 'eso09_sequencial', '0', 'eso09_sequencial', 19, false, false, false, 1, 'text', 'eso09_sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_tipoprocesso                      ', 'bool                                    ', 'eso09_tipoprocesso', 'f', 'eso09_tipoprocesso', 1, false, false, false, 5, 'text', 'eso09_tipoprocesso');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_nroprocessoadm                    ', 'int8                                    ', 'eso09_nroprocessoadm', '0', 'eso09_nroprocessoadm', 21, false, false, false, 1, 'text', 'eso09_nroprocessoadm');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_indautoria                        ', 'bool                                    ', 'eso09_indautoria', 'f', 'eso09_indautoria', 1, false, false, false, 5, 'text', 'eso09_indautoria');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_indmateriaproc                    ', 'bool                                    ', 'eso09_indmateriaproc', 'f', 'eso09_indmateriaproc', 1, false, false, false, 5, 'text', 'eso09_indmateriaproc');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_obsproc                           ', 'varchar(255)                            ', 'eso09_obsproc', '', 'eso09_obsproc', 255, false, true, false, 0, 'text', 'eso09_obsproc');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_indundfederacao                   ', 'bool                                    ', 'eso09_indundfederacao', 'f', 'eso09_indundfederacao', 1, false, false, false, 5, 'text', '');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_codmuniIBGE                       ', 'int8                                    ', 'eso09_codmuniIBGE', '0', 'eso09_codmuniIBGE', 7, false, false, false, 1, 'text', 'eso09_codmuniIBGE');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_idvara                            ', 'int4                                    ', 'eso09_idvara', '0', 'eso09_idvara', 4, false, false, false, 1, 'text', 'eso09_idvara');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_codsusp                           ', 'int8                                    ', 'eso09_codsusp', '0', 'eso09_codsusp', 14, false, false, false, 1, 'text', 'eso09_codsusp');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_codsuspexigi                      ', 'bool                                    ', 'eso09_codsuspexigi', 'f', 'eso09_codsuspexigi', 1, false, false, false, 5, 'text', 'eso09_codsuspexigi');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_dtdecisao                         ', 'date                                    ', 'eso09_dtdecisao', 'null', 'eso09_dtdecisao', 10, false, false, false, 1, 'text', 'eso09_dtdecisao');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_inddeposito                       ', 'bool                                    ', 'eso09_inddeposito', 'f', 'eso09_inddeposito', 1, false, false, false, 5, 'text', 'eso09_inddeposito');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso09_instit                            ', 'int4                                    ', 'eso09_instit', '0', 'eso09_instit', 5, false, false, false, 1, 'text', 'eso09_instit');
         
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_tipoprocesso'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_nroprocessoadm'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_indautoria'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_indmateriaproc'), 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_obsproc'), 6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_indundfederacao'), 7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_codmuniIBGE'), 8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_idvara'), 9, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_codsusp'), 10, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_codsuspexigi'), 11, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_dtdecisao'), 12, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_inddeposito'), 13, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso09_instit'), 14, 0);
         
        --DROP TABLE:
        DROP TABLE IF EXISTS eventos1070 CASCADE;
      
        
        -- Módulo: esocial
        CREATE TABLE eventos1070(
        eso09_sequencial                int8 NOT NULL default 0,
        eso09_tipoprocesso              int4 NOT NULL default 0,
        eso09_nroprocessoadm            numeric NOT NULL default 0,
        eso09_indautoria                int4 NOT NULL default 0,
        eso09_indmateriaproc            int4 NOT NULL default 0,
        eso09_obsproc           		varchar(255) NOT NULL ,
        eso09_indundfederacao           varchar(2)   NOT NULL ,
        eso09_codmuniIBGE               int8 NOT NULL default 0,
        eso09_idvara            		int4 NOT NULL default 0,
        eso09_codsusp           		int8 NOT NULL default 0,
        eso09_codsuspexigi              int4 NOT NULL default 0,
        eso09_dtdecisao         		date NOT NULL default null,
        eso09_inddeposito               varchar(1) NOT NULL,
        eso09_instit            		int4 NOT NULL default 0);
        
        CREATE SEQUENCE eventos1070_eso09_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        
        -- Criando Menus
        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'S-1070 - Tabela de Processos Administrativos/Judiciais','S-1070 - Tabela de Processos Administrativos/Judiciais','',1,1,'S-1070 - Tabela de Processos Administrativos/Judiciais','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Eventos%'),(select max(id_item) from db_itensmenu),4,10216);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','eso1_eventos1070001.php',1,1,'Inclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%S-1070 - Tabela de Processos Administrativos/Judiciais%'),(select max(id_item) from db_itensmenu),1,(select id_item from db_modulos where descr_modulo like'%eSocial%'));
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','eso1_eventos1070002.php',1,1,'Alteração','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%S-1070 - Tabela de Processos Administrativos/Judiciais%'),(select max(id_item) from db_itensmenu),2,(select id_item from db_modulos where descr_modulo like'%eSocial%'));
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','eso1_eventos1070003.php',1,1,'Exclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%S-1070 - Tabela de Processos Administrativos/Judiciais%'),(select max(id_item) from db_itensmenu),3,(select id_item from db_modulos where descr_modulo like'%eSocial%'));
        
        commit;
SQL;
        $this->execute($sql);
    }
}
