-- Ocorrência 6245
BEGIN;


SELECT fc_startsession();

-- Início do script

DROP TABLE IF EXISTS dadoscomplementareslrf CASCADE;
DROP TABLE IF EXISTS operacoesdecreditolrf CASCADE;
DROP TABLE IF EXISTS publicacaoeperiodicidadergf CASCADE;
DROP TABLE IF EXISTS publicacaoeperiodicidaderreo CASCADE;


DELETE FROM db_syssequencia WHERE nomesequencia = 'dadoscomplementareslrf_c218_sequencial_seq';
DELETE FROM db_sysforkey WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_dadoscomplementareslrf');
DELETE FROM db_sysforkey WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_dadoscomplementareslrf');
DELETE FROM db_sysforkey WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_dadoscomplementareslrf');

DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dadoscomplementareslrf');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dadoscomplementareslrf');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dadoscomplementareslrf');

DELETE FROM db_sysarquivo WHERE nomearq = 'dadoscomplementareslrf';

DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'operacoesdecreditolrf');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'operacoesdecreditolrf');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'operacoesdecreditolrf');

DELETE FROM db_sysarquivo WHERE nomearq = 'operacoesdecreditolrf';

DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidadergf');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidadergf');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidadergf');

DELETE FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidadergf';

DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidaderreo');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidaderreo');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidaderreo');

DELETE FROM db_sysarquivo WHERE nomearq = 'publicacaoeperiodicidaderreo';

DELETE FROM db_syscampo WHERE nomecam LIKE 'c218%';
DELETE FROM db_syscampo WHERE nomecam LIKE 'c219%';
DELETE FROM db_syscampo WHERE nomecam LIKE 'c220%';
DELETE FROM db_syscampo WHERE nomecam LIKE 'c221%';

CREATE TABLE dadoscomplementareslrf(
  c218_sequencial bigint NOT NULL,
  c218_codorgao char(2) NOT NULL,
  c218_passivosreconhecidos double precision NOT NULL,
  c218_vlsaldoatualconcgarantiainterna double precision NOT NULL,
  c218_vlsaldoatualconcgarantia double precision NOT NULL,
  c218_vlsaldoatualcontragarantiainterna double precision NOT NULL,
  c218_vlsaldoatualcontragarantiaexterna double precision NOT NULL,
  c218_medidascorretivas text,
  c218_recalieninvpermanente double precision NOT NULL,
  c218_vldotatualizadaincentcontrib double precision NOT NULL,
  c218_vlempenhadoicentcontrib double precision NOT NULL,
  c218_vldotatualizadaincentinstfinanc double precision NOT NULL,
  c218_vlempenhadoincentinstfinanc double precision NOT NULL,
  c218_vlliqincentcontrib double precision NOT NULL,
  c218_vlliqincentinstfinanc double precision NOT NULL,
  c218_vlirpnpincentcontrib double precision NOT NULL,
  c218_vlirpnpincentinstfinanc double precision NOT NULL,
  c218_vlrecursosnaoaplicados double precision NOT NULL,
  c218_vlapropiacaodepositosjudiciais double precision NOT NULL,
  c218_vloutrosajustes double precision NOT NULL,
  c218_anousu int4 NOT NULL,
  c218_mesusu int2 NOT NULL,
  c218_metarrecada int2,
  c218_dscmedidasadotadas text, CONSTRAINT dadoscomplementareslrf_pk PRIMARY KEY (c218_sequencial)
  );

ALTER TABLE dadoscomplementareslrf ADD CONSTRAINT dadoscomplementareslrf_referencia UNIQUE (c218_codorgao, c218_anousu, c218_mesusu);


CREATE TABLE operacoesdecreditolrf(
  c219_dadoscomplementareslrf bigint,
  c219_contopcredito int2 NOT NULL,
  c219_dsccontopcredito text,
  c219_realizopcredito int2 NOT NULL,
  c219_tiporealizopcreditocapta int2,
  c219_tiporealizopcreditoreceb int2,
  c219_tiporealizopcreditoassundir int2,
  c219_tiporealizopcreditoassunobg int2
  );


CREATE TABLE publicacaoeperiodicidaderreo(
  c220_dadoscomplementareslrf bigint,
  c220_publiclrf int2 NOT NULL,
  c220_dtpublicacaorelatoriolrf date,
  c220_localpublicacao text,
  c220_tpbimestre int2,
  c220_exerciciotpbimestre int4
);

