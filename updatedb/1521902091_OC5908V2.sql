begin;
select fc_startsession();
DROP TABLE IF EXISTS public.bfdcasp202017;
DROP TABLE IF EXISTS public.bfdcasp102017;
DROP TABLE IF EXISTS public.bodcasp502017;
DROP TABLE IF EXISTS public.bodcasp402017;
DROP TABLE IF EXISTS public.bodcasp302017;
DROP TABLE IF EXISTS public.bodcasp202017;
DROP TABLE IF EXISTS public.bodcasp102017;
DROP TABLE IF EXISTS public.bpdcasp712017;
DROP TABLE IF EXISTS public.bpdcasp702017;
DROP TABLE IF EXISTS public.bpdcasp602017;
DROP TABLE IF EXISTS public.bpdcasp502017;
DROP TABLE IF EXISTS public.bpdcasp402017;
DROP TABLE IF EXISTS public.bpdcasp302017;
DROP TABLE IF EXISTS public.bpdcasp202017;
DROP TABLE IF EXISTS public.bpdcasp102017;
DROP TABLE IF EXISTS public.dfcdcasp1102017;
DROP TABLE IF EXISTS public.dfcdcasp1002017;
DROP TABLE IF EXISTS public.dfcdcasp902017;
DROP TABLE IF EXISTS public.dfcdcasp802017;
DROP TABLE IF EXISTS public.dfcdcasp702017;
DROP TABLE IF EXISTS public.dfcdcasp602017;
DROP TABLE IF EXISTS public.dfcdcasp502017;
DROP TABLE IF EXISTS public.dfcdcasp402017;
DROP TABLE IF EXISTS public.dfcdcasp302017;
DROP TABLE IF EXISTS public.dfcdcasp202017;
DROP TABLE IF EXISTS public.dfcdcasp102017;
DROP TABLE IF EXISTS public.dvpdcasp302017;
DROP TABLE IF EXISTS public.dvpdcasp202017;
DROP TABLE IF EXISTS public.dvpdcasp102017;
DROP TABLE IF EXISTS public.idedcasp2017;
DROP TABLE IF EXISTS public.rpsd112017;
DROP TABLE IF EXISTS public.rpsd102017;

DROP SEQUENCE IF EXISTS bfdcasp102017_si206_sequencial_seq;
DROP SEQUENCE IF EXISTS bfdcasp202017_si207_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp102017_si201_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp202017_si202_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp302017_si203_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp402017_si204_sequencial_seq;
DROP SEQUENCE IF EXISTS bodcasp502017_si205_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp102017_si208_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp202017_si209_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp302017_si210_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp402017_si211_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp502017_si212_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp602017_si213_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp702017_si214_sequencial_seq;
DROP SEQUENCE IF EXISTS bpdcasp712017_si215_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp1002017_si228_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp102017_si219_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp1102017_si229_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp202017_si220_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp302017_si221_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp402017_si222_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp502017_si223_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp602017_si224_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp702017_si225_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp802017_si226_sequencial_seq;
DROP SEQUENCE IF EXISTS dfcdcasp902017_si227_sequencial_seq;
DROP SEQUENCE IF EXISTS dvpdcasp102017_si216_sequencial_seq;
DROP SEQUENCE IF EXISTS dvpdcasp202017_si217_sequencial_seq;
DROP SEQUENCE IF EXISTS dvpdcasp302017_si218_sequencial_seq;
DROP SEQUENCE IF EXISTS idedcasp2017_si200_sequencial_seq;
DROP SEQUENCE IF EXISTS rpsd102017_si189_sequencial_seq;
DROP SEQUENCE IF EXISTS rpsd112017_si190_sequencial_seq;


CREATE SEQUENCE bfdcasp102017_si206_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bfdcasp202017_si207_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bodcasp102017_si201_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bodcasp202017_si202_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bodcasp302017_si203_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bodcasp402017_si204_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bodcasp502017_si205_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp102017_si208_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp202017_si209_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp302017_si210_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp402017_si211_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp502017_si212_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp602017_si213_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp702017_si214_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE bpdcasp712017_si215_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp1002017_si228_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp102017_si219_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp1102017_si229_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp202017_si220_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp302017_si221_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp402017_si222_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp502017_si223_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp602017_si224_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp702017_si225_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp802017_si226_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dfcdcasp902017_si227_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dvpdcasp102017_si216_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dvpdcasp202017_si217_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE dvpdcasp302017_si218_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE idedcasp2017_si200_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE rpsd102017_si189_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE rpsd112017_si190_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;


-- Table: public.idedcasp2017


