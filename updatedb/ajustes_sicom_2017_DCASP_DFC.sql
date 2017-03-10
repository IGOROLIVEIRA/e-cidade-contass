BEGIN;
SELECT fc_startsession();


-- Deletando  sequences
DROP SEQUENCE IF EXISTS dfcdcasp102017_si219_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp202017_si220_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp302017_si221_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp402017_si222_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp502017_si223_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp602017_si224_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp702017_si225_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp802017_si226_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp902017_si227_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp1002017_si228_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp1102017_si229_sequencial_seq;


COMMIT;

----------------

BEGIN;
SELECT fc_startsession();


-- Criando sequences
CREATE SEQUENCE dfcdcasp102017_si219_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp202017_si220_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp302017_si221_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp402017_si222_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp502017_si223_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp602017_si224_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp702017_si225_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp802017_si226_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp902017_si227_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp1002017_si228_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dfcdcasp1102017_si229_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

-- Operações nas tabelas
ALTER TABLE dfcdcasp102017 ADD COLUMN si219_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp102017 ADD COLUMN si219_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp102017 ADD COLUMN si219_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp102017 ALTER COLUMN si219_vlreceitaderivadaoriginaria      SET DATA TYPE float8;
ALTER TABLE dfcdcasp102017 ALTER COLUMN si219_vltranscorrenterecebida          SET DATA TYPE float8;
ALTER TABLE dfcdcasp102017 ALTER COLUMN si219_vloutrosingressosoperacionais    SET DATA TYPE float8;
ALTER TABLE dfcdcasp102017 ALTER COLUMN si219_vltotalingressosativoperacionais SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp202017 ADD COLUMN si220_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp202017 ADD COLUMN si220_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp202017 ADD COLUMN si220_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp202017 ALTER COLUMN si220_vldesembolsopessoaldespesas         SET DATA TYPE float8;
ALTER TABLE dfcdcasp202017 ALTER COLUMN si220_vldesembolsojurosencargdivida       SET DATA TYPE float8;
ALTER TABLE dfcdcasp202017 ALTER COLUMN si220_vldesembolsotransfconcedidas        SET DATA TYPE float8;
ALTER TABLE dfcdcasp202017 ALTER COLUMN si220_vloutrosdesembolsos                 SET DATA TYPE float8;
ALTER TABLE dfcdcasp202017 ALTER COLUMN si220_vltotaldesembolsosativoperacionais  SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp302017 ADD COLUMN si221_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp302017 ADD COLUMN si221_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp302017 ADD COLUMN si221_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp302017 ALTER COLUMN si221_vlfluxocaixaliquidooperacional  SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp402017 ADD COLUMN si222_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp402017 ADD COLUMN si222_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp402017 ADD COLUMN si222_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp402017 ALTER COLUMN si222_vlalienacaobens                     SET DATA TYPE float8;
ALTER TABLE dfcdcasp402017 ALTER COLUMN si222_vlamortizacaoemprestimoconcedido    SET DATA TYPE float8;
ALTER TABLE dfcdcasp402017 ALTER COLUMN si222_vloutrosingressos                   SET DATA TYPE float8;
ALTER TABLE dfcdcasp402017 ALTER COLUMN si222_vltotalingressosatividainvestiment  SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp502017 ADD COLUMN si223_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp502017 ADD COLUMN si223_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp502017 ADD COLUMN si223_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp502017 ALTER COLUMN si223_vlaquisicaoativonaocirculante       SET DATA TYPE float8;
ALTER TABLE dfcdcasp502017 ALTER COLUMN si223_vlconcessaoempresfinanciamento      SET DATA TYPE float8;
ALTER TABLE dfcdcasp502017 ALTER COLUMN si223_vloutrosdesembolsos                 SET DATA TYPE float8;
ALTER TABLE dfcdcasp502017 ALTER COLUMN si223_vltotaldesembolsoatividainvestimen  SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp602017 ADD COLUMN si224_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp602017 ADD COLUMN si224_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp602017 ADD COLUMN si224_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp602017 ALTER COLUMN si224_vlfluxocaixaliquidoinvestimento SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp702017 ADD COLUMN si225_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp702017 ADD COLUMN si225_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp702017 ADD COLUMN si225_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp702017 ALTER COLUMN si225_vloperacoescredito                  SET DATA TYPE float8;
ALTER TABLE dfcdcasp702017 ALTER COLUMN si225_vlintegralizacaodependentes         SET DATA TYPE float8;
ALTER TABLE dfcdcasp702017 ALTER COLUMN si225_vltranscapitalrecebida              SET DATA TYPE float8;
ALTER TABLE dfcdcasp702017 ALTER COLUMN si225_vloutrosingressosfinanciamento      SET DATA TYPE float8;
ALTER TABLE dfcdcasp702017 ALTER COLUMN si225_vltotalingressoatividafinanciament  SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp802017 ADD COLUMN si226_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp802017 ADD COLUMN si226_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp802017 ADD COLUMN si226_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp802017 ALTER COLUMN si226_vlamortizacaorefinanciamento        SET DATA TYPE float8;
ALTER TABLE dfcdcasp802017 ALTER COLUMN si226_vloutrosdesembolsosfinanciamento    SET DATA TYPE float8;
ALTER TABLE dfcdcasp802017 ALTER COLUMN si226_vltotaldesembolsoatividafinanciame  SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp902017 ADD COLUMN si227_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp902017 ADD COLUMN si227_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp902017 ADD COLUMN si227_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp902017 ALTER COLUMN si227_vlfluxocaixafinanciamento SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp1002017 ADD COLUMN si228_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp1002017 ADD COLUMN si228_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp1002017 ADD COLUMN si228_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp1002017 ALTER COLUMN si228_vlgeracaoliquidaequivalentecaixa  SET DATA TYPE float8;

COMMIT;

----------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dfcdcasp1102017 ADD COLUMN si229_anousu  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp1102017 ADD COLUMN si229_periodo int4 NOT NULL default 0;
ALTER TABLE dfcdcasp1102017 ADD COLUMN si229_instit  int4 NOT NULL default 0;
ALTER TABLE dfcdcasp1102017 ALTER COLUMN si229_vlcaixaequivalentecaixainicial SET DATA TYPE float8;
ALTER TABLE dfcdcasp1102017 ALTER COLUMN si229_vlcaixaequivalentecaixafinal   SET DATA TYPE float8;

COMMIT;
