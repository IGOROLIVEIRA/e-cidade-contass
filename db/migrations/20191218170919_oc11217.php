<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc11217 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- CRIA CAMPOS PARA TABELA PLACAIXAREC
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k81_regrepasse', 'int4', 'Regularização de Repasse', '', 'Regularização de Repasse', 1, FALSE, FALSE, FALSE, 1, 'text', 'Regularização de Repasse');
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='placaixarec' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k81_regrepasse'), 14, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k81_exerc', 'int8', 'Ano de Referência', '', 'Ano de Referência', 4, FALSE, FALSE, FALSE, 1, 'text', 'Ano de Referência');
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='placaixarec' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k81_exerc'), 15, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'k81_emparlamentar', 'int4', 'Referente a Emenda Parlamentar', '', 'Referente a Emenda Parlamentar', 1, FALSE, FALSE, FALSE, 1, 'text', 'Referente a Emenda Parlamentar');
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='placaixarec' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'k81_emparlamentar'), 16, 0);
        
        ALTER TABLE placaixarec ADD COLUMN k81_regrepasse INTEGER;

        ALTER TABLE placaixarec ADD COLUMN k81_exerc BIGINT;
        
        ALTER TABLE placaixarec ADD COLUMN k81_emparlamentar INTEGER DEFAULT 0;

        -- MODIFICA TABELA SICOM 2020
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si25_regularizacaorepasse', 'int8', 'Regularização de Repasse', 0, 'Regularização de Repasse', 1, FALSE, FALSE, FALSE, 1, 'text', 'Regularização de Repasse');

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si25_exercicio', 'int8', 'Exercício', 0, 'Exercício', 4, FALSE, FALSE, FALSE, 1, 'text', 'Exercício');

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si25_emendaparlamentar', 'int8', 'Emenda Parlamentar', 0, 'Emenda Parlamentar', 1, FALSE, FALSE, FALSE, 1, 'text', 'Emenda Parlamentar');
    
        UPDATE db_sysarqcamp ac SET seqarq = seqarq+3 FROM db_syscampo c WHERE ac.seqarq > 8 AND c.nomecam LIKE 'si25%' AND ac.codcam = c.codcam;

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rec102014' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si25_regularizacaorepasse'), 9, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rec102014' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si25_exercicio'), 10, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='rec102014' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si25_emendaparlamentar'), 11, 0);
        
        ALTER TABLE ONLY rec112020
        DROP CONSTRAINT rec112020_reg10_fk;

        DROP TABLE rec102020;

        CREATE TABLE rec102020 (
            si25_sequencial bigint DEFAULT 0 NOT NULL,
            si25_tiporegistro bigint DEFAULT 0 NOT NULL,
            si25_codreceita bigint DEFAULT 0 NOT NULL,
            si25_codorgao character varying(2) NOT NULL,
            si25_ededucaodereceita bigint DEFAULT 0 NOT NULL,
            si25_identificadordeducao bigint DEFAULT 0 NOT NULL,
            si25_naturezareceita bigint DEFAULT 0 NOT NULL,
            si25_regularizacaorepasse bigint DEFAULT 0,
            si25_exercicio character varying(4),
            si25_emendaparlamentar bigint DEFAULT 0 NOT NULL,           
            si25_vlarrecadado double precision DEFAULT 0 NOT NULL,
            si25_mes bigint DEFAULT 0 NOT NULL,
            si25_instit bigint DEFAULT 0
        );

        ALTER TABLE ONLY rec102020
        ADD CONSTRAINT rec102020_sequ_pk PRIMARY KEY (si25_sequencial);

        ALTER TABLE rec102020 OWNER TO dbportal;

        ALTER TABLE ONLY rec112020
        ADD CONSTRAINT rec112020_reg10_fk FOREIGN KEY (si26_reg10) REFERENCES rec102020(si25_sequencial);

        COMMIT;

SQL;
    $this->execute($sql);
  }

}


