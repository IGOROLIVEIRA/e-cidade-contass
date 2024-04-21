<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class ImportEvento5011 extends PostgresMigration
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
            'Empregador/Órgão Público',
            'Empregador/Órgão Público',
            '',
            1,
            1,
            'Empregador/Órgão Público',
            't');

        INSERT INTO db_menu 
        VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao like 'Totalizadores'),
            (SELECT MAX(id_item) FROM db_itensmenu),
            2,
            10216);

        INSERT INTO db_itensmenu
        VALUES ((SELECT MAX(id_item)+1 FROM db_itensmenu),
            'Contribuição Previdenciária',
            'Contribuição Previdenciária',
            'eso3_evt5011consulta001.php',
            1,
            1,
            'Contribuição Previdenciária',
            't');

        INSERT INTO db_menu 
        VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao like 'Empregador/%rgão P%blico'),
            (SELECT MAX(id_item) FROM db_itensmenu),
            1,
            10216);

SQL;
        $this->execute($sql);
    }

    private function checkMenu()
    {
        $result = $this->fetchRow("SELECT id_item FROM db_itensmenu WHERE funcao = 'eso3_evt5011consulta001.php'");
        if (empty($result)) {
            return true;
        }
        return false;
    }

    private function createTableEvt()
    {
        $sql = <<<SQL

        -- Criando  sequences
        CREATE SEQUENCE evt5011consulta_rh219_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- TABELAS E ESTRUTURA

        -- Módulo: esocial
        CREATE TABLE evt5011consulta(
        rh219_sequencial        int8 NOT NULL default 0,
        rh219_perapurano        int4 NOT NULL default 0,
        rh219_perapurmes        int4 NOT NULL default 0,
        rh219_indapuracao       int4 NOT NULL default 0,
        rh219_classtrib     int8 NOT NULL default 0,
        rh219_cnaeprep      varchar(10) NOT NULL ,
        rh219_aliqrat       int8 NOT NULL default 0,
        rh219_fap       float8 NOT NULL default 0,
        rh219_aliqratajust      float8 NOT NULL default 0,
        rh219_fpas      varchar(10) NOT NULL ,
        rh219_vrbccp00      float8 NOT NULL default 0,
        rh219_baseaposentadoria     float8 NOT NULL default 0,
        rh219_vrsalfam      float8 NOT NULL default 0,
        rh219_vrsalmat      float8 NOT NULL default 0,
        rh219_vrdesccp      float8 NOT NULL default 0,
        rh219_vrcpseg       float8 NOT NULL default 0,
        rh219_vrcr      float8 default 0,
        rh219_instit    int4 NOT NULL,
        CONSTRAINT evt5011consulta_sequ_pk PRIMARY KEY (rh219_sequencial));

SQL;
        $this->execute($sql);

    }

    private function dropTableEvt()
    {
        $sql = <<<SQL

        --DROP TABLE:
        DROP TABLE IF EXISTS evt5011consulta CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS evt5011consulta_rh219_sequencial_seq;

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
INSERT INTO configuracoes.db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'evt5011consulta', 'Importação e consulta do evento 5011 do esocial', 'rh219', '2023-08-07', 'Consulta do evento 5011', 0, false, false, false, false);
 
-- INSERINDO db_sysarqmod
INSERT INTO configuracoes.db_sysarqmod (codmod, codarq) VALUES (81, (select max(codarq) from db_sysarquivo));
 
