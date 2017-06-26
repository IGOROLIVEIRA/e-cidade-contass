BEGIN;
SELECT fc_startsession();

 -- Rotina
INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Prev. Extra-Orçamentárias', '','con4_recextorc001.php',1,1,'','t');
INSERT INTO db_menu VALUES (32, (SELECT max(id_item) FROM db_itensmenu), 1, 39);

COMMIT;

------------

BEGIN;
SELECT fc_startsession();

-- Relatório
INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Prev. Extra-Orçamentárias', '','cai2_controleext001.php',1,1,'','t');
INSERT INTO db_menu VALUES (30, (SELECT max(id_item) FROM db_itensmenu), 1, 39);

COMMIT;

------------

BEGIN;
SELECT fc_startsession();

--DROP TABLE & SEQUENCES:
DROP TABLE IF EXISTS controleext CASCADE;

-- TABELAS E ESTRUTURA
-- Módulo: caixa
CREATE TABLE controleext(
k167_sequencial   int4 NOT NULL default 0,
k167_codcon   int4 NOT NULL default 0,
k167_anousu   int4  default 0,
k167_prevanu    float8  default 0,
k167_dtcad    date default null,
k167_anocad    int4  default 0,
CONSTRAINT controleext_sequ_pk PRIMARY KEY (k167_sequencial));

-- CHAVE ESTRANGEIRA
ALTER TABLE controleext
ADD CONSTRAINT controleext_codcon_ae_fk FOREIGN KEY (k167_codcon,k167_anousu)
REFERENCES conplano;

ALTER TABLE controleext
ADD CONSTRAINT controleext_codconanousu_in UNIQUE (k167_codcon,k167_anousu);

COMMIT;

------------

BEGIN;
SELECT fc_startsession();

DROP SEQUENCE IF EXISTS controleext_k167_sequencial_seq;

-- Criando sequences
CREATE SEQUENCE controleext_k167_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

------------

BEGIN;
SELECT fc_startsession();

-- Módulo: caixa
CREATE TABLE controleextvlrtransf(
k168_codprevisao    int4 NOT NULL default 0,
k168_mescompet    int4  default 0,
k168_previni    date NOT NULL ,
k168_prevfim    date NOT NULL ,
k168_vlrprev    float8 default 0
);

-- CHAVE ESTRANGEIRA
ALTER TABLE controleextvlrtransf
ADD CONSTRAINT controleextvlrtransf_sequencial_ae_fk FOREIGN KEY (k168_codprevisao)
REFERENCES controleext(k167_sequencial);

ALTER TABLE controleextvlrtransf
ADD CONSTRAINT controleextvlrtransf_codprevisaomes_in UNIQUE (k168_codprevisao,k168_mescompet);

COMMIT;