CREATE TABLE public.idedcasp2017
(
  si200_sequencial integer NOT NULL DEFAULT 0,
  si200_codmunicipio character varying(5) COLLATE pg_catalog."default" NOT NULL,
  si200_cnpjorgao character varying(14) COLLATE pg_catalog."default" NOT NULL,
  si200_codorgao character varying(2) COLLATE pg_catalog."default" NOT NULL,
  si200_tipoorgao character varying(2) COLLATE pg_catalog."default" NOT NULL,
  si200_tipodemcontabil integer NOT NULL DEFAULT 0,
  si200_exercicioreferencia integer NOT NULL DEFAULT 0,
  si200_datageracao date NOT NULL,
  si200_codcontroleremessa character varying(20) COLLATE pg_catalog."default",
  si200_anousu integer NOT NULL DEFAULT 0,
  si200_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT idedcasp2017_sequ_pk PRIMARY KEY (si200_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.idedcasp2017
  OWNER to dbportal;

CREATE TABLE public.bfdcasp102017
(
  si206_sequencial integer NOT NULL DEFAULT 0,
  si206_tiporegistro integer NOT NULL DEFAULT 0,
  si206_exercicio integer NOT NULL DEFAULT 0,
  si206_vlrecorcamenrecurord double precision NOT NULL DEFAULT 0,
  si206_vlrecorcamenrecinceduc double precision NOT NULL DEFAULT 0,
  si206_vlrecorcamenrecurvincusaude double precision NOT NULL DEFAULT 0,
  si206_vlrecorcamenrecurvincurpps double precision NOT NULL DEFAULT 0,
  si206_vlrecorcamenrecurvincuassistsoc double precision NOT NULL DEFAULT 0,
  si206_vlrecorcamenoutrasdestrecursos double precision NOT NULL DEFAULT 0,
  si206_vltransfinanexecuorcamentaria double precision NOT NULL DEFAULT 0,
  si206_vltransfinanindepenexecuorc double precision NOT NULL DEFAULT 0,
  si206_vltransfinanreceaportesrpps double precision NOT NULL DEFAULT 0,
  si206_vlincrirspnaoprocessado double precision NOT NULL DEFAULT 0,
  si206_vlincrirspprocessado double precision NOT NULL DEFAULT 0,
  si206_vldeporestituvinculados double precision NOT NULL DEFAULT 0,
  si206_vloutrosrecextraorcamentario double precision NOT NULL DEFAULT 0,
  si206_vlsaldoexeranteriorcaixaequicaixa double precision NOT NULL DEFAULT 0,
  si206_vlsaldoexerantdeporestvinc double precision NOT NULL DEFAULT 0,
  si206_vltotalingresso double precision DEFAULT 0,
  si206_ano integer NOT NULL DEFAULT 0,
  si206_periodo integer NOT NULL DEFAULT 0,
  si206_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bfdcasp102017_sequ_pk PRIMARY KEY (si206_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bfdcasp102017
  OWNER to dbportal;

CREATE TABLE public.bfdcasp202017
(
  si207_sequencial integer NOT NULL DEFAULT 0,
  si207_tiporegistro integer NOT NULL DEFAULT 0,
  si207_exercicio integer NOT NULL DEFAULT 0,
  si207_vldesporcamenrecurordinarios double precision NOT NULL DEFAULT 0,
  si207_vldesporcamenrecurvincueducacao double precision NOT NULL DEFAULT 0,
  si207_vldesporcamenrecurvincusaude double precision NOT NULL DEFAULT 0,
  si207_vldesporcamenrecurvincurpps double precision NOT NULL DEFAULT 0,
  si207_vldesporcamenrecurvincuassistsoc double precision NOT NULL DEFAULT 0,
  si207_vloutrasdesporcamendestrecursos double precision NOT NULL DEFAULT 0,
  si207_vltransfinanconcexecorcamentaria double precision NOT NULL DEFAULT 0,
  si207_vltransfinanconcindepenexecorc double precision NOT NULL DEFAULT 0,
  si207_vltransfinanconcaportesrecurpps double precision NOT NULL DEFAULT 0,
  si207_vlpagrspnaoprocessado double precision NOT NULL DEFAULT 0,
  si207_vlpagrspprocessado double precision NOT NULL DEFAULT 0,
  si207_vldeposrestvinculados double precision NOT NULL DEFAULT 0,
  si207_vloutrospagextraorcamentarios double precision NOT NULL DEFAULT 0,
  si207_vlsaldoexeratualcaixaequicaixa double precision NOT NULL DEFAULT 0,
  si207_vlsaldoexeratualdeporestvinc double precision NOT NULL DEFAULT 0,
  si207_vltotaldispendios double precision DEFAULT 0,
  si207_ano integer NOT NULL DEFAULT 0,
  si207_periodo integer NOT NULL DEFAULT 0,
  si207_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bfdcasp202017_sequ_pk PRIMARY KEY (si207_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bfdcasp202017
  OWNER to dbportal;

CREATE TABLE public.bodcasp102017
(
  si201_sequencial integer NOT NULL DEFAULT 0,
  si201_tiporegistro integer NOT NULL DEFAULT 0,
  si201_faserecorcamentaria integer NOT NULL DEFAULT 0,
  si201_vlrectributaria double precision NOT NULL DEFAULT 0,
  si201_vlreccontribuicoes double precision NOT NULL DEFAULT 0,
  si201_vlrecpatrimonial double precision NOT NULL DEFAULT 0,
  si201_vlrecagropecuaria double precision NOT NULL DEFAULT 0,
  si201_vlrecindustrial double precision NOT NULL DEFAULT 0,
  si201_vlrecservicos double precision NOT NULL DEFAULT 0,
  si201_vltransfcorrentes double precision NOT NULL DEFAULT 0,
  si201_vloutrasreccorrentes double precision NOT NULL DEFAULT 0,
  si201_vloperacoescredito double precision NOT NULL DEFAULT 0,
  si201_vlalienacaobens double precision NOT NULL DEFAULT 0,
  si201_vlamortemprestimo double precision NOT NULL DEFAULT 0,
  si201_vltransfcapital double precision NOT NULL DEFAULT 0,
  si201_vloutrasreccapital double precision NOT NULL DEFAULT 0,
  si201_vlrecarrecadaxeant double precision NOT NULL DEFAULT 0,
  si201_vlopcredrefintermob double precision NOT NULL DEFAULT 0,
  si201_vlopcredrefintcontrat double precision NOT NULL DEFAULT 0,
  si201_vlopcredrefextmob double precision NOT NULL DEFAULT 0,
  si201_vlopcredrefextcontrat double precision NOT NULL DEFAULT 0,
  si201_vldeficit double precision NOT NULL DEFAULT 0,
  si201_vltotalquadroreceita double precision DEFAULT 0,
  si201_ano integer NOT NULL DEFAULT 0,
  si201_periodo integer NOT NULL DEFAULT 0,
  si201_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bodcasp102017_sequ_pk PRIMARY KEY (si201_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bodcasp102017
  OWNER to dbportal;


CREATE TABLE public.bodcasp202017
(
  si202_sequencial integer NOT NULL DEFAULT 0,
  si202_tiporegistro integer NOT NULL DEFAULT 0,
  si202_faserecorcamentaria integer NOT NULL DEFAULT 0,
  si202_vlsaldoexeantsupfin double precision NOT NULL DEFAULT 0,
  si202_vlsaldoexeantrecredad double precision NOT NULL DEFAULT 0,
  si202_vltotalsaldoexeant double precision DEFAULT 0,
  si202_anousu integer NOT NULL DEFAULT 0,
  si202_periodo integer NOT NULL DEFAULT 0,
  si202_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT bodcasp202017_sequ_pk PRIMARY KEY (si202_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bodcasp202017
  OWNER to dbportal;

-- Table: public.bodcasp302017

CREATE TABLE public.bodcasp302017
(
  si203_sequencial integer NOT NULL DEFAULT 0,
  si203_tiporegistro integer NOT NULL DEFAULT 0,
  si203_fasedespesaorca integer NOT NULL DEFAULT 0,
  si203_vlpessoalencarsoci double precision NOT NULL DEFAULT 0,
  si203_vljurosencardividas double precision NOT NULL DEFAULT 0,
  si203_vloutrasdespcorren double precision NOT NULL DEFAULT 0,
  si203_vlinvestimentos double precision NOT NULL DEFAULT 0,
  si203_vlinverfinanceira double precision NOT NULL DEFAULT 0,
  si203_vlamortizadivida double precision NOT NULL DEFAULT 0,
  si203_vlreservacontingen double precision NOT NULL DEFAULT 0,
  si203_vlreservarpps double precision NOT NULL DEFAULT 0,
  si203_vlamortizadiviintermob double precision NOT NULL DEFAULT 0,
  si203_vlamortizaoutrasdivinter double precision NOT NULL DEFAULT 0,
  si203_vlamortizadivextmob double precision NOT NULL DEFAULT 0,
  si203_vlamortizaoutrasdivext double precision NOT NULL DEFAULT 0,
  si203_vlsuperavit double precision NOT NULL DEFAULT 0,
  si203_vltotalquadrodespesa double precision DEFAULT 0,
  si203_anousu integer NOT NULL DEFAULT 0,
  si203_periodo integer NOT NULL DEFAULT 0,
  si203_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT bodcasp302017_sequ_pk PRIMARY KEY (si203_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bodcasp302017
  OWNER to dbportal;

-- Table: public.bodcasp402017

CREATE TABLE public.bodcasp402017
(
  si204_sequencial integer NOT NULL DEFAULT 0,
  si204_tiporegistro integer NOT NULL DEFAULT 0,
  si204_faserestospagarnaoproc integer NOT NULL DEFAULT 0,
  si204_vlrspnaoprocpessoalencarsociais double precision NOT NULL DEFAULT 0,
  si204_vlrspnaoprocjurosencardividas double precision NOT NULL DEFAULT 0,
  si204_vlrspnaoprocoutrasdespcorrentes double precision NOT NULL DEFAULT 0,
  si204_vlrspnaoprocinvestimentos double precision NOT NULL DEFAULT 0,
  si204_vlrspnaoprocinverfinanceira double precision NOT NULL DEFAULT 0,
  si204_vlrspnaoprocamortizadivida double precision NOT NULL DEFAULT 0,
  si204_vltotalexecurspnaoprocessado double precision DEFAULT 0,
  si204_ano integer NOT NULL DEFAULT 0,
  si204_periodo integer NOT NULL DEFAULT 0,
  si204_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bodcasp402017_sequ_pk PRIMARY KEY (si204_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bodcasp402017
  OWNER to dbportal;


-- Table: public.bodcasp502017

CREATE TABLE public.bodcasp502017
(
  si205_sequencial integer NOT NULL DEFAULT 0,
  si205_tiporegistro integer NOT NULL DEFAULT 0,
  si205_faserestospagarprocnaoliqui integer NOT NULL DEFAULT 0,
  si205_vlrspprocliqpessoalencarsoc double precision NOT NULL DEFAULT 0,
  si205_vlrspprocliqjurosencardiv double precision NOT NULL DEFAULT 0,
  si205_vlrspprocliqoutrasdespcorrentes double precision NOT NULL DEFAULT 0,
  si205_vlrspprocesliqinv double precision NOT NULL DEFAULT 0,
  si205_vlrspprocliqinverfinan double precision NOT NULL DEFAULT 0,
  si205_vlrspprocliqamortizadivida double precision NOT NULL DEFAULT 0,
  si205_vltotalexecrspprocnaoproceli double precision DEFAULT 0,
  si205_ano integer NOT NULL DEFAULT 0,
  si205_periodo integer NOT NULL DEFAULT 0,
  si205_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bodcasp502017_sequ_pk PRIMARY KEY (si205_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bodcasp502017
  OWNER to dbportal;

-- Table: public.bpdcasp102017

CREATE TABLE public.bpdcasp102017
(
  si208_sequencial integer NOT NULL DEFAULT 0,
  si208_tiporegistro integer NOT NULL DEFAULT 0,
  si208_exercicio integer NOT NULL DEFAULT 0,
  si208_vlativocircucaixaequicaixa double precision NOT NULL DEFAULT 0,
  si208_vlativocircucredicurtoprazo double precision NOT NULL DEFAULT 0,
  si208_vlativocircuinvestapliccurtoprazo double precision NOT NULL DEFAULT 0,
  si208_vlativocircuestoques double precision NOT NULL DEFAULT 0,
  si208_vlativocircuvpdantecipada double precision NOT NULL DEFAULT 0,
  si208_vlativonaocircucredilongoprazo double precision NOT NULL DEFAULT 0,
  si208_vlativonaocircuinvestemplongpraz double precision NOT NULL DEFAULT 0,
  si208_vlativonaocircuestoques double precision NOT NULL DEFAULT 0,
  si208_vlativonaocircuvpdantecipada double precision NOT NULL DEFAULT 0,
  si208_vlativonaocircuinvestimentos double precision NOT NULL DEFAULT 0,
  si208_vlativonaocircuimobilizado double precision NOT NULL DEFAULT 0,
  si208_vlativonaocircuintagivel double precision NOT NULL DEFAULT 0,
  si208_vltotalativo double precision DEFAULT 0,
  si208_ano integer NOT NULL DEFAULT 0,
  si208_periodo integer NOT NULL DEFAULT 0,
  si208_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp102017_sequ_pk PRIMARY KEY (si208_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp102017
  OWNER to dbportal;

-- Table: public.bpdcasp202017

CREATE TABLE public.bpdcasp202017
(
  si209_sequencial integer NOT NULL DEFAULT 0,
  si209_tiporegistro integer NOT NULL DEFAULT 0,
  si209_exercicio integer NOT NULL DEFAULT 0,
  si209_vlpassivcircultrabprevicurtoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassivcirculemprefinancurtoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassivocirculafornecedcurtoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassicircuobrigfiscacurtoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassivocirculaobrigacoutrosentes double precision NOT NULL DEFAULT 0,
  si209_vlpassivocirculaprovisoecurtoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassicircudemaiobrigcurtoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassinaocircutrabprevilongoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassnaocircemprfinalongpraz double precision NOT NULL DEFAULT 0,
  si209_vlpassivnaocirculforneclongoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassnaocircobrifisclongpraz double precision NOT NULL DEFAULT 0,
  si209_vlpassivnaocirculprovislongoprazo double precision NOT NULL DEFAULT 0,
  si209_vlpassnaocircdemaobrilongpraz double precision NOT NULL DEFAULT 0,
  si209_vlpassivonaocircularesuldiferido double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidocapitalsocial double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidoadianfuturocapital double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidoreservacapital double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidoajustavaliacao double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidoreservalucros double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidodemaisreservas double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidoresultexercicio double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidresultacumexeranteri double precision NOT NULL DEFAULT 0,
  si209_vlpatriliquidoacoescotas double precision NOT NULL DEFAULT 0,
  si209_vltotalpassivo double precision DEFAULT 0,
  si209_ano integer NOT NULL DEFAULT 0,
  si209_periodo integer NOT NULL DEFAULT 0,
  si209_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp202017_sequ_pk PRIMARY KEY (si209_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp202017
  OWNER to dbportal;

-- Table: public.bpdcasp302017

CREATE TABLE public.bpdcasp302017
(
  si210_sequencial integer NOT NULL DEFAULT 0,
  si210_tiporegistro integer NOT NULL DEFAULT 0,
  si210_exercicio integer NOT NULL DEFAULT 0,
  si210_vlativofinanceiro double precision NOT NULL DEFAULT 0,
  si210_vlativopermanente double precision NOT NULL DEFAULT 0,
  si210_vltotalativofinanceiropermanente double precision DEFAULT 0,
  si210_ano integer NOT NULL DEFAULT 0,
  si210_periodo integer NOT NULL DEFAULT 0,
  si210_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp302017_sequ_pk PRIMARY KEY (si210_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp302017
  OWNER to dbportal;

-- Table: public.bpdcasp402017

CREATE TABLE public.bpdcasp402017
(
  si211_sequencial integer NOT NULL DEFAULT 0,
  si211_tiporegistro integer NOT NULL DEFAULT 0,
  si211_exercicio integer NOT NULL DEFAULT 0,
  si211_vlpassivofinanceiro double precision NOT NULL DEFAULT 0,
  si211_vlpassivopermanente double precision NOT NULL DEFAULT 0,
  si211_vltotalpassivofinanceiropermanente double precision DEFAULT 0,
  si211_ano integer NOT NULL DEFAULT 0,
  si211_periodo integer NOT NULL DEFAULT 0,
  si211_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp402017_sequ_pk PRIMARY KEY (si211_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp402017
  OWNER to dbportal;

-- Table: public.bpdcasp502017

CREATE TABLE public.bpdcasp502017
(
  si212_sequencial integer NOT NULL DEFAULT 0,
  si212_tiporegistro integer NOT NULL DEFAULT 0,
  si212_exercicio integer NOT NULL DEFAULT 0,
  si212_vlsaldopatrimonial double precision DEFAULT 0,
  si212_ano integer NOT NULL DEFAULT 0,
  si212_periodo integer NOT NULL DEFAULT 0,
  si212_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp502017_sequ_pk PRIMARY KEY (si212_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp502017
  OWNER to dbportal;

-- Table: public.bpdcasp602017


CREATE TABLE public.bpdcasp602017
(
  si213_sequencial integer NOT NULL DEFAULT 0,
  si213_tiporegistro integer NOT NULL DEFAULT 0,
  si213_exercicio integer NOT NULL DEFAULT 0,
  si213_vlatospotenativosgarancontrarecebi double precision NOT NULL DEFAULT 0,
  si213_vlatospotenativodirconveoutroinstr double precision NOT NULL DEFAULT 0,
  si213_vlatospotenativosdireitoscontratua double precision NOT NULL DEFAULT 0,
  si213_vlatospotenativosoutrosatos double precision NOT NULL DEFAULT 0,
  si213_vlatospotenpassivgarancontraconced double precision NOT NULL DEFAULT 0,
  si213_vlatospotepassobriconvoutrinst double precision NOT NULL DEFAULT 0,
  si213_vlatospotenpassivoobrigacocontratu double precision NOT NULL DEFAULT 0,
  si213_vlatospotenpassivooutrosatos double precision DEFAULT 0,
  si213_ano integer NOT NULL DEFAULT 0,
  si213_periodo integer NOT NULL DEFAULT 0,
  si213_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp602017_sequ_pk PRIMARY KEY (si213_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp602017
  OWNER to dbportal;

-- Table: public.bpdcasp702017


CREATE TABLE public.bpdcasp702017
(
  si214_sequencial integer NOT NULL DEFAULT 0,
  si214_tiporegistro integer NOT NULL DEFAULT 0,
  si214_exercicio integer NOT NULL DEFAULT 0,
  si214_vltotalsupdef double precision DEFAULT 0,
  si214_ano integer NOT NULL DEFAULT 0,
  si214_periodo integer NOT NULL DEFAULT 0,
  si214_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp702017_sequ_pk PRIMARY KEY (si214_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp702017
  OWNER to dbportal;

-- Table: public.bpdcasp712017

CREATE TABLE public.bpdcasp712017
(
  si215_sequencial integer NOT NULL DEFAULT 0,
  si215_tiporegistro integer NOT NULL DEFAULT 0,
  si215_exercicio integer NOT NULL DEFAULT 0,
  si215_codfontrecursos integer NOT NULL DEFAULT 0,
  si215_vlsaldofonte double precision DEFAULT 0,
  si215_ano integer NOT NULL DEFAULT 0,
  si215_periodo integer NOT NULL DEFAULT 0,
  si215_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT bpdcasp712017_sequ_pk PRIMARY KEY (si215_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.bpdcasp712017
  OWNER to dbportal;

-- Table: public.dfcdcasp102017

CREATE TABLE public.dfcdcasp102017
(
  si219_sequencial integer NOT NULL DEFAULT 0,
  si219_tiporegistro integer NOT NULL DEFAULT 0,
  si219_exercicio integer NOT NULL DEFAULT 0,
  si219_vlreceitaderivadaoriginaria double precision NOT NULL DEFAULT 0,
  si219_vltranscorrenterecebida double precision NOT NULL DEFAULT 0,
  si219_vloutrosingressosoperacionais double precision NOT NULL DEFAULT 0,
  si219_vltotalingressosativoperacionais double precision DEFAULT 0,
  si219_anousu integer NOT NULL DEFAULT 0,
  si219_periodo integer NOT NULL DEFAULT 0,
  si219_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp102017_sequ_pk PRIMARY KEY (si219_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp102017
  OWNER to dbportal;

-- Table: public.dfcdcasp202017

CREATE TABLE public.dfcdcasp202017
(
  si220_sequencial integer NOT NULL DEFAULT 0,
  si220_tiporegistro integer NOT NULL DEFAULT 0,
  si220_exercicio integer NOT NULL DEFAULT 0,
  si220_vldesembolsopessoaldespesas double precision NOT NULL DEFAULT 0,
  si220_vldesembolsojurosencargdivida double precision NOT NULL DEFAULT 0,
  si220_vldesembolsotransfconcedidas double precision NOT NULL DEFAULT 0,
  si220_vloutrosdesembolsos double precision NOT NULL DEFAULT 0,
  si220_vltotaldesembolsosativoperacionais double precision DEFAULT 0,
  si220_anousu integer NOT NULL DEFAULT 0,
  si220_periodo integer NOT NULL DEFAULT 0,
  si220_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp202017_sequ_pk PRIMARY KEY (si220_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp202017
  OWNER to dbportal;

-- Table: public.dfcdcasp302017

CREATE TABLE public.dfcdcasp302017
(
  si221_sequencial integer NOT NULL DEFAULT 0,
  si221_tiporegistro integer NOT NULL DEFAULT 0,
  si221_exercicio integer NOT NULL DEFAULT 0,
  si221_vlfluxocaixaliquidooperacional double precision DEFAULT 0,
  si221_anousu integer NOT NULL DEFAULT 0,
  si221_periodo integer NOT NULL DEFAULT 0,
  si221_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp302017_sequ_pk PRIMARY KEY (si221_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp302017
  OWNER to dbportal;

-- Table: public.dfcdcasp402017

CREATE TABLE public.dfcdcasp402017
(
  si222_sequencial integer NOT NULL DEFAULT 0,
  si222_tiporegistro integer NOT NULL DEFAULT 0,
  si222_exercicio integer NOT NULL DEFAULT 0,
  si222_vlalienacaobens double precision NOT NULL DEFAULT 0,
  si222_vlamortizacaoemprestimoconcedido double precision NOT NULL DEFAULT 0,
  si222_vloutrosingressos double precision NOT NULL DEFAULT 0,
  si222_vltotalingressosatividainvestiment double precision DEFAULT 0,
  si222_anousu integer NOT NULL DEFAULT 0,
  si222_periodo integer NOT NULL DEFAULT 0,
  si222_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp402017_sequ_pk PRIMARY KEY (si222_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp402017
  OWNER to dbportal;

-- Table: public.dfcdcasp502017

CREATE TABLE public.dfcdcasp502017
(
  si223_sequencial integer NOT NULL DEFAULT 0,
  si223_tiporegistro integer NOT NULL DEFAULT 0,
  si223_exercicio integer NOT NULL DEFAULT 0,
  si223_vlaquisicaoativonaocirculante double precision NOT NULL DEFAULT 0,
  si223_vlconcessaoempresfinanciamento double precision NOT NULL DEFAULT 0,
  si223_vloutrosdesembolsos double precision NOT NULL DEFAULT 0,
  si223_vltotaldesembolsoatividainvestimen double precision DEFAULT 0,
  si223_anousu integer NOT NULL DEFAULT 0,
  si223_periodo integer NOT NULL DEFAULT 0,
  si223_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp502017_sequ_pk PRIMARY KEY (si223_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp502017
  OWNER to dbportal;

-- Table: public.dfcdcasp602017

CREATE TABLE public.dfcdcasp602017
(
  si224_sequencial integer NOT NULL DEFAULT 0,
  si224_tiporegistro integer NOT NULL DEFAULT 0,
  si224_exercicio integer NOT NULL DEFAULT 0,
  si224_vlfluxocaixaliquidoinvestimento double precision DEFAULT 0,
  si224_anousu integer NOT NULL DEFAULT 0,
  si224_periodo integer NOT NULL DEFAULT 0,
  si224_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp602017_sequ_pk PRIMARY KEY (si224_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp602017
  OWNER to dbportal;

-- Table: public.dfcdcasp702017

CREATE TABLE public.dfcdcasp702017
(
  si225_sequencial integer NOT NULL DEFAULT 0,
  si225_tiporegistro integer NOT NULL DEFAULT 0,
  si225_exercicio integer NOT NULL DEFAULT 0,
  si225_vloperacoescredito double precision NOT NULL DEFAULT 0,
  si225_vlintegralizacaodependentes double precision NOT NULL DEFAULT 0,
  si225_vltranscapitalrecebida double precision NOT NULL DEFAULT 0,
  si225_vloutrosingressosfinanciamento double precision NOT NULL DEFAULT 0,
  si225_vltotalingressoatividafinanciament double precision DEFAULT 0,
  si225_anousu integer NOT NULL DEFAULT 0,
  si225_periodo integer NOT NULL DEFAULT 0,
  si225_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp702017_sequ_pk PRIMARY KEY (si225_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp702017
  OWNER to dbportal;

-- Table: public.dfcdcasp802017

CREATE TABLE public.dfcdcasp802017
(
  si226_sequencial integer NOT NULL DEFAULT 0,
  si226_tiporegistro integer NOT NULL DEFAULT 0,
  si226_exercicio integer NOT NULL DEFAULT 0,
  si226_vlamortizacaorefinanciamento double precision NOT NULL DEFAULT 0,
  si226_vloutrosdesembolsosfinanciamento double precision NOT NULL DEFAULT 0,
  si226_vltotaldesembolsoatividafinanciame double precision DEFAULT 0,
  si226_anousu integer NOT NULL DEFAULT 0,
  si226_periodo integer NOT NULL DEFAULT 0,
  si226_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp802017_sequ_pk PRIMARY KEY (si226_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp802017
  OWNER to dbportal;

-- Table: public.dfcdcasp902017

CREATE TABLE public.dfcdcasp902017
(
  si227_sequencial integer NOT NULL DEFAULT 0,
  si227_tiporegistro integer NOT NULL DEFAULT 0,
  si227_exercicio integer NOT NULL DEFAULT 0,
  si227_vlfluxocaixafinanciamento double precision DEFAULT 0,
  si227_anousu integer NOT NULL DEFAULT 0,
  si227_periodo integer NOT NULL DEFAULT 0,
  si227_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp902017_sequ_pk PRIMARY KEY (si227_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp902017
  OWNER to dbportal;

-- Table: public.dfcdcasp1002017

CREATE TABLE public.dfcdcasp1002017
(
  si228_sequencial integer NOT NULL DEFAULT 0,
  si228_tiporegistro integer NOT NULL DEFAULT 0,
  si228_exercicio integer NOT NULL DEFAULT 0,
  si228_vlgeracaoliquidaequivalentecaixa double precision DEFAULT 0,
  si228_anousu integer NOT NULL DEFAULT 0,
  si228_periodo integer NOT NULL DEFAULT 0,
  si228_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp1002017_sequ_pk PRIMARY KEY (si228_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp1002017
  OWNER to dbportal;


-- Table: public.dfcdcasp1102017

CREATE TABLE public.dfcdcasp1102017
(
  si229_sequencial integer NOT NULL DEFAULT 0,
  si229_tiporegistro integer NOT NULL DEFAULT 0,
  si229_exercicio integer NOT NULL DEFAULT 0,
  si229_vlcaixaequivalentecaixainicial double precision NOT NULL DEFAULT 0,
  si229_vlcaixaequivalentecaixafinal double precision DEFAULT 0,
  si229_anousu integer NOT NULL DEFAULT 0,
  si229_periodo integer NOT NULL DEFAULT 0,
  si229_instit integer NOT NULL DEFAULT 0,
  CONSTRAINT dfcdcasp1102017_sequ_pk PRIMARY KEY (si229_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dfcdcasp1102017
  OWNER to dbportal;

-- Table: public.dvpdcasp102017

CREATE TABLE public.dvpdcasp102017
(
  si216_sequencial integer NOT NULL DEFAULT 0,
  si216_tiporegistro integer NOT NULL DEFAULT 0,
  si216_exercicio integer NOT NULL DEFAULT 0,
  si216_vlimpostos double precision NOT NULL DEFAULT 0,
  si216_vlcontribuicoes double precision NOT NULL DEFAULT 0,
  si216_vlexploracovendasdireitos double precision NOT NULL DEFAULT 0,
  si216_vlvariacoesaumentativasfinanceiras double precision NOT NULL DEFAULT 0,
  si216_vltransfdelegacoesrecebidas double precision NOT NULL DEFAULT 0,
  si216_vlvalorizacaoativodesincorpassivo double precision NOT NULL DEFAULT 0,
  si216_vloutrasvariacoespatriaumentativas double precision NOT NULL DEFAULT 0,
  si216_vltotalvpaumentativas double precision DEFAULT 0,
  si216_ano integer NOT NULL DEFAULT 0,
  si216_periodo integer NOT NULL DEFAULT 0,
  si216_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT dvpdcasp102017_sequ_pk PRIMARY KEY (si216_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dvpdcasp102017
  OWNER to dbportal;

-- Table: public.dvpdcasp202017


CREATE TABLE public.dvpdcasp202017
(
  si217_sequencial integer NOT NULL DEFAULT 0,
  si217_tiporegistro integer NOT NULL DEFAULT 0,
  si217_exercicio integer NOT NULL DEFAULT 0,
  si217_vldiminutivapessoaencargos double precision NOT NULL DEFAULT 0,
  si217_vlprevassistenciais double precision NOT NULL DEFAULT 0,
  si217_vlservicoscapitalfixo double precision NOT NULL DEFAULT 0,
  si217_vldiminutivavariacoesfinanceiras double precision NOT NULL DEFAULT 0,
  si217_vltransfconcedidas double precision NOT NULL DEFAULT 0,
  si217_vldesvaloativoincorpopassivo double precision NOT NULL DEFAULT 0,
  si217_vltributarias double precision NOT NULL DEFAULT 0,
  si217_vlmercadoriavendidoservicos double precision NOT NULL DEFAULT 0,
  si217_vloutrasvariacoespatridiminutivas double precision NOT NULL DEFAULT 0,
  si217_vltotalvpdiminutivas double precision DEFAULT 0,
  si217_ano integer NOT NULL DEFAULT 0,
  si217_periodo integer NOT NULL DEFAULT 0,
  si217_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT dvpdcasp202017_sequ_pk PRIMARY KEY (si217_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dvpdcasp202017
  OWNER to dbportal;

-- Table: public.dvpdcasp302017

CREATE TABLE public.dvpdcasp302017
(
  si218_sequencial integer NOT NULL DEFAULT 0,
  si218_tiporegistro integer NOT NULL DEFAULT 0,
  si218_exercicio integer NOT NULL DEFAULT 0,
  si218_vlresultadopatrimonialperiodo double precision DEFAULT 0,
  si218_ano integer NOT NULL DEFAULT 0,
  si218_periodo integer NOT NULL DEFAULT 0,
  si218_institu integer NOT NULL DEFAULT 0,
  CONSTRAINT dvpdcasp302017_sequ_pk PRIMARY KEY (si218_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.dvpdcasp302017
  OWNER to dbportal;

-- Table: public.rpsd102017

CREATE TABLE public.rpsd102017
(
  si189_sequencial bigint NOT NULL DEFAULT 0,
  si189_tiporegistro bigint NOT NULL DEFAULT 0,
  si189_codreduzidorsp bigint NOT NULL DEFAULT 0,
  si189_codorgao character varying(2) COLLATE pg_catalog."default" NOT NULL,
  si189_codunidadesub character varying(8) COLLATE pg_catalog."default" NOT NULL,
  si189_codunidadesuborig character varying(8) COLLATE pg_catalog."default" NOT NULL,
  si189_nroempenho bigint NOT NULL DEFAULT 0,
  si189_exercicioempenho bigint NOT NULL DEFAULT 0,
  si189_dtempenho date NOT NULL,
  si189_tipopagamentorsp bigint NOT NULL DEFAULT 0,
  si189_vlpagorsp double precision NOT NULL DEFAULT 0,
  si189_mes bigint NOT NULL DEFAULT 0,
  si189_instit bigint DEFAULT 0,
  CONSTRAINT rpsd102017_sequ_pk PRIMARY KEY (si189_sequencial)
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.rpsd102017
  OWNER to dbportal;

-- Table: public.rpsd112017

CREATE TABLE public.rpsd112017
(
  si190_sequencial bigint NOT NULL DEFAULT 0,
  si190_tiporegistro bigint NOT NULL DEFAULT 0,
  si190_codreduzidorsp bigint NOT NULL DEFAULT 0,
  si190_codfontrecursos bigint NOT NULL DEFAULT 0,
  si190_vlpagofontersp double precision NOT NULL DEFAULT 0,
  si190_reg10 bigint NOT NULL DEFAULT 0,
  si190_mes bigint NOT NULL DEFAULT 0,
  si190_instit bigint DEFAULT 0,
  CONSTRAINT rpsd112017_sequ_pk PRIMARY KEY (si190_sequencial),
  CONSTRAINT rpsd112017_reg10_fk FOREIGN KEY (si190_reg10)
  REFERENCES public.rpsd102017 (si189_sequencial) MATCH SIMPLE
  ON UPDATE NO ACTION
  ON DELETE NO ACTION
)
WITH (
OIDS = TRUE
)
TABLESPACE pg_default;

ALTER TABLE public.rpsd112017
  OWNER to dbportal;
commit;