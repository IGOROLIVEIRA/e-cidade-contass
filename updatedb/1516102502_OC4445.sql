
-- Ocorrência 4445
BEGIN;
SELECT fc_startsession();

-- Início do script
DELETE
FROM db_sysforkey
WHERE codcam IN
    (SELECT codcam
     FROM db_syscampo
     WHERE nomecam LIKE 'i77%');


DELETE
FROM db_sysarqcamp
WHERE codcam IN
    (SELECT codcam
     FROM db_syscampo
     WHERE nomecam LIKE 'i77_%');


DELETE
FROM db_syssequencia
WHERE nomesequencia= 'inventariomaterial_i77_sequencial_seq';


DELETE
FROM db_syscampo
WHERE nomecam LIKE 'i77_%';


DELETE
FROM db_sysarqmod
WHERE codarq =
    (SELECT codarq
     FROM db_sysarquivo
     WHERE nomearq = 'inventariomaterial');


DELETE
FROM db_sysarquivo
WHERE nomearq = 'inventariomaterial';


DROP TABLE IF EXISTS inventariomaterial;


DROP SEQUENCE IF EXISTS inventariomaterial_i77_sequencial_seq;

CREATE TABLE "inventariomaterial" (
  "i77_sequencial" integer not null default 0,
  "i77_inventario" integer NOT NULL,
  "i77_estoque" integer NOT NULL,
  "i77_db_depart" integer NOT NULL,
  "i77_estoqueinicial" integer,
  "i77_contagem" integer,
  "i77_valorinicial" FLOAT,
  "i77_valormedio" FLOAT,
  "i77_vinculoinventario" BOOLEAN NOT NULL,
  "i77_datainclusao" DATE NOT NULL,
  "i77_dataprocessamento" DATE,
  "i77_ultimolancamento" integer,
  CONSTRAINT inventariomaterial_pk PRIMARY KEY ("i77_sequencial")
) WITH (
  OIDS=FALSE
);

ALTER TABLE "inventariomaterial" ADD CONSTRAINT "i77_inventario_fk" FOREIGN KEY ("i77_inventario") REFERENCES "inventario"("t75_sequencial");
ALTER TABLE "inventariomaterial" ADD CONSTRAINT "i77_estoque_fk" FOREIGN KEY ("i77_estoque") REFERENCES "matestoque"("m70_codigo");
ALTER TABLE "inventariomaterial" ADD CONSTRAINT "i77_db_depart_fk" FOREIGN KEY ("i77_db_depart") REFERENCES "db_depart"("coddepto");
ALTER TABLE "inventariomaterial" ADD CONSTRAINT "i77_ultimolancamento_fk" FOREIGN KEY ("i77_ultimolancamento") REFERENCES "matestoqueini"("m80_codigo");

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform)
VALUES (
          (SELECT max(codarq)+1
           FROM db_sysarquivo), 'inventariomaterial',
                                'estrutura para armazenar a ligação entre inventarios e materiais',
                                'i77  ',
                                '2018-01-16',
                                'Inventarios e materiais',
                                0,
                                TRUE,
                                FALSE,
                                FALSE,
                                FALSE);

 -- INSERINDO db_sysarqmod

