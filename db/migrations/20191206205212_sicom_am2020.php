<?php

use Phinx\Migration\AbstractMigration;

class SicomAm2020 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        CREATE TABLE aberlic102020 (
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


        ALTER TABLE aberlic102020 OWNER TO dbportal;


        CREATE SEQUENCE aberlic102020_si46_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aberlic102020_si46_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aberlic112020 (
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


        ALTER TABLE aberlic112020 OWNER TO dbportal;


        CREATE SEQUENCE aberlic112020_si47_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aberlic112020_si47_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aberlic122020 (
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


        ALTER TABLE aberlic122020 OWNER TO dbportal;


        CREATE SEQUENCE aberlic122020_si48_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aberlic122020_si48_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aberlic132020 (
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


        ALTER TABLE aberlic132020 OWNER TO dbportal;


        CREATE SEQUENCE aberlic132020_si49_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aberlic132020_si49_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aberlic142020 (
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


        ALTER TABLE aberlic142020 OWNER TO dbportal;


        CREATE SEQUENCE aberlic142020_si50_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aberlic142020_si50_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aberlic152020 (
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


        ALTER TABLE aberlic152020 OWNER TO dbportal;


        CREATE SEQUENCE aberlic152020_si51_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aberlic152020_si51_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aberlic162020 (
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


        ALTER TABLE aberlic162020 OWNER TO dbportal;


        CREATE SEQUENCE aberlic162020_si52_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aberlic162020_si52_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aex102020 (
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


        ALTER TABLE aex102020 OWNER TO dbportal;


        CREATE SEQUENCE aex102020_si130_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aex102020_si130_sequencial_seq OWNER TO dbportal;


        CREATE TABLE alq102020 (
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


        ALTER TABLE alq102020 OWNER TO dbportal;


        CREATE SEQUENCE alq102020_si121_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE alq102020_si121_sequencial_seq OWNER TO dbportal;


        CREATE TABLE alq112020 (
            si122_sequencial bigint DEFAULT 0 NOT NULL,
            si122_tiporegistro bigint DEFAULT 0 NOT NULL,
            si122_codreduzido bigint DEFAULT 0 NOT NULL,
            si122_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si122_valoranuladofonte double precision DEFAULT 0 NOT NULL,
            si122_mes bigint DEFAULT 0 NOT NULL,
            si122_reg10 bigint DEFAULT 0 NOT NULL,
            si122_instit bigint DEFAULT 0
        );


        ALTER TABLE alq112020 OWNER TO dbportal;


        CREATE SEQUENCE alq112020_si122_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE alq112020_si122_sequencial_seq OWNER TO dbportal;


        CREATE TABLE alq122020 (
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


        ALTER TABLE alq122020 OWNER TO dbportal;


        CREATE SEQUENCE alq122020_si123_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE alq122020_si123_sequencial_seq OWNER TO dbportal;


        CREATE TABLE anl102020 (
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


        ALTER TABLE anl102020 OWNER TO dbportal;


        CREATE SEQUENCE anl102020_si110_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE anl102020_si110_sequencial_seq OWNER TO dbportal;


        CREATE TABLE anl112020 (
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


        ALTER TABLE anl112020 OWNER TO dbportal;


        CREATE SEQUENCE anl112020_si111_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE anl112020_si111_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aob102020 (
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


        ALTER TABLE aob102020 OWNER TO dbportal;


        CREATE SEQUENCE aob102020_si141_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aob102020_si141_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aob112020 (
            si142_sequencial bigint DEFAULT 0 NOT NULL,
            si142_tiporegistro bigint DEFAULT 0 NOT NULL,
            si142_codreduzido bigint DEFAULT 0 NOT NULL,
            si142_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si142_valoranulacaofonte double precision DEFAULT 0 NOT NULL,
            si142_mes bigint DEFAULT 0 NOT NULL,
            si142_reg10 bigint DEFAULT 0 NOT NULL,
            si142_instit bigint DEFAULT 0
        );


        ALTER TABLE aob112020 OWNER TO dbportal;


        CREATE SEQUENCE aob112020_si142_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aob112020_si142_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aoc102020 (
            si38_sequencial bigint DEFAULT 0 NOT NULL,
            si38_tiporegistro bigint DEFAULT 0 NOT NULL,
            si38_codorgao character varying(2) NOT NULL,
            si38_nrodecreto bigint DEFAULT 0 NOT NULL,
            si38_datadecreto date NOT NULL,
            si38_mes bigint DEFAULT 0 NOT NULL,
            si38_instit bigint DEFAULT 0
        );


        ALTER TABLE aoc102020 OWNER TO dbportal;


        CREATE SEQUENCE aoc102020_si38_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aoc102020_si38_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aoc112020 (
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


        ALTER TABLE aoc112020 OWNER TO dbportal;


        CREATE SEQUENCE aoc112020_si39_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aoc112020_si39_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aoc122020 (
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


        ALTER TABLE aoc122020 OWNER TO dbportal;


        CREATE SEQUENCE aoc122020_si40_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aoc122020_si40_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aoc132020 (
            si41_sequencial bigint DEFAULT 0 NOT NULL,
            si41_tiporegistro bigint DEFAULT 0 NOT NULL,
            si41_codreduzidodecreto bigint DEFAULT 0 NOT NULL,
            si41_origemrecalteracao character varying(2) NOT NULL,
            si41_valorabertoorigem double precision DEFAULT 0 NOT NULL,
            si41_mes bigint DEFAULT 0 NOT NULL,
            si41_reg10 bigint DEFAULT 0 NOT NULL,
            si41_instit bigint DEFAULT 0
        );


        ALTER TABLE aoc132020 OWNER TO dbportal;


        CREATE SEQUENCE aoc132020_si41_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aoc132020_si41_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aoc142020 (
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
            si42_vlacrescimo double precision DEFAULT 0 NOT NULL,
            si42_mes bigint DEFAULT 0 NOT NULL,
            si42_reg10 bigint DEFAULT 0 NOT NULL,
            si42_instit bigint DEFAULT 0
        );


        ALTER TABLE aoc142020 OWNER TO dbportal;


        CREATE SEQUENCE aoc142020_si42_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aoc142020_si42_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aoc152020 (
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
            si194_idsubacao character varying(4) DEFAULT NULL::character varying,
            si194_naturezadespesa bigint DEFAULT 0 NOT NULL,
            si194_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si194_vlreducao double precision DEFAULT 0 NOT NULL,
            si194_mes bigint DEFAULT 0 NOT NULL,
            si194_reg10 bigint DEFAULT 0 NOT NULL,
            si194_instit bigint DEFAULT 0 NOT NULL
        );


        ALTER TABLE aoc152020 OWNER TO dbportal;


        CREATE SEQUENCE aoc152020_si194_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aoc152020_si194_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aop102020 (
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


        ALTER TABLE aop102020 OWNER TO dbportal;


        CREATE SEQUENCE aop102020_si137_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aop102020_si137_sequencial_seq OWNER TO dbportal;


        CREATE TABLE aop112020 (
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


        ALTER TABLE aop112020 OWNER TO dbportal;


        CREATE SEQUENCE aop112020_si138_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE aop112020_si138_sequencial_seq OWNER TO dbportal;


        CREATE TABLE arc102020 (
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


        ALTER TABLE arc102020 OWNER TO dbportal;


        CREATE SEQUENCE arc102020_si28_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE arc102020_si28_sequencial_seq OWNER TO dbportal;


        CREATE TABLE arc112020 (
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


        ALTER TABLE arc112020 OWNER TO dbportal;


        CREATE SEQUENCE arc112020_si29_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE arc112020_si29_sequencial_seq OWNER TO dbportal;


        CREATE TABLE arc122020 (
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


        ALTER TABLE arc122020 OWNER TO dbportal;


        CREATE TABLE arc202020 (
            si31_sequencial bigint DEFAULT 0 NOT NULL,
            si31_tiporegistro bigint DEFAULT 0 NOT NULL,
            si31_codorgao character varying(2) NOT NULL,
            si31_codestorno bigint DEFAULT 0 NOT NULL,
            si31_ededucaodereceita bigint DEFAULT 0 NOT NULL,
            si31_identificadordeducao bigint,
            si31_naturezareceitaestornada bigint DEFAULT 0 NOT NULL,
            si31_vlestornado double precision DEFAULT 0 NOT NULL,
            si31_mes bigint DEFAULT 0 NOT NULL,
            si31_instit bigint DEFAULT 0
        );


        ALTER TABLE arc202020 OWNER TO dbportal;


        CREATE SEQUENCE arc202020_si31_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE arc202020_si31_sequencial_seq OWNER TO dbportal;


        CREATE TABLE arc212020 (
            si32_sequencial bigint DEFAULT 0 NOT NULL,
            si32_tiporegistro bigint DEFAULT 0 NOT NULL,
            si32_codestorno bigint DEFAULT 0 NOT NULL,
            si32_codfonteestornada bigint DEFAULT 0 NOT NULL,
            si32_tipodocumento bigint,
            si32_nrodocumento character varying(14) DEFAULT NULL::character varying,
            si32_nroconvenio character varying(30) DEFAULT NULL::character varying,
            si32_dataassinatura date,
            si32_vlestornadofonte double precision DEFAULT 0 NOT NULL,
            si32_reg20 bigint DEFAULT 0 NOT NULL,
            si32_instit bigint DEFAULT 0,
            si32_mes bigint NOT NULL
        );


        ALTER TABLE arc212020 OWNER TO dbportal;


        CREATE SEQUENCE arc212020_si32_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE arc212020_si32_sequencial_seq OWNER TO dbportal;


        CREATE TABLE caixa102020 (
            si103_sequencial bigint DEFAULT 0 NOT NULL,
            si103_tiporegistro bigint DEFAULT 0 NOT NULL,
            si103_codorgao character varying(2) NOT NULL,
            si103_vlsaldoinicial double precision DEFAULT 0 NOT NULL,
            si103_vlsaldofinal double precision DEFAULT 0 NOT NULL,
            si103_mes bigint DEFAULT 0 NOT NULL,
            si103_instit bigint DEFAULT 0
        );


        ALTER TABLE caixa102020 OWNER TO dbportal;


        CREATE SEQUENCE caixa102020_si103_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE caixa102020_si103_sequencial_seq OWNER TO dbportal;


        CREATE TABLE caixa112020 (
            si166_sequencial bigint DEFAULT 0 NOT NULL,
            si166_tiporegistro bigint DEFAULT 0 NOT NULL,
            si166_codfontecaixa bigint DEFAULT 0 NOT NULL,
            si166_vlsaldoinicialfonte double precision DEFAULT 0 NOT NULL,
            si166_vlsaldofinalfonte double precision DEFAULT 0 NOT NULL,
            si166_mes bigint DEFAULT 0 NOT NULL,
            si166_instit bigint DEFAULT 0,
            si166_reg10 bigint DEFAULT 0 NOT NULL
        );


        ALTER TABLE caixa112020 OWNER TO dbportal;


        CREATE SEQUENCE caixa112020_si166_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE caixa112020_si166_sequencial_seq OWNER TO dbportal;


        CREATE TABLE caixa122020 (
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


        ALTER TABLE caixa122020 OWNER TO dbportal;


        CREATE SEQUENCE caixa122020_si104_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE caixa122020_si104_sequencial_seq OWNER TO dbportal;


        CREATE TABLE caixa132020 (
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
            si105_instit bigint DEFAULT 0,
            si105_codfontcaixa integer DEFAULT 0
        );


        ALTER TABLE caixa132020 OWNER TO dbportal;


        CREATE SEQUENCE caixa132020_si105_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE caixa132020_si105_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conge102020 (
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


        ALTER TABLE conge102020 OWNER TO dbportal;


        CREATE SEQUENCE conge102020_si182_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conge102020_si182_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conge202020 (
            si183_sequencial bigint DEFAULT 0 NOT NULL,
            si183_tiporegistro bigint DEFAULT 0 NOT NULL,
            si183_codorgao character varying(2) NOT NULL,
            si183_codunidadesub character varying(8) NOT NULL,
            si183_nroconvenioconge character varying(30) NOT NULL,
            si183_dataassinaturaconvoriginalconge date NOT NULL,
            si183_nroseqtermoaditivoconge bigint DEFAULT 0 NOT NULL,
            si183_dscalteracaoconge character varying(500) DEFAULT 0 NOT NULL,
            si183_dataassinaturatermoaditivoconge date NOT NULL,
            si183_datafinalvigenciaconge date NOT NULL,
            si183_valoratualizadoconvenioconge double precision NOT NULL,
            si183_valoratualizadocontrapartidaconge double precision NOT NULL,
            si183_mes bigint DEFAULT 0 NOT NULL,
            si183_instit bigint DEFAULT 0
        );


        ALTER TABLE conge202020 OWNER TO dbportal;


        CREATE SEQUENCE conge202020_si183_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conge202020_si183_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conge302020 (
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


        ALTER TABLE conge302020 OWNER TO dbportal;


        CREATE SEQUENCE conge302020_si184_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conge302020_si184_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conge402020 (
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


        ALTER TABLE conge402020 OWNER TO dbportal;


        CREATE SEQUENCE conge402020_si237_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conge402020_si237_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conge502020 (
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


        ALTER TABLE conge502020 OWNER TO dbportal;


        CREATE SEQUENCE conge502020_si238_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conge502020_si238_sequencial_seq OWNER TO dbportal;


        CREATE TABLE consid102020 (
            si158_sequencial bigint DEFAULT 0 NOT NULL,
            si158_tiporegistro bigint DEFAULT 0 NOT NULL,
            si158_codarquivo character varying(20) NOT NULL,
            si158_exercicioreferenciaconsid bigint DEFAULT 0,
            si158_mesreferenciaconsid character varying(2),
            si158_consideracoes character varying(4000) NOT NULL,
            si158_mes bigint,
            si158_instit bigint
        );


        ALTER TABLE consid102020 OWNER TO dbportal;


        CREATE SEQUENCE consid102020_si158_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE consid102020_si158_sequencial_seq OWNER TO dbportal;


        CREATE TABLE consor102020 (
            si16_sequencial bigint DEFAULT 0 NOT NULL,
            si16_tiporegistro bigint DEFAULT 0 NOT NULL,
            si16_codorgao character varying(2) NOT NULL,
            si16_cnpjconsorcio character varying(14) NOT NULL,
            si16_areaatuacao character varying(2) NOT NULL,
            si16_descareaatuacao character varying(150),
            si16_mes bigint DEFAULT 0 NOT NULL,
            si16_instit bigint DEFAULT 0
        );


        ALTER TABLE consor102020 OWNER TO dbportal;


        CREATE SEQUENCE consor102020_si16_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE consor102020_si16_sequencial_seq OWNER TO dbportal;


        CREATE TABLE consor202020 (
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


        ALTER TABLE consor202020 OWNER TO dbportal;


        CREATE SEQUENCE consor202020_si17_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE consor202020_si17_sequencial_seq OWNER TO dbportal;


        CREATE TABLE consor302020 (
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


        ALTER TABLE consor302020 OWNER TO dbportal;


        CREATE SEQUENCE consor302020_si18_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE consor302020_si18_sequencial_seq OWNER TO dbportal;


        CREATE TABLE consor402020 (
            si19_sequencial bigint DEFAULT 0 NOT NULL,
            si19_tiporegistro bigint DEFAULT 0 NOT NULL,
            si19_cnpjconsorcio character varying(14) NOT NULL,
            si19_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si19_vldispcaixa double precision DEFAULT 0 NOT NULL,
            si19_mes bigint DEFAULT 0 NOT NULL,
            si19_instit bigint DEFAULT 0
        );


        ALTER TABLE consor402020 OWNER TO dbportal;


        CREATE SEQUENCE consor402020_si19_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE consor402020_si19_sequencial_seq OWNER TO dbportal;


        CREATE TABLE consor502020 (
            si20_sequencial bigint DEFAULT 0 NOT NULL,
            si20_tiporegistro bigint DEFAULT 0 NOT NULL,
            si20_codorgao character varying(2) NOT NULL,
            si20_cnpjconsorcio character varying(14) NOT NULL,
            si20_tipoencerramento bigint DEFAULT 0 NOT NULL,
            si20_dtencerramento date NOT NULL,
            si20_mes bigint DEFAULT 0 NOT NULL,
            si20_instit bigint DEFAULT 0
        );


        ALTER TABLE consor502020 OWNER TO dbportal;


        CREATE SEQUENCE consor502020_si20_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE consor502020_si20_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos102020 (
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


        ALTER TABLE contratos102020 OWNER TO dbportal;


        CREATE SEQUENCE contratos102020_si83_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos102020_si83_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos112020 (
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


        ALTER TABLE contratos112020 OWNER TO dbportal;


        CREATE SEQUENCE contratos112020_si84_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos112020_si84_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos122020 (
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


        ALTER TABLE contratos122020 OWNER TO dbportal;


        CREATE SEQUENCE contratos122020_si85_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos122020_si85_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos132020 (
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


        ALTER TABLE contratos132020 OWNER TO dbportal;


        CREATE SEQUENCE contratos132020_si86_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos132020_si86_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos202020 (
            si87_sequencial bigint DEFAULT 0 NOT NULL,
            si87_tiporegistro bigint DEFAULT 0 NOT NULL,
            si87_codaditivo bigint DEFAULT 0 NOT NULL,
            si87_codorgao character varying(2) NOT NULL,
            si87_codunidadesub character varying(8) NOT NULL,
            si87_nrocontrato bigint DEFAULT 0 NOT NULL,
            si87_dtassinaturacontoriginal date,
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


        ALTER TABLE contratos202020 OWNER TO dbportal;


        CREATE SEQUENCE contratos202020_si87_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos202020_si87_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos212020 (
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


        ALTER TABLE contratos212020 OWNER TO dbportal;


        CREATE SEQUENCE contratos212020_si88_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos212020_si88_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos302020 (
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


        ALTER TABLE contratos302020 OWNER TO dbportal;


        CREATE SEQUENCE contratos302020_si89_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos302020_si89_sequencial_seq OWNER TO dbportal;


        CREATE TABLE contratos402020 (
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


        ALTER TABLE contratos402020 OWNER TO dbportal;


        CREATE SEQUENCE contratos402020_si91_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE contratos402020_si91_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conv102020 (
            si92_sequencial bigint DEFAULT 0 NOT NULL,
            si92_tiporegistro bigint DEFAULT 0 NOT NULL,
            si92_codconvenio bigint DEFAULT 0 NOT NULL,
            si92_codorgao character varying(2) NOT NULL,
            si92_nroconvenio character varying(30) NOT NULL,
            si92_dataassinatura date NOT NULL,
            si92_objetoconvenio character varying(500) NOT NULL,
            si92_datainiciovigencia date NOT NULL,
            si92_datafinalvigencia date NOT NULL,
            si92_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si92_vlconvenio double precision DEFAULT 0 NOT NULL,
            si92_vlcontrapartida double precision DEFAULT 0 NOT NULL,
            si92_mes bigint DEFAULT 0 NOT NULL,
            si92_instit bigint DEFAULT 0
        );


        ALTER TABLE conv102020 OWNER TO dbportal;


        CREATE SEQUENCE conv102020_si92_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conv102020_si92_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conv112020 (
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


        ALTER TABLE conv112020 OWNER TO dbportal;


        CREATE SEQUENCE conv112020_si93_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conv112020_si93_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conv202020 (
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


        ALTER TABLE conv202020 OWNER TO dbportal;


        CREATE SEQUENCE conv202020_si94_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conv202020_si94_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conv302020 (
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


        ALTER TABLE conv302020 OWNER TO dbportal;


        CREATE SEQUENCE conv302020_si203_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conv302020_si203_sequencial_seq OWNER TO dbportal;


        CREATE TABLE conv312020 (
            si204_sequencial bigint DEFAULT 0 NOT NULL,
            si204_tiporegistro bigint DEFAULT 0 NOT NULL,
            si204_codreceita bigint DEFAULT 0 NOT NULL,
            si204_prevorcamentoassin bigint DEFAULT 0 NOT NULL,
            si204_nroconvenio character varying(30),
            si204_dataassinatura date,
            si204_vlprevisaoconvenio double precision DEFAULT 0 NOT NULL,
            si204_mes bigint DEFAULT 0 NOT NULL,
            si204_instit bigint DEFAULT 0
        );


        ALTER TABLE conv312020 OWNER TO dbportal;


        CREATE SEQUENCE conv312020_si204_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE conv312020_si204_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cronem102020 (
            si170_sequencial bigint DEFAULT 0 NOT NULL,
            si170_tiporegistro bigint DEFAULT 0 NOT NULL,
            si170_codorgao character varying(2) DEFAULT 0 NOT NULL,
            si170_codunidadesub character varying(8) DEFAULT 0 NOT NULL,
            si170_grupodespesa bigint DEFAULT 0 NOT NULL,
            si170_vldotmensal double precision DEFAULT 0 NOT NULL,
            si170_instit bigint DEFAULT 0,
            si170_mes bigint
        );


        ALTER TABLE cronem102020 OWNER TO dbportal;


        CREATE SEQUENCE cronem102020_si170_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cronem102020_si170_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb102020 (
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


        ALTER TABLE ctb102020 OWNER TO dbportal;


        CREATE SEQUENCE ctb102020_si95_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb102020_si95_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb202020 (
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


        ALTER TABLE ctb202020 OWNER TO dbportal;


        CREATE SEQUENCE ctb202020_si96_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb202020_si96_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb212020 (
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


        ALTER TABLE ctb212020 OWNER TO dbportal;


        CREATE SEQUENCE ctb212020_si97_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb212020_si97_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb222020 (
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


        ALTER TABLE ctb222020 OWNER TO dbportal;


        CREATE SEQUENCE ctb222020_si98_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb222020_si98_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb302020 (
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


        ALTER TABLE ctb302020 OWNER TO dbportal;


        CREATE SEQUENCE ctb302020_si99_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb302020_si99_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb312020 (
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


        ALTER TABLE ctb312020 OWNER TO dbportal;


        CREATE SEQUENCE ctb312020_si100_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb312020_si100_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb402020 (
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


        ALTER TABLE ctb402020 OWNER TO dbportal;


        CREATE SEQUENCE ctb402020_si101_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb402020_si101_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ctb502020 (
            si102_sequencial bigint DEFAULT 0 NOT NULL,
            si102_tiporegistro bigint DEFAULT 0 NOT NULL,
            si102_codorgao character varying(2) NOT NULL,
            si102_codctb bigint DEFAULT 0 NOT NULL,
            si102_situacaoconta character varying(1) NOT NULL,
            si102_datasituacao date NOT NULL,
            si102_mes bigint DEFAULT 0 NOT NULL,
            si102_instit bigint DEFAULT 0
        );


        ALTER TABLE ctb502020 OWNER TO dbportal;


        CREATE SEQUENCE ctb502020_si102_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ctb502020_si102_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cute102020 (
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


        ALTER TABLE cute102020 OWNER TO dbportal;


        CREATE SEQUENCE cute102020_si199_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cute102020_si199_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cute202020 (
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


        ALTER TABLE cute202020 OWNER TO dbportal;


        CREATE SEQUENCE cute202020_si200_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cute202020_si200_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cute212020 (
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


        ALTER TABLE cute212020 OWNER TO dbportal;


        CREATE SEQUENCE cute212020_si201_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cute212020_si201_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cute302020 (
            si202_sequencial bigint DEFAULT 0 NOT NULL,
            si202_tiporegistro bigint DEFAULT 0 NOT NULL,
            si202_codorgao character varying(2) NOT NULL,
            si202_codctb bigint DEFAULT 0 NOT NULL,
            si202_situacaoconta character varying(1) NOT NULL,
            si202_datasituacao date NOT NULL,
            si202_mes bigint DEFAULT 0 NOT NULL,
            si202_instit bigint DEFAULT 0
        );


        ALTER TABLE cute302020 OWNER TO dbportal;


        CREATE SEQUENCE cute302020_si202_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cute302020_si202_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cvc102020 (
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


        ALTER TABLE cvc102020 OWNER TO dbportal;


        CREATE SEQUENCE cvc102020_si146_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cvc102020_si146_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cvc202020 (
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


        ALTER TABLE cvc202020 OWNER TO dbportal;


        CREATE SEQUENCE cvc202020_si147_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cvc202020_si147_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cvc302020 (
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


        ALTER TABLE cvc302020 OWNER TO dbportal;


        CREATE SEQUENCE cvc302020_si148_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cvc302020_si148_sequencial_seq OWNER TO dbportal;


        CREATE TABLE cvc402020 (
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


        ALTER TABLE cvc402020 OWNER TO dbportal;


        CREATE SEQUENCE cvc402020_si149_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE cvc402020_si149_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dclrf102020 (
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


        ALTER TABLE dclrf102020 OWNER TO dbportal;


        CREATE SEQUENCE dclrf102020_si157_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dclrf102020_si157_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dclrf112020 (
            si205_sequencial bigint DEFAULT 0 NOT NULL,
            si205_tiporegistro bigint DEFAULT 0 NOT NULL,
            si205_medidasadotadas bigint DEFAULT 0 NOT NULL,
            si205_dscmedidasadotadas character varying(4000),
            si205_reg10 bigint DEFAULT 0 NOT NULL,
            si205_mes bigint DEFAULT 0 NOT NULL,
            si205_instit bigint DEFAULT 0 NOT NULL
        );


        ALTER TABLE dclrf112020 OWNER TO dbportal;


        CREATE SEQUENCE dclrf112020_si205_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dclrf112020_si205_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dclrf202020 (
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


        ALTER TABLE dclrf202020 OWNER TO dbportal;


        CREATE SEQUENCE dclrf202020_si191_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dclrf202020_si191_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dclrf302020 (
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


        ALTER TABLE dclrf302020 OWNER TO dbportal;


        CREATE SEQUENCE dclrf302020_si192_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dclrf302020_si192_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dclrf402020 (
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


        ALTER TABLE dclrf402020 OWNER TO dbportal;


        CREATE SEQUENCE dclrf402020_si193_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dclrf402020_si193_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ddc102020 (
            si150_sequencial bigint DEFAULT 0 NOT NULL,
            si150_tiporegistro bigint DEFAULT 0 NOT NULL,
            si150_codorgao character varying(2) NOT NULL,
            si150_nroleiautorizacao character varying(6) DEFAULT '0'::character varying NOT NULL,
            si150_dtleiautorizacao date NOT NULL,
            si150_dtpublicacaoleiautorizacao date NOT NULL,
            si150_mes bigint DEFAULT 0 NOT NULL,
            si150_instit bigint DEFAULT 0
        );


        ALTER TABLE ddc102020 OWNER TO dbportal;


        CREATE SEQUENCE ddc102020_si150_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ddc102020_si150_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ddc202020 (
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


        ALTER TABLE ddc202020 OWNER TO dbportal;


        CREATE SEQUENCE ddc202020_si153_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ddc202020_si153_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ddc302020 (
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


        ALTER TABLE ddc302020 OWNER TO dbportal;


        CREATE SEQUENCE ddc302020_si154_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ddc302020_si154_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ddc402020 (
            si178_sequencial bigint DEFAULT 0 NOT NULL,
            si178_tiporegistro bigint DEFAULT 0 NOT NULL,
            si178_codorgao character varying(2) NOT NULL,
            si178_passivoatuarial bigint DEFAULT 0 NOT NULL,
            si178_vlsaldoanterior double precision DEFAULT 0 NOT NULL,
            si178_vlsaldoatual double precision DEFAULT 0,
            si178_mes bigint DEFAULT 0 NOT NULL,
            si178_instit bigint DEFAULT 0
        );


        ALTER TABLE ddc402020 OWNER TO dbportal;


        CREATE SEQUENCE ddc402020_si178_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ddc402020_si178_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa102020 (
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


        ALTER TABLE dispensa102020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa102020_si74_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa102020_si74_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa112020 (
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


        ALTER TABLE dispensa112020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa112020_si75_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa112020_si75_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa122020 (
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


        ALTER TABLE dispensa122020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa122020_si76_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa122020_si76_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa132020 (
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


        ALTER TABLE dispensa132020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa132020_si77_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa132020_si77_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa142020 (
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


        ALTER TABLE dispensa142020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa142020_si78_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa142020_si78_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa152020 (
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


        ALTER TABLE dispensa152020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa152020_si79_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa152020_si79_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa162020 (
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


        ALTER TABLE dispensa162020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa162020_si80_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa162020_si80_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa172020 (
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


        ALTER TABLE dispensa172020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa172020_si81_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa172020_si81_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dispensa182020 (
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


        ALTER TABLE dispensa182020 OWNER TO dbportal;


        CREATE SEQUENCE dispensa182020_si82_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dispensa182020_si82_sequencial_seq OWNER TO dbportal;


        CREATE TABLE emp102020 (
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


        ALTER TABLE emp102020 OWNER TO dbportal;


        CREATE SEQUENCE emp102020_si106_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE emp102020_si106_sequencial_seq OWNER TO dbportal;


        CREATE TABLE emp112020 (
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


        ALTER TABLE emp112020 OWNER TO dbportal;


        CREATE SEQUENCE emp112020_si107_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE emp112020_si107_sequencial_seq OWNER TO dbportal;


        CREATE TABLE emp122020 (
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


        ALTER TABLE emp122020 OWNER TO dbportal;


        CREATE SEQUENCE emp122020_si108_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE emp122020_si108_sequencial_seq OWNER TO dbportal;


        CREATE TABLE emp202020 (
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


        ALTER TABLE emp202020 OWNER TO dbportal;


        CREATE SEQUENCE emp202020_si109_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE emp202020_si109_sequencial_seq OWNER TO dbportal;


        CREATE TABLE emp302020 (
            si206_sequencial bigint DEFAULT 0 NOT NULL,
            si206_tiporegistro bigint DEFAULT 0 NOT NULL,
            si206_codorgao character varying(2) NOT NULL,
            si206_codunidadesub character varying(8) NOT NULL,
            si206_nroempenho bigint DEFAULT 0 NOT NULL,
            si206_dtempenho date NOT NULL,
            si206_codorgaorespcontrato character varying(2) DEFAULT NULL::character varying,
            si206_codunidadesubrespcontrato character varying(8) DEFAULT NULL::character varying,
            si206_nrocontrato bigint DEFAULT 0,
            si206_dtassinaturacontrato date,
            si206_nrosequencialtermoaditivo bigint DEFAULT 0,
            si206_nroconvenio character varying(30) DEFAULT NULL::character varying,
            si206_dtassinaturaconvenio date,
            si206_nroconvenioconge character varying(30) DEFAULT NULL::character varying,
            si206_dtassinaturaconge date,
            si206_mes bigint DEFAULT 0 NOT NULL,
            si206_instit bigint DEFAULT 0
        );


        ALTER TABLE emp302020 OWNER TO dbportal;


        CREATE SEQUENCE emp302020_si206_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE emp302020_si206_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ext102020 (
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


        ALTER TABLE ext102020 OWNER TO dbportal;


        CREATE SEQUENCE ext102020_si124_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ext102020_si124_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ext202020 (
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


        ALTER TABLE ext202020 OWNER TO dbportal;


        CREATE SEQUENCE ext202020_si165_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ext202020_si165_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ext302020 (
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


        ALTER TABLE ext302020 OWNER TO dbportal;


        CREATE SEQUENCE ext302020_si126_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ext302020_si126_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ext312020 (
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


        ALTER TABLE ext312020 OWNER TO dbportal;


        CREATE SEQUENCE ext312020_si127_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ext312020_si127_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ext322020 (
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


        ALTER TABLE ext322020 OWNER TO dbportal;


        CREATE SEQUENCE ext322020_si128_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ext322020_si128_sequencial_seq OWNER TO dbportal;


        CREATE TABLE hablic102020 (
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


        ALTER TABLE hablic102020 OWNER TO dbportal;


        CREATE SEQUENCE hablic102020_si57_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE hablic102020_si57_sequencial_seq OWNER TO dbportal;


        CREATE TABLE hablic112020 (
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


        ALTER TABLE hablic112020 OWNER TO dbportal;


        CREATE SEQUENCE hablic112020_si58_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE hablic112020_si58_sequencial_seq OWNER TO dbportal;


        CREATE TABLE hablic202020 (
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


        ALTER TABLE hablic202020 OWNER TO dbportal;


        CREATE SEQUENCE hablic202020_si59_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE hablic202020_si59_sequencial_seq OWNER TO dbportal;


        CREATE TABLE homolic102020 (
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


        ALTER TABLE homolic102020 OWNER TO dbportal;


        CREATE SEQUENCE homolic102020_si63_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE homolic102020_si63_sequencial_seq OWNER TO dbportal;


        CREATE TABLE homolic202020 (
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


        ALTER TABLE homolic202020 OWNER TO dbportal;


        CREATE SEQUENCE homolic202020_si64_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE homolic202020_si64_sequencial_seq OWNER TO dbportal;


        CREATE TABLE homolic302020 (
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


        ALTER TABLE homolic302020 OWNER TO dbportal;


        CREATE SEQUENCE homolic302020_si65_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE homolic302020_si65_sequencial_seq OWNER TO dbportal;


        CREATE TABLE homolic402020 (
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


        ALTER TABLE homolic402020 OWNER TO dbportal;


        CREATE SEQUENCE homolic402020_si65_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE homolic402020_si65_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ide2020 (
            si11_sequencial bigint DEFAULT 0 NOT NULL,
            si11_codmunicipio character varying(5) NOT NULL,
            si11_cnpjmunicipio character varying(14) NOT NULL,
            si11_codorgao character varying(3) NOT NULL,
            si11_tipoorgao character varying(2) NOT NULL,
            si11_exercicioreferencia bigint DEFAULT 0 NOT NULL,
            si11_mesreferencia character varying(2) NOT NULL,
            si11_datageracao date NOT NULL,
            si11_codcontroleremessa character varying(20),
            si11_mes bigint DEFAULT 0 NOT NULL,
            si11_instit bigint DEFAULT 0
        );


        ALTER TABLE ide2020 OWNER TO dbportal;


        CREATE SEQUENCE ide2020_si11_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ide2020_si11_sequencial_seq OWNER TO dbportal;


        CREATE SEQUENCE idedcasp2020_si200_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        CREATE TABLE iderp102020 (
            si179_sequencial bigint DEFAULT 0 NOT NULL,
            si179_tiporegistro bigint DEFAULT 0 NOT NULL,
            si179_codiderp bigint DEFAULT 0 NOT NULL,
            si179_codorgao character varying(2) DEFAULT 0 NOT NULL,
            si179_codunidadesub character varying(8) DEFAULT 0 NOT NULL,
            si179_nroempenho bigint DEFAULT 0 NOT NULL,
            si179_tiporestospagar bigint DEFAULT 0 NOT NULL,
            si179_disponibilidadecaixa bigint DEFAULT 0 NOT NULL,
            si179_vlinscricao double precision DEFAULT 0 NOT NULL,
            si179_instit bigint DEFAULT 0,
            si179_mes bigint DEFAULT 0 NOT NULL
        );


        ALTER TABLE iderp102020 OWNER TO dbportal;


        CREATE SEQUENCE iderp102020_si179_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE iderp102020_si179_sequencial_seq OWNER TO dbportal;


        CREATE TABLE iderp112020 (
            si180_sequencial bigint DEFAULT 0 NOT NULL,
            si180_tiporegistro bigint DEFAULT 0 NOT NULL,
            si180_codiderp bigint DEFAULT 0 NOT NULL,
            si180_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si180_vlinscricaofonte double precision DEFAULT 0 NOT NULL,
            si180_mes bigint DEFAULT 0 NOT NULL,
            si180_reg10 bigint DEFAULT 0 NOT NULL,
            si180_instit bigint DEFAULT 0
        );


        ALTER TABLE iderp112020 OWNER TO dbportal;


        CREATE SEQUENCE iderp112020_si180_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE iderp112020_si180_sequencial_seq OWNER TO dbportal;


        CREATE TABLE iderp202020 (
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


        ALTER TABLE iderp202020 OWNER TO dbportal;


        CREATE SEQUENCE iderp202020_si181_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE iderp202020_si181_sequencial_seq OWNER TO dbportal;


        CREATE TABLE item102020 (
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


        ALTER TABLE item102020 OWNER TO dbportal;


        CREATE SEQUENCE item102020_si43_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE item102020_si43_sequencial_seq OWNER TO dbportal;


        CREATE TABLE julglic102020 (
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


        ALTER TABLE julglic102020 OWNER TO dbportal;


        CREATE SEQUENCE julglic102020_si60_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE julglic102020_si60_sequencial_seq OWNER TO dbportal;


        CREATE TABLE julglic202020 (
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


        ALTER TABLE julglic202020 OWNER TO dbportal;


        CREATE SEQUENCE julglic202020_si61_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE julglic202020_si61_sequencial_seq OWNER TO dbportal;


        CREATE TABLE julglic302020 (
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


        ALTER TABLE julglic302020 OWNER TO dbportal;


        CREATE SEQUENCE julglic302020_si62_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE julglic302020_si62_sequencial_seq OWNER TO dbportal;


        CREATE TABLE julglic402020 (
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


        ALTER TABLE julglic402020 OWNER TO dbportal;


        CREATE SEQUENCE julglic402020_si62_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE julglic402020_si62_sequencial_seq OWNER TO dbportal;


        CREATE TABLE lao102020 (
            si34_sequencial bigint DEFAULT 0 NOT NULL,
            si34_tiporegistro bigint DEFAULT 0 NOT NULL,
            si34_codorgao character varying(2) NOT NULL,
            si34_nroleialteracao bigint NOT NULL,
            si34_dataleialteracao date NOT NULL,
            si34_mes bigint DEFAULT 0 NOT NULL,
            si34_instit bigint DEFAULT 0
        );


        ALTER TABLE lao102020 OWNER TO dbportal;


        CREATE SEQUENCE lao102020_si34_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE lao102020_si34_sequencial_seq OWNER TO dbportal;


        CREATE TABLE lao112020 (
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


        ALTER TABLE lao112020 OWNER TO dbportal;


        CREATE SEQUENCE lao112020_si35_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE lao112020_si35_sequencial_seq OWNER TO dbportal;


        CREATE TABLE lao202020 (
            si36_sequencial bigint DEFAULT 0 NOT NULL,
            si36_tiporegistro bigint DEFAULT 0 NOT NULL,
            si36_codorgao character varying(2) NOT NULL,
            si36_nroleialterorcam character varying(6) NOT NULL,
            si36_dataleialterorcam date NOT NULL,
            si36_mes bigint DEFAULT 0 NOT NULL,
            si36_instit bigint DEFAULT 0
        );


        ALTER TABLE lao202020 OWNER TO dbportal;


        CREATE SEQUENCE lao202020_si36_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE lao202020_si36_sequencial_seq OWNER TO dbportal;


        CREATE TABLE lao212020 (
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


        ALTER TABLE lao212020 OWNER TO dbportal;


        CREATE SEQUENCE lao212020_si37_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE lao212020_si37_sequencial_seq OWNER TO dbportal;


        CREATE TABLE lqd102020 (
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


        ALTER TABLE lqd102020 OWNER TO dbportal;


        CREATE SEQUENCE lqd102020_si118_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE lqd102020_si118_sequencial_seq OWNER TO dbportal;


        CREATE TABLE lqd112020 (
            si119_sequencial bigint DEFAULT 0 NOT NULL,
            si119_tiporegistro bigint DEFAULT 0 NOT NULL,
            si119_codreduzido bigint DEFAULT 0 NOT NULL,
            si119_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si119_valorfonte double precision DEFAULT 0 NOT NULL,
            si119_mes bigint DEFAULT 0 NOT NULL,
            si119_reg10 bigint DEFAULT 0 NOT NULL,
            si119_instit bigint DEFAULT 0
        );


        ALTER TABLE lqd112020 OWNER TO dbportal;


        CREATE SEQUENCE lqd112020_si119_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE lqd112020_si119_sequencial_seq OWNER TO dbportal;


        CREATE TABLE lqd122020 (
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


        ALTER TABLE lqd122020 OWNER TO dbportal;


        CREATE SEQUENCE lqd122020_si120_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE lqd122020_si120_sequencial_seq OWNER TO dbportal;


        CREATE TABLE metareal102020 (
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
            si171_instit bigint DEFAULT 0,
            si171_mes integer
        );


        ALTER TABLE metareal102020 OWNER TO dbportal;


        CREATE SEQUENCE metareal102020_si171_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE metareal102020_si171_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ntf102020 (
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


        ALTER TABLE ntf102020 OWNER TO dbportal;


        CREATE SEQUENCE ntf102020_si143_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ntf102020_si143_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ntf112020 (
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


        ALTER TABLE ntf112020 OWNER TO dbportal;


        CREATE SEQUENCE ntf112020_si144_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ntf112020_si144_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ntf202020 (
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


        ALTER TABLE ntf202020 OWNER TO dbportal;


        CREATE SEQUENCE ntf202020_si145_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ntf202020_si145_sequencial_seq OWNER TO dbportal;


        CREATE TABLE obelac102020 (
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


        ALTER TABLE obelac102020 OWNER TO dbportal;


        CREATE SEQUENCE obelac102020_si139_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE obelac102020_si139_sequencial_seq OWNER TO dbportal;


        CREATE TABLE obelac112020 (
            si140_sequencial bigint DEFAULT 0 NOT NULL,
            si140_tiporegistro bigint DEFAULT 0 NOT NULL,
            si140_codreduzido bigint DEFAULT 0 NOT NULL,
            si140_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si140_valorfonte double precision DEFAULT 0 NOT NULL,
            si140_mes bigint DEFAULT 0 NOT NULL,
            si140_reg10 bigint DEFAULT 0 NOT NULL,
            si140_instit bigint DEFAULT 0
        );


        ALTER TABLE obelac112020 OWNER TO dbportal;


        CREATE SEQUENCE obelac112020_si140_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE obelac112020_si140_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ops102020 (
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


        ALTER TABLE ops102020 OWNER TO dbportal;


        CREATE SEQUENCE ops102020_si132_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ops102020_si132_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ops112020 (
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


        ALTER TABLE ops112020 OWNER TO dbportal;


        CREATE SEQUENCE ops112020_si133_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ops112020_si133_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ops122020 (
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


        ALTER TABLE ops122020 OWNER TO dbportal;


        CREATE SEQUENCE ops122020_si134_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ops122020_si134_sequencial_seq OWNER TO dbportal;


        CREATE TABLE ops132020 (
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


        ALTER TABLE ops132020 OWNER TO dbportal;


        CREATE SEQUENCE ops132020_si135_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE ops132020_si135_sequencial_seq OWNER TO dbportal;


        CREATE TABLE orgao102020 (
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


        ALTER TABLE orgao102020 OWNER TO dbportal;


        CREATE SEQUENCE orgao102020_si14_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE orgao102020_si14_sequencial_seq OWNER TO dbportal;


        CREATE TABLE orgao112020 (
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


        ALTER TABLE orgao112020 OWNER TO dbportal;


        CREATE SEQUENCE orgao112020_si15_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE orgao112020_si15_sequencial_seq OWNER TO dbportal;


        CREATE TABLE parec102020 (
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


        ALTER TABLE parec102020 OWNER TO dbportal;


        CREATE SEQUENCE parec102020_si22_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE parec102020_si22_sequencial_seq OWNER TO dbportal;


        CREATE SEQUENCE parec102020_si66_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE parec102020_si66_sequencial_seq OWNER TO dbportal;


        CREATE TABLE parec112020 (
            si23_sequencial bigint DEFAULT 0 NOT NULL,
            si23_tiporegistro bigint DEFAULT 0 NOT NULL,
            si23_codreduzido bigint DEFAULT 0 NOT NULL,
            si23_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si23_vlfonte double precision DEFAULT 0 NOT NULL,
            si23_reg10 bigint DEFAULT 0 NOT NULL,
            si23_mes bigint DEFAULT 0 NOT NULL,
            si23_instit bigint DEFAULT 0
        );


        ALTER TABLE parec112020 OWNER TO dbportal;


        CREATE SEQUENCE parec112020_si23_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE parec112020_si23_sequencial_seq OWNER TO dbportal;


        CREATE TABLE parelic102020 (
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


        ALTER TABLE parelic102020 OWNER TO dbportal;


        CREATE TABLE parpps102020 (
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


        ALTER TABLE parpps102020 OWNER TO dbportal;


        CREATE SEQUENCE parpps102020_si156_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE parpps102020_si156_sequencial_seq OWNER TO dbportal;


        CREATE TABLE parpps202020 (
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


        ALTER TABLE parpps202020 OWNER TO dbportal;


        CREATE SEQUENCE parpps202020_si155_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE parpps202020_si155_sequencial_seq OWNER TO dbportal;


        CREATE TABLE pessoa102020 (
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


        ALTER TABLE pessoa102020 OWNER TO dbportal;


        CREATE SEQUENCE pessoa102020_si12_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE pessoa102020_si12_sequencial_seq OWNER TO dbportal;


        CREATE TABLE pessoaflpgo102020 (
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


        ALTER TABLE pessoaflpgo102020 OWNER TO dbportal;


        CREATE SEQUENCE pessoaflpgo102020_si193_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE pessoaflpgo102020_si193_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rec102020 (
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


        ALTER TABLE rec102020 OWNER TO dbportal;


        CREATE SEQUENCE rec102020_si25_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rec102020_si25_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rec112020 (
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


        ALTER TABLE rec112020 OWNER TO dbportal;


        CREATE SEQUENCE rec112020_si26_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rec112020_si26_sequencial_seq OWNER TO dbportal;


        CREATE TABLE regadesao102020 (
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


        ALTER TABLE regadesao102020 OWNER TO dbportal;


        CREATE SEQUENCE regadesao102020_si67_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE regadesao102020_si67_sequencial_seq OWNER TO dbportal;


        CREATE TABLE regadesao112020 (
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


        ALTER TABLE regadesao112020 OWNER TO dbportal;


        CREATE SEQUENCE regadesao112020_si68_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE regadesao112020_si68_sequencial_seq OWNER TO dbportal;


        CREATE TABLE regadesao122020 (
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


        ALTER TABLE regadesao122020 OWNER TO dbportal;


        CREATE SEQUENCE regadesao122020_si69_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE regadesao122020_si69_sequencial_seq OWNER TO dbportal;


        CREATE TABLE regadesao132020 (
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


        ALTER TABLE regadesao132020 OWNER TO dbportal;


        CREATE SEQUENCE regadesao132020_si70_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE regadesao132020_si70_sequencial_seq OWNER TO dbportal;


        CREATE TABLE regadesao142020 (
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


        ALTER TABLE regadesao142020 OWNER TO dbportal;


        CREATE SEQUENCE regadesao142020_si71_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE regadesao142020_si71_sequencial_seq OWNER TO dbportal;


        CREATE TABLE regadesao152020 (
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


        ALTER TABLE regadesao152020 OWNER TO dbportal;


        CREATE SEQUENCE regadesao152020_si72_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE regadesao152020_si72_sequencial_seq OWNER TO dbportal;


        CREATE TABLE regadesao202020 (
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


        ALTER TABLE regadesao202020 OWNER TO dbportal;


        CREATE SEQUENCE regadesao202020_si73_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE regadesao202020_si73_sequencial_seq OWNER TO dbportal;


        CREATE TABLE reglic102020 (
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


        ALTER TABLE reglic102020 OWNER TO dbportal;


        CREATE SEQUENCE reglic102020_si44_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE reglic102020_si44_sequencial_seq OWNER TO dbportal;


        CREATE TABLE reglic202020 (
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


        ALTER TABLE reglic202020 OWNER TO dbportal;


        CREATE SEQUENCE reglic202020_si45_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE reglic202020_si45_sequencial_seq OWNER TO dbportal;


        CREATE TABLE resplic102020 (
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


        ALTER TABLE resplic102020 OWNER TO dbportal;


        CREATE SEQUENCE resplic102020_si55_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE resplic102020_si55_sequencial_seq OWNER TO dbportal;


        CREATE TABLE resplic202020 (
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


        ALTER TABLE resplic202020 OWNER TO dbportal;


        CREATE SEQUENCE resplic202020_si56_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE resplic202020_si56_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rsp102020 (
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


        ALTER TABLE rsp102020 OWNER TO dbportal;


        CREATE SEQUENCE rsp102020_si112_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rsp102020_si112_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rsp112020 (
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


        ALTER TABLE rsp112020 OWNER TO dbportal;


        CREATE SEQUENCE rsp112020_si113_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rsp112020_si113_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rsp122020 (
            si114_sequencial bigint DEFAULT 0 NOT NULL,
            si114_tiporegistro bigint DEFAULT 0 NOT NULL,
            si114_codreduzidorsp bigint DEFAULT 0 NOT NULL,
            si114_tipodocumento bigint DEFAULT 0 NOT NULL,
            si114_nrodocumento character varying(14) NOT NULL,
            si114_mes bigint DEFAULT 0 NOT NULL,
            si114_reg10 bigint DEFAULT 0 NOT NULL,
            si114_instit bigint DEFAULT 0
        );


        ALTER TABLE rsp122020 OWNER TO dbportal;


        CREATE SEQUENCE rsp122020_si114_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rsp122020_si114_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rsp202020 (
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


        ALTER TABLE rsp202020 OWNER TO dbportal;


        CREATE SEQUENCE rsp202020_si115_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rsp202020_si115_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rsp212020 (
            si116_sequencial bigint DEFAULT 0 NOT NULL,
            si116_tiporegistro bigint DEFAULT 0 NOT NULL,
            si116_codreduzidomov bigint DEFAULT 0 NOT NULL,
            si116_codfontrecursos bigint DEFAULT 0 NOT NULL,
            si116_vlmovimentacaofonte double precision DEFAULT 0 NOT NULL,
            si116_mes bigint DEFAULT 0 NOT NULL,
            si116_reg20 bigint DEFAULT 0 NOT NULL,
            si116_instit bigint DEFAULT 0
        );


        ALTER TABLE rsp212020 OWNER TO dbportal;


        CREATE SEQUENCE rsp212020_si116_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rsp212020_si116_sequencial_seq OWNER TO dbportal;


        CREATE TABLE rsp222020 (
            si117_sequencial bigint DEFAULT 0 NOT NULL,
            si117_tiporegistro bigint DEFAULT 0 NOT NULL,
            si117_codreduzidomov bigint DEFAULT 0 NOT NULL,
            si117_tipodocumento bigint DEFAULT 0 NOT NULL,
            si117_nrodocumento character varying(14) NOT NULL,
            si117_mes bigint DEFAULT 0 NOT NULL,
            si117_reg20 bigint DEFAULT 0 NOT NULL,
            si117_instit bigint DEFAULT 0
        );


        ALTER TABLE rsp222020 OWNER TO dbportal;


        CREATE SEQUENCE rsp222020_si117_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE rsp222020_si117_sequencial_seq OWNER TO dbportal;


        CREATE TABLE tce102020 (
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


        ALTER TABLE tce102020 OWNER TO dbportal;


        CREATE SEQUENCE tce102020_si187_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE tce102020_si187_sequencial_seq OWNER TO dbportal;


        CREATE TABLE tce112020 (
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


        ALTER TABLE tce112020 OWNER TO dbportal;


        CREATE SEQUENCE tce112020_si188_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE tce112020_si188_sequencial_seq OWNER TO dbportal;


        ALTER TABLE ONLY aberlic102020
        ADD CONSTRAINT aberlic102020_sequ_pk PRIMARY KEY (si46_sequencial);



        ALTER TABLE ONLY aberlic112020
        ADD CONSTRAINT aberlic112020_sequ_pk PRIMARY KEY (si47_sequencial);



        ALTER TABLE ONLY aberlic122020
        ADD CONSTRAINT aberlic122020_sequ_pk PRIMARY KEY (si48_sequencial);



        ALTER TABLE ONLY aberlic132020
        ADD CONSTRAINT aberlic132020_sequ_pk PRIMARY KEY (si49_sequencial);



        ALTER TABLE ONLY aberlic142020
        ADD CONSTRAINT aberlic142020_sequ_pk PRIMARY KEY (si50_sequencial);



        ALTER TABLE ONLY aberlic152020
        ADD CONSTRAINT aberlic152020_sequ_pk PRIMARY KEY (si51_sequencial);



        ALTER TABLE ONLY aberlic162020
        ADD CONSTRAINT aberlic162020_sequ_pk PRIMARY KEY (si52_sequencial);



        ALTER TABLE ONLY aex102020
        ADD CONSTRAINT aex112020_sequ_pk PRIMARY KEY (si130_sequencial);



        ALTER TABLE ONLY alq102020
        ADD CONSTRAINT alq102020_sequ_pk PRIMARY KEY (si121_sequencial);



        ALTER TABLE ONLY alq112020
        ADD CONSTRAINT alq112020_sequ_pk PRIMARY KEY (si122_sequencial);



        ALTER TABLE ONLY alq122020
        ADD CONSTRAINT alq122020_sequ_pk PRIMARY KEY (si123_sequencial);



        ALTER TABLE ONLY anl102020
        ADD CONSTRAINT anl102020_sequ_pk PRIMARY KEY (si110_sequencial);



        ALTER TABLE ONLY anl112020
        ADD CONSTRAINT anl112020_sequ_pk PRIMARY KEY (si111_sequencial);



        ALTER TABLE ONLY aob102020
        ADD CONSTRAINT aob102020_sequ_pk PRIMARY KEY (si141_sequencial);



        ALTER TABLE ONLY aob112020
        ADD CONSTRAINT aob112020_sequ_pk PRIMARY KEY (si142_sequencial);



        ALTER TABLE ONLY aoc102020
        ADD CONSTRAINT aoc102020_sequ_pk PRIMARY KEY (si38_sequencial);



        ALTER TABLE ONLY aoc112020
        ADD CONSTRAINT aoc112020_sequ_pk PRIMARY KEY (si39_sequencial);



        ALTER TABLE ONLY aoc122020
        ADD CONSTRAINT aoc122020_sequ_pk PRIMARY KEY (si40_sequencial);



        ALTER TABLE ONLY aoc132020
        ADD CONSTRAINT aoc132020_sequ_pk PRIMARY KEY (si41_sequencial);



        ALTER TABLE ONLY aoc142020
        ADD CONSTRAINT aoc142020_sequ_pk PRIMARY KEY (si42_sequencial);



        ALTER TABLE ONLY aoc152020
        ADD CONSTRAINT aoc152020_sequ_pk PRIMARY KEY (si194_sequencial);



        ALTER TABLE ONLY aop102020
        ADD CONSTRAINT aop102020_sequ_pk PRIMARY KEY (si137_sequencial);



        ALTER TABLE ONLY aop112020
        ADD CONSTRAINT aop112020_sequ_pk PRIMARY KEY (si138_sequencial);



        ALTER TABLE ONLY arc102020
        ADD CONSTRAINT arc102020_sequ_pk PRIMARY KEY (si28_sequencial);



        ALTER TABLE ONLY arc112020
        ADD CONSTRAINT arc112020_sequ_pk PRIMARY KEY (si29_sequencial);



        ALTER TABLE ONLY arc122020
        ADD CONSTRAINT arc122020_sequ_pk PRIMARY KEY (si30_sequencial);



        ALTER TABLE ONLY arc202020
        ADD CONSTRAINT arc202020_sequ_pk PRIMARY KEY (si31_sequencial);



        ALTER TABLE ONLY arc212020
        ADD CONSTRAINT arc212020_sequ_pk PRIMARY KEY (si32_sequencial);



        ALTER TABLE ONLY caixa102020
        ADD CONSTRAINT caixa102020_sequ_pk PRIMARY KEY (si103_sequencial);



        ALTER TABLE ONLY caixa112020
        ADD CONSTRAINT caixa112020_sequ_pk PRIMARY KEY (si166_sequencial);



        ALTER TABLE ONLY caixa122020
        ADD CONSTRAINT caixa122020_sequ_pk PRIMARY KEY (si104_sequencial);



        ALTER TABLE ONLY caixa132020
        ADD CONSTRAINT caixa132020_sequ_pk PRIMARY KEY (si105_sequencial);



        ALTER TABLE ONLY conge102020
        ADD CONSTRAINT conge102020_sequ_pk PRIMARY KEY (si182_sequencial);



        ALTER TABLE ONLY conge202020
        ADD CONSTRAINT conge202020_sequ_pk PRIMARY KEY (si183_sequencial);



        ALTER TABLE ONLY conge302020
        ADD CONSTRAINT conge302020_sequ_pk PRIMARY KEY (si184_sequencial);



        ALTER TABLE ONLY consid102020
        ADD CONSTRAINT consid102020_sequ_pk PRIMARY KEY (si158_sequencial);



        ALTER TABLE ONLY consor102020
        ADD CONSTRAINT consor102020_sequ_pk PRIMARY KEY (si16_sequencial);



        ALTER TABLE ONLY consor202020
        ADD CONSTRAINT consor202020_sequ_pk PRIMARY KEY (si17_sequencial);



        ALTER TABLE ONLY consor302020
        ADD CONSTRAINT consor302020_sequ_pk PRIMARY KEY (si18_sequencial);



        ALTER TABLE ONLY consor402020
        ADD CONSTRAINT consor402020_sequ_pk PRIMARY KEY (si19_sequencial);



        ALTER TABLE ONLY consor502020
        ADD CONSTRAINT consor502020_sequ_pk PRIMARY KEY (si20_sequencial);



        ALTER TABLE ONLY contratos102020
        ADD CONSTRAINT contratos102020_sequ_pk PRIMARY KEY (si83_sequencial);



        ALTER TABLE ONLY contratos112020
        ADD CONSTRAINT contratos112020_sequ_pk PRIMARY KEY (si84_sequencial);



        ALTER TABLE ONLY contratos122020
        ADD CONSTRAINT contratos122020_sequ_pk PRIMARY KEY (si85_sequencial);



        ALTER TABLE ONLY contratos132020
        ADD CONSTRAINT contratos132020_sequ_pk PRIMARY KEY (si86_sequencial);



        ALTER TABLE ONLY contratos202020
        ADD CONSTRAINT contratos202020_sequ_pk PRIMARY KEY (si87_sequencial);



        ALTER TABLE ONLY contratos212020
        ADD CONSTRAINT contratos212020_sequ_pk PRIMARY KEY (si88_sequencial);



        ALTER TABLE ONLY contratos302020
        ADD CONSTRAINT contratos302020_sequ_pk PRIMARY KEY (si89_sequencial);



        ALTER TABLE ONLY contratos402020
        ADD CONSTRAINT contratos402020_sequ_pk PRIMARY KEY (si91_sequencial);



        ALTER TABLE ONLY conv102020
        ADD CONSTRAINT conv102020_sequ_pk PRIMARY KEY (si92_sequencial);



        ALTER TABLE ONLY conv112020
        ADD CONSTRAINT conv112020_sequ_pk PRIMARY KEY (si93_sequencial);



        ALTER TABLE ONLY conv202020
        ADD CONSTRAINT conv202020_sequ_pk PRIMARY KEY (si94_sequencial);



        ALTER TABLE ONLY cronem102020
        ADD CONSTRAINT cronem102020_sequ_pk PRIMARY KEY (si170_sequencial);



        ALTER TABLE ONLY ctb102020
        ADD CONSTRAINT ctb102020_sequ_pk PRIMARY KEY (si95_sequencial);



        ALTER TABLE ONLY ctb202020
        ADD CONSTRAINT ctb202020_sequ_pk PRIMARY KEY (si96_sequencial);



        ALTER TABLE ONLY ctb212020
        ADD CONSTRAINT ctb212020_sequ_pk PRIMARY KEY (si97_sequencial);



        ALTER TABLE ONLY ctb222020
        ADD CONSTRAINT ctb222020_sequ_pk PRIMARY KEY (si98_sequencial);



        ALTER TABLE ONLY ctb302020
        ADD CONSTRAINT ctb302020_sequ_pk PRIMARY KEY (si99_sequencial);



        ALTER TABLE ONLY ctb312020
        ADD CONSTRAINT ctb312020_sequ_pk PRIMARY KEY (si100_sequencial);



        ALTER TABLE ONLY ctb402020
        ADD CONSTRAINT ctb402020_sequ_pk PRIMARY KEY (si101_sequencial);



        ALTER TABLE ONLY ctb502020
        ADD CONSTRAINT ctb502020_sequ_pk PRIMARY KEY (si102_sequencial);



        ALTER TABLE ONLY cute102020
        ADD CONSTRAINT cute102020_sequ_pk PRIMARY KEY (si199_sequencial);



        ALTER TABLE ONLY cute202020
        ADD CONSTRAINT cute202020_sequ_pk PRIMARY KEY (si200_sequencial);



        ALTER TABLE ONLY cute212020
        ADD CONSTRAINT cute212020_sequ_pk PRIMARY KEY (si201_sequencial);



        ALTER TABLE ONLY cute302020
        ADD CONSTRAINT cute302020_sequ_pk PRIMARY KEY (si202_sequencial);



        ALTER TABLE ONLY cvc102020
        ADD CONSTRAINT cvc102020_sequ_pk PRIMARY KEY (si146_sequencial);



        ALTER TABLE ONLY cvc202020
        ADD CONSTRAINT cvc202020_sequ_pk PRIMARY KEY (si147_sequencial);



        ALTER TABLE ONLY cvc302020
        ADD CONSTRAINT cvc302020_sequ_pk PRIMARY KEY (si148_sequencial);



        ALTER TABLE ONLY cvc402020
        ADD CONSTRAINT cvc402020_sequ_pk PRIMARY KEY (si149_sequencial);



        ALTER TABLE ONLY dclrf102020
        ADD CONSTRAINT dclrf102020_sequ_pk PRIMARY KEY (si157_sequencial);



        ALTER TABLE ONLY dclrf112020
        ADD CONSTRAINT dclrf112020_sequ_pk PRIMARY KEY (si205_sequencial);



        ALTER TABLE ONLY dclrf202020
        ADD CONSTRAINT dclrf202020_sequ_pk PRIMARY KEY (si191_sequencial);



        ALTER TABLE ONLY dclrf302020
        ADD CONSTRAINT dclrf302020_sequ_pk PRIMARY KEY (si192_sequencial);



        ALTER TABLE ONLY dclrf402020
        ADD CONSTRAINT dclrf402020_sequ_pk PRIMARY KEY (si193_sequencial);



        ALTER TABLE ONLY ddc102020
        ADD CONSTRAINT ddc102020_sequ_pk PRIMARY KEY (si150_sequencial);



        ALTER TABLE ONLY ddc202020
        ADD CONSTRAINT ddc202020_sequ_pk PRIMARY KEY (si153_sequencial);



        ALTER TABLE ONLY ddc302020
        ADD CONSTRAINT ddc302020_sequ_pk PRIMARY KEY (si154_sequencial);



        ALTER TABLE ONLY ddc402020
        ADD CONSTRAINT ddc402020_sequ_pk PRIMARY KEY (si178_sequencial);



        ALTER TABLE ONLY dispensa102020
        ADD CONSTRAINT dispensa102020_sequ_pk PRIMARY KEY (si74_sequencial);



        ALTER TABLE ONLY dispensa112020
        ADD CONSTRAINT dispensa112020_sequ_pk PRIMARY KEY (si75_sequencial);



        ALTER TABLE ONLY dispensa122020
        ADD CONSTRAINT dispensa122020_sequ_pk PRIMARY KEY (si76_sequencial);



        ALTER TABLE ONLY dispensa132020
        ADD CONSTRAINT dispensa132020_sequ_pk PRIMARY KEY (si77_sequencial);



        ALTER TABLE ONLY dispensa142020
        ADD CONSTRAINT dispensa142020_sequ_pk PRIMARY KEY (si78_sequencial);



        ALTER TABLE ONLY dispensa152020
        ADD CONSTRAINT dispensa152020_sequ_pk PRIMARY KEY (si79_sequencial);



        ALTER TABLE ONLY dispensa162020
        ADD CONSTRAINT dispensa162020_sequ_pk PRIMARY KEY (si80_sequencial);



        ALTER TABLE ONLY dispensa172020
        ADD CONSTRAINT dispensa172020_sequ_pk PRIMARY KEY (si81_sequencial);



        ALTER TABLE ONLY dispensa182020
        ADD CONSTRAINT dispensa182020_sequ_pk PRIMARY KEY (si82_sequencial);



        ALTER TABLE ONLY emp102020
        ADD CONSTRAINT emp102020_sequ_pk PRIMARY KEY (si106_sequencial);



        ALTER TABLE ONLY emp112020
        ADD CONSTRAINT emp112020_sequ_pk PRIMARY KEY (si107_sequencial);



        ALTER TABLE ONLY emp122020
        ADD CONSTRAINT emp122020_sequ_pk PRIMARY KEY (si108_sequencial);



        ALTER TABLE ONLY emp202020
        ADD CONSTRAINT emp202020_sequ_pk PRIMARY KEY (si109_sequencial);



        ALTER TABLE ONLY emp302020
        ADD CONSTRAINT emp302020_sequ_pk PRIMARY KEY (si206_sequencial);



        ALTER TABLE ONLY ext102020
        ADD CONSTRAINT ext102020_sequ_pk PRIMARY KEY (si124_sequencial);



        ALTER TABLE ONLY ext202020
        ADD CONSTRAINT ext202020_sequ_pk PRIMARY KEY (si165_sequencial);



        ALTER TABLE ONLY ext302020
        ADD CONSTRAINT ext302020_sequ_pk PRIMARY KEY (si126_sequencial);



        ALTER TABLE ONLY ext312020
        ADD CONSTRAINT ext312020_sequ_pk PRIMARY KEY (si127_sequencial);



        ALTER TABLE ONLY ext322020
        ADD CONSTRAINT ext322020_sequ_pk PRIMARY KEY (si128_sequencial);



        ALTER TABLE ONLY hablic102020
        ADD CONSTRAINT hablic102020_sequ_pk PRIMARY KEY (si57_sequencial);



        ALTER TABLE ONLY hablic112020
        ADD CONSTRAINT hablic112020_sequ_pk PRIMARY KEY (si58_sequencial);



        ALTER TABLE ONLY hablic202020
        ADD CONSTRAINT hablic202020_sequ_pk PRIMARY KEY (si59_sequencial);



        ALTER TABLE ONLY homolic102020
        ADD CONSTRAINT homolic102020_sequ_pk PRIMARY KEY (si63_sequencial);



        ALTER TABLE ONLY homolic202020
        ADD CONSTRAINT homolic202020_sequ_pk PRIMARY KEY (si64_sequencial);



        ALTER TABLE ONLY homolic302020
        ADD CONSTRAINT homolic302020_sequ_pk PRIMARY KEY (si65_sequencial);



        ALTER TABLE ONLY homolic402020
        ADD CONSTRAINT homolic402020_sequ_pk PRIMARY KEY (si65_sequencial);



        ALTER TABLE ONLY ide2020
        ADD CONSTRAINT ide2020_sequ_pk PRIMARY KEY (si11_sequencial);



        ALTER TABLE ONLY iderp102020
        ADD CONSTRAINT iderp102020_sequ_pk PRIMARY KEY (si179_sequencial);



        ALTER TABLE ONLY iderp112020
        ADD CONSTRAINT iderp112020_sequ_pk PRIMARY KEY (si180_sequencial);



        ALTER TABLE ONLY iderp202020
        ADD CONSTRAINT iderp202020_sequ_pk PRIMARY KEY (si181_sequencial);



        ALTER TABLE ONLY item102020
        ADD CONSTRAINT item102020_sequ_pk PRIMARY KEY (si43_sequencial);



        ALTER TABLE ONLY julglic102020
        ADD CONSTRAINT julglic102020_sequ_pk PRIMARY KEY (si60_sequencial);



        ALTER TABLE ONLY julglic202020
        ADD CONSTRAINT julglic202020_sequ_pk PRIMARY KEY (si61_sequencial);



        ALTER TABLE ONLY julglic402020
        ADD CONSTRAINT julglic402020_sequ_pk PRIMARY KEY (si62_sequencial);



        ALTER TABLE ONLY lao102020
        ADD CONSTRAINT lao102020_sequ_pk PRIMARY KEY (si34_sequencial);



        ALTER TABLE ONLY lao112020
        ADD CONSTRAINT lao112020_sequ_pk PRIMARY KEY (si35_sequencial);



        ALTER TABLE ONLY lao202020
        ADD CONSTRAINT lao202020_sequ_pk PRIMARY KEY (si36_sequencial);



        ALTER TABLE ONLY lao212020
        ADD CONSTRAINT lao212020_sequ_pk PRIMARY KEY (si37_sequencial);



        ALTER TABLE ONLY lqd102020
        ADD CONSTRAINT lqd102020_sequ_pk PRIMARY KEY (si118_sequencial);



        ALTER TABLE ONLY lqd112020
        ADD CONSTRAINT lqd112020_sequ_pk PRIMARY KEY (si119_sequencial);



        ALTER TABLE ONLY lqd122020
        ADD CONSTRAINT lqd122020_sequ_pk PRIMARY KEY (si120_sequencial);



        ALTER TABLE ONLY metareal102020
        ADD CONSTRAINT metareal102020_sequ_pk PRIMARY KEY (si171_sequencial);



        ALTER TABLE ONLY ntf102020
        ADD CONSTRAINT ntf102020_sequ_pk PRIMARY KEY (si143_sequencial);



        ALTER TABLE ONLY ntf112020
        ADD CONSTRAINT ntf112020_sequ_pk PRIMARY KEY (si144_sequencial);



        ALTER TABLE ONLY ntf202020
        ADD CONSTRAINT ntf202020_sequ_pk PRIMARY KEY (si145_sequencial);



        ALTER TABLE ONLY obelac102020
        ADD CONSTRAINT obelac102020_sequ_pk PRIMARY KEY (si139_sequencial);



        ALTER TABLE ONLY obelac112020
        ADD CONSTRAINT obelac112020_sequ_pk PRIMARY KEY (si140_sequencial);



        ALTER TABLE ONLY ops102020
        ADD CONSTRAINT ops102020_sequ_pk PRIMARY KEY (si132_sequencial);



        ALTER TABLE ONLY ops112020
        ADD CONSTRAINT ops112020_sequ_pk PRIMARY KEY (si133_sequencial);



        ALTER TABLE ONLY ops122020
        ADD CONSTRAINT ops122020_sequ_pk PRIMARY KEY (si134_sequencial);



        ALTER TABLE ONLY ops132020
        ADD CONSTRAINT ops132020_sequ_pk PRIMARY KEY (si135_sequencial);



        ALTER TABLE ONLY orgao102020
        ADD CONSTRAINT orgao102020_sequ_pk PRIMARY KEY (si14_sequencial);



        ALTER TABLE ONLY orgao112020
        ADD CONSTRAINT orgao112020_sequ_pk PRIMARY KEY (si15_sequencial);



        ALTER TABLE ONLY parec102020
        ADD CONSTRAINT parec102020_sequ_pk PRIMARY KEY (si22_sequencial);



        ALTER TABLE ONLY parec112020
        ADD CONSTRAINT parec112020_sequ_pk PRIMARY KEY (si23_sequencial);



        ALTER TABLE ONLY parelic102020
        ADD CONSTRAINT parelic102020_sequ_pk PRIMARY KEY (si66_sequencial);



        ALTER TABLE ONLY parpps102020
        ADD CONSTRAINT parpps102020_sequ_pk PRIMARY KEY (si156_sequencial);



        ALTER TABLE ONLY parpps202020
        ADD CONSTRAINT parpps202020_sequ_pk PRIMARY KEY (si155_sequencial);



        ALTER TABLE ONLY pessoa102020
        ADD CONSTRAINT pessoa102020_sequ_pk PRIMARY KEY (si12_sequencial);



        ALTER TABLE ONLY pessoaflpgo102020
        ADD CONSTRAINT pessoaflpgo102020_sequ_pk PRIMARY KEY (si193_sequencial);



        ALTER TABLE ONLY rec102020
        ADD CONSTRAINT rec102020_sequ_pk PRIMARY KEY (si25_sequencial);



        ALTER TABLE ONLY rec112020
        ADD CONSTRAINT rec112020_sequ_pk PRIMARY KEY (si26_sequencial);



        ALTER TABLE ONLY regadesao102020
        ADD CONSTRAINT regadesao102020_sequ_pk PRIMARY KEY (si67_sequencial);



        ALTER TABLE ONLY regadesao112020
        ADD CONSTRAINT regadesao112020_sequ_pk PRIMARY KEY (si68_sequencial);



        ALTER TABLE ONLY regadesao122020
        ADD CONSTRAINT regadesao122020_sequ_pk PRIMARY KEY (si69_sequencial);



        ALTER TABLE ONLY regadesao132020
        ADD CONSTRAINT regadesao132020_sequ_pk PRIMARY KEY (si70_sequencial);



        ALTER TABLE ONLY regadesao142020
        ADD CONSTRAINT regadesao142020_sequ_pk PRIMARY KEY (si71_sequencial);



        ALTER TABLE ONLY regadesao152020
        ADD CONSTRAINT regadesao152020_sequ_pk PRIMARY KEY (si72_sequencial);



        ALTER TABLE ONLY regadesao202020
        ADD CONSTRAINT regadesao202020_sequ_pk PRIMARY KEY (si73_sequencial);



        ALTER TABLE ONLY reglic102020
        ADD CONSTRAINT reglic102020_sequ_pk PRIMARY KEY (si44_sequencial);



        ALTER TABLE ONLY reglic202020
        ADD CONSTRAINT reglic202020_sequ_pk PRIMARY KEY (si45_sequencial);



        ALTER TABLE ONLY resplic102020
        ADD CONSTRAINT resplic102020_sequ_pk PRIMARY KEY (si55_sequencial);



        ALTER TABLE ONLY resplic202020
        ADD CONSTRAINT resplic202020_sequ_pk PRIMARY KEY (si56_sequencial);



        ALTER TABLE ONLY rsp102020
        ADD CONSTRAINT rsp102020_sequ_pk PRIMARY KEY (si112_sequencial);



        ALTER TABLE ONLY rsp112020
        ADD CONSTRAINT rsp112020_sequ_pk PRIMARY KEY (si113_sequencial);



        ALTER TABLE ONLY rsp122020
        ADD CONSTRAINT rsp122020_sequ_pk PRIMARY KEY (si114_sequencial);



        ALTER TABLE ONLY rsp202020
        ADD CONSTRAINT rsp202020_sequ_pk PRIMARY KEY (si115_sequencial);



        ALTER TABLE ONLY rsp212020
        ADD CONSTRAINT rsp212020_sequ_pk PRIMARY KEY (si116_sequencial);



        ALTER TABLE ONLY rsp222020
        ADD CONSTRAINT rsp222020_sequ_pk PRIMARY KEY (si117_sequencial);



        ALTER TABLE ONLY tce102020
        ADD CONSTRAINT tce102020_sequ_pk PRIMARY KEY (si187_sequencial);



        ALTER TABLE ONLY tce112020
        ADD CONSTRAINT tce112020_sequ_pk PRIMARY KEY (si188_sequencial);



        CREATE INDEX aberlic112020_si47_reg10_index ON aberlic112020 USING btree (si47_reg10);



        CREATE INDEX aberlic122020_si48_reg10_index ON aberlic122020 USING btree (si48_reg10);



        CREATE INDEX aberlic132020_si49_reg10_index ON aberlic132020 USING btree (si49_reg10);



        CREATE INDEX aberlic142020_si50_reg10_index ON aberlic142020 USING btree (si50_reg10);



        CREATE INDEX aberlic152020_si51_reg10_index ON aberlic152020 USING btree (si51_reg10);



        CREATE INDEX aberlic162020_si52_reg10_index ON aberlic162020 USING btree (si52_reg10);



        CREATE INDEX alq112020_si122_reg10_index ON alq112020 USING btree (si122_reg10);



        CREATE INDEX alq122020_si123_reg10_index ON alq122020 USING btree (si123_reg10);



        CREATE INDEX anl112020_si111_reg10_index ON anl112020 USING btree (si111_reg10);



        CREATE INDEX aob112020_si142_reg10_index ON aob112020 USING btree (si142_reg10);



        CREATE INDEX aoc112020_si39_reg10_index ON aoc112020 USING btree (si39_reg10);



        CREATE INDEX aoc122020_si40_reg10_index ON aoc122020 USING btree (si40_reg10);



        CREATE INDEX aoc132020_si41_reg10_index ON aoc132020 USING btree (si41_reg10);



        CREATE INDEX aoc142020_si42_reg10_index ON aoc142020 USING btree (si42_reg10);



        CREATE INDEX aoc152020_si194_reg10_index ON aoc152020 USING btree (si194_reg10);



        CREATE INDEX aop112020_si138_reg10_index ON aop112020 USING btree (si138_reg10);



        CREATE INDEX arc112020_si15_reg10_index ON arc112020 USING btree (si29_reg10);



        CREATE INDEX arc122020_si30_reg10_index ON arc122020 USING btree (si30_reg10);



        CREATE INDEX arcwq2020_si32_reg20_index ON arc212020 USING btree (si32_reg20);



        CREATE INDEX caixa122020_si104_reg10_index ON caixa122020 USING btree (si104_reg10);



        CREATE INDEX caixa132020_si105_reg10_index ON caixa132020 USING btree (si105_reg10);



        CREATE INDEX contratos112020_si84_reg10_index ON contratos112020 USING btree (si84_reg10);



        CREATE INDEX contratos122020_si85_reg10_index ON contratos122020 USING btree (si85_reg10);



        CREATE INDEX contratos132020_si86_reg10_index ON contratos132020 USING btree (si86_reg10);



        CREATE INDEX contratos212020_si88_reg10_index ON contratos212020 USING btree (si88_reg20);



        CREATE INDEX conv112020_si93_reg10_index ON conv112020 USING btree (si93_reg10);



        CREATE INDEX ctb212020_si97_reg20_index ON ctb212020 USING btree (si97_reg20);



        CREATE INDEX ctb222020_si98_reg21_index ON ctb222020 USING btree (si98_reg21);



        CREATE INDEX ctb312020_si100_reg30_index ON ctb312020 USING btree (si100_reg30);



        CREATE INDEX cute212020_si201_reg10_index ON cute212020 USING btree (si201_reg10);



        CREATE INDEX dispensa112020_si75_reg10_index ON dispensa112020 USING btree (si75_reg10);



        CREATE INDEX dispensa122020_si76_reg10_index ON dispensa122020 USING btree (si76_reg10);



        CREATE INDEX dispensa132020_si77_reg10_index ON dispensa132020 USING btree (si77_reg10);



        CREATE INDEX dispensa142020_si78_reg10_index ON dispensa142020 USING btree (si78_reg10);



        CREATE INDEX dispensa152020_si79_reg10_index ON dispensa152020 USING btree (si79_reg10);



        CREATE INDEX dispensa162020_si80_reg10_index ON dispensa162020 USING btree (si80_reg10);



        CREATE INDEX dispensa172020_si81_reg10_index ON dispensa172020 USING btree (si81_reg10);



        CREATE INDEX dispensa182020_si82_reg10_index ON dispensa182020 USING btree (si82_reg10);



        CREATE INDEX emp112020_si107_reg10_index ON emp112020 USING btree (si107_reg10);



        CREATE INDEX emp122020_si108_reg10_index ON emp122020 USING btree (si108_reg10);



        CREATE INDEX ext312020_si127_reg20_index ON ext312020 USING btree (si127_reg30);



        CREATE INDEX ext322020_si128_reg20_index ON ext322020 USING btree (si128_reg30);



        CREATE INDEX hablic112020_si58_reg10_index ON hablic112020 USING btree (si58_mes);



        CREATE INDEX lao112020_si35_reg10_index ON lao112020 USING btree (si35_reg10);



        CREATE INDEX lao212020_si37_reg20_index ON lao212020 USING btree (si37_reg20);



        CREATE INDEX lqd112020_si119_reg10_index ON lqd112020 USING btree (si119_reg10);



        CREATE INDEX lqd122020_si120_reg10_index ON lqd122020 USING btree (si120_reg10);



        CREATE INDEX ntf112020_si144_reg10_index ON ntf112020 USING btree (si144_reg10);



        CREATE INDEX obelac112020_si140_reg10_index ON obelac112020 USING btree (si140_reg10);



        CREATE INDEX ops112020_si133_reg10_index ON ops112020 USING btree (si133_reg10);



        CREATE INDEX ops122020_si134_reg10_index ON ops122020 USING btree (si134_reg10);



        CREATE INDEX ops132020_si135_reg10_index ON ops132020 USING btree (si135_reg10);



        CREATE INDEX orgao112020_si15_reg10_index ON orgao112020 USING btree (si15_reg10);



        CREATE INDEX parec112020_si23_reg10_index ON parec112020 USING btree (si23_reg10);



        CREATE INDEX rec112020_si26_reg10_index ON rec112020 USING btree (si26_reg10);



        CREATE INDEX regadesao112020_si68_reg10_index ON regadesao112020 USING btree (si68_reg10);



        CREATE INDEX regadesao122020_si69_reg10_index ON regadesao122020 USING btree (si69_reg10);



        CREATE INDEX regadesao132020_si70_reg10_index ON regadesao132020 USING btree (si70_reg10);



        CREATE INDEX regadesao142020_si71_reg10_index ON regadesao142020 USING btree (si71_reg10);



        CREATE INDEX regadesao152020_si72_reg10_index ON regadesao152020 USING btree (si72_reg10);



        CREATE INDEX rsp112020_si113_reg10_index ON rsp112020 USING btree (si113_reg10);



        CREATE INDEX rsp122020_si114_reg10_index ON rsp122020 USING btree (si114_reg10);



        CREATE INDEX rsp212020_si116_reg20_index ON rsp212020 USING btree (si116_reg20);



        CREATE INDEX rsp222020_si117_reg20_index ON rsp222020 USING btree (si117_reg20);



        ALTER TABLE ONLY aberlic112020
        ADD CONSTRAINT aberlic112020_reg10_fk FOREIGN KEY (si47_reg10) REFERENCES aberlic102020(si46_sequencial);



        ALTER TABLE ONLY aberlic122020
        ADD CONSTRAINT aberlic122020_reg10_fk FOREIGN KEY (si48_reg10) REFERENCES aberlic102020(si46_sequencial);



        ALTER TABLE ONLY aberlic132020
        ADD CONSTRAINT aberlic132020_reg10_fk FOREIGN KEY (si49_reg10) REFERENCES aberlic102020(si46_sequencial);



        ALTER TABLE ONLY aberlic142020
        ADD CONSTRAINT aberlic142020_reg10_fk FOREIGN KEY (si50_reg10) REFERENCES aberlic102020(si46_sequencial);



        ALTER TABLE ONLY aberlic152020
        ADD CONSTRAINT aberlic152020_reg10_fk FOREIGN KEY (si51_reg10) REFERENCES aberlic102020(si46_sequencial);



        ALTER TABLE ONLY aberlic162020
        ADD CONSTRAINT aberlic162020_reg10_fk FOREIGN KEY (si52_reg10) REFERENCES aberlic102020(si46_sequencial);



        ALTER TABLE ONLY alq112020
        ADD CONSTRAINT alq112020_reg10_fk FOREIGN KEY (si122_reg10) REFERENCES alq102020(si121_sequencial);



        ALTER TABLE ONLY alq122020
        ADD CONSTRAINT alq122020_reg10_fk FOREIGN KEY (si123_reg10) REFERENCES alq102020(si121_sequencial);



        ALTER TABLE ONLY anl112020
        ADD CONSTRAINT anl112020_reg10_fk FOREIGN KEY (si111_reg10) REFERENCES anl102020(si110_sequencial);



        ALTER TABLE ONLY aob112020
        ADD CONSTRAINT aob112020_reg10_fk FOREIGN KEY (si142_reg10) REFERENCES aob102020(si141_sequencial);



        ALTER TABLE ONLY aoc112020
        ADD CONSTRAINT aoc112020_reg10_fk FOREIGN KEY (si39_reg10) REFERENCES aoc102020(si38_sequencial);



        ALTER TABLE ONLY aoc122020
        ADD CONSTRAINT aoc122020_reg10_fk FOREIGN KEY (si40_reg10) REFERENCES aoc102020(si38_sequencial);



        ALTER TABLE ONLY aoc132020
        ADD CONSTRAINT aoc132020_reg10_fk FOREIGN KEY (si41_reg10) REFERENCES aoc102020(si38_sequencial);



        ALTER TABLE ONLY aoc142020
        ADD CONSTRAINT aoc142020_reg10_fk FOREIGN KEY (si42_reg10) REFERENCES aoc102020(si38_sequencial);



        ALTER TABLE ONLY aoc152020
        ADD CONSTRAINT aoc152020_reg10_fk FOREIGN KEY (si194_reg10) REFERENCES aoc102020(si38_sequencial);



        ALTER TABLE ONLY aop112020
        ADD CONSTRAINT aop112020_reg10_fk FOREIGN KEY (si138_reg10) REFERENCES aop102020(si137_sequencial);



        ALTER TABLE ONLY arc112020
        ADD CONSTRAINT arc112020_reg10_fk FOREIGN KEY (si29_reg10) REFERENCES arc102020(si28_sequencial);



        ALTER TABLE ONLY arc122020
        ADD CONSTRAINT arc122020_reg10_fk FOREIGN KEY (si30_reg10) REFERENCES arc102020(si28_sequencial);



        ALTER TABLE ONLY arc212020
        ADD CONSTRAINT arc212020_reg20_fk FOREIGN KEY (si32_reg20) REFERENCES arc202020(si31_sequencial);



        ALTER TABLE ONLY caixa112020
        ADD CONSTRAINT caixa112020_reg10_fk FOREIGN KEY (si166_reg10) REFERENCES caixa102020(si103_sequencial);



        ALTER TABLE ONLY caixa122020
        ADD CONSTRAINT caixa122020_reg10_fk FOREIGN KEY (si104_reg10) REFERENCES caixa102020(si103_sequencial);



        ALTER TABLE ONLY caixa132020
        ADD CONSTRAINT caixa132020_reg10_fk FOREIGN KEY (si105_reg10) REFERENCES caixa102020(si103_sequencial);



        ALTER TABLE ONLY contratos112020
        ADD CONSTRAINT contratos112020_reg10_fk FOREIGN KEY (si84_reg10) REFERENCES contratos102020(si83_sequencial);



        ALTER TABLE ONLY contratos122020
        ADD CONSTRAINT contratos122020_reg10_fk FOREIGN KEY (si85_reg10) REFERENCES contratos102020(si83_sequencial);



        ALTER TABLE ONLY contratos132020
        ADD CONSTRAINT contratos132020_reg10_fk FOREIGN KEY (si86_reg10) REFERENCES contratos102020(si83_sequencial);



        ALTER TABLE ONLY contratos212020
        ADD CONSTRAINT contratos212020_reg20_fk FOREIGN KEY (si88_reg20) REFERENCES contratos202020(si87_sequencial);



        ALTER TABLE ONLY conv112020
        ADD CONSTRAINT conv112020_reg10_fk FOREIGN KEY (si93_reg10) REFERENCES conv102020(si92_sequencial);



        ALTER TABLE ONLY ctb212020
        ADD CONSTRAINT ctb212020_reg20_fk FOREIGN KEY (si97_reg20) REFERENCES ctb202020(si96_sequencial);



        ALTER TABLE ONLY ctb222020
        ADD CONSTRAINT ctb222020_reg21_fk FOREIGN KEY (si98_reg21) REFERENCES ctb212020(si97_sequencial);



        ALTER TABLE ONLY ctb312020
        ADD CONSTRAINT ctb312020_reg30_fk FOREIGN KEY (si100_reg30) REFERENCES ctb302020(si99_sequencial);



        ALTER TABLE ONLY cute212020
        ADD CONSTRAINT cute212020_reg10_fk FOREIGN KEY (si201_reg10) REFERENCES cute102020(si199_sequencial);



        ALTER TABLE ONLY dclrf112020
        ADD CONSTRAINT dclrf112020_reg10_fk FOREIGN KEY (si205_reg10) REFERENCES dclrf102020(si157_sequencial);



        ALTER TABLE ONLY dclrf202020
        ADD CONSTRAINT dclrf202020_reg10_fk FOREIGN KEY (si191_reg10) REFERENCES dclrf102020(si157_sequencial);



        ALTER TABLE ONLY dclrf302020
        ADD CONSTRAINT dclrf302020_reg10_fk FOREIGN KEY (si192_reg10) REFERENCES dclrf102020(si157_sequencial);



        ALTER TABLE ONLY dclrf402020
        ADD CONSTRAINT dclrf402020_reg10_fk FOREIGN KEY (si193_reg10) REFERENCES dclrf102020(si157_sequencial);



        ALTER TABLE ONLY dispensa112020
        ADD CONSTRAINT dispensa112020_reg10_fk FOREIGN KEY (si75_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY dispensa122020
        ADD CONSTRAINT dispensa122020_reg10_fk FOREIGN KEY (si76_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY dispensa132020
        ADD CONSTRAINT dispensa132020_reg10_fk FOREIGN KEY (si77_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY dispensa142020
        ADD CONSTRAINT dispensa142020_reg10_fk FOREIGN KEY (si78_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY dispensa152020
        ADD CONSTRAINT dispensa152020_reg10_fk FOREIGN KEY (si79_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY dispensa162020
        ADD CONSTRAINT dispensa162020_reg10_fk FOREIGN KEY (si80_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY dispensa172020
        ADD CONSTRAINT dispensa172020_reg10_fk FOREIGN KEY (si81_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY dispensa182020
        ADD CONSTRAINT dispensa182020_reg10_fk FOREIGN KEY (si82_reg10) REFERENCES dispensa102020(si74_sequencial);



        ALTER TABLE ONLY emp112020
        ADD CONSTRAINT emp112020_reg10_fk FOREIGN KEY (si107_reg10) REFERENCES emp102020(si106_sequencial);



        ALTER TABLE ONLY emp122020
        ADD CONSTRAINT emp122020_reg10_fk FOREIGN KEY (si108_reg10) REFERENCES emp102020(si106_sequencial);



        ALTER TABLE ONLY ext312020
        ADD CONSTRAINT ext312020_reg22_fk FOREIGN KEY (si127_reg30) REFERENCES ext302020(si126_sequencial);



        ALTER TABLE ONLY ext322020
        ADD CONSTRAINT ext322020_reg23_fk FOREIGN KEY (si128_reg30) REFERENCES ext322020(si128_sequencial);



        ALTER TABLE ONLY hablic112020
        ADD CONSTRAINT hablic112020_reg10_fk FOREIGN KEY (si58_reg10) REFERENCES hablic102020(si57_sequencial);



        ALTER TABLE ONLY lao112020
        ADD CONSTRAINT lao112020_reg10_fk FOREIGN KEY (si35_reg10) REFERENCES lao102020(si34_sequencial);



        ALTER TABLE ONLY lao212020
        ADD CONSTRAINT lao212020_reg20_fk FOREIGN KEY (si37_reg20) REFERENCES lao202020(si36_sequencial);



        ALTER TABLE ONLY lqd112020
        ADD CONSTRAINT lqd112020_reg10_fk FOREIGN KEY (si119_reg10) REFERENCES lqd102020(si118_sequencial);



        ALTER TABLE ONLY lqd122020
        ADD CONSTRAINT lqd122020_reg10_fk FOREIGN KEY (si120_reg10) REFERENCES lqd102020(si118_sequencial);



        ALTER TABLE ONLY ntf112020
        ADD CONSTRAINT ntf112020_reg10_fk FOREIGN KEY (si144_reg10) REFERENCES ntf102020(si143_sequencial);



        ALTER TABLE ONLY obelac112020
        ADD CONSTRAINT obelac112020_reg10_fk FOREIGN KEY (si140_reg10) REFERENCES lqd122020(si120_sequencial);



        ALTER TABLE ONLY ops112020
        ADD CONSTRAINT ops112020_reg10_fk FOREIGN KEY (si133_reg10) REFERENCES ops102020(si132_sequencial);



        ALTER TABLE ONLY ops122020
        ADD CONSTRAINT ops122020_reg10_fk FOREIGN KEY (si134_reg10) REFERENCES ops102020(si132_sequencial);



        ALTER TABLE ONLY ops132020
        ADD CONSTRAINT ops132020_reg10_fk FOREIGN KEY (si135_reg10) REFERENCES ops102020(si132_sequencial);



        ALTER TABLE ONLY orgao112020
        ADD CONSTRAINT orgao112020_reg10_fk FOREIGN KEY (si15_reg10) REFERENCES orgao102020(si14_sequencial);



        ALTER TABLE ONLY parec112020
        ADD CONSTRAINT parec112020_reg10_fk FOREIGN KEY (si23_reg10) REFERENCES parec102020(si22_sequencial);



        ALTER TABLE ONLY rec112020
        ADD CONSTRAINT rec112020_reg10_fk FOREIGN KEY (si26_reg10) REFERENCES rec102020(si25_sequencial);



        ALTER TABLE ONLY regadesao112020
        ADD CONSTRAINT regadesao112020_reg10_fk FOREIGN KEY (si68_reg10) REFERENCES regadesao102020(si67_sequencial);



        ALTER TABLE ONLY regadesao122020
        ADD CONSTRAINT regadesao122020_reg10_fk FOREIGN KEY (si69_reg10) REFERENCES regadesao102020(si67_sequencial);



        ALTER TABLE ONLY regadesao132020
        ADD CONSTRAINT regadesao132020_reg10_fk FOREIGN KEY (si70_reg10) REFERENCES regadesao102020(si67_sequencial);



        ALTER TABLE ONLY regadesao142020
        ADD CONSTRAINT regadesao142020_reg10_fk FOREIGN KEY (si71_reg10) REFERENCES regadesao102020(si67_sequencial);



        ALTER TABLE ONLY regadesao152020
        ADD CONSTRAINT regadesao152020_reg10_fk FOREIGN KEY (si72_reg10) REFERENCES regadesao102020(si67_sequencial);



        ALTER TABLE ONLY rsp112020
        ADD CONSTRAINT rsp112020_reg10_fk FOREIGN KEY (si113_reg10) REFERENCES rsp102020(si112_sequencial);



        ALTER TABLE ONLY rsp122020
        ADD CONSTRAINT rsp122020_reg10_fk FOREIGN KEY (si114_reg10) REFERENCES rsp102020(si112_sequencial);



        ALTER TABLE ONLY rsp212020
        ADD CONSTRAINT rsp212020_reg20_fk FOREIGN KEY (si116_reg20) REFERENCES rsp202020(si115_sequencial);



        ALTER TABLE ONLY rsp222020
        ADD CONSTRAINT rsp222020_reg20_fk FOREIGN KEY (si117_reg20) REFERENCES rsp202020(si115_sequencial);



        ALTER TABLE ONLY tce112020
        ADD CONSTRAINT tce112020_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES tce112020(si188_sequencial);

SQL;
        $this->execute($sql);

    }

    public function down()
    {

    }
}
