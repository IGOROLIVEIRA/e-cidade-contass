<?php

use Phinx\Migration\AbstractMigration;

class Oc11397 extends AbstractMigration
{

    public function up()
    {
      $sql = "
        INSERT INTO db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
          VALUES ((SELECT max(id_item) FROM db_itensmenu) + 1, 'Editais', 'Editais SICOM', 'con4_gerareditais.php', 1, 1, 'Editais SICOM', 't');
                
        INSERT INTO db_menu(id_item, id_item_filho, menusequencia, modulo) VALUES (8987, (SELECT id_item FROM db_itensmenu where descricao = 'Editais' limit 1), (SELECT max(menusequencia) FROM db_menu where id_item = 8987 and modulo = 2000018)+1, 2000018);

      --
      --  Criação das tabelas do RALIC 2020  
      --
        
        --
        -- Tabela ralic102020
        -- 
        
          CREATE TABLE ralic102020(
            si180_sequencial bigint DEFAULT 0 NOT NULL,
            si180_tiporegistro bigint DEFAULT 0 NOT NULL,
            si180_codorgaoresp character varying(3) NOT NULL,
            si180_codunidadesubresp character varying(8) NOT NULL,
            si180_codunidadesubrespestadual character varying(4),
            si180_exerciciolicitacao smallint NOT NULL,
            si180_nroprocessolicitatorio character varying(12) NOT NULL,
            si180_tipocadastradolicitacao char(1) NOT NULL,
            si180_dsccadastrolicitatorio varchar(150),
            si180_codmodalidadelicitacao smallint NOT NULL,
            si180_naturezaprocedimento smallint NOT NULL,
            si180_nroedital integer NOT NULL,
            si180_exercicioedital smallint DEFAULT 0 NOT NULL,
            si180_dtpublicacaoeditaldo date,
            si180_link varchar(200) NOT NULL,
            si180_tipolicitacao smallint,
            si180_naturezaobjeto smallint,
            si180_objeto character varying(500) NOT NULL,
            si180_regimeexecucaoobras smallint,
            si180_vlcontratacao real NOT NULL,
            si180_bdi real,
            si180_mesexercicioreforc integer,
            si180_origemrecurso smallint NOT NULL,
            si180_dscorigemrecurso varchar(150),
            si180_mes bigint DEFAULT 0 NOT NULL,
            si180_instit bigint DEFAULT 0
          );
          
          ALTER TABLE ralic102020 OWNER TO dbportal;
          
          --
          -- Name: ralic102020_si180_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
          --
          
          CREATE SEQUENCE ralic102020_si180_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
          
          
          ALTER TABLE ralic102020_si180_sequencial_seq OWNER TO dbportal;
          
          ALTER TABLE ONLY ralic102020 ADD CONSTRAINT ralic102020_sequ_pk PRIMARY KEY (si180_sequencial);
        
        -- 
        -- Tabela ralic112020
        -- 
        
          CREATE TABLE ralic112020(
            si181_sequencial bigint DEFAULT 0 NOT NULL,
            si181_tiporegistro bigint DEFAULT 0 NOT NULL,
            si181_codorgaoresp char(3) NOT NULL,
            si181_codunidadesubresp character varying(8),
            si181_codunidadesubrespestadual char(4),
            si181_exerciciolicitacao smallint NOT NULL,
            si181_nroprocessolicitatorio character varying(12) NOT NULL,
            si181_codobralocal bigint,
            si181_classeobjeto smallint NOT NULL,
            si181_tipoatividadeobra smallint,
            si181_tipoatividadeservico smallint,
            si181_dscatividadeservico varchar(150),
            si181_tipoatividadeservespecializado smallint,
            si181_dscatividadeservespecializado varchar(150),
            si181_codfuncao char(2) NOT NULL,
            si181_codsubfuncao char(3) NOT NULL,
            si181_codbempublico smallint NOT NULL,
            si181_reg10 bigint DEFAULT 0 NOT NULL,
            si181_mes bigint DEFAULT 0 NOT NULL,
            si181_instit bigint DEFAULT 0
          );
          
          ALTER TABLE ralic112020 OWNER TO dbportal;
          
          --
          -- Name: ralic112020_si181_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
          --
          
          CREATE SEQUENCE ralic112020_si181_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
          
          
          ALTER TABLE ralic112020_si181_sequencial_seq OWNER TO dbportal;
          
          ALTER TABLE ONLY ralic112020 ADD CONSTRAINT ralic112020_sequ_pk PRIMARY KEY (si181_sequencial);
          
          ALTER TABLE ONLY ralic112020
                ADD CONSTRAINT ralic112020_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES ralic102020(si180_sequencial);
        
        -- 
        -- Tabela ralic122020
        -- 
        
          CREATE TABLE ralic122020(
            si182_sequencial bigint DEFAULT 0 NOT NULL,
            si182_tiporegistro bigint DEFAULT 0 NOT NULL,
            si182_codorgaoresp character varying(3) NOT NULL,
            si182_codunidadesubresp character varying(8),
            si182_codunidadesubrespestadual char(4),
            si182_exercicioprocesso smallint DEFAULT 0 NOT NULL,
            si182_nroprocessolicitatorio character varying(12) NOT NULL,
            si182_codobralocal bigint,
            si182_logradouro varchar(100) NOT NULL,
            si182_numero smallint NOT NULL,
            si182_bairro varchar(100),
            si182_distrito varchar(100),
            si182_municipio varchar(50) NOT NULL,
            si182_cep bigint NOT NULL,
            si182_graulatitude smallint NOT NULL,
            si182_minutolatitude smallint NOT NULL,
            si182_segundolatitude real NOT NULL,
            si182_graulongitude smallint NOT NULL,
            si182_minutolongitude smallint NOT NULL,
            si182_segundolongitude real NOT NULL,
            si182_reg10 bigint DEFAULT 0 NOT NULL,
            si182_mes bigint DEFAULT 0 NOT NULL,
            si182_instit bigint DEFAULT 0
          );
          
          ALTER TABLE ralic122020 OWNER TO dbportal; 
          
          --
          -- Name: ralic122020_si182_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
          --
          
          CREATE SEQUENCE ralic122020_si182_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
          
          
          ALTER TABLE ralic122020_si182_sequencial_seq OWNER TO dbportal;
          
          ALTER TABLE ONLY ralic122020 ADD CONSTRAINT ralic122020_sequ_pk PRIMARY KEY (si182_sequencial);
          
          ALTER TABLE ONLY ralic122020
                ADD CONSTRAINT ralic122020_reg10_fk FOREIGN KEY (si182_reg10) REFERENCES ralic102020(si180_sequencial);

       --
       -- Criação das tabelas do REDISPI 2020
       --
        
        -- 
        -- Tabela redispi102020
        -- 
        
          CREATE TABLE redispi102020(
            si183_sequencial bigint DEFAULT 0 NOT NULL,
            si183_tiporegistro bigint DEFAULT 0 NOT NULL,
            si183_codorgaoresp character varying(2) NOT NULL,
            si183_codunidadesubresp character varying(8),
            si183_codunidadesubrespestadual char(4),
            si183_exercicioprocesso smallint NOT NULL,
            si183_nroprocesso varchar(12) NOT NULL,
            si183_tipoprocesso smallint NOT NULL,
            si183_tipocadastradodispensainexigibilidade smallint NOT NULL,
            si183_dsccadastrolicitatorio varchar(150),
            si183_dtabertura DATE NOT NULL,
            si183_naturezaobjeto smallint NOT NULL,
            si183_objeto character varying(500) NOT NULL,
            si183_justificativa character varying(250) NOT NULL,
            si183_razao character varying(250) NOT NULL,
            si183_vlrecurso REAL NOT NULL,
            si183_bdi REAL,
            si183_mes bigint DEFAULT 0 NOT NULL,
            si183_instit bigint DEFAULT 0
          );
          
          ALTER TABLE redispi102020 OWNER TO dbportal;
          
          --
          -- Name: redispi102020_si183_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
          --
          
          CREATE SEQUENCE redispi102020_si183_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
        
        
          ALTER TABLE redispi102020_si183_sequencial_seq OWNER TO dbportal;
          ALTER TABLE ONLY redispi102020 ADD CONSTRAINT redispi102020_sequ_pk PRIMARY KEY (si183_sequencial);
        
        -- 
        -- Tabela redispi112020
        -- 
        
          CREATE TABLE redispi112020(
            si184_sequencial bigint DEFAULT 0 NOT NULL,
            si184_tiporegistro bigint DEFAULT 0 NOT NULL,
            si184_codorgaoresp character varying(2) NOT NULL,
            si184_codunidadesubresp character varying(8),
            si184_codunidadesubrespestadual character varying(4),
            si184_exercicioprocesso smallint NOT NULL,
            si184_nroprocesso varchar(12) NOT NULL,
            si184_codobralocal bigint,
            si184_tipoprocesso smallint NOT NULL,
            si184_classeobjeto smallint NOT NULL,
            si184_tipoatividadeobra smallint,
            si184_tipoatividadeservico smallint,
            si184_dscatividadeservico varchar(150),
            si184_tipoatividadeservespecializado smallint,
            si184_dscatividadeservespecializado varchar(150),
            si184_codfuncao char(2) NOT NULL,
            si184_codsubfuncao char(3) NOT NULL,
            si184_codbempublico smallint NOT NULL,
            si184_reg10 bigint DEFAULT 0 NOT NULL,
            si184_mes bigint DEFAULT 0 NOT NULL,
            si184_instit bigint DEFAULT 0
          );
          
          ALTER TABLE redispi112020 OWNER TO dbportal;
          
          --
          -- Name: redispi112020_si184_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
          --
          
          CREATE SEQUENCE redispi112020_si184_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
          
          
          ALTER TABLE redispi112020_si184_sequencial_seq OWNER TO dbportal;
          ALTER TABLE ONLY redispi112020 ADD CONSTRAINT redispi112020_sequ_pk PRIMARY KEY (si184_sequencial);
          ALTER TABLE ONLY redispi112020
                ADD CONSTRAINT redispi112020_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES redispi102020(si183_sequencial);
        
        
        -- 
        -- Tabela redispi122020
        -- 
        
          CREATE TABLE redispi122020(
            si185_sequencial bigint DEFAULT 0 NOT NULL,
            si185_tiporegistro bigint DEFAULT 0 NOT NULL,
            si185_codorgaoresp char(2) NOT NULL,
            si185_codunidadesubresp varchar(8),
            si185_codunidadesubrespestadual character varying(4),
            si185_exercicioprocesso smallint DEFAULT 0 NOT NULL,
            si185_nroprocesso char(12) NOT NULL,
            si185_codobralocal bigint,
            si185_logradouro varchar(100) NOT NULL,
            si185_numero smallint,
            si185_bairro varchar(100),
            si185_cidade varchar(100) NOT NULL,
            si185_cep char(8) NOT NULL,
            si185_graulatitude smallint NOT NULL,
            si185_minutolatitude smallint NOT NULL,
            si185_segundolatitude real NOT NULL,
            si185_graulongitude smallint NOT NULL,
            si185_minutolongitude smallint NOT NULL,
            si185_segundolongitude real NOT NULL,
            si185_reg10 bigint DEFAULT 0 NOT NULL,
            si185_mes bigint DEFAULT 0 NOT NULL,
            si185_instit bigint DEFAULT 0
          );
          
          ALTER TABLE redispi122020 OWNER TO dbportal;
          
          --
          -- Name: redispi122020_si185_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
          --
          
          CREATE SEQUENCE redispi122020_si185_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
        
        
          ALTER TABLE redispi122020_si185_sequencial_seq OWNER TO dbportal;
          ALTER TABLE ONLY redispi122020 ADD CONSTRAINT redispi122020_sequ_pk PRIMARY KEY (si185_sequencial);
          ALTER TABLE ONLY redispi122020
                ADD CONSTRAINT redispi122020_reg10_fk FOREIGN KEY (si185_reg10) REFERENCES redispi102020(si183_sequencial);
              
              
        -- 
        -- Tabela ideedital2020
        -- 
        
        CREATE TABLE ideedital2020(
          si186_sequencial bigint DEFAULT 0 NOT NULL,
          si186_codidentificador char(5) NOT NULL,
          si186_cnpj char(14) NOT NULL,
          si186_codorgao character varying(3) NOT NULL,
          si186_tipoorgao character varying(2) NOT NULL,
          si186_exercicioreferencia smallint NOT NULL,
          si186_mesreferencia char(2) NOT NULL,
          si186_datageracao DATE NOT NULL,
          si186_codcontroleremessa varchar(20),
          si186_codseqremessames integer NOT NULL,
          si186_mes bigint DEFAULT 0 NOT NULL,
          si186_instit bigint DEFAULT 0
        );
        
        ALTER TABLE ideedital2020 OWNER TO dbportal;
        
        --
        -- Name: ideedital2020_si186_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal
        --
        
        CREATE SEQUENCE ideedital2020_si186_sequencial_seq
              START WITH 1
              INCREMENT BY 1
              NO MINVALUE
              NO MAXVALUE
              CACHE 1;
        
        
        ALTER TABLE ideedital2020_si186_sequencial_seq OWNER TO dbportal;
        ALTER TABLE ONLY ideedital2020 ADD CONSTRAINT ideedital2020_sequ_pk PRIMARY KEY (si186_sequencial);

      ";
      $this->execute($sql);

    }

    public function down(){
      $sql = "
        DELETE FROM db_menu where id_item_filho = (select id_item from db_itensmenu where descricao = 'Editais');
        DELETE FROM db_itensmenu where descricao = 'Editais';
        
        --
        -- Remoção das tabelas RALIC 2020
        --
        
        DROP TABLE ralic122020;
        DROP SEQUENCE ralic122020_si182_sequencial_seq;
        DROP TABLE ralic112020;
        DROP SEQUENCE ralic122020_si181_sequencial_seq;
        DROP TABLE ralic102020;
        DROP SEQUENCE ralic122020_si180_sequencial_seq;
        
        --
        -- Remoção das tabelas REDISPI 2020
        --
        
        DROP TABLE redispi122020;
        DROP SEQUENCE redispi122020_si185_sequencial_seq;
        DROP TABLE redispi112020;
        DROP SEQUENCE redispi112020_si184_sequencial_seq;
        DROP TABLE redispi102020;
        DROP SEQUENCE redispi102020_si183_sequencial_seq;
        
        --
        -- Remoção da tabela IDEEDITAL 2020
        --
        
        DROP TABLE ideedital2020;
        DROP SEQUENCE ideedital2020_si186_sequencial_seq;
      ";

      $this->execute($sql);
    }
}
