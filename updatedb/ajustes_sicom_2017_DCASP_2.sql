BEGIN;
SELECT fc_startsession();

-- Deletando  sequences
DROP SEQUENCE IF EXISTS bpdcasp102017_si208_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp202017_si209_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp302017_si210_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp402017_si211_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp502017_si212_sequencial_seq;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp102017_si208_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp202017_si209_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp202017_si209_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp302017_si210_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp402017_si211_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp502017_si212_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp602017_si213_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp702017_si214_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE bpdcasp712017_si215_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dvpdcasp102017_si216_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dvpdcasp202017_si217_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

CREATE SEQUENCE dvpdcasp302017_si218_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

-- Operações nas tabelas
ALTER TABLE bpdcasp102017 ADD COLUMN si208_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp102017 ADD COLUMN si208_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp102017 ADD COLUMN si208_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativocircucaixaequicaixa        SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativocircucredicurtoprazo        SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativocircuinvestapliccurtoprazo        SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativocircuestoques        SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativocircuestoques        SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativocircuvpdantecipada SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativonaocircucredilongoprazo SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativonaocircuinvestemplongpraz SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativonaocircuestoques SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativonaocircuvpdantecipada SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativonaocircuinvestimentos SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativonaocircuimobilizado SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vlativonaocircuintagivel SET DATA TYPE float8;
ALTER TABLE bpdcasp102017 ALTER COLUMN si208_vltotalativo SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bpdcasp202017 ADD COLUMN si209_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp202017 ADD COLUMN si209_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp202017 ADD COLUMN si209_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivcircultrabprevicurtoprazo  SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivcirculemprefinancurtoprazo SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivocirculafornecedcurtoprazo SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassicircuobrigfiscacurtoprazo   SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivocirculaobrigacoutrosentes SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivocirculaprovisoecurtoprazo SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassicircudemaiobrigcurtoprazo   SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassinaocircutrabprevilongoprazo SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassnaocircemprfinalongpraz      SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivnaocirculforneclongoprazo  SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassnaocircobrifisclongpraz      SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivnaocirculprovislongoprazo  SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassnaocircdemaobrilongpraz      SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpassivonaocircularesuldiferido   SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidocapitalsocial        SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidoadianfuturocapital   SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidoreservacapital       SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidoajustavaliacao       SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidoreservalucros        SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidodemaisreservas       SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidoresultexercicio      SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidresultacumexeranteri  SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vlpatriliquidoacoescotas           SET DATA TYPE float8;
ALTER TABLE bpdcasp202017 ALTER COLUMN si209_vltotalpassivo                     SET DATA TYPE float8;


COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bpdcasp302017 ADD COLUMN si210_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp302017 ADD COLUMN si210_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp302017 ADD COLUMN si210_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp302017 ALTER COLUMN si210_vlativofinanceiro                 SET DATA TYPE float8;
ALTER TABLE bpdcasp302017 ALTER COLUMN si210_vlativopermanente                 SET DATA TYPE float8;
ALTER TABLE bpdcasp302017 ALTER COLUMN si210_vltotalativofinanceiropermanente  SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bpdcasp402017 ADD COLUMN si211_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp402017 ADD COLUMN si211_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp402017 ADD COLUMN si211_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp402017 ALTER COLUMN si211_vlpassivofinanceiro     SET DATA TYPE float8;
ALTER TABLE bpdcasp402017 ALTER COLUMN si211_vlpassivopermanente     SET DATA TYPE float8;
ALTER TABLE bpdcasp402017 ALTER COLUMN si211_vltotalpassivofinanceiropermanente  SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bpdcasp502017 ADD COLUMN si212_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp502017 ADD COLUMN si212_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp502017 ADD COLUMN si212_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp502017 ALTER COLUMN si212_vlsaldopatrimonial SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bpdcasp602017 ADD COLUMN si213_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp602017 ADD COLUMN si213_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp602017 ADD COLUMN si213_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotenativosgarancontrarecebi SET DATA TYPE float8;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotenativodirconveoutroinstr SET DATA TYPE float8;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotenativosdireitoscontratua SET DATA TYPE float8;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotenativosoutrosatos        SET DATA TYPE float8;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotenpassivgarancontraconced SET DATA TYPE float8;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotepassobriconvoutrinst     SET DATA TYPE float8;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotenpassivoobrigacocontratu SET DATA TYPE float8;
ALTER TABLE bpdcasp602017 ALTER COLUMN si213_vlatospotenpassivooutrosatos       SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bpdcasp702017 ADD COLUMN si214_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp702017 ADD COLUMN si214_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp702017 ADD COLUMN si214_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp702017 ALTER COLUMN si214_vltotalsupdef SET DATA TYPE float8;


COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE bpdcasp712017 ADD COLUMN si215_ano      int4 NOT NULL default 0;
ALTER TABLE bpdcasp712017 ADD COLUMN si215_periodo  int4 NOT NULL default 0;
ALTER TABLE bpdcasp712017 ADD COLUMN si215_institu  int4 NOT NULL default 0;
ALTER TABLE bpdcasp712017 ALTER COLUMN si215_vlsaldofonte SET DATA TYPE float8;


COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dvpdcasp102017 ADD COLUMN si216_ano      int4 NOT NULL default 0;
ALTER TABLE dvpdcasp102017 ADD COLUMN si216_periodo  int4 NOT NULL default 0;
ALTER TABLE dvpdcasp102017 ADD COLUMN si216_institu  int4 NOT NULL default 0;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vlimpostos                          SET DATA TYPE float8;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vlcontribuicoes                     SET DATA TYPE float8;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vlexploracovendasdireitos           SET DATA TYPE float8;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vlvariacoesaumentativasfinanceiras  SET DATA TYPE float8;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vltransfdelegacoesrecebidas         SET DATA TYPE float8;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vlvalorizacaoativodesincorpassivo   SET DATA TYPE float8;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vloutrasvariacoespatriaumentativas  SET DATA TYPE float8;
ALTER TABLE dvpdcasp102017 ALTER COLUMN si216_vltotalvpaumentativas               SET DATA TYPE float8;

COMMIT;
--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dvpdcasp202017 ADD COLUMN si217_ano      int4 NOT NULL default 0;
ALTER TABLE dvpdcasp202017 ADD COLUMN si217_periodo  int4 NOT NULL default 0;
ALTER TABLE dvpdcasp202017 ADD COLUMN si217_institu  int4 NOT NULL default 0;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vldiminutivapessoaencargos         SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vlprevassistenciais                SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vlservicoscapitalfixo              SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vldiminutivavariacoesfinanceiras   SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vltransfconcedidas                 SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vldesvaloativoincorpopassivo       SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vltributarias                      SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vlmercadoriavendidoservicos        SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vloutrasvariacoespatridiminutivas  SET DATA TYPE float8;
ALTER TABLE dvpdcasp202017 ALTER COLUMN si217_vltotalvpdiminutivas               SET DATA TYPE float8;

COMMIT;

--------------------------

BEGIN;
SELECT fc_startsession();

ALTER TABLE dvpdcasp302017 ADD COLUMN si218_ano      int4 NOT NULL default 0;
ALTER TABLE dvpdcasp302017 ADD COLUMN si218_periodo  int4 NOT NULL default 0;
ALTER TABLE dvpdcasp302017 ADD COLUMN si218_institu  int4 NOT NULL default 0;
ALTER TABLE dvpdcasp302017 ALTER COLUMN si218_vlresultadopatrimonialperiodo SET DATA TYPE float8;

COMMIT;