INSERT INTO db_sysarqmod (codmod, codarq)
VALUES (
          (SELECT codmod
           FROM db_sysmodulo
           WHERE nomemod LIKE '%material%'),
          (SELECT max(codarq)
           FROM db_sysarquivo));

 -- INSERINDO db_syscampo

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_sequencial                          ',
                              'int4                                    ',
                              'Sequencia inventario material',
                              '0',
                              'Sequencia inventario material',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Sequencia inventario material');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_inventario                          ',
                              'int4                                    ',
                              'Inventario',
                              '0',
                              'Inventario',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Inventario');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_estoque                                ',
                              'int4                                    ',
                              'Código Estoque',
                              '0',
                              'Código Estoque',
                              10,
                              FALSE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Código Estoque');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_db_depart                           ',
                              'int4                                    ',
                              'Departamento do material',
                              'null',
                              'Departamento do material',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Departamento do material');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_estoqueinicial                           ',
                              'numeric(10)                                    ',
                              'Estoque inicial',
                              'null',
                              'Estoque inicial',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              4,
                              'text',
                              'Estoque inicial');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_contagem                           ',
                              'numeric(10)                                   ',
                              'Contagem',
                              'null',
                              'Contagem',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              4,
                              'text',
                              'Contagem');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_valorinicial                    ',
                              'numeric(10)                             ',
                              'Valor na tabela estoque',
                              'null',
                              'Valor na tabela estoque',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              4,
                              'text',
                              'Valor na tabela estoque');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_valormedio                       ',
                              'numeric(10)                             ',
                              'Valor no inventario',
                              'null',
                              'Valor no inventario',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              4,
                              'text',
                              'Valor no inventario');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_vinculoinventario                            ',
                              'bool                                    ',
                              'Status vinculo',
                              'null',
                              'Status vinculo',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              0,
                              'select',
                              'Status vinculo');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_datainclusao                            ',
                              'date                                    ',
                              'Data inclusao no inventario',
                              'null',
                              'Data inclusao no inventario',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              0,
                              '',
                              'Data inclusao no inventario');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_dataprocessamento                            ',
                              'date                                    ',
                              'Data processamento inventario',
                              'null',
                              'Data processamento inventario',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              0,
                              '',
                              'Data processamento inventario');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
VALUES (
          (SELECT max(codcam)+1
           FROM db_syscampo), 'i77_ultimolancamento                            ',
                              'int4                                    ',
                              'Sequencia ultimo',
                              'null',
                              'Sequencia ultimo',
                              10,
                              TRUE,
                              FALSE,
                              FALSE,
                              1,
                              'text',
                              'Data processamento inventario');

 -- INSERINDO db_syssequencia
CREATE SEQUENCE inventariomaterial_i77_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq)
VALUES (
          (SELECT max(codsequencia)+1
           FROM db_syssequencia), 'inventariomaterial_i77_sequencial_seq',
                                  1,
                                  1,
                                  9223372036854775807,
                                  1,
                                  1);

 -- INSERINDO db_sysarqcamp

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_sequencial'), 1, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_inventario'), 2, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_estoque'), 3, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_db_depart'), 4, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_estoqueinicial'), 5, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_contagem'), 6, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_valorinicial'), 7, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_valormedio'), 8, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_vinculoinventario'), 9, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_datainclusao'), 10, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_dataprocessamento'), 11, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'i77_ultimolancamento'), 12, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'inventariomaterial_i77_sequencial_seq'));



 -- INSERINDO db_sysforkey

INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'i77_inventario'), 1,
                                              3435,
                                              0);




INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'i77_estoque'), 1,
                                        1019,
                                        0);


INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'i77_ultimolancamento'), 1,
                                             1133,
                                             0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel)
VALUES (
          (SELECT max(codarq)
           FROM db_sysarquivo),
          (SELECT codcam
           FROM db_syscampo
           WHERE nomecam = 'i77_db_depart'), 1,
                                             154,
                                             0);


/*INSERE OS TIPOS DE MOVIMENTACOES DE ESTOQUE*/

INSERT INTO matestoquetipo VALUES (23, 'ENTRADA INVENTÁRIO', 't', 1);
INSERT INTO matestoquetipo VALUES (24, 'SAÍDA INVENTÁRIO', 'f', 2);
INSERT INTO conhistdocregra
VALUES (
            (SELECT max(c92_sequencial)+1
             FROM conhistdocregra), 403,
                                    'ENTRADA MANUAL',
                                    'select 1 from matestoqueinimei inner join matestoqueini on m82_matestoqueini = m80_codigo  where m82_codigo = [codigomovimentacaoestoque] and m80_codtipo = 23',
                                    2018);
-- Fim do script

COMMIT;