CREATE TABLE publicacaoeperiodicidadergf(
  c221_dadoscomplementareslrf bigint,
  c221_publicrgf int2 NOT NULL,
  c221_dtpublicacaorelatoriorgf date,
  c221_localpublicacaorgf text,
  c221_tpperiodo int2,
  c221_exerciciotpperiodo int4
  );


ALTER TABLE operacoesdecreditolrf ADD CONSTRAINT dadoscomplementareslrf_fk
FOREIGN KEY (c219_dadoscomplementareslrf) REFERENCES dadoscomplementareslrf (c218_sequencial) MATCH FULL;


ALTER TABLE operacoesdecreditolrf ADD CONSTRAINT operacoesdecreditolrf_uq UNIQUE (c219_dadoscomplementareslrf);


ALTER TABLE publicacaoeperiodicidaderreo ADD CONSTRAINT dadoscomplementareslrf_fk
FOREIGN KEY (c220_dadoscomplementareslrf) REFERENCES dadoscomplementareslrf (c218_sequencial) MATCH FULL;


ALTER TABLE publicacaoeperiodicidaderreo ADD CONSTRAINT publicacaoeperiodicidaderreo_uq UNIQUE (c220_dadoscomplementareslrf);


ALTER TABLE publicacaoeperiodicidadergf ADD CONSTRAINT dadoscomplementareslrf_fk
FOREIGN KEY (c221_dadoscomplementareslrf) REFERENCES dadoscomplementareslrf (c218_sequencial) MATCH FULL;


ALTER TABLE publicacaoeperiodicidadergf ADD CONSTRAINT publicacaoeperiodicidadergf_uq UNIQUE (c221_dadoscomplementareslrf);


DROP SEQUENCE IF EXISTS dadoscomplementareslrf_c218_sequencial_seq;


CREATE SEQUENCE dadoscomplementareslrf_c218_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807
START 1 CACHE 1; --CADASTRANDO TABELAS NO DICIONARIO


INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((SELECT max(codsequencia)+1 FROM db_syssequencia), 'dadoscomplementareslrf_c218_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'dadoscomplementareslrf', 'Dados Complementares à LRF', 'c218', '2018-04-26', 'Dados Complementares à LRF', 0, TRUE, FALSE, FALSE, FALSE);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (SELECT max(codarq) FROM db_sysarquivo));
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'operacoesdecreditolrf', 'Informações Sobre Operações de Crédito', 'c219', '2018-04-26', 'Informações Sobre Operações de Crédito', 0, TRUE, FALSE, FALSE, FALSE);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (SELECT max(codarq) FROM db_sysarquivo));
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'publicacaoeperiodicidaderreo', 'Publicação e Periodicidade do RREO da LRF', 'c220', '2018-04-26', 'Publicação e Periodicidade do RREO da LRF', 0, TRUE, FALSE, FALSE, FALSE);

INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (SELECT max(codarq) FROM db_sysarquivo));
INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'publicacaoeperiodicidadergf', 'Publicação e Periodicidade do RGF da LRF', 'c221', '2018-04-26', 'Publicação e Periodicidade do RGF da LRF', 0, TRUE, FALSE, FALSE, FALSE);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (SELECT max(codarq) FROM db_sysarquivo));

