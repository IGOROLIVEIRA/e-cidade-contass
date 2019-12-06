<?php

use Phinx\Migration\AbstractMigration;

class SicomFolha2020 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        CREATE TABLE afast102020 (
            si199_sequencial integer DEFAULT 0 NOT NULL,
            si199_tiporegistro integer DEFAULT 0 NOT NULL,
            si199_codvinculopessoa integer DEFAULT 0 NOT NULL,
            si199_codafastamento bigint DEFAULT 0 NOT NULL,
            si199_dtinicioafastamento date NOT NULL,
            si199_dtretornoafastamento date NOT NULL,
            si199_tipoafastamento integer DEFAULT 0 NOT NULL,
            si199_dscoutrosafastamentos character varying(500),
            si199_mes integer DEFAULT 0 NOT NULL,
            si199_inst integer DEFAULT 0
        );


        ALTER TABLE afast102020 OWNER TO dbportal;


        CREATE SEQUENCE afast102020_si199_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE afast102020_si199_sequencial_seq OWNER TO dbportal;


        CREATE TABLE afast202020 (
            si200_sequencial integer DEFAULT 0 NOT NULL,
            si200_tiporegistro integer DEFAULT 0 NOT NULL,
            si200_codvinculopessoa integer DEFAULT 0 NOT NULL,
            si200_codafastamento bigint DEFAULT 0 NOT NULL,
            si200_dtterminoafastamento date NOT NULL,
            si200_mes integer DEFAULT 0 NOT NULL,
            si200_inst integer DEFAULT 0
        );


        ALTER TABLE afast202020 OWNER TO dbportal;


        CREATE SEQUENCE afast202020_si200_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE afast202020_si200_sequencial_seq OWNER TO dbportal;


        CREATE TABLE afast302020 (
            si201_sequencial integer DEFAULT 0 NOT NULL,
            si201_tiporegistro integer DEFAULT 0 NOT NULL,
            si201_codvinculopessoa integer DEFAULT 0 NOT NULL,
            si201_codafastamento bigint DEFAULT 0 NOT NULL,
            si201_dtretornoafastamento date NOT NULL,
            si201_mes integer DEFAULT 0 NOT NULL,
            si201_inst integer DEFAULT 0
        );


        ALTER TABLE afast302020 OWNER TO dbportal;


        CREATE SEQUENCE afast302020_si201_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE afast302020_si201_sequencial_seq OWNER TO dbportal;


        CREATE TABLE flpgo102020 (
            si195_sequencial bigint DEFAULT 0 NOT NULL,
            si195_tiporegistro bigint,
            si195_codvinculopessoa bigint,
            si195_regime character varying(1),
            si195_indtipopagamento character varying(1),
            si195_dsctipopagextra character varying(150),
            si195_indsituacaoservidorpensionista character varying(1),
            si195_dscsituacao varchar(150),
            si195_indpensionistaprevidenciario integer,
            si195_nrocpfinstituidor character varying(11),
            si195_datobitoinstituidor date,
            si195_tipodependencia bigint,
            si195_dscdependencia character varying(150),
            si195_datafastpreliminar date,
            si195_datconcessaoaposentadoriapensao date,
            si195_dsccargo character varying(120),
            si195_codcargo bigint,
            si195_sglcargo character varying(3),
            si195_dscsiglacargo character varying(150),
            si195_dscapo character varying(3),
            si195_natcargo integer,
            si195_dscnatcargo character varying(150),
            si195_indcessao character varying(3),
            si195_dsclotacao character varying(250),
            si195_indsalaaula character varying(1),
            si195_vlrcargahorariasemanal bigint,
            si195_datefetexercicio date,
            si195_datcomissionado date,
            si195_datexclusao date,
            si195_datcomissionadoexclusao date,
            si195_vlrremuneracaobruta double precision,
            si195_vlrdescontos double precision,
            si195_vlrremuneracaoliquida double precision,
            si195_natsaldoliquido character varying(1),
            si195_mes bigint,
            si195_inst bigint
        );


        ALTER TABLE flpgo102020 OWNER TO dbportal;


        CREATE SEQUENCE flpgo102020_si195_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE flpgo102020_si195_sequencial_seq OWNER TO dbportal;


        CREATE TABLE flpgo112020 (
            si196_sequencial bigint DEFAULT 0 NOT NULL,
            si196_tiporegistro bigint,
            si196_indtipopagamento character varying(1),
            si196_codvinculopessoa character varying(15),
            si196_codrubricaremuneracao character varying(4),
            si196_desctiporubrica character varying(150),
            si196_vlrremuneracaodetalhada double precision,
            si196_reg10 bigint DEFAULT 0,
            si196_mes bigint,
            si196_inst bigint
        );


        ALTER TABLE flpgo112020 OWNER TO dbportal;


        CREATE SEQUENCE flpgo112020_si196_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE flpgo112020_si196_sequencial_seq OWNER TO dbportal;


        CREATE TABLE flpgo122020 (
            si197_sequencial bigint DEFAULT 0 NOT NULL,
            si197_tiporegistro bigint,
            si197_indtipopagamento character varying(1),
            si197_codvinculopessoa character varying(15),
            si197_codrubricadesconto character varying(4),
            si197_desctiporubricadesconto character varying(150),
            si197_vlrdescontodetalhado double precision,
            si197_reg10 bigint DEFAULT 0,
            si197_mes bigint,
            si197_inst bigint
        );


        ALTER TABLE flpgo122020 OWNER TO dbportal;


        CREATE SEQUENCE flpgo122020_si197_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE flpgo122020_si197_sequencial_seq OWNER TO dbportal;


        CREATE TABLE respinf2020 (
            si197_sequencial bigint DEFAULT 0 NOT NULL,
            si197_nrodocumento character varying(11) NOT NULL,
            si197_dtinicio date,
            si197_dtfinal date,
            si197_mes bigint,
            si197_instit bigint
        );


        ALTER TABLE respinf2020 OWNER TO dbportal;


        CREATE SEQUENCE respinf2020_si197_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE respinf2020_si197_sequencial_seq OWNER TO dbportal;


        CREATE TABLE terem102020 (
            si194_sequencial bigint DEFAULT 0 NOT NULL,
            si194_tiporegistro bigint DEFAULT 0 NOT NULL,
            si194_cnpj character varying(14),
            si194_codteto bigint DEFAULT 0,
            si194_vlrparateto double precision DEFAULT 0 NOT NULL,
            si194_tipocadastro bigint DEFAULT 0 NOT NULL,
            si194_dtinicial date NOT NULL,
            si194_nrleiteto bigint DEFAULT 0 NOT NULL,
            si194_dtpublicacaolei date NOT NULL,
            si194_dtfinal date,
            si194_justalteracao character varying(250),
            si194_mes bigint DEFAULT 0 NOT NULL,
            si194_inst bigint DEFAULT 0
        );


        ALTER TABLE terem102020 OWNER TO dbportal;


        CREATE SEQUENCE terem102020_si194_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE terem102020_si194_sequencial_seq OWNER TO dbportal;


        CREATE TABLE terem202020 (
            si196_sequencial bigint DEFAULT 0 NOT NULL,
            si196_tiporegistro bigint DEFAULT 0 NOT NULL,
            si196_codteto bigint DEFAULT 0 NOT NULL,
            si196_vlrparateto double precision DEFAULT 0 NOT NULL,
            si196_nrleiteto bigint DEFAULT 0 NOT NULL,
            si196_dtpublicacaolei date NOT NULL,
            si196_justalteracaoteto character varying(250),
            si196_mes bigint DEFAULT 0 NOT NULL,
            si196_inst bigint DEFAULT 0
        );


        ALTER TABLE terem202020 OWNER TO dbportal;


        CREATE SEQUENCE terem202020_si196_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE terem202020_si196_sequencial_seq OWNER TO dbportal;


        CREATE TABLE viap102020 (
            si198_sequencial integer DEFAULT 0 NOT NULL,
            si198_tiporegistro integer DEFAULT 0 NOT NULL,
            si198_nrocpfagentepublico character varying(11) NOT NULL,
            si198_codmatriculapessoa integer DEFAULT 0 NOT NULL,
            si198_codvinculopessoa integer DEFAULT 0 NOT NULL,
            si198_mes integer DEFAULT 0 NOT NULL,
            si198_instit integer DEFAULT 0
        );


        ALTER TABLE viap102020 OWNER TO dbportal;


        CREATE SEQUENCE viap102020_si198_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE viap102020_si198_sequencial_seq OWNER TO dbportal;


        ALTER TABLE ONLY afast102020
        ADD CONSTRAINT afast102020_sequ_pk PRIMARY KEY (si199_sequencial);



        ALTER TABLE ONLY afast202020
        ADD CONSTRAINT afast202020_sequ_pk PRIMARY KEY (si200_sequencial);



        ALTER TABLE ONLY afast302020
        ADD CONSTRAINT afast302020_sequ_pk PRIMARY KEY (si201_sequencial);



        ALTER TABLE ONLY flpgo102020
        ADD CONSTRAINT flpgo102020_sequ_pk PRIMARY KEY (si195_sequencial);



        ALTER TABLE ONLY flpgo112020
        ADD CONSTRAINT flpgo112020_sequ_pk PRIMARY KEY (si196_sequencial);



        ALTER TABLE ONLY flpgo122020
        ADD CONSTRAINT flpgo122020_sequ_pk PRIMARY KEY (si197_sequencial);



        ALTER TABLE ONLY respinf2020
        ADD CONSTRAINT respinf2020_sequ_pk PRIMARY KEY (si197_sequencial);



        ALTER TABLE ONLY terem102020
        ADD CONSTRAINT terem102020_sequ_pk PRIMARY KEY (si194_sequencial);



        ALTER TABLE ONLY terem202020
        ADD CONSTRAINT terem202020_sequ_pk PRIMARY KEY (si196_sequencial);



        ALTER TABLE ONLY viap102020
        ADD CONSTRAINT viap102020_sequ_pk PRIMARY KEY (si198_sequencial);



        ALTER TABLE ONLY flpgo112020
        ADD CONSTRAINT flpgo112020_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES flpgo102020(si195_sequencial);



        ALTER TABLE ONLY flpgo122020
        ADD CONSTRAINT flpgo122020_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES flpgo102020(si195_sequencial);

SQL;
        $this->execute($sql);

    }

    public function down()
    {

    }
}
