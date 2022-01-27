<?php

use Classes\PostgresMigration;

class AddTableasArquivoRetorno extends PostgresMigration
{
    
    public function up()
    {
        if ($this->checkDicionarioDados()) {
            $this->addArquivoRetornoDicDados();
            $this->addArquivoRetornoDadosDicDados();
        }
        $this->createTableArquivoRetorno();
        $this->createTableArquivoRetornoDados();
    }

    public function down()
    {
        $sql = "
        DROP SEQUENCE arquivoretorno_rh216_sequencial_seq;
        DROP SEQUENCE arquivoretornodados_rh217_sequencial_seq;
        DROP TABLE arquivoretornodados;
        DROP TABLE arquivoretorno;
        ";

        $this->execute($sql);
    }

    private function createTableArquivoRetorno()
    {
        $sql = <<<SQL
        -- Criando  sequences
        CREATE SEQUENCE arquivoretorno_rh216_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- TABELAS E ESTRUTURA

        -- Módulo: esocial
        CREATE TABLE arquivoretorno(
        rh216_sequencial        int8 NOT NULL default 0,
        rh216_arquivo       varchar(100) NOT NULL ,
        rh216_dataimportacao        timestamp default null,
        rh216_instit  int4 NOT NULL,
        CONSTRAINT arquivoretorno_sequ_pk PRIMARY KEY (rh216_sequencial));
SQL;
        $this->execute($sql);
    }

    private function createTableArquivoRetornoDados()
    {
        $sql = <<<SQL
        -- Criando  sequences
        CREATE SEQUENCE arquivoretornodados_rh217_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        -- Módulo: esocial
        CREATE TABLE arquivoretornodados(
        rh217_sequencial        int8 NOT NULL default 0,
        rh217_cpf       varchar(11) NOT NULL ,
        rh217_nis       varchar(11) NOT NULL ,
        rh217_nome      varchar(100) NOT NULL ,
        rh217_dn        varchar(8) NOT NULL ,
        rh217_cod_nis_inv       int4 NOT NULL default 0,
        rh217_cod_cpf_inv       int4 NOT NULL default 0,
        rh217_cod_nome_inv      int4 NOT NULL default 0,
        rh217_cod_dn_inv        int4 NOT NULL default 0,
        rh217_cod_cnis_nis      int4 NOT NULL default 0,
        rh217_cod_cnis_dn       int4 NOT NULL default 0,
        rh217_cod_cnis_obito        int4 NOT NULL default 0,
        rh217_cod_cnis_cpf      int4 NOT NULL default 0,
        rh217_cod_cnis_cpf_nao_inf      int4 NOT NULL default 0,
        rh217_cod_cpf_nao_consta        int4 NOT NULL default 0,
        rh217_cod_cpf_nulo      int4 NOT NULL default 0,
        rh217_cod_cpf_cancelado     int4 NOT NULL default 0,
        rh217_cod_cpf_suspenso      int4 NOT NULL default 0,
        rh217_cod_cpf_dn        int4 NOT NULL default 0,
        rh217_cod_cpf_nome      int4 NOT NULL default 0,
        rh217_cod_orientacao_cpf        int4 NOT NULL default 0,
        rh217_cod_orientacao_nis        int4 NOT NULL default 0,
        rh217_arquivoretorno        int8 default 0,
        rh217_msg  text[] NULL,
        CONSTRAINT arquivoretornodados_sequ_pk PRIMARY KEY (rh217_sequencial));

        -- CHAVE ESTRANGEIRA
        ALTER TABLE arquivoretornodados
        ADD CONSTRAINT arquivoretornodados_arquivoretorno_fk FOREIGN KEY (rh217_arquivoretorno)
        REFERENCES arquivoretorno;
SQL;
        $this->execute($sql);
    }

    private function checkDicionarioDados()
    {
        $result = $this->fetchRow("SELECT * FROM db_sysarquivo WHERE nomearq = 'arquivoretorno'");
        if (empty($result)) {
            return true;
        }
        return false;
    }

