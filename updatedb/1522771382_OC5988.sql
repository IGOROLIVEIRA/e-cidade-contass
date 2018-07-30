
-- Ocorrência 5988
BEGIN;
SELECT fc_startsession();

-- Início do script


ALTER TABLE empprestaitem ADD COLUMN e46_desconto float;


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e46_desconto',
                              'float',
                              'Desconto do ítem',
                              '0',
                              'Desconto do ítem',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              4,
                              'float',
                              'Desconto do ítem');


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT codarq
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('e46_emppresta'))),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e46_desconto'),
          (SELECT max(seqarq)+1
           FROM db_sysarqcamp
           WHERE codcam =
               (SELECT codcam
                FROM db_syscampo
                WHERE nomecam IN ('e46_emppresta'))), 0);

 -- INSERINDO db_sysarquivo

CREATE SEQUENCE empdescontonota_e999_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE empdescontonota (e999_sequencial INTEGER DEFAULT NEXTVAL('empdescontonota_e999_sequencial_seq') PRIMARY KEY, e999_empenho int NOT NULL, e999_nota text NOT NULL, e999_valor float NOT NULL, e999_desconto float NOT NULL);


ALTER TABLE empdescontonota ADD CONSTRAINT sequencial UNIQUE (e999_nota,e999_empenho);


INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform)
VALUES (
          (SELECT max(codarq)+1
           FROM db_sysarquivo), 'empdescontonota',
                                'Estrutura para agrupar os descontos aplicados aos ítens com notas em comum',
                                'e999',
                                '2018-04-03',
                                'Desconto de Notas',
                                0,
                                TRUE,
                                FALSE,
                                FALSE,
                                FALSE);

 -- INSERINDO db_sysarqmod

INSERT INTO db_sysarqmod (codmod, codarq)
VALUES (38,
          (SELECT max(codarq)
           FROM db_sysarquivo));

 -- INSERINDO db_syscampo

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e999_sequencial',
                              'int4 ',
                              'Cód. Seq',
                              '0',
                              'Cód. Seq',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Cód. Seq');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e999_nota',
                              'text',
                              'Nota',
                              '0',
                              'Nota',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Nota');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e999_empenho',
                              'text',
                              'Cod. Empenho',
                              '0',
                              'Cod. Empenho',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Cod. Empenho');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e999_valor',
                              'float',
                              'Valor',
                              '0',
                              'Valor',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Valor');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'e999_desconto',
                              'float',
                              'Desconto',
                              '0',
                              'Desconto',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Desconto');

 -- INSERINDO db_syssequencia

INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq)
VALUES (
          (SELECT max(codsequencia)+1
           FROM db_syssequencia), 'empdescontonota_e999_sequencial_seq',
                                  1,
                                  1,
                                  9223372036854775807,
                                  1,
                                  1);

 -- INSERINDO db_sysarqcamp

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e999_sequencial'), 1,
          (SELECT codsequencia
           FROM db_syssequencia
           WHERE nomesequencia = 'empdescontonota_e999_sequencial_seq'));


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e999_nota'), 2,
                                         0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e999_valor'), 3,
                                          0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e999_desconto'), 4,
                                             0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e999_empenho'), 5,
                                             0);

 -- INSERINDO db_sysforkey

INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e999_nota'), 1,
                                         1037,
                                         0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'e999_empenho'), 1,
                                         889,
                                         0);

-- Fim do script

COMMIT;

