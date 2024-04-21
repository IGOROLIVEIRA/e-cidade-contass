<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc10813 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        SELECT fc_startsession();

        -- CRIA MENU
        
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Previsão de Receitas', 'Previsão de Receitas','con1_convprevrec001.php',1,1,'Previsão de Receitas','t');

        INSERT INTO db_menu VALUES (3000055, (select max(id_item) from db_itensmenu), (select max(menusequencia) from db_menu where id_item = 3000055 and modulo = 209)+1, 209);
        
        --CRIA TABELA PREVISAO RECEITA CONVENIO
        
        -- INSERINDO db_sysarquivo
        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'prevconvenioreceita', 'Previsão Receita Convênio', 'c229 ', '2019-11-05', 'Previsão Receita Convênio', 0, false, false, false, false);
         
        -- INSERINDO db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));
         
        -- INSERINDO db_syscampo
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c229_fonte                              ', 'int4                                    ', 'Receita', '0', 'Receita', 6, false, false, false, 1, 'text', 'Receita');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c229_convenio                           ', 'int4                                    ', 'Convênio', '0', 'Convênio', 6, false, false, false, 1, 'text', 'Convênio');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c229_vlprevisto                         ', 'float8                                  ', 'Valor Previsto do Convênio', '0', 'Valor Previsto do Convênio', 14, false, false, false, 4, 'text', 'Valor Previsto do Convênio');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c229_anousu                             ', 'int4                                    ', 'Ano', '0', 'Ano', 4, false, false, false, 1, 'text', 'Ano');
         
        -- INSERINDO db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c229_fonte'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c229_convenio'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c229_vlprevisto'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c229_anousu'), 4, 0);
         
        -- INSERINDO db_sysforkey
        INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c229_fonte'), 1, 780, 0);
        
        -- CRIANDO TABELA
        CREATE TABLE prevconvenioreceita(
            c229_fonte              int4 NOT NULL default 0,
            c229_convenio           int4 NOT NULL default 0,
            c229_vlprevisto         float8 NOT NULL default 0,
            c229_anousu             int4 default 0,
            CONSTRAINT prevconvenioreceita_font_convenio_ano_pk PRIMARY KEY (c229_fonte, c229_convenio, c229_anousu));
        
        ALTER TABLE prevconvenioreceita ADD CONSTRAINT prevconvenioreceita_fonte_fk FOREIGN KEY (c229_anousu,c229_fonte) REFERENCES orcreceita;

        --MODIFICA TABELA DO SICOM
        ALTER TABLE conv312019 DROP CONSTRAINT conv312019_reg10_fk;
        
        DROP INDEX conv312019_si204_reg10_index;

        ALTER TABLE conv312019 DROP COLUMN si204_reg10;

        ALTER TABLE conv312019 ALTER COLUMN si204_nroconvenio TYPE varchar(30);
        
        ALTER TABLE conv312019 ALTER COLUMN si204_nroconvenio DROP NOT NULL;

        COMMIT;        
SQL;
        $this->execute($sql);
    }
}