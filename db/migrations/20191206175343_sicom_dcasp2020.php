<?php

use Phinx\Migration\AbstractMigration;

class SicomDcasp2020 extends AbstractMigration
{

    public function change()
    {
        $sql = <<<SQL
        CREATE TABLE bfdcasp102020 (
            si206_sequencial integer DEFAULT 0 NOT NULL,
            si206_tiporegistro integer DEFAULT 0 NOT NULL,
            si206_exercicio integer DEFAULT 0 NOT NULL,
            si206_vlrecorcamenrecurord double precision DEFAULT 0 NOT NULL,
            si206_vlrecorcamenrecinceduc double precision DEFAULT 0 NOT NULL,
            si206_vlrecorcamenrecurvincusaude double precision DEFAULT 0 NOT NULL,
            si206_vlrecorcamenrecurvincurpps double precision DEFAULT 0 NOT NULL,
            si206_vlrecorcamenrecurvincuassistsoc double precision DEFAULT 0 NOT NULL,
            si206_vlrecorcamenoutrasdestrecursos double precision DEFAULT 0 NOT NULL,
            si206_vltransfinanexecuorcamentaria double precision DEFAULT 0 NOT NULL,
            si206_vltransfinanindepenexecuorc double precision DEFAULT 0 NOT NULL,
            si206_vltransfinanreceaportesrpps double precision DEFAULT 0 NOT NULL,
            si206_vlincrirspnaoprocessado double precision DEFAULT 0 NOT NULL,
            si206_vlincrirspprocessado double precision DEFAULT 0 NOT NULL,
            si206_vldeporestituvinculados double precision DEFAULT 0 NOT NULL,
            si206_vloutrosrecextraorcamentario double precision DEFAULT 0 NOT NULL,
            si206_vlsaldoexeranteriorcaixaequicaixa double precision DEFAULT 0 NOT NULL,
            si206_vlsaldoexerantdeporestvinc double precision DEFAULT 0 NOT NULL,
            si206_vltotalingresso double precision DEFAULT 0,
            si206_ano integer DEFAULT 0 NOT NULL,
            si206_periodo integer DEFAULT 0 NOT NULL,
            si206_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bfdcasp102020 OWNER TO dbportal;


        CREATE SEQUENCE bfdcasp102020_si206_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bfdcasp102020_si206_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bfdcasp202020 (
            si207_sequencial integer DEFAULT 0 NOT NULL,
            si207_tiporegistro integer DEFAULT 0 NOT NULL,
            si207_exercicio integer DEFAULT 0 NOT NULL,
            si207_vldesporcamenrecurordinarios double precision DEFAULT 0 NOT NULL,
            si207_vldesporcamenrecurvincueducacao double precision DEFAULT 0 NOT NULL,
            si207_vldesporcamenrecurvincusaude double precision DEFAULT 0 NOT NULL,
            si207_vldesporcamenrecurvincurpps double precision DEFAULT 0 NOT NULL,
            si207_vldesporcamenrecurvincuassistsoc double precision DEFAULT 0 NOT NULL,
            si207_vloutrasdesporcamendestrecursos double precision DEFAULT 0 NOT NULL,
            si207_vltransfinanconcexecorcamentaria double precision DEFAULT 0 NOT NULL,
            si207_vltransfinanconcindepenexecorc double precision DEFAULT 0 NOT NULL,
            si207_vltransfinanconcaportesrecurpps double precision DEFAULT 0 NOT NULL,
            si207_vlpagrspnaoprocessado double precision DEFAULT 0 NOT NULL,
            si207_vlpagrspprocessado double precision DEFAULT 0 NOT NULL,
            si207_vldeposrestvinculados double precision DEFAULT 0 NOT NULL,
            si207_vloutrospagextraorcamentarios double precision DEFAULT 0 NOT NULL,
            si207_vlsaldoexeratualcaixaequicaixa double precision DEFAULT 0 NOT NULL,
            si207_vlsaldoexeratualdeporestvinc double precision DEFAULT 0 NOT NULL,
            si207_vltotaldispendios double precision DEFAULT 0,
            si207_ano integer DEFAULT 0 NOT NULL,
            si207_periodo integer DEFAULT 0 NOT NULL,
            si207_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bfdcasp202020 OWNER TO dbportal;


        CREATE SEQUENCE bfdcasp202020_si207_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bfdcasp202020_si207_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bodcasp102020 (
            si201_sequencial integer DEFAULT 0 NOT NULL,
            si201_tiporegistro integer DEFAULT 0 NOT NULL,
            si201_faserecorcamentaria integer DEFAULT 0 NOT NULL,
            si201_vlrectributaria double precision DEFAULT 0 NOT NULL,
            si201_vlreccontribuicoes double precision DEFAULT 0 NOT NULL,
            si201_vlrecpatrimonial double precision DEFAULT 0 NOT NULL,
            si201_vlrecagropecuaria double precision DEFAULT 0 NOT NULL,
            si201_vlrecindustrial double precision DEFAULT 0 NOT NULL,
            si201_vlrecservicos double precision DEFAULT 0 NOT NULL,
            si201_vltransfcorrentes double precision DEFAULT 0 NOT NULL,
            si201_vloutrasreccorrentes double precision DEFAULT 0 NOT NULL,
            si201_vloperacoescredito double precision DEFAULT 0 NOT NULL,
            si201_vlalienacaobens double precision DEFAULT 0 NOT NULL,
            si201_vlamortemprestimo double precision DEFAULT 0 NOT NULL,
            si201_vltransfcapital double precision DEFAULT 0 NOT NULL,
            si201_vloutrasreccapital double precision DEFAULT 0 NOT NULL,
            si201_vlrecarrecadaxeant double precision DEFAULT 0 NOT NULL,
            si201_vlopcredrefintermob double precision DEFAULT 0 NOT NULL,
            si201_vlopcredrefintcontrat double precision DEFAULT 0 NOT NULL,
            si201_vlopcredrefextmob double precision DEFAULT 0 NOT NULL,
            si201_vlopcredrefextcontrat double precision DEFAULT 0 NOT NULL,
            si201_vldeficit double precision DEFAULT 0 NOT NULL,
            si201_vltotalquadroreceita double precision DEFAULT 0,
            si201_ano integer DEFAULT 0 NOT NULL,
            si201_periodo integer DEFAULT 0 NOT NULL,
            si201_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bodcasp102020 OWNER TO dbportal;


        CREATE SEQUENCE bodcasp102020_si201_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bodcasp102020_si201_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bodcasp202020 (
            si202_sequencial integer DEFAULT 0 NOT NULL,
            si202_tiporegistro integer DEFAULT 0 NOT NULL,
            si202_faserecorcamentaria integer DEFAULT 0 NOT NULL,
            si202_vlsaldoexeantsupfin double precision DEFAULT 0 NOT NULL,
            si202_vlsaldoexeantrecredad double precision DEFAULT 0 NOT NULL,
            si202_vltotalsaldoexeant double precision DEFAULT 0,
            si202_anousu integer DEFAULT 0 NOT NULL,
            si202_periodo integer DEFAULT 0 NOT NULL,
            si202_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bodcasp202020 OWNER TO dbportal;


        CREATE SEQUENCE bodcasp202020_si202_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bodcasp202020_si202_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bodcasp302020 (
            si203_sequencial integer DEFAULT 0 NOT NULL,
            si203_tiporegistro integer DEFAULT 0 NOT NULL,
            si203_fasedespesaorca integer DEFAULT 0 NOT NULL,
            si203_vlpessoalencarsoci double precision DEFAULT 0 NOT NULL,
            si203_vljurosencardividas double precision DEFAULT 0 NOT NULL,
            si203_vloutrasdespcorren double precision DEFAULT 0 NOT NULL,
            si203_vlinvestimentos double precision DEFAULT 0 NOT NULL,
            si203_vlinverfinanceira double precision DEFAULT 0 NOT NULL,
            si203_vlamortizadivida double precision DEFAULT 0 NOT NULL,
            si203_vlreservacontingen double precision DEFAULT 0 NOT NULL,
            si203_vlreservarpps double precision DEFAULT 0 NOT NULL,
            si203_vlamortizadiviintermob double precision DEFAULT 0 NOT NULL,
            si203_vlamortizaoutrasdivinter double precision DEFAULT 0 NOT NULL,
            si203_vlamortizadivextmob double precision DEFAULT 0 NOT NULL,
            si203_vlamortizaoutrasdivext double precision DEFAULT 0 NOT NULL,
            si203_vlsuperavit double precision DEFAULT 0 NOT NULL,
            si203_vltotalquadrodespesa double precision DEFAULT 0,
            si203_anousu integer DEFAULT 0 NOT NULL,
            si203_periodo integer DEFAULT 0 NOT NULL,
            si203_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bodcasp302020 OWNER TO dbportal;


        CREATE SEQUENCE bodcasp302020_si203_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bodcasp302020_si203_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bodcasp402020 (
            si204_sequencial integer DEFAULT 0 NOT NULL,
            si204_tiporegistro integer DEFAULT 0 NOT NULL,
            si204_faserestospagarnaoproc integer DEFAULT 0 NOT NULL,
            si204_vlrspnaoprocpessoalencarsociais double precision DEFAULT 0 NOT NULL,
            si204_vlrspnaoprocjurosencardividas double precision DEFAULT 0 NOT NULL,
            si204_vlrspnaoprocoutrasdespcorrentes double precision DEFAULT 0 NOT NULL,
            si204_vlrspnaoprocinvestimentos double precision DEFAULT 0 NOT NULL,
            si204_vlrspnaoprocinverfinanceira double precision DEFAULT 0 NOT NULL,
            si204_vlrspnaoprocamortizadivida double precision DEFAULT 0 NOT NULL,
            si204_vltotalexecurspnaoprocessado double precision DEFAULT 0,
            si204_ano integer DEFAULT 0 NOT NULL,
            si204_periodo integer DEFAULT 0 NOT NULL,
            si204_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bodcasp402020 OWNER TO dbportal;


        CREATE SEQUENCE bodcasp402020_si204_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bodcasp402020_si204_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bodcasp502020 (
            si205_sequencial integer DEFAULT 0 NOT NULL,
            si205_tiporegistro integer DEFAULT 0 NOT NULL,
            si205_faserestospagarprocnaoliqui integer DEFAULT 0 NOT NULL,
            si205_vlrspprocliqpessoalencarsoc double precision DEFAULT 0 NOT NULL,
            si205_vlrspprocliqjurosencardiv double precision DEFAULT 0 NOT NULL,
            si205_vlrspprocliqoutrasdespcorrentes double precision DEFAULT 0 NOT NULL,
            si205_vlrspprocesliqinv double precision DEFAULT 0 NOT NULL,
            si205_vlrspprocliqinverfinan double precision DEFAULT 0 NOT NULL,
            si205_vlrspprocliqamortizadivida double precision DEFAULT 0 NOT NULL,
            si205_vltotalexecrspprocnaoproceli double precision DEFAULT 0,
            si205_ano integer DEFAULT 0 NOT NULL,
            si205_periodo integer DEFAULT 0 NOT NULL,
            si205_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bodcasp502020 OWNER TO dbportal;


        CREATE SEQUENCE bodcasp502020_si205_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bodcasp502020_si205_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp102020 (
            si208_sequencial integer DEFAULT 0 NOT NULL,
            si208_tiporegistro integer DEFAULT 0 NOT NULL,
            si208_exercicio integer DEFAULT 0 NOT NULL,
            si208_vlativocircucaixaequicaixa double precision DEFAULT 0 NOT NULL,
            si208_vlativocircucredicurtoprazo double precision DEFAULT 0 NOT NULL,
            si208_vlativocircuinvestapliccurtoprazo double precision DEFAULT 0 NOT NULL,
            si208_vlativocircuestoques double precision DEFAULT 0 NOT NULL,
            si208_vlativocircuvpdantecipada double precision DEFAULT 0 NOT NULL,
            si208_vlativonaocircucredilongoprazo double precision DEFAULT 0 NOT NULL,
            si208_vlativonaocircuinvestemplongpraz double precision DEFAULT 0 NOT NULL,
            si208_vlativonaocircuestoques double precision DEFAULT 0 NOT NULL,
            si208_vlativonaocircuvpdantecipada double precision DEFAULT 0 NOT NULL,
            si208_vlativonaocircuinvestimentos double precision DEFAULT 0 NOT NULL,
            si208_vlativonaocircuimobilizado double precision DEFAULT 0 NOT NULL,
            si208_vlativonaocircuintagivel double precision DEFAULT 0 NOT NULL,
            si208_vltotalativo double precision DEFAULT 0,
            si208_ano integer DEFAULT 0 NOT NULL,
            si208_periodo integer DEFAULT 0 NOT NULL,
            si208_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp102020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp102020_si208_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp102020_si208_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp202020 (
            si209_sequencial integer DEFAULT 0 NOT NULL,
            si209_tiporegistro integer DEFAULT 0 NOT NULL,
            si209_exercicio integer DEFAULT 0 NOT NULL,
            si209_vlpassivcircultrabprevicurtoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassivcirculemprefinancurtoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassivocirculafornecedcurtoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassicircuobrigfiscacurtoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassivocirculaobrigacoutrosentes double precision DEFAULT 0 NOT NULL,
            si209_vlpassivocirculaprovisoecurtoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassicircudemaiobrigcurtoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassinaocircutrabprevilongoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassnaocircemprfinalongpraz double precision DEFAULT 0 NOT NULL,
            si209_vlpassivnaocirculforneclongoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassnaocircobrifisclongpraz double precision DEFAULT 0 NOT NULL,
            si209_vlpassivnaocirculprovislongoprazo double precision DEFAULT 0 NOT NULL,
            si209_vlpassnaocircdemaobrilongpraz double precision DEFAULT 0 NOT NULL,
            si209_vlpassivonaocircularesuldiferido double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidocapitalsocial double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidoadianfuturocapital double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidoreservacapital double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidoajustavaliacao double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidoreservalucros double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidodemaisreservas double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidoresultexercicio double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidresultacumexeranteri double precision DEFAULT 0 NOT NULL,
            si209_vlpatriliquidoacoescotas double precision DEFAULT 0 NOT NULL,
            si209_vltotalpassivo double precision DEFAULT 0,
            si209_ano integer DEFAULT 0 NOT NULL,
            si209_periodo integer DEFAULT 0 NOT NULL,
            si209_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp202020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp202020_si209_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp202020_si209_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp302020 (
            si210_sequencial integer DEFAULT 0 NOT NULL,
            si210_tiporegistro integer DEFAULT 0 NOT NULL,
            si210_exercicio integer DEFAULT 0 NOT NULL,
            si210_vlativofinanceiro double precision DEFAULT 0 NOT NULL,
            si210_vlativopermanente double precision DEFAULT 0 NOT NULL,
            si210_vltotalativofinanceiropermanente double precision DEFAULT 0,
            si210_ano integer DEFAULT 0 NOT NULL,
            si210_periodo integer DEFAULT 0 NOT NULL,
            si210_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp302020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp302020_si210_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp302020_si210_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp402020 (
            si211_sequencial integer DEFAULT 0 NOT NULL,
            si211_tiporegistro integer DEFAULT 0 NOT NULL,
            si211_exercicio integer DEFAULT 0 NOT NULL,
            si211_vlpassivofinanceiro double precision DEFAULT 0 NOT NULL,
            si211_vlpassivopermanente double precision DEFAULT 0 NOT NULL,
            si211_vltotalpassivofinanceiropermanente double precision DEFAULT 0,
            si211_ano integer DEFAULT 0 NOT NULL,
            si211_periodo integer DEFAULT 0 NOT NULL,
            si211_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp402020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp402020_si211_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp402020_si211_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp502020 (
            si212_sequencial integer DEFAULT 0 NOT NULL,
            si212_tiporegistro integer DEFAULT 0 NOT NULL,
            si212_exercicio integer DEFAULT 0 NOT NULL,
            si212_vlsaldopatrimonial double precision DEFAULT 0,
            si212_ano integer DEFAULT 0 NOT NULL,
            si212_periodo integer DEFAULT 0 NOT NULL,
            si212_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp502020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp502020_si212_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp502020_si212_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp602020 (
            si213_sequencial integer DEFAULT 0 NOT NULL,
            si213_tiporegistro integer DEFAULT 0 NOT NULL,
            si213_exercicio integer DEFAULT 0 NOT NULL,
            si213_vlatospotenativosgarancontrarecebi double precision DEFAULT 0 NOT NULL,
            si213_vlatospotenativodirconveoutroinstr double precision DEFAULT 0 NOT NULL,
            si213_vlatospotenativosdireitoscontratua double precision DEFAULT 0 NOT NULL,
            si213_vlatospotenativosoutrosatos double precision DEFAULT 0 NOT NULL,
            si213_vlatospotenpassivgarancontraconced double precision DEFAULT 0 NOT NULL,
            si213_vlatospotepassobriconvoutrinst double precision DEFAULT 0 NOT NULL,
            si213_vlatospotenpassivoobrigacocontratu double precision DEFAULT 0 NOT NULL,
            si213_vlatospotenpassivooutrosatos double precision DEFAULT 0,
            si213_ano integer DEFAULT 0 NOT NULL,
            si213_periodo integer DEFAULT 0 NOT NULL,
            si213_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp602020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp602020_si213_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp602020_si213_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp702020 (
            si214_sequencial integer DEFAULT 0 NOT NULL,
            si214_tiporegistro integer DEFAULT 0 NOT NULL,
            si214_exercicio integer DEFAULT 0 NOT NULL,
            si214_vltotalsupdef double precision DEFAULT 0,
            si214_ano integer DEFAULT 0 NOT NULL,
            si214_periodo integer DEFAULT 0 NOT NULL,
            si214_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp702020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp702020_si214_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp702020_si214_sequencial_seq OWNER TO dbportal;


        CREATE TABLE bpdcasp712020 (
            si215_sequencial integer DEFAULT 0 NOT NULL,
            si215_tiporegistro integer DEFAULT 0 NOT NULL,
            si215_exercicio integer DEFAULT 0 NOT NULL,
            si215_codfontrecursos integer DEFAULT 0 NOT NULL,
            si215_vlsaldofonte double precision DEFAULT 0,
            si215_ano integer DEFAULT 0 NOT NULL,
            si215_periodo integer DEFAULT 0 NOT NULL,
            si215_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE bpdcasp712020 OWNER TO dbportal;


        CREATE SEQUENCE bpdcasp712020_si215_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE bpdcasp712020_si215_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp1002020 (
            si228_sequencial integer DEFAULT 0 NOT NULL,
            si228_tiporegistro integer DEFAULT 0 NOT NULL,
            si228_vlgeracaoliquidaequivalentecaixa double precision DEFAULT 0,
            si228_anousu integer DEFAULT 0 NOT NULL,
            si228_periodo integer DEFAULT 0 NOT NULL,
            si228_mes integer DEFAULT 0 NOT NULL,
            si228_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp1002020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp1002020_si228_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp1002020_si228_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp102020 (
            si219_sequencial integer DEFAULT 0 NOT NULL,
            si219_tiporegistro integer DEFAULT 0 NOT NULL,
            si219_vlreceitaderivadaoriginaria double precision DEFAULT 0 NOT NULL,
            si219_vltranscorrenterecebida double precision DEFAULT 0 NOT NULL,
            si219_vloutrosingressosoperacionais double precision DEFAULT 0 NOT NULL,
            si219_vltotalingressosativoperacionais double precision DEFAULT 0,
            si219_anousu integer DEFAULT 0 NOT NULL,
            si219_periodo integer DEFAULT 0 NOT NULL,
            si219_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp102020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp102020_si219_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp102020_si219_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp1102020 (
            si229_sequencial integer DEFAULT 0 NOT NULL,
            si229_tiporegistro integer DEFAULT 0 NOT NULL,
            si229_vlcaixaequivalentecaixainicial double precision DEFAULT 0 NOT NULL,
            si229_vlcaixaequivalentecaixafinal double precision DEFAULT 0,
            si229_anousu integer DEFAULT 0 NOT NULL,
            si229_periodo integer DEFAULT 0 NOT NULL,
            si229_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp1102020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp1102020_si229_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp1102020_si229_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp202020 (
            si220_sequencial integer DEFAULT 0 NOT NULL,
            si220_tiporegistro integer DEFAULT 0 NOT NULL,
            si220_vldesembolsopessoaldespesas double precision DEFAULT 0 NOT NULL,
            si220_vldesembolsojurosencargdivida double precision DEFAULT 0 NOT NULL,
            si220_vldesembolsotransfconcedidas double precision DEFAULT 0 NOT NULL,
            si220_vloutrosdesembolsos double precision DEFAULT 0 NOT NULL,
            si220_vltotaldesembolsosativoperacionais double precision DEFAULT 0,
            si220_anousu integer DEFAULT 0 NOT NULL,
            si220_periodo integer DEFAULT 0 NOT NULL,
            si220_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp202020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp202020_si220_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp202020_si220_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp302020 (
            si221_sequencial integer DEFAULT 0 NOT NULL,
            si221_tiporegistro integer DEFAULT 0 NOT NULL,
            si221_vlfluxocaixaliquidooperacional double precision DEFAULT 0,
            si221_anousu integer DEFAULT 0 NOT NULL,
            si221_periodo integer DEFAULT 0 NOT NULL,
            si221_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp302020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp302020_si221_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp302020_si221_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp402020 (
            si222_sequencial integer DEFAULT 0 NOT NULL,
            si222_tiporegistro integer DEFAULT 0 NOT NULL,
            si222_vlalienacaobens double precision DEFAULT 0 NOT NULL,
            si222_vlamortizacaoemprestimoconcedido double precision DEFAULT 0 NOT NULL,
            si222_vloutrosingressos double precision DEFAULT 0 NOT NULL,
            si222_vltotalingressosatividainvestiment double precision DEFAULT 0,
            si222_anousu integer DEFAULT 0 NOT NULL,
            si222_periodo integer DEFAULT 0 NOT NULL,
            si222_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp402020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp402020_si222_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp402020_si222_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp502020 (
            si223_sequencial integer DEFAULT 0 NOT NULL,
            si223_tiporegistro integer DEFAULT 0 NOT NULL,
            si223_vlaquisicaoativonaocirculante double precision DEFAULT 0 NOT NULL,
            si223_vlconcessaoempresfinanciamento double precision DEFAULT 0 NOT NULL,
            si223_vloutrosdesembolsos double precision DEFAULT 0 NOT NULL,
            si223_vltotaldesembolsoatividainvestimen double precision DEFAULT 0,
            si223_anousu integer DEFAULT 0 NOT NULL,
            si223_periodo integer DEFAULT 0 NOT NULL,
            si223_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp502020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp502020_si223_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp502020_si223_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp602020 (
            si224_sequencial integer DEFAULT 0 NOT NULL,
            si224_tiporegistro integer DEFAULT 0 NOT NULL,
            si224_vlfluxocaixaliquidoinvestimento double precision DEFAULT 0,
            si224_anousu integer DEFAULT 0 NOT NULL,
            si224_periodo integer DEFAULT 0 NOT NULL,
            si224_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp602020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp602020_si224_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp602020_si224_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp702020 (
            si225_sequencial integer DEFAULT 0 NOT NULL,
            si225_tiporegistro integer DEFAULT 0 NOT NULL,
            si225_vloperacoescredito double precision DEFAULT 0 NOT NULL,
            si225_vlintegralizacaodependentes double precision DEFAULT 0 NOT NULL,
            si225_vltranscapitalrecebida double precision DEFAULT 0 NOT NULL,
            si225_vloutrosingressosfinanciamento double precision DEFAULT 0 NOT NULL,
            si225_vltotalingressoatividafinanciament double precision DEFAULT 0,
            si225_anousu integer DEFAULT 0 NOT NULL,
            si225_periodo integer DEFAULT 0 NOT NULL,
            si225_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp702020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp702020_si225_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp702020_si225_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp802020 (
            si226_sequencial integer DEFAULT 0 NOT NULL,
            si226_tiporegistro integer DEFAULT 0 NOT NULL,
            si226_vlamortizacaorefinanciamento double precision DEFAULT 0 NOT NULL,
            si226_vloutrosdesembolsosfinanciamento double precision DEFAULT 0 NOT NULL,
            si226_vltotaldesembolsoatividafinanciame double precision DEFAULT 0,
            si226_anousu integer DEFAULT 0 NOT NULL,
            si226_periodo integer DEFAULT 0 NOT NULL,
            si226_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp802020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp802020_si226_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp802020_si226_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dfcdcasp902020 (
            si227_sequencial integer DEFAULT 0 NOT NULL,
            si227_tiporegistro integer DEFAULT 0 NOT NULL,
            si227_vlfluxocaixafinanciamento double precision DEFAULT 0,
            si227_anousu integer DEFAULT 0 NOT NULL,
            si227_periodo integer DEFAULT 0 NOT NULL,
            si227_instit integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dfcdcasp902020 OWNER TO dbportal;


        CREATE SEQUENCE dfcdcasp902020_si227_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dfcdcasp902020_si227_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dvpdcasp102020 (
            si216_sequencial integer DEFAULT 0 NOT NULL,
            si216_tiporegistro integer DEFAULT 0 NOT NULL,
            si216_vlimpostos double precision DEFAULT 0 NOT NULL,
            si216_vlcontribuicoes double precision DEFAULT 0 NOT NULL,
            si216_vlexploracovendasdireitos double precision DEFAULT 0 NOT NULL,
            si216_vlvariacoesaumentativasfinanceiras double precision DEFAULT 0 NOT NULL,
            si216_vltransfdelegacoesrecebidas double precision DEFAULT 0 NOT NULL,
            si216_vlvalorizacaoativodesincorpassivo double precision DEFAULT 0 NOT NULL,
            si216_vloutrasvariacoespatriaumentativas double precision DEFAULT 0 NOT NULL,
            si216_vltotalvpaumentativas double precision DEFAULT 0,
            si216_ano integer DEFAULT 0 NOT NULL,
            si216_periodo integer DEFAULT 0 NOT NULL,
            si216_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dvpdcasp102020 OWNER TO dbportal;


        CREATE SEQUENCE dvpdcasp102020_si216_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dvpdcasp102020_si216_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dvpdcasp202020 (
            si217_sequencial integer DEFAULT 0 NOT NULL,
            si217_tiporegistro integer DEFAULT 0 NOT NULL,
            si217_vldiminutivapessoaencargos double precision DEFAULT 0 NOT NULL,
            si217_vlprevassistenciais double precision DEFAULT 0 NOT NULL,
            si217_vlservicoscapitalfixo double precision DEFAULT 0 NOT NULL,
            si217_vldiminutivavariacoesfinanceiras double precision DEFAULT 0 NOT NULL,
            si217_vltransfconcedidas double precision DEFAULT 0 NOT NULL,
            si217_vldesvaloativoincorpopassivo double precision DEFAULT 0 NOT NULL,
            si217_vltributarias double precision DEFAULT 0 NOT NULL,
            si217_vlmercadoriavendidoservicos double precision DEFAULT 0 NOT NULL,
            si217_vloutrasvariacoespatridiminutivas double precision DEFAULT 0 NOT NULL,
            si217_vltotalvpdiminutivas double precision DEFAULT 0,
            si217_ano integer DEFAULT 0 NOT NULL,
            si217_periodo integer DEFAULT 0 NOT NULL,
            si217_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dvpdcasp202020 OWNER TO dbportal;


        CREATE SEQUENCE dvpdcasp202020_si217_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dvpdcasp202020_si217_sequencial_seq OWNER TO dbportal;


        CREATE TABLE dvpdcasp302020 (
            si218_sequencial integer DEFAULT 0 NOT NULL,
            si218_tiporegistro integer DEFAULT 0 NOT NULL,
            si218_vlresultadopatrimonialperiodo double precision DEFAULT 0,
            si218_ano integer DEFAULT 0 NOT NULL,
            si218_periodo integer DEFAULT 0 NOT NULL,
            si218_institu integer DEFAULT 0 NOT NULL
        );


        ALTER TABLE dvpdcasp302020 OWNER TO dbportal;


        CREATE SEQUENCE dvpdcasp302020_si218_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


        ALTER TABLE dvpdcasp302020_si218_sequencial_seq OWNER TO dbportal;


        ALTER TABLE ONLY bfdcasp102020
        ADD CONSTRAINT bfdcasp102020_sequ_pk PRIMARY KEY (si206_sequencial);



        ALTER TABLE ONLY bfdcasp202020
        ADD CONSTRAINT bfdcasp202020_sequ_pk PRIMARY KEY (si207_sequencial);



        ALTER TABLE ONLY bodcasp102020
        ADD CONSTRAINT bodcasp102020_sequ_pk PRIMARY KEY (si201_sequencial);



        ALTER TABLE ONLY bodcasp202020
        ADD CONSTRAINT bodcasp202020_sequ_pk PRIMARY KEY (si202_sequencial);



        ALTER TABLE ONLY bodcasp302020
        ADD CONSTRAINT bodcasp302020_sequ_pk PRIMARY KEY (si203_sequencial);



        ALTER TABLE ONLY bodcasp402020
        ADD CONSTRAINT bodcasp402020_sequ_pk PRIMARY KEY (si204_sequencial);



        ALTER TABLE ONLY bodcasp502020
        ADD CONSTRAINT bodcasp502020_sequ_pk PRIMARY KEY (si205_sequencial);



        ALTER TABLE ONLY bpdcasp102020
        ADD CONSTRAINT bpdcasp102020_sequ_pk PRIMARY KEY (si208_sequencial);



        ALTER TABLE ONLY bpdcasp202020
        ADD CONSTRAINT bpdcasp202020_sequ_pk PRIMARY KEY (si209_sequencial);



        ALTER TABLE ONLY bpdcasp302020
        ADD CONSTRAINT bpdcasp302020_sequ_pk PRIMARY KEY (si210_sequencial);



        ALTER TABLE ONLY bpdcasp402020
        ADD CONSTRAINT bpdcasp402020_sequ_pk PRIMARY KEY (si211_sequencial);



        ALTER TABLE ONLY bpdcasp502020
        ADD CONSTRAINT bpdcasp502020_sequ_pk PRIMARY KEY (si212_sequencial);



        ALTER TABLE ONLY bpdcasp602020
        ADD CONSTRAINT bpdcasp602020_sequ_pk PRIMARY KEY (si213_sequencial);



        ALTER TABLE ONLY bpdcasp702020
        ADD CONSTRAINT bpdcasp702020_sequ_pk PRIMARY KEY (si214_sequencial);



        ALTER TABLE ONLY bpdcasp712020
        ADD CONSTRAINT bpdcasp712020_sequ_pk PRIMARY KEY (si215_sequencial);



        ALTER TABLE ONLY dfcdcasp1002020
        ADD CONSTRAINT dfcdcasp1002020_sequ_pk PRIMARY KEY (si228_sequencial);



        ALTER TABLE ONLY dfcdcasp102020
        ADD CONSTRAINT dfcdcasp102020_sequ_pk PRIMARY KEY (si219_sequencial);



        ALTER TABLE ONLY dfcdcasp1102020
        ADD CONSTRAINT dfcdcasp1102020_sequ_pk PRIMARY KEY (si229_sequencial);



        ALTER TABLE ONLY dfcdcasp202020
        ADD CONSTRAINT dfcdcasp202020_sequ_pk PRIMARY KEY (si220_sequencial);



        ALTER TABLE ONLY dfcdcasp302020
        ADD CONSTRAINT dfcdcasp302020_sequ_pk PRIMARY KEY (si221_sequencial);



        ALTER TABLE ONLY dfcdcasp402020
        ADD CONSTRAINT dfcdcasp402020_sequ_pk PRIMARY KEY (si222_sequencial);



        ALTER TABLE ONLY dfcdcasp502020
        ADD CONSTRAINT dfcdcasp502020_sequ_pk PRIMARY KEY (si223_sequencial);



        ALTER TABLE ONLY dfcdcasp602020
        ADD CONSTRAINT dfcdcasp602020_sequ_pk PRIMARY KEY (si224_sequencial);



        ALTER TABLE ONLY dfcdcasp702020
        ADD CONSTRAINT dfcdcasp702020_sequ_pk PRIMARY KEY (si225_sequencial);



        ALTER TABLE ONLY dfcdcasp802020
        ADD CONSTRAINT dfcdcasp802020_sequ_pk PRIMARY KEY (si226_sequencial);



        ALTER TABLE ONLY dfcdcasp902020
        ADD CONSTRAINT dfcdcasp902020_sequ_pk PRIMARY KEY (si227_sequencial);



        ALTER TABLE ONLY dvpdcasp102020
        ADD CONSTRAINT dvpdcasp102020_sequ_pk PRIMARY KEY (si216_sequencial);



        ALTER TABLE ONLY dvpdcasp202020
        ADD CONSTRAINT dvpdcasp202020_sequ_pk PRIMARY KEY (si217_sequencial);



        ALTER TABLE ONLY dvpdcasp302020
        ADD CONSTRAINT dvpdcasp302020_sequ_pk PRIMARY KEY (si218_sequencial);

        CREATE TABLE idedcasp2020
        (
          si200_sequencial integer NOT NULL DEFAULT 0,
          si200_codmunicipio character varying(5) NOT NULL,
          si200_cnpjorgao character varying(14) NOT NULL,
          si200_codorgao character varying(2) NOT NULL,
          si200_tipoorgao character varying(2) NOT NULL,
          si200_tipodemcontabil integer NOT NULL DEFAULT 0,
          si200_exercicioreferencia integer NOT NULL DEFAULT 0,
          si200_datageracao date NOT NULL,
          si200_codcontroleremessa character varying(20),
          si200_anousu integer NOT NULL DEFAULT 0,
          si200_instit integer NOT NULL DEFAULT 0,
          CONSTRAINT idedcasp2020_sequ_pk PRIMARY KEY (si200_sequencial)
        )
        WITH (
          OIDS=TRUE
      );
        ALTER TABLE idedcasp2020
        OWNER TO dbportal;

SQL;
        $this->execute($sql);
    }

    public function down()
    {

    }
}
