<?php

use Phinx\Migration\AbstractMigration;

class SicomBalancete2020 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        CREATE TABLE balancete102020 (
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


        ALTER TABLE balancete102020 OWNER TO dbportal;


        CREATE SEQUENCE balancete102020_si177_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete102020_si177_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete112020 (
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


        ALTER TABLE balancete112020 OWNER TO dbportal;


        CREATE SEQUENCE balancete112020_si178_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete112020_si178_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete122020 (
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


        ALTER TABLE balancete122020 OWNER TO dbportal;


        CREATE SEQUENCE balancete122020_si179_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete122020_si179_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete132020 (
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


        ALTER TABLE balancete132020 OWNER TO dbportal;


        CREATE SEQUENCE balancete132020_si180_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete132020_si180_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete142020 (
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


        ALTER TABLE balancete142020 OWNER TO dbportal;


        CREATE SEQUENCE balancete142020_si181_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete142020_si181_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete152020 (
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


        ALTER TABLE balancete152020 OWNER TO dbportal;


        CREATE SEQUENCE balancete152020_si182_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete152020_si182_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete162020 (
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


        ALTER TABLE balancete162020 OWNER TO dbportal;


        CREATE SEQUENCE balancete162020_si183_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete162020_si183_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete172020 (
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


        ALTER TABLE balancete172020 OWNER TO dbportal;


        CREATE SEQUENCE balancete172020_si184_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete172020_si184_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete182020 (
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


        ALTER TABLE balancete182020 OWNER TO dbportal;


        CREATE SEQUENCE balancete182020_si185_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete182020_si185_sequencial_seq OWNER TO dbportal;


        CREATE SEQUENCE balancete182020_si186_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete182020_si186_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete192020 (
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


        ALTER TABLE balancete192020 OWNER TO dbportal;


        CREATE SEQUENCE balancete192020_si186_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete192020_si186_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete202020 (
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


        ALTER TABLE balancete202020 OWNER TO dbportal;


        CREATE SEQUENCE balancete202020_si187_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete202020_si187_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete212020 (
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


        ALTER TABLE balancete212020 OWNER TO dbportal;


        CREATE SEQUENCE balancete212020_si188_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete212020_si188_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete222020 (
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


        ALTER TABLE balancete222020 OWNER TO dbportal;


        CREATE SEQUENCE balancete222020_si189_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete222020_si189_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete232020 (
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


        ALTER TABLE balancete232020 OWNER TO dbportal;


        CREATE SEQUENCE balancete232020_si190_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete232020_si190_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete242020 (
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


        ALTER TABLE balancete242020 OWNER TO dbportal;


        CREATE SEQUENCE balancete242020_si191_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete242020_si191_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete252020 (
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


        ALTER TABLE balancete252020 OWNER TO dbportal;


        CREATE SEQUENCE balancete252020_si195_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete252020_si195_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete262020 (
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
            si196_saldofinalpessoaatributosf double precision DEFAULT 0 NOT NULL,
            si196_naturezasaldofinalpessoaatributosf character varying(1) NOT NULL,
            si196_mes bigint DEFAULT 0 NOT NULL,
            si196_instit bigint DEFAULT 0,
            si196_reg10 bigint NOT NULL
        );


        ALTER TABLE balancete262020 OWNER TO dbportal;


        CREATE SEQUENCE balancete262020_si196_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete262020_si196_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete272020 (
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


        ALTER TABLE balancete272020 OWNER TO dbportal;


        CREATE SEQUENCE balancete272020_si197_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete272020_si197_sequencial_seq OWNER TO dbportal;


        CREATE TABLE balancete282020 (
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


        ALTER TABLE balancete282020 OWNER TO dbportal;


        CREATE SEQUENCE balancete282020_si198_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE balancete282020_si198_sequencial_seq OWNER TO dbportal;


        ALTER TABLE ONLY balancete102020
        ADD CONSTRAINT balancete102020_sequ_pk PRIMARY KEY (si177_sequencial);



        ALTER TABLE ONLY balancete112020
        ADD CONSTRAINT balancete112020_sequ_pk PRIMARY KEY (si178_sequencial);



        ALTER TABLE ONLY balancete122020
        ADD CONSTRAINT balancete122020_sequ_pk PRIMARY KEY (si179_sequencial);



        ALTER TABLE ONLY balancete132020
        ADD CONSTRAINT balancete132020_sequ_pk PRIMARY KEY (si180_sequencial);



        ALTER TABLE ONLY balancete142020
        ADD CONSTRAINT balancete142020_sequ_pk PRIMARY KEY (si181_sequencial);



        ALTER TABLE ONLY balancete152020
        ADD CONSTRAINT balancete152020_sequ_pk PRIMARY KEY (si182_sequencial);



        ALTER TABLE ONLY balancete162020
        ADD CONSTRAINT balancete162020_sequ_pk PRIMARY KEY (si183_sequencial);



        ALTER TABLE ONLY balancete172020
        ADD CONSTRAINT balancete172020_sequ_pk PRIMARY KEY (si184_sequencial);



        ALTER TABLE ONLY balancete182020
        ADD CONSTRAINT balancete182020_sequ_pk PRIMARY KEY (si185_sequencial);



        ALTER TABLE ONLY balancete192020
        ADD CONSTRAINT balancete192020_sequ_pk PRIMARY KEY (si186_sequencial);



        ALTER TABLE ONLY balancete202020
        ADD CONSTRAINT balancete202020_sequ_pk PRIMARY KEY (si187_sequencial);



        ALTER TABLE ONLY balancete212020
        ADD CONSTRAINT balancete212020_sequ_pk PRIMARY KEY (si188_sequencial);



        ALTER TABLE ONLY balancete222020
        ADD CONSTRAINT balancete222020_sequ_pk PRIMARY KEY (si189_sequencial);



        ALTER TABLE ONLY balancete232020
        ADD CONSTRAINT balancete232020_sequ_pk PRIMARY KEY (si190_sequencial);



        ALTER TABLE ONLY balancete242020
        ADD CONSTRAINT balancete242020_sequ_pk PRIMARY KEY (si191_sequencial);



        ALTER TABLE ONLY balancete252020
        ADD CONSTRAINT balancete252020_sequ_pk PRIMARY KEY (si195_sequencial);



        ALTER TABLE ONLY balancete262020
        ADD CONSTRAINT balancete262020_sequ_pk PRIMARY KEY (si196_sequencial);



        ALTER TABLE ONLY balancete272020
        ADD CONSTRAINT balancete272020_sequ_pk PRIMARY KEY (si197_sequencial);



        ALTER TABLE ONLY balancete282020
        ADD CONSTRAINT balancete282020_sequ_pk PRIMARY KEY (si198_sequencial);



        ALTER TABLE ONLY balancete252020
        ADD CONSTRAINT fk_balancete102020_reg10_fk FOREIGN KEY (si195_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete262020
        ADD CONSTRAINT fk_balancete102020_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete112020
        ADD CONSTRAINT fk_balancete112020_reg10_fk FOREIGN KEY (si178_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete122020
        ADD CONSTRAINT fk_balancete122020_reg10_fk FOREIGN KEY (si179_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete132020
        ADD CONSTRAINT fk_balancete132020_reg10_fk FOREIGN KEY (si180_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete142020
        ADD CONSTRAINT fk_balancete142020_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete152020
        ADD CONSTRAINT fk_balancete152020_reg10_fk FOREIGN KEY (si182_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete162020
        ADD CONSTRAINT fk_balancete162020_reg10_fk FOREIGN KEY (si183_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete172020
        ADD CONSTRAINT fk_balancete172020_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete182020
        ADD CONSTRAINT fk_balancete182020_reg10_fk FOREIGN KEY (si185_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete192020
        ADD CONSTRAINT fk_balancete192020_reg10_fk FOREIGN KEY (si186_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete202020
        ADD CONSTRAINT fk_balancete202020_reg10_fk FOREIGN KEY (si187_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete212020
        ADD CONSTRAINT fk_balancete212020_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete222020
        ADD CONSTRAINT fk_balancete222020_si77_sequencial FOREIGN KEY (si189_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete232020
        ADD CONSTRAINT fk_balancete232020_reg10_fk FOREIGN KEY (si190_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete242020
        ADD CONSTRAINT fk_balancete242020_reg10_fk FOREIGN KEY (si191_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete272020
        ADD CONSTRAINT fk_balancete272020_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES balancete102020(si177_sequencial);



        ALTER TABLE ONLY balancete282020
        ADD CONSTRAINT fk_balancete282020_reg10_fk FOREIGN KEY (si198_reg10) REFERENCES balancete102020(si177_sequencial);";   

        $this->execute($sql);
    }

    public function down()
    {

    }
}