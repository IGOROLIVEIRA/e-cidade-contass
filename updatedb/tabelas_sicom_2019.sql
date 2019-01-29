 BEGIN;
  SELECT fc_startsession();
  --
  -- PostgreSQL database dump
  --

  --
  -- Name: public; Type: SCHEMA; Schema: -; Owner: dbportal
  --

  -- CREATE SCHEMA public;


  -- ALTER SCHEMA public OWNER TO dbportal;

  -- SET search_path = public, pg_catalog;

  -- SET default_tablespace = '';

  -- SET default_with_oids = true;

  --
  -- Name: aberlic102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aberlic102019 (
      si46_sequencial bigint DEFAULT 0 NOT NULL,
      si46_tiporegistro bigint DEFAULT 0 NOT NULL,
      si46_codorgaoresp character varying(2) NOT NULL,
      si46_codunidadesubresp character varying(8) NOT NULL,
      si46_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si46_nroprocessolicitatorio character varying(12) NOT NULL,
      si46_codmodalidadelicitacao bigint DEFAULT 0 NOT NULL,
      si46_nromodalidade bigint DEFAULT 0 NOT NULL,
      si46_naturezaprocedimento bigint DEFAULT 0 NOT NULL,
      si46_dtabertura date NOT NULL,
      si46_dteditalconvite date NOT NULL,
      si46_dtpublicacaoeditaldo date,
      si46_dtpublicacaoeditalveiculo1 date,
      si46_veiculo1publicacao character varying(50),
      si46_dtpublicacaoeditalveiculo2 date,
      si46_veiculo2publicacao character varying(50),
      si46_dtrecebimentodoc date NOT NULL,
      si46_tipolicitacao bigint,
      si46_naturezaobjeto bigint,
      si46_objeto character varying(500) NOT NULL,
      si46_regimeexecucaoobras bigint DEFAULT 0,
      si46_nroconvidado bigint DEFAULT 0,
      si46_clausulaprorrogacao character varying(250),
      si46_unidademedidaprazoexecucao bigint DEFAULT 0 NOT NULL,
      si46_prazoexecucao bigint DEFAULT 0 NOT NULL,
      si46_formapagamento character varying(80) NOT NULL,
      si46_criterioaceitabilidade character varying(80),
      si46_criterioadjudicacao bigint DEFAULT 0 NOT NULL,
      si46_processoporlote bigint DEFAULT 0 NOT NULL,
      si46_criteriodesempate bigint DEFAULT 0 NOT NULL,
      si46_destinacaoexclusiva bigint DEFAULT 0 NOT NULL,
      si46_subcontratacao bigint DEFAULT 0 NOT NULL,
      si46_limitecontratacao bigint DEFAULT 0 NOT NULL,
      si46_mes bigint DEFAULT 0 NOT NULL,
      si46_instit bigint DEFAULT 0
  );


  ALTER TABLE aberlic102019 OWNER TO dbportal;

  --
  -- Name: aberlic102019_si46_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aberlic102019_si46_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aberlic102019_si46_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aberlic112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aberlic112019 (
      si47_sequencial bigint DEFAULT 0 NOT NULL,
      si47_tiporegistro bigint DEFAULT 0 NOT NULL,
      si47_codorgaoresp character varying(2) NOT NULL,
      si47_codunidadesubresp character varying(8) NOT NULL,
      si47_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si47_nroprocessolicitatorio character varying(12) NOT NULL,
      si47_nrolote bigint DEFAULT 0 NOT NULL,
      si47_dsclote character varying(250) NOT NULL,
      si47_reg10 bigint DEFAULT 0 NOT NULL,
      si47_mes bigint DEFAULT 0 NOT NULL,
      si47_instit bigint DEFAULT 0
  );

  ALTER TABLE aberlic112019 OWNER TO dbportal;

  --
  -- Name: aberlic112019_si47_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aberlic112019_si47_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aberlic112019_si47_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aberlic122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aberlic122019 (
      si48_sequencial bigint DEFAULT 0 NOT NULL,
      si48_tiporegistro bigint DEFAULT 0 NOT NULL,
      si48_codorgaoresp character varying(2) NOT NULL,
      si48_codunidadesubresp character varying(8) NOT NULL,
      si48_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si48_nroprocessolicitatorio character varying(12) NOT NULL,
      si48_coditem bigint DEFAULT 0 NOT NULL,
      si48_nroitem bigint DEFAULT 0 NOT NULL,
      si48_reg10 bigint DEFAULT 0 NOT NULL,
      si48_mes bigint DEFAULT 0 NOT NULL,
      si48_instit bigint DEFAULT 0
  );


  ALTER TABLE aberlic122019 OWNER TO dbportal;

  --
  -- Name: aberlic122019_si48_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aberlic122019_si48_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aberlic122019_si48_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aberlic132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aberlic132019 (
      si49_sequencial bigint DEFAULT 0 NOT NULL,
      si49_tiporegistro bigint DEFAULT 0 NOT NULL,
      si49_codorgaoresp character varying(2) NOT NULL,
      si49_codunidadesubresp character varying(8) NOT NULL,
      si49_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si49_nroprocessolicitatorio character varying(12) NOT NULL,
      si49_nrolote bigint DEFAULT 0 NOT NULL,
      si49_coditem bigint DEFAULT 0 NOT NULL,
      si49_mes bigint DEFAULT 0 NOT NULL,
      si49_reg10 bigint DEFAULT 0 NOT NULL,
      si49_instit bigint DEFAULT 0
  );


  ALTER TABLE aberlic132019 OWNER TO dbportal;

  --
  -- Name: aberlic132019_si49_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aberlic132019_si49_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aberlic132019_si49_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aberlic142019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aberlic142019 (
      si50_sequencial bigint DEFAULT 0 NOT NULL,
      si50_tiporegistro bigint DEFAULT 0 NOT NULL,
      si50_codorgaoresp character varying(2) NOT NULL,
      si50_codunidadesubresp character varying(8) NOT NULL,
      si50_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si50_nroprocessolicitatorio character varying(12) NOT NULL,
      si50_nrolote bigint DEFAULT 0,
      si50_coditem bigint DEFAULT 0 NOT NULL,
      si50_dtcotacao date NOT NULL,
      si50_vlrefpercentual real DEFAULT 0 NOT NULL,
      si50_vlcotprecosunitario double precision DEFAULT 0 NOT NULL,
      si50_quantidade double precision DEFAULT 0 NOT NULL,
      si50_vlminalienbens double precision DEFAULT 0 NOT NULL,
      si50_mes bigint DEFAULT 0 NOT NULL,
      si50_reg10 bigint DEFAULT 0 NOT NULL,
      si50_instit bigint DEFAULT 0
  );


  ALTER TABLE aberlic142019 OWNER TO dbportal;

  --
  -- Name: aberlic142019_si50_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aberlic142019_si50_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aberlic142019_si50_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aberlic152019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aberlic152019 (
      si51_sequencial bigint DEFAULT 0 NOT NULL,
      si51_tiporegistro bigint DEFAULT 0 NOT NULL,
      si51_codorgaoresp character varying(2) NOT NULL,
      si51_codunidadesubresp character varying(8) NOT NULL,
      si51_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si51_nroprocessolicitatorio character varying(12) NOT NULL,
      si51_nrolote bigint DEFAULT 0,
      si51_coditem bigint DEFAULT 0 NOT NULL,
      si51_vlitem double precision DEFAULT 0 NOT NULL,
      si51_mes bigint DEFAULT 0 NOT NULL,
      si51_reg10 bigint DEFAULT 0 NOT NULL,
      si51_instit bigint DEFAULT 0
  );


  ALTER TABLE aberlic152019 OWNER TO dbportal;

  --
  -- Name: aberlic152019_si51_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aberlic152019_si51_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aberlic152019_si51_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aberlic162019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aberlic162019 (
      si52_sequencial bigint DEFAULT 0 NOT NULL,
      si52_tiporegistro bigint DEFAULT 0 NOT NULL,
      si52_codorgaoresp character varying(2) NOT NULL,
      si52_codunidadesubresp character varying(8) NOT NULL,
      si52_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si52_nroprocessolicitatorio character varying(12) NOT NULL,
      si52_codorgao character varying(2) NOT NULL,
      si52_codunidadesub character varying(8) NOT NULL,
      si52_codfuncao character varying(2) NOT NULL,
      si52_codsubfuncao character varying(3) NOT NULL,
      si52_codprograma character varying(4) NOT NULL,
      si52_idacao character varying(4) NOT NULL,
      si52_idsubacao character varying(4),
      si52_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si52_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si52_vlrecurso double precision DEFAULT 0 NOT NULL,
      si52_mes bigint DEFAULT 0 NOT NULL,
      si52_reg10 bigint DEFAULT 0 NOT NULL,
      si52_instit bigint DEFAULT 0
  );


  ALTER TABLE aberlic162019 OWNER TO dbportal;

  --
  -- Name: aberlic162019_si52_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aberlic162019_si52_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aberlic162019_si52_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aex102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aex102019 (
      si130_sequencial bigint DEFAULT 0 NOT NULL,
      si130_tiporegistro bigint DEFAULT 0 NOT NULL,
      si130_codext bigint DEFAULT 0 NOT NULL,
      si130_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si130_nroop bigint DEFAULT 0 NOT NULL,
      si130_codunidadesub character varying(8) NOT NULL,
      si130_dtpagamento date NOT NULL,
      si130_nroanulacaoop bigint DEFAULT 0 NOT NULL,
      si130_dtanulacaoop date NOT NULL,
      si130_vlanulacaoop double precision DEFAULT 0 NOT NULL,
      si130_mes bigint DEFAULT 0 NOT NULL,
      si130_instit bigint DEFAULT 0
  );


  ALTER TABLE aex102019 OWNER TO dbportal;

  --
  -- Name: aex102019_si130_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aex102019_si130_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aex102019_si130_sequencial_seq OWNER TO dbportal;

  --
  -- Name: alq102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE alq102019 (
      si121_sequencial bigint DEFAULT 0 NOT NULL,
      si121_tiporegistro bigint DEFAULT 0 NOT NULL,
      si121_codreduzido bigint DEFAULT 0 NOT NULL,
      si121_codorgao character varying(2) NOT NULL,
      si121_codunidadesub character varying(8) NOT NULL,
      si121_nroempenho bigint DEFAULT 0 NOT NULL,
      si121_dtempenho date NOT NULL,
      si121_dtliquidacao date NOT NULL,
      si121_nroliquidacao bigint DEFAULT 0 NOT NULL,
      si121_dtanulacaoliq date NOT NULL,
      si121_nroliquidacaoanl bigint DEFAULT 0 NOT NULL,
      si121_tpliquidacao bigint DEFAULT 0 NOT NULL,
      si121_justificativaanulacao character varying(500) NOT NULL,
      si121_vlanulado double precision DEFAULT 0 NOT NULL,
      si121_mes bigint DEFAULT 0 NOT NULL,
      si121_instit bigint DEFAULT 0
  );


  ALTER TABLE alq102019 OWNER TO dbportal;

  --
  -- Name: alq102019_si121_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE alq102019_si121_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE alq102019_si121_sequencial_seq OWNER TO dbportal;

  --
  -- Name: alq112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE alq112019 (
      si122_sequencial bigint DEFAULT 0 NOT NULL,
      si122_tiporegistro bigint DEFAULT 0 NOT NULL,
      si122_codreduzido bigint DEFAULT 0 NOT NULL,
      si122_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si122_valoranuladofonte double precision DEFAULT 0 NOT NULL,
      si122_mes bigint DEFAULT 0 NOT NULL,
      si122_reg10 bigint DEFAULT 0 NOT NULL,
      si122_instit bigint DEFAULT 0
  );


  ALTER TABLE alq112019 OWNER TO dbportal;

  --
  -- Name: alq112019_si122_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE alq112019_si122_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE alq112019_si122_sequencial_seq OWNER TO dbportal;

  --
  -- Name: alq122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE alq122019 (
      si123_sequencial bigint DEFAULT 0 NOT NULL,
      si123_tiporegistro bigint DEFAULT 0 NOT NULL,
      si123_codreduzido bigint DEFAULT 0 NOT NULL,
      si123_mescompetencia character varying(2) NOT NULL,
      si123_exerciciocompetencia bigint DEFAULT 0 NOT NULL,
      si123_vlanuladodspexerant double precision DEFAULT 0 NOT NULL,
      si123_mes bigint DEFAULT 0 NOT NULL,
      si123_reg10 bigint DEFAULT 0 NOT NULL,
      si123_instit bigint DEFAULT 0
  );


  ALTER TABLE alq122019 OWNER TO dbportal;

  --
  -- Name: alq122019_si123_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE alq122019_si123_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE alq122019_si123_sequencial_seq OWNER TO dbportal;

  --
  -- Name: anl102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE anl102019 (
      si110_sequencial bigint DEFAULT 0 NOT NULL,
      si110_tiporegistro bigint DEFAULT 0 NOT NULL,
      si110_codorgao character varying(2) NOT NULL,
      si110_codunidadesub character varying(8) NOT NULL,
      si110_nroempenho bigint DEFAULT 0 NOT NULL,
      si110_dtempenho date NOT NULL,
      si110_dtanulacao date NOT NULL,
      si110_nroanulacao bigint DEFAULT 0 NOT NULL,
      si110_tipoanulacao bigint DEFAULT 0 NOT NULL,
      si110_especanulacaoempenho character varying(200) NOT NULL,
      si110_vlanulacao double precision DEFAULT 0 NOT NULL,
      si110_mes bigint DEFAULT 0 NOT NULL,
      si110_instit bigint DEFAULT 0
  );


  ALTER TABLE anl102019 OWNER TO dbportal;

  --
  -- Name: anl102019_si110_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE anl102019_si110_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE anl102019_si110_sequencial_seq OWNER TO dbportal;

  --
  -- Name: anl112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE anl112019 (
      si111_sequencial bigint DEFAULT 0 NOT NULL,
      si111_tiporegistro bigint DEFAULT 0 NOT NULL,
      si111_codunidadesub character varying(8) NOT NULL,
      si111_nroempenho bigint DEFAULT 0 NOT NULL,
      si111_nroanulacao bigint DEFAULT 0 NOT NULL,
      si111_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si111_vlanulacaofonte double precision DEFAULT 0 NOT NULL,
      si111_mes bigint DEFAULT 0 NOT NULL,
      si111_reg10 bigint DEFAULT 0 NOT NULL,
      si111_instit bigint DEFAULT 0
  );


  ALTER TABLE anl112019 OWNER TO dbportal;

  --
  -- Name: anl112019_si111_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE anl112019_si111_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE anl112019_si111_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aob102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aob102019 (
      si141_sequencial bigint DEFAULT 0 NOT NULL,
      si141_tiporegistro bigint DEFAULT 0 NOT NULL,
      si141_codreduzido bigint DEFAULT 0 NOT NULL,
      si141_codorgao character varying(2) NOT NULL,
      si141_codunidadesub character varying(8) NOT NULL,
      si141_nrolancamento bigint DEFAULT 0 NOT NULL,
      si141_dtlancamento date NOT NULL,
      si141_tipolancamento bigint DEFAULT 0 NOT NULL,
      si141_nroanulacaolancamento bigint DEFAULT 0 NOT NULL,
      si141_dtanulacaolancamento date NOT NULL,
      si141_nroempenho bigint DEFAULT 0 NOT NULL,
      si141_dtempenho date NOT NULL,
      si141_nroliquidacao bigint DEFAULT 0,
      si141_dtliquidacao date,
      si141_valoranulacaolancamento double precision DEFAULT 0 NOT NULL,
      si141_mes bigint DEFAULT 0 NOT NULL,
      si141_instit bigint DEFAULT 0
  );


  ALTER TABLE aob102019 OWNER TO dbportal;

  --
  -- Name: aob102019_si141_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aob102019_si141_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aob102019_si141_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aob112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aob112019 (
      si142_sequencial bigint DEFAULT 0 NOT NULL,
      si142_tiporegistro bigint DEFAULT 0 NOT NULL,
      si142_codreduzido bigint DEFAULT 0 NOT NULL,
      si142_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si142_valoranulacaofonte double precision DEFAULT 0 NOT NULL,
      si142_mes bigint DEFAULT 0 NOT NULL,
      si142_reg10 bigint DEFAULT 0 NOT NULL,
      si142_instit bigint DEFAULT 0
  );


  ALTER TABLE aob112019 OWNER TO dbportal;

  --
  -- Name: aob112019_si142_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aob112019_si142_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aob112019_si142_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aoc102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aoc102019 (
      si38_sequencial bigint DEFAULT 0 NOT NULL,
      si38_tiporegistro bigint DEFAULT 0 NOT NULL,
      si38_codorgao character varying(2) NOT NULL,
      si38_nrodecreto bigint DEFAULT 0 NOT NULL,
      si38_datadecreto date NOT NULL,
      si38_mes bigint DEFAULT 0 NOT NULL,
      si38_instit bigint DEFAULT 0
  );


  ALTER TABLE aoc102019 OWNER TO dbportal;

  --
  -- Name: aoc102019_si38_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aoc102019_si38_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aoc102019_si38_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aoc112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aoc112019 (
      si39_sequencial bigint DEFAULT 0 NOT NULL,
      si39_tiporegistro bigint DEFAULT 0 NOT NULL,
      si39_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
      si39_nrodecreto bigint DEFAULT 0 NOT NULL,
      si39_tipodecretoalteracao bigint DEFAULT 0 NOT NULL,
      si39_valoraberto double precision DEFAULT 0 NOT NULL,
      si39_mes bigint DEFAULT 0 NOT NULL,
      si39_reg10 bigint DEFAULT 0 NOT NULL,
      si39_instit bigint DEFAULT 0
  );


  ALTER TABLE aoc112019 OWNER TO dbportal;

  --
  -- Name: aoc112019_si39_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aoc112019_si39_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aoc112019_si39_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aoc122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aoc122019 (
      si40_sequencial bigint DEFAULT 0 NOT NULL,
      si40_tiporegistro bigint DEFAULT 0 NOT NULL,
      si40_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
      si40_nroleialteracao character varying(6) NOT NULL,
      si40_dataleialteracao date NOT NULL,
      si40_tpleiorigdecreto character varying(4) NOT NULL,
      si40_tipoleialteracao bigint DEFAULT 0 NOT NULL,
      si40_valorabertolei double precision NOT NULL,
      si40_mes bigint DEFAULT 0 NOT NULL,
      si40_reg10 bigint DEFAULT 0 NOT NULL,
      si40_instit bigint DEFAULT 0

  );


  ALTER TABLE aoc122019 OWNER TO dbportal;

  --
  -- Name: aoc122019_si40_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aoc122019_si40_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aoc122019_si40_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aoc132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aoc132019 (
      si41_sequencial bigint DEFAULT 0 NOT NULL,
      si41_tiporegistro bigint DEFAULT 0 NOT NULL,
      si41_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
      si41_origemrecalteracao character varying(2) NOT NULL,
      si41_valorabertoorigem double precision DEFAULT 0 NOT NULL,
      si41_mes bigint DEFAULT 0 NOT NULL,
      si41_reg10 bigint DEFAULT 0 NOT NULL,
      si41_instit bigint DEFAULT 0
  );


  ALTER TABLE aoc132019 OWNER TO dbportal;

  --
  -- Name: aoc132019_si41_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aoc132019_si41_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aoc132019_si41_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aoc142019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aoc142019 (
      si42_sequencial bigint DEFAULT 0 NOT NULL,
      si42_tiporegistro bigint DEFAULT 0 NOT NULL,
      si42_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
      si42_origemrecalteracao character varying(2) NOT NULL,
      si42_codorigem bigint DEFAULT 0,
      si42_codorgao character varying(2) NOT NULL,
      si42_codunidadesub character varying(8) NOT NULL,
      si42_codfuncao character varying(2) NOT NULL,
      si42_codsubfuncao character varying(3) NOT NULL,
      si42_codprograma character varying(4) NOT NULL,
      si42_idacao character varying(4) NOT NULL,
      si42_idsubacao character varying(4),
      si42_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si42_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si42_vlacrescimo double precision DEFAULT 0 NOT NULL,   --Renomear campo de vlAcrescimoReducao para vlAcrescimo
      si42_mes bigint DEFAULT 0 NOT NULL,
      si42_reg10 bigint DEFAULT 0 NOT NULL,
      si42_instit bigint DEFAULT 0
  );


  ALTER TABLE aoc142019 OWNER TO dbportal;

  --
  -- Name: aoc142019_si42_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aoc142019_si42_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aoc142019_si42_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aoc152019_si193_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE TABLE aoc152019(
      si194_sequencial bigint DEFAULT 0 NOT NULL,
      si194_tiporegistro bigint DEFAULT 0 NOT NULL,
      si194_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
      si194_origemrecalteracao character varying(2) NOT NULL,
      si194_codorigem bigint DEFAULT 0 NOT NULL,
      si194_codorgao character varying(2) NOT NULL,
      si194_codunidadesub character varying(8) NOT NULL,
      si194_codfuncao character varying(2) NOT NULL,
      si194_codsubfuncao character varying(3) NOT NULL,
      si194_codprograma character varying(4) NOT NULL,
      si194_idacao character varying(4) NOT NULL,
      si194_idsubacao character varying(4) DEFAULT NULL,
      si194_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si194_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si194_vlreducao double precision DEFAULT 0 NOT NULL,
      si194_mes bigint DEFAULT 0 NOT NULL,
      si194_instit bigint DEFAULT 0 NOT NULL
  );

  CREATE SEQUENCE aoc152019_si194_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;

  ALTER TABLE aoc152019_si194_sequencial_seq OWNER TO dbportal;


  --
  -- Name: aop102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aop102019 (
      si137_sequencial bigint DEFAULT 0 NOT NULL,
      si137_tiporegistro bigint DEFAULT 0 NOT NULL,
      si137_codreduzido bigint DEFAULT 0 NOT NULL,
      si137_codorgao character varying(2) NOT NULL,
      si137_codunidadesub character varying(8) NOT NULL,
      si137_nroop bigint DEFAULT 0 NOT NULL,
      si137_dtpagamento date NOT NULL,
      si137_nroanulacaoop bigint DEFAULT 0 NOT NULL,
      si137_dtanulacaoop date NOT NULL,
      si137_justificativaanulacao character varying(500) NOT NULL,
      si137_vlanulacaoop double precision DEFAULT 0 NOT NULL,
      si137_mes bigint DEFAULT 0 NOT NULL,
      si137_instit bigint DEFAULT 0
  );


  ALTER TABLE aop102019 OWNER TO dbportal;

  --
  -- Name: aop102019_si137_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aop102019_si137_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aop102019_si137_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aop112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE aop112019 (
      si138_sequencial bigint DEFAULT 0 NOT NULL,
      si138_tiporegistro bigint DEFAULT 0 NOT NULL,
      si138_codreduzido bigint DEFAULT 0 NOT NULL,
      si138_tipopagamento bigint DEFAULT 0 NOT NULL,
      si138_nroempenho bigint DEFAULT 0 NOT NULL,
      si138_dtempenho date NOT NULL,
      si138_nroliquidacao bigint DEFAULT 0,
      si138_dtliquidacao date,
      si138_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si138_valoranulacaofonte double precision DEFAULT 0 NOT NULL,
      si138_mes bigint DEFAULT 0 NOT NULL,
      si138_reg10 bigint DEFAULT 0 NOT NULL,
      si138_instit bigint DEFAULT 0
  );


  ALTER TABLE aop112019 OWNER TO dbportal;

  --
  -- Name: aop112019_si138_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE aop112019_si138_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE aop112019_si138_sequencial_seq OWNER TO dbportal;

  --
  -- Name: arc102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE arc102019 (
      si28_sequencial bigint DEFAULT 0 NOT NULL,
      si28_tiporegistro bigint DEFAULT 0 NOT NULL,
      si28_codcorrecao bigint DEFAULT 0 NOT NULL,
      si28_codorgao character varying(2) NOT NULL,
      si28_ededucaodereceita bigint DEFAULT 0 NOT NULL,
      si28_identificadordeducaorecreduzida bigint DEFAULT 0,
      si28_naturezareceitareduzida bigint DEFAULT 0 NOT NULL,
      si28_identificadordeducaorecacrescida bigint DEFAULT 0,
      si28_naturezareceitaacrescida bigint DEFAULT 0 NOT NULL,
      si28_vlreduzidoacrescido double precision DEFAULT 0 NOT NULL,
      si28_mes bigint DEFAULT 0 NOT NULL,
      si28_instit bigint DEFAULT 0
  );


  ALTER TABLE arc102019 OWNER TO dbportal;

  --
  -- Name: arc102019_si28_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE arc102019_si28_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE arc102019_si28_sequencial_seq OWNER TO dbportal;

  --
  -- Name: arc112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE arc112019 (
      si29_sequencial bigint DEFAULT 0 NOT NULL,
      si29_tiporegistro bigint DEFAULT 0 NOT NULL,
      si29_codcorrecao bigint DEFAULT 0 NOT NULL,
      si29_codfontereduzida bigint DEFAULT 0 NOT NULL,
      si29_tipodocumento bigint DEFAULT 0,
      si29_nrodocumento character varying(14),
      si29_nroconvenio character varying(30),
      si29_dataassinatura character varying(8),
      si29_vlreduzidofonte double precision DEFAULT 0 NOT NULL,
      si29_reg10 bigint DEFAULT 0 NOT NULL,
      si29_mes bigint DEFAULT 0 NOT NULL,
      si29_instit bigint DEFAULT 0
  );


  ALTER TABLE arc112019 OWNER TO dbportal;

  --
  -- Name: arc112019_si29_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE arc112019_si29_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE arc112019_si29_sequencial_seq OWNER TO dbportal;

  --
  -- Name: arc122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE arc122019 (
      si30_sequencial bigint DEFAULT 0 NOT NULL,
      si30_tiporegistro bigint DEFAULT 0 NOT NULL,
      si30_codcorrecao bigint DEFAULT 0 NOT NULL,
      si30_codfonteacrescida bigint DEFAULT 0 NOT NULL,
      si30_tipodocumento bigint DEFAULT 0,
      si30_nrodocumento character varying(14),
      si30_nroconvenio character varying(30),
      si30_datassinatura date,
      si30_vlacrescidofonte double precision DEFAULT 0 NOT NULL,
      si30_reg10 bigint DEFAULT 0 NOT NULL,
      si30_mes bigint DEFAULT 0 NOT NULL,
      si30_instit bigint DEFAULT 0
  );


  ALTER TABLE arc122019 OWNER TO dbportal;

  --
  -- Name: arc202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE arc202019 (
      si31_sequencial bigint DEFAULT 0 NOT NULL,
      si31_tiporegistro bigint DEFAULT 0 NOT NULL,
      si31_codorgao character varying(2) NOT NULL,
      si31_codestorno bigint DEFAULT 0 NOT NULL,
      si31_ededucaodereceita bigint DEFAULT 0 NOT NULL,
      si31_identificadordeducao bigint DEFAULT 0,
      si31_naturezareceitaestornada bigint DEFAULT 0 NOT NULL,
      si31_vlestornado double precision DEFAULT 0 NOT NULL,
      si31_mes bigint DEFAULT 0 NOT NULL,
      si31_instit bigint DEFAULT 0
  );


  ALTER TABLE arc202019 OWNER TO dbportal;

  --
  -- Name: arc202019_si31_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE arc202019_si31_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE arc202019_si31_sequencial_seq OWNER TO dbportal;

  --
  -- Name: arc212019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE arc212019 (
      si32_sequencial bigint DEFAULT 0 NOT NULL,
      si32_tiporegistro bigint DEFAULT 0 NOT NULL,
      si32_codestorno bigint DEFAULT 0 NOT NULL,
      si32_codfonteestornada bigint DEFAULT 0 NOT NULL,
      si32_tipodocumento bigint DEFAULT 0,
      si32_nrodocumento character varying(14) DEFAULT NULL,
      si32_nroconvenio character varying(30) DEFAULT NULL,
      si32_dataassinatura date DEFAULT NULL,
      si32_vlestornadofonte double precision DEFAULT 0 NOT NULL,
      si32_reg20 bigint DEFAULT 0 NOT NULL,
      si32_instit bigint DEFAULT 0
  );


  ALTER TABLE arc212019 OWNER TO dbportal;

  --
  -- Name: arc212019_si32_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE arc212019_si32_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE arc212019_si32_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete102019 (
      si177_sequencial bigint DEFAULT 0 NOT NULL,
      si177_tiporegistro bigint DEFAULT 0 NOT NULL,
      si177_contacontaabil bigint DEFAULT 0 NOT NULL,
      si177_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si177_saldoinicial double precision DEFAULT 0 NOT NULL,
      si177_naturezasaldoinicial character varying(1) NOT NULL,
      si177_totaldebitos double precision DEFAULT 0 NOT NULL,
      si177_totalcreditos double precision DEFAULT 0 NOT NULL,
      si177_saldofinal double precision DEFAULT 0 NOT NULL,
      si177_naturezasaldofinal character varying(1) NOT NULL,
      si177_mes bigint DEFAULT 0 NOT NULL,
      si177_instit bigint DEFAULT 0
  );


  ALTER TABLE balancete102019 OWNER TO dbportal;

  --
  -- Name: balancete102019_si177_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete102019_si177_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete102019_si177_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete112019 (
      si178_sequencial bigint DEFAULT 0 NOT NULL,
      si178_tiporegistro bigint DEFAULT 0 NOT NULL,
      si178_contacontaabil bigint DEFAULT 0 NOT NULL,
      si178_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si178_codorgao character varying(2) NOT NULL,
      si178_codunidadesub character varying(8) NOT NULL,
      si178_codfuncao character varying(2) NOT NULL,
      si178_codsubfuncao character varying(3) NOT NULL,
      si178_codprograma character varying(4),
      si178_idacao character varying(4) NOT NULL,
      si178_idsubacao character varying(4) NOT NULL,
      si178_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si178_subelemento character varying(2) NOT NULL,
      si178_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si178_saldoinicialcd double precision DEFAULT 0 NOT NULL,
      si178_naturezasaldoinicialcd character varying(1) NOT NULL,
      si178_totaldebitoscd double precision DEFAULT 0 NOT NULL,
      si178_totalcreditoscd double precision DEFAULT 0 NOT NULL,
      si178_saldofinalcd double precision DEFAULT 0 NOT NULL,
      si178_naturezasaldofinalcd character varying(1) NOT NULL,
      si178_mes bigint DEFAULT 0 NOT NULL,
      si178_instit bigint DEFAULT 0,
      si178_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete112019 OWNER TO dbportal;

  --
  -- Name: balancete112019_si178_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete112019_si178_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete112019_si178_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete122019 (
      si179_sequencial bigint DEFAULT 0 NOT NULL,
      si179_tiporegistro bigint DEFAULT 0 NOT NULL,
      si179_contacontabil bigint DEFAULT 0 NOT NULL,
      si179_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si179_naturezareceita bigint DEFAULT 0 NOT NULL,
      si179_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si179_saldoinicialcr double precision DEFAULT 0 NOT NULL,
      si179_naturezasaldoinicialcr character varying(1) NOT NULL,
      si179_totaldebitoscr double precision DEFAULT 0 NOT NULL,
      si179_totalcreditoscr double precision DEFAULT 0 NOT NULL,
      si179_saldofinalcr double precision DEFAULT 0 NOT NULL,
      si179_naturezasaldofinalcr character varying(1) NOT NULL,
      si179_mes bigint DEFAULT 0 NOT NULL,
      si179_instit bigint DEFAULT 0,
      si179_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete122019 OWNER TO dbportal;

  --
  -- Name: balancete122019_si179_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete122019_si179_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete122019_si179_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete132019 (
      si180_sequencial bigint DEFAULT 0 NOT NULL,
      si180_tiporegistro bigint DEFAULT 0 NOT NULL,
      si180_contacontabil bigint DEFAULT 0 NOT NULL,
      si180_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si180_codprograma character varying(4) NOT NULL,
      si180_idacao character varying(4) NOT NULL,
      si180_idsubacao character varying(4),
      si180_saldoinicialpa double precision DEFAULT 0 NOT NULL,
      si180_naturezasaldoinicialpa character varying(1) NOT NULL,
      si180_totaldebitospa double precision DEFAULT 0 NOT NULL,
      si180_totalcreditospa double precision DEFAULT 0 NOT NULL,
      si180_saldofinalpa double precision DEFAULT 0 NOT NULL,
      si180_naturezasaldofinalpa character varying(1) NOT NULL,
      si180_mes bigint DEFAULT 0 NOT NULL,
      si180_instit bigint DEFAULT 0,
      si180_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete132019 OWNER TO dbportal;

  --
  -- Name: balancete132019_si180_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete132019_si180_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete132019_si180_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete142019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete142019 (
      si181_sequencial bigint DEFAULT 0 NOT NULL,
      si181_tiporegistro bigint DEFAULT 0 NOT NULL,
      si181_contacontabil bigint DEFAULT 0 NOT NULL,
      si181_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si181_codorgao character varying(2) NOT NULL,
      si181_codunidadesub character varying(8) NOT NULL,
      si181_codunidadesuborig character varying(8) NOT NULL,
      si181_codfuncao character varying(2) NOT NULL,
      si181_codsubfuncao character varying(3) NOT NULL,
      si181_codprograma character varying(4) NOT NULL,
      si181_idacao character varying(4) NOT NULL,
      si181_idsubacao character varying(4),
      si181_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si181_subelemento character varying(2) NOT NULL,
      si181_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si181_nroempenho bigint DEFAULT 0 NOT NULL,
      si181_anoinscricao bigint DEFAULT 0 NOT NULL,
      si181_saldoinicialrsp double precision DEFAULT 0 NOT NULL,
      si181_naturezasaldoinicialrsp character varying(1) NOT NULL,
      si181_totaldebitosrsp double precision DEFAULT 0 NOT NULL,
      si181_totalcreditosrsp double precision DEFAULT 0 NOT NULL,
      si181_saldofinalrsp double precision DEFAULT 0 NOT NULL,
      si181_naturezasaldofinalrsp character varying(1) NOT NULL,
      si181_mes bigint DEFAULT 0 NOT NULL,
      si181_instit bigint DEFAULT 0,
      si181_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete142019 OWNER TO dbportal;

  --
  -- Name: balancete142019_si181_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete142019_si181_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete142019_si181_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete152019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete152019 (
      si182_sequencial bigint DEFAULT 0 NOT NULL,
      si182_tiporegistro bigint DEFAULT 0 NOT NULL,
      si182_contacontabil bigint DEFAULT 0 NOT NULL,
      si182_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si182_atributosf character varying(1) NOT NULL,
      si182_saldoinicialsf double precision DEFAULT 0 NOT NULL,
      si182_naturezasaldoinicialsf character varying(1) NOT NULL,
      si182_totaldebitossf double precision DEFAULT 0 NOT NULL,
      si182_totalcreditossf double precision DEFAULT 0 NOT NULL,
      si182_saldofinalsf double precision DEFAULT 0 NOT NULL,
      si182_naturezasaldofinalsf character varying(1) NOT NULL,
      si182_mes bigint DEFAULT 0 NOT NULL,
      si182_instit bigint DEFAULT 0,
      si182_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete152019 OWNER TO dbportal;

  --
  -- Name: balancete152019_si182_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete152019_si182_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete152019_si182_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete162019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete162019 (
      si183_sequencial bigint DEFAULT 0 NOT NULL,
      si183_tiporegistro bigint DEFAULT 0 NOT NULL,
      si183_contacontabil bigint DEFAULT 0 NOT NULL,
      si183_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si183_atributosf character varying(1) NOT NULL,
      si183_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si183_saldoinicialfontsf double precision DEFAULT 0 NOT NULL,
      si183_naturezasaldoinicialfontsf character varying(1) NOT NULL,
      si183_totaldebitosfontsf double precision DEFAULT 0 NOT NULL,
      si183_totalcreditosfontsf double precision DEFAULT 0 NOT NULL,
      si183_saldofinalfontsf double precision DEFAULT 0 NOT NULL,
      si183_naturezasaldofinalfontsf character varying(1) NOT NULL,
      si183_mes bigint DEFAULT 0 NOT NULL,
      si183_instit bigint DEFAULT 0,
      si183_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete162019 OWNER TO dbportal;

  --
  -- Name: balancete162019_si183_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete162019_si183_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete162019_si183_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete172019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete172019 (
      si184_sequencial bigint DEFAULT 0 NOT NULL,
      si184_tiporegistro bigint DEFAULT 0 NOT NULL,
      si184_contacontabil bigint DEFAULT 0 NOT NULL,
      si184_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si184_atributosf character varying(1) NOT NULL,
      si184_codctb bigint DEFAULT 0 NOT NULL,
      si184_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si184_saldoinicialctb double precision DEFAULT 0 NOT NULL,
      si184_naturezasaldoinicialctb character varying(1) NOT NULL,
      si184_totaldebitosctb double precision DEFAULT 0 NOT NULL,
      si184_totalcreditosctb double precision DEFAULT 0 NOT NULL,
      si184_saldofinalctb double precision DEFAULT 0 NOT NULL,
      si184_naturezasaldofinalctb character varying(1) NOT NULL,
      si184_mes bigint DEFAULT 0 NOT NULL,
      si184_instit bigint DEFAULT 0,
      si184_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete172019 OWNER TO dbportal;

  --
  -- Name: balancete172019_si184_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete172019_si184_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete172019_si184_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete182019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete182019 (
      si185_sequencial bigint DEFAULT 0 NOT NULL,
      si185_tiporegistro bigint DEFAULT 0 NOT NULL,
      si185_contacontabil bigint DEFAULT 0 NOT NULL,
      si185_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si185_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si185_saldoinicialfr double precision DEFAULT 0 NOT NULL,
      si185_naturezasaldoinicialfr character varying(1) NOT NULL,
      si185_totaldebitosfr double precision DEFAULT 0 NOT NULL,
      si185_totalcreditosfr double precision DEFAULT 0 NOT NULL,
      si185_saldofinalfr double precision DEFAULT 0 NOT NULL,
      si185_naturezasaldofinalfr character varying(1) NOT NULL,
      si185_mes bigint DEFAULT 0 NOT NULL,
      si185_instit bigint DEFAULT 0,
      si185_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete182019 OWNER TO dbportal;

  --
  -- Name: balancete182019_si185_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete182019_si185_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete182019_si185_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete182019_si186_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete182019_si186_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete182019_si186_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete192019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete192019 (
      si186_sequencial bigint DEFAULT 0 NOT NULL,
      si186_tiporegistro bigint DEFAULT 0 NOT NULL,
      si186_contacontabil bigint DEFAULT 0 NOT NULL,
      si186_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si186_cnpjconsorcio bigint DEFAULT 0 NOT NULL,
      si186_saldoinicialconsor double precision DEFAULT 0 NOT NULL,
      si186_naturezasaldoinicialconsor character varying(1) NOT NULL,
      si186_totaldebitosconsor double precision DEFAULT 0 NOT NULL,
      si186_totalcreditosconsor double precision DEFAULT 0 NOT NULL,
      si186_saldofinalconsor double precision DEFAULT 0 NOT NULL,
      si186_naturezasaldofinalconsor character varying(1) NOT NULL,
      si186_mes bigint DEFAULT 0 NOT NULL,
      si186_instit bigint DEFAULT 0,
      si186_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete192019 OWNER TO dbportal;

  --
  -- Name: balancete192019_si186_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete192019_si186_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete192019_si186_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete202019 (
      si187_sequencial bigint DEFAULT 0 NOT NULL,
      si187_tiporegistro bigint DEFAULT 0 NOT NULL,
      si187_contacontabil bigint DEFAULT 0 NOT NULL,
      si187_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si187_cnpjconsorcio bigint DEFAULT 0 NOT NULL,
      si187_tiporecurso integer DEFAULT 0 NOT NULL,
      si187_codfuncao character varying(2) NOT NULL,
      si187_codsubfuncao character varying(3) NOT NULL,
      si187_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si187_subelemento character varying(2) NOT NULL,
      si187_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si187_saldoinicialconscf double precision DEFAULT 0 NOT NULL,
      si187_naturezasaldoinicialconscf character varying(1) NOT NULL,
      si187_totaldebitosconscf double precision DEFAULT 0 NOT NULL,
      si187_totalcreditosconscf double precision DEFAULT 0 NOT NULL,
      si187_saldofinalconscf double precision DEFAULT 0 NOT NULL,
      si187_naturezasaldofinalconscf character varying(1) NOT NULL,
      si187_mes bigint DEFAULT 0 NOT NULL,
      si187_instit bigint DEFAULT 0,
      si187_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete202019 OWNER TO dbportal;

  --
  -- Name: balancete202019_si187_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete202019_si187_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete202019_si187_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete212019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete212019 (
      si188_sequencial bigint DEFAULT 0 NOT NULL,
      si188_tiporegistro bigint DEFAULT 0 NOT NULL,
      si188_contacontabil bigint DEFAULT 0 NOT NULL,
      si188_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si188_cnpjconsorcio bigint DEFAULT 0 NOT NULL,
      si188_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si188_saldoinicialconsorfr double precision DEFAULT 0 NOT NULL,
      si188_naturezasaldoinicialconsorfr character varying(1) NOT NULL,
      si188_totaldebitosconsorfr double precision DEFAULT 0 NOT NULL,
      si188_totalcreditosconsorfr double precision DEFAULT 0 NOT NULL,
      si188_saldofinalconsorfr double precision DEFAULT 0 NOT NULL,
      si188_naturezasaldofinalconsorfr character varying(1) NOT NULL,
      si188_mes bigint DEFAULT 0 NOT NULL,
      si188_instit bigint DEFAULT 0,
      si188_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete212019 OWNER TO dbportal;

  --
  -- Name: balancete212019_si188_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete212019_si188_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete212019_si188_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete222019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete222019 (
      si189_sequencial bigint DEFAULT 0 NOT NULL,
      si189_tiporegistro bigint DEFAULT 0 NOT NULL,
      si189_contacontabil bigint DEFAULT 0 NOT NULL,
      si189_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si189_atributosf character varying(1) NOT NULL,
      si189_codctb bigint DEFAULT 0 NOT NULL,
      si189_saldoinicialctbsf double precision DEFAULT 0 NOT NULL,
      si189_naturezasaldoinicialctbsf character varying(1) NOT NULL,
      si189_totaldebitosctbsf double precision DEFAULT 0 NOT NULL,
      si189_totalcreditosctbsf double precision DEFAULT 0 NOT NULL,
      si189_saldofinalctbsf double precision DEFAULT 0 NOT NULL,
      si189_naturezasaldofinalctbsf character varying(1) NOT NULL,
      si189_mes bigint DEFAULT 0 NOT NULL,
      si189_instit bigint DEFAULT 0,
      si189_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete222019 OWNER TO dbportal;

  --
  -- Name: balancete222019_si189_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete222019_si189_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete222019_si189_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete232019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete232019 (
      si190_sequencial bigint DEFAULT 0 NOT NULL,
      si190_tiporegistro bigint DEFAULT 0 NOT NULL,
      si190_contacontabil bigint DEFAULT 0 NOT NULL,
      si190_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si190_naturezareceita bigint DEFAULT 0 NOT NULL,
      si190_saldoinicialnatreceita double precision DEFAULT 0 NOT NULL,
      si190_naturezasaldoinicialnatreceita character varying(1) NOT NULL,
      si190_totaldebitosnatreceita double precision DEFAULT 0 NOT NULL,
      si190_totalcreditosnatreceita double precision DEFAULT 0 NOT NULL,
      si190_saldofinalnatreceita double precision DEFAULT 0 NOT NULL,
      si190_naturezasaldofinalnatreceita character varying(1) NOT NULL,
      si190_mes bigint DEFAULT 0 NOT NULL,
      si190_instit bigint DEFAULT 0,
      si190_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete232019 OWNER TO dbportal;

  --
  -- Name: balancete232019_si190_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete232019_si190_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete232019_si190_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete242019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete242019 (
      si191_sequencial bigint DEFAULT 0 NOT NULL,
      si191_tiporegistro bigint DEFAULT 0 NOT NULL,
      si191_contacontabil bigint DEFAULT 0 NOT NULL,
      si191_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si191_codorgao character varying(2) NOT NULL,
      si191_codunidadesub character varying(8) NOT NULL,
      si191_saldoinicialorgao double precision DEFAULT 0 NOT NULL,
      si191_naturezasaldoinicialorgao character varying(1) NOT NULL,
      si191_totaldebitosorgao double precision DEFAULT 0 NOT NULL,
      si191_totalcreditosorgao double precision DEFAULT 0 NOT NULL,
      si191_saldofinalorgao double precision DEFAULT 0 NOT NULL,
      si191_naturezasaldofinalorgao character varying(1) NOT NULL,
      si191_mes bigint DEFAULT 0 NOT NULL,
      si191_instit bigint DEFAULT 0,
      si191_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete242019 OWNER TO dbportal;

  --
  -- Name: balancete242019_si191_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete242019_si191_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete242019_si191_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete252019_si195_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE TABLE balancete252019 (
      si195_sequencial bigint DEFAULT 0 NOT NULL,
      si195_tiporegistro bigint DEFAULT 0 NOT NULL,
      si195_contacontabil bigint DEFAULT 0 NOT NULL,
      si195_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si195_atributosf character varying(1) NOT NULL,
      si195_naturezareceita bigint DEFAULT 0 NOT NULL,
      si195_saldoinicialnrsf double precision DEFAULT 0 NOT NULL,
      si195_naturezasaldoinicialnrsf character varying(1) NOT NULL,
      si195_totaldebitosnrsf double precision DEFAULT 0 NOT NULL,
      si195_totalcreditosnrsf double precision DEFAULT 0 NOT NULL,
      si195_saldofinalnrsf double precision DEFAULT 0 NOT NULL,
      si195_naturezasaldofinalnrsf character varying(1) NOT NULL,
      si195_mes bigint DEFAULT 0 NOT NULL,
      si195_instit bigint DEFAULT 0,
      si195_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete252019 OWNER TO dbportal;

  --
  -- Name: balancete252019_si195_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete252019_si195_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete252019_si195_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete262019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete262019 (
      si196_sequencial bigint DEFAULT 0 NOT NULL,
      si196_tiporegistro bigint DEFAULT 0 NOT NULL,
      si196_contacontabil bigint DEFAULT 0 NOT NULL,
      si196_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si196_tipodocumentopessoaatributosf bigint NOT NULL,
      si196_nrodocumentopessoaatributosf character varying(14) NOT NULL,
      si196_atributosf character varying(1) NOT NULL,
      si196_saldoinicialpessoaatributosf double precision DEFAULT 0 NOT NULL,
      si196_naturezasaldoinicialpessoaatributosf character varying(1) NOT NULL,
      si196_totaldebitospessoaatributosf double precision DEFAULT 0 NOT NULL,
      si196_totalcreditospessoaatributosf double precision DEFAULT 0 NOT NULL,
      si196_saldofinalpessoaatributossf double precision DEFAULT 0 NOT NULL,
      si196_naturezasaldofinalpessoaatributosf character varying(1) NOT NULL,
      si196_naturezareceita bigint DEFAULT 0 NOT NULL,
      si196_mes bigint DEFAULT 0 NOT NULL,
      si196_instit bigint DEFAULT 0,
      si196_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete262019 OWNER TO dbportal;

  --
  -- Name: balancete262019_si196_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete262019_si196_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete262019_si196_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete272019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete272019 (
      si197_sequencial bigint DEFAULT 0 NOT NULL,
      si197_tiporegistro bigint DEFAULT 0 NOT NULL,
      si197_contacontabil bigint DEFAULT 0 NOT NULL,
      si197_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si197_codorgao character varying(2) NOT NULL,
      si197_codunidadesub character varying(8) NOT NULL,
      si197_codfontrecursos bigint NOT NULL,
      si197_atributosf character varying(1) NOT NULL,
      si197_saldoinicialoufontesf double precision NOT NULL,
      si197_naturezasaldoinicialoufontesf character varying(1) NOT NULL,
      si197_totaldebitosoufontesf double precision NOT NULL,
      si197_totalcreditosoufontesf double precision NOT NULL,
      si197_saldofinaloufontesf double precision NOT NULL,
      si197_naturezasaldofinaloufontesf character varying(1) NOT NULL,
      si197_mes bigint DEFAULT 0 NOT NULL,
      si197_instit bigint DEFAULT 0,
      si197_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete272019 OWNER TO dbportal;

  --
  -- Name: balancete272019_si197_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete272019_si197_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete272019_si197_sequencial_seq OWNER TO dbportal;

  --
  -- Name: balancete282019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE balancete282019 (
      si198_sequencial bigint DEFAULT 0 NOT NULL,
      si198_tiporegistro bigint DEFAULT 0 NOT NULL,
      si198_contacontabil bigint DEFAULT 0 NOT NULL,
      si198_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
      si198_codctb bigint DEFAULT 0 NOT NULL,
      si198_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si198_saldoinicialctbfonte double precision DEFAULT 0 NOT NULL,
      si198_naturezasaldoinicialctbfonte character varying(1) NOT NULL,
      si198_totaldebitosctbfonte double precision DEFAULT 0 NOT NULL,
      si198_totalcreditosctbfonte double precision DEFAULT 0 NOT NULL,
      si198_saldofinalctbfonte double precision DEFAULT 0 NOT NULL,
      si198_naturezasaldofinalctbfonte character varying(1) NOT NULL,
      si198_mes bigint DEFAULT 0 NOT NULL,
      si198_instit bigint DEFAULT 0,
      si198_reg10 bigint NOT NULL
  );


  ALTER TABLE balancete282019 OWNER TO dbportal;

  --
  -- Name: balancete282019_si198_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE balancete282019_si198_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE balancete282019_si198_sequencial_seq OWNER TO dbportal;


  --
  -- Name: bfdcasp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --
  -- todo mecher no DCASP posteriormente - INICIO
  CREATE TABLE bfdcasp102019 (
      si206_sequencial integer DEFAULT 0 NOT NULL,
      si206_tiporegistro integer DEFAULT 0 NOT NULL,
      si206_exercicio integer DEFAULT 0 NOT NULL,
      si206_vlrecorcamenrecurord double precision DEFAULT 0 NOT NULL,
      si206_vlrecorcamenrecinceduc double precision DEFAULT 0 NOT NULL,
      si206_vlrecorcamenrecurvincusaude double precision DEFAULT 0 NOT NULL,
      si206_vlrecorcamenrecurvincurpps double precision DEFAULT 0 NOT NULL,
      si206_vlrecorcamenrecurvincuassistsoc double precision DEFAULT 0 NOT NULL,
      si206_vlrecorcamenoutrasdestrecursos double precision DEFAULT 0 NOT NULL,
      si206_vltransfinanexecuorcamentaria double precision DEFAULT 0 NOT NULL,
      si206_vltransfinanindepenexecuorc double precision DEFAULT 0 NOT NULL,
      si206_vltransfinanreceaportesrpps double precision DEFAULT 0 NOT NULL,
      si206_vlincrirspnaoprocessado double precision DEFAULT 0 NOT NULL,
      si206_vlincrirspprocessado double precision DEFAULT 0 NOT NULL,
      si206_vldeporestituvinculados double precision DEFAULT 0 NOT NULL,
      si206_vloutrosrecextraorcamentario double precision DEFAULT 0 NOT NULL,
      si206_vlsaldoexeranteriorcaixaequicaixa double precision DEFAULT 0 NOT NULL,
      si206_vlsaldoexerantdeporestvinc double precision DEFAULT 0 NOT NULL,
      si206_vltotalingresso double precision DEFAULT 0,
      si206_ano integer DEFAULT 0 NOT NULL,
      si206_periodo integer DEFAULT 0 NOT NULL,
      si206_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bfdcasp102019 OWNER TO dbportal;

  --
  -- Name: bfdcasp102019_si206_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bfdcasp102019_si206_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bfdcasp102019_si206_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bfdcasp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bfdcasp202019 (
      si207_sequencial integer DEFAULT 0 NOT NULL,
      si207_tiporegistro integer DEFAULT 0 NOT NULL,
      si207_exercicio integer DEFAULT 0 NOT NULL,
      si207_vldesporcamenrecurordinarios double precision DEFAULT 0 NOT NULL,
      si207_vldesporcamenrecurvincueducacao double precision DEFAULT 0 NOT NULL,
      si207_vldesporcamenrecurvincusaude double precision DEFAULT 0 NOT NULL,
      si207_vldesporcamenrecurvincurpps double precision DEFAULT 0 NOT NULL,
      si207_vldesporcamenrecurvincuassistsoc double precision DEFAULT 0 NOT NULL,
      si207_vloutrasdesporcamendestrecursos double precision DEFAULT 0 NOT NULL,
      si207_vltransfinanconcexecorcamentaria double precision DEFAULT 0 NOT NULL,
      si207_vltransfinanconcindepenexecorc double precision DEFAULT 0 NOT NULL,
      si207_vltransfinanconcaportesrecurpps double precision DEFAULT 0 NOT NULL,
      si207_vlpagrspnaoprocessado double precision DEFAULT 0 NOT NULL,
      si207_vlpagrspprocessado double precision DEFAULT 0 NOT NULL,
      si207_vldeposrestvinculados double precision DEFAULT 0 NOT NULL,
      si207_vloutrospagextraorcamentarios double precision DEFAULT 0 NOT NULL,
      si207_vlsaldoexeratualcaixaequicaixa double precision DEFAULT 0 NOT NULL,
      si207_vlsaldoexeratualdeporestvinc double precision DEFAULT 0 NOT NULL,
      si207_vltotaldispendios double precision DEFAULT 0,
      si207_ano integer DEFAULT 0 NOT NULL,
      si207_periodo integer DEFAULT 0 NOT NULL,
      si207_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bfdcasp202019 OWNER TO dbportal;

  --
  -- Name: bfdcasp202019_si207_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bfdcasp202019_si207_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bfdcasp202019_si207_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bodcasp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bodcasp102019 (
      si201_sequencial integer DEFAULT 0 NOT NULL,
      si201_tiporegistro integer DEFAULT 0 NOT NULL,
      si201_faserecorcamentaria integer DEFAULT 0 NOT NULL,
      si201_vlrectributaria double precision DEFAULT 0 NOT NULL,
      si201_vlreccontribuicoes double precision DEFAULT 0 NOT NULL,
      si201_vlrecpatrimonial double precision DEFAULT 0 NOT NULL,
      si201_vlrecagropecuaria double precision DEFAULT 0 NOT NULL,
      si201_vlrecindustrial double precision DEFAULT 0 NOT NULL,
      si201_vlrecservicos double precision DEFAULT 0 NOT NULL,
      si201_vltransfcorrentes double precision DEFAULT 0 NOT NULL,
      si201_vloutrasreccorrentes double precision DEFAULT 0 NOT NULL,
      si201_vloperacoescredito double precision DEFAULT 0 NOT NULL,
      si201_vlalienacaobens double precision DEFAULT 0 NOT NULL,
      si201_vlamortemprestimo double precision DEFAULT 0 NOT NULL,
      si201_vltransfcapital double precision DEFAULT 0 NOT NULL,
      si201_vloutrasreccapital double precision DEFAULT 0 NOT NULL,
      si201_vlrecarrecadaxeant double precision DEFAULT 0 NOT NULL,
      si201_vlopcredrefintermob double precision DEFAULT 0 NOT NULL,
      si201_vlopcredrefintcontrat double precision DEFAULT 0 NOT NULL,
      si201_vlopcredrefextmob double precision DEFAULT 0 NOT NULL,
      si201_vlopcredrefextcontrat double precision DEFAULT 0 NOT NULL,
      si201_vldeficit double precision DEFAULT 0 NOT NULL,
      si201_vltotalquadroreceita double precision DEFAULT 0,
      si201_ano integer DEFAULT 0 NOT NULL,
      si201_periodo integer DEFAULT 0 NOT NULL,
      si201_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bodcasp102019 OWNER TO dbportal;

  --
  -- Name: bodcasp102019_si201_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bodcasp102019_si201_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bodcasp102019_si201_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bodcasp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bodcasp202019 (
      si202_sequencial integer DEFAULT 0 NOT NULL,
      si202_tiporegistro integer DEFAULT 0 NOT NULL,
      si202_faserecorcamentaria integer DEFAULT 0 NOT NULL,
      si202_vlsaldoexeantsupfin double precision DEFAULT 0 NOT NULL,
      si202_vlsaldoexeantrecredad double precision DEFAULT 0 NOT NULL,
      si202_vltotalsaldoexeant double precision DEFAULT 0,
      si202_anousu integer DEFAULT 0 NOT NULL,
      si202_periodo integer DEFAULT 0 NOT NULL,
      si202_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bodcasp202019 OWNER TO dbportal;

  --
  -- Name: bodcasp202019_si202_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bodcasp202019_si202_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bodcasp202019_si202_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bodcasp302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bodcasp302019 (
      si203_sequencial integer DEFAULT 0 NOT NULL,
      si203_tiporegistro integer DEFAULT 0 NOT NULL,
      si203_fasedespesaorca integer DEFAULT 0 NOT NULL,
      si203_vlpessoalencarsoci double precision DEFAULT 0 NOT NULL,
      si203_vljurosencardividas double precision DEFAULT 0 NOT NULL,
      si203_vloutrasdespcorren double precision DEFAULT 0 NOT NULL,
      si203_vlinvestimentos double precision DEFAULT 0 NOT NULL,
      si203_vlinverfinanceira double precision DEFAULT 0 NOT NULL,
      si203_vlamortizadivida double precision DEFAULT 0 NOT NULL,
      si203_vlreservacontingen double precision DEFAULT 0 NOT NULL,
      si203_vlreservarpps double precision DEFAULT 0 NOT NULL,
      si203_vlamortizadiviintermob double precision DEFAULT 0 NOT NULL,
      si203_vlamortizaoutrasdivinter double precision DEFAULT 0 NOT NULL,
      si203_vlamortizadivextmob double precision DEFAULT 0 NOT NULL,
      si203_vlamortizaoutrasdivext double precision DEFAULT 0 NOT NULL,
      si203_vlsuperavit double precision DEFAULT 0 NOT NULL,
      si203_vltotalquadrodespesa double precision DEFAULT 0,
      si203_anousu integer DEFAULT 0 NOT NULL,
      si203_periodo integer DEFAULT 0 NOT NULL,
      si203_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bodcasp302019 OWNER TO dbportal;

  --
  -- Name: bodcasp302019_si203_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bodcasp302019_si203_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bodcasp302019_si203_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bodcasp402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bodcasp402019 (
      si204_sequencial integer DEFAULT 0 NOT NULL,
      si204_tiporegistro integer DEFAULT 0 NOT NULL,
      si204_faserestospagarnaoproc integer DEFAULT 0 NOT NULL,
      si204_vlrspnaoprocpessoalencarsociais double precision DEFAULT 0 NOT NULL,
      si204_vlrspnaoprocjurosencardividas double precision DEFAULT 0 NOT NULL,
      si204_vlrspnaoprocoutrasdespcorrentes double precision DEFAULT 0 NOT NULL,
      si204_vlrspnaoprocinvestimentos double precision DEFAULT 0 NOT NULL,
      si204_vlrspnaoprocinverfinanceira double precision DEFAULT 0 NOT NULL,
      si204_vlrspnaoprocamortizadivida double precision DEFAULT 0 NOT NULL,
      si204_vltotalexecurspnaoprocessado double precision DEFAULT 0,
      si204_ano integer DEFAULT 0 NOT NULL,
      si204_periodo integer DEFAULT 0 NOT NULL,
      si204_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bodcasp402019 OWNER TO dbportal;

  --
  -- Name: bodcasp402019_si204_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bodcasp402019_si204_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bodcasp402019_si204_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bodcasp502019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bodcasp502019 (
      si205_sequencial integer DEFAULT 0 NOT NULL,
      si205_tiporegistro integer DEFAULT 0 NOT NULL,
      si205_faserestospagarprocnaoliqui integer DEFAULT 0 NOT NULL,
      si205_vlrspprocliqpessoalencarsoc double precision DEFAULT 0 NOT NULL,
      si205_vlrspprocliqjurosencardiv double precision DEFAULT 0 NOT NULL,
      si205_vlrspprocliqoutrasdespcorrentes double precision DEFAULT 0 NOT NULL,
      si205_vlrspprocesliqinv double precision DEFAULT 0 NOT NULL,
      si205_vlrspprocliqinverfinan double precision DEFAULT 0 NOT NULL,
      si205_vlrspprocliqamortizadivida double precision DEFAULT 0 NOT NULL,
      si205_vltotalexecrspprocnaoproceli double precision DEFAULT 0,
      si205_ano integer DEFAULT 0 NOT NULL,
      si205_periodo integer DEFAULT 0 NOT NULL,
      si205_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bodcasp502019 OWNER TO dbportal;

  --
  -- Name: bodcasp502019_si205_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bodcasp502019_si205_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bodcasp502019_si205_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp102019 (
      si208_sequencial integer DEFAULT 0 NOT NULL,
      si208_tiporegistro integer DEFAULT 0 NOT NULL,
      si208_exercicio integer DEFAULT 0 NOT NULL,
      si208_vlativocircucaixaequicaixa double precision DEFAULT 0 NOT NULL,
      si208_vlativocircucredicurtoprazo double precision DEFAULT 0 NOT NULL,
      si208_vlativocircuinvestapliccurtoprazo double precision DEFAULT 0 NOT NULL,
      si208_vlativocircuestoques double precision DEFAULT 0 NOT NULL,
      si208_vlativocircuvpdantecipada double precision DEFAULT 0 NOT NULL,
      si208_vlativonaocircucredilongoprazo double precision DEFAULT 0 NOT NULL,
      si208_vlativonaocircuinvestemplongpraz double precision DEFAULT 0 NOT NULL,
      si208_vlativonaocircuestoques double precision DEFAULT 0 NOT NULL,
      si208_vlativonaocircuvpdantecipada double precision DEFAULT 0 NOT NULL,
      si208_vlativonaocircuinvestimentos double precision DEFAULT 0 NOT NULL,
      si208_vlativonaocircuimobilizado double precision DEFAULT 0 NOT NULL,
      si208_vlativonaocircuintagivel double precision DEFAULT 0 NOT NULL,
      si208_vltotalativo double precision DEFAULT 0,
      si208_ano integer DEFAULT 0 NOT NULL,
      si208_periodo integer DEFAULT 0 NOT NULL,
      si208_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp102019 OWNER TO dbportal;

  --
  -- Name: bpdcasp102019_si208_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp102019_si208_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp102019_si208_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp202019 (
      si209_sequencial integer DEFAULT 0 NOT NULL,
      si209_tiporegistro integer DEFAULT 0 NOT NULL,
      si209_exercicio integer DEFAULT 0 NOT NULL,
      si209_vlpassivcircultrabprevicurtoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassivcirculemprefinancurtoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassivocirculafornecedcurtoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassicircuobrigfiscacurtoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassivocirculaobrigacoutrosentes double precision DEFAULT 0 NOT NULL,
      si209_vlpassivocirculaprovisoecurtoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassicircudemaiobrigcurtoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassinaocircutrabprevilongoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassnaocircemprfinalongpraz double precision DEFAULT 0 NOT NULL,
      si209_vlpassivnaocirculforneclongoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassnaocircobrifisclongpraz double precision DEFAULT 0 NOT NULL,
      si209_vlpassivnaocirculprovislongoprazo double precision DEFAULT 0 NOT NULL,
      si209_vlpassnaocircdemaobrilongpraz double precision DEFAULT 0 NOT NULL,
      si209_vlpassivonaocircularesuldiferido double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidocapitalsocial double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidoadianfuturocapital double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidoreservacapital double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidoajustavaliacao double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidoreservalucros double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidodemaisreservas double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidoresultexercicio double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidresultacumexeranteri double precision DEFAULT 0 NOT NULL,
      si209_vlpatriliquidoacoescotas double precision DEFAULT 0 NOT NULL,
      si209_vltotalpassivo double precision DEFAULT 0,
      si209_ano integer DEFAULT 0 NOT NULL,
      si209_periodo integer DEFAULT 0 NOT NULL,
      si209_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp202019 OWNER TO dbportal;

  --
  -- Name: bpdcasp202019_si209_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp202019_si209_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp202019_si209_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp302019 (
      si210_sequencial integer DEFAULT 0 NOT NULL,
      si210_tiporegistro integer DEFAULT 0 NOT NULL,
      si210_exercicio integer DEFAULT 0 NOT NULL,
      si210_vlativofinanceiro double precision DEFAULT 0 NOT NULL,
      si210_vlativopermanente double precision DEFAULT 0 NOT NULL,
      si210_vltotalativofinanceiropermanente double precision DEFAULT 0,
      si210_ano integer DEFAULT 0 NOT NULL,
      si210_periodo integer DEFAULT 0 NOT NULL,
      si210_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp302019 OWNER TO dbportal;

  --
  -- Name: bpdcasp302019_si210_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp302019_si210_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp302019_si210_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp402019 (
      si211_sequencial integer DEFAULT 0 NOT NULL,
      si211_tiporegistro integer DEFAULT 0 NOT NULL,
      si211_exercicio integer DEFAULT 0 NOT NULL,
      si211_vlpassivofinanceiro double precision DEFAULT 0 NOT NULL,
      si211_vlpassivopermanente double precision DEFAULT 0 NOT NULL,
      si211_vltotalpassivofinanceiropermanente double precision DEFAULT 0,
      si211_ano integer DEFAULT 0 NOT NULL,
      si211_periodo integer DEFAULT 0 NOT NULL,
      si211_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp402019 OWNER TO dbportal;

  --
  -- Name: bpdcasp402019_si211_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp402019_si211_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp402019_si211_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp502019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp502019 (
      si212_sequencial integer DEFAULT 0 NOT NULL,
      si212_tiporegistro integer DEFAULT 0 NOT NULL,
      si212_exercicio integer DEFAULT 0 NOT NULL,
      si212_vlsaldopatrimonial double precision DEFAULT 0,
      si212_ano integer DEFAULT 0 NOT NULL,
      si212_periodo integer DEFAULT 0 NOT NULL,
      si212_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp502019 OWNER TO dbportal;

  --
  -- Name: bpdcasp502019_si212_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp502019_si212_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp502019_si212_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp602019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp602019 (
      si213_sequencial integer DEFAULT 0 NOT NULL,
      si213_tiporegistro integer DEFAULT 0 NOT NULL,
      si213_exercicio integer DEFAULT 0 NOT NULL,
      si213_vlatospotenativosgarancontrarecebi double precision DEFAULT 0 NOT NULL,
      si213_vlatospotenativodirconveoutroinstr double precision DEFAULT 0 NOT NULL,
      si213_vlatospotenativosdireitoscontratua double precision DEFAULT 0 NOT NULL,
      si213_vlatospotenativosoutrosatos double precision DEFAULT 0 NOT NULL,
      si213_vlatospotenpassivgarancontraconced double precision DEFAULT 0 NOT NULL,
      si213_vlatospotepassobriconvoutrinst double precision DEFAULT 0 NOT NULL,
      si213_vlatospotenpassivoobrigacocontratu double precision DEFAULT 0 NOT NULL,
      si213_vlatospotenpassivooutrosatos double precision DEFAULT 0,
      si213_ano integer DEFAULT 0 NOT NULL,
      si213_periodo integer DEFAULT 0 NOT NULL,
      si213_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp602019 OWNER TO dbportal;

  --
  -- Name: bpdcasp602019_si213_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp602019_si213_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp602019_si213_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp702019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp702019 (
      si214_sequencial integer DEFAULT 0 NOT NULL,
      si214_tiporegistro integer DEFAULT 0 NOT NULL,
      si214_exercicio integer DEFAULT 0 NOT NULL,
      si214_vltotalsupdef double precision DEFAULT 0,
      si214_ano integer DEFAULT 0 NOT NULL,
      si214_periodo integer DEFAULT 0 NOT NULL,
      si214_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp702019 OWNER TO dbportal;

  --
  -- Name: bpdcasp702019_si214_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp702019_si214_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp702019_si214_sequencial_seq OWNER TO dbportal;

  --
  -- Name: bpdcasp712019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE bpdcasp712019 (
      si215_sequencial integer DEFAULT 0 NOT NULL,
      si215_tiporegistro integer DEFAULT 0 NOT NULL,
      si215_exercicio integer DEFAULT 0 NOT NULL,
      si215_codfontrecursos integer DEFAULT 0 NOT NULL,
      si215_vlsaldofonte double precision DEFAULT 0,
      si215_ano integer DEFAULT 0 NOT NULL,
      si215_periodo integer DEFAULT 0 NOT NULL,
      si215_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE bpdcasp712019 OWNER TO dbportal;

  --
  -- Name: bpdcasp712019_si215_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE bpdcasp712019_si215_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE bpdcasp712019_si215_sequencial_seq OWNER TO dbportal;

  -- todo FIM do bloco 'CASP'
  --
  -- Name: caixa102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE caixa102019 (
      si103_sequencial bigint DEFAULT 0 NOT NULL,
      si103_tiporegistro bigint DEFAULT 0 NOT NULL,
      si103_codorgao character varying(2) NOT NULL,
      si103_vlsaldoinicial double precision DEFAULT 0 NOT NULL,
      si103_vlsaldofinal double precision DEFAULT 0 NOT NULL,
      si103_mes bigint DEFAULT 0 NOT NULL,
      si103_instit bigint DEFAULT 0
  );


  ALTER TABLE caixa102019 OWNER TO dbportal;

  --
  -- Name: caixa102019_si103_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE caixa102019_si103_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE caixa102019_si103_sequencial_seq OWNER TO dbportal;

  --
  -- Name: caixa112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE caixa112019 (
      si166_sequencial bigint DEFAULT 0 NOT NULL,
      si166_tiporegistro bigint DEFAULT 0 NOT NULL,
      si166_codfontecaixa bigint DEFAULT 0 NOT NULL,
      si166_vlsaldoinicialfonte double precision DEFAULT 0 NOT NULL,
      si166_vlsaldofinalfonte double precision DEFAULT 0 NOT NULL,
      si166_mes bigint DEFAULT 0 NOT NULL,
      si166_instit bigint DEFAULT 0,
      si166_reg10 bigint DEFAULT 0 NOT NULL
  );


  ALTER TABLE caixa112019 OWNER TO dbportal;

  --
  -- Name: caixa112019_si166_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE caixa112019_si166_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE caixa112019_si166_sequencial_seq OWNER TO dbportal;

  --
  -- Name: caixa122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE caixa122019 (
      si104_sequencial bigint DEFAULT 0 NOT NULL,
      si104_tiporegistro bigint DEFAULT 0 NOT NULL,
      si104_codreduzido bigint DEFAULT 0 NOT NULL,
      si104_codfontecaixa bigint DEFAULT 0 NOT NULL,
      si104_tipomovimentacao bigint DEFAULT 0 NOT NULL,
      si104_tipoentrsaida character varying(2) NOT NULL,
      si104_descrmovimentacao character varying(50),
      si104_valorentrsaida double precision DEFAULT 0 NOT NULL,
      si104_codctbtransf bigint DEFAULT 0,
      si104_codfontectbtransf bigint DEFAULT 0,
      si104_mes bigint DEFAULT 0 NOT NULL,
      si104_reg10 bigint DEFAULT 0 NOT NULL,
      si104_instit bigint DEFAULT 0
  );


  ALTER TABLE caixa122019 OWNER TO dbportal;

  --
  -- Name: caixa122019_si104_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE caixa122019_si104_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE caixa122019_si104_sequencial_seq OWNER TO dbportal;

  --
  -- Name: caixa132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE caixa132019 (
      si105_sequencial bigint DEFAULT 0 NOT NULL,
      si105_tiporegistro bigint DEFAULT 0 NOT NULL,
      si105_codreduzido bigint DEFAULT 0 NOT NULL,
      si105_ededucaodereceita bigint DEFAULT 0 NOT NULL,
      si105_identificadordeducao bigint DEFAULT 0,
      si105_naturezareceita bigint DEFAULT 0 NOT NULL,
      si105_codfontecaixa bigint DEFAULT 0 NOT NULL,
      si105_vlrreceitacont double precision DEFAULT 0 NOT NULL,
      si105_mes bigint DEFAULT 0 NOT NULL,
      si105_reg10 bigint DEFAULT 0 NOT NULL,
      si105_instit bigint DEFAULT 0
  );


  ALTER TABLE caixa132019 OWNER TO dbportal;

  --
  -- Name: caixa132019_si105_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE caixa132019_si105_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE caixa132019_si105_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cute102019_si199_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE TABLE cute102019(
      si199_sequencial bigint DEFAULT 0 NOT NULL,
      si199_tiporegistro bigint DEFAULT 0 NOT NULL,
      si199_tipoconta character varying(2) NOT NULL,
      si199_codctb bigint DEFAULT 0 NOT NULL,
      si199_codorgao character varying(2) NOT NULL,
      si199_banco bigint DEFAULT 0 NOT NULL,
      si199_agencia character varying(6) NOT NULL,
      si199_digitoverificadoragencia character varying(2),
      si199_contabancaria bigint DEFAULT 0 NOT NULL,
      si199_digitoverificadorcontabancaria character varying(2) NOT NULL,
      si199_desccontabancaria character varying(50) NOT NULL,
      si199_mes bigint DEFAULT 0 NOT NULL,
      si199_instit bigint DEFAULT 0
  );

  ALTER TABLE cute102019 OWNER TO dbportal;

  CREATE SEQUENCE cute102019_si199_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;

  ALTER TABLE cute102019_si199_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cute202019_si200_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE TABLE cute202019(
      si200_sequencial bigint DEFAULT 0 NOT NULL,
      si200_tiporegistro bigint DEFAULT 0 NOT NULL,
      si200_codorgao character varying(2) NOT NULL,
      si200_codctb bigint DEFAULT 0 NOT NULL,
      si200_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si200_vlsaldoinicialfonte double precision DEFAULT 0 NOT NULL,
      si200_vlsaldofinalfonte double precision DEFAULT 0 NOT NULL,
      si200_mes bigint DEFAULT 0 NOT NULL,
      si200_instit bigint DEFAULT 0
  );

  ALTER TABLE cute202019 OWNER TO dbportal;

  CREATE SEQUENCE cute202019_si200_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;

  ALTER TABLE cute202019_si200_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cute212019_si201_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE TABLE cute212019( --todo checar reg10
      si201_sequencial bigint DEFAULT 0 NOT NULL,
      si201_tiporegistro bigint DEFAULT 0 NOT NULL,
      si201_codctb bigint DEFAULT 0 NOT NULL,
      si201_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si201_tipomovimentacao bigint DEFAULT 0 NOT NULL,
      si201_tipoentrsaida character varying(2) NOT NULL,
      si201_valorentrsaida double precision DEFAULT 0 NOT NULL,
      si201_codorgaotransf character varying(2),
      si201_reg10 bigint DEFAULT 0 NOT NULL,
      si201_mes bigint DEFAULT 0 NOT NULL,
      si201_instit bigint DEFAULT 0
  );

  ALTER TABLE cute212019 OWNER TO dbportal;

  CREATE SEQUENCE cute212019_si201_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;

  ALTER TABLE cute212019_si201_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cute212019_si201_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE TABLE cute302019(
      si202_sequencial bigint DEFAULT 0 NOT NULL,
      si202_tiporegistro bigint DEFAULT 0 NOT NULL,
      si202_codorgao character varying(2) NOT NULL,
      si202_codctb bigint DEFAULT 0 NOT NULL,
      si202_situacaoconta character varying(1) NOT NULL,
      si202_datasituacao date NOT NULL,
      si202_mes bigint DEFAULT 0 NOT NULL,
      si202_instit bigint DEFAULT 0
  );

  ALTER TABLE cute302019 OWNER TO dbportal;

  CREATE SEQUENCE cute302019_si202_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;

  ALTER TABLE cute302019_si202_sequencial_seq OWNER TO dbportal;

  --
  -- Name: consor102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE consor102019 (
      si16_sequencial bigint DEFAULT 0 NOT NULL,
      si16_tiporegistro bigint DEFAULT 0 NOT NULL,
      si16_codorgao character varying(2) NOT NULL,
      si16_cnpjconsorcio character varying(14) NOT NULL,
      si16_areaatuacao character varying(2) NOT NULL,
      si16_descareaatuacao character varying(150),
      si16_mes bigint DEFAULT 0 NOT NULL,
      si16_instit bigint DEFAULT 0
  );


  ALTER TABLE consor102019 OWNER TO dbportal;

  --
  -- Name: consor102019_si16_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE consor102019_si16_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE consor102019_si16_sequencial_seq OWNER TO dbportal;

  --
  -- Name: consor202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE consor202019 (
      si17_sequencial bigint DEFAULT 0 NOT NULL,
      si17_tiporegistro bigint DEFAULT 0 NOT NULL,
      si17_codorgao character varying(2) NOT NULL,
      si17_cnpjconsorcio character varying(14) NOT NULL,
      si17_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si17_vltransfrateio double precision DEFAULT 0 NOT NULL,
      si17_prestcontas bigint DEFAULT 0 NOT NULL,
      si17_mes bigint DEFAULT 0 NOT NULL,
      si17_instit bigint DEFAULT 0
  );


  ALTER TABLE consor202019 OWNER TO dbportal;

  --
  -- Name: consor202019_si17_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE consor202019_si17_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE consor202019_si17_sequencial_seq OWNER TO dbportal;

  --
  -- Name: consor302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE consor302019 (
      si18_sequencial bigint DEFAULT 0 NOT NULL,
      si18_tiporegistro bigint DEFAULT 0 NOT NULL,
      si18_cnpjconsorcio character varying(14) NOT NULL,
      si18_mesreferencia character varying(2) NOT NULL,
      si18_codfuncao character varying(2) NOT NULL,
      si18_codsubfuncao character varying(3) NOT NULL,
      si18_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si18_subelemento character varying(2) NOT NULL,
      si18_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si18_vlempenhadofonte double precision DEFAULT 0 NOT NULL,
      si18_vlanulacaoempenhofonte double precision DEFAULT 0 NOT NULL,
      si18_vlliquidadofonte double precision DEFAULT 0 NOT NULL,
      si18_vlanulacaoliquidacaofonte double precision DEFAULT 0 NOT NULL,
      si18_vlpagofonte double precision DEFAULT 0 NOT NULL,
      si18_vlanulacaopagamentofonte double precision DEFAULT 0 NOT NULL,
      si18_mes bigint DEFAULT 0 NOT NULL,
      si18_instit bigint DEFAULT 0
  );


  ALTER TABLE consor302019 OWNER TO dbportal;

  --
  -- Name: consor302019_si18_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE consor302019_si18_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE consor302019_si18_sequencial_seq OWNER TO dbportal;

  --
  -- Name: consor402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE consor402019 (
      si19_sequencial bigint DEFAULT 0 NOT NULL,
      si19_tiporegistro bigint DEFAULT 0 NOT NULL,
      si19_cnpjconsorcio character varying(14) NOT NULL,
      si19_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si19_vldispcaixa double precision DEFAULT 0 NOT NULL,
      si19_mes bigint DEFAULT 0 NOT NULL,
      si19_instit bigint DEFAULT 0
  );


  ALTER TABLE consor402019 OWNER TO dbportal;

  --
  -- Name: consor402019_si19_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE consor402019_si19_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE consor402019_si19_sequencial_seq OWNER TO dbportal;

  --
  -- Name: consor502019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE consor502019 (
      si20_sequencial bigint DEFAULT 0 NOT NULL,
      si20_tiporegistro bigint DEFAULT 0 NOT NULL,
      si20_codorgao character varying(2) NOT NULL,
      si20_cnpjconsorcio character varying(14) NOT NULL,
      si20_tipoencerramento bigint DEFAULT 0 NOT NULL,
      si20_dtencerramento date NOT NULL,
      si20_mes bigint DEFAULT 0 NOT NULL,
      si20_instit bigint DEFAULT 0
  );


  ALTER TABLE consor502019 OWNER TO dbportal;

  --
  -- Name: consor502019_si20_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE consor502019_si20_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE consor502019_si20_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos102019 (
      si83_sequencial bigint DEFAULT 0 NOT NULL,
      si83_tiporegistro bigint DEFAULT 0 NOT NULL,
      si83_codcontrato bigint DEFAULT 0 NOT NULL,
      si83_codorgao character varying(2) NOT NULL,
      si83_codunidadesub character varying(8) NOT NULL,
      si83_nrocontrato bigint DEFAULT 0 NOT NULL,
      si83_exerciciocontrato bigint DEFAULT 0 NOT NULL,
      si83_dataassinatura date NOT NULL,
      si83_contdeclicitacao bigint DEFAULT 0 NOT NULL,
      si83_codorgaoresp character varying(2),
      si83_codunidadesubresp character varying(8),
      si83_nroprocesso character varying(12),
      si83_exercicioprocesso bigint DEFAULT 0,
      si83_tipoprocesso bigint DEFAULT 0,
      si83_naturezaobjeto bigint DEFAULT 0 NOT NULL,
      si83_objetocontrato character varying(500) NOT NULL,
      si83_tipoinstrumento bigint DEFAULT 0 NOT NULL,
      si83_datainiciovigencia date NOT NULL,
      si83_datafinalvigencia date NOT NULL,
      si83_vlcontrato double precision DEFAULT 0 NOT NULL,
      si83_formafornecimento character varying(50),
      si83_formapagamento character varying(100),
      si83_prazoexecucao character varying(100),
      si83_multarescisoria character varying(100),
      si83_multainadimplemento character varying(100),
      si83_garantia bigint DEFAULT 0,
      si83_cpfsignatariocontratante character varying(11) NOT NULL,
      si83_datapublicacao date NOT NULL,
      si83_veiculodivulgacao character varying(50) NOT NULL,
      si83_mes bigint DEFAULT 0 NOT NULL,
      si83_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos102019 OWNER TO dbportal;

  --
  -- Name: contratos102019_si83_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos102019_si83_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos102019_si83_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos112019 (
      si84_sequencial bigint DEFAULT 0 NOT NULL,
      si84_tiporegistro bigint DEFAULT 0 NOT NULL,
      si84_codcontrato bigint DEFAULT 0 NOT NULL,
      si84_coditem bigint DEFAULT 0 NOT NULL,
      si84_quantidadeitem double precision DEFAULT 0 NOT NULL,
      si84_valorunitarioitem double precision DEFAULT 0 NOT NULL,
      si84_mes bigint DEFAULT 0 NOT NULL,
      si84_reg10 bigint DEFAULT 0 NOT NULL,
      si84_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos112019 OWNER TO dbportal;

  --
  -- Name: contratos112019_si84_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos112019_si84_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos112019_si84_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos122019 (
      si85_sequencial bigint DEFAULT 0 NOT NULL,
      si85_tiporegistro bigint DEFAULT 0 NOT NULL,
      si85_codcontrato bigint DEFAULT 0 NOT NULL,
      si85_codorgao character varying(2) NOT NULL,
      si85_codunidadesub character varying(8) NOT NULL,
      si85_codfuncao character varying(2) NOT NULL,
      si85_codsubfuncao character varying(3) NOT NULL,
      si85_codprograma character varying(4) NOT NULL,
      si85_idacao character varying(4) NOT NULL,
      si85_idsubacao character varying(4),
      si85_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si85_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si85_vlrecurso double precision DEFAULT 0 NOT NULL,
      si85_mes bigint DEFAULT 0 NOT NULL,
      si85_reg10 bigint DEFAULT 0 NOT NULL,
      si85_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos122019 OWNER TO dbportal;

  --
  -- Name: contratos122019_si85_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos122019_si85_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos122019_si85_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos132019 (
      si86_sequencial bigint DEFAULT 0 NOT NULL,
      si86_tiporegistro bigint DEFAULT 0 NOT NULL,
      si86_codcontrato bigint DEFAULT 0 NOT NULL,
      si86_tipodocumento bigint DEFAULT 0 NOT NULL,
      si86_nrodocumento character varying(14) NOT NULL,
      si86_cpfrepresentantelegal character varying(11) NOT NULL,
      si86_mes bigint DEFAULT 0 NOT NULL,
      si86_reg10 bigint DEFAULT 0 NOT NULL,
      si86_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos132019 OWNER TO dbportal;

  --
  -- Name: contratos132019_si86_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos132019_si86_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos132019_si86_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos202019 (
      si87_sequencial bigint DEFAULT 0 NOT NULL,
      si87_tiporegistro bigint DEFAULT 0 NOT NULL,
      si87_codaditivo bigint DEFAULT 0 NOT NULL,
      si87_codorgao character varying(2) NOT NULL,
      si87_codunidadesub character varying(8) NOT NULL,
      si87_nrocontrato bigint DEFAULT 0 NOT NULL,
      si87_dtassinaturacontoriginal date NOT NULL,
      si87_nroseqtermoaditivo character varying(2) NOT NULL,
      si87_dtassinaturatermoaditivo date NOT NULL,
      si87_tipoalteracaovalor bigint DEFAULT 0 NOT NULL,
      si87_tipotermoaditivo character varying(2) NOT NULL,
      si87_dscalteracao character varying(250),
      si87_novadatatermino date,
      si87_valoraditivo double precision DEFAULT 0 NOT NULL,
      si87_datapublicacao date NOT NULL,
      si87_veiculodivulgacao character varying(50) NOT NULL,
      si87_mes bigint DEFAULT 0 NOT NULL,
      si87_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos202019 OWNER TO dbportal;

  --
  -- Name: contratos202019_si87_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos202019_si87_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos202019_si87_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos212019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos212019 (
      si88_sequencial bigint DEFAULT 0 NOT NULL,
      si88_tiporegistro bigint DEFAULT 0 NOT NULL,
      si88_codaditivo bigint DEFAULT 0 NOT NULL,
      si88_coditem bigint DEFAULT 0 NOT NULL,
      si88_tipoalteracaoitem bigint DEFAULT 0 NOT NULL,
      si88_quantacrescdecresc double precision DEFAULT 0 NOT NULL,
      si88_valorunitarioitem double precision DEFAULT 0 NOT NULL,
      si88_mes bigint DEFAULT 0 NOT NULL,
      si88_reg20 bigint DEFAULT 0 NOT NULL,
      si88_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos212019 OWNER TO dbportal;

  --
  -- Name: contratos212019_si88_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos212019_si88_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos212019_si88_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos302019 (
      si89_sequencial bigint DEFAULT 0 NOT NULL,
      si89_tiporegistro bigint DEFAULT 0 NOT NULL,
      si89_codorgao character varying(2) NOT NULL,
      si89_codunidadesub character varying(8) NOT NULL,
      si89_nrocontrato bigint DEFAULT 0 NOT NULL,
      si89_dtassinaturacontoriginal date NOT NULL,
      si89_tipoapostila character varying(2) NOT NULL,
      si89_nroseqapostila bigint DEFAULT 0 NOT NULL,
      si89_dataapostila date NOT NULL,
      si89_tipoalteracaoapostila bigint DEFAULT 0 NOT NULL,
      si89_dscalteracao character varying(250) NOT NULL,
      si89_valorapostila double precision DEFAULT 0 NOT NULL,
      si89_mes bigint DEFAULT 0 NOT NULL,
      si89_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos302019 OWNER TO dbportal;

  --
  -- Name: contratos302019_si89_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos302019_si89_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos302019_si89_sequencial_seq OWNER TO dbportal;

  --
  -- Name: contratos402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE contratos402019 (
      si91_sequencial bigint DEFAULT 0 NOT NULL,
      si91_tiporegistro bigint DEFAULT 0 NOT NULL,
      si91_codorgao character varying(2) NOT NULL,
      si91_codunidadesub character varying(8),
      si91_nrocontrato bigint DEFAULT 0 NOT NULL,
      si91_dtassinaturacontoriginal date NOT NULL,
      si91_datarescisao date NOT NULL,
      si91_valorcancelamentocontrato double precision DEFAULT 0 NOT NULL,
      si91_mes bigint DEFAULT 0 NOT NULL,
      si91_instit bigint DEFAULT 0
  );


  ALTER TABLE contratos402019 OWNER TO dbportal;

  --
  -- Name: contratos402019_si91_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE contratos402019_si91_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE contratos402019_si91_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conv102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conv102019 (
      si92_sequencial bigint DEFAULT 0 NOT NULL,
      si92_tiporegistro bigint DEFAULT 0 NOT NULL,
      si92_codconvenio bigint DEFAULT 0 NOT NULL,
      si92_codorgao character varying(2) NOT NULL,
      si92_nroconvenio character varying(30) NOT NULL,
      si92_dtassinatura date NOT NULL,
      si92_objetoconvenio character varying(500) NOT NULL,
      si92_datainiciovigencia date NOT NULL,
      si92_datafinalvigencia date NOT NULL,
      si92_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si92_vlconvenio double precision DEFAULT 0 NOT NULL,
      si92_vlcontrapartida double precision DEFAULT 0 NOT NULL,
      si92_mes bigint DEFAULT 0 NOT NULL,
      si92_instit bigint DEFAULT 0
  );


  ALTER TABLE conv102019 OWNER TO dbportal;

  --
  -- Name: conv102019_si92_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conv102019_si92_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conv102019_si92_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conv112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conv112019 (
      si93_sequencial bigint DEFAULT 0 NOT NULL,
      si93_tiporegistro bigint DEFAULT 0 NOT NULL,
      si93_codconvenio bigint DEFAULT 0 NOT NULL,
      si93_tipodocumento bigint DEFAULT 0,
      si93_nrodocumento character varying(14),
      si93_esferaconcedente bigint DEFAULT 0 NOT NULL,
      si93_dscexterior character varying(120),
      si93_valorconcedido double precision DEFAULT 0 NOT NULL,
      si93_mes bigint DEFAULT 0 NOT NULL,
      si93_reg10 bigint DEFAULT 0 NOT NULL,
      si93_instit bigint DEFAULT 0
  );


  ALTER TABLE conv112019 OWNER TO dbportal;

  --
  -- Name: conv112019_si93_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conv112019_si93_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conv112019_si93_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conv202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conv202019 (
      si94_sequencial bigint DEFAULT 0 NOT NULL,
      si94_tiporegistro bigint DEFAULT 0 NOT NULL,
      si94_codorgao character varying(2) NOT NULL,
      si94_nroconvenio character varying(30) NOT NULL,
      si94_dtassinaturaconvoriginal date NOT NULL,
      si94_nroseqtermoaditivo character varying(2) NOT NULL,
      si94_dscalteracao character varying(500) NOT NULL,
      si94_dtssinaturatermoaditivo date NOT NULL,
      si94_datafinalvigencia date NOT NULL,
      si94_valoratualizadoconvenio double precision DEFAULT 0 NOT NULL,
      si94_valoratualizadocontrapartida double precision DEFAULT 0 NOT NULL,
      si94_mes bigint DEFAULT 0 NOT NULL,
      si94_instit bigint DEFAULT 0
  );


  ALTER TABLE conv202019 OWNER TO dbportal;

  --
  -- Name: conv202019_si94_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conv202019_si94_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conv202019_si94_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conv202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conv302019 (
      si203_sequencial bigint DEFAULT 0 NOT NULL,
      si203_tiporegistro bigint DEFAULT 0 NOT NULL,
      si203_codreceita bigint DEFAULT 0 NOT NULL,
      si203_codorgao character varying(2) NOT NULL,
      si203_naturezareceita bigint DEFAULT 0 NOT NULL,
      si203_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si203_vlprevisao double precision DEFAULT 0 NOT NULL,
      si203_mes bigint DEFAULT 0 NOT NULL,
      si203_instit bigint DEFAULT 0
  );


  ALTER TABLE conv302019 OWNER TO dbportal;

  --
  -- Name: conv302019_si203_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conv302019_si203_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conv302019_si203_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conv312019_si203_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE TABLE conv312019 ( -- todo checar reg10
      si204_sequencial bigint DEFAULT 0 NOT NULL,
      si204_tiporegistro bigint DEFAULT 0 NOT NULL,
      si204_codreceita bigint DEFAULT 0 NOT NULL,
      si204_prevorcamentoassin bigint DEFAULT 0 NOT NULL,
      si204_nroconvenio character varying(2) NOT NULL,
      si204_dataassinatura date,
      si204_vlprevisaoconvenio double precision DEFAULT 0 NOT NULL,
      si204_reg10 bigint DEFAULT 0 NOT NULL,
      si204_mes bigint DEFAULT 0 NOT NULL,
      si204_instit bigint DEFAULT 0
  );


  ALTER TABLE conv312019 OWNER TO dbportal;

  --
  -- Name: conv302019_si204_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conv312019_si204_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conv312019_si204_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cronem102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE cronem102019 (
      si170_sequencial bigint DEFAULT 0 NOT NULL,
      si170_tiporegistro bigint DEFAULT 0 NOT NULL,
      si170_codorgao character varying(2) DEFAULT 0 NOT NULL,
      si170_codunidadesub character varying(8) DEFAULT 0 NOT NULL,
      si170_grupodespesa bigint DEFAULT 0 NOT NULL,
      si170_vldotmensal double precision DEFAULT 0 NOT NULL,
      si170_instit bigint DEFAULT 0
  );


  ALTER TABLE cronem102019 OWNER TO dbportal;

  --
  -- Name: cronem102019_si170_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE cronem102019_si170_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE cronem102019_si170_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb102019 (
      si95_sequencial bigint DEFAULT 0 NOT NULL,
      si95_tiporegistro bigint DEFAULT 0 NOT NULL,
      si95_codctb bigint DEFAULT 0 NOT NULL,
      si95_codorgao character varying(2) NOT NULL,
      si95_banco character varying(3) NOT NULL,
      si95_agencia character varying(6) NOT NULL,
      si95_digitoverificadoragencia character varying(2),
      si95_contabancaria bigint DEFAULT 0 NOT NULL,
      si95_digitoverificadorcontabancaria character varying(2) NOT NULL,
      si95_tipoconta character varying(2) NOT NULL,
      si95_tipoaplicacao character varying(2),
      si95_nroseqaplicacao bigint DEFAULT 0,
      si95_desccontabancaria character varying(50) NOT NULL,
      si95_contaconvenio bigint DEFAULT 0 NOT NULL,
      si95_nroconvenio character varying(30),
      si95_dataassinaturaconvenio date,
      si95_mes bigint DEFAULT 0 NOT NULL,
      si95_instit bigint DEFAULT 0
  );


  ALTER TABLE ctb102019 OWNER TO dbportal;

  --
  -- Name: ctb102019_si95_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb102019_si95_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb102019_si95_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb202019 (
      si96_sequencial bigint DEFAULT 0 NOT NULL,
      si96_tiporegistro bigint DEFAULT 0 NOT NULL,
      si96_codorgao character varying(2) NOT NULL,
      si96_codctb bigint DEFAULT 0 NOT NULL,
      si96_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si96_vlsaldoinicialfonte double precision DEFAULT 0 NOT NULL,
      si96_vlsaldofinalfonte double precision DEFAULT 0 NOT NULL,
      si96_mes bigint DEFAULT 0 NOT NULL,
      si96_instit bigint DEFAULT 0
  );


  ALTER TABLE ctb202019 OWNER TO dbportal;

  --
  -- Name: ctb202019_si96_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb202019_si96_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb202019_si96_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb212019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb212019 (
      si97_sequencial bigint DEFAULT 0 NOT NULL,
      si97_tiporegistro bigint DEFAULT 0 NOT NULL,
      si97_codctb bigint DEFAULT 0 NOT NULL,
      si97_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si97_codreduzidomov bigint DEFAULT 0 NOT NULL,
      si97_tipomovimentacao bigint DEFAULT 0 NOT NULL,
      si97_tipoentrsaida character varying(2) NOT NULL,
      si97_dscoutrasmov character varying(50),
      si97_valorentrsaida double precision DEFAULT 0 NOT NULL,
      si97_codctbtransf bigint DEFAULT 0,
      si97_codfontectbtransf bigint DEFAULT 0 NOT NULL,
      si97_mes bigint DEFAULT 0 NOT NULL,
      si97_reg20 bigint DEFAULT 0 NOT NULL,
      si97_instit bigint DEFAULT 0
  );


  ALTER TABLE ctb212019 OWNER TO dbportal;

  --
  -- Name: ctb212019_si97_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb212019_si97_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb212019_si97_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb222019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb222019 (
      si98_sequencial bigint DEFAULT 0 NOT NULL,
      si98_tiporegistro bigint DEFAULT 0 NOT NULL,
      si98_codreduzidomov bigint DEFAULT 0 NOT NULL,
      si98_ededucaodereceita bigint DEFAULT 0 NOT NULL,
      si98_identificadordeducao bigint DEFAULT 0,
      si98_naturezareceita bigint DEFAULT 0 NOT NULL,
      si98_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si98_vlrreceitacont double precision DEFAULT 0 NOT NULL,
      si98_mes bigint DEFAULT 0 NOT NULL,
      si98_reg21 bigint DEFAULT 0 NOT NULL,
      si98_instit bigint DEFAULT 0
  );


  ALTER TABLE ctb222019 OWNER TO dbportal;

  --
  -- Name: ctb222019_si98_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb222019_si98_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb222019_si98_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb302019 (
      si99_sequencial bigint DEFAULT 0 NOT NULL,
      si99_tiporegistro bigint DEFAULT 0 NOT NULL,
      si99_codorgao character varying(2) NOT NULL,
      si99_codagentearrecadador bigint DEFAULT 0 NOT NULL,
      si99_cnpjagentearrecadador character varying(14) NOT NULL,
      si99_vlsaldoinicial double precision DEFAULT 0 NOT NULL,
      si99_vlsaldofinal double precision DEFAULT 0 NOT NULL,
      si99_mes bigint DEFAULT 0 NOT NULL,
      si99_instit bigint DEFAULT 0
  );


  ALTER TABLE ctb302019 OWNER TO dbportal;

  --
  -- Name: ctb302019_si99_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb302019_si99_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb302019_si99_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb312019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb312019 (
      si100_sequencial bigint DEFAULT 0 NOT NULL,
      si100_tiporegistro bigint DEFAULT 0 NOT NULL,
      si100_codagentearrecadador bigint DEFAULT 0 NOT NULL,
      si100_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si100_vlsaldoinicialagfonte double precision DEFAULT 0 NOT NULL,
      si100_vlentradafonte double precision DEFAULT 0 NOT NULL,
      si100_vlsaidafonte double precision DEFAULT 0 NOT NULL,
      si100_vlsaldofinalagfonte double precision DEFAULT 0 NOT NULL,
      si100_mes bigint DEFAULT 0 NOT NULL,
      si100_reg30 bigint DEFAULT 0 NOT NULL,
      si100_instit integer DEFAULT 0
  );


  ALTER TABLE ctb312019 OWNER TO dbportal;

  --
  -- Name: ctb312019_si100_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb312019_si100_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb312019_si100_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb402019 (
      si101_sequencial bigint DEFAULT 0 NOT NULL,
      si101_tiporegistro bigint DEFAULT 0 NOT NULL,
      si101_codorgao character varying(2) NOT NULL,
      si101_codctb bigint DEFAULT 0 NOT NULL,
      si101_desccontabancaria character varying(50) NOT NULL,
      si101_nroconvenio character varying(30),
      si101_dataassinaturaconvenio date,
      si101_mes bigint DEFAULT 0 NOT NULL,
      si101_instit bigint DEFAULT 0
  );


  ALTER TABLE ctb402019 OWNER TO dbportal;

  --
  -- Name: ctb402019_si101_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb402019_si101_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb402019_si101_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ctb502019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ctb502019 (
      si102_sequencial bigint DEFAULT 0 NOT NULL,
      si102_tiporegistro bigint DEFAULT 0 NOT NULL,
      si102_codorgao character varying(2) NOT NULL,
      si102_codctb bigint DEFAULT 0 NOT NULL,
      si102_situacaoconta character varying(1) NOT NULL,
      si102_datasituacao date NOT NULL,
      si102_mes bigint DEFAULT 0 NOT NULL,
      si102_instit bigint DEFAULT 0
  );


  ALTER TABLE ctb502019 OWNER TO dbportal;

  --
  -- Name: ctb502019_si102_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ctb502019_si102_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ctb502019_si102_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cvc102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE cvc102019 (
      si146_sequencial bigint DEFAULT 0 NOT NULL,
      si146_tiporegistro bigint DEFAULT 0 NOT NULL,
      si146_codorgao character varying(2) NOT NULL,
      si146_codunidadesub character varying(8) NOT NULL,
      si146_codveiculo character varying(10) NOT NULL,
      si146_tpveiculo character varying(2) NOT NULL,
      si146_subtipoveiculo character varying(2) NOT NULL,
      si146_descveiculo character varying(100) NOT NULL,
      si146_marca character varying(50) NOT NULL,
      si146_modelo character varying(50) NOT NULL,
      si146_ano bigint DEFAULT 0 NOT NULL,
      si146_placa character varying(8),
      si146_chassi character varying(30),
      si146_numerorenavam bigint DEFAULT 0,
      si146_nroserie character varying(20),
      si146_situacao character varying(2) NOT NULL,
      si146_tipodocumento bigint DEFAULT 0,
      si146_nrodocumento character varying(14),
      si146_tpdeslocamento character varying(2) NOT NULL,
      si146_mes bigint DEFAULT 0 NOT NULL,
      si146_instit bigint DEFAULT 0
  );


  ALTER TABLE cvc102019 OWNER TO dbportal;

  --
  -- Name: cvc102019_si146_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE cvc102019_si146_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE cvc102019_si146_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cvc202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE cvc202019 (
      si147_sequencial bigint DEFAULT 0 NOT NULL,
      si147_tiporegistro bigint DEFAULT 0 NOT NULL,
      si147_codorgao character varying(2) NOT NULL,
      si147_codunidadesub character varying(8) NOT NULL,
      si147_codveiculo character varying(10) NOT NULL,
      si147_origemgasto bigint DEFAULT 0 NOT NULL,
      si147_codunidadesubempenho character varying(8),
      si147_nroempenho bigint DEFAULT 0,
      si147_dtempenho date,
      si147_marcacaoinicial bigint DEFAULT 0 NOT NULL,
      si147_marcacaofinal bigint DEFAULT 0 NOT NULL,
      si147_tipogasto character varying(2) NOT NULL,
      si147_qtdeutilizada double precision DEFAULT 0 NOT NULL,
      si147_vlgasto double precision DEFAULT 0 NOT NULL,
      si147_dscpecasservicos character varying(50),
      si147_atestadocontrole character varying(1) NOT NULL,
      si147_mes bigint DEFAULT 0 NOT NULL,
      si147_instit bigint DEFAULT 0
  );


  ALTER TABLE cvc202019 OWNER TO dbportal;

  --
  -- Name: cvc202019_si147_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE cvc202019_si147_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE cvc202019_si147_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cvc302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE cvc302019 (
      si148_sequencial bigint DEFAULT 0 NOT NULL,
      si148_tiporegistro bigint DEFAULT 0 NOT NULL,
      si148_codorgao character varying(2) NOT NULL,
      si148_codunidadesub character varying(8) NOT NULL,
      si148_codveiculo character varying(10) NOT NULL,
      si148_nomeestabelecimento character varying(250) NOT NULL,
      si148_localidade character varying(250) NOT NULL,
      si148_qtdediasrodados bigint DEFAULT 0 NOT NULL,
      si148_distanciaestabelecimento double precision DEFAULT 0 NOT NULL,
      si148_numeropassageiros bigint DEFAULT 0 NOT NULL,
      si148_turnos character varying(2) NOT NULL,
      si148_mes bigint DEFAULT 0 NOT NULL,
      si148_instit bigint DEFAULT 0
  );


  ALTER TABLE cvc302019 OWNER TO dbportal;

  --
  -- Name: cvc302019_si148_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE cvc302019_si148_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE cvc302019_si148_sequencial_seq OWNER TO dbportal;

  --
  -- Name: cvc402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE cvc402019 (
      si149_sequencial bigint DEFAULT 0 NOT NULL,
      si149_tiporegistro bigint DEFAULT 0 NOT NULL,
      si149_codorgao character varying(2) NOT NULL,
      si149_codunidadesub character varying(8) NOT NULL,
      si149_codveiculo character varying(10) NOT NULL,
      si149_tipobaixa bigint DEFAULT 0 NOT NULL,
      si149_descbaixa character varying(50),
      si149_dtbaixa date NOT NULL,
      si149_mes bigint DEFAULT 0 NOT NULL,
      si149_instit bigint DEFAULT 0
  );


  ALTER TABLE cvc402019 OWNER TO dbportal;

  --
  -- Name: cvc402019_si149_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE cvc402019_si149_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE cvc402019_si149_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dclrf102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dclrf102019 (
      si157_sequencial bigint DEFAULT 0 NOT NULL,
      si157_tiporegistro bigint DEFAULT 0 NOT NULL,
      si157_codorgao character varying(2) NOT NULL,
      si157_passivosreconhecidos double precision DEFAULT 0 NOT NULL,
      si157_vlsaldoatualconcgarantiainterna double precision DEFAULT 0 NOT NULL,
      si157_vlsaldoatualconcgarantia double precision DEFAULT 0 NOT NULL,
      si157_vlsaldoatualcontragarantiainterna double precision DEFAULT 0 NOT NULL,
      si157_vlsaldoatualcontragarantiaexterna double precision DEFAULT 0 NOT NULL,
      si157_medidascorretivas character varying(4000),
      si157_recalieninvpermanente double precision DEFAULT 0 NOT NULL,
      si157_vldotatualizadaincentcontrib double precision DEFAULT 0 NOT NULL,
      si157_vlempenhadoicentcontrib double precision DEFAULT 0 NOT NULL,
      si157_vldotatualizadaincentinstfinanc double precision DEFAULT 0 NOT NULL,
      si157_vlempenhadoincentinstfinanc double precision DEFAULT 0 NOT NULL,
      si157_vlliqincentcontrib double precision DEFAULT 0 NOT NULL,
      si157_vlliqincentinstfinanc double precision DEFAULT 0 NOT NULL,
      si157_vlirpnpincentcontrib double precision DEFAULT 0 NOT NULL,
      si157_vlirpnpincentinstfinanc double precision DEFAULT 0 NOT NULL,
      si157_vlrecursosnaoaplicados double precision DEFAULT 0 NOT NULL,
      si157_vlapropiacaodepositosjudiciais double precision DEFAULT 0 NOT NULL,
      si157_vloutrosajustes double precision DEFAULT 0 NOT NULL,
      si157_metarrecada bigint DEFAULT 0 NOT NULL,
      si157_mes bigint DEFAULT 0 NOT NULL,
      si157_instit bigint DEFAULT 0
  );


  ALTER TABLE dclrf102019 OWNER TO dbportal;

  --
  -- Name: dclrf102019_si157_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dclrf102019_si157_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dclrf102019_si157_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dclrf112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dclrf112019 (
      si205_sequencial bigint DEFAULT 0 NOT NULL,
      si205_tiporegistro bigint DEFAULT 0 NOT NULL,
      si205_medidasadotadas bigint DEFAULT 0 NOT NULL,
      si205_dscmedidasadotadas character varying(4000),
      si205_reg10 bigint DEFAULT 0 NOT NULL,
      si205_mes bigint DEFAULT 0 NOT NULL,
      si205_instit bigint DEFAULT 0 NOT NULL
  );


  ALTER TABLE dclrf112019 OWNER TO dbportal;

  --
  -- Name: dclrf112019_si205_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dclrf112019_si205_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dclrf112019_si205_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dclrf202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dclrf202019 (
      si191_sequencial bigint DEFAULT 0 NOT NULL,
      si191_tiporegistro bigint DEFAULT 0 NOT NULL,
      si191_contopcredito bigint DEFAULT 0 NOT NULL,
      si191_dsccontopcredito character varying(1000) DEFAULT 0,
      si191_realizopcredito bigint DEFAULT 0 NOT NULL,
      si191_tiporealizopcreditocapta bigint DEFAULT 0,
      si191_tiporealizopcreditoreceb bigint DEFAULT 0,
      si191_tiporealizopcreditoassundir bigint DEFAULT 0,
      si191_tiporealizopcreditoassunobg bigint DEFAULT 0,
      si191_reg10 bigint DEFAULT 0 NOT NULL,
      si191_mes bigint DEFAULT 0 NOT NULL,
      si191_instit bigint DEFAULT 0 NOT NULL
  );


  ALTER TABLE dclrf202019 OWNER TO dbportal;

  --
  -- Name: dclrf202019_si169_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dclrf202019_si191_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dclrf202019_si191_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dclrf302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dclrf302019 (
      si192_sequencial bigint NOT NULL,
      si192_tiporegistro integer NOT NULL,
      si192_publiclrf integer NOT NULL,
      si192_dtpublicacaorelatoriolrf date,
      si192_localpublicacao character varying(1000),
      si192_tpbimestre integer,
      si192_exerciciotpbimestre integer,
      si192_reg10 bigint DEFAULT 0 NOT NULL,
      si192_mes bigint DEFAULT 0 NOT NULL,
      si192_instit bigint DEFAULT 0 NOT NULL
  );


  ALTER TABLE dclrf302019 OWNER TO dbportal;

  --
  -- Name: dclrf302019_si178_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dclrf302019_si192_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dclrf302019_si192_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dclrf402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dclrf402019 (
      si193_sequencial bigint NOT NULL,
      si193_tiporegistro integer NOT NULL,
      si193_publicrgf integer NOT NULL,
      si193_dtpublicacaorgf date,
      si193_localpublicacaorgf character varying(1000),
      si193_tpperiodo integer,
      si193_exerciciotpperiodo integer,
      si193_reg10 bigint DEFAULT 0 NOT NULL,
      si193_mes bigint DEFAULT 0 NOT NULL,
      si193_instit bigint DEFAULT 0 NOT NULL
  );


  ALTER TABLE dclrf402019 OWNER TO dbportal;

  --
  -- Name: dclrf402019_si193_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dclrf402019_si193_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dclrf402019_si193_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ddc102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ddc102019 (
      si150_sequencial bigint DEFAULT 0 NOT NULL,
      si150_tiporegistro bigint DEFAULT 0 NOT NULL,
      si150_codorgao character varying(2) NOT NULL,
      si150_nroleiautorizacao character varying(6) DEFAULT '0'::character varying NOT NULL,
      si150_dtleiautorizacao date NOT NULL,
      si150_dtpublicacaoleiautorizacao date NOT NULL,
      si150_mes bigint DEFAULT 0 NOT NULL,
      si150_instit bigint DEFAULT 0
  );


  ALTER TABLE ddc102019 OWNER TO dbportal;

  --
  -- Name: ddc102019_si150_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ddc102019_si150_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ddc102019_si150_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ddc202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ddc202019 (
      si153_sequencial bigint DEFAULT 0 NOT NULL,
      si153_tiporegistro bigint DEFAULT 0 NOT NULL,
      si153_codorgao character varying(2) NOT NULL,
      si153_nrocontratodivida character varying(30) NOT NULL,
      si153_dtassinatura date NOT NULL,
      si153_contratodeclei bigint DEFAULT 0,
      si153_nroleiautorizacao character varying(6),
      si153_dtleiautorizacao date,
      si153_objetocontratodivida character varying(1000) NOT NULL,
      si153_especificacaocontratodivida character varying(500) NOT NULL,
      si153_mes bigint DEFAULT 0 NOT NULL,
      si153_instit bigint DEFAULT 0
  );


  ALTER TABLE ddc202019 OWNER TO dbportal;

  --
  -- Name: ddc202019_si153_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ddc202019_si153_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ddc202019_si153_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ddc302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ddc302019 (
      si154_sequencial bigint DEFAULT 0 NOT NULL,
      si154_tiporegistro bigint DEFAULT 0 NOT NULL,
      si154_codorgao character varying(2) NOT NULL,
      si154_nrocontratodivida character varying(30) DEFAULT '0'::character varying NOT NULL,
      si154_dtassinatura date NOT NULL,
      si154_tipolancamento character varying(2) NOT NULL,
      si154_subtipo character varying(1),
      si154_tipodocumentocredor bigint DEFAULT 0 NOT NULL,
      si154_nrodocumentocredor character varying(14) NOT NULL,
      si154_justificativacancelamento character varying(500),
      si154_vlsaldoanterior double precision DEFAULT 0 NOT NULL,
      si154_vlcontratacao double precision DEFAULT 0 NOT NULL,
      si154_vlamortizacao double precision DEFAULT 0 NOT NULL,
      si154_vlcancelamento double precision DEFAULT 0 NOT NULL,
      si154_vlencampacao double precision DEFAULT 0 NOT NULL,
      si154_vlatualizacao double precision DEFAULT 0 NOT NULL,
      si154_vlsaldoatual double precision DEFAULT 0 NOT NULL,
      si154_mes bigint DEFAULT 0 NOT NULL,
      si154_instit bigint DEFAULT 0
  );


  ALTER TABLE ddc302019 OWNER TO dbportal;

  --
  -- Name: ddc302019_si154_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ddc302019_si154_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ddc302019_si154_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ddc402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ddc402019 (
      si178_sequencial bigint DEFAULT 0 NOT NULL,
      si178_tiporegistro bigint DEFAULT 0 NOT NULL,
      si178_codorgao character varying(2) NOT NULL,
      si178_passivoatuarial bigint DEFAULT 0 NOT NULL,
      si178_vlsaldoanterior double precision DEFAULT 0 NOT NULL,
      si178_vlsaldoatual double precision DEFAULT 0,
      si178_mes bigint DEFAULT 0 NOT NULL,
      si178_instit bigint DEFAULT 0
  );


  ALTER TABLE ddc402019 OWNER TO dbportal;

  --
  -- Name: ddc402019_si178_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ddc402019_si178_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ddc402019_si178_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp1002019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp1002019 (
      si228_sequencial integer DEFAULT 0 NOT NULL,
      si228_tiporegistro integer DEFAULT 0 NOT NULL,
      si228_vlgeracaoliquidaequivalentecaixa double precision DEFAULT 0,
      si228_anousu integer DEFAULT 0 NOT NULL,
      si228_periodo integer DEFAULT 0 NOT NULL,
      si228_mes integer DEFAULT 0 NOT NULL,
      si228_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp1002019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp1002019_si228_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp1002019_si228_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp1002019_si228_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp102019 (
      si219_sequencial integer DEFAULT 0 NOT NULL,
      si219_tiporegistro integer DEFAULT 0 NOT NULL,
      si219_vlreceitaderivadaoriginaria double precision DEFAULT 0 NOT NULL,
      si219_vltranscorrenterecebida double precision DEFAULT 0 NOT NULL,
      si219_vloutrosingressosoperacionais double precision DEFAULT 0 NOT NULL,
      si219_vltotalingressosativoperacionais double precision DEFAULT 0,
      si219_anousu integer DEFAULT 0 NOT NULL,
      si219_periodo integer DEFAULT 0 NOT NULL,
      si219_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp102019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp102019_si219_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp102019_si219_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp102019_si219_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp1102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp1102019 (
      si229_sequencial integer DEFAULT 0 NOT NULL,
      si229_tiporegistro integer DEFAULT 0 NOT NULL,
      si229_vlcaixaequivalentecaixainicial double precision DEFAULT 0 NOT NULL,
      si229_vlcaixaequivalentecaixafinal double precision DEFAULT 0,
      si229_anousu integer DEFAULT 0 NOT NULL,
      si229_periodo integer DEFAULT 0 NOT NULL,
      si229_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp1102019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp1102019_si229_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp1102019_si229_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp1102019_si229_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp202019 (
      si220_sequencial integer DEFAULT 0 NOT NULL,
      si220_tiporegistro integer DEFAULT 0 NOT NULL,
      si220_vldesembolsopessoaldespesas double precision DEFAULT 0 NOT NULL,
      si220_vldesembolsojurosencargdivida double precision DEFAULT 0 NOT NULL,
      si220_vldesembolsotransfconcedidas double precision DEFAULT 0 NOT NULL,
      si220_vloutrosdesembolsos double precision DEFAULT 0 NOT NULL,
      si220_vltotaldesembolsosativoperacionais double precision DEFAULT 0,
      si220_anousu integer DEFAULT 0 NOT NULL,
      si220_periodo integer DEFAULT 0 NOT NULL,
      si220_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp202019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp202019_si220_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp202019_si220_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp202019_si220_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp302019 (
      si221_sequencial integer DEFAULT 0 NOT NULL,
      si221_tiporegistro integer DEFAULT 0 NOT NULL,
      si221_vlfluxocaixaliquidooperacional double precision DEFAULT 0,
      si221_anousu integer DEFAULT 0 NOT NULL,
      si221_periodo integer DEFAULT 0 NOT NULL,
      si221_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp302019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp302019_si221_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp302019_si221_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp302019_si221_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp402019 (
      si222_sequencial integer DEFAULT 0 NOT NULL,
      si222_tiporegistro integer DEFAULT 0 NOT NULL,
      si222_vlalienacaobens double precision DEFAULT 0 NOT NULL,
      si222_vlamortizacaoemprestimoconcedido double precision DEFAULT 0 NOT NULL,
      si222_vloutrosingressos double precision DEFAULT 0 NOT NULL,
      si222_vltotalingressosatividainvestiment double precision DEFAULT 0,
      si222_anousu integer DEFAULT 0 NOT NULL,
      si222_periodo integer DEFAULT 0 NOT NULL,
      si222_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp402019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp402019_si222_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp402019_si222_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp402019_si222_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp502019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp502019 (
      si223_sequencial integer DEFAULT 0 NOT NULL,
      si223_tiporegistro integer DEFAULT 0 NOT NULL,
      si223_vlaquisicaoativonaocirculante double precision DEFAULT 0 NOT NULL,
      si223_vlconcessaoempresfinanciamento double precision DEFAULT 0 NOT NULL,
      si223_vloutrosdesembolsos double precision DEFAULT 0 NOT NULL,
      si223_vltotaldesembolsoatividainvestimen double precision DEFAULT 0,
      si223_anousu integer DEFAULT 0 NOT NULL,
      si223_periodo integer DEFAULT 0 NOT NULL,
      si223_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp502019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp502019_si223_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp502019_si223_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp502019_si223_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp602019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp602019 (
      si224_sequencial integer DEFAULT 0 NOT NULL,
      si224_tiporegistro integer DEFAULT 0 NOT NULL,
      si224_vlfluxocaixaliquidoinvestimento double precision DEFAULT 0,
      si224_anousu integer DEFAULT 0 NOT NULL,
      si224_periodo integer DEFAULT 0 NOT NULL,
      si224_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp602019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp602019_si224_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp602019_si224_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp602019_si224_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp702019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp702019 (
      si225_sequencial integer DEFAULT 0 NOT NULL,
      si225_tiporegistro integer DEFAULT 0 NOT NULL,
      si225_vloperacoescredito double precision DEFAULT 0 NOT NULL,
      si225_vlintegralizacaodependentes double precision DEFAULT 0 NOT NULL,
      si225_vltranscapitalrecebida double precision DEFAULT 0 NOT NULL,
      si225_vloutrosingressosfinanciamento double precision DEFAULT 0 NOT NULL,
      si225_vltotalingressoatividafinanciament double precision DEFAULT 0,
      si225_anousu integer DEFAULT 0 NOT NULL,
      si225_periodo integer DEFAULT 0 NOT NULL,
      si225_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp702019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp702019_si225_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp702019_si225_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp702019_si225_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp802019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp802019 (
      si226_sequencial integer DEFAULT 0 NOT NULL,
      si226_tiporegistro integer DEFAULT 0 NOT NULL,
      si226_vlamortizacaorefinanciamento double precision DEFAULT 0 NOT NULL,
      si226_vloutrosdesembolsosfinanciamento double precision DEFAULT 0 NOT NULL,
      si226_vltotaldesembolsoatividafinanciame double precision DEFAULT 0,
      si226_anousu integer DEFAULT 0 NOT NULL,
      si226_periodo integer DEFAULT 0 NOT NULL,
      si226_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp802019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp802019_si226_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp802019_si226_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp802019_si226_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dfcdcasp902019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dfcdcasp902019 (
      si227_sequencial integer DEFAULT 0 NOT NULL,
      si227_tiporegistro integer DEFAULT 0 NOT NULL,
      si227_vlfluxocaixafinanciamento double precision DEFAULT 0,
      si227_anousu integer DEFAULT 0 NOT NULL,
      si227_periodo integer DEFAULT 0 NOT NULL,
      si227_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dfcdcasp902019 OWNER TO dbportal;

  --
  -- Name: dfcdcasp902019_si227_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dfcdcasp902019_si227_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dfcdcasp902019_si227_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa102019 (
      si74_sequencial bigint DEFAULT 0 NOT NULL,
      si74_tiporegistro bigint NOT NULL,
      si74_codorgaoresp character varying(2) NOT NULL,
      si74_codunidadesubresp character varying(8) NOT NULL,
      si74_exercicioprocesso bigint NOT NULL,
      si74_nroprocesso character varying(12) NOT NULL,
      si74_tipoprocesso bigint NOT NULL,
      si74_dtabertura date NOT NULL,
      si74_naturezaobjeto bigint NOT NULL,
      si74_objeto character varying(500) NOT NULL,
      si74_justificativa character varying(250) NOT NULL,
      si74_razao character varying(250) NOT NULL,
      si74_dtpublicacaotermoratificacao date NOT NULL,
      si74_veiculopublicacao character varying(50) NOT NULL,
      si74_processoporlote bigint NOT NULL,
      si74_mes bigint,
      si74_instit bigint
  );


  ALTER TABLE dispensa102019 OWNER TO dbportal;

  --
  -- Name: dispensa102019_si74_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa102019_si74_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa102019_si74_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa112019 (
      si75_sequencial bigint DEFAULT 0 NOT NULL,
      si75_tiporegistro bigint DEFAULT 0 NOT NULL,
      si75_codorgaoresp character varying(2) DEFAULT 0 NOT NULL,
      si75_codunidadesubresp character varying(8) NOT NULL,
      si75_exercicioprocesso bigint DEFAULT 0 NOT NULL,
      si75_nroprocesso character varying(12) NOT NULL,
      si75_tipoprocesso bigint DEFAULT 0 NOT NULL,
      si75_nrolote bigint DEFAULT 0 NOT NULL,
      si75_dsclote character varying(250) NOT NULL,
      si75_mes bigint,
      si75_reg10 bigint DEFAULT 0 NOT NULL,
      si75_instit bigint
  );


  ALTER TABLE dispensa112019 OWNER TO dbportal;

  --
  -- Name: dispensa112019_si75_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa112019_si75_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa112019_si75_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa122019 (
      si76_sequencial bigint DEFAULT 0 NOT NULL,
      si76_tiporegistro bigint DEFAULT 0 NOT NULL,
      si76_codorgaoresp character varying(2) NOT NULL,
      si76_codunidadesubresp character varying(8) NOT NULL,
      si76_exercicioprocesso bigint DEFAULT 0 NOT NULL,
      si76_nroprocesso character varying(12) NOT NULL,
      si76_tipoprocesso bigint NOT NULL,
      si76_coditem bigint DEFAULT 0 NOT NULL,
      si76_nroitem bigint DEFAULT 0 NOT NULL,
      si76_mes bigint NOT NULL,
      si76_reg10 bigint DEFAULT 0 NOT NULL,
      si76_instit bigint NOT NULL
  );


  ALTER TABLE dispensa122019 OWNER TO dbportal;

  --
  -- Name: dispensa122019_si76_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa122019_si76_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa122019_si76_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa132019 (
      si77_sequencial bigint DEFAULT 0 NOT NULL,
      si77_tiporegistro bigint DEFAULT 0 NOT NULL,
      si77_codorgaoresp character varying(2) NOT NULL,
      si77_codunidadesubresp character varying(8) NOT NULL,
      si77_exercicioprocesso bigint NOT NULL,
      si77_nroprocesso character varying(12) NOT NULL,
      si77_tipoprocesso bigint NOT NULL,
      si77_nrolote bigint NOT NULL,
      si77_coditem bigint NOT NULL,
      si77_mes bigint NOT NULL,
      si77_reg10 bigint DEFAULT 0 NOT NULL,
      si77_instit bigint NOT NULL
  );


  ALTER TABLE dispensa132019 OWNER TO dbportal;

  --
  -- Name: dispensa132019_si77_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa132019_si77_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa132019_si77_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa142019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa142019 (
      si78_sequencial bigint DEFAULT 0 NOT NULL,
      si78_tiporegistro bigint NOT NULL,
      si78_codorgaoresp character varying(2) NOT NULL,
      si78_codunidadesubres character varying(8) NOT NULL,
      si78_exercicioprocesso bigint NOT NULL,
      si78_nroprocesso character varying(12) NOT NULL,
      si78_tipoprocesso bigint NOT NULL,
      si78_tiporesp bigint NOT NULL,
      si78_nrocpfresp character varying(11) NOT NULL,
      si78_mes bigint,
      si78_reg10 bigint DEFAULT 0 NOT NULL,
      si78_instit bigint
  );


  ALTER TABLE dispensa142019 OWNER TO dbportal;

  --
  -- Name: dispensa142019_si78_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa142019_si78_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa142019_si78_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa152019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa152019 (
      si79_sequencial bigint DEFAULT 0 NOT NULL,
      si79_tiporegistro bigint DEFAULT 0 NOT NULL,
      si79_codorgaoresp character varying(2) NOT NULL,
      si79_codunidadesubresp character varying(8) NOT NULL,
      si79_exercicioprocesso bigint NOT NULL,
      si79_nroprocesso character varying(12) NOT NULL,
      si79_tipoprocesso bigint NOT NULL,
      si79_nrolote bigint,
      si79_coditem bigint NOT NULL,
      si79_vlcotprecosunitario double precision NOT NULL,
      si79_quantidade double precision NOT NULL,
      si79_mes bigint,
      si79_reg10 bigint DEFAULT 0 NOT NULL,
      si79_instit bigint
  );


  ALTER TABLE dispensa152019 OWNER TO dbportal;

  --
  -- Name: dispensa152019_si79_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa152019_si79_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa152019_si79_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa162019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa162019 (
      si80_sequencial bigint DEFAULT 0 NOT NULL,
      si80_tiporegistro bigint NOT NULL,
      si80_codorgaoresp character varying(2) NOT NULL,
      si80_codunidadesubresp character varying(8) NOT NULL,
      si80_exercicioprocesso bigint NOT NULL,
      si80_nroprocesso character varying(12) NOT NULL,
      si80_tipoprocesso bigint NOT NULL,
      si80_codorgao character varying(2) NOT NULL,
      si80_codunidadesub character varying(8) NOT NULL,
      si80_codfuncao character varying(2) NOT NULL,
      si80_codsubfuncao character varying(3) NOT NULL,
      si80_codprograma character varying(4) NOT NULL,
      si80_idacao character varying(4) NOT NULL,
      si80_idsubacao character varying(4),
      si80_naturezadespesa bigint NOT NULL,
      si80_codfontrecursos bigint NOT NULL,
      si80_vlrecurso double precision NOT NULL,
      si80_mes bigint,
      si80_reg10 bigint DEFAULT 0 NOT NULL,
      si80_instit bigint
  );


  ALTER TABLE dispensa162019 OWNER TO dbportal;

  --
  -- Name: dispensa162019_si80_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa162019_si80_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa162019_si80_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa172019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa172019 (
      si81_sequencial bigint DEFAULT 0 NOT NULL,
      si81_tiporegistro bigint DEFAULT 0 NOT NULL,
      si81_codorgaoresp character varying(2) NOT NULL,
      si81_codunidadesubresp character varying(8) NOT NULL,
      si81_exercicioprocesso bigint DEFAULT 0 NOT NULL,
      si81_nroprocesso character varying(12) NOT NULL,
      si81_tipoprocesso bigint DEFAULT 0 NOT NULL,
      si81_tipodocumento bigint DEFAULT 0 NOT NULL,
      si81_nrodocumento character varying(14) NOT NULL,
      si81_nroinscricaoestadual character varying(30),
      si81_ufinscricaoestadual character varying(2),
      si81_nrocertidaoregularidadeinss character varying(30),
      si81_dtemissaocertidaoregularidadeinss date,
      si81_dtvalidadecertidaoregularidadeinss date,
      si81_nrocertidaoregularidadefgts character varying(30),
      si81_dtemissaocertidaoregularidadefgts date,
      si81_dtvalidadecertidaoregularidadefgts date,
      si81_nrocndt character varying(30),
      si81_dtemissaocndt date,
      si81_dtvalidadecndt date,
      si81_nrolote bigint DEFAULT 0,
      si81_coditem bigint DEFAULT 0 NOT NULL,
      si81_quantidade double precision DEFAULT 0 NOT NULL,
      si81_vlitem double precision DEFAULT 0 NOT NULL,
      si81_mes bigint DEFAULT 0 NOT NULL,
      si81_reg10 bigint DEFAULT 0 NOT NULL,
      si81_instit bigint DEFAULT 0
  );


  ALTER TABLE dispensa172019 OWNER TO dbportal;

  --
  -- Name: dispensa172019_si81_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa172019_si81_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa172019_si81_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dispensa182019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dispensa182019 (
      si82_sequencial bigint DEFAULT 0 NOT NULL,
      si82_tiporegistro bigint DEFAULT 0 NOT NULL,
      si82_codorgaoresp character varying(2) NOT NULL,
      si82_codunidadesubresp character varying(8) NOT NULL,
      si82_exercicioprocesso bigint DEFAULT 0 NOT NULL,
      si82_nroprocesso character varying(12) NOT NULL,
      si82_tipoprocesso bigint DEFAULT 0 NOT NULL,
      si82_tipodocumento bigint DEFAULT 0 NOT NULL,
      si82_nrodocumento character varying(14) NOT NULL,
      si82_datacredenciamento date NOT NULL,
      si82_nrolote bigint DEFAULT 0,
      si82_coditem bigint DEFAULT 0 NOT NULL,
      si82_nroinscricaoestadual character varying(30),
      si82_ufinscricaoestadual character varying(2),
      si82_nrocertidaoregularidadeinss character varying(30),
      si82_dataemissaocertidaoregularidadeinss date,
      si82_dtvalidadecertidaoregularidadeinss date,
      si82_nrocertidaoregularidadefgts character varying(30),
      si82_dtemissaocertidaoregularidadefgts date,
      si82_dtvalidadecertidaoregularidadefgts date,
      si82_nrocndt character varying(30),
      si82_dtemissaocndt date,
      si82_dtvalidadecndt date,
      si82_mes bigint DEFAULT 0 NOT NULL,
      si82_reg10 bigint DEFAULT 0 NOT NULL,
      si82_instit bigint DEFAULT 0
  );


  ALTER TABLE dispensa182019 OWNER TO dbportal;

  --
  -- Name: dispensa182019_si82_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dispensa182019_si82_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dispensa182019_si82_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dvpdcasp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dvpdcasp102019 ( --todo rever tabela
      si216_sequencial integer DEFAULT 0 NOT NULL,
      si216_tiporegistro integer DEFAULT 0 NOT NULL,
      si216_vlimpostos double precision DEFAULT 0 NOT NULL,
      si216_vlcontribuicoes double precision DEFAULT 0 NOT NULL,
      si216_vlexploracovendasdireitos double precision DEFAULT 0 NOT NULL,
      si216_vlvariacoesaumentativasfinanceiras double precision DEFAULT 0 NOT NULL,
      si216_vltransfdelegacoesrecebidas double precision DEFAULT 0 NOT NULL,
      si216_vlvalorizacaoativodesincorpassivo double precision DEFAULT 0 NOT NULL,
      si216_vloutrasvariacoespatriaumentativas double precision DEFAULT 0 NOT NULL,
      si216_vltotalvpaumentativas double precision DEFAULT 0,
      si216_ano integer DEFAULT 0 NOT NULL,
      si216_periodo integer DEFAULT 0 NOT NULL,
      si216_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dvpdcasp102019 OWNER TO dbportal;

  --
  -- Name: dvpdcasp102019_si216_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dvpdcasp102019_si216_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dvpdcasp102019_si216_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dvpdcasp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dvpdcasp202019 (
      si217_sequencial integer DEFAULT 0 NOT NULL,
      si217_tiporegistro integer DEFAULT 0 NOT NULL,
--       si217_exercicio integer DEFAULT 0 NOT NULL,
      si217_vldiminutivapessoaencargos double precision DEFAULT 0 NOT NULL,
      si217_vlprevassistenciais double precision DEFAULT 0 NOT NULL,
      si217_vlservicoscapitalfixo double precision DEFAULT 0 NOT NULL,
      si217_vldiminutivavariacoesfinanceiras double precision DEFAULT 0 NOT NULL,
      si217_vltransfconcedidas double precision DEFAULT 0 NOT NULL,
      si217_vldesvaloativoincorpopassivo double precision DEFAULT 0 NOT NULL,
      si217_vltributarias double precision DEFAULT 0 NOT NULL,
      si217_vlmercadoriavendidoservicos double precision DEFAULT 0 NOT NULL,
      si217_vloutrasvariacoespatridiminutivas double precision DEFAULT 0 NOT NULL,
      si217_vltotalvpdiminutivas double precision DEFAULT 0,
      si217_ano integer DEFAULT 0 NOT NULL,
      si217_periodo integer DEFAULT 0 NOT NULL,
      si217_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dvpdcasp202019 OWNER TO dbportal;

  --
  -- Name: dvpdcasp202019_si217_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dvpdcasp202019_si217_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dvpdcasp202019_si217_sequencial_seq OWNER TO dbportal;

  --
  -- Name: dvpdcasp302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE dvpdcasp302019 (
      si218_sequencial integer DEFAULT 0 NOT NULL,
      si218_tiporegistro integer DEFAULT 0 NOT NULL,
--       si218_exercicio integer DEFAULT 0 NOT NULL,
      si218_vlresultadopatrimonialperiodo double precision DEFAULT 0,
      si218_ano integer DEFAULT 0 NOT NULL,
      si218_periodo integer DEFAULT 0 NOT NULL,
      si218_institu integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE dvpdcasp302019 OWNER TO dbportal;

  --
  -- Name: dvpdcasp302019_si218_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE dvpdcasp302019_si218_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE dvpdcasp302019_si218_sequencial_seq OWNER TO dbportal;

  --
  -- Name: emp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE emp102019 (
      si106_sequencial bigint DEFAULT 0 NOT NULL,
      si106_tiporegistro bigint DEFAULT 0 NOT NULL,
      si106_codorgao character varying(2) NOT NULL,
      si106_codunidadesub character varying(8) NOT NULL,
      si106_codfuncao character varying(2) NOT NULL,
      si106_codsubfuncao character varying(3) NOT NULL,
      si106_codprograma character varying(4) NOT NULL,
      si106_idacao character varying(4) NOT NULL,
      si106_idsubacao character varying(4),
      si106_naturezadespesa bigint DEFAULT 0 NOT NULL,
      si106_subelemento character varying(2) NOT NULL,
      si106_nroempenho bigint DEFAULT 0 NOT NULL,
      si106_dtempenho date NOT NULL,
      si106_modalidadeempenho bigint DEFAULT 0 NOT NULL,
      si106_tpempenho character varying(2) NOT NULL,
      si106_vlbruto double precision DEFAULT 0 NOT NULL,
      si106_especificacaoempenho character varying(500) NOT NULL,
      si106_despdeccontrato bigint DEFAULT 0 NOT NULL,
      si106_codorgaorespcontrato character varying(2),
      si106_codunidadesubrespcontrato character varying(8),
      si106_nrocontrato bigint DEFAULT 0,
      si106_dtassinaturacontrato date,
      si106_nrosequencialtermoaditivo character varying(2),
      si106_despdecconvenio bigint DEFAULT 0 NOT NULL,
      si106_nroconvenio character varying(30),
      si106_dataassinaturaconvenio date,
      si106_despdecconvenioconge bigint DEFAULT 0 NOT NULL,
      si106_nroconvenioconge character varying(30),
      si106_dataassinaturaconvenioconge date,
      si106_despdeclicitacao bigint DEFAULT 0 NOT NULL,
      si106_codorgaoresplicit character varying(2),
      si106_codunidadesubresplicit character varying(8),
      si106_nroprocessolicitatorio character varying(12),
      si106_exercicioprocessolicitatorio bigint DEFAULT 0,
      si106_tipoprocesso bigint DEFAULT 0,
      si106_cpfordenador character varying(11) NOT NULL,
      si106_tipodespesaemprpps bigint DEFAULT 0,
      si106_mes bigint DEFAULT 0 NOT NULL,
      si106_instit bigint DEFAULT 0
  );


  ALTER TABLE emp102019 OWNER TO dbportal;

  --
  -- Name: emp102019_si106_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE emp102019_si106_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE emp102019_si106_sequencial_seq OWNER TO dbportal;

  --
  -- Name: emp112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE emp112019 (
      si107_sequencial bigint DEFAULT 0 NOT NULL,
      si107_tiporegistro bigint DEFAULT 0 NOT NULL,
      si107_codunidadesub character varying(8) NOT NULL,
      si107_nroempenho bigint DEFAULT 0 NOT NULL,
      si107_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si107_valorfonte double precision DEFAULT 0 NOT NULL,
      si107_mes bigint DEFAULT 0 NOT NULL,
      si107_reg10 bigint DEFAULT 0 NOT NULL,
      si107_instit bigint DEFAULT 0
  );


  ALTER TABLE emp112019 OWNER TO dbportal;

  --
  -- Name: emp112019_si107_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE emp112019_si107_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE emp112019_si107_sequencial_seq OWNER TO dbportal;

  --
  -- Name: emp122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE emp122019 (
      si108_sequencial bigint DEFAULT 0 NOT NULL,
      si108_tiporegistro bigint DEFAULT 0 NOT NULL,
      si108_codunidadesub character varying(8) NOT NULL,
      si108_nroempenho bigint DEFAULT 0 NOT NULL,
      si108_tipodocumento bigint DEFAULT 0 NOT NULL,
      si108_nrodocumento character varying(14) NOT NULL,
      si108_mes bigint DEFAULT 0 NOT NULL,
      si108_reg10 bigint DEFAULT 0 NOT NULL,
      si108_instit bigint DEFAULT 0
  );


  ALTER TABLE emp122019 OWNER TO dbportal;

  --
  -- Name: emp122019_si108_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE emp122019_si108_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE emp122019_si108_sequencial_seq OWNER TO dbportal;

  --
  -- Name: emp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE emp202019 (
      si109_sequencial bigint DEFAULT 0 NOT NULL,
      si109_tiporegistro bigint DEFAULT 0 NOT NULL,
      si109_codorgao character varying(2) NOT NULL,
      si109_codunidadesub character varying(8) NOT NULL,
      si109_nroempenho bigint DEFAULT 0 NOT NULL,
      si109_dtempenho date NOT NULL,
      si109_nroreforco bigint DEFAULT 0 NOT NULL,
      si109_dtreforco date NOT NULL,
      si109_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si109_vlreforco double precision DEFAULT 0 NOT NULL,
      si109_mes bigint DEFAULT 0 NOT NULL,
      si109_instit bigint DEFAULT 0
  );


  ALTER TABLE emp202019 OWNER TO dbportal;

  --
  -- Name: emp202019_si109_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE emp202019_si109_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE emp202019_si109_sequencial_seq OWNER TO dbportal;

  --
  -- Name: emp302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE emp302019 ( -- todo rever sequencial da tabela
      si206_sequencial bigint DEFAULT 0 NOT NULL,
      si206_tiporegistro bigint DEFAULT 0 NOT NULL,
      si206_codorgao character varying(2) NOT NULL,
      si206_codunidadesub character varying(8) NOT NULL,
      si206_nroempenho bigint DEFAULT 0 NOT NULL,
      si206_dtempenho date NOT NULL,
      si206_codorgaorespcontrato character varying(2) DEFAULT NULL,
      si206_codunidadesubrespcontrato character varying(8) DEFAULT NULL,
      si206_nrocontrato bigint DEFAULT 0,
      si206_dtassinaturacontrato date DEFAULT NULL,
      si206_nrosequencialtermoaditivo bigint DEFAULT 0,
      si206_nroconvenio character varying(30) DEFAULT NULL,
      si206_dtassinaturaconvenio date DEFAULT NULL,
      si206_nroconvenioconge character varying(30) DEFAULT NULL,
      si206_dtassinaturaconge date DEFAULT NULL,
      si206_mes bigint DEFAULT 0 NOT NULL,
      si206_instit bigint DEFAULT 0
  );


  ALTER TABLE emp302019 OWNER TO dbportal;

  --
  -- Name: emp302019_si206_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE emp302019_si206_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE emp302019_si206_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ext102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ext102019 (
      si124_sequencial bigint DEFAULT 0 NOT NULL,
      si124_tiporegistro bigint DEFAULT 0 NOT NULL,
      si124_codext bigint DEFAULT 0 NOT NULL,
      si124_codorgao character varying(2) NOT NULL,
      si124_tipolancamento character varying(2) NOT NULL,
      si124_subtipo character varying(4) NOT NULL,
      si124_desdobrasubtipo character varying(4),
      si124_descextraorc character varying(50) NOT NULL,
      si124_mes bigint DEFAULT 0 NOT NULL,
      si124_instit bigint DEFAULT 0
  );


  ALTER TABLE ext102019 OWNER TO dbportal;

  --
  -- Name: ext102019_si124_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ext102019_si124_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ext102019_si124_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ext202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ext202019 (
      si165_sequencial bigint DEFAULT 0 NOT NULL,
      si165_tiporegistro bigint DEFAULT 0 NOT NULL,
      si165_codorgao character varying(2) NOT NULL,
      si165_codext bigint DEFAULT 0 NOT NULL,
      si165_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si165_vlsaldoanteriorfonte double precision DEFAULT 0 NOT NULL,
      si165_natsaldoanteriorfonte character varying(1) NOT NULL,
      si165_totaldebitos double precision DEFAULT 0 NOT NULL,
      si165_totalcreditos double precision DEFAULT 0 NOT NULL,
      si165_vlsaldoatualfonte double precision DEFAULT 0 NOT NULL,
      si165_natsaldoatualfonte character varying(1) NOT NULL,
      si165_mes bigint DEFAULT 0 NOT NULL,
      si165_instit bigint DEFAULT 0
  );


  ALTER TABLE ext202019 OWNER TO dbportal;

  --
  -- Name: ext202019_si165_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ext202019_si165_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ext202019_si165_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ext302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ext302019 (
      si126_sequencial bigint DEFAULT 0 NOT NULL,
      si126_tiporegistro bigint DEFAULT 0 NOT NULL,
      si126_codext bigint DEFAULT 0 NOT NULL,
      si126_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si126_codreduzidoop bigint DEFAULT 0 NOT NULL,
      si126_nroop bigint DEFAULT 0 NOT NULL,
      si126_codunidadesub character varying(8) NOT NULL,
      si126_dtpagamento date NOT NULL,
      si126_tipodocumentocredor bigint DEFAULT 0,
      si126_nrodocumentocredor character varying(14),
      si126_vlop double precision DEFAULT 0 NOT NULL,
      si126_especificacaoop character varying(500) NOT NULL,
      si126_cpfresppgto character varying(11) NOT NULL,
      si126_mes bigint DEFAULT 0 NOT NULL,
      si126_instit bigint DEFAULT 0
  );


  ALTER TABLE ext302019 OWNER TO dbportal;

  --
  -- Name: ext302019_si126_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ext302019_si126_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ext302019_si126_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ext312019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ext312019 (
      si127_sequencial bigint DEFAULT 0 NOT NULL,
      si127_tiporegistro bigint DEFAULT 0 NOT NULL,
      si127_codreduzidoop bigint DEFAULT 0 NOT NULL,
      si127_tipodocumentoop character varying(2) NOT NULL,
      si127_nrodocumento character varying(15),
      si127_codctb bigint DEFAULT 0,
      si127_codfontectb bigint DEFAULT 0,
      si127_desctipodocumentoop character varying(50),
      si127_dtemissao date NOT NULL,
      si127_vldocumento double precision DEFAULT 0 NOT NULL,
      si127_mes bigint DEFAULT 0 NOT NULL,
      si127_reg30 bigint DEFAULT 0 NOT NULL,
      si127_instit bigint DEFAULT 0 NOT NULL
  );


  ALTER TABLE ext312019 OWNER TO dbportal;

  --
  -- Name: ext312019_si127_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ext312019_si127_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ext312019_si127_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ext322019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ext322019 (
      si128_sequencial bigint DEFAULT 0 NOT NULL,
      si128_tiporegistro bigint DEFAULT 0 NOT NULL,
      si128_codreduzidoop bigint DEFAULT 0 NOT NULL,
      si128_tiporetencao character varying(4) NOT NULL,
      si128_descricaoretencao character varying(50),
      si128_vlretencao double precision DEFAULT 0 NOT NULL,
      si128_mes bigint DEFAULT 0 NOT NULL,
      si128_reg30 bigint DEFAULT 0,
      si128_instit bigint DEFAULT 0
  );


  ALTER TABLE ext322019 OWNER TO dbportal;

  --
  -- Name: ext322019_si128_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ext322019_si128_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ext322019_si128_sequencial_seq OWNER TO dbportal;

  --
  -- Name: hablic102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE hablic102019 (
      si57_sequencial bigint DEFAULT 0 NOT NULL,
      si57_tiporegistro bigint DEFAULT 0 NOT NULL,
      si57_codorgao character varying(2) NOT NULL,
      si57_codunidadesub character varying(8) NOT NULL,
      si57_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si57_nroprocessolicitatorio character varying(12) NOT NULL,
      si57_tipodocumento bigint DEFAULT 0 NOT NULL,
      si57_nrodocumento character varying(14) NOT NULL,
      si57_objetosocial character varying(2000),
      si57_orgaorespregistro bigint DEFAULT 0,
      si57_dataregistro date,
      si57_nroregistro character varying(20),
      si57_dataregistrocvm date,
      si57_nroregistrocvm character varying(20),
      si57_nroinscricaoestadual character varying(30),
      si57_ufinscricaoestadual character varying(2),
      si57_nrocertidaoregularidadeinss character varying(30),
      si57_dtemissaocertidaoregularidadeinss date,
      si57_dtvalidadecertidaoregularidadeinss date,
      si57_nrocertidaoregularidadefgts character varying(30),
      si57_dtemissaocertidaoregularidadefgts date,
      si57_dtvalidadecertidaoregularidadefgts date,
      si57_nrocndt character varying(30),
      si57_dtemissaocndt date,
      si57_dtvalidadecndt date,
      si57_dthabilitacao date NOT NULL,
      si57_presencalicitantes bigint DEFAULT 0 NOT NULL,
      si57_renunciarecurso bigint DEFAULT 0 NOT NULL,
      si57_mes bigint DEFAULT 0 NOT NULL,
      si57_instit bigint DEFAULT 0
  );


  ALTER TABLE hablic102019 OWNER TO dbportal;

  --
  -- Name: hablic102019_si57_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE hablic102019_si57_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE hablic102019_si57_sequencial_seq OWNER TO dbportal;

  --
  -- Name: hablic112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE hablic112019 (
      si58_sequencial bigint DEFAULT 0 NOT NULL,
      si58_tiporegistro bigint DEFAULT 0 NOT NULL,
      si58_codorgao character varying(2) NOT NULL,
      si58_codunidadesub character varying(8) NOT NULL,
      si58_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si58_nroprocessolicitatorio character varying(12) NOT NULL,
      si58_tipodocumentocnpjempresahablic bigint DEFAULT 0 NOT NULL,
      si58_cnpjempresahablic character varying(14) NOT NULL,
      si58_tipodocumentosocio bigint DEFAULT 0 NOT NULL,
      si58_nrodocumentosocio character varying(14) NOT NULL,
      si58_tipoparticipacao bigint DEFAULT 0 NOT NULL,
      si58_mes bigint DEFAULT 0 NOT NULL,
      si58_reg10 bigint DEFAULT 0 NOT NULL,
      si58_instit bigint DEFAULT 0
  );


  ALTER TABLE hablic112019 OWNER TO dbportal;

  --
  -- Name: hablic112019_si58_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE hablic112019_si58_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE hablic112019_si58_sequencial_seq OWNER TO dbportal;

  --
  -- Name: hablic202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE hablic202019 (
      si59_sequencial bigint DEFAULT 0 NOT NULL,
      si59_tiporegistro bigint DEFAULT 0 NOT NULL,
      si59_codorgao character varying(2) NOT NULL,
      si59_codunidadesub character varying(8),
      si59_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si59_nroprocessolicitatorio character varying(12) NOT NULL,
      si59_tipodocumento bigint DEFAULT 0 NOT NULL,
      si59_nrodocumento character varying(14) NOT NULL,
      si59_datacredenciamento date NOT NULL,
      si59_nrolote bigint DEFAULT 0,
      si59_coditem bigint DEFAULT 0 NOT NULL,
      si59_nroinscricaoestadual character varying(30),
      si59_ufinscricaoestadual character varying(2),
      si59_nrocertidaoregularidadeinss character varying(30),
      si59_dataemissaocertidaoregularidadeinss date,
      si59_dtvalidadecertidaoregularidadeinss date,
      si59_nrocertidaoregularidadefgts character varying(30),
      si59_dtemissaocertidaoregularidadefgts date,
      si59_dtvalidadecertidaoregularidadefgts date,
      si59_nrocndt character varying(30),
      si59_dtemissaocndt date,
      si59_dtvalidadecndt date,
      si59_mes bigint DEFAULT 0 NOT NULL,
      si59_instit bigint DEFAULT 0
  );


  ALTER TABLE hablic202019 OWNER TO dbportal;

  --
  -- Name: hablic202019_si59_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE hablic202019_si59_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE hablic202019_si59_sequencial_seq OWNER TO dbportal;

  --
  -- Name: homolic102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE homolic102019(
      si63_sequencial bigint DEFAULT 0 NOT NULL,
      si63_tiporegistro bigint DEFAULT 0 NOT NULL,
      si63_codorgao character varying(2) NOT NULL,
      si63_codunidadesub character varying(8) NOT NULL,
      si63_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si63_nroprocessolicitatorio character varying(12) NOT NULL,
      si63_tipodocumento bigint DEFAULT 0 NOT NULL,
      si63_nrodocumento character varying(14) NOT NULL,
      si63_nrolote bigint DEFAULT 0,
      si63_coditem bigint DEFAULT 0 NOT NULL,
      si63_quantidade double precision DEFAULT 0 NOT NULL,
      si63_vlunitariohomologado double precision DEFAULT 0 NOT NULL,
      si63_mes bigint DEFAULT 0 NOT NULL,
      si63_instit bigint DEFAULT 0
  );


  ALTER TABLE homolic102019 OWNER TO dbportal;

  --
  -- Name: homolic102019_si63_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE homolic102019_si63_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE homolic102019_si63_sequencial_seq OWNER TO dbportal;

  --
  -- Name: homolic202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE homolic202019 (
      si64_sequencial bigint DEFAULT 0 NOT NULL,
      si64_tiporegistro bigint DEFAULT 0 NOT NULL,
      si64_codorgao character varying(2) NOT NULL,
      si64_codunidadesub character varying(8) NOT NULL,
      si64_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si64_nroprocessolicitatorio character varying(12) NOT NULL,
      si64_tipodocumento bigint DEFAULT 0 NOT NULL,
      si64_nrodocumento character varying(14) NOT NULL,
      si64_nrolote bigint DEFAULT 0,
      si64_coditem character varying(15),
      si64_percdesconto double precision DEFAULT 0 NOT NULL,
      si64_mes bigint DEFAULT 0 NOT NULL,
      si64_instit bigint DEFAULT 0
  );


  ALTER TABLE homolic202019 OWNER TO dbportal;

  --
  -- Name: homolic202019_si64_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE homolic202019_si64_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE homolic202019_si64_sequencial_seq OWNER TO dbportal;

  --
  -- Name: homolic302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE homolic302019 (
      si65_sequencial bigint DEFAULT 0 NOT NULL,
      si65_tiporegistro bigint DEFAULT 0 NOT NULL,
      si65_codorgao character varying(2) NOT NULL,
      si65_codunidadesub character varying(8) NOT NULL,
      si65_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si65_nroprocessolicitatorio character varying(12) NOT NULL,
      si65_tipodocumento bigint DEFAULT 0 NOT NULL,
      si65_nrodocumento character varying(14) NOT NULL,
      si65_nrolote bigint DEFAULT 0,
      si65_coditem character varying(15),
      si65_perctaxaadm double precision DEFAULT 0 NOT NULL,
      si65_mes bigint DEFAULT 0 NOT NULL,
      si65_instit bigint DEFAULT 0
  );


  ALTER TABLE homolic302019 OWNER TO dbportal;

  --
  -- Name: homolic302019_si65_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE homolic302019_si65_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE homolic302019_si65_sequencial_seq OWNER TO dbportal;

  --
  -- Name: homolic402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE homolic402019 (
      si65_sequencial bigint DEFAULT 0 NOT NULL,
      si65_tiporegistro bigint DEFAULT 0 NOT NULL,
      si65_codorgao character varying(2) NOT NULL,
      si65_codunidadesub character varying(8),
      si65_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si65_nroprocessolicitatorio character varying(12) NOT NULL,
      si65_dthomologacao date NOT NULL,
      si65_dtadjudicacao date,
      si65_mes bigint DEFAULT 0 NOT NULL,
      si65_instit bigint DEFAULT 0
  );


  ALTER TABLE homolic402019 OWNER TO dbportal;

  --
  -- Name: homolic402019_si65_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE homolic402019_si65_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE homolic402019_si65_sequencial_seq OWNER TO dbportal;

  --
  -- Name: idedcasp2019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE idedcasp2019 (
      si200_sequencial integer DEFAULT 0 NOT NULL,
      si200_codmunicipio character varying(5) NOT NULL,
      si200_cnpjorgao character varying(14) NOT NULL,
      si200_codorgao character varying(2) NOT NULL,
      si200_tipoorgao character varying(2) NOT NULL,
      si200_tipodemcontabil integer DEFAULT 0 NOT NULL,
      si200_exercicioreferencia integer DEFAULT 0 NOT NULL,
      si200_datageracao date NOT NULL,
      si200_codcontroleremessa character varying(20),
      si200_anousu integer DEFAULT 0 NOT NULL,
      si200_instit integer DEFAULT 0 NOT NULL
  );


  ALTER TABLE idedcasp2019 OWNER TO dbportal;

  --
  -- Name: idedcasp2019_si200_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE idedcasp2019_si200_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE idedcasp2019_si200_sequencial_seq OWNER TO dbportal;

  --
  -- Name: incamp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE incamp102019 (
  --     si160_sequencial bigint DEFAULT 0 NOT NULL,
  --     si160_tiporegistro bigint DEFAULT 0 NOT NULL,
  --     si160_possuisubacao bigint DEFAULT 0 NOT NULL,
  --     si160_idacao character varying(4) NOT NULL,
  --     si160_descacao character varying(200) NOT NULL,
  --     si160_finalidadeacao character varying(500) NOT NULL,
  --     si160_produto character varying(50),
  --     si160_unidademedida character varying(15),
  --     si160_metas1ano double precision DEFAULT 0 NOT NULL,
  --     si160_metas2ano double precision DEFAULT 0 NOT NULL,
  --     si160_metas3ano double precision DEFAULT 0 NOT NULL,
  --     si160_metas4ano double precision DEFAULT 0 NOT NULL,
  --     si160_recursos1ano double precision DEFAULT 0 NOT NULL,
  --     si160_recursos2ano double precision DEFAULT 0 NOT NULL,
  --     si160_recursos3ano double precision DEFAULT 0 NOT NULL,
  --     si160_recursos4ano double precision DEFAULT 0 NOT NULL,
  --     si160_mes bigint DEFAULT 0 NOT NULL,
  --     si160_instit bigint DEFAULT 0
  -- );


  -- ALTER TABLE incamp102019 OWNER TO dbportal;

  -- --
  -- -- Name: incamp102019_si160_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  -- --

  -- CREATE SEQUENCE incamp102019_si160_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE incamp102019_si160_sequencial_seq OWNER TO dbportal;

  --
  -- Name: incamp112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE incamp112019 (
  --     si161_sequencial bigint DEFAULT 0 NOT NULL,
  --     si161_tiporegistro bigint DEFAULT 0 NOT NULL,
  --     si161_idacao character varying(4) NOT NULL,
  --     si161_idsubacao character varying(4) NOT NULL,
  --     si161_descdubacao character varying(200) NOT NULL,
  --     si161_finalidadesubacao character varying(500) NOT NULL,
  --     si161_produtosubacao character varying(50) NOT NULL,
  --     si161_unidademedida character varying(15) NOT NULL,
  --     si161_metas1ano double precision DEFAULT 0 NOT NULL,
  --     si161_metas2ano double precision DEFAULT 0 NOT NULL,
  --     si161_metas3ano double precision DEFAULT 0 NOT NULL,
  --     si161_metas4ano double precision DEFAULT 0 NOT NULL,
  --     si161_recursos1ano double precision DEFAULT 0 NOT NULL,
  --     si161_recursos2ano double precision DEFAULT 0 NOT NULL,
  --     si161_recursos3ano double precision DEFAULT 0 NOT NULL,
  --     si161_recursos4ano double precision DEFAULT 0 NOT NULL,
  --     si161_mes bigint DEFAULT 0 NOT NULL,
  --     si161_reg10 bigint DEFAULT 0 NOT NULL,
  --     si161_instit bigint DEFAULT 0
  -- );


  -- ALTER TABLE incamp112019 OWNER TO dbportal;

  --
  -- Name: incamp112019_si161_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  -- CREATE SEQUENCE incamp112019_si161_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE incamp112019_si161_sequencial_seq OWNER TO dbportal;

  --
  -- Name: incamp122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE incamp122019 (
  --     si162_sequencial bigint DEFAULT 0 NOT NULL,
  --     si162_tiporegistro bigint DEFAULT 0 NOT NULL,
  --     si162_codprograma character varying(4) NOT NULL,
  --     si162_idacao character varying(4) NOT NULL,
  --     si162_codorgao character varying(2) NOT NULL,
  --     si1162_codunidadesub character varying(8) NOT NULL,
  --     si162_codfuncao character varying(2) NOT NULL,
  --     si162_codsubfuncao character varying(3) NOT NULL,
  --     si162_mes bigint DEFAULT 0 NOT NULL,
  --     si162_reg10 bigint DEFAULT 0 NOT NULL,
  --     si162_instit bigint DEFAULT 0
  -- );


  -- ALTER TABLE incamp122019 OWNER TO dbportal;

  --
  -- Name: incamp122019_si162_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  -- CREATE SEQUENCE incamp122019_si162_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE incamp122019_si162_sequencial_seq OWNER TO dbportal;

  --
  -- Name: incorgao2019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE incorgao2019 (
  --     si163_sequencial bigint DEFAULT 0 NOT NULL,
  --     si163_codorgao character varying(2) NOT NULL,
  --     si163_cpfgestor character varying(11) NOT NULL,
  --     si163_tipoorgao character varying(2) NOT NULL,
  --     si163_mes bigint DEFAULT 0 NOT NULL,
  --     si163_instit integer DEFAULT 0
  -- );


  -- ALTER TABLE incorgao2019 OWNER TO dbportal;

  --
  -- Name: incpro2019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE incpro2019 ( -- todo sem tabela
  --     si159_sequencial bigint DEFAULT 0 NOT NULL,
  --     si159_codprograma character varying(4) NOT NULL,
  --     si159_nomeprograma character varying(200) NOT NULL,
  --     si159_objetivo character varying(500) NOT NULL,
  --     si159_totrecursos1ano double precision DEFAULT 0 NOT NULL,
  --     si159_totrecursos2ano double precision DEFAULT 0 NOT NULL,
  --     si159_totrecursos3ano double precision DEFAULT 0 NOT NULL,
  --     si159_totrecursos4ano double precision DEFAULT 0 NOT NULL,
  --     si159_nrolei character varying(6) NOT NULL,
  --     si159_dtlei date NOT NULL,
  --     si159_dtpublicacaolei date NOT NULL,
  --     si159_mes bigint DEFAULT 0 NOT NULL,
  --     si159_instit bigint DEFAULT 0
  -- );


  -- ALTER TABLE incpro2019 OWNER TO dbportal;

  -- --
  -- -- Name: incpro2019_si159_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  -- --

  -- CREATE SEQUENCE incpro2019_si159_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE incpro2019_si159_sequencial_seq OWNER TO dbportal;

  --
  -- Name: item102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE item102019 (
      si43_sequencial bigint DEFAULT 0 NOT NULL,
      si43_tiporegistro bigint DEFAULT 0 NOT NULL,
      si43_coditem bigint DEFAULT 0 NOT NULL,
      si43_dscitem text NOT NULL,
      si43_unidademedida character varying(50) NOT NULL,
      si43_tipocadastro bigint DEFAULT 0 NOT NULL,
      si43_justificativaalteracao character varying(100),
      si43_mes bigint DEFAULT 0 NOT NULL,
      si43_instit bigint DEFAULT 0
  );


  ALTER TABLE item102019 OWNER TO dbportal;

  --
  -- Name: item102019_si43_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE item102019_si43_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE item102019_si43_sequencial_seq OWNER TO dbportal;

  --
  -- Name: iuoc2019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE iuoc2019 (
  --     si164_sequencial bigint DEFAULT 0 NOT NULL,
  --     si164_codorgao character varying(2) NOT NULL,
  --     si164_codunidadesub character varying(8) NOT NULL,
  --     si164_idfundo character varying(2),
  --     si164_descunidadesub character varying(50) NOT NULL,
  --     si164_esubunidade bigint DEFAULT 0 NOT NULL,
  --     si164_mes bigint DEFAULT 0 NOT NULL,
  --     si164_instit bigint DEFAULT 0
  -- );


  -- ALTER TABLE iuoc2019 OWNER TO dbportal;

  --
  -- Name: iuoc2019_si164_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  -- CREATE SEQUENCE iuoc2019_si164_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE iuoc2019_si164_sequencial_seq OWNER TO dbportal;

  --
  -- Name: julglic102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE julglic102019 (
      si60_sequencial bigint DEFAULT 0 NOT NULL,
      si60_tiporegistro bigint DEFAULT 0 NOT NULL,
      si60_codorgao character varying(2) NOT NULL,
      si60_codunidadesub character varying(8) NOT NULL,
      si60_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si60_nroprocessolicitatorio character varying(12) NOT NULL,
      si60_tipodocumento bigint DEFAULT 0 NOT NULL,
      si60_nrodocumento character varying(14) NOT NULL,
      si60_nrolote bigint DEFAULT 0,
      si60_coditem bigint DEFAULT 0 NOT NULL,
      si60_vlunitario double precision DEFAULT 0 NOT NULL,
      si60_quantidade double precision DEFAULT 0 NOT NULL,
      si60_mes bigint DEFAULT 0 NOT NULL,
      si60_instit bigint DEFAULT 0
  );


  ALTER TABLE julglic102019 OWNER TO dbportal;

  --
  -- Name: julglic102019_si60_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE julglic102019_si60_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE julglic102019_si60_sequencial_seq OWNER TO dbportal;

  --
  -- Name: julglic202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE julglic202019 (
      si61_sequencial bigint DEFAULT 0 NOT NULL,
      si61_tiporegistro bigint DEFAULT 0 NOT NULL,
      si61_codorgao character varying(2) NOT NULL,
      si61_codunidadesub character varying(8) NOT NULL,
      si61_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si61_nroprocessolicitatorio character varying(12) NOT NULL,
      si61_tipodocumento bigint DEFAULT 0 NOT NULL,
      si61_nrodocumento character varying(14) NOT NULL,
      si61_nrolote bigint DEFAULT 0,
      si61_coditem character varying(15),
      si61_percdesconto double precision DEFAULT 0 NOT NULL,
      si61_mes bigint DEFAULT 0 NOT NULL,
      si61_instit bigint DEFAULT 0
  );


  ALTER TABLE julglic202019 OWNER TO dbportal;

  --
  -- Name: julglic202019_si61_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE julglic202019_si61_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE julglic202019_si61_sequencial_seq OWNER TO dbportal;

  --
  -- Name: julglic302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE julglic302019 (
      si62_sequencial bigint DEFAULT 0 NOT NULL,
      si62_tiporegistro bigint DEFAULT 0 NOT NULL,
      si62_codorgao character varying(2) NOT NULL,
      si62_codunidadesub character varying(8) NOT NULL,
      si62_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si62_nroprocessolicitatorio character varying(12) NOT NULL,
      si62_tipodocumento bigint DEFAULT 0 NOT NULL,
      si62_nrodocumento character varying(14) NOT NULL,
      si62_nrolote bigint,
      si62_coditem character varying(15),
      si62_perctaxaadm double precision DEFAULT 0 NOT NULL,
      si62_mes bigint DEFAULT 0 NOT NULL,
      si62_instit integer DEFAULT 0
  );


  ALTER TABLE julglic302019 OWNER TO dbportal;

  --
  -- Name: julglic402019_si62_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE julglic302019_si62_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE julglic302019_si62_sequencial_seq OWNER TO dbportal;

  --
  -- Name: julglic402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE julglic402019 (
      si62_sequencial bigint DEFAULT 0 NOT NULL,
      si62_tiporegistro bigint DEFAULT 0 NOT NULL,
      si62_codorgao character varying(2) NOT NULL,
      si62_codunidadesub character varying(8) NOT NULL,
      si62_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si62_nroprocessolicitatorio character varying(12) NOT NULL,
      si62_dtjulgamento date NOT NULL,
      si62_presencalicitantes bigint DEFAULT 0 NOT NULL,
      si62_renunciarecurso bigint DEFAULT 0 NOT NULL,
      si62_mes bigint DEFAULT 0 NOT NULL,
      si62_instit integer DEFAULT 0
  );


  ALTER TABLE julglic402019 OWNER TO dbportal;

  --
  -- Name: julglic402019_si62_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE julglic402019_si62_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE julglic402019_si62_sequencial_seq OWNER TO dbportal;



  --
  -- Name: lao102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE lao102019 (
      si34_sequencial bigint DEFAULT 0 NOT NULL,
      si34_tiporegistro bigint DEFAULT 0 NOT NULL,
      si34_codorgao character varying(2) NOT NULL,
      si34_nroleialteracao bigint NOT NULL,
      si34_dataleialteracao date NOT NULL,
      si34_mes bigint DEFAULT 0 NOT NULL,
      si34_instit bigint DEFAULT 0
  );


  ALTER TABLE lao102019 OWNER TO dbportal;

  --
  -- Name: lao102019_si34_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE lao102019_si34_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE lao102019_si34_sequencial_seq OWNER TO dbportal;

  --
  -- Name: lao112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE lao112019 (
      si35_sequencial bigint DEFAULT 0 NOT NULL,
      si35_tiporegistro bigint DEFAULT 0 NOT NULL,
      si35_nroleialteracao bigint NOT NULL,
      si35_tipoleialteracao bigint DEFAULT 0 NOT NULL,
      si35_artigoleialteracao character varying(6) NOT NULL,
      si35_descricaoartigo character varying(512) NOT NULL,
      si35_vlautorizadoalteracao double precision DEFAULT 0 NOT NULL,
      si35_mes bigint DEFAULT 0 NOT NULL,
      si35_reg10 bigint DEFAULT 0 NOT NULL,
      si35_instit bigint DEFAULT 0
  );


  ALTER TABLE lao112019 OWNER TO dbportal;

  --
  -- Name: lao112019_si35_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE lao112019_si35_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE lao112019_si35_sequencial_seq OWNER TO dbportal;

  --
  -- Name: lao202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE lao202019 (
      si36_sequencial bigint DEFAULT 0 NOT NULL,
      si36_tiporegistro bigint DEFAULT 0 NOT NULL,
      si36_codorgao character varying(2) NOT NULL,
      si36_nroleialterorcam character varying(6) NOT NULL,
      si36_dataleialterorcam date NOT NULL,
      si36_mes bigint DEFAULT 0 NOT NULL,
      si36_instit bigint DEFAULT 0
  );


  ALTER TABLE lao202019 OWNER TO dbportal;

  --
  -- Name: lao202019_si36_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE lao202019_si36_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE lao202019_si36_sequencial_seq OWNER TO dbportal;

  --
  -- Name: lao212019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE lao212019 (
      si37_sequencial bigint DEFAULT 0 NOT NULL,
      si37_tiporegistro bigint DEFAULT 0 NOT NULL,
      si37_nroleialterorcam bigint NOT NULL,
      si37_tipoautorizacao bigint DEFAULT 0 NOT NULL,
      si37_artigoleialterorcamento character varying(6) NOT NULL,
      si37_descricaoartigo character varying(512) NOT NULL,
      si37_novopercentual double precision DEFAULT 0 NOT NULL,
      si37_mes bigint DEFAULT 0 NOT NULL,
      si37_reg20 bigint DEFAULT 0 NOT NULL,
      si37_instit bigint DEFAULT 0
  );


  ALTER TABLE lao212019 OWNER TO dbportal;

  --
  -- Name: lao212019_si37_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE lao212019_si37_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE lao212019_si37_sequencial_seq OWNER TO dbportal;

  --
  -- Name: lqd102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE lqd102019 (
      si118_sequencial bigint DEFAULT 0 NOT NULL,
      si118_tiporegistro bigint DEFAULT 0 NOT NULL,
      si118_codreduzido bigint DEFAULT 0 NOT NULL,
      si118_codorgao character varying(2) NOT NULL,
      si118_codunidadesub character varying(8) NOT NULL,
      si118_tpliquidacao bigint DEFAULT 0 NOT NULL,
      si118_nroempenho bigint DEFAULT 0 NOT NULL,
      si118_dtempenho date NOT NULL,
      si118_dtliquidacao date NOT NULL,
      si118_nroliquidacao bigint DEFAULT 0 NOT NULL,
      si118_vlliquidado double precision DEFAULT 0 NOT NULL,
      si118_cpfliquidante character varying(11) NOT NULL,
      si118_mes bigint DEFAULT 0 NOT NULL,
      si118_instit bigint DEFAULT 0
  );


  ALTER TABLE lqd102019 OWNER TO dbportal;

  --
  -- Name: lqd102019_si118_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE lqd102019_si118_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE lqd102019_si118_sequencial_seq OWNER TO dbportal;

  --
  -- Name: lqd112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE lqd112019 (
      si119_sequencial bigint DEFAULT 0 NOT NULL,
      si119_tiporegistro bigint DEFAULT 0 NOT NULL,
      si119_codreduzido bigint DEFAULT 0 NOT NULL,
      si119_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si119_valorfonte double precision DEFAULT 0 NOT NULL,
      si119_mes bigint DEFAULT 0 NOT NULL,
      si119_reg10 bigint DEFAULT 0 NOT NULL,
      si119_instit bigint DEFAULT 0
  );


  ALTER TABLE lqd112019 OWNER TO dbportal;

  --
  -- Name: lqd112019_si119_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE lqd112019_si119_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE lqd112019_si119_sequencial_seq OWNER TO dbportal;

  --
  -- Name: lqd122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE lqd122019 (
      si120_sequencial bigint DEFAULT 0 NOT NULL,
      si120_tiporegistro bigint DEFAULT 0 NOT NULL,
      si120_codreduzido bigint DEFAULT 0 NOT NULL,
      si120_mescompetencia character varying(2) NOT NULL,
      si120_exerciciocompetencia bigint DEFAULT 0 NOT NULL,
      si120_vldspexerant double precision DEFAULT 0 NOT NULL,
      si120_mes bigint DEFAULT 0 NOT NULL,
      si120_reg10 bigint DEFAULT 0 NOT NULL,
      si120_instit bigint DEFAULT 0
  );


  ALTER TABLE lqd122019 OWNER TO dbportal;

  --
  -- Name: lqd122019_si120_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE lqd122019_si120_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE lqd122019_si120_sequencial_seq OWNER TO dbportal;

  --
  -- Name: metareal102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE metareal102019 (
      si171_sequencial bigint DEFAULT 0 NOT NULL,
      si171_tiporegistro bigint DEFAULT 0 NOT NULL,
      si171_codorgao character varying(2) DEFAULT 0 NOT NULL,
      si171_codunidadesub character varying(8) DEFAULT 0 NOT NULL,
      si171_codfuncao character varying(2) DEFAULT 0 NOT NULL,
      si171_codsubfuncao character varying(3) DEFAULT 0 NOT NULL,
      si171_codprograma character varying(4) DEFAULT 0 NOT NULL,
      si171_idacao character varying(4) DEFAULT 0 NOT NULL,
      si171_idsubacao character varying(4) DEFAULT 0,
      si171_metarealizada double precision DEFAULT 0 NOT NULL,
      si171_justificativa character varying(1000) DEFAULT 0,
      si171_instit bigint DEFAULT 0
  );


  ALTER TABLE metareal102019 OWNER TO dbportal;

  --
  -- Name: metareal102019_si171_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE metareal102019_si171_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE metareal102019_si171_sequencial_seq OWNER TO dbportal;

  --
  -- Name: iderp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE iderp102019 (
      si179_sequencial bigint DEFAULT 0 NOT NULL,
      si179_tiporegistro bigint DEFAULT 0 NOT NULL,
      si179_codiderp bigint DEFAULT 0 NOT NULL,
      si179_codorgao character varying(2) DEFAULT 0 NOT NULL,
      si179_codunidadesub character varying(8) DEFAULT 0 NOT NULL,
      si179_nroempenho bigint DEFAULT 0 NOT NULL,
      si179_tiporestospagar bigint DEFAULT 0 NOT NULL,
      si179_disponibilidadecaixa bigint DEFAULT 0 NOT NULL,
      si179_vlinscricao double precision DEFAULT 0 NOT NULL,
      si179_instit bigint DEFAULT 0
  );


  ALTER TABLE iderp102019 OWNER TO dbportal;

  --
  -- Name: iderp102019_si179_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE iderp102019_si179_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE iderp102019_si179_sequencial_seq OWNER TO dbportal;

  --
  -- Name: iderp112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE iderp112019 (
      si180_sequencial bigint DEFAULT 0 NOT NULL,
      si180_tiporegistro bigint DEFAULT 0 NOT NULL,
      si180_codiderp bigint DEFAULT 0 NOT NULL,
      si180_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si180_vlinscricaofonte double precision DEFAULT 0 NOT NULL,
      si180_mes bigint DEFAULT 0 NOT NULL,
      si180_reg10 bigint DEFAULT 0 NOT NULL,
      si180_instit bigint DEFAULT 0
  );


  ALTER TABLE iderp112019 OWNER TO dbportal;

  --
  -- Name: iderp112019_si180_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE iderp112019_si180_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE iderp112019_si180_sequencial_seq OWNER TO dbportal;

  --
  -- Name: iderp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE iderp202019 (
      si181_sequencial bigint DEFAULT 0 NOT NULL,
      si181_tiporegistro bigint DEFAULT 0 NOT NULL,
      si181_codorgao character varying(2) NOT NULL,
      si181_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si181_vlcaixabruta double precision DEFAULT 0 NOT NULL,
      si181_vlrspexerciciosanteriores double precision DEFAULT 0 NOT NULL,
      si181_vlrestituiveisrecolher double precision DEFAULT 0 NOT NULL,
      si181_vlrestituiveisativofinanceiro double precision DEFAULT 0 NOT NULL,
      si181_vlsaldodispcaixa double precision DEFAULT 0 NOT NULL,
      si181_mes bigint DEFAULT 0 NOT NULL,
      si181_instit bigint DEFAULT 0
  );


  ALTER TABLE iderp202019 OWNER TO dbportal;

  --
  -- Name: iderp202019_si181_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE iderp202019_si181_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE iderp202019_si181_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conge102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conge102019 (
      si182_sequencial bigint DEFAULT 0 NOT NULL,
      si182_tiporegistro bigint DEFAULT 0 NOT NULL,
      si182_codconvenioconge bigint DEFAULT 0 NOT NULL,
      si182_codorgao character varying(2) NOT NULL,
      si182_codunidadesub character varying(8) NOT NULL,
      si182_nroconvenioconge character varying(30) NOT NULL,
      si182_dscinstrumento character varying(50) NOT NULL,
      si182_dataassinaturaconge date NOT NULL,
      si182_datapublicconge date NOT NULL,
      si182_nrocpfrespconge character varying(11) NOT NULL,
      si182_dsccargorespconge character varying(50) NOT NULL,
      si182_objetoconvenioconge character varying(500) NOT NULL,
      si182_datainiciovigenciaconge date NOT NULL,
      si182_datafinalvigenciaconge date NOT NULL,
      si182_formarepasse bigint NOT NULL,
      si182_tipodocumentoincentivador bigint,
      si182_nrodocumentoincentivador character varying(14),
      si182_quantparcelas bigint,
      si182_vltotalconvenioconge double precision DEFAULT 0 NOT NULL,
      si182_vlcontrapartidaconge double precision DEFAULT 0 NOT NULL,
      si182_tipodocumentobeneficiario bigint DEFAULT 0 NOT NULL,
      si182_nrodocumentobeneficiario character varying(14) DEFAULT 0 NOT NULL,
      si182_mes bigint DEFAULT 0 NOT NULL,
      si182_instit bigint DEFAULT 0
  );


  ALTER TABLE conge102019 OWNER TO dbportal;

  --
  -- Name: conge102019_si182_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conge102019_si182_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conge102019_si182_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conge202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conge202019 (
      si183_sequencial bigint DEFAULT 0 NOT NULL,
      si183_tiporegistro bigint DEFAULT 0 NOT NULL,
      si183_codorgao character varying(2) NOT NULL,
      si183_codunidadesub character varying(8) NOT NULL,
      si183_nroconvenioconge character varying(30) NOT NULL,
      si183_dataassinaturaconvoriginalconge date NOT NULL,
      si183_nroseqtermoaditivoconge bigint DEFAULT 0 NOT NULL,
      si183_dscAlteracaoConge character varying(500) DEFAULT 0 NOT NULL,
      si183_dataassinaturatermoaditivoconge date NOT NULL,
      si183_datafinalvigenciaconge date NOT NULL,
      si183_valoratualizadoconvenioconge double precision NOT NULL,
      si183_valoratualizadocontrapartidaconge double precision NOT NULL,
      si183_mes bigint DEFAULT 0 NOT NULL,
      si183_instit bigint DEFAULT 0
  );


  ALTER TABLE conge202019 OWNER TO dbportal;

  --
  -- Name: conge202019_si183_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conge202019_si183_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conge202019_si183_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conge302019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conge302019 (
      si184_sequencial bigint DEFAULT 0 NOT NULL,
      si184_tiporegistro bigint DEFAULT 0 NOT NULL,
      si184_codorgao character varying(2) NOT NULL,
      si184_codunidadesub character varying(8) NOT NULL,
      si184_nroconvenioconge character varying(30) NOT NULL,
      si184_dataassinaturaconvoriginalconge date NOT NULL,
      si184_numeroparcela bigint DEFAULT 0 NOT NULL,
      si184_datarepasseconge bigint DEFAULT 0 NOT NULL,
      si184_vlrepassadoconge double precision NOT NULL,
      si184_banco character varying(3) DEFAULT 0 NOT NULL,
      si184_agencia character varying(6) DEFAULT 0 NOT NULL,
      si184_digitoverificadoragencia character varying(2) DEFAULT 0 NOT NULL,
      si184_contabancaria character varying(12) DEFAULT 0 NOT NULL,
      si184_digitoverificadorcontabancaria character varying(2) DEFAULT 0 NOT NULL,
      si184_tipodocumentotitularconta bigint DEFAULT 0 NOT NULL,
      si184_nrodocumentotitularconta character varying(14) DEFAULT 0 NOT NULL,
      si184_prazoprestacontas date NOT NULL,
      si184_mes bigint DEFAULT 0 NOT NULL,
      si184_instit bigint DEFAULT 0
  );


  ALTER TABLE conge302019 OWNER TO dbportal;

  --
  -- Name: conge302019_si184_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conge302019_si184_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conge302019_si184_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conge402019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conge402019 (
      si237_sequencial bigint DEFAULT 0 NOT NULL,
      si237_tiporegistro bigint DEFAULT 0 NOT NULL,
      si237_codorgao character varying(2) NOT NULL,
      si237_codunidadesub character varying(8) NOT NULL,
      si237_nroconvenioconge character varying(30) NOT NULL,
      si237_dataassinaturaconvoriginalconge date NOT NULL,
      si237_datarepasseconge bigint DEFAULT 0 NOT NULL,
      si237_prestacaocontasparcela bigint NOT NULL,
      si237_dataprestacontasparcela date,
      si237_prestacaocontas bigint,
      si237_datacienfatos date,
      si237_prorrogprazo bigint DEFAULT 0 NOT NULL,
      si237_dataprorrogprazo date,
      si237_nrocpfrespprestconge character varying(11),
      si237_dsccargorespprestconge character varying(50),
      si237_mes bigint DEFAULT 0 NOT NULL,
      si237_instit bigint DEFAULT 0
  );


  ALTER TABLE conge402019 OWNER TO dbportal;

  --
  -- Name: conge402019_si237_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conge402019_si237_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conge402019_si237_sequencial_seq OWNER TO dbportal;

  --
  -- Name: conge502019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE conge502019 (
      si238_sequencial bigint DEFAULT 0 NOT NULL,
      si238_tiporegistro bigint DEFAULT 0 NOT NULL,
      si238_codorgao character varying(2) NOT NULL,
      si238_codunidadesub character varying(8) NOT NULL,
      si238_nroconvenioconge character varying(30) NOT NULL,
      si238_dataassinaturaconvoriginalconge date NOT NULL,
      si238_dscmedidaadministrativa character varying(500) NOT NULL,
      si238_datainiciomedida date NOT NULL,
      si238_datafinalmedida date NOT NULL,
      si238_adocaomedidasadmin bigint DEFAULT 0 NOT NULL,
      si238_nrocpfrespmedidaconge character varying(11) NOT NULL,
      si238_dsccargorespmedidaconge character varying(50) NOT NULL,
      si238_mes bigint DEFAULT 0 NOT NULL,
      si238_instit bigint DEFAULT 0
  );


  ALTER TABLE conge502019 OWNER TO dbportal;

  --
  -- Name: conge502019_si238_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE conge502019_si238_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE conge502019_si238_sequencial_seq OWNER TO dbportal;

  --
  -- Name: tce102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE tce102019 (
      si187_sequencial bigint DEFAULT 0 NOT NULL,
      si187_tiporegistro bigint DEFAULT 0 NOT NULL,
      si187_numprocessotce character varying(12) NOT NULL,
      si187_datainstauracaotce date NOT NULL,
      si187_codunidadesub character varying(8) NOT NULL,
      si187_nroconvenioconge character varying(30) NOT NULL,
      si187_dataassinaturaconvoriginalconge date NOT NULL,
      si187_dscinstrumelegaltce character varying(50) NOT NULL,
      si187_nrocpfautoridadeinstauratce character varying(11) NOT NULL,
      si187_dsccargoresptce character varying(50) NOT NULL,
      si187_vloriginaldano double precision DEFAULT 0 NOT NULL,
      si187_vlatualizadodano double precision DEFAULT 0 NOT NULL,
      si187_dataatualizacao date NOT NULL,
      si187_indice character varying(20) NOT NULL,
      si187_ocorrehipotese bigint DEFAULT 0 NOT NULL,
      si187_identiresponsavel bigint DEFAULT 0 NOT NULL,
      si187_mes bigint DEFAULT 0 NOT NULL,
      si187_instit bigint DEFAULT 0
  );


  ALTER TABLE tce102019 OWNER TO dbportal;

  --
  -- Name: tce102019_si187_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE tce102019_si187_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE tce102019_si187_sequencial_seq OWNER TO dbportal;

  --
  -- Name: tce112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE tce112019 (
      si188_sequencial bigint DEFAULT 0 NOT NULL,
      si188_tiporegistro bigint DEFAULT 0 NOT NULL,
      si188_numprocessotce character varying(12) NOT NULL,
      si188_datainstauracaotce date NOT NULL,
      si188_tipodocumentorespdano bigint DEFAULT 0 NOT NULL,
      si188_nrodocumentorespdano character varying(14) NOT NULL,
      si188_mes bigint DEFAULT 0 NOT NULL,
      si188_reg10 bigint DEFAULT 0 NOT NULL,
      si188_instit bigint DEFAULT 0
  );


  ALTER TABLE tce112019 OWNER TO dbportal;

  --
  -- Name: tce112019_si188_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE tce112019_si188_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE tce112019_si188_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ntf102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ntf102019 (
      si143_sequencial bigint DEFAULT 0 NOT NULL,
      si143_tiporegistro bigint DEFAULT 0 NOT NULL,
      si143_codnotafiscal bigint DEFAULT 0 NOT NULL,
      si143_codorgao character varying(2) NOT NULL,
      si143_nfnumero bigint DEFAULT 0,
      si143_nfserie character varying(8),
      si143_tipodocumento bigint DEFAULT 0 NOT NULL,
      si143_nrodocumento character varying(14) NOT NULL,
      si143_nroinscestadual character varying(30),
      si143_nroinscmunicipal character varying(30),
      si143_nomemunicipio character varying(120) NOT NULL,
      si143_cepmunicipio bigint DEFAULT 0 NOT NULL,
      si143_ufcredor character varying(2) NOT NULL,
      si143_notafiscaleletronica bigint DEFAULT 0 NOT NULL,
      si143_chaveacesso bigint,
      si143_outrachaveacesso character varying(60),
      si143_nfaidf character varying(15) NOT NULL,
      si143_dtemissaonf date NOT NULL,
      si143_dtvencimentonf date,
      si143_nfvalortotal double precision DEFAULT 0 NOT NULL,
      si143_nfvalordesconto double precision DEFAULT 0 NOT NULL,
      si143_nfvalorliquido double precision DEFAULT 0 NOT NULL,
      si143_mes bigint DEFAULT 0 NOT NULL,
      si143_instit bigint DEFAULT 0
  );


  ALTER TABLE ntf102019 OWNER TO dbportal;

  --
  -- Name: ntf102019_si143_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ntf102019_si143_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ntf102019_si143_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ntf112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ntf112019 (
      si144_sequencial bigint DEFAULT 0 NOT NULL,
      si144_tiporegistro bigint DEFAULT 0 NOT NULL,
      si144_codnotafiscal bigint DEFAULT 0 NOT NULL,
      si144_coditem bigint DEFAULT 0 NOT NULL,
      si144_quantidadeitem double precision DEFAULT 0 NOT NULL,
      si144_valorunitarioitem double precision DEFAULT 0 NOT NULL,
      si144_mes bigint DEFAULT 0 NOT NULL,
      si144_reg10 bigint DEFAULT 0 NOT NULL,
      si144_instit bigint DEFAULT 0
  );


  ALTER TABLE ntf112019 OWNER TO dbportal;

  --
  -- Name: ntf112019_si144_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ntf112019_si144_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ntf112019_si144_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ntf202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ntf202019 (
      si145_sequencial bigint DEFAULT 0 NOT NULL,
      si145_tiporegistro bigint DEFAULT 0 NOT NULL,
      si145_nfnumero bigint DEFAULT 0 NOT NULL,
      si145_nfserie character varying(8) DEFAULT 0,
      si145_tipodocumento bigint DEFAULT 0 NOT NULL,
      si145_nrodocumento character varying(14) DEFAULT 0 NOT NULL,
      si145_chaveacesso bigint,
      si145_dtemissaonf date NOT NULL,
      si145_codunidadesub character varying(8) NOT NULL,
      si145_dtempenho date NOT NULL,
      si145_nroempenho bigint DEFAULT 0 NOT NULL,
      si145_dtliquidacao date NOT NULL,
      si145_nroliquidacao bigint DEFAULT 0 NOT NULL,
      si145_mes bigint DEFAULT 0 NOT NULL,
      si145_reg10 bigint DEFAULT 0 NOT NULL,
      si145_instit bigint DEFAULT 0
  );


  ALTER TABLE ntf202019 OWNER TO dbportal;

  --
  -- Name: ntf202019_si145_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ntf202019_si145_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ntf202019_si145_sequencial_seq OWNER TO dbportal;

  --
  -- Name: obelac102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE obelac102019 (
      si139_sequencial bigint DEFAULT 0 NOT NULL,
      si139_tiporegistro bigint DEFAULT 0 NOT NULL,
      si139_codreduzido bigint DEFAULT 0 NOT NULL,
      si139_codorgao character varying(2) NOT NULL,
      si139_codunidadesub character varying(8) NOT NULL,
      si139_nrolancamento bigint DEFAULT 0 NOT NULL,
      si139_dtlancamento date NOT NULL,
      si139_tipolancamento bigint DEFAULT 0 NOT NULL,
      si139_nroempenho bigint DEFAULT 0 NOT NULL,
      si139_dtempenho date NOT NULL,
      si139_nroliquidacao bigint DEFAULT 0,
      si139_dtliquidacao date,
      si139_esplancamento character varying(500) NOT NULL,
      si139_valorlancamento double precision DEFAULT 0 NOT NULL,
      si139_mes bigint DEFAULT 0 NOT NULL,
      si139_instit bigint DEFAULT 0
  );


  ALTER TABLE obelac102019 OWNER TO dbportal;

  --
  -- Name: obelac102019_si139_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE obelac102019_si139_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE obelac102019_si139_sequencial_seq OWNER TO dbportal;

  --
  -- Name: obelac112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE obelac112019 (
      si140_sequencial bigint DEFAULT 0 NOT NULL,
      si140_tiporegistro bigint DEFAULT 0 NOT NULL,
      si140_codreduzido bigint DEFAULT 0 NOT NULL,
      si140_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si140_valorfonte double precision DEFAULT 0 NOT NULL,
      si140_mes bigint DEFAULT 0 NOT NULL,
      si140_reg10 bigint DEFAULT 0 NOT NULL,
      si140_instit bigint DEFAULT 0
  );


  ALTER TABLE obelac112019 OWNER TO dbportal;

  --
  -- Name: obelac112019_si140_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE obelac112019_si140_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE obelac112019_si140_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ops102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ops102019 (
      si132_sequencial bigint DEFAULT 0 NOT NULL,
      si132_tiporegistro bigint DEFAULT 0 NOT NULL,
      si132_codorgao character varying(2) NOT NULL,
      si132_codunidadesub character varying(8) NOT NULL,
      si132_nroop bigint DEFAULT 0 NOT NULL,
      si132_dtpagamento date NOT NULL,
      si132_vlop double precision DEFAULT 0 NOT NULL,
      si132_especificacaoop character varying(500) NOT NULL,
      si132_cpfresppgto character varying(11) NOT NULL,
      si132_mes bigint DEFAULT 0 NOT NULL,
      si132_instit bigint DEFAULT 0
  );


  ALTER TABLE ops102019 OWNER TO dbportal;

  --
  -- Name: ops102019_si132_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ops102019_si132_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ops102019_si132_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ops112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ops112019 (
      si133_sequencial bigint DEFAULT 0 NOT NULL,
      si133_tiporegistro bigint DEFAULT 0 NOT NULL,
      si133_codreduzidoop bigint DEFAULT 0 NOT NULL,
      si133_codunidadesub character varying(8) NOT NULL,
      si133_nroop bigint DEFAULT 0 NOT NULL,
      si133_dtpagamento date NOT NULL,
      si133_tipopagamento bigint DEFAULT 0 NOT NULL,
      si133_nroempenho bigint DEFAULT 0 NOT NULL,
      si133_dtempenho date NOT NULL,
      si133_nroliquidacao bigint DEFAULT 0,
      si133_dtliquidacao date,
      si133_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si133_valorfonte double precision DEFAULT 0 NOT NULL,
      si133_tipodocumentocredor bigint DEFAULT 0,
      si133_nrodocumento character varying(14),
      si133_codorgaoempop character varying(2),
      si133_codunidadeempop character varying(8),
      si133_mes bigint DEFAULT 0 NOT NULL,
      si133_reg10 bigint DEFAULT 0 NOT NULL,
      si133_instit bigint DEFAULT 0
  );


  ALTER TABLE ops112019 OWNER TO dbportal;

  --
  -- Name: ops112019_si133_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ops112019_si133_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ops112019_si133_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ops122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ops122019 (
      si134_sequencial bigint DEFAULT 0 NOT NULL,
      si134_tiporegistro bigint DEFAULT 0 NOT NULL,
      si134_codreduzidoop bigint DEFAULT 0 NOT NULL,
      si134_tipodocumentoop character varying(2) NOT NULL,
      si134_nrodocumento character varying(15),
      si134_codctb bigint DEFAULT 0,
      si134_codfontectb bigint DEFAULT 0,
      si134_desctipodocumentoop character varying(50),
      si134_dtemissao date NOT NULL,
      si134_vldocumento double precision DEFAULT 0 NOT NULL,
      si134_mes bigint DEFAULT 0 NOT NULL,
      si134_reg10 bigint DEFAULT 0 NOT NULL,
      si134_instit integer DEFAULT 0
  );


  ALTER TABLE ops122019 OWNER TO dbportal;

  --
  -- Name: ops122019_si134_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ops122019_si134_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ops122019_si134_sequencial_seq OWNER TO dbportal;

  --
  -- Name: ops132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE ops132019 (
      si135_sequencial bigint DEFAULT 0 NOT NULL,
      si135_tiporegistro bigint DEFAULT 0 NOT NULL,
      si135_codreduzidoop bigint DEFAULT 0 NOT NULL,
      si135_tiporetencao character varying(4) NOT NULL,
      si135_descricaoretencao character varying(50),
      si135_vlretencao double precision DEFAULT 0 NOT NULL,
      si135_vlantecipado double precision DEFAULT 0 NOT NULL,
      si135_mes bigint DEFAULT 0 NOT NULL,
      si135_reg10 bigint DEFAULT 0 NOT NULL,
      si135_instit bigint DEFAULT 0
  );


  ALTER TABLE ops132019 OWNER TO dbportal;

  --
  -- Name: ops132019_si135_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE ops132019_si135_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE ops132019_si135_sequencial_seq OWNER TO dbportal;

  -- --
  -- -- Name: ops142019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  -- --
  --
  -- CREATE TABLE ops142019 (
  --     si136_sequencial bigint DEFAULT 0 NOT NULL,
  --     si136_tiporegistro bigint DEFAULT 0 NOT NULL,
  --     si136_codreduzidoop bigint DEFAULT 0 NOT NULL,
  --     si136_tipovlantecipado character varying(2) NOT NULL,
  --     si136_descricaovlantecipado character varying(50),
  --     si136_vlantecipado double precision DEFAULT 0 NOT NULL,
  --     si136_mes bigint DEFAULT 0 NOT NULL,
  --     si136_reg10 bigint DEFAULT 0 NOT NULL,
  --     si136_instit bigint DEFAULT 0
  -- );
  --
  --
  -- ALTER TABLE ops142019 OWNER TO dbportal;
  --
  -- --
  -- -- Name: ops142019_si136_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  -- --
  --
  -- CREATE SEQUENCE ops142019_si136_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;
  --
  --
  -- ALTER TABLE ops142019_si136_sequencial_seq OWNER TO dbportal;

  --
  -- Name: orgao102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE orgao102019 (
      si14_sequencial bigint DEFAULT 0 NOT NULL,
      si14_tiporegistro bigint DEFAULT 0 NOT NULL,
      si14_codorgao character varying(2) NOT NULL,
      si14_tipoorgao character varying(2) NOT NULL,
      si14_cnpjorgao character varying(14) NOT NULL,
      si14_tipodocumentofornsoftware bigint DEFAULT 0 NOT NULL,
      si14_nrodocumentofornsoftware character varying(14) NOT NULL,
      si14_versaosoftware character varying(50) NOT NULL,
      si14_assessoriacontabil bigint NOT NULL,
      si14_tipodocumentoassessoria bigint,
      si14_nrodocumentoassessoria character varying(14),
      si14_mes bigint DEFAULT 0 NOT NULL,
      si14_instit bigint DEFAULT 0
  );


  ALTER TABLE orgao102019 OWNER TO dbportal;

  --
  -- Name: orgao102019_si14_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE orgao102019_si14_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE orgao102019_si14_sequencial_seq OWNER TO dbportal;

  --
  -- Name: orgao112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE orgao112019 (
      si15_sequencial bigint DEFAULT 0 NOT NULL,
      si15_tiporegistro bigint DEFAULT 0 NOT NULL,
      si15_tiporesponsavel character varying(2) NOT NULL,
      si15_cartident character varying(10) NOT NULL,
      si15_orgemissorci character varying(10) NOT NULL,
      si15_cpf character varying(11) NOT NULL,
      si15_crccontador character varying(11),
      si15_ufcrccontador character varying(2),
      si15_cargoorddespdeleg character varying(50),
      si15_dtinicio date NOT NULL,
      si15_dtfinal date NOT NULL,
      si15_email character varying(50) NOT NULL,
      si15_reg10 bigint DEFAULT 0 NOT NULL,
      si15_mes bigint DEFAULT 0 NOT NULL,
      si15_instit bigint DEFAULT 0
  );


  ALTER TABLE orgao112019 OWNER TO dbportal;

  --
  -- Name: orgao112019_si15_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE orgao112019_si15_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE orgao112019_si15_sequencial_seq OWNER TO dbportal;

  --
  -- Name: parec102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE parec102019 (
      si22_sequencial bigint DEFAULT 0 NOT NULL,
      si22_tiporegistro bigint DEFAULT 0 NOT NULL,
      si22_codreduzido bigint DEFAULT 0 NOT NULL,
      si22_codorgao character varying(2) NOT NULL,
      si22_ededucaodereceita bigint DEFAULT 0 NOT NULL,
      si22_identificadordeducao bigint DEFAULT 0,
      si22_naturezareceita bigint DEFAULT 0 NOT NULL,
      si22_tipoatualizacao bigint DEFAULT 0 NOT NULL,
      si22_vlacrescidoreduzido double precision DEFAULT 0 NOT NULL,
      si22_mes bigint DEFAULT 0 NOT NULL,
      si22_instit bigint DEFAULT 0
  );


  ALTER TABLE parec102019 OWNER TO dbportal;

  --
  -- Name: parec102019_si22_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE parec102019_si22_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE parec102019_si22_sequencial_seq OWNER TO dbportal;

  --
  -- Name: parec102019_si66_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE parec102019_si66_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE parec102019_si66_sequencial_seq OWNER TO dbportal;

  --
  -- Name: parec112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE parec112019 (
      si23_sequencial bigint DEFAULT 0 NOT NULL,
      si23_tiporegistro bigint DEFAULT 0 NOT NULL,
      si23_codreduzido bigint DEFAULT 0 NOT NULL,
      si23_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si23_vlfonte double precision DEFAULT 0 NOT NULL,
      si23_reg10 bigint DEFAULT 0 NOT NULL,
      si23_mes bigint DEFAULT 0 NOT NULL,
      si23_instit bigint DEFAULT 0
  );


  ALTER TABLE parec112019 OWNER TO dbportal;

  --
  -- Name: parec112019_si23_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE parec112019_si23_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE parec112019_si23_sequencial_seq OWNER TO dbportal;

  --
  -- Name: parelic102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE parelic102019 (
      si66_sequencial bigint DEFAULT 0 NOT NULL,
      si66_tiporegistro bigint DEFAULT 0 NOT NULL,
      si66_codorgao character varying(2) NOT NULL,
      si66_codunidadesub character varying(8),
      si66_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si66_nroprocessolicitatorio character varying(12) NOT NULL,
      si66_dataparecer date NOT NULL,
      si66_tipoparecer bigint DEFAULT 0 NOT NULL,
      si66_nrocpf character varying(11) NOT NULL,
      si66_mes bigint DEFAULT 0 NOT NULL,
      si66_instit bigint DEFAULT 0
  );


  ALTER TABLE parelic102019 OWNER TO dbportal;

  --
  -- Name: parpps102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE parpps102019 (
      si156_sequencial bigint DEFAULT 0 NOT NULL,
      si156_tiporegistro bigint DEFAULT 0 NOT NULL,
      si156_codorgao character varying(2) NOT NULL,
      si156_tipoplano bigint DEFAULT 0 NOT NULL,
      si156_exercicio bigint DEFAULT 0 NOT NULL,
      si156_vlsaldofinanceiroexercicioanterior double precision DEFAULT 0 NOT NULL,
      si156_vlreceitaprevidenciariaanterior double precision DEFAULT 0 NOT NULL,
      si156_vldespesaprevidenciariaanterior double precision DEFAULT 0 NOT NULL,
      si156_mes bigint DEFAULT 0 NOT NULL,
      si156_instit bigint DEFAULT 0
  );


  ALTER TABLE parpps102019 OWNER TO dbportal;

  --
  -- Name: parpps102019_si156_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE parpps102019_si156_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE parpps102019_si156_sequencial_seq OWNER TO dbportal;

  --
  -- Name: parpps202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE parpps202019 (
      si155_sequencial bigint DEFAULT 0 NOT NULL,
      si155_tiporegistro bigint DEFAULT 0 NOT NULL,
      si155_codorgao character varying(2) NOT NULL,
      si155_tipoplano bigint DEFAULT 0 NOT NULL,
      si155_exercicio bigint DEFAULT 0 NOT NULL,
      si155_vlreceitaprevidenciaria double precision DEFAULT 0 NOT NULL,
      si155_vldespesaprevidenciaria double precision DEFAULT 0 NOT NULL,
      si155_mes bigint DEFAULT 0 NOT NULL,
      si155_instit bigint DEFAULT 0
  );


  ALTER TABLE parpps202019 OWNER TO dbportal;

  --
  -- Name: parpps202019_si155_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE parpps202019_si155_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE parpps202019_si155_sequencial_seq OWNER TO dbportal;

  --
  -- Name: pessoaflpgo102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE pessoaflpgo102019 ( -- revisar essa tabela
  --     si193_sequencial bigint DEFAULT 0 NOT NULL,
  --     si193_tiporegistro bigint DEFAULT 0 NOT NULL,
  --     si193_tipodocumento bigint DEFAULT 0 NOT NULL,
  --     si193_nrodocumento character varying(14) NOT NULL,
  --     si193_nome character varying(120) NOT NULL,
  --     si193_indsexo character varying(1),
  --     si193_datanascimento date,
  --     si193_tipocadastro bigint DEFAULT 0 NOT NULL,
  --     si193_justalteracao character varying(100),
  --     si193_mes bigint DEFAULT 0 NOT NULL,
  --     si193_inst bigint DEFAULT 0
  -- );


  -- ALTER TABLE pessoaflpgo102019 OWNER TO dbportal;

  --
  -- Name: pessoaflpgo102019_si193_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  -- CREATE SEQUENCE pessoaflpgo102019_si193_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE pessoaflpgo102019_si193_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rec102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rec102019 (
      si25_sequencial bigint DEFAULT 0 NOT NULL,
      si25_tiporegistro bigint DEFAULT 0 NOT NULL,
      si25_codreceita bigint DEFAULT 0 NOT NULL,
      si25_codorgao character varying(2) NOT NULL,
      si25_ededucaodereceita bigint DEFAULT 0 NOT NULL,
      si25_identificadordeducao bigint DEFAULT 0 NOT NULL,
      si25_naturezareceita bigint DEFAULT 0 NOT NULL,
      si25_vlarrecadado double precision DEFAULT 0 NOT NULL,
      si25_mes bigint DEFAULT 0 NOT NULL,
      si25_instit bigint DEFAULT 0
  );


  ALTER TABLE rec102019 OWNER TO dbportal;

  --
  -- Name: rec102019_si25_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rec102019_si25_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rec102019_si25_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rec112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rec112019 (
      si26_sequencial bigint DEFAULT 0 NOT NULL,
      si26_tiporegistro bigint DEFAULT 0 NOT NULL,
      si26_codreceita bigint DEFAULT 0 NOT NULL,
      si26_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si26_tipodocumento bigint,
      si26_nrodocumento character varying(14),
      si26_nroconvenio character varying(30),
      si26_dataassinatura date,
      si26_vlarrecadadofonte double precision DEFAULT 0 NOT NULL,
      si26_reg10 bigint DEFAULT 0 NOT NULL,
      si26_mes bigint DEFAULT 0 NOT NULL,
      si26_instit bigint DEFAULT 0
  );


  ALTER TABLE rec112019 OWNER TO dbportal;

  --
  -- Name: rec112019_si26_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rec112019_si26_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rec112019_si26_sequencial_seq OWNER TO dbportal;

  --
  -- Name: regadesao102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE regadesao102019 (
      si67_sequencial bigint DEFAULT 0 NOT NULL,
      si67_tiporegistro bigint DEFAULT 0 NOT NULL,
      si67_codorgao character varying(2) NOT NULL,
      si67_codunidadesub character varying(8) NOT NULL,
      si67_nroprocadesao character varying(12) NOT NULL,
      si63_exercicioadesao bigint DEFAULT 0 NOT NULL,
      si67_dtabertura date NOT NULL,
      si67_nomeorgaogerenciador character varying(100) NOT NULL,
      si67_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si67_nroprocessolicitatorio character varying(20) NOT NULL,
      si67_codmodalidadelicitacao bigint DEFAULT 0 NOT NULL,
      si67_nromodalidade bigint DEFAULT 0 NOT NULL,
      si67_dtataregpreco date NOT NULL,
      si67_dtvalidade date NOT NULL,
      si67_naturezaprocedimento bigint DEFAULT 0 NOT NULL,
      si67_dtpublicacaoavisointencao date,
      si67_objetoadesao character varying(500) NOT NULL,
      si67_cpfresponsavel character varying(11) NOT NULL,
      si67_descontotabela bigint DEFAULT 0 NOT NULL,
      si67_processoporlote bigint DEFAULT 0 NOT NULL,
      si67_mes bigint DEFAULT 0 NOT NULL,
      si67_instit bigint DEFAULT 0
  );


  ALTER TABLE regadesao102019 OWNER TO dbportal;

  --
  -- Name: regadesao102019_si67_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE regadesao102019_si67_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE regadesao102019_si67_sequencial_seq OWNER TO dbportal;

  --
  -- Name: regadesao112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE regadesao112019 (
      si68_sequencial bigint DEFAULT 0 NOT NULL,
      si68_tiporegistro bigint DEFAULT 0 NOT NULL,
      si68_codorgao character varying(2) NOT NULL,
      si68_codunidadesub character varying(8) NOT NULL,
      si68_nroprocadesao character varying(12) NOT NULL,
      si68_exercicioadesao bigint DEFAULT 0 NOT NULL,
      si68_nrolote bigint DEFAULT 0 NOT NULL,
      si68_dsclote character varying(250) NOT NULL,
      si68_mes bigint DEFAULT 0 NOT NULL,
      si68_reg10 bigint DEFAULT 0 NOT NULL,
      si68_instit bigint DEFAULT 0
  );


  ALTER TABLE regadesao112019 OWNER TO dbportal;

  --
  -- Name: regadesao112019_si68_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE regadesao112019_si68_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE regadesao112019_si68_sequencial_seq OWNER TO dbportal;

  --
  -- Name: regadesao122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE regadesao122019 (
      si69_sequencial bigint DEFAULT 0 NOT NULL,
      si69_tiporegistro bigint DEFAULT 0 NOT NULL,
      si69_codorgao character varying(2) NOT NULL,
      si69_codunidadesub character varying(8) NOT NULL,
      si69_nroprocadesao character varying(12) NOT NULL,
      si69_exercicioadesao bigint DEFAULT 0 NOT NULL,
      si69_coditem bigint DEFAULT 0 NOT NULL,
      si69_nroitem bigint DEFAULT 0 NOT NULL,
      si69_mes bigint DEFAULT 0 NOT NULL,
      si69_reg10 bigint DEFAULT 0 NOT NULL,
      si69_instit bigint DEFAULT 0
  );


  ALTER TABLE regadesao122019 OWNER TO dbportal;

  --
  -- Name: regadesao122019_si69_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE regadesao122019_si69_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE regadesao122019_si69_sequencial_seq OWNER TO dbportal;

  --
  -- Name: regadesao132019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE regadesao132019 (
      si70_sequencial bigint DEFAULT 0 NOT NULL,
      si70_tiporegistro bigint DEFAULT 0 NOT NULL,
      si70_codorgao character varying(2) NOT NULL,
      si70_codunidadesub character varying(8) NOT NULL,
      si70_nroprocadesao character varying(12) NOT NULL,
      si70_exercicioadesao bigint DEFAULT 0 NOT NULL,
      si70_nrolote bigint DEFAULT 0 NOT NULL,
      si70_coditem bigint DEFAULT 0 NOT NULL,
      si70_mes bigint DEFAULT 0 NOT NULL,
      si70_reg10 bigint DEFAULT 0 NOT NULL,
      si70_instit bigint DEFAULT 0
  );


  ALTER TABLE regadesao132019 OWNER TO dbportal;

  --
  -- Name: regadesao132019_si70_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE regadesao132019_si70_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE regadesao132019_si70_sequencial_seq OWNER TO dbportal;

  --
  -- Name: regadesao142019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE regadesao142019 (
      si71_sequencial bigint DEFAULT 0 NOT NULL,
      si71_tiporegistro bigint DEFAULT 0 NOT NULL,
      si71_codorgao character varying(2) NOT NULL,
      si71_codunidadesub character varying(8) NOT NULL,
      si71_nroprocadesao character varying(12) NOT NULL,
      si71_exercicioadesao bigint DEFAULT 0 NOT NULL,
      si71_nrolote bigint DEFAULT 0,
      si71_coditem bigint DEFAULT 0 NOT NULL,
      si71_dtcotacao date NOT NULL,
      si71_vlcotprecosunitario double precision DEFAULT 0 NOT NULL,
      si71_quantidade double precision DEFAULT 0 NOT NULL,
      si71_mes bigint DEFAULT 0 NOT NULL,
      si71_reg10 bigint DEFAULT 0 NOT NULL,
      si71_instit bigint DEFAULT 0
  );


  ALTER TABLE regadesao142019 OWNER TO dbportal;

  --
  -- Name: regadesao142019_si71_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE regadesao142019_si71_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE regadesao142019_si71_sequencial_seq OWNER TO dbportal;

  --
  -- Name: regadesao152019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE regadesao152019 (
      si72_sequencial bigint DEFAULT 0 NOT NULL,
      si72_tiporegistro bigint DEFAULT 0 NOT NULL,
      si72_codorgao character varying(2) NOT NULL,
      si72_codunidadesub character varying(8) NOT NULL,
      si72_nroprocadesao character varying(12) NOT NULL,
      si72_exercicioadesao bigint DEFAULT 0 NOT NULL,
      si72_nrolote bigint DEFAULT 0,
      si72_coditem bigint DEFAULT 0 NOT NULL,
      si72_precounitario double precision DEFAULT 0 NOT NULL,
      si72_quantidadelicitada double precision DEFAULT 0 NOT NULL,
      si72_quantidadeaderida double precision DEFAULT 0 NOT NULL,
      si72_tipodocumento bigint DEFAULT 0 NOT NULL,
      si72_nrodocumento character varying(14) NOT NULL,
      si72_mes bigint DEFAULT 0 NOT NULL,
      si72_reg10 bigint DEFAULT 0 NOT NULL,
      si72_instit bigint DEFAULT 0
  );


  ALTER TABLE regadesao152019 OWNER TO dbportal;

  --
  -- Name: regadesao152019_si72_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE regadesao152019_si72_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE regadesao152019_si72_sequencial_seq OWNER TO dbportal;

  --
  -- Name: regadesao202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE regadesao202019 (
      si73_sequencial bigint DEFAULT 0 NOT NULL,
      si73_tiporegistro bigint DEFAULT 0 NOT NULL,
      si73_codorgao character varying(2) NOT NULL,
      si73_codunidadesub character varying(8) NOT NULL,
      si73_nroprocadesao character varying(12) NOT NULL,
      si73_exercicioadesao bigint DEFAULT 0 NOT NULL,
      si73_nrolote bigint DEFAULT 0,
      si73_coditem bigint DEFAULT 0,
      si73_percdesconto double precision DEFAULT 0 NOT NULL,
      si73_tipodocumento bigint DEFAULT 0 NOT NULL,
      si73_nrodocumento character varying(14) NOT NULL,
      si73_mes bigint DEFAULT 0 NOT NULL,
      si73_instit bigint DEFAULT 0
  );


  ALTER TABLE regadesao202019 OWNER TO dbportal;

  --
  -- Name: regadesao202019_si73_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE regadesao202019_si73_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE regadesao202019_si73_sequencial_seq OWNER TO dbportal;

  --
  -- Name: reglic102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE reglic102019 (
      si44_sequencial bigint DEFAULT 0 NOT NULL,
      si44_tiporegistro bigint DEFAULT 0 NOT NULL,
      si44_codorgao character varying(2) NOT NULL,
      si44_tipodecreto bigint DEFAULT 0 NOT NULL,
      si44_nrodecretomunicipal bigint DEFAULT 0 NOT NULL,
      si44_datadecretomunicipal date NOT NULL,
      si44_datapublicacaodecretomunicipal date NOT NULL,
      si44_mes bigint DEFAULT 0 NOT NULL,
      si44_instit bigint DEFAULT 0
  );


  ALTER TABLE reglic102019 OWNER TO dbportal;

  --
  -- Name: reglic102019_si44_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE reglic102019_si44_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE reglic102019_si44_sequencial_seq OWNER TO dbportal;

  --
  -- Name: reglic202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE reglic202019 (
      si45_sequencial bigint DEFAULT 0 NOT NULL,
      si45_tiporegistro bigint DEFAULT 0 NOT NULL,
      si45_codorgao character varying(2) NOT NULL,
      si45_regulamentart47 bigint DEFAULT 0 NOT NULL,
      si45_nronormareg character varying(6),
      si45_datanormareg date,
      si45_datapubnormareg date,
      si45_regexclusiva bigint DEFAULT 0,
      si45_artigoregexclusiva character varying(6),
      si45_valorlimiteregexclusiva double precision DEFAULT 0 NOT NULL,
      si45_procsubcontratacao bigint DEFAULT 0,
      si45_artigoprocsubcontratacao character varying(6),
      si45_percentualsubcontratacao double precision DEFAULT 0 NOT NULL,
      si45_criteriosempenhopagamento bigint DEFAULT 0,
      si45_artigoempenhopagamento character varying(6),
      si45_estabeleceuperccontratacao bigint DEFAULT 0,
      si45_artigoperccontratacao character varying(6),
      si45_percentualcontratacao double precision DEFAULT 0 NOT NULL,
      si45_mes bigint DEFAULT 0 NOT NULL,
      si45_instit bigint DEFAULT 0
  );


  ALTER TABLE reglic202019 OWNER TO dbportal;

  --
  -- Name: reglic202019_si45_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE reglic202019_si45_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE reglic202019_si45_sequencial_seq OWNER TO dbportal;

  --
  -- Name: resplic102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE resplic102019 (
      si55_sequencial bigint DEFAULT 0 NOT NULL,
      si55_tiporegistro bigint DEFAULT 0 NOT NULL,
      si55_codorgao character varying(2) NOT NULL,
      si55_codunidadesub character varying(8) NOT NULL,
      si55_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si55_nroprocessolicitatorio character varying(12) NOT NULL,
      si55_tiporesp bigint DEFAULT 0 NOT NULL,
      si55_nrocpfresp character varying(11) NOT NULL,
      si55_mes bigint DEFAULT 0 NOT NULL,
      si55_instit bigint DEFAULT 0
  );


  ALTER TABLE resplic102019 OWNER TO dbportal;

  --
  -- Name: resplic102019_si55_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE resplic102019_si55_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE resplic102019_si55_sequencial_seq OWNER TO dbportal;

  --
  -- Name: resplic202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE resplic202019 (
      si56_sequencial bigint DEFAULT 0 NOT NULL,
      si56_tiporegistro bigint DEFAULT 0 NOT NULL,
      si56_codorgao character varying(2) NOT NULL,
      si56_codunidadesub character varying(8) NOT NULL,
      si56_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
      si56_nroprocessolicitatorio character varying(12) NOT NULL,
      si56_codtipocomissao bigint DEFAULT 0 NOT NULL,
      si56_descricaoatonomeacao bigint DEFAULT 0 NOT NULL,
      si56_nroatonomeacao bigint DEFAULT 0 NOT NULL,
      si56_dataatonomeacao date NOT NULL,
      si56_iniciovigencia date NOT NULL,
      si56_finalvigencia date NOT NULL,
      si56_cpfmembrocomissao character varying(11) NOT NULL,
      si56_codatribuicao bigint DEFAULT 0 NOT NULL,
      si56_cargo character varying(50) NOT NULL,
      si56_naturezacargo bigint DEFAULT 0 NOT NULL,
      si56_mes bigint DEFAULT 0 NOT NULL,
      si56_instit bigint DEFAULT 0
  );


  ALTER TABLE resplic202019 OWNER TO dbportal;

  --
  -- Name: resplic202019_si56_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE resplic202019_si56_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE resplic202019_si56_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rsp102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rsp102019 (
      si112_sequencial bigint DEFAULT 0 NOT NULL,
      si112_tiporegistro bigint DEFAULT 0 NOT NULL,
      si112_codreduzidorsp bigint DEFAULT 0 NOT NULL,
      si112_codorgao character varying(2) NOT NULL,
      si112_codunidadesub character varying(8) NOT NULL,
      si112_codunidadesuborig character varying(8) NOT NULL,
      si112_nroempenho bigint DEFAULT 0 NOT NULL,
      si112_exercicioempenho bigint DEFAULT 0 NOT NULL,
      si112_dtempenho date NOT NULL,
      si112_dotorig character varying(21),
      si112_vloriginal double precision DEFAULT 0 NOT NULL,
      si112_vlsaldoantproce double precision DEFAULT 0 NOT NULL,
      si112_vlsaldoantnaoproc double precision DEFAULT 0 NOT NULL,
      si112_mes bigint DEFAULT 0 NOT NULL,
      si112_instit bigint DEFAULT 0
  );


  ALTER TABLE rsp102019 OWNER TO dbportal;

  --
  -- Name: rsp102019_si112_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rsp102019_si112_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rsp102019_si112_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rsp112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rsp112019 (
      si113_sequencial bigint DEFAULT 0 NOT NULL,
      si113_tiporegistro bigint DEFAULT 0 NOT NULL,
      si113_codreduzidorsp bigint DEFAULT 0 NOT NULL,
      si113_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si113_vloriginalfonte double precision DEFAULT 0 NOT NULL,
      si113_vlsaldoantprocefonte double precision DEFAULT 0 NOT NULL,
      si113_vlsaldoantnaoprocfonte double precision DEFAULT 0 NOT NULL,
      si113_mes bigint DEFAULT 0 NOT NULL,
      si113_reg10 bigint DEFAULT 0 NOT NULL,
      si113_instit bigint DEFAULT 0
  );


  ALTER TABLE rsp112019 OWNER TO dbportal;

  --
  -- Name: rsp112019_si113_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rsp112019_si113_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rsp112019_si113_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rsp122019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rsp122019 (
      si114_sequencial bigint DEFAULT 0 NOT NULL,
      si114_tiporegistro bigint DEFAULT 0 NOT NULL,
      si114_codreduzidorsp bigint DEFAULT 0 NOT NULL,
      si114_tipodocumento bigint DEFAULT 0 NOT NULL,
      si114_nrodocumento character varying(14) NOT NULL,
      si114_mes bigint DEFAULT 0 NOT NULL,
      si114_reg10 bigint DEFAULT 0 NOT NULL,
      si114_instit bigint DEFAULT 0
  );


  ALTER TABLE rsp122019 OWNER TO dbportal;

  --
  -- Name: rsp122019_si114_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rsp122019_si114_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rsp122019_si114_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rsp202019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rsp202019 (
      si115_sequencial bigint DEFAULT 0 NOT NULL,
      si115_tiporegistro bigint DEFAULT 0 NOT NULL,
      si115_codreduzidomov bigint DEFAULT 0 NOT NULL,
      si115_codorgao character varying(2) NOT NULL,
      si115_codunidadesub character varying(8) NOT NULL,
      si115_codunidadesuborig character varying(8) NOT NULL,
      si115_nroempenho bigint DEFAULT 0 NOT NULL,
      si115_exercicioempenho bigint DEFAULT 0 NOT NULL,
      si115_dtempenho date NOT NULL,
      si115_tiporestospagar bigint DEFAULT 0 NOT NULL,
      si115_tipomovimento bigint DEFAULT 0 NOT NULL,
      si115_dtmovimentacao date NOT NULL,
      si115_dotorig character varying(21),
      si115_vlmovimentacao double precision DEFAULT 0 NOT NULL,
      si115_codorgaoencampatribuic character varying(2),
      si115_codunidadesubencampatribuic character varying(8),
      si115_justificativa character varying(500) NOT NULL,
      si115_atocancelamento character varying(20),
      si115_dataatocancelamento date,
      si115_mes bigint DEFAULT 0 NOT NULL,
      si115_instit bigint DEFAULT 0
  );


  ALTER TABLE rsp202019 OWNER TO dbportal;

  --
  -- Name: rsp202019_si115_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rsp202019_si115_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rsp202019_si115_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rsp212019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rsp212019 (
      si116_sequencial bigint DEFAULT 0 NOT NULL,
      si116_tiporegistro bigint DEFAULT 0 NOT NULL,
      si116_codreduzidomov bigint DEFAULT 0 NOT NULL,
      si116_codfontrecursos bigint DEFAULT 0 NOT NULL,
      si116_vlmovimentacaofonte double precision DEFAULT 0 NOT NULL,
      si116_mes bigint DEFAULT 0 NOT NULL,
      si116_reg20 bigint DEFAULT 0 NOT NULL,
      si116_instit bigint DEFAULT 0
  );


  ALTER TABLE rsp212019 OWNER TO dbportal;

  --
  -- Name: rsp212019_si116_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rsp212019_si116_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rsp212019_si116_sequencial_seq OWNER TO dbportal;

  --
  -- Name: rsp222019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE TABLE rsp222019 (
      si117_sequencial bigint DEFAULT 0 NOT NULL,
      si117_tiporegistro bigint DEFAULT 0 NOT NULL,
      si117_codreduzidomov bigint DEFAULT 0 NOT NULL,
      si117_tipodocumento bigint DEFAULT 0 NOT NULL,
      si117_nrodocumento character varying(14) NOT NULL,
      si117_mes bigint DEFAULT 0 NOT NULL,
      si117_reg20 bigint DEFAULT 0 NOT NULL,
      si117_instit bigint DEFAULT 0
  );


  ALTER TABLE rsp222019 OWNER TO dbportal;

  --
  -- Name: rsp222019_si117_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  CREATE SEQUENCE rsp222019_si117_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE rsp222019_si117_sequencial_seq OWNER TO dbportal;

  --
  -- Name: supdef102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE supdef102019 (
  --     si167_sequencial bigint DEFAULT 0 NOT NULL,
  --     si167_tiporegistro bigint DEFAULT 0 NOT NULL,
  --     si167_superavitdeficit character varying(1) DEFAULT 0 NOT NULL,
  --     si167_vlapurado double precision DEFAULT 0 NOT NULL,
  --     si167_mes bigint DEFAULT 0 NOT NULL,
  --     si167_instit bigint DEFAULT 0
  -- );


  -- ALTER TABLE supdef102019 OWNER TO dbportal;

  --
  -- Name: supdef102019_si167_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  --

  -- CREATE SEQUENCE supdef102019_si167_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE supdef102019_si167_sequencial_seq OWNER TO dbportal;

  --
  -- Name: supdef112019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE TABLE supdef112019 ( -- todo revisar tabela
  --     si168_sequencial bigint DEFAULT 0 NOT NULL,
  --     si168_tiporegistro bigint DEFAULT 0 NOT NULL,
  --     si168_codfontrecursos bigint DEFAULT 0 NOT NULL,
  --     si168_superavitdeficit character varying(1) DEFAULT 0 NOT NULL,
  --     si168_vlapuradofonte double precision DEFAULT 0 NOT NULL,
  --     si168_mes bigint DEFAULT 0 NOT NULL,
  --     si168_reg10 bigint DEFAULT 0 NOT NULL,
  --     si168_instit bigint DEFAULT 0
  -- );


  -- ALTER TABLE supdef112019 OWNER TO dbportal;

  -- --
  -- -- Name: supdef112019_si168_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
  -- --

  -- CREATE SEQUENCE supdef112019_si168_sequencial_seq
  --     START WITH 1
  --     INCREMENT BY 1
  --     NO MINVALUE
  --     NO MAXVALUE
  --     CACHE 1;


  -- ALTER TABLE supdef112019_si168_sequencial_seq OWNER TO dbportal;

  --
  -- Name: aberlic102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aberlic102019
      ADD CONSTRAINT aberlic102019_sequ_pk PRIMARY KEY (si46_sequencial);


  --
  -- Name: aberlic112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aberlic112019
      ADD CONSTRAINT aberlic112019_sequ_pk PRIMARY KEY (si47_sequencial);


  --
  -- Name: aberlic122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aberlic122019
      ADD CONSTRAINT aberlic122019_sequ_pk PRIMARY KEY (si48_sequencial);


  --
  -- Name: aberlic132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aberlic132019
      ADD CONSTRAINT aberlic132019_sequ_pk PRIMARY KEY (si49_sequencial);


  --
  -- Name: aberlic142019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aberlic142019
      ADD CONSTRAINT aberlic142019_sequ_pk PRIMARY KEY (si50_sequencial);


  --
  -- Name: aberlic152019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aberlic152019
      ADD CONSTRAINT aberlic152019_sequ_pk PRIMARY KEY (si51_sequencial);


  --
  -- Name: aberlic162019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aberlic162019
      ADD CONSTRAINT aberlic162019_sequ_pk PRIMARY KEY (si52_sequencial);


  --
  -- Name: aex112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aex102019
      ADD CONSTRAINT aex112019_sequ_pk PRIMARY KEY (si130_sequencial);


  --
  -- Name: alq102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY alq102019
      ADD CONSTRAINT alq102019_sequ_pk PRIMARY KEY (si121_sequencial);


  --
  -- Name: alq112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY alq112019
      ADD CONSTRAINT alq112019_sequ_pk PRIMARY KEY (si122_sequencial);


  --
  -- Name: alq122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY alq122019
      ADD CONSTRAINT alq122019_sequ_pk PRIMARY KEY (si123_sequencial);


  --
  -- Name: anl102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY anl102019
      ADD CONSTRAINT anl102019_sequ_pk PRIMARY KEY (si110_sequencial);


  --
  -- Name: anl112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY anl112019
      ADD CONSTRAINT anl112019_sequ_pk PRIMARY KEY (si111_sequencial);


  --
  -- Name: aob102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aob102019
      ADD CONSTRAINT aob102019_sequ_pk PRIMARY KEY (si141_sequencial);


  --
  -- Name: aob112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aob112019
      ADD CONSTRAINT aob112019_sequ_pk PRIMARY KEY (si142_sequencial);


  --
  -- Name: aoc102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aoc102019
      ADD CONSTRAINT aoc102019_sequ_pk PRIMARY KEY (si38_sequencial);


  --
  -- Name: aoc112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aoc112019
      ADD CONSTRAINT aoc112019_sequ_pk PRIMARY KEY (si39_sequencial);


  --
  -- Name: aoc122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aoc122019
      ADD CONSTRAINT aoc122019_sequ_pk PRIMARY KEY (si40_sequencial);


  --
  -- Name: aoc132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aoc132019
      ADD CONSTRAINT aoc132019_sequ_pk PRIMARY KEY (si41_sequencial);


  --
  -- Name: aoc142019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aoc142019
      ADD CONSTRAINT aoc142019_sequ_pk PRIMARY KEY (si42_sequencial);


  --
  -- Name: aop102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aop102019
      ADD CONSTRAINT aop102019_sequ_pk PRIMARY KEY (si137_sequencial);


  --
  -- Name: aop112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY aop112019
      ADD CONSTRAINT aop112019_sequ_pk PRIMARY KEY (si138_sequencial);


  --
  -- Name: arc102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY arc102019
      ADD CONSTRAINT arc102019_sequ_pk PRIMARY KEY (si28_sequencial);


  --
  -- Name: arc112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY arc112019
      ADD CONSTRAINT arc112019_sequ_pk PRIMARY KEY (si29_sequencial);


  --
  -- Name: arc122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY arc122019
      ADD CONSTRAINT arc122019_sequ_pk PRIMARY KEY (si30_sequencial);


  --
  -- Name: arc202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY arc202019
      ADD CONSTRAINT arc202019_sequ_pk PRIMARY KEY (si31_sequencial);


  --
  -- Name: arc212019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY arc212019
      ADD CONSTRAINT arc212019_sequ_pk PRIMARY KEY (si32_sequencial);


  --
  -- Name: balancete102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete102019
      ADD CONSTRAINT balancete102019_sequ_pk PRIMARY KEY (si177_sequencial);


  --
  -- Name: balancete112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete112019
      ADD CONSTRAINT balancete112019_sequ_pk PRIMARY KEY (si178_sequencial);


  --
  -- Name: balancete122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete122019
      ADD CONSTRAINT balancete122019_sequ_pk PRIMARY KEY (si179_sequencial);


  --
  -- Name: balancete132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete132019
      ADD CONSTRAINT balancete132019_sequ_pk PRIMARY KEY (si180_sequencial);


  --
  -- Name: balancete142019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete142019
      ADD CONSTRAINT balancete142019_sequ_pk PRIMARY KEY (si181_sequencial);


  --
  -- Name: balancete152019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete152019
      ADD CONSTRAINT balancete152019_sequ_pk PRIMARY KEY (si182_sequencial);


  --
  -- Name: balancete162019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete162019
      ADD CONSTRAINT balancete162019_sequ_pk PRIMARY KEY (si183_sequencial);


  --
  -- Name: balancete172019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete172019
      ADD CONSTRAINT balancete172019_sequ_pk PRIMARY KEY (si184_sequencial);


  --
  -- Name: balancete182019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete182019
      ADD CONSTRAINT balancete182019_sequ_pk PRIMARY KEY (si185_sequencial);


  --
  -- Name: balancete192019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete192019
      ADD CONSTRAINT balancete192019_sequ_pk PRIMARY KEY (si186_sequencial);


  --
  -- Name: balancete202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete202019
      ADD CONSTRAINT balancete202019_sequ_pk PRIMARY KEY (si187_sequencial);


  --
  -- Name: balancete212019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete212019
      ADD CONSTRAINT balancete212019_sequ_pk PRIMARY KEY (si188_sequencial);


  --
  -- Name: balancete222019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete222019
      ADD CONSTRAINT balancete222019_sequ_pk PRIMARY KEY (si189_sequencial);


  --
  -- Name: balancete232019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete232019
      ADD CONSTRAINT balancete232019_sequ_pk PRIMARY KEY (si190_sequencial);


  --
  -- Name: balancete242019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete242019
      ADD CONSTRAINT balancete242019_sequ_pk PRIMARY KEY (si191_sequencial);


  --
  -- Name: balancete252019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete252019
      ADD CONSTRAINT balancete252019_sequ_pk PRIMARY KEY (si195_sequencial);

  --
  -- Name: balancete262019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete262019
      ADD CONSTRAINT balancete262019_sequ_pk PRIMARY KEY (si196_sequencial);

  --
  -- Name: balancete272019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete272019
      ADD CONSTRAINT balancete272019_sequ_pk PRIMARY KEY (si197_sequencial);

  --
  -- Name: balancete282019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY balancete282019
      ADD CONSTRAINT balancete282019_sequ_pk PRIMARY KEY (si198_sequencial);

  --
  -- Name: bfdcasp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bfdcasp102019
      ADD CONSTRAINT bfdcasp102019_sequ_pk PRIMARY KEY (si206_sequencial);


  --
  -- Name: bfdcasp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bfdcasp202019
      ADD CONSTRAINT bfdcasp202019_sequ_pk PRIMARY KEY (si207_sequencial);


  --
  -- Name: bodcasp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bodcasp102019
      ADD CONSTRAINT bodcasp102019_sequ_pk PRIMARY KEY (si201_sequencial);


  --
  -- Name: bodcasp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bodcasp202019
      ADD CONSTRAINT bodcasp202019_sequ_pk PRIMARY KEY (si202_sequencial);


  --
  -- Name: bodcasp302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bodcasp302019
      ADD CONSTRAINT bodcasp302019_sequ_pk PRIMARY KEY (si203_sequencial);


  --
  -- Name: bodcasp402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bodcasp402019
      ADD CONSTRAINT bodcasp402019_sequ_pk PRIMARY KEY (si204_sequencial);


  --
  -- Name: bodcasp502019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bodcasp502019
      ADD CONSTRAINT bodcasp502019_sequ_pk PRIMARY KEY (si205_sequencial);


  --
  -- Name: bpdcasp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp102019
      ADD CONSTRAINT bpdcasp102019_sequ_pk PRIMARY KEY (si208_sequencial);


  --
  -- Name: bpdcasp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp202019
      ADD CONSTRAINT bpdcasp202019_sequ_pk PRIMARY KEY (si209_sequencial);


  --
  -- Name: bpdcasp302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp302019
      ADD CONSTRAINT bpdcasp302019_sequ_pk PRIMARY KEY (si210_sequencial);


  --
  -- Name: bpdcasp402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp402019
      ADD CONSTRAINT bpdcasp402019_sequ_pk PRIMARY KEY (si211_sequencial);


  --
  -- Name: bpdcasp502019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp502019
      ADD CONSTRAINT bpdcasp502019_sequ_pk PRIMARY KEY (si212_sequencial);


  --
  -- Name: bpdcasp602019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp602019
      ADD CONSTRAINT bpdcasp602019_sequ_pk PRIMARY KEY (si213_sequencial);


  --
  -- Name: bpdcasp702019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp702019
      ADD CONSTRAINT bpdcasp702019_sequ_pk PRIMARY KEY (si214_sequencial);


  --
  -- Name: bpdcasp712019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY bpdcasp712019
      ADD CONSTRAINT bpdcasp712019_sequ_pk PRIMARY KEY (si215_sequencial);


  --
  -- Name: caixa102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY caixa102019
      ADD CONSTRAINT caixa102019_sequ_pk PRIMARY KEY (si103_sequencial);


  --
  -- Name: caixa112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY caixa112019
      ADD CONSTRAINT caixa112019_sequ_pk PRIMARY KEY (si166_sequencial);


  --
  -- Name: caixa122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY caixa122019
      ADD CONSTRAINT caixa122019_sequ_pk PRIMARY KEY (si104_sequencial);


  --
  -- Name: caixa132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY caixa132019
      ADD CONSTRAINT caixa132019_sequ_pk PRIMARY KEY (si105_sequencial);


  --
  -- Name: conge102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY conge102019
      ADD CONSTRAINT conge102019_sequ_pk PRIMARY KEY (si182_sequencial);

  --
  -- Name: conge202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY conge202019
      ADD CONSTRAINT conge202019_sequ_pk PRIMARY KEY (si183_sequencial);

  --
  -- Name: conge302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY conge302019
      ADD CONSTRAINT conge302019_sequ_pk PRIMARY KEY (si184_sequencial);

  --
  -- Name: consor102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY consor102019
      ADD CONSTRAINT consor102019_sequ_pk PRIMARY KEY (si16_sequencial);


  --
  -- Name: consor202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY consor202019
      ADD CONSTRAINT consor202019_sequ_pk PRIMARY KEY (si17_sequencial);


  --
  -- Name: consor302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY consor302019
      ADD CONSTRAINT consor302019_sequ_pk PRIMARY KEY (si18_sequencial);


  --
  -- Name: consor402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY consor402019
      ADD CONSTRAINT consor402019_sequ_pk PRIMARY KEY (si19_sequencial);


  --
  -- Name: consor502019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY consor502019
      ADD CONSTRAINT consor502019_sequ_pk PRIMARY KEY (si20_sequencial);


  --
  -- Name: contratos102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos102019
      ADD CONSTRAINT contratos102019_sequ_pk PRIMARY KEY (si83_sequencial);


  --
  -- Name: contratos112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos112019
      ADD CONSTRAINT contratos112019_sequ_pk PRIMARY KEY (si84_sequencial);


  --
  -- Name: contratos122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos122019
      ADD CONSTRAINT contratos122019_sequ_pk PRIMARY KEY (si85_sequencial);


  --
  -- Name: contratos132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos132019
      ADD CONSTRAINT contratos132019_sequ_pk PRIMARY KEY (si86_sequencial);


  --
  -- Name: contratos202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos202019
      ADD CONSTRAINT contratos202019_sequ_pk PRIMARY KEY (si87_sequencial);


  --
  -- Name: contratos212019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos212019
      ADD CONSTRAINT contratos212019_sequ_pk PRIMARY KEY (si88_sequencial);


  --
  -- Name: contratos302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos302019
      ADD CONSTRAINT contratos302019_sequ_pk PRIMARY KEY (si89_sequencial);


  --
  -- Name: contratos402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY contratos402019
      ADD CONSTRAINT contratos402019_sequ_pk PRIMARY KEY (si91_sequencial);


  --
  -- Name: conv102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY conv102019
      ADD CONSTRAINT conv102019_sequ_pk PRIMARY KEY (si92_sequencial);


  --
  -- Name: conv112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY conv112019
      ADD CONSTRAINT conv112019_sequ_pk PRIMARY KEY (si93_sequencial);


  --
  -- Name: conv202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY conv202019
      ADD CONSTRAINT conv202019_sequ_pk PRIMARY KEY (si94_sequencial);

  --
  -- Name: conv302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY conv3002019
  --     ADD CONSTRAINT conv3002019_sequ_pk PRIMARY KEY (si203_sequencial);

  -- --
  -- -- Name: conv312019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  -- --

  -- ALTER TABLE ONLY conv3102019
  --     ADD CONSTRAINT conv3102019_sequ_pk PRIMARY KEY (si204_sequencial);

  --
  -- Name: cronem102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cronem102019
      ADD CONSTRAINT cronem102019_sequ_pk PRIMARY KEY (si170_sequencial);


  --
  -- Name: ctb102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb102019
      ADD CONSTRAINT ctb102019_sequ_pk PRIMARY KEY (si95_sequencial);


  --
  -- Name: ctb202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb202019
      ADD CONSTRAINT ctb202019_sequ_pk PRIMARY KEY (si96_sequencial);


  --
  -- Name: ctb212019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb212019
      ADD CONSTRAINT ctb212019_sequ_pk PRIMARY KEY (si97_sequencial);


  --
  -- Name: ctb222019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb222019
      ADD CONSTRAINT ctb222019_sequ_pk PRIMARY KEY (si98_sequencial);


  --
  -- Name: ctb302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb302019
      ADD CONSTRAINT ctb302019_sequ_pk PRIMARY KEY (si99_sequencial);


  --
  -- Name: ctb312019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb312019
      ADD CONSTRAINT ctb312019_sequ_pk PRIMARY KEY (si100_sequencial);


  --
  -- Name: ctb402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb402019
      ADD CONSTRAINT ctb402019_sequ_pk PRIMARY KEY (si101_sequencial);


  --
  -- Name: ctb502019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ctb502019
      ADD CONSTRAINT ctb502019_sequ_pk PRIMARY KEY (si102_sequencial);


  --
  -- Name: cute102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cute102019
      ADD CONSTRAINT cute102019_sequ_pk PRIMARY KEY (si199_sequencial);

  --
  -- Name: cute202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cute202019
      ADD CONSTRAINT cute202019_sequ_pk PRIMARY KEY (si200_sequencial);

  --
  -- Name: cute212019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cute212019
      ADD CONSTRAINT cute212019_sequ_pk PRIMARY KEY (si201_sequencial);

  --
  -- Name: cute302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cute302019
      ADD CONSTRAINT cute302019_sequ_pk PRIMARY KEY (si202_sequencial);


  --
  -- Name: cvc102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cvc102019
      ADD CONSTRAINT cvc102019_sequ_pk PRIMARY KEY (si146_sequencial);


  --
  -- Name: cvc202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cvc202019
      ADD CONSTRAINT cvc202019_sequ_pk PRIMARY KEY (si147_sequencial);


  --
  -- Name: cvc302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cvc302019
      ADD CONSTRAINT cvc302019_sequ_pk PRIMARY KEY (si148_sequencial);


  --
  -- Name: cvc402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY cvc402019
      ADD CONSTRAINT cvc402019_sequ_pk PRIMARY KEY (si149_sequencial);


  --
  -- Name: dclrf102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dclrf102019
      ADD CONSTRAINT dclrf102019_sequ_pk PRIMARY KEY (si157_sequencial);

  --
  -- Name: dclrf112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dclrf112019
      ADD CONSTRAINT dclrf112019_sequ_pk PRIMARY KEY (si205_sequencial);


  --
  -- Name: dclrf202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dclrf202019
      ADD CONSTRAINT dclrf202019_sequ_pk PRIMARY KEY (si191_sequencial);


  --
  -- Name: dclrf302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dclrf302019
      ADD CONSTRAINT dclrf302019_sequ_pk PRIMARY KEY (si192_sequencial);


  --
  -- Name: ddc102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ddc102019
      ADD CONSTRAINT ddc102019_sequ_pk PRIMARY KEY (si150_sequencial);

  --
  -- Name: ddc202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ddc202019
      ADD CONSTRAINT ddc202019_sequ_pk PRIMARY KEY (si153_sequencial);


  --
  -- Name: ddc302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ddc302019
      ADD CONSTRAINT ddc302019_sequ_pk PRIMARY KEY (si154_sequencial);


  --
  -- Name: ddc402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ddc402019
      ADD CONSTRAINT ddc402019_sequ_pk PRIMARY KEY (si178_sequencial);


  --
  -- Name: dfcdcasp1002019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp1002019
      ADD CONSTRAINT dfcdcasp1002019_sequ_pk PRIMARY KEY (si228_sequencial);


  --
  -- Name: dfcdcasp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp102019
      ADD CONSTRAINT dfcdcasp102019_sequ_pk PRIMARY KEY (si219_sequencial);


  --
  -- Name: dfcdcasp1102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp1102019
      ADD CONSTRAINT dfcdcasp1102019_sequ_pk PRIMARY KEY (si229_sequencial);


  --
  -- Name: dfcdcasp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp202019
      ADD CONSTRAINT dfcdcasp202019_sequ_pk PRIMARY KEY (si220_sequencial);


  --
  -- Name: dfcdcasp302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp302019
      ADD CONSTRAINT dfcdcasp302019_sequ_pk PRIMARY KEY (si221_sequencial);


  --
  -- Name: dfcdcasp402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp402019
      ADD CONSTRAINT dfcdcasp402019_sequ_pk PRIMARY KEY (si222_sequencial);


  --
  -- Name: dfcdcasp502019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp502019
      ADD CONSTRAINT dfcdcasp502019_sequ_pk PRIMARY KEY (si223_sequencial);


  --
  -- Name: dfcdcasp602019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp602019
      ADD CONSTRAINT dfcdcasp602019_sequ_pk PRIMARY KEY (si224_sequencial);


  --
  -- Name: dfcdcasp702019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp702019
      ADD CONSTRAINT dfcdcasp702019_sequ_pk PRIMARY KEY (si225_sequencial);


  --
  -- Name: dfcdcasp802019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp802019
      ADD CONSTRAINT dfcdcasp802019_sequ_pk PRIMARY KEY (si226_sequencial);


  --
  -- Name: dfcdcasp902019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dfcdcasp902019
      ADD CONSTRAINT dfcdcasp902019_sequ_pk PRIMARY KEY (si227_sequencial);


  --
  -- Name: dispensa102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa102019
      ADD CONSTRAINT dispensa102019_sequ_pk PRIMARY KEY (si74_sequencial);


  --
  -- Name: dispensa112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa112019
      ADD CONSTRAINT dispensa112019_sequ_pk PRIMARY KEY (si75_sequencial);


  --
  -- Name: dispensa122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa122019
      ADD CONSTRAINT dispensa122019_sequ_pk PRIMARY KEY (si76_sequencial);


  --
  -- Name: dispensa132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa132019
      ADD CONSTRAINT dispensa132019_sequ_pk PRIMARY KEY (si77_sequencial);


  --
  -- Name: dispensa142019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa142019
      ADD CONSTRAINT dispensa142019_sequ_pk PRIMARY KEY (si78_sequencial);


  --
  -- Name: dispensa152019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa152019
      ADD CONSTRAINT dispensa152019_sequ_pk PRIMARY KEY (si79_sequencial);


  --
  -- Name: dispensa162019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa162019
      ADD CONSTRAINT dispensa162019_sequ_pk PRIMARY KEY (si80_sequencial);


  --
  -- Name: dispensa172019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa172019
      ADD CONSTRAINT dispensa172019_sequ_pk PRIMARY KEY (si81_sequencial);


  --
  -- Name: dispensa182019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dispensa182019
      ADD CONSTRAINT dispensa182019_sequ_pk PRIMARY KEY (si82_sequencial);


  --
  -- Name: dvpdcasp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dvpdcasp102019
      ADD CONSTRAINT dvpdcasp102019_sequ_pk PRIMARY KEY (si216_sequencial);


  --
  -- Name: dvpdcasp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dvpdcasp202019
      ADD CONSTRAINT dvpdcasp202019_sequ_pk PRIMARY KEY (si217_sequencial);


  --
  -- Name: dvpdcasp302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY dvpdcasp302019
      ADD CONSTRAINT dvpdcasp302019_sequ_pk PRIMARY KEY (si218_sequencial);


  --
  -- Name: emp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY emp102019
      ADD CONSTRAINT emp102019_sequ_pk PRIMARY KEY (si106_sequencial);


  --
  -- Name: emp112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY emp112019
      ADD CONSTRAINT emp112019_sequ_pk PRIMARY KEY (si107_sequencial);


  --
  -- Name: emp122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY emp122019
      ADD CONSTRAINT emp122019_sequ_pk PRIMARY KEY (si108_sequencial);


  --
  -- Name: emp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY emp202019
      ADD CONSTRAINT emp202019_sequ_pk PRIMARY KEY (si109_sequencial);

  --
  -- Name: emp302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY emp302019
      ADD CONSTRAINT emp302019_sequ_pk PRIMARY KEY (si206_sequencial);


  --
  -- Name: ext102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ext102019
      ADD CONSTRAINT ext102019_sequ_pk PRIMARY KEY (si124_sequencial);


  --
  -- Name: ext202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ext202019
      ADD CONSTRAINT ext202019_sequ_pk PRIMARY KEY (si165_sequencial);


  --
  -- Name: ext302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ext302019
      ADD CONSTRAINT ext302019_sequ_pk PRIMARY KEY (si126_sequencial);


  --
  -- Name: ext312019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ext312019
      ADD CONSTRAINT ext312019_sequ_pk PRIMARY KEY (si127_sequencial);


  --
  -- Name: ext322019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ext322019
      ADD CONSTRAINT ext322019_sequ_pk PRIMARY KEY (si128_sequencial);

  --
  -- Name: hablic102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY hablic102019
      ADD CONSTRAINT hablic102019_sequ_pk PRIMARY KEY (si57_sequencial);


  --
  -- Name: hablic112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY hablic112019
      ADD CONSTRAINT hablic112019_sequ_pk PRIMARY KEY (si58_sequencial);


  --
  -- Name: hablic202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY hablic202019
      ADD CONSTRAINT hablic202019_sequ_pk PRIMARY KEY (si59_sequencial);


  --
  -- Name: homolic102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY homolic102019
      ADD CONSTRAINT homolic102019_sequ_pk PRIMARY KEY (si63_sequencial);


  --
  -- Name: homolic202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY homolic202019
      ADD CONSTRAINT homolic202019_sequ_pk PRIMARY KEY (si64_sequencial);

  --
  -- Name: homolic302019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY homolic302019
      ADD CONSTRAINT homolic302019_sequ_pk PRIMARY KEY (si65_sequencial);


  --
  -- Name: homolic402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY homolic402019
      ADD CONSTRAINT homolic402019_sequ_pk PRIMARY KEY (si65_sequencial);

  --
  -- Name: idedcasp2019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY idedcasp2019
      ADD CONSTRAINT idedcasp2019_sequ_pk PRIMARY KEY (si200_sequencial);

  -- Name: iderp2019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY iderp102019
      ADD CONSTRAINT iderp102019_sequ_pk PRIMARY KEY (si179_sequencial);
  --
  -- Name: iderp2019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY iderp112019
      ADD CONSTRAINT iderp112019_sequ_pk PRIMARY KEY (si180_sequencial);

  --
  -- Name: iderp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY iderp202019
      ADD CONSTRAINT iderp202019_sequ_pk PRIMARY KEY (si181_sequencial);


  --
  -- Name: incamp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY incamp102019
  --     ADD CONSTRAINT incamp102019_sequ_pk PRIMARY KEY (si160_sequencial);


  --
  -- Name: incamp112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY incamp112019
  --     ADD CONSTRAINT incamp112019_sequ_pk PRIMARY KEY (si161_sequencial);


  --
  -- Name: incamp122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY incamp122019
  --     ADD CONSTRAINT incamp122019_sequ_pk PRIMARY KEY (si162_sequencial);


  --
  -- Name: incorgao2019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY incorgao2019
  --     ADD CONSTRAINT incorgao2019_sequ_pk PRIMARY KEY (si163_sequencial);


  --
  -- Name: incpro2019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY incpro2019
  --     ADD CONSTRAINT incpro2019_sequ_pk PRIMARY KEY (si159_sequencial);


  --
  -- Name: item102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY item102019
      ADD CONSTRAINT item102019_sequ_pk PRIMARY KEY (si43_sequencial);


  --
  -- Name: iuoc2019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY iuoc2019
  --     ADD CONSTRAINT iuoc2019_sequ_pk PRIMARY KEY (si164_sequencial);


  --
  -- Name: julglic102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY julglic102019
      ADD CONSTRAINT julglic102019_sequ_pk PRIMARY KEY (si60_sequencial);


  --
  -- Name: julglic202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY julglic202019
      ADD CONSTRAINT julglic202019_sequ_pk PRIMARY KEY (si61_sequencial);


  --
  -- Name: julglic402019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY julglic402019
      ADD CONSTRAINT julglic402019_sequ_pk PRIMARY KEY (si62_sequencial);


  --
  -- Name: lao102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY lao102019
      ADD CONSTRAINT lao102019_sequ_pk PRIMARY KEY (si34_sequencial);


  --
  -- Name: lao112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY lao112019
      ADD CONSTRAINT lao112019_sequ_pk PRIMARY KEY (si35_sequencial);


  --
  -- Name: lao202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY lao202019
      ADD CONSTRAINT lao202019_sequ_pk PRIMARY KEY (si36_sequencial);


  --
  -- Name: lao212019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY lao212019
      ADD CONSTRAINT lao212019_sequ_pk PRIMARY KEY (si37_sequencial);


  --
  -- Name: lqd102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY lqd102019
      ADD CONSTRAINT lqd102019_sequ_pk PRIMARY KEY (si118_sequencial);


  --
  -- Name: lqd112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY lqd112019
      ADD CONSTRAINT lqd112019_sequ_pk PRIMARY KEY (si119_sequencial);


  --
  -- Name: lqd122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY lqd122019
      ADD CONSTRAINT lqd122019_sequ_pk PRIMARY KEY (si120_sequencial);


  --
  -- Name: metareal102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY metareal102019
      ADD CONSTRAINT metareal102019_sequ_pk PRIMARY KEY (si171_sequencial);


  --
  -- Name: ntf102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ntf102019
      ADD CONSTRAINT ntf102019_sequ_pk PRIMARY KEY (si143_sequencial);


  --
  -- Name: ntf112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ntf112019
      ADD CONSTRAINT ntf112019_sequ_pk PRIMARY KEY (si144_sequencial);


  --
  -- Name: ntf202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ntf202019
      ADD CONSTRAINT ntf202019_sequ_pk PRIMARY KEY (si145_sequencial);


  --
  -- Name: obelac102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY obelac102019
      ADD CONSTRAINT obelac102019_sequ_pk PRIMARY KEY (si139_sequencial);


  --
  -- Name: obelac112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY obelac112019
      ADD CONSTRAINT obelac112019_sequ_pk PRIMARY KEY (si140_sequencial);


  --
  -- Name: ops102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ops102019
      ADD CONSTRAINT ops102019_sequ_pk PRIMARY KEY (si132_sequencial);


  --
  -- Name: ops112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ops112019
      ADD CONSTRAINT ops112019_sequ_pk PRIMARY KEY (si133_sequencial);


  --
  -- Name: ops122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ops122019
      ADD CONSTRAINT ops122019_sequ_pk PRIMARY KEY (si134_sequencial);


  --
  -- Name: ops132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY ops132019
      ADD CONSTRAINT ops132019_sequ_pk PRIMARY KEY (si135_sequencial);

  --
  -- Name: orgao102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY orgao102019
      ADD CONSTRAINT orgao102019_sequ_pk PRIMARY KEY (si14_sequencial);


  --
  -- Name: orgao112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY orgao112019
      ADD CONSTRAINT orgao112019_sequ_pk PRIMARY KEY (si15_sequencial);


  --
  -- Name: parec102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY parec102019
      ADD CONSTRAINT parec102019_sequ_pk PRIMARY KEY (si22_sequencial);


  --
  -- Name: parec112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY parec112019
      ADD CONSTRAINT parec112019_sequ_pk PRIMARY KEY (si23_sequencial);


  --
  -- Name: parelic102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY parelic102019
      ADD CONSTRAINT parelic102019_sequ_pk PRIMARY KEY (si66_sequencial);


  --
  -- Name: parpps102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY parpps102019
      ADD CONSTRAINT parpps102019_sequ_pk PRIMARY KEY (si156_sequencial);


  --
  -- Name: parpps202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY parpps202019
      ADD CONSTRAINT parpps202019_sequ_pk PRIMARY KEY (si155_sequencial);

  --
  -- Name: pessoaflpgo102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY pessoaflpgo102019
  --     ADD CONSTRAINT pessoaflpgo102019_sequ_pk PRIMARY KEY (si193_sequencial);


  --
  -- Name: rec102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rec102019
      ADD CONSTRAINT rec102019_sequ_pk PRIMARY KEY (si25_sequencial);


  --
  -- Name: rec112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rec112019
      ADD CONSTRAINT rec112019_sequ_pk PRIMARY KEY (si26_sequencial);


  --
  -- Name: regadesao102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY regadesao102019
      ADD CONSTRAINT regadesao102019_sequ_pk PRIMARY KEY (si67_sequencial);


  --
  -- Name: regadesao112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY regadesao112019
      ADD CONSTRAINT regadesao112019_sequ_pk PRIMARY KEY (si68_sequencial);


  --
  -- Name: regadesao122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY regadesao122019
      ADD CONSTRAINT regadesao122019_sequ_pk PRIMARY KEY (si69_sequencial);


  --
  -- Name: regadesao132019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY regadesao132019
      ADD CONSTRAINT regadesao132019_sequ_pk PRIMARY KEY (si70_sequencial);


  --
  -- Name: regadesao142019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY regadesao142019
      ADD CONSTRAINT regadesao142019_sequ_pk PRIMARY KEY (si71_sequencial);


  --
  -- Name: regadesao152019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY regadesao152019
      ADD CONSTRAINT regadesao152019_sequ_pk PRIMARY KEY (si72_sequencial);


  --
  -- Name: regadesao202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY regadesao202019
      ADD CONSTRAINT regadesao202019_sequ_pk PRIMARY KEY (si73_sequencial);


  --
  -- Name: reglic102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY reglic102019
      ADD CONSTRAINT reglic102019_sequ_pk PRIMARY KEY (si44_sequencial);


  --
  -- Name: reglic202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY reglic202019
      ADD CONSTRAINT reglic202019_sequ_pk PRIMARY KEY (si45_sequencial);

  --
  -- Name: resplic102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY resplic102019
      ADD CONSTRAINT resplic102019_sequ_pk PRIMARY KEY (si55_sequencial);


  --
  -- Name: resplic202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY resplic202019
      ADD CONSTRAINT resplic202019_sequ_pk PRIMARY KEY (si56_sequencial);


  --
  -- Name: rsp102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rsp102019
      ADD CONSTRAINT rsp102019_sequ_pk PRIMARY KEY (si112_sequencial);


  --
  -- Name: rsp112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rsp112019
      ADD CONSTRAINT rsp112019_sequ_pk PRIMARY KEY (si113_sequencial);


  --
  -- Name: rsp122019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rsp122019
      ADD CONSTRAINT rsp122019_sequ_pk PRIMARY KEY (si114_sequencial);


  --
  -- Name: rsp202019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rsp202019
      ADD CONSTRAINT rsp202019_sequ_pk PRIMARY KEY (si115_sequencial);


  --
  -- Name: rsp212019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rsp212019
      ADD CONSTRAINT rsp212019_sequ_pk PRIMARY KEY (si116_sequencial);


  --
  -- Name: rsp222019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY rsp222019
      ADD CONSTRAINT rsp222019_sequ_pk PRIMARY KEY (si117_sequencial);


  --
  -- Name: supdef102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY supdef102019
  --     ADD CONSTRAINT supdef102019_sequ_pk PRIMARY KEY (si167_sequencial);


  --
  -- Name: supdef112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  -- ALTER TABLE ONLY supdef112019
  --     ADD CONSTRAINT supdef112019_sequ_pk PRIMARY KEY (si168_sequencial);


  --
  -- Name: tce102019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY tce102019
      ADD CONSTRAINT tce102019_sequ_pk PRIMARY KEY (si187_sequencial);

  --
  -- Name: tce112019_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
  --

  ALTER TABLE ONLY tce112019
      ADD CONSTRAINT tce112019_sequ_pk PRIMARY KEY (si188_sequencial);


  --
  -- Name: aberlic112019_si47_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aberlic112019_si47_reg10_index ON aberlic112019 USING btree (si47_reg10);


  --
  -- Name: aberlic122019_si48_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aberlic122019_si48_reg10_index ON aberlic122019 USING btree (si48_reg10);


  --
  -- Name: aberlic132019_si49_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aberlic132019_si49_reg10_index ON aberlic132019 USING btree (si49_reg10);


  --
  -- Name: aberlic142019_si50_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aberlic142019_si50_reg10_index ON aberlic142019 USING btree (si50_reg10);


  --
  -- Name: aberlic152019_si51_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aberlic152019_si51_reg10_index ON aberlic152019 USING btree (si51_reg10);


  --
  -- Name: aberlic162019_si52_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aberlic162019_si52_reg10_index ON aberlic162019 USING btree (si52_reg10);


  --
  -- Name: alq112019_si122_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX alq112019_si122_reg10_index ON alq112019 USING btree (si122_reg10);


  --
  -- Name: alq122019_si123_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX alq122019_si123_reg10_index ON alq122019 USING btree (si123_reg10);


  --
  -- Name: anl112019_si111_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX anl112019_si111_reg10_index ON anl112019 USING btree (si111_reg10);


  --
  -- Name: aob112019_si142_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aob112019_si142_reg10_index ON aob112019 USING btree (si142_reg10);


  --
  -- Name: aoc112019_si39_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aoc112019_si39_reg10_index ON aoc112019 USING btree (si39_reg10);


  --
  -- Name: aoc122019_si40_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aoc122019_si40_reg10_index ON aoc122019 USING btree (si40_reg10);


  --
  -- Name: aoc132019_si41_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aoc132019_si41_reg10_index ON aoc132019 USING btree (si41_reg10);


  --
  -- Name: aoc142019_si42_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aoc142019_si42_reg10_index ON aoc142019 USING btree (si42_reg10);


  --
  -- Name: aop112019_si138_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX aop112019_si138_reg10_index ON aop112019 USING btree (si138_reg10);


  --
  -- Name: arc112019_si15_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX arc112019_si15_reg10_index ON arc112019 USING btree (si29_reg10);


  --
  -- Name: arc122019_si30_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX arc122019_si30_reg10_index ON arc122019 USING btree (si30_reg10);


  --
  -- Name: arcwq2019_si32_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX arcwq2019_si32_reg20_index ON arc212019 USING btree (si32_reg20);


  --
  -- Name: caixa122019_si104_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX caixa122019_si104_reg10_index ON caixa122019 USING btree (si104_reg10);


  --
  -- Name: caixa132019_si105_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX caixa132019_si105_reg10_index ON caixa132019 USING btree (si105_reg10);


  --
  -- Name: contratos112019_si84_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX contratos112019_si84_reg10_index ON contratos112019 USING btree (si84_reg10);


  --
  -- Name: contratos122019_si85_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX contratos122019_si85_reg10_index ON contratos122019 USING btree (si85_reg10);


  --
  -- Name: contratos132019_si86_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX contratos132019_si86_reg10_index ON contratos132019 USING btree (si86_reg10);


  --
  -- Name: contratos212019_si88_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX contratos212019_si88_reg10_index ON contratos212019 USING btree (si88_reg20);

  --
  -- Name: conv312019_si204_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX conv312019_si204_reg10_index ON conv312019 USING btree (si204_reg10);

  --
  -- Name: cute212019_si201_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX cute212019_si201_reg10_index ON cute212019 USING btree (si201_reg10);


  --
  -- Name: conv112019_si93_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX conv112019_si93_reg10_index ON conv112019 USING btree (si93_reg10);


  --
  -- Name: ctb212019_si97_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ctb212019_si97_reg20_index ON ctb212019 USING btree (si97_reg20);


  --
  -- Name: ctb222019_si98_reg21_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ctb222019_si98_reg21_index ON ctb222019 USING btree (si98_reg21);


  --
  -- Name: ctb312019_si100_reg30_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ctb312019_si100_reg30_index ON ctb312019 USING btree (si100_reg30);

  --
  -- Name: dispensa112019_si75_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa112019_si75_reg10_index ON dispensa112019 USING btree (si75_reg10);


  --
  -- Name: dispensa122019_si76_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa122019_si76_reg10_index ON dispensa122019 USING btree (si76_reg10);


  --
  -- Name: dispensa132019_si77_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa132019_si77_reg10_index ON dispensa132019 USING btree (si77_reg10);


  --
  -- Name: dispensa142019_si78_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa142019_si78_reg10_index ON dispensa142019 USING btree (si78_reg10);


  --
  -- Name: dispensa152019_si79_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa152019_si79_reg10_index ON dispensa152019 USING btree (si79_reg10);


  --
  -- Name: dispensa162019_si80_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa162019_si80_reg10_index ON dispensa162019 USING btree (si80_reg10);


  --
  -- Name: dispensa172019_si81_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa172019_si81_reg10_index ON dispensa172019 USING btree (si81_reg10);


  --
  -- Name: dispensa182019_si82_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX dispensa182019_si82_reg10_index ON dispensa182019 USING btree (si82_reg10);


  --
  -- Name: emp112019_si107_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX emp112019_si107_reg10_index ON emp112019 USING btree (si107_reg10);


  --
  -- Name: emp122019_si108_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX emp122019_si108_reg10_index ON emp122019 USING btree (si108_reg10);


  --
  -- Name: ext312019_si127_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ext312019_si127_reg20_index ON ext312019 USING btree (si127_reg30);


  --
  -- Name: ext322019_si128_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ext322019_si128_reg20_index ON ext322019 USING btree (si128_reg30);

  --
  -- Name: hablic112019_si58_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX hablic112019_si58_reg10_index ON hablic112019 USING btree (si58_mes);


  --
  -- Name: incamp112019_si161_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE INDEX incamp112019_si161_reg10_index ON incamp112019 USING btree (si161_reg10);


  --
  -- Name: incamp122019_si162_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  -- CREATE INDEX incamp122019_si162_reg10_index ON incamp122019 USING btree (si162_reg10);


  --
  -- Name: lao112019_si35_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX lao112019_si35_reg10_index ON lao112019 USING btree (si35_reg10);


  --
  -- Name: lao212019_si37_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX lao212019_si37_reg20_index ON lao212019 USING btree (si37_reg20);


  --
  -- Name: lqd112019_si119_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX lqd112019_si119_reg10_index ON lqd112019 USING btree (si119_reg10);


  --
  -- Name: lqd122019_si120_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX lqd122019_si120_reg10_index ON lqd122019 USING btree (si120_reg10);


  --
  -- Name: ntf112019_si144_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ntf112019_si144_reg10_index ON ntf112019 USING btree (si144_reg10);


  --
  -- Name: obelac112019_si140_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX obelac112019_si140_reg10_index ON obelac112019 USING btree (si140_reg10);


  --
  -- Name: ops112019_si133_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ops112019_si133_reg10_index ON ops112019 USING btree (si133_reg10);


  --
  -- Name: ops122019_si134_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ops122019_si134_reg10_index ON ops122019 USING btree (si134_reg10);


  --
  -- Name: ops132019_si135_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX ops132019_si135_reg10_index ON ops132019 USING btree (si135_reg10);

  --
  -- Name: orgao112019_si15_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX orgao112019_si15_reg10_index ON orgao112019 USING btree (si15_reg10);


  --
  -- Name: parec112019_si23_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX parec112019_si23_reg10_index ON parec112019 USING btree (si23_reg10);


  --
  -- Name: rec112019_si26_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX rec112019_si26_reg10_index ON rec112019 USING btree (si26_reg10);


  --
  -- Name: regadesao112019_si68_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX regadesao112019_si68_reg10_index ON regadesao112019 USING btree (si68_reg10);


  --
  -- Name: regadesao122019_si69_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX regadesao122019_si69_reg10_index ON regadesao122019 USING btree (si69_reg10);


  --
  -- Name: regadesao132019_si70_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX regadesao132019_si70_reg10_index ON regadesao132019 USING btree (si70_reg10);


  --
  -- Name: regadesao142019_si71_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX regadesao142019_si71_reg10_index ON regadesao142019 USING btree (si71_reg10);


  --
  -- Name: regadesao152019_si72_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX regadesao152019_si72_reg10_index ON regadesao152019 USING btree (si72_reg10);


  --
  -- Name: rsp112019_si113_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX rsp112019_si113_reg10_index ON rsp112019 USING btree (si113_reg10);


  --
  -- Name: rsp122019_si114_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX rsp122019_si114_reg10_index ON rsp122019 USING btree (si114_reg10);


  --
  -- Name: rsp212019_si116_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX rsp212019_si116_reg20_index ON rsp212019 USING btree (si116_reg20);


  --
  -- Name: rsp222019_si117_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
  --

  CREATE INDEX rsp222019_si117_reg20_index ON rsp222019 USING btree (si117_reg20);

  --
  -- Name: aberlic112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aberlic112019
      ADD CONSTRAINT aberlic112019_reg10_fk FOREIGN KEY (si47_reg10) REFERENCES aberlic102019(si46_sequencial);


  --
  -- Name: aberlic122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aberlic122019
      ADD CONSTRAINT aberlic122019_reg10_fk FOREIGN KEY (si48_reg10) REFERENCES aberlic102019(si46_sequencial);


  --
  -- Name: aberlic132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aberlic132019
      ADD CONSTRAINT aberlic132019_reg10_fk FOREIGN KEY (si49_reg10) REFERENCES aberlic102019(si46_sequencial);


  --
  -- Name: aberlic142019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aberlic142019
      ADD CONSTRAINT aberlic142019_reg10_fk FOREIGN KEY (si50_reg10) REFERENCES aberlic102019(si46_sequencial);


  --
  -- Name: aberlic152019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aberlic152019
      ADD CONSTRAINT aberlic152019_reg10_fk FOREIGN KEY (si51_reg10) REFERENCES aberlic102019(si46_sequencial);


  --
  -- Name: aberlic162019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aberlic162019
      ADD CONSTRAINT aberlic162019_reg10_fk FOREIGN KEY (si52_reg10) REFERENCES aberlic102019(si46_sequencial);


  --
  -- Name: alq112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY alq112019
      ADD CONSTRAINT alq112019_reg10_fk FOREIGN KEY (si122_reg10) REFERENCES alq102019(si121_sequencial);


  --
  -- Name: alq122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY alq122019
      ADD CONSTRAINT alq122019_reg10_fk FOREIGN KEY (si123_reg10) REFERENCES alq102019(si121_sequencial);


  --
  -- Name: anl112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY anl112019
      ADD CONSTRAINT anl112019_reg10_fk FOREIGN KEY (si111_reg10) REFERENCES anl102019(si110_sequencial);


  --
  -- Name: aob112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aob112019
      ADD CONSTRAINT aob112019_reg10_fk FOREIGN KEY (si142_reg10) REFERENCES aob102019(si141_sequencial);


  --
  -- Name: aoc112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aoc112019
      ADD CONSTRAINT aoc112019_reg10_fk FOREIGN KEY (si39_reg10) REFERENCES aoc102019(si38_sequencial);


  --
  -- Name: aoc122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aoc122019
      ADD CONSTRAINT aoc122019_reg10_fk FOREIGN KEY (si40_reg10) REFERENCES aoc102019(si38_sequencial);


  --
  -- Name: aoc132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aoc132019
      ADD CONSTRAINT aoc132019_reg10_fk FOREIGN KEY (si41_reg10) REFERENCES aoc102019(si38_sequencial);


  --
  -- Name: aoc142019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aoc142019
      ADD CONSTRAINT aoc142019_reg10_fk FOREIGN KEY (si42_reg10) REFERENCES aoc102019(si38_sequencial);


  --
  -- Name: aop112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY aop112019
      ADD CONSTRAINT aop112019_reg10_fk FOREIGN KEY (si138_reg10) REFERENCES aop102019(si137_sequencial);


  --
  -- Name: arc112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY arc112019
      ADD CONSTRAINT arc112019_reg10_fk FOREIGN KEY (si29_reg10) REFERENCES arc102019(si28_sequencial);


  --
  -- Name: arc122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY arc122019
      ADD CONSTRAINT arc122019_reg10_fk FOREIGN KEY (si30_reg10) REFERENCES arc102019(si28_sequencial);


  --
  -- Name: arc212019_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY arc212019
      ADD CONSTRAINT arc212019_reg20_fk FOREIGN KEY (si32_reg20) REFERENCES arc202019(si31_sequencial);


  --
  -- Name: caixa112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY caixa112019
      ADD CONSTRAINT caixa112019_reg10_fk FOREIGN KEY (si166_reg10) REFERENCES caixa102019(si103_sequencial);


  --
  -- Name: caixa122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY caixa122019
      ADD CONSTRAINT caixa122019_reg10_fk FOREIGN KEY (si104_reg10) REFERENCES caixa102019(si103_sequencial);


  --
  -- Name: caixa132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY caixa132019
      ADD CONSTRAINT caixa132019_reg10_fk FOREIGN KEY (si105_reg10) REFERENCES caixa102019(si103_sequencial);


  --
  -- Name: contratos112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY contratos112019
      ADD CONSTRAINT contratos112019_reg10_fk FOREIGN KEY (si84_reg10) REFERENCES contratos102019(si83_sequencial);


  --
  -- Name: contratos122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY contratos122019
      ADD CONSTRAINT contratos122019_reg10_fk FOREIGN KEY (si85_reg10) REFERENCES contratos102019(si83_sequencial);


  --
  -- Name: contratos132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY contratos132019
      ADD CONSTRAINT contratos132019_reg10_fk FOREIGN KEY (si86_reg10) REFERENCES contratos102019(si83_sequencial);


  --
  -- Name: contratos212019_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY contratos212019
      ADD CONSTRAINT contratos212019_reg20_fk FOREIGN KEY (si88_reg20) REFERENCES contratos202019(si87_sequencial);


  --
  -- Name: conv112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY conv112019
      ADD CONSTRAINT conv112019_reg10_fk FOREIGN KEY (si93_reg10) REFERENCES conv102019(si92_sequencial);

  --
  -- Name: conv312019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY conv312019
      ADD CONSTRAINT conv312019_reg10_fk FOREIGN KEY (si204_reg10) REFERENCES conv102019(si92_sequencial);


  --
  -- Name: ctb212019_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ctb212019
      ADD CONSTRAINT ctb212019_reg20_fk FOREIGN KEY (si97_reg20) REFERENCES ctb202019(si96_sequencial);


  --
  -- Name: ctb222019_reg21_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ctb222019
      ADD CONSTRAINT ctb222019_reg21_fk FOREIGN KEY (si98_reg21) REFERENCES ctb212019(si97_sequencial);


  --
  -- Name: ctb312019_reg30_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ctb312019
      ADD CONSTRAINT ctb312019_reg30_fk FOREIGN KEY (si100_reg30) REFERENCES ctb302019(si99_sequencial);

  --
  -- Name: cute212019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY cute212019
      ADD CONSTRAINT cute212019_reg10_fk FOREIGN KEY (si201_reg10) REFERENCES cute102019(si199_sequencial);


  --
  -- Name: dclrf112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dclrf112019
      ADD CONSTRAINT dclrf112019_reg10_fk FOREIGN KEY (si205_reg10) REFERENCES dclrf102019(si157_sequencial);

  --
  -- Name: dclrf202019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dclrf202019
      ADD CONSTRAINT dclrf202019_reg10_fk FOREIGN KEY (si191_reg10) REFERENCES dclrf102019(si157_sequencial);

  --
  -- Name: dclrf302019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dclrf302019
      ADD CONSTRAINT dclrf302019_reg10_fk FOREIGN KEY (si192_reg10) REFERENCES dclrf102019(si157_sequencial);

  --
  -- Name: dispensa112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa112019
      ADD CONSTRAINT dispensa112019_reg10_fk FOREIGN KEY (si75_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: dispensa122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa122019
      ADD CONSTRAINT dispensa122019_reg10_fk FOREIGN KEY (si76_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: dispensa132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa132019
      ADD CONSTRAINT dispensa132019_reg10_fk FOREIGN KEY (si77_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: dispensa142019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa142019
      ADD CONSTRAINT dispensa142019_reg10_fk FOREIGN KEY (si78_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: dispensa152019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa152019
      ADD CONSTRAINT dispensa152019_reg10_fk FOREIGN KEY (si79_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: dispensa162019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa162019
      ADD CONSTRAINT dispensa162019_reg10_fk FOREIGN KEY (si80_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: dispensa172019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa172019
      ADD CONSTRAINT dispensa172019_reg10_fk FOREIGN KEY (si81_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: dispensa182019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY dispensa182019
      ADD CONSTRAINT dispensa182019_reg10_fk FOREIGN KEY (si82_reg10) REFERENCES dispensa102019(si74_sequencial);


  --
  -- Name: emp112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY emp112019
      ADD CONSTRAINT emp112019_reg10_fk FOREIGN KEY (si107_reg10) REFERENCES emp102019(si106_sequencial);


  --
  -- Name: emp122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY emp122019
      ADD CONSTRAINT emp122019_reg10_fk FOREIGN KEY (si108_reg10) REFERENCES emp102019(si106_sequencial);


  --
  -- Name: ext312019_reg22_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ext312019
      ADD CONSTRAINT ext312019_reg22_fk FOREIGN KEY (si127_reg30) REFERENCES ext302019(si126_sequencial);


  --
  -- Name: ext322019_reg23_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ext322019
      ADD CONSTRAINT ext322019_reg23_fk FOREIGN KEY (si128_reg30) REFERENCES ext322019(si128_sequencial);


  --
  -- Name: fk_balancete112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete112019
      ADD CONSTRAINT fk_balancete112019_reg10_fk FOREIGN KEY (si178_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete122019
      ADD CONSTRAINT fk_balancete122019_reg10_fk FOREIGN KEY (si179_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete132019
      ADD CONSTRAINT fk_balancete132019_reg10_fk FOREIGN KEY (si180_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete142019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete142019
      ADD CONSTRAINT fk_balancete142019_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete152019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete152019
      ADD CONSTRAINT fk_balancete152019_reg10_fk FOREIGN KEY (si182_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete162019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete162019
      ADD CONSTRAINT fk_balancete162019_reg10_fk FOREIGN KEY (si183_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete172019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete172019
      ADD CONSTRAINT fk_balancete172019_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete102019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete182019
      ADD CONSTRAINT fk_balancete182019_reg10_fk FOREIGN KEY (si185_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete102019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete202019
      ADD CONSTRAINT fk_balancete202019_reg10_fk FOREIGN KEY (si187_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete212019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete212019
      ADD CONSTRAINT fk_balancete212019_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete222019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete222019
      ADD CONSTRAINT fk_balancete222019_si77_sequencial FOREIGN KEY (si189_reg10) REFERENCES balancete102019(si177_sequencial);


  --
  -- Name: fk_balancete232019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete232019
      ADD CONSTRAINT fk_balancete232019_reg10_fk FOREIGN KEY (si190_reg10) REFERENCES balancete102019(si177_sequencial);

  --
  -- Name: fk_balancete242019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete242019
      ADD CONSTRAINT fk_balancete242019_reg10_fk FOREIGN KEY (si191_reg10) REFERENCES balancete102019(si177_sequencial);

  --
  -- Name: fk_balancete252019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete252019
      ADD CONSTRAINT fk_balancete102019_reg10_fk FOREIGN KEY (si195_reg10) REFERENCES balancete102019(si177_sequencial);

  --
  -- Name: fk_balancete262019_si196_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete262019
      ADD CONSTRAINT fk_balancete102019_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES balancete102019(si177_sequencial);

  --
  -- Name: fk_balancete272019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete272019
      ADD CONSTRAINT fk_balancete272019_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES balancete102019(si177_sequencial);

  --
  -- Name: fk_balancete282019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY balancete282019
      ADD CONSTRAINT fk_balancete282019_reg10_fk FOREIGN KEY (si198_reg10) REFERENCES balancete102019(si177_sequencial);

  --
  -- Name: hablic112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY hablic112019
      ADD CONSTRAINT hablic112019_reg10_fk FOREIGN KEY (si58_reg10) REFERENCES hablic102019(si57_sequencial);


  --
  -- Name: incamp112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  -- ALTER TABLE ONLY incamp112019
  --     ADD CONSTRAINT incamp112019_reg10_fk FOREIGN KEY (si161_reg10) REFERENCES incamp102019(si160_sequencial);


  --
  -- Name: incamp122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  -- ALTER TABLE ONLY incamp122019
  --     ADD CONSTRAINT incamp122019_reg10_fk FOREIGN KEY (si162_reg10) REFERENCES incamp102019(si160_sequencial);


  --
  -- Name: lao112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY lao112019
      ADD CONSTRAINT lao112019_reg10_fk FOREIGN KEY (si35_reg10) REFERENCES lao102019(si34_sequencial);


  --
  -- Name: lao212019_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY lao212019
      ADD CONSTRAINT lao212019_reg20_fk FOREIGN KEY (si37_reg20) REFERENCES lao202019(si36_sequencial);


  --
  -- Name: lqd112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY lqd112019
      ADD CONSTRAINT lqd112019_reg10_fk FOREIGN KEY (si119_reg10) REFERENCES lqd102019(si118_sequencial);


  --
  -- Name: lqd122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY lqd122019
      ADD CONSTRAINT lqd122019_reg10_fk FOREIGN KEY (si120_reg10) REFERENCES lqd102019(si118_sequencial);


  --
  -- Name: ntf112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ntf112019
      ADD CONSTRAINT ntf112019_reg10_fk FOREIGN KEY (si144_reg10) REFERENCES ntf102019(si143_sequencial);


  --
  -- Name: obelac112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY obelac112019
      ADD CONSTRAINT obelac112019_reg10_fk FOREIGN KEY (si140_reg10) REFERENCES lqd122019(si120_sequencial);


  --
  -- Name: ops112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ops112019
      ADD CONSTRAINT ops112019_reg10_fk FOREIGN KEY (si133_reg10) REFERENCES ops102019(si132_sequencial);


  --
  -- Name: ops122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ops122019
      ADD CONSTRAINT ops122019_reg10_fk FOREIGN KEY (si134_reg10) REFERENCES ops102019(si132_sequencial);


  --
  -- Name: ops132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY ops132019
      ADD CONSTRAINT ops132019_reg10_fk FOREIGN KEY (si135_reg10) REFERENCES ops102019(si132_sequencial);


  --
  -- Name: ops142019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  -- ALTER TABLE ONLY ops142019
  --     ADD CONSTRAINT ops142019_reg10_fk FOREIGN KEY (si136_reg10) REFERENCES ops102019(si132_sequencial);


  --
  -- Name: orgao112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY orgao112019
      ADD CONSTRAINT orgao112019_reg10_fk FOREIGN KEY (si15_reg10) REFERENCES orgao102019(si14_sequencial);


  --
  -- Name: parec112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY parec112019
      ADD CONSTRAINT parec112019_reg10_fk FOREIGN KEY (si23_reg10) REFERENCES parec102019(si22_sequencial);


  --
  -- Name: rec112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY rec112019
      ADD CONSTRAINT rec112019_reg10_fk FOREIGN KEY (si26_reg10) REFERENCES rec102019(si25_sequencial);


  --
  -- Name: regadesao112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY regadesao112019
      ADD CONSTRAINT regadesao112019_reg10_fk FOREIGN KEY (si68_reg10) REFERENCES regadesao102019(si67_sequencial);


  --
  -- Name: regadesao122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY regadesao122019
      ADD CONSTRAINT regadesao122019_reg10_fk FOREIGN KEY (si69_reg10) REFERENCES regadesao102019(si67_sequencial);


  --
  -- Name: regadesao132019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY regadesao132019
      ADD CONSTRAINT regadesao132019_reg10_fk FOREIGN KEY (si70_reg10) REFERENCES regadesao102019(si67_sequencial);


  --
  -- Name: regadesao142019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY regadesao142019
      ADD CONSTRAINT regadesao142019_reg10_fk FOREIGN KEY (si71_reg10) REFERENCES regadesao102019(si67_sequencial);


  --
  -- Name: regadesao152019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY regadesao152019
      ADD CONSTRAINT regadesao152019_reg10_fk FOREIGN KEY (si72_reg10) REFERENCES regadesao102019(si67_sequencial);


  --
  -- Name: rsp112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY rsp112019
      ADD CONSTRAINT rsp112019_reg10_fk FOREIGN KEY (si113_reg10) REFERENCES rsp102019(si112_sequencial);


  --
  -- Name: rsp122019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY rsp122019
      ADD CONSTRAINT rsp122019_reg10_fk FOREIGN KEY (si114_reg10) REFERENCES rsp102019(si112_sequencial);


  --
  -- Name: rsp212019_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY rsp212019
      ADD CONSTRAINT rsp212019_reg20_fk FOREIGN KEY (si116_reg20) REFERENCES rsp202019(si115_sequencial);


  --
  -- Name: rsp222019_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY rsp222019
      ADD CONSTRAINT rsp222019_reg20_fk FOREIGN KEY (si117_reg20) REFERENCES rsp202019(si115_sequencial);

  --
  -- Name: tce112019_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
  --

  ALTER TABLE ONLY tce112019
      ADD CONSTRAINT tce112019_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES tce112019(si188_sequencial);


  --
  -- PostgreSQL database dump complete
  --
 COMMIT;
