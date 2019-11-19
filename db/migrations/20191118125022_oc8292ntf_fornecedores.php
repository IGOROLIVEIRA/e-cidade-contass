<?php

use Phinx\Migration\AbstractMigration;

class Oc8292ntfFornecedores extends AbstractMigration
{
    public function up()
    {
        $sSQL = <<<SQL
      SELECT fc_startsession();

        ALTER TABLE cgm ADD COLUMN z01_notificaemail BOOLEAN DEFAULT TRUE;

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES ((select max(codcam)+1 from db_syscampo), 'z01_notificaemail', 'bool', 'Notificação por e-mail', true, 'Notificação por e-mail', 1, false, false, false, 0, 'select', 'Notificação por e-mail');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES (
            (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('z01_numcgm') limit 1) order by codarq limit 1)
            , (select codcam from db_syscampo where nomecam = 'z01_notificaemail')
            , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('z01_numcgm') limit 1) order by codarq limit 1))
            , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('z01_numcgm') limit 1) order by codarq limit 1)));


        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Notificação de Fornecedores','Notificação de Fornecedores','pro1_notificacaofornecedor.php',1,1,'Notificação de Fornecedores','t');
        INSERT INTO db_menu VALUES (32,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 32 and modulo = 604),604);

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Tipos de Notificação','Tipos de Notificação','pro1_notificacaofornecedor.php',1,1,'Tipos de Notificação','t');
        INSERT INTO db_menu VALUES (29,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 32 and modulo = 604),604);
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Incluir','Tipos de Notificação','pro1_tiposnotificacao001.php',1,1,'Incluir Tipos de Notificação','t');
        INSERT INTO db_menu VALUES ((select max(id_item)-1 from db_itensmenu),(select max(id_item) from db_itensmenu),1,604);
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Alterar','Tipos de Notificação','pro1_tiposnotificacao002.php',1,1,'Alterar Tipos de Notificação','t');
        INSERT INTO db_menu VALUES ((select max(id_item)-2 from db_itensmenu),(select max(id_item) from db_itensmenu),2,604);
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Excluir','Tipos de Notificação','pro1_tiposnotificacao003.php',1,1,'Excluir Tipos de Notificação','t');
        INSERT INTO db_menu VALUES ((select max(id_item)-3 from db_itensmenu),(select max(id_item) from db_itensmenu),3,604);

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'tiposnotificacao', 'tiposnotificacao', 'p110 ', '2019-04-11', 'tiposnotificacao', 0, false, false, false, false);
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p110_sequencial', 'int4', 'Codigo Sequencial', '0', 'Sequencial', 10, false, false, false, 1, 'text', 'Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p110_tipo', 'varchar(100)', 'Tipo', '', 'Tipo', 100, false, false, false, 0, 'text', 'Tipo');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p110_textoemail', 'text', 'Texto Padrão', '', 'Texto Padrão', 900, false, false, false, 0, 'text', 'Texto Padrão');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p110_vinculonotificacao', 'int4', 'Vinculo', '0', 'Vinculo', 10, false, false, false, 1, 'text', 'Vinculo');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p110_sequencial'), 1, (select max(codsequencia) from db_syssequencia));
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p110_tipo'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p110_textoemail'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p110_vinculonotificacao'), 4, 0);

        INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'tiposnotificacao_p110_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

        INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p110_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

        --DROP TABLE:
        DROP TABLE IF EXISTS tiposnotificacao CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS tiposnotificacao_p110_sequencial_seq;


        -- Criando  sequences
        CREATE SEQUENCE tiposnotificacao_p110_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- TABELAS E ESTRUTURA

        -- Modulo: protocolo
        CREATE TABLE tiposnotificacao(
        p110_sequencial   int4 NOT NULL default 0,
        p110_tipo   varchar(100) NOT NULL,
        p110_textoemail   text,
        p110_vinculonotificacao   int4,
        CONSTRAINT tiposnotificacao_sequ_pk PRIMARY KEY (p110_sequencial));

        -- INDICES
        CREATE UNIQUE INDEX p110_sequencial_index ON tiposnotificacao(p110_sequencial);


        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'nfaberturaprocesso', 'nfaberturaprocesso', 'p111 ', '2019-04-17', 'nfaberturaprocesso', 0, false, false, false, false);
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p111_sequencial', 'int4', 'Codigo Sequencial', '0', 'Codigo Sequencial', 10, false, false, true, 1, 'text', 'Codigo Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p111_codproc', 'int4', 'Numero do codigo do Processo', '0', 'Numero de Controle', 10, false, false, false, 1, 'text', 'Numero de Controle');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p111_dataenvio', 'date', 'Data de Envio', 'null', 'Data de Envio', 10, false, false, false, 1, 'text', 'Data de Envio');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p111_nfe', 'int8', 'Nota Fiscal', '0', 'Nota Fiscal', 19, false, false, false, 1, 'text', 'Nota Fiscal');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p111_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p111_codproc'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p111_dataenvio'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p111_nfe'), 4, 0);

        INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'nfaberturaprocesso_p111_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

        INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p111_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

        INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p111_codproc'), 1, 403, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS nfaberturaprocesso CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS nfaberturaprocesso_p111_sequencial_seq;


        -- Criando  sequences
        CREATE SEQUENCE nfaberturaprocesso_p111_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        CREATE TABLE nfaberturaprocesso(
        p111_sequencial   int4 NOT NULL default 0,
        p111_codproc    int4 NOT NULL default 0,
        p111_dataenvio   date NOT NULL default null,
        p111_nfe    int8 NOT NULL default 0,
        CONSTRAINT nfaberturaprocesso_sequencial_pk PRIMARY KEY (p111_sequencial)
        );


        -- CHAVE ESTRANGEIRA
        ALTER TABLE nfaberturaprocesso
        ADD CONSTRAINT nfaberturaprocesso_codproc_fk FOREIGN KEY (p111_codproc)
        REFERENCES protprocesso;


        -- INDICES
        CREATE UNIQUE INDEX p111_sequencial_index ON nfaberturaprocesso(p111_sequencial);

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'nfprevisaopagamento', 'nfprevisaopagamento', 'p112 ', '2019-04-17', 'nfprevisaopagamento', 0, false, false, false, false);
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p112_sequencial', 'int4', 'Codigo Sequencial', '0', 'Codigo Sequencial', 10, false, false, false, 1, 'text', 'Codigo Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p112_codproc', 'int4', 'Numero do cÃ³digo do Processo', '0', 'Numero de Controle', 10, false, false, false, 1, 'text', 'Numero de Controle');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p112_nfe', 'int8', 'Nota Fiscal', '0', 'Nota Fiscal', 19, false, false, false, 1, 'text', 'Nota Fiscal');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p112_dataliquidacao', 'date', 'Liquidacao', 'null', 'Liquidacao', 10, false, false, false, 1, 'text', 'Liquidacao');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p112_dataprevisao', 'date', 'Previsao', 'null', 'Previsao', 10, false, false, false, 1, 'text', 'Previsao');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p112_dataenvio', 'date', 'Data de Envio', 'null', 'Data de Envio', 10, false, false, false, 1, 'text', 'Data de Envio');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p112_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p112_codproc'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p112_nfe'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p112_dataliquidacao'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p112_dataprevisao'), 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p112_dataenvio'), 6, 0);

        INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'nfprevisaopagamento_p112_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

        INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p112_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

        INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p112_codproc'), 1, 403, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS nfprevisaopagamento CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS nfprevisaopagamento_p112_sequencial_seq;

        CREATE SEQUENCE nfprevisaopagamento_p112_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- Criando  sequences
        -- TABELAS E ESTRUTURA

        -- Modulo: protocolo
        CREATE TABLE nfprevisaopagamento(
        p112_sequencial   int4 NOT NULL default 0,
        p112_codproc    int4 NOT NULL default 0,
        p112_nfe    int8 NOT NULL default 0,
        p112_dataliquidacao   date NOT NULL default null,
        p112_dataprevisao   date NOT NULL default null,
        p112_nfgeral BOOLEAN,
        p112_nfaberturaprocesso int4,
        p112_dataenvio    date NOT NULL default null,
        CONSTRAINT nfprevisaopagamento_sequencial_pk PRIMARY KEY (p112_sequencial));

        -- CHAVE ESTRANGEIRA
        ALTER TABLE nfprevisaopagamento
        ADD CONSTRAINT nfprevisaopagamento_codproc_fk FOREIGN KEY (p112_codproc)
        REFERENCES protprocesso;

        -- INDICES
        CREATE UNIQUE INDEX p112_sequencial_index ON nfprevisaopagamento(p112_sequencial);

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'nfpagamentorealizado', 'nfpagamentorealizado', 'p113 ', '2019-04-23', 'nfpagamentorealizado', 0, false, false, false, false);
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (4, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p113_sequencial', 'int4', 'Codigo Sequencial', '0', 'Codigo Sequencial', 11, false, false, true, 1, 'text', 'Codigo Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p113_codproc', 'int4', 'Numero do código do Processo', '0', 'Numero do código do Processo', 10, false, false, false, 1, 'text', 'Numero do código do Processo');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p113_nfe', 'int8', 'Nota Fiscal', '0', 'Nota Fiscal', 19, false, false, false, 1, 'text', 'Nota Fiscal');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p113_numpagamento', 'int8', 'Numero de Pagamento', '0', 'Numero de Pagamento', 19, false, false, false, 1, 'text', 'Numero de Pagamento');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'p113_dataenvio', 'date', 'Data de Envio', 'null', 'Data de Envio', 10, false, false, false, 1, 'text', 'Data de Envio');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p113_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p113_codproc'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p113_nfe'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p113_numpagamento'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p113_dataenvio'), 5, 0);

        INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'nfpagamentorealizado_p113_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

        INSERT INTO db_sysindices (codind, nomeind, codarq, campounico) VALUES ((select max(codind)+1 from db_sysindices), 'p113_sequencial_index', (select max(codarq) from db_sysarquivo), '1');

        INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'p113_codproc'), 1, 403, 0);

        --DROP TABLE:
        DROP TABLE IF EXISTS nfpagamentorealizado CASCADE;
        --Criando drop sequences
        DROP SEQUENCE IF EXISTS nfpagamentorealizado_p113_sequencial_seq;

        -- Criando  sequences
        CREATE SEQUENCE nfpagamentorealizado_p113_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        -- TABELAS E ESTRUTURA

        -- Modulo: protocolo
        CREATE TABLE nfpagamentorealizado(
        p113_sequencial   int4 NOT NULL default 0,
        p113_codproc    int4 NOT NULL default 0,
        p113_nfe    int8 NOT NULL default 0,
        p113_numpagamento   int8 NOT NULL default 0,
        p113_nfgeral BOOLEAN,
        p113_nfaberturaprocesso int4,
        p113_nfprevisaopagamento int4,
        p113_dataenvio    date NOT NULL default null,
        CONSTRAINT nfpagamentorealizado_sequencial_pk PRIMARY KEY (p113_sequencial));

        -- CHAVE ESTRANGEIRA

        ALTER TABLE nfpagamentorealizado
        ADD CONSTRAINT nfpagamentorealizado_codproc_fk FOREIGN KEY (p113_codproc)
        REFERENCES protprocesso;

        -- INDICES

        CREATE UNIQUE INDEX p113_sequencial_index ON nfpagamentorealizado(p113_sequencial);

        -- Fim do script
  
SQL;
        $this->execute($sSQL);
    }
}