    private function addArquivoRetornoDicDados()
    {
        $sql = <<<SQL
        -- INSERINDO db_sysarquivo
        INSERT INTO configuracoes.db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'arquivoretorno', 'Controle Arquivo Retorno eSocial', 'rh216', '2021-07-30', 'Controle Arquivo Retorno eSocial', 0, false, false, false, false);
         
        -- INSERINDO db_sysarqmod
        INSERT INTO configuracoes.db_sysarqmod (codmod, codarq) VALUES (81, (select max(codarq) from db_sysarquivo));
         
        -- INSERINDO db_syscampo
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh216_sequencial', 'int8', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh216_arquivo', 'varchar(100)', 'Nome Arquivo', '', 'Nome Arquivo', 100, false, false, false, 0, 'text', 'Nome Arquivo');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh216_dataimportacao', 'date', 'Data Importação', 'null', 'Data Importação', 10, false, false, false, 1, 'text', 'Data Importação');
         
        -- INSERINDO db_syssequencia
        INSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'arquivoretorno_rh216_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
         
        -- INSERINDO db_sysarqcamp
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretorno'), (select codcam from db_syscampo where nomecam = 'rh216_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'arquivoretorno_rh216_sequencial_seq'));
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretorno'), (select codcam from db_syscampo where nomecam = 'rh216_arquivo'), 2, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretorno'), (select codcam from db_syscampo where nomecam = 'rh216_dataimportacao'), 3, 0);
         
        -- INSERINDO db_sysprikey
        INSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretorno'), (select codcam from db_syscampo where nomecam = 'rh216_sequencial'), 1, (select codcam from db_syscampo where nomecam = 'rh216_sequencial'), 0);