--CADASTRA CAMPOS
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_sequencial', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'int4', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_codorgao', 'char(2)', 'Código do órgão', '0', 'Código do órgão', 10, FALSE, FALSE, FALSE, 1, 'text', 'Código do órgão');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_passivosreconhecidos', 'double', 'Valores dos passivos  reconhecidos', '0', 'Valores dos passivos  reconhecidos', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Valores dos passivos reconhecidos');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlsaldoatualconcgarantiainterna', 'double', 'Saldo atual das concessões de garantia', '0', 'Saldo atual das concessões de garantia', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das concessões de garantia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlsaldoatualconcgarantia', 'double', 'Saldo atual das concessões de garantia', '0', 'Saldo atual das concessões de garantia', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das concessões de garantia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlsaldoatualcontragarantiainterna', 'double', 'Saldo atual das contragarantias', '0', 'Saldo atual das contragarantias', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das contragarantias');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlsaldoatualcontragarantiaexterna', 'double', 'Saldo atual das contragarantias externas', '0', 'Saldo atual das contragarantias externas', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das contragarantias externas');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_medidascorretivas', 'text', 'Medidas corretivas adotadas', '0', 'Medidas corretivas adotadas', 10, FALSE, FALSE, FALSE, 1, 'text', 'Medidas corretivas adotadas');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_recalieninvpermanente', 'Double', 'cálculo apurado da receita de alienação', '0', 'cálculo apurado da receita de alienação', 10, FALSE, FALSE, FALSE, 1, 'double', 'cálculo apurado da receita de alienação');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vldotatualizadaincentcontrib', 'double', 'Valor da dotação atualizada de Incentivo', '0', 'Valor da dotação atualizada de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Valor da dotação atualizada de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlempenhadoicentcontrib', 'Double', 'Valor empenhado de Incentivo', '0', 'Valor empenhado de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor empenhado de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vldotatualizadaincentinstfinanc', 'double', 'Valor da dotação atualizada de Incentivo', '0', 'Valor da dotação atualizada de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor da dotação atualizada de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlempenhadoincentinstfinanc', 'double', 'Valor empenhado de Incentivo concedido', '0', 'Valor empenhado de Incentivo concedido', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor empenhado de Incentivo concedido');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlliqincentcontrib', 'double', 'Valor Liquidado de Incentivo', '0', 'Valor Liquidado de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor Liquidado de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlliqincentinstfinanc', 'double', 'Valor Liquidado de Incentivo', '0', 'Valor Liquidado de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor Liquidado de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlirpnpincentcontrib', 'double', 'Restos a Pagar Não Processados', '0', 'Restos a Pagar Não Processados', 10, FALSE, FALSE, FALSE, 1, 'text', 'Restos a Pagar Não Processados');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlirpnpincentinstfinanc', 'double', 'Restos a Pagar Não Processados de Incen', '0', 'Restos a Pagar Não Processados de Incen', 10, FALSE, FALSE, FALSE, 1, 'text', 'Restos a Pagar Não Processados de Incen');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlrecursosnaoaplicados', 'double', 'Recursos do FUNDEB não aplicados', '0', 'Recursos do FUNDEB não aplicados', 10, FALSE, FALSE, FALSE, 1, 'text', 'Recursos do FUNDEB não aplicados');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vlapropiacaodepositosjudiciais', 'double', 'Saldo apurado da apropriação', '0', 'Saldo apurado da apropriação', 10, FALSE, FALSE, FALSE, 1, 'text', 'Saldo apurado da apropriação');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_vloutrosajustes', 'double', 'Valores não considerados', '0', 'Valores não considerados', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valores não considerados');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_metarrecada', 'int4', 'Atingimento da meta bimestral de arrec', '0', 'Atingimento da meta bimestral de arrec', 10, FALSE, FALSE, FALSE, 1, 'text', 'Atingimento da meta bimestral de arrec');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_dscmedidasadotadas', 'text', 'Medidas adotadas e a adotar', '0', 'Medidas adotadas e a adotar', 10, FALSE, FALSE, FALSE, 1, 'text', 'Medidas adotadas e a adotar');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_anousu', 'int4', 'Ano de Referencia', '0', 'Ano de Referencia', 10, FALSE, FALSE, FALSE, 1, 'text', 'Ano de Referencia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c218_mesusu', 'int2', 'Mes de Referencia', '0', 'Mes de Referencia', 10, FALSE, FALSE, FALSE, 1, 'text', 'Mes de Referencia');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_dadoscomplementareslrf', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_contopcredito', 'int4', 'Contratação de operação de crédito', '0', 'Contratação de operação de crédito', 10, FALSE, FALSE, FALSE, 1, 'text', 'Contratação de operação de crédito');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_dsccontopcredito', 'text', 'Descrição da ocorrência', '0', 'Descrição da ocorrência', 10, FALSE, FALSE, FALSE, 1, 'text', 'Descrição da ocorrência');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_realizopcredito', 'int4', 'operações de crédito vedadas', '0', 'operações de crédito vedadas', 10, FALSE, FALSE, FALSE, 1, 'text', 'operações de crédito vedadas');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_tiporealizopcreditocapta', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_tiporealizopcreditoreceb', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_tiporealizopcreditoassundir', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c219_tiporealizopcreditoassunobg', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c220_dadoscomplementareslrf', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c220_publiclrf', 'int4', 'Publicação do RREO da LRF', '0', 'Publicação do RREO da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Publicação do RREO da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c220_dtpublicacaorelatoriolrf', 'date', 'Data de publicação do RREO da LRF', '0', 'Data de publicação do RREO da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Data de publicação do RREO da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c220_localpublicacao', 'text', 'Onde foi dada a publicidade do RREO', '0', 'Onde foi dada a publicidade do RREO', 10, FALSE, FALSE, FALSE, 1, 'text', 'Onde foi dada a publicidade do RREO');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c220_tpbimestre', 'int4', 'Bimestre a que se refere a data de publi', '0', 'Bimestre a que se refere a data de publi', 10, FALSE, FALSE, FALSE, 1, 'text', 'Bimestre a que se refere a data de publi');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c220_exerciciotpbimestre', 'int4', 'Exercício a que se refere o período', '0', 'Exercício a que se refere o período', 10, FALSE, FALSE, FALSE, 1, 'text', 'Exercício a que se refere o período');

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c221_dadoscomplementareslrf', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c221_publicrgf', 'int4', 'Publicação do RGF da LRF', '0', 'Publicação do RGF da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Publicação do RGF da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c221_dtpublicacaorelatoriorgf', 'date', 'Data de publicação do RGF da LRF', '0', 'Data de publicação do RGF da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Data de publicação do RGF da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c221_localpublicacaorgf', 'int4', 'Onde foi dada a publicidade do RGF ', '0', 'Onde foi dada a publicidade do RGF ', 10, FALSE, FALSE, FALSE, 1, 'text', 'Onde foi dada a publicidade do RGF ');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c221_tpperiodo', 'int4', 'Periodo a que se refere a data de public', '0', 'Periodo a que se refere a data de public', 10, FALSE, FALSE, FALSE, 1, 'text', 'Periodo a que se refere a data de public');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c221_exerciciotpperiodo', 'int4', 'Exercício a que se refere o período', '0', 'Exercício a que se refere o período', 10, FALSE, FALSE, FALSE, 1, 'text', 'Exercício a que se refere o período');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_sequencial'), 1, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'dadoscomplementareslrf_c218_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_codorgao'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_passivosreconhecidos'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlsaldoatualconcgarantiainterna'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlsaldoatualconcgarantia'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlsaldoatualcontragarantiainterna'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlsaldoatualcontragarantiaexterna'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_medidascorretivas'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_recalieninvpermanente'), 9, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vldotatualizadaincentcontrib'), 10, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlempenhadoicentcontrib'), 11, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vldotatualizadaincentinstfinanc'), 12, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlempenhadoincentinstfinanc'), 13, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlliqincentcontrib'), 14, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlliqincentinstfinanc'), 15, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlirpnpincentcontrib'), 16, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlirpnpincentinstfinanc'), 17, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlrecursosnaoaplicados'), 18, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vlapropiacaodepositosjudiciais'), 19, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_vloutrosajustes'), 20, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_metarrecada'), 21, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_dscmedidasadotadas'), 22, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_anousu'), 23, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_mesusu'), 24, 0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_dadoscomplementareslrf'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_contopcredito'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_dsccontopcredito'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_realizopcredito'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_tiporealizopcreditocapta'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_tiporealizopcreditoreceb'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_tiporealizopcreditoassundir'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_tiporealizopcreditoassunobg'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_dadoscomplementareslrf'), 1, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_publiclrf'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_dtpublicacaorelatoriolrf'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_localpublicacao'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_tpbimestre'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_exerciciotpbimestre'), 6, 0);

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_dadoscomplementareslrf'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_publicrgf'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_dtpublicacaorelatoriorgf'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_localpublicacaorgf'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_tpperiodo'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_exerciciotpperiodo'), 6, 0);

INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c219_dadoscomplementareslrf'), 1, (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_sequencial'), 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c220_dadoscomplementareslrf'), 1, (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_sequencial'), 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c221_dadoscomplementareslrf'), 1, (SELECT codcam FROM db_syscampo WHERE nomecam = 'c218_sequencial'), 0);
-- TABELAS SICOM

DROP TABLE IF EXISTS dclrf202018 CASCADE;
DROP TABLE IF EXISTS dclrf302018 CASCADE;
DROP TABLE IF EXISTS dclrf402018 CASCADE;
DROP TABLE IF EXISTS dclrf102018 CASCADE;

--LIMPA DO DICIONARIO AS TABELAS DOS REGISTROS 10


DELETE FROM db_sysforkey WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf102018');
DELETE FROM db_sysforkey WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf202018');
DELETE FROM db_sysforkey WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf302018');
DELETE FROM db_sysforkey WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf402018');

DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf102018');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf102018');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf102018');
DELETE FROM db_sysarquivo WHERE nomearq = 'dclrf102018';
--LIMPA DO DICIONARIO AS TABELAS DOS REGISTROS 20
DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf202018');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf202018');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf202018');
DELETE FROM db_sysarquivo WHERE nomearq = 'dclrf202018';
--LIMPA DO DICIONARIO AS TABELAS DOS REGISTROS 30
DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf302018');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf302018');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf302018');
DELETE FROM db_sysarquivo WHERE nomearq = 'dclrf302018';
--LIMPA DO DICIONARIO AS TABELAS DOS REGISTROS 40
DELETE FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf402018');
DELETE FROM db_sysarqmod WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf402018');
DELETE FROM db_acount WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'dclrf402018');
DELETE FROM db_sysarquivo WHERE nomearq = 'dclrf402018';

