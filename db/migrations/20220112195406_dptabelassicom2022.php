<?php

use Phinx\Migration\AbstractMigration;

class Dptabelassicom2022 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL


-- aberlic102022 definition

-- Drop table

-- DROP TABLE aberlic102022;

CREATE TABLE aberlic102022 (
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
    CONSTRAINT aberlic102022_sequ_pk PRIMARY KEY (si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aex102022 definition

-- Drop table

-- DROP TABLE aex102022;

CREATE TABLE aex102022 (
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
    CONSTRAINT aex112022_sequ_pk PRIMARY KEY (si130_sequencial)
)
WITH (
    OIDS=TRUE
);


-- alq102022 definition

-- Drop table

-- DROP TABLE alq102022;

CREATE TABLE alq102022 (
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
    CONSTRAINT alq102022_sequ_pk PRIMARY KEY (si121_sequencial)
)
WITH (
    OIDS=TRUE
);


-- anl102022 definition

-- Drop table

-- DROP TABLE anl102022;

CREATE TABLE anl102022 (
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
    CONSTRAINT anl102022_sequ_pk PRIMARY KEY (si110_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aob102022 definition

-- Drop table

-- DROP TABLE aob102022;

CREATE TABLE aob102022 (
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
    CONSTRAINT aob102022_sequ_pk PRIMARY KEY (si141_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aoc102022 definition

-- Drop table

-- DROP TABLE aoc102022;

CREATE TABLE aoc102022 (
    si38_sequencial int8 NOT NULL DEFAULT 0,
    si38_tiporegistro int8 NOT NULL DEFAULT 0,
    si38_codorgao varchar(2) NOT NULL,
    si38_nrodecreto varchar(8) NOT NULL DEFAULT 0,
    si38_datadecreto date NOT NULL,
    si38_mes int8 NOT NULL DEFAULT 0,
    si38_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc102022_sequ_pk PRIMARY KEY (si38_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aop102022 definition

-- Drop table

-- DROP TABLE aop102022;

CREATE TABLE aop102022 (
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
    CONSTRAINT aop102022_sequ_pk PRIMARY KEY (si137_sequencial)
)
WITH (
    OIDS=TRUE
);


-- arc102022 definition

-- Drop table

-- DROP TABLE arc102022;

CREATE TABLE arc102022 (
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
    CONSTRAINT arc102022_sequ_pk PRIMARY KEY (si28_sequencial)
)
WITH (
    OIDS=TRUE
);


-- arc202022 definition

-- Drop table

-- DROP TABLE arc202022;

CREATE TABLE arc202022 (
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
    CONSTRAINT arc202022_sequ_pk PRIMARY KEY (si31_sequencial)
)
WITH (
    OIDS=TRUE
);


-- caixa102022 definition

-- Drop table

-- DROP TABLE caixa102022;

CREATE TABLE caixa102022 (
    si103_sequencial int8 NOT NULL DEFAULT 0,
    si103_tiporegistro int8 NOT NULL DEFAULT 0,
    si103_codorgao varchar(2) NOT NULL,
    si103_vlsaldoinicial float8 NOT NULL DEFAULT 0,
    si103_vlsaldofinal float8 NOT NULL DEFAULT 0,
    si103_mes int8 NOT NULL DEFAULT 0,
    si103_instit int8 NULL DEFAULT 0,
    CONSTRAINT caixa102022_sequ_pk PRIMARY KEY (si103_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge102022 definition

-- Drop table

-- DROP TABLE conge102022;

CREATE TABLE conge102022 (
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
    CONSTRAINT conge102022_sequ_pk PRIMARY KEY (si182_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge202022 definition

-- Drop table

-- DROP TABLE conge202022;

CREATE TABLE conge202022 (
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
    CONSTRAINT conge202022_sequ_pk PRIMARY KEY (si183_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge302022 definition

-- Drop table

-- DROP TABLE conge302022;

CREATE TABLE conge302022 (
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
    CONSTRAINT conge302022_sequ_pk PRIMARY KEY (si184_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conge402022 definition

-- Drop table

-- DROP TABLE conge402022;

CREATE TABLE conge402022 (
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


-- conge502022 definition

-- Drop table

-- DROP TABLE conge502022;

CREATE TABLE conge502022 (
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


-- consid102022 definition

-- Drop table

-- DROP TABLE consid102022;

CREATE TABLE consid102022 (
    si158_sequencial int8 NOT NULL DEFAULT 0,
    si158_tiporegistro int8 NOT NULL DEFAULT 0,
    si158_codarquivo varchar(20) NOT NULL,
    si158_exercicioreferenciaconsid int8 NULL DEFAULT 0,
    si158_mesreferenciaconsid varchar(2) NULL,
    si158_consideracoes varchar(4000) NOT NULL,
    si158_mes int8 NULL,
    si158_instit int8 NULL,
    CONSTRAINT consid102022_sequ_pk PRIMARY KEY (si158_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor102022 definition

-- Drop table

-- DROP TABLE consor102022;

CREATE TABLE consor102022 (
    si16_sequencial int8 NOT NULL DEFAULT 0,
    si16_tiporegistro int8 NOT NULL DEFAULT 0,
    si16_codorgao varchar(2) NOT NULL,
    si16_cnpjconsorcio varchar(14) NOT NULL,
    si16_areaatuacao varchar(2) NOT NULL,
    si16_descareaatuacao varchar(150) NULL,
    si16_mes int8 NOT NULL DEFAULT 0,
    si16_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor102022_sequ_pk PRIMARY KEY (si16_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor202022 definition

-- Drop table

-- DROP TABLE consor202022;

CREATE TABLE consor202022 (
    si17_sequencial int8 NOT NULL DEFAULT 0,
    si17_tiporegistro int8 NOT NULL DEFAULT 0,
    si17_codorgao varchar(2) NOT NULL,
    si17_cnpjconsorcio varchar(14) NOT NULL,
    si17_codfontrecursos int8 NOT NULL DEFAULT 0,
    si17_vltransfrateio float8 NOT NULL DEFAULT 0,
    si17_prestcontas int8 NOT NULL DEFAULT 0,
    si17_mes int8 NOT NULL DEFAULT 0,
    si17_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor202022_sequ_pk PRIMARY KEY (si17_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor302022 definition

-- Drop table

-- DROP TABLE consor302022;

CREATE TABLE consor302022 (
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
    CONSTRAINT consor302022_sequ_pk PRIMARY KEY (si18_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor402022 definition

-- Drop table

-- DROP TABLE consor402022;

CREATE TABLE consor402022 (
    si19_sequencial int8 NOT NULL DEFAULT 0,
    si19_tiporegistro int8 NOT NULL DEFAULT 0,
    si19_cnpjconsorcio varchar(14) NOT NULL,
    si19_codfontrecursos int8 NOT NULL DEFAULT 0,
    si19_vldispcaixa float8 NOT NULL DEFAULT 0,
    si19_mes int8 NOT NULL DEFAULT 0,
    si19_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor402022_sequ_pk PRIMARY KEY (si19_sequencial)
)
WITH (
    OIDS=TRUE
);


-- consor502022 definition

-- Drop table

-- DROP TABLE consor502022;

CREATE TABLE consor502022 (
    si20_sequencial int8 NOT NULL DEFAULT 0,
    si20_tiporegistro int8 NOT NULL DEFAULT 0,
    si20_codorgao varchar(2) NOT NULL,
    si20_cnpjconsorcio varchar(14) NOT NULL,
    si20_tipoencerramento int8 NOT NULL DEFAULT 0,
    si20_dtencerramento date NOT NULL,
    si20_mes int8 NOT NULL DEFAULT 0,
    si20_instit int8 NULL DEFAULT 0,
    CONSTRAINT consor502022_sequ_pk PRIMARY KEY (si20_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos102022 definition

-- Drop table

-- DROP TABLE contratos102022;

CREATE TABLE contratos102022 (
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
    CONSTRAINT contratos102022_sequ_pk PRIMARY KEY (si83_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos122022 definition

-- Drop table

-- DROP TABLE contratos122022;

CREATE TABLE contratos122022 (
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
    CONSTRAINT contratos122022_sequ_pk PRIMARY KEY (si85_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX contratos122022_si85_reg10_index ON contratos122022 USING btree (si85_reg10);


-- contratos132022 definition

-- Drop table

-- DROP TABLE contratos132022;

CREATE TABLE contratos132022 (
    si86_sequencial int8 NOT NULL DEFAULT 0,
    si86_tiporegistro int8 NOT NULL DEFAULT 0,
    si86_codcontrato int8 NOT NULL DEFAULT 0,
    si86_tipodocumento int8 NOT NULL DEFAULT 0,
    si86_nrodocumento varchar(14) NOT NULL,
    si86_cpfrepresentantelegal varchar(11) NOT NULL,
    si86_mes int8 NOT NULL DEFAULT 0,
    si86_reg10 int8 NOT NULL DEFAULT 0,
    si86_instit int8 NULL DEFAULT 0,
    CONSTRAINT contratos132022_sequ_pk PRIMARY KEY (si86_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX contratos132022_si86_reg10_index ON contratos132022 USING btree (si86_reg10);


-- contratos202022 definition

-- Drop table

-- DROP TABLE contratos202022;

CREATE TABLE contratos202022 (
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
    CONSTRAINT contratos202022_sequ_pk PRIMARY KEY (si87_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos302022 definition

-- Drop table

-- DROP TABLE contratos302022;

CREATE TABLE contratos302022 (
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
    CONSTRAINT contratos302022_sequ_pk PRIMARY KEY (si89_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos402022 definition

-- Drop table

-- DROP TABLE contratos402022;

CREATE TABLE contratos402022 (
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
    CONSTRAINT contratos402022_sequ_pk PRIMARY KEY (si91_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conv102022 definition

-- Drop table

-- DROP TABLE conv102022;

CREATE TABLE conv102022 (
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
    CONSTRAINT conv102022_sequ_pk PRIMARY KEY (si92_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conv202022 definition

-- Drop table

-- DROP TABLE conv202022;

CREATE TABLE conv202022 (
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


-- conv212022 definition

-- Drop table

-- DROP TABLE conv212022;

CREATE TABLE conv212022 (
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


-- conv302022 definition

-- Drop table

-- DROP TABLE conv302022;

CREATE TABLE conv302022 (
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


-- conv312022 definition

-- Drop table

-- DROP TABLE conv312022;

CREATE TABLE conv312022 (
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


-- cronem102022 definition

-- Drop table

-- DROP TABLE cronem102022;

CREATE TABLE cronem102022 (
    si170_sequencial int8 NOT NULL DEFAULT 0,
    si170_tiporegistro int8 NOT NULL DEFAULT 0,
    si170_codorgao varchar(2) NOT NULL DEFAULT 0,
    si170_codunidadesub varchar(8) NOT NULL DEFAULT 0,
    si170_grupodespesa int8 NOT NULL DEFAULT 0,
    si170_vldotmensal float8 NOT NULL DEFAULT 0,
    si170_instit int8 NULL DEFAULT 0,
    si170_mes int8 NULL,
    CONSTRAINT cronem102022_sequ_pk PRIMARY KEY (si170_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb102022 definition

-- Drop table

-- DROP TABLE ctb102022;

CREATE TABLE ctb102022 (
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
    CONSTRAINT ctb102022_sequ_pk PRIMARY KEY (si95_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb202022 definition

-- Drop table

-- DROP TABLE ctb202022;

CREATE TABLE ctb202022 (
    si96_sequencial int8 NOT NULL DEFAULT 0,
    si96_tiporegistro int8 NOT NULL DEFAULT 0,
    si96_codorgao varchar(2) NOT NULL,
    si96_codctb int8 NOT NULL DEFAULT 0,
    si96_codfontrecursos int8 NOT NULL DEFAULT 0,
    si96_vlsaldoinicialfonte float8 NOT NULL DEFAULT 0,
    si96_vlsaldofinalfonte float8 NOT NULL DEFAULT 0,
    si96_mes int8 NOT NULL DEFAULT 0,
    si96_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb202022_sequ_pk PRIMARY KEY (si96_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb302022 definition

-- Drop table

-- DROP TABLE ctb302022;

CREATE TABLE ctb302022 (
    si99_sequencial int8 NOT NULL DEFAULT 0,
    si99_tiporegistro int8 NOT NULL DEFAULT 0,
    si99_codorgao varchar(2) NOT NULL,
    si99_codagentearrecadador int8 NOT NULL DEFAULT 0,
    si99_cnpjagentearrecadador varchar(14) NOT NULL,
    si99_vlsaldoinicial float8 NOT NULL DEFAULT 0,
    si99_vlsaldofinal float8 NOT NULL DEFAULT 0,
    si99_mes int8 NOT NULL DEFAULT 0,
    si99_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb302022_sequ_pk PRIMARY KEY (si99_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb402022 definition

-- Drop table

-- DROP TABLE ctb402022;

CREATE TABLE ctb402022 (
    si101_sequencial int8 NOT NULL DEFAULT 0,
    si101_tiporegistro int8 NOT NULL DEFAULT 0,
    si101_codorgao varchar(2) NOT NULL,
    si101_codctb int8 NOT NULL DEFAULT 0,
    si101_desccontabancaria varchar(50) NOT NULL,
    si101_nroconvenio varchar(30) NULL,
    si101_dataassinaturaconvenio date NULL,
    si101_mes int8 NOT NULL DEFAULT 0,
    si101_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb402022_sequ_pk PRIMARY KEY (si101_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ctb502022 definition

-- Drop table

-- DROP TABLE ctb502022;

CREATE TABLE ctb502022 (
    si102_sequencial int8 NOT NULL DEFAULT 0,
    si102_tiporegistro int8 NOT NULL DEFAULT 0,
    si102_codorgao varchar(2) NOT NULL,
    si102_codctb int8 NOT NULL DEFAULT 0,
    si102_situacaoconta varchar(1) NOT NULL,
    si102_datasituacao date NOT NULL,
    si102_mes int8 NOT NULL DEFAULT 0,
    si102_instit int8 NULL DEFAULT 0,
    CONSTRAINT ctb502022_sequ_pk PRIMARY KEY (si102_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cute102022 definition

-- Drop table

-- DROP TABLE cute102022;

CREATE TABLE cute102022 (
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
    CONSTRAINT cute102022_sequ_pk PRIMARY KEY (si199_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cute202022 definition

-- Drop table

-- DROP TABLE cute202022;

CREATE TABLE cute202022 (
    si200_sequencial int8 NOT NULL DEFAULT 0,
    si200_tiporegistro int8 NOT NULL DEFAULT 0,
    si200_codorgao varchar(2) NOT NULL,
    si200_codctb int8 NOT NULL DEFAULT 0,
    si200_codfontrecursos int8 NOT NULL DEFAULT 0,
    si200_vlsaldoinicialfonte float8 NOT NULL DEFAULT 0,
    si200_vlsaldofinalfonte float8 NOT NULL DEFAULT 0,
    si200_mes int8 NOT NULL DEFAULT 0,
    si200_instit int8 NULL DEFAULT 0,
    CONSTRAINT cute202022_sequ_pk PRIMARY KEY (si200_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cute302022 definition

-- Drop table

-- DROP TABLE cute302022;

CREATE TABLE cute302022 (
    si202_sequencial int8 NOT NULL DEFAULT 0,
    si202_tiporegistro int8 NOT NULL DEFAULT 0,
    si202_codorgao varchar(2) NOT NULL,
    si202_codctb int8 NOT NULL DEFAULT 0,
    si202_situacaoconta varchar(1) NOT NULL,
    si202_datasituacao date NOT NULL,
    si202_mes int8 NOT NULL DEFAULT 0,
    si202_instit int8 NULL DEFAULT 0,
    CONSTRAINT cute302022_sequ_pk PRIMARY KEY (si202_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc102022 definition

-- Drop table

-- DROP TABLE cvc102022;

CREATE TABLE cvc102022 (
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
    CONSTRAINT cvc102022_sequ_pk PRIMARY KEY (si146_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc202022 definition

-- Drop table

-- DROP TABLE cvc202022;

CREATE TABLE cvc202022 (
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
    CONSTRAINT cvc202022_sequ_pk PRIMARY KEY (si147_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc302022 definition

-- Drop table

-- DROP TABLE cvc302022;

CREATE TABLE cvc302022 (
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
    CONSTRAINT cvc302022_sequ_pk PRIMARY KEY (si148_sequencial)
)
WITH (
    OIDS=TRUE
);


-- cvc402022 definition

-- Drop table

-- DROP TABLE cvc402022;

CREATE TABLE cvc402022 (
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
    CONSTRAINT cvc402022_sequ_pk PRIMARY KEY (si149_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dclrf102022 definition

-- Drop table

-- DROP TABLE dclrf102022;

CREATE TABLE dclrf102022 (
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


-- dclrf112022 definition

-- Drop table

-- DROP TABLE dclrf112022;

CREATE TABLE dclrf112022 (
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


-- dclrf202022 definition

-- Drop table

-- DROP TABLE dclrf202022;

CREATE TABLE dclrf202022 (
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


-- dclrf302022 definition

-- Drop table

-- DROP TABLE dclrf302022;

CREATE TABLE dclrf302022 (
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


-- dclrf402022 definition

-- Drop table

-- DROP TABLE dclrf402022;

CREATE TABLE dclrf402022 (
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


-- ddc102022 definition

-- Drop table

-- DROP TABLE ddc102022;

CREATE TABLE ddc102022 (
    si150_sequencial int8 NOT NULL DEFAULT 0,
    si150_tiporegistro int8 NOT NULL DEFAULT 0,
    si150_codorgao varchar(2) NOT NULL,
    si150_nroleiautorizacao varchar(6) NOT NULL DEFAULT '0'::character varying,
    si150_dtleiautorizacao date NOT NULL,
    si150_dtpublicacaoleiautorizacao date NOT NULL,
    si150_mes int8 NOT NULL DEFAULT 0,
    si150_instit int8 NULL DEFAULT 0,
    CONSTRAINT ddc102022_sequ_pk PRIMARY KEY (si150_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ddc202022 definition

-- Drop table

-- DROP TABLE ddc202022;

CREATE TABLE ddc202022 (
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
    CONSTRAINT ddc202022_sequ_pk PRIMARY KEY (si153_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ddc302022 definition

-- Drop table

-- DROP TABLE ddc302022;

CREATE TABLE ddc302022 (
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
    CONSTRAINT ddc302022_sequ_pk PRIMARY KEY (si154_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ddc402022 definition

-- Drop table

-- DROP TABLE ddc402022;

CREATE TABLE ddc402022 (
    si178_sequencial int8 NOT NULL DEFAULT 0,
    si178_tiporegistro int8 NOT NULL DEFAULT 0,
    si178_codorgao varchar(2) NOT NULL,
    si178_passivoatuarial int8 NOT NULL DEFAULT 0,
    si178_vlsaldoanterior float8 NOT NULL DEFAULT 0,
    si178_vlsaldoatual float8 NULL DEFAULT 0,
    si178_mes int8 NOT NULL DEFAULT 0,
    si178_instit int8 NULL DEFAULT 0,
    CONSTRAINT ddc402022_sequ_pk PRIMARY KEY (si178_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dispensa102022 definition

-- Drop table

-- DROP TABLE dispensa102022;

CREATE TABLE dispensa102022 (
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
    CONSTRAINT dispensa102022_sequ_pk PRIMARY KEY (si74_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dispensa182022 definition

-- Drop table

-- DROP TABLE dispensa182022;

CREATE TABLE dispensa182022 (
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
    CONSTRAINT dispensa182022_sequ_pk PRIMARY KEY (si82_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa182022_si82_reg10_index ON dispensa182022 USING btree (si82_reg10);


-- emp102022 definition

-- Drop table

-- DROP TABLE emp102022;

CREATE TABLE emp102022 (
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
    CONSTRAINT emp102022_sequ_pk PRIMARY KEY (si106_sequencial)
)
WITH (
    OIDS=TRUE
);


-- emp202022 definition

-- Drop table

-- DROP TABLE emp202022;

CREATE TABLE emp202022 (
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
    CONSTRAINT emp202022_sequ_pk PRIMARY KEY (si109_sequencial)
)
WITH (
    OIDS=TRUE
);


-- emp302022 definition

-- Drop table

-- DROP TABLE emp302022;

CREATE TABLE emp302022 (
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
    CONSTRAINT emp302022_sequ_pk PRIMARY KEY (si206_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ext102022 definition

-- Drop table

-- DROP TABLE ext102022;

CREATE TABLE ext102022 (
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
    CONSTRAINT ext102022_sequ_pk PRIMARY KEY (si124_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ext202022 definition

-- Drop table

-- DROP TABLE ext202022;

CREATE TABLE ext202022 (
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
    CONSTRAINT ext202022_sequ_pk PRIMARY KEY (si165_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ext302022 definition

-- Drop table

-- DROP TABLE ext302022;

CREATE TABLE ext302022 (
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
    CONSTRAINT ext302022_sequ_pk PRIMARY KEY (si126_sequencial)
)
WITH (
    OIDS=TRUE
);


-- hablic102022 definition

-- Drop table

-- DROP TABLE hablic102022;

CREATE TABLE hablic102022 (
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
    CONSTRAINT hablic102022_sequ_pk PRIMARY KEY (si57_sequencial)
)
WITH (
    OIDS=TRUE
);


-- hablic202022 definition

-- Drop table

-- DROP TABLE hablic202022;

CREATE TABLE hablic202022 (
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
    CONSTRAINT hablic202022_sequ_pk PRIMARY KEY (si59_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic102022 definition

-- Drop table

-- DROP TABLE homolic102022;

CREATE TABLE homolic102022 (
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
    CONSTRAINT homolic102022_sequ_pk PRIMARY KEY (si63_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic202022 definition

-- Drop table

-- DROP TABLE homolic202022;

CREATE TABLE homolic202022 (
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
    CONSTRAINT homolic202022_sequ_pk PRIMARY KEY (si64_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic302022 definition

-- Drop table

-- DROP TABLE homolic302022;

CREATE TABLE homolic302022 (
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
    CONSTRAINT homolic302022_sequ_pk PRIMARY KEY (si65_sequencial)
)
WITH (
    OIDS=TRUE
);


-- homolic402022 definition

-- Drop table

-- DROP TABLE homolic402022;

CREATE TABLE homolic402022 (
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
    CONSTRAINT homolic402022_sequ_pk PRIMARY KEY (si65_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ide2022 definition

-- Drop table

-- DROP TABLE ide2022;

CREATE TABLE ide2022 (
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
    CONSTRAINT ide2022_sequ_pk PRIMARY KEY (si11_sequencial)
)
WITH (
    OIDS=TRUE
);


-- idedcasp2022 definition

-- Drop table

-- DROP TABLE idedcasp2022;

CREATE TABLE idedcasp2022 (
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
    CONSTRAINT idedcasp2022_sequ_pk PRIMARY KEY (si200_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ideedital2022 definition

-- Drop table

-- DROP TABLE ideedital2022;

CREATE TABLE ideedital2022 (
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
    CONSTRAINT ideedital2022_sequ_pk PRIMARY KEY (si186_sequencial)
)
WITH (
    OIDS=TRUE
);


-- iderp102022 definition

-- Drop table

-- DROP TABLE iderp102022;

CREATE TABLE iderp102022 (
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
    CONSTRAINT iderp102022_sequ_pk PRIMARY KEY (si179_sequencial)
)
WITH (
    OIDS=TRUE
);


-- iderp112022 definition

-- Drop table

-- DROP TABLE iderp112022;

CREATE TABLE iderp112022 (
    si180_sequencial int8 NOT NULL DEFAULT 0,
    si180_tiporegistro int8 NOT NULL DEFAULT 0,
    si180_codiderp int8 NOT NULL DEFAULT 0,
    si180_codfontrecursos int8 NOT NULL DEFAULT 0,
    si180_vlinscricaofonte float8 NOT NULL DEFAULT 0,
    si180_mes int8 NOT NULL DEFAULT 0,
    si180_reg10 int8 NOT NULL DEFAULT 0,
    si180_instit int8 NULL DEFAULT 0,
    CONSTRAINT iderp112022_sequ_pk PRIMARY KEY (si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- iderp202022 definition

-- Drop table

-- DROP TABLE iderp202022;

CREATE TABLE iderp202022 (
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
    CONSTRAINT iderp202022_sequ_pk PRIMARY KEY (si181_sequencial)
)
WITH (
    OIDS=TRUE
);


-- item102022 definition

-- Drop table

-- DROP TABLE item102022;

CREATE TABLE item102022 (
    si43_sequencial int8 NOT NULL DEFAULT 0,
    si43_tiporegistro int8 NOT NULL DEFAULT 0,
    si43_coditem int8 NOT NULL DEFAULT 0,
    si43_dscitem text NOT NULL,
    si43_unidademedida varchar(50) NOT NULL,
    si43_tipocadastro int8 NOT NULL DEFAULT 0,
    si43_justificativaalteracao varchar(100) NULL,
    si43_mes int8 NOT NULL DEFAULT 0,
    si43_instit int8 NULL DEFAULT 0,
    CONSTRAINT item102022_sequ_pk PRIMARY KEY (si43_sequencial)
)
WITH (
    OIDS=TRUE
);


-- julglic102022 definition

-- Drop table

-- DROP TABLE julglic102022;

CREATE TABLE julglic102022 (
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
    CONSTRAINT julglic102022_sequ_pk PRIMARY KEY (si60_sequencial)
)
WITH (
    OIDS=TRUE
);


-- julglic202022 definition

-- Drop table

-- DROP TABLE julglic202022;

CREATE TABLE julglic202022 (
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
    CONSTRAINT julglic202022_sequ_pk PRIMARY KEY (si61_sequencial)
)
WITH (
    OIDS=TRUE
);


-- julglic302022 definition

-- Drop table

-- DROP TABLE julglic302022;

CREATE TABLE julglic302022 (
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


-- julglic402022 definition

-- Drop table

-- DROP TABLE julglic402022;

CREATE TABLE julglic402022 (
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
    CONSTRAINT julglic402022_sequ_pk PRIMARY KEY (si62_sequencial)
)
WITH (
    OIDS=TRUE
);


-- lao102022 definition

-- Drop table

-- DROP TABLE lao102022;

CREATE TABLE lao102022 (
    si34_sequencial int8 NOT NULL DEFAULT 0,
    si34_tiporegistro int8 NOT NULL DEFAULT 0,
    si34_codorgao varchar(2) NOT NULL,
    si34_nroleialteracao int8 NOT NULL,
    si34_dataleialteracao date NOT NULL,
    si34_mes int8 NOT NULL DEFAULT 0,
    si34_instit int8 NULL DEFAULT 0,
    CONSTRAINT lao102022_sequ_pk PRIMARY KEY (si34_sequencial)
)
WITH (
    OIDS=TRUE
);


-- lao202022 definition

-- Drop table

-- DROP TABLE lao202022;

CREATE TABLE lao202022 (
    si36_sequencial int8 NOT NULL DEFAULT 0,
    si36_tiporegistro int8 NOT NULL DEFAULT 0,
    si36_codorgao varchar(2) NOT NULL,
    si36_nroleialterorcam varchar(6) NOT NULL,
    si36_dataleialterorcam date NOT NULL,
    si36_mes int8 NOT NULL DEFAULT 0,
    si36_instit int8 NULL DEFAULT 0,
    CONSTRAINT lao202022_sequ_pk PRIMARY KEY (si36_sequencial)
)
WITH (
    OIDS=TRUE
);


-- lqd102022 definition

-- Drop table

-- DROP TABLE lqd102022;

CREATE TABLE lqd102022 (
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
    CONSTRAINT lqd102022_sequ_pk PRIMARY KEY (si118_sequencial)
)
WITH (
    OIDS=TRUE
);


-- metareal102022 definition

-- Drop table

-- DROP TABLE metareal102022;

CREATE TABLE metareal102022 (
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
    CONSTRAINT metareal102022_sequ_pk PRIMARY KEY (si171_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ntf102022 definition

-- Drop table

-- DROP TABLE ntf102022;

CREATE TABLE ntf102022 (
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
    CONSTRAINT ntf102022_sequ_pk PRIMARY KEY (si143_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ntf202022 definition

-- Drop table

-- DROP TABLE ntf202022;

CREATE TABLE ntf202022 (
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
    CONSTRAINT ntf202022_sequ_pk PRIMARY KEY (si145_sequencial)
)
WITH (
    OIDS=TRUE
);


-- obelac102022 definition

-- Drop table

-- DROP TABLE obelac102022;

CREATE TABLE obelac102022 (
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
    CONSTRAINT obelac102022_sequ_pk PRIMARY KEY (si139_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ops102022 definition

-- Drop table

-- DROP TABLE ops102022;

CREATE TABLE ops102022 (
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
    CONSTRAINT ops102022_sequ_pk PRIMARY KEY (si132_sequencial)
)
WITH (
    OIDS=TRUE
);


-- orgao102022 definition

-- Drop table

-- DROP TABLE orgao102022;

CREATE TABLE orgao102022 (
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
    CONSTRAINT orgao102022_sequ_pk PRIMARY KEY (si14_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parec102022 definition

-- Drop table

-- DROP TABLE parec102022;

CREATE TABLE parec102022 (
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
    CONSTRAINT parec102022_sequ_pk PRIMARY KEY (si22_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parelic102022 definition

-- Drop table

-- DROP TABLE parelic102022;

CREATE TABLE parelic102022 (
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
    CONSTRAINT parelic102022_sequ_pk PRIMARY KEY (si66_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parpps102022 definition

-- Drop table

-- DROP TABLE parpps102022;

CREATE TABLE parpps102022 (
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
    CONSTRAINT parpps102022_sequ_pk PRIMARY KEY (si156_sequencial)
)
WITH (
    OIDS=TRUE
);


-- parpps202022 definition

-- Drop table

-- DROP TABLE parpps202022;

CREATE TABLE parpps202022 (
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
    CONSTRAINT parpps202022_sequ_pk PRIMARY KEY (si155_sequencial)
)
WITH (
    OIDS=TRUE
);


-- pessoa102022 definition

-- Drop table

-- DROP TABLE pessoa102022;

CREATE TABLE pessoa102022 (
    si12_sequencial int8 NOT NULL DEFAULT 0,
    si12_tiporegistro int8 NOT NULL DEFAULT 0,
    si12_tipodocumento int8 NOT NULL DEFAULT 0,
    si12_nrodocumento varchar(14) NOT NULL,
    si12_nomerazaosocial varchar(120) NOT NULL,
    si12_tipocadastro int8 NOT NULL DEFAULT 0,
    si12_justificativaalteracao varchar(100) NULL,
    si12_mes int8 NOT NULL DEFAULT 0,
    si12_instit int8 NULL DEFAULT 0,
    CONSTRAINT pessoa102022_sequ_pk PRIMARY KEY (si12_sequencial)
)
WITH (
    OIDS=TRUE
);


-- pessoaflpgo102022 definition

-- Drop table

-- DROP TABLE pessoaflpgo102022;

CREATE TABLE pessoaflpgo102022 (
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
    CONSTRAINT pessoaflpgo102022_sequ_pk PRIMARY KEY (si193_sequencial)
)
WITH (
    OIDS=TRUE
);


-- pessoasobra102022 definition

-- Drop table

-- DROP TABLE pessoasobra102022;

CREATE TABLE pessoasobra102022 (
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


-- rec102022 definition

-- Drop table

-- DROP TABLE rec102022;

CREATE TABLE rec102022 (
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
    CONSTRAINT rec102022_sequ_pk PRIMARY KEY (si25_sequencial)
)
WITH (
    OIDS=TRUE
);


-- regadesao102022 definition

-- Drop table

-- DROP TABLE regadesao102022;

CREATE TABLE regadesao102022 (
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
    CONSTRAINT regadesao102022_sequ_pk PRIMARY KEY (si67_sequencial)
)
WITH (
    OIDS=TRUE
);


-- regadesao202022 definition

-- Drop table

-- DROP TABLE regadesao202022;

CREATE TABLE regadesao202022 (
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
    CONSTRAINT regadesao202022_sequ_pk PRIMARY KEY (si73_sequencial)
)
WITH (
    OIDS=TRUE
);


-- reglic102022 definition

-- Drop table

-- DROP TABLE reglic102022;

CREATE TABLE reglic102022 (
    si44_sequencial int8 NOT NULL DEFAULT 0,
    si44_tiporegistro int8 NOT NULL DEFAULT 0,
    si44_codorgao varchar(2) NOT NULL,
    si44_tipodecreto int8 NOT NULL DEFAULT 0,
    si44_nrodecretomunicipal int8 NOT NULL DEFAULT 0,
    si44_datadecretomunicipal date NOT NULL,
    si44_datapublicacaodecretomunicipal date NOT NULL,
    si44_mes int8 NOT NULL DEFAULT 0,
    si44_instit int8 NULL DEFAULT 0,
    CONSTRAINT reglic102022_sequ_pk PRIMARY KEY (si44_sequencial)
)
WITH (
    OIDS=TRUE
);


-- reglic202022 definition

-- Drop table

-- DROP TABLE reglic202022;

CREATE TABLE reglic202022 (
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
    CONSTRAINT reglic202022_sequ_pk PRIMARY KEY (si45_sequencial)
)
WITH (
    OIDS=TRUE
);


-- resplic102022 definition

-- Drop table

-- DROP TABLE resplic102022;

CREATE TABLE resplic102022 (
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
    CONSTRAINT resplic102022_sequ_pk PRIMARY KEY (si55_sequencial)
)
WITH (
    OIDS=TRUE
);


-- resplic202022 definition

-- Drop table

-- DROP TABLE resplic202022;

CREATE TABLE resplic202022 (
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
    CONSTRAINT resplic202022_sequ_pk PRIMARY KEY (si56_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rsp102022 definition

-- Drop table

-- DROP TABLE rsp102022;

CREATE TABLE rsp102022 (
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
    CONSTRAINT rsp102022_sequ_pk PRIMARY KEY (si112_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rsp202022 definition

-- Drop table

-- DROP TABLE rsp202022;

CREATE TABLE rsp202022 (
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
    CONSTRAINT rsp202022_sequ_pk PRIMARY KEY (si115_sequencial)
)
WITH (
    OIDS=TRUE
);


-- tce102022 definition

-- Drop table

-- DROP TABLE tce102022;

CREATE TABLE tce102022 (
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
    CONSTRAINT tce102022_sequ_pk PRIMARY KEY (si187_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic112022 definition

-- Drop table

-- DROP TABLE aberlic112022;

CREATE TABLE aberlic112022 (
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
    CONSTRAINT aberlic112022_reg10_fk FOREIGN KEY (si47_reg10) REFERENCES aberlic102022(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic122022 definition

-- Drop table

-- DROP TABLE aberlic122022;

CREATE TABLE aberlic122022 (
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
    CONSTRAINT aberlic122022_reg10_fk FOREIGN KEY (si48_reg10) REFERENCES aberlic102022(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic132022 definition

-- Drop table

-- DROP TABLE aberlic132022;

CREATE TABLE aberlic132022 (
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
    CONSTRAINT aberlic132022_reg10_fk FOREIGN KEY (si49_reg10) REFERENCES aberlic102022(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic142022 definition

-- Drop table

-- DROP TABLE aberlic142022;

CREATE TABLE aberlic142022 (
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
    CONSTRAINT aberlic142022_reg10_fk FOREIGN KEY (si50_reg10) REFERENCES aberlic102022(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic152022 definition

-- Drop table

-- DROP TABLE aberlic152022;

CREATE TABLE aberlic152022 (
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
    CONSTRAINT aberlic152022_reg10_fk FOREIGN KEY (si51_reg10) REFERENCES aberlic102022(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic162022 definition

-- Drop table

-- DROP TABLE aberlic162022;

CREATE TABLE aberlic162022 (
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
    CONSTRAINT aberlic162022_reg10_fk FOREIGN KEY (si52_reg10) REFERENCES aberlic102022(si46_sequencial)
)
WITH (
    OIDS=TRUE
);


-- alq112022 definition

-- Drop table

-- DROP TABLE alq112022;

CREATE TABLE alq112022 (
    si122_sequencial int8 NOT NULL DEFAULT 0,
    si122_tiporegistro int8 NOT NULL DEFAULT 0,
    si122_codreduzido int8 NOT NULL DEFAULT 0,
    si122_codfontrecursos int8 NOT NULL DEFAULT 0,
    si122_valoranuladofonte float8 NOT NULL DEFAULT 0,
    si122_mes int8 NOT NULL DEFAULT 0,
    si122_reg10 int8 NOT NULL DEFAULT 0,
    si122_instit int8 NULL DEFAULT 0,
    CONSTRAINT alq112022_sequ_pk PRIMARY KEY (si122_sequencial),
    CONSTRAINT alq112022_reg10_fk FOREIGN KEY (si122_reg10) REFERENCES alq102022(si121_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX alq112022_si122_reg10_index ON alq112022 USING btree (si122_reg10);


-- alq122022 definition

-- Drop table

-- DROP TABLE alq122022;

CREATE TABLE alq122022 (
    si123_sequencial int8 NOT NULL DEFAULT 0,
    si123_tiporegistro int8 NOT NULL DEFAULT 0,
    si123_codreduzido int8 NOT NULL DEFAULT 0,
    si123_mescompetencia varchar(2) NOT NULL,
    si123_exerciciocompetencia int8 NOT NULL DEFAULT 0,
    si123_vlanuladodspexerant float8 NOT NULL DEFAULT 0,
    si123_mes int8 NOT NULL DEFAULT 0,
    si123_reg10 int8 NOT NULL DEFAULT 0,
    si123_instit int8 NULL DEFAULT 0,
    CONSTRAINT alq122022_sequ_pk PRIMARY KEY (si123_sequencial),
    CONSTRAINT alq122022_reg10_fk FOREIGN KEY (si123_reg10) REFERENCES alq102022(si121_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX alq122022_si123_reg10_index ON alq122022 USING btree (si123_reg10);


-- anl112022 definition

-- Drop table

-- DROP TABLE anl112022;

CREATE TABLE anl112022 (
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
    CONSTRAINT anl112022_sequ_pk PRIMARY KEY (si111_sequencial),
    CONSTRAINT anl112022_reg10_fk FOREIGN KEY (si111_reg10) REFERENCES anl102022(si110_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX anl112022_si111_reg10_index ON anl112022 USING btree (si111_reg10);


-- aob112022 definition

-- Drop table

-- DROP TABLE aob112022;

CREATE TABLE aob112022 (
    si142_sequencial int8 NOT NULL DEFAULT 0,
    si142_tiporegistro int8 NOT NULL DEFAULT 0,
    si142_codreduzido int8 NOT NULL DEFAULT 0,
    si142_codfontrecursos int8 NOT NULL DEFAULT 0,
    si142_valoranulacaofonte float8 NOT NULL DEFAULT 0,
    si142_mes int8 NOT NULL DEFAULT 0,
    si142_reg10 int8 NOT NULL DEFAULT 0,
    si142_instit int8 NULL DEFAULT 0,
    CONSTRAINT aob112022_sequ_pk PRIMARY KEY (si142_sequencial),
    CONSTRAINT aob112022_reg10_fk FOREIGN KEY (si142_reg10) REFERENCES aob102022(si141_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aob112022_si142_reg10_index ON aob112022 USING btree (si142_reg10);


-- aoc112022 definition

-- Drop table

-- DROP TABLE aoc112022;

CREATE TABLE aoc112022 (
    si39_sequencial int8 NOT NULL DEFAULT 0,
    si39_tiporegistro int8 NOT NULL DEFAULT 0,
    si39_codreduzidodecreto int8 NOT NULL DEFAULT 0,
    si39_nrodecreto varchar(8) NOT NULL DEFAULT 0,
    si39_tipodecretoalteracao int8 NOT NULL DEFAULT 0,
    si39_valoraberto float8 NOT NULL DEFAULT 0,
    si39_mes int8 NOT NULL DEFAULT 0,
    si39_reg10 int8 NOT NULL DEFAULT 0,
    si39_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc112022_sequ_pk PRIMARY KEY (si39_sequencial),
    CONSTRAINT aoc112022_reg10_fk FOREIGN KEY (si39_reg10) REFERENCES aoc102022(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc112022_si39_reg10_index ON aoc112022 USING btree (si39_reg10);


-- aoc122022 definition

-- Drop table

-- DROP TABLE aoc122022;

CREATE TABLE aoc122022 (
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
    CONSTRAINT aoc122022_sequ_pk PRIMARY KEY (si40_sequencial),
    CONSTRAINT aoc122022_reg10_fk FOREIGN KEY (si40_reg10) REFERENCES aoc102022(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc122022_si40_reg10_index ON aoc122022 USING btree (si40_reg10);


-- aoc132022 definition

-- Drop table

-- DROP TABLE aoc132022;

CREATE TABLE aoc132022 (
    si41_sequencial int8 NOT NULL DEFAULT 0,
    si41_tiporegistro int8 NOT NULL DEFAULT 0,
    si41_codreduzidodecreto int8 NOT NULL DEFAULT 0,
    si41_origemrecalteracao varchar(2) NOT NULL,
    si41_valorabertoorigem float8 NOT NULL DEFAULT 0,
    si41_mes int8 NOT NULL DEFAULT 0,
    si41_reg10 int8 NOT NULL DEFAULT 0,
    si41_instit int8 NULL DEFAULT 0,
    CONSTRAINT aoc132022_sequ_pk PRIMARY KEY (si41_sequencial),
    CONSTRAINT aoc132022_reg10_fk FOREIGN KEY (si41_reg10) REFERENCES aoc102022(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc132022_si41_reg10_index ON aoc132022 USING btree (si41_reg10);


-- aoc142022 definition

-- Drop table

-- DROP TABLE aoc142022;

CREATE TABLE aoc142022 (
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
    CONSTRAINT aoc142022_sequ_pk PRIMARY KEY (si42_sequencial),
    CONSTRAINT aoc142022_reg10_fk FOREIGN KEY (si42_reg10) REFERENCES aoc102022(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc142022_si42_reg10_index ON aoc142022 USING btree (si42_reg10);


-- aoc152022 definition

-- Drop table

-- DROP TABLE aoc152022;

CREATE TABLE aoc152022 (
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
    CONSTRAINT aoc152022_sequ_pk PRIMARY KEY (si194_sequencial),
    CONSTRAINT aoc152022_reg10_fk FOREIGN KEY (si194_reg10) REFERENCES aoc102022(si38_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aoc152022_si194_reg10_index ON aoc152022 USING btree (si194_reg10);


-- aop112022 definition

-- Drop table

-- DROP TABLE aop112022;

CREATE TABLE aop112022 (
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
    CONSTRAINT aop112022_sequ_pk PRIMARY KEY (si138_sequencial),
    CONSTRAINT aop112022_reg10_fk FOREIGN KEY (si138_reg10) REFERENCES aop102022(si137_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX aop112022_si138_reg10_index ON aop112022 USING btree (si138_reg10);


-- arc112022 definition

-- Drop table

-- DROP TABLE arc112022;

CREATE TABLE arc112022 (
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
    CONSTRAINT arc112022_sequ_pk PRIMARY KEY (si29_sequencial),
    CONSTRAINT arc112022_reg10_fk FOREIGN KEY (si29_reg10) REFERENCES arc102022(si28_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX arc112022_si15_reg10_index ON arc112022 USING btree (si29_reg10);


-- arc122022 definition

-- Drop table

-- DROP TABLE arc122022;

CREATE TABLE arc122022 (
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
    CONSTRAINT arc122022_sequ_pk PRIMARY KEY (si30_sequencial),
    CONSTRAINT arc122022_reg10_fk FOREIGN KEY (si30_reg10) REFERENCES arc102022(si28_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX arc122022_si30_reg10_index ON arc122022 USING btree (si30_reg10);


-- arc212022 definition

-- Drop table

-- DROP TABLE arc212022;

CREATE TABLE arc212022 (
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
    CONSTRAINT arc212022_sequ_pk PRIMARY KEY (si32_sequencial),
    CONSTRAINT arc212022_reg20_fk FOREIGN KEY (si32_reg20) REFERENCES arc202022(si31_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX arcwq2022_si32_reg20_index ON arc212022 USING btree (si32_reg20);


-- caixa112022 definition

-- Drop table

-- DROP TABLE caixa112022;

CREATE TABLE caixa112022 (
    si166_sequencial int8 NOT NULL DEFAULT 0,
    si166_tiporegistro int8 NOT NULL DEFAULT 0,
    si166_codfontecaixa int8 NOT NULL DEFAULT 0,
    si166_vlsaldoinicialfonte float8 NOT NULL DEFAULT 0,
    si166_vlsaldofinalfonte float8 NOT NULL DEFAULT 0,
    si166_mes int8 NOT NULL DEFAULT 0,
    si166_instit int8 NULL DEFAULT 0,
    si166_reg10 int8 NOT NULL DEFAULT 0,
    CONSTRAINT caixa112022_sequ_pk PRIMARY KEY (si166_sequencial),
    CONSTRAINT caixa112022_reg10_fk FOREIGN KEY (si166_reg10) REFERENCES caixa102022(si103_sequencial)
)
WITH (
    OIDS=TRUE
);


-- caixa122022 definition

-- Drop table

-- DROP TABLE caixa122022;

CREATE TABLE caixa122022 (
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
    CONSTRAINT caixa122022_sequ_pk PRIMARY KEY (si104_sequencial),
    CONSTRAINT caixa122022_reg10_fk FOREIGN KEY (si104_reg10) REFERENCES caixa102022(si103_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX caixa122022_si104_reg10_index ON caixa122022 USING btree (si104_reg10);


-- caixa132022 definition

-- Drop table

-- DROP TABLE caixa132022;

CREATE TABLE caixa132022 (
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
    CONSTRAINT caixa132022_sequ_pk PRIMARY KEY (si105_sequencial),
    CONSTRAINT caixa132022_reg10_fk FOREIGN KEY (si105_reg10) REFERENCES caixa102022(si103_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX caixa132022_si105_reg10_index ON caixa132022 USING btree (si105_reg10);


-- contratos112022 definition

-- Drop table

-- DROP TABLE contratos112022;

CREATE TABLE contratos112022 (
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
    CONSTRAINT contratos112022_sequ_pk PRIMARY KEY (si84_sequencial),
    CONSTRAINT contratos112022_reg10_fk FOREIGN KEY (si84_reg10) REFERENCES contratos102022(si83_sequencial)
)
WITH (
    OIDS=TRUE
);


-- contratos212022 definition

-- Drop table

-- DROP TABLE contratos212022;

CREATE TABLE contratos212022 (
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
    CONSTRAINT contratos212022_sequ_pk PRIMARY KEY (si88_sequencial),
    CONSTRAINT contratos212022_reg20_fk FOREIGN KEY (si88_reg20) REFERENCES contratos202022(si87_sequencial)
)
WITH (
    OIDS=TRUE
);


-- conv112022 definition

-- Drop table

-- DROP TABLE conv112022;

CREATE TABLE conv112022 (
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
    CONSTRAINT conv112022_sequ_pk PRIMARY KEY (si93_sequencial),
    CONSTRAINT conv112022_reg10_fk FOREIGN KEY (si93_reg10) REFERENCES conv102022(si92_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX conv112022_si93_reg10_index ON conv112022 USING btree (si93_reg10);


-- ctb212022 definition

-- Drop table

-- DROP TABLE ctb212022;

CREATE TABLE ctb212022 (
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
    CONSTRAINT ctb212022_sequ_pk PRIMARY KEY (si97_sequencial),
    CONSTRAINT ctb212022_reg20_fk FOREIGN KEY (si97_reg20) REFERENCES ctb202022(si96_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ctb212022_si97_reg20_index ON ctb212022 USING btree (si97_reg20);


-- ctb222022 definition

-- Drop table

-- DROP TABLE ctb222022;

CREATE TABLE ctb222022 (
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
    CONSTRAINT ctb222022_sequ_pk PRIMARY KEY (si98_sequencial),
    CONSTRAINT ctb222022_reg21_fk FOREIGN KEY (si98_reg21) REFERENCES ctb212022(si97_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ctb222022_si98_reg21_index ON ctb222022 USING btree (si98_reg21);


-- ctb312022 definition

-- Drop table

-- DROP TABLE ctb312022;

CREATE TABLE ctb312022 (
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
    CONSTRAINT ctb312022_sequ_pk PRIMARY KEY (si100_sequencial),
    CONSTRAINT ctb312022_reg30_fk FOREIGN KEY (si100_reg30) REFERENCES ctb302022(si99_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ctb312022_si100_reg30_index ON ctb312022 USING btree (si100_reg30);


-- cute212022 definition

-- Drop table

-- DROP TABLE cute212022;

CREATE TABLE cute212022 (
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
    CONSTRAINT cute212022_sequ_pk PRIMARY KEY (si201_sequencial),
    CONSTRAINT cute212022_reg10_fk FOREIGN KEY (si201_reg10) REFERENCES cute102022(si199_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX cute212022_si201_reg10_index ON cute212022 USING btree (si201_reg10);


-- dispensa112022 definition

-- Drop table

-- DROP TABLE dispensa112022;

CREATE TABLE dispensa112022 (
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
    CONSTRAINT dispensa112022_sequ_pk PRIMARY KEY (si75_sequencial),
    CONSTRAINT dispensa112022_reg10_fk FOREIGN KEY (si75_reg10) REFERENCES dispensa102022(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa112022_si75_reg10_index ON dispensa112022 USING btree (si75_reg10);


-- dispensa122022 definition

-- Drop table

-- DROP TABLE dispensa122022;

CREATE TABLE dispensa122022 (
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
    CONSTRAINT dispensa122022_sequ_pk PRIMARY KEY (si76_sequencial),
    CONSTRAINT dispensa122022_reg10_fk FOREIGN KEY (si76_reg10) REFERENCES dispensa102022(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa122022_si76_reg10_index ON dispensa122022 USING btree (si76_reg10);


-- dispensa132022 definition

-- Drop table

-- DROP TABLE dispensa132022;

CREATE TABLE dispensa132022 (
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
    CONSTRAINT dispensa132022_sequ_pk PRIMARY KEY (si77_sequencial),
    CONSTRAINT dispensa132022_reg10_fk FOREIGN KEY (si77_reg10) REFERENCES dispensa102022(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa132022_si77_reg10_index ON dispensa132022 USING btree (si77_reg10);


-- dispensa142022 definition

-- Drop table

-- DROP TABLE dispensa142022;

CREATE TABLE dispensa142022 (
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
    CONSTRAINT dispensa142022_sequ_pk PRIMARY KEY (si78_sequencial),
    CONSTRAINT dispensa142022_reg10_fk FOREIGN KEY (si78_reg10) REFERENCES dispensa102022(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa142022_si78_reg10_index ON dispensa142022 USING btree (si78_reg10);


-- dispensa152022 definition

-- Drop table

-- DROP TABLE dispensa152022;

CREATE TABLE dispensa152022 (
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
    CONSTRAINT dispensa152022_sequ_pk PRIMARY KEY (si79_sequencial),
    CONSTRAINT dispensa152022_reg10_fk FOREIGN KEY (si79_reg10) REFERENCES dispensa102022(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa152022_si79_reg10_index ON dispensa152022 USING btree (si79_reg10);


-- dispensa162022 definition

-- Drop table

-- DROP TABLE dispensa162022;

CREATE TABLE dispensa162022 (
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
    CONSTRAINT dispensa162022_sequ_pk PRIMARY KEY (si80_sequencial),
    CONSTRAINT dispensa162022_reg10_fk FOREIGN KEY (si80_reg10) REFERENCES dispensa102022(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa162022_si80_reg10_index ON dispensa162022 USING btree (si80_reg10);


-- dispensa172022 definition

-- Drop table

-- DROP TABLE dispensa172022;

CREATE TABLE dispensa172022 (
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
    CONSTRAINT dispensa172022_sequ_pk PRIMARY KEY (si81_sequencial),
    CONSTRAINT dispensa172022_reg10_fk FOREIGN KEY (si81_reg10) REFERENCES dispensa102022(si74_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX dispensa172022_si81_reg10_index ON dispensa172022 USING btree (si81_reg10);


-- emp112022 definition

-- Drop table

-- DROP TABLE emp112022;

CREATE TABLE emp112022 (
    si107_sequencial int8 NOT NULL DEFAULT 0,
    si107_tiporegistro int8 NOT NULL DEFAULT 0,
    si107_codunidadesub varchar(8) NOT NULL,
    si107_nroempenho int8 NOT NULL DEFAULT 0,
    si107_codfontrecursos int8 NOT NULL DEFAULT 0,
    si107_valorfonte float8 NOT NULL DEFAULT 0,
    si107_mes int8 NOT NULL DEFAULT 0,
    si107_reg10 int8 NOT NULL DEFAULT 0,
    si107_instit int8 NULL DEFAULT 0,
    CONSTRAINT emp112022_sequ_pk PRIMARY KEY (si107_sequencial),
    CONSTRAINT emp112022_reg10_fk FOREIGN KEY (si107_reg10) REFERENCES emp102022(si106_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX emp112022_si107_reg10_index ON emp112022 USING btree (si107_reg10);


-- emp122022 definition

-- Drop table

-- DROP TABLE emp122022;

CREATE TABLE emp122022 (
    si108_sequencial int8 NOT NULL DEFAULT 0,
    si108_tiporegistro int8 NOT NULL DEFAULT 0,
    si108_codunidadesub varchar(8) NOT NULL,
    si108_nroempenho int8 NOT NULL DEFAULT 0,
    si108_tipodocumento int8 NOT NULL DEFAULT 0,
    si108_nrodocumento varchar(14) NOT NULL,
    si108_mes int8 NOT NULL DEFAULT 0,
    si108_reg10 int8 NOT NULL DEFAULT 0,
    si108_instit int8 NULL DEFAULT 0,
    CONSTRAINT emp122022_sequ_pk PRIMARY KEY (si108_sequencial),
    CONSTRAINT emp122022_reg10_fk FOREIGN KEY (si108_reg10) REFERENCES emp102022(si106_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX emp122022_si108_reg10_index ON emp122022 USING btree (si108_reg10);


-- ext312022 definition

-- Drop table

-- DROP TABLE ext312022;

CREATE TABLE ext312022 (
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
    CONSTRAINT ext312022_sequ_pk PRIMARY KEY (si127_sequencial),
    CONSTRAINT ext312022_reg22_fk FOREIGN KEY (si127_reg30) REFERENCES ext302022(si126_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ext312022_si127_reg20_index ON ext312022 USING btree (si127_reg30);


-- ext322022 definition

-- Drop table

-- DROP TABLE ext322022;

CREATE TABLE ext322022 (
    si128_sequencial int8 NOT NULL DEFAULT 0,
    si128_tiporegistro int8 NOT NULL DEFAULT 0,
    si128_codreduzidoop int8 NOT NULL DEFAULT 0,
    si128_tiporetencao varchar(4) NOT NULL,
    si128_descricaoretencao varchar(50) NULL,
    si128_vlretencao float8 NOT NULL DEFAULT 0,
    si128_mes int8 NOT NULL DEFAULT 0,
    si128_reg30 int8 NULL DEFAULT 0,
    si128_instit int8 NULL DEFAULT 0,
    CONSTRAINT ext322022_sequ_pk PRIMARY KEY (si128_sequencial),
    CONSTRAINT ext322022_reg23_fk FOREIGN KEY (si128_reg30) REFERENCES ext322022(si128_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ext322022_si128_reg20_index ON ext322022 USING btree (si128_reg30);


-- lao112022 definition

-- Drop table

-- DROP TABLE lao112022;

CREATE TABLE lao112022 (
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
    CONSTRAINT lao112022_sequ_pk PRIMARY KEY (si35_sequencial),
    CONSTRAINT lao112022_reg10_fk FOREIGN KEY (si35_reg10) REFERENCES lao102022(si34_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lao112022_si35_reg10_index ON lao112022 USING btree (si35_reg10);


-- lao212022 definition

-- Drop table

-- DROP TABLE lao212022;

CREATE TABLE lao212022 (
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
    CONSTRAINT lao212022_sequ_pk PRIMARY KEY (si37_sequencial),
    CONSTRAINT lao212022_reg20_fk FOREIGN KEY (si37_reg20) REFERENCES lao202022(si36_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lao212022_si37_reg20_index ON lao212022 USING btree (si37_reg20);


-- lqd112022 definition

-- Drop table

-- DROP TABLE lqd112022;

CREATE TABLE lqd112022 (
    si119_sequencial int8 NOT NULL DEFAULT 0,
    si119_tiporegistro int8 NOT NULL DEFAULT 0,
    si119_codreduzido int8 NOT NULL DEFAULT 0,
    si119_codfontrecursos int8 NOT NULL DEFAULT 0,
    si119_valorfonte float8 NOT NULL DEFAULT 0,
    si119_mes int8 NOT NULL DEFAULT 0,
    si119_reg10 int8 NOT NULL DEFAULT 0,
    si119_instit int8 NULL DEFAULT 0,
    CONSTRAINT lqd112022_sequ_pk PRIMARY KEY (si119_sequencial),
    CONSTRAINT lqd112022_reg10_fk FOREIGN KEY (si119_reg10) REFERENCES lqd102022(si118_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lqd112022_si119_reg10_index ON lqd112022 USING btree (si119_reg10);


-- lqd122022 definition

-- Drop table

-- DROP TABLE lqd122022;

CREATE TABLE lqd122022 (
    si120_sequencial int8 NOT NULL DEFAULT 0,
    si120_tiporegistro int8 NOT NULL DEFAULT 0,
    si120_codreduzido int8 NOT NULL DEFAULT 0,
    si120_mescompetencia varchar(2) NOT NULL,
    si120_exerciciocompetencia int8 NOT NULL DEFAULT 0,
    si120_vldspexerant float8 NOT NULL DEFAULT 0,
    si120_mes int8 NOT NULL DEFAULT 0,
    si120_reg10 int8 NOT NULL DEFAULT 0,
    si120_instit int8 NULL DEFAULT 0,
    CONSTRAINT lqd122022_sequ_pk PRIMARY KEY (si120_sequencial),
    CONSTRAINT lqd122022_reg10_fk FOREIGN KEY (si120_reg10) REFERENCES lqd102022(si118_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX lqd122022_si120_reg10_index ON lqd122022 USING btree (si120_reg10);


-- ntf112022 definition

-- Drop table

-- DROP TABLE ntf112022;

CREATE TABLE ntf112022 (
    si144_sequencial int8 NOT NULL DEFAULT 0,
    si144_tiporegistro int8 NOT NULL DEFAULT 0,
    si144_codnotafiscal int8 NOT NULL DEFAULT 0,
    si144_coditem int8 NOT NULL DEFAULT 0,
    si144_quantidadeitem float8 NOT NULL DEFAULT 0,
    si144_valorunitarioitem float8 NOT NULL DEFAULT 0,
    si144_mes int8 NOT NULL DEFAULT 0,
    si144_reg10 int8 NOT NULL DEFAULT 0,
    si144_instit int8 NULL DEFAULT 0,
    CONSTRAINT ntf112022_sequ_pk PRIMARY KEY (si144_sequencial),
    CONSTRAINT ntf112022_reg10_fk FOREIGN KEY (si144_reg10) REFERENCES ntf102022(si143_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ntf112022_si144_reg10_index ON ntf112022 USING btree (si144_reg10);


-- obelac112022 definition

-- Drop table

-- DROP TABLE obelac112022;

CREATE TABLE obelac112022 (
    si140_sequencial int8 NOT NULL DEFAULT 0,
    si140_tiporegistro int8 NOT NULL DEFAULT 0,
    si140_codreduzido int8 NOT NULL DEFAULT 0,
    si140_codfontrecursos int8 NOT NULL DEFAULT 0,
    si140_valorfonte float8 NOT NULL DEFAULT 0,
    si140_mes int8 NOT NULL DEFAULT 0,
    si140_reg10 int8 NOT NULL DEFAULT 0,
    si140_instit int8 NULL DEFAULT 0,
    CONSTRAINT obelac112022_sequ_pk PRIMARY KEY (si140_sequencial),
    CONSTRAINT obelac112022_reg10_fk FOREIGN KEY (si140_reg10) REFERENCES lqd122022(si120_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX obelac112022_si140_reg10_index ON obelac112022 USING btree (si140_reg10);


-- ops112022 definition

-- Drop table

-- DROP TABLE ops112022;

CREATE TABLE ops112022 (
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
    CONSTRAINT ops112022_sequ_pk PRIMARY KEY (si133_sequencial),
    CONSTRAINT ops112022_reg10_fk FOREIGN KEY (si133_reg10) REFERENCES ops102022(si132_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ops112022_si133_reg10_index ON ops112022 USING btree (si133_reg10);


-- ops122022 definition

-- Drop table

-- DROP TABLE ops122022;

CREATE TABLE ops122022 (
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
    CONSTRAINT ops122022_sequ_pk PRIMARY KEY (si134_sequencial),
    CONSTRAINT ops122022_reg10_fk FOREIGN KEY (si134_reg10) REFERENCES ops102022(si132_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ops122022_si134_reg10_index ON ops122022 USING btree (si134_reg10);


-- ops132022 definition

-- Drop table

-- DROP TABLE ops132022;

CREATE TABLE ops132022 (
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
    CONSTRAINT ops132022_sequ_pk PRIMARY KEY (si135_sequencial),
    CONSTRAINT ops132022_reg10_fk FOREIGN KEY (si135_reg10) REFERENCES ops102022(si132_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX ops132022_si135_reg10_index ON ops132022 USING btree (si135_reg10);


-- orgao112022 definition

-- Drop table

-- DROP TABLE orgao112022;

CREATE TABLE orgao112022 (
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
    CONSTRAINT orgao112022_sequ_pk PRIMARY KEY (si15_sequencial),
    CONSTRAINT orgao112022_reg10_fk FOREIGN KEY (si15_reg10) REFERENCES orgao102022(si14_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX orgao112022_si15_reg10_index ON orgao112022 USING btree (si15_reg10);


-- parec112022 definition

-- Drop table

-- DROP TABLE parec112022;

CREATE TABLE parec112022 (
    si23_sequencial int8 NOT NULL DEFAULT 0,
    si23_tiporegistro int8 NOT NULL DEFAULT 0,
    si23_codreduzido int8 NOT NULL DEFAULT 0,
    si23_codfontrecursos int8 NOT NULL DEFAULT 0,
    si23_vlfonte float8 NOT NULL DEFAULT 0,
    si23_reg10 int8 NOT NULL DEFAULT 0,
    si23_mes int8 NOT NULL DEFAULT 0,
    si23_instit int8 NULL DEFAULT 0,
    CONSTRAINT parec112022_sequ_pk PRIMARY KEY (si23_sequencial),
    CONSTRAINT parec112022_reg10_fk FOREIGN KEY (si23_reg10) REFERENCES parec102022(si22_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX parec112022_si23_reg10_index ON parec112022 USING btree (si23_reg10);


-- rec112022 definition

-- Drop table

-- DROP TABLE rec112022;

CREATE TABLE rec112022 (
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
    CONSTRAINT rec112022_sequ_pk PRIMARY KEY (si26_sequencial),
    CONSTRAINT rec112022_reg10_fk FOREIGN KEY (si26_reg10) REFERENCES rec102022(si25_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rec112022_si26_reg10_index ON rec112022 USING btree (si26_reg10);


-- regadesao112022 definition

-- Drop table

-- DROP TABLE regadesao112022;

CREATE TABLE regadesao112022 (
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
    CONSTRAINT regadesao112022_sequ_pk PRIMARY KEY (si68_sequencial),
    CONSTRAINT regadesao112022_reg10_fk FOREIGN KEY (si68_reg10) REFERENCES regadesao102022(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao112022_si68_reg10_index ON regadesao112022 USING btree (si68_reg10);


-- regadesao122022 definition

-- Drop table

-- DROP TABLE regadesao122022;

CREATE TABLE regadesao122022 (
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
    CONSTRAINT regadesao122022_sequ_pk PRIMARY KEY (si69_sequencial),
    CONSTRAINT regadesao122022_reg10_fk FOREIGN KEY (si69_reg10) REFERENCES regadesao102022(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao122022_si69_reg10_index ON regadesao122022 USING btree (si69_reg10);


-- regadesao132022 definition

-- Drop table

-- DROP TABLE regadesao132022;

CREATE TABLE regadesao132022 (
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
    CONSTRAINT regadesao132022_sequ_pk PRIMARY KEY (si70_sequencial),
    CONSTRAINT regadesao132022_reg10_fk FOREIGN KEY (si70_reg10) REFERENCES regadesao102022(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao132022_si70_reg10_index ON regadesao132022 USING btree (si70_reg10);


-- regadesao142022 definition

-- Drop table

-- DROP TABLE regadesao142022;

CREATE TABLE regadesao142022 (
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
    CONSTRAINT regadesao142022_sequ_pk PRIMARY KEY (si71_sequencial),
    CONSTRAINT regadesao142022_reg10_fk FOREIGN KEY (si71_reg10) REFERENCES regadesao102022(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao142022_si71_reg10_index ON regadesao142022 USING btree (si71_reg10);


-- regadesao152022 definition

-- Drop table

-- DROP TABLE regadesao152022;

CREATE TABLE regadesao152022 (
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
    CONSTRAINT regadesao152022_sequ_pk PRIMARY KEY (si72_sequencial),
    CONSTRAINT regadesao152022_reg10_fk FOREIGN KEY (si72_reg10) REFERENCES regadesao102022(si67_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX regadesao152022_si72_reg10_index ON regadesao152022 USING btree (si72_reg10);


-- rsp112022 definition

-- Drop table

-- DROP TABLE rsp112022;

CREATE TABLE rsp112022 (
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
    CONSTRAINT rsp112022_sequ_pk PRIMARY KEY (si113_sequencial),
    CONSTRAINT rsp112022_reg10_fk FOREIGN KEY (si113_reg10) REFERENCES rsp102022(si112_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp112022_si113_reg10_index ON rsp112022 USING btree (si113_reg10);


-- rsp122022 definition

-- Drop table

-- DROP TABLE rsp122022;

CREATE TABLE rsp122022 (
    si114_sequencial int8 NOT NULL DEFAULT 0,
    si114_tiporegistro int8 NOT NULL DEFAULT 0,
    si114_codreduzidorsp int8 NOT NULL DEFAULT 0,
    si114_tipodocumento int8 NOT NULL DEFAULT 0,
    si114_nrodocumento varchar(14) NOT NULL,
    si114_mes int8 NOT NULL DEFAULT 0,
    si114_reg10 int8 NOT NULL DEFAULT 0,
    si114_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp122022_sequ_pk PRIMARY KEY (si114_sequencial),
    CONSTRAINT rsp122022_reg10_fk FOREIGN KEY (si114_reg10) REFERENCES rsp102022(si112_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp122022_si114_reg10_index ON rsp122022 USING btree (si114_reg10);


-- rsp212022 definition

-- Drop table

-- DROP TABLE rsp212022;

CREATE TABLE rsp212022 (
    si116_sequencial int8 NOT NULL DEFAULT 0,
    si116_tiporegistro int8 NOT NULL DEFAULT 0,
    si116_codreduzidomov int8 NOT NULL DEFAULT 0,
    si116_codfontrecursos int8 NOT NULL DEFAULT 0,
    si116_vlmovimentacaofonte float8 NOT NULL DEFAULT 0,
    si116_mes int8 NOT NULL DEFAULT 0,
    si116_reg20 int8 NOT NULL DEFAULT 0,
    si116_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp212022_sequ_pk PRIMARY KEY (si116_sequencial),
    CONSTRAINT rsp212022_reg20_fk FOREIGN KEY (si116_reg20) REFERENCES rsp202022(si115_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp212022_si116_reg20_index ON rsp212022 USING btree (si116_reg20);


-- rsp222022 definition

-- Drop table

-- DROP TABLE rsp222022;

CREATE TABLE rsp222022 (
    si117_sequencial int8 NOT NULL DEFAULT 0,
    si117_tiporegistro int8 NOT NULL DEFAULT 0,
    si117_codreduzidomov int8 NOT NULL DEFAULT 0,
    si117_tipodocumento int8 NOT NULL DEFAULT 0,
    si117_nrodocumento varchar(14) NOT NULL,
    si117_mes int8 NOT NULL DEFAULT 0,
    si117_reg20 int8 NOT NULL DEFAULT 0,
    si117_instit int8 NULL DEFAULT 0,
    CONSTRAINT rsp222022_sequ_pk PRIMARY KEY (si117_sequencial),
    CONSTRAINT rsp222022_reg20_fk FOREIGN KEY (si117_reg20) REFERENCES rsp202022(si115_sequencial)
)
WITH (
    OIDS=TRUE
);
CREATE INDEX rsp222022_si117_reg20_index ON rsp222022 USING btree (si117_reg20);


-- tce112022 definition

-- Drop table

-- DROP TABLE tce112022;

CREATE TABLE tce112022 (
    si188_sequencial int8 NOT NULL DEFAULT 0,
    si188_tiporegistro int8 NOT NULL DEFAULT 0,
    si188_numprocessotce varchar(12) NOT NULL,
    si188_datainstauracaotce date NOT NULL,
    si188_tipodocumentorespdano int8 NOT NULL DEFAULT 0,
    si188_nrodocumentorespdano varchar(14) NOT NULL,
    si188_mes int8 NOT NULL DEFAULT 0,
    si188_reg10 int8 NOT NULL DEFAULT 0,
    si188_instit int8 NULL DEFAULT 0,
    CONSTRAINT tce112022_sequ_pk PRIMARY KEY (si188_sequencial),
    CONSTRAINT tce112022_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES tce112022(si188_sequencial)
)
WITH (
    OIDS=TRUE
);


-- aberlic102022_si46_sequencial_seq definition

-- DROP SEQUENCE aberlic102022_si46_sequencial_seq;

CREATE SEQUENCE aberlic102022_si46_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic112022_si47_sequencial_seq definition

-- DROP SEQUENCE aberlic112022_si47_sequencial_seq;

CREATE SEQUENCE aberlic112022_si47_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic122022_si48_sequencial_seq definition

-- DROP SEQUENCE aberlic122022_si48_sequencial_seq;

CREATE SEQUENCE aberlic122022_si48_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic132022_si49_sequencial_seq definition

-- DROP SEQUENCE aberlic132022_si49_sequencial_seq;

CREATE SEQUENCE aberlic132022_si49_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic142022_si50_sequencial_seq definition

-- DROP SEQUENCE aberlic142022_si50_sequencial_seq;

CREATE SEQUENCE aberlic142022_si50_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic152022_si51_sequencial_seq definition

-- DROP SEQUENCE aberlic152022_si51_sequencial_seq;

CREATE SEQUENCE aberlic152022_si51_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic162022_si52_sequencial_seq definition

-- DROP SEQUENCE aberlic162022_si52_sequencial_seq;

CREATE SEQUENCE aberlic162022_si52_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aex102022_si130_sequencial_seq definition

-- DROP SEQUENCE aex102022_si130_sequencial_seq;

CREATE SEQUENCE aex102022_si130_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq102022_si121_sequencial_seq definition

-- DROP SEQUENCE alq102022_si121_sequencial_seq;

CREATE SEQUENCE alq102022_si121_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq112022_si122_sequencial_seq definition

-- DROP SEQUENCE alq112022_si122_sequencial_seq;

CREATE SEQUENCE alq112022_si122_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq122022_si123_sequencial_seq definition

-- DROP SEQUENCE alq122022_si123_sequencial_seq;

CREATE SEQUENCE alq122022_si123_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- anl102022_si110_sequencial_seq definition

-- DROP SEQUENCE anl102022_si110_sequencial_seq;

CREATE SEQUENCE anl102022_si110_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- anl112022_si111_sequencial_seq definition

-- DROP SEQUENCE anl112022_si111_sequencial_seq;

CREATE SEQUENCE anl112022_si111_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aob102022_si141_sequencial_seq definition

-- DROP SEQUENCE aob102022_si141_sequencial_seq;

CREATE SEQUENCE aob102022_si141_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aob112022_si142_sequencial_seq definition

-- DROP SEQUENCE aob112022_si142_sequencial_seq;

CREATE SEQUENCE aob112022_si142_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc102022_si38_sequencial_seq definition

-- DROP SEQUENCE aoc102022_si38_sequencial_seq;

CREATE SEQUENCE aoc102022_si38_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc112022_si39_sequencial_seq definition

-- DROP SEQUENCE aoc112022_si39_sequencial_seq;

CREATE SEQUENCE aoc112022_si39_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc122022_si40_sequencial_seq definition

-- DROP SEQUENCE aoc122022_si40_sequencial_seq;

CREATE SEQUENCE aoc122022_si40_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc132022_si41_sequencial_seq definition

-- DROP SEQUENCE aoc132022_si41_sequencial_seq;

CREATE SEQUENCE aoc132022_si41_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc142022_si42_sequencial_seq definition

-- DROP SEQUENCE aoc142022_si42_sequencial_seq;

CREATE SEQUENCE aoc142022_si42_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc152022_si194_sequencial_seq definition

-- DROP SEQUENCE aoc152022_si194_sequencial_seq;

CREATE SEQUENCE aoc152022_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aop102022_si137_sequencial_seq definition

-- DROP SEQUENCE aop102022_si137_sequencial_seq;

CREATE SEQUENCE aop102022_si137_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aop112022_si138_sequencial_seq definition

-- DROP SEQUENCE aop112022_si138_sequencial_seq;

CREATE SEQUENCE aop112022_si138_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc102022_si28_sequencial_seq definition

-- DROP SEQUENCE arc102022_si28_sequencial_seq;

CREATE SEQUENCE arc102022_si28_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc112022_si29_sequencial_seq definition

-- DROP SEQUENCE arc112022_si29_sequencial_seq;

CREATE SEQUENCE arc112022_si29_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- arc202022_si31_sequencial_seq definition

-- DROP SEQUENCE arc202022_si31_sequencial_seq;

CREATE SEQUENCE arc202022_si31_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc212022_si32_sequencial_seq definition

-- DROP SEQUENCE arc212022_si32_sequencial_seq;

CREATE SEQUENCE arc212022_si32_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa102022_si103_sequencial_seq definition

-- DROP SEQUENCE caixa102022_si103_sequencial_seq;

CREATE SEQUENCE caixa102022_si103_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa112022_si166_sequencial_seq definition

-- DROP SEQUENCE caixa112022_si166_sequencial_seq;

CREATE SEQUENCE caixa112022_si166_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa122022_si104_sequencial_seq definition

-- DROP SEQUENCE caixa122022_si104_sequencial_seq;

CREATE SEQUENCE caixa122022_si104_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa132022_si105_sequencial_seq definition

-- DROP SEQUENCE caixa132022_si105_sequencial_seq;

CREATE SEQUENCE caixa132022_si105_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge102022_si182_sequencial_seq definition

-- DROP SEQUENCE conge102022_si182_sequencial_seq;

CREATE SEQUENCE conge102022_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- conge202022_si183_sequencial_seq definition

-- DROP SEQUENCE conge202022_si183_sequencial_seq;

CREATE SEQUENCE conge202022_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge302022_si184_sequencial_seq definition

-- DROP SEQUENCE conge302022_si184_sequencial_seq;

CREATE SEQUENCE conge302022_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge402022_si237_sequencial_seq definition

-- DROP SEQUENCE conge402022_si237_sequencial_seq;

CREATE SEQUENCE conge402022_si237_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge502022_si238_sequencial_seq definition

-- DROP SEQUENCE conge502022_si238_sequencial_seq;

CREATE SEQUENCE conge502022_si238_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consid102022_si158_sequencial_seq definition

-- DROP SEQUENCE consid102022_si158_sequencial_seq;

CREATE SEQUENCE consid102022_si158_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor102022_si16_sequencial_seq definition

-- DROP SEQUENCE consor102022_si16_sequencial_seq;

CREATE SEQUENCE consor102022_si16_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- consor202022_si17_sequencial_seq definition

-- DROP SEQUENCE consor202022_si17_sequencial_seq;

CREATE SEQUENCE consor202022_si17_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor302022_si18_sequencial_seq definition

-- DROP SEQUENCE consor302022_si18_sequencial_seq;

CREATE SEQUENCE consor302022_si18_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor402022_si19_sequencial_seq definition

-- DROP SEQUENCE consor402022_si19_sequencial_seq;

CREATE SEQUENCE consor402022_si19_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor502022_si20_sequencial_seq definition

-- DROP SEQUENCE consor502022_si20_sequencial_seq;

CREATE SEQUENCE consor502022_si20_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos102022_si83_sequencial_seq definition

-- DROP SEQUENCE contratos102022_si83_sequencial_seq;

CREATE SEQUENCE contratos102022_si83_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos112022_si84_sequencial_seq definition

-- DROP SEQUENCE contratos112022_si84_sequencial_seq;

CREATE SEQUENCE contratos112022_si84_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos122022_si85_sequencial_seq definition

-- DROP SEQUENCE contratos122022_si85_sequencial_seq;

CREATE SEQUENCE contratos122022_si85_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos132022_si86_sequencial_seq definition

-- DROP SEQUENCE contratos132022_si86_sequencial_seq;

CREATE SEQUENCE contratos132022_si86_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- contratos202022_si87_sequencial_seq definition

-- DROP SEQUENCE contratos202022_si87_sequencial_seq;

CREATE SEQUENCE contratos202022_si87_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos212022_si88_sequencial_seq definition

-- DROP SEQUENCE contratos212022_si88_sequencial_seq;

CREATE SEQUENCE contratos212022_si88_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos302022_si89_sequencial_seq definition

-- DROP SEQUENCE contratos302022_si89_sequencial_seq;

CREATE SEQUENCE contratos302022_si89_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos402022_si91_sequencial_seq definition

-- DROP SEQUENCE contratos402022_si91_sequencial_seq;

CREATE SEQUENCE contratos402022_si91_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- conv102022_si92_sequencial_seq definition

-- DROP SEQUENCE conv102022_si92_sequencial_seq;

CREATE SEQUENCE conv102022_si92_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv112022_si93_sequencial_seq definition

-- DROP SEQUENCE conv112022_si93_sequencial_seq;

CREATE SEQUENCE conv112022_si93_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv202022_si94_sequencial_seq definition

-- DROP SEQUENCE conv202022_si94_sequencial_seq;

CREATE SEQUENCE conv202022_si94_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv212022_si232_sequencial_seq definition

-- DROP SEQUENCE conv212022_si232_sequencial_seq;

CREATE SEQUENCE conv212022_si232_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv302022_si203_sequencial_seq definition

-- DROP SEQUENCE conv302022_si203_sequencial_seq;

CREATE SEQUENCE conv302022_si203_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv312022_si204_sequencial_seq definition

-- DROP SEQUENCE conv312022_si204_sequencial_seq;

CREATE SEQUENCE conv312022_si204_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cronem102022_si170_sequencial_seq definition

-- DROP SEQUENCE cronem102022_si170_sequencial_seq;

CREATE SEQUENCE cronem102022_si170_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb102022_si95_sequencial_seq definition

-- DROP SEQUENCE ctb102022_si95_sequencial_seq;

CREATE SEQUENCE ctb102022_si95_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- ctb202022_si96_sequencial_seq definition

-- DROP SEQUENCE ctb202022_si96_sequencial_seq;

CREATE SEQUENCE ctb202022_si96_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb212022_si97_sequencial_seq definition

-- DROP SEQUENCE ctb212022_si97_sequencial_seq;

CREATE SEQUENCE ctb212022_si97_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb222022_si98_sequencial_seq definition

-- DROP SEQUENCE ctb222022_si98_sequencial_seq;

CREATE SEQUENCE ctb222022_si98_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb302022_si99_sequencial_seq definition

-- DROP SEQUENCE ctb302022_si99_sequencial_seq;

CREATE SEQUENCE ctb302022_si99_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb312022_si100_sequencial_seq definition

-- DROP SEQUENCE ctb312022_si100_sequencial_seq;

CREATE SEQUENCE ctb312022_si100_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb402022_si101_sequencial_seq definition

-- DROP SEQUENCE ctb402022_si101_sequencial_seq;

CREATE SEQUENCE ctb402022_si101_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb502022_si102_sequencial_seq definition

-- DROP SEQUENCE ctb502022_si102_sequencial_seq;

CREATE SEQUENCE ctb502022_si102_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute102022_si199_sequencial_seq definition

-- DROP SEQUENCE cute102022_si199_sequencial_seq;

CREATE SEQUENCE cute102022_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cute202022_si200_sequencial_seq definition

-- DROP SEQUENCE cute202022_si200_sequencial_seq;

CREATE SEQUENCE cute202022_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute212022_si201_sequencial_seq definition

-- DROP SEQUENCE cute212022_si201_sequencial_seq;

CREATE SEQUENCE cute212022_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute302022_si202_sequencial_seq definition

-- DROP SEQUENCE cute302022_si202_sequencial_seq;

CREATE SEQUENCE cute302022_si202_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc102022_si146_sequencial_seq definition

-- DROP SEQUENCE cvc102022_si146_sequencial_seq;

CREATE SEQUENCE cvc102022_si146_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cvc202022_si147_sequencial_seq definition

-- DROP SEQUENCE cvc202022_si147_sequencial_seq;

CREATE SEQUENCE cvc202022_si147_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc302022_si148_sequencial_seq definition

-- DROP SEQUENCE cvc302022_si148_sequencial_seq;

CREATE SEQUENCE cvc302022_si148_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc402022_si149_sequencial_seq definition

-- DROP SEQUENCE cvc402022_si149_sequencial_seq;

CREATE SEQUENCE cvc402022_si149_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf102022_si157_sequencial_seq definition

-- DROP SEQUENCE dclrf102022_si157_sequencial_seq;

CREATE SEQUENCE dclrf102022_si157_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf112022_si205_sequencial_seq definition

-- DROP SEQUENCE dclrf112022_si205_sequencial_seq;

CREATE SEQUENCE dclrf112022_si205_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- dclrf202022_si191_sequencial_seq definition

-- DROP SEQUENCE dclrf202022_si191_sequencial_seq;

CREATE SEQUENCE dclrf202022_si191_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf302022_si192_sequencial_seq definition

-- DROP SEQUENCE dclrf302022_si192_sequencial_seq;

CREATE SEQUENCE dclrf302022_si192_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf402022_si193_sequencial_seq definition

-- DROP SEQUENCE dclrf402022_si193_sequencial_seq;

CREATE SEQUENCE dclrf402022_si193_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc202022_si153_sequencial_seq definition

-- DROP SEQUENCE ddc202022_si153_sequencial_seq;

CREATE SEQUENCE ddc202022_si153_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc302022_si154_sequencial_seq definition

-- DROP SEQUENCE ddc302022_si154_sequencial_seq;

CREATE SEQUENCE ddc302022_si154_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc402022_si178_sequencial_seq definition

-- DROP SEQUENCE ddc402022_si178_sequencial_seq;

CREATE SEQUENCE ddc402022_si178_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa102022_si74_sequencial_seq definition

-- DROP SEQUENCE dispensa102022_si74_sequencial_seq;

CREATE SEQUENCE dispensa102022_si74_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa112022_si75_sequencial_seq definition

-- DROP SEQUENCE dispensa112022_si75_sequencial_seq;

CREATE SEQUENCE dispensa112022_si75_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa122022_si76_sequencial_seq definition

-- DROP SEQUENCE dispensa122022_si76_sequencial_seq;

CREATE SEQUENCE dispensa122022_si76_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa132022_si77_sequencial_seq definition

-- DROP SEQUENCE dispensa132022_si77_sequencial_seq;

CREATE SEQUENCE dispensa132022_si77_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa142022_si78_sequencial_seq definition

-- DROP SEQUENCE dispensa142022_si78_sequencial_seq;

CREATE SEQUENCE dispensa142022_si78_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa152022_si79_sequencial_seq definition

-- DROP SEQUENCE dispensa152022_si79_sequencial_seq;

CREATE SEQUENCE dispensa152022_si79_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa162022_si80_sequencial_seq definition

-- DROP SEQUENCE dispensa162022_si80_sequencial_seq;

CREATE SEQUENCE dispensa162022_si80_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa172022_si81_sequencial_seq definition

-- DROP SEQUENCE dispensa172022_si81_sequencial_seq;

CREATE SEQUENCE dispensa172022_si81_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa182022_si82_sequencial_seq definition

-- DROP SEQUENCE dispensa182022_si82_sequencial_seq;

CREATE SEQUENCE dispensa182022_si82_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp102022_si106_sequencial_seq definition

-- DROP SEQUENCE emp102022_si106_sequencial_seq;

CREATE SEQUENCE emp102022_si106_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp112022_si107_sequencial_seq definition

-- DROP SEQUENCE emp112022_si107_sequencial_seq;

CREATE SEQUENCE emp112022_si107_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp122022_si108_sequencial_seq definition

-- DROP SEQUENCE emp122022_si108_sequencial_seq;

CREATE SEQUENCE emp122022_si108_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- emp202022_si109_sequencial_seq definition

-- DROP SEQUENCE emp202022_si109_sequencial_seq;

CREATE SEQUENCE emp202022_si109_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp302022_si206_sequencial_seq definition

-- DROP SEQUENCE emp302022_si206_sequencial_seq;

CREATE SEQUENCE emp302022_si206_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext102022_si124_sequencial_seq definition

-- DROP SEQUENCE ext102022_si124_sequencial_seq;

CREATE SEQUENCE ext102022_si124_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext202022_si165_sequencial_seq definition

-- DROP SEQUENCE ext202022_si165_sequencial_seq;

CREATE SEQUENCE ext202022_si165_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext302022_si126_sequencial_seq definition

-- DROP SEQUENCE ext302022_si126_sequencial_seq;

CREATE SEQUENCE ext302022_si126_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext312022_si127_sequencial_seq definition

-- DROP SEQUENCE ext312022_si127_sequencial_seq;

CREATE SEQUENCE ext312022_si127_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext322022_si128_sequencial_seq definition

-- DROP SEQUENCE ext322022_si128_sequencial_seq;

CREATE SEQUENCE ext322022_si128_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- hablic102022_si57_sequencial_seq definition

-- DROP SEQUENCE hablic102022_si57_sequencial_seq;

CREATE SEQUENCE hablic102022_si57_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- hablic112022_si58_sequencial_seq definition

-- DROP SEQUENCE hablic112022_si58_sequencial_seq;

CREATE SEQUENCE hablic112022_si58_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- hablic202022_si59_sequencial_seq definition

-- DROP SEQUENCE hablic202022_si59_sequencial_seq;

CREATE SEQUENCE hablic202022_si59_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic102022_si63_sequencial_seq definition

-- DROP SEQUENCE homolic102022_si63_sequencial_seq;

CREATE SEQUENCE homolic102022_si63_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic202022_si64_sequencial_seq definition

-- DROP SEQUENCE homolic202022_si64_sequencial_seq;

CREATE SEQUENCE homolic202022_si64_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic302022_si65_sequencial_seq definition

-- DROP SEQUENCE homolic302022_si65_sequencial_seq;

CREATE SEQUENCE homolic302022_si65_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic402022_si65_sequencial_seq definition

-- DROP SEQUENCE homolic402022_si65_sequencial_seq;

CREATE SEQUENCE homolic402022_si65_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ide2022_si11_sequencial_seq definition

-- DROP SEQUENCE ide2022_si11_sequencial_seq;

CREATE SEQUENCE ide2022_si11_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- idedcasp2022_si200_sequencial_seq definition

-- DROP SEQUENCE idedcasp2022_si200_sequencial_seq;

CREATE SEQUENCE idedcasp2022_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ideedital2022_si186_sequencial_seq definition

-- DROP SEQUENCE ideedital2022_si186_sequencial_seq;

CREATE SEQUENCE ideedital2022_si186_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp102022_si179_sequencial_seq definition

-- DROP SEQUENCE iderp102022_si179_sequencial_seq;

CREATE SEQUENCE iderp102022_si179_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp112022_si180_sequencial_seq definition

-- DROP SEQUENCE iderp112022_si180_sequencial_seq;

CREATE SEQUENCE iderp112022_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp202022_si181_sequencial_seq definition

-- DROP SEQUENCE iderp202022_si181_sequencial_seq;

CREATE SEQUENCE iderp202022_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- item102022_si43_sequencial_seq definition

-- DROP SEQUENCE item102022_si43_sequencial_seq;

CREATE SEQUENCE item102022_si43_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic102022_si60_sequencial_seq definition

-- DROP SEQUENCE julglic102022_si60_sequencial_seq;

CREATE SEQUENCE julglic102022_si60_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic202022_si61_sequencial_seq definition

-- DROP SEQUENCE julglic202022_si61_sequencial_seq;

CREATE SEQUENCE julglic202022_si61_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic302022_si62_sequencial_seq definition

-- DROP SEQUENCE julglic302022_si62_sequencial_seq;

CREATE SEQUENCE julglic302022_si62_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic402022_si62_sequencial_seq definition

-- DROP SEQUENCE julglic402022_si62_sequencial_seq;

CREATE SEQUENCE julglic402022_si62_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao102022_si34_sequencial_seq definition

-- DROP SEQUENCE lao102022_si34_sequencial_seq;

CREATE SEQUENCE lao102022_si34_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao112022_si35_sequencial_seq definition

-- DROP SEQUENCE lao112022_si35_sequencial_seq;

CREATE SEQUENCE lao112022_si35_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao202022_si36_sequencial_seq definition

-- DROP SEQUENCE lao202022_si36_sequencial_seq;

CREATE SEQUENCE lao202022_si36_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao212022_si37_sequencial_seq definition

-- DROP SEQUENCE lao212022_si37_sequencial_seq;

CREATE SEQUENCE lao212022_si37_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd102022_si118_sequencial_seq definition

-- DROP SEQUENCE lqd102022_si118_sequencial_seq;

CREATE SEQUENCE lqd102022_si118_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd112022_si119_sequencial_seq definition

-- DROP SEQUENCE lqd112022_si119_sequencial_seq;

CREATE SEQUENCE lqd112022_si119_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd122022_si120_sequencial_seq definition

-- DROP SEQUENCE lqd122022_si120_sequencial_seq;

CREATE SEQUENCE lqd122022_si120_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf102022_si143_sequencial_seq definition

-- DROP SEQUENCE ntf102022_si143_sequencial_seq;

CREATE SEQUENCE ntf102022_si143_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf112022_si144_sequencial_seq definition

-- DROP SEQUENCE ntf112022_si144_sequencial_seq;

CREATE SEQUENCE ntf112022_si144_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf202022_si145_sequencial_seq definition

-- DROP SEQUENCE ntf202022_si145_sequencial_seq;

CREATE SEQUENCE ntf202022_si145_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- obelac102022_si139_sequencial_seq definition

-- DROP SEQUENCE obelac102022_si139_sequencial_seq;

CREATE SEQUENCE obelac102022_si139_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- obelac112022_si140_sequencial_seq definition

-- DROP SEQUENCE obelac112022_si140_sequencial_seq;

CREATE SEQUENCE obelac112022_si140_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops102022_si132_sequencial_seq definition

-- DROP SEQUENCE ops102022_si132_sequencial_seq;

CREATE SEQUENCE ops102022_si132_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops112022_si133_sequencial_seq definition

-- DROP SEQUENCE ops112022_si133_sequencial_seq;

CREATE SEQUENCE ops112022_si133_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops122022_si134_sequencial_seq definition

-- DROP SEQUENCE ops122022_si134_sequencial_seq;

CREATE SEQUENCE ops122022_si134_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops132022_si135_sequencial_seq definition

-- DROP SEQUENCE ops132022_si135_sequencial_seq;

CREATE SEQUENCE ops132022_si135_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- orgao102022_si14_sequencial_seq definition

-- DROP SEQUENCE orgao102022_si14_sequencial_seq;

CREATE SEQUENCE orgao102022_si14_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- orgao112022_si15_sequencial_seq definition

-- DROP SEQUENCE orgao112022_si15_sequencial_seq;

CREATE SEQUENCE orgao112022_si15_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec102022_si22_sequencial_seq definition

-- DROP SEQUENCE parec102022_si22_sequencial_seq;

CREATE SEQUENCE parec102022_si22_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec102022_si66_sequencial_seq definition

-- DROP SEQUENCE parec102022_si66_sequencial_seq;

CREATE SEQUENCE parec102022_si66_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec112022_si23_sequencial_seq definition

-- DROP SEQUENCE parec112022_si23_sequencial_seq;

CREATE SEQUENCE parec112022_si23_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parpps102022_si156_sequencial_seq definition

-- DROP SEQUENCE parpps102022_si156_sequencial_seq;

CREATE SEQUENCE parpps102022_si156_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- parpps202022_si155_sequencial_seq definition

-- DROP SEQUENCE parpps202022_si155_sequencial_seq;

CREATE SEQUENCE parpps202022_si155_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoa102022_si12_sequencial_seq definition

-- DROP SEQUENCE pessoa102022_si12_sequencial_seq;

CREATE SEQUENCE pessoa102022_si12_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoaflpgo102022_si193_sequencial_seq definition

-- DROP SEQUENCE pessoaflpgo102022_si193_sequencial_seq;

CREATE SEQUENCE pessoaflpgo102022_si193_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoasobra102022_si194_sequencial_seq definition

-- DROP SEQUENCE pessoasobra102022_si194_sequencial_seq;

CREATE SEQUENCE pessoasobra102022_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rec102022_si25_sequencial_seq definition

-- DROP SEQUENCE rec102022_si25_sequencial_seq;

CREATE SEQUENCE rec102022_si25_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rec112022_si26_sequencial_seq definition

-- DROP SEQUENCE rec112022_si26_sequencial_seq;

CREATE SEQUENCE rec112022_si26_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao102022_si67_sequencial_seq definition

-- DROP SEQUENCE regadesao102022_si67_sequencial_seq;

CREATE SEQUENCE regadesao102022_si67_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao112022_si68_sequencial_seq definition

-- DROP SEQUENCE regadesao112022_si68_sequencial_seq;

CREATE SEQUENCE regadesao112022_si68_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao122022_si69_sequencial_seq definition

-- DROP SEQUENCE regadesao122022_si69_sequencial_seq;

CREATE SEQUENCE regadesao122022_si69_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao132022_si70_sequencial_seq definition

-- DROP SEQUENCE regadesao132022_si70_sequencial_seq;

CREATE SEQUENCE regadesao132022_si70_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao142022_si71_sequencial_seq definition

-- DROP SEQUENCE regadesao142022_si71_sequencial_seq;

CREATE SEQUENCE regadesao142022_si71_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao152022_si72_sequencial_seq definition

-- DROP SEQUENCE regadesao152022_si72_sequencial_seq;

CREATE SEQUENCE regadesao152022_si72_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- regadesao202022_si73_sequencial_seq definition

-- DROP SEQUENCE regadesao202022_si73_sequencial_seq;

CREATE SEQUENCE regadesao202022_si73_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- reglic102022_si44_sequencial_seq definition

-- DROP SEQUENCE reglic102022_si44_sequencial_seq;

CREATE SEQUENCE reglic102022_si44_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- reglic202022_si45_sequencial_seq definition

-- DROP SEQUENCE reglic202022_si45_sequencial_seq;

CREATE SEQUENCE reglic202022_si45_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- resplic102022_si55_sequencial_seq definition

-- DROP SEQUENCE resplic102022_si55_sequencial_seq;

CREATE SEQUENCE resplic102022_si55_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- resplic202022_si56_sequencial_seq definition

-- DROP SEQUENCE resplic202022_si56_sequencial_seq;

CREATE SEQUENCE resplic202022_si56_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp102022_si112_sequencial_seq definition

-- DROP SEQUENCE rsp102022_si112_sequencial_seq;

CREATE SEQUENCE rsp102022_si112_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp112022_si113_sequencial_seq definition

-- DROP SEQUENCE rsp112022_si113_sequencial_seq;

CREATE SEQUENCE rsp112022_si113_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp122022_si114_sequencial_seq definition

-- DROP SEQUENCE rsp122022_si114_sequencial_seq;

CREATE SEQUENCE rsp122022_si114_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp202022_si115_sequencial_seq definition

-- DROP SEQUENCE rsp202022_si115_sequencial_seq;

CREATE SEQUENCE rsp202022_si115_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp212022_si116_sequencial_seq definition

-- DROP SEQUENCE rsp212022_si116_sequencial_seq;

CREATE SEQUENCE rsp212022_si116_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp222022_si117_sequencial_seq definition

-- DROP SEQUENCE rsp222022_si117_sequencial_seq;

CREATE SEQUENCE rsp222022_si117_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- tce102022_si187_sequencial_seq definition

-- DROP SEQUENCE tce102022_si187_sequencial_seq;

CREATE SEQUENCE tce102022_si187_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- tce112022_si188_sequencial_seq definition

-- DROP SEQUENCE tce112022_si188_sequencial_seq;

CREATE SEQUENCE tce112022_si188_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;



-- bfdcasp102022 definition

-- Drop table

-- DROP TABLE bfdcasp102022;

CREATE TABLE bfdcasp102022 (
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
    CONSTRAINT bfdcasp102022_sequ_pk PRIMARY KEY (si206_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bfdcasp202022 definition

-- Drop table

-- DROP TABLE bfdcasp202022;

CREATE TABLE bfdcasp202022 (
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
    CONSTRAINT bfdcasp202022_sequ_pk PRIMARY KEY (si207_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp102022 definition

-- Drop table

-- DROP TABLE bodcasp102022;

CREATE TABLE bodcasp102022 (
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
    CONSTRAINT bodcasp102022_sequ_pk PRIMARY KEY (si201_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp202022 definition

-- Drop table

-- DROP TABLE bodcasp202022;

CREATE TABLE bodcasp202022 (
    si202_sequencial int4 NOT NULL DEFAULT 0,
    si202_tiporegistro int4 NOT NULL DEFAULT 0,
    si202_faserecorcamentaria int4 NOT NULL DEFAULT 0,
    si202_vlsaldoexeantsupfin float8 NOT NULL DEFAULT 0,
    si202_vlsaldoexeantrecredad float8 NOT NULL DEFAULT 0,
    si202_vltotalsaldoexeant float8 NULL DEFAULT 0,
    si202_anousu int4 NOT NULL DEFAULT 0,
    si202_periodo int4 NOT NULL DEFAULT 0,
    si202_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT bodcasp202022_sequ_pk PRIMARY KEY (si202_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp302022 definition

-- Drop table

-- DROP TABLE bodcasp302022;

CREATE TABLE bodcasp302022 (
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
    CONSTRAINT bodcasp302022_sequ_pk PRIMARY KEY (si203_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp402022 definition

-- Drop table

-- DROP TABLE bodcasp402022;

CREATE TABLE bodcasp402022 (
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
    CONSTRAINT bodcasp402022_sequ_pk PRIMARY KEY (si204_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bodcasp502022 definition

-- Drop table

-- DROP TABLE bodcasp502022;

CREATE TABLE bodcasp502022 (
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
    CONSTRAINT bodcasp502022_sequ_pk PRIMARY KEY (si205_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp102022 definition

-- Drop table

-- DROP TABLE bpdcasp102022;

CREATE TABLE bpdcasp102022 (
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
    CONSTRAINT bpdcasp102022_sequ_pk PRIMARY KEY (si208_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp202022 definition

-- Drop table

-- DROP TABLE bpdcasp202022;

CREATE TABLE bpdcasp202022 (
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
    CONSTRAINT bpdcasp202022_sequ_pk PRIMARY KEY (si209_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp302022 definition

-- Drop table

-- DROP TABLE bpdcasp302022;

CREATE TABLE bpdcasp302022 (
    si210_sequencial int4 NOT NULL DEFAULT 0,
    si210_tiporegistro int4 NOT NULL DEFAULT 0,
    si210_exercicio int4 NOT NULL DEFAULT 0,
    si210_vlativofinanceiro float8 NOT NULL DEFAULT 0,
    si210_vlativopermanente float8 NOT NULL DEFAULT 0,
    si210_vltotalativofinanceiropermanente float8 NULL DEFAULT 0,
    si210_ano int4 NOT NULL DEFAULT 0,
    si210_periodo int4 NOT NULL DEFAULT 0,
    si210_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp302022_sequ_pk PRIMARY KEY (si210_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp402022 definition

-- Drop table

-- DROP TABLE bpdcasp402022;

CREATE TABLE bpdcasp402022 (
    si211_sequencial int4 NOT NULL DEFAULT 0,
    si211_tiporegistro int4 NOT NULL DEFAULT 0,
    si211_exercicio int4 NOT NULL DEFAULT 0,
    si211_vlpassivofinanceiro float8 NOT NULL DEFAULT 0,
    si211_vlpassivopermanente float8 NOT NULL DEFAULT 0,
    si211_vltotalpassivofinanceiropermanente float8 NULL DEFAULT 0,
    si211_ano int4 NOT NULL DEFAULT 0,
    si211_periodo int4 NOT NULL DEFAULT 0,
    si211_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp402022_sequ_pk PRIMARY KEY (si211_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp502022 definition

-- Drop table

-- DROP TABLE bpdcasp502022;

CREATE TABLE bpdcasp502022 (
    si212_sequencial int4 NOT NULL DEFAULT 0,
    si212_tiporegistro int4 NOT NULL DEFAULT 0,
    si212_exercicio int4 NOT NULL DEFAULT 0,
    si212_vlsaldopatrimonial float8 NULL DEFAULT 0,
    si212_ano int4 NOT NULL DEFAULT 0,
    si212_periodo int4 NOT NULL DEFAULT 0,
    si212_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp502022_sequ_pk PRIMARY KEY (si212_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp602022 definition

-- Drop table

-- DROP TABLE bpdcasp602022;

CREATE TABLE bpdcasp602022 (
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
    CONSTRAINT bpdcasp602022_sequ_pk PRIMARY KEY (si213_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp702022 definition

-- Drop table

-- DROP TABLE bpdcasp702022;

CREATE TABLE bpdcasp702022 (
    si214_sequencial int4 NOT NULL DEFAULT 0,
    si214_tiporegistro int4 NOT NULL DEFAULT 0,
    si214_exercicio int4 NOT NULL DEFAULT 0,
    si214_vltotalsupdef float8 NULL DEFAULT 0,
    si214_ano int4 NOT NULL DEFAULT 0,
    si214_periodo int4 NOT NULL DEFAULT 0,
    si214_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp702022_sequ_pk PRIMARY KEY (si214_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bpdcasp712022 definition

-- Drop table

-- DROP TABLE bpdcasp712022;

CREATE TABLE bpdcasp712022 (
    si215_sequencial int4 NOT NULL DEFAULT 0,
    si215_tiporegistro int4 NOT NULL DEFAULT 0,
    si215_exercicio int4 NOT NULL DEFAULT 0,
    si215_codfontrecursos int4 NOT NULL DEFAULT 0,
    si215_vlsaldofonte float8 NULL DEFAULT 0,
    si215_ano int4 NOT NULL DEFAULT 0,
    si215_periodo int4 NOT NULL DEFAULT 0,
    si215_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT bpdcasp712022_sequ_pk PRIMARY KEY (si215_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp1002022 definition

-- Drop table

-- DROP TABLE dfcdcasp1002022;

CREATE TABLE dfcdcasp1002022 (
    si228_sequencial int4 NOT NULL DEFAULT 0,
    si228_tiporegistro int4 NOT NULL DEFAULT 0,
    si228_vlgeracaoliquidaequivalentecaixa float8 NULL DEFAULT 0,
    si228_anousu int4 NOT NULL DEFAULT 0,
    si228_periodo int4 NOT NULL DEFAULT 0,
    si228_mes int4 NOT NULL DEFAULT 0,
    si228_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp1002022_sequ_pk PRIMARY KEY (si228_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp102022 definition

-- Drop table

-- DROP TABLE dfcdcasp102022;

CREATE TABLE dfcdcasp102022 (
    si219_sequencial int4 NOT NULL DEFAULT 0,
    si219_tiporegistro int4 NOT NULL DEFAULT 0,
    si219_vlreceitaderivadaoriginaria float8 NOT NULL DEFAULT 0,
    si219_vltranscorrenterecebida float8 NOT NULL DEFAULT 0,
    si219_vloutrosingressosoperacionais float8 NOT NULL DEFAULT 0,
    si219_vltotalingressosativoperacionais float8 NULL DEFAULT 0,
    si219_anousu int4 NOT NULL DEFAULT 0,
    si219_periodo int4 NOT NULL DEFAULT 0,
    si219_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp102022_sequ_pk PRIMARY KEY (si219_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp1102022 definition

-- Drop table

-- DROP TABLE dfcdcasp1102022;

CREATE TABLE dfcdcasp1102022 (
    si229_sequencial int4 NOT NULL DEFAULT 0,
    si229_tiporegistro int4 NOT NULL DEFAULT 0,
    si229_vlcaixaequivalentecaixainicial float8 NOT NULL DEFAULT 0,
    si229_vlcaixaequivalentecaixafinal float8 NULL DEFAULT 0,
    si229_anousu int4 NOT NULL DEFAULT 0,
    si229_periodo int4 NOT NULL DEFAULT 0,
    si229_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp1102022_sequ_pk PRIMARY KEY (si229_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp202022 definition

-- Drop table

-- DROP TABLE dfcdcasp202022;

CREATE TABLE dfcdcasp202022 (
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
    CONSTRAINT dfcdcasp202022_sequ_pk PRIMARY KEY (si220_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp302022 definition

-- Drop table

-- DROP TABLE dfcdcasp302022;

CREATE TABLE dfcdcasp302022 (
    si221_sequencial int4 NOT NULL DEFAULT 0,
    si221_tiporegistro int4 NOT NULL DEFAULT 0,
    si221_vlfluxocaixaliquidooperacional float8 NULL DEFAULT 0,
    si221_anousu int4 NOT NULL DEFAULT 0,
    si221_periodo int4 NOT NULL DEFAULT 0,
    si221_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp302022_sequ_pk PRIMARY KEY (si221_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp402022 definition

-- Drop table

-- DROP TABLE dfcdcasp402022;

CREATE TABLE dfcdcasp402022 (
    si222_sequencial int4 NOT NULL DEFAULT 0,
    si222_tiporegistro int4 NOT NULL DEFAULT 0,
    si222_vlalienacaobens float8 NOT NULL DEFAULT 0,
    si222_vlamortizacaoemprestimoconcedido float8 NOT NULL DEFAULT 0,
    si222_vloutrosingressos float8 NOT NULL DEFAULT 0,
    si222_vltotalingressosatividainvestiment float8 NULL DEFAULT 0,
    si222_anousu int4 NOT NULL DEFAULT 0,
    si222_periodo int4 NOT NULL DEFAULT 0,
    si222_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp402022_sequ_pk PRIMARY KEY (si222_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp502022 definition

-- Drop table

-- DROP TABLE dfcdcasp502022;

CREATE TABLE dfcdcasp502022 (
    si223_sequencial int4 NOT NULL DEFAULT 0,
    si223_tiporegistro int4 NOT NULL DEFAULT 0,
    si223_vlaquisicaoativonaocirculante float8 NOT NULL DEFAULT 0,
    si223_vlconcessaoempresfinanciamento float8 NOT NULL DEFAULT 0,
    si223_vloutrosdesembolsos float8 NOT NULL DEFAULT 0,
    si223_vltotaldesembolsoatividainvestimen float8 NULL DEFAULT 0,
    si223_anousu int4 NOT NULL DEFAULT 0,
    si223_periodo int4 NOT NULL DEFAULT 0,
    si223_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp502022_sequ_pk PRIMARY KEY (si223_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp602022 definition

-- Drop table

-- DROP TABLE dfcdcasp602022;

CREATE TABLE dfcdcasp602022 (
    si224_sequencial int4 NOT NULL DEFAULT 0,
    si224_tiporegistro int4 NOT NULL DEFAULT 0,
    si224_vlfluxocaixaliquidoinvestimento float8 NULL DEFAULT 0,
    si224_anousu int4 NOT NULL DEFAULT 0,
    si224_periodo int4 NOT NULL DEFAULT 0,
    si224_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp602022_sequ_pk PRIMARY KEY (si224_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp702022 definition

-- Drop table

-- DROP TABLE dfcdcasp702022;

CREATE TABLE dfcdcasp702022 (
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
    CONSTRAINT dfcdcasp702022_sequ_pk PRIMARY KEY (si225_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp802022 definition

-- Drop table

-- DROP TABLE dfcdcasp802022;

CREATE TABLE dfcdcasp802022 (
    si226_sequencial int4 NOT NULL DEFAULT 0,
    si226_tiporegistro int4 NOT NULL DEFAULT 0,
    si226_vlamortizacaorefinanciamento float8 NOT NULL DEFAULT 0,
    si226_vloutrosdesembolsosfinanciamento float8 NOT NULL DEFAULT 0,
    si226_vltotaldesembolsoatividafinanciame float8 NULL DEFAULT 0,
    si226_anousu int4 NOT NULL DEFAULT 0,
    si226_periodo int4 NOT NULL DEFAULT 0,
    si226_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp802022_sequ_pk PRIMARY KEY (si226_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dfcdcasp902022 definition

-- Drop table

-- DROP TABLE dfcdcasp902022;

CREATE TABLE dfcdcasp902022 (
    si227_sequencial int4 NOT NULL DEFAULT 0,
    si227_tiporegistro int4 NOT NULL DEFAULT 0,
    si227_vlfluxocaixafinanciamento float8 NULL DEFAULT 0,
    si227_anousu int4 NOT NULL DEFAULT 0,
    si227_periodo int4 NOT NULL DEFAULT 0,
    si227_instit int4 NOT NULL DEFAULT 0,
    CONSTRAINT dfcdcasp902022_sequ_pk PRIMARY KEY (si227_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dvpdcasp102022 definition

-- Drop table

-- DROP TABLE dvpdcasp102022;

CREATE TABLE dvpdcasp102022 (
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
    CONSTRAINT dvpdcasp102022_sequ_pk PRIMARY KEY (si216_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dvpdcasp202022 definition

-- Drop table

-- DROP TABLE dvpdcasp202022;

CREATE TABLE dvpdcasp202022 (
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
    CONSTRAINT dvpdcasp202022_sequ_pk PRIMARY KEY (si217_sequencial)
)
WITH (
    OIDS=TRUE
);


-- dvpdcasp302022 definition

-- Drop table

-- DROP TABLE dvpdcasp302022;

CREATE TABLE dvpdcasp302022 (
    si218_sequencial int4 NOT NULL DEFAULT 0,
    si218_tiporegistro int4 NOT NULL DEFAULT 0,
    si218_vlresultadopatrimonialperiodo float8 NULL DEFAULT 0,
    si218_ano int4 NOT NULL DEFAULT 0,
    si218_periodo int4 NOT NULL DEFAULT 0,
    si218_institu int4 NOT NULL DEFAULT 0,
    CONSTRAINT dvpdcasp302022_sequ_pk PRIMARY KEY (si218_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rpsd102022 definition

-- Drop table

-- DROP TABLE rpsd102022;

CREATE TABLE rpsd102022 (
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
    CONSTRAINT rpsd102022_sequ_pk PRIMARY KEY (si189_sequencial)
)
WITH (
    OIDS=TRUE
);


-- rpsd112022 definition

-- Drop table

-- DROP TABLE rpsd112022;

CREATE TABLE rpsd112022 (
    si190_sequencial int8 NOT NULL DEFAULT 0,
    si190_tiporegistro int8 NOT NULL DEFAULT 0,
    si190_codreduzidorsp int8 NOT NULL DEFAULT 0,
    si190_codfontrecursos int8 NOT NULL DEFAULT 0,
    si190_vlpagofontersp float8 NOT NULL DEFAULT 0,
    si190_reg10 int8 NOT NULL DEFAULT 0,
    si190_mes int8 NOT NULL DEFAULT 0,
    si190_instit int8 NULL DEFAULT 0,
    CONSTRAINT rpsd112022_sequ_pk PRIMARY KEY (si190_sequencial),
    CONSTRAINT rpsd112022_reg10_fk FOREIGN KEY (si190_reg10) REFERENCES rpsd102022(si189_sequencial)
)
WITH (
    OIDS=TRUE
);


-- bfdcasp102022_si206_sequencial_seq definition

-- DROP SEQUENCE bfdcasp102022_si206_sequencial_seq;

CREATE SEQUENCE bfdcasp102022_si206_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bfdcasp202022_si207_sequencial_seq definition

-- DROP SEQUENCE bfdcasp202022_si207_sequencial_seq;

CREATE SEQUENCE bfdcasp202022_si207_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp102022_si201_sequencial_seq definition

-- DROP SEQUENCE bodcasp102022_si201_sequencial_seq;

CREATE SEQUENCE bodcasp102022_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp202022_si202_sequencial_seq definition

-- DROP SEQUENCE bodcasp202022_si202_sequencial_seq;

CREATE SEQUENCE bodcasp202022_si202_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp302022_si203_sequencial_seq definition

-- DROP SEQUENCE bodcasp302022_si203_sequencial_seq;

CREATE SEQUENCE bodcasp302022_si203_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp402022_si204_sequencial_seq definition

-- DROP SEQUENCE bodcasp402022_si204_sequencial_seq;

CREATE SEQUENCE bodcasp402022_si204_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp502022_si205_sequencial_seq definition

-- DROP SEQUENCE bodcasp502022_si205_sequencial_seq;

CREATE SEQUENCE bodcasp502022_si205_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp102022_si208_sequencial_seq definition

-- DROP SEQUENCE bpdcasp102022_si208_sequencial_seq;

CREATE SEQUENCE bpdcasp102022_si208_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp202022_si209_sequencial_seq definition

-- DROP SEQUENCE bpdcasp202022_si209_sequencial_seq;

CREATE SEQUENCE bpdcasp202022_si209_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp302022_si210_sequencial_seq definition

-- DROP SEQUENCE bpdcasp302022_si210_sequencial_seq;

CREATE SEQUENCE bpdcasp302022_si210_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp402022_si211_sequencial_seq definition

-- DROP SEQUENCE bpdcasp402022_si211_sequencial_seq;

CREATE SEQUENCE bpdcasp402022_si211_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp502022_si212_sequencial_seq definition

-- DROP SEQUENCE bpdcasp502022_si212_sequencial_seq;

CREATE SEQUENCE bpdcasp502022_si212_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp602022_si213_sequencial_seq definition

-- DROP SEQUENCE bpdcasp602022_si213_sequencial_seq;

CREATE SEQUENCE bpdcasp602022_si213_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp702022_si214_sequencial_seq definition

-- DROP SEQUENCE bpdcasp702022_si214_sequencial_seq;

CREATE SEQUENCE bpdcasp702022_si214_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp712022_si215_sequencial_seq definition

-- DROP SEQUENCE bpdcasp712022_si215_sequencial_seq;

CREATE SEQUENCE bpdcasp712022_si215_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp1002022_si228_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp1002022_si228_sequencial_seq;

CREATE SEQUENCE dfcdcasp1002022_si228_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp102022_si219_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp102022_si219_sequencial_seq;

CREATE SEQUENCE dfcdcasp102022_si219_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp1102022_si229_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp1102022_si229_sequencial_seq;

CREATE SEQUENCE dfcdcasp1102022_si229_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp202022_si220_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp202022_si220_sequencial_seq;

CREATE SEQUENCE dfcdcasp202022_si220_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp302022_si221_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp302022_si221_sequencial_seq;

CREATE SEQUENCE dfcdcasp302022_si221_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp402022_si222_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp402022_si222_sequencial_seq;

CREATE SEQUENCE dfcdcasp402022_si222_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp502022_si223_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp502022_si223_sequencial_seq;

CREATE SEQUENCE dfcdcasp502022_si223_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp602022_si224_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp602022_si224_sequencial_seq;

CREATE SEQUENCE dfcdcasp602022_si224_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp702022_si225_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp702022_si225_sequencial_seq;

CREATE SEQUENCE dfcdcasp702022_si225_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp802022_si226_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp802022_si226_sequencial_seq;

CREATE SEQUENCE dfcdcasp802022_si226_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp902022_si227_sequencial_seq definition

-- DROP SEQUENCE dfcdcasp902022_si227_sequencial_seq;

CREATE SEQUENCE dfcdcasp902022_si227_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp102022_si216_sequencial_seq definition

-- DROP SEQUENCE dvpdcasp102022_si216_sequencial_seq;

CREATE SEQUENCE dvpdcasp102022_si216_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp202022_si217_sequencial_seq definition

-- DROP SEQUENCE dvpdcasp202022_si217_sequencial_seq;

CREATE SEQUENCE dvpdcasp202022_si217_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp302022_si218_sequencial_seq definition

-- DROP SEQUENCE dvpdcasp302022_si218_sequencial_seq;

CREATE SEQUENCE dvpdcasp302022_si218_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rpsd102022_si189_sequencial_seq definition

-- DROP SEQUENCE rpsd102022_si189_sequencial_seq;

CREATE SEQUENCE rpsd102022_si189_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rpsd112022_si190_sequencial_seq definition

-- DROP SEQUENCE rpsd112022_si190_sequencial_seq;

CREATE SEQUENCE rpsd112022_si190_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- balancete102022 definition

-- Drop table

-- DROP TABLE balancete102022;

CREATE TABLE balancete102022 (
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
    CONSTRAINT balancete102022_sequ_pk PRIMARY KEY (si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete112022 definition

-- Drop table

-- DROP TABLE balancete112022;

CREATE TABLE balancete112022 (
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
    CONSTRAINT balancete112022_sequ_pk PRIMARY KEY (si178_sequencial),
    CONSTRAINT fk_balancete112022_reg10_fk FOREIGN KEY (si178_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete122022 definition

-- Drop table

-- DROP TABLE balancete122022;

CREATE TABLE balancete122022 (
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
    CONSTRAINT balancete122022_sequ_pk PRIMARY KEY (si179_sequencial),
    CONSTRAINT fk_balancete122022_reg10_fk FOREIGN KEY (si179_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete132022 definition

-- Drop table

-- DROP TABLE balancete132022;

CREATE TABLE balancete132022 (
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
    CONSTRAINT balancete132022_sequ_pk PRIMARY KEY (si180_sequencial),
    CONSTRAINT fk_balancete132022_reg10_fk FOREIGN KEY (si180_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete142022 definition

-- Drop table

-- DROP TABLE balancete142022;

CREATE TABLE balancete142022 (
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
    CONSTRAINT balancete142022_sequ_pk PRIMARY KEY (si181_sequencial),
    CONSTRAINT fk_balancete142022_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete152022 definition

-- Drop table

-- DROP TABLE balancete152022;

CREATE TABLE balancete152022 (
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
    CONSTRAINT balancete152022_sequ_pk PRIMARY KEY (si182_sequencial),
    CONSTRAINT fk_balancete152022_reg10_fk FOREIGN KEY (si182_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete162022 definition

-- Drop table

-- DROP TABLE balancete162022;

CREATE TABLE balancete162022 (
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
    CONSTRAINT balancete162022_sequ_pk PRIMARY KEY (si183_sequencial),
    CONSTRAINT fk_balancete162022_reg10_fk FOREIGN KEY (si183_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete172022 definition

-- Drop table

-- DROP TABLE balancete172022;

CREATE TABLE balancete172022 (
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
    CONSTRAINT balancete172022_sequ_pk PRIMARY KEY (si184_sequencial),
    CONSTRAINT fk_balancete172022_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete182022 definition

-- Drop table

-- DROP TABLE balancete182022;

CREATE TABLE balancete182022 (
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
    CONSTRAINT balancete182022_sequ_pk PRIMARY KEY (si185_sequencial),
    CONSTRAINT fk_balancete182022_reg10_fk FOREIGN KEY (si185_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete192022 definition

-- Drop table

-- DROP TABLE balancete192022;

CREATE TABLE balancete192022 (
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
    CONSTRAINT balancete192022_sequ_pk PRIMARY KEY (si186_sequencial),
    CONSTRAINT fk_balancete192022_reg10_fk FOREIGN KEY (si186_reg10) REFERENCES balancete102022(si177_sequencial)
)
WITH (
    OIDS=TRUE
);

-- balancete202022 definition

-- Drop table

-- DROP TABLE balancete202022;

CREATE TABLE balancete202022 (
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
    CONSTRAINT balancete202022_sequ_pk PRIMARY KEY (si187_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete212022 definition

-- Drop table

-- DROP TABLE balancete212022;

CREATE TABLE balancete212022 (
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
    CONSTRAINT balancete212022_sequ_pk PRIMARY KEY (si188_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete222022 definition

-- Drop table

-- DROP TABLE balancete222022;

CREATE TABLE balancete222022 (
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
    CONSTRAINT balancete222022_sequ_pk PRIMARY KEY (si189_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete232022 definition

-- Drop table

-- DROP TABLE balancete232022;

CREATE TABLE balancete232022 (
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
    CONSTRAINT balancete232022_sequ_pk PRIMARY KEY (si190_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete242022 definition

-- Drop table

-- DROP TABLE balancete242022;

CREATE TABLE balancete242022 (
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
    CONSTRAINT balancete242022_sequ_pk PRIMARY KEY (si191_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete252022 definition

-- Drop table

-- DROP TABLE balancete252022;

CREATE TABLE balancete252022 (
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
    CONSTRAINT balancete252022_sequ_pk PRIMARY KEY (si195_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete262022 definition

-- Drop table

-- DROP TABLE balancete262022;

CREATE TABLE balancete262022 (
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
    CONSTRAINT balancete262022_sequ_pk PRIMARY KEY (si196_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete272022 definition

-- Drop table

-- DROP TABLE balancete272022;

CREATE TABLE balancete272022 (
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
    CONSTRAINT balancete272022_sequ_pk PRIMARY KEY (si197_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete282022 definition

-- Drop table

-- DROP TABLE balancete282022;

CREATE TABLE balancete282022 (
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
    CONSTRAINT balancete282022_sequ_pk PRIMARY KEY (si198_sequencial)
)
WITH (
    OIDS=TRUE
);


-- balancete202022 foreign keys

ALTER TABLE balancete202022 ADD CONSTRAINT fk_balancete202022_reg10_fk FOREIGN KEY (si187_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete212022 foreign keys

ALTER TABLE balancete212022 ADD CONSTRAINT fk_balancete212022_reg10_fk FOREIGN KEY (si188_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete222022 foreign keys

ALTER TABLE balancete222022 ADD CONSTRAINT fk_balancete222022_si77_sequencial FOREIGN KEY (si189_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete232022 foreign keys

ALTER TABLE balancete232022 ADD CONSTRAINT fk_balancete232022_reg10_fk FOREIGN KEY (si190_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete242022 foreign keys

ALTER TABLE balancete242022 ADD CONSTRAINT fk_balancete242022_reg10_fk FOREIGN KEY (si191_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete252022 foreign keys

ALTER TABLE balancete252022 ADD CONSTRAINT fk_balancete102022_reg10_fk FOREIGN KEY (si195_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete262022 foreign keys

ALTER TABLE balancete262022 ADD CONSTRAINT fk_balancete102022_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete272022 foreign keys

ALTER TABLE balancete272022 ADD CONSTRAINT fk_balancete272022_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES balancete102022(si177_sequencial);


-- balancete282022 foreign keys

ALTER TABLE balancete282022 ADD CONSTRAINT fk_balancete282022_reg10_fk FOREIGN KEY (si198_reg10) REFERENCES balancete102022(si177_sequencial);

-- balancete102022_si177_sequencial_seq definition

-- DROP SEQUENCE balancete102022_si177_sequencial_seq;

CREATE SEQUENCE balancete102022_si177_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete112022_si178_sequencial_seq definition

-- DROP SEQUENCE balancete112022_si178_sequencial_seq;

CREATE SEQUENCE balancete112022_si178_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete122022_si179_sequencial_seq definition

-- DROP SEQUENCE balancete122022_si179_sequencial_seq;

CREATE SEQUENCE balancete122022_si179_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete132022_si180_sequencial_seq definition

-- DROP SEQUENCE balancete132022_si180_sequencial_seq;

CREATE SEQUENCE balancete132022_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete142022_si181_sequencial_seq definition

-- DROP SEQUENCE balancete142022_si181_sequencial_seq;

CREATE SEQUENCE balancete142022_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete152022_si182_sequencial_seq definition

-- DROP SEQUENCE balancete152022_si182_sequencial_seq;

CREATE SEQUENCE balancete152022_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete162022_si183_sequencial_seq definition

-- DROP SEQUENCE balancete162022_si183_sequencial_seq;

CREATE SEQUENCE balancete162022_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete172022_si184_sequencial_seq definition

-- DROP SEQUENCE balancete172022_si184_sequencial_seq;

CREATE SEQUENCE balancete172022_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete182022_si185_sequencial_seq definition

-- DROP SEQUENCE balancete182022_si185_sequencial_seq;

CREATE SEQUENCE balancete182022_si185_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete182022_si186_sequencial_seq definition

-- DROP SEQUENCE balancete182022_si186_sequencial_seq;

CREATE SEQUENCE balancete182022_si186_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete192022_si186_sequencial_seq definition

-- DROP SEQUENCE balancete192022_si186_sequencial_seq;

CREATE SEQUENCE balancete192022_si186_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete202022_si187_sequencial_seq definition

-- DROP SEQUENCE balancete202022_si187_sequencial_seq;

CREATE SEQUENCE balancete202022_si187_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete212022_si188_sequencial_seq definition

-- DROP SEQUENCE balancete212022_si188_sequencial_seq;

CREATE SEQUENCE balancete212022_si188_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete222022_si189_sequencial_seq definition

-- DROP SEQUENCE balancete222022_si189_sequencial_seq;

CREATE SEQUENCE balancete222022_si189_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete232022_si190_sequencial_seq definition

-- DROP SEQUENCE balancete232022_si190_sequencial_seq;

CREATE SEQUENCE balancete232022_si190_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete242022_si191_sequencial_seq definition

-- DROP SEQUENCE balancete242022_si191_sequencial_seq;

CREATE SEQUENCE balancete242022_si191_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete252022_si195_sequencial_seq definition

-- DROP SEQUENCE balancete252022_si195_sequencial_seq;

CREATE SEQUENCE balancete252022_si195_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete262022_si196_sequencial_seq definition

-- DROP SEQUENCE balancete262022_si196_sequencial_seq;

CREATE SEQUENCE balancete262022_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete272022_si197_sequencial_seq definition

-- DROP SEQUENCE balancete272022_si197_sequencial_seq;

CREATE SEQUENCE balancete272022_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- balancete282022_si198_sequencial_seq definition

-- DROP SEQUENCE balancete282022_si198_sequencial_seq;

CREATE SEQUENCE balancete282022_si198_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic102022 definition

-- Drop table

-- DROP TABLE ralic102022;

CREATE TABLE ralic102022 (
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
    CONSTRAINT ralic102022_sequ_pk PRIMARY KEY (si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- redispi102022 definition

-- Drop table

-- DROP TABLE redispi102022;

CREATE TABLE redispi102022 (
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
    CONSTRAINT redispi102022_sequ_pk PRIMARY KEY (si183_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ralic112022 definition

-- Drop table

-- DROP TABLE ralic112022;

CREATE TABLE ralic112022 (
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
    CONSTRAINT ralic112022_sequ_pk PRIMARY KEY (si181_sequencial),
    CONSTRAINT ralic112022_reg10_fk FOREIGN KEY (si181_reg10) REFERENCES ralic102022(si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- ralic122022 definition

-- Drop table

-- DROP TABLE ralic122022;

CREATE TABLE ralic122022 (
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
    CONSTRAINT ralic122022_sequ_pk PRIMARY KEY (si182_sequencial),
    CONSTRAINT ralic122022_reg10_fk FOREIGN KEY (si182_reg10) REFERENCES ralic102022(si180_sequencial)
)
WITH (
    OIDS=TRUE
);


-- redispi112022 definition

-- Drop table

-- DROP TABLE redispi112022;

CREATE TABLE redispi112022 (
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
    CONSTRAINT redispi112022_sequ_pk PRIMARY KEY (si184_sequencial),
    CONSTRAINT redispi112022_reg10_fk FOREIGN KEY (si184_reg10) REFERENCES redispi102022(si183_sequencial)
)
WITH (
    OIDS=TRUE
);


-- redispi122022 definition

-- Drop table

-- DROP TABLE redispi122022;

CREATE TABLE redispi122022 (
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
    CONSTRAINT redispi122022_sequ_pk PRIMARY KEY (si185_sequencial),
    CONSTRAINT redispi122022_reg10_fk FOREIGN KEY (si185_reg10) REFERENCES redispi102022(si183_sequencial)
)
WITH (
    OIDS=TRUE
);

-- ralic102022_si180_sequencial_seq definition

-- DROP SEQUENCE ralic102022_si180_sequencial_seq;

CREATE SEQUENCE ralic102022_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic112022_si181_sequencial_seq definition

-- DROP SEQUENCE ralic112022_si181_sequencial_seq;

CREATE SEQUENCE ralic112022_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic122022_si182_sequencial_seq definition

-- DROP SEQUENCE ralic122022_si182_sequencial_seq;

CREATE SEQUENCE ralic122022_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi102022_si183_sequencial_seq definition

-- DROP SEQUENCE redispi102022_si183_sequencial_seq;

CREATE SEQUENCE redispi102022_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi112022_si184_sequencial_seq definition

-- DROP SEQUENCE redispi112022_si184_sequencial_seq;

CREATE SEQUENCE redispi112022_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi122022_si185_sequencial_seq definition

-- DROP SEQUENCE redispi122022_si185_sequencial_seq;

CREATE SEQUENCE redispi122022_si185_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- afast102022 definition

-- Drop table

-- DROP TABLE afast102022;

CREATE TABLE afast102022 (
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
    CONSTRAINT afast102022_sequ_pk PRIMARY KEY (si199_sequencial)
)
WITH (
    OIDS=TRUE
);


-- afast202022 definition

-- Drop table

-- DROP TABLE afast202022;

CREATE TABLE afast202022 (
    si200_sequencial int4 NOT NULL DEFAULT 0,
    si200_tiporegistro int4 NOT NULL DEFAULT 0,
    si200_codvinculopessoa int4 NOT NULL DEFAULT 0,
    si200_codafastamento int8 NOT NULL DEFAULT 0,
    si200_dtterminoafastamento date NOT NULL,
    si200_mes int4 NOT NULL DEFAULT 0,
    si200_inst int4 NULL DEFAULT 0,
    CONSTRAINT afast202022_sequ_pk PRIMARY KEY (si200_sequencial)
)
WITH (
    OIDS=TRUE
);


-- afast302022 definition

-- Drop table

-- DROP TABLE afast302022;

CREATE TABLE afast302022 (
    si201_sequencial int4 NOT NULL DEFAULT 0,
    si201_tiporegistro int4 NOT NULL DEFAULT 0,
    si201_codvinculopessoa int4 NOT NULL DEFAULT 0,
    si201_codafastamento int8 NOT NULL DEFAULT 0,
    si201_dtretornoafastamento date NOT NULL,
    si201_mes int4 NOT NULL DEFAULT 0,
    si201_inst int4 NULL DEFAULT 0,
    CONSTRAINT afast302022_sequ_pk PRIMARY KEY (si201_sequencial)
)
WITH (
    OIDS=TRUE
);


-- flpgo102022 definition

-- Drop table

-- DROP TABLE flpgo102022;

CREATE TABLE flpgo102022 (
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
    CONSTRAINT flpgo102022_sequ_pk PRIMARY KEY (si195_sequencial)
)
WITH (
    OIDS=TRUE
);


-- respinf2022 definition

-- Drop table

-- DROP TABLE respinf2022;

CREATE TABLE respinf2022 (
    si197_sequencial int8 NOT NULL DEFAULT 0,
    si197_nrodocumento varchar(11) NOT NULL,
    si197_dtinicio date NULL,
    si197_dtfinal date NULL,
    si197_mes int8 NULL,
    si197_instit int8 NULL,
    CONSTRAINT respinf2022_sequ_pk PRIMARY KEY (si197_sequencial)
)
WITH (
    OIDS=TRUE
);


-- terem102022 definition

-- Drop table

-- DROP TABLE terem102022;

CREATE TABLE terem102022 (
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
    CONSTRAINT terem102022_sequ_pk PRIMARY KEY (si194_sequencial)
)
WITH (
    OIDS=TRUE
);


-- terem202022 definition

-- Drop table

-- DROP TABLE terem202022;

CREATE TABLE terem202022 (
    si196_sequencial int8 NOT NULL DEFAULT 0,
    si196_tiporegistro int8 NOT NULL DEFAULT 0,
    si196_codteto int8 NOT NULL DEFAULT 0,
    si196_vlrparateto float8 NOT NULL DEFAULT 0,
    si196_nrleiteto int8 NOT NULL DEFAULT 0,
    si196_dtpublicacaolei date NOT NULL,
    si196_justalteracaoteto varchar(250) NULL,
    si196_mes int8 NOT NULL DEFAULT 0,
    si196_inst int8 NULL DEFAULT 0,
    CONSTRAINT terem202022_sequ_pk PRIMARY KEY (si196_sequencial)
)
WITH (
    OIDS=TRUE
);


-- viap102022 definition

-- Drop table

-- DROP TABLE viap102022;

CREATE TABLE viap102022 (
    si198_sequencial int4 NOT NULL DEFAULT 0,
    si198_tiporegistro int4 NOT NULL DEFAULT 0,
    si198_nrocpfagentepublico varchar(11) NOT NULL,
    si198_codmatriculapessoa int4 NOT NULL DEFAULT 0,
    si198_codvinculopessoa int4 NOT NULL DEFAULT 0,
    si198_mes int4 NOT NULL DEFAULT 0,
    si198_instit int4 NULL DEFAULT 0,
    CONSTRAINT viap102022_sequ_pk PRIMARY KEY (si198_sequencial)
)
WITH (
    OIDS=TRUE
);


-- flpgo112022 definition

-- Drop table

-- DROP TABLE flpgo112022;

CREATE TABLE flpgo112022 (
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
    CONSTRAINT flpgo112022_sequ_pk PRIMARY KEY (si196_sequencial),
    CONSTRAINT flpgo112022_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES flpgo102022(si195_sequencial)
)
WITH (
    OIDS=TRUE
);


-- flpgo122022 definition

-- Drop table

-- DROP TABLE flpgo122022;

CREATE TABLE flpgo122022 (
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
    CONSTRAINT flpgo122022_sequ_pk PRIMARY KEY (si197_sequencial),
    CONSTRAINT flpgo122022_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES flpgo102022(si195_sequencial)
)
WITH (
    OIDS=TRUE
);

-- afast102022_si199_sequencial_seq definition

-- DROP SEQUENCE afast102022_si199_sequencial_seq;

CREATE SEQUENCE afast102022_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- afast202022_si200_sequencial_seq definition

-- DROP SEQUENCE afast202022_si200_sequencial_seq;

CREATE SEQUENCE afast202022_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- afast302022_si201_sequencial_seq definition

-- DROP SEQUENCE afast302022_si201_sequencial_seq;

CREATE SEQUENCE afast302022_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- flpgo102022_si195_sequencial_seq definition

-- DROP SEQUENCE flpgo102022_si195_sequencial_seq;

CREATE SEQUENCE flpgo102022_si195_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- flpgo112022_si196_sequencial_seq definition

-- DROP SEQUENCE flpgo112022_si196_sequencial_seq;

CREATE SEQUENCE flpgo112022_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- flpgo122022_si197_sequencial_seq definition

-- DROP SEQUENCE flpgo122022_si197_sequencial_seq;

CREATE SEQUENCE flpgo122022_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- respinf2022_si197_sequencial_seq definition

-- DROP SEQUENCE respinf2022_si197_sequencial_seq;

CREATE SEQUENCE respinf2022_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- terem102022_si194_sequencial_seq definition

-- DROP SEQUENCE terem102022_si194_sequencial_seq;

CREATE SEQUENCE terem102022_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- terem202022_si196_sequencial_seq definition

-- DROP SEQUENCE terem202022_si196_sequencial_seq;

CREATE SEQUENCE terem202022_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- viap102022_si198_sequencial_seq definition

-- DROP SEQUENCE viap102022_si198_sequencial_seq;

CREATE SEQUENCE viap102022_si198_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cadobras102022 definition

-- Drop table

-- DROP TABLE cadobras102022;

CREATE TABLE cadobras102022 (
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


-- cadobras202022 definition

-- Drop table

-- DROP TABLE cadobras202022;

CREATE TABLE cadobras202022 (
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


-- cadobras212022 definition

-- Drop table

-- DROP TABLE cadobras212022;

CREATE TABLE cadobras212022 (
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


-- cadobras302022 definition

-- Drop table

-- DROP TABLE cadobras302022;

CREATE TABLE cadobras302022 (
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


-- exeobras102022 definition

-- Drop table

-- DROP TABLE exeobras102022;

CREATE TABLE exeobras102022 (
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


-- licobras102022 definition

-- Drop table

-- DROP TABLE licobras102022;

CREATE TABLE licobras102022 (
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


-- licobras202022 definition

-- Drop table

-- DROP TABLE licobras202022;

CREATE TABLE licobras202022 (
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

-- cadobras102022_si198_sequencial_seq definition

-- DROP SEQUENCE cadobras102022_si198_sequencial_seq;

CREATE SEQUENCE cadobras102022_si198_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras202022_si199_sequencial_seq definition

-- DROP SEQUENCE cadobras202022_si199_sequencial_seq;

CREATE SEQUENCE cadobras202022_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras212022_si200_sequencial_seq definition

-- DROP SEQUENCE cadobras212022_si200_sequencial_seq;

CREATE SEQUENCE cadobras212022_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras302022_si201_sequencial_seq definition

-- DROP SEQUENCE cadobras302022_si201_sequencial_seq;

CREATE SEQUENCE cadobras302022_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- exeobras102022_si197_sequencial_seq definition

-- DROP SEQUENCE exeobras102022_si197_sequencial_seq;

CREATE SEQUENCE exeobras102022_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- licobras102022_si195_sequencial_seq definition

-- DROP SEQUENCE licobras102022_si195_sequencial_seq;

CREATE SEQUENCE licobras102022_si195_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- licobras202022_si196_sequencial_seq definition

-- DROP SEQUENCE licobras202022_si196_sequencial_seq;

CREATE SEQUENCE licobras202022_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

SQL;
        $this->execute($sql);
    }
}