SQL;

        $this->execute($sql);
    }

    private function addArquivoRetornoDadosDicDados()
    {
        $sql = <<<SQL
        -- INSERINDO db_sysarquivo
        INSERT INTO configuracoes.db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'arquivoretornodados', 'Arquivo Retorno eSocial', 'rh217', '2021-07-30', 'Arquivo Retorno eSocial', 0, false, false, false, false);
         
        -- INSERINDO db_sysarqmod
        INSERT INTO configuracoes.db_sysarqmod (codmod, codarq) VALUES (81, (select max(codarq) from db_sysarquivo));
         
        -- INSERINDO db_syscampo
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_sequencial', 'int8', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cpf', 'varchar(11)', 'CPF', '', 'CPF', 11, false, true, false, 0, 'text', 'CPF');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_nis', 'varchar(11)', 'NIS', '', 'NIS', 11, false, true, false, 0, 'text', 'NIS');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_nome', 'varchar(100)', 'Nome', '', 'Nome', 100, false, true, false, 0, 'text', 'Nome');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_dn', 'varchar(8)', 'Data Nascimento', '', 'Data Nascimento', 8, false, true, false, 0, 'text', 'Data Nascimento');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_nis_inv', 'int4', 'NIS Inválido', '0', 'NIS Inválido', 11, false, false, false, 1, 'text', 'NIS Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cpf_inv', 'int4', 'CPF Inválido', '0', 'CPF Inválido', 11, false, false, false, 1, 'text', 'CPF Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_nome_inv', 'int4', 'Nome Inválido', '0', 'Nome Inválido', 11, false, false, false, 1, 'text', 'Nome Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_dn_inv', 'int4', 'rh217_cod_dn_inv', '0', 'Data Nascimento Inválido', 11, false, false, false, 1, 'text', 'Data Nascimento Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cnis_nis', 'int4', 'NIS CNIS Inválido', '0', 'NIS CNIS Inválido', 11, false, false, false, 1, 'text', 'NIS CNIS Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cnis_dn', 'int4', 'Data Nascimento CNIS Inválido', '0', 'Data Nascimento CNIS Inválido', 11, false, false, false, 1, 'text', 'Data Nascimento CNIS Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cnis_obito', 'int4', 'Óbito CNIS Inválido', '0', 'Óbito CNIS Inválido', 11, false, false, false, 1, 'text', 'Óbito CNIS Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cnis_cpf', 'int4', 'CPF CNIS Inválido', '0', 'CPF CNIS Inválido', 11, false, false, false, 1, 'text', 'CPF CNIS Inválido');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cnis_cpf_nao_inf', 'int4', 'CPF CNIS Não Informado', '0', 'CPF CNIS Não Informado', 11, false, false, false, 1, 'text', 'CPF CNIS Não Informado');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cpf_nao_consta', 'int4', 'CPF Não Consta', '0', 'CPF Não Consta', 11, false, false, false, 1, 'text', 'CPF Não Consta');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cpf_nulo', 'int4', 'CPF Nulo', '0', 'CPF Nulo', 11, false, false, false, 1, 'text', 'CPF Nulo');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cpf_cancelado', 'int4', 'CPF Cancelado', '0', 'CPF Cancelado', 11, false, false, false, 1, 'text', 'CPF Cancelado');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cpf_suspenso', 'int4', 'CPF Suspenso', '0', 'CPF Suspenso', 11, false, false, false, 1, 'text', 'CPF Suspenso');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cpf_dn', 'int4', 'CPF Data Nascimento Diverge', '0', 'CPF Data Nascimento Diverge', 11, false, false, false, 1, 'text', 'CPF Data Nascimento Diverge');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_cpf_nome', 'int4', 'CPF Nome Diverge', '0', 'CPF Nome Diverge', 11, false, false, false, 1, 'text', 'CPF Nome Diverge');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_orientacao_cpf', 'int4', 'Orientação CPF', '0', 'Orientação CPF', 11, false, false, false, 1, 'text', 'Orientação CPF');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_cod_orientacao_nis', 'int4', 'Orientação NIS', '0', 'Orientação NIS', 11, false, false, false, 1, 'text', 'Orientação NIS');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_arquivoretorno', 'int8', 'Cod. Arquivo Controle', '0', 'Cod. Arquivo Controle', 11, false, false, false, 1, 'text', 'Cod. Arquivo Controle');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh217_msg', 'text', 'Mensagens de Retorno', '', 'Mensagens de Retorno', 1, false, true, false, 0, 'text', 'Mensagens de Retorno');
         
        -- INSERINDO db_syssequencia
        INSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'arquivoretornodados_rh217_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
         
        -- INSERINDO db_sysarqcamp
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'arquivoretornodados_rh217_sequencial_seq'));
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cpf'), 2, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_nis'), 3, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_nome'), 4, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_dn'), 5, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_nis_inv'), 6, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cpf_inv'), 7, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_nome_inv'), 8, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_dn_inv'), 9, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cnis_nis'), 10, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cnis_dn'), 11, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cnis_obito'), 12, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cnis_cpf'), 13, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cnis_cpf_nao_inf'), 14, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cpf_nao_consta'), 15, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cpf_nulo'), 16, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cpf_cancelado'), 17, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cpf_suspenso'), 18, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cpf_dn'), 19, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_cpf_nome'), 20, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_orientacao_cpf'), 21, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_cod_orientacao_nis'), 22, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_arquivoretorno'), 23, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_msg'), 24, 0);
         
        -- INSERINDO db_sysforkey
        INSERT INTO configuracoes.db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_arquivoretorno'), 1, (select codarq from db_sysarquivo where nomearq = 'arquivoretorno'), 0);
         
        -- INSERINDO db_sysprikey
        INSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'arquivoretornodados'), (select codcam from db_syscampo where nomecam = 'rh217_sequencial'), 1, (select codcam from db_syscampo where nomecam = 'rh217_sequencial'), 0);
         
SQL;

        $this->execute($sql);
    }
}
