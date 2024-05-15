<?php

use Phinx\Migration\AbstractMigration;

class Eventos1020 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
            -- INSERINDO db_sysarquivo
            INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'eventos1020                             ', 'eventos1020', 'eso08', '2021-08-30', 'eventos1020', 0, false, false, false, false);

            -- INSERINDO db_syscampo
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_sequencial                        ', 'int8                                    ', 'eso08_sequencial', '0', 'eso08_sequencial', 20, false, false, true, 1, 'text', 'eso08_sequencial');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codempregadorlotacao              ', 'text                                    ', 'eso08_codempregadorlotacao', '', 'eso08_codempregadorlotacao', 30, false, true, false, 0, 'text', 'eso08_codempregadorlotacao');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codtipolotacao                    ', 'varchar(14)                             ', 'eso08_codtipolotacao', '', 'eso08_codtipolotacao', 14, false, true, false, 0, 'text', 'eso08_codtipolotacao');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codtipoinscricao                  ', 'varchar(14)                             ', 'eso08_codtipoinscricao', '', 'eso08_codtipoinscricao', 14, false, true, false, 0, 'text', 'eso08_codtipoinscricao');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_numeroinscricao                   ', 'varchar(14)                             ', 'eso08_numeroinscricao', '', 'eso08_numeroinscricao', 14, false, true, false, 0, 'text', 'eso08_numeroinscricao');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codfpas                           ', 'int4                                    ', 'eso08_codfpas', '0', 'eso08_codfpas', 3, false, false, false, 1, 'text', 'eso08_codfpas');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codterceiros                      ', 'int4                                    ', 'eso08_codterceiros', '0', 'eso08_codterceiros', 4, false, false, false, 1, 'text', 'eso08_codterceiros');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codterceiroscombinado             ', 'varchar(14)                             ', 'eso08_codterceiroscombinado', '', 'eso08_codterceiroscombinado', 14, false, true, false, 0, 'text', 'eso08_codterceiroscombinado');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codterceirosprocjudicial          ', 'int4                                    ', 'eso08_codterceirosprocjudicial', '0', 'eso08_codterceirosprocjudicial', 4, false, false, false, 1, 'text', 'eso08_codterceirosprocjudicial');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_nroprocessojudicial               ', 'int8                                    ', 'eso08_nroprocessojudicial', '0', 'eso08_nroprocessojudicial', 20, false, false, false, 1, 'text', 'eso08_nroprocessojudicial');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_codindicasuspensao                ', 'int8                                    ', 'eso08_codindicasuspensao', '0', 'eso08_codindicasuspensao', 14, false, false, false, 1, 'text', 'eso08_codindicasuspensao');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_tipoinscricaocontratante          ', 'bool                                    ', 'eso08_tipoinscricaocontratante', 'f', 'eso08_tipoinscricaocontratante', 1, false, false, false, 5, 'text', 'eso08_tipoinscricaocontratante');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_numeroinscricaocontratante        ', 'int8                                    ', 'eso08_numeroinscricaocontratante', '0', 'eso08_numeroinscricaocontratante', 14, false, false, false, 1, 'text', 'eso08_numeroinscricaocontratante');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_tipoinscricaoproprietario         ', 'bool                                    ', 'eso08_tipoinscricaoproprietario', 'f', 'eso08_tipoinscricaoproprietario', 1, false, false, false, 5, 'text', 'eso08_tipoinscricaoproprietario');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_nroinscricaoproprietario          ', 'int8                                    ', 'eso08_nroinscricaoproprietario', '0', 'eso08_nroinscricaoproprietario', 14, false, false, false, 1, 'text', 'eso08_nroinscricaoproprietario');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_aliquotarat                       ', 'bool                                    ', 'eso08_aliquotarat', 'f', 'eso08_aliquotarat', 1, false, false, false, 5, 'text', 'eso08_aliquotarat');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_fatoracidentario                  ', 'float4                                  ', 'eso08_fatoracidentario', '0', 'eso08_fatoracidentario', 5, false, false, false, 4, 'text', 'eso08_fatoracidentario');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'eso08_instit                            ', 'int4                                    ', 'eso08_instit', '0', 'eso08_instit', 1, false, false, false, 1, 'text', 'eso08_instit');

            -- INSERINDO db_syssequencia

            -- INSERINDO db_sysarqcamp
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_sequencial'), 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codempregadorlotacao'), 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codtipolotacao'), 3, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codtipoinscricao'), 4, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_numeroinscricao'), 5, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codfpas'), 6, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codterceiros'), 7, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codterceiroscombinado'), 8, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codterceirosprocjudicial'), 9, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_nroprocessojudicial'), 10, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_codindicasuspensao'), 11, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_tipoinscricaocontratante'), 12, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_numeroinscricaocontratante'), 13, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_tipoinscricaoproprietario'), 14, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_nroinscricaoproprietario'), 15, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_aliquotarat'), 16, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_fatoracidentario'), 17, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'eso08_instit'), 18, 0);

            --DROP TABLE:
            DROP TABLE IF EXISTS eventos1020 CASCADE;
            --Criando drop sequences

            -- Criando  sequences
            -- TABELAS E ESTRUTURA

            -- Módulo: esocial
            CREATE TABLE eventos1020(
            eso08_sequencial                        int8 NOT NULL default 0,
            eso08_codempregadorlotacao              text ,
            eso08_codtipolotacao                    varchar(14) ,
            eso08_codtipoinscricao                  varchar(14) ,
            eso08_numeroinscricao                   varchar(14) ,
            eso08_codfpas                           int4,
            eso08_codterceiros                      int4,
            eso08_codterceiroscombinado             varchar(14),
            eso08_codterceirosprocjudicial          int4,
            eso08_nroprocessojudicial               int8,
            eso08_codindicasuspensao                int8,
            eso08_tipoinscricaocontratante          bool ,
            eso08_numeroinscricaocontratante        int8,
            eso08_tipoinscricaoproprietario         bool ,
            eso08_nroinscricaoproprietario          int8,
            eso08_aliquotarat                       bool ,
            eso08_fatoracidentario                  float4,
            eso08_instit                            int4);

            CREATE SEQUENCE eventos1020_eso08_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            -- Criando Menus
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'S-1020 - Tabela de Lotações Tributárias','S-1020 - Tabela de Lotações Tributárias','',1,1,'S-1020 - Tabela de Lotações Tributárias','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%Cadastro de Eventos%'),(select max(id_item) from db_itensmenu),3,10216);

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','eso1_eventos1020001.php',1,1,'Inclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%S-1020 - Tabela de Lotações Tributárias%'),(select max(id_item) from db_itensmenu),1,(select id_item from db_modulos where descr_modulo like'%eSocial%'));

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','eso1_eventos1020002.php',1,1,'Alteração','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%S-1020 - Tabela de Lotações Tributárias%'),(select max(id_item) from db_itensmenu),2,(select id_item from db_modulos where descr_modulo like'%eSocial%'));

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','eso1_eventos1020003.php',1,1,'Exclusão','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where help like'%S-1020 - Tabela de Lotações Tributárias%'),(select max(id_item) from db_itensmenu),3,(select id_item from db_modulos where descr_modulo like'%eSocial%'));
SQL;
        $this->execute($sql);
    }
}
