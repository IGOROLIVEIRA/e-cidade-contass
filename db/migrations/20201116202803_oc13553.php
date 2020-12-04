<?php

use Phinx\Migration\AbstractMigration;

class Oc13553 extends AbstractMigration
{
    public function up(){
		$sql = "
			CREATE SCHEMA sicom2021;

			CREATE TABLE sicom2021.contratos102021 (
					si83_sequencial bigint DEFAULT 0 NOT NULL,
					si83_tiporegistro bigint DEFAULT 0 NOT NULL,
					si83_tipocadastro bigint,
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
					si83_unidadedemedidaprazoexec bigint default 0,
					si83_prazoexecucao bigint,
					si83_multarescisoria character varying(100),
					si83_multainadimplemento character varying(100),
					si83_garantia bigint DEFAULT 0,
					si83_cpfsignatariocontratante character varying(11) NOT NULL,
					si83_datapublicacao date NOT NULL,
					si83_veiculodivulgacao character varying(50) NOT NULL,
					si83_mes bigint DEFAULT 0 NOT NULL,
					si83_instit bigint DEFAULT 0
				);
			
			
			CREATE SEQUENCE sicom2021.contratos102021_si83_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
			
			CREATE TABLE sicom2021.contratos112021 (
				si84_sequencial bigint DEFAULT 0 NOT NULL,
				si84_tiporegistro bigint DEFAULT 0 NOT NULL,
				si84_codcontrato bigint DEFAULT 0 NOT NULL,
				si84_coditem bigint DEFAULT 0 NOT NULL,
				si84_tipomaterial bigint default 0,
				si84_coditemsinapi character varying(15),
				si84_coditemsimcro character varying(15),
				si84_descoutrosmateriais character varying(250),
				si84_itemplanilha bigint default 0,
				si84_quantidadeitem double precision DEFAULT 0 NOT NULL,
				si84_valorunitarioitem double precision DEFAULT 0 NOT NULL,
				si84_mes bigint DEFAULT 0 NOT NULL,
				si84_reg10 bigint DEFAULT 0 NOT NULL,
				si84_instit bigint DEFAULT 0
			);
			
			
			CREATE SEQUENCE sicom2021.contratos112021_si84_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
			
			CREATE TABLE sicom2021.contratos122021 (
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
			
			CREATE SEQUENCE sicom2021.contratos122021_si85_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
			CREATE TABLE sicom2021.contratos132021 (
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
			
			
			CREATE SEQUENCE sicom2021.contratos132021_si86_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
			
			CREATE TABLE sicom2021.contratos202021 (
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
			
			
			CREATE SEQUENCE sicom2021.contratos202021_si87_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
			
			CREATE TABLE sicom2021.contratos212021 (
				si88_sequencial bigint DEFAULT 0 NOT NULL,
				si88_tiporegistro bigint DEFAULT 0 NOT NULL,
				si88_codaditivo bigint DEFAULT 0 NOT NULL,
				si88_coditem bigint DEFAULT 0 NOT NULL,
				si88_tipomaterial bigint default 0,
				si88_coditemsinapi character varying(15),
				si88_coditemsimcro character varying(15),
				si88_descoutrosmateriais character varying(250),
				si88_itemplanilha bigint default 0,
				si88_tipoalteracaoitem bigint DEFAULT 0 NOT NULL,
				si88_quantacrescdecresc double precision DEFAULT 0 NOT NULL,
				si88_valorunitarioitem double precision DEFAULT 0 NOT NULL,
				si88_mes bigint DEFAULT 0 NOT NULL,
				si88_reg20 bigint DEFAULT 0 NOT NULL,
				si88_instit bigint DEFAULT 0
			);
			
			
			CREATE SEQUENCE sicom2021.contratos212021_si88_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
			
			CREATE TABLE sicom2021.contratos302021 (
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
			
			CREATE SEQUENCE sicom2021.contratos302021_si89_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
			
			CREATE TABLE sicom2021.contratos402021 (
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
			
			CREATE SEQUENCE sicom2021.contratos402021_si91_sequencial_seq
			START WITH 1
			INCREMENT BY 1
			NO MINVALUE
			NO MAXVALUE
			CACHE 1;
			
					

		";
//		$this->execute($sql);
    }

    public function down(){

	}
}