DELETE FROM db_sysforkey WHERE codcam IN (SELECT codcam FROM db_syscampo WHERE nomecam like 'si190%');
DELETE FROM db_sysforkey WHERE codcam IN (SELECT codcam FROM db_syscampo WHERE nomecam like 'si191%');
DELETE FROM db_sysforkey WHERE codcam IN (SELECT codcam FROM db_syscampo WHERE nomecam like 'si192%');
DELETE FROM db_sysforkey WHERE codcam IN (SELECT codcam FROM db_syscampo WHERE nomecam like 'si193%');

DELETE FROM db_syscampo WHERE nomecam LIKE 'si190%';
DELETE FROM db_syscampo WHERE nomecam LIKE 'si191%';
DELETE FROM db_syscampo WHERE nomecam LIKE 'si192%';
DELETE FROM db_syscampo WHERE nomecam LIKE 'si193%';

CREATE TABLE dclrf102018(
  si190_sequencial bigint NOT NULL,
  si190_tiporegistro int2 NOT NULL,
  si190_codorgao char(2) NOT NULL,
  si190_passivosreconhecidos double precision NOT NULL,
  si190_vlsaldoatualconcgarantiainterna double precision NOT NULL,
  si190_vlsaldoatualconcgarantia double precision NOT NULL,
  si190_vlsaldoatualcontragarantiainterna double precision NOT NULL,
  si190_vlsaldoatualcontragarantiaexterna double precision NOT NULL,
  si190_medidascorretivas text,
  si190_recalieninvpermanente double precision NOT NULL,
  si190_vldotatualizadaincentcontrib double precision NOT NULL,
  si190_vlempenhadoicentcontrib double precision NOT NULL,
  si190_vldotatualizadaincentinstfinanc double precision NOT NULL,
  si190_vlempenhadoincentinstfinanc double precision NOT NULL,
  si190_vlliqincentcontrib double precision NOT NULL,
  si190_vlliqincentinstfinanc double precision NOT NULL,
  si190_vlirpnpincentcontrib double precision NOT NULL,
  si190_vlirpnpincentinstfinanc double precision NOT NULL,
  si190_vlrecursosnaoaplicados double precision NOT NULL,
  si190_vlapropiacaodepositosjudiciais double precision NOT NULL,
  si190_vloutrosajustes double precision NOT NULL,
  si190_metarrecada int2,
  si190_dscmedidasadotadas text,
  si190_mes int2 NOT NULL,
  CONSTRAINT dclrf102018_pk PRIMARY KEY (si190_sequencial)
);

ALTER TABLE dclrf102018 ADD CONSTRAINT dclrf102018_referencia UNIQUE (si190_codorgao, si190_mes);

CREATE TABLE dclrf202018(
  si191_reg10 bigint,
  si191_tiporegistro int2 NOT NULL,
  si191_contopcredito int2 NOT NULL,
  si191_dsccontopcredito text,
  si191_realizopcredito int2 NOT NULL,
  si191_tiporealizopcreditocapta int2,
  si191_tiporealizopcreditoreceb int2,
  si191_tiporealizopcreditoassundir int2,
  si191_tiporealizopcreditoassunobg int2
);

CREATE TABLE dclrf302018(
  si192_reg10 bigint,
  si192_tiporegistro int2 NOT NULL,
  si192_publiclrf int2 NOT NULL,
  si192_dtpublicacaorelatoriolrf date,
  si192_localpublicacao text,
  si192_tpbimestre int2,
  si192_exerciciotpbimestre int4
);


