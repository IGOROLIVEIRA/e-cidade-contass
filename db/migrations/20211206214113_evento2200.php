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

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_tipojornada', 'int4', 'Tipo de Jornada', '', 'Tipo de Jornada', 3, false, false, false, 1, 'text', 'Tipo de Jornada');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'rh02_tipojornada'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_horarionoturno', 'boolean', 'Possui Hor�rio Noturno', '', 'Possui Hor�rio Noturno', 3, false, false, false, 1, 'text', 'Possui Hor�rio Noturno');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'rh02_horarionoturno'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_cnpjcedente', 'varchar(100)', 'CNPJ Cedente', '', 'CNPJ Cedente', 3, false, false, false, 1, 'text', 'CNPJ Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (1186, (select codcam from db_syscampo where nomecam = 'rh02_cnpjcedente'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_mattraborgcedente', 'varchar(100)', 'Matricula do Trabalhador no �rg�o Cedente', '', 'Matricula do Trabalhador no �rg�o Cedente', 3, false, false, false, 1, 'text', 'Matricula do Trabalhador no �rg�o Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'rh02_mattraborgcedente'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_dataadmisorgcedente', 'date', 'Data de Admiss�o no �rg�o Cedente', '', 'Data de Admiss�o no �rg�o Cedente', 3, false, false, false, 1, 'text', 'Data de Admiss�o no �rg�o Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'rh02_dataadmisorgcedente'), 5, 0);

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Jornada de Trabalho' ,
        'Jornada de Trabalho' ,
        '' ,
        '1' ,
        '1' ,
        'Jornada de Trabalho' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4374 ,4001447 ,102 ,952 );

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Inclus�o' ,
        'Inclus�o' ,
        'pes1_jornadadetrabalho001.php' ,
        '1' ,
        '1' ,
        'Inclus�o' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4001447 ,(select max(id_item) from db_itensmenu) ,102 ,952 );

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Altera��o' ,
        'Altera��o' ,
        'pes1_jornadadetrabalho002.php' ,
        '1' ,
        '1' ,
        'Altera��o' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4001447 ,(select max(id_item) from db_itensmenu) ,102 ,952 );

        insert 	into	db_itensmenu( id_item ,	descricao ,	help ,	funcao ,	itemativo ,	manutencao ,	desctec ,	libcliente )
        values ( (select max(id_item)+1 from db_itensmenu) ,
        'Exclus�o' ,
        'Exclus�o' ,
        'pes2_jornadadetrabalho003.php' ,
        '1' ,
        '1' ,
        'Exclus�o' ,
        'true' );

        insert into db_menu( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4001447 ,(select max(id_item) from db_itensmenu) ,102 ,952 );


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

        -- M�dulo: pessoal
        CREATE TABLE jornadadetrabalho(
        jt_sequencial           int4 NOT NULL default 0,
        jt_nome         varchar(50) NOT NULL ,
        jt_descricao            varchar(100) ,
        CONSTRAINT jornadadetrabalho_sequ_pk PRIMARY KEY (jt_sequencial));

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
