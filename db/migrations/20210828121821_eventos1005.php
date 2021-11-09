<?php

use Phinx\Migration\AbstractMigration;

class Eventos1005 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        begin;
            -- INSERINDO db_sysarquivo
            INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'eventos1005                             ', 'eventos1005', 'eso06', '2021-08-28', 'eventos1005', 0, false, false, false, false);
            
            -- INSERINDO db_syscampo
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_sequencial                        ', 'int8                                    ', 'Sequencial', '0', 'Sequencial', 20, false, false, false, 1, 'text', 'Sequencial');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_tipoinscricao                     ', 'int4                                    ', 'eso06_tipoinscricao', 'f', 'eso06_tipoinscricao', 1, false, false, false, 5, 'text', 'eso06_tipoinscricao');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_nroinscricaoobra                  ', 'varchar(14)                             ', 'eso06_nroinscricaoobra', 'eso06_nroinscricaoobra', 'eso06_nroinscricaoobra', 14, false, true, false, 0, 'text', 'eso06_nroinscricaoobra');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_codcnaf                           ', 'varchar(7)                              ', 'eso06_codcnaf', '', 'eso06_codcnaf', 7, false, true, false, 0, 'text', 'eso06_codcnaf');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_aliquotarat                       ', 'varchar(1)                              ', 'eso06_aliquotarat', '', 'eso06_aliquotarat', 1, false, true, false, 0, 'text', 'eso06_aliquotarat');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_fatoracidentario                  ', 'varchar(5)                              ', 'eso06_fatoracidentario', '', 'eso06_fatoracidentario', 5, false, true, false, 0, 'text', 'eso06_fatoracidentario');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_codtipoprocessorat                ', 'int4                                    ', 'eso06_codtipoprocessorat', 'eso06_codtipoprocessorat', 'eso06_codtipoprocessorat', 1, false, false, false, 1, 'text', 'eso06_codtipoprocessorat');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_nroprocessos1070rat               ', 'int8                                    ', 'eso06_nroprocessos1070rat', '0', 'eso06_nroprocessos1070rat', 21, false, false, false, 1, 'text', 'eso06_nroprocessos1070rat');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_codindicativosuspensaos1070rat    ', 'int8                                    ', 'eso06_codindicativosuspensaos1070rat', '0', 'eso06_codindicativosuspensaos1070rat', 14, false, false, false, 1, 'text', 'eso06_codindicativosuspensaos1070rat');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_codtipoprocessofap                ', 'int4                                    ', 'eso06_codtipoprocessofap', '0', 'eso06_codtipoprocessofap', 1, false, false, false, 1, 'text', 'eso06_codtipoprocessofap');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_nroprocessos1070fap               ', 'int8                                    ', 'eso06_nroprocessos1070fap', '0', 'eso06_nroprocessos1070fap', 21, false, false, false, 1, 'text', 'eso06_nroprocessos1070fap');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_codindicativosuspensaos1070fap    ', 'int8                                    ', 'eso06_codindicativosuspensaos1070fap', '0', 'eso06_codindicativosuspensaos1070fap', 14, false, false, false, 1, 'text', 'eso06_codindicativosuspensaos1070fap');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_tipocaepf                         ', 'int4                                    ', 'eso06_tipocaepf', '0', 'eso06_tipocaepf', 1, false, false, false, 1, 'text', 'eso06_tipocaepf');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_subscontribuicaoobra              ', 'int4                                    ', 'eso06_subscontribuicaoobra', '0', 'eso06_subscontribuicaoobra', 1, false, false, false, 1, 'text', 'eso06_subscontribuicaoobra');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_nroprocessojudicia                ', 'int8                                    ', 'eso06_nroprocessojudicia', '0', 'eso06_nroprocessojudicia', 20, false, false, false, 1, 'text', 'eso06_nroprocessojudicia');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_nroinscricaoenteducativa          ', 'int8                                    ', 'eso06_nroinscricaoenteducativa', '0', 'eso06_nroinscricaoenteducativa', 14, false, false, false, 1, 'text', 'eso06_nroinscricaoenteducativa');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_nroprocessocontratacaodeficiencia ', 'int8                                    ', 'eso06_nroprocessocontratacaodeficiencia', '0', 'eso06_nroprocessocontratacaodeficiencia', 20, false, false, false, 1, 'text', 'eso06_nroprocessocontratacaodeficiencia');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso06_instit                            ', 'int4                                    ', 'eso06_instit', '0', 'eso06_instit', 1, false, false, false, 1, 'text', 'eso06_instit');
             
            -- INSERINDO db_syssequencia
             
            -- INSERINDO db_sysarqcamp
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_sequencial'), 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_tipoinscricao'), 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_nroinscricaoobra'), 3, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_codcnaf'), 4, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_aliquotarat'), 5, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_fatoracidentario'), 6, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_codtipoprocessorat'), 7, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_nroprocessos1070rat'), 8, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_codindicativosuspensaos1070rat'), 9, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_codtipoprocessofap'), 10, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_nroprocessos1070fap'), 11, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_codindicativosuspensaos1070fap'), 12, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_tipocaepf'), 13, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_subscontribuicaoobra'), 14, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_nroprocessojudicia'), 15, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_nroinscricaoenteducativa'), 16, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_nroprocessocontratacaodeficiencia'), 17, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso06_instit'), 18, 0);
             
            -- INSERINDO db_sysforkey
             
            
            
            --DROP TABLE:
            DROP TABLE IF EXISTS eventos1005 CASCADE;
            --Criando drop sequences
            
            
            -- Criando  sequences
            -- TABELAS E ESTRUTURA
            
            -- Módulo: esocial
            CREATE TABLE eventos1005(
            eso06_sequencial                		int8 NOT NULL default 0,
            eso06_tipoinscricao             		int4,
            eso06_nroinscricaoobra          		varchar(14),
            eso06_codcnaf           				varchar(7)  ,
            eso06_aliquotarat               		varchar(1)  ,
            eso06_fatoracidentario          		varchar(5)  ,
            eso06_codtipoprocessorat                int4,
            eso06_nroprocessos1070rat               int8,
            eso06_codindicativosuspensaos1070rat    int8,
            eso06_codtipoprocessofap                int4,
            eso06_nroprocessos1070fap               int8,
            eso06_codindicativosuspensaos1070fap    int8,
            eso06_tipocaepf         				int4,
            eso06_subscontribuicaoobra              int4,
            eso06_nroprocessojudicia                int8,
            eso06_nroinscricaoenteducativa          int8,
            eso06_nroprocessocontratacaodeficiencia int8,
            eso06_instit			  				int8);
            
            -- Criando  sequences
            CREATE SEQUENCE eventos1005_eso06_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
            
            -- Criando Menus
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'S-1005 - Tabela de Estabelecimentos','S-1005 - Tabela de Estabelecimentos','',1,1,'S-1005 - Tabela de Estabelecimentos','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Eventos%'),(select max(id_item) from db_itensmenu),2,10216);
            
            
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','eso1_eventos1005001.php',1,1,'Inclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'S-1005 - Tabela de Estabelecimentos'),(select max(id_item) from db_itensmenu),1,(select id_item from db_modulos where descr_modulo like'%eSocial%'));
            
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','eso1_eventos1005002.php',1,1,'Alteração','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'S-1005 - Tabela de Estabelecimentos'),(select max(id_item) from db_itensmenu),2,(select id_item from db_modulos where descr_modulo like'%eSocial%'));
            
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','eso1_eventos1005003.php',1,1,'Exclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'S-1005 - Tabela de Estabelecimentos'),(select max(id_item) from db_itensmenu),3,(select id_item from db_modulos where descr_modulo like'%eSocial%'));
      commit;
SQL;
    $this->execute($sql);
    }
}
