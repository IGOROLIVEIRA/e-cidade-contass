<?php

use Classes\PostgresMigration;

class Oc13857 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si31_regularizacaorepasseestornada', 'int8', 'Regularização de Repasse', 0, 'Regularização de Repasse', 1, FALSE, FALSE, FALSE, 1, 'text', 'Regularização de Repasse');

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si31_exercicioestornada', 'int8', 'Exercício', 0, 'Exercício', 4, FALSE, FALSE, FALSE, 1, 'text', 'Exercício');

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si31_emendaparlamentarestornada', 'int8', 'Emenda Parlamentar', 0, 'Emenda Parlamentar', 1, FALSE, FALSE, FALSE, 1, 'text', 'Emenda Parlamentar');

        UPDATE db_sysarqcamp ac SET seqarq = seqarq+3 FROM db_syscampo c WHERE ac.seqarq > 8 AND c.nomecam LIKE 'si31%' AND ac.codcam = c.codcam;

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='arc202014' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si31_regularizacaorepasseestornada'), 9, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='arc202014' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si31_exercicioestornada'), 10, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='arc202014' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si31_emendaparlamentarestornada'), 11, 0);
                

        DROP TABLE arc212021;
        
        DROP TABLE arc202021;

        CREATE TABLE arc202021 (
            si31_sequencial int8 NOT NULL DEFAULT 0,
            si31_tiporegistro int8 NOT NULL DEFAULT 0,
            si31_codorgao varchar(2) NOT NULL,
            si31_codestorno int8 NOT NULL DEFAULT 0,
            si31_ededucaodereceita int8 NOT NULL DEFAULT 0,
            si31_identificadordeducao int8 NULL,
            si31_naturezareceitaestornada int8 NOT NULL DEFAULT 0,
            si31_regularizacaorepasseestornada bigint DEFAULT 0,
            si31_exercicioestornada character varying(4),
            si31_emendaparlamentarestornada bigint DEFAULT 0 NOT NULL,
            si31_vlestornado float8 NOT NULL DEFAULT 0,
            si31_mes int8 NOT NULL DEFAULT 0,
            si31_instit int8 NULL DEFAULT 0,
            CONSTRAINT arc202021_sequ_pk PRIMARY KEY (si31_sequencial)
        )
        WITH (
            OIDS=TRUE
        );

        CREATE TABLE arc212021 (
            si32_sequencial int8 NOT NULL DEFAULT 0,
            si32_tiporegistro int8 NOT NULL DEFAULT 0,
            si32_codestorno int8 NOT NULL DEFAULT 0,
            si32_codfonteestornada int8 NOT NULL DEFAULT 0,
            si32_tipodocumento int8 NULL,
            si32_nrodocumento varchar(14) NULL DEFAULT NULL::character varying,
            si32_nroconvenio varchar(30) NULL DEFAULT NULL::character varying,
            si32_dataassinatura date NULL,
            si32_vlestornadofonte float8 NOT NULL DEFAULT 0,
            si32_reg20 int8 NOT NULL DEFAULT 0,
            si32_instit int8 NULL DEFAULT 0,
            si32_mes int8 NOT NULL,
            CONSTRAINT arc212021_sequ_pk PRIMARY KEY (si32_sequencial),
            CONSTRAINT arc212021_reg20_fk FOREIGN KEY (si32_reg20) REFERENCES arc202021(si31_sequencial)
        )
        WITH (
            OIDS=TRUE
        );
        CREATE INDEX arcwq2021_si32_reg20_index ON arc212021 USING btree (si32_reg20);

        COMMIT;

SQL;
    $this->execute($sql);
 	}

}