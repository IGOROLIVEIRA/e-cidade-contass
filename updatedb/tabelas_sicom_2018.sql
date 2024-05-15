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
-- Name: aberlic102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aberlic102018 (
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
    si46_descontotabela bigint DEFAULT 0 NOT NULL,
    si46_processoporlote bigint DEFAULT 0 NOT NULL,
    si46_criteriodesempate bigint DEFAULT 0 NOT NULL,
    si46_destinacaoexclusiva bigint DEFAULT 0 NOT NULL,
    si46_subcontratacao bigint DEFAULT 0 NOT NULL,
    si46_limitecontratacao bigint DEFAULT 0 NOT NULL,
    si46_mes bigint DEFAULT 0 NOT NULL,
    si46_instit bigint DEFAULT 0
);


ALTER TABLE aberlic102018 OWNER TO dbportal;

--
-- Name: aberlic102018_si46_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aberlic102018_si46_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aberlic102018_si46_sequencial_seq OWNER TO dbportal;

--
-- Name: aberlic112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aberlic112018 (
    si47_sequencial bigint DEFAULT 0 NOT NULL,
    si47_tiporegistro bigint DEFAULT 0 NOT NULL,
    si47_codorgaoresp character varying(2) NOT NULL,
    si47_codunidadesubresp character varying(8) NOT NULL,
    si47_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
    si47_nroprocessolicitatorio character varying(12) NOT NULL,
    si47_nrolote bigint DEFAULT 0 NOT NULL,
    si47_dsclote character varying(250) NOT NULL,
    si47_mes bigint DEFAULT 0 NOT NULL,
    si47_reg10 bigint DEFAULT 0 NOT NULL,
    si47_instit bigint DEFAULT 0
);


ALTER TABLE aberlic112018 OWNER TO dbportal;

--
-- Name: aberlic112018_si47_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aberlic112018_si47_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aberlic112018_si47_sequencial_seq OWNER TO dbportal;

--
-- Name: aberlic122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aberlic122018 (
    si48_sequencial bigint DEFAULT 0 NOT NULL,
    si48_tiporegistro bigint DEFAULT 0 NOT NULL,
    si48_codorgaoresp character varying(2) NOT NULL,
    si48_codunidadesubresp character varying(8) NOT NULL,
    si48_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
    si48_nroprocessolicitatorio character varying(12) NOT NULL,
    si48_coditem bigint DEFAULT 0 NOT NULL,
    si48_nroitem bigint DEFAULT 0 NOT NULL,
    si48_mes bigint DEFAULT 0 NOT NULL,
    si48_reg10 bigint DEFAULT 0 NOT NULL,
    si48_instit bigint DEFAULT 0
);


ALTER TABLE aberlic122018 OWNER TO dbportal;

--
-- Name: aberlic122018_si48_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aberlic122018_si48_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aberlic122018_si48_sequencial_seq OWNER TO dbportal;