CREATE TABLE dclrf402018(
  si193_reg10 bigint,
  si193_tiporegistro int2 NOT NULL,
  si193_publicrgf int2 NOT NULL,
  si193_dtpublicacaorelatoriorgf date,
  si193_localpublicacaorgf text,
  si193_tpperiodo int2,
  si193_exerciciotpperiodo int4
  );


ALTER TABLE dclrf202018 ADD CONSTRAINT dclrf102018_fk
FOREIGN KEY (si191_reg10) REFERENCES dclrf102018 (si190_sequencial) MATCH FULL;

ALTER TABLE dclrf202018 ADD CONSTRAINT dclrf202018_uq UNIQUE (si191_reg10);

ALTER TABLE dclrf302018 ADD CONSTRAINT dclrf102018_fk
FOREIGN KEY (si192_reg10) REFERENCES dclrf102018 (si190_sequencial) MATCH FULL;

ALTER TABLE dclrf302018 ADD CONSTRAINT dclrf302018_uq UNIQUE (si192_reg10);

ALTER TABLE dclrf402018 ADD CONSTRAINT dclrf402018_fk
FOREIGN KEY (si193_reg10) REFERENCES dclrf102018 (si190_sequencial) MATCH FULL;

ALTER TABLE dclrf402018 ADD CONSTRAINT dclrf402018_uq UNIQUE (si193_reg10);

DROP SEQUENCE IF EXISTS dclrf102018_si190_sequencial_seq;

CREATE SEQUENCE dclrf102018_si190_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807
START 1 CACHE 1;

--CADASTRANDO TABELAS NO DICIONARIO
DELETE FROM db_syssequencia WHERE nomesequencia LIKE 'dclrf102018_si190_sequencial_seq';
INSERT INTO db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((SELECT max(codsequencia)+1 FROM db_syssequencia), 'dclrf102018_si190_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'dclrf102018', 'Dados Complementares à LRF', 'si190', '2018-04-26', 'Dados Complementares à LRF', 0, TRUE, FALSE, FALSE, FALSE);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (2008005, (SELECT max(codarq) FROM db_sysarquivo));

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'dclrf202018', 'Informações Sobre Operações de Crédito', 'si191', '2018-04-26', 'Informações Sobre Operações de Crédito', 0, TRUE, FALSE, FALSE, FALSE);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (2008005, (SELECT max(codarq) FROM db_sysarquivo));

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'dclrf302018', 'Publicação e Periodicidade do RREO da LRF', 'si192', '2018-04-26', 'Publicação e Periodicidade do RREO da LRF', 0, TRUE, FALSE, FALSE, FALSE);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (2008005, (SELECT max(codarq) FROM db_sysarquivo));

INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((SELECT max(codarq)+1 FROM db_sysarquivo), 'dclrf402018', 'Publicação e Periodicidade do RGF da LRF', 'si193', '2018-04-26', 'Publicação e Periodicidade do RGF da LRF', 0, TRUE, FALSE, FALSE, FALSE);
INSERT INTO db_sysarqmod (codmod, codarq) VALUES (2008005, (SELECT max(codarq) FROM db_sysarquivo));
--CADASTRA CAMPOS

INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_sequencial', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'int4', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_tiporegistro', 'int4', 'Tipo registro', '0', 'Tipo registro', 10, FALSE, FALSE, FALSE, 1, 'int4', 'Tipo registro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_codorgao', 'char(2)', 'Código do órgão', '0', 'Código do órgão', 10, FALSE, FALSE, FALSE, 1, 'text', 'Código do órgão');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_passivosreconhecidos', 'double', 'Valores dos passivos  reconhecidos', '0', 'Valores dos passivos  reconhecidos', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Valores dos passivos reconhecidos');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlsaldoatualconcgarantiainterna', 'double', 'Saldo atual das concessões de garantia', '0', 'Saldo atual das concessões de garantia', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das concessões de garantia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlsaldoatualconcgarantia', 'double', 'Saldo atual das concessões de garantia', '0', 'Saldo atual das concessões de garantia', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das concessões de garantia');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlsaldoatualcontragarantiainterna', 'double', 'Saldo atual das contragarantias', '0', 'Saldo atual das contragarantias', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das contragarantias');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlsaldoatualcontragarantiaexterna', 'double', 'Saldo atual das contragarantias externas', '0', 'Saldo atual das contragarantias externas', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Saldo atual das contragarantias externas');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_medidascorretivas', 'text', 'Medidas corretivas adotadas', '0', 'Medidas corretivas adotadas', 10, FALSE, FALSE, FALSE, 1, 'text', 'Medidas corretivas adotadas');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_recalieninvpermanente', 'Double', 'cálculo apurado da receita de alienação', '0', 'cálculo apurado da receita de alienação', 10, FALSE, FALSE, FALSE, 1, 'double', 'cálculo apurado da receita de alienação');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vldotatualizadaincentcontrib', 'double', 'Valor da dotação atualizada de Incentivo', '0', 'Valor da dotação atualizada de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'Double', 'Valor da dotação atualizada de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlempenhadoicentcontrib', 'Double', 'Valor empenhado de Incentivo', '0', 'Valor empenhado de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor empenhado de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vldotatualizadaincentinstfinanc', 'double', 'Valor da dotação atualizada de Incentivo', '0', 'Valor da dotação atualizada de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor da dotação atualizada de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlempenhadoincentinstfinanc', 'double', 'Valor empenhado de Incentivo concedido', '0', 'Valor empenhado de Incentivo concedido', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor empenhado de Incentivo concedido');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlliqincentcontrib', 'double', 'Valor Liquidado de Incentivo', '0', 'Valor Liquidado de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor Liquidado de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlliqincentinstfinanc', 'double', 'Valor Liquidado de Incentivo', '0', 'Valor Liquidado de Incentivo', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valor Liquidado de Incentivo');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlirpnpincentcontrib', 'double', 'Restos a Pagar Não Processados', '0', 'Restos a Pagar Não Processados', 10, FALSE, FALSE, FALSE, 1, 'text', 'Restos a Pagar Não Processados');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlirpnpincentinstfinanc', 'double', 'Restos a Pagar Não Processados de Incen', '0', 'Restos a Pagar Não Processados de Incen', 10, FALSE, FALSE, FALSE, 1, 'text', 'Restos a Pagar Não Processados de Incen');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlrecursosnaoaplicados', 'double', 'Recursos do FUNDEB não aplicados', '0', 'Recursos do FUNDEB não aplicados', 10, FALSE, FALSE, FALSE, 1, 'text', 'Recursos do FUNDEB não aplicados');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vlapropiacaodepositosjudiciais', 'double', 'Saldo apurado da apropriação', '0', 'Saldo apurado da apropriação', 10, FALSE, FALSE, FALSE, 1, 'text', 'Saldo apurado da apropriação');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_vloutrosajustes', 'double', 'Valores não considerados', '0', 'Valores não considerados', 10, FALSE, FALSE, FALSE, 1, 'text', 'Valores não considerados');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_metarrecada', 'int4', 'Atingimento da meta bimestral de arrec', '0', 'Atingimento da meta bimestral de arrec', 10, FALSE, FALSE, FALSE, 1, 'text', 'Atingimento da meta bimestral de arrec');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_dscmedidasadotadas', 'text', 'Medidas adotadas e a adotar', '0', 'Medidas adotadas e a adotar', 10, FALSE, FALSE, FALSE, 1, 'text', 'Medidas adotadas e a adotar');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si190_mes', 'int2', 'Mes de Referencia', '0', 'Mes de Referencia', 10, FALSE, FALSE, FALSE, 1, 'text', 'Mes de Referencia');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_reg10', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_tiporegistro', 'int2', 'Tipo registro', '0', 'Tipo registro', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo registro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_contopcredito', 'int4', 'Contratação de operação de crédito', '0', 'Contratação de operação de crédito', 10, FALSE, FALSE, FALSE, 1, 'text', 'Contratação de operação de crédito');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_dsccontopcredito', 'text', 'Descrição da ocorrência', '0', 'Descrição da ocorrência', 10, FALSE, FALSE, FALSE, 1, 'text', 'Descrição da ocorrência');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_realizopcredito', 'int4', 'operações de crédito vedadas', '0', 'operações de crédito vedadas', 10, FALSE, FALSE, FALSE, 1, 'text', 'operações de crédito vedadas');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_tiporealizopcreditocapta', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_tiporealizopcreditoreceb', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_tiporealizopcreditoassundir', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si191_tiporealizopcreditoassunobg', 'int4', 'Tipo da realização de operações de créd', '0', 'Tipo da realização de operações de créd', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo da realização de operações de créd');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si192_reg10', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si192_tiporegistro', 'int4', 'Tipo registro', '0', 'Tipo registro', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo registro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si192_publiclrf', 'int4', 'Publicação do RREO da LRF', '0', 'Publicação do RREO da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Publicação do RREO da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si192_dtpublicacaorelatoriolrf', 'date', 'Data de publicação do RREO da LRF', '0', 'Data de publicação do RREO da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Data de publicação do RREO da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si192_localpublicacao', 'text', 'Onde foi dada a publicidade do RREO', '0', 'Onde foi dada a publicidade do RREO', 10, FALSE, FALSE, FALSE, 1, 'text', 'Onde foi dada a publicidade do RREO');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si192_tpbimestre', 'int4', 'Bimestre a que se refere a data de publi', '0', 'Bimestre a que se refere a data de publi', 10, FALSE, FALSE, FALSE, 1, 'text', 'Bimestre a que se refere a data de publi');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si192_exerciciotpbimestre', 'int4', 'Exercício a que se refere o período', '0', 'Exercício a que se refere o período', 10, FALSE, FALSE, FALSE, 1, 'text', 'Exercício a que se refere o período');


INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si193_reg10', 'int4', 'Sequencial DCLRF', '0', 'Sequencial DCLRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Sequencial DCLRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si193_tiporegistro', 'int4', 'Tipo Registro', '0', 'Tipo Registro', 10, FALSE, FALSE, FALSE, 1, 'text', 'Tipo Registro');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si193_publicrgf', 'int4', 'Publicação do RGF da LRF', '0', 'Publicação do RGF da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Publicação do RGF da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si193_dtpublicacaorelatoriorgf', 'date', 'Data de publicação do RGF da LRF', '0', 'Data de publicação do RGF da LRF', 10, FALSE, FALSE, FALSE, 1, 'text', 'Data de publicação do RGF da LRF');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si193_localpublicacaorgf', 'int4', 'Onde foi dada a publicidade do RGF ', '0', 'Onde foi dada a publicidade do RGF ', 10, FALSE, FALSE, FALSE, 1, 'text', 'Onde foi dada a publicidade do RGF ');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si193_tpperiodo', 'int4', 'Periodo a que se refere a data de public', '0', 'Periodo a que se refere a data de public', 10, FALSE, FALSE, FALSE, 1, 'text', 'Periodo a que se refere a data de public');
INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si193_exerciciotpperiodo', 'int4', 'Exercício a que se refere o período', '0', 'Exercício a que se refere o período', 10, FALSE, FALSE, FALSE, 1, 'text', 'Exercício a que se refere o período');

INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_sequencial'), 1, (SELECT codsequencia FROM db_syssequencia WHERE nomesequencia = 'dclrf102018_si190_sequencial_seq'));
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_codorgao'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_passivosreconhecidos'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlsaldoatualconcgarantiainterna'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlsaldoatualconcgarantia'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlsaldoatualcontragarantiainterna'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlsaldoatualcontragarantiaexterna'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_medidascorretivas'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_recalieninvpermanente'), 9, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vldotatualizadaincentcontrib'), 10, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlempenhadoicentcontrib'), 11, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vldotatualizadaincentinstfinanc'), 12, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlempenhadoincentinstfinanc'), 13, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlliqincentcontrib'), 14, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlliqincentinstfinanc'), 15, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlirpnpincentcontrib'), 16, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlirpnpincentinstfinanc'), 17, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlrecursosnaoaplicados'), 18, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vlapropiacaodepositosjudiciais'), 19, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_vloutrosajustes'), 20, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_metarrecada'), 21, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_dscmedidasadotadas'), 22, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_tiporegistro'), 23, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-3 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_mes'), 24, 0);



INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_reg10'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_contopcredito'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_dsccontopcredito'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_realizopcredito'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_tiporealizopcreditocapta'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_tiporealizopcreditoreceb'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_tiporealizopcreditoassundir'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_tiporealizopcreditoassunobg'), 8, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-2 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_tiporegistro'), 9, 0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_reg10'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_publiclrf'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_dtpublicacaorelatoriolrf'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_localpublicacao'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_tpbimestre'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_exerciciotpbimestre'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq)-1 FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_tiporegistro'), 7, 0);


INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_reg10'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_publicrgf'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_dtpublicacaorelatoriorgf'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_localpublicacaorgf'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_tpperiodo'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_exerciciotpperiodo'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_tiporegistro'), 7, 0);

INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si191_reg10'), 1, (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_sequencial'), 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si192_reg10'), 1, (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_sequencial'), 0);
INSERT INTO db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si193_reg10'), 1, (SELECT codcam FROM db_syscampo WHERE nomecam = 'si190_sequencial'), 0);


-- Fim do script

COMMIT;
