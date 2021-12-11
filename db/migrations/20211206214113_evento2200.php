<?php

use Phinx\Migration\AbstractMigration;

class Evento2200 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE pessoal.rhpessoalmov ADD rh02_tipojornada int4 NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_horarionoturno boolean NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_cnpjcedente varchar(100) NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_mattraborgcedente varchar(100) NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_dataadmisorgcedente date NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_jornadadetrabalho int4 NULL;

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_tipojornada', 'int4', 'Tipo de Jornada', '', 'Tipo de Jornada', 3, false, false, false, 1, 'text', 'Tipo de Jornada');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'rh02_tipojornada'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_horarionoturno', 'boolean', 'Possui Horário Noturno', '', 'Possui Horário Noturno', 3, false, false, false, 1, 'text', 'Possui Horário Noturno');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'rh02_horarionoturno'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_cnpjcedente', 'varchar(100)', 'CNPJ Cedente', '', 'CNPJ Cedente', 3, false, false, false, 1, 'text', 'CNPJ Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (1186, (select codcam from db_syscampo where nomecam = 'rh02_cnpjcedente'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_mattraborgcedente', 'varchar(100)', 'Matricula do Trabalhador no órgão Cedente', '', 'Matricula do Trabalhador no órgão Cedente', 3, false, false, false, 1, 'text', 'Matricula do Trabalhador');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'rh02_mattraborgcedente'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_dataadmisorgcedente', 'date', 'Data de Admissão no órgão Cedente', '', 'Data de Admissão no órgão Cedente', 3, false, false, false, 1, 'text', 'Data de Admissão no órgão Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'rh02_dataadmisorgcedente'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_jornadadetrabalho', 'int4', 'Jornada de Trabalho', '', 'Jornada de Trabalho', 3, false, false, false, 1, 'text', 'Jornada de Trabalho');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'rh02_jornadadetrabalho'), 5, 0);

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Jornada de Trabalho' ,
        'Jornada de Trabalho' ,
        '' ,
        '1' ,
        '1' ,
        'Jornada de Trabalho' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4374 ,(SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Jornada de Trabalho') ,102 ,952 );

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Inclusão' ,
        'Inclusão' ,
        'pes1_jornadadetrabalho001.php' ,
        '1' ,
        '1' ,
        'Inclusão' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( (SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Jornada de Trabalho') ,(select max(id_item) from db_itensmenu) ,102 ,952 );

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Alteração' ,
        'Alteração' ,
        'pes1_jornadadetrabalho002.php' ,
        '1' ,
        '1' ,
        'Alteração' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( (SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Jornada de Trabalho') ,(select max(id_item) from db_itensmenu) ,102 ,952 );

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Exclusão' ,
        'Exclusão' ,
        'pes2_jornadadetrabalho003.php' ,
        '1' ,
        '1' ,
        'Exclusão' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( (SELECT id_item FROM db_itensmenu WHERE descricao ILIKE 'Jornada de Trabalho') ,(select max(id_item) from db_itensmenu) ,102 ,952 );


        --DROP TABLE:
        DROP TABLE IF EXISTS jornadadetrabalho CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS jornadadetrabalho_jt_sequencial_seq;


        -- Criando  sequences
        CREATE SEQUENCE jornadadetrabalho_jt_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        -- TABELAS E ESTRUTURA

        -- Módulo: pessoal
        CREATE TABLE jornadadetrabalho(
        jt_sequencial           int4 NOT NULL default 0,
        jt_nome         varchar(50) NOT NULL ,
        jt_descricao            varchar(100) ,
        CONSTRAINT jornadadetrabalho_sequ_pk PRIMARY KEY (jt_sequencial));

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'jornadadetrabalho                       ', 'jornadadetrabalho', 'jt   ', '2021-12-07', 'jornadadetrabalho', 0, false, false, false, false);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'jt_sequencial                           ', 'int4                                    ', 'Sequencial', '0', 'Sequencial', 10, false, false, false, 1, 'text', 'Sequencial');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select max(codcam) from db_syscampo), 1, (select max(codsequencia) from db_syssequencia));

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'jt_nome                                 ', 'varchar(50)                             ', 'Nome', '', 'Nome', 50, false, true, false, 0, 'text', 'Nome');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select max(codcam) from db_syscampo), 2, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'jt_descricao                            ', 'varchar(100)                            ', 'Descrição', '', 'Descrição', 100, false, true, false, 0, 'text', 'Descrição');
		INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select max(codcam) from db_syscampo), 3, 0);

        INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'jornadadetrabalho_jt_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

        COMMIT;
SQL;
        $this->execute($sql);
    }
}
