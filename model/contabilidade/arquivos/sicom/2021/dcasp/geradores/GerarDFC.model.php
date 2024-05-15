<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - DFC
 * @author gabriel
 * @package Contabilidade
 */
class GerarDFC extends GerarAM
{
    public $iAno;
    public $iPeriodo;

    public function gerarDados()
    {

        $this->sArquivo = "DFC";
        $this->abreArquivo();

        $sSql = "select * from dfcdcasp102021 where si219_anousu = {$this->iAno} AND si219_periodo = {$this->iPeriodo} AND si219_instit = " . db_getsession("DB_instit");
        $rsDFC10 = db_query($sSql);

        $sSql = "select * from dfcdcasp202021 where si220_anousu = {$this->iAno} AND si220_periodo = {$this->iPeriodo} AND si220_instit = " . db_getsession("DB_instit");
        $rsDFC20 = db_query($sSql);

        $sSql = "select * from dfcdcasp302021 where si221_anousu = {$this->iAno} AND si221_periodo = {$this->iPeriodo} AND si221_instit = " . db_getsession("DB_instit");
        $rsDFC30 = db_query($sSql);

        $sSql = "select * from dfcdcasp402021 where si222_anousu = {$this->iAno} AND si222_periodo = {$this->iPeriodo} AND si222_instit = " . db_getsession("DB_instit");
        $rsDFC40 = db_query($sSql);

        $sSql = "select * from dfcdcasp502021 where si223_anousu = {$this->iAno} AND si223_periodo = {$this->iPeriodo} AND si223_instit = " . db_getsession("DB_instit");
        $rsDFC50 = db_query($sSql);

        $sSql = "select * from dfcdcasp602021 where si224_anousu = {$this->iAno} AND si224_periodo = {$this->iPeriodo} AND si224_instit = " . db_getsession("DB_instit");
        $rsDFC60 = db_query($sSql);

        $sSql = "select * from dfcdcasp702021 where si225_anousu = {$this->iAno} AND si225_periodo = {$this->iPeriodo} AND si225_instit = " . db_getsession("DB_instit");
        $rsDFC70 = db_query($sSql);

        $sSql = "select * from dfcdcasp802021 where si226_anousu = {$this->iAno} AND si226_periodo = {$this->iPeriodo} AND si226_instit = " . db_getsession("DB_instit");
        $rsDFC80 = db_query($sSql);

        $sSql = "select * from dfcdcasp902021 where si227_anousu = {$this->iAno} AND si227_periodo = {$this->iPeriodo} AND si227_instit = " . db_getsession("DB_instit");
        $rsDFC90 = db_query($sSql);

        $sSql = "select * from dfcdcasp1002021 where si228_anousu = {$this->iAno} AND si228_periodo = {$this->iPeriodo} AND si228_instit = " . db_getsession("DB_instit");
        $rsDFC100 = db_query($sSql);

        $sSql = "select * from dfcdcasp1102021 where si229_anousu = {$this->iAno} AND si229_periodo = {$this->iPeriodo} AND si229_instit = " . db_getsession("DB_instit");
        $rsDFC110 = db_query($sSql);


        if (pg_num_rows($rsDFC10) == 0
            && pg_num_rows($rsDFC20) == 0
            && pg_num_rows($rsDFC30) == 0
            && pg_num_rows($rsDFC40) == 0
            && pg_num_rows($rsDFC50) == 0
            && pg_num_rows($rsDFC60) == 0
            && pg_num_rows($rsDFC70) == 0
            && pg_num_rows($rsDFC80) == 0
            && pg_num_rows($rsDFC90) == 0
            && pg_num_rows($rsDFC100) == 0
            && pg_num_rows($rsDFC110) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();

        } else {


            /** Registro 10 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC10); $iCont++) {

                $aDFC10 = pg_fetch_array($rsDFC10, $iCont, PGSQL_ASSOC);

                $aCSVDFC10 = array();
                $aCSVDFC10['si219_tiporegistro']                      = $this->padLeftZero($aDFC10['si219_tiporegistro'], 2);

//        $aCSVDFC10['si219_vlreceitaderivadaoriginaria']       = $this->sicomNumberReal($aDFC10['si219_vlreceitaderivadaoriginaria'], 2);
//        $aCSVDFC10['si219_vltranscorrenterecebida']           = $this->sicomNumberReal($aDFC10['si219_vltranscorrenterecebida'], 2);


                $aCSVDFC10['si219_vlreceitatributaria']  = $this->sicomNumberReal($aDFC10['si219_vlreceitatributaria'], 2);
                $aCSVDFC10['si219_vlreceitacontribuicao']  = $this->sicomNumberReal($aDFC10['si219_vlreceitacontribuicao'], 2);
                $aCSVDFC10['si219_vlreceitapatrimonial']  = $this->sicomNumberReal($aDFC10['si219_vlreceitapatrimonial'], 2);
                $aCSVDFC10['si219_vlreceitaagropecuaria']  = $this->sicomNumberReal($aDFC10['si219_vlreceitaagropecuaria'], 2);
                $aCSVDFC10['si219_vlreceitaindustrial']  = $this->sicomNumberReal($aDFC10['si219_vlreceitaindustrial'], 2);
                $aCSVDFC10['si219_vlreceitaservicos']  = $this->sicomNumberReal($aDFC10['si219_vlreceitaservicos'], 2);
                $aCSVDFC10['si219_vlremuneracaodisponibilidade']  = $this->sicomNumberReal($aDFC10['si219_vlremuneracaodisponibilidade'], 2);
                $aCSVDFC10['si219_vloutrasreceitas']  = $this->sicomNumberReal($aDFC10['si219_vloutrasreceitas'], 2);
                $aCSVDFC10['si219_vltransferenciarecebidas']  = $this->sicomNumberReal($aDFC10['si219_vltransferenciarecebidas'], 2);
                $aCSVDFC10['si219_vloutrosingressosoperacionais']     = $this->sicomNumberReal($aDFC10['si219_vloutrosingressosoperacionais'], 2);
                $aCSVDFC10['si219_vltotalingressosativoperacionais']  = $this->sicomNumberReal($aDFC10['si219_vltotalingressosativoperacionais'], 2);

                $this->sLinha = $aCSVDFC10;
                $this->adicionaLinha();

            }


            /** Registro 20 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC20); $iCont++) {

                $aDFC20 = pg_fetch_array($rsDFC20, $iCont, PGSQL_ASSOC);

                $aCSVDFC20 = array();
                $aCSVDFC20['si220_tiporegistro']                        = $this->padLeftZero($aDFC20['si220_tiporegistro'], 2);
                $aCSVDFC20['si220_vldesembolsopessoaldespesas']         = $this->sicomNumberReal($aDFC20['si220_vldesembolsopessoaldespesas'], 2);
                $aCSVDFC20['si220_vldesembolsojurosencargdivida']       = $this->sicomNumberReal($aDFC20['si220_vldesembolsojurosencargdivida'], 2);
                $aCSVDFC20['si220_vldesembolsotransfconcedidas']        = $this->sicomNumberReal($aDFC20['si220_vldesembolsotransfconcedidas'], 2);
                $aCSVDFC20['si220_vloutrosdesembolsos']                 = $this->sicomNumberReal($aDFC20['si220_vloutrosdesembolsos'], 2);
                $aCSVDFC20['si220_vltotaldesembolsosativoperacionais']  = $this->sicomNumberReal($aDFC20['si220_vltotaldesembolsosativoperacionais'], 2);

                $this->sLinha = $aCSVDFC20;
                $this->adicionaLinha();

            }


            /** Registro 30 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC30); $iCont++) {

                $aDFC30 = pg_fetch_array($rsDFC30, $iCont, PGSQL_ASSOC);

                $aCSVDFC30 = array();
                $aCSVDFC30['si221_tiporegistro']                    = $this->padLeftZero($aDFC30['si221_tiporegistro'], 2);
                $aCSVDFC30['si221_vlfluxocaixaliquidooperacional']  = $this->sicomNumberReal($aDFC30['si221_vlfluxocaixaliquidooperacional'], 2);

                $this->sLinha = $aCSVDFC30;
                $this->adicionaLinha();

            }


            /** Registro 40 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC40); $iCont++) {

                $aDFC40 = pg_fetch_array($rsDFC40, $iCont, PGSQL_ASSOC);

                $aCSVDFC40 = array();

                $aCSVDFC40['si222_tiporegistro']                        = $this->padLeftZero($aDFC40['si222_tiporegistro'], 2);
                $aCSVDFC40['si222_vlalienacaobens']                     = $this->sicomNumberReal($aDFC40['si222_vlalienacaobens'], 2);
                $aCSVDFC40['si222_vlamortizacaoemprestimoconcedido']    = $this->sicomNumberReal($aDFC40['si222_vlamortizacaoemprestimoconcedido'], 2);
                $aCSVDFC40['si222_vloutrosingressos']                   = $this->sicomNumberReal($aDFC40['si222_vloutrosingressos'], 2);
                $aCSVDFC40['si222_vltotalingressosatividainvestiment']  = $this->sicomNumberReal($aDFC40['si222_vltotalingressosatividainvestiment'], 2);

                $this->sLinha = $aCSVDFC40;
                $this->adicionaLinha();

            }


            /** Registro 50 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC50); $iCont++) {

                $aDFC50 = pg_fetch_array($rsDFC50, $iCont, PGSQL_ASSOC);

                $aCSVDFC50 = array();

                $aCSVDFC50['si223_tiporegistro']                        = $this->padLeftZero($aDFC50['si223_tiporegistro'], 2);
                $aCSVDFC50['si223_vlaquisicaoativonaocirculante']       = $this->sicomNumberReal($aDFC50['si223_vlaquisicaoativonaocirculante'], 2);
                $aCSVDFC50['si223_vlconcessaoempresfinanciamento']      = $this->sicomNumberReal($aDFC50['si223_vlconcessaoempresfinanciamento'], 2);
                $aCSVDFC50['si223_vloutrosdesembolsos']                 = $this->sicomNumberReal($aDFC50['si223_vloutrosdesembolsos'], 2);
                $aCSVDFC50['si223_vltotaldesembolsoatividainvestimen']  = $this->sicomNumberReal($aDFC50['si223_vltotaldesembolsoatividainvestimen'], 2);

                $this->sLinha = $aCSVDFC50;
                $this->adicionaLinha();

            }


            /** Registro 60 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC60); $iCont++) {

                $aDFC60 = pg_fetch_array($rsDFC60, $iCont, PGSQL_ASSOC);

                $aCSVDFC60 = array();

                $aCSVDFC60['si224_tiporegistro']                    = $this->padLeftZero($aDFC60['si224_tiporegistro'], 2);
                $aCSVDFC60['si224_vlfluxocaixaliquidoinvestimento'] = $this->sicomNumberReal($aDFC60['si224_vlfluxocaixaliquidoinvestimento'], 2);

                $this->sLinha = $aCSVDFC60;
                $this->adicionaLinha();

            }


            /** Registro 70 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC70); $iCont++) {

                $aDFC70 = pg_fetch_array($rsDFC70, $iCont, PGSQL_ASSOC);

                $aCSVDFC70 = array();
                $aCSVDFC70['si225_tiporegistro']                        = $this->padLeftZero($aDFC70['si225_tiporegistro'], 2);
                $aCSVDFC70['si225_vloperacoescredito']                  = $this->sicomNumberReal($aDFC70['si225_vloperacoescredito'], 2);
                $aCSVDFC70['si225_vlintegralizacaodependentes']         = $this->sicomNumberReal($aDFC70['si225_vlintegralizacaodependentes'], 2);
                //$aCSVDFC70['si225_vltranscapitalrecebida']              = $this->sicomNumberReal($aDFC70['si225_vltranscapitalrecebida'], 2);
                $aCSVDFC70['si225_vloutrosingressosfinanciamento']      = $this->sicomNumberReal($aDFC70['si225_vloutrosingressosfinanciamento'], 2);
                $aCSVDFC70['si225_vltotalingressoatividafinanciament']  = $this->sicomNumberReal($aDFC70['si225_vltotalingressoatividafinanciament'], 2);


                $this->sLinha = $aCSVDFC70;
                $this->adicionaLinha();

            }


            /** Registro 80 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC80); $iCont++) {

                $aDFC80 = pg_fetch_array($rsDFC80, $iCont, PGSQL_ASSOC);

                $aCSVDFC80 = array();
                $aCSVDFC80['si226_tiporegistro']                        = $this->padLeftZero($aDFC80['si226_tiporegistro'], 2);
                $aCSVDFC80['si226_vlamortizacaorefinanciamento']        = $this->sicomNumberReal($aDFC80['si226_vlamortizacaorefinanciamento'], 2);
                $aCSVDFC80['si226_vloutrosdesembolsosfinanciamento']    = $this->sicomNumberReal($aDFC80['si226_vloutrosdesembolsosfinanciamento'], 2);
                $aCSVDFC80['si226_vltotaldesembolsoatividafinanciame']  = $this->sicomNumberReal($aDFC80['si226_vltotaldesembolsoatividafinanciame'], 2);

                $this->sLinha = $aCSVDFC80;
                $this->adicionaLinha();

            }


            /** Registro 90 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC90); $iCont++) {

                $aDFC90 = pg_fetch_array($rsDFC90, $iCont, PGSQL_ASSOC);

                $aCSVDFC90 = array();
                $aCSVDFC90['si227_tiporegistro']              = $this->padLeftZero($aDFC90['si227_tiporegistro'], 2);
                $aCSVDFC90['si227_vlfluxocaixafinanciamento'] = $this->sicomNumberReal($aDFC90['si227_vlfluxocaixafinanciamento'], 2);

                $this->sLinha = $aCSVDFC90;
                $this->adicionaLinha();

            }


            /** Registro 100 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC100); $iCont++) {

                $aDFC100 = pg_fetch_array($rsDFC100, $iCont, PGSQL_ASSOC);

                $aCSVDFC100 = array();
                $aCSVDFC100['si228_tiporegistro']                     = $this->padLeftZero($aDFC100['si228_tiporegistro'], 3);
                $aCSVDFC100['si228_vlgeracaoliquidaequivalentecaixa'] = $this->sicomNumberReal($aDFC100['si228_vlgeracaoliquidaequivalentecaixa'], 2);

                $this->sLinha = $aCSVDFC100;
                $this->adicionaLinha();

            }


            /** Registro 110 */
            for ($iCont = 0; $iCont < pg_num_rows($rsDFC110); $iCont++) {

                $aDFC110 = pg_fetch_array($rsDFC110, $iCont, PGSQL_ASSOC);

                $aCSVDFC110 = array();
                $aCSVDFC110['si229_tiporegistro']                   = $this->padLeftZero($aDFC110['si229_tiporegistro'], 3);
                $aCSVDFC110['si229_vlcaixaequivalentecaixainicial'] = $this->sicomNumberReal($aDFC110['si229_vlcaixaequivalentecaixainicial'], 2);
                $aCSVDFC110['si229_vlcaixaequivalentecaixafinal']   = $this->sicomNumberReal($aDFC110['si229_vlcaixaequivalentecaixafinal'], 2);

                $this->sLinha = $aCSVDFC110;
                $this->adicionaLinha();

            }

            $this->fechaArquivo();

        }

    }

}
