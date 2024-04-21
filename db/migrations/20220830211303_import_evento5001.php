<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class ImportEvento5001 extends PostgresMigration
{

    public function up()
    {
        $this->insertMenu();
        $this->createTableEvt();
        $this->insertDicionarioDados();
    }

    public function down()
    {
        $this->dropTableEvt();
    }

    private function insertMenu() 
    {
        if (!$this->checkMenu()) {
            return;
        }
        $sql = <<<SQL

        SELECT fc_startsession();

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Totalizadores',
            'Totalizadores',
            '',
            1,
            1,
            'Totalizadores',
            't');

        INSERT INTO db_menu 
        VALUES (31,
            (SELECT MAX(id_item) FROM db_itensmenu),
            1,
            10216);

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Empregado/Servidor/Autônomo',
            'Empregado/Servidor/Autônomo',
            '',
            1,
            1,
            'Empregado/Servidor/Autônomo',
            't');

        INSERT INTO db_menu 
        VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Totalizadores'),
            (SELECT MAX(id_item) FROM db_itensmenu),
            1,
            10216);

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Contribuição Previdenciária',
            'Contribuição Previdenciária',
            'eso3_evt5001consulta001.php',
            1,
            1,
            'Contribuição Previdenciária',
            't');

        INSERT INTO db_menu 
        VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao like 'Empregado/Servidor/Aut%nomo'),
            (SELECT MAX(id_item) FROM db_itensmenu),
            1,
            10216);

SQL;
        $this->execute($sql);
    }

    private function checkMenu()
    {
        $result = $this->fetchRow("SELECT id_item FROM db_itensmenu WHERE funcao = 'eso3_evt5001consulta001.php'");
        if (empty($result)) {
            return true;
        }
        return false;
    }

    private function createTableEvt()
    {
        $sql = <<<SQL

        -- Criando  sequences
        CREATE SEQUENCE evt5001consulta_rh218_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- TABELAS E ESTRUTURA
        CREATE TABLE evt5001consulta(
        rh218_sequencial                int8 NOT NULL default 0,
        rh218_perapurano                int4 NOT NULL default 0,
        rh218_perapurmes                int4 NOT NULL default 0,
        rh218_indapuracao               int4 NOT NULL default 0,
        rh218_regist            int8 NOT NULL default 0,
        rh218_codcateg          int4 NOT NULL default 0,
        rh218_nrrecarqbase              varchar(100) NOT NULL ,
        rh218_tpcr              varchar(10) NOT NULL ,
        rh218_vrdescseg         float8 NOT NULL default 0,
        rh218_vrcpseg           float8 NOT NULL default 0,
        rh218_instit            int8 default 0,
        CONSTRAINT evt5001consulta_sequ_pk PRIMARY KEY (rh218_sequencial));

        -- CHAVE ESTRANGEIRA
        ALTER TABLE evt5001consulta
        ADD CONSTRAINT evt5001consulta_regist_fk FOREIGN KEY (rh218_regist)
        REFERENCES rhpessoal;

SQL;
        $this->execute($sql);

    }

    private function dropTableEvt()
    {
        $sql = <<<SQL

        --DROP TABLE:
        DROP TABLE IF EXISTS evt5001consulta CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS evt5001consulta_rh218_sequencial_seq;

SQL;
        $this->execute($sql);
    }

    private function insertDicionarioDados()
    {
        if (!$this->checkDicionario()) {
            return;
        }
        $sql = <<<SQL

        -- INSERINDO db_sysarquivo
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'evt5001consulta', 'Importação e consulta do evento 5001 do esocial', 'rh218', '2022-09-01', 'Consulta do evento 5001', 0, false, false, false, false);

-- INSERINDO db_sysarqmod
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (81, (select max(codarq) from db_sysarquivo));

-- INSERINDO db_syscampo
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_perapurano', 'int4', 'Período Apuração Ano', '0', 'Período Apuração Ano', 11, false, false, false, 1, 'text', 'Período Apuração Ano');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_perapurmes', 'int4', 'Período Apuração Mês', '0', 'Período Apuração Mês', 11, false, false, false, 1, 'text', 'Período Apuração Mês');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_indapuracao', 'int4', 'Tipo Período Apuração', '0', 'Tipo Período Apuração', 11, false, false, false, 1, 'text', 'Tipo Período Apuração');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_regist', 'int8', 'Matrícula', '0', 'Matrícula', 11, false, false, false, 1, 'text', 'Matrícula');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_codcateg', 'int4', 'Categoria', '0', 'Categoria', 11, false, false, false, 1, 'text', 'Categoria');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_nrrecarqbase', 'varchar(100)', 'Recibo', '', 'Recibo', 100, false, true, false, 0, 'text', 'Recibo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_tpcr', 'varchar(10)', 'Código de Receita', '', 'Código de Receita', 10, false, true, false, 0, 'text', 'Código de Receita');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_vrdescseg', 'float8', 'Desconto Realizado', '0', 'Desconto Realizado', 14, false, false, false, 4, 'text', 'Desconto Realizado');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_vrcpseg', 'float8', 'Valor Devido', '0', 'Valor Devido', 14, false, false, false, 4, 'text', 'Valor Devido');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_sequencial', 'int8', 'Sequencial', '0', 'Sequencial', 11, false, false, false, 1, 'text', 'Sequencial');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_instit', 'int8', 'Instituição', '0', 'Instituição', 11, false, false, false, 1, 'text', 'Instituição');

-- INSERINDO db_syssequencia
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'evt5001consulta_rh218_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

-- INSERINDO db_sysarqcamp
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_perapurano'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_perapurmes'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_indapuracao'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_regist'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_codcateg'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_nrrecarqbase'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_tpcr'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_vrdescseg'), 9, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_vrcpseg'), 10, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'evt5001consulta_rh218_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_instit'), 11, 0);

-- INSERINDO db_sysforkey
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_regist'), 1, 1153, 0);

-- INSERINDO db_sysprikey
INSERT INTO db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_sequencial'), 1, (select codcam from db_syscampo where nomecam = 'rh218_sequencial'), 0);

SQL;
        $this->execute($sql);
    }

    private function checkDicionario()
    {
        $result = $this->fetchRow("SELECT codarq FROM db_sysarquivo WHERE nomearq = 'evt5001consulta'");
        if (empty($result)) {
            return true;
        }
        return false;
    }
}
