<?php

use Phinx\Migration\AbstractMigration;

class DpTabelassicom extends AbstractMigration
{
    public function up()
    {
      $sql = <<<SQL


-- aberlic102021 definition

-- Drop table

-- DROP TABLE aberlic102021;

CREATE TABLE aberlic102021 (
    si46_sequencial int8 NOT NULL DEFAULT 0,
    si46_tiporegistro int8 NOT NULL DEFAULT 0,
    si46_tipocadastro int8 NOT NULL DEFAULT 0,
    si46_codorgaoresp varchar(2) NOT NULL,
    si46_codunidadesubresp varchar(8) NOT NULL,
    si46_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si46_nroprocessolicitatorio varchar(12) NOT NULL,
    si46_codmodalidadelicitacao int8 NOT NULL DEFAULT 0,
    si46_nroedital int8 NOT NULL DEFAULT 0,
    si46_exercicioedital int8 NOT NULL DEFAULT 0,
    si46_naturezaprocedimento int8 NOT NULL DEFAULT 0,
    si46_dtabertura date NOT NULL,
    si46_dteditalconvite date NOT NULL,
    si46_dtpublicacaoeditaldo date NULL,
    si46_dtpublicacaoeditalveiculo1 date NULL,
    si46_veiculo1publicacao varchar(50) NULL,
    si46_dtpublicacaoeditalveiculo2 date NULL,
    si46_veiculo2publicacao varchar(50) NULL,
    si46_dtrecebimentodoc date NOT NULL,
    si46_tipolicitacao int8 NULL,
    si46_naturezaobjeto int8 NULL,
    si46_objeto varchar(500) NOT NULL,
    si46_regimeexecucaoobras int8 NULL DEFAULT 0,
    si46_nroconvidado int8 NULL DEFAULT 0,
    si46_clausulaprorrogacao varchar(250) NULL,
    si46_unidademedidaprazoexecucao int8 NOT NULL DEFAULT 0,
    si46_prazoexecucao int8 NOT NULL DEFAULT 0,
    si46_formapagamento varchar(80) NOT NULL,
    si46_criterioaceitabilidade varchar(80) NULL,
    si46_criterioadjudicacao int8 NOT NULL DEFAULT 0,
    si46_processoporlote int8 NOT NULL DEFAULT 0,
    si46_criteriodesempate int8 NOT NULL DEFAULT 0,
    si46_destinacaoexclusiva int8 NOT NULL DEFAULT 0,
    si46_subcontratacao int8 NOT NULL DEFAULT 0,
    si46_limitecontratacao int8 NOT NULL DEFAULT 0,
    si46_mes int8 NOT NULL DEFAULT 0,
    si46_instit int8 NULL DEFAULT 0,
    CONSTRAINT aberlic102021_sequ_pk PRIMARY KEY (si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aex102021 definition

-- Drop table

-- DROP TABLE aex102021;

CREATE TABLE aex102021 (
    si130_sequencial int8 NOT NULL DEFAULT 0,
    si130_tiporegistro int8 NOT NULL DEFAULT 0,
    si130_codext int8 NOT NULL DEFAULT 0,
    si130_codfontrecursos int8 NOT NULL DEFAULT 0,
    si130_nroop int8 NOT NULL DEFAULT 0,
    si130_codunidadesub varchar(8) NOT NULL,
    si130_dtpagamento date NOT NULL,
    si130_nroanulacaoop int8 NOT NULL DEFAULT 0,
    si130_dtanulacaoop date NOT NULL,
    si130_vlanulacaoop float8 NOT NULL DEFAULT 0,
    si130_mes int8 NOT NULL DEFAULT 0,
    si130_instit int8 NULL DEFAULT 0,
    CONSTRAINT aex112021_sequ_pk PRIMARY KEY (si130_sequencial)
)
WITH (
    OIDS=TRUE
);


-- alq102021 definition

-- Drop table

-- DROP TABLE alq102021;

CREATE TABLE alq102021 (
    si121_sequencial int8 NOT NULL DEFAULT 0,
    si121_tiporegistro int8 NOT NULL DEFAULT 0,
    si121_codreduzido int8 NOT NULL DEFAULT 0,
    si121_codorgao varchar(2) NOT NULL,
    si121_codunidadesub varchar(8) NOT NULL,
    si121_nroempenho int8 NOT NULL DEFAULT 0,
    si121_dtempenho date NOT NULL,
    si121_dtliquidacao date NOT NULL,
    si121_nroliquidacao int8 NOT NULL DEFAULT 0,
    si121_dtanulacaoliq date NOT NULL,
    si121_nroliquidacaoanl int8 NOT NULL DEFAULT 0,
    si121_tpliquidacao int8 NOT NULL DEFAULT 0,
    si121_justificativaanulacao varchar(500) NOT NULL,
    si121_vlanulado float8 NOT NULL DEFAULT 0,
    si121_mes int8 NOT NULL DEFAULT 0,
    si121_instit int8 NULL DEFAULT 0,
    CONSTRAINT alq102021_sequ_pk PRIMARY KEY (si121_sequencial)
)
WITH (
    OIDS=TRUE
);


-- anl102021 definition

-- Drop table

-- DROP TABLE anl102021;

CREATE TABLE anl102021 (
    si110_sequencial int8 NOT NULL DEFAULT 0,
    si110_tiporegistro int8 NOT NULL DEFAULT 0,
    si110_codorgao varchar(2) NOT NULL,
    si110_codunidadesub varchar(8) NOT NULL,
    si110_nroempenho int8 NOT NULL DEFAULT 0,
    si110_dtempenho date NOT NULL,
    si110_dtanulacao date NOT NULL,
    si110_nroanulacao int8 NOT NULL DEFAULT 0,
    si110_tipoanulacao int8 NOT NULL DEFAULT 0,
    si110_especanulacaoempenho varchar(200) NOT NULL,
    si110_vlanulacao float8 NOT NULL DEFAULT 0,
    si110_mes int8 NOT NULL DEFAULT 0,
    si110_instit int8 NULL DEFAULT 0,
    CONSTRAINT anl102021_sequ_pk PRIMARY KEY (si110_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aob102021 definition

-- Drop table

-- DROP TABLE aob102021;

CREATE TABLE aob102021 (
    si141_sequencial int8 NOT NULL DEFAULT 0,
    si141_tiporegistro int8 NOT NULL DEFAULT 0,
    si141_codreduzido int8 NOT NULL DEFAULT 0,
    si141_codorgao varchar(2) NOT NULL,
    si141_codunidadesub varchar(8) NOT NULL,
    si141_nrolancamento int8 NOT NULL DEFAULT 0,
    si141_dtlancamento date NOT NULL,
    si141_tipolancamento int8 NOT NULL DEFAULT 0,
    si141_nroanulacaolancamento int8 NOT NULL DEFAULT 0,
    si141_dtanulacaolancamento date NOT NULL,
    si141_nroempenho int8 NOT NULL DEFAULT 0,
    si141_dtempenho date NOT NULL,
    si141_nroliquidacao int8 NULL DEFAULT 0,
    si141_dtliquidacao date NULL,
    si141_valoranulacaolancamento float8 NOT NULL DEFAULT 0,
    si141_mes int8 NOT NULL DEFAULT 0,
    si141_instit int8 NULL DEFAULT 0,
    CONSTRAINT aob102021_sequ_pk PRIMARY KEY (si141_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aoc102021 definition

-- Drop table

-- DROP TABLE aoc102021;

CREATE TABLE aoc102021 (
    si38_sequencial int8 NOT NULL DEFAULT 0,
    si38_tiporegistro int8 NOT NULL DEFAULT 0,
    si38_codorgao varchar(2) NOT NULL,
    si38_nrodecreto varchar(8) NOT NULL DEFAULT 0,
    si38_datadecreto date NOT NULL,
    si38_mes int8 NOT NULL DEFAULT 0,
    si38_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc102021_sequ_pk PRIMARY KEY (si38_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aop102021 definition

-- Drop table

-- DROP TABLE aop102021;

CREATE TABLE aop102021 (
    si137_sequencial int8 NOT NULL DEFAULT 0,
    si137_tiporegistro int8 NOT NULL DEFAULT 0,
    si137_codreduzido int8 NOT NULL DEFAULT 0,
    si137_codorgao varchar(2) NOT NULL,
    si137_codunidadesub varchar(8) NOT NULL,
    si137_nroop int8 NOT NULL DEFAULT 0,
    si137_dtpagamento date NOT NULL,
    si137_nroanulacaoop int8 NOT NULL DEFAULT 0,
    si137_dtanulacaoop date NOT NULL,
    si137_justificativaanulacao varchar(500) NOT NULL,
    si137_vlanulacaoop float8 NOT NULL DEFAULT 0,
    si137_mes int8 NOT NULL DEFAULT 0,
    si137_instit int8 NULL DEFAULT 0,
    CONSTRAINT aop102021_sequ_pk PRIMARY KEY (si137_sequencial)
)
WITH (
    OIDS=TRUE
);


-- arc102021 definition

-- Drop table

-- DROP TABLE arc102021;

CREATE TABLE arc102021 (
    si28_sequencial int8 NOT NULL DEFAULT 0,
    si28_tiporegistro int8 NOT NULL DEFAULT 0,
    si28_codcorrecao int8 NOT NULL DEFAULT 0,
    si28_codorgao varchar(2) NOT NULL,
    si28_ededucaodereceita int8 NOT NULL DEFAULT 0,
    si28_identificadordeducaorecreduzida int8 NULL DEFAULT 0,
    si28_naturezareceitareduzida int8 NOT NULL DEFAULT 0,
    si28_identificadordeducaorecacrescida int8 NULL DEFAULT 0,
    si28_naturezareceitaacrescida int8 NOT NULL DEFAULT 0,
    si28_vlreduzidoacrescido float8 NOT NULL DEFAULT 0,
    si28_mes int8 NOT NULL DEFAULT 0,
    si28_instit int8 NULL DEFAULT 0,
    CONSTRAINT arc102021_sequ_pk PRIMARY KEY (si28_sequencial)
)
WITH (
    OIDS=TRUE
);


-- arc202021 definition

-- Drop table

-- DROP TABLE arc202021;

CREATE TABLE arc202021 (
    si31_sequencial int8 NOT NULL DEFAULT 0,
    si31_tiporegistro int8 NOT NULL DEFAULT 0,
    si31_codorgao varchar(2) NOT NULL,
    si31_codestorno int8 NOT NULL DEFAULT 0,
    si31_ededucaodereceita int8 NOT NULL DEFAULT 0,
    si31_identificadordeducao int8 NULL,
    si31_naturezareceitaestornada int8 NOT NULL DEFAULT 0,
    si31_vlestornado float8 NOT NULL DEFAULT 0,
    si31_mes int8 NOT NULL DEFAULT 0,
    si31_instit int8 NULL DEFAULT 0,
    CONSTRAINT arc202021_sequ_pk PRIMARY KEY (si31_sequencial)
)
WITH (
    OIDS=TRUE
);


-- caixa102021 definition

-- Drop table

-- DROP TABLE caixa102021;

CREATE TABLE caixa102021 (
    si103_sequencial int8 NOT NULL DEFAULT 0,
    si103_tiporegistro int8 NOT NULL DEFAULT 0,
    si103_codorgao varchar(2) NOT NULL,
    si103_vlsaldoinicial float8 NOT NULL DEFAULT 0,
    si103_vlsaldofinal float8 NOT NULL DEFAULT 0,
    si103_mes int8 NOT NULL DEFAULT 0,
    si103_instit int8 NULL DEFAULT 0,
    CONSTRAINT caixa102021_sequ_pk PRIMARY KEY (si103_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge102021 definition

-- Drop table

-- DROP TABLE conge102021;

CREATE TABLE conge102021 (
    si182_sequencial int8 NOT NULL DEFAULT 0,
    si182_tiporegistro int8 NOT NULL DEFAULT 0,
    si182_codconvenioconge int8 NOT NULL DEFAULT 0,
    si182_codorgao varchar(2) NOT NULL,
    si182_codunidadesub varchar(8) NOT NULL,
    si182_nroconvenioconge varchar(30) NOT NULL,
    si182_dscinstrumento varchar(50) NOT NULL,
    si182_dataassinaturaconge date NOT NULL,
    si182_datapublicconge date NOT NULL,
    si182_nrocpfrespconge varchar(11) NOT NULL,
    si182_dsccargorespconge varchar(50) NOT NULL,
    si182_objetoconvenioconge varchar(500) NOT NULL,
    si182_datainiciovigenciaconge date NOT NULL,
    si182_datafinalvigenciaconge date NOT NULL,
    si182_formarepasse int8 NOT NULL,
    si182_tipodocumentoincentivador int8 NULL,
    si182_nrodocumentoincentivador varchar(14) NULL,
    si182_quantparcelas int8 NULL,
    si182_vltotalconvenioconge float8 NOT NULL DEFAULT 0,
    si182_vlcontrapartidaconge float8 NOT NULL DEFAULT 0,
    si182_tipodocumentobeneficiario int8 NOT NULL DEFAULT 0,
    si182_nrodocumentobeneficiario varchar(14) NOT NULL DEFAULT 0,
    si182_mes int8 NOT NULL DEFAULT 0,
    si182_instit int8 NULL DEFAULT 0,
    CONSTRAINT conge102021_sequ_pk PRIMARY KEY (si182_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge202021 definition

-- Drop table

-- DROP TABLE conge202021;

CREATE TABLE conge202021 (
    si183_sequencial int8 NOT NULL DEFAULT 0,
    si183_tiporegistro int8 NOT NULL DEFAULT 0,
    si183_codorgao varchar(2) NOT NULL,
    si183_codunidadesub varchar(8) NOT NULL,
    si183_nroconvenioconge varchar(30) NOT NULL,
    si183_dataassinaturaconvoriginalconge date NOT NULL,
    si183_nroseqtermoaditivoconge int8 NOT NULL DEFAULT 0,
    si183_dscalteracaoconge varchar(500) NOT NULL DEFAULT 0,
    si183_dataassinaturatermoaditivoconge date NOT NULL,
    si183_datafinalvigenciaconge date NOT NULL,
    si183_valoratualizadoconvenioconge float8 NOT NULL,
    si183_valoratualizadocontrapartidaconge float8 NOT NULL,
    si183_mes int8 NOT NULL DEFAULT 0,
    si183_instit int8 NULL DEFAULT 0,
    CONSTRAINT conge202021_sequ_pk PRIMARY KEY (si183_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge302021 definition

-- Drop table

-- DROP TABLE conge302021;

CREATE TABLE conge302021 (
    si184_sequencial int8 NOT NULL DEFAULT 0,
    si184_tiporegistro int8 NOT NULL DEFAULT 0,
    si184_codorgao varchar(2) NOT NULL,
    si184_codunidadesub varchar(8) NOT NULL,
    si184_nroconvenioconge varchar(30) NOT NULL,
    si184_dataassinaturaconvoriginalconge date NOT NULL,
    si184_numeroparcela int8 NOT NULL DEFAULT 0,
    si184_datarepasseconge int8 NOT NULL DEFAULT 0,
    si184_vlrepassadoconge float8 NOT NULL,
    si184_banco varchar(3) NOT NULL DEFAULT 0,
    si184_agencia varchar(6) NOT NULL DEFAULT 0,
    si184_digitoverificadoragencia varchar(2) NOT NULL DEFAULT 0,
    si184_contabancaria varchar(12) NOT NULL DEFAULT 0,
    si184_digitoverificadorcontabancaria varchar(2) NOT NULL DEFAULT 0,
    si184_tipodocumentotitularconta int8 NOT NULL DEFAULT 0,
    si184_nrodocumentotitularconta varchar(14) NOT NULL DEFAULT 0,
    si184_prazoprestacontas date NOT NULL,
    si184_mes int8 NOT NULL DEFAULT 0,
    si184_instit int8 NULL DEFAULT 0,
    CONSTRAINT conge302021_sequ_pk PRIMARY KEY (si184_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge402021 definition

-- Drop table

-- DROP TABLE conge402021;

CREATE TABLE conge402021 (
    si237_sequencial int8 NOT NULL DEFAULT 0,
    si237_tiporegistro int8 NOT NULL DEFAULT 0,
    si237_codorgao varchar(2) NOT NULL,
    si237_codunidadesub varchar(8) NOT NULL,
    si237_nroconvenioconge varchar(30) NOT NULL,
    si237_dataassinaturaconvoriginalconge date NOT NULL,
    si237_datarepasseconge int8 NOT NULL DEFAULT 0,
    si237_prestacaocontasparcela int8 NOT NULL,
    si237_dataprestacontasparcela date NULL,
    si237_prestacaocontas int8 NULL,
    si237_datacienfatos date NULL,
    si237_prorrogprazo int8 NOT NULL DEFAULT 0,
    si237_dataprorrogprazo date NULL,
    si237_nrocpfrespprestconge varchar(11) NULL,
    si237_dsccargorespprestconge varchar(50) NULL,
    si237_mes int8 NOT NULL DEFAULT 0,
    si237_instit int8 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- conge502021 definition

-- Drop table

-- DROP TABLE conge502021;

CREATE TABLE conge502021 (
    si238_sequencial int8 NOT NULL DEFAULT 0,
    si238_tiporegistro int8 NOT NULL DEFAULT 0,
    si238_codorgao varchar(2) NOT NULL,
    si238_codunidadesub varchar(8) NOT NULL,
    si238_nroconvenioconge varchar(30) NOT NULL,
    si238_dataassinaturaconvoriginalconge date NOT NULL,
    si238_dscmedidaadministrativa varchar(500) NOT NULL,
    si238_datainiciomedida date NOT NULL,
    si238_datafinalmedida date NOT NULL,
    si238_adocaomedidasadmin int8 NOT NULL DEFAULT 0,
    si238_nrocpfrespmedidaconge varchar(11) NOT NULL,
    si238_dsccargorespmedidaconge varchar(50) NOT NULL,
    si238_mes int8 NOT NULL DEFAULT 0,
    si238_instit int8 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- consid102021 definition

-- Drop table

-- DROP TABLE consid102021;

CREATE TABLE consid102021 (
    si158_sequencial int8 NOT NULL DEFAULT 0,
    si158_tiporegistro int8 NOT NULL DEFAULT 0,
    si158_codarquivo varchar(20) NOT NULL,
    si158_exercicioreferenciaconsid int8 NULL DEFAULT 0,
    si158_mesreferenciaconsid varchar(2) NULL,
    si158_consideracoes varchar(4000) NOT NULL,
    si158_mes int8 NULL,
    si158_instit int8 NULL,
    CONSTRAINT consid102021_sequ_pk PRIMARY KEY (si158_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor102021 definition

-- Drop table

-- DROP TABLE consor102021;

CREATE TABLE consor102021 (
    si16_sequencial int8 NOT NULL DEFAULT 0,
    si16_tiporegistro int8 NOT NULL DEFAULT 0,
    si16_codorgao varchar(2) NOT NULL,
    si16_cnpjconsorcio varchar(14) NOT NULL,
    si16_areaatuacao varchar(2) NOT NULL,
    si16_descareaatuacao varchar(150) NULL,
    si16_mes int8 NOT NULL DEFAULT 0,
    si16_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor102021_sequ_pk PRIMARY KEY (si16_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor202021 definition

-- Drop table

-- DROP TABLE consor202021;

CREATE TABLE consor202021 (
    si17_sequencial int8 NOT NULL DEFAULT 0,
    si17_tiporegistro int8 NOT NULL DEFAULT 0,
    si17_codorgao varchar(2) NOT NULL,
    si17_cnpjconsorcio varchar(14) NOT NULL,
    si17_codfontrecursos int8 NOT NULL DEFAULT 0,
    si17_vltransfrateio float8 NOT NULL DEFAULT 0,
    si17_prestcontas int8 NOT NULL DEFAULT 0,
    si17_mes int8 NOT NULL DEFAULT 0,
    si17_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor202021_sequ_pk PRIMARY KEY (si17_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor302021 definition

-- Drop table

-- DROP TABLE consor302021;

CREATE TABLE consor302021 (
    si18_sequencial int8 NOT NULL DEFAULT 0,
    si18_tiporegistro int8 NOT NULL DEFAULT 0,
    si18_cnpjconsorcio varchar(14) NOT NULL,
    si18_mesreferencia varchar(2) NOT NULL,
    si18_codfuncao varchar(2) NOT NULL,
    si18_codsubfuncao varchar(3) NOT NULL,
    si18_naturezadespesa int8 NOT NULL DEFAULT 0,
    si18_subelemento varchar(2) NOT NULL,
    si18_codfontrecursos int8 NOT NULL DEFAULT 0,
    si18_vlempenhadofonte float8 NOT NULL DEFAULT 0,
    si18_vlanulacaoempenhofonte float8 NOT NULL DEFAULT 0,
    si18_vlliquidadofonte float8 NOT NULL DEFAULT 0,
    si18_vlanulacaoliquidacaofonte float8 NOT NULL DEFAULT 0,
    si18_vlpagofonte float8 NOT NULL DEFAULT 0,
    si18_vlanulacaopagamentofonte float8 NOT NULL DEFAULT 0,
    si18_mes int8 NOT NULL DEFAULT 0,
    si18_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor302021_sequ_pk PRIMARY KEY (si18_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor402021 definition

-- Drop table

-- DROP TABLE consor402021;

CREATE TABLE consor402021 (
    si19_sequencial int8 NOT NULL DEFAULT 0,
    si19_tiporegistro int8 NOT NULL DEFAULT 0,
    si19_cnpjconsorcio varchar(14) NOT NULL,
    si19_codfontrecursos int8 NOT NULL DEFAULT 0,
    si19_vldispcaixa float8 NOT NULL DEFAULT 0,
    si19_mes int8 NOT NULL DEFAULT 0,
    si19_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor402021_sequ_pk PRIMARY KEY (si19_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor502021 definition

-- Drop table

-- DROP TABLE consor502021;

CREATE TABLE consor502021 (
    si20_sequencial int8 NOT NULL DEFAULT 0,
    si20_tiporegistro int8 NOT NULL DEFAULT 0,
    si20_codorgao varchar(2) NOT NULL,
    si20_cnpjconsorcio varchar(14) NOT NULL,
    si20_tipoencerramento int8 NOT NULL DEFAULT 0,
    si20_dtencerramento date NOT NULL,
    si20_mes int8 NOT NULL DEFAULT 0,
    si20_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor502021_sequ_pk PRIMARY KEY (si20_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos102021 definition

-- Drop table

-- DROP TABLE contratos102021;

CREATE TABLE contratos102021 (
    si83_sequencial int8 NOT NULL DEFAULT 0,
    si83_tiporegistro int8 NOT NULL DEFAULT 0,
    si83_tipocadastro int8 NULL,
    si83_codcontrato int8 NOT NULL DEFAULT 0,
    si83_codorgao varchar(2) NOT NULL,
    si83_codunidadesub varchar(8) NOT NULL,
    si83_nrocontrato int8 NOT NULL DEFAULT 0,
    si83_exerciciocontrato int8 NOT NULL DEFAULT 0,
    si83_dataassinatura date NOT NULL,
    si83_contdeclicitacao int8 NOT NULL DEFAULT 0,
    si83_codorgaoresp varchar(2) NULL,
    si83_codunidadesubresp varchar(8) NULL,
    si83_nroprocesso varchar(12) NULL,
    si83_exercicioprocesso int8 NULL DEFAULT 0,
    si83_tipoprocesso int8 NULL DEFAULT 0,
    si83_naturezaobjeto int8 NOT NULL DEFAULT 0,
    si83_objetocontrato varchar(500) NOT NULL,
    si83_tipoinstrumento int8 NOT NULL DEFAULT 0,
    si83_datainiciovigencia date NOT NULL,
    si83_datafinalvigencia date NOT NULL,
    si83_vlcontrato float8 NOT NULL DEFAULT 0,
    si83_formafornecimento varchar(50) NULL,
    si83_formapagamento varchar(100) NULL,
    si83_unidadedemedidaprazoexex int8 NULL DEFAULT 0,
    si83_prazoexecucao int8 NULL,
    si83_multarescisoria varchar(100) NULL,
    si83_multainadimplemento varchar(100) NULL,
    si83_garantia int8 NULL DEFAULT 0,
    si83_cpfsignatariocontratante varchar(11) NOT NULL,
    si83_datapublicacao date NOT NULL,
    si83_veiculodivulgacao varchar(50) NOT NULL,
    si83_mes int8 NOT NULL DEFAULT 0,
    si83_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos102021_sequ_pk PRIMARY KEY (si83_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos122021 definition

-- Drop table

-- DROP TABLE contratos122021;

CREATE TABLE contratos122021 (
    si85_sequencial int8 NOT NULL DEFAULT 0,
    si85_tiporegistro int8 NOT NULL DEFAULT 0,
    si85_codcontrato int8 NOT NULL DEFAULT 0,
    si85_codorgao varchar(2) NOT NULL,
    si85_codunidadesub varchar(8) NOT NULL,
    si85_codfuncao varchar(2) NOT NULL,
    si85_codsubfuncao varchar(3) NOT NULL,
    si85_codprograma varchar(4) NOT NULL,
    si85_idacao varchar(4) NOT NULL,
    si85_idsubacao varchar(4) NULL,
    si85_naturezadespesa int8 NOT NULL DEFAULT 0,
    si85_codfontrecursos int8 NOT NULL DEFAULT 0,
    si85_vlrecurso float8 NOT NULL DEFAULT 0,
    si85_mes int8 NOT NULL DEFAULT 0,
    si85_reg10 int8 NOT NULL DEFAULT 0,
    si85_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos122021_sequ_pk PRIMARY KEY (si85_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX contratos122021_si85_reg10_index ON contratos122021 USING btree (si85_reg10);


-- contratos132021 definition

-- Drop table

-- DROP TABLE contratos132021;

CREATE TABLE contratos132021 (
    si86_sequencial int8 NOT NULL DEFAULT 0,
    si86_tiporegistro int8 NOT NULL DEFAULT 0,
    si86_codcontrato int8 NOT NULL DEFAULT 0,
    si86_tipodocumento int8 NOT NULL DEFAULT 0,
    si86_nrodocumento varchar(14) NOT NULL,
    si86_cpfrepresentantelegal varchar(11) NOT NULL,
    si86_mes int8 NOT NULL DEFAULT 0,
    si86_reg10 int8 NOT NULL DEFAULT 0,
    si86_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos132021_sequ_pk PRIMARY KEY (si86_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX contratos132021_si86_reg10_index ON contratos132021 USING btree (si86_reg10);


-- contratos202021 definition

-- Drop table

-- DROP TABLE contratos202021;

CREATE TABLE contratos202021 (
    si87_sequencial int8 NOT NULL DEFAULT 0,
    si87_tiporegistro int8 NOT NULL DEFAULT 0,
    si87_codaditivo int8 NOT NULL DEFAULT 0,
    si87_codorgao varchar(2) NOT NULL,
    si87_codunidadesub varchar(8) NOT NULL,
    si87_nrocontrato int8 NOT NULL DEFAULT 0,
    si87_dtassinaturacontoriginal date NULL,
    si87_nroseqtermoaditivo varchar(2) NOT NULL,
    si87_dtassinaturatermoaditivo date NOT NULL,
    si87_tipoalteracaovalor int8 NOT NULL DEFAULT 0,
    si87_tipotermoaditivo varchar(2) NOT NULL,
    si87_dscalteracao varchar(250) NULL,
    si87_novadatatermino date NULL,
    si87_valoraditivo float8 NOT NULL DEFAULT 0,
    si87_datapublicacao date NOT NULL,
    si87_veiculodivulgacao varchar(50) NOT NULL,
    si87_mes int8 NOT NULL DEFAULT 0,
    si87_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos202021_sequ_pk PRIMARY KEY (si87_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos302021 definition

-- Drop table

-- DROP TABLE contratos302021;

CREATE TABLE contratos302021 (
    si89_sequencial int8 NOT NULL DEFAULT 0,
    si89_tiporegistro int8 NOT NULL DEFAULT 0,
    si89_codorgao varchar(2) NOT NULL,
    si89_codunidadesub varchar(8) NOT NULL,
    si89_nrocontrato int8 NOT NULL DEFAULT 0,
    si89_dtassinaturacontoriginal date NOT NULL,
    si89_tipoapostila varchar(2) NOT NULL,
    si89_nroseqapostila int8 NOT NULL DEFAULT 0,
    si89_dataapostila date NOT NULL,
    si89_tipoalteracaoapostila int8 NOT NULL DEFAULT 0,
    si89_dscalteracao varchar(250) NOT NULL,
    si89_valorapostila float8 NOT NULL DEFAULT 0,
    si89_mes int8 NOT NULL DEFAULT 0,
    si89_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos302021_sequ_pk PRIMARY KEY (si89_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos402021 definition

-- Drop table

-- DROP TABLE contratos402021;

CREATE TABLE contratos402021 (
    si91_sequencial int8 NOT NULL DEFAULT 0,
    si91_tiporegistro int8 NOT NULL DEFAULT 0,
    si91_codorgao varchar(2) NOT NULL,
    si91_codunidadesub varchar(8) NULL,
    si91_nrocontrato int8 NOT NULL DEFAULT 0,
    si91_dtassinaturacontoriginal date NOT NULL,
    si91_datarescisao date NOT NULL,
    si91_valorcancelamentocontrato float8 NOT NULL DEFAULT 0,
    si91_mes int8 NOT NULL DEFAULT 0,
    si91_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos402021_sequ_pk PRIMARY KEY (si91_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conv102021 definition

-- Drop table

-- DROP TABLE conv102021;

CREATE TABLE conv102021 (
    si92_sequencial int8 NOT NULL DEFAULT 0,
    si92_tiporegistro int8 NOT NULL DEFAULT 0,
    si92_codconvenio int8 NOT NULL DEFAULT 0,
    si92_codorgao varchar(2) NOT NULL,
    si92_nroconvenio varchar(30) NOT NULL,
    si92_dataassinatura date NOT NULL,
    si92_objetoconvenio varchar(500) NOT NULL,
    si92_datainiciovigencia date NOT NULL,
    si92_datafinalvigencia date NOT NULL,
    si92_codfontrecursos int8 NOT NULL DEFAULT 0,
    si92_vlconvenio float8 NOT NULL DEFAULT 0,
    si92_vlcontrapartida float8 NOT NULL DEFAULT 0,
    si92_mes int8 NOT NULL DEFAULT 0,
    si92_instit int8 NULL DEFAULT 0,
    CONSTRAINT conv102021_sequ_pk PRIMARY KEY (si92_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conv202021 definition

-- Drop table

-- DROP TABLE conv202021;

CREATE TABLE conv202021 (
    si94_sequencial int8 NOT NULL DEFAULT 0,
    si94_tiporegistro int8 NOT NULL DEFAULT 0,
    si94_codorgao varchar(2) NOT NULL,
    si94_nroconvenio varchar(30) NOT NULL,
    si94_dtassinaturaconvoriginal date NOT NULL,
    si94_nroseqtermoaditivo varchar(2) NOT NULL,
    si94_codconvaditivo varchar(20) NOT NULL,
    si94_dscalteracao varchar(500) NOT NULL,
    si94_dtassinaturatermoaditivo date NOT NULL,
    si94_datafinalvigencia date NOT NULL,
    si94_valoratualizadoconvenio float8 NOT NULL DEFAULT 0,
    si94_valoratualizadocontrapartida float8 NOT NULL DEFAULT 0,
    si94_mes int8 NOT NULL DEFAULT 0,
    si94_instit int8 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- conv212021 definition

-- Drop table

-- DROP TABLE conv212021;

CREATE TABLE conv212021 (
    si232_sequencial int8 NOT NULL DEFAULT 0,
    si232_tiporegistro int8 NOT NULL DEFAULT 0,
    si232_codconvaditivo varchar(20) NOT NULL,
    si232_tipotermoaditivo varchar(2) NOT NULL,
    si232_dsctipotermoaditivo varchar(250) NULL,
    si232_mes int8 NOT NULL DEFAULT 0,
    si232_instint int8 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- conv302021 definition

-- Drop table

-- DROP TABLE conv302021;

CREATE TABLE conv302021 (
    si203_sequencial int8 NOT NULL DEFAULT 0,
    si203_tiporegistro int8 NOT NULL DEFAULT 0,
    si203_codreceita int8 NOT NULL DEFAULT 0,
    si203_codorgao varchar(2) NOT NULL,
    si203_naturezareceita int8 NOT NULL DEFAULT 0,
    si203_codfontrecursos int8 NOT NULL DEFAULT 0,
    si203_vlprevisao float8 NOT NULL DEFAULT 0,
    si203_mes int8 NOT NULL DEFAULT 0,
    si203_instit int8 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- conv312021 definition

-- Drop table

-- DROP TABLE conv312021;

CREATE TABLE conv312021 (
    si204_sequencial int8 NOT NULL DEFAULT 0,
    si204_tiporegistro int8 NOT NULL DEFAULT 0,
    si204_codreceita int8 NOT NULL DEFAULT 0,
    si204_prevorcamentoassin int8 NOT NULL DEFAULT 0,
    si204_nroconvenio varchar(30) NULL,
    si204_dataassinatura date NULL,
    si204_vlprevisaoconvenio float8 NOT NULL DEFAULT 0,
    si204_mes int8 NOT NULL DEFAULT 0,
    si204_instit int8 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- cronem102021 definition

-- Drop table

-- DROP TABLE cronem102021;

CREATE TABLE cronem102021 (
    si170_sequencial int8 NOT NULL DEFAULT 0,
    si170_tiporegistro int8 NOT NULL DEFAULT 0,
    si170_codorgao varchar(2) NOT NULL DEFAULT 0,
    si170_codunidadesub varchar(8) NOT NULL DEFAULT 0,
    si170_grupodespesa int8 NOT NULL DEFAULT 0,
    si170_vldotmensal float8 NOT NULL DEFAULT 0,
    si170_instit int8 NULL DEFAULT 0,
    si170_mes int8 NULL,
    CONSTRAINT cronem102021_sequ_pk PRIMARY KEY (si170_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb102021 definition

-- Drop table

-- DROP TABLE ctb102021;

CREATE TABLE ctb102021 (
    si95_sequencial int8 NOT NULL DEFAULT 0,
    si95_tiporegistro int8 NOT NULL DEFAULT 0,
    si95_codctb int8 NOT NULL DEFAULT 0,
    si95_codorgao varchar(2) NOT NULL,
    si95_banco varchar(3) NOT NULL,
    si95_agencia varchar(6) NOT NULL,
    si95_digitoverificadoragencia varchar(2) NULL,
    si95_contabancaria int8 NOT NULL DEFAULT 0,
    si95_digitoverificadorcontabancaria varchar(2) NOT NULL,
    si95_tipoconta varchar(2) NOT NULL,
    si95_tipoaplicacao varchar(2) NULL,
    si95_nroseqaplicacao int8 NULL DEFAULT 0,
    si95_desccontabancaria varchar(50) NOT NULL,
    si95_contaconvenio int8 NOT NULL DEFAULT 0,
    si95_nroconvenio varchar(30) NULL,
    si95_dataassinaturaconvenio date NULL,
    si95_mes int8 NOT NULL DEFAULT 0,
    si95_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb102021_sequ_pk PRIMARY KEY (si95_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb202021 definition

-- Drop table

-- DROP TABLE ctb202021;

CREATE TABLE ctb202021 (
    si96_sequencial int8 NOT NULL DEFAULT 0,
    si96_tiporegistro int8 NOT NULL DEFAULT 0,
    si96_codorgao varchar(2) NOT NULL,
    si96_codctb int8 NOT NULL DEFAULT 0,
    si96_codfontrecursos int8 NOT NULL DEFAULT 0,
    si96_vlsaldoinicialfonte float8 NOT NULL DEFAULT 0,
    si96_vlsaldofinalfonte float8 NOT NULL DEFAULT 0,
    si96_mes int8 NOT NULL DEFAULT 0,
    si96_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb202021_sequ_pk PRIMARY KEY (si96_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb302021 definition

-- Drop table

-- DROP TABLE ctb302021;

CREATE TABLE ctb302021 (
    si99_sequencial int8 NOT NULL DEFAULT 0,
    si99_tiporegistro int8 NOT NULL DEFAULT 0,
    si99_codorgao varchar(2) NOT NULL,
    si99_codagentearrecadador int8 NOT NULL DEFAULT 0,
    si99_cnpjagentearrecadador varchar(14) NOT NULL,
    si99_vlsaldoinicial float8 NOT NULL DEFAULT 0,
    si99_vlsaldofinal float8 NOT NULL DEFAULT 0,
    si99_mes int8 NOT NULL DEFAULT 0,
    si99_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb302021_sequ_pk PRIMARY KEY (si99_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb402021 definition

-- Drop table

-- DROP TABLE ctb402021;

CREATE TABLE ctb402021 (
    si101_sequencial int8 NOT NULL DEFAULT 0,
    si101_tiporegistro int8 NOT NULL DEFAULT 0,
    si101_codorgao varchar(2) NOT NULL,
    si101_codctb int8 NOT NULL DEFAULT 0,
    si101_desccontabancaria varchar(50) NOT NULL,
    si101_nroconvenio varchar(30) NULL,
    si101_dataassinaturaconvenio date NULL,
    si101_mes int8 NOT NULL DEFAULT 0,
    si101_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb402021_sequ_pk PRIMARY KEY (si101_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb502021 definition

-- Drop table

-- DROP TABLE ctb502021;

CREATE TABLE ctb502021 (
    si102_sequencial int8 NOT NULL DEFAULT 0,
    si102_tiporegistro int8 NOT NULL DEFAULT 0,
    si102_codorgao varchar(2) NOT NULL,
    si102_codctb int8 NOT NULL DEFAULT 0,
    si102_situacaoconta varchar(1) NOT NULL,
    si102_datasituacao date NOT NULL,
    si102_mes int8 NOT NULL DEFAULT 0,
    si102_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb502021_sequ_pk PRIMARY KEY (si102_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cute102021 definition

-- Drop table

-- DROP TABLE cute102021;

CREATE TABLE cute102021 (
    si199_sequencial int8 NOT NULL DEFAULT 0,
    si199_tiporegistro int8 NOT NULL DEFAULT 0,
    si199_tipoconta varchar(2) NOT NULL,
    si199_codctb int8 NOT NULL DEFAULT 0,
    si199_codorgao varchar(2) NOT NULL,
    si199_banco int8 NOT NULL DEFAULT 0,
    si199_agencia varchar(6) NOT NULL,
    si199_digitoverificadoragencia varchar(2) NULL,
    si199_contabancaria int8 NOT NULL DEFAULT 0,
    si199_digitoverificadorcontabancaria varchar(2) NOT NULL,
    si199_desccontabancaria varchar(50) NOT NULL,
    si199_mes int8 NOT NULL DEFAULT 0,
    si199_instit int8 NULL DEFAULT 0,
    CONSTRAINT cute102021_sequ_pk PRIMARY KEY (si199_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cute202021 definition

-- Drop table

-- DROP TABLE cute202021;

CREATE TABLE cute202021 (
    si200_sequencial int8 NOT NULL DEFAULT 0,
    si200_tiporegistro int8 NOT NULL DEFAULT 0,
    si200_codorgao varchar(2) NOT NULL,
    si200_codctb int8 NOT NULL DEFAULT 0,
    si200_codfontrecursos int8 NOT NULL DEFAULT 0,
    si200_vlsaldoinicialfonte float8 NOT NULL DEFAULT 0,
    si200_vlsaldofinalfonte float8 NOT NULL DEFAULT 0,
    si200_mes int8 NOT NULL DEFAULT 0,
    si200_instit int8 NULL DEFAULT 0,
    CONSTRAINT cute202021_sequ_pk PRIMARY KEY (si200_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cute302021 definition

-- Drop table

-- DROP TABLE cute302021;

CREATE TABLE cute302021 (
    si202_sequencial int8 NOT NULL DEFAULT 0,
    si202_tiporegistro int8 NOT NULL DEFAULT 0,
    si202_codorgao varchar(2) NOT NULL,
    si202_codctb int8 NOT NULL DEFAULT 0,
    si202_situacaoconta varchar(1) NOT NULL,
    si202_datasituacao date NOT NULL,
    si202_mes int8 NOT NULL DEFAULT 0,
    si202_instit int8 NULL DEFAULT 0,
    CONSTRAINT cute302021_sequ_pk PRIMARY KEY (si202_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc102021 definition

-- Drop table

-- DROP TABLE cvc102021;

CREATE TABLE cvc102021 (
    si146_sequencial int8 NOT NULL DEFAULT 0,
    si146_tiporegistro int8 NOT NULL DEFAULT 0,
    si146_codorgao varchar(2) NOT NULL,
    si146_codunidadesub varchar(8) NOT NULL,
    si146_codveiculo varchar(10) NOT NULL,
    si146_tpveiculo varchar(2) NOT NULL,
    si146_subtipoveiculo varchar(2) NOT NULL,
    si146_descveiculo varchar(100) NOT NULL,
    si146_marca varchar(50) NOT NULL,
    si146_modelo varchar(50) NOT NULL,
    si146_ano int8 NOT NULL DEFAULT 0,
    si146_placa varchar(8) NULL,
    si146_chassi varchar(30) NULL,
    si146_numerorenavam int8 NULL DEFAULT 0,
    si146_nroserie varchar(20) NULL,
    si146_situacao varchar(2) NOT NULL,
    si146_tipodocumento int8 NULL DEFAULT 0,
    si146_nrodocumento varchar(14) NULL,
    si146_tpdeslocamento varchar(2) NOT NULL,
    si146_mes int8 NOT NULL DEFAULT 0,
    si146_instit int8 NULL DEFAULT 0,
    CONSTRAINT cvc102021_sequ_pk PRIMARY KEY (si146_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc202021 definition

-- Drop table

-- DROP TABLE cvc202021;

CREATE TABLE cvc202021 (
    si147_sequencial int8 NOT NULL DEFAULT 0,
    si147_tiporegistro int8 NOT NULL DEFAULT 0,
    si147_codorgao varchar(2) NOT NULL,
    si147_codunidadesub varchar(8) NOT NULL,
    si147_codveiculo varchar(10) NOT NULL,
    si147_origemgasto int8 NOT NULL DEFAULT 0,
    si147_codunidadesubempenho varchar(8) NULL,
    si147_nroempenho int8 NULL DEFAULT 0,
    si147_dtempenho date NULL,
    si147_marcacaoinicial int8 NOT NULL DEFAULT 0,
    si147_marcacaofinal int8 NOT NULL DEFAULT 0,
    si147_tipogasto varchar(2) NOT NULL,
    si147_qtdeutilizada float8 NOT NULL DEFAULT 0,
    si147_vlgasto float8 NOT NULL DEFAULT 0,
    si147_dscpecasservicos varchar(50) NULL,
    si147_atestadocontrole varchar(1) NOT NULL,
    si147_mes int8 NOT NULL DEFAULT 0,
    si147_instit int8 NULL DEFAULT 0,
    CONSTRAINT cvc202021_sequ_pk PRIMARY KEY (si147_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc302021 definition

-- Drop table

-- DROP TABLE cvc302021;

CREATE TABLE cvc302021 (
    si148_sequencial int8 NOT NULL DEFAULT 0,
    si148_tiporegistro int8 NOT NULL DEFAULT 0,
    si148_codorgao varchar(2) NOT NULL,
    si148_codunidadesub varchar(8) NOT NULL,
    si148_codveiculo varchar(10) NOT NULL,
    si148_nomeestabelecimento varchar(250) NOT NULL,
    si148_localidade varchar(250) NOT NULL,
    si148_qtdediasrodados int8 NOT NULL DEFAULT 0,
    si148_distanciaestabelecimento float8 NOT NULL DEFAULT 0,
    si148_numeropassageiros int8 NOT NULL DEFAULT 0,
    si148_turnos varchar(2) NOT NULL,
    si148_mes int8 NOT NULL DEFAULT 0,
    si148_instit int8 NULL DEFAULT 0,
    CONSTRAINT cvc302021_sequ_pk PRIMARY KEY (si148_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc402021 definition

-- Drop table

-- DROP TABLE cvc402021;

CREATE TABLE cvc402021 (
    si149_sequencial int8 NOT NULL DEFAULT 0,
    si149_tiporegistro int8 NOT NULL DEFAULT 0,
    si149_codorgao varchar(2) NOT NULL,
    si149_codunidadesub varchar(8) NOT NULL,
    si149_codveiculo varchar(10) NOT NULL,
    si149_tipobaixa int8 NOT NULL DEFAULT 0,
    si149_descbaixa varchar(50) NULL,
    si149_dtbaixa date NOT NULL,
    si149_mes int8 NOT NULL DEFAULT 0,
    si149_instit int8 NULL DEFAULT 0,
    CONSTRAINT cvc402021_sequ_pk PRIMARY KEY (si149_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dclrf102021 definition

-- Drop table

-- DROP TABLE dclrf102021;

CREATE TABLE dclrf102021 (
    si157_sequencial int8 NOT NULL DEFAULT 0,
    si157_tiporegistro int8 NOT NULL DEFAULT 0,
    si157_codorgao varchar(2) NOT NULL,
    si157_passivosreconhecidos float8 NOT NULL DEFAULT 0,
    si157_vlsaldoatualconcgarantiainterna float8 NOT NULL DEFAULT 0,
    si157_vlsaldoatualconcgarantia float8 NOT NULL DEFAULT 0,
    si157_vlsaldoatualcontragarantiainterna float8 NOT NULL DEFAULT 0,
    si157_vlsaldoatualcontragarantiaexterna float8 NOT NULL DEFAULT 0,
    si157_medidascorretivas varchar(4000) NULL,
    si157_recalieninvpermanente float8 NOT NULL DEFAULT 0,
    si157_vldotinicialincentcontrib float8 NOT NULL DEFAULT 0,
    si157_vldotatualizadaincentcontrib float8 NOT NULL DEFAULT 0,
    si157_vlempenhadoicentcontrib float8 NOT NULL DEFAULT 0,
    si157_vldotinicialincentinstfinanc float8 NOT NULL DEFAULT 0,
    si157_vldotatualizadaincentinstfinanc float8 NOT NULL DEFAULT 0,
    si157_vlempenhadoincentinstfinanc float8 NOT NULL DEFAULT 0,
    si157_vlliqincentcontrib float8 NOT NULL DEFAULT 0,
    si157_vlliqincentinstfinanc float8 NOT NULL DEFAULT 0,
    si157_vlirpnpincentcontrib float8 NOT NULL DEFAULT 0,
    si157_vlirpnpincentinstfinanc float8 NOT NULL DEFAULT 0,
    si157_vlapropiacaodepositosjudiciais float8 NOT NULL DEFAULT 0,
    si157_vlajustesrelativosrpps float8 NOT NULL DEFAULT 0,
    si157_vloutrosajustes float8 NOT NULL DEFAULT 0,
    si157_metarrecada int8 NOT NULL DEFAULT 0,
    si157_mes int8 NOT NULL DEFAULT 0,
    si157_instit int8 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- dclrf112021 definition

-- Drop table

-- DROP TABLE dclrf112021;

CREATE TABLE dclrf112021 (
    si205_sequencial int8 NOT NULL DEFAULT 0,
    si205_tiporegistro int8 NOT NULL DEFAULT 0,
    si205_medidasadotadas int8 NOT NULL DEFAULT 0,
    si205_dscmedidasadotadas varchar(4000) NULL,
    si205_reg10 int8 NOT NULL DEFAULT 0,
    si205_mes int8 NOT NULL DEFAULT 0,
    si205_instit int8 NOT NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- dclrf202021 definition

-- Drop table

-- DROP TABLE dclrf202021;

CREATE TABLE dclrf202021 (
    si191_sequencial int8 NOT NULL DEFAULT 0,
    si191_tiporegistro int8 NOT NULL DEFAULT 0,
    si191_contopcredito int8 NOT NULL DEFAULT 0,
    si191_dsccontopcredito varchar(1000) NULL DEFAULT 0,
    si191_realizopcredito int8 NOT NULL DEFAULT 0,
    si191_tiporealizopcreditocapta int8 NULL DEFAULT 0,
    si191_tiporealizopcreditoreceb int8 NULL DEFAULT 0,
    si191_tiporealizopcreditoassundir int8 NULL DEFAULT 0,
    si191_tiporealizopcreditoassunobg int8 NULL DEFAULT 0,
    si191_reg10 int8 NOT NULL DEFAULT 0,
    si191_mes int8 NOT NULL DEFAULT 0,
    si191_instit int8 NOT NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- dclrf302021 definition

-- Drop table

-- DROP TABLE dclrf302021;

CREATE TABLE dclrf302021 (
    si192_sequencial int8 NOT NULL,
    si192_tiporegistro int4 NOT NULL,
    si192_publiclrf int4 NOT NULL,
    si192_dtpublicacaorelatoriolrf date NULL,
    si192_localpublicacao varchar(1000) NULL,
    si192_tpbimestre int4 NULL,
    si192_exerciciotpbimestre int4 NULL,
    si192_reg10 int8 NOT NULL DEFAULT 0,
    si192_mes int8 NOT NULL DEFAULT 0,
    si192_instit int8 NOT NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- dclrf402021 definition

-- Drop table

-- DROP TABLE dclrf402021;

CREATE TABLE dclrf402021 (
    si193_sequencial int8 NOT NULL,
    si193_tiporegistro int4 NOT NULL,
    si193_publicrgf int4 NOT NULL,
    si193_dtpublicacaorgf date NULL,
    si193_localpublicacaorgf varchar(1000) NULL,
    si193_tpperiodo int4 NULL,
    si193_exerciciotpperiodo int4 NULL,
    si193_reg10 int8 NOT NULL DEFAULT 0,
    si193_mes int8 NOT NULL DEFAULT 0,
    si193_instit int8 NOT NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- ddc102021 definition

-- Drop table

-- DROP TABLE ddc102021;

CREATE TABLE ddc102021 (
    si150_sequencial int8 NOT NULL DEFAULT 0,
    si150_tiporegistro int8 NOT NULL DEFAULT 0,
    si150_codorgao varchar(2) NOT NULL,
    si150_nroleiautorizacao varchar(6) NOT NULL DEFAULT '0'::character varying,
    si150_dtleiautorizacao date NOT NULL,
    si150_dtpublicacaoleiautorizacao date NOT NULL,
    si150_mes int8 NOT NULL DEFAULT 0,
    si150_instit int8 NULL DEFAULT 0,
    CONSTRAINT ddc102021_sequ_pk PRIMARY KEY (si150_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ddc202021 definition

-- Drop table

-- DROP TABLE ddc202021;

CREATE TABLE ddc202021 (
    si153_sequencial int8 NOT NULL DEFAULT 0,
    si153_tiporegistro int8 NOT NULL DEFAULT 0,
    si153_codorgao varchar(2) NOT NULL,
    si153_nrocontratodivida varchar(30) NOT NULL,
    si153_dtassinatura date NOT NULL,
    si153_contratodeclei int8 NULL DEFAULT 0,
    si153_nroleiautorizacao varchar(6) NULL,
    si153_dtleiautorizacao date NULL,
    si153_objetocontratodivida varchar(1000) NOT NULL,
    si153_especificacaocontratodivida varchar(500) NOT NULL,
    si153_mes int8 NOT NULL DEFAULT 0,
    si153_instit int8 NULL DEFAULT 0,
    CONSTRAINT ddc202021_sequ_pk PRIMARY KEY (si153_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ddc302021 definition

-- Drop table

-- DROP TABLE ddc302021;

CREATE TABLE ddc302021 (
    si154_sequencial int8 NOT NULL DEFAULT 0,
    si154_tiporegistro int8 NOT NULL DEFAULT 0,
    si154_codorgao varchar(2) NOT NULL,
    si154_nrocontratodivida varchar(30) NOT NULL DEFAULT '0'::character varying,
    si154_dtassinatura date NOT NULL,
    si154_tipolancamento varchar(2) NOT NULL,
    si154_subtipo varchar(1) NULL,
    si154_tipodocumentocredor int8 NOT NULL DEFAULT 0,
    si154_nrodocumentocredor varchar(14) NOT NULL,
    si154_justificativacancelamento varchar(500) NULL,
    si154_vlsaldoanterior float8 NOT NULL DEFAULT 0,
    si154_vlcontratacao float8 NOT NULL DEFAULT 0,
    si154_vlamortizacao float8 NOT NULL DEFAULT 0,
    si154_vlcancelamento float8 NOT NULL DEFAULT 0,
    si154_vlencampacao float8 NOT NULL DEFAULT 0,
    si154_vlatualizacao float8 NOT NULL DEFAULT 0,
    si154_vlsaldoatual float8 NOT NULL DEFAULT 0,
    si154_mes int8 NOT NULL DEFAULT 0,
    si154_instit int8 NULL DEFAULT 0,
    CONSTRAINT ddc302021_sequ_pk PRIMARY KEY (si154_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ddc402021 definition

-- Drop table

-- DROP TABLE ddc402021;

CREATE TABLE ddc402021 (
    si178_sequencial int8 NOT NULL DEFAULT 0,
    si178_tiporegistro int8 NOT NULL DEFAULT 0,
    si178_codorgao varchar(2) NOT NULL,
    si178_passivoatuarial int8 NOT NULL DEFAULT 0,
    si178_vlsaldoanterior float8 NOT NULL DEFAULT 0,
    si178_vlsaldoatual float8 NULL DEFAULT 0,
    si178_mes int8 NOT NULL DEFAULT 0,
    si178_instit int8 NULL DEFAULT 0,
    CONSTRAINT ddc402021_sequ_pk PRIMARY KEY (si178_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dispensa102021 definition

-- Drop table

-- DROP TABLE dispensa102021;

CREATE TABLE dispensa102021 (
    si74_sequencial int8 NOT NULL DEFAULT 0,
    si74_tiporegistro int8 NOT NULL,
    si74_codorgaoresp varchar(2) NOT NULL,
    si74_codunidadesubresp varchar(8) NOT NULL,
    si74_exercicioprocesso int8 NOT NULL,
    si74_nroprocesso varchar(12) NOT NULL,
    si74_tipoprocesso int8 NOT NULL,
    si74_dtabertura date NOT NULL,
    si74_naturezaobjeto int8 NOT NULL,
    si74_objeto varchar(500) NOT NULL,
    si74_justificativa varchar(250) NOT NULL,
    si74_razao varchar(250) NOT NULL,
    si74_dtpublicacaotermoratificacao date NOT NULL,
    si74_veiculopublicacao varchar(50) NOT NULL,
    si74_processoporlote int8 NOT NULL,
    si74_mes int8 NULL,
    si74_instit int8 NULL,
    si74_tipocadastro int8 NULL,
    CONSTRAINT dispensa102021_sequ_pk PRIMARY KEY (si74_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dispensa182021 definition

-- Drop table

-- DROP TABLE dispensa182021;

CREATE TABLE dispensa182021 (
    si82_sequencial int8 NOT NULL DEFAULT 0,
    si82_tiporegistro int8 NOT NULL DEFAULT 0,
    si82_codorgaoresp varchar(2) NOT NULL,
    si82_codunidadesubresp varchar(8) NOT NULL,
    si82_exercicioprocesso int8 NOT NULL DEFAULT 0,
    si82_nroprocesso varchar(12) NOT NULL,
    si82_tipoprocesso int8 NOT NULL DEFAULT 0,
    si82_tipodocumento int8 NOT NULL DEFAULT 0,
    si82_nrodocumento varchar(14) NOT NULL,
    si82_datacredenciamento date NOT NULL,
    si82_nrolote int8 NULL DEFAULT 0,
    si82_coditem int8 NOT NULL DEFAULT 0,
    si82_nroinscricaoestadual varchar(30) NULL,
    si82_ufinscricaoestadual varchar(2) NULL,
    si82_nrocertidaoregularidadeinss varchar(30) NULL,
    si82_dataemissaocertidaoregularidadeinss date NULL,
    si82_dtvalidadecertidaoregularidadeinss date NULL,
    si82_nrocertidaoregularidadefgts varchar(30) NULL,
    si82_dtemissaocertidaoregularidadefgts date NULL,
    si82_dtvalidadecertidaoregularidadefgts date NULL,
    si82_nrocndt varchar(30) NULL,
    si82_dtemissaocndt date NULL,
    si82_dtvalidadecndt date NULL,
    si82_mes int8 NOT NULL DEFAULT 0,
    si82_reg10 int8 NOT NULL DEFAULT 0,
    si82_instit int8 NULL DEFAULT 0,
    CONSTRAINT dispensa182021_sequ_pk PRIMARY KEY (si82_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa182021_si82_reg10_index ON dispensa182021 USING btree (si82_reg10);


-- emp102021 definition

-- Drop table

-- DROP TABLE emp102021;

CREATE TABLE emp102021 (
    si106_sequencial int8 NOT NULL DEFAULT 0,
    si106_tiporegistro int8 NOT NULL DEFAULT 0,
    si106_codorgao varchar(2) NOT NULL,
    si106_codunidadesub varchar(8) NOT NULL,
    si106_codfuncao varchar(2) NOT NULL,
    si106_codsubfuncao varchar(3) NOT NULL,
    si106_codprograma varchar(4) NOT NULL,
    si106_idacao varchar(4) NOT NULL,
    si106_idsubacao varchar(4) NULL,
    si106_naturezadespesa int8 NOT NULL DEFAULT 0,
    si106_subelemento varchar(2) NOT NULL,
    si106_nroempenho int8 NOT NULL DEFAULT 0,
    si106_dtempenho date NOT NULL,
    si106_modalidadeempenho int8 NOT NULL DEFAULT 0,
    si106_tpempenho varchar(2) NOT NULL,
    si106_vlbruto float8 NOT NULL DEFAULT 0,
    si106_especificacaoempenho varchar(500) NOT NULL,
    si106_despdeccontrato int8 NOT NULL DEFAULT 0,
    si106_codorgaorespcontrato varchar(2) NULL,
    si106_codunidadesubrespcontrato varchar(8) NULL,
    si106_nrocontrato int8 NULL DEFAULT 0,
    si106_dtassinaturacontrato date NULL,
    si106_nrosequencialtermoaditivo varchar(2) NULL,
    si106_despdecconvenio int8 NOT NULL DEFAULT 0,
    si106_nroconvenio varchar(30) NULL,
    si106_dataassinaturaconvenio date NULL,
    si106_despdecconvenioconge int8 NOT NULL DEFAULT 0,
    si106_nroconvenioconge varchar(30) NULL,
    si106_dataassinaturaconvenioconge date NULL,
    si106_despdeclicitacao int8 NOT NULL DEFAULT 0,
    si106_codorgaoresplicit varchar(2) NULL,
    si106_codunidadesubresplicit varchar(8) NULL,
    si106_nroprocessolicitatorio varchar(12) NULL,
    si106_exercicioprocessolicitatorio int8 NULL DEFAULT 0,
    si106_tipoprocesso int8 NULL DEFAULT 0,
    si106_cpfordenador varchar(11) NOT NULL,
    si106_tipodespesaemprpps int8 NULL DEFAULT 0,
    si106_mes int8 NOT NULL DEFAULT 0,
    si106_instit int8 NULL DEFAULT 0,
    CONSTRAINT emp102021_sequ_pk PRIMARY KEY (si106_sequencial)
)
WITH (
    OIDS=TRUE
);


-- emp202021 definition

-- Drop table

-- DROP TABLE emp202021;

CREATE TABLE emp202021 (
    si109_sequencial int8 NOT NULL DEFAULT 0,
    si109_tiporegistro int8 NOT NULL DEFAULT 0,
    si109_codorgao varchar(2) NOT NULL,
    si109_codunidadesub varchar(8) NOT NULL,
    si109_nroempenho int8 NOT NULL DEFAULT 0,
    si109_dtempenho date NOT NULL,
    si109_nroreforco int8 NOT NULL DEFAULT 0,
    si109_dtreforco date NOT NULL,
    si109_codfontrecursos int8 NOT NULL DEFAULT 0,
    si109_vlreforco float8 NOT NULL DEFAULT 0,
    si109_mes int8 NOT NULL DEFAULT 0,
    si109_instit int8 NULL DEFAULT 0,
    CONSTRAINT emp202021_sequ_pk PRIMARY KEY (si109_sequencial)
)
WITH (
    OIDS=TRUE
);


-- emp302021 definition

-- Drop table

-- DROP TABLE emp302021;

CREATE TABLE emp302021 (
    si206_sequencial int8 NOT NULL DEFAULT 0,
    si206_tiporegistro int8 NOT NULL DEFAULT 0,
    si206_codorgao varchar(2) NOT NULL,
    si206_codunidadesub varchar(8) NOT NULL,
    si206_nroempenho int8 NOT NULL DEFAULT 0,
    si206_dtempenho date NOT NULL,
    si206_codorgaorespcontrato varchar(2) NULL DEFAULT NULL::character varying,
    si206_codunidadesubrespcontrato varchar(8) NULL DEFAULT NULL::character varying,
    si206_nrocontrato int8 NULL DEFAULT 0,
    si206_dtassinaturacontrato date NULL,
    si206_nrosequencialtermoaditivo int8 NULL DEFAULT 0,
    si206_nroconvenio varchar(30) NULL DEFAULT NULL::character varying,
    si206_dtassinaturaconvenio date NULL,
    si206_nroconvenioconge varchar(30) NULL DEFAULT NULL::character varying,
    si206_dtassinaturaconge date NULL,
    si206_mes int8 NOT NULL DEFAULT 0,
    si206_instit int8 NULL DEFAULT 0,
    CONSTRAINT emp302021_sequ_pk PRIMARY KEY (si206_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ext102021 definition

-- Drop table

-- DROP TABLE ext102021;

CREATE TABLE ext102021 (
    si124_sequencial int8 NOT NULL DEFAULT 0,
    si124_tiporegistro int8 NOT NULL DEFAULT 0,
    si124_codext int8 NOT NULL DEFAULT 0,
    si124_codorgao varchar(2) NOT NULL,
    si124_tipolancamento varchar(2) NOT NULL,
    si124_subtipo varchar(4) NOT NULL,
    si124_desdobrasubtipo varchar(4) NULL,
    si124_descextraorc varchar(50) NOT NULL,
    si124_mes int8 NOT NULL DEFAULT 0,
    si124_instit int8 NULL DEFAULT 0,
    CONSTRAINT ext102021_sequ_pk PRIMARY KEY (si124_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ext202021 definition

-- Drop table

-- DROP TABLE ext202021;

CREATE TABLE ext202021 (
    si165_sequencial int8 NOT NULL DEFAULT 0,
    si165_tiporegistro int8 NOT NULL DEFAULT 0,
    si165_codorgao varchar(2) NOT NULL,
    si165_codext int8 NOT NULL DEFAULT 0,
    si165_codfontrecursos int8 NOT NULL DEFAULT 0,
    si165_vlsaldoanteriorfonte float8 NOT NULL DEFAULT 0,
    si165_natsaldoanteriorfonte varchar(1) NOT NULL,
    si165_totaldebitos float8 NOT NULL DEFAULT 0,
    si165_totalcreditos float8 NOT NULL DEFAULT 0,
    si165_vlsaldoatualfonte float8 NOT NULL DEFAULT 0,
    si165_natsaldoatualfonte varchar(1) NOT NULL,
    si165_mes int8 NOT NULL DEFAULT 0,
    si165_instit int8 NULL DEFAULT 0,
    CONSTRAINT ext202021_sequ_pk PRIMARY KEY (si165_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ext302021 definition

-- Drop table

-- DROP TABLE ext302021;

CREATE TABLE ext302021 (
    si126_sequencial int8 NOT NULL DEFAULT 0,
    si126_tiporegistro int8 NOT NULL DEFAULT 0,
    si126_codext int8 NOT NULL DEFAULT 0,
    si126_codfontrecursos int8 NOT NULL DEFAULT 0,
    si126_codreduzidoop int8 NOT NULL DEFAULT 0,
    si126_nroop int8 NOT NULL DEFAULT 0,
    si126_codunidadesub varchar(8) NOT NULL,
    si126_dtpagamento date NOT NULL,
    si126_tipodocumentocredor int8 NULL DEFAULT 0,
    si126_nrodocumentocredor varchar(14) NULL,
    si126_vlop float8 NOT NULL DEFAULT 0,
    si126_especificacaoop varchar(500) NOT NULL,
    si126_cpfresppgto varchar(11) NOT NULL,
    si126_mes int8 NOT NULL DEFAULT 0,
    si126_instit int8 NULL DEFAULT 0,
    CONSTRAINT ext302021_sequ_pk PRIMARY KEY (si126_sequencial)
)
WITH (
    OIDS=TRUE
);


-- hablic102021 definition

-- Drop table

-- DROP TABLE hablic102021;

CREATE TABLE hablic102021 (
    si57_sequencial int8 NOT NULL DEFAULT 0,
    si57_tiporegistro int8 NOT NULL DEFAULT 0,
    si57_codorgao varchar(2) NOT NULL,
    si57_codunidadesub varchar(8) NOT NULL,
    si57_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si57_nroprocessolicitatorio varchar(12) NOT NULL,
    si57_tipodocumento int8 NOT NULL DEFAULT 0,
    si57_nrodocumento varchar(14) NOT NULL,
    si57_objetosocial varchar(2000) NULL,
    si57_orgaorespregistro int8 NULL DEFAULT 0,
    si57_dataregistro date NULL,
    si57_nroregistro varchar(20) NULL,
    si57_dataregistrocvm date NULL,
    si57_nroregistrocvm varchar(20) NULL,
    si57_nroinscricaoestadual varchar(30) NULL,
    si57_ufinscricaoestadual varchar(2) NULL,
    si57_nrocertidaoregularidadeinss varchar(30) NULL,
    si57_dtemissaocertidaoregularidadeinss date NULL,
    si57_dtvalidadecertidaoregularidadeinss date NULL,
    si57_nrocertidaoregularidadefgts varchar(30) NULL,
    si57_dtemissaocertidaoregularidadefgts date NULL,
    si57_dtvalidadecertidaoregularidadefgts date NULL,
    si57_nrocndt varchar(30) NULL,
    si57_dtemissaocndt date NULL,
    si57_dtvalidadecndt date NULL,
    si57_dthabilitacao date NOT NULL,
    si57_presencalicitantes int8 NOT NULL DEFAULT 0,
    si57_renunciarecurso int8 NOT NULL DEFAULT 0,
    si57_mes int8 NOT NULL DEFAULT 0,
    si57_instit int8 NULL DEFAULT 0,
    CONSTRAINT hablic102021_sequ_pk PRIMARY KEY (si57_sequencial)
)
WITH (
    OIDS=TRUE
);


-- hablic202021 definition

-- Drop table

-- DROP TABLE hablic202021;

CREATE TABLE hablic202021 (
    si59_sequencial int8 NOT NULL DEFAULT 0,
    si59_tiporegistro int8 NOT NULL DEFAULT 0,
    si59_codorgao varchar(2) NOT NULL,
    si59_codunidadesub varchar(8) NULL,
    si59_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si59_nroprocessolicitatorio varchar(12) NOT NULL,
    si59_tipodocumento int8 NOT NULL DEFAULT 0,
    si59_nrodocumento varchar(14) NOT NULL,
    si59_datacredenciamento date NOT NULL,
    si59_nrolote int8 NULL DEFAULT 0,
    si59_coditem int8 NOT NULL DEFAULT 0,
    si59_nroinscricaoestadual varchar(30) NULL,
    si59_ufinscricaoestadual varchar(2) NULL,
    si59_nrocertidaoregularidadeinss varchar(30) NULL,
    si59_dataemissaocertidaoregularidadeinss date NULL,
    si59_dtvalidadecertidaoregularidadeinss date NULL,
    si59_nrocertidaoregularidadefgts varchar(30) NULL,
    si59_dtemissaocertidaoregularidadefgts date NULL,
    si59_dtvalidadecertidaoregularidadefgts date NULL,
    si59_nrocndt varchar(30) NULL,
    si59_dtemissaocndt date NULL,
    si59_dtvalidadecndt date NULL,
    si59_mes int8 NOT NULL DEFAULT 0,
    si59_instit int8 NULL DEFAULT 0,
    CONSTRAINT hablic202021_sequ_pk PRIMARY KEY (si59_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic102021 definition

-- Drop table

-- DROP TABLE homolic102021;

CREATE TABLE homolic102021 (
    si63_sequencial int8 NOT NULL DEFAULT 0,
    si63_tiporegistro int8 NOT NULL DEFAULT 0,
    si63_codorgao varchar(2) NOT NULL,
    si63_codunidadesub varchar(8) NOT NULL,
    si63_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si63_nroprocessolicitatorio varchar(12) NOT NULL,
    si63_tipodocumento int8 NOT NULL DEFAULT 0,
    si63_nrodocumento varchar(14) NOT NULL,
    si63_nrolote int8 NULL DEFAULT 0,
    si63_coditem int8 NOT NULL DEFAULT 0,
    si63_quantidade float8 NOT NULL DEFAULT 0,
    si63_vlunitariohomologado float8 NOT NULL DEFAULT 0,
    si63_mes int8 NOT NULL DEFAULT 0,
    si63_instit int8 NULL DEFAULT 0,
    CONSTRAINT homolic102021_sequ_pk PRIMARY KEY (si63_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic202021 definition

-- Drop table

-- DROP TABLE homolic202021;

CREATE TABLE homolic202021 (
    si64_sequencial int8 NOT NULL DEFAULT 0,
    si64_tiporegistro int8 NOT NULL DEFAULT 0,
    si64_codorgao varchar(2) NOT NULL,
    si64_codunidadesub varchar(8) NOT NULL,
    si64_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si64_nroprocessolicitatorio varchar(12) NOT NULL,
    si64_tipodocumento int8 NOT NULL DEFAULT 0,
    si64_nrodocumento varchar(14) NOT NULL,
    si64_nrolote int8 NULL DEFAULT 0,
    si64_coditem varchar(15) NULL,
    si64_percdesconto float8 NOT NULL DEFAULT 0,
    si64_mes int8 NOT NULL DEFAULT 0,
    si64_instit int8 NULL DEFAULT 0,
    CONSTRAINT homolic202021_sequ_pk PRIMARY KEY (si64_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic302021 definition

-- Drop table

-- DROP TABLE homolic302021;

CREATE TABLE homolic302021 (
    si65_sequencial int8 NOT NULL DEFAULT 0,
    si65_tiporegistro int8 NOT NULL DEFAULT 0,
    si65_codorgao varchar(2) NOT NULL,
    si65_codunidadesub varchar(8) NOT NULL,
    si65_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si65_nroprocessolicitatorio varchar(12) NOT NULL,
    si65_tipodocumento int8 NOT NULL DEFAULT 0,
    si65_nrodocumento varchar(14) NOT NULL,
    si65_nrolote int8 NULL DEFAULT 0,
    si65_coditem varchar(15) NULL,
    si65_perctaxaadm float8 NOT NULL DEFAULT 0,
    si65_mes int8 NOT NULL DEFAULT 0,
    si65_instit int8 NULL DEFAULT 0,
    CONSTRAINT homolic302021_sequ_pk PRIMARY KEY (si65_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic402021 definition

-- Drop table

-- DROP TABLE homolic402021;

CREATE TABLE homolic402021 (
    si65_sequencial int8 NOT NULL DEFAULT 0,
    si65_tiporegistro int8 NOT NULL DEFAULT 0,
    si65_codorgao varchar(2) NOT NULL,
    si65_codunidadesub varchar(8) NULL,
    si65_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si65_nroprocessolicitatorio varchar(12) NOT NULL,
    si65_dthomologacao date NOT NULL,
    si65_dtadjudicacao date NULL,
    si65_mes int8 NOT NULL DEFAULT 0,
    si65_instit int8 NULL DEFAULT 0,
    CONSTRAINT homolic402021_sequ_pk PRIMARY KEY (si65_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ide2021 definition

-- Drop table

-- DROP TABLE ide2021;

CREATE TABLE ide2021 (
    si11_sequencial int8 NOT NULL DEFAULT 0,
    si11_codmunicipio varchar(5) NOT NULL,
    si11_cnpjmunicipio varchar(14) NOT NULL,
    si11_codorgao varchar(3) NOT NULL,
    si11_tipoorgao varchar(2) NOT NULL,
    si11_exercicioreferencia int8 NOT NULL DEFAULT 0,
    si11_mesreferencia varchar(2) NOT NULL,
    si11_datageracao date NOT NULL,
    si11_codcontroleremessa varchar(20) NULL,
    si11_mes int8 NOT NULL DEFAULT 0,
    si11_instit int8 NULL DEFAULT 0,
    CONSTRAINT ide2021_sequ_pk PRIMARY KEY (si11_sequencial)
)
WITH (
    OIDS=TRUE
);


-- idedcasp2021 definition

-- Drop table

-- DROP TABLE idedcasp2021;

CREATE TABLE idedcasp2021 (
    si200_sequencial int4 NOT NULL DEFAULT 0,
    si200_codmunicipio varchar(5) NOT NULL,
    si200_cnpjorgao varchar(14) NOT NULL,
    si200_codorgao varchar(2) NOT NULL,
    si200_tipoorgao varchar(2) NOT NULL,
    si200_tipodemcontabil int4 NOT NULL DEFAULT 0,
    si200_exercicioreferencia int4 NOT NULL DEFAULT 0,
    si200_datageracao date NOT NULL,
    si200_codcontroleremessa varchar(20) NULL,
    si200_anousu int4 NOT NULL DEFAULT 0,
    si200_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT idedcasp2021_sequ_pk PRIMARY KEY (si200_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ideedital2021 definition

-- Drop table

-- DROP TABLE ideedital2021;

CREATE TABLE ideedital2021 (
    si186_sequencial int8 NOT NULL DEFAULT 0,
    si186_codidentificador bpchar(5) NOT NULL,
    si186_cnpj bpchar(14) NOT NULL,
    si186_codorgao varchar(3) NOT NULL,
    si186_tipoorgao varchar(2) NOT NULL,
    si186_exercicioreferencia int2 NOT NULL,
    si186_mesreferencia bpchar(2) NOT NULL,
    si186_datageracao date NOT NULL,
    si186_codcontroleremessa varchar(20) NULL,
    si186_codseqremessames int4 NOT NULL,
    si186_mes int8 NOT NULL DEFAULT 0,
    si186_instit int8 NULL DEFAULT 0,
    CONSTRAINT ideedital2021_sequ_pk PRIMARY KEY (si186_sequencial)
)
WITH (
    OIDS=TRUE
);


-- iderp102021 definition

-- Drop table

-- DROP TABLE iderp102021;

CREATE TABLE iderp102021 (
    si179_sequencial int8 NOT NULL DEFAULT 0,
    si179_tiporegistro int8 NOT NULL DEFAULT 0,
    si179_codiderp int8 NOT NULL DEFAULT 0,
    si179_codorgao varchar(2) NOT NULL DEFAULT 0,
    si179_codunidadesub varchar(8) NOT NULL DEFAULT 0,
    si179_nroempenho int8 NOT NULL DEFAULT 0,
    si179_tiporestospagar int8 NOT NULL DEFAULT 0,
    si179_disponibilidadecaixa int8 NOT NULL DEFAULT 0,
    si179_vlinscricao float8 NOT NULL DEFAULT 0,
    si179_instit int8 NULL DEFAULT 0,
    si179_mes int8 NOT NULL DEFAULT 0,
    CONSTRAINT iderp102021_sequ_pk PRIMARY KEY (si179_sequencial)
)
WITH (
    OIDS=TRUE
);


-- iderp112021 definition

-- Drop table

-- DROP TABLE iderp112021;

CREATE TABLE iderp112021 (
    si180_sequencial int8 NOT NULL DEFAULT 0,
    si180_tiporegistro int8 NOT NULL DEFAULT 0,
    si180_codiderp int8 NOT NULL DEFAULT 0,
    si180_codfontrecursos int8 NOT NULL DEFAULT 0,
    si180_vlinscricaofonte float8 NOT NULL DEFAULT 0,
    si180_mes int8 NOT NULL DEFAULT 0,
    si180_reg10 int8 NOT NULL DEFAULT 0,
    si180_instit int8 NULL DEFAULT 0,
    CONSTRAINT iderp112021_sequ_pk PRIMARY KEY (si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- iderp202021 definition

-- Drop table

-- DROP TABLE iderp202021;

CREATE TABLE iderp202021 (
    si181_sequencial int8 NOT NULL DEFAULT 0,
    si181_tiporegistro int8 NOT NULL DEFAULT 0,
    si181_codorgao varchar(2) NOT NULL,
    si181_codfontrecursos int8 NOT NULL DEFAULT 0,
    si181_vlcaixabruta float8 NOT NULL DEFAULT 0,
    si181_vlrspexerciciosanteriores float8 NOT NULL DEFAULT 0,
    si181_vlrestituiveisrecolher float8 NULL DEFAULT 0,
    si181_vlrestituiveisativofinanceiro float8 NULL DEFAULT 0,
    si181_vlsaldodispcaixa float8 NOT NULL DEFAULT 0,
    si181_mes int8 NOT NULL DEFAULT 0,
    si181_instit int8 NULL DEFAULT 0,
    CONSTRAINT iderp202021_sequ_pk PRIMARY KEY (si181_sequencial)
)
WITH (
    OIDS=TRUE
);


-- item102021 definition

-- Drop table

-- DROP TABLE item102021;

CREATE TABLE item102021 (
    si43_sequencial int8 NOT NULL DEFAULT 0,
    si43_tiporegistro int8 NOT NULL DEFAULT 0,
    si43_coditem int8 NOT NULL DEFAULT 0,
    si43_dscitem text NOT NULL,
    si43_unidademedida varchar(50) NOT NULL,
    si43_tipocadastro int8 NOT NULL DEFAULT 0,
    si43_justificativaalteracao varchar(100) NULL,
    si43_mes int8 NOT NULL DEFAULT 0,
    si43_instit int8 NULL DEFAULT 0,
    CONSTRAINT item102021_sequ_pk PRIMARY KEY (si43_sequencial)
)
WITH (
    OIDS=TRUE
);


-- julglic102021 definition

-- Drop table

-- DROP TABLE julglic102021;

CREATE TABLE julglic102021 (
    si60_sequencial int8 NOT NULL DEFAULT 0,
    si60_tiporegistro int8 NOT NULL DEFAULT 0,
    si60_codorgao varchar(2) NOT NULL,
    si60_codunidadesub varchar(8) NOT NULL,
    si60_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si60_nroprocessolicitatorio varchar(12) NOT NULL,
    si60_tipodocumento int8 NOT NULL DEFAULT 0,
    si60_nrodocumento varchar(14) NOT NULL,
    si60_nrolote int8 NULL DEFAULT 0,
    si60_coditem int8 NOT NULL DEFAULT 0,
    si60_vlunitario float8 NOT NULL DEFAULT 0,
    si60_quantidade float8 NOT NULL DEFAULT 0,
    si60_mes int8 NOT NULL DEFAULT 0,
    si60_instit int8 NULL DEFAULT 0,
    CONSTRAINT julglic102021_sequ_pk PRIMARY KEY (si60_sequencial)
)
WITH (
    OIDS=TRUE
);


-- julglic202021 definition

-- Drop table

-- DROP TABLE julglic202021;

CREATE TABLE julglic202021 (
    si61_sequencial int8 NOT NULL DEFAULT 0,
    si61_tiporegistro int8 NOT NULL DEFAULT 0,
    si61_codorgao varchar(2) NOT NULL,
    si61_codunidadesub varchar(8) NOT NULL,
    si61_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si61_nroprocessolicitatorio varchar(12) NOT NULL,
    si61_tipodocumento int8 NOT NULL DEFAULT 0,
    si61_nrodocumento varchar(14) NOT NULL,
    si61_nrolote int8 NULL DEFAULT 0,
    si61_coditem varchar(15) NULL,
    si61_percdesconto float8 NOT NULL DEFAULT 0,
    si61_mes int8 NOT NULL DEFAULT 0,
    si61_instit int8 NULL DEFAULT 0,
    CONSTRAINT julglic202021_sequ_pk PRIMARY KEY (si61_sequencial)
)
WITH (
    OIDS=TRUE
);


-- julglic302021 definition

-- Drop table

-- DROP TABLE julglic302021;

CREATE TABLE julglic302021 (
    si62_sequencial int8 NOT NULL DEFAULT 0,
    si62_tiporegistro int8 NOT NULL DEFAULT 0,
    si62_codorgao varchar(2) NOT NULL,
    si62_codunidadesub varchar(8) NOT NULL,
    si62_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si62_nroprocessolicitatorio varchar(12) NOT NULL,
    si62_tipodocumento int8 NOT NULL DEFAULT 0,
    si62_nrodocumento varchar(14) NOT NULL,
    si62_nrolote int8 NULL,
    si62_coditem varchar(15) NULL,
    si62_perctaxaadm float8 NOT NULL DEFAULT 0,
    si62_mes int8 NOT NULL DEFAULT 0,
    si62_instit int4 NULL DEFAULT 0
)
WITH (
    OIDS=TRUE
);


-- julglic402021 definition

-- Drop table

-- DROP TABLE julglic402021;

CREATE TABLE julglic402021 (
    si62_sequencial int8 NOT NULL DEFAULT 0,
    si62_tiporegistro int8 NOT NULL DEFAULT 0,
    si62_codorgao varchar(2) NOT NULL,
    si62_codunidadesub varchar(8) NOT NULL,
    si62_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si62_nroprocessolicitatorio varchar(12) NOT NULL,
    si62_dtjulgamento date NOT NULL,
    si62_presencalicitantes int8 NOT NULL DEFAULT 0,
    si62_renunciarecurso int8 NOT NULL DEFAULT 0,
    si62_mes int8 NOT NULL DEFAULT 0,
    si62_instit int4 NULL DEFAULT 0,
    CONSTRAINT julglic402021_sequ_pk PRIMARY KEY (si62_sequencial)
)
WITH (
    OIDS=TRUE
);


-- lao102021 definition

-- Drop table

-- DROP TABLE lao102021;

CREATE TABLE lao102021 (
    si34_sequencial int8 NOT NULL DEFAULT 0,
    si34_tiporegistro int8 NOT NULL DEFAULT 0,
    si34_codorgao varchar(2) NOT NULL,
    si34_nroleialteracao int8 NOT NULL,
    si34_dataleialteracao date NOT NULL,
    si34_mes int8 NOT NULL DEFAULT 0,
    si34_instit int8 NULL DEFAULT 0,
    CONSTRAINT lao102021_sequ_pk PRIMARY KEY (si34_sequencial)
)
WITH (
    OIDS=TRUE
);


-- lao202021 definition

-- Drop table

-- DROP TABLE lao202021;

CREATE TABLE lao202021 (
    si36_sequencial int8 NOT NULL DEFAULT 0,
    si36_tiporegistro int8 NOT NULL DEFAULT 0,
    si36_codorgao varchar(2) NOT NULL,
    si36_nroleialterorcam varchar(6) NOT NULL,
    si36_dataleialterorcam date NOT NULL,
    si36_mes int8 NOT NULL DEFAULT 0,
    si36_instit int8 NULL DEFAULT 0,
    CONSTRAINT lao202021_sequ_pk PRIMARY KEY (si36_sequencial)
)
WITH (
    OIDS=TRUE
);


-- lqd102021 definition

-- Drop table

-- DROP TABLE lqd102021;

CREATE TABLE lqd102021 (
    si118_sequencial int8 NOT NULL DEFAULT 0,
    si118_tiporegistro int8 NOT NULL DEFAULT 0,
    si118_codreduzido int8 NOT NULL DEFAULT 0,
    si118_codorgao varchar(2) NOT NULL,
    si118_codunidadesub varchar(8) NOT NULL,
    si118_tpliquidacao int8 NOT NULL DEFAULT 0,
    si118_nroempenho int8 NOT NULL DEFAULT 0,
    si118_dtempenho date NOT NULL,
    si118_dtliquidacao date NOT NULL,
    si118_nroliquidacao int8 NOT NULL DEFAULT 0,
    si118_vlliquidado float8 NOT NULL DEFAULT 0,
    si118_cpfliquidante varchar(11) NOT NULL,
    si118_mes int8 NOT NULL DEFAULT 0,
    si118_instit int8 NULL DEFAULT 0,
    CONSTRAINT lqd102021_sequ_pk PRIMARY KEY (si118_sequencial)
)
WITH (
    OIDS=TRUE
);


-- metareal102021 definition

-- Drop table

-- DROP TABLE metareal102021;

CREATE TABLE metareal102021 (
    si171_sequencial int8 NOT NULL DEFAULT 0,
    si171_tiporegistro int8 NOT NULL DEFAULT 0,
    si171_codorgao varchar(2) NOT NULL DEFAULT 0,
    si171_codunidadesub varchar(8) NOT NULL DEFAULT 0,
    si171_codfuncao varchar(2) NOT NULL DEFAULT 0,
    si171_codsubfuncao varchar(3) NOT NULL DEFAULT 0,
    si171_codprograma varchar(4) NOT NULL DEFAULT 0,
    si171_idacao varchar(4) NOT NULL DEFAULT 0,
    si171_idsubacao varchar(4) NULL DEFAULT 0,
    si171_metarealizada float8 NOT NULL DEFAULT 0,
    si171_justificativa varchar(1000) NULL DEFAULT 0,
    si171_instit int8 NULL DEFAULT 0,
    si171_mes int4 NULL,
    CONSTRAINT metareal102021_sequ_pk PRIMARY KEY (si171_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ntf102021 definition

-- Drop table

-- DROP TABLE ntf102021;

CREATE TABLE ntf102021 (
    si143_sequencial int8 NOT NULL DEFAULT 0,
    si143_tiporegistro int8 NOT NULL DEFAULT 0,
    si143_codnotafiscal int8 NOT NULL DEFAULT 0,
    si143_codorgao varchar(2) NOT NULL,
    si143_nfnumero int8 NULL DEFAULT 0,
    si143_nfserie varchar(8) NULL,
    si143_tipodocumento int8 NOT NULL DEFAULT 0,
    si143_nrodocumento varchar(14) NOT NULL,
    si143_nroinscestadual varchar(30) NULL,
    si143_nroinscmunicipal varchar(30) NULL,
    si143_nomemunicipio varchar(120) NOT NULL,
    si143_cepmunicipio int8 NOT NULL DEFAULT 0,
    si143_ufcredor varchar(2) NOT NULL,
    si143_notafiscaleletronica int8 NOT NULL DEFAULT 0,
    si143_chaveacesso varchar(44) NULL,
    si143_outrachaveacesso varchar(60) NULL,
    si143_nfaidf varchar(15) NOT NULL,
    si143_dtemissaonf date NOT NULL,
    si143_dtvencimentonf date NULL,
    si143_nfvalortotal float8 NOT NULL DEFAULT 0,
    si143_nfvalordesconto float8 NOT NULL DEFAULT 0,
    si143_nfvalorliquido float8 NOT NULL DEFAULT 0,
    si143_mes int8 NOT NULL DEFAULT 0,
    si143_instit int8 NULL DEFAULT 0,
    CONSTRAINT ntf102021_sequ_pk PRIMARY KEY (si143_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ntf202021 definition

-- Drop table

-- DROP TABLE ntf202021;

CREATE TABLE ntf202021 (
    si145_sequencial int8 NOT NULL DEFAULT 0,
    si145_tiporegistro int8 NOT NULL DEFAULT 0,
    si145_nfnumero int8 NOT NULL DEFAULT 0,
    si145_nfserie varchar(8) NULL DEFAULT 0,
    si145_tipodocumento int8 NOT NULL DEFAULT 0,
    si145_nrodocumento varchar(14) NOT NULL DEFAULT 0,
    si145_chaveacesso varchar(44) NULL,
    si145_dtemissaonf date NOT NULL,
    si145_codunidadesub varchar(8) NOT NULL,
    si145_dtempenho date NOT NULL,
    si145_nroempenho int8 NOT NULL DEFAULT 0,
    si145_dtliquidacao date NOT NULL,
    si145_nroliquidacao int8 NOT NULL DEFAULT 0,
    si145_mes int8 NOT NULL DEFAULT 0,
    si145_reg10 int8 NOT NULL DEFAULT 0,
    si145_instit int8 NULL DEFAULT 0,
    CONSTRAINT ntf202021_sequ_pk PRIMARY KEY (si145_sequencial)
)
WITH (
    OIDS=TRUE
);


-- obelac102021 definition

-- Drop table

-- DROP TABLE obelac102021;

CREATE TABLE obelac102021 (
    si139_sequencial int8 NOT NULL DEFAULT 0,
    si139_tiporegistro int8 NOT NULL DEFAULT 0,
    si139_codreduzido int8 NOT NULL DEFAULT 0,
    si139_codorgao varchar(2) NOT NULL,
    si139_codunidadesub varchar(8) NOT NULL,
    si139_nrolancamento int8 NOT NULL DEFAULT 0,
    si139_dtlancamento date NOT NULL,
    si139_tipolancamento int8 NOT NULL DEFAULT 0,
    si139_nroempenho int8 NOT NULL DEFAULT 0,
    si139_dtempenho date NOT NULL,
    si139_nroliquidacao int8 NULL DEFAULT 0,
    si139_dtliquidacao date NULL,
    si139_esplancamento varchar(500) NOT NULL,
    si139_valorlancamento float8 NOT NULL DEFAULT 0,
    si139_mes int8 NOT NULL DEFAULT 0,
    si139_instit int8 NULL DEFAULT 0,
    CONSTRAINT obelac102021_sequ_pk PRIMARY KEY (si139_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ops102021 definition

-- Drop table

-- DROP TABLE ops102021;

CREATE TABLE ops102021 (
    si132_sequencial int8 NOT NULL DEFAULT 0,
    si132_tiporegistro int8 NOT NULL DEFAULT 0,
    si132_codorgao varchar(2) NOT NULL,
    si132_codunidadesub varchar(8) NOT NULL,
    si132_nroop int8 NOT NULL DEFAULT 0,
    si132_dtpagamento date NOT NULL,
    si132_vlop float8 NOT NULL DEFAULT 0,
    si132_especificacaoop varchar(500) NOT NULL,
    si132_cpfresppgto varchar(11) NOT NULL,
    si132_mes int8 NOT NULL DEFAULT 0,
    si132_instit int8 NULL DEFAULT 0,
    CONSTRAINT ops102021_sequ_pk PRIMARY KEY (si132_sequencial)
)
WITH (
    OIDS=TRUE
);


-- orgao102021 definition

-- Drop table

-- DROP TABLE orgao102021;

CREATE TABLE orgao102021 (
    si14_sequencial int8 NOT NULL DEFAULT 0,
    si14_tiporegistro int8 NOT NULL DEFAULT 0,
    si14_codorgao varchar(2) NOT NULL,
    si14_tipoorgao varchar(2) NOT NULL,
    si14_cnpjorgao varchar(14) NOT NULL,
    si14_tipodocumentofornsoftware int8 NOT NULL DEFAULT 0,
    si14_nrodocumentofornsoftware varchar(14) NOT NULL,
    si14_versaosoftware varchar(50) NOT NULL,
    si14_assessoriacontabil int8 NOT NULL,
    si14_tipodocumentoassessoria int8 NULL,
    si14_nrodocumentoassessoria varchar(14) NULL,
    si14_mes int8 NOT NULL DEFAULT 0,
    si14_instit int8 NULL DEFAULT 0,
    CONSTRAINT orgao102021_sequ_pk PRIMARY KEY (si14_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parec102021 definition

-- Drop table

-- DROP TABLE parec102021;

CREATE TABLE parec102021 (
    si22_sequencial int8 NOT NULL DEFAULT 0,
    si22_tiporegistro int8 NOT NULL DEFAULT 0,
    si22_codreduzido int8 NOT NULL DEFAULT 0,
    si22_codorgao varchar(2) NOT NULL,
    si22_ededucaodereceita int8 NOT NULL DEFAULT 0,
    si22_identificadordeducao int8 NULL DEFAULT 0,
    si22_naturezareceita int8 NOT NULL DEFAULT 0,
    si22_tipoatualizacao int8 NOT NULL DEFAULT 0,
    si22_vlacrescidoreduzido float8 NOT NULL DEFAULT 0,
    si22_mes int8 NOT NULL DEFAULT 0,
    si22_instit int8 NULL DEFAULT 0,
    CONSTRAINT parec102021_sequ_pk PRIMARY KEY (si22_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parelic102021 definition

-- Drop table

-- DROP TABLE parelic102021;

CREATE TABLE parelic102021 (
    si66_sequencial int8 NOT NULL DEFAULT 0,
    si66_tiporegistro int8 NOT NULL DEFAULT 0,
    si66_codorgao varchar(2) NOT NULL,
    si66_codunidadesub varchar(8) NULL,
    si66_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si66_nroprocessolicitatorio varchar(12) NOT NULL,
    si66_dataparecer date NOT NULL,
    si66_tipoparecer int8 NOT NULL DEFAULT 0,
    si66_nrocpf varchar(11) NOT NULL,
    si66_mes int8 NOT NULL DEFAULT 0,
    si66_instit int8 NULL DEFAULT 0,
    CONSTRAINT parelic102021_sequ_pk PRIMARY KEY (si66_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parpps102021 definition

-- Drop table

-- DROP TABLE parpps102021;

CREATE TABLE parpps102021 (
    si156_sequencial int8 NOT NULL DEFAULT 0,
    si156_tiporegistro int8 NOT NULL DEFAULT 0,
    si156_codorgao varchar(2) NOT NULL,
    si156_tipoplano int8 NOT NULL DEFAULT 0,
    si156_exercicio int8 NOT NULL DEFAULT 0,
    si156_vlsaldofinanceiroexercicioanterior float8 NOT NULL DEFAULT 0,
    si156_vlreceitaprevidenciariaanterior float8 NOT NULL DEFAULT 0,
    si156_vldespesaprevidenciariaanterior float8 NOT NULL DEFAULT 0,
    si156_mes int8 NOT NULL DEFAULT 0,
    si156_instit int8 NULL DEFAULT 0,
    CONSTRAINT parpps102021_sequ_pk PRIMARY KEY (si156_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parpps202021 definition

-- Drop table

-- DROP TABLE parpps202021;

CREATE TABLE parpps202021 (
    si155_sequencial int8 NOT NULL DEFAULT 0,
    si155_tiporegistro int8 NOT NULL DEFAULT 0,
    si155_codorgao varchar(2) NOT NULL,
    si155_tipoplano int8 NOT NULL DEFAULT 0,
    si155_exercicio int8 NOT NULL DEFAULT 0,
    si155_vlreceitaprevidenciaria float8 NOT NULL DEFAULT 0,
    si155_vldespesaprevidenciaria float8 NOT NULL DEFAULT 0,
    si155_mes int8 NOT NULL DEFAULT 0,
    si155_instit int8 NULL DEFAULT 0,
    si155_dtavaliacao date NULL,
    CONSTRAINT parpps202021_sequ_pk PRIMARY KEY (si155_sequencial)
)
WITH (
    OIDS=TRUE
);


-- pessoa102021 definition

-- Drop table

-- DROP TABLE pessoa102021;

CREATE TABLE pessoa102021 (
    si12_sequencial int8 NOT NULL DEFAULT 0,
    si12_tiporegistro int8 NOT NULL DEFAULT 0,
    si12_tipodocumento int8 NOT NULL DEFAULT 0,
    si12_nrodocumento varchar(14) NOT NULL,
    si12_nomerazaosocial varchar(120) NOT NULL,
    si12_tipocadastro int8 NOT NULL DEFAULT 0,
    si12_justificativaalteracao varchar(100) NULL,
    si12_mes int8 NOT NULL DEFAULT 0,
    si12_instit int8 NULL DEFAULT 0,
    CONSTRAINT pessoa102021_sequ_pk PRIMARY KEY (si12_sequencial)
)
WITH (
    OIDS=TRUE
);


-- pessoaflpgo102021 definition

-- Drop table

-- DROP TABLE pessoaflpgo102021;

CREATE TABLE pessoaflpgo102021 (
    si193_sequencial int8 NOT NULL DEFAULT 0,
    si193_tiporegistro int8 NOT NULL DEFAULT 0,
    si193_tipodocumento int8 NOT NULL DEFAULT 0,
    si193_nrodocumento varchar(14) NOT NULL,
    si193_nome varchar(120) NOT NULL,
    si193_indsexo varchar(1) NULL,
    si193_datanascimento date NULL,
    si193_tipocadastro int8 NOT NULL DEFAULT 0,
    si193_justalteracao varchar(100) NULL,
    si193_mes int8 NOT NULL DEFAULT 0,
    si193_inst int8 NULL DEFAULT 0,
    CONSTRAINT pessoaflpgo102021_sequ_pk PRIMARY KEY (si193_sequencial)
)
WITH (
    OIDS=TRUE
);


-- pessoasobra102021 definition

-- Drop table

-- DROP TABLE pessoasobra102021;

CREATE TABLE pessoasobra102021 (
    si194_sequencial int8 NULL,
    si194_tiporegistro int8 NULL,
    si194_nrodocumento varchar(14) NULL,
    si194_nome varchar(120) NULL,
    si194_tipocadastro int8 NULL,
    si194_justificativaalteracao text NULL,
    si194_mes int8 NULL,
    si194_instit int4 NULL
)
WITH (
    OIDS=TRUE
);


-- rec102021 definition

-- Drop table

-- DROP TABLE rec102021;

CREATE TABLE rec102021 (
    si25_sequencial int8 NOT NULL DEFAULT 0,
    si25_tiporegistro int8 NOT NULL DEFAULT 0,
    si25_codreceita int8 NOT NULL DEFAULT 0,
    si25_codorgao varchar(2) NOT NULL,
    si25_ededucaodereceita int8 NOT NULL DEFAULT 0,
    si25_identificadordeducao int8 NOT NULL DEFAULT 0,
    si25_naturezareceita int8 NOT NULL DEFAULT 0,
    si25_regularizacaorepasse int8 NULL DEFAULT 0,
    si25_exercicio varchar(4) NULL,
    si25_emendaparlamentar int8 NOT NULL DEFAULT 0,
    si25_vlarrecadado float8 NOT NULL DEFAULT 0,
    si25_mes int8 NOT NULL DEFAULT 0,
    si25_instit int8 NULL DEFAULT 0,
    CONSTRAINT rec102021_sequ_pk PRIMARY KEY (si25_sequencial)
)
WITH (
    OIDS=TRUE
);


-- regadesao102021 definition

-- Drop table

-- DROP TABLE regadesao102021;

CREATE TABLE regadesao102021 (
    si67_sequencial int8 NOT NULL DEFAULT 0,
    si67_tiporegistro int8 NOT NULL DEFAULT 0,
    si67_tipocadastro int4 NOT NULL,
    si67_codorgao varchar(2) NOT NULL,
    si67_codunidadesub varchar(8) NOT NULL,
    si67_nroprocadesao varchar(12) NOT NULL,
    si63_exercicioadesao int8 NOT NULL DEFAULT 0,
    si67_dtabertura date NOT NULL,
    si67_nomeorgaogerenciador varchar(100) NOT NULL,
    si67_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si67_nroprocessolicitatorio varchar(20) NOT NULL,
    si67_codmodalidadelicitacao int8 NOT NULL DEFAULT 0,
    si67_nroedital int4 NOT NULL,
    si67_exercicioedital int4 NOT NULL,
    si67_dtataregpreco date NOT NULL,
    si67_dtvalidade date NOT NULL,
    si67_naturezaprocedimento int8 NOT NULL DEFAULT 0,
    si67_dtpublicacaoavisointencao date NULL,
    si67_objetoadesao varchar(500) NOT NULL,
    si67_cpfresponsavel varchar(11) NOT NULL,
    si67_descontotabela int8 NOT NULL DEFAULT 0,
    si67_processoporlote int8 NOT NULL DEFAULT 0,
    si67_mes int8 NOT NULL DEFAULT 0,
    si67_instit int8 NULL DEFAULT 0,
    CONSTRAINT regadesao102021_sequ_pk PRIMARY KEY (si67_sequencial)
)
WITH (
    OIDS=TRUE
);


-- regadesao202021 definition

-- Drop table

-- DROP TABLE regadesao202021;

CREATE TABLE regadesao202021 (
    si73_sequencial int8 NOT NULL DEFAULT 0,
    si73_tiporegistro int8 NOT NULL DEFAULT 0,
    si73_codorgao varchar(2) NOT NULL,
    si73_codunidadesub varchar(8) NOT NULL,
    si73_nroprocadesao varchar(12) NOT NULL,
    si73_exercicioadesao int8 NOT NULL DEFAULT 0,
    si73_nrolote int8 NULL DEFAULT 0,
    si73_coditem int8 NULL DEFAULT 0,
    si73_percdesconto float8 NOT NULL DEFAULT 0,
    si73_tipodocumento int8 NOT NULL DEFAULT 0,
    si73_nrodocumento varchar(14) NOT NULL,
    si73_mes int8 NOT NULL DEFAULT 0,
    si73_instit int8 NULL DEFAULT 0,
    CONSTRAINT regadesao202021_sequ_pk PRIMARY KEY (si73_sequencial)
)
WITH (
    OIDS=TRUE
);


-- reglic102021 definition

-- Drop table

-- DROP TABLE reglic102021;

CREATE TABLE reglic102021 (
    si44_sequencial int8 NOT NULL DEFAULT 0,
    si44_tiporegistro int8 NOT NULL DEFAULT 0,
    si44_codorgao varchar(2) NOT NULL,
    si44_tipodecreto int8 NOT NULL DEFAULT 0,
    si44_nrodecretomunicipal int8 NOT NULL DEFAULT 0,
    si44_datadecretomunicipal date NOT NULL,
    si44_datapublicacaodecretomunicipal date NOT NULL,
    si44_mes int8 NOT NULL DEFAULT 0,
    si44_instit int8 NULL DEFAULT 0,
    CONSTRAINT reglic102021_sequ_pk PRIMARY KEY (si44_sequencial)
)
WITH (
    OIDS=TRUE
);


-- reglic202021 definition

-- Drop table

-- DROP TABLE reglic202021;

CREATE TABLE reglic202021 (
    si45_sequencial int8 NOT NULL DEFAULT 0,
    si45_tiporegistro int8 NOT NULL DEFAULT 0,
    si45_codorgao varchar(2) NOT NULL,
    si45_regulamentart47 int8 NOT NULL DEFAULT 0,
    si45_nronormareg varchar(6) NULL,
    si45_datanormareg date NULL,
    si45_datapubnormareg date NULL,
    si45_regexclusiva int8 NULL DEFAULT 0,
    si45_artigoregexclusiva varchar(6) NULL,
    si45_valorlimiteregexclusiva float8 NOT NULL DEFAULT 0,
    si45_procsubcontratacao int8 NULL DEFAULT 0,
    si45_artigoprocsubcontratacao varchar(6) NULL,
    si45_percentualsubcontratacao float8 NOT NULL DEFAULT 0,
    si45_criteriosempenhopagamento int8 NULL DEFAULT 0,
    si45_artigoempenhopagamento varchar(6) NULL,
    si45_estabeleceuperccontratacao int8 NULL DEFAULT 0,
    si45_artigoperccontratacao varchar(6) NULL,
    si45_percentualcontratacao float8 NOT NULL DEFAULT 0,
    si45_mes int8 NOT NULL DEFAULT 0,
    si45_instit int8 NULL DEFAULT 0,
    CONSTRAINT reglic202021_sequ_pk PRIMARY KEY (si45_sequencial)
)
WITH (
    OIDS=TRUE
);


-- resplic102021 definition

-- Drop table

-- DROP TABLE resplic102021;

CREATE TABLE resplic102021 (
    si55_sequencial int8 NOT NULL DEFAULT 0,
    si55_tiporegistro int8 NOT NULL DEFAULT 0,
    si55_codorgao varchar(2) NOT NULL,
    si55_codunidadesub varchar(8) NOT NULL,
    si55_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si55_nroprocessolicitatorio varchar(12) NOT NULL,
    si55_tiporesp int8 NOT NULL DEFAULT 0,
    si55_nrocpfresp varchar(11) NOT NULL,
    si55_mes int8 NOT NULL DEFAULT 0,
    si55_instit int8 NULL DEFAULT 0,
    CONSTRAINT resplic102021_sequ_pk PRIMARY KEY (si55_sequencial)
)
WITH (
    OIDS=TRUE
);


-- resplic202021 definition

-- Drop table

-- DROP TABLE resplic202021;

CREATE TABLE resplic202021 (
    si56_sequencial int8 NOT NULL DEFAULT 0,
    si56_tiporegistro int8 NOT NULL DEFAULT 0,
    si56_codorgao varchar(2) NOT NULL,
    si56_codunidadesub varchar(8) NOT NULL,
    si56_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si56_nroprocessolicitatorio varchar(12) NOT NULL,
    si56_codtipocomissao int8 NOT NULL DEFAULT 0,
    si56_descricaoatonomeacao int8 NOT NULL DEFAULT 0,
    si56_nroatonomeacao int8 NOT NULL DEFAULT 0,
    si56_dataatonomeacao date NOT NULL,
    si56_iniciovigencia date NOT NULL,
    si56_finalvigencia date NOT NULL,
    si56_cpfmembrocomissao varchar(11) NOT NULL,
    si56_codatribuicao int8 NOT NULL DEFAULT 0,
    si56_cargo varchar(50) NOT NULL,
    si56_naturezacargo int8 NOT NULL DEFAULT 0,
    si56_mes int8 NOT NULL DEFAULT 0,
    si56_instit int8 NULL DEFAULT 0,
    CONSTRAINT resplic202021_sequ_pk PRIMARY KEY (si56_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rsp102021 definition

-- Drop table

-- DROP TABLE rsp102021;

CREATE TABLE rsp102021 (
    si112_sequencial int8 NOT NULL DEFAULT 0,
    si112_tiporegistro int8 NOT NULL DEFAULT 0,
    si112_codreduzidorsp int8 NOT NULL DEFAULT 0,
    si112_codorgao varchar(2) NOT NULL,
    si112_codunidadesub varchar(8) NOT NULL,
    si112_codunidadesuborig varchar(8) NOT NULL,
    si112_nroempenho int8 NOT NULL DEFAULT 0,
    si112_exercicioempenho int8 NOT NULL DEFAULT 0,
    si112_dtempenho date NOT NULL,
    si112_dotorig varchar(21) NULL,
    si112_vloriginal float8 NOT NULL DEFAULT 0,
    si112_vlsaldoantproce float8 NOT NULL DEFAULT 0,
    si112_vlsaldoantnaoproc float8 NOT NULL DEFAULT 0,
    si112_mes int8 NOT NULL DEFAULT 0,
    si112_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp102021_sequ_pk PRIMARY KEY (si112_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rsp202021 definition

-- Drop table

-- DROP TABLE rsp202021;

CREATE TABLE rsp202021 (
    si115_sequencial int8 NOT NULL DEFAULT 0,
    si115_tiporegistro int8 NOT NULL DEFAULT 0,
    si115_codreduzidomov int8 NOT NULL DEFAULT 0,
    si115_codorgao varchar(2) NOT NULL,
    si115_codunidadesub varchar(8) NOT NULL,
    si115_codunidadesuborig varchar(8) NOT NULL,
    si115_nroempenho int8 NOT NULL DEFAULT 0,
    si115_exercicioempenho int8 NOT NULL DEFAULT 0,
    si115_dtempenho date NOT NULL,
    si115_tiporestospagar int8 NOT NULL DEFAULT 0,
    si115_tipomovimento int8 NOT NULL DEFAULT 0,
    si115_dtmovimentacao date NOT NULL,
    si115_dotorig varchar(21) NULL,
    si115_vlmovimentacao float8 NOT NULL DEFAULT 0,
    si115_codorgaoencampatribuic varchar(2) NULL,
    si115_codunidadesubencampatribuic varchar(8) NULL,
    si115_justificativa varchar(500) NOT NULL,
    si115_atocancelamento varchar(20) NULL,
    si115_dataatocancelamento date NULL,
    si115_mes int8 NOT NULL DEFAULT 0,
    si115_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp202021_sequ_pk PRIMARY KEY (si115_sequencial)
)
WITH (
    OIDS=TRUE
);


-- tce102021 definition

-- Drop table

-- DROP TABLE tce102021;

CREATE TABLE tce102021 (
    si187_sequencial int8 NOT NULL DEFAULT 0,
    si187_tiporegistro int8 NOT NULL DEFAULT 0,
    si187_numprocessotce varchar(12) NOT NULL,
    si187_datainstauracaotce date NOT NULL,
    si187_codunidadesub varchar(8) NOT NULL,
    si187_nroconvenioconge varchar(30) NOT NULL,
    si187_dataassinaturaconvoriginalconge date NOT NULL,
    si187_dscinstrumelegaltce varchar(50) NOT NULL,
    si187_nrocpfautoridadeinstauratce varchar(11) NOT NULL,
    si187_dsccargoresptce varchar(50) NOT NULL,
    si187_vloriginaldano float8 NOT NULL DEFAULT 0,
    si187_vlatualizadodano float8 NOT NULL DEFAULT 0,
    si187_dataatualizacao date NOT NULL,
    si187_indice varchar(20) NOT NULL,
    si187_ocorrehipotese int8 NOT NULL DEFAULT 0,
    si187_identiresponsavel int8 NOT NULL DEFAULT 0,
    si187_mes int8 NOT NULL DEFAULT 0,
    si187_instit int8 NULL DEFAULT 0,
    CONSTRAINT tce102021_sequ_pk PRIMARY KEY (si187_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic112021 definition

-- Drop table

-- DROP TABLE aberlic112021;

CREATE TABLE aberlic112021 (
    si47_sequencial int8 NOT NULL DEFAULT 0,
    si47_tiporegistro int8 NOT NULL DEFAULT 0,
    si47_codorgaoresp varchar(2) NOT NULL,
    si47_codunidadesubresp varchar(8) NOT NULL,
    si47_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si47_nroprocessolicitatorio varchar(12) NOT NULL,
    si47_nrolote int8 NOT NULL DEFAULT 0,
    si47_dsclote varchar(250) NOT NULL,
    si47_reg10 int8 NOT NULL DEFAULT 0,
    si47_mes int8 NOT NULL DEFAULT 0,
    si47_instit int8 NULL DEFAULT 0,
    CONSTRAINT aberlic112021_reg10_fk FOREIGN KEY (si47_reg10) REFERENCES aberlic102021(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic122021 definition

-- Drop table

-- DROP TABLE aberlic122021;

CREATE TABLE aberlic122021 (
    si48_sequencial int8 NOT NULL DEFAULT 0,
    si48_tiporegistro int8 NOT NULL DEFAULT 0,
    si48_codorgaoresp varchar(2) NOT NULL,
    si48_codunidadesubresp varchar(8) NOT NULL,
    si48_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si48_nroprocessolicitatorio varchar(12) NOT NULL,
    si48_coditem int8 NOT NULL DEFAULT 0,
    si48_nroitem int8 NOT NULL DEFAULT 0,
    si48_reg10 int8 NOT NULL DEFAULT 0,
    si48_mes int8 NOT NULL DEFAULT 0,
    si48_instit int8 NULL DEFAULT 0,
    CONSTRAINT aberlic122021_reg10_fk FOREIGN KEY (si48_reg10) REFERENCES aberlic102021(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic132021 definition

-- Drop table

-- DROP TABLE aberlic132021;

CREATE TABLE aberlic132021 (
    si49_sequencial int8 NOT NULL DEFAULT 0,
    si49_tiporegistro int8 NOT NULL DEFAULT 0,
    si49_codorgaoresp varchar(2) NOT NULL,
    si49_codunidadesubresp varchar(8) NOT NULL,
    si49_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si49_nroprocessolicitatorio varchar(12) NOT NULL,
    si49_nrolote int8 NOT NULL DEFAULT 0,
    si49_coditem int8 NOT NULL DEFAULT 0,
    si49_mes int8 NOT NULL DEFAULT 0,
    si49_reg10 int8 NOT NULL DEFAULT 0,
    si49_instit int8 NULL DEFAULT 0,
    CONSTRAINT aberlic132021_reg10_fk FOREIGN KEY (si49_reg10) REFERENCES aberlic102021(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic142021 definition

-- Drop table

-- DROP TABLE aberlic142021;

CREATE TABLE aberlic142021 (
    si50_sequencial int8 NOT NULL DEFAULT 0,
    si50_tiporegistro int8 NOT NULL DEFAULT 0,
    si50_codorgaoresp varchar(2) NOT NULL,
    si50_codunidadesubresp varchar(8) NOT NULL,
    si50_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si50_nroprocessolicitatorio varchar(12) NOT NULL,
    si50_nrolote int8 NULL DEFAULT 0,
    si50_coditem int8 NOT NULL DEFAULT 0,
    si50_dtcotacao date NOT NULL,
    si50_vlrefpercentual float4 NOT NULL DEFAULT 0,
    si50_vlcotprecosunitario float8 NOT NULL DEFAULT 0,
    si50_quantidade float8 NOT NULL DEFAULT 0,
    si50_vlminalienbens float8 NOT NULL DEFAULT 0,
    si50_mes int8 NOT NULL DEFAULT 0,
    si50_reg10 int8 NOT NULL DEFAULT 0,
    si50_instit int8 NULL DEFAULT 0,
    CONSTRAINT aberlic142021_reg10_fk FOREIGN KEY (si50_reg10) REFERENCES aberlic102021(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic152021 definition

-- Drop table

-- DROP TABLE aberlic152021;

CREATE TABLE aberlic152021 (
    si51_sequencial int8 NOT NULL DEFAULT 0,
    si51_tiporegistro int8 NOT NULL DEFAULT 0,
    si51_codorgaoresp varchar(2) NOT NULL,
    si51_codunidadesubresp varchar(8) NOT NULL,
    si51_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si51_nroprocessolicitatorio varchar(12) NOT NULL,
    si51_nrolote int8 NULL DEFAULT 0,
    si51_coditem int8 NOT NULL DEFAULT 0,
    si51_vlitem float8 NOT NULL DEFAULT 0,
    si51_mes int8 NOT NULL DEFAULT 0,
    si51_reg10 int8 NOT NULL DEFAULT 0,
    si51_instit int8 NULL DEFAULT 0,
    CONSTRAINT aberlic152021_reg10_fk FOREIGN KEY (si51_reg10) REFERENCES aberlic102021(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic162021 definition

-- Drop table

-- DROP TABLE aberlic162021;

CREATE TABLE aberlic162021 (
    si52_sequencial int8 NOT NULL DEFAULT 0,
    si52_tiporegistro int8 NOT NULL DEFAULT 0,
    si52_codorgaoresp varchar(2) NOT NULL,
    si52_codunidadesubresp varchar(8) NOT NULL,
    si52_exerciciolicitacao int8 NOT NULL DEFAULT 0,
    si52_nroprocessolicitatorio varchar(12) NOT NULL,
    si52_codorgao varchar(2) NOT NULL,
    si52_codunidadesub varchar(8) NOT NULL,
    si52_codfuncao varchar(2) NOT NULL,
    si52_codsubfuncao varchar(3) NOT NULL,
    si52_codprograma varchar(4) NOT NULL,
    si52_idacao varchar(4) NOT NULL,
    si52_idsubacao varchar(4) NULL,
    si52_naturezadespesa int8 NOT NULL DEFAULT 0,
    si52_codfontrecursos int8 NOT NULL DEFAULT 0,
    si52_vlrecurso float8 NOT NULL DEFAULT 0,
    si52_mes int8 NOT NULL DEFAULT 0,
    si52_reg10 int8 NOT NULL DEFAULT 0,
    si52_instit int8 NULL DEFAULT 0,
    CONSTRAINT aberlic162021_reg10_fk FOREIGN KEY (si52_reg10) REFERENCES aberlic102021(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- alq112021 definition

-- Drop table

-- DROP TABLE alq112021;

CREATE TABLE alq112021 (
    si122_sequencial int8 NOT NULL DEFAULT 0,
    si122_tiporegistro int8 NOT NULL DEFAULT 0,
    si122_codreduzido int8 NOT NULL DEFAULT 0,
    si122_codfontrecursos int8 NOT NULL DEFAULT 0,
    si122_valoranuladofonte float8 NOT NULL DEFAULT 0,
    si122_mes int8 NOT NULL DEFAULT 0,
    si122_reg10 int8 NOT NULL DEFAULT 0,
    si122_instit int8 NULL DEFAULT 0,
    CONSTRAINT alq112021_sequ_pk PRIMARY KEY (si122_sequencial),
    CONSTRAINT alq112021_reg10_fk FOREIGN KEY (si122_reg10) REFERENCES alq102021(si121_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX alq112021_si122_reg10_index ON alq112021 USING btree (si122_reg10);


-- alq122021 definition

-- Drop table

-- DROP TABLE alq122021;

CREATE TABLE alq122021 (
    si123_sequencial int8 NOT NULL DEFAULT 0,
    si123_tiporegistro int8 NOT NULL DEFAULT 0,
    si123_codreduzido int8 NOT NULL DEFAULT 0,
    si123_mescompetencia varchar(2) NOT NULL,
    si123_exerciciocompetencia int8 NOT NULL DEFAULT 0,
    si123_vlanuladodspexerant float8 NOT NULL DEFAULT 0,
    si123_mes int8 NOT NULL DEFAULT 0,
    si123_reg10 int8 NOT NULL DEFAULT 0,
    si123_instit int8 NULL DEFAULT 0,
    CONSTRAINT alq122021_sequ_pk PRIMARY KEY (si123_sequencial),
    CONSTRAINT alq122021_reg10_fk FOREIGN KEY (si123_reg10) REFERENCES alq102021(si121_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX alq122021_si123_reg10_index ON alq122021 USING btree (si123_reg10);


-- anl112021 definition

-- Drop table

-- DROP TABLE anl112021;

CREATE TABLE anl112021 (
    si111_sequencial int8 NOT NULL DEFAULT 0,
    si111_tiporegistro int8 NOT NULL DEFAULT 0,
    si111_codunidadesub varchar(8) NOT NULL,
    si111_nroempenho int8 NOT NULL DEFAULT 0,
    si111_nroanulacao int8 NOT NULL DEFAULT 0,
    si111_codfontrecursos int8 NOT NULL DEFAULT 0,
    si111_vlanulacaofonte float8 NOT NULL DEFAULT 0,
    si111_mes int8 NOT NULL DEFAULT 0,
    si111_reg10 int8 NOT NULL DEFAULT 0,
    si111_instit int8 NULL DEFAULT 0,
    CONSTRAINT anl112021_sequ_pk PRIMARY KEY (si111_sequencial),
    CONSTRAINT anl112021_reg10_fk FOREIGN KEY (si111_reg10) REFERENCES anl102021(si110_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX anl112021_si111_reg10_index ON anl112021 USING btree (si111_reg10);


-- aob112021 definition

-- Drop table

-- DROP TABLE aob112021;

CREATE TABLE aob112021 (
    si142_sequencial int8 NOT NULL DEFAULT 0,
    si142_tiporegistro int8 NOT NULL DEFAULT 0,
    si142_codreduzido int8 NOT NULL DEFAULT 0,
    si142_codfontrecursos int8 NOT NULL DEFAULT 0,
    si142_valoranulacaofonte float8 NOT NULL DEFAULT 0,
    si142_mes int8 NOT NULL DEFAULT 0,
    si142_reg10 int8 NOT NULL DEFAULT 0,
    si142_instit int8 NULL DEFAULT 0,
    CONSTRAINT aob112021_sequ_pk PRIMARY KEY (si142_sequencial),
    CONSTRAINT aob112021_reg10_fk FOREIGN KEY (si142_reg10) REFERENCES aob102021(si141_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aob112021_si142_reg10_index ON aob112021 USING btree (si142_reg10);


-- aoc112021 definition

-- Drop table

-- DROP TABLE aoc112021;

CREATE TABLE aoc112021 (
    si39_sequencial int8 NOT NULL DEFAULT 0,
    si39_tiporegistro int8 NOT NULL DEFAULT 0,
    si39_codreduzidodecreto int8 NOT NULL DEFAULT 0,
    si39_nrodecreto varchar(8) NOT NULL DEFAULT 0,
    si39_tipodecretoalteracao int8 NOT NULL DEFAULT 0,
    si39_valoraberto float8 NOT NULL DEFAULT 0,
    si39_mes int8 NOT NULL DEFAULT 0,
    si39_reg10 int8 NOT NULL DEFAULT 0,
    si39_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc112021_sequ_pk PRIMARY KEY (si39_sequencial),
    CONSTRAINT aoc112021_reg10_fk FOREIGN KEY (si39_reg10) REFERENCES aoc102021(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc112021_si39_reg10_index ON aoc112021 USING btree (si39_reg10);


-- aoc122021 definition

-- Drop table

-- DROP TABLE aoc122021;

CREATE TABLE aoc122021 (
    si40_sequencial int8 NOT NULL DEFAULT 0,
    si40_tiporegistro int8 NOT NULL DEFAULT 0,
    si40_codreduzidodecreto int8 NOT NULL DEFAULT 0,
    si40_nroleialteracao varchar(6) NOT NULL,
    si40_dataleialteracao date NULL,
    si40_tpleiorigdecreto varchar(4) NOT NULL,
    si40_tipoleialteracao int8 NULL DEFAULT 0,
    si40_valorabertolei float8 NULL,
    si40_mes int8 NOT NULL DEFAULT 0,
    si40_reg10 int8 NOT NULL DEFAULT 0,
    si40_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc122021_sequ_pk PRIMARY KEY (si40_sequencial),
    CONSTRAINT aoc122021_reg10_fk FOREIGN KEY (si40_reg10) REFERENCES aoc102021(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc122021_si40_reg10_index ON aoc122021 USING btree (si40_reg10);


-- aoc132021 definition

-- Drop table

-- DROP TABLE aoc132021;

CREATE TABLE aoc132021 (
    si41_sequencial int8 NOT NULL DEFAULT 0,
    si41_tiporegistro int8 NOT NULL DEFAULT 0,
    si41_codreduzidodecreto int8 NOT NULL DEFAULT 0,
    si41_origemrecalteracao varchar(2) NOT NULL,
    si41_valorabertoorigem float8 NOT NULL DEFAULT 0,
    si41_mes int8 NOT NULL DEFAULT 0,
    si41_reg10 int8 NOT NULL DEFAULT 0,
    si41_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc132021_sequ_pk PRIMARY KEY (si41_sequencial),
    CONSTRAINT aoc132021_reg10_fk FOREIGN KEY (si41_reg10) REFERENCES aoc102021(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc132021_si41_reg10_index ON aoc132021 USING btree (si41_reg10);


-- aoc142021 definition

-- Drop table

-- DROP TABLE aoc142021;

CREATE TABLE aoc142021 (
    si42_sequencial int8 NOT NULL DEFAULT 0,
    si42_tiporegistro int8 NOT NULL DEFAULT 0,
    si42_codreduzidodecreto int8 NOT NULL DEFAULT 0,
    si42_origemrecalteracao varchar(2) NOT NULL,
    si42_codorigem int8 NULL DEFAULT 0,
    si42_codorgao varchar(2) NOT NULL,
    si42_codunidadesub varchar(8) NOT NULL,
    si42_codfuncao varchar(2) NOT NULL,
    si42_codsubfuncao varchar(3) NOT NULL,
    si42_codprograma varchar(4) NOT NULL,
    si42_idacao varchar(4) NOT NULL,
    si42_idsubacao varchar(4) NULL,
    si42_naturezadespesa int8 NOT NULL DEFAULT 0,
    si42_codfontrecursos int8 NOT NULL DEFAULT 0,
    si42_vlacrescimo float8 NOT NULL DEFAULT 0,
    si42_mes int8 NOT NULL DEFAULT 0,
    si42_reg10 int8 NOT NULL DEFAULT 0,
    si42_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc142021_sequ_pk PRIMARY KEY (si42_sequencial),
    CONSTRAINT aoc142021_reg10_fk FOREIGN KEY (si42_reg10) REFERENCES aoc102021(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc142021_si42_reg10_index ON aoc142021 USING btree (si42_reg10);


-- aoc152021 definition

-- Drop table

-- DROP TABLE aoc152021;

CREATE TABLE aoc152021 (
    si194_sequencial int8 NOT NULL DEFAULT 0,
    si194_tiporegistro int8 NOT NULL DEFAULT 0,
    si194_codreduzidodecreto int8 NOT NULL DEFAULT 0,
    si194_origemrecalteracao varchar(2) NOT NULL,
    si194_codorigem int8 NOT NULL DEFAULT 0,
    si194_codorgao varchar(2) NOT NULL,
    si194_codunidadesub varchar(8) NOT NULL,
    si194_codfuncao varchar(2) NOT NULL,
    si194_codsubfuncao varchar(3) NOT NULL,
    si194_codprograma varchar(4) NOT NULL,
    si194_idacao varchar(4) NOT NULL,
    si194_idsubacao varchar(4) NULL DEFAULT NULL::character varying,
    si194_naturezadespesa int8 NOT NULL DEFAULT 0,
    si194_codfontrecursos int8 NOT NULL DEFAULT 0,
    si194_vlreducao float8 NOT NULL DEFAULT 0,
    si194_mes int8 NOT NULL DEFAULT 0,
    si194_reg10 int8 NOT NULL DEFAULT 0,
    si194_instit int8 NOT NULL DEFAULT 0,
    CONSTRAINT aoc152021_sequ_pk PRIMARY KEY (si194_sequencial),
    CONSTRAINT aoc152021_reg10_fk FOREIGN KEY (si194_reg10) REFERENCES aoc102021(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc152021_si194_reg10_index ON aoc152021 USING btree (si194_reg10);


-- aop112021 definition

-- Drop table

-- DROP TABLE aop112021;

CREATE TABLE aop112021 (
    si138_sequencial int8 NOT NULL DEFAULT 0,
    si138_tiporegistro int8 NOT NULL DEFAULT 0,
    si138_codreduzido int8 NOT NULL DEFAULT 0,
    si138_tipopagamento int8 NOT NULL DEFAULT 0,
    si138_nroempenho int8 NOT NULL DEFAULT 0,
    si138_dtempenho date NOT NULL,
    si138_nroliquidacao int8 NULL DEFAULT 0,
    si138_dtliquidacao date NULL,
    si138_codfontrecursos int8 NOT NULL DEFAULT 0,
    si138_valoranulacaofonte float8 NOT NULL DEFAULT 0,
    si138_mes int8 NOT NULL DEFAULT 0,
    si138_reg10 int8 NOT NULL DEFAULT 0,
    si138_instit int8 NULL DEFAULT 0,
    CONSTRAINT aop112021_sequ_pk PRIMARY KEY (si138_sequencial),
    CONSTRAINT aop112021_reg10_fk FOREIGN KEY (si138_reg10) REFERENCES aop102021(si137_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aop112021_si138_reg10_index ON aop112021 USING btree (si138_reg10);


-- arc112021 definition

-- Drop table

-- DROP TABLE arc112021;

CREATE TABLE arc112021 (
    si29_sequencial int8 NOT NULL DEFAULT 0,
    si29_tiporegistro int8 NOT NULL DEFAULT 0,
    si29_codcorrecao int8 NOT NULL DEFAULT 0,
    si29_codfontereduzida int8 NOT NULL DEFAULT 0,
    si29_tipodocumento int8 NULL DEFAULT 0,
    si29_nrodocumento varchar(14) NULL,
    si29_nroconvenio varchar(30) NULL,
    si29_dataassinatura varchar(8) NULL,
    si29_vlreduzidofonte float8 NOT NULL DEFAULT 0,
    si29_reg10 int8 NOT NULL DEFAULT 0,
    si29_mes int8 NOT NULL DEFAULT 0,
    si29_instit int8 NULL DEFAULT 0,
    CONSTRAINT arc112021_sequ_pk PRIMARY KEY (si29_sequencial),
    CONSTRAINT arc112021_reg10_fk FOREIGN KEY (si29_reg10) REFERENCES arc102021(si28_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX arc112021_si15_reg10_index ON arc112021 USING btree (si29_reg10);


-- arc122021 definition

-- Drop table

-- DROP TABLE arc122021;

CREATE TABLE arc122021 (
    si30_sequencial int8 NOT NULL DEFAULT 0,
    si30_tiporegistro int8 NOT NULL DEFAULT 0,
    si30_codcorrecao int8 NOT NULL DEFAULT 0,
    si30_codfonteacrescida int8 NOT NULL DEFAULT 0,
    si30_tipodocumento int8 NULL DEFAULT 0,
    si30_nrodocumento varchar(14) NULL,
    si30_nroconvenio varchar(30) NULL,
    si30_datassinatura date NULL,
    si30_vlacrescidofonte float8 NOT NULL DEFAULT 0,
    si30_reg10 int8 NOT NULL DEFAULT 0,
    si30_mes int8 NOT NULL DEFAULT 0,
    si30_instit int8 NULL DEFAULT 0,
    CONSTRAINT arc122021_sequ_pk PRIMARY KEY (si30_sequencial),
    CONSTRAINT arc122021_reg10_fk FOREIGN KEY (si30_reg10) REFERENCES arc102021(si28_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX arc122021_si30_reg10_index ON arc122021 USING btree (si30_reg10);


-- arc212021 definition

-- Drop table

-- DROP TABLE arc212021;

CREATE TABLE arc212021 (
    si32_sequencial int8 NOT NULL DEFAULT 0,
    si32_tiporegistro int8 NOT NULL DEFAULT 0,
    si32_codestorno int8 NOT NULL DEFAULT 0,
    si32_codfonteestornada int8 NOT NULL DEFAULT 0,
    si32_tipodocumento int8 NULL,
    si32_nrodocumento varchar(14) NULL DEFAULT NULL::character varying,
    si32_nroconvenio varchar(30) NULL DEFAULT NULL::character varying,
    si32_dataassinatura date NULL,
    si32_vlestornadofonte float8 NOT NULL DEFAULT 0,
    si32_reg20 int8 NOT NULL DEFAULT 0,
    si32_instit int8 NULL DEFAULT 0,
    si32_mes int8 NOT NULL,
    CONSTRAINT arc212021_sequ_pk PRIMARY KEY (si32_sequencial),
    CONSTRAINT arc212021_reg20_fk FOREIGN KEY (si32_reg20) REFERENCES arc202021(si31_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX arcwq2021_si32_reg20_index ON arc212021 USING btree (si32_reg20);


-- caixa112021 definition

-- Drop table

-- DROP TABLE caixa112021;

CREATE TABLE caixa112021 (
    si166_sequencial int8 NOT NULL DEFAULT 0,
    si166_tiporegistro int8 NOT NULL DEFAULT 0,
    si166_codfontecaixa int8 NOT NULL DEFAULT 0,
    si166_vlsaldoinicialfonte float8 NOT NULL DEFAULT 0,
    si166_vlsaldofinalfonte float8 NOT NULL DEFAULT 0,
    si166_mes int8 NOT NULL DEFAULT 0,
    si166_instit int8 NULL DEFAULT 0,
    si166_reg10 int8 NOT NULL DEFAULT 0,
    CONSTRAINT caixa112021_sequ_pk PRIMARY KEY (si166_sequencial),
    CONSTRAINT caixa112021_reg10_fk FOREIGN KEY (si166_reg10) REFERENCES caixa102021(si103_sequencial)
)
WITH (
    OIDS=TRUE
);


-- caixa122021 definition

-- Drop table

-- DROP TABLE caixa122021;

CREATE TABLE caixa122021 (
    si104_sequencial int8 NOT NULL DEFAULT 0,
    si104_tiporegistro int8 NOT NULL DEFAULT 0,
    si104_codreduzido int8 NOT NULL DEFAULT 0,
    si104_codfontecaixa int8 NOT NULL DEFAULT 0,
    si104_tipomovimentacao int8 NOT NULL DEFAULT 0,
    si104_tipoentrsaida varchar(2) NOT NULL,
    si104_descrmovimentacao varchar(50) NULL,
    si104_valorentrsaida float8 NOT NULL DEFAULT 0,
    si104_codctbtransf int8 NULL DEFAULT 0,
    si104_codfontectbtransf int8 NULL DEFAULT 0,
    si104_mes int8 NOT NULL DEFAULT 0,
    si104_reg10 int8 NOT NULL DEFAULT 0,
    si104_instit int8 NULL DEFAULT 0,
    CONSTRAINT caixa122021_sequ_pk PRIMARY KEY (si104_sequencial),
    CONSTRAINT caixa122021_reg10_fk FOREIGN KEY (si104_reg10) REFERENCES caixa102021(si103_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX caixa122021_si104_reg10_index ON caixa122021 USING btree (si104_reg10);


-- caixa132021 definition

-- Drop table

-- DROP TABLE caixa132021;

CREATE TABLE caixa132021 (
    si105_sequencial int8 NOT NULL DEFAULT 0,
    si105_tiporegistro int8 NOT NULL DEFAULT 0,
    si105_codreduzido int8 NOT NULL DEFAULT 0,
    si105_ededucaodereceita int8 NOT NULL DEFAULT 0,
    si105_identificadordeducao int8 NULL DEFAULT 0,
    si105_naturezareceita int8 NOT NULL DEFAULT 0,
    si105_codfontecaixa int8 NOT NULL DEFAULT 0,
    si105_vlrreceitacont float8 NOT NULL DEFAULT 0,
    si105_mes int8 NOT NULL DEFAULT 0,
    si105_reg10 int8 NOT NULL DEFAULT 0,
    si105_instit int8 NULL DEFAULT 0,
    si105_codfontcaixa int4 NULL DEFAULT 0,
    CONSTRAINT caixa132021_sequ_pk PRIMARY KEY (si105_sequencial),
    CONSTRAINT caixa132021_reg10_fk FOREIGN KEY (si105_reg10) REFERENCES caixa102021(si103_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX caixa132021_si105_reg10_index ON caixa132021 USING btree (si105_reg10);


-- contratos112021 definition

-- Drop table

-- DROP TABLE contratos112021;

CREATE TABLE contratos112021 (
    si84_sequencial int8 NOT NULL DEFAULT 0,
    si84_tiporegistro int8 NOT NULL DEFAULT 0,
    si84_codcontrato int8 NOT NULL DEFAULT 0,
    si84_coditem int8 NOT NULL DEFAULT 0,
    si84_tipomaterial int8 NULL DEFAULT 0,
    si84_coditemsinapi varchar(15) NULL,
    si84_coditemsimcro varchar(15) NULL,
    si84_descoutrosmateriais varchar(250) NULL,
    si84_itemplanilha int8 NULL DEFAULT 0,
    si84_quantidadeitem float8 NOT NULL DEFAULT 0,
    si84_valorunitarioitem float8 NOT NULL DEFAULT 0,
    si84_mes int8 NOT NULL DEFAULT 0,
    si84_reg10 int8 NOT NULL DEFAULT 0,
    si84_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos112021_sequ_pk PRIMARY KEY (si84_sequencial),
    CONSTRAINT contratos112021_reg10_fk FOREIGN KEY (si84_reg10) REFERENCES contratos102021(si83_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos212021 definition

-- Drop table

-- DROP TABLE contratos212021;

CREATE TABLE contratos212021 (
    si88_sequencial int8 NOT NULL DEFAULT 0,
    si88_tiporegistro int8 NOT NULL DEFAULT 0,
    si88_codaditivo int8 NOT NULL DEFAULT 0,
    si88_coditem int8 NOT NULL DEFAULT 0,
    si88_tipomaterial int8 NULL DEFAULT 0,
    si88_coditemsinapi varchar(15) NULL,
    si88_coditemsimcro varchar(15) NULL,
    si88_descoutrosmateriais varchar(250) NULL,
    si88_itemplanilha int8 NULL DEFAULT 0,
    si88_tipoalteracaoitem int8 NOT NULL DEFAULT 0,
    si88_quantacrescdecresc float8 NOT NULL DEFAULT 0,
    si88_valorunitarioitem float8 NOT NULL DEFAULT 0,
    si88_mes int8 NOT NULL DEFAULT 0,
    si88_reg20 int8 NOT NULL DEFAULT 0,
    si88_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos212021_sequ_pk PRIMARY KEY (si88_sequencial),
    CONSTRAINT contratos212021_reg20_fk FOREIGN KEY (si88_reg20) REFERENCES contratos202021(si87_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conv112021 definition

-- Drop table

-- DROP TABLE conv112021;

CREATE TABLE conv112021 (
    si93_sequencial int8 NOT NULL DEFAULT 0,
    si93_tiporegistro int8 NOT NULL DEFAULT 0,
    si93_codconvenio int8 NOT NULL DEFAULT 0,
    si93_tipodocumento int8 NULL DEFAULT 0,
    si93_nrodocumento varchar(14) NULL,
    si93_esferaconcedente int8 NOT NULL DEFAULT 0,
    si93_dscexterior varchar(120) NULL,
    si93_valorconcedido float8 NOT NULL DEFAULT 0,
    si93_mes int8 NOT NULL DEFAULT 0,
    si93_reg10 int8 NOT NULL DEFAULT 0,
    si93_instit int8 NULL DEFAULT 0,
    CONSTRAINT conv112021_sequ_pk PRIMARY KEY (si93_sequencial),
    CONSTRAINT conv112021_reg10_fk FOREIGN KEY (si93_reg10) REFERENCES conv102021(si92_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX conv112021_si93_reg10_index ON conv112021 USING btree (si93_reg10);


-- ctb212021 definition

-- Drop table

-- DROP TABLE ctb212021;

CREATE TABLE ctb212021 (
    si97_sequencial int8 NOT NULL DEFAULT 0,
    si97_tiporegistro int8 NOT NULL DEFAULT 0,
    si97_codctb int8 NOT NULL DEFAULT 0,
    si97_codfontrecursos int8 NOT NULL DEFAULT 0,
    si97_codreduzidomov int8 NOT NULL DEFAULT 0,
    si97_tipomovimentacao int8 NOT NULL DEFAULT 0,
    si97_tipoentrsaida varchar(2) NOT NULL,
    si97_dscoutrasmov varchar(50) NULL,
    si97_valorentrsaida float8 NOT NULL DEFAULT 0,
    si97_codctbtransf int8 NULL DEFAULT 0,
    si97_codfontectbtransf int8 NOT NULL DEFAULT 0,
    si97_mes int8 NOT NULL DEFAULT 0,
    si97_reg20 int8 NOT NULL DEFAULT 0,
    si97_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb212021_sequ_pk PRIMARY KEY (si97_sequencial),
    CONSTRAINT ctb212021_reg20_fk FOREIGN KEY (si97_reg20) REFERENCES ctb202021(si96_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ctb212021_si97_reg20_index ON ctb212021 USING btree (si97_reg20);


-- ctb222021 definition

-- Drop table

-- DROP TABLE ctb222021;

CREATE TABLE ctb222021 (
    si98_sequencial int8 NOT NULL DEFAULT 0,
    si98_tiporegistro int8 NOT NULL DEFAULT 0,
    si98_codreduzidomov int8 NOT NULL DEFAULT 0,
    si98_ededucaodereceita int8 NOT NULL DEFAULT 0,
    si98_identificadordeducao int8 NULL DEFAULT 0,
    si98_naturezareceita int8 NOT NULL DEFAULT 0,
    si98_codfontrecursos int8 NOT NULL DEFAULT 0,
    si98_vlrreceitacont float8 NOT NULL DEFAULT 0,
    si98_mes int8 NOT NULL DEFAULT 0,
    si98_reg21 int8 NOT NULL DEFAULT 0,
    si98_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb222021_sequ_pk PRIMARY KEY (si98_sequencial),
    CONSTRAINT ctb222021_reg21_fk FOREIGN KEY (si98_reg21) REFERENCES ctb212021(si97_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ctb222021_si98_reg21_index ON ctb222021 USING btree (si98_reg21);


-- ctb312021 definition

-- Drop table

-- DROP TABLE ctb312021;

CREATE TABLE ctb312021 (
    si100_sequencial int8 NOT NULL DEFAULT 0,
    si100_tiporegistro int8 NOT NULL DEFAULT 0,
    si100_codagentearrecadador int8 NOT NULL DEFAULT 0,
    si100_codfontrecursos int8 NOT NULL DEFAULT 0,
    si100_vlsaldoinicialagfonte float8 NOT NULL DEFAULT 0,
    si100_vlentradafonte float8 NOT NULL DEFAULT 0,
    si100_vlsaidafonte float8 NOT NULL DEFAULT 0,
    si100_vlsaldofinalagfonte float8 NOT NULL DEFAULT 0,
    si100_mes int8 NOT NULL DEFAULT 0,
    si100_reg30 int8 NOT NULL DEFAULT 0,
    si100_instit int4 NULL DEFAULT 0,
    CONSTRAINT ctb312021_sequ_pk PRIMARY KEY (si100_sequencial),
    CONSTRAINT ctb312021_reg30_fk FOREIGN KEY (si100_reg30) REFERENCES ctb302021(si99_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ctb312021_si100_reg30_index ON ctb312021 USING btree (si100_reg30);


-- cute212021 definition

-- Drop table

-- DROP TABLE cute212021;

CREATE TABLE cute212021 (
    si201_sequencial int8 NOT NULL DEFAULT 0,
    si201_tiporegistro int8 NOT NULL DEFAULT 0,
    si201_codctb int8 NOT NULL DEFAULT 0,
    si201_codfontrecursos int8 NOT NULL DEFAULT 0,
    si201_tipomovimentacao int8 NOT NULL DEFAULT 0,
    si201_tipoentrsaida varchar(2) NOT NULL,
    si201_valorentrsaida float8 NOT NULL DEFAULT 0,
    si201_codorgaotransf varchar(2) NULL,
    si201_reg10 int8 NOT NULL DEFAULT 0,
    si201_mes int8 NOT NULL DEFAULT 0,
    si201_instit int8 NULL DEFAULT 0,
    CONSTRAINT cute212021_sequ_pk PRIMARY KEY (si201_sequencial),
    CONSTRAINT cute212021_reg10_fk FOREIGN KEY (si201_reg10) REFERENCES cute102021(si199_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX cute212021_si201_reg10_index ON cute212021 USING btree (si201_reg10);


-- dispensa112021 definition

-- Drop table

-- DROP TABLE dispensa112021;

CREATE TABLE dispensa112021 (
    si75_sequencial int8 NOT NULL DEFAULT 0,
    si75_tiporegistro int8 NOT NULL DEFAULT 0,
    si75_codorgaoresp varchar(2) NOT NULL DEFAULT 0,
    si75_codunidadesubresp varchar(8) NOT NULL,
    si75_exercicioprocesso int8 NOT NULL DEFAULT 0,
    si75_nroprocesso varchar(12) NOT NULL,
    si75_tipoprocesso int8 NOT NULL DEFAULT 0,
    si75_nrolote int8 NOT NULL DEFAULT 0,
    si75_dsclote varchar(250) NOT NULL,
    si75_mes int8 NULL,
    si75_reg10 int8 NOT NULL DEFAULT 0,
    si75_instit int8 NULL,
    CONSTRAINT dispensa112021_sequ_pk PRIMARY KEY (si75_sequencial),
    CONSTRAINT dispensa112021_reg10_fk FOREIGN KEY (si75_reg10) REFERENCES dispensa102021(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa112021_si75_reg10_index ON dispensa112021 USING btree (si75_reg10);


-- dispensa122021 definition

-- Drop table

-- DROP TABLE dispensa122021;

CREATE TABLE dispensa122021 (
    si76_sequencial int8 NOT NULL DEFAULT 0,
    si76_tiporegistro int8 NOT NULL DEFAULT 0,
    si76_codorgaoresp varchar(2) NOT NULL,
    si76_codunidadesubresp varchar(8) NOT NULL,
    si76_exercicioprocesso int8 NOT NULL DEFAULT 0,
    si76_nroprocesso varchar(12) NOT NULL,
    si76_tipoprocesso int8 NOT NULL,
    si76_coditem int8 NOT NULL DEFAULT 0,
    si76_nroitem int8 NOT NULL DEFAULT 0,
    si76_mes int8 NOT NULL,
    si76_reg10 int8 NOT NULL DEFAULT 0,
    si76_instit int8 NOT NULL,
    CONSTRAINT dispensa122021_sequ_pk PRIMARY KEY (si76_sequencial),
    CONSTRAINT dispensa122021_reg10_fk FOREIGN KEY (si76_reg10) REFERENCES dispensa102021(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa122021_si76_reg10_index ON dispensa122021 USING btree (si76_reg10);


-- dispensa132021 definition

-- Drop table

-- DROP TABLE dispensa132021;

CREATE TABLE dispensa132021 (
    si77_sequencial int8 NOT NULL DEFAULT 0,
    si77_tiporegistro int8 NOT NULL DEFAULT 0,
    si77_codorgaoresp varchar(2) NOT NULL,
    si77_codunidadesubresp varchar(8) NOT NULL,
    si77_exercicioprocesso int8 NOT NULL,
    si77_nroprocesso varchar(12) NOT NULL,
    si77_tipoprocesso int8 NOT NULL,
    si77_nrolote int8 NOT NULL,
    si77_coditem int8 NOT NULL,
    si77_mes int8 NOT NULL,
    si77_reg10 int8 NOT NULL DEFAULT 0,
    si77_instit int8 NOT NULL,
    CONSTRAINT dispensa132021_sequ_pk PRIMARY KEY (si77_sequencial),
    CONSTRAINT dispensa132021_reg10_fk FOREIGN KEY (si77_reg10) REFERENCES dispensa102021(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa132021_si77_reg10_index ON dispensa132021 USING btree (si77_reg10);


-- dispensa142021 definition

-- Drop table

-- DROP TABLE dispensa142021;

CREATE TABLE dispensa142021 (
    si78_sequencial int8 NOT NULL DEFAULT 0,
    si78_tiporegistro int8 NOT NULL,
    si78_codorgaoresp varchar(2) NOT NULL,
    si78_codunidadesubres varchar(8) NOT NULL,
    si78_exercicioprocesso int8 NOT NULL,
    si78_nroprocesso varchar(12) NOT NULL,
    si78_tipoprocesso int8 NOT NULL,
    si78_tiporesp int8 NOT NULL,
    si78_nrocpfresp varchar(11) NOT NULL,
    si78_mes int8 NULL,
    si78_reg10 int8 NOT NULL DEFAULT 0,
    si78_instit int8 NULL,
    CONSTRAINT dispensa142021_sequ_pk PRIMARY KEY (si78_sequencial),
    CONSTRAINT dispensa142021_reg10_fk FOREIGN KEY (si78_reg10) REFERENCES dispensa102021(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa142021_si78_reg10_index ON dispensa142021 USING btree (si78_reg10);


-- dispensa152021 definition

-- Drop table

-- DROP TABLE dispensa152021;

CREATE TABLE dispensa152021 (
    si79_sequencial int8 NOT NULL DEFAULT 0,
    si79_tiporegistro int8 NOT NULL DEFAULT 0,
    si79_codorgaoresp varchar(2) NOT NULL,
    si79_codunidadesubresp varchar(8) NOT NULL,
    si79_exercicioprocesso int8 NOT NULL,
    si79_nroprocesso varchar(12) NOT NULL,
    si79_tipoprocesso int8 NOT NULL,
    si79_nrolote int8 NULL,
    si79_coditem int8 NOT NULL,
    si79_vlcotprecosunitario float8 NOT NULL,
    si79_quantidade float8 NOT NULL,
    si79_mes int8 NULL,
    si79_reg10 int8 NOT NULL DEFAULT 0,
    si79_instit int8 NULL,
    CONSTRAINT dispensa152021_sequ_pk PRIMARY KEY (si79_sequencial),
    CONSTRAINT dispensa152021_reg10_fk FOREIGN KEY (si79_reg10) REFERENCES dispensa102021(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa152021_si79_reg10_index ON dispensa152021 USING btree (si79_reg10);


-- dispensa162021 definition

-- Drop table

-- DROP TABLE dispensa162021;

CREATE TABLE dispensa162021 (
    si80_sequencial int8 NOT NULL DEFAULT 0,
    si80_tiporegistro int8 NOT NULL,
    si80_codorgaoresp varchar(2) NOT NULL,
    si80_codunidadesubresp varchar(8) NOT NULL,
    si80_exercicioprocesso int8 NOT NULL,
    si80_nroprocesso varchar(12) NOT NULL,
    si80_tipoprocesso int8 NOT NULL,
    si80_codorgao varchar(2) NOT NULL,
    si80_codunidadesub varchar(8) NOT NULL,
    si80_codfuncao varchar(2) NOT NULL,
    si80_codsubfuncao varchar(3) NOT NULL,
    si80_codprograma varchar(4) NOT NULL,
    si80_idacao varchar(4) NOT NULL,
    si80_idsubacao varchar(4) NULL,
    si80_naturezadespesa int8 NOT NULL,
    si80_codfontrecursos int8 NOT NULL,
    si80_vlrecurso float8 NOT NULL,
    si80_mes int8 NULL,
    si80_reg10 int8 NOT NULL DEFAULT 0,
    si80_instit int8 NULL,
    CONSTRAINT dispensa162021_sequ_pk PRIMARY KEY (si80_sequencial),
    CONSTRAINT dispensa162021_reg10_fk FOREIGN KEY (si80_reg10) REFERENCES dispensa102021(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa162021_si80_reg10_index ON dispensa162021 USING btree (si80_reg10);


-- dispensa172021 definition

-- Drop table

-- DROP TABLE dispensa172021;

CREATE TABLE dispensa172021 (
    si81_sequencial int8 NOT NULL DEFAULT 0,
    si81_tiporegistro int8 NOT NULL DEFAULT 0,
    si81_codorgaoresp varchar(2) NOT NULL,
    si81_codunidadesubresp varchar(8) NOT NULL,
    si81_exercicioprocesso int8 NOT NULL DEFAULT 0,
    si81_nroprocesso varchar(12) NOT NULL,
    si81_tipoprocesso int8 NOT NULL DEFAULT 0,
    si81_tipodocumento int8 NOT NULL DEFAULT 0,
    si81_nrodocumento varchar(14) NOT NULL,
    si81_nroinscricaoestadual varchar(30) NULL,
    si81_ufinscricaoestadual varchar(2) NULL,
    si81_nrocertidaoregularidadeinss varchar(30) NULL,
    si81_dtemissaocertidaoregularidadeinss date NULL,
    si81_dtvalidadecertidaoregularidadeinss date NULL,
    si81_nrocertidaoregularidadefgts varchar(30) NULL,
    si81_dtemissaocertidaoregularidadefgts date NULL,
    si81_dtvalidadecertidaoregularidadefgts date NULL,
    si81_nrocndt varchar(30) NULL,
    si81_dtemissaocndt date NULL,
    si81_dtvalidadecndt date NULL,
    si81_nrolote int8 NULL DEFAULT 0,
    si81_coditem int8 NOT NULL DEFAULT 0,
    si81_quantidade float8 NOT NULL DEFAULT 0,
    si81_vlitem float8 NOT NULL DEFAULT 0,
    si81_mes int8 NOT NULL DEFAULT 0,
    si81_reg10 int8 NOT NULL DEFAULT 0,
    si81_instit int8 NULL DEFAULT 0,
    CONSTRAINT dispensa172021_sequ_pk PRIMARY KEY (si81_sequencial),
    CONSTRAINT dispensa172021_reg10_fk FOREIGN KEY (si81_reg10) REFERENCES dispensa102021(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa172021_si81_reg10_index ON dispensa172021 USING btree (si81_reg10);


-- emp112021 definition

-- Drop table

-- DROP TABLE emp112021;

CREATE TABLE emp112021 (
    si107_sequencial int8 NOT NULL DEFAULT 0,
    si107_tiporegistro int8 NOT NULL DEFAULT 0,
    si107_codunidadesub varchar(8) NOT NULL,
    si107_nroempenho int8 NOT NULL DEFAULT 0,
    si107_codfontrecursos int8 NOT NULL DEFAULT 0,
    si107_valorfonte float8 NOT NULL DEFAULT 0,
    si107_mes int8 NOT NULL DEFAULT 0,
    si107_reg10 int8 NOT NULL DEFAULT 0,
    si107_instit int8 NULL DEFAULT 0,
    CONSTRAINT emp112021_sequ_pk PRIMARY KEY (si107_sequencial),
    CONSTRAINT emp112021_reg10_fk FOREIGN KEY (si107_reg10) REFERENCES emp102021(si106_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX emp112021_si107_reg10_index ON emp112021 USING btree (si107_reg10);


-- emp122021 definition

-- Drop table

-- DROP TABLE emp122021;

CREATE TABLE emp122021 (
    si108_sequencial int8 NOT NULL DEFAULT 0,
    si108_tiporegistro int8 NOT NULL DEFAULT 0,
    si108_codunidadesub varchar(8) NOT NULL,
    si108_nroempenho int8 NOT NULL DEFAULT 0,
    si108_tipodocumento int8 NOT NULL DEFAULT 0,
    si108_nrodocumento varchar(14) NOT NULL,
    si108_mes int8 NOT NULL DEFAULT 0,
    si108_reg10 int8 NOT NULL DEFAULT 0,
    si108_instit int8 NULL DEFAULT 0,
    CONSTRAINT emp122021_sequ_pk PRIMARY KEY (si108_sequencial),
    CONSTRAINT emp122021_reg10_fk FOREIGN KEY (si108_reg10) REFERENCES emp102021(si106_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX emp122021_si108_reg10_index ON emp122021 USING btree (si108_reg10);


-- ext312021 definition

-- Drop table

-- DROP TABLE ext312021;

CREATE TABLE ext312021 (
    si127_sequencial int8 NOT NULL DEFAULT 0,
    si127_tiporegistro int8 NOT NULL DEFAULT 0,
    si127_codreduzidoop int8 NOT NULL DEFAULT 0,
    si127_tipodocumentoop varchar(2) NOT NULL,
    si127_nrodocumento varchar(15) NULL,
    si127_codctb int8 NULL DEFAULT 0,
    si127_codfontectb int8 NULL DEFAULT 0,
    si127_desctipodocumentoop varchar(50) NULL,
    si127_dtemissao date NOT NULL,
    si127_vldocumento float8 NOT NULL DEFAULT 0,
    si127_mes int8 NOT NULL DEFAULT 0,
    si127_reg30 int8 NOT NULL DEFAULT 0,
    si127_instit int8 NOT NULL DEFAULT 0,
    CONSTRAINT ext312021_sequ_pk PRIMARY KEY (si127_sequencial),
    CONSTRAINT ext312021_reg22_fk FOREIGN KEY (si127_reg30) REFERENCES ext302021(si126_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ext312021_si127_reg20_index ON ext312021 USING btree (si127_reg30);


-- ext322021 definition

-- Drop table

-- DROP TABLE ext322021;

CREATE TABLE ext322021 (
    si128_sequencial int8 NOT NULL DEFAULT 0,
    si128_tiporegistro int8 NOT NULL DEFAULT 0,
    si128_codreduzidoop int8 NOT NULL DEFAULT 0,
    si128_tiporetencao varchar(4) NOT NULL,
    si128_descricaoretencao varchar(50) NULL,
    si128_vlretencao float8 NOT NULL DEFAULT 0,
    si128_mes int8 NOT NULL DEFAULT 0,
    si128_reg30 int8 NULL DEFAULT 0,
    si128_instit int8 NULL DEFAULT 0,
    CONSTRAINT ext322021_sequ_pk PRIMARY KEY (si128_sequencial),
    CONSTRAINT ext322021_reg23_fk FOREIGN KEY (si128_reg30) REFERENCES ext322021(si128_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ext322021_si128_reg20_index ON ext322021 USING btree (si128_reg30);


-- lao112021 definition

-- Drop table

-- DROP TABLE lao112021;

CREATE TABLE lao112021 (
    si35_sequencial int8 NOT NULL DEFAULT 0,
    si35_tiporegistro int8 NOT NULL DEFAULT 0,
    si35_nroleialteracao int8 NOT NULL,
    si35_tipoleialteracao int8 NOT NULL DEFAULT 0,
    si35_artigoleialteracao varchar(6) NOT NULL,
    si35_descricaoartigo varchar(512) NOT NULL,
    si35_vlautorizadoalteracao float8 NOT NULL DEFAULT 0,
    si35_mes int8 NOT NULL DEFAULT 0,
    si35_reg10 int8 NOT NULL DEFAULT 0,
    si35_instit int8 NULL DEFAULT 0,
    CONSTRAINT lao112021_sequ_pk PRIMARY KEY (si35_sequencial),
    CONSTRAINT lao112021_reg10_fk FOREIGN KEY (si35_reg10) REFERENCES lao102021(si34_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lao112021_si35_reg10_index ON lao112021 USING btree (si35_reg10);


-- lao212021 definition

-- Drop table

-- DROP TABLE lao212021;

CREATE TABLE lao212021 (
    si37_sequencial int8 NOT NULL DEFAULT 0,
    si37_tiporegistro int8 NOT NULL DEFAULT 0,
    si37_nroleialterorcam int8 NOT NULL,
    si37_tipoautorizacao int8 NOT NULL DEFAULT 0,
    si37_artigoleialterorcamento varchar(6) NOT NULL,
    si37_descricaoartigo varchar(512) NOT NULL,
    si37_novopercentual float8 NOT NULL DEFAULT 0,
    si37_mes int8 NOT NULL DEFAULT 0,
    si37_reg20 int8 NOT NULL DEFAULT 0,
    si37_instit int8 NULL DEFAULT 0,
    CONSTRAINT lao212021_sequ_pk PRIMARY KEY (si37_sequencial),
    CONSTRAINT lao212021_reg20_fk FOREIGN KEY (si37_reg20) REFERENCES lao202021(si36_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lao212021_si37_reg20_index ON lao212021 USING btree (si37_reg20);


-- lqd112021 definition

-- Drop table

-- DROP TABLE lqd112021;

CREATE TABLE lqd112021 (
    si119_sequencial int8 NOT NULL DEFAULT 0,
    si119_tiporegistro int8 NOT NULL DEFAULT 0,
    si119_codreduzido int8 NOT NULL DEFAULT 0,
    si119_codfontrecursos int8 NOT NULL DEFAULT 0,
    si119_valorfonte float8 NOT NULL DEFAULT 0,
    si119_mes int8 NOT NULL DEFAULT 0,
    si119_reg10 int8 NOT NULL DEFAULT 0,
    si119_instit int8 NULL DEFAULT 0,
    CONSTRAINT lqd112021_sequ_pk PRIMARY KEY (si119_sequencial),
    CONSTRAINT lqd112021_reg10_fk FOREIGN KEY (si119_reg10) REFERENCES lqd102021(si118_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lqd112021_si119_reg10_index ON lqd112021 USING btree (si119_reg10);


-- lqd122021 definition

-- Drop table

-- DROP TABLE lqd122021;

CREATE TABLE lqd122021 (
    si120_sequencial int8 NOT NULL DEFAULT 0,
    si120_tiporegistro int8 NOT NULL DEFAULT 0,
    si120_codreduzido int8 NOT NULL DEFAULT 0,
    si120_mescompetencia varchar(2) NOT NULL,
    si120_exerciciocompetencia int8 NOT NULL DEFAULT 0,
    si120_vldspexerant float8 NOT NULL DEFAULT 0,
    si120_mes int8 NOT NULL DEFAULT 0,
    si120_reg10 int8 NOT NULL DEFAULT 0,
    si120_instit int8 NULL DEFAULT 0,
    CONSTRAINT lqd122021_sequ_pk PRIMARY KEY (si120_sequencial),
    CONSTRAINT lqd122021_reg10_fk FOREIGN KEY (si120_reg10) REFERENCES lqd102021(si118_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lqd122021_si120_reg10_index ON lqd122021 USING btree (si120_reg10);


-- ntf112021 definition

-- Drop table

-- DROP TABLE ntf112021;

CREATE TABLE ntf112021 (
    si144_sequencial int8 NOT NULL DEFAULT 0,
    si144_tiporegistro int8 NOT NULL DEFAULT 0,
    si144_codnotafiscal int8 NOT NULL DEFAULT 0,
    si144_coditem int8 NOT NULL DEFAULT 0,
    si144_quantidadeitem float8 NOT NULL DEFAULT 0,
    si144_valorunitarioitem float8 NOT NULL DEFAULT 0,
    si144_mes int8 NOT NULL DEFAULT 0,
    si144_reg10 int8 NOT NULL DEFAULT 0,
    si144_instit int8 NULL DEFAULT 0,
    CONSTRAINT ntf112021_sequ_pk PRIMARY KEY (si144_sequencial),
    CONSTRAINT ntf112021_reg10_fk FOREIGN KEY (si144_reg10) REFERENCES ntf102021(si143_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ntf112021_si144_reg10_index ON ntf112021 USING btree (si144_reg10);


-- obelac112021 definition

-- Drop table

-- DROP TABLE obelac112021;

CREATE TABLE obelac112021 (
    si140_sequencial int8 NOT NULL DEFAULT 0,
    si140_tiporegistro int8 NOT NULL DEFAULT 0,
    si140_codreduzido int8 NOT NULL DEFAULT 0,
    si140_codfontrecursos int8 NOT NULL DEFAULT 0,
    si140_valorfonte float8 NOT NULL DEFAULT 0,
    si140_mes int8 NOT NULL DEFAULT 0,
    si140_reg10 int8 NOT NULL DEFAULT 0,
    si140_instit int8 NULL DEFAULT 0,
    CONSTRAINT obelac112021_sequ_pk PRIMARY KEY (si140_sequencial),
    CONSTRAINT obelac112021_reg10_fk FOREIGN KEY (si140_reg10) REFERENCES lqd122021(si120_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX obelac112021_si140_reg10_index ON obelac112021 USING btree (si140_reg10);


-- ops112021 definition

-- Drop table

-- DROP TABLE ops112021;

CREATE TABLE ops112021 (
    si133_sequencial int8 NOT NULL DEFAULT 0,
    si133_tiporegistro int8 NOT NULL DEFAULT 0,
    si133_codreduzidoop int8 NOT NULL DEFAULT 0,
    si133_codunidadesub varchar(8) NOT NULL,
    si133_nroop int8 NOT NULL DEFAULT 0,
    si133_dtpagamento date NOT NULL,
    si133_tipopagamento int8 NOT NULL DEFAULT 0,
    si133_nroempenho int8 NOT NULL DEFAULT 0,
    si133_dtempenho date NOT NULL,
    si133_nroliquidacao int8 NULL DEFAULT 0,
    si133_dtliquidacao date NULL,
    si133_codfontrecursos int8 NOT NULL DEFAULT 0,
    si133_valorfonte float8 NOT NULL DEFAULT 0,
    si133_tipodocumentocredor int8 NULL DEFAULT 0,
    si133_nrodocumento varchar(14) NULL,
    si133_codorgaoempop varchar(2) NULL,
    si133_codunidadeempop varchar(8) NULL,
    si133_mes int8 NOT NULL DEFAULT 0,
    si133_reg10 int8 NOT NULL DEFAULT 0,
    si133_instit int8 NULL DEFAULT 0,
    CONSTRAINT ops112021_sequ_pk PRIMARY KEY (si133_sequencial),
    CONSTRAINT ops112021_reg10_fk FOREIGN KEY (si133_reg10) REFERENCES ops102021(si132_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ops112021_si133_reg10_index ON ops112021 USING btree (si133_reg10);


-- ops122021 definition

-- Drop table

-- DROP TABLE ops122021;

CREATE TABLE ops122021 (
    si134_sequencial int8 NOT NULL DEFAULT 0,
    si134_tiporegistro int8 NOT NULL DEFAULT 0,
    si134_codreduzidoop int8 NOT NULL DEFAULT 0,
    si134_tipodocumentoop varchar(2) NOT NULL,
    si134_nrodocumento varchar(15) NULL,
    si134_codctb int8 NULL DEFAULT 0,
    si134_codfontectb int8 NULL DEFAULT 0,
    si134_desctipodocumentoop varchar(50) NULL,
    si134_dtemissao date NOT NULL,
    si134_vldocumento float8 NOT NULL DEFAULT 0,
    si134_mes int8 NOT NULL DEFAULT 0,
    si134_reg10 int8 NOT NULL DEFAULT 0,
    si134_instit int4 NULL DEFAULT 0,
    CONSTRAINT ops122021_sequ_pk PRIMARY KEY (si134_sequencial),
    CONSTRAINT ops122021_reg10_fk FOREIGN KEY (si134_reg10) REFERENCES ops102021(si132_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ops122021_si134_reg10_index ON ops122021 USING btree (si134_reg10);


-- ops132021 definition

-- Drop table

-- DROP TABLE ops132021;

CREATE TABLE ops132021 (
    si135_sequencial int8 NOT NULL DEFAULT 0,
    si135_tiporegistro int8 NOT NULL DEFAULT 0,
    si135_codreduzidoop int8 NOT NULL DEFAULT 0,
    si135_tiporetencao varchar(4) NOT NULL,
    si135_descricaoretencao varchar(50) NULL,
    si135_vlretencao float8 NOT NULL DEFAULT 0,
    si135_vlantecipado float8 NOT NULL DEFAULT 0,
    si135_mes int8 NOT NULL DEFAULT 0,
    si135_reg10 int8 NOT NULL DEFAULT 0,
    si135_instit int8 NULL DEFAULT 0,
    CONSTRAINT ops132021_sequ_pk PRIMARY KEY (si135_sequencial),
    CONSTRAINT ops132021_reg10_fk FOREIGN KEY (si135_reg10) REFERENCES ops102021(si132_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ops132021_si135_reg10_index ON ops132021 USING btree (si135_reg10);


-- orgao112021 definition

-- Drop table

-- DROP TABLE orgao112021;

CREATE TABLE orgao112021 (
    si15_sequencial int8 NOT NULL DEFAULT 0,
    si15_tiporegistro int8 NOT NULL DEFAULT 0,
    si15_tiporesponsavel varchar(2) NOT NULL,
    si15_cartident varchar(10) NOT NULL,
    si15_orgemissorci varchar(10) NOT NULL,
    si15_cpf varchar(11) NOT NULL,
    si15_crccontador varchar(11) NULL,
    si15_ufcrccontador varchar(2) NULL,
    si15_cargoorddespdeleg varchar(50) NULL,
    si15_dtinicio date NOT NULL,
    si15_dtfinal date NOT NULL,
    si15_email varchar(50) NOT NULL,
    si15_reg10 int8 NOT NULL DEFAULT 0,
    si15_mes int8 NOT NULL DEFAULT 0,
    si15_instit int8 NULL DEFAULT 0,
    CONSTRAINT orgao112021_sequ_pk PRIMARY KEY (si15_sequencial),
    CONSTRAINT orgao112021_reg10_fk FOREIGN KEY (si15_reg10) REFERENCES orgao102021(si14_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX orgao112021_si15_reg10_index ON orgao112021 USING btree (si15_reg10);


-- parec112021 definition

-- Drop table

-- DROP TABLE parec112021;

CREATE TABLE parec112021 (
    si23_sequencial int8 NOT NULL DEFAULT 0,
    si23_tiporegistro int8 NOT NULL DEFAULT 0,
    si23_codreduzido int8 NOT NULL DEFAULT 0,
    si23_codfontrecursos int8 NOT NULL DEFAULT 0,
    si23_vlfonte float8 NOT NULL DEFAULT 0,
    si23_reg10 int8 NOT NULL DEFAULT 0,
    si23_mes int8 NOT NULL DEFAULT 0,
    si23_instit int8 NULL DEFAULT 0,
    CONSTRAINT parec112021_sequ_pk PRIMARY KEY (si23_sequencial),
    CONSTRAINT parec112021_reg10_fk FOREIGN KEY (si23_reg10) REFERENCES parec102021(si22_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX parec112021_si23_reg10_index ON parec112021 USING btree (si23_reg10);


-- rec112021 definition

-- Drop table

-- DROP TABLE rec112021;

CREATE TABLE rec112021 (
    si26_sequencial int8 NOT NULL DEFAULT 0,
    si26_tiporegistro int8 NOT NULL DEFAULT 0,
    si26_codreceita int8 NOT NULL DEFAULT 0,
    si26_codfontrecursos int8 NOT NULL DEFAULT 0,
    si26_tipodocumento int8 NULL,
    si26_nrodocumento varchar(14) NULL,
    si26_nroconvenio varchar(30) NULL,
    si26_dataassinatura date NULL,
    si26_vlarrecadadofonte float8 NOT NULL DEFAULT 0,
    si26_reg10 int8 NOT NULL DEFAULT 0,
    si26_mes int8 NOT NULL DEFAULT 0,
    si26_instit int8 NULL DEFAULT 0,
    CONSTRAINT rec112021_sequ_pk PRIMARY KEY (si26_sequencial),
    CONSTRAINT rec112021_reg10_fk FOREIGN KEY (si26_reg10) REFERENCES rec102021(si25_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rec112021_si26_reg10_index ON rec112021 USING btree (si26_reg10);


-- regadesao112021 definition

-- Drop table

-- DROP TABLE regadesao112021;

CREATE TABLE regadesao112021 (
    si68_sequencial int8 NOT NULL DEFAULT 0,
    si68_tiporegistro int8 NOT NULL DEFAULT 0,
    si68_codorgao varchar(2) NOT NULL,
    si68_codunidadesub varchar(8) NOT NULL,
    si68_nroprocadesao varchar(12) NOT NULL,
    si68_exercicioadesao int8 NOT NULL DEFAULT 0,
    si68_nrolote int8 NOT NULL DEFAULT 0,
    si68_dsclote varchar(250) NOT NULL,
    si68_mes int8 NOT NULL DEFAULT 0,
    si68_reg10 int8 NOT NULL DEFAULT 0,
    si68_instit int8 NULL DEFAULT 0,
    CONSTRAINT regadesao112021_sequ_pk PRIMARY KEY (si68_sequencial),
    CONSTRAINT regadesao112021_reg10_fk FOREIGN KEY (si68_reg10) REFERENCES regadesao102021(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao112021_si68_reg10_index ON regadesao112021 USING btree (si68_reg10);


-- regadesao122021 definition

-- Drop table

-- DROP TABLE regadesao122021;

CREATE TABLE regadesao122021 (
    si69_sequencial int8 NOT NULL DEFAULT 0,
    si69_tiporegistro int8 NOT NULL DEFAULT 0,
    si69_codorgao varchar(2) NOT NULL,
    si69_codunidadesub varchar(8) NOT NULL,
    si69_nroprocadesao varchar(12) NOT NULL,
    si69_exercicioadesao int8 NOT NULL DEFAULT 0,
    si69_coditem int8 NOT NULL DEFAULT 0,
    si69_nroitem int8 NOT NULL DEFAULT 0,
    si69_mes int8 NOT NULL DEFAULT 0,
    si69_reg10 int8 NOT NULL DEFAULT 0,
    si69_instit int8 NULL DEFAULT 0,
    CONSTRAINT regadesao122021_sequ_pk PRIMARY KEY (si69_sequencial),
    CONSTRAINT regadesao122021_reg10_fk FOREIGN KEY (si69_reg10) REFERENCES regadesao102021(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao122021_si69_reg10_index ON regadesao122021 USING btree (si69_reg10);


-- regadesao132021 definition

-- Drop table

-- DROP TABLE regadesao132021;

CREATE TABLE regadesao132021 (
    si70_sequencial int8 NOT NULL DEFAULT 0,
    si70_tiporegistro int8 NOT NULL DEFAULT 0,
    si70_codorgao varchar(2) NOT NULL,
    si70_codunidadesub varchar(8) NOT NULL,
    si70_nroprocadesao varchar(12) NOT NULL,
    si70_exercicioadesao int8 NOT NULL DEFAULT 0,
    si70_nrolote int8 NOT NULL DEFAULT 0,
    si70_coditem int8 NOT NULL DEFAULT 0,
    si70_mes int8 NOT NULL DEFAULT 0,
    si70_reg10 int8 NOT NULL DEFAULT 0,
    si70_instit int8 NULL DEFAULT 0,
    CONSTRAINT regadesao132021_sequ_pk PRIMARY KEY (si70_sequencial),
    CONSTRAINT regadesao132021_reg10_fk FOREIGN KEY (si70_reg10) REFERENCES regadesao102021(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao132021_si70_reg10_index ON regadesao132021 USING btree (si70_reg10);


-- regadesao142021 definition

-- Drop table

-- DROP TABLE regadesao142021;

CREATE TABLE regadesao142021 (
    si71_sequencial int8 NOT NULL DEFAULT 0,
    si71_tiporegistro int8 NOT NULL DEFAULT 0,
    si71_codorgao varchar(2) NOT NULL,
    si71_codunidadesub varchar(8) NOT NULL,
    si71_nroprocadesao varchar(12) NOT NULL,
    si71_exercicioadesao int8 NOT NULL DEFAULT 0,
    si71_nrolote int8 NULL DEFAULT 0,
    si71_coditem int8 NOT NULL DEFAULT 0,
    si71_dtcotacao date NOT NULL,
    si71_vlcotprecosunitario float8 NOT NULL DEFAULT 0,
    si71_quantidade float8 NOT NULL DEFAULT 0,
    si71_mes int8 NOT NULL DEFAULT 0,
    si71_reg10 int8 NOT NULL DEFAULT 0,
    si71_instit int8 NULL DEFAULT 0,
    CONSTRAINT regadesao142021_sequ_pk PRIMARY KEY (si71_sequencial),
    CONSTRAINT regadesao142021_reg10_fk FOREIGN KEY (si71_reg10) REFERENCES regadesao102021(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao142021_si71_reg10_index ON regadesao142021 USING btree (si71_reg10);


-- regadesao152021 definition

-- Drop table

-- DROP TABLE regadesao152021;

CREATE TABLE regadesao152021 (
    si72_sequencial int8 NOT NULL DEFAULT 0,
    si72_tiporegistro int8 NOT NULL DEFAULT 0,
    si72_codorgao varchar(2) NOT NULL,
    si72_codunidadesub varchar(8) NOT NULL,
    si72_nroprocadesao varchar(12) NOT NULL,
    si72_exercicioadesao int8 NOT NULL DEFAULT 0,
    si72_nrolote int8 NULL DEFAULT 0,
    si72_coditem int8 NOT NULL DEFAULT 0,
    si72_precounitario float8 NOT NULL DEFAULT 0,
    si72_quantidadelicitada float8 NOT NULL DEFAULT 0,
    si72_quantidadeaderida float8 NOT NULL DEFAULT 0,
    si72_tipodocumento int8 NOT NULL DEFAULT 0,
    si72_nrodocumento varchar(14) NOT NULL,
    si72_mes int8 NOT NULL DEFAULT 0,
    si72_reg10 int8 NOT NULL DEFAULT 0,
    si72_instit int8 NULL DEFAULT 0,
    CONSTRAINT regadesao152021_sequ_pk PRIMARY KEY (si72_sequencial),
    CONSTRAINT regadesao152021_reg10_fk FOREIGN KEY (si72_reg10) REFERENCES regadesao102021(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao152021_si72_reg10_index ON regadesao152021 USING btree (si72_reg10);


-- rsp112021 definition

-- Drop table

-- DROP TABLE rsp112021;

CREATE TABLE rsp112021 (
    si113_sequencial int8 NOT NULL DEFAULT 0,
    si113_tiporegistro int8 NOT NULL DEFAULT 0,
    si113_codreduzidorsp int8 NOT NULL DEFAULT 0,
    si113_codfontrecursos int8 NOT NULL DEFAULT 0,
    si113_vloriginalfonte float8 NOT NULL DEFAULT 0,
    si113_vlsaldoantprocefonte float8 NOT NULL DEFAULT 0,
    si113_vlsaldoantnaoprocfonte float8 NOT NULL DEFAULT 0,
    si113_mes int8 NOT NULL DEFAULT 0,
    si113_reg10 int8 NOT NULL DEFAULT 0,
    si113_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp112021_sequ_pk PRIMARY KEY (si113_sequencial),
    CONSTRAINT rsp112021_reg10_fk FOREIGN KEY (si113_reg10) REFERENCES rsp102021(si112_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp112021_si113_reg10_index ON rsp112021 USING btree (si113_reg10);


-- rsp122021 definition

-- Drop table

-- DROP TABLE rsp122021;

CREATE TABLE rsp122021 (
    si114_sequencial int8 NOT NULL DEFAULT 0,
    si114_tiporegistro int8 NOT NULL DEFAULT 0,
    si114_codreduzidorsp int8 NOT NULL DEFAULT 0,
    si114_tipodocumento int8 NOT NULL DEFAULT 0,
    si114_nrodocumento varchar(14) NOT NULL,
    si114_mes int8 NOT NULL DEFAULT 0,
    si114_reg10 int8 NOT NULL DEFAULT 0,
    si114_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp122021_sequ_pk PRIMARY KEY (si114_sequencial),
    CONSTRAINT rsp122021_reg10_fk FOREIGN KEY (si114_reg10) REFERENCES rsp102021(si112_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp122021_si114_reg10_index ON rsp122021 USING btree (si114_reg10);


-- rsp212021 definition

-- Drop table

-- DROP TABLE rsp212021;

CREATE TABLE rsp212021 (
    si116_sequencial int8 NOT NULL DEFAULT 0,
    si116_tiporegistro int8 NOT NULL DEFAULT 0,
    si116_codreduzidomov int8 NOT NULL DEFAULT 0,
    si116_codfontrecursos int8 NOT NULL DEFAULT 0,
    si116_vlmovimentacaofonte float8 NOT NULL DEFAULT 0,
    si116_mes int8 NOT NULL DEFAULT 0,
    si116_reg20 int8 NOT NULL DEFAULT 0,
    si116_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp212021_sequ_pk PRIMARY KEY (si116_sequencial),
    CONSTRAINT rsp212021_reg20_fk FOREIGN KEY (si116_reg20) REFERENCES rsp202021(si115_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp212021_si116_reg20_index ON rsp212021 USING btree (si116_reg20);


-- rsp222021 definition

-- Drop table

-- DROP TABLE rsp222021;

CREATE TABLE rsp222021 (
    si117_sequencial int8 NOT NULL DEFAULT 0,
    si117_tiporegistro int8 NOT NULL DEFAULT 0,
    si117_codreduzidomov int8 NOT NULL DEFAULT 0,
    si117_tipodocumento int8 NOT NULL DEFAULT 0,
    si117_nrodocumento varchar(14) NOT NULL,
    si117_mes int8 NOT NULL DEFAULT 0,
    si117_reg20 int8 NOT NULL DEFAULT 0,
    si117_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp222021_sequ_pk PRIMARY KEY (si117_sequencial),
    CONSTRAINT rsp222021_reg20_fk FOREIGN KEY (si117_reg20) REFERENCES rsp202021(si115_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp222021_si117_reg20_index ON rsp222021 USING btree (si117_reg20);


-- tce112021 definition

-- Drop table

-- DROP TABLE tce112021;

CREATE TABLE tce112021 (
    si188_sequencial int8 NOT NULL DEFAULT 0,
    si188_tiporegistro int8 NOT NULL DEFAULT 0,
    si188_numprocessotce varchar(12) NOT NULL,
    si188_datainstauracaotce date NOT NULL,
    si188_tipodocumentorespdano int8 NOT NULL DEFAULT 0,
    si188_nrodocumentorespdano varchar(14) NOT NULL,
    si188_mes int8 NOT NULL DEFAULT 0,
    si188_reg10 int8 NOT NULL DEFAULT 0,
    si188_instit int8 NULL DEFAULT 0,
    CONSTRAINT tce112021_sequ_pk PRIMARY KEY (si188_sequencial),
    CONSTRAINT tce112021_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES tce112021(si188_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic102021_si46_sequencial_seq definition

-- DROP SEQUENCE aberlic102021_si46_sequencial_seq;

CREATE SEQUENCE aberlic102021_si46_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic112021_si47_sequencial_seq definition

-- DROP SEQUENCE aberlic112021_si47_sequencial_seq;

CREATE SEQUENCE aberlic112021_si47_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic122021_si48_sequencial_seq definition

-- DROP SEQUENCE aberlic122021_si48_sequencial_seq;

CREATE SEQUENCE aberlic122021_si48_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic132021_si49_sequencial_seq definition

-- DROP SEQUENCE aberlic132021_si49_sequencial_seq;

CREATE SEQUENCE aberlic132021_si49_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic142021_si50_sequencial_seq definition

-- DROP SEQUENCE aberlic142021_si50_sequencial_seq;

CREATE SEQUENCE aberlic142021_si50_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic152021_si51_sequencial_seq definition

-- DROP SEQUENCE aberlic152021_si51_sequencial_seq;

CREATE SEQUENCE aberlic152021_si51_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic162021_si52_sequencial_seq definition

-- DROP SEQUENCE aberlic162021_si52_sequencial_seq;

CREATE SEQUENCE aberlic162021_si52_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aex102021_si130_sequencial_seq definition

-- DROP SEQUENCE aex102021_si130_sequencial_seq;

CREATE SEQUENCE aex102021_si130_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq102021_si121_sequencial_seq definition

-- DROP SEQUENCE alq102021_si121_sequencial_seq;

CREATE SEQUENCE alq102021_si121_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq112021_si122_sequencial_seq definition

-- DROP SEQUENCE alq112021_si122_sequencial_seq;

CREATE SEQUENCE alq112021_si122_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq122021_si123_sequencial_seq definition

-- DROP SEQUENCE alq122021_si123_sequencial_seq;

CREATE SEQUENCE alq122021_si123_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- anl102021_si110_sequencial_seq definition

-- DROP SEQUENCE anl102021_si110_sequencial_seq;

CREATE SEQUENCE anl102021_si110_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- anl112021_si111_sequencial_seq definition

-- DROP SEQUENCE anl112021_si111_sequencial_seq;

CREATE SEQUENCE anl112021_si111_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aob102021_si141_sequencial_seq definition

-- DROP SEQUENCE aob102021_si141_sequencial_seq;

CREATE SEQUENCE aob102021_si141_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aob112021_si142_sequencial_seq definition

-- DROP SEQUENCE aob112021_si142_sequencial_seq;

CREATE SEQUENCE aob112021_si142_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc102021_si38_sequencial_seq definition

-- DROP SEQUENCE aoc102021_si38_sequencial_seq;

CREATE SEQUENCE aoc102021_si38_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc112021_si39_sequencial_seq definition

-- DROP SEQUENCE aoc112021_si39_sequencial_seq;

CREATE SEQUENCE aoc112021_si39_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc122021_si40_sequencial_seq definition

-- DROP SEQUENCE aoc122021_si40_sequencial_seq;

CREATE SEQUENCE aoc122021_si40_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc132021_si41_sequencial_seq definition

-- DROP SEQUENCE aoc132021_si41_sequencial_seq;

CREATE SEQUENCE aoc132021_si41_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc142021_si42_sequencial_seq definition

-- DROP SEQUENCE aoc142021_si42_sequencial_seq;

CREATE SEQUENCE aoc142021_si42_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc152021_si194_sequencial_seq definition

-- DROP SEQUENCE aoc152021_si194_sequencial_seq;

CREATE SEQUENCE aoc152021_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aop102021_si137_sequencial_seq definition

-- DROP SEQUENCE aop102021_si137_sequencial_seq;

CREATE SEQUENCE aop102021_si137_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aop112021_si138_sequencial_seq definition

-- DROP SEQUENCE aop112021_si138_sequencial_seq;

CREATE SEQUENCE aop112021_si138_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc102021_si28_sequencial_seq definition

-- DROP SEQUENCE arc102021_si28_sequencial_seq;

CREATE SEQUENCE arc102021_si28_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc112021_si29_sequencial_seq definition

-- DROP SEQUENCE arc112021_si29_sequencial_seq;

CREATE SEQUENCE arc112021_si29_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- arc202021_si31_sequencial_seq definition

-- DROP SEQUENCE arc202021_si31_sequencial_seq;

CREATE SEQUENCE arc202021_si31_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc212021_si32_sequencial_seq definition

-- DROP SEQUENCE arc212021_si32_sequencial_seq;

CREATE SEQUENCE arc212021_si32_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa102021_si103_sequencial_seq definition

-- DROP SEQUENCE caixa102021_si103_sequencial_seq;

CREATE SEQUENCE caixa102021_si103_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa112021_si166_sequencial_seq definition

-- DROP SEQUENCE caixa112021_si166_sequencial_seq;

CREATE SEQUENCE caixa112021_si166_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa122021_si104_sequencial_seq definition

-- DROP SEQUENCE caixa122021_si104_sequencial_seq;

CREATE SEQUENCE caixa122021_si104_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa132021_si105_sequencial_seq definition

-- DROP SEQUENCE caixa132021_si105_sequencial_seq;

CREATE SEQUENCE caixa132021_si105_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge102021_si182_sequencial_seq definition

-- DROP SEQUENCE conge102021_si182_sequencial_seq;

CREATE SEQUENCE conge102021_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- conge202021_si183_sequencial_seq definition

-- DROP SEQUENCE conge202021_si183_sequencial_seq;

CREATE SEQUENCE conge202021_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge302021_si184_sequencial_seq definition

-- DROP SEQUENCE conge302021_si184_sequencial_seq;

CREATE SEQUENCE conge302021_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge402021_si237_sequencial_seq definition

-- DROP SEQUENCE conge402021_si237_sequencial_seq;

CREATE SEQUENCE conge402021_si237_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge502021_si238_sequencial_seq definition

-- DROP SEQUENCE conge502021_si238_sequencial_seq;

CREATE SEQUENCE conge502021_si238_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consid102021_si158_sequencial_seq definition

-- DROP SEQUENCE consid102021_si158_sequencial_seq;

CREATE SEQUENCE consid102021_si158_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor102021_si16_sequencial_seq definition

-- DROP SEQUENCE consor102021_si16_sequencial_seq;

CREATE SEQUENCE consor102021_si16_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- consor202021_si17_sequencial_seq definition

-- DROP SEQUENCE consor202021_si17_sequencial_seq;

CREATE SEQUENCE consor202021_si17_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor302021_si18_sequencial_seq definition

-- DROP SEQUENCE consor302021_si18_sequencial_seq;

CREATE SEQUENCE consor302021_si18_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor402021_si19_sequencial_seq definition

-- DROP SEQUENCE consor402021_si19_sequencial_seq;

CREATE SEQUENCE consor402021_si19_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor502021_si20_sequencial_seq definition

-- DROP SEQUENCE consor502021_si20_sequencial_seq;

CREATE SEQUENCE consor502021_si20_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos102021_si83_sequencial_seq definition

-- DROP SEQUENCE contratos102021_si83_sequencial_seq;

CREATE SEQUENCE contratos102021_si83_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos112021_si84_sequencial_seq definition

-- DROP SEQUENCE contratos112021_si84_sequencial_seq;

CREATE SEQUENCE contratos112021_si84_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos122021_si85_sequencial_seq definition

-- DROP SEQUENCE contratos122021_si85_sequencial_seq;

CREATE SEQUENCE contratos122021_si85_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos132021_si86_sequencial_seq definition

-- DROP SEQUENCE contratos132021_si86_sequencial_seq;

CREATE SEQUENCE contratos132021_si86_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- contratos202021_si87_sequencial_seq definition

-- DROP SEQUENCE contratos202021_si87_sequencial_seq;

CREATE SEQUENCE contratos202021_si87_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos212021_si88_sequencial_seq definition

-- DROP SEQUENCE contratos212021_si88_sequencial_seq;

CREATE SEQUENCE contratos212021_si88_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos302021_si89_sequencial_seq definition

-- DROP SEQUENCE contratos302021_si89_sequencial_seq;

CREATE SEQUENCE contratos302021_si89_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos402021_si91_sequencial_seq definition

-- DROP SEQUENCE contratos402021_si91_sequencial_seq;

CREATE SEQUENCE contratos402021_si91_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- conv102021_si92_sequencial_seq definition

-- DROP SEQUENCE conv102021_si92_sequencial_seq;

CREATE SEQUENCE conv102021_si92_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv112021_si93_sequencial_seq definition

-- DROP SEQUENCE conv112021_si93_sequencial_seq;

CREATE SEQUENCE conv112021_si93_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv202021_si94_sequencial_seq definition

-- DROP SEQUENCE conv202021_si94_sequencial_seq;

CREATE SEQUENCE conv202021_si94_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv212021_si232_sequencial_seq definition

-- DROP SEQUENCE conv212021_si232_sequencial_seq;

CREATE SEQUENCE conv212021_si232_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv302021_si203_sequencial_seq definition

-- DROP SEQUENCE conv302021_si203_sequencial_seq;

CREATE SEQUENCE conv302021_si203_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv312021_si204_sequencial_seq definition

-- DROP SEQUENCE conv312021_si204_sequencial_seq;

CREATE SEQUENCE conv312021_si204_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cronem102021_si170_sequencial_seq definition

-- DROP SEQUENCE cronem102021_si170_sequencial_seq;

CREATE SEQUENCE cronem102021_si170_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb102021_si95_sequencial_seq definition

-- DROP SEQUENCE ctb102021_si95_sequencial_seq;

CREATE SEQUENCE ctb102021_si95_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- ctb202021_si96_sequencial_seq definition

-- DROP SEQUENCE ctb202021_si96_sequencial_seq;

CREATE SEQUENCE ctb202021_si96_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb212021_si97_sequencial_seq definition

-- DROP SEQUENCE ctb212021_si97_sequencial_seq;

CREATE SEQUENCE ctb212021_si97_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb222021_si98_sequencial_seq definition

-- DROP SEQUENCE ctb222021_si98_sequencial_seq;

CREATE SEQUENCE ctb222021_si98_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb302021_si99_sequencial_seq definition

-- DROP SEQUENCE ctb302021_si99_sequencial_seq;

CREATE SEQUENCE ctb302021_si99_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb312021_si100_sequencial_seq definition

-- DROP SEQUENCE ctb312021_si100_sequencial_seq;

CREATE SEQUENCE ctb312021_si100_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb402021_si101_sequencial_seq definition

-- DROP SEQUENCE ctb402021_si101_sequencial_seq;

CREATE SEQUENCE ctb402021_si101_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb502021_si102_sequencial_seq definition

-- DROP SEQUENCE ctb502021_si102_sequencial_seq;

CREATE SEQUENCE ctb502021_si102_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute102021_si199_sequencial_seq definition

-- DROP SEQUENCE cute102021_si199_sequencial_seq;

CREATE SEQUENCE cute102021_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cute202021_si200_sequencial_seq definition

-- DROP SEQUENCE cute202021_si200_sequencial_seq;

CREATE SEQUENCE cute202021_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute212021_si201_sequencial_seq definition

-- DROP SEQUENCE cute212021_si201_sequencial_seq;

CREATE SEQUENCE cute212021_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute302021_si202_sequencial_seq definition

-- DROP SEQUENCE cute302021_si202_sequencial_seq;

CREATE SEQUENCE cute302021_si202_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc102021_si146_sequencial_seq definition

-- DROP SEQUENCE cvc102021_si146_sequencial_seq;

CREATE SEQUENCE cvc102021_si146_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cvc202021_si147_sequencial_seq definition

-- DROP SEQUENCE cvc202021_si147_sequencial_seq;

CREATE SEQUENCE cvc202021_si147_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc302021_si148_sequencial_seq definition

-- DROP SEQUENCE cvc302021_si148_sequencial_seq;

CREATE SEQUENCE cvc302021_si148_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc402021_si149_sequencial_seq definition

-- DROP SEQUENCE cvc402021_si149_sequencial_seq;

CREATE SEQUENCE cvc402021_si149_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf102021_si157_sequencial_seq definition

-- DROP SEQUENCE dclrf102021_si157_sequencial_seq;

CREATE SEQUENCE dclrf102021_si157_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf112021_si205_sequencial_seq definition

-- DROP SEQUENCE dclrf112021_si205_sequencial_seq;

CREATE SEQUENCE dclrf112021_si205_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- dclrf202021_si191_sequencial_seq definition

-- DROP SEQUENCE dclrf202021_si191_sequencial_seq;

CREATE SEQUENCE dclrf202021_si191_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf302021_si192_sequencial_seq definition

-- DROP SEQUENCE dclrf302021_si192_sequencial_seq;

CREATE SEQUENCE dclrf302021_si192_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf402021_si193_sequencial_seq definition

-- DROP SEQUENCE dclrf402021_si193_sequencial_seq;

CREATE SEQUENCE dclrf402021_si193_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc202021_si153_sequencial_seq definition

-- DROP SEQUENCE ddc202021_si153_sequencial_seq;

CREATE SEQUENCE ddc202021_si153_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc302021_si154_sequencial_seq definition

-- DROP SEQUENCE ddc302021_si154_sequencial_seq;

CREATE SEQUENCE ddc302021_si154_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc402021_si178_sequencial_seq definition

-- DROP SEQUENCE ddc402021_si178_sequencial_seq;

CREATE SEQUENCE ddc402021_si178_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa102021_si74_sequencial_seq definition

-- DROP SEQUENCE dispensa102021_si74_sequencial_seq;

CREATE SEQUENCE dispensa102021_si74_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa112021_si75_sequencial_seq definition

-- DROP SEQUENCE dispensa112021_si75_sequencial_seq;

CREATE SEQUENCE dispensa112021_si75_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa122021_si76_sequencial_seq definition

-- DROP SEQUENCE dispensa122021_si76_sequencial_seq;

CREATE SEQUENCE dispensa122021_si76_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa132021_si77_sequencial_seq definition

-- DROP SEQUENCE dispensa132021_si77_sequencial_seq;

CREATE SEQUENCE dispensa132021_si77_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa142021_si78_sequencial_seq definition

-- DROP SEQUENCE dispensa142021_si78_sequencial_seq;

CREATE SEQUENCE dispensa142021_si78_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa152021_si79_sequencial_seq definition

-- DROP SEQUENCE dispensa152021_si79_sequencial_seq;

CREATE SEQUENCE dispensa152021_si79_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa162021_si80_sequencial_seq definition

-- DROP SEQUENCE dispensa162021_si80_sequencial_seq;

CREATE SEQUENCE dispensa162021_si80_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa172021_si81_sequencial_seq definition

-- DROP SEQUENCE dispensa172021_si81_sequencial_seq;

CREATE SEQUENCE dispensa172021_si81_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa182021_si82_sequencial_seq definition

-- DROP SEQUENCE dispensa182021_si82_sequencial_seq;

CREATE SEQUENCE dispensa182021_si82_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp102021_si106_sequencial_seq definition

-- DROP SEQUENCE emp102021_si106_sequencial_seq;

CREATE SEQUENCE emp102021_si106_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp112021_si107_sequencial_seq definition

-- DROP SEQUENCE emp112021_si107_sequencial_seq;

CREATE SEQUENCE emp112021_si107_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp122021_si108_sequencial_seq definition

-- DROP SEQUENCE emp122021_si108_sequencial_seq;

CREATE SEQUENCE emp122021_si108_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- emp202021_si109_sequencial_seq definition

-- DROP SEQUENCE emp202021_si109_sequencial_seq;

CREATE SEQUENCE emp202021_si109_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp302021_si206_sequencial_seq definition

-- DROP SEQUENCE emp302021_si206_sequencial_seq;

CREATE SEQUENCE emp302021_si206_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext102021_si124_sequencial_seq definition

-- DROP SEQUENCE ext102021_si124_sequencial_seq;

CREATE SEQUENCE ext102021_si124_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext202021_si165_sequencial_seq definition

-- DROP SEQUENCE ext202021_si165_sequencial_seq;

CREATE SEQUENCE ext202021_si165_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext302021_si126_sequencial_seq definition

-- DROP SEQUENCE ext302021_si126_sequencial_seq;

CREATE SEQUENCE ext302021_si126_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext312021_si127_sequencial_seq definition

-- DROP SEQUENCE ext312021_si127_sequencial_seq;

CREATE SEQUENCE ext312021_si127_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext322021_si128_sequencial_seq definition

-- DROP SEQUENCE ext322021_si128_sequencial_seq;

CREATE SEQUENCE ext322021_si128_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- hablic102021_si57_sequencial_seq definition

-- DROP SEQUENCE hablic102021_si57_sequencial_seq;

CREATE SEQUENCE hablic102021_si57_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- hablic112021_si58_sequencial_seq definition

-- DROP SEQUENCE hablic112021_si58_sequencial_seq;

CREATE SEQUENCE hablic112021_si58_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- hablic202021_si59_sequencial_seq definition

-- DROP SEQUENCE hablic202021_si59_sequencial_seq;

CREATE SEQUENCE hablic202021_si59_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic102021_si63_sequencial_seq definition

-- DROP SEQUENCE homolic102021_si63_sequencial_seq;

CREATE SEQUENCE homolic102021_si63_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic202021_si64_sequencial_seq definition

-- DROP SEQUENCE homolic202021_si64_sequencial_seq;

CREATE SEQUENCE homolic202021_si64_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic302021_si65_sequencial_seq definition

-- DROP SEQUENCE homolic302021_si65_sequencial_seq;

CREATE SEQUENCE homolic302021_si65_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic402021_si65_sequencial_seq definition

-- DROP SEQUENCE homolic402021_si65_sequencial_seq;

CREATE SEQUENCE homolic402021_si65_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ide2021_si11_sequencial_seq definition

-- DROP SEQUENCE ide2021_si11_sequencial_seq;

CREATE SEQUENCE ide2021_si11_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- idedcasp2021_si200_sequencial_seq definition

-- DROP SEQUENCE idedcasp2021_si200_sequencial_seq;

CREATE SEQUENCE idedcasp2021_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ideedital2021_si186_sequencial_seq definition

-- DROP SEQUENCE ideedital2021_si186_sequencial_seq;

CREATE SEQUENCE ideedital2021_si186_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp102021_si179_sequencial_seq definition

-- DROP SEQUENCE iderp102021_si179_sequencial_seq;

CREATE SEQUENCE iderp102021_si179_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp112021_si180_sequencial_seq definition

-- DROP SEQUENCE iderp112021_si180_sequencial_seq;

CREATE SEQUENCE iderp112021_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp202021_si181_sequencial_seq definition

-- DROP SEQUENCE iderp202021_si181_sequencial_seq;

CREATE SEQUENCE iderp202021_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- item102021_si43_sequencial_seq definition

-- DROP SEQUENCE item102021_si43_sequencial_seq;

CREATE SEQUENCE item102021_si43_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic102021_si60_sequencial_seq definition

-- DROP SEQUENCE julglic102021_si60_sequencial_seq;

CREATE SEQUENCE julglic102021_si60_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic202021_si61_sequencial_seq definition

-- DROP SEQUENCE julglic202021_si61_sequencial_seq;

CREATE SEQUENCE julglic202021_si61_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic302021_si62_sequencial_seq definition

-- DROP SEQUENCE julglic302021_si62_sequencial_seq;

CREATE SEQUENCE julglic302021_si62_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic402021_si62_sequencial_seq definition

-- DROP SEQUENCE julglic402021_si62_sequencial_seq;

CREATE SEQUENCE julglic402021_si62_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao102021_si34_sequencial_seq definition

-- DROP SEQUENCE lao102021_si34_sequencial_seq;

CREATE SEQUENCE lao102021_si34_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao112021_si35_sequencial_seq definition

-- DROP SEQUENCE lao112021_si35_sequencial_seq;

CREATE SEQUENCE lao112021_si35_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao202021_si36_sequencial_seq definition

-- DROP SEQUENCE lao202021_si36_sequencial_seq;

CREATE SEQUENCE lao202021_si36_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao212021_si37_sequencial_seq definition

-- DROP SEQUENCE lao212021_si37_sequencial_seq;

CREATE SEQUENCE lao212021_si37_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd102021_si118_sequencial_seq definition

-- DROP SEQUENCE lqd102021_si118_sequencial_seq;

CREATE SEQUENCE lqd102021_si118_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd112021_si119_sequencial_seq definition

-- DROP SEQUENCE lqd112021_si119_sequencial_seq;

CREATE SEQUENCE lqd112021_si119_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd122021_si120_sequencial_seq definition

-- DROP SEQUENCE lqd122021_si120_sequencial_seq;

CREATE SEQUENCE lqd122021_si120_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf102021_si143_sequencial_seq definition

-- DROP SEQUENCE ntf102021_si143_sequencial_seq;

CREATE SEQUENCE ntf102021_si143_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf112021_si144_sequencial_seq definition

-- DROP SEQUENCE ntf112021_si144_sequencial_seq;

CREATE SEQUENCE ntf112021_si144_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf202021_si145_sequencial_seq definition

-- DROP SEQUENCE ntf202021_si145_sequencial_seq;

CREATE SEQUENCE ntf202021_si145_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- obelac102021_si139_sequencial_seq definition

-- DROP SEQUENCE obelac102021_si139_sequencial_seq;

CREATE SEQUENCE obelac102021_si139_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- obelac112021_si140_sequencial_seq definition

-- DROP SEQUENCE obelac112021_si140_sequencial_seq;

CREATE SEQUENCE obelac112021_si140_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops102021_si132_sequencial_seq definition

-- DROP SEQUENCE ops102021_si132_sequencial_seq;

CREATE SEQUENCE ops102021_si132_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops112021_si133_sequencial_seq definition

-- DROP SEQUENCE ops112021_si133_sequencial_seq;

CREATE SEQUENCE ops112021_si133_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops122021_si134_sequencial_seq definition

-- DROP SEQUENCE ops122021_si134_sequencial_seq;

CREATE SEQUENCE ops122021_si134_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops132021_si135_sequencial_seq definition

-- DROP SEQUENCE ops132021_si135_sequencial_seq;

CREATE SEQUENCE ops132021_si135_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- orgao102021_si14_sequencial_seq definition

-- DROP SEQUENCE orgao102021_si14_sequencial_seq;

CREATE SEQUENCE orgao102021_si14_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- orgao112021_si15_sequencial_seq definition

-- DROP SEQUENCE orgao112021_si15_sequencial_seq;

CREATE SEQUENCE orgao112021_si15_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec102021_si22_sequencial_seq definition

-- DROP SEQUENCE parec102021_si22_sequencial_seq;

CREATE SEQUENCE parec102021_si22_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec102021_si66_sequencial_seq definition

-- DROP SEQUENCE parec102021_si66_sequencial_seq;

CREATE SEQUENCE parec102021_si66_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec112021_si23_sequencial_seq definition

-- DROP SEQUENCE parec112021_si23_sequencial_seq;

CREATE SEQUENCE parec112021_si23_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parpps102021_si156_sequencial_seq definition

-- DROP SEQUENCE parpps102021_si156_sequencial_seq;

CREATE SEQUENCE parpps102021_si156_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- parpps202021_si155_sequencial_seq definition

-- DROP SEQUENCE parpps202021_si155_sequencial_seq;

CREATE SEQUENCE parpps202021_si155_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoa102021_si12_sequencial_seq definition

-- DROP SEQUENCE pessoa102021_si12_sequencial_seq;

CREATE SEQUENCE pessoa102021_si12_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoaflpgo102021_si193_sequencial_seq definition

-- DROP SEQUENCE pessoaflpgo102021_si193_sequencial_seq;

CREATE SEQUENCE pessoaflpgo102021_si193_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoasobra102021_si194_sequencial_seq definition

-- DROP SEQUENCE pessoasobra102021_si194_sequencial_seq;

CREATE SEQUENCE pessoasobra102021_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rec102021_si25_sequencial_seq definition

-- DROP SEQUENCE rec102021_si25_sequencial_seq;

CREATE SEQUENCE rec102021_si25_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rec112021_si26_sequencial_seq definition

-- DROP SEQUENCE rec112021_si26_sequencial_seq;

CREATE SEQUENCE rec112021_si26_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao102021_si67_sequencial_seq definition

-- DROP SEQUENCE regadesao102021_si67_sequencial_seq;

CREATE SEQUENCE regadesao102021_si67_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao112021_si68_sequencial_seq definition

-- DROP SEQUENCE regadesao112021_si68_sequencial_seq;

CREATE SEQUENCE regadesao112021_si68_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao122021_si69_sequencial_seq definition

-- DROP SEQUENCE regadesao122021_si69_sequencial_seq;

CREATE SEQUENCE regadesao122021_si69_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao132021_si70_sequencial_seq definition

-- DROP SEQUENCE regadesao132021_si70_sequencial_seq;

CREATE SEQUENCE regadesao132021_si70_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao142021_si71_sequencial_seq definition

-- DROP SEQUENCE regadesao142021_si71_sequencial_seq;

CREATE SEQUENCE regadesao142021_si71_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao152021_si72_sequencial_seq definition

-- DROP SEQUENCE regadesao152021_si72_sequencial_seq;

CREATE SEQUENCE regadesao152021_si72_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- regadesao202021_si73_sequencial_seq definition

-- DROP SEQUENCE regadesao202021_si73_sequencial_seq;

CREATE SEQUENCE regadesao202021_si73_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- reglic102021_si44_sequencial_seq definition

-- DROP SEQUENCE reglic102021_si44_sequencial_seq;

CREATE SEQUENCE reglic102021_si44_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- reglic202021_si45_sequencial_seq definition

-- DROP SEQUENCE reglic202021_si45_sequencial_seq;

CREATE SEQUENCE reglic202021_si45_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- resplic102021_si55_sequencial_seq definition

-- DROP SEQUENCE resplic102021_si55_sequencial_seq;

CREATE SEQUENCE resplic102021_si55_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- resplic202021_si56_sequencial_seq definition

-- DROP SEQUENCE resplic202021_si56_sequencial_seq;

CREATE SEQUENCE resplic202021_si56_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp102021_si112_sequencial_seq definition

-- DROP SEQUENCE rsp102021_si112_sequencial_seq;

CREATE SEQUENCE rsp102021_si112_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp112021_si113_sequencial_seq definition

-- DROP SEQUENCE rsp112021_si113_sequencial_seq;

CREATE SEQUENCE rsp112021_si113_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp122021_si114_sequencial_seq definition

-- DROP SEQUENCE rsp122021_si114_sequencial_seq;

CREATE SEQUENCE rsp122021_si114_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp202021_si115_sequencial_seq definition

-- DROP SEQUENCE rsp202021_si115_sequencial_seq;

CREATE SEQUENCE rsp202021_si115_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp212021_si116_sequencial_seq definition

-- DROP SEQUENCE rsp212021_si116_sequencial_seq;

CREATE SEQUENCE rsp212021_si116_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp222021_si117_sequencial_seq definition

-- DROP SEQUENCE rsp222021_si117_sequencial_seq;

CREATE SEQUENCE rsp222021_si117_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- tce102021_si187_sequencial_seq definition

-- DROP SEQUENCE tce102021_si187_sequencial_seq;

CREATE SEQUENCE tce102021_si187_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- tce112021_si188_sequencial_seq definition

-- DROP SEQUENCE tce112021_si188_sequencial_seq;

CREATE SEQUENCE tce112021_si188_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;



-- bfdcasp102021 definition

-- Drop table

-- DROP TABLE bfdcasp102021;

CREATE TABLE bfdcasp102021 (
    si206_sequencial int4 NOT NULL DEFAULT 0,
    si206_tiporegistro int4 NOT NULL DEFAULT 0,
    si206_exercicio int4 NOT NULL DEFAULT 0,
    si206_vlrecorcamenrecurord float8 NOT NULL DEFAULT 0,
    si206_vlrecorcamenrecinceduc float8 NOT NULL DEFAULT 0,
    si206_vlrecorcamenrecurvincusaude float8 NOT NULL DEFAULT 0,
    si206_vlrecorcamenrecurvincurpps float8 NOT NULL DEFAULT 0,
    si206_vlrecorcamenrecurvincuassistsoc float8 NOT NULL DEFAULT 0,
    si206_vlrecorcamenoutrasdestrecursos float8 NOT NULL DEFAULT 0,
    si206_vltransfinanexecuorcamentaria float8 NOT NULL DEFAULT 0,
    si206_vltransfinanindepenexecuorc float8 NOT NULL DEFAULT 0,
    si206_vltransfinanreceaportesrpps float8 NOT NULL DEFAULT 0,
    si206_vlincrirspnaoprocessado float8 NOT NULL DEFAULT 0,
    si206_vlincrirspprocessado float8 NOT NULL DEFAULT 0,
    si206_vldeporestituvinculados float8 NOT NULL DEFAULT 0,
    si206_vloutrosrecextraorcamentario float8 NOT NULL DEFAULT 0,
    si206_vlsaldoexeranteriorcaixaequicaixa float8 NOT NULL DEFAULT 0,
    si206_vlsaldoexerantdeporestvinc float8 NOT NULL DEFAULT 0,
    si206_vltotalingresso float8 NULL DEFAULT 0,
    si206_ano int4 NOT NULL DEFAULT 0,
    si206_periodo int4 NOT NULL DEFAULT 0,
    si206_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bfdcasp102021_sequ_pk PRIMARY KEY (si206_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bfdcasp202021 definition

-- Drop table

-- DROP TABLE bfdcasp202021;

CREATE TABLE bfdcasp202021 (
    si207_sequencial int4 NOT NULL DEFAULT 0,
    si207_tiporegistro int4 NOT NULL DEFAULT 0,
    si207_exercicio int4 NOT NULL DEFAULT 0,
    si207_vldesporcamenrecurordinarios float8 NOT NULL DEFAULT 0,
    si207_vldesporcamenrecurvincueducacao float8 NOT NULL DEFAULT 0,
    si207_vldesporcamenrecurvincusaude float8 NOT NULL DEFAULT 0,
    si207_vldesporcamenrecurvincurpps float8 NOT NULL DEFAULT 0,
    si207_vldesporcamenrecurvincuassistsoc float8 NOT NULL DEFAULT 0,
    si207_vloutrasdesporcamendestrecursos float8 NOT NULL DEFAULT 0,
    si207_vltransfinanconcexecorcamentaria float8 NOT NULL DEFAULT 0,
    si207_vltransfinanconcindepenexecorc float8 NOT NULL DEFAULT 0,
    si207_vltransfinanconcaportesrecurpps float8 NOT NULL DEFAULT 0,
    si207_vlpagrspnaoprocessado float8 NOT NULL DEFAULT 0,
    si207_vlpagrspprocessado float8 NOT NULL DEFAULT 0,
    si207_vldeposrestvinculados float8 NOT NULL DEFAULT 0,
    si207_vloutrospagextraorcamentarios float8 NOT NULL DEFAULT 0,
    si207_vlsaldoexeratualcaixaequicaixa float8 NOT NULL DEFAULT 0,
    si207_vlsaldoexeratualdeporestvinc float8 NOT NULL DEFAULT 0,
    si207_vltotaldispendios float8 NULL DEFAULT 0,
    si207_ano int4 NOT NULL DEFAULT 0,
    si207_periodo int4 NOT NULL DEFAULT 0,
    si207_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bfdcasp202021_sequ_pk PRIMARY KEY (si207_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp102021 definition

-- Drop table

-- DROP TABLE bodcasp102021;

CREATE TABLE bodcasp102021 (
    si201_sequencial int4 NOT NULL DEFAULT 0,
    si201_tiporegistro int4 NOT NULL DEFAULT 0,
    si201_faserecorcamentaria int4 NOT NULL DEFAULT 0,
    si201_vlrectributaria float8 NOT NULL DEFAULT 0,
    si201_vlreccontribuicoes float8 NOT NULL DEFAULT 0,
    si201_vlrecpatrimonial float8 NOT NULL DEFAULT 0,
    si201_vlrecagropecuaria float8 NOT NULL DEFAULT 0,
    si201_vlrecindustrial float8 NOT NULL DEFAULT 0,
    si201_vlrecservicos float8 NOT NULL DEFAULT 0,
    si201_vltransfcorrentes float8 NOT NULL DEFAULT 0,
    si201_vloutrasreccorrentes float8 NOT NULL DEFAULT 0,
    si201_vloperacoescredito float8 NOT NULL DEFAULT 0,
    si201_vlalienacaobens float8 NOT NULL DEFAULT 0,
    si201_vlamortemprestimo float8 NOT NULL DEFAULT 0,
    si201_vltransfcapital float8 NOT NULL DEFAULT 0,
    si201_vloutrasreccapital float8 NOT NULL DEFAULT 0,
    si201_vlrecarrecadaxeant float8 NOT NULL DEFAULT 0,
    si201_vlopcredrefintermob float8 NOT NULL DEFAULT 0,
    si201_vlopcredrefintcontrat float8 NOT NULL DEFAULT 0,
    si201_vlopcredrefextmob float8 NOT NULL DEFAULT 0,
    si201_vlopcredrefextcontrat float8 NOT NULL DEFAULT 0,
    si201_vldeficit float8 NOT NULL DEFAULT 0,
    si201_vltotalquadroreceita float8 NULL DEFAULT 0,
    si201_ano int4 NOT NULL DEFAULT 0,
    si201_periodo int4 NOT NULL DEFAULT 0,
    si201_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bodcasp102021_sequ_pk PRIMARY KEY (si201_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp202021 definition

-- Drop table

-- DROP TABLE bodcasp202021;

CREATE TABLE bodcasp202021 (
    si202_sequencial int4 NOT NULL DEFAULT 0,
    si202_tiporegistro int4 NOT NULL DEFAULT 0,
    si202_faserecorcamentaria int4 NOT NULL DEFAULT 0,
    si202_vlsaldoexeantsupfin float8 NOT NULL DEFAULT 0,
    si202_vlsaldoexeantrecredad float8 NOT NULL DEFAULT 0,
    si202_vltotalsaldoexeant float8 NULL DEFAULT 0,
    si202_anousu int4 NOT NULL DEFAULT 0,
    si202_periodo int4 NOT NULL DEFAULT 0,
    si202_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT bodcasp202021_sequ_pk PRIMARY KEY (si202_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp302021 definition

-- Drop table

-- DROP TABLE bodcasp302021;

CREATE TABLE bodcasp302021 (
    si203_sequencial int4 NOT NULL DEFAULT 0,
    si203_tiporegistro int4 NOT NULL DEFAULT 0,
    si203_fasedespesaorca int4 NOT NULL DEFAULT 0,
    si203_vlpessoalencarsoci float8 NOT NULL DEFAULT 0,
    si203_vljurosencardividas float8 NOT NULL DEFAULT 0,
    si203_vloutrasdespcorren float8 NOT NULL DEFAULT 0,
    si203_vlinvestimentos float8 NOT NULL DEFAULT 0,
    si203_vlinverfinanceira float8 NOT NULL DEFAULT 0,
    si203_vlamortizadivida float8 NOT NULL DEFAULT 0,
    si203_vlreservacontingen float8 NOT NULL DEFAULT 0,
    si203_vlreservarpps float8 NOT NULL DEFAULT 0,
    si203_vlamortizadiviintermob float8 NOT NULL DEFAULT 0,
    si203_vlamortizaoutrasdivinter float8 NOT NULL DEFAULT 0,
    si203_vlamortizadivextmob float8 NOT NULL DEFAULT 0,
    si203_vlamortizaoutrasdivext float8 NOT NULL DEFAULT 0,
    si203_vlsuperavit float8 NOT NULL DEFAULT 0,
    si203_vltotalquadrodespesa float8 NULL DEFAULT 0,
    si203_anousu int4 NOT NULL DEFAULT 0,
    si203_periodo int4 NOT NULL DEFAULT 0,
    si203_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT bodcasp302021_sequ_pk PRIMARY KEY (si203_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp402021 definition

-- Drop table

-- DROP TABLE bodcasp402021;

CREATE TABLE bodcasp402021 (
    si204_sequencial int4 NOT NULL DEFAULT 0,
    si204_tiporegistro int4 NOT NULL DEFAULT 0,
    si204_faserestospagarnaoproc int4 NOT NULL DEFAULT 0,
    si204_vlrspnaoprocpessoalencarsociais float8 NOT NULL DEFAULT 0,
    si204_vlrspnaoprocjurosencardividas float8 NOT NULL DEFAULT 0,
    si204_vlrspnaoprocoutrasdespcorrentes float8 NOT NULL DEFAULT 0,
    si204_vlrspnaoprocinvestimentos float8 NOT NULL DEFAULT 0,
    si204_vlrspnaoprocinverfinanceira float8 NOT NULL DEFAULT 0,
    si204_vlrspnaoprocamortizadivida float8 NOT NULL DEFAULT 0,
    si204_vltotalexecurspnaoprocessado float8 NULL DEFAULT 0,
    si204_ano int4 NOT NULL DEFAULT 0,
    si204_periodo int4 NOT NULL DEFAULT 0,
    si204_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bodcasp402021_sequ_pk PRIMARY KEY (si204_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp502021 definition

-- Drop table

-- DROP TABLE bodcasp502021;

CREATE TABLE bodcasp502021 (
    si205_sequencial int4 NOT NULL DEFAULT 0,
    si205_tiporegistro int4 NOT NULL DEFAULT 0,
    si205_faserestospagarprocnaoliqui int4 NOT NULL DEFAULT 0,
    si205_vlrspprocliqpessoalencarsoc float8 NOT NULL DEFAULT 0,
    si205_vlrspprocliqjurosencardiv float8 NOT NULL DEFAULT 0,
    si205_vlrspprocliqoutrasdespcorrentes float8 NOT NULL DEFAULT 0,
    si205_vlrspprocesliqinv float8 NOT NULL DEFAULT 0,
    si205_vlrspprocliqinverfinan float8 NOT NULL DEFAULT 0,
    si205_vlrspprocliqamortizadivida float8 NOT NULL DEFAULT 0,
    si205_vltotalexecrspprocnaoproceli float8 NULL DEFAULT 0,
    si205_ano int4 NOT NULL DEFAULT 0,
    si205_periodo int4 NOT NULL DEFAULT 0,
    si205_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bodcasp502021_sequ_pk PRIMARY KEY (si205_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp102021 definition

-- Drop table

-- DROP TABLE bpdcasp102021;

CREATE TABLE bpdcasp102021 (
    si208_sequencial int4 NOT NULL DEFAULT 0,
    si208_tiporegistro int4 NOT NULL DEFAULT 0,
    si208_exercicio int4 NOT NULL DEFAULT 0,
    si208_vlativocircucaixaequicaixa float8 NOT NULL DEFAULT 0,
    si208_vlativocircucredicurtoprazo float8 NOT NULL DEFAULT 0,
    si208_vlativocircuinvestapliccurtoprazo float8 NOT NULL DEFAULT 0,
    si208_vlativocircuestoques float8 NOT NULL DEFAULT 0,
    si208_vlativocircuvpdantecipada float8 NOT NULL DEFAULT 0,
    si208_vlativonaocircucredilongoprazo float8 NOT NULL DEFAULT 0,
    si208_vlativonaocircuinvestemplongpraz float8 NOT NULL DEFAULT 0,
    si208_vlativonaocircuestoques float8 NOT NULL DEFAULT 0,
    si208_vlativonaocircuvpdantecipada float8 NOT NULL DEFAULT 0,
    si208_vlativonaocircuinvestimentos float8 NOT NULL DEFAULT 0,
    si208_vlativonaocircuimobilizado float8 NOT NULL DEFAULT 0,
    si208_vlativonaocircuintagivel float8 NOT NULL DEFAULT 0,
    si208_vltotalativo float8 NULL DEFAULT 0,
    si208_ano int4 NOT NULL DEFAULT 0,
    si208_periodo int4 NOT NULL DEFAULT 0,
    si208_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp102021_sequ_pk PRIMARY KEY (si208_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp202021 definition

-- Drop table

-- DROP TABLE bpdcasp202021;

CREATE TABLE bpdcasp202021 (
    si209_sequencial int4 NOT NULL DEFAULT 0,
    si209_tiporegistro int4 NOT NULL DEFAULT 0,
    si209_exercicio int4 NOT NULL DEFAULT 0,
    si209_vlpassivcircultrabprevicurtoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassivcirculemprefinancurtoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassivocirculafornecedcurtoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassicircuobrigfiscacurtoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassivocirculaobrigacoutrosentes float8 NOT NULL DEFAULT 0,
    si209_vlpassivocirculaprovisoecurtoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassicircudemaiobrigcurtoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassinaocircutrabprevilongoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassnaocircemprfinalongpraz float8 NOT NULL DEFAULT 0,
    si209_vlpassivnaocirculforneclongoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassnaocircobrifisclongpraz float8 NOT NULL DEFAULT 0,
    si209_vlpassivnaocirculprovislongoprazo float8 NOT NULL DEFAULT 0,
    si209_vlpassnaocircdemaobrilongpraz float8 NOT NULL DEFAULT 0,
    si209_vlpassivonaocircularesuldiferido float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidocapitalsocial float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidoadianfuturocapital float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidoreservacapital float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidoajustavaliacao float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidoreservalucros float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidodemaisreservas float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidoresultexercicio float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidresultacumexeranteri float8 NOT NULL DEFAULT 0,
    si209_vlpatriliquidoacoescotas float8 NOT NULL DEFAULT 0,
    si209_vltotalpassivo float8 NULL DEFAULT 0,
    si209_ano int4 NOT NULL DEFAULT 0,
    si209_periodo int4 NOT NULL DEFAULT 0,
    si209_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp202021_sequ_pk PRIMARY KEY (si209_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp302021 definition

-- Drop table

-- DROP TABLE bpdcasp302021;

CREATE TABLE bpdcasp302021 (
    si210_sequencial int4 NOT NULL DEFAULT 0,
    si210_tiporegistro int4 NOT NULL DEFAULT 0,
    si210_exercicio int4 NOT NULL DEFAULT 0,
    si210_vlativofinanceiro float8 NOT NULL DEFAULT 0,
    si210_vlativopermanente float8 NOT NULL DEFAULT 0,
    si210_vltotalativofinanceiropermanente float8 NULL DEFAULT 0,
    si210_ano int4 NOT NULL DEFAULT 0,
    si210_periodo int4 NOT NULL DEFAULT 0,
    si210_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp302021_sequ_pk PRIMARY KEY (si210_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp402021 definition

-- Drop table

-- DROP TABLE bpdcasp402021;

CREATE TABLE bpdcasp402021 (
    si211_sequencial int4 NOT NULL DEFAULT 0,
    si211_tiporegistro int4 NOT NULL DEFAULT 0,
    si211_exercicio int4 NOT NULL DEFAULT 0,
    si211_vlpassivofinanceiro float8 NOT NULL DEFAULT 0,
    si211_vlpassivopermanente float8 NOT NULL DEFAULT 0,
    si211_vltotalpassivofinanceiropermanente float8 NULL DEFAULT 0,
    si211_ano int4 NOT NULL DEFAULT 0,
    si211_periodo int4 NOT NULL DEFAULT 0,
    si211_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp402021_sequ_pk PRIMARY KEY (si211_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp502021 definition

-- Drop table

-- DROP TABLE bpdcasp502021;

CREATE TABLE bpdcasp502021 (
    si212_sequencial int4 NOT NULL DEFAULT 0,
    si212_tiporegistro int4 NOT NULL DEFAULT 0,
    si212_exercicio int4 NOT NULL DEFAULT 0,
    si212_vlsaldopatrimonial float8 NULL DEFAULT 0,
    si212_ano int4 NOT NULL DEFAULT 0,
    si212_periodo int4 NOT NULL DEFAULT 0,
    si212_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp502021_sequ_pk PRIMARY KEY (si212_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp602021 definition

-- Drop table

-- DROP TABLE bpdcasp602021;

CREATE TABLE bpdcasp602021 (
    si213_sequencial int4 NOT NULL DEFAULT 0,
    si213_tiporegistro int4 NOT NULL DEFAULT 0,
    si213_exercicio int4 NOT NULL DEFAULT 0,
    si213_vlatospotenativosgarancontrarecebi float8 NOT NULL DEFAULT 0,
    si213_vlatospotenativodirconveoutroinstr float8 NOT NULL DEFAULT 0,
    si213_vlatospotenativosdireitoscontratua float8 NOT NULL DEFAULT 0,
    si213_vlatospotenativosoutrosatos float8 NOT NULL DEFAULT 0,
    si213_vlatospotenpassivgarancontraconced float8 NOT NULL DEFAULT 0,
    si213_vlatospotepassobriconvoutrinst float8 NOT NULL DEFAULT 0,
    si213_vlatospotenpassivoobrigacocontratu float8 NOT NULL DEFAULT 0,
    si213_vlatospotenpassivooutrosatos float8 NULL DEFAULT 0,
    si213_ano int4 NOT NULL DEFAULT 0,
    si213_periodo int4 NOT NULL DEFAULT 0,
    si213_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp602021_sequ_pk PRIMARY KEY (si213_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp702021 definition

-- Drop table

-- DROP TABLE bpdcasp702021;

CREATE TABLE bpdcasp702021 (
    si214_sequencial int4 NOT NULL DEFAULT 0,
    si214_tiporegistro int4 NOT NULL DEFAULT 0,
    si214_exercicio int4 NOT NULL DEFAULT 0,
    si214_vltotalsupdef float8 NULL DEFAULT 0,
    si214_ano int4 NOT NULL DEFAULT 0,
    si214_periodo int4 NOT NULL DEFAULT 0,
    si214_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp702021_sequ_pk PRIMARY KEY (si214_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp712021 definition

-- Drop table

-- DROP TABLE bpdcasp712021;

CREATE TABLE bpdcasp712021 (
    si215_sequencial int4 NOT NULL DEFAULT 0,
    si215_tiporegistro int4 NOT NULL DEFAULT 0,
    si215_exercicio int4 NOT NULL DEFAULT 0,
    si215_codfontrecursos int4 NOT NULL DEFAULT 0,
    si215_vlsaldofonte float8 NULL DEFAULT 0,
    si215_ano int4 NOT NULL DEFAULT 0,
    si215_periodo int4 NOT NULL DEFAULT 0,
    si215_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp712021_sequ_pk PRIMARY KEY (si215_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp1002021 definition

-- Drop table

-- DROP TABLE dfcdcasp1002021;

CREATE TABLE dfcdcasp1002021 (
    si228_sequencial int4 NOT NULL DEFAULT 0,
    si228_tiporegistro int4 NOT NULL DEFAULT 0,
    si228_vlgeracaoliquidaequivalentecaixa float8 NULL DEFAULT 0,
    si228_anousu int4 NOT NULL DEFAULT 0,
    si228_periodo int4 NOT NULL DEFAULT 0,
    si228_mes int4 NOT NULL DEFAULT 0,
    si228_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp1002021_sequ_pk PRIMARY KEY (si228_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp102021 definition

-- Drop table

-- DROP TABLE dfcdcasp102021;

CREATE TABLE dfcdcasp102021 (
    si219_sequencial int4 NOT NULL DEFAULT 0,
    si219_tiporegistro int4 NOT NULL DEFAULT 0,
    si219_vlreceitaderivadaoriginaria float8 NOT NULL DEFAULT 0,
    si219_vltranscorrenterecebida float8 NOT NULL DEFAULT 0,
    si219_vloutrosingressosoperacionais float8 NOT NULL DEFAULT 0,
    si219_vltotalingressosativoperacionais float8 NULL DEFAULT 0,
    si219_anousu int4 NOT NULL DEFAULT 0,
    si219_periodo int4 NOT NULL DEFAULT 0,
    si219_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp102021_sequ_pk PRIMARY KEY (si219_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp1102021 definition

-- Drop table

-- DROP TABLE dfcdcasp1102021;

CREATE TABLE dfcdcasp1102021 (
    si229_sequencial int4 NOT NULL DEFAULT 0,
    si229_tiporegistro int4 NOT NULL DEFAULT 0,
    si229_vlcaixaequivalentecaixainicial float8 NOT NULL DEFAULT 0,
    si229_vlcaixaequivalentecaixafinal float8 NULL DEFAULT 0,
    si229_anousu int4 NOT NULL DEFAULT 0,
    si229_periodo int4 NOT NULL DEFAULT 0,
    si229_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp1102021_sequ_pk PRIMARY KEY (si229_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp202021 definition

-- Drop table

-- DROP TABLE dfcdcasp202021;

CREATE TABLE dfcdcasp202021 (
    si220_sequencial int4 NOT NULL DEFAULT 0,
    si220_tiporegistro int4 NOT NULL DEFAULT 0,
    si220_vldesembolsopessoaldespesas float8 NOT NULL DEFAULT 0,
    si220_vldesembolsojurosencargdivida float8 NOT NULL DEFAULT 0,
    si220_vldesembolsotransfconcedidas float8 NOT NULL DEFAULT 0,
    si220_vloutrosdesembolsos float8 NOT NULL DEFAULT 0,
    si220_vltotaldesembolsosativoperacionais float8 NULL DEFAULT 0,
    si220_anousu int4 NOT NULL DEFAULT 0,
    si220_periodo int4 NOT NULL DEFAULT 0,
    si220_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp202021_sequ_pk PRIMARY KEY (si220_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp302021 definition

-- Drop table

-- DROP TABLE dfcdcasp302021;

CREATE TABLE dfcdcasp302021 (
    si221_sequencial int4 NOT NULL DEFAULT 0,
    si221_tiporegistro int4 NOT NULL DEFAULT 0,
    si221_vlfluxocaixaliquidooperacional float8 NULL DEFAULT 0,
    si221_anousu int4 NOT NULL DEFAULT 0,
    si221_periodo int4 NOT NULL DEFAULT 0,
    si221_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp302021_sequ_pk PRIMARY KEY (si221_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp402021 definition

-- Drop table

-- DROP TABLE dfcdcasp402021;

CREATE TABLE dfcdcasp402021 (
    si222_sequencial int4 NOT NULL DEFAULT 0,
    si222_tiporegistro int4 NOT NULL DEFAULT 0,
    si222_vlalienacaobens float8 NOT NULL DEFAULT 0,
    si222_vlamortizacaoemprestimoconcedido float8 NOT NULL DEFAULT 0,
    si222_vloutrosingressos float8 NOT NULL DEFAULT 0,
    si222_vltotalingressosatividainvestiment float8 NULL DEFAULT 0,
    si222_anousu int4 NOT NULL DEFAULT 0,
    si222_periodo int4 NOT NULL DEFAULT 0,
    si222_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp402021_sequ_pk PRIMARY KEY (si222_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp502021 definition

-- Drop table

-- DROP TABLE dfcdcasp502021;

CREATE TABLE dfcdcasp502021 (
    si223_sequencial int4 NOT NULL DEFAULT 0,
    si223_tiporegistro int4 NOT NULL DEFAULT 0,
    si223_vlaquisicaoativonaocirculante float8 NOT NULL DEFAULT 0,
    si223_vlconcessaoempresfinanciamento float8 NOT NULL DEFAULT 0,
    si223_vloutrosdesembolsos float8 NOT NULL DEFAULT 0,
    si223_vltotaldesembolsoatividainvestimen float8 NULL DEFAULT 0,
    si223_anousu int4 NOT NULL DEFAULT 0,
    si223_periodo int4 NOT NULL DEFAULT 0,
    si223_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp502021_sequ_pk PRIMARY KEY (si223_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp602021 definition

-- Drop table

-- DROP TABLE dfcdcasp602021;

CREATE TABLE dfcdcasp602021 (
    si224_sequencial int4 NOT NULL DEFAULT 0,
    si224_tiporegistro int4 NOT NULL DEFAULT 0,
    si224_vlfluxocaixaliquidoinvestimento float8 NULL DEFAULT 0,
    si224_anousu int4 NOT NULL DEFAULT 0,
    si224_periodo int4 NOT NULL DEFAULT 0,
    si224_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp602021_sequ_pk PRIMARY KEY (si224_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp702021 definition

-- Drop table

-- DROP TABLE dfcdcasp702021;

CREATE TABLE dfcdcasp702021 (
    si225_sequencial int4 NOT NULL DEFAULT 0,
    si225_tiporegistro int4 NOT NULL DEFAULT 0,
    si225_vloperacoescredito float8 NOT NULL DEFAULT 0,
    si225_vlintegralizacaodependentes float8 NOT NULL DEFAULT 0,
    si225_vltranscapitalrecebida float8 NOT NULL DEFAULT 0,
    si225_vloutrosingressosfinanciamento float8 NOT NULL DEFAULT 0,
    si225_vltotalingressoatividafinanciament float8 NULL DEFAULT 0,
    si225_anousu int4 NOT NULL DEFAULT 0,
    si225_periodo int4 NOT NULL DEFAULT 0,
    si225_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp702021_sequ_pk PRIMARY KEY (si225_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp802021 definition

-- Drop table

-- DROP TABLE dfcdcasp802021;

CREATE TABLE dfcdcasp802021 (
    si226_sequencial int4 NOT NULL DEFAULT 0,
    si226_tiporegistro int4 NOT NULL DEFAULT 0,
    si226_vlamortizacaorefinanciamento float8 NOT NULL DEFAULT 0,
    si226_vloutrosdesembolsosfinanciamento float8 NOT NULL DEFAULT 0,
    si226_vltotaldesembolsoatividafinanciame float8 NULL DEFAULT 0,
    si226_anousu int4 NOT NULL DEFAULT 0,
    si226_periodo int4 NOT NULL DEFAULT 0,
    si226_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp802021_sequ_pk PRIMARY KEY (si226_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp902021 definition

-- Drop table

-- DROP TABLE dfcdcasp902021;

CREATE TABLE dfcdcasp902021 (
    si227_sequencial int4 NOT NULL DEFAULT 0,
    si227_tiporegistro int4 NOT NULL DEFAULT 0,
    si227_vlfluxocaixafinanciamento float8 NULL DEFAULT 0,
    si227_anousu int4 NOT NULL DEFAULT 0,
    si227_periodo int4 NOT NULL DEFAULT 0,
    si227_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp902021_sequ_pk PRIMARY KEY (si227_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dvpdcasp102021 definition

-- Drop table

-- DROP TABLE dvpdcasp102021;

CREATE TABLE dvpdcasp102021 (
    si216_sequencial int4 NOT NULL DEFAULT 0,
    si216_tiporegistro int4 NOT NULL DEFAULT 0,
    si216_vlimpostos float8 NOT NULL DEFAULT 0,
    si216_vlcontribuicoes float8 NOT NULL DEFAULT 0,
    si216_vlexploracovendasdireitos float8 NOT NULL DEFAULT 0,
    si216_vlvariacoesaumentativasfinanceiras float8 NOT NULL DEFAULT 0,
    si216_vltransfdelegacoesrecebidas float8 NOT NULL DEFAULT 0,
    si216_vlvalorizacaoativodesincorpassivo float8 NOT NULL DEFAULT 0,
    si216_vloutrasvariacoespatriaumentativas float8 NOT NULL DEFAULT 0,
    si216_vltotalvpaumentativas float8 NULL DEFAULT 0,
    si216_ano int4 NOT NULL DEFAULT 0,
    si216_periodo int4 NOT NULL DEFAULT 0,
    si216_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT dvpdcasp102021_sequ_pk PRIMARY KEY (si216_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dvpdcasp202021 definition

-- Drop table

-- DROP TABLE dvpdcasp202021;

CREATE TABLE dvpdcasp202021 (
    si217_sequencial int4 NOT NULL DEFAULT 0,
    si217_tiporegistro int4 NOT NULL DEFAULT 0,
    si217_vldiminutivapessoaencargos float8 NOT NULL DEFAULT 0,
    si217_vlprevassistenciais float8 NOT NULL DEFAULT 0,
    si217_vlservicoscapitalfixo float8 NOT NULL DEFAULT 0,
    si217_vldiminutivavariacoesfinanceiras float8 NOT NULL DEFAULT 0,
    si217_vltransfconcedidas float8 NOT NULL DEFAULT 0,
    si217_vldesvaloativoincorpopassivo float8 NOT NULL DEFAULT 0,
    si217_vltributarias float8 NOT NULL DEFAULT 0,
    si217_vlmercadoriavendidoservicos float8 NOT NULL DEFAULT 0,
    si217_vloutrasvariacoespatridiminutivas float8 NOT NULL DEFAULT 0,
    si217_vltotalvpdiminutivas float8 NULL DEFAULT 0,
    si217_ano int4 NOT NULL DEFAULT 0,
    si217_periodo int4 NOT NULL DEFAULT 0,
    si217_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT dvpdcasp202021_sequ_pk PRIMARY KEY (si217_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dvpdcasp302021 definition

-- Drop table

-- DROP TABLE dvpdcasp302021;

CREATE TABLE dvpdcasp302021 (
    si218_sequencial int4 NOT NULL DEFAULT 0,
    si218_tiporegistro int4 NOT NULL DEFAULT 0,
    si218_vlresultadopatrimonialperiodo float8 NULL DEFAULT 0,
    si218_ano int4 NOT NULL DEFAULT 0,
    si218_periodo int4 NOT NULL DEFAULT 0,
    si218_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT dvpdcasp302021_sequ_pk PRIMARY KEY (si218_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rpsd102021 definition

-- Drop table

-- DROP TABLE rpsd102021;

CREATE TABLE rpsd102021 (
    si189_sequencial int8 NOT NULL DEFAULT 0,
    si189_tiporegistro int8 NOT NULL DEFAULT 0,
    si189_codreduzidorsp int8 NOT NULL DEFAULT 0,
    si189_codorgao varchar(2) NOT NULL,
    si189_codunidadesub varchar(8) NOT NULL,
    si189_codunidadesuborig varchar(8) NOT NULL,
    si189_nroempenho int8 NOT NULL DEFAULT 0,
    si189_exercicioempenho int8 NOT NULL DEFAULT 0,
    si189_dtempenho date NOT NULL,
    si189_tipopagamentorsp int8 NOT NULL DEFAULT 0,
    si189_vlpagorsp float8 NOT NULL DEFAULT 0,
    si189_mes int8 NOT NULL DEFAULT 0,
    si189_instit int8 NULL DEFAULT 0,
    CONSTRAINT rpsd102021_sequ_pk PRIMARY KEY (si189_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rpsd112021 definition

-- Drop table

-- DROP TABLE rpsd112021;

CREATE TABLE rpsd112021 (
    si190_sequencial int8 NOT NULL DEFAULT 0,
    si190_tiporegistro int8 NOT NULL DEFAULT 0,
    si190_codreduzidorsp int8 NOT NULL DEFAULT 0,
    si190_codfontrecursos int8 NOT NULL DEFAULT 0,
    si190_vlpagofontersp float8 NOT NULL DEFAULT 0,
    si190_reg10 int8 NOT NULL DEFAULT 0,
    si190_mes int8 NOT NULL DEFAULT 0,
    si190_instit int8 NULL DEFAULT 0,
    CONSTRAINT rpsd112021_sequ_pk PRIMARY KEY (si190_sequencial),
    CONSTRAINT rpsd112021_reg10_fk FOREIGN KEY (si190_reg10) REFERENCES rpsd102021(si189_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bfdcasp102021_si206_sequencial_seq definition

-- DROP SEQUENCE bfdcasp102021_si206_sequencial_seq;

CREATE SEQUENCE bfdcasp102021_si206_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bfdcasp202021_si207_sequencial_seq definition

-- DROP SEQUENCE bfdcasp202021_si207_sequencial_seq;

CREATE SEQUENCE bfdcasp202021_si207_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp102021_si201_sequencial_seq definition

-- DROP SEQUENCE bodcasp102021_si201_sequencial_seq;

CREATE SEQUENCE bodcasp102021_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp202021_si202_sequencial_seq definition

-- DROP SEQUENCE bodcasp202021_si202_sequencial_seq;

CREATE SEQUENCE bodcasp202021_si202_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp302021_si203_sequencial_seq definition

-- DROP SEQUENCE bodcasp302021_si203_sequencial_seq;

CREATE SEQUENCE bodcasp302021_si203_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp402021_si204_sequencial_seq definition

-- DROP SEQUENCE bodcasp402021_si204_sequencial_seq;

CREATE SEQUENCE bodcasp402021_si204_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp502021_si205_sequencial_seq definition

-- DROP SEQUENCE bodcasp502021_si205_sequencial_seq;

CREATE SEQUENCE bodcasp502021_si205_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp102021_si208_sequencial_seq definition

-- DROP SEQUENCE bpdcasp102021_si208_sequencial_seq;

CREATE SEQUENCE bpdcasp102021_si208_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp202021_si209_sequencial_seq definition

-- DROP SEQUENCE bpdcasp202021_si209_sequencial_seq;

CREATE SEQUENCE bpdcasp202021_si209_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp302021_si210_sequencial_seq definition

-- DROP SEQUENCE bpdcasp302021_si210_sequencial_seq;

CREATE SEQUENCE bpdcasp302021_si210_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp402021_si211_sequencial_seq definition

-- DROP SEQUENCE bpdcasp402021_si211_sequencial_seq;

CREATE SEQUENCE bpdcasp402021_si211_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp502021_si212_sequencial_seq definition

-- DROP SEQUENCE bpdcasp502021_si212_sequencial_seq;

CREATE SEQUENCE bpdcasp502021_si212_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp602021_si213_sequencial_seq definition

-- DROP SEQUENCE bpdcasp602021_si213_sequencial_seq;

CREATE SEQUENCE bpdcasp602021_si213_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp702021_si214_sequencial_seq definition

-- DROP SEQUENCE bpdcasp702021_si214_sequencial_seq;

CREATE SEQUENCE bpdcasp702021_si214_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp712021_si215_sequencial_seq definition

-- DROP SEQUENCE bpdcasp712021_si215_sequencial_seq;

CREATE SEQUENCE bpdcasp712021_si215_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp1002021_si228_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp1002021_si228_sequencial_seq;

CREATE SEQUENCE dfcdcasp1002021_si228_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp102021_si219_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp102021_si219_sequencial_seq;

CREATE SEQUENCE dfcdcasp102021_si219_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp1102021_si229_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp1102021_si229_sequencial_seq;

CREATE SEQUENCE dfcdcasp1102021_si229_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp202021_si220_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp202021_si220_sequencial_seq;

CREATE SEQUENCE dfcdcasp202021_si220_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp302021_si221_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp302021_si221_sequencial_seq;

CREATE SEQUENCE dfcdcasp302021_si221_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp402021_si222_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp402021_si222_sequencial_seq;

CREATE SEQUENCE dfcdcasp402021_si222_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp502021_si223_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp502021_si223_sequencial_seq;

CREATE SEQUENCE dfcdcasp502021_si223_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp602021_si224_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp602021_si224_sequencial_seq;

CREATE SEQUENCE dfcdcasp602021_si224_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp702021_si225_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp702021_si225_sequencial_seq;

CREATE SEQUENCE dfcdcasp702021_si225_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp802021_si226_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp802021_si226_sequencial_seq;

CREATE SEQUENCE dfcdcasp802021_si226_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp902021_si227_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp902021_si227_sequencial_seq;

CREATE SEQUENCE dfcdcasp902021_si227_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp102021_si216_sequencial_seq definition

-- DROP SEQUENCE dvpdcasp102021_si216_sequencial_seq;

CREATE SEQUENCE dvpdcasp102021_si216_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp202021_si217_sequencial_seq definition

-- DROP SEQUENCE dvpdcasp202021_si217_sequencial_seq;

CREATE SEQUENCE dvpdcasp202021_si217_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp302021_si218_sequencial_seq definition

-- DROP SEQUENCE dvpdcasp302021_si218_sequencial_seq;

CREATE SEQUENCE dvpdcasp302021_si218_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rpsd102021_si189_sequencial_seq definition

-- DROP SEQUENCE rpsd102021_si189_sequencial_seq;

CREATE SEQUENCE rpsd102021_si189_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rpsd112021_si190_sequencial_seq definition

-- DROP SEQUENCE rpsd112021_si190_sequencial_seq;

CREATE SEQUENCE rpsd112021_si190_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- balancete102021 definition

-- Drop table

-- DROP TABLE balancete102021;

CREATE TABLE balancete102021 (
    si177_sequencial int8 NOT NULL DEFAULT 0,
    si177_tiporegistro int8 NOT NULL DEFAULT 0,
    si177_contacontaabil int8 NOT NULL DEFAULT 0,
    si177_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si177_saldoinicial float8 NOT NULL DEFAULT 0,
    si177_naturezasaldoinicial varchar(1) NOT NULL,
    si177_totaldebitos float8 NOT NULL DEFAULT 0,
    si177_totalcreditos float8 NOT NULL DEFAULT 0,
    si177_saldofinal float8 NOT NULL DEFAULT 0,
    si177_naturezasaldofinal varchar(1) NOT NULL,
    si177_mes int8 NOT NULL DEFAULT 0,
    si177_instit int8 NULL DEFAULT 0,
    CONSTRAINT balancete102021_sequ_pk PRIMARY KEY (si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete112021 definition

-- Drop table

-- DROP TABLE balancete112021;

CREATE TABLE balancete112021 (
    si178_sequencial int8 NOT NULL DEFAULT 0,
    si178_tiporegistro int8 NOT NULL DEFAULT 0,
    si178_contacontaabil int8 NOT NULL DEFAULT 0,
    si178_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si178_codorgao varchar(2) NOT NULL,
    si178_codunidadesub varchar(8) NOT NULL,
    si178_codfuncao varchar(2) NOT NULL,
    si178_codsubfuncao varchar(3) NOT NULL,
    si178_codprograma varchar(4) NULL,
    si178_idacao varchar(4) NOT NULL,
    si178_idsubacao varchar(4) NOT NULL,
    si178_naturezadespesa int8 NOT NULL DEFAULT 0,
    si178_subelemento varchar(2) NOT NULL,
    si178_codfontrecursos int8 NOT NULL DEFAULT 0,
    si178_saldoinicialcd float8 NOT NULL DEFAULT 0,
    si178_naturezasaldoinicialcd varchar(1) NOT NULL,
    si178_totaldebitoscd float8 NOT NULL DEFAULT 0,
    si178_totalcreditoscd float8 NOT NULL DEFAULT 0,
    si178_saldofinalcd float8 NOT NULL DEFAULT 0,
    si178_naturezasaldofinalcd varchar(1) NOT NULL,
    si178_mes int8 NOT NULL DEFAULT 0,
    si178_instit int8 NULL DEFAULT 0,
    si178_reg10 int8 NOT NULL,
    CONSTRAINT balancete112021_sequ_pk PRIMARY KEY (si178_sequencial),
    CONSTRAINT fk_balancete112021_reg10_fk FOREIGN KEY (si178_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete122021 definition

-- Drop table

-- DROP TABLE balancete122021;

CREATE TABLE balancete122021 (
    si179_sequencial int8 NOT NULL DEFAULT 0,
    si179_tiporegistro int8 NOT NULL DEFAULT 0,
    si179_contacontabil int8 NOT NULL DEFAULT 0,
    si179_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si179_naturezareceita int8 NOT NULL DEFAULT 0,
    si179_codfontrecursos int8 NOT NULL DEFAULT 0,
    si179_saldoinicialcr float8 NOT NULL DEFAULT 0,
    si179_naturezasaldoinicialcr varchar(1) NOT NULL,
    si179_totaldebitoscr float8 NOT NULL DEFAULT 0,
    si179_totalcreditoscr float8 NOT NULL DEFAULT 0,
    si179_saldofinalcr float8 NOT NULL DEFAULT 0,
    si179_naturezasaldofinalcr varchar(1) NOT NULL,
    si179_mes int8 NOT NULL DEFAULT 0,
    si179_instit int8 NULL DEFAULT 0,
    si179_reg10 int8 NOT NULL,
    CONSTRAINT balancete122021_sequ_pk PRIMARY KEY (si179_sequencial),
    CONSTRAINT fk_balancete122021_reg10_fk FOREIGN KEY (si179_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete132021 definition

-- Drop table

-- DROP TABLE balancete132021;

CREATE TABLE balancete132021 (
    si180_sequencial int8 NOT NULL DEFAULT 0,
    si180_tiporegistro int8 NOT NULL DEFAULT 0,
    si180_contacontabil int8 NOT NULL DEFAULT 0,
    si180_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si180_codprograma varchar(4) NOT NULL,
    si180_idacao varchar(4) NOT NULL,
    si180_idsubacao varchar(4) NULL,
    si180_saldoinicialpa float8 NOT NULL DEFAULT 0,
    si180_naturezasaldoinicialpa varchar(1) NOT NULL,
    si180_totaldebitospa float8 NOT NULL DEFAULT 0,
    si180_totalcreditospa float8 NOT NULL DEFAULT 0,
    si180_saldofinalpa float8 NOT NULL DEFAULT 0,
    si180_naturezasaldofinalpa varchar(1) NOT NULL,
    si180_mes int8 NOT NULL DEFAULT 0,
    si180_instit int8 NULL DEFAULT 0,
    si180_reg10 int8 NOT NULL,
    CONSTRAINT balancete132021_sequ_pk PRIMARY KEY (si180_sequencial),
    CONSTRAINT fk_balancete132021_reg10_fk FOREIGN KEY (si180_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete142021 definition

-- Drop table

-- DROP TABLE balancete142021;

CREATE TABLE balancete142021 (
    si181_sequencial int8 NOT NULL DEFAULT 0,
    si181_tiporegistro int8 NOT NULL DEFAULT 0,
    si181_contacontabil int8 NOT NULL DEFAULT 0,
    si181_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si181_codorgao varchar(2) NOT NULL,
    si181_codunidadesub varchar(8) NOT NULL,
    si181_codunidadesuborig varchar(8) NOT NULL,
    si181_codfuncao varchar(2) NOT NULL,
    si181_codsubfuncao varchar(3) NOT NULL,
    si181_codprograma varchar(4) NOT NULL,
    si181_idacao varchar(4) NOT NULL,
    si181_idsubacao varchar(4) NULL,
    si181_naturezadespesa int8 NOT NULL DEFAULT 0,
    si181_subelemento varchar(2) NOT NULL,
    si181_codfontrecursos int8 NOT NULL DEFAULT 0,
    si181_nroempenho int8 NOT NULL DEFAULT 0,
    si181_anoinscricao int8 NOT NULL DEFAULT 0,
    si181_saldoinicialrsp float8 NOT NULL DEFAULT 0,
    si181_naturezasaldoinicialrsp varchar(1) NOT NULL,
    si181_totaldebitosrsp float8 NOT NULL DEFAULT 0,
    si181_totalcreditosrsp float8 NOT NULL DEFAULT 0,
    si181_saldofinalrsp float8 NOT NULL DEFAULT 0,
    si181_naturezasaldofinalrsp varchar(1) NOT NULL,
    si181_mes int8 NOT NULL DEFAULT 0,
    si181_instit int8 NULL DEFAULT 0,
    si181_reg10 int8 NOT NULL,
    CONSTRAINT balancete142021_sequ_pk PRIMARY KEY (si181_sequencial),
    CONSTRAINT fk_balancete142021_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete152021 definition

-- Drop table

-- DROP TABLE balancete152021;

CREATE TABLE balancete152021 (
    si182_sequencial int8 NOT NULL DEFAULT 0,
    si182_tiporegistro int8 NOT NULL DEFAULT 0,
    si182_contacontabil int8 NOT NULL DEFAULT 0,
    si182_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si182_atributosf varchar(1) NOT NULL,
    si182_saldoinicialsf float8 NOT NULL DEFAULT 0,
    si182_naturezasaldoinicialsf varchar(1) NOT NULL,
    si182_totaldebitossf float8 NOT NULL DEFAULT 0,
    si182_totalcreditossf float8 NOT NULL DEFAULT 0,
    si182_saldofinalsf float8 NOT NULL DEFAULT 0,
    si182_naturezasaldofinalsf varchar(1) NOT NULL,
    si182_mes int8 NOT NULL DEFAULT 0,
    si182_instit int8 NULL DEFAULT 0,
    si182_reg10 int8 NOT NULL,
    CONSTRAINT balancete152021_sequ_pk PRIMARY KEY (si182_sequencial),
    CONSTRAINT fk_balancete152021_reg10_fk FOREIGN KEY (si182_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete162021 definition

-- Drop table

-- DROP TABLE balancete162021;

CREATE TABLE balancete162021 (
    si183_sequencial int8 NOT NULL DEFAULT 0,
    si183_tiporegistro int8 NOT NULL DEFAULT 0,
    si183_contacontabil int8 NOT NULL DEFAULT 0,
    si183_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si183_atributosf varchar(1) NOT NULL,
    si183_codfontrecursos int8 NOT NULL DEFAULT 0,
    si183_saldoinicialfontsf float8 NOT NULL DEFAULT 0,
    si183_naturezasaldoinicialfontsf varchar(1) NOT NULL,
    si183_totaldebitosfontsf float8 NOT NULL DEFAULT 0,
    si183_totalcreditosfontsf float8 NOT NULL DEFAULT 0,
    si183_saldofinalfontsf float8 NOT NULL DEFAULT 0,
    si183_naturezasaldofinalfontsf varchar(1) NOT NULL,
    si183_mes int8 NOT NULL DEFAULT 0,
    si183_instit int8 NULL DEFAULT 0,
    si183_reg10 int8 NOT NULL,
    CONSTRAINT balancete162021_sequ_pk PRIMARY KEY (si183_sequencial),
    CONSTRAINT fk_balancete162021_reg10_fk FOREIGN KEY (si183_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete172021 definition

-- Drop table

-- DROP TABLE balancete172021;

CREATE TABLE balancete172021 (
    si184_sequencial int8 NOT NULL DEFAULT 0,
    si184_tiporegistro int8 NOT NULL DEFAULT 0,
    si184_contacontabil int8 NOT NULL DEFAULT 0,
    si184_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si184_atributosf varchar(1) NOT NULL,
    si184_codctb int8 NOT NULL DEFAULT 0,
    si184_codfontrecursos int8 NOT NULL DEFAULT 0,
    si184_saldoinicialctb float8 NOT NULL DEFAULT 0,
    si184_naturezasaldoinicialctb varchar(1) NOT NULL,
    si184_totaldebitosctb float8 NOT NULL DEFAULT 0,
    si184_totalcreditosctb float8 NOT NULL DEFAULT 0,
    si184_saldofinalctb float8 NOT NULL DEFAULT 0,
    si184_naturezasaldofinalctb varchar(1) NOT NULL,
    si184_mes int8 NOT NULL DEFAULT 0,
    si184_instit int8 NULL DEFAULT 0,
    si184_reg10 int8 NOT NULL,
    CONSTRAINT balancete172021_sequ_pk PRIMARY KEY (si184_sequencial),
    CONSTRAINT fk_balancete172021_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete182021 definition

-- Drop table

-- DROP TABLE balancete182021;

CREATE TABLE balancete182021 (
    si185_sequencial int8 NOT NULL DEFAULT 0,
    si185_tiporegistro int8 NOT NULL DEFAULT 0,
    si185_contacontabil int8 NOT NULL DEFAULT 0,
    si185_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si185_codfontrecursos int8 NOT NULL DEFAULT 0,
    si185_saldoinicialfr float8 NOT NULL DEFAULT 0,
    si185_naturezasaldoinicialfr varchar(1) NOT NULL,
    si185_totaldebitosfr float8 NOT NULL DEFAULT 0,
    si185_totalcreditosfr float8 NOT NULL DEFAULT 0,
    si185_saldofinalfr float8 NOT NULL DEFAULT 0,
    si185_naturezasaldofinalfr varchar(1) NOT NULL,
    si185_mes int8 NOT NULL DEFAULT 0,
    si185_instit int8 NULL DEFAULT 0,
    si185_reg10 int8 NOT NULL,
    CONSTRAINT balancete182021_sequ_pk PRIMARY KEY (si185_sequencial),
    CONSTRAINT fk_balancete182021_reg10_fk FOREIGN KEY (si185_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete192021 definition

-- Drop table

-- DROP TABLE balancete192021;

CREATE TABLE balancete192021 (
    si186_sequencial int8 NOT NULL DEFAULT 0,
    si186_tiporegistro int8 NOT NULL DEFAULT 0,
    si186_contacontabil int8 NOT NULL DEFAULT 0,
    si186_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si186_cnpjconsorcio int8 NOT NULL DEFAULT 0,
    si186_saldoinicialconsor float8 NOT NULL DEFAULT 0,
    si186_naturezasaldoinicialconsor varchar(1) NOT NULL,
    si186_totaldebitosconsor float8 NOT NULL DEFAULT 0,
    si186_totalcreditosconsor float8 NOT NULL DEFAULT 0,
    si186_saldofinalconsor float8 NOT NULL DEFAULT 0,
    si186_naturezasaldofinalconsor varchar(1) NOT NULL,
    si186_mes int8 NOT NULL DEFAULT 0,
    si186_instit int8 NULL DEFAULT 0,
    si186_reg10 int8 NOT NULL,
    CONSTRAINT balancete192021_sequ_pk PRIMARY KEY (si186_sequencial),
    CONSTRAINT fk_balancete192021_reg10_fk FOREIGN KEY (si186_reg10) REFERENCES balancete102021(si177_sequencial)
)
WITH (
    OIDS=TRUE
);

-- balancete202021 definition

-- Drop table

-- DROP TABLE balancete202021;

CREATE TABLE balancete202021 (
    si187_sequencial int8 NOT NULL DEFAULT 0,
    si187_tiporegistro int8 NOT NULL DEFAULT 0,
    si187_contacontabil int8 NOT NULL DEFAULT 0,
    si187_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si187_cnpjconsorcio int8 NOT NULL DEFAULT 0,
    si187_tiporecurso int4 NOT NULL DEFAULT 0,
    si187_codfuncao varchar(2) NOT NULL,
    si187_codsubfuncao varchar(3) NOT NULL,
    si187_naturezadespesa int8 NOT NULL DEFAULT 0,
    si187_subelemento varchar(2) NOT NULL,
    si187_codfontrecursos int8 NOT NULL DEFAULT 0,
    si187_saldoinicialconscf float8 NOT NULL DEFAULT 0,
    si187_naturezasaldoinicialconscf varchar(1) NOT NULL,
    si187_totaldebitosconscf float8 NOT NULL DEFAULT 0,
    si187_totalcreditosconscf float8 NOT NULL DEFAULT 0,
    si187_saldofinalconscf float8 NOT NULL DEFAULT 0,
    si187_naturezasaldofinalconscf varchar(1) NOT NULL,
    si187_mes int8 NOT NULL DEFAULT 0,
    si187_instit int8 NULL DEFAULT 0,
    si187_reg10 int8 NOT NULL,
    CONSTRAINT balancete202021_sequ_pk PRIMARY KEY (si187_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete212021 definition

-- Drop table

-- DROP TABLE balancete212021;

CREATE TABLE balancete212021 (
    si188_sequencial int8 NOT NULL DEFAULT 0,
    si188_tiporegistro int8 NOT NULL DEFAULT 0,
    si188_contacontabil int8 NOT NULL DEFAULT 0,
    si188_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si188_cnpjconsorcio int8 NOT NULL DEFAULT 0,
    si188_codfontrecursos int8 NOT NULL DEFAULT 0,
    si188_saldoinicialconsorfr float8 NOT NULL DEFAULT 0,
    si188_naturezasaldoinicialconsorfr varchar(1) NOT NULL,
    si188_totaldebitosconsorfr float8 NOT NULL DEFAULT 0,
    si188_totalcreditosconsorfr float8 NOT NULL DEFAULT 0,
    si188_saldofinalconsorfr float8 NOT NULL DEFAULT 0,
    si188_naturezasaldofinalconsorfr varchar(1) NOT NULL,
    si188_mes int8 NOT NULL DEFAULT 0,
    si188_instit int8 NULL DEFAULT 0,
    si188_reg10 int8 NOT NULL,
    CONSTRAINT balancete212021_sequ_pk PRIMARY KEY (si188_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete222021 definition

-- Drop table

-- DROP TABLE balancete222021;

CREATE TABLE balancete222021 (
    si189_sequencial int8 NOT NULL DEFAULT 0,
    si189_tiporegistro int8 NOT NULL DEFAULT 0,
    si189_contacontabil int8 NOT NULL DEFAULT 0,
    si189_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si189_atributosf varchar(1) NOT NULL,
    si189_codctb int8 NOT NULL DEFAULT 0,
    si189_saldoinicialctbsf float8 NOT NULL DEFAULT 0,
    si189_naturezasaldoinicialctbsf varchar(1) NOT NULL,
    si189_totaldebitosctbsf float8 NOT NULL DEFAULT 0,
    si189_totalcreditosctbsf float8 NOT NULL DEFAULT 0,
    si189_saldofinalctbsf float8 NOT NULL DEFAULT 0,
    si189_naturezasaldofinalctbsf varchar(1) NOT NULL,
    si189_mes int8 NOT NULL DEFAULT 0,
    si189_instit int8 NULL DEFAULT 0,
    si189_reg10 int8 NOT NULL,
    CONSTRAINT balancete222021_sequ_pk PRIMARY KEY (si189_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete232021 definition

-- Drop table

-- DROP TABLE balancete232021;

CREATE TABLE balancete232021 (
    si190_sequencial int8 NOT NULL DEFAULT 0,
    si190_tiporegistro int8 NOT NULL DEFAULT 0,
    si190_contacontabil int8 NOT NULL DEFAULT 0,
    si190_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si190_naturezareceita int8 NOT NULL DEFAULT 0,
    si190_saldoinicialnatreceita float8 NOT NULL DEFAULT 0,
    si190_naturezasaldoinicialnatreceita varchar(1) NOT NULL,
    si190_totaldebitosnatreceita float8 NOT NULL DEFAULT 0,
    si190_totalcreditosnatreceita float8 NOT NULL DEFAULT 0,
    si190_saldofinalnatreceita float8 NOT NULL DEFAULT 0,
    si190_naturezasaldofinalnatreceita varchar(1) NOT NULL,
    si190_mes int8 NOT NULL DEFAULT 0,
    si190_instit int8 NULL DEFAULT 0,
    si190_reg10 int8 NOT NULL,
    CONSTRAINT balancete232021_sequ_pk PRIMARY KEY (si190_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete242021 definition

-- Drop table

-- DROP TABLE balancete242021;

CREATE TABLE balancete242021 (
    si191_sequencial int8 NOT NULL DEFAULT 0,
    si191_tiporegistro int8 NOT NULL DEFAULT 0,
    si191_contacontabil int8 NOT NULL DEFAULT 0,
    si191_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si191_codorgao varchar(2) NOT NULL,
    si191_codunidadesub varchar(8) NOT NULL,
    si191_saldoinicialorgao float8 NOT NULL DEFAULT 0,
    si191_naturezasaldoinicialorgao varchar(1) NOT NULL,
    si191_totaldebitosorgao float8 NOT NULL DEFAULT 0,
    si191_totalcreditosorgao float8 NOT NULL DEFAULT 0,
    si191_saldofinalorgao float8 NOT NULL DEFAULT 0,
    si191_naturezasaldofinalorgao varchar(1) NOT NULL,
    si191_mes int8 NOT NULL DEFAULT 0,
    si191_instit int8 NULL DEFAULT 0,
    si191_reg10 int8 NOT NULL,
    CONSTRAINT balancete242021_sequ_pk PRIMARY KEY (si191_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete252021 definition

-- Drop table

-- DROP TABLE balancete252021;

CREATE TABLE balancete252021 (
    si195_sequencial int8 NOT NULL DEFAULT 0,
    si195_tiporegistro int8 NOT NULL DEFAULT 0,
    si195_contacontabil int8 NOT NULL DEFAULT 0,
    si195_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si195_atributosf varchar(1) NOT NULL,
    si195_naturezareceita int8 NOT NULL DEFAULT 0,
    si195_saldoinicialnrsf float8 NOT NULL DEFAULT 0,
    si195_naturezasaldoinicialnrsf varchar(1) NOT NULL,
    si195_totaldebitosnrsf float8 NOT NULL DEFAULT 0,
    si195_totalcreditosnrsf float8 NOT NULL DEFAULT 0,
    si195_saldofinalnrsf float8 NOT NULL DEFAULT 0,
    si195_naturezasaldofinalnrsf varchar(1) NOT NULL,
    si195_mes int8 NOT NULL DEFAULT 0,
    si195_instit int8 NULL DEFAULT 0,
    si195_reg10 int8 NOT NULL,
    CONSTRAINT balancete252021_sequ_pk PRIMARY KEY (si195_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete262021 definition

-- Drop table

-- DROP TABLE balancete262021;

CREATE TABLE balancete262021 (
    si196_sequencial int8 NOT NULL DEFAULT 0,
    si196_tiporegistro int8 NOT NULL DEFAULT 0,
    si196_contacontabil int8 NOT NULL DEFAULT 0,
    si196_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si196_tipodocumentopessoaatributosf int8 NOT NULL,
    si196_nrodocumentopessoaatributosf varchar(14) NOT NULL,
    si196_atributosf varchar(1) NOT NULL,
    si196_saldoinicialpessoaatributosf float8 NOT NULL DEFAULT 0,
    si196_naturezasaldoinicialpessoaatributosf varchar(1) NOT NULL,
    si196_totaldebitospessoaatributosf float8 NOT NULL DEFAULT 0,
    si196_totalcreditospessoaatributosf float8 NOT NULL DEFAULT 0,
    si196_saldofinalpessoaatributosf float8 NOT NULL DEFAULT 0,
    si196_naturezasaldofinalpessoaatributosf varchar(1) NOT NULL,
    si196_mes int8 NOT NULL DEFAULT 0,
    si196_instit int8 NULL DEFAULT 0,
    si196_reg10 int8 NOT NULL,
    CONSTRAINT balancete262021_sequ_pk PRIMARY KEY (si196_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete272021 definition

-- Drop table

-- DROP TABLE balancete272021;

CREATE TABLE balancete272021 (
    si197_sequencial int8 NOT NULL DEFAULT 0,
    si197_tiporegistro int8 NOT NULL DEFAULT 0,
    si197_contacontabil int8 NOT NULL DEFAULT 0,
    si197_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si197_codorgao varchar(2) NOT NULL,
    si197_codunidadesub varchar(8) NOT NULL,
    si197_codfontrecursos int8 NOT NULL,
    si197_atributosf varchar(1) NOT NULL,
    si197_saldoinicialoufontesf float8 NOT NULL,
    si197_naturezasaldoinicialoufontesf varchar(1) NOT NULL,
    si197_totaldebitosoufontesf float8 NOT NULL,
    si197_totalcreditosoufontesf float8 NOT NULL,
    si197_saldofinaloufontesf float8 NOT NULL,
    si197_naturezasaldofinaloufontesf varchar(1) NOT NULL,
    si197_mes int8 NOT NULL DEFAULT 0,
    si197_instit int8 NULL DEFAULT 0,
    si197_reg10 int8 NOT NULL,
    CONSTRAINT balancete272021_sequ_pk PRIMARY KEY (si197_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete282021 definition

-- Drop table

-- DROP TABLE balancete282021;

CREATE TABLE balancete282021 (
    si198_sequencial int8 NOT NULL DEFAULT 0,
    si198_tiporegistro int8 NOT NULL DEFAULT 0,
    si198_contacontabil int8 NOT NULL DEFAULT 0,
    si198_codfundo varchar(8) NOT NULL DEFAULT '00000000'::character varying,
    si198_codctb int8 NOT NULL DEFAULT 0,
    si198_codfontrecursos int8 NOT NULL DEFAULT 0,
    si198_saldoinicialctbfonte float8 NOT NULL DEFAULT 0,
    si198_naturezasaldoinicialctbfonte varchar(1) NOT NULL,
    si198_totaldebitosctbfonte float8 NOT NULL DEFAULT 0,
    si198_totalcreditosctbfonte float8 NOT NULL DEFAULT 0,
    si198_saldofinalctbfonte float8 NOT NULL DEFAULT 0,
    si198_naturezasaldofinalctbfonte varchar(1) NOT NULL,
    si198_mes int8 NOT NULL DEFAULT 0,
    si198_instit int8 NULL DEFAULT 0,
    si198_reg10 int8 NOT NULL,
    CONSTRAINT balancete282021_sequ_pk PRIMARY KEY (si198_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete202021 foreign keys

ALTER TABLE balancete202021 ADD CONSTRAINT fk_balancete202021_reg10_fk FOREIGN KEY (si187_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete212021 foreign keys

ALTER TABLE balancete212021 ADD CONSTRAINT fk_balancete212021_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete222021 foreign keys

ALTER TABLE balancete222021 ADD CONSTRAINT fk_balancete222021_si77_sequencial FOREIGN KEY (si189_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete232021 foreign keys

ALTER TABLE balancete232021 ADD CONSTRAINT fk_balancete232021_reg10_fk FOREIGN KEY (si190_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete242021 foreign keys

ALTER TABLE balancete242021 ADD CONSTRAINT fk_balancete242021_reg10_fk FOREIGN KEY (si191_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete252021 foreign keys

ALTER TABLE balancete252021 ADD CONSTRAINT fk_balancete102021_reg10_fk FOREIGN KEY (si195_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete262021 foreign keys

ALTER TABLE balancete262021 ADD CONSTRAINT fk_balancete102021_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete272021 foreign keys

ALTER TABLE balancete272021 ADD CONSTRAINT fk_balancete272021_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES balancete102021(si177_sequencial);


-- balancete282021 foreign keys

ALTER TABLE balancete282021 ADD CONSTRAINT fk_balancete282021_reg10_fk FOREIGN KEY (si198_reg10) REFERENCES balancete102021(si177_sequencial);

-- balancete102021_si177_sequencial_seq definition

-- DROP SEQUENCE balancete102021_si177_sequencial_seq;

CREATE SEQUENCE balancete102021_si177_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete112021_si178_sequencial_seq definition

-- DROP SEQUENCE balancete112021_si178_sequencial_seq;

CREATE SEQUENCE balancete112021_si178_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete122021_si179_sequencial_seq definition

-- DROP SEQUENCE balancete122021_si179_sequencial_seq;

CREATE SEQUENCE balancete122021_si179_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete132021_si180_sequencial_seq definition

-- DROP SEQUENCE balancete132021_si180_sequencial_seq;

CREATE SEQUENCE balancete132021_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete142021_si181_sequencial_seq definition

-- DROP SEQUENCE balancete142021_si181_sequencial_seq;

CREATE SEQUENCE balancete142021_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete152021_si182_sequencial_seq definition

-- DROP SEQUENCE balancete152021_si182_sequencial_seq;

CREATE SEQUENCE balancete152021_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete162021_si183_sequencial_seq definition

-- DROP SEQUENCE balancete162021_si183_sequencial_seq;

CREATE SEQUENCE balancete162021_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete172021_si184_sequencial_seq definition

-- DROP SEQUENCE balancete172021_si184_sequencial_seq;

CREATE SEQUENCE balancete172021_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete182021_si185_sequencial_seq definition

-- DROP SEQUENCE balancete182021_si185_sequencial_seq;

CREATE SEQUENCE balancete182021_si185_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete182021_si186_sequencial_seq definition

-- DROP SEQUENCE balancete182021_si186_sequencial_seq;

CREATE SEQUENCE balancete182021_si186_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete192021_si186_sequencial_seq definition

-- DROP SEQUENCE balancete192021_si186_sequencial_seq;

CREATE SEQUENCE balancete192021_si186_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete202021_si187_sequencial_seq definition

-- DROP SEQUENCE balancete202021_si187_sequencial_seq;

CREATE SEQUENCE balancete202021_si187_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete212021_si188_sequencial_seq definition

-- DROP SEQUENCE balancete212021_si188_sequencial_seq;

CREATE SEQUENCE balancete212021_si188_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete222021_si189_sequencial_seq definition

-- DROP SEQUENCE balancete222021_si189_sequencial_seq;

CREATE SEQUENCE balancete222021_si189_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete232021_si190_sequencial_seq definition

-- DROP SEQUENCE balancete232021_si190_sequencial_seq;

CREATE SEQUENCE balancete232021_si190_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete242021_si191_sequencial_seq definition

-- DROP SEQUENCE balancete242021_si191_sequencial_seq;

CREATE SEQUENCE balancete242021_si191_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete252021_si195_sequencial_seq definition

-- DROP SEQUENCE balancete252021_si195_sequencial_seq;

CREATE SEQUENCE balancete252021_si195_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete262021_si196_sequencial_seq definition

-- DROP SEQUENCE balancete262021_si196_sequencial_seq;

CREATE SEQUENCE balancete262021_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete272021_si197_sequencial_seq definition

-- DROP SEQUENCE balancete272021_si197_sequencial_seq;

CREATE SEQUENCE balancete272021_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete282021_si198_sequencial_seq definition

-- DROP SEQUENCE balancete282021_si198_sequencial_seq;

CREATE SEQUENCE balancete282021_si198_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic102021 definition

-- Drop table

-- DROP TABLE ralic102021;

CREATE TABLE ralic102021 (
    si180_sequencial int8 NOT NULL DEFAULT 0,
    si180_tiporegistro int8 NOT NULL DEFAULT 0,
    si180_codorgaoresp varchar(3) NOT NULL,
    si180_codunidadesubresp varchar(8) NOT NULL,
    si180_codunidadesubrespestadual varchar(4) NULL,
    si180_exerciciolicitacao int2 NOT NULL,
    si180_nroprocessolicitatorio varchar(12) NOT NULL,
    si180_tipocadastradolicitacao bpchar(1) NOT NULL,
    si180_dsccadastrolicitatorio varchar(150) NULL,
    si180_codmodalidadelicitacao int2 NOT NULL,
    si180_naturezaprocedimento int2 NOT NULL,
    si180_nroedital int4 NOT NULL,
    si180_exercicioedital int2 NOT NULL DEFAULT 0,
    si180_dtpublicacaoeditaldo date NULL,
    si180_link varchar(200) NOT NULL,
    si180_tipolicitacao int2 NULL,
    si180_naturezaobjeto int2 NULL,
    si180_objeto varchar(500) NOT NULL,
    si180_regimeexecucaoobras int2 NULL,
    si180_vlcontratacao float4 NOT NULL,
    si180_bdi float4 NULL,
    si180_mesexercicioreforc int4 NULL,
    si180_origemrecurso int2 NOT NULL,
    si180_dscorigemrecurso varchar(150) NULL,
    si180_mes int8 NOT NULL DEFAULT 0,
    si180_instit int8 NULL DEFAULT 0,
    CONSTRAINT ralic102021_sequ_pk PRIMARY KEY (si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- redispi102021 definition

-- Drop table

-- DROP TABLE redispi102021;

CREATE TABLE redispi102021 (
    si183_sequencial int8 NOT NULL DEFAULT 0,
    si183_tiporegistro int8 NOT NULL DEFAULT 0,
    si183_codorgaoresp varchar(3) NOT NULL,
    si183_codunidadesubresp varchar(8) NULL,
    si183_codunidadesubrespestadual bpchar(4) NULL,
    si183_exercicioprocesso int2 NOT NULL,
    si183_nroprocesso varchar(12) NOT NULL,
    si183_tipoprocesso int2 NOT NULL,
    si183_tipocadastradodispensainexigibilidade int2 NOT NULL,
    si183_dsccadastrolicitatorio varchar(150) NULL,
    si183_dtabertura date NOT NULL,
    si183_naturezaobjeto int2 NOT NULL,
    si183_objeto varchar(500) NOT NULL,
    si183_justificativa varchar(250) NOT NULL,
    si183_razao varchar(250) NOT NULL,
    si183_vlrecurso float4 NOT NULL,
    si183_bdi float4 NULL,
    si183_mes int8 NOT NULL DEFAULT 0,
    si183_instit int8 NULL DEFAULT 0,
    CONSTRAINT redispi102021_sequ_pk PRIMARY KEY (si183_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ralic112021 definition

-- Drop table

-- DROP TABLE ralic112021;

CREATE TABLE ralic112021 (
    si181_sequencial int8 NOT NULL DEFAULT 0,
    si181_tiporegistro int8 NOT NULL DEFAULT 0,
    si181_codorgaoresp bpchar(3) NOT NULL,
    si181_codunidadesubresp varchar(8) NULL,
    si181_codunidadesubrespestadual bpchar(4) NULL,
    si181_exerciciolicitacao int2 NOT NULL,
    si181_nroprocessolicitatorio varchar(12) NOT NULL,
    si181_codobralocal int8 NULL,
    si181_classeobjeto int2 NOT NULL,
    si181_tipoatividadeobra int2 NULL,
    si181_tipoatividadeservico int2 NULL,
    si181_dscatividadeservico varchar(150) NULL,
    si181_tipoatividadeservespecializado int2 NULL,
    si181_dscatividadeservespecializado varchar(150) NULL,
    si181_codfuncao bpchar(2) NOT NULL,
    si181_codsubfuncao bpchar(3) NOT NULL,
    si181_codbempublico int2 NULL,
    si181_reg10 int8 NOT NULL DEFAULT 0,
    si181_mes int8 NOT NULL DEFAULT 0,
    si181_instit int8 NULL DEFAULT 0,
    CONSTRAINT ralic112021_sequ_pk PRIMARY KEY (si181_sequencial),
    CONSTRAINT ralic112021_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES ralic102021(si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ralic122021 definition

-- Drop table

-- DROP TABLE ralic122021;

CREATE TABLE ralic122021 (
    si182_sequencial int8 NOT NULL DEFAULT 0,
    si182_tiporegistro int8 NOT NULL DEFAULT 0,
    si182_codorgaoresp varchar(3) NOT NULL,
    si182_codunidadesubresp varchar(8) NULL,
    si182_codunidadesubrespestadual bpchar(4) NULL,
    si182_exercicioprocesso int2 NOT NULL DEFAULT 0,
    si182_nroprocessolicitatorio varchar(12) NOT NULL,
    si182_codobralocal int8 NULL,
    si182_logradouro varchar(100) NOT NULL,
    si182_numero int2 NOT NULL,
    si182_bairro varchar(100) NULL,
    si182_distrito varchar(100) NULL,
    si182_municipio varchar(50) NOT NULL,
    si182_cep int8 NOT NULL,
    si182_graulatitude int2 NOT NULL,
    si182_minutolatitude int2 NOT NULL,
    si182_segundolatitude numeric NOT NULL,
    si182_graulongitude int2 NOT NULL,
    si182_minutolongitude int2 NOT NULL,
    si182_segundolongitude numeric NOT NULL,
    si182_reg10 int8 NOT NULL DEFAULT 0,
    si182_mes int8 NOT NULL DEFAULT 0,
    si182_instit int8 NULL DEFAULT 0,
    CONSTRAINT ralic122021_sequ_pk PRIMARY KEY (si182_sequencial),
    CONSTRAINT ralic122021_reg10_fk FOREIGN KEY (si182_reg10) REFERENCES ralic102021(si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- redispi112021 definition

-- Drop table

-- DROP TABLE redispi112021;

CREATE TABLE redispi112021 (
    si184_sequencial int8 NOT NULL DEFAULT 0,
    si184_tiporegistro int8 NOT NULL DEFAULT 0,
    si184_codorgaoresp varchar(3) NOT NULL,
    si184_codunidadesubresp varchar(8) NULL,
    si184_codunidadesubrespestadual varchar(4) NULL,
    si184_exercicioprocesso int2 NOT NULL,
    si184_nroprocesso varchar(12) NOT NULL,
    si184_codobralocal int8 NULL,
    si184_tipoprocesso int2 NOT NULL,
    si184_classeobjeto int2 NOT NULL,
    si184_tipoatividadeobra int2 NULL,
    si184_tipoatividadeservico int2 NULL,
    si184_dscatividadeservico varchar(150) NULL,
    si184_tipoatividadeservespecializado int2 NULL,
    si184_dscatividadeservespecializado varchar(150) NULL,
    si184_codfuncao bpchar(2) NOT NULL,
    si184_codsubfuncao bpchar(3) NOT NULL,
    si184_codbempublico int2 NOT NULL,
    si184_reg10 int8 NOT NULL DEFAULT 0,
    si184_mes int8 NOT NULL DEFAULT 0,
    si184_instit int8 NULL DEFAULT 0,
    CONSTRAINT redispi112021_sequ_pk PRIMARY KEY (si184_sequencial),
    CONSTRAINT redispi112021_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES redispi102021(si183_sequencial)
)
WITH (
    OIDS=TRUE
);


-- redispi122021 definition

-- Drop table

-- DROP TABLE redispi122021;

CREATE TABLE redispi122021 (
    si185_sequencial int8 NOT NULL DEFAULT 0,
    si185_tiporegistro int8 NOT NULL DEFAULT 0,
    si185_codorgaoresp bpchar(3) NOT NULL,
    si185_codunidadesubresp varchar(8) NULL,
    si185_codunidadesubrespestadual varchar(4) NULL,
    si185_exercicioprocesso int2 NOT NULL DEFAULT 0,
    si185_nroprocesso bpchar(12) NOT NULL,
    si185_codobralocal int8 NULL,
    si185_logradouro varchar(100) NOT NULL,
    si185_numero int2 NULL,
    si185_bairro varchar(100) NULL,
    si185_distrito varchar(100) NULL,
    si185_cidade varchar(100) NOT NULL,
    si185_cep bpchar(8) NOT NULL,
    si185_graulatitude int2 NOT NULL,
    si185_minutolatitude int2 NOT NULL,
    si185_segundolatitude float4 NOT NULL,
    si185_graulongitude int2 NOT NULL,
    si185_minutolongitude int2 NOT NULL,
    si185_segundolongitude float4 NOT NULL,
    si185_reg10 int8 NOT NULL DEFAULT 0,
    si185_mes int8 NOT NULL DEFAULT 0,
    si185_instit int8 NULL DEFAULT 0,
    CONSTRAINT redispi122021_sequ_pk PRIMARY KEY (si185_sequencial),
    CONSTRAINT redispi122021_reg10_fk FOREIGN KEY (si185_reg10) REFERENCES redispi102021(si183_sequencial)
)
WITH (
    OIDS=TRUE
);

-- ralic102021_si180_sequencial_seq definition

-- DROP SEQUENCE ralic102021_si180_sequencial_seq;

CREATE SEQUENCE ralic102021_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic112021_si181_sequencial_seq definition

-- DROP SEQUENCE ralic112021_si181_sequencial_seq;

CREATE SEQUENCE ralic112021_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic122021_si182_sequencial_seq definition

-- DROP SEQUENCE ralic122021_si182_sequencial_seq;

CREATE SEQUENCE ralic122021_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi102021_si183_sequencial_seq definition

-- DROP SEQUENCE redispi102021_si183_sequencial_seq;

CREATE SEQUENCE redispi102021_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi112021_si184_sequencial_seq definition

-- DROP SEQUENCE redispi112021_si184_sequencial_seq;

CREATE SEQUENCE redispi112021_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi122021_si185_sequencial_seq definition

-- DROP SEQUENCE redispi122021_si185_sequencial_seq;

CREATE SEQUENCE redispi122021_si185_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- afast102021 definition

-- Drop table

-- DROP TABLE afast102021;

CREATE TABLE afast102021 (
    si199_sequencial int4 NOT NULL DEFAULT 0,
    si199_tiporegistro int4 NOT NULL DEFAULT 0,
    si199_codvinculopessoa int4 NOT NULL DEFAULT 0,
    si199_codafastamento int8 NOT NULL DEFAULT 0,
    si199_dtinicioafastamento date NOT NULL,
    si199_dtretornoafastamento date NOT NULL,
    si199_tipoafastamento int4 NOT NULL DEFAULT 0,
    si199_dscoutrosafastamentos varchar(500) NULL,
    si199_mes int4 NOT NULL DEFAULT 0,
    si199_inst int4 NULL DEFAULT 0,
    CONSTRAINT afast102021_sequ_pk PRIMARY KEY (si199_sequencial)
)
WITH (
    OIDS=TRUE
);


-- afast202021 definition

-- Drop table

-- DROP TABLE afast202021;

CREATE TABLE afast202021 (
    si200_sequencial int4 NOT NULL DEFAULT 0,
    si200_tiporegistro int4 NOT NULL DEFAULT 0,
    si200_codvinculopessoa int4 NOT NULL DEFAULT 0,
    si200_codafastamento int8 NOT NULL DEFAULT 0,
    si200_dtterminoafastamento date NOT NULL,
    si200_mes int4 NOT NULL DEFAULT 0,
    si200_inst int4 NULL DEFAULT 0,
    CONSTRAINT afast202021_sequ_pk PRIMARY KEY (si200_sequencial)
)
WITH (
    OIDS=TRUE
);


-- afast302021 definition

-- Drop table

-- DROP TABLE afast302021;

CREATE TABLE afast302021 (
    si201_sequencial int4 NOT NULL DEFAULT 0,
    si201_tiporegistro int4 NOT NULL DEFAULT 0,
    si201_codvinculopessoa int4 NOT NULL DEFAULT 0,
    si201_codafastamento int8 NOT NULL DEFAULT 0,
    si201_dtretornoafastamento date NOT NULL,
    si201_mes int4 NOT NULL DEFAULT 0,
    si201_inst int4 NULL DEFAULT 0,
    CONSTRAINT afast302021_sequ_pk PRIMARY KEY (si201_sequencial)
)
WITH (
    OIDS=TRUE
);


-- flpgo102021 definition

-- Drop table

-- DROP TABLE flpgo102021;

CREATE TABLE flpgo102021 (
    si195_sequencial int8 NOT NULL DEFAULT 0,
    si195_tiporegistro int8 NULL,
    si195_codvinculopessoa int8 NULL,
    si195_regime varchar(1) NULL,
    si195_indtipopagamento varchar(1) NULL,
    si195_dsctipopagextra varchar(150) NULL,
    si195_indsituacaoservidorpensionista varchar(1) NULL,
    si195_dscsituacao varchar(150) NULL,
    si195_indpensionistaprevidenciario int4 NULL,
    si195_nrocpfinstituidor varchar(11) NULL,
    si195_datobitoinstituidor date NULL,
    si195_tipodependencia int8 NULL,
    si195_dscdependencia varchar(150) NULL,
    si195_datafastpreliminar date NULL,
    si195_datconcessaoaposentadoriapensao date NULL,
    si195_dsccargo varchar(120) NULL,
    si195_codcargo int8 NULL,
    si195_sglcargo varchar(3) NULL,
    si195_dscsiglacargo varchar(150) NULL,
    si195_dscapo varchar(3) NULL,
    si195_natcargo int4 NULL,
    si195_dscnatcargo varchar(150) NULL,
    si195_indcessao varchar(3) NULL,
    si195_dsclotacao varchar(250) NULL,
    si195_indsalaaula varchar(1) NULL,
    si195_vlrcargahorariasemanal int8 NULL,
    si195_datefetexercicio date NULL,
    si195_datcomissionado date NULL,
    si195_datexclusao date NULL,
    si195_datcomissionadoexclusao date NULL,
    si195_vlrremuneracaobruta float8 NULL,
    si195_vlrdescontos float8 NULL,
    si195_vlrremuneracaoliquida float8 NULL,
    si195_natsaldoliquido varchar(1) NULL,
    si195_mes int8 NULL,
    si195_inst int8 NULL,
    CONSTRAINT flpgo102021_sequ_pk PRIMARY KEY (si195_sequencial)
)
WITH (
    OIDS=TRUE
);


-- respinf2021 definition

-- Drop table

-- DROP TABLE respinf2021;

CREATE TABLE respinf2021 (
    si197_sequencial int8 NOT NULL DEFAULT 0,
    si197_nrodocumento varchar(11) NOT NULL,
    si197_dtinicio date NULL,
    si197_dtfinal date NULL,
    si197_mes int8 NULL,
    si197_instit int8 NULL,
    CONSTRAINT respinf2021_sequ_pk PRIMARY KEY (si197_sequencial)
)
WITH (
    OIDS=TRUE
);


-- terem102021 definition

-- Drop table

-- DROP TABLE terem102021;

CREATE TABLE terem102021 (
    si194_sequencial int8 NOT NULL DEFAULT 0,
    si194_tiporegistro int8 NOT NULL DEFAULT 0,
    si194_cnpj varchar(14) NULL,
    si194_codteto int8 NULL DEFAULT 0,
    si194_vlrparateto float8 NOT NULL DEFAULT 0,
    si194_tipocadastro int8 NOT NULL DEFAULT 0,
    si194_dtinicial date NOT NULL,
    si194_nrleiteto int8 NOT NULL DEFAULT 0,
    si194_dtpublicacaolei date NOT NULL,
    si194_dtfinal date NULL,
    si194_justalteracao varchar(250) NULL,
    si194_mes int8 NOT NULL DEFAULT 0,
    si194_inst int8 NULL DEFAULT 0,
    CONSTRAINT terem102021_sequ_pk PRIMARY KEY (si194_sequencial)
)
WITH (
    OIDS=TRUE
);


-- terem202021 definition

-- Drop table

-- DROP TABLE terem202021;

CREATE TABLE terem202021 (
    si196_sequencial int8 NOT NULL DEFAULT 0,
    si196_tiporegistro int8 NOT NULL DEFAULT 0,
    si196_codteto int8 NOT NULL DEFAULT 0,
    si196_vlrparateto float8 NOT NULL DEFAULT 0,
    si196_nrleiteto int8 NOT NULL DEFAULT 0,
    si196_dtpublicacaolei date NOT NULL,
    si196_justalteracaoteto varchar(250) NULL,
    si196_mes int8 NOT NULL DEFAULT 0,
    si196_inst int8 NULL DEFAULT 0,
    CONSTRAINT terem202021_sequ_pk PRIMARY KEY (si196_sequencial)
)
WITH (
    OIDS=TRUE
);


-- viap102021 definition

-- Drop table

-- DROP TABLE viap102021;

CREATE TABLE viap102021 (
    si198_sequencial int4 NOT NULL DEFAULT 0,
    si198_tiporegistro int4 NOT NULL DEFAULT 0,
    si198_nrocpfagentepublico varchar(11) NOT NULL,
    si198_codmatriculapessoa int4 NOT NULL DEFAULT 0,
    si198_codvinculopessoa int4 NOT NULL DEFAULT 0,
    si198_mes int4 NOT NULL DEFAULT 0,
    si198_instit int4 NULL DEFAULT 0,
    CONSTRAINT viap102021_sequ_pk PRIMARY KEY (si198_sequencial)
)
WITH (
    OIDS=TRUE
);


-- flpgo112021 definition

-- Drop table

-- DROP TABLE flpgo112021;

CREATE TABLE flpgo112021 (
    si196_sequencial int8 NOT NULL DEFAULT 0,
    si196_tiporegistro int8 NULL,
    si196_indtipopagamento varchar(1) NULL,
    si196_codvinculopessoa varchar(15) NULL,
    si196_codrubricaremuneracao varchar(4) NULL,
    si196_desctiporubrica varchar(150) NULL,
    si196_vlrremuneracaodetalhada float8 NULL,
    si196_reg10 int8 NULL DEFAULT 0,
    si196_mes int8 NULL,
    si196_inst int8 NULL,
    CONSTRAINT flpgo112021_sequ_pk PRIMARY KEY (si196_sequencial),
    CONSTRAINT flpgo112021_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES flpgo102021(si195_sequencial)
)
WITH (
    OIDS=TRUE
);


-- flpgo122021 definition

-- Drop table

-- DROP TABLE flpgo122021;

CREATE TABLE flpgo122021 (
    si197_sequencial int8 NOT NULL DEFAULT 0,
    si197_tiporegistro int8 NULL,
    si197_indtipopagamento varchar(1) NULL,
    si197_codvinculopessoa varchar(15) NULL,
    si197_codrubricadesconto varchar(4) NULL,
    si197_desctiporubricadesconto varchar(150) NULL,
    si197_vlrdescontodetalhado float8 NULL,
    si197_reg10 int8 NULL DEFAULT 0,
    si197_mes int8 NULL,
    si197_inst int8 NULL,
    CONSTRAINT flpgo122021_sequ_pk PRIMARY KEY (si197_sequencial),
    CONSTRAINT flpgo122021_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES flpgo102021(si195_sequencial)
)
WITH (
    OIDS=TRUE
);

-- afast102021_si199_sequencial_seq definition

-- DROP SEQUENCE afast102021_si199_sequencial_seq;

CREATE SEQUENCE afast102021_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- afast202021_si200_sequencial_seq definition

-- DROP SEQUENCE afast202021_si200_sequencial_seq;

CREATE SEQUENCE afast202021_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- afast302021_si201_sequencial_seq definition

-- DROP SEQUENCE afast302021_si201_sequencial_seq;

CREATE SEQUENCE afast302021_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- flpgo102021_si195_sequencial_seq definition

-- DROP SEQUENCE flpgo102021_si195_sequencial_seq;

CREATE SEQUENCE flpgo102021_si195_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- flpgo112021_si196_sequencial_seq definition

-- DROP SEQUENCE flpgo112021_si196_sequencial_seq;

CREATE SEQUENCE flpgo112021_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- flpgo122021_si197_sequencial_seq definition

-- DROP SEQUENCE flpgo122021_si197_sequencial_seq;

CREATE SEQUENCE flpgo122021_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- respinf2021_si197_sequencial_seq definition

-- DROP SEQUENCE respinf2021_si197_sequencial_seq;

CREATE SEQUENCE respinf2021_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- terem102021_si194_sequencial_seq definition

-- DROP SEQUENCE terem102021_si194_sequencial_seq;

CREATE SEQUENCE terem102021_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- terem202021_si196_sequencial_seq definition

-- DROP SEQUENCE terem202021_si196_sequencial_seq;

CREATE SEQUENCE terem202021_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- viap102021_si198_sequencial_seq definition

-- DROP SEQUENCE viap102021_si198_sequencial_seq;

CREATE SEQUENCE viap102021_si198_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cadobras102021 definition

-- Drop table

-- DROP TABLE cadobras102021;

CREATE TABLE cadobras102021 (
    si198_sequencial int8 NULL,
    si198_tiporegistro int8 NULL,
    si198_codorgaoresp varchar(3) NULL,
    si198_codobra int8 NULL,
    si198_tiporesponsavel int8 NULL,
    si198_nrodocumento varchar(14) NULL,
    si198_tiporegistroconselho int8 NULL,
    si198_nroregistroconseprof varchar(10) NULL,
    si198_numrt int8 NULL DEFAULT 0,
    si198_dtinicioatividadeseng date NULL,
    si198_tipovinculo int8 NULL,
    si198_mes int8 NULL,
    si198_instit int4 NULL
)
WITH (
    OIDS=TRUE
);


-- cadobras202021 definition

-- Drop table

-- DROP TABLE cadobras202021;

CREATE TABLE cadobras202021 (
    si199_sequencial int8 NULL,
    si199_tiporegistro int8 NULL,
    si199_codorgaoresp varchar(3) NULL,
    si199_codobra int8 NULL,
    si199_situacaodaobra int8 NULL,
    si199_dtsituacao date NULL,
    si199_veiculopublicacao varchar(50) NULL,
    si199_dtpublicacao date NULL,
    si199_descsituacao varchar(500) NULL,
    si199_mes int8 NULL,
    si199_instit int4 NULL
)
WITH (
    OIDS=TRUE
);


-- cadobras212021 definition

-- Drop table

-- DROP TABLE cadobras212021;

CREATE TABLE cadobras212021 (
    si200_sequencial int8 NULL,
    si200_tiporegistro int8 NULL,
    si200_codorgaoresp varchar(3) NULL,
    si200_codobra int8 NULL,
    si200_dtparalisacao date NULL,
    si200_motivoparalisacap int8 NULL,
    si200_descoutrosparalisacao varchar(150) NULL,
    si200_dtretomada date NULL,
    si200_mes int8 NULL,
    si200_instit int4 NULL
)
WITH (
    OIDS=TRUE
);


-- cadobras302021 definition

-- Drop table

-- DROP TABLE cadobras302021;

CREATE TABLE cadobras302021 (
    si201_sequencial int8 NULL,
    si201_tiporegistro int8 NULL,
    si201_codorgaoresp varchar(3) NULL,
    si201_codobra int8 NULL,
    si201_tipomedicao int8 NULL,
    si201_descoutrostiposmed varchar(500) NULL,
    si201_nummedicao varchar(20) NULL,
    si201_descmedicao varchar(500) NULL,
    si201_dtiniciomedicao date NULL,
    si201_dtfimmedicao date NULL,
    si201_dtmedicao date NULL,
    si201_valormedicao float8 NULL,
    si201_mes int8 NULL,
    si201_pdf varchar(25) NULL,
    si201_instit int4 NULL
)
WITH (
    OIDS=TRUE
);


-- exeobras102021 definition

-- Drop table

-- DROP TABLE exeobras102021;

CREATE TABLE exeobras102021 (
    si197_sequencial int8 NULL,
    si197_tiporegistro int8 NULL,
    si197_codorgao varchar(3) NULL,
    si197_codunidadesub varchar(8) NULL,
    si197_nrocontrato int8 NULL,
    si197_exerciciolicitacao int8 NULL,
    si197_codobra int8 NULL,
    si197_objeto text NULL,
    si197_linkobra text NULL,
    si197_mes int8 NULL,
    si197_instit int4 NULL
)
WITH (
    OIDS=TRUE
);


-- licobras102021 definition

-- Drop table

-- DROP TABLE licobras102021;

CREATE TABLE licobras102021 (
    si195_sequencial int8 NULL,
    si195_tiporegistro int8 NULL,
    si195_codorgaoresp varchar(3) NULL,
    si195_codunidadesubrespestadual varchar(4) NULL,
    si195_exerciciolicitacao int8 NULL,
    si195_nroprocessolicitatorio varchar(12) NULL,
    si195_codobra int8 NULL,
    si195_objeto text NULL,
    si195_linkobra text NULL,
    si195_mes int8 NULL,
    si195_instit int4 NULL
)
WITH (
    OIDS=TRUE
);


-- licobras202021 definition

-- Drop table

-- DROP TABLE licobras202021;

CREATE TABLE licobras202021 (
    si196_sequencial int8 NULL,
    si196_tiporegistro int8 NULL,
    si196_codorgaoresp varchar(3) NULL,
    si196_codunidadesubrespestadual varchar(4) NULL,
    si196_exerciciolicitacao int8 NULL,
    si196_nroprocessolicitatorio varchar(12) NULL,
    si196_tipoprocesso int4 NULL,
    si196_codobra int8 NULL,
    si196_objeto text NULL,
    si196_linkobra text NULL,
    si196_mes int8 NULL,
    si196_instit int4 NULL
)
WITH (
    OIDS=TRUE
);

-- cadobras102021_si198_sequencial_seq definition

-- DROP SEQUENCE cadobras102021_si198_sequencial_seq;

CREATE SEQUENCE cadobras102021_si198_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras202021_si199_sequencial_seq definition

-- DROP SEQUENCE cadobras202021_si199_sequencial_seq;

CREATE SEQUENCE cadobras202021_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras212021_si200_sequencial_seq definition

-- DROP SEQUENCE cadobras212021_si200_sequencial_seq;

CREATE SEQUENCE cadobras212021_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras302021_si201_sequencial_seq definition

-- DROP SEQUENCE cadobras302021_si201_sequencial_seq;

CREATE SEQUENCE cadobras302021_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- exeobras102021_si197_sequencial_seq definition

-- DROP SEQUENCE exeobras102021_si197_sequencial_seq;

CREATE SEQUENCE exeobras102021_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- licobras102021_si195_sequencial_seq definition

-- DROP SEQUENCE licobras102021_si195_sequencial_seq;

CREATE SEQUENCE licobras102021_si195_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- licobras202021_si196_sequencial_seq definition

-- DROP SEQUENCE licobras202021_si196_sequencial_seq;

CREATE SEQUENCE licobras202021_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

SQL;
      $this->execute($sql);
    }
}
