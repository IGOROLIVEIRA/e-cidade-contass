<?php

use Phinx\Migration\AbstractMigration;

class Oc11211Aberlic2020 extends AbstractMigration
{
    public function up()
    {
        $sql = "

            DROP TABLE aberlic162020;
            DROP TABLE aberlic152020;
            DROP TABLE aberlic142020;
            DROP TABLE aberlic132020;
            DROP TABLE aberlic122020;
            DROP TABLE aberlic112020;
            DROP TABLE aberlic102020;
            
            CREATE TABLE aberlic102020 (
                si46_sequencial bigint DEFAULT 0 NOT NULL,
                si46_tiporegistro bigint DEFAULT 0 NOT NULL,
                si46_tipocadastro bigint DEFAULT 0 NOT NULL,
                si46_codorgaoresp character varying(2) NOT NULL,
                si46_codunidadesubresp character varying(8) NOT NULL,
                si46_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
                si46_nroprocessolicitatorio character varying(12) NOT NULL,
                si46_codmodalidadelicitacao bigint DEFAULT 0 NOT NULL,
                si46_nroedital bigint DEFAULT 0 NOT NULL,
                si46_exercicioedital bigint DEFAULT 0 NOT NULL,
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

            DROP SEQUENCE aberlic102020_si46_sequencial_seq;
            CREATE SEQUENCE aberlic102020_si46_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;

            ALTER TABLE aberlic102020_si46_sequencial_seq OWNER TO dbportal;
            ALTER TABLE ONLY aberlic102020 ADD CONSTRAINT aberlic102020_sequ_pk PRIMARY KEY (si46_sequencial);
            
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

            DROP SEQUENCE aberlic112020_si47_sequencial_seq;
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

            DROP SEQUENCE aberlic122020_si48_sequencial_seq;
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

            DROP SEQUENCE aberlic132020_si49_sequencial_seq;
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

            DROP SEQUENCE aberlic142020_si50_sequencial_seq;
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

            DROP SEQUENCE aberlic152020_si51_sequencial_seq;
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

            DROP SEQUENCE aberlic162020_si52_sequencial_seq;
            CREATE SEQUENCE aberlic162020_si52_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
            
            ALTER TABLE aberlic162020_si52_sequencial_seq OWNER TO dbportal;

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
        ";
        $this->execute($sql);
    }

    public function down(){

    }
}

