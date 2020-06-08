<?php

use Phinx\Migration\AbstractMigration;

class Oc12251CorrecaoRedispi extends AbstractMigration
{
    public function up()
    {
		$sql = "
				-- 
				-- Tabela redispi122020
				-- 
					DROP TABLE redispi122020;
				  	CREATE TABLE redispi122020(
						si185_sequencial bigint DEFAULT 0 NOT NULL,
						si185_tiporegistro bigint DEFAULT 0 NOT NULL,
						si185_codorgaoresp char(3) NOT NULL,
						si185_codunidadesubresp varchar(8),
						si185_codunidadesubrespestadual character varying(4),
						si185_exercicioprocesso smallint DEFAULT 0 NOT NULL,
						si185_nroprocesso char(12) NOT NULL,
						si185_codobralocal bigint,
						si185_logradouro varchar(100) NOT NULL,
						si185_numero smallint,
						si185_bairro varchar(100),
						si185_distrito varchar(100),
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
				  
				  	DROP SEQUENCE redispi122020_si185_sequencial_seq;
				  	
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
		";
		$this->execute($sql);
    }

    public function down(){

	}
}