--
-- Name: aberlic132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aberlic132018 (
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


ALTER TABLE aberlic132018 OWNER TO dbportal;

--
-- Name: aberlic132018_si49_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aberlic132018_si49_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aberlic132018_si49_sequencial_seq OWNER TO dbportal;

--
-- Name: aberlic142018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aberlic142018 (
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


ALTER TABLE aberlic142018 OWNER TO dbportal;

--
-- Name: aberlic142018_si50_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aberlic142018_si50_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aberlic142018_si50_sequencial_seq OWNER TO dbportal;

--
-- Name: aberlic152018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aberlic152018 (
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


ALTER TABLE aberlic152018 OWNER TO dbportal;

--
-- Name: aberlic152018_si51_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aberlic152018_si51_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aberlic152018_si51_sequencial_seq OWNER TO dbportal;

--
-- Name: aberlic162018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aberlic162018 (
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


ALTER TABLE aberlic162018 OWNER TO dbportal;

--
-- Name: aberlic162018_si52_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aberlic162018_si52_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aberlic162018_si52_sequencial_seq OWNER TO dbportal;

--
-- Name: aex102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aex102018 (
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


ALTER TABLE aex102018 OWNER TO dbportal;

--
-- Name: aex102018_si130_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aex102018_si130_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aex102018_si130_sequencial_seq OWNER TO dbportal;

--
-- Name: alq102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE alq102018 (
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


ALTER TABLE alq102018 OWNER TO dbportal;

--
-- Name: alq102018_si121_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE alq102018_si121_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE alq102018_si121_sequencial_seq OWNER TO dbportal;

--
-- Name: alq112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE alq112018 (
    si122_sequencial bigint DEFAULT 0 NOT NULL,
    si122_tiporegistro bigint DEFAULT 0 NOT NULL,
    si122_codreduzido bigint DEFAULT 0 NOT NULL,
    si122_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si122_valoranuladofonte double precision DEFAULT 0 NOT NULL,
    si122_mes bigint DEFAULT 0 NOT NULL,
    si122_reg10 bigint DEFAULT 0 NOT NULL,
    si122_instit bigint DEFAULT 0
);


ALTER TABLE alq112018 OWNER TO dbportal;

--
-- Name: alq112018_si122_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE alq112018_si122_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE alq112018_si122_sequencial_seq OWNER TO dbportal;

--
-- Name: alq122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE alq122018 (
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


ALTER TABLE alq122018 OWNER TO dbportal;

--
-- Name: alq122018_si123_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE alq122018_si123_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE alq122018_si123_sequencial_seq OWNER TO dbportal;

--
-- Name: anl102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE anl102018 (
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


ALTER TABLE anl102018 OWNER TO dbportal;

--
-- Name: anl102018_si110_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE anl102018_si110_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE anl102018_si110_sequencial_seq OWNER TO dbportal;

--
-- Name: anl112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE anl112018 (
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


ALTER TABLE anl112018 OWNER TO dbportal;

--
-- Name: anl112018_si111_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE anl112018_si111_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE anl112018_si111_sequencial_seq OWNER TO dbportal;

--
-- Name: aob102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aob102018 (
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
    si141_nroliquidacao bigint DEFAULT 0 NOT NULL,
    si141_dtliquidacao date NOT NULL,
    si141_valoranulacaolancamento double precision DEFAULT 0 NOT NULL,
    si141_mes bigint DEFAULT 0 NOT NULL,
    si141_instit bigint DEFAULT 0
);


ALTER TABLE aob102018 OWNER TO dbportal;

--
-- Name: aob102018_si141_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aob102018_si141_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aob102018_si141_sequencial_seq OWNER TO dbportal;

--
-- Name: aob112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aob112018 (
    si142_sequencial bigint DEFAULT 0 NOT NULL,
    si142_tiporegistro bigint DEFAULT 0 NOT NULL,
    si142_codreduzido bigint DEFAULT 0 NOT NULL,
    si142_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si142_valoranulacaofonte double precision DEFAULT 0 NOT NULL,
    si142_mes bigint DEFAULT 0 NOT NULL,
    si142_reg10 bigint DEFAULT 0 NOT NULL,
    si142_instit bigint DEFAULT 0
);


ALTER TABLE aob112018 OWNER TO dbportal;

--
-- Name: aob112018_si142_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aob112018_si142_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aob112018_si142_sequencial_seq OWNER TO dbportal;

--
-- Name: aoc102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aoc102018 (
    si38_sequencial bigint DEFAULT 0 NOT NULL,
    si38_tiporegistro bigint DEFAULT 0 NOT NULL,
    si38_codorgao character varying(2) NOT NULL,
    si38_nrodecreto bigint DEFAULT 0 NOT NULL,
    si38_datadecreto date NOT NULL,
    si38_mes bigint DEFAULT 0 NOT NULL,
    si38_instit bigint DEFAULT 0
);


ALTER TABLE aoc102018 OWNER TO dbportal;

--
-- Name: aoc102018_si38_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aoc102018_si38_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aoc102018_si38_sequencial_seq OWNER TO dbportal;

--
-- Name: aoc112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aoc112018 (
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


ALTER TABLE aoc112018 OWNER TO dbportal;

--
-- Name: aoc112018_si39_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aoc112018_si39_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aoc112018_si39_sequencial_seq OWNER TO dbportal;

--
-- Name: aoc122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aoc122018 (
    si40_sequencial bigint DEFAULT 0 NOT NULL,
    si40_tiporegistro bigint DEFAULT 0 NOT NULL,
    si40_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
    si40_nroleialteracao character varying(6) NOT NULL,
    si40_dataleialteracao date NOT NULL,
    si40_tpleiorigdecreto character varying(4) NOT NULL,
    si40_tipoleialteracao bigint DEFAULT 0 NOT NULL,
    si40_mes bigint DEFAULT 0 NOT NULL,
    si40_reg10 bigint DEFAULT 0 NOT NULL,
    si40_instit bigint DEFAULT 0,
    si40_valorabertolei double precision
);


ALTER TABLE aoc122018 OWNER TO dbportal;

--
-- Name: aoc122018_si40_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aoc122018_si40_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aoc122018_si40_sequencial_seq OWNER TO dbportal;

--
-- Name: aoc132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aoc132018 (
    si41_sequencial bigint DEFAULT 0 NOT NULL,
    si41_tiporegistro bigint DEFAULT 0 NOT NULL,
    si41_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
    si41_origemrecalteracao character varying(2) NOT NULL,
    si41_valorabertoorigem double precision DEFAULT 0 NOT NULL,
    si41_mes bigint DEFAULT 0 NOT NULL,
    si41_reg10 bigint DEFAULT 0 NOT NULL,
    si41_instit bigint DEFAULT 0
);


ALTER TABLE aoc132018 OWNER TO dbportal;

--
-- Name: aoc132018_si41_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aoc132018_si41_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aoc132018_si41_sequencial_seq OWNER TO dbportal;

--
-- Name: aoc142018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aoc142018 (
    si42_sequencial bigint DEFAULT 0 NOT NULL,
    si42_tiporegistro bigint DEFAULT 0 NOT NULL,
    si42_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
    si42_tipoalteracao bigint DEFAULT 0 NOT NULL,
    si42_codorgao character varying(2) NOT NULL,
    si42_codunidadesub character varying(8) NOT NULL,
    si42_codfuncao character varying(2) NOT NULL,
    si42_codsubfuncao character varying(3) NOT NULL,
    si42_codprograma character varying(4) NOT NULL,
    si42_idacao character varying(4) NOT NULL,
    si42_idsubacao character varying(4),
    si42_naturezadespesa bigint DEFAULT 0 NOT NULL,
    si42_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si42_vlacrescimoreducao double precision DEFAULT 0 NOT NULL,
    si42_mes bigint DEFAULT 0 NOT NULL,
    si42_reg10 bigint DEFAULT 0 NOT NULL,
    si42_instit bigint DEFAULT 0,
    si42_origemrecalteracao character varying(6)
);


ALTER TABLE aoc142018 OWNER TO dbportal;

--
-- Name: aoc142018_si42_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aoc142018_si42_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aoc142018_si42_sequencial_seq OWNER TO dbportal;

--
-- Name: aop102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aop102018 (
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


ALTER TABLE aop102018 OWNER TO dbportal;

--
-- Name: aop102018_si137_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aop102018_si137_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aop102018_si137_sequencial_seq OWNER TO dbportal;

--
-- Name: aop112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE aop112018 (
    si138_sequencial bigint DEFAULT 0 NOT NULL,
    si138_tiporegistro bigint DEFAULT 0 NOT NULL,
    si138_codreduzido bigint DEFAULT 0 NOT NULL,
    si138_tipopagamento bigint DEFAULT 0 NOT NULL,
    si138_nroempenho bigint DEFAULT 0 NOT NULL,
    si138_dtempenho date NOT NULL,
    si138_nroliquidacao bigint DEFAULT 0 NOT NULL,
    si138_dtliquidacao date NOT NULL,
    si138_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si138_valoranulacaofonte double precision DEFAULT 0 NOT NULL,
    si138_codorgaoempop character varying(2),
    si138_codunidadeempop character varying(8),
    si138_mes bigint DEFAULT 0 NOT NULL,
    si138_reg10 bigint DEFAULT 0 NOT NULL,
    si138_instit bigint DEFAULT 0
);


ALTER TABLE aop112018 OWNER TO dbportal;

--
-- Name: aop112018_si138_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE aop112018_si138_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE aop112018_si138_sequencial_seq OWNER TO dbportal;

--
-- Name: arc102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE arc102018 (
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


ALTER TABLE arc102018 OWNER TO dbportal;

--
-- Name: arc102018_si28_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE arc102018_si28_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE arc102018_si28_sequencial_seq OWNER TO dbportal;

--
-- Name: arc112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE arc112018 (
    si29_sequencial bigint DEFAULT 0 NOT NULL,
    si29_tiporegistro bigint DEFAULT 0 NOT NULL,
    si29_codcorrecao bigint DEFAULT 0 NOT NULL,
    si29_codfontereduzida bigint DEFAULT 0 NOT NULL,
    si29_cnpjorgaocontribuinte character varying(14),
    si29_vlreduzidofonte double precision DEFAULT 0 NOT NULL,
    si29_reg10 bigint DEFAULT 0 NOT NULL,
    si29_mes bigint DEFAULT 0 NOT NULL,
    si29_instit bigint DEFAULT 0
);


ALTER TABLE arc112018 OWNER TO dbportal;

--
-- Name: arc112018_si29_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE arc112018_si29_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE arc112018_si29_sequencial_seq OWNER TO dbportal;

--
-- Name: arc122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE arc122018 (
    si30_sequencial bigint DEFAULT 0 NOT NULL,
    si30_tiporegistro bigint DEFAULT 0 NOT NULL,
    si30_codcorrecao bigint DEFAULT 0 NOT NULL,
    si30_codfonteacrescida bigint DEFAULT 0 NOT NULL,
    si30_cnpjorgaocontribuinte character varying(14),
    si30_vlacrescidofonte double precision DEFAULT 0 NOT NULL,
    si30_reg10 bigint DEFAULT 0 NOT NULL,
    si30_mes bigint DEFAULT 0 NOT NULL,
    si30_instit bigint DEFAULT 0
);


ALTER TABLE arc122018 OWNER TO dbportal;

--
-- Name: arc202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE arc202018 (
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


ALTER TABLE arc202018 OWNER TO dbportal;

--
-- Name: arc202018_si31_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE arc202018_si31_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE arc202018_si31_sequencial_seq OWNER TO dbportal;

--
-- Name: arc212018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE arc212018 (
    si32_sequencial bigint DEFAULT 0 NOT NULL,
    si32_tiporegistro bigint DEFAULT 0 NOT NULL,
    si32_codestorno bigint DEFAULT 0 NOT NULL,
    si32_codfonteestornada bigint DEFAULT 0 NOT NULL,
    si32_cnpjorgaocontribuinte character varying(14),
    si32_vlestornadofonte double precision DEFAULT 0 NOT NULL,
    si32_reg20 bigint DEFAULT 0 NOT NULL,
    si32_instit bigint DEFAULT 0
);


ALTER TABLE arc212018 OWNER TO dbportal;

--
-- Name: arc212018_si32_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE arc212018_si32_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE arc212018_si32_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete102018 (
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


ALTER TABLE balancete102018 OWNER TO dbportal;

--
-- Name: balancete102018_si177_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete102018_si177_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete102018_si177_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete112018 (
    si178_sequencial bigint DEFAULT 0 NOT NULL,
    si178_tiporegistro bigint DEFAULT 0 NOT NULL,
    si178_contacontaabil bigint DEFAULT 0 NOT NULL,
    si178_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
    si178_codorgao character varying(2) NOT NULL,
    si178_codunidadesub character varying(8) NOT NULL,
    si178_codfuncao character varying(2) NOT NULL,
    si178_codsubfuncao character varying(3) NOT NULL,
    si178_codprograma text NOT NULL,
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


ALTER TABLE balancete112018 OWNER TO dbportal;

--
-- Name: balancete112018_si178_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete112018_si178_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete112018_si178_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete122018 (
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


ALTER TABLE balancete122018 OWNER TO dbportal;

--
-- Name: balancete122018_si179_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete122018_si179_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete122018_si179_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete132018 (
    si180_sequencial bigint DEFAULT 0 NOT NULL,
    si180_tiporegistro bigint DEFAULT 0 NOT NULL,
    si180_contacontabil bigint DEFAULT 0 NOT NULL,
    si180_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
    si180_codprograma character varying(4) NOT NULL,
    si180_idacao text NOT NULL,
    si180_idsubacao character varying(4),
    si180_saldoiniciaipa double precision DEFAULT 0 NOT NULL,
    si180_naturezasaldoiniciaipa character varying(1) NOT NULL,
    si180_totaldebitospa double precision DEFAULT 0 NOT NULL,
    si180_totalcreditospa double precision DEFAULT 0 NOT NULL,
    si180_saldofinaipa double precision DEFAULT 0 NOT NULL,
    si180_naturezasaldofinaipa character varying(1) NOT NULL,
    si180_mes bigint DEFAULT 0 NOT NULL,
    si180_instit bigint DEFAULT 0,
    si180_reg10 bigint NOT NULL
);


ALTER TABLE balancete132018 OWNER TO dbportal;

--
-- Name: balancete132018_si180_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete132018_si180_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete132018_si180_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete142018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete142018 (
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


ALTER TABLE balancete142018 OWNER TO dbportal;

--
-- Name: balancete142018_si181_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete142018_si181_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete142018_si181_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete152018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete152018 (
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


ALTER TABLE balancete152018 OWNER TO dbportal;

--
-- Name: balancete152018_si182_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete152018_si182_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete152018_si182_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete162018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete162018 (
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


ALTER TABLE balancete162018 OWNER TO dbportal;

--
-- Name: balancete162018_si183_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete162018_si183_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete162018_si183_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete172018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete172018 (
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


ALTER TABLE balancete172018 OWNER TO dbportal;

--
-- Name: balancete172018_si184_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete172018_si184_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete172018_si184_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete182018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete182018 (
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


ALTER TABLE balancete182018 OWNER TO dbportal;

--
-- Name: balancete182018_si185_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete182018_si185_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete182018_si185_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete182018_si186_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete182018_si186_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete182018_si186_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete192018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete192018 (
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


ALTER TABLE balancete192018 OWNER TO dbportal;

--
-- Name: balancete192018_si186_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete192018_si186_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete192018_si186_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete202018 (
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


ALTER TABLE balancete202018 OWNER TO dbportal;

--
-- Name: balancete202018_si187_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete202018_si187_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete202018_si187_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete212018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete212018 (
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


ALTER TABLE balancete212018 OWNER TO dbportal;

--
-- Name: balancete212018_si188_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete212018_si188_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete212018_si188_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete222018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete222018 (
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


ALTER TABLE balancete222018 OWNER TO dbportal;

--
-- Name: balancete222018_si189_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete222018_si189_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete222018_si189_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete232018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete232018 (
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


ALTER TABLE balancete232018 OWNER TO dbportal;

--
-- Name: balancete232018_si190_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete232018_si190_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete232018_si190_sequencial_seq OWNER TO dbportal;

--
-- Name: balancete242018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE balancete242018 (
    si191_sequencial bigint DEFAULT 0 NOT NULL,
    si191_tiporegistro bigint DEFAULT 0 NOT NULL,
    si191_contacontabil bigint DEFAULT 0 NOT NULL,
    si191_codfundo character varying(8) DEFAULT '00000000'::character varying NOT NULL,
    si191_codorgao bigint DEFAULT 0 NOT NULL,
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


ALTER TABLE balancete242018 OWNER TO dbportal;

--
-- Name: balancete242018_si191_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE balancete242018_si191_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE balancete242018_si191_sequencial_seq OWNER TO dbportal;

--
-- Name: bfdcasp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bfdcasp102018 (
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


ALTER TABLE bfdcasp102018 OWNER TO dbportal;

--
-- Name: bfdcasp102018_si206_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bfdcasp102018_si206_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bfdcasp102018_si206_sequencial_seq OWNER TO dbportal;

--
-- Name: bfdcasp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bfdcasp202018 (
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


ALTER TABLE bfdcasp202018 OWNER TO dbportal;

--
-- Name: bfdcasp202018_si207_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bfdcasp202018_si207_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bfdcasp202018_si207_sequencial_seq OWNER TO dbportal;

--
-- Name: bodcasp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bodcasp102018 (
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


ALTER TABLE bodcasp102018 OWNER TO dbportal;

--
-- Name: bodcasp102018_si201_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bodcasp102018_si201_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bodcasp102018_si201_sequencial_seq OWNER TO dbportal;

--
-- Name: bodcasp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bodcasp202018 (
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


ALTER TABLE bodcasp202018 OWNER TO dbportal;

--
-- Name: bodcasp202018_si202_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bodcasp202018_si202_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bodcasp202018_si202_sequencial_seq OWNER TO dbportal;

--
-- Name: bodcasp302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bodcasp302018 (
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


ALTER TABLE bodcasp302018 OWNER TO dbportal;

--
-- Name: bodcasp302018_si203_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bodcasp302018_si203_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bodcasp302018_si203_sequencial_seq OWNER TO dbportal;

--
-- Name: bodcasp402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bodcasp402018 (
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


ALTER TABLE bodcasp402018 OWNER TO dbportal;

--
-- Name: bodcasp402018_si204_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bodcasp402018_si204_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bodcasp402018_si204_sequencial_seq OWNER TO dbportal;

--
-- Name: bodcasp502018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bodcasp502018 (
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


ALTER TABLE bodcasp502018 OWNER TO dbportal;

--
-- Name: bodcasp502018_si205_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bodcasp502018_si205_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bodcasp502018_si205_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp102018 (
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


ALTER TABLE bpdcasp102018 OWNER TO dbportal;

--
-- Name: bpdcasp102018_si208_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp102018_si208_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp102018_si208_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp202018 (
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


ALTER TABLE bpdcasp202018 OWNER TO dbportal;

--
-- Name: bpdcasp202018_si209_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp202018_si209_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp202018_si209_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp302018 (
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


ALTER TABLE bpdcasp302018 OWNER TO dbportal;

--
-- Name: bpdcasp302018_si210_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp302018_si210_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp302018_si210_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp402018 (
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


ALTER TABLE bpdcasp402018 OWNER TO dbportal;

--
-- Name: bpdcasp402018_si211_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp402018_si211_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp402018_si211_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp502018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp502018 (
    si212_sequencial integer DEFAULT 0 NOT NULL,
    si212_tiporegistro integer DEFAULT 0 NOT NULL,
    si212_exercicio integer DEFAULT 0 NOT NULL,
    si212_vlsaldopatrimonial double precision DEFAULT 0,
    si212_ano integer DEFAULT 0 NOT NULL,
    si212_periodo integer DEFAULT 0 NOT NULL,
    si212_institu integer DEFAULT 0 NOT NULL
);


ALTER TABLE bpdcasp502018 OWNER TO dbportal;

--
-- Name: bpdcasp502018_si212_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp502018_si212_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp502018_si212_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp602018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp602018 (
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


ALTER TABLE bpdcasp602018 OWNER TO dbportal;

--
-- Name: bpdcasp602018_si213_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp602018_si213_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp602018_si213_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp702018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp702018 (
    si214_sequencial integer DEFAULT 0 NOT NULL,
    si214_tiporegistro integer DEFAULT 0 NOT NULL,
    si214_exercicio integer DEFAULT 0 NOT NULL,
    si214_vltotalsupdef double precision DEFAULT 0,
    si214_ano integer DEFAULT 0 NOT NULL,
    si214_periodo integer DEFAULT 0 NOT NULL,
    si214_institu integer DEFAULT 0 NOT NULL
);


ALTER TABLE bpdcasp702018 OWNER TO dbportal;

--
-- Name: bpdcasp702018_si214_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp702018_si214_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp702018_si214_sequencial_seq OWNER TO dbportal;

--
-- Name: bpdcasp712018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE bpdcasp712018 (
    si215_sequencial integer DEFAULT 0 NOT NULL,
    si215_tiporegistro integer DEFAULT 0 NOT NULL,
    si215_exercicio integer DEFAULT 0 NOT NULL,
    si215_codfontrecursos integer DEFAULT 0 NOT NULL,
    si215_vlsaldofonte double precision DEFAULT 0,
    si215_ano integer DEFAULT 0 NOT NULL,
    si215_periodo integer DEFAULT 0 NOT NULL,
    si215_institu integer DEFAULT 0 NOT NULL
);


ALTER TABLE bpdcasp712018 OWNER TO dbportal;

--
-- Name: bpdcasp712018_si215_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE bpdcasp712018_si215_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE bpdcasp712018_si215_sequencial_seq OWNER TO dbportal;

--
-- Name: caixa102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE caixa102018 (
    si103_sequencial bigint DEFAULT 0 NOT NULL,
    si103_tiporegistro bigint DEFAULT 0 NOT NULL,
    si103_codorgao character varying(2) NOT NULL,
    si103_vlsaldoinicial double precision DEFAULT 0 NOT NULL,
    si103_vlsaldofinal double precision DEFAULT 0 NOT NULL,
    si103_mes bigint DEFAULT 0 NOT NULL,
    si103_instit bigint DEFAULT 0
);


ALTER TABLE caixa102018 OWNER TO dbportal;

--
-- Name: caixa102018_si103_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE caixa102018_si103_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE caixa102018_si103_sequencial_seq OWNER TO dbportal;

--
-- Name: caixa112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE caixa112018 (
    si166_sequencial bigint DEFAULT 0 NOT NULL,
    si166_tiporegistro bigint DEFAULT 0 NOT NULL,
    si166_codfontecaixa character varying(3) NOT NULL,
    si166_vlsaldoinicialfonte double precision DEFAULT 0 NOT NULL,
    si166_vlsaldofinalfonte double precision DEFAULT 0 NOT NULL,
    si166_mes bigint DEFAULT 0 NOT NULL,
    si166_instit bigint DEFAULT 0,
    si166_reg10 bigint DEFAULT 0 NOT NULL
);


ALTER TABLE caixa112018 OWNER TO dbportal;

--
-- Name: caixa112018_si166_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE caixa112018_si166_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE caixa112018_si166_sequencial_seq OWNER TO dbportal;

--
-- Name: caixa122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE caixa122018 (
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


ALTER TABLE caixa122018 OWNER TO dbportal;

--
-- Name: caixa122018_si104_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE caixa122018_si104_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE caixa122018_si104_sequencial_seq OWNER TO dbportal;

--
-- Name: caixa132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE caixa132018 (
    si105_sequencial bigint DEFAULT 0 NOT NULL,
    si105_tiporegistro bigint DEFAULT 0 NOT NULL,
    si105_codreduzido bigint DEFAULT 0 NOT NULL,
    si105_ededucaodereceita bigint DEFAULT 0 NOT NULL,
    si105_identificadordeducao bigint DEFAULT 0,
    si105_naturezareceita bigint DEFAULT 0 NOT NULL,
    si105_vlrreceitacont double precision DEFAULT 0 NOT NULL,
    si105_mes bigint DEFAULT 0 NOT NULL,
    si105_reg10 bigint DEFAULT 0 NOT NULL,
    si105_instit bigint DEFAULT 0
);


ALTER TABLE caixa132018 OWNER TO dbportal;

--
-- Name: caixa132018_si105_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE caixa132018_si105_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE caixa132018_si105_sequencial_seq OWNER TO dbportal;

--
-- Name: consid102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE consid102018 (
    si158_sequencial bigint DEFAULT 0 NOT NULL,
    si158_tiporegistro bigint DEFAULT 0 NOT NULL,
    si158_codarquivo character varying(20) NOT NULL,
    si158_exercicioreferenciaconsid bigint DEFAULT 0,
    si158_mesreferenciaconsid character varying(2),
    si158_consideracoes character varying(3000) NOT NULL,
    si158_mes bigint DEFAULT 0 NOT NULL,
    si158_instit bigint DEFAULT 0
);


ALTER TABLE consid102018 OWNER TO dbportal;

--
-- Name: consid102018_si158_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE consid102018_si158_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE consid102018_si158_sequencial_seq OWNER TO dbportal;

--
-- Name: consor102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE consor102018 (
    si16_sequencial bigint DEFAULT 0 NOT NULL,
    si16_tiporegistro bigint DEFAULT 0 NOT NULL,
    si16_codorgao character varying(2) NOT NULL,
    si16_cnpjconsorcio character varying(14) DEFAULT '0'::character varying NOT NULL,
    si16_areaatuacao character varying(2) NOT NULL,
    si16_descareaatuacao character varying(150),
    si16_mes bigint DEFAULT 0 NOT NULL,
    si16_instit bigint DEFAULT 0
);


ALTER TABLE consor102018 OWNER TO dbportal;

--
-- Name: consor102018_si16_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE consor102018_si16_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE consor102018_si16_sequencial_seq OWNER TO dbportal;

--
-- Name: consor202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE consor202018 (
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


ALTER TABLE consor202018 OWNER TO dbportal;

--
-- Name: consor202018_si17_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE consor202018_si17_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE consor202018_si17_sequencial_seq OWNER TO dbportal;

--
-- Name: consor302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE consor302018 (
    si18_sequencial bigint DEFAULT 0 NOT NULL,
    si18_tiporegistro bigint DEFAULT 0 NOT NULL,
    si18_cnpjconsorcio character varying(14) NOT NULL,
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


ALTER TABLE consor302018 OWNER TO dbportal;

--
-- Name: consor302018_si18_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE consor302018_si18_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE consor302018_si18_sequencial_seq OWNER TO dbportal;

--
-- Name: consor402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE consor402018 (
    si19_sequencial bigint DEFAULT 0 NOT NULL,
    si19_tiporegistro bigint DEFAULT 0 NOT NULL,
    si19_cnpjconsorcio character varying(14) NOT NULL,
    si19_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si19_vldispcaixa double precision DEFAULT 0 NOT NULL,
    si19_mes bigint DEFAULT 0 NOT NULL,
    si19_instit bigint DEFAULT 0
);


ALTER TABLE consor402018 OWNER TO dbportal;

--
-- Name: consor402018_si19_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE consor402018_si19_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE consor402018_si19_sequencial_seq OWNER TO dbportal;

--
-- Name: consor502018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE consor502018 (
    si20_sequencial bigint DEFAULT 0 NOT NULL,
    si20_tiporegistro bigint DEFAULT 0 NOT NULL,
    si20_codorgao character varying(2) NOT NULL,
    si20_cnpjconsorcio character varying(14) NOT NULL,
    si20_tipoencerramento bigint DEFAULT 0 NOT NULL,
    si20_dtencerramento date NOT NULL,
    si20_mes bigint DEFAULT 0 NOT NULL,
    si20_instit bigint DEFAULT 0
);


ALTER TABLE consor502018 OWNER TO dbportal;

--
-- Name: consor502018_si20_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE consor502018_si20_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE consor502018_si20_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos102018 (
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


ALTER TABLE contratos102018 OWNER TO dbportal;

--
-- Name: contratos102018_si83_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos102018_si83_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos102018_si83_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos112018 (
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


ALTER TABLE contratos112018 OWNER TO dbportal;

--
-- Name: contratos112018_si84_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos112018_si84_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos112018_si84_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos122018 (
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


ALTER TABLE contratos122018 OWNER TO dbportal;

--
-- Name: contratos122018_si85_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos122018_si85_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos122018_si85_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos132018 (
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


ALTER TABLE contratos132018 OWNER TO dbportal;

--
-- Name: contratos132018_si86_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos132018_si86_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos132018_si86_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos202018 (
    si87_sequencial bigint DEFAULT 0 NOT NULL,
    si87_tiporegistro bigint DEFAULT 0 NOT NULL,
    si87_codaditivo bigint DEFAULT 0 NOT NULL,
    si87_codorgao character varying(2) NOT NULL,
    si87_codunidadesub character varying(8) NOT NULL,
    si87_nrocontrato bigint DEFAULT 0 NOT NULL,
    si87_dataassinaturacontoriginal date NOT NULL,
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


ALTER TABLE contratos202018 OWNER TO dbportal;

--
-- Name: contratos202018_si87_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos202018_si87_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos202018_si87_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos212018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos212018 (
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


ALTER TABLE contratos212018 OWNER TO dbportal;

--
-- Name: contratos212018_si88_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos212018_si88_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos212018_si88_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos302018 (
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


ALTER TABLE contratos302018 OWNER TO dbportal;

--
-- Name: contratos302018_si89_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos302018_si89_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos302018_si89_sequencial_seq OWNER TO dbportal;

--
-- Name: contratos402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE contratos402018 (
    si91_sequencial bigint DEFAULT 0 NOT NULL,
    si91_tiporegistro bigint DEFAULT 0 NOT NULL,
    si91_codorgao character varying(2) NOT NULL,
    si91_codunidadesub character varying(8) NOT NULL,
    si91_nrocontrato bigint DEFAULT 0 NOT NULL,
    si91_dtassinaturacontoriginal date NOT NULL,
    si91_datarescisao date NOT NULL,
    si91_valorcancelamentocontrato double precision DEFAULT 0 NOT NULL,
    si91_mes bigint DEFAULT 0 NOT NULL,
    si91_instit bigint DEFAULT 0
);


ALTER TABLE contratos402018 OWNER TO dbportal;

--
-- Name: contratos402018_si91_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE contratos402018_si91_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE contratos402018_si91_sequencial_seq OWNER TO dbportal;

--
-- Name: conv102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conv102018 (
    si92_sequencial bigint DEFAULT 0 NOT NULL,
    si92_tiporegistro bigint DEFAULT 0 NOT NULL,
    si92_codconvenio bigint DEFAULT 0 NOT NULL,
    si92_codorgao character varying(2) NOT NULL,
    si92_nroconvenio character varying(30) NOT NULL,
    si92_dataassinatura date NOT NULL,
    si92_objetoconvenio character varying(500) NOT NULL,
    si92_datainiciovigencia date NOT NULL,
    si92_datafinalvigencia date NOT NULL,
    si92_vlconvenio double precision DEFAULT 0 NOT NULL,
    si92_vlcontrapartida double precision DEFAULT 0 NOT NULL,
    si92_mes bigint DEFAULT 0 NOT NULL,
    si92_instit bigint DEFAULT 0
);


ALTER TABLE conv102018 OWNER TO dbportal;

--
-- Name: conv102018_si92_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conv102018_si92_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conv102018_si92_sequencial_seq OWNER TO dbportal;

--
-- Name: conv112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conv112018 (
    si93_sequencial bigint DEFAULT 0 NOT NULL,
    si93_tiporegistro bigint DEFAULT 0 NOT NULL,
    si93_codconvenio bigint DEFAULT 0 NOT NULL,
    si93_tipodocumento bigint DEFAULT 0 NOT NULL,
    si93_nrodocumento character varying(14) NOT NULL,
    si93_esferaconcedente bigint DEFAULT 0 NOT NULL,
    si93_valorconcedido double precision DEFAULT 0 NOT NULL,
    si93_mes bigint DEFAULT 0 NOT NULL,
    si93_reg10 bigint DEFAULT 0 NOT NULL,
    si93_instit bigint DEFAULT 0
);


ALTER TABLE conv112018 OWNER TO dbportal;

--
-- Name: conv112018_si93_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conv112018_si93_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conv112018_si93_sequencial_seq OWNER TO dbportal;

--
-- Name: conv202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conv202018 (
    si94_sequencial bigint DEFAULT 0 NOT NULL,
    si94_tiporegistro bigint DEFAULT 0 NOT NULL,
    si94_codorgao character varying(2) NOT NULL,
    si94_nroconvenio character varying(30) NOT NULL,
    si94_dtassinaturaconvoriginal date NOT NULL,
    si94_nroseqtermoaditivo character varying(2) NOT NULL,
    si94_dscalteracao character varying(500) NOT NULL,
    si94_dtassinaturatermoaditivo date NOT NULL,
    si94_datafinalvigencia date NOT NULL,
    si94_valoratualizadoconvenio double precision DEFAULT 0 NOT NULL,
    si94_valoratualizadocontrapartida double precision DEFAULT 0 NOT NULL,
    si94_mes bigint DEFAULT 0 NOT NULL,
    si94_instit bigint DEFAULT 0
);


ALTER TABLE conv202018 OWNER TO dbportal;

--
-- Name: conv202018_si94_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conv202018_si94_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conv202018_si94_sequencial_seq OWNER TO dbportal;

--
-- Name: cronem102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE cronem102018 (
    si170_sequencial bigint DEFAULT 0 NOT NULL,
    si170_tiporegistro bigint DEFAULT 0 NOT NULL,
    si170_codorgao character varying(2) DEFAULT 0 NOT NULL,
    si170_codunidadesub character varying(8) DEFAULT 0 NOT NULL,
    si170_grupodespesa bigint DEFAULT 0 NOT NULL,
    si170_vldotmensal double precision DEFAULT 0 NOT NULL,
    si170_instit bigint DEFAULT 0
);


ALTER TABLE cronem102018 OWNER TO dbportal;

--
-- Name: cronem102018_si170_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE cronem102018_si170_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cronem102018_si170_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb102018 (
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
    si95_nroconvenio bigint DEFAULT 0,
    si95_dataassinaturaconvenio date,
    si95_mes bigint DEFAULT 0 NOT NULL,
    si95_instit bigint DEFAULT 0
);


ALTER TABLE ctb102018 OWNER TO dbportal;

--
-- Name: ctb102018_si95_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb102018_si95_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb102018_si95_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb202018 (
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


ALTER TABLE ctb202018 OWNER TO dbportal;

--
-- Name: ctb202018_si96_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb202018_si96_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb202018_si96_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb212018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb212018 (
    si97_sequencial bigint DEFAULT 0 NOT NULL,
    si97_tiporegistro bigint DEFAULT 0 NOT NULL,
    si97_codctb bigint DEFAULT 0 NOT NULL,
    si97_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si97_codreduzidomov bigint DEFAULT 0 NOT NULL,
    si97_tipomovimentacao bigint DEFAULT 0 NOT NULL,
    si97_tipoentrsaida character varying(2) NOT NULL,
    si97_valorentrsaida double precision DEFAULT 0 NOT NULL,
    si97_codctbtransf bigint DEFAULT 0,
    si97_codfontectbtransf bigint DEFAULT 0 NOT NULL,
    si97_mes bigint DEFAULT 0 NOT NULL,
    si97_reg20 bigint DEFAULT 0 NOT NULL,
    si97_instit bigint DEFAULT 0
);


ALTER TABLE ctb212018 OWNER TO dbportal;

--
-- Name: ctb212018_si97_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb212018_si97_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb212018_si97_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb222018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb222018 (
    si98_sequencial bigint DEFAULT 0 NOT NULL,
    si98_tiporegistro bigint DEFAULT 0 NOT NULL,
    si98_codreduzidomov bigint DEFAULT 0 NOT NULL,
    si98_ededucaodereceita bigint DEFAULT 0 NOT NULL,
    si98_identificadordeducao bigint DEFAULT 0,
    si98_naturezareceita bigint DEFAULT 0 NOT NULL,
    si98_vlrreceitacont double precision DEFAULT 0 NOT NULL,
    si98_mes bigint DEFAULT 0 NOT NULL,
    si98_reg21 bigint DEFAULT 0 NOT NULL,
    si98_instit bigint DEFAULT 0
);


ALTER TABLE ctb222018 OWNER TO dbportal;

--
-- Name: ctb222018_si98_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb222018_si98_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb222018_si98_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb302018 (
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


ALTER TABLE ctb302018 OWNER TO dbportal;

--
-- Name: ctb302018_si99_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb302018_si99_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb302018_si99_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb312018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb312018 (
    si100_sequencial bigint DEFAULT 0 NOT NULL,
    si100_tiporegistro bigint DEFAULT 0 NOT NULL,
    si100_codagentearrecadador bigint DEFAULT 0 NOT NULL,
    si100_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si100_vlsaldoinicialagfonte double precision DEFAULT 0 NOT NULL,
    si100_vlentrada double precision DEFAULT 0 NOT NULL,
    si100_vlsaida double precision DEFAULT 0 NOT NULL,
    si100_vlsaldofinalagfonte double precision DEFAULT 0 NOT NULL,
    si100_mes bigint DEFAULT 0 NOT NULL,
    si100_reg30 bigint DEFAULT 0 NOT NULL,
    si100_instit integer DEFAULT 0
);


ALTER TABLE ctb312018 OWNER TO dbportal;

--
-- Name: ctb312018_si100_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb312018_si100_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb312018_si100_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb402018 (
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


ALTER TABLE ctb402018 OWNER TO dbportal;

--
-- Name: ctb402018_si101_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb402018_si101_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb402018_si101_sequencial_seq OWNER TO dbportal;

--
-- Name: ctb502018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ctb502018 (
    si102_sequencial bigint DEFAULT 0 NOT NULL,
    si102_tiporegistro bigint DEFAULT 0 NOT NULL,
    si102_codorgao character varying(2) NOT NULL,
    si102_codctb bigint DEFAULT 0 NOT NULL,
    si102_situacaoconta character varying(1) NOT NULL,
    si102_datasituacao date NOT NULL,
    si102_mes bigint DEFAULT 0 NOT NULL,
    si102_instit bigint DEFAULT 0
);


ALTER TABLE ctb502018 OWNER TO dbportal;

--
-- Name: ctb502018_si102_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ctb502018_si102_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ctb502018_si102_sequencial_seq OWNER TO dbportal;

--
-- Name: cvc102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE cvc102018 (
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


ALTER TABLE cvc102018 OWNER TO dbportal;

--
-- Name: cvc102018_si146_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE cvc102018_si146_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cvc102018_si146_sequencial_seq OWNER TO dbportal;

--
-- Name: cvc202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE cvc202018 (
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


ALTER TABLE cvc202018 OWNER TO dbportal;

--
-- Name: cvc202018_si147_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE cvc202018_si147_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cvc202018_si147_sequencial_seq OWNER TO dbportal;

--
-- Name: cvc302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE cvc302018 (
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


ALTER TABLE cvc302018 OWNER TO dbportal;

--
-- Name: cvc302018_si148_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE cvc302018_si148_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cvc302018_si148_sequencial_seq OWNER TO dbportal;

--
-- Name: cvc402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE cvc402018 (
    si149_sequencial bigint DEFAULT 0 NOT NULL,
    si149_tiporegistro bigint DEFAULT 0 NOT NULL,
    si149_codorgao character varying(2),
    si149_codunidadesub character varying(8),
    si149_codveiculo character varying(10),
    si149_tipobaixa bigint DEFAULT 0,
    si149_descbaixa character varying(50),
    si149_dtbaixa date,
    si149_mes bigint DEFAULT 0 NOT NULL,
    si149_instit bigint DEFAULT 0
);


ALTER TABLE cvc402018 OWNER TO dbportal;

--
-- Name: cvc402018_si149_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE cvc402018_si149_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cvc402018_si149_sequencial_seq OWNER TO dbportal;

--
-- Name: dclrf102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dclrf102018 (
    si157_sequencial bigint DEFAULT 0 NOT NULL,
    si157_tiporegistro bigint DEFAULT 0 NOT NULL,
    si157_codorgao bigint DEFAULT 0 NOT NULL,
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
    si157_dscmedidasadotadas character varying(4000),
    si157_mes bigint DEFAULT 0 NOT NULL,
    si157_instit bigint DEFAULT 0
);


ALTER TABLE dclrf102018 OWNER TO dbportal;

--
-- Name: dclrf102018_si157_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dclrf102018_si157_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dclrf102018_si157_sequencial_seq OWNER TO dbportal;

--
-- Name: dclrf202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dclrf202018 (
    si169_sequencial bigint DEFAULT 0 NOT NULL,
    si169_tiporegistro bigint DEFAULT 0 NOT NULL,
    si169_contopcredito bigint DEFAULT 0 NOT NULL,
    si169_dsccontopcredito character varying(1000) DEFAULT 0 NOT NULL,
    si169_realizopcredito bigint DEFAULT 0 NOT NULL,
    si169_tiporealizopcreditocapta bigint DEFAULT 0 NOT NULL,
    si169_tiporealizopcreditoreceb bigint DEFAULT 0 NOT NULL,
    si169_tiporealizopcreditoassundir bigint DEFAULT 0 NOT NULL,
    si169_tiporealizopcreditoassunobg bigint DEFAULT 0 NOT NULL,
    si169_mes bigint DEFAULT 0 NOT NULL,
    si169_instit bigint DEFAULT 0
);


ALTER TABLE dclrf202018 OWNER TO dbportal;

--
-- Name: dclrf202018_si169_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dclrf202018_si169_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dclrf202018_si169_sequencial_seq OWNER TO dbportal;

--
-- Name: dclrf302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dclrf302018 (
    si178_sequencial bigint NOT NULL,
    si178_tiporegistro integer NOT NULL,
    si178_publiclrf integer NOT NULL,
    si178_dtpublicacaorelatoriolrf date NOT NULL,
    si178_localpublicacao character varying(1000) NOT NULL,
    si178_tpbimestre integer NOT NULL,
    si178_exerciciotpbimestre integer NOT NULL,
    si178_mes bigint NOT NULL,
    si178_instit bigint
);


ALTER TABLE dclrf302018 OWNER TO dbportal;

--
-- Name: dclrf302018_si178_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dclrf302018_si178_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dclrf302018_si178_sequencial_seq OWNER TO dbportal;

--
-- Name: dclrf402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dclrf402018 (
    si230_sequencial bigint NOT NULL,
    si230_tiporegistro integer NOT NULL,
    si230_publicrgf integer NOT NULL,
    si230_dtpublicacaorgf date NOT NULL,
    si230_localpublicacaorgf character varying(1000) NOT NULL,
    si230_tpperiodo integer NOT NULL,
    si230_exerciciotpperiodo integer NOT NULL,
    si230_mes bigint NOT NULL,
    si230_instit bigint
);


ALTER TABLE dclrf402018 OWNER TO dbportal;

--
-- Name: dclrf402018_si230_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dclrf402018_si230_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dclrf402018_si230_sequencial_seq OWNER TO dbportal;

--
-- Name: ddc102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ddc102018 (
    si150_sequencial bigint DEFAULT 0 NOT NULL,
    si150_tiporegistro bigint DEFAULT 0 NOT NULL,
    si150_codorgao character varying(2) NOT NULL,
    si150_nroleiautorizacao character varying(6) DEFAULT '0'::character varying NOT NULL,
    si150_dtleiautorizacao date NOT NULL,
    si150_dtpublicacaoleiautorizacao date NOT NULL,
    si150_mes bigint DEFAULT 0 NOT NULL,
    si150_instit bigint DEFAULT 0
);


ALTER TABLE ddc102018 OWNER TO dbportal;

--
-- Name: ddc102018_si150_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ddc102018_si150_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ddc102018_si150_sequencial_seq OWNER TO dbportal;

--
-- Name: ddc112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ddc112018 (
    si151_sequencial bigint DEFAULT 0 NOT NULL,
    si151_tiporegistro bigint DEFAULT 0 NOT NULL,
    si151_codcontrato bigint DEFAULT 0 NOT NULL,
    si151_codorgao character varying(2) NOT NULL,
    si151_nrocontratodivida bigint DEFAULT 0 NOT NULL,
    si151_dataassinatura date NOT NULL,
    si151_tipolancamento character varying(2) NOT NULL,
    si151_objetocontrato character varying(500) NOT NULL,
    si151_mes bigint DEFAULT 0 NOT NULL,
    si151_reg10 bigint DEFAULT 0 NOT NULL,
    si151_instit bigint DEFAULT 0
);


ALTER TABLE ddc112018 OWNER TO dbportal;

--
-- Name: ddc112018_si151_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ddc112018_si151_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ddc112018_si151_sequencial_seq OWNER TO dbportal;

--
-- Name: ddc122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ddc122018 (
    si152_sequencial bigint DEFAULT 0 NOT NULL,
    si152_tiporegistro bigint DEFAULT 0 NOT NULL,
    si152_codcontrato bigint DEFAULT 0 NOT NULL,
    si152_tipodocumento bigint DEFAULT 0 NOT NULL,
    si152_nrodocumento character varying(14) NOT NULL,
    si152_mes bigint DEFAULT 0 NOT NULL,
    si152_reg10 bigint DEFAULT 0 NOT NULL,
    si152_instit bigint DEFAULT 0
);


ALTER TABLE ddc122018 OWNER TO dbportal;

--
-- Name: ddc122018_si152_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ddc122018_si152_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ddc122018_si152_sequencial_seq OWNER TO dbportal;

--
-- Name: ddc202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ddc202018 (
    si153_sequencial bigint DEFAULT 0 NOT NULL,
    si153_tiporegistro bigint DEFAULT 0 NOT NULL,
    si153_codorgao character varying(2) NOT NULL,
    si153_nrocontratodivida character varying(30) NOT NULL,
    si153_dtassinatura date NOT NULL,
    si153_contratodeclei bigint DEFAULT 0 NOT NULL,
    si153_nroleiautorizacao character varying(6) NOT NULL,
    si153_dtleiautorizacao date NOT NULL,
    si153_objetocontratodivida character varying(1000) NOT NULL,
    si153_especificacaocontratodivida character varying(500) NOT NULL,
    si153_mes bigint DEFAULT 0 NOT NULL,
    si153_instit bigint DEFAULT 0
);


ALTER TABLE ddc202018 OWNER TO dbportal;

--
-- Name: ddc202018_si153_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ddc202018_si153_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ddc202018_si153_sequencial_seq OWNER TO dbportal;

--
-- Name: ddc302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ddc302018 (
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


ALTER TABLE ddc302018 OWNER TO dbportal;

--
-- Name: ddc302018_si154_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ddc302018_si154_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ddc302018_si154_sequencial_seq OWNER TO dbportal;

--
-- Name: ddc402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ddc402018 (
    si178_sequencial bigint DEFAULT 0 NOT NULL,
    si178_tiporegistro bigint DEFAULT 0 NOT NULL,
    si178_codorgao character varying(2) NOT NULL,
    si178_passivoatuarial bigint DEFAULT 0 NOT NULL,
    si178_vlsaldoanterior double precision DEFAULT 0 NOT NULL,
    si178_vlsaldoatual double precision DEFAULT 0,
    si178_mes bigint DEFAULT 0 NOT NULL,
    si178_instit bigint DEFAULT 0
);


ALTER TABLE ddc402018 OWNER TO dbportal;

--
-- Name: ddc402018_si178_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ddc402018_si178_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ddc402018_si178_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp1002018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp1002018 (
    si228_sequencial integer DEFAULT 0 NOT NULL,
    si228_tiporegistro integer DEFAULT 0 NOT NULL,
    si228_exercicio integer DEFAULT 0 NOT NULL,
    si228_vlgeracaoliquidaequivalentecaixa double precision DEFAULT 0,
    si228_anousu integer DEFAULT 0 NOT NULL,
    si228_periodo integer DEFAULT 0 NOT NULL,
    si228_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp1002018 OWNER TO dbportal;

--
-- Name: dfcdcasp1002018_si228_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp1002018_si228_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp1002018_si228_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp102018 (
    si219_sequencial integer DEFAULT 0 NOT NULL,
    si219_tiporegistro integer DEFAULT 0 NOT NULL,
    si219_exercicio integer DEFAULT 0 NOT NULL,
    si219_vlreceitaderivadaoriginaria double precision DEFAULT 0 NOT NULL,
    si219_vltranscorrenterecebida double precision DEFAULT 0 NOT NULL,
    si219_vloutrosingressosoperacionais double precision DEFAULT 0 NOT NULL,
    si219_vltotalingressosativoperacionais double precision DEFAULT 0,
    si219_anousu integer DEFAULT 0 NOT NULL,
    si219_periodo integer DEFAULT 0 NOT NULL,
    si219_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp102018 OWNER TO dbportal;

--
-- Name: dfcdcasp102018_si219_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp102018_si219_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp102018_si219_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp1102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp1102018 (
    si229_sequencial integer DEFAULT 0 NOT NULL,
    si229_tiporegistro integer DEFAULT 0 NOT NULL,
    si229_exercicio integer DEFAULT 0 NOT NULL,
    si229_vlcaixaequivalentecaixainicial double precision DEFAULT 0 NOT NULL,
    si229_vlcaixaequivalentecaixafinal double precision DEFAULT 0,
    si229_anousu integer DEFAULT 0 NOT NULL,
    si229_periodo integer DEFAULT 0 NOT NULL,
    si229_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp1102018 OWNER TO dbportal;

--
-- Name: dfcdcasp1102018_si229_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp1102018_si229_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp1102018_si229_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp202018 (
    si220_sequencial integer DEFAULT 0 NOT NULL,
    si220_tiporegistro integer DEFAULT 0 NOT NULL,
    si220_exercicio integer DEFAULT 0 NOT NULL,
    si220_vldesembolsopessoaldespesas double precision DEFAULT 0 NOT NULL,
    si220_vldesembolsojurosencargdivida double precision DEFAULT 0 NOT NULL,
    si220_vldesembolsotransfconcedidas double precision DEFAULT 0 NOT NULL,
    si220_vloutrosdesembolsos double precision DEFAULT 0 NOT NULL,
    si220_vltotaldesembolsosativoperacionais double precision DEFAULT 0,
    si220_anousu integer DEFAULT 0 NOT NULL,
    si220_periodo integer DEFAULT 0 NOT NULL,
    si220_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp202018 OWNER TO dbportal;

--
-- Name: dfcdcasp202018_si220_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp202018_si220_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp202018_si220_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp302018 (
    si221_sequencial integer DEFAULT 0 NOT NULL,
    si221_tiporegistro integer DEFAULT 0 NOT NULL,
    si221_exercicio integer DEFAULT 0 NOT NULL,
    si221_vlfluxocaixaliquidooperacional double precision DEFAULT 0,
    si221_anousu integer DEFAULT 0 NOT NULL,
    si221_periodo integer DEFAULT 0 NOT NULL,
    si221_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp302018 OWNER TO dbportal;

--
-- Name: dfcdcasp302018_si221_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp302018_si221_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp302018_si221_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp402018 (
    si222_sequencial integer DEFAULT 0 NOT NULL,
    si222_tiporegistro integer DEFAULT 0 NOT NULL,
    si222_exercicio integer DEFAULT 0 NOT NULL,
    si222_vlalienacaobens double precision DEFAULT 0 NOT NULL,
    si222_vlamortizacaoemprestimoconcedido double precision DEFAULT 0 NOT NULL,
    si222_vloutrosingressos double precision DEFAULT 0 NOT NULL,
    si222_vltotalingressosatividainvestiment double precision DEFAULT 0,
    si222_anousu integer DEFAULT 0 NOT NULL,
    si222_periodo integer DEFAULT 0 NOT NULL,
    si222_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp402018 OWNER TO dbportal;

--
-- Name: dfcdcasp402018_si222_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp402018_si222_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp402018_si222_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp502018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp502018 (
    si223_sequencial integer DEFAULT 0 NOT NULL,
    si223_tiporegistro integer DEFAULT 0 NOT NULL,
    si223_exercicio integer DEFAULT 0 NOT NULL,
    si223_vlaquisicaoativonaocirculante double precision DEFAULT 0 NOT NULL,
    si223_vlconcessaoempresfinanciamento double precision DEFAULT 0 NOT NULL,
    si223_vloutrosdesembolsos double precision DEFAULT 0 NOT NULL,
    si223_vltotaldesembolsoatividainvestimen double precision DEFAULT 0,
    si223_anousu integer DEFAULT 0 NOT NULL,
    si223_periodo integer DEFAULT 0 NOT NULL,
    si223_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp502018 OWNER TO dbportal;

--
-- Name: dfcdcasp502018_si223_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp502018_si223_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp502018_si223_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp602018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp602018 (
    si224_sequencial integer DEFAULT 0 NOT NULL,
    si224_tiporegistro integer DEFAULT 0 NOT NULL,
    si224_exercicio integer DEFAULT 0 NOT NULL,
    si224_vlfluxocaixaliquidoinvestimento double precision DEFAULT 0,
    si224_anousu integer DEFAULT 0 NOT NULL,
    si224_periodo integer DEFAULT 0 NOT NULL,
    si224_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp602018 OWNER TO dbportal;

--
-- Name: dfcdcasp602018_si224_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp602018_si224_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp602018_si224_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp702018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp702018 (
    si225_sequencial integer DEFAULT 0 NOT NULL,
    si225_tiporegistro integer DEFAULT 0 NOT NULL,
    si225_exercicio integer DEFAULT 0 NOT NULL,
    si225_vloperacoescredito double precision DEFAULT 0 NOT NULL,
    si225_vlintegralizacaodependentes double precision DEFAULT 0 NOT NULL,
    si225_vltranscapitalrecebida double precision DEFAULT 0 NOT NULL,
    si225_vloutrosingressosfinanciamento double precision DEFAULT 0 NOT NULL,
    si225_vltotalingressoatividafinanciament double precision DEFAULT 0,
    si225_anousu integer DEFAULT 0 NOT NULL,
    si225_periodo integer DEFAULT 0 NOT NULL,
    si225_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp702018 OWNER TO dbportal;

--
-- Name: dfcdcasp702018_si225_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp702018_si225_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp702018_si225_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp802018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp802018 (
    si226_sequencial integer DEFAULT 0 NOT NULL,
    si226_tiporegistro integer DEFAULT 0 NOT NULL,
    si226_exercicio integer DEFAULT 0 NOT NULL,
    si226_vlamortizacaorefinanciamento double precision DEFAULT 0 NOT NULL,
    si226_vloutrosdesembolsosfinanciamento double precision DEFAULT 0 NOT NULL,
    si226_vltotaldesembolsoatividafinanciame double precision DEFAULT 0,
    si226_anousu integer DEFAULT 0 NOT NULL,
    si226_periodo integer DEFAULT 0 NOT NULL,
    si226_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp802018 OWNER TO dbportal;

--
-- Name: dfcdcasp802018_si226_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp802018_si226_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp802018_si226_sequencial_seq OWNER TO dbportal;

--
-- Name: dfcdcasp902018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dfcdcasp902018 (
    si227_sequencial integer DEFAULT 0 NOT NULL,
    si227_tiporegistro integer DEFAULT 0 NOT NULL,
    si227_exercicio integer DEFAULT 0 NOT NULL,
    si227_vlfluxocaixafinanciamento double precision DEFAULT 0,
    si227_anousu integer DEFAULT 0 NOT NULL,
    si227_periodo integer DEFAULT 0 NOT NULL,
    si227_instit integer DEFAULT 0 NOT NULL
);


ALTER TABLE dfcdcasp902018 OWNER TO dbportal;

--
-- Name: dfcdcasp902018_si227_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dfcdcasp902018_si227_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dfcdcasp902018_si227_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa102018 (
    si74_sequencial bigint DEFAULT 0 NOT NULL,
    si74_tiporegistro bigint,
    si74_codorgaoresp character varying(2),
    si74_codunidadesubresp character varying(8),
    si74_exercicioprocesso bigint,
    si74_nroprocesso character varying(12),
    si74_tipoprocesso bigint,
    si74_dtabertura date,
    si74_naturezaobjeto bigint,
    si74_objeto character varying(500),
    si74_justificativa character varying(250),
    si74_razao character varying(250),
    si74_dtpublicacaotermoratificacao date,
    si74_veiculopublicacao character varying(50),
    si74_processoporlote bigint,
    si74_mes bigint,
    si74_instit bigint
);


ALTER TABLE dispensa102018 OWNER TO dbportal;

--
-- Name: dispensa102018_si74_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa102018_si74_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa102018_si74_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa112018 (
    si75_sequencial bigint DEFAULT 0 NOT NULL,
    si75_tiporegistro bigint,
    si75_codorgaoresp character varying(2),
    si75_codunidadesubresp character varying(8),
    si75_exercicioprocesso bigint,
    si75_nroprocesso character varying(12),
    si75_tipoprocesso bigint,
    si75_nrolote bigint,
    si75_dsclote character varying(250),
    si75_mes bigint,
    si75_reg10 bigint DEFAULT 0 NOT NULL,
    si75_instit bigint
);


ALTER TABLE dispensa112018 OWNER TO dbportal;

--
-- Name: dispensa112018_si75_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa112018_si75_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa112018_si75_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa122018 (
    si76_sequencial bigint DEFAULT 0 NOT NULL,
    si76_tiporegistro bigint,
    si76_codorgaoresp character varying(2),
    si76_codunidadesubresp character varying(8),
    si76_exercicioprocesso bigint,
    si76_nroprocesso character varying(12),
    si76_tipoprocesso bigint,
    si76_coditem bigint,
    si76_nroitem bigint,
    si76_mes bigint,
    si76_reg10 bigint DEFAULT 0 NOT NULL,
    si76_instit bigint
);


ALTER TABLE dispensa122018 OWNER TO dbportal;

--
-- Name: dispensa122018_si76_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa122018_si76_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa122018_si76_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa132018 (
    si77_sequencial bigint DEFAULT 0 NOT NULL,
    si77_tiporegistro bigint,
    si77_codorgaoresp character varying(2),
    si77_codunidadesubresp character varying(8),
    si77_exercicioprocesso bigint,
    si77_nroprocesso character varying(12),
    si77_tipoprocesso bigint,
    si77_nrolote bigint,
    si77_coditem bigint,
    si77_mes bigint,
    si77_reg10 bigint DEFAULT 0 NOT NULL,
    si77_instit bigint DEFAULT 0
);


ALTER TABLE dispensa132018 OWNER TO dbportal;

--
-- Name: dispensa132018_si77_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa132018_si77_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa132018_si77_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa142018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa142018 (
    si78_sequencial bigint DEFAULT 0 NOT NULL,
    si78_tiporegistro bigint,
    si78_codorgaoresp character varying(2),
    si78_codunidadesubres character varying(8),
    si78_exercicioprocesso bigint,
    si78_nroprocesso character varying(12),
    si78_tipoprocesso bigint,
    si78_tiporesp bigint,
    si78_nrocpfresp character varying(11),
    si78_mes bigint,
    si78_reg10 bigint DEFAULT 0 NOT NULL,
    si78_instit bigint
);


ALTER TABLE dispensa142018 OWNER TO dbportal;

--
-- Name: dispensa142018_si78_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa142018_si78_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa142018_si78_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa152018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa152018 (
    si79_sequencial bigint DEFAULT 0 NOT NULL,
    si79_tiporegistro bigint DEFAULT 0 NOT NULL,
    si79_codorgaoresp character varying(2),
    si79_codunidadesubresp character varying(8),
    si79_exercicioprocesso bigint,
    si79_nroprocesso character varying(12),
    si79_tipoprocesso bigint,
    si79_nrolote bigint,
    si79_coditem bigint,
    si79_vlcotprecosunitario double precision,
    si79_quantidade double precision,
    si79_mes bigint,
    si79_reg10 bigint DEFAULT 0 NOT NULL,
    si79_instit bigint
);


ALTER TABLE dispensa152018 OWNER TO dbportal;

--
-- Name: dispensa152018_si79_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa152018_si79_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa152018_si79_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa162018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa162018 (
    si80_sequencial bigint DEFAULT 0 NOT NULL,
    si80_tiporegistro bigint,
    si80_codorgaoresp character varying(2),
    si80_codunidadesubresp character varying(8),
    si80_exercicioprocesso bigint,
    si80_nroprocesso character varying(12),
    si80_tipoprocesso bigint,
    si80_codorgao character varying(2),
    si80_codunidadesub character varying(8),
    si80_codfuncao character varying(2),
    si80_codsubfuncao character varying(3),
    si80_codprograma character varying(4),
    si80_idacao character varying(4),
    si80_idsubacao character varying(4),
    si80_naturezadespesa bigint,
    si80_codfontrecursos bigint,
    si80_vlrecurso double precision,
    si80_mes bigint,
    si80_reg10 bigint DEFAULT 0 NOT NULL,
    si80_instit bigint
);


ALTER TABLE dispensa162018 OWNER TO dbportal;

--
-- Name: dispensa162018_si80_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa162018_si80_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa162018_si80_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa172018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa172018 (
    si81_sequencial bigint DEFAULT 0 NOT NULL,
    si81_tiporegistro bigint DEFAULT 0 NOT NULL,
    si81_codorgaoresp character varying(2),
    si81_codunidadesubresp character varying(8),
    si81_exercicioprocesso bigint DEFAULT 0 NOT NULL,
    si81_nroprocesso character varying(12),
    si81_tipoprocesso bigint DEFAULT 0 NOT NULL,
    si81_tipodocumento bigint DEFAULT 0 NOT NULL,
    si81_nrodocumento character varying(14),
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


ALTER TABLE dispensa172018 OWNER TO dbportal;

--
-- Name: dispensa172018_si81_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa172018_si81_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa172018_si81_sequencial_seq OWNER TO dbportal;

--
-- Name: dispensa182018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dispensa182018 (
    si82_sequencial bigint DEFAULT 0 NOT NULL,
    si82_tiporegistro bigint DEFAULT 0 NOT NULL,
    si82_codorgaoresp character varying(2) NOT NULL,
    si82_codunidadesubresp character varying(8) NOT NULL,
    si82_exercicioprocesso bigint DEFAULT 0 NOT NULL,
    si82_nroprocesso character varying(12),
    si82_tipoprocesso bigint DEFAULT 0 NOT NULL,
    si82_tipodocumento bigint DEFAULT 0 NOT NULL,
    si82_nrodocumento character varying(14),
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


ALTER TABLE dispensa182018 OWNER TO dbportal;

--
-- Name: dispensa182018_si82_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dispensa182018_si82_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dispensa182018_si82_sequencial_seq OWNER TO dbportal;

--
-- Name: dvpdcasp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dvpdcasp102018 (
    si216_sequencial integer DEFAULT 0 NOT NULL,
    si216_tiporegistro integer DEFAULT 0 NOT NULL,
    si216_exercicio integer DEFAULT 0 NOT NULL,
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


ALTER TABLE dvpdcasp102018 OWNER TO dbportal;

--
-- Name: dvpdcasp102018_si216_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dvpdcasp102018_si216_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dvpdcasp102018_si216_sequencial_seq OWNER TO dbportal;

--
-- Name: dvpdcasp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dvpdcasp202018 (
    si217_sequencial integer DEFAULT 0 NOT NULL,
    si217_tiporegistro integer DEFAULT 0 NOT NULL,
    si217_exercicio integer DEFAULT 0 NOT NULL,
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


ALTER TABLE dvpdcasp202018 OWNER TO dbportal;

--
-- Name: dvpdcasp202018_si217_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dvpdcasp202018_si217_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dvpdcasp202018_si217_sequencial_seq OWNER TO dbportal;

--
-- Name: dvpdcasp302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE dvpdcasp302018 (
    si218_sequencial integer DEFAULT 0 NOT NULL,
    si218_tiporegistro integer DEFAULT 0 NOT NULL,
    si218_exercicio integer DEFAULT 0 NOT NULL,
    si218_vlresultadopatrimonialperiodo double precision DEFAULT 0,
    si218_ano integer DEFAULT 0 NOT NULL,
    si218_periodo integer DEFAULT 0 NOT NULL,
    si218_institu integer DEFAULT 0 NOT NULL
);


ALTER TABLE dvpdcasp302018 OWNER TO dbportal;

--
-- Name: dvpdcasp302018_si218_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE dvpdcasp302018_si218_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE dvpdcasp302018_si218_sequencial_seq OWNER TO dbportal;

--
-- Name: emp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE emp102018 (
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


ALTER TABLE emp102018 OWNER TO dbportal;

--
-- Name: emp102018_si106_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE emp102018_si106_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE emp102018_si106_sequencial_seq OWNER TO dbportal;

--
-- Name: emp112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE emp112018 (
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


ALTER TABLE emp112018 OWNER TO dbportal;

--
-- Name: emp112018_si107_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE emp112018_si107_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE emp112018_si107_sequencial_seq OWNER TO dbportal;

--
-- Name: emp122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE emp122018 (
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


ALTER TABLE emp122018 OWNER TO dbportal;

--
-- Name: emp122018_si108_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE emp122018_si108_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE emp122018_si108_sequencial_seq OWNER TO dbportal;

--
-- Name: emp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE emp202018 (
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


ALTER TABLE emp202018 OWNER TO dbportal;

--
-- Name: emp202018_si109_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE emp202018_si109_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE emp202018_si109_sequencial_seq OWNER TO dbportal;

--
-- Name: ext102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ext102018 (
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


ALTER TABLE ext102018 OWNER TO dbportal;

--
-- Name: ext102018_si124_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ext102018_si124_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ext102018_si124_sequencial_seq OWNER TO dbportal;

--
-- Name: ext202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ext202018 (
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


ALTER TABLE ext202018 OWNER TO dbportal;

--
-- Name: ext202018_si165_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ext202018_si165_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ext202018_si165_sequencial_seq OWNER TO dbportal;

--
-- Name: ext302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ext302018 (
    si126_sequencial bigint DEFAULT 0 NOT NULL,
    si126_tiporegistro bigint DEFAULT 0 NOT NULL,
    si126_codext bigint DEFAULT 0 NOT NULL,
    si126_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si126_codreduzidoop bigint DEFAULT 0 NOT NULL,
    si126_nroop bigint DEFAULT 0,
    si126_codunidadesub character varying(8) NOT NULL,
    si126_dtpagamento date,
    si126_tipodocumentocredor bigint DEFAULT 0,
    si126_nrodocumentocredor character varying(14),
    si126_vlop double precision DEFAULT 0,
    si126_especificacaoop character varying(200),
    si126_cpfresppgto character varying(11),
    si126_mes bigint DEFAULT 0 NOT NULL,
    si126_instit bigint DEFAULT 0
);


ALTER TABLE ext302018 OWNER TO dbportal;

--
-- Name: ext302018_si126_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ext302018_si126_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ext302018_si126_sequencial_seq OWNER TO dbportal;

--
-- Name: ext312018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ext312018 (
    si127_sequencial bigint DEFAULT 0 NOT NULL,
    si127_tiporegistro bigint DEFAULT 0 NOT NULL,
    si127_codreduzidoop bigint DEFAULT 0,
    si127_tipodocumentoop character varying(2),
    si127_nrodocumento character varying(15),
    si127_codctb bigint DEFAULT 0,
    si127_codfontectb bigint DEFAULT 0,
    si127_desctipodocumentoop character varying(50),
    si127_dtemissao date,
    si127_vldocumento double precision DEFAULT 0,
    si127_mes bigint DEFAULT 0 NOT NULL,
    si127_reg30 bigint DEFAULT 0,
    si127_instit bigint DEFAULT 0
);


ALTER TABLE ext312018 OWNER TO dbportal;

--
-- Name: ext312018_si127_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ext312018_si127_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ext312018_si127_sequencial_seq OWNER TO dbportal;

--
-- Name: ext322018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ext322018 (
    si128_sequencial bigint DEFAULT 0 NOT NULL,
    si128_tiporegistro bigint DEFAULT 0 NOT NULL,
    si128_codreduzidoop bigint DEFAULT 0,
    si128_tiporetencao character varying(4),
    si128_descricaoretencao character varying(50),
    si128_vlretencao double precision DEFAULT 0,
    si128_mes bigint DEFAULT 0 NOT NULL,
    si128_reg30 bigint DEFAULT 0,
    si128_instit bigint DEFAULT 0
);


ALTER TABLE ext322018 OWNER TO dbportal;

--
-- Name: ext322018_si128_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ext322018_si128_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ext322018_si128_sequencial_seq OWNER TO dbportal;

--
-- Name: flpgo102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE flpgo102018 (
    si195_sequencial bigint DEFAULT 0 NOT NULL,
    si195_tiporegistro bigint DEFAULT 0 NOT NULL,
    si195_nrodocumento character varying(14) DEFAULT 0 NOT NULL,
    si195_codreduzidopessoa bigint DEFAULT 0 NOT NULL,
    si195_regime character varying(1) NOT NULL,
    si195_indtipopagamento character varying(1) NOT NULL,
    si195_indsituacaoservidorpensionista character varying(1) NOT NULL,
    si195_dscsituacao character varying(120),
    si195_datconcessaoaposentadoriapensao date,
    si195_dsccargo character varying(150) NOT NULL,
    si195_sglcargo character varying(3) NOT NULL,
    si195_dscsiglacargo character varying(150),
    si195_reqcargo bigint DEFAULT 0 NOT NULL,
    si195_indcessao character varying(3),
    si195_dsclotacao character varying(120),
    si195_vlrcargahorariasemanal bigint DEFAULT 0,
    si195_datefetexercicio date NOT NULL,
    si195_datexclusao date,
    si195_vlrremuneracaobruta double precision DEFAULT 0 NOT NULL,
    si195_natsaldoliquido character varying(1) NOT NULL,
    si195_vlrremuneracaoliquida double precision DEFAULT 0 NOT NULL,
    si195_vlrdeducoes double precision DEFAULT 0 NOT NULL,
    si195_mes bigint DEFAULT 0 NOT NULL,
    si195_inst bigint DEFAULT 0
);


ALTER TABLE flpgo102018 OWNER TO dbportal;

--
-- Name: flpgo102018_si195_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE flpgo102018_si195_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE flpgo102018_si195_sequencial_seq OWNER TO dbportal;

--
-- Name: flpgo112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE flpgo112018 (
    si196_sequencial bigint DEFAULT 0 NOT NULL,
    si196_tiporegistro bigint DEFAULT 0 NOT NULL,
    si196_nrodocumento character varying(14) DEFAULT 0 NOT NULL,
    si196_codreduzidopessoa bigint DEFAULT 0 NOT NULL,
    si196_tiporemuneracao bigint DEFAULT 0 NOT NULL,
    si196_desctiporemuneracao character varying(150),
    si196_vlrremuneracaodetalhada double precision DEFAULT 0 NOT NULL,
    si196_mes bigint DEFAULT 0 NOT NULL,
    si196_inst bigint DEFAULT 0 NOT NULL,
    si196_reg10 bigint DEFAULT 0
);


ALTER TABLE flpgo112018 OWNER TO dbportal;

--
-- Name: flpgo112018_si196_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE flpgo112018_si196_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE flpgo112018_si196_sequencial_seq OWNER TO dbportal;

--
-- Name: flpgo122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE flpgo122018 (
    si197_sequencial bigint DEFAULT 0 NOT NULL,
    si197_tiporegistro bigint DEFAULT 0 NOT NULL,
    si197_nrodocumento character varying(14) DEFAULT 0 NOT NULL,
    si197_codreduzidopessoa bigint DEFAULT 0 NOT NULL,
    si197_tipodesconto bigint DEFAULT 0 NOT NULL,
    si197_vlrdescontodetalhado double precision DEFAULT 0 NOT NULL,
    si197_mes bigint DEFAULT 0 NOT NULL,
    si197_inst bigint DEFAULT 0 NOT NULL,
    si197_reg10 bigint DEFAULT 0
);


ALTER TABLE flpgo122018 OWNER TO dbportal;

--
-- Name: flpgo122018_si197_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE flpgo122018_si197_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE flpgo122018_si197_sequencial_seq OWNER TO dbportal;

--
-- Name: hablic102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE hablic102018 (
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


ALTER TABLE hablic102018 OWNER TO dbportal;

--
-- Name: hablic102018_si57_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE hablic102018_si57_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE hablic102018_si57_sequencial_seq OWNER TO dbportal;

--
-- Name: hablic112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE hablic112018 (
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


ALTER TABLE hablic112018 OWNER TO dbportal;

--
-- Name: hablic112018_si58_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE hablic112018_si58_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE hablic112018_si58_sequencial_seq OWNER TO dbportal;

--
-- Name: hablic202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE hablic202018 (
    si59_sequencial bigint DEFAULT 0 NOT NULL,
    si59_tiporegistro bigint DEFAULT 0 NOT NULL,
    si59_codorgao character varying(2) NOT NULL,
    si59_codunidadesub character varying(8) NOT NULL,
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


ALTER TABLE hablic202018 OWNER TO dbportal;

--
-- Name: hablic202018_si59_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE hablic202018_si59_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE hablic202018_si59_sequencial_seq OWNER TO dbportal;

--
-- Name: homolic102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE homolic102018 (
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


ALTER TABLE homolic102018 OWNER TO dbportal;

--
-- Name: homolic102018_si63_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE homolic102018_si63_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homolic102018_si63_sequencial_seq OWNER TO dbportal;

--
-- Name: homolic202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE homolic202018 (
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


ALTER TABLE homolic202018 OWNER TO dbportal;

--
-- Name: homolic202018_si64_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE homolic202018_si64_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homolic202018_si64_sequencial_seq OWNER TO dbportal;

--
-- Name: homolic402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE homolic402018 (
    si65_sequencial bigint DEFAULT 0 NOT NULL,
    si65_tiporegistro bigint DEFAULT 0 NOT NULL,
    si65_codorgao character varying(2) NOT NULL,
    si65_codunidadesub character varying(8) NOT NULL,
    si65_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
    si65_nroprocessolicitatorio character varying(12) NOT NULL,
    si65_dthomologacao date NOT NULL,
    si65_dtadjudicacao date,
    si65_mes bigint DEFAULT 0 NOT NULL,
    si65_instit bigint DEFAULT 0
);


ALTER TABLE homolic402018 OWNER TO dbportal;

--
-- Name: homolic402018_si65_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE homolic402018_si65_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE homolic402018_si65_sequencial_seq OWNER TO dbportal;

--
-- Name: ide2018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ide2018 (
    si11_sequencial bigint DEFAULT 0 NOT NULL,
    si11_codmunicipio character varying(5) NOT NULL,
    si11_cnpjmunicipio character varying(14) NOT NULL,
    si11_codorgao character varying(2) NOT NULL,
    si11_tipoorgao character varying(2) NOT NULL,
    si11_exercicioreferencia bigint DEFAULT 0 NOT NULL,
    si11_mesreferencia character varying(2) NOT NULL,
    si11_datageracao date NOT NULL,
    si11_codcontroleremessa character varying(20),
    si11_mes bigint DEFAULT 0 NOT NULL,
    si11_instit bigint DEFAULT 0
);


ALTER TABLE ide2018 OWNER TO dbportal;

--
-- Name: ide2018_si11_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ide2018_si11_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ide2018_si11_sequencial_seq OWNER TO dbportal;

--
-- Name: idedcasp2018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE idedcasp2018 (
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


ALTER TABLE idedcasp2018 OWNER TO dbportal;

--
-- Name: idedcasp2018_si200_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE idedcasp2018_si200_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE idedcasp2018_si200_sequencial_seq OWNER TO dbportal;

--
-- Name: incamp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE incamp102018 (
    si160_sequencial bigint DEFAULT 0 NOT NULL,
    si160_tiporegistro bigint DEFAULT 0 NOT NULL,
    si160_possuisubacao bigint DEFAULT 0 NOT NULL,
    si160_idacao character varying(4) NOT NULL,
    si160_descacao character varying(200) NOT NULL,
    si160_finalidadeacao character varying(500) NOT NULL,
    si160_produto character varying(50),
    si160_unidademedida character varying(15),
    si160_metas1ano double precision DEFAULT 0 NOT NULL,
    si160_metas2ano double precision DEFAULT 0 NOT NULL,
    si160_metas3ano double precision DEFAULT 0 NOT NULL,
    si160_metas4ano double precision DEFAULT 0 NOT NULL,
    si160_recursos1ano double precision DEFAULT 0 NOT NULL,
    si160_recursos2ano double precision DEFAULT 0 NOT NULL,
    si160_recursos3ano double precision DEFAULT 0 NOT NULL,
    si160_recursos4ano double precision DEFAULT 0 NOT NULL,
    si160_mes bigint DEFAULT 0 NOT NULL,
    si160_instit bigint DEFAULT 0
);


ALTER TABLE incamp102018 OWNER TO dbportal;

--
-- Name: incamp102018_si160_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE incamp102018_si160_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE incamp102018_si160_sequencial_seq OWNER TO dbportal;

--
-- Name: incamp112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE incamp112018 (
    si161_sequencial bigint DEFAULT 0 NOT NULL,
    si161_tiporegistro bigint DEFAULT 0 NOT NULL,
    si161_idacao character varying(4) NOT NULL,
    si161_idsubacao character varying(4) NOT NULL,
    si161_descdubacao character varying(200) NOT NULL,
    si161_finalidadesubacao character varying(500) NOT NULL,
    si161_produtosubacao character varying(50) NOT NULL,
    si161_unidademedida character varying(15) NOT NULL,
    si161_metas1ano double precision DEFAULT 0 NOT NULL,
    si161_metas2ano double precision DEFAULT 0 NOT NULL,
    si161_metas3ano double precision DEFAULT 0 NOT NULL,
    si161_metas4ano double precision DEFAULT 0 NOT NULL,
    si161_recursos1ano double precision DEFAULT 0 NOT NULL,
    si161_recursos2ano double precision DEFAULT 0 NOT NULL,
    si161_recursos3ano double precision DEFAULT 0 NOT NULL,
    si161_recursos4ano double precision DEFAULT 0 NOT NULL,
    si161_mes bigint DEFAULT 0 NOT NULL,
    si161_reg10 bigint DEFAULT 0 NOT NULL,
    si161_instit bigint DEFAULT 0
);


ALTER TABLE incamp112018 OWNER TO dbportal;

--
-- Name: incamp112018_si161_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE incamp112018_si161_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE incamp112018_si161_sequencial_seq OWNER TO dbportal;

--
-- Name: incamp122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE incamp122018 (
    si162_sequencial bigint DEFAULT 0 NOT NULL,
    si162_tiporegistro bigint DEFAULT 0 NOT NULL,
    si162_codprograma character varying(4) NOT NULL,
    si162_idacao character varying(4) NOT NULL,
    si162_codorgao character varying(2) NOT NULL,
    si1162_codunidadesub character varying(8) NOT NULL,
    si162_codfuncao character varying(2) NOT NULL,
    si162_codsubfuncao character varying(3) NOT NULL,
    si162_mes bigint DEFAULT 0 NOT NULL,
    si162_reg10 bigint DEFAULT 0 NOT NULL,
    si162_instit bigint DEFAULT 0
);


ALTER TABLE incamp122018 OWNER TO dbportal;

--
-- Name: incamp122018_si162_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE incamp122018_si162_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE incamp122018_si162_sequencial_seq OWNER TO dbportal;

--
-- Name: incorgao2018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE incorgao2018 (
    si163_sequencial bigint DEFAULT 0 NOT NULL,
    si163_codorgao character varying(2) NOT NULL,
    si163_cpfgestor character varying(11) NOT NULL,
    si163_tipoorgao character varying(2) NOT NULL,
    si163_mes bigint DEFAULT 0 NOT NULL,
    si163_instit integer DEFAULT 0
);


ALTER TABLE incorgao2018 OWNER TO dbportal;

--
-- Name: incpro2018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE incpro2018 (
    si159_sequencial bigint DEFAULT 0 NOT NULL,
    si159_codprograma character varying(4) NOT NULL,
    si159_nomeprograma character varying(200) NOT NULL,
    si159_objetivo character varying(500) NOT NULL,
    si159_totrecursos1ano double precision DEFAULT 0 NOT NULL,
    si159_totrecursos2ano double precision DEFAULT 0 NOT NULL,
    si159_totrecursos3ano double precision DEFAULT 0 NOT NULL,
    si159_totrecursos4ano double precision DEFAULT 0 NOT NULL,
    si159_nrolei character varying(6) NOT NULL,
    si159_dtlei date NOT NULL,
    si159_dtpublicacaolei date NOT NULL,
    si159_mes bigint DEFAULT 0 NOT NULL,
    si159_instit bigint DEFAULT 0
);


ALTER TABLE incpro2018 OWNER TO dbportal;

--
-- Name: incpro2018_si159_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE incpro2018_si159_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE incpro2018_si159_sequencial_seq OWNER TO dbportal;

--
-- Name: item102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE item102018 (
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


ALTER TABLE item102018 OWNER TO dbportal;

--
-- Name: item102018_si43_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE item102018_si43_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE item102018_si43_sequencial_seq OWNER TO dbportal;

--
-- Name: iuoc2018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE iuoc2018 (
    si164_sequencial bigint DEFAULT 0 NOT NULL,
    si164_codorgao character varying(2) NOT NULL,
    si164_codunidadesub character varying(8) NOT NULL,
    si164_idfundo character varying(2),
    si164_descunidadesub character varying(50) NOT NULL,
    si164_esubunidade bigint DEFAULT 0 NOT NULL,
    si164_mes bigint DEFAULT 0 NOT NULL,
    si164_instit bigint DEFAULT 0
);


ALTER TABLE iuoc2018 OWNER TO dbportal;

--
-- Name: iuoc2018_si164_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE iuoc2018_si164_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE iuoc2018_si164_sequencial_seq OWNER TO dbportal;

--
-- Name: julglic102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE julglic102018 (
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


ALTER TABLE julglic102018 OWNER TO dbportal;

--
-- Name: julglic102018_si60_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE julglic102018_si60_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE julglic102018_si60_sequencial_seq OWNER TO dbportal;

--
-- Name: julglic202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE julglic202018 (
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


ALTER TABLE julglic202018 OWNER TO dbportal;

--
-- Name: julglic202018_si61_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE julglic202018_si61_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE julglic202018_si61_sequencial_seq OWNER TO dbportal;

--
-- Name: julglic402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE julglic402018 (
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


ALTER TABLE julglic402018 OWNER TO dbportal;

--
-- Name: julglic402018_si62_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE julglic402018_si62_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE julglic402018_si62_sequencial_seq OWNER TO dbportal;

--
-- Name: lao102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE lao102018 (
    si34_sequencial bigint DEFAULT 0 NOT NULL,
    si34_tiporegistro bigint DEFAULT 0 NOT NULL,
    si34_codorgao character varying(2) NOT NULL,
    si34_nroleialteracao bigint NOT NULL,
    si34_dataleialteracao date NOT NULL,
    si34_mes bigint DEFAULT 0 NOT NULL,
    si34_instit bigint DEFAULT 0
);


ALTER TABLE lao102018 OWNER TO dbportal;

--
-- Name: lao102018_si34_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE lao102018_si34_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lao102018_si34_sequencial_seq OWNER TO dbportal;

--
-- Name: lao112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE lao112018 (
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


ALTER TABLE lao112018 OWNER TO dbportal;

--
-- Name: lao112018_si35_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE lao112018_si35_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lao112018_si35_sequencial_seq OWNER TO dbportal;

--
-- Name: lao202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE lao202018 (
    si36_sequencial bigint DEFAULT 0 NOT NULL,
    si36_tiporegistro bigint DEFAULT 0 NOT NULL,
    si36_codorgao character varying(2) NOT NULL,
    si36_nroleialterorcam character varying(6) NOT NULL,
    si36_dataleialterorcam date NOT NULL,
    si36_mes bigint DEFAULT 0 NOT NULL,
    si36_instit bigint DEFAULT 0
);


ALTER TABLE lao202018 OWNER TO dbportal;

--
-- Name: lao202018_si36_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE lao202018_si36_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lao202018_si36_sequencial_seq OWNER TO dbportal;

--
-- Name: lao212018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE lao212018 (
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


ALTER TABLE lao212018 OWNER TO dbportal;

--
-- Name: lao212018_si37_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE lao212018_si37_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lao212018_si37_sequencial_seq OWNER TO dbportal;

--
-- Name: lqd102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE lqd102018 (
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


ALTER TABLE lqd102018 OWNER TO dbportal;

--
-- Name: lqd102018_si118_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE lqd102018_si118_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lqd102018_si118_sequencial_seq OWNER TO dbportal;

--
-- Name: lqd112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE lqd112018 (
    si119_sequencial bigint DEFAULT 0 NOT NULL,
    si119_tiporegistro bigint DEFAULT 0 NOT NULL,
    si119_codreduzido bigint DEFAULT 0 NOT NULL,
    si119_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si119_valorfonte double precision DEFAULT 0 NOT NULL,
    si119_mes bigint DEFAULT 0 NOT NULL,
    si119_reg10 bigint DEFAULT 0 NOT NULL,
    si119_instit bigint DEFAULT 0
);


ALTER TABLE lqd112018 OWNER TO dbportal;

--
-- Name: lqd112018_si119_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE lqd112018_si119_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lqd112018_si119_sequencial_seq OWNER TO dbportal;

--
-- Name: lqd122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE lqd122018 (
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


ALTER TABLE lqd122018 OWNER TO dbportal;

--
-- Name: lqd122018_si120_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE lqd122018_si120_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE lqd122018_si120_sequencial_seq OWNER TO dbportal;

--
-- Name: metareal102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE metareal102018 (
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


ALTER TABLE metareal102018 OWNER TO dbportal;

--
-- Name: metareal102018_si171_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE metareal102018_si171_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE metareal102018_si171_sequencial_seq OWNER TO dbportal;

--
-- Name: iderp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE iderp102018 (
    si231_sequencial bigint DEFAULT 0 NOT NULL,
    si231_tiporegistro bigint DEFAULT 0 NOT NULL,
    si231_codreduzidoiderp bigint DEFAULT 0 NOT NULL,
    si231_codorgao character varying(2) DEFAULT 0 NOT NULL,
    si231_codunidadesub character varying(8) DEFAULT 0 NOT NULL,
    si231_nroempenho bigint DEFAULT 0 NOT NULL,
    si231_tiporestospagar bigint DEFAULT 0 NOT NULL,
    si231_disponibilidadecaixa bigint DEFAULT 0 NOT NULL,
    si231_vlinscricao double precision DEFAULT 0 NOT NULL,
    si231_instit bigint DEFAULT 0
);


ALTER TABLE iderp102018 OWNER TO dbportal;

--
-- Name: iderp102018_si231_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE iderp102018_si231_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE iderp102018_si231_sequencial_seq OWNER TO dbportal;

--
-- Name: iderp112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE iderp112018 (
    si232_sequencial bigint DEFAULT 0 NOT NULL,
    si232_tiporegistro bigint DEFAULT 0 NOT NULL,
    si232_codreduzidoiderp bigint DEFAULT 0 NOT NULL,
    si232_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si232_vlinscricaofonte double precision DEFAULT 0 NOT NULL,
    si232_mes bigint DEFAULT 0 NOT NULL,
    si232_reg10 bigint DEFAULT 0 NOT NULL,
    si232_instit bigint DEFAULT 0
);


ALTER TABLE iderp112018 OWNER TO dbportal;

--
-- Name: iderp112018_si232_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE iderp112018_si232_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE iderp112018_si232_sequencial_seq OWNER TO dbportal;

--
-- Name: iderp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE iderp202018 (
    si233_sequencial bigint DEFAULT 0 NOT NULL,
    si233_tiporegistro bigint DEFAULT 0 NOT NULL,
    si233_codorgao character varying(2) NOT NULL,
    si233_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si233_vlcaixabruta double precision DEFAULT 0 NOT NULL,
    si233_vlrspexerciciosanteriores double precision DEFAULT 0 NOT NULL,
    si233_vlrestituiveisrecolher double precision DEFAULT 0 NOT NULL,
    si233_vlrestituiveisativofinanceiro double precision DEFAULT 0 NOT NULL,
    si233_vlsaldodispcaixa double precision DEFAULT 0 NOT NULL,
    si233_mes bigint DEFAULT 0 NOT NULL,
    si233_instit bigint DEFAULT 0
);


ALTER TABLE iderp202018 OWNER TO dbportal;

--
-- Name: iderp202018_si233_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE iderp202018_si233_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE iderp202018_si233_sequencial_seq OWNER TO dbportal;

--
-- Name: conge102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conge102018 (
    si234_sequencial bigint DEFAULT 0 NOT NULL,
    si234_tiporegistro bigint DEFAULT 0 NOT NULL,
    si234_codconvenioconge bigint DEFAULT 0 NOT NULL,
    si234_codorgao character varying(2) NOT NULL,
    si234_codunidadesub character varying(8) NOT NULL,
    si234_nroconvenioconge character varying(30) NOT NULL,
    si234_dscinstrumento character varying(50) NOT NULL,
    si234_dataassinaturaconge date NOT NULL,
    si234_datapublicconge date NOT NULL,
    si234_nrocpfrespconge character varying(11) NOT NULL,
    si234_dsccargorespconge character varying(50) NOT NULL,
    si234_objetoconvenioconge character varying(500) NOT NULL,
    si234_datainiciovigenciaconge date NOT NULL,
    si234_datafinalvigenciaconge date NOT NULL,
    si234_formarepasse bigint NOT NULL,
    si234_tipodocumentoincentivador bigint,
    si234_nrodocumentoincentivador character varying(14),
    si234_quantparcelas bigint,
    si234_vltotalconvenioconge double precision DEFAULT 0 NOT NULL,
    si234_vlcontrapartidaconge double precision DEFAULT 0 NOT NULL,
    si234_tipodocumentobeneficiario bigint DEFAULT 0 NOT NULL,
    si234_nrodocumentobeneficiario character varying(14) DEFAULT 0 NOT NULL,
    si234_mes bigint DEFAULT 0 NOT NULL,
    si234_instit bigint DEFAULT 0
);


ALTER TABLE conge102018 OWNER TO dbportal;

--
-- Name: conge102018_si234_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conge102018_si234_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conge102018_si234_sequencial_seq OWNER TO dbportal;

--
-- Name: conge202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conge202018 (
    si235_sequencial bigint DEFAULT 0 NOT NULL,
    si235_tiporegistro bigint DEFAULT 0 NOT NULL,
    si235_codorgao character varying(2) NOT NULL,
    si235_codunidadesub character varying(8) NOT NULL,
    si235_nroconvenioconge character varying(30) NOT NULL,
    si235_dataassinaturaconvoriginalconge date NOT NULL,
    si235_nroseqtermoaditivoconge bigint DEFAULT 0 NOT NULL,
    si235_dscAlteracaoConge character varying(500) DEFAULT 0 NOT NULL,
    si235_dataassinaturatermoaditivoconge date NOT NULL,
    si235_datafinalvigenciaconge date NOT NULL,
    si235_valoratualizadoconvenioconge double precision NOT NULL,
    si235_valoratualizadocontrapartidaconge double precision NOT NULL,
    si235_mes bigint DEFAULT 0 NOT NULL,
    si235_instit bigint DEFAULT 0
);


ALTER TABLE conge202018 OWNER TO dbportal;

--
-- Name: conge202018_si235_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conge202018_si235_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conge202018_si235_sequencial_seq OWNER TO dbportal;

--
-- Name: conge302018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conge302018 (
    si236_sequencial bigint DEFAULT 0 NOT NULL,
    si236_tiporegistro bigint DEFAULT 0 NOT NULL,
    si236_codorgao character varying(2) NOT NULL,
    si236_codunidadesub character varying(8) NOT NULL,
    si236_nroconvenioconge character varying(30) NOT NULL,
    si236_dataassinaturaconvoriginalconge date NOT NULL,
    si236_datarepasseconge bigint DEFAULT 0 NOT NULL,
    si236_vlrepassadoconge double precision NOT NULL,
    si236_banco character varying(3) DEFAULT 0 NOT NULL,
    si236_agencia character varying(6) DEFAULT 0 NOT NULL,
    si236_digitoverificadoragencia character varying(2) DEFAULT 0 NOT NULL,
    si236_contabancaria character varying(12) DEFAULT 0 NOT NULL,
    si236_digitoverificadorcontabancaria character varying(2) DEFAULT 0 NOT NULL,
    si236_tipodocumentotitularconta bigint DEFAULT 0 NOT NULL,
    si236_nrodocumentotitularconta character varying(14) DEFAULT 0 NOT NULL,
    si236_prazoprestacontas date NOT NULL,
    si236_mes bigint DEFAULT 0 NOT NULL,
    si236_instit bigint DEFAULT 0
);


ALTER TABLE conge302018 OWNER TO dbportal;

--
-- Name: conge302018_si236_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conge302018_si236_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conge302018_si236_sequencial_seq OWNER TO dbportal;

--
-- Name: conge402018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conge402018 (
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
    si237_nrocpfrespprestconge character varying(11) NOT NULL,
    si237_dsccargorespprestconge character varying(50) NOT NULL,
    si237_mes bigint DEFAULT 0 NOT NULL,
    si237_instit bigint DEFAULT 0
);


ALTER TABLE conge402018 OWNER TO dbportal;

--
-- Name: conge402018_si237_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conge402018_si237_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conge402018_si237_sequencial_seq OWNER TO dbportal;

--
-- Name: conge502018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE conge502018 (
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


ALTER TABLE conge502018 OWNER TO dbportal;

--
-- Name: conge502018_si238_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE conge502018_si238_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE conge502018_si238_sequencial_seq OWNER TO dbportal;

--
-- Name: tce102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE tce102018 (
    si239_sequencial bigint DEFAULT 0 NOT NULL,
    si239_tiporegistro bigint DEFAULT 0 NOT NULL,
    si239_numprocessotce character varying(12) NOT NULL,
    si239_datainstauracaotce date NOT NULL,
    si239_codunidadesub character varying(8) NOT NULL,
    si239_nroconvenioconge character varying(30) NOT NULL,
    si239_dataassinaturaconvoriginalconge date NOT NULL,
    si239_dscinstrumelegaltce character varying(50) NOT NULL,
    si239_nrocpfautoridadeinstauratce character varying(11) NOT NULL,
    si239_dsccargoresptce character varying(50) NOT NULL,
    si239_vloriginaldano double precision DEFAULT 0 NOT NULL,
    si239_vlatualizadodano double precision DEFAULT 0 NOT NULL,
    si239_dataatualizacao date NOT NULL,
    si239_indice character varying(20) NOT NULL,
    si239_ocorrehipotese bigint DEFAULT 0 NOT NULL,
    si239_identiresponsavel bigint DEFAULT 0 NOT NULL,
    si239_mes bigint DEFAULT 0 NOT NULL,
    si239_instit bigint DEFAULT 0
);


ALTER TABLE tce102018 OWNER TO dbportal;

--
-- Name: tce102018_si239_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE tce102018_si239_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tce102018_si239_sequencial_seq OWNER TO dbportal;

--
-- Name: tce112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE tce112018 (
    si240_sequencial bigint DEFAULT 0 NOT NULL,
    si240_tiporegistro bigint DEFAULT 0 NOT NULL,
    si240_tipodocumentorespdano bigint DEFAULT 0 NOT NULL,
    si240_nrodocumentorespdano character varying(14) NOT NULL,
    si240_mes bigint DEFAULT 0 NOT NULL,
    si240_reg10 bigint DEFAULT 0 NOT NULL,
    si240_instit bigint DEFAULT 0
);


ALTER TABLE tce112018 OWNER TO dbportal;

--
-- Name: tce112018_si240_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE tce112018_si240_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tce112018_si240_sequencial_seq OWNER TO dbportal;

--
-- Name: ntf102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ntf102018 (
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
    si143_chaveacesso character varying(44),
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


ALTER TABLE ntf102018 OWNER TO dbportal;

--
-- Name: ntf102018_si143_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ntf102018_si143_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ntf102018_si143_sequencial_seq OWNER TO dbportal;

--
-- Name: ntf112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ntf112018 (
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


ALTER TABLE ntf112018 OWNER TO dbportal;

--
-- Name: ntf112018_si144_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ntf112018_si144_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ntf112018_si144_sequencial_seq OWNER TO dbportal;

--
-- Name: ntf202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ntf202018 (
    si145_sequencial bigint DEFAULT 0 NOT NULL,
    si145_tiporegistro bigint DEFAULT 0 NOT NULL,
    si145_nfnumero bigint DEFAULT 0 NOT NULL,
    si145_nfserie character varying(8) DEFAULT 0,
    si145_tipodocumento bigint DEFAULT 0 NOT NULL,
    si145_nrodocumento character varying(14) DEFAULT 0 NOT NULL,
    si145_chaveacesso character varying(44),
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


ALTER TABLE ntf202018 OWNER TO dbportal;

--
-- Name: ntf202018_si145_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ntf202018_si145_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ntf202018_si145_sequencial_seq OWNER TO dbportal;

--
-- Name: obelac102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE obelac102018 (
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
    si139_nroliquidacao bigint DEFAULT 0 NOT NULL,
    si139_dtliquidacao date NOT NULL,
    si139_esplancamento character varying(200) NOT NULL,
    si139_valorlancamento double precision DEFAULT 0 NOT NULL,
    si139_mes bigint DEFAULT 0 NOT NULL,
    si139_instit bigint DEFAULT 0
);


ALTER TABLE obelac102018 OWNER TO dbportal;

--
-- Name: obelac102018_si139_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE obelac102018_si139_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE obelac102018_si139_sequencial_seq OWNER TO dbportal;

--
-- Name: obelac112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE obelac112018 (
    si140_sequencial bigint DEFAULT 0 NOT NULL,
    si140_tiporegistro bigint DEFAULT 0 NOT NULL,
    si140_codreduzido bigint DEFAULT 0 NOT NULL,
    si140_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si140_valorfonte double precision DEFAULT 0 NOT NULL,
    si140_mes bigint DEFAULT 0 NOT NULL,
    si140_reg10 bigint DEFAULT 0 NOT NULL,
    si140_instit bigint DEFAULT 0
);


ALTER TABLE obelac112018 OWNER TO dbportal;

--
-- Name: obelac112018_si140_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE obelac112018_si140_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE obelac112018_si140_sequencial_seq OWNER TO dbportal;

--
-- Name: ops102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ops102018 (
    si132_sequencial bigint DEFAULT 0 NOT NULL,
    si132_tiporegistro bigint DEFAULT 0 NOT NULL,
    si132_codorgao character varying(2) NOT NULL,
    si132_codunidadesub character varying(8) NOT NULL,
    si132_nroop bigint DEFAULT 0 NOT NULL,
    si132_dtpagamento date NOT NULL,
    si132_vlop double precision DEFAULT 0 NOT NULL,
    si132_especificacaoop character varying(200) NOT NULL,
    si132_cpfresppgto character varying(11) NOT NULL,
    si132_mes bigint DEFAULT 0 NOT NULL,
    si132_instit bigint DEFAULT 0
);


ALTER TABLE ops102018 OWNER TO dbportal;

--
-- Name: ops102018_si132_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ops102018_si132_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ops102018_si132_sequencial_seq OWNER TO dbportal;

--
-- Name: ops112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ops112018 (
    si133_sequencial bigint DEFAULT 0 NOT NULL,
    si133_tiporegistro bigint DEFAULT 0 NOT NULL,
    si133_codreduzidoop bigint DEFAULT 0 NOT NULL,
    si133_codunidadesub character varying(8) NOT NULL,
    si133_nroop bigint DEFAULT 0 NOT NULL,
    si133_dtpagamento date NOT NULL,
    si133_tipopagamento bigint DEFAULT 0 NOT NULL,
    si133_nroempenho bigint DEFAULT 0 NOT NULL,
    si133_dtempenho date NOT NULL,
    si133_nroliquidacao bigint DEFAULT 0 NOT NULL,
    si133_dtliquidacao date NOT NULL,
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


ALTER TABLE ops112018 OWNER TO dbportal;

--
-- Name: ops112018_si133_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ops112018_si133_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ops112018_si133_sequencial_seq OWNER TO dbportal;

--
-- Name: ops122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ops122018 (
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


ALTER TABLE ops122018 OWNER TO dbportal;

--
-- Name: ops122018_si134_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ops122018_si134_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ops122018_si134_sequencial_seq OWNER TO dbportal;

--
-- Name: ops132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ops132018 (
    si135_sequencial bigint DEFAULT 0 NOT NULL,
    si135_tiporegistro bigint DEFAULT 0 NOT NULL,
    si135_codreduzidoop bigint DEFAULT 0 NOT NULL,
    si135_tiporetencao character varying(4) NOT NULL,
    si135_descricaoretencao character varying(50),
    si135_vlretencao double precision DEFAULT 0 NOT NULL,
    si135_mes bigint DEFAULT 0 NOT NULL,
    si135_reg10 bigint DEFAULT 0 NOT NULL,
    si135_instit bigint DEFAULT 0
);


ALTER TABLE ops132018 OWNER TO dbportal;

--
-- Name: ops132018_si135_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ops132018_si135_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ops132018_si135_sequencial_seq OWNER TO dbportal;

--
-- Name: ops142018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE ops142018 (
    si136_sequencial bigint DEFAULT 0 NOT NULL,
    si136_tiporegistro bigint DEFAULT 0 NOT NULL,
    si136_codreduzidoop bigint DEFAULT 0 NOT NULL,
    si136_tipovlantecipado character varying(2) NOT NULL,
    si136_descricaovlantecipado character varying(50),
    si136_vlantecipado double precision DEFAULT 0 NOT NULL,
    si136_mes bigint DEFAULT 0 NOT NULL,
    si136_reg10 bigint DEFAULT 0 NOT NULL,
    si136_instit bigint DEFAULT 0
);


ALTER TABLE ops142018 OWNER TO dbportal;

--
-- Name: ops142018_si136_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE ops142018_si136_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ops142018_si136_sequencial_seq OWNER TO dbportal;

--
-- Name: orgao102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE orgao102018 (
    si14_sequencial bigint DEFAULT 0 NOT NULL,
    si14_tiporegistro bigint DEFAULT 0 NOT NULL,
    si14_codorgao character varying(2) NOT NULL,
    si14_tipoorgao character varying(2) NOT NULL,
    si14_cnpjorgao character varying(14) NOT NULL,
    si14_tipodocumentofornsoftware bigint DEFAULT 0 NOT NULL,
    si14_nrodocumentofornsoftware character varying(14) NOT NULL,
    si14_versaosoftware character varying(50) NOT NULL,
    si14_assessoriacontabil bigint,
    si14_tipodocumentoassessoria bigint,
    si14_nrodocumentoassessoria bigint,
    si14_mes bigint DEFAULT 0 NOT NULL,
    si14_instit bigint DEFAULT 0
);


ALTER TABLE orgao102018 OWNER TO dbportal;

--
-- Name: orgao102018_si14_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE orgao102018_si14_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE orgao102018_si14_sequencial_seq OWNER TO dbportal;

--
-- Name: orgao112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE orgao112018 (
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


ALTER TABLE orgao112018 OWNER TO dbportal;

--
-- Name: orgao112018_si15_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE orgao112018_si15_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE orgao112018_si15_sequencial_seq OWNER TO dbportal;

--
-- Name: parec102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE parec102018 (
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


ALTER TABLE parec102018 OWNER TO dbportal;

--
-- Name: parec102018_si22_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE parec102018_si22_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE parec102018_si22_sequencial_seq OWNER TO dbportal;

--
-- Name: parec102018_si66_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE parec102018_si66_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE parec102018_si66_sequencial_seq OWNER TO dbportal;

--
-- Name: parec112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE parec112018 (
    si23_sequencial bigint DEFAULT 0 NOT NULL,
    si23_tiporegistro bigint DEFAULT 0 NOT NULL,
    si23_codreduzido bigint DEFAULT 0 NOT NULL,
    si23_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si23_vlfonte double precision DEFAULT 0 NOT NULL,
    si23_reg10 bigint DEFAULT 0 NOT NULL,
    si23_mes bigint DEFAULT 0 NOT NULL,
    si23_instit bigint DEFAULT 0
);


ALTER TABLE parec112018 OWNER TO dbportal;

--
-- Name: parec112018_si23_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE parec112018_si23_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE parec112018_si23_sequencial_seq OWNER TO dbportal;

--
-- Name: parelic102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE parelic102018 (
    si66_sequencial bigint DEFAULT 0 NOT NULL,
    si66_tiporegistro bigint DEFAULT 0 NOT NULL,
    si66_codorgao character varying(2) NOT NULL,
    si66_codunidadesub character varying(8) NOT NULL,
    si66_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
    si66_nroprocessolicitatorio character varying(12) NOT NULL,
    si66_dataparecer date NOT NULL,
    si66_tipoparecer bigint DEFAULT 0 NOT NULL,
    si66_nrocpf character varying(11) NOT NULL,
    si66_mes bigint DEFAULT 0 NOT NULL,
    si66_instit bigint DEFAULT 0
);


ALTER TABLE parelic102018 OWNER TO dbportal;

--
-- Name: parpps102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE parpps102018 (
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


ALTER TABLE parpps102018 OWNER TO dbportal;

--
-- Name: parpps102018_si156_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE parpps102018_si156_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE parpps102018_si156_sequencial_seq OWNER TO dbportal;

--
-- Name: parpps202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE parpps202018 (
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


ALTER TABLE parpps202018 OWNER TO dbportal;

--
-- Name: parpps202018_si155_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE parpps202018_si155_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE parpps202018_si155_sequencial_seq OWNER TO dbportal;

--
-- Name: pessoa102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE pessoa102018 (
    si12_sequencial bigint DEFAULT 0 NOT NULL,
    si12_tiporegistro bigint DEFAULT 0 NOT NULL,
    si12_tipodocumento bigint DEFAULT 0 NOT NULL,
    si12_nrodocumento character varying(14) NOT NULL,
    si12_nomerazaosocial character varying(120) NOT NULL,
    si12_tipocadastro bigint DEFAULT 0 NOT NULL,
    si12_justificativaalteracao character varying(100),
    si12_mes bigint DEFAULT 0 NOT NULL,
    si12_instit bigint DEFAULT 0
);


ALTER TABLE pessoa102018 OWNER TO dbportal;

--
-- Name: pessoa102018_si12_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE pessoa102018_si12_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE pessoa102018_si12_sequencial_seq OWNER TO dbportal;

--
-- Name: pessoaflpgo102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE pessoaflpgo102018 (
    si193_sequencial bigint DEFAULT 0 NOT NULL,
    si193_tiporegistro bigint DEFAULT 0 NOT NULL,
    si193_tipodocumento bigint DEFAULT 0 NOT NULL,
    si193_nrodocumento character varying(14) NOT NULL,
    si193_nome character varying(120) NOT NULL,
    si193_indsexo character varying(1),
    si193_datanascimento date,
    si193_tipocadastro bigint DEFAULT 0 NOT NULL,
    si193_justalteracao character varying(100),
    si193_mes bigint DEFAULT 0 NOT NULL,
    si193_inst bigint DEFAULT 0
);


ALTER TABLE pessoaflpgo102018 OWNER TO dbportal;

--
-- Name: pessoaflpgo102018_si193_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE pessoaflpgo102018_si193_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE pessoaflpgo102018_si193_sequencial_seq OWNER TO dbportal;

--
-- Name: rec102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rec102018 (
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


ALTER TABLE rec102018 OWNER TO dbportal;

--
-- Name: rec102018_si25_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rec102018_si25_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rec102018_si25_sequencial_seq OWNER TO dbportal;

--
-- Name: rec112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rec112018 (
    si26_sequencial bigint DEFAULT 0 NOT NULL,
    si26_tiporegistro bigint DEFAULT 0 NOT NULL,
    si26_codreceita bigint DEFAULT 0 NOT NULL,
    si26_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si26_cnpjorgaocontribuinte character varying(14),
    si26_vlarrecadadofonte double precision DEFAULT 0 NOT NULL,
    si26_reg10 bigint DEFAULT 0 NOT NULL,
    si26_mes bigint DEFAULT 0 NOT NULL,
    si26_instit bigint DEFAULT 0
);


ALTER TABLE rec112018 OWNER TO dbportal;

--
-- Name: rec112018_si26_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rec112018_si26_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rec112018_si26_sequencial_seq OWNER TO dbportal;

--
-- Name: regadesao102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE regadesao102018 (
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


ALTER TABLE regadesao102018 OWNER TO dbportal;

--
-- Name: regadesao102018_si67_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE regadesao102018_si67_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE regadesao102018_si67_sequencial_seq OWNER TO dbportal;

--
-- Name: regadesao112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE regadesao112018 (
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


ALTER TABLE regadesao112018 OWNER TO dbportal;

--
-- Name: regadesao112018_si68_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE regadesao112018_si68_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE regadesao112018_si68_sequencial_seq OWNER TO dbportal;

--
-- Name: regadesao122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE regadesao122018 (
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


ALTER TABLE regadesao122018 OWNER TO dbportal;

--
-- Name: regadesao122018_si69_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE regadesao122018_si69_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE regadesao122018_si69_sequencial_seq OWNER TO dbportal;

--
-- Name: regadesao132018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE regadesao132018 (
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


ALTER TABLE regadesao132018 OWNER TO dbportal;

--
-- Name: regadesao132018_si70_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE regadesao132018_si70_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE regadesao132018_si70_sequencial_seq OWNER TO dbportal;

--
-- Name: regadesao142018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE regadesao142018 (
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


ALTER TABLE regadesao142018 OWNER TO dbportal;

--
-- Name: regadesao142018_si71_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE regadesao142018_si71_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE regadesao142018_si71_sequencial_seq OWNER TO dbportal;

--
-- Name: regadesao152018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE regadesao152018 (
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


ALTER TABLE regadesao152018 OWNER TO dbportal;

--
-- Name: regadesao152018_si72_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE regadesao152018_si72_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE regadesao152018_si72_sequencial_seq OWNER TO dbportal;

--
-- Name: regadesao202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE regadesao202018 (
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


ALTER TABLE regadesao202018 OWNER TO dbportal;

--
-- Name: regadesao202018_si73_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE regadesao202018_si73_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE regadesao202018_si73_sequencial_seq OWNER TO dbportal;

--
-- Name: reglic102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE reglic102018 (
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


ALTER TABLE reglic102018 OWNER TO dbportal;

--
-- Name: reglic102018_si44_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE reglic102018_si44_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE reglic102018_si44_sequencial_seq OWNER TO dbportal;

--
-- Name: reglic202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE reglic202018 (
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


ALTER TABLE reglic202018 OWNER TO dbportal;

--
-- Name: reglic202018_si45_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE reglic202018_si45_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE reglic202018_si45_sequencial_seq OWNER TO dbportal;

--
-- Name: respinf102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE respinf102018 (
    si197_sequencial bigint DEFAULT 0 NOT NULL,
    si197_nomeresponsavel character varying(120) NOT NULL,
    si197_cartident character varying(10) NOT NULL,
    si197_orgemissorci character varying(10) NOT NULL,
    si197_cpf character varying(11) NOT NULL,
    si197_dtinicio date NOT NULL,
    si197_dtfinal date NOT NULL,
    si197_mes bigint DEFAULT 0 NOT NULL,
    si197_inst bigint DEFAULT 0
);


ALTER TABLE respinf102018 OWNER TO dbportal;

--
-- Name: respinf102018_si197_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE respinf102018_si197_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE respinf102018_si197_sequencial_seq OWNER TO dbportal;

--
-- Name: resplic102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE resplic102018 (
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


ALTER TABLE resplic102018 OWNER TO dbportal;

--
-- Name: resplic102018_si55_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE resplic102018_si55_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE resplic102018_si55_sequencial_seq OWNER TO dbportal;

--
-- Name: resplic202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE resplic202018 (
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


ALTER TABLE resplic202018 OWNER TO dbportal;

--
-- Name: resplic202018_si56_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE resplic202018_si56_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE resplic202018_si56_sequencial_seq OWNER TO dbportal;

--
-- Name: rsp102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rsp102018 (
    si112_sequencial bigint DEFAULT 0 NOT NULL,
    si112_tiporegistro bigint DEFAULT 0 NOT NULL,
    si112_codreduzidorsp bigint DEFAULT 0 NOT NULL,
    si112_codorgao character varying(2) NOT NULL,
    si112_codunidadesub character varying(8) NOT NULL,
    si112_codunidadesuborig character varying(8),
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


ALTER TABLE rsp102018 OWNER TO dbportal;

--
-- Name: rsp102018_si112_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rsp102018_si112_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rsp102018_si112_sequencial_seq OWNER TO dbportal;

--
-- Name: rsp112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rsp112018 (
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


ALTER TABLE rsp112018 OWNER TO dbportal;

--
-- Name: rsp112018_si113_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rsp112018_si113_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rsp112018_si113_sequencial_seq OWNER TO dbportal;

--
-- Name: rsp122018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rsp122018 (
    si114_sequencial bigint DEFAULT 0 NOT NULL,
    si114_tiporegistro bigint DEFAULT 0 NOT NULL,
    si114_codreduzidorsp bigint DEFAULT 0 NOT NULL,
    si114_tipodocumento bigint DEFAULT 0 NOT NULL,
    si114_nrodocumento character varying(14) NOT NULL,
    si114_mes bigint DEFAULT 0 NOT NULL,
    si114_reg10 bigint DEFAULT 0 NOT NULL,
    si114_instit bigint DEFAULT 0
);


ALTER TABLE rsp122018 OWNER TO dbportal;

--
-- Name: rsp122018_si114_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rsp122018_si114_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rsp122018_si114_sequencial_seq OWNER TO dbportal;

--
-- Name: rsp202018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rsp202018 (
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
    si115_justificativa character varying(500),
    si115_atocancelamento character varying(20),
    si115_dataatocancelamento date,
    si115_mes bigint DEFAULT 0 NOT NULL,
    si115_instit bigint DEFAULT 0
);


ALTER TABLE rsp202018 OWNER TO dbportal;

--
-- Name: rsp202018_si115_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rsp202018_si115_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rsp202018_si115_sequencial_seq OWNER TO dbportal;

--
-- Name: rsp212018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rsp212018 (
    si116_sequencial bigint DEFAULT 0 NOT NULL,
    si116_tiporegistro bigint DEFAULT 0 NOT NULL,
    si116_codreduzidomov bigint DEFAULT 0 NOT NULL,
    si116_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si116_vlmovimentacaofonte double precision DEFAULT 0 NOT NULL,
    si116_mes bigint DEFAULT 0 NOT NULL,
    si116_reg20 bigint DEFAULT 0 NOT NULL,
    si116_instit bigint DEFAULT 0
);


ALTER TABLE rsp212018 OWNER TO dbportal;

--
-- Name: rsp212018_si116_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rsp212018_si116_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rsp212018_si116_sequencial_seq OWNER TO dbportal;

--
-- Name: rsp222018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE rsp222018 (
    si117_sequencial bigint DEFAULT 0 NOT NULL,
    si117_tiporegistro bigint DEFAULT 0 NOT NULL,
    si117_codreduzidomov bigint DEFAULT 0 NOT NULL,
    si117_tipodocumento bigint DEFAULT 0 NOT NULL,
    si117_nrodocumento character varying(14) NOT NULL,
    si117_mes bigint DEFAULT 0 NOT NULL,
    si117_reg20 bigint DEFAULT 0 NOT NULL,
    si117_instit bigint DEFAULT 0
);


ALTER TABLE rsp222018 OWNER TO dbportal;

--
-- Name: rsp222018_si117_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE rsp222018_si117_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE rsp222018_si117_sequencial_seq OWNER TO dbportal;

--
-- Name: supdef102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE supdef102018 (
    si167_sequencial bigint DEFAULT 0 NOT NULL,
    si167_tiporegistro bigint DEFAULT 0 NOT NULL,
    si167_superavitdeficit character varying(1) DEFAULT 0 NOT NULL,
    si167_vlapurado double precision DEFAULT 0 NOT NULL,
    si167_mes bigint DEFAULT 0 NOT NULL,
    si167_instit bigint DEFAULT 0
);


ALTER TABLE supdef102018 OWNER TO dbportal;

--
-- Name: supdef102018_si167_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE supdef102018_si167_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE supdef102018_si167_sequencial_seq OWNER TO dbportal;

--
-- Name: supdef112018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE supdef112018 (
    si168_sequencial bigint DEFAULT 0 NOT NULL,
    si168_tiporegistro bigint DEFAULT 0 NOT NULL,
    si168_codfontrecursos bigint DEFAULT 0 NOT NULL,
    si168_superavitdeficit character varying(1) DEFAULT 0 NOT NULL,
    si168_vlapuradofonte double precision DEFAULT 0 NOT NULL,
    si168_mes bigint DEFAULT 0 NOT NULL,
    si168_reg10 bigint DEFAULT 0 NOT NULL,
    si168_instit bigint DEFAULT 0
);


ALTER TABLE supdef112018 OWNER TO dbportal;

--
-- Name: supdef112018_si168_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE supdef112018_si168_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE supdef112018_si168_sequencial_seq OWNER TO dbportal;

--
-- Name: terem102018; Type: TABLE; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE TABLE terem102018 (
    si194_sequencial bigint DEFAULT 0 NOT NULL,
    si194_tiporegistro bigint DEFAULT 0 NOT NULL,
    si194_cnpj character varying(14),
    si194_vlrparateto double precision DEFAULT 0 NOT NULL,
    si194_tipocadastro bigint DEFAULT 0 NOT NULL,
    si194_dtinicial date NOT NULL,
    si194_dtfinal date NOT NULL,
    si194_justalteracao character varying(100),
    si194_mes bigint DEFAULT 0 NOT NULL,
    si194_inst bigint DEFAULT 0
);


ALTER TABLE terem102018 OWNER TO dbportal;

--
-- Name: terem102018_si194_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
--

CREATE SEQUENCE terem102018_si194_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE terem102018_si194_sequencial_seq OWNER TO dbportal;

--
-- Name: aberlic102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aberlic102018
    ADD CONSTRAINT aberlic102018_sequ_pk PRIMARY KEY (si46_sequencial);


--
-- Name: aberlic112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aberlic112018
    ADD CONSTRAINT aberlic112018_sequ_pk PRIMARY KEY (si47_sequencial);


--
-- Name: aberlic122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aberlic122018
    ADD CONSTRAINT aberlic122018_sequ_pk PRIMARY KEY (si48_sequencial);


--
-- Name: aberlic132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aberlic132018
    ADD CONSTRAINT aberlic132018_sequ_pk PRIMARY KEY (si49_sequencial);


--
-- Name: aberlic142018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aberlic142018
    ADD CONSTRAINT aberlic142018_sequ_pk PRIMARY KEY (si50_sequencial);


--
-- Name: aberlic152018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aberlic152018
    ADD CONSTRAINT aberlic152018_sequ_pk PRIMARY KEY (si51_sequencial);


--
-- Name: aberlic162018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aberlic162018
    ADD CONSTRAINT aberlic162018_sequ_pk PRIMARY KEY (si52_sequencial);


--
-- Name: aex112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aex102018
    ADD CONSTRAINT aex112018_sequ_pk PRIMARY KEY (si130_sequencial);


--
-- Name: alq102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY alq102018
    ADD CONSTRAINT alq102018_sequ_pk PRIMARY KEY (si121_sequencial);


--
-- Name: alq112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY alq112018
    ADD CONSTRAINT alq112018_sequ_pk PRIMARY KEY (si122_sequencial);


--
-- Name: alq122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY alq122018
    ADD CONSTRAINT alq122018_sequ_pk PRIMARY KEY (si123_sequencial);


--
-- Name: anl102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY anl102018
    ADD CONSTRAINT anl102018_sequ_pk PRIMARY KEY (si110_sequencial);


--
-- Name: anl112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY anl112018
    ADD CONSTRAINT anl112018_sequ_pk PRIMARY KEY (si111_sequencial);


--
-- Name: aob102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aob102018
    ADD CONSTRAINT aob102018_sequ_pk PRIMARY KEY (si141_sequencial);


--
-- Name: aob112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aob112018
    ADD CONSTRAINT aob112018_sequ_pk PRIMARY KEY (si142_sequencial);


--
-- Name: aoc102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aoc102018
    ADD CONSTRAINT aoc102018_sequ_pk PRIMARY KEY (si38_sequencial);


--
-- Name: aoc112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aoc112018
    ADD CONSTRAINT aoc112018_sequ_pk PRIMARY KEY (si39_sequencial);


--
-- Name: aoc122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aoc122018
    ADD CONSTRAINT aoc122018_sequ_pk PRIMARY KEY (si40_sequencial);


--
-- Name: aoc132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aoc132018
    ADD CONSTRAINT aoc132018_sequ_pk PRIMARY KEY (si41_sequencial);


--
-- Name: aoc142018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aoc142018
    ADD CONSTRAINT aoc142018_sequ_pk PRIMARY KEY (si42_sequencial);


--
-- Name: aop102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aop102018
    ADD CONSTRAINT aop102018_sequ_pk PRIMARY KEY (si137_sequencial);


--
-- Name: aop112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY aop112018
    ADD CONSTRAINT aop112018_sequ_pk PRIMARY KEY (si138_sequencial);


--
-- Name: arc102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY arc102018
    ADD CONSTRAINT arc102018_sequ_pk PRIMARY KEY (si28_sequencial);


--
-- Name: arc112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY arc112018
    ADD CONSTRAINT arc112018_sequ_pk PRIMARY KEY (si29_sequencial);


--
-- Name: arc122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY arc122018
    ADD CONSTRAINT arc122018_sequ_pk PRIMARY KEY (si30_sequencial);


--
-- Name: arc202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY arc202018
    ADD CONSTRAINT arc202018_sequ_pk PRIMARY KEY (si31_sequencial);


--
-- Name: arc212018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY arc212018
    ADD CONSTRAINT arc212018_sequ_pk PRIMARY KEY (si32_sequencial);


--
-- Name: balancete102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete102018
    ADD CONSTRAINT balancete102018_sequ_pk PRIMARY KEY (si177_sequencial);


--
-- Name: balancete112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete112018
    ADD CONSTRAINT balancete112018_sequ_pk PRIMARY KEY (si178_sequencial);


--
-- Name: balancete122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete122018
    ADD CONSTRAINT balancete122018_sequ_pk PRIMARY KEY (si179_sequencial);


--
-- Name: balancete132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete132018
    ADD CONSTRAINT balancete132018_sequ_pk PRIMARY KEY (si180_sequencial);


--
-- Name: balancete142018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete142018
    ADD CONSTRAINT balancete142018_sequ_pk PRIMARY KEY (si181_sequencial);


--
-- Name: balancete152018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete152018
    ADD CONSTRAINT balancete152018_sequ_pk PRIMARY KEY (si182_sequencial);


--
-- Name: balancete162018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete162018
    ADD CONSTRAINT balancete162018_sequ_pk PRIMARY KEY (si183_sequencial);


--
-- Name: balancete172018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete172018
    ADD CONSTRAINT balancete172018_sequ_pk PRIMARY KEY (si184_sequencial);


--
-- Name: balancete182018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete182018
    ADD CONSTRAINT balancete182018_sequ_pk PRIMARY KEY (si185_sequencial);


--
-- Name: balancete192018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete192018
    ADD CONSTRAINT balancete192018_sequ_pk PRIMARY KEY (si186_sequencial);


--
-- Name: balancete202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete202018
    ADD CONSTRAINT balancete202018_sequ_pk PRIMARY KEY (si187_sequencial);


--
-- Name: balancete212018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete212018
    ADD CONSTRAINT balancete212018_sequ_pk PRIMARY KEY (si188_sequencial);


--
-- Name: balancete222018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete222018
    ADD CONSTRAINT balancete222018_sequ_pk PRIMARY KEY (si189_sequencial);


--
-- Name: balancete232018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete232018
    ADD CONSTRAINT balancete232018_sequ_pk PRIMARY KEY (si190_sequencial);


--
-- Name: balancete242018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY balancete242018
    ADD CONSTRAINT balancete242018_sequ_pk PRIMARY KEY (si191_sequencial);


--
-- Name: bfdcasp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bfdcasp102018
    ADD CONSTRAINT bfdcasp102018_sequ_pk PRIMARY KEY (si206_sequencial);


--
-- Name: bfdcasp202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bfdcasp202018
    ADD CONSTRAINT bfdcasp202018_sequ_pk PRIMARY KEY (si207_sequencial);


--
-- Name: bodcasp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bodcasp102018
    ADD CONSTRAINT bodcasp102018_sequ_pk PRIMARY KEY (si201_sequencial);


--
-- Name: bodcasp202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bodcasp202018
    ADD CONSTRAINT bodcasp202018_sequ_pk PRIMARY KEY (si202_sequencial);


--
-- Name: bodcasp302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bodcasp302018
    ADD CONSTRAINT bodcasp302018_sequ_pk PRIMARY KEY (si203_sequencial);


--
-- Name: bodcasp402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bodcasp402018
    ADD CONSTRAINT bodcasp402018_sequ_pk PRIMARY KEY (si204_sequencial);


--
-- Name: bodcasp502018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bodcasp502018
    ADD CONSTRAINT bodcasp502018_sequ_pk PRIMARY KEY (si205_sequencial);


--
-- Name: bpdcasp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp102018
    ADD CONSTRAINT bpdcasp102018_sequ_pk PRIMARY KEY (si208_sequencial);


--
-- Name: bpdcasp202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp202018
    ADD CONSTRAINT bpdcasp202018_sequ_pk PRIMARY KEY (si209_sequencial);


--
-- Name: bpdcasp302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp302018
    ADD CONSTRAINT bpdcasp302018_sequ_pk PRIMARY KEY (si210_sequencial);


--
-- Name: bpdcasp402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp402018
    ADD CONSTRAINT bpdcasp402018_sequ_pk PRIMARY KEY (si211_sequencial);


--
-- Name: bpdcasp502018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp502018
    ADD CONSTRAINT bpdcasp502018_sequ_pk PRIMARY KEY (si212_sequencial);


--
-- Name: bpdcasp602018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp602018
    ADD CONSTRAINT bpdcasp602018_sequ_pk PRIMARY KEY (si213_sequencial);


--
-- Name: bpdcasp702018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp702018
    ADD CONSTRAINT bpdcasp702018_sequ_pk PRIMARY KEY (si214_sequencial);


--
-- Name: bpdcasp712018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY bpdcasp712018
    ADD CONSTRAINT bpdcasp712018_sequ_pk PRIMARY KEY (si215_sequencial);


--
-- Name: caixa102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY caixa102018
    ADD CONSTRAINT caixa102018_sequ_pk PRIMARY KEY (si103_sequencial);


--
-- Name: caixa112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY caixa112018
    ADD CONSTRAINT caixa112018_sequ_pk PRIMARY KEY (si166_sequencial);


--
-- Name: caixa122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY caixa122018
    ADD CONSTRAINT caixa122018_sequ_pk PRIMARY KEY (si104_sequencial);


--
-- Name: caixa132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY caixa132018
    ADD CONSTRAINT caixa132018_sequ_pk PRIMARY KEY (si105_sequencial);


--
-- Name: consid102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY consid102018
    ADD CONSTRAINT consid102018_sequ_pk PRIMARY KEY (si158_sequencial);


--
-- Name: consor102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY consor102018
    ADD CONSTRAINT consor102018_sequ_pk PRIMARY KEY (si16_sequencial);


--
-- Name: consor202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY consor202018
    ADD CONSTRAINT consor202018_sequ_pk PRIMARY KEY (si17_sequencial);


--
-- Name: consor302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY consor302018
    ADD CONSTRAINT consor302018_sequ_pk PRIMARY KEY (si18_sequencial);


--
-- Name: consor402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY consor402018
    ADD CONSTRAINT consor402018_sequ_pk PRIMARY KEY (si19_sequencial);


--
-- Name: consor502018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY consor502018
    ADD CONSTRAINT consor502018_sequ_pk PRIMARY KEY (si20_sequencial);


--
-- Name: contratos102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos102018
    ADD CONSTRAINT contratos102018_sequ_pk PRIMARY KEY (si83_sequencial);


--
-- Name: contratos112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos112018
    ADD CONSTRAINT contratos112018_sequ_pk PRIMARY KEY (si84_sequencial);


--
-- Name: contratos122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos122018
    ADD CONSTRAINT contratos122018_sequ_pk PRIMARY KEY (si85_sequencial);


--
-- Name: contratos132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos132018
    ADD CONSTRAINT contratos132018_sequ_pk PRIMARY KEY (si86_sequencial);


--
-- Name: contratos202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos202018
    ADD CONSTRAINT contratos202018_sequ_pk PRIMARY KEY (si87_sequencial);


--
-- Name: contratos212018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos212018
    ADD CONSTRAINT contratos212018_sequ_pk PRIMARY KEY (si88_sequencial);


--
-- Name: contratos302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos302018
    ADD CONSTRAINT contratos302018_sequ_pk PRIMARY KEY (si89_sequencial);


--
-- Name: contratos402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY contratos402018
    ADD CONSTRAINT contratos402018_sequ_pk PRIMARY KEY (si91_sequencial);


--
-- Name: conv102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY conv102018
    ADD CONSTRAINT conv102018_sequ_pk PRIMARY KEY (si92_sequencial);


--
-- Name: conv112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY conv112018
    ADD CONSTRAINT conv112018_sequ_pk PRIMARY KEY (si93_sequencial);


--
-- Name: conv202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY conv202018
    ADD CONSTRAINT conv202018_sequ_pk PRIMARY KEY (si94_sequencial);


--
-- Name: cronem102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY cronem102018
    ADD CONSTRAINT cronem102018_sequ_pk PRIMARY KEY (si170_sequencial);


--
-- Name: ctb102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb102018
    ADD CONSTRAINT ctb102018_sequ_pk PRIMARY KEY (si95_sequencial);


--
-- Name: ctb202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb202018
    ADD CONSTRAINT ctb202018_sequ_pk PRIMARY KEY (si96_sequencial);


--
-- Name: ctb212018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb212018
    ADD CONSTRAINT ctb212018_sequ_pk PRIMARY KEY (si97_sequencial);


--
-- Name: ctb222018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb222018
    ADD CONSTRAINT ctb222018_sequ_pk PRIMARY KEY (si98_sequencial);


--
-- Name: ctb302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb302018
    ADD CONSTRAINT ctb302018_sequ_pk PRIMARY KEY (si99_sequencial);


--
-- Name: ctb312018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb312018
    ADD CONSTRAINT ctb312018_sequ_pk PRIMARY KEY (si100_sequencial);


--
-- Name: ctb402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb402018
    ADD CONSTRAINT ctb402018_sequ_pk PRIMARY KEY (si101_sequencial);


--
-- Name: ctb502018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ctb502018
    ADD CONSTRAINT ctb502018_sequ_pk PRIMARY KEY (si102_sequencial);


--
-- Name: cvc102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY cvc102018
    ADD CONSTRAINT cvc102018_sequ_pk PRIMARY KEY (si146_sequencial);


--
-- Name: cvc202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY cvc202018
    ADD CONSTRAINT cvc202018_sequ_pk PRIMARY KEY (si147_sequencial);


--
-- Name: cvc302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY cvc302018
    ADD CONSTRAINT cvc302018_sequ_pk PRIMARY KEY (si148_sequencial);


--
-- Name: cvc402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY cvc402018
    ADD CONSTRAINT cvc402018_sequ_pk PRIMARY KEY (si149_sequencial);


--
-- Name: dclrf102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dclrf102018
    ADD CONSTRAINT dclrf102018_sequ_pk PRIMARY KEY (si157_sequencial);


--
-- Name: dclrf202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dclrf202018
    ADD CONSTRAINT dclrf202018_sequ_pk PRIMARY KEY (si169_sequencial);


--
-- Name: dclrf302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dclrf302018
    ADD CONSTRAINT dclrf302018_sequ_pk PRIMARY KEY (si178_sequencial);


--
-- Name: ddc102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ddc102018
    ADD CONSTRAINT ddc102018_sequ_pk PRIMARY KEY (si150_sequencial);


--
-- Name: ddc112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ddc112018
    ADD CONSTRAINT ddc112018_sequ_pk PRIMARY KEY (si151_sequencial);


--
-- Name: ddc122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ddc122018
    ADD CONSTRAINT ddc122018_sequ_pk PRIMARY KEY (si152_sequencial);


--
-- Name: ddc202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ddc202018
    ADD CONSTRAINT ddc202018_sequ_pk PRIMARY KEY (si153_sequencial);


--
-- Name: ddc302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ddc302018
    ADD CONSTRAINT ddc302018_sequ_pk PRIMARY KEY (si154_sequencial);


--
-- Name: ddc402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ddc402018
    ADD CONSTRAINT ddc402018_sequ_pk PRIMARY KEY (si178_sequencial);


--
-- Name: dfcdcasp1002018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp1002018
    ADD CONSTRAINT dfcdcasp1002018_sequ_pk PRIMARY KEY (si228_sequencial);


--
-- Name: dfcdcasp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp102018
    ADD CONSTRAINT dfcdcasp102018_sequ_pk PRIMARY KEY (si219_sequencial);


--
-- Name: dfcdcasp1102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp1102018
    ADD CONSTRAINT dfcdcasp1102018_sequ_pk PRIMARY KEY (si229_sequencial);


--
-- Name: dfcdcasp202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp202018
    ADD CONSTRAINT dfcdcasp202018_sequ_pk PRIMARY KEY (si220_sequencial);


--
-- Name: dfcdcasp302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp302018
    ADD CONSTRAINT dfcdcasp302018_sequ_pk PRIMARY KEY (si221_sequencial);


--
-- Name: dfcdcasp402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp402018
    ADD CONSTRAINT dfcdcasp402018_sequ_pk PRIMARY KEY (si222_sequencial);


--
-- Name: dfcdcasp502018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp502018
    ADD CONSTRAINT dfcdcasp502018_sequ_pk PRIMARY KEY (si223_sequencial);


--
-- Name: dfcdcasp602018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp602018
    ADD CONSTRAINT dfcdcasp602018_sequ_pk PRIMARY KEY (si224_sequencial);


--
-- Name: dfcdcasp702018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp702018
    ADD CONSTRAINT dfcdcasp702018_sequ_pk PRIMARY KEY (si225_sequencial);


--
-- Name: dfcdcasp802018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp802018
    ADD CONSTRAINT dfcdcasp802018_sequ_pk PRIMARY KEY (si226_sequencial);


--
-- Name: dfcdcasp902018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dfcdcasp902018
    ADD CONSTRAINT dfcdcasp902018_sequ_pk PRIMARY KEY (si227_sequencial);


--
-- Name: dispensa102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa102018
    ADD CONSTRAINT dispensa102018_sequ_pk PRIMARY KEY (si74_sequencial);


--
-- Name: dispensa112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa112018
    ADD CONSTRAINT dispensa112018_sequ_pk PRIMARY KEY (si75_sequencial);


--
-- Name: dispensa122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa122018
    ADD CONSTRAINT dispensa122018_sequ_pk PRIMARY KEY (si76_sequencial);


--
-- Name: dispensa132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa132018
    ADD CONSTRAINT dispensa132018_sequ_pk PRIMARY KEY (si77_sequencial);


--
-- Name: dispensa142018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa142018
    ADD CONSTRAINT dispensa142018_sequ_pk PRIMARY KEY (si78_sequencial);


--
-- Name: dispensa152018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa152018
    ADD CONSTRAINT dispensa152018_sequ_pk PRIMARY KEY (si79_sequencial);


--
-- Name: dispensa162018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa162018
    ADD CONSTRAINT dispensa162018_sequ_pk PRIMARY KEY (si80_sequencial);


--
-- Name: dispensa172018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa172018
    ADD CONSTRAINT dispensa172018_sequ_pk PRIMARY KEY (si81_sequencial);


--
-- Name: dispensa182018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dispensa182018
    ADD CONSTRAINT dispensa182018_sequ_pk PRIMARY KEY (si82_sequencial);


--
-- Name: dvpdcasp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dvpdcasp102018
    ADD CONSTRAINT dvpdcasp102018_sequ_pk PRIMARY KEY (si216_sequencial);


--
-- Name: dvpdcasp202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dvpdcasp202018
    ADD CONSTRAINT dvpdcasp202018_sequ_pk PRIMARY KEY (si217_sequencial);


--
-- Name: dvpdcasp302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY dvpdcasp302018
    ADD CONSTRAINT dvpdcasp302018_sequ_pk PRIMARY KEY (si218_sequencial);


--
-- Name: emp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY emp102018
    ADD CONSTRAINT emp102018_sequ_pk PRIMARY KEY (si106_sequencial);


--
-- Name: emp112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY emp112018
    ADD CONSTRAINT emp112018_sequ_pk PRIMARY KEY (si107_sequencial);


--
-- Name: emp122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY emp122018
    ADD CONSTRAINT emp122018_sequ_pk PRIMARY KEY (si108_sequencial);


--
-- Name: emp202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY emp202018
    ADD CONSTRAINT emp202018_sequ_pk PRIMARY KEY (si109_sequencial);


--
-- Name: ext102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ext102018
    ADD CONSTRAINT ext102018_sequ_pk PRIMARY KEY (si124_sequencial);


--
-- Name: ext202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ext202018
    ADD CONSTRAINT ext202018_sequ_pk PRIMARY KEY (si165_sequencial);


--
-- Name: ext302018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ext302018
    ADD CONSTRAINT ext302018_sequ_pk PRIMARY KEY (si126_sequencial);


--
-- Name: ext312018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ext312018
    ADD CONSTRAINT ext312018_sequ_pk PRIMARY KEY (si127_sequencial);


--
-- Name: ext322018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ext322018
    ADD CONSTRAINT ext322018_sequ_pk PRIMARY KEY (si128_sequencial);


--
-- Name: flpgo102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY flpgo102018
    ADD CONSTRAINT flpgo102018_sequ_pk PRIMARY KEY (si195_sequencial);


--
-- Name: flpgo112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY flpgo112018
    ADD CONSTRAINT flpgo112018_sequ_pk PRIMARY KEY (si196_sequencial);


--
-- Name: flpgo122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY flpgo122018
    ADD CONSTRAINT flpgo122018_sequ_pk PRIMARY KEY (si197_sequencial);


--
-- Name: hablic102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY hablic102018
    ADD CONSTRAINT hablic102018_sequ_pk PRIMARY KEY (si57_sequencial);


--
-- Name: hablic112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY hablic112018
    ADD CONSTRAINT hablic112018_sequ_pk PRIMARY KEY (si58_sequencial);


--
-- Name: hablic202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY hablic202018
    ADD CONSTRAINT hablic202018_sequ_pk PRIMARY KEY (si59_sequencial);


--
-- Name: homolic102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY homolic102018
    ADD CONSTRAINT homolic102018_sequ_pk PRIMARY KEY (si63_sequencial);


--
-- Name: homolic202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY homolic202018
    ADD CONSTRAINT homolic202018_sequ_pk PRIMARY KEY (si64_sequencial);


--
-- Name: homolic402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY homolic402018
    ADD CONSTRAINT homolic402018_sequ_pk PRIMARY KEY (si65_sequencial);


--
-- Name: ide2018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ide2018
    ADD CONSTRAINT ide2018_sequ_pk PRIMARY KEY (si11_sequencial);


--
-- Name: idedcasp2018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY idedcasp2018
    ADD CONSTRAINT idedcasp2018_sequ_pk PRIMARY KEY (si200_sequencial);


--
-- Name: incamp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY incamp102018
    ADD CONSTRAINT incamp102018_sequ_pk PRIMARY KEY (si160_sequencial);


--
-- Name: incamp112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY incamp112018
    ADD CONSTRAINT incamp112018_sequ_pk PRIMARY KEY (si161_sequencial);


--
-- Name: incamp122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY incamp122018
    ADD CONSTRAINT incamp122018_sequ_pk PRIMARY KEY (si162_sequencial);


--
-- Name: incorgao2018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY incorgao2018
    ADD CONSTRAINT incorgao2018_sequ_pk PRIMARY KEY (si163_sequencial);


--
-- Name: incpro2018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY incpro2018
    ADD CONSTRAINT incpro2018_sequ_pk PRIMARY KEY (si159_sequencial);


--
-- Name: item102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY item102018
    ADD CONSTRAINT item102018_sequ_pk PRIMARY KEY (si43_sequencial);


--
-- Name: iuoc2018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY iuoc2018
    ADD CONSTRAINT iuoc2018_sequ_pk PRIMARY KEY (si164_sequencial);


--
-- Name: julglic102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY julglic102018
    ADD CONSTRAINT julglic102018_sequ_pk PRIMARY KEY (si60_sequencial);


--
-- Name: julglic202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY julglic202018
    ADD CONSTRAINT julglic202018_sequ_pk PRIMARY KEY (si61_sequencial);


--
-- Name: julglic402018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY julglic402018
    ADD CONSTRAINT julglic402018_sequ_pk PRIMARY KEY (si62_sequencial);


--
-- Name: lao102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY lao102018
    ADD CONSTRAINT lao102018_sequ_pk PRIMARY KEY (si34_sequencial);


--
-- Name: lao112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY lao112018
    ADD CONSTRAINT lao112018_sequ_pk PRIMARY KEY (si35_sequencial);


--
-- Name: lao202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY lao202018
    ADD CONSTRAINT lao202018_sequ_pk PRIMARY KEY (si36_sequencial);


--
-- Name: lao212018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY lao212018
    ADD CONSTRAINT lao212018_sequ_pk PRIMARY KEY (si37_sequencial);


--
-- Name: lqd102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY lqd102018
    ADD CONSTRAINT lqd102018_sequ_pk PRIMARY KEY (si118_sequencial);


--
-- Name: lqd112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY lqd112018
    ADD CONSTRAINT lqd112018_sequ_pk PRIMARY KEY (si119_sequencial);


--
-- Name: lqd122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY lqd122018
    ADD CONSTRAINT lqd122018_sequ_pk PRIMARY KEY (si120_sequencial);


--
-- Name: metareal102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY metareal102018
    ADD CONSTRAINT metareal102018_sequ_pk PRIMARY KEY (si171_sequencial);


--
-- Name: ntf102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ntf102018
    ADD CONSTRAINT ntf102018_sequ_pk PRIMARY KEY (si143_sequencial);


--
-- Name: ntf112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ntf112018
    ADD CONSTRAINT ntf112018_sequ_pk PRIMARY KEY (si144_sequencial);


--
-- Name: ntf202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ntf202018
    ADD CONSTRAINT ntf202018_sequ_pk PRIMARY KEY (si145_sequencial);


--
-- Name: obelac102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY obelac102018
    ADD CONSTRAINT obelac102018_sequ_pk PRIMARY KEY (si139_sequencial);


--
-- Name: obelac112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY obelac112018
    ADD CONSTRAINT obelac112018_sequ_pk PRIMARY KEY (si140_sequencial);


--
-- Name: ops102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ops102018
    ADD CONSTRAINT ops102018_sequ_pk PRIMARY KEY (si132_sequencial);


--
-- Name: ops112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ops112018
    ADD CONSTRAINT ops112018_sequ_pk PRIMARY KEY (si133_sequencial);


--
-- Name: ops122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ops122018
    ADD CONSTRAINT ops122018_sequ_pk PRIMARY KEY (si134_sequencial);


--
-- Name: ops132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ops132018
    ADD CONSTRAINT ops132018_sequ_pk PRIMARY KEY (si135_sequencial);


--
-- Name: ops142018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY ops142018
    ADD CONSTRAINT ops142018_sequ_pk PRIMARY KEY (si136_sequencial);


--
-- Name: orgao102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY orgao102018
    ADD CONSTRAINT orgao102018_sequ_pk PRIMARY KEY (si14_sequencial);


--
-- Name: orgao112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY orgao112018
    ADD CONSTRAINT orgao112018_sequ_pk PRIMARY KEY (si15_sequencial);


--
-- Name: parec102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY parec102018
    ADD CONSTRAINT parec102018_sequ_pk PRIMARY KEY (si22_sequencial);


--
-- Name: parec112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY parec112018
    ADD CONSTRAINT parec112018_sequ_pk PRIMARY KEY (si23_sequencial);


--
-- Name: parelic102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY parelic102018
    ADD CONSTRAINT parelic102018_sequ_pk PRIMARY KEY (si66_sequencial);


--
-- Name: parpps102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY parpps102018
    ADD CONSTRAINT parpps102018_sequ_pk PRIMARY KEY (si156_sequencial);


--
-- Name: parpps202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY parpps202018
    ADD CONSTRAINT parpps202018_sequ_pk PRIMARY KEY (si155_sequencial);


--
-- Name: pessoa102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY pessoa102018
    ADD CONSTRAINT pessoa102018_sequ_pk PRIMARY KEY (si12_sequencial);


--
-- Name: pessoaflpgo102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY pessoaflpgo102018
    ADD CONSTRAINT pessoaflpgo102018_sequ_pk PRIMARY KEY (si193_sequencial);


--
-- Name: rec102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rec102018
    ADD CONSTRAINT rec102018_sequ_pk PRIMARY KEY (si25_sequencial);


--
-- Name: rec112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rec112018
    ADD CONSTRAINT rec112018_sequ_pk PRIMARY KEY (si26_sequencial);


--
-- Name: regadesao102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY regadesao102018
    ADD CONSTRAINT regadesao102018_sequ_pk PRIMARY KEY (si67_sequencial);


--
-- Name: regadesao112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY regadesao112018
    ADD CONSTRAINT regadesao112018_sequ_pk PRIMARY KEY (si68_sequencial);


--
-- Name: regadesao122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY regadesao122018
    ADD CONSTRAINT regadesao122018_sequ_pk PRIMARY KEY (si69_sequencial);


--
-- Name: regadesao132018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY regadesao132018
    ADD CONSTRAINT regadesao132018_sequ_pk PRIMARY KEY (si70_sequencial);


--
-- Name: regadesao142018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY regadesao142018
    ADD CONSTRAINT regadesao142018_sequ_pk PRIMARY KEY (si71_sequencial);


--
-- Name: regadesao152018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY regadesao152018
    ADD CONSTRAINT regadesao152018_sequ_pk PRIMARY KEY (si72_sequencial);


--
-- Name: regadesao202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY regadesao202018
    ADD CONSTRAINT regadesao202018_sequ_pk PRIMARY KEY (si73_sequencial);


--
-- Name: reglic102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY reglic102018
    ADD CONSTRAINT reglic102018_sequ_pk PRIMARY KEY (si44_sequencial);


--
-- Name: reglic202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY reglic202018
    ADD CONSTRAINT reglic202018_sequ_pk PRIMARY KEY (si45_sequencial);


--
-- Name: respinf102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY respinf102018
    ADD CONSTRAINT respinf102018_sequ_pk PRIMARY KEY (si197_sequencial);


--
-- Name: resplic102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY resplic102018
    ADD CONSTRAINT resplic102018_sequ_pk PRIMARY KEY (si55_sequencial);


--
-- Name: resplic202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY resplic202018
    ADD CONSTRAINT resplic202018_sequ_pk PRIMARY KEY (si56_sequencial);


--
-- Name: rsp102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rsp102018
    ADD CONSTRAINT rsp102018_sequ_pk PRIMARY KEY (si112_sequencial);


--
-- Name: rsp112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rsp112018
    ADD CONSTRAINT rsp112018_sequ_pk PRIMARY KEY (si113_sequencial);


--
-- Name: rsp122018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rsp122018
    ADD CONSTRAINT rsp122018_sequ_pk PRIMARY KEY (si114_sequencial);


--
-- Name: rsp202018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rsp202018
    ADD CONSTRAINT rsp202018_sequ_pk PRIMARY KEY (si115_sequencial);


--
-- Name: rsp212018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rsp212018
    ADD CONSTRAINT rsp212018_sequ_pk PRIMARY KEY (si116_sequencial);


--
-- Name: rsp222018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY rsp222018
    ADD CONSTRAINT rsp222018_sequ_pk PRIMARY KEY (si117_sequencial);


--
-- Name: supdef102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY supdef102018
    ADD CONSTRAINT supdef102018_sequ_pk PRIMARY KEY (si167_sequencial);


--
-- Name: supdef112018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY supdef112018
    ADD CONSTRAINT supdef112018_sequ_pk PRIMARY KEY (si168_sequencial);


--
-- Name: terem102018_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace: 
--

ALTER TABLE ONLY terem102018
    ADD CONSTRAINT terem102018_sequ_pk PRIMARY KEY (si194_sequencial);


--
-- Name: aberlic112018_si47_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aberlic112018_si47_reg10_index ON aberlic112018 USING btree (si47_reg10);


--
-- Name: aberlic122018_si48_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aberlic122018_si48_reg10_index ON aberlic122018 USING btree (si48_reg10);


--
-- Name: aberlic132018_si49_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aberlic132018_si49_reg10_index ON aberlic132018 USING btree (si49_reg10);


--
-- Name: aberlic142018_si50_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aberlic142018_si50_reg10_index ON aberlic142018 USING btree (si50_reg10);


--
-- Name: aberlic152018_si51_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aberlic152018_si51_reg10_index ON aberlic152018 USING btree (si51_reg10);


--
-- Name: aberlic162018_si52_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aberlic162018_si52_reg10_index ON aberlic162018 USING btree (si52_reg10);


--
-- Name: alq112018_si122_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX alq112018_si122_reg10_index ON alq112018 USING btree (si122_reg10);


--
-- Name: alq122018_si123_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX alq122018_si123_reg10_index ON alq122018 USING btree (si123_reg10);


--
-- Name: anl112018_si111_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX anl112018_si111_reg10_index ON anl112018 USING btree (si111_reg10);


--
-- Name: aob112018_si142_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aob112018_si142_reg10_index ON aob112018 USING btree (si142_reg10);


--
-- Name: aoc112018_si39_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aoc112018_si39_reg10_index ON aoc112018 USING btree (si39_reg10);


--
-- Name: aoc122018_si40_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aoc122018_si40_reg10_index ON aoc122018 USING btree (si40_reg10);


--
-- Name: aoc132018_si41_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aoc132018_si41_reg10_index ON aoc132018 USING btree (si41_reg10);


--
-- Name: aoc142018_si42_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aoc142018_si42_reg10_index ON aoc142018 USING btree (si42_reg10);


--
-- Name: aop112018_si138_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX aop112018_si138_reg10_index ON aop112018 USING btree (si138_reg10);


--
-- Name: arc112018_si15_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX arc112018_si15_reg10_index ON arc112018 USING btree (si29_reg10);


--
-- Name: arc122018_si30_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX arc122018_si30_reg10_index ON arc122018 USING btree (si30_reg10);


--
-- Name: arcwq2018_si32_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX arcwq2018_si32_reg20_index ON arc212018 USING btree (si32_reg20);


--
-- Name: caixa122018_si104_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX caixa122018_si104_reg10_index ON caixa122018 USING btree (si104_reg10);


--
-- Name: caixa132018_si105_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX caixa132018_si105_reg10_index ON caixa132018 USING btree (si105_reg10);


--
-- Name: contratos112018_si84_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX contratos112018_si84_reg10_index ON contratos112018 USING btree (si84_reg10);


--
-- Name: contratos122018_si85_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX contratos122018_si85_reg10_index ON contratos122018 USING btree (si85_reg10);


--
-- Name: contratos132018_si86_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX contratos132018_si86_reg10_index ON contratos132018 USING btree (si86_reg10);


--
-- Name: contratos212018_si88_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX contratos212018_si88_reg10_index ON contratos212018 USING btree (si88_reg20);


--
-- Name: conv112018_si93_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX conv112018_si93_reg10_index ON conv112018 USING btree (si93_reg10);


--
-- Name: ctb212018_si97_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ctb212018_si97_reg20_index ON ctb212018 USING btree (si97_reg20);


--
-- Name: ctb222018_si98_reg21_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ctb222018_si98_reg21_index ON ctb222018 USING btree (si98_reg21);


--
-- Name: ctb312018_si100_reg30_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ctb312018_si100_reg30_index ON ctb312018 USING btree (si100_reg30);


--
-- Name: ddc112018_si151_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ddc112018_si151_reg10_index ON ddc112018 USING btree (si151_reg10);


--
-- Name: ddc122018_si152_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ddc122018_si152_reg10_index ON ddc122018 USING btree (si152_reg10);


--
-- Name: dispensa112018_si75_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa112018_si75_reg10_index ON dispensa112018 USING btree (si75_reg10);


--
-- Name: dispensa122018_si76_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa122018_si76_reg10_index ON dispensa122018 USING btree (si76_reg10);


--
-- Name: dispensa132018_si77_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa132018_si77_reg10_index ON dispensa132018 USING btree (si77_reg10);


--
-- Name: dispensa142018_si78_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa142018_si78_reg10_index ON dispensa142018 USING btree (si78_reg10);


--
-- Name: dispensa152018_si79_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa152018_si79_reg10_index ON dispensa152018 USING btree (si79_reg10);


--
-- Name: dispensa162018_si80_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa162018_si80_reg10_index ON dispensa162018 USING btree (si80_reg10);


--
-- Name: dispensa172018_si81_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa172018_si81_reg10_index ON dispensa172018 USING btree (si81_reg10);


--
-- Name: dispensa182018_si82_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX dispensa182018_si82_reg10_index ON dispensa182018 USING btree (si82_reg10);


--
-- Name: emp112018_si107_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX emp112018_si107_reg10_index ON emp112018 USING btree (si107_reg10);


--
-- Name: emp122018_si108_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX emp122018_si108_reg10_index ON emp122018 USING btree (si108_reg10);


--
-- Name: ext312018_si127_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ext312018_si127_reg20_index ON ext312018 USING btree (si127_reg30);


--
-- Name: ext322018_si128_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ext322018_si128_reg20_index ON ext322018 USING btree (si128_reg30);


--
-- Name: flpgo112018_si196_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX flpgo112018_si196_reg10_index ON flpgo112018 USING btree (si196_reg10);


--
-- Name: flpgo122018_si197_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX flpgo122018_si197_reg10_index ON flpgo122018 USING btree (si197_reg10);


--
-- Name: hablic112018_si58_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX hablic112018_si58_reg10_index ON hablic112018 USING btree (si58_mes);


--
-- Name: incamp112018_si161_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX incamp112018_si161_reg10_index ON incamp112018 USING btree (si161_reg10);


--
-- Name: incamp122018_si162_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX incamp122018_si162_reg10_index ON incamp122018 USING btree (si162_reg10);


--
-- Name: lao112018_si35_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX lao112018_si35_reg10_index ON lao112018 USING btree (si35_reg10);


--
-- Name: lao212018_si37_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX lao212018_si37_reg20_index ON lao212018 USING btree (si37_reg20);


--
-- Name: lqd112018_si119_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX lqd112018_si119_reg10_index ON lqd112018 USING btree (si119_reg10);


--
-- Name: lqd122018_si120_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX lqd122018_si120_reg10_index ON lqd122018 USING btree (si120_reg10);


--
-- Name: ntf112018_si144_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ntf112018_si144_reg10_index ON ntf112018 USING btree (si144_reg10);


--
-- Name: obelac112018_si140_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX obelac112018_si140_reg10_index ON obelac112018 USING btree (si140_reg10);


--
-- Name: ops112018_si133_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ops112018_si133_reg10_index ON ops112018 USING btree (si133_reg10);


--
-- Name: ops122018_si134_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ops122018_si134_reg10_index ON ops122018 USING btree (si134_reg10);


--
-- Name: ops132018_si135_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ops132018_si135_reg10_index ON ops132018 USING btree (si135_reg10);


--
-- Name: ops142018_si133_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX ops142018_si133_reg10_index ON ops142018 USING btree (si136_reg10);


--
-- Name: orgao112018_si15_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX orgao112018_si15_reg10_index ON orgao112018 USING btree (si15_reg10);


--
-- Name: parec112018_si23_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX parec112018_si23_reg10_index ON parec112018 USING btree (si23_reg10);


--
-- Name: rec112018_si26_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX rec112018_si26_reg10_index ON rec112018 USING btree (si26_reg10);


--
-- Name: regadesao112018_si68_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX regadesao112018_si68_reg10_index ON regadesao112018 USING btree (si68_reg10);


--
-- Name: regadesao122018_si69_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX regadesao122018_si69_reg10_index ON regadesao122018 USING btree (si69_reg10);


--
-- Name: regadesao132018_si70_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX regadesao132018_si70_reg10_index ON regadesao132018 USING btree (si70_reg10);


--
-- Name: regadesao142018_si71_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX regadesao142018_si71_reg10_index ON regadesao142018 USING btree (si71_reg10);


--
-- Name: regadesao152018_si72_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX regadesao152018_si72_reg10_index ON regadesao152018 USING btree (si72_reg10);


--
-- Name: rsp112018_si113_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX rsp112018_si113_reg10_index ON rsp112018 USING btree (si113_reg10);


--
-- Name: rsp122018_si114_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX rsp122018_si114_reg10_index ON rsp122018 USING btree (si114_reg10);


--
-- Name: rsp212018_si116_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX rsp212018_si116_reg20_index ON rsp212018 USING btree (si116_reg20);


--
-- Name: rsp222018_si117_reg20_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX rsp222018_si117_reg20_index ON rsp222018 USING btree (si117_reg20);


--
-- Name: supdef112018_si167_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace: 
--

CREATE INDEX supdef112018_si167_reg10_index ON supdef112018 USING btree (si168_reg10);


--
-- Name: aberlic112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aberlic112018
    ADD CONSTRAINT aberlic112018_reg10_fk FOREIGN KEY (si47_reg10) REFERENCES aberlic102018(si46_sequencial);


--
-- Name: aberlic122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aberlic122018
    ADD CONSTRAINT aberlic122018_reg10_fk FOREIGN KEY (si48_reg10) REFERENCES aberlic102018(si46_sequencial);


--
-- Name: aberlic132018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aberlic132018
    ADD CONSTRAINT aberlic132018_reg10_fk FOREIGN KEY (si49_reg10) REFERENCES aberlic102018(si46_sequencial);


--
-- Name: aberlic142018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aberlic142018
    ADD CONSTRAINT aberlic142018_reg10_fk FOREIGN KEY (si50_reg10) REFERENCES aberlic102018(si46_sequencial);


--
-- Name: aberlic152018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aberlic152018
    ADD CONSTRAINT aberlic152018_reg10_fk FOREIGN KEY (si51_reg10) REFERENCES aberlic102018(si46_sequencial);


--
-- Name: aberlic162018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aberlic162018
    ADD CONSTRAINT aberlic162018_reg10_fk FOREIGN KEY (si52_reg10) REFERENCES aberlic102018(si46_sequencial);


--
-- Name: alq112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY alq112018
    ADD CONSTRAINT alq112018_reg10_fk FOREIGN KEY (si122_reg10) REFERENCES alq102018(si121_sequencial);


--
-- Name: alq122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY alq122018
    ADD CONSTRAINT alq122018_reg10_fk FOREIGN KEY (si123_reg10) REFERENCES alq102018(si121_sequencial);


--
-- Name: anl112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY anl112018
    ADD CONSTRAINT anl112018_reg10_fk FOREIGN KEY (si111_reg10) REFERENCES anl102018(si110_sequencial);


--
-- Name: aob112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aob112018
    ADD CONSTRAINT aob112018_reg10_fk FOREIGN KEY (si142_reg10) REFERENCES aob102018(si141_sequencial);


--
-- Name: aoc112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aoc112018
    ADD CONSTRAINT aoc112018_reg10_fk FOREIGN KEY (si39_reg10) REFERENCES aoc102018(si38_sequencial);


--
-- Name: aoc122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aoc122018
    ADD CONSTRAINT aoc122018_reg10_fk FOREIGN KEY (si40_reg10) REFERENCES aoc102018(si38_sequencial);


--
-- Name: aoc132018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aoc132018
    ADD CONSTRAINT aoc132018_reg10_fk FOREIGN KEY (si41_reg10) REFERENCES aoc102018(si38_sequencial);


--
-- Name: aoc142018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aoc142018
    ADD CONSTRAINT aoc142018_reg10_fk FOREIGN KEY (si42_reg10) REFERENCES aoc102018(si38_sequencial);


--
-- Name: aop112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY aop112018
    ADD CONSTRAINT aop112018_reg10_fk FOREIGN KEY (si138_reg10) REFERENCES aop102018(si137_sequencial);


--
-- Name: arc112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY arc112018
    ADD CONSTRAINT arc112018_reg10_fk FOREIGN KEY (si29_reg10) REFERENCES arc102018(si28_sequencial);


--
-- Name: arc122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY arc122018
    ADD CONSTRAINT arc122018_reg10_fk FOREIGN KEY (si30_reg10) REFERENCES arc102018(si28_sequencial);


--
-- Name: arc212018_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY arc212018
    ADD CONSTRAINT arc212018_reg20_fk FOREIGN KEY (si32_reg20) REFERENCES arc202018(si31_sequencial);


--
-- Name: caixa112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY caixa112018
    ADD CONSTRAINT caixa112018_reg10_fk FOREIGN KEY (si166_reg10) REFERENCES caixa102018(si103_sequencial);


--
-- Name: caixa122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY caixa122018
    ADD CONSTRAINT caixa122018_reg10_fk FOREIGN KEY (si104_reg10) REFERENCES caixa102018(si103_sequencial);


--
-- Name: caixa132018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY caixa132018
    ADD CONSTRAINT caixa132018_reg10_fk FOREIGN KEY (si105_reg10) REFERENCES caixa102018(si103_sequencial);


--
-- Name: contratos112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY contratos112018
    ADD CONSTRAINT contratos112018_reg10_fk FOREIGN KEY (si84_reg10) REFERENCES contratos102018(si83_sequencial);


--
-- Name: contratos122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY contratos122018
    ADD CONSTRAINT contratos122018_reg10_fk FOREIGN KEY (si85_reg10) REFERENCES contratos102018(si83_sequencial);


--
-- Name: contratos132018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY contratos132018
    ADD CONSTRAINT contratos132018_reg10_fk FOREIGN KEY (si86_reg10) REFERENCES contratos102018(si83_sequencial);


--
-- Name: contratos212018_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY contratos212018
    ADD CONSTRAINT contratos212018_reg20_fk FOREIGN KEY (si88_reg20) REFERENCES contratos202018(si87_sequencial);


--
-- Name: conv112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY conv112018
    ADD CONSTRAINT conv112018_reg10_fk FOREIGN KEY (si93_reg10) REFERENCES conv102018(si92_sequencial);


--
-- Name: ctb212018_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ctb212018
    ADD CONSTRAINT ctb212018_reg20_fk FOREIGN KEY (si97_reg20) REFERENCES ctb202018(si96_sequencial);


--
-- Name: ctb222018_reg21_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ctb222018
    ADD CONSTRAINT ctb222018_reg21_fk FOREIGN KEY (si98_reg21) REFERENCES ctb212018(si97_sequencial);


--
-- Name: ctb312018_reg30_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ctb312018
    ADD CONSTRAINT ctb312018_reg30_fk FOREIGN KEY (si100_reg30) REFERENCES ctb302018(si99_sequencial);


--
-- Name: ddc112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ddc112018
    ADD CONSTRAINT ddc112018_reg10_fk FOREIGN KEY (si151_reg10) REFERENCES ddc102018(si150_sequencial);


--
-- Name: ddc122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ddc122018
    ADD CONSTRAINT ddc122018_reg10_fk FOREIGN KEY (si152_reg10) REFERENCES ddc102018(si150_sequencial);


--
-- Name: dispensa112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa112018
    ADD CONSTRAINT dispensa112018_reg10_fk FOREIGN KEY (si75_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: dispensa122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa122018
    ADD CONSTRAINT dispensa122018_reg10_fk FOREIGN KEY (si76_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: dispensa132018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa132018
    ADD CONSTRAINT dispensa132018_reg10_fk FOREIGN KEY (si77_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: dispensa142018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa142018
    ADD CONSTRAINT dispensa142018_reg10_fk FOREIGN KEY (si78_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: dispensa152018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa152018
    ADD CONSTRAINT dispensa152018_reg10_fk FOREIGN KEY (si79_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: dispensa162018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa162018
    ADD CONSTRAINT dispensa162018_reg10_fk FOREIGN KEY (si80_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: dispensa172018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa172018
    ADD CONSTRAINT dispensa172018_reg10_fk FOREIGN KEY (si81_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: dispensa182018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY dispensa182018
    ADD CONSTRAINT dispensa182018_reg10_fk FOREIGN KEY (si82_reg10) REFERENCES dispensa102018(si74_sequencial);


--
-- Name: emp112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY emp112018
    ADD CONSTRAINT emp112018_reg10_fk FOREIGN KEY (si107_reg10) REFERENCES emp102018(si106_sequencial);


--
-- Name: emp122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY emp122018
    ADD CONSTRAINT emp122018_reg10_fk FOREIGN KEY (si108_reg10) REFERENCES emp102018(si106_sequencial);


--
-- Name: ext312018_reg22_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ext312018
    ADD CONSTRAINT ext312018_reg22_fk FOREIGN KEY (si127_reg30) REFERENCES ext302018(si126_sequencial);


--
-- Name: ext322018_reg23_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ext322018
    ADD CONSTRAINT ext322018_reg23_fk FOREIGN KEY (si128_reg30) REFERENCES ext322018(si128_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete112018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si178_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete122018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si179_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete132018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si180_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete142018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si181_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete152018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si182_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete162018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si183_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete172018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si184_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete182018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si185_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete202018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si187_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete212018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si188_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete222018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si189_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete232018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si190_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: fk_balancete102018_si77_sequencial; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY balancete242018
    ADD CONSTRAINT fk_balancete102018_si77_sequencial FOREIGN KEY (si191_reg10) REFERENCES balancete102018(si177_sequencial);


--
-- Name: flpgo112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY flpgo112018
    ADD CONSTRAINT flpgo112018_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES flpgo102018(si195_sequencial);


--
-- Name: flpgo122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY flpgo122018
    ADD CONSTRAINT flpgo122018_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES flpgo102018(si195_sequencial);


--
-- Name: hablic112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY hablic112018
    ADD CONSTRAINT hablic112018_reg10_fk FOREIGN KEY (si58_reg10) REFERENCES hablic102018(si57_sequencial);


--
-- Name: incamp112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY incamp112018
    ADD CONSTRAINT incamp112018_reg10_fk FOREIGN KEY (si161_reg10) REFERENCES incamp102018(si160_sequencial);


--
-- Name: incamp122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY incamp122018
    ADD CONSTRAINT incamp122018_reg10_fk FOREIGN KEY (si162_reg10) REFERENCES incamp102018(si160_sequencial);


--
-- Name: lao112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY lao112018
    ADD CONSTRAINT lao112018_reg10_fk FOREIGN KEY (si35_reg10) REFERENCES lao102018(si34_sequencial);


--
-- Name: lao212018_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY lao212018
    ADD CONSTRAINT lao212018_reg20_fk FOREIGN KEY (si37_reg20) REFERENCES lao202018(si36_sequencial);


--
-- Name: lqd112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY lqd112018
    ADD CONSTRAINT lqd112018_reg10_fk FOREIGN KEY (si119_reg10) REFERENCES lqd102018(si118_sequencial);


--
-- Name: lqd122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY lqd122018
    ADD CONSTRAINT lqd122018_reg10_fk FOREIGN KEY (si120_reg10) REFERENCES lqd102018(si118_sequencial);


--
-- Name: ntf112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ntf112018
    ADD CONSTRAINT ntf112018_reg10_fk FOREIGN KEY (si144_reg10) REFERENCES ntf102018(si143_sequencial);


--
-- Name: obelac112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY obelac112018
    ADD CONSTRAINT obelac112018_reg10_fk FOREIGN KEY (si140_reg10) REFERENCES lqd122018(si120_sequencial);


--
-- Name: ops112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ops112018
    ADD CONSTRAINT ops112018_reg10_fk FOREIGN KEY (si133_reg10) REFERENCES ops102018(si132_sequencial);


--
-- Name: ops122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ops122018
    ADD CONSTRAINT ops122018_reg10_fk FOREIGN KEY (si134_reg10) REFERENCES ops102018(si132_sequencial);


--
-- Name: ops132018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ops132018
    ADD CONSTRAINT ops132018_reg10_fk FOREIGN KEY (si135_reg10) REFERENCES ops102018(si132_sequencial);


--
-- Name: ops142018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY ops142018
    ADD CONSTRAINT ops142018_reg10_fk FOREIGN KEY (si136_reg10) REFERENCES ops102018(si132_sequencial);


--
-- Name: orgao112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY orgao112018
    ADD CONSTRAINT orgao112018_reg10_fk FOREIGN KEY (si15_reg10) REFERENCES orgao102018(si14_sequencial);


--
-- Name: parec112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY parec112018
    ADD CONSTRAINT parec112018_reg10_fk FOREIGN KEY (si23_reg10) REFERENCES parec102018(si22_sequencial);


--
-- Name: rec112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY rec112018
    ADD CONSTRAINT rec112018_reg10_fk FOREIGN KEY (si26_reg10) REFERENCES rec102018(si25_sequencial);


--
-- Name: regadesao112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY regadesao112018
    ADD CONSTRAINT regadesao112018_reg10_fk FOREIGN KEY (si68_reg10) REFERENCES regadesao102018(si67_sequencial);


--
-- Name: regadesao122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY regadesao122018
    ADD CONSTRAINT regadesao122018_reg10_fk FOREIGN KEY (si69_reg10) REFERENCES regadesao102018(si67_sequencial);


--
-- Name: regadesao132018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY regadesao132018
    ADD CONSTRAINT regadesao132018_reg10_fk FOREIGN KEY (si70_reg10) REFERENCES regadesao102018(si67_sequencial);


--
-- Name: regadesao142018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY regadesao142018
    ADD CONSTRAINT regadesao142018_reg10_fk FOREIGN KEY (si71_reg10) REFERENCES regadesao102018(si67_sequencial);


--
-- Name: regadesao152018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY regadesao152018
    ADD CONSTRAINT regadesao152018_reg10_fk FOREIGN KEY (si72_reg10) REFERENCES regadesao102018(si67_sequencial);


--
-- Name: rsp112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY rsp112018
    ADD CONSTRAINT rsp112018_reg10_fk FOREIGN KEY (si113_reg10) REFERENCES rsp102018(si112_sequencial);


--
-- Name: rsp122018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY rsp122018
    ADD CONSTRAINT rsp122018_reg10_fk FOREIGN KEY (si114_reg10) REFERENCES rsp102018(si112_sequencial);


--
-- Name: rsp212018_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY rsp212018
    ADD CONSTRAINT rsp212018_reg20_fk FOREIGN KEY (si116_reg20) REFERENCES rsp202018(si115_sequencial);


--
-- Name: rsp222018_reg20_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY rsp222018
    ADD CONSTRAINT rsp222018_reg20_fk FOREIGN KEY (si117_reg20) REFERENCES rsp202018(si115_sequencial);


--
-- Name: supdef112018_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
--

ALTER TABLE ONLY supdef112018
    ADD CONSTRAINT supdef112018_reg10_fk FOREIGN KEY (si168_reg10) REFERENCES supdef102018(si167_sequencial);


--
-- PostgreSQL database dump complete
--
COMMIT;