-- INSERINDO db_syscampo
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_sequencial', 'int8', 'Sequencial', '0', 'Sequencial', 11, false, false, false, 1, 'text', 'Sequencial');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_perapurano', 'int4', 'Período Apuração Ano', '0', 'Período Apuração Ano', 11, false, false, false, 1, 'text', 'Período Apuração Ano');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_perapurmes', 'int4', 'Período Apuração Mês', '0', 'Período Apuração Mês', 11, false, false, false, 1, 'text', 'Período Apuração Mês');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_indapuracao', 'int4', 'Tipo de Folha', '0', 'Tipo de Folha', 11, false, false, false, 1, 'text', 'Tipo de Folha');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_classtrib', 'int8', 'Classificação Tributária', '0', 'Classificação Tributária', 11, false, false, false, 1, 'text', 'Classificação Tributária');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_cnaeprep ', 'varchar(10)', 'Código CNAE', '', 'Código CNAE', 10, false, true, false, 0, 'text', 'Código CNAE');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_aliqrat  ', 'int8', 'Alíquota RAT', '0', 'Alíquota RAT', 11, false, false, false, 1, 'text', 'Alíquota RAT');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_fap', 'float8', 'Alíquota FAP', '0', 'Alíquota FAP', 11, false, false, false, 4, 'text', 'Alíquota FAP');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_fpas', 'varchar(10)', 'Código FPAS', '', 'Código FPAS', 10, false, true, false, 0, 'text', 'Código FPAS');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_vrbccp00', 'float8', 'Base de Cálculo', '0', 'Base de Cálculo', 11, false, false, false, 4, 'text', 'Base de Cálculo');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_vrsalfam', 'float8', 'Valor Salário Família', '0', 'Valor Salário Família', 11, false, false, false, 4, 'text', 'Valor Salário Família');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_vrsalmat', 'float8', 'Valor Salário Maternidade', '0', 'Valor Salário Maternidade', 11, false, false, false, 4, 'text', 'Valor Salário Maternidade');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_vrdesccp', 'float8', 'Valor da Contribuição Descontada dos Segurados', '0', 'Valor da Contribuição Descontada dos Segurados', 11, false, false, false, 4, 'text', 'Valor da Contribuição Descontada dos Seg');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_vrcpseg', 'float8', 'Valor Calculado Pelo eSocial', '0', 'Valor Calculado Pelo eSocial', 11, false, false, false, 4, 'text', 'Valor Calculado Pelo eSocial');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_vrcr', 'float8', 'Contribuição Patronal', '0', 'Contribuição Patronal', 11, false, false, false, 4, 'text', 'Contribuição Patronal');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_aliqratajust', 'float8', 'Alíquota RAT Ajustada', '0', 'Alíquota RAT Ajustada', 11, false, false, false, 4, 'text', 'Alíquota RAT Ajustada');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_baseaposentadoria', 'float8', 'Base de Cálculo Aposentadoria Especial', '0', 'Base de Cálculo Aposentadoria Especial', 11, false, false, false, 4, 'text', 'Base de Cálculo Aposentadoria Especial');
INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh219_instit', 'int4', 'Instituição', '0', 'Instituição', 11, false, false, false, 1, 'text', 'Instituição');
 
-- INSERINDO db_syssequencia
INSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'evt5011consulta_rh219_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
 
-- INSERINDO db_sysarqcamp
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'evt5011consulta_rh219_sequencial_seq'));
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_perapurano'), 2, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_perapurmes'), 3, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_indapuracao'), 4, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_classtrib'), 5, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_cnaeprep'), 6, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_aliqrat'), 7, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_fap'), 8, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_fpas'), 10, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_vrbccp00'), 11, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_vrsalfam'), 13, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_vrsalmat'), 14, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_vrdesccp'), 15, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_vrcpseg'), 16, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_vrcr'), 17, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_aliqratajust'), 9, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_baseaposentadoria'), 12, 0);
INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_instit'), 18, 0);
 
-- INSERINDO db_sysprikey
INSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5011consulta'), (select codcam from db_syscampo where nomecam = 'rh219_sequencial'), 1, (select codcam from db_syscampo where nomecam = 'rh219_sequencial'), 0);
 

SQL;
        $this->execute($sql);
    }

    private function checkDicionario()
    {
        $result = $this->fetchRow("SELECT codarq FROM db_sysarquivo WHERE nomearq = 'evt5011consulta'");
        if (empty($result)) {
            return true;
        }
        return false;
    }

}
