<?php

use Phinx\Migration\AbstractMigration;

class Oc11442 extends AbstractMigration
{
    public function up()
    {
		$sql = "

				ALTER TABLE adesaoregprecos add column si06_edital integer;
				ALTER TABLE adesaoregprecos add column si06_cadinicial integer DEFAULT null;
				ALTER TABLE adesaoregprecos add column si06_exercicioedital integer;  
				ALTER TABLE adesaoregprecos add column si06_anocadastro integer;  
			
				DROP TABLE regadesao152020, regadesao142020, regadesao132020, regadesao122020, regadesao112020, regadesao102020;
		
				CREATE TABLE regadesao102020 (
				si67_sequencial bigint DEFAULT 0 NOT NULL,
				si67_tiporegistro bigint DEFAULT 0 NOT NULL,
				si67_tipocadastro integer NOT NULL,
				si67_codorgao character varying(2) NOT NULL,
				si67_codunidadesub character varying(8) NOT NULL,
				si67_nroprocadesao character varying(12) NOT NULL,
				si63_exercicioadesao bigint DEFAULT 0 NOT NULL,
				si67_dtabertura date NOT NULL,
				si67_nomeorgaogerenciador character varying(100) NOT NULL,
				si67_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
				si67_nroprocessolicitatorio character varying(20) NOT NULL,
				si67_codmodalidadelicitacao bigint DEFAULT 0 NOT NULL,
				si67_nroedital integer NOT NULL,
				si67_exercicioedital integer NOT NULL,
				si67_dtataregpreco date NOT NULL,
				si67_dtvalidade date NOT NULL,
				si67_naturezaprocedimento bigint DEFAULT 0 NOT NULL,
				si67_dtpublicacaoavisointencao date,
				si67_objetoadesao character varying(500) NOT NULL,
				si67_cpfresponsavel character varying(11) NOT NULL,
				si67_descontotabela bigint DEFAULT 0 NOT NULL,
				si67_processoporlote bigint DEFAULT 0 NOT NULL,
				si67_mes bigint DEFAULT 0 NOT NULL,
				si67_instit bigint DEFAULT 0);
				
				ALTER TABLE regadesao102020 OWNER TO dbportal;
			
				
				ALTER TABLE regadesao102020_si67_sequencial_seq OWNER TO dbportal;
				
				 --
				 -- Name: regadesao102020_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
				 --
			
				ALTER TABLE ONLY regadesao102020
					ADD CONSTRAINT regadesao102020_sequ_pk PRIMARY KEY (si67_sequencial);
			
				
				--
				-- Name: regadesao112020; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
				--
			
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
			
				
				ALTER TABLE regadesao112020_si68_sequencial_seq OWNER TO dbportal;
			
				--
				-- Name: regadesao112020_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
				--
			
				ALTER TABLE ONLY regadesao112020
					ADD CONSTRAINT regadesao112020_sequ_pk PRIMARY KEY (si68_sequencial);
			
			
				--
				-- Name: regadesao122020; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
				--
			
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
			
					ALTER TABLE regadesao122020_si69_sequencial_seq OWNER TO dbportal;
					
				--
				-- Name: regadesao122020_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
				--
			
				ALTER TABLE ONLY regadesao122020
					ADD CONSTRAINT regadesao122020_sequ_pk PRIMARY KEY (si69_sequencial);
					
				--
				-- Name: regadesao132020; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
				--
			
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
			
				--
				-- Name: regadesao132020_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
				--
			
				ALTER TABLE ONLY regadesao132020
					ADD CONSTRAINT regadesao132020_sequ_pk PRIMARY KEY (si70_sequencial);
				--
				-- Name: regadesao142020; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
				--
			
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
			
				--
				-- Name: regadesao142020_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
				--
			
				ALTER TABLE ONLY regadesao142020
					ADD CONSTRAINT regadesao142020_sequ_pk PRIMARY KEY (si71_sequencial);
					
				--
				-- Name: regadesao152020; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:
				--
			
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
			
				
				--
				-- Name: regadesao152020_sequ_pk; Type: CONSTRAINT; Schema: public; Owner: dbportal; Tablespace:
				--
			
				ALTER TABLE ONLY regadesao152020
					ADD CONSTRAINT regadesao152020_sequ_pk PRIMARY KEY (si72_sequencial);
			
								
				-- Criação dos índices
				
				--
				-- Name: regadesao112020_si68_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
				--
				
				CREATE INDEX regadesao112020_si68_reg10_index ON regadesao112020 USING btree (si68_reg10);
				
				--
				-- Name: regadesao122020_si69_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
				--
				
				CREATE INDEX regadesao122020_si69_reg10_index ON regadesao122020 USING btree (si69_reg10);
				
				--
				-- Name: regadesao132020_si70_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
				--
				
				CREATE INDEX regadesao132020_si70_reg10_index ON regadesao132020 USING btree (si70_reg10);
				
				--
				-- Name: regadesao142020_si71_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
				--
				
				CREATE INDEX regadesao142020_si71_reg10_index ON regadesao142020 USING btree (si71_reg10);
				
				--
				-- Name: regadesao152020_si72_reg10_index; Type: INDEX; Schema: public; Owner: dbportal; Tablespace:
				--
				
				CREATE INDEX regadesao152020_si72_reg10_index ON regadesao152020 USING btree (si72_reg10);
			
				-- Chaves estrangeiras
				
				--
				-- Name: regadesao112020_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
				--
				
				ALTER TABLE ONLY regadesao112020
					ADD CONSTRAINT regadesao112020_reg10_fk FOREIGN KEY (si68_reg10) REFERENCES regadesao102020(si67_sequencial);
				
				
				--
				-- Name: regadesao122020_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
				--
				
				ALTER TABLE ONLY regadesao122020
					ADD CONSTRAINT regadesao122020_reg10_fk FOREIGN KEY (si69_reg10) REFERENCES regadesao102020(si67_sequencial);
							
				--
				-- Name: regadesao132020_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
				--
				
				ALTER TABLE ONLY regadesao132020
					ADD CONSTRAINT regadesao132020_reg10_fk FOREIGN KEY (si70_reg10) REFERENCES regadesao102020(si67_sequencial);
								
				--
				-- Name: regadesao142020_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
				--
				
				ALTER TABLE ONLY regadesao142020
					ADD CONSTRAINT regadesao142020_reg10_fk FOREIGN KEY (si71_reg10) REFERENCES regadesao102020(si67_sequencial);
				
				--
				-- Name: regadesao152020_reg10_fk; Type: FK CONSTRAINT; Schema: public; Owner: dbportal
				--
				
				ALTER TABLE ONLY regadesao152020
					ADD CONSTRAINT regadesao152020_reg10_fk FOREIGN KEY (si72_reg10) REFERENCES regadesao102020(si67_sequencial);

  				";
		$this->execute($sql);
    }

    public function down(){
    	$sql = "ALTER TABLE adesaoregprecos DROP COLUMN si06_cadinicial, DROP COLUMN si06_edital, DROP COLUMN si06_exercicioedital";
		$this->execute($sql);
	}
}
