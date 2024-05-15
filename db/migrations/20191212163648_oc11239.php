<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc11239 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        --Criação de campos tipo termo, descrição e data de cadastro
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c208_tipotermoaditivo', 'integer', 'Tipo do Termo Aditivo', '', 'Tipo do Termo Aditivo', 10, FALSE, FALSE, FALSE, 1, 'integer', 'Tipo do Termo Aditivo');
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='convdetalhatermos' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c208_tipotermoaditivo'), 9, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c208_dsctipotermoaditivo', 'varchar(250)', 'Descrição Tipo do Termo Aditivo', '', 'Descrição', 250, FALSE, TRUE, FALSE, 1, 'text', 'Tipo do Termo Aditivo');
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='convdetalhatermos' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c208_dsctipotermoaditivo'), 10, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c208_datacadastro', 'date', 'Data de Cadastro', '', 'Data de Cadastro', 10, FALSE, FALSE, FALSE, 1, 'text', 'Data de Cadastro');
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='convdetalhatermos' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c208_datacadastro'), 11  , 0);
                
        ALTER TABLE convdetalhatermos ADD COLUMN c208_tipotermoaditivo INTEGER NOT NULL DEFAULT 0;
        
        ALTER TABLE convdetalhatermos ADD COLUMN c208_dsctipotermoaditivo CHARACTER VARYING(250);

        ALTER TABLE convdetalhatermos ADD COLUMN c208_datacadastro DATE;

        UPDATE convdetalhatermos SET c208_datacadastro = c208_dataassinaturatermoaditivo;

        ALTER TABLE convdetalhatermos ALTER COLUMN c208_datacadastro SET NOT NULL;

        --Criação de tabelas SICOM
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si94_codconvaditivo', 'varchar(20)', 'Código Convênio Aditivo', '', 'Código Convênio Aditivo', 20, FALSE, FALSE, FALSE, 1, 'text', 'Código Convênio Aditivo');
        
        UPDATE db_sysarqcamp ac SET seqarq = seqarq+1 FROM db_syscampo c WHERE ac.seqarq > 5 AND c.nomecam LIKE 'si94%' AND ac.codcam = c.codcam;

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='conv202014' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si94_codconvaditivo'), 6, 0);

        DROP TABLE conv202020;

        CREATE TABLE conv202020 (
            si94_sequencial bigint DEFAULT 0 NOT NULL,
            si94_tiporegistro bigint DEFAULT 0 NOT NULL,
            si94_codorgao character varying(2) NOT NULL,
            si94_nroconvenio character varying(30) NOT NULL,
            si94_dtassinaturaconvoriginal date NOT NULL,
            si94_nroseqtermoaditivo character varying(2) NOT NULL,
            si94_codconvaditivo character varying(20) NOT NULL,
            si94_dscalteracao character varying(500) NOT NULL,
            si94_dtassinaturatermoaditivo date NOT NULL,
            si94_datafinalvigencia date NOT NULL,
            si94_valoratualizadoconvenio double precision DEFAULT 0 NOT NULL,
            si94_valoratualizadocontrapartida double precision DEFAULT 0 NOT NULL,
            si94_mes bigint DEFAULT 0 NOT NULL,
            si94_instit bigint DEFAULT 0
        );

        ALTER TABLE conv202020 OWNER TO dbportal;

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) 
        VALUES ((select max(codarq)+1 from db_sysarquivo), 'conv212020', 'conv212020', 'si232', '2019-12-13', 'conv212020', 0, false, false, false, false);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si232_tiporegistro', 'int8', 'Tipo de Registro', 0, 'Tipo de Registro', 2, FALSE, FALSE, FALSE, 1, 'text', 'Tipo de Registro');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='conv212020' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si232_tiporegistro'), 1, 0);
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si232_codconvaditivo', 'varchar(20)', 'Código Convênio Aditivo', '', 'Código Convênio Aditivo', 20, FALSE, FALSE, FALSE, 1, 'text', 'Código Convênio Aditivo');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='conv212020' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si232_codconvaditivo'), 2, 0);
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si232_tipotermoaditivo', 'varchar(2)', 'Tipo do Termo Aditivo', '', 'Tipo do Termo Aditivo', 2, FALSE, FALSE, FALSE, 1, 'text', 'Tipo do Termo Aditivo');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='conv212020' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si232_tipotermoaditivo'), 3, 0);
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si232_dsctipotermoaditivo', 'varchar(250)', 'Descrição do Tipo do Termo Aditivo', '', 'Descrição do Tipo do Termo Aditivo', 250, FALSE, FALSE, FALSE, 1, 'text', 'Descrição do Tipo do Termo Aditivo');
    
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='conv212020' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si232_dsctipotermoaditivo'), 4, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si232_mes', 'int8', 'Mês', 0, 'Mês', 10, FALSE, FALSE, FALSE, 1, 'text', 'Mês');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='conv212020' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si232_mes'), 5, 0);
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si232_instint', 'int8', 'Instituição', 0, 'Instituição', 10, FALSE, FALSE, FALSE, 1, 'text', 'Instituição');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='conv212020' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si232_instint'), 6, 0);

        CREATE TABLE conv212020 (
            si232_sequencial bigint DEFAULT 0 NOT NULL,
            si232_tiporegistro bigint DEFAULT 0 NOT NULL,
            si232_codconvaditivo character varying(20) NOT NULL,
            si232_tipotermoaditivo character varying(2) NOT NULL,
            si232_dsctipotermoaditivo character varying(250),
            si232_mes bigint DEFAULT 0 NOT NULL,
            si232_instint bigint DEFAULT 0
        );

        ALTER TABLE conv212020 OWNER TO dbportal;

        CREATE SEQUENCE conv212020_si232_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;

        ALTER TABLE conv212020_si232_sequencial_seq OWNER TO dbportal;

        COMMIT;

SQL;
        $this->execute($sql);
    }

}