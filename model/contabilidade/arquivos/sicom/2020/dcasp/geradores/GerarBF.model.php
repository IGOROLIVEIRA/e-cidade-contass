<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - BF
 * @author gabriel
 * @package Contabilidade
 */
class GerarBF extends GerarAM
{

  public $iAno;
  public $iPeriodo;

  public function gerarDados()
  {

    $this->sArquivo = "BF";
    $this->abreArquivo();

    $sSql = "select * from bfdcasp102020 where si206_ano = {$this->iAno} AND si206_periodo = {$this->iPeriodo} AND si206_institu = " . db_getsession("DB_instit");
    $rsBF10 = db_query($sSql);

    $sSql = "select * from bfdcasp202020 where si207_ano = {$this->iAno} AND si207_periodo = {$this->iPeriodo} AND si207_institu = " . db_getsession("DB_instit");
    $rsBF20 = db_query($sSql);

    if (pg_num_rows($rsBF10) == 0
      && pg_num_rows($rsBF20) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {


      /** Registro 10 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBF10); $iCont++) {

        $aBF10 = pg_fetch_array($rsBF10, $iCont, PGSQL_ASSOC);

        $aCSVBF10 = array();
        $aCSVBF10['si206_tiporegistro']                       = $this->padLeftZero($aBF10['si206_tiporegistro'], 2);
        $aCSVBF10['si206_vlrecorcamenrecurord']               = $this->sicomNumberReal($aBF10['si206_vlrecorcamenrecurord'], 2);
        $aCSVBF10['si206_vlrecorcamenrecinceduc']             = $this->sicomNumberReal($aBF10['si206_vlrecorcamenrecinceduc'], 2);
        $aCSVBF10['si206_vlrecorcamenrecurvincusaude']        = $this->sicomNumberReal($aBF10['si206_vlrecorcamenrecurvincusaude'], 2);
        $aCSVBF10['si206_vlrecorcamenrecurvincurpps']         = $this->sicomNumberReal($aBF10['si206_vlrecorcamenrecurvincurpps'], 2);
        $aCSVBF10['si206_vlrecorcamenrecurvincuassistsoc']    = $this->sicomNumberReal($aBF10['si206_vlrecorcamenrecurvincuassistsoc'], 2);
        $aCSVBF10['si206_vlrecorcamenoutrasdestrecursos']     = $this->sicomNumberReal($aBF10['si206_vlrecorcamenoutrasdestrecursos'], 2);
        $aCSVBF10['si206_vltransfinanexecuorcamentaria']      = $this->sicomNumberReal($aBF10['si206_vltransfinanexecuorcamentaria'], 2);
        $aCSVBF10['si206_vltransfinanindepenexecuorc']        = $this->sicomNumberReal($aBF10['si206_vltransfinanindepenexecuorc'], 2);
        $aCSVBF10['si206_vltransfinanreceaportesrpps']        = $this->sicomNumberReal($aBF10['si206_vltransfinanreceaportesrpps'], 2);
        $aCSVBF10['si206_vlincrirspnaoprocessado']            = $this->sicomNumberReal(abs($aBF10['si206_vlincrirspnaoprocessado']), 2);
        $aCSVBF10['si206_vlincrirspprocessado']               = $this->sicomNumberReal($aBF10['si206_vlincrirspprocessado'], 2);
        $aCSVBF10['si206_vldeporestituvinculados']            = $this->sicomNumberReal($aBF10['si206_vldeporestituvinculados'], 2);
        $aCSVBF10['si206_vloutrosrecextraorcamentario']       = $this->sicomNumberReal($aBF10['si206_vloutrosrecextraorcamentario'], 2);
        $aCSVBF10['si206_vlsaldoexeranteriorcaixaequicaixa']  = $this->sicomNumberReal($aBF10['si206_vlsaldoexeranteriorcaixaequicaixa'], 2);
        $aCSVBF10['si206_vlsaldoexerantdeporestvinc']         = $this->sicomNumberReal($aBF10['si206_vlsaldoexerantdeporestvinc'], 2);
        $aCSVBF10['si206_vltotalingresso']                    = $this->sicomNumberReal($aBF10['si206_vltotalingresso'], 2);

        $this->sLinha = $aCSVBF10;
        $this->adicionaLinha();

      }


      /** Registro 20 */
      for ($iCont = 0; $iCont < pg_num_rows($rsBF20); $iCont++) {

        $aBF20 = pg_fetch_array($rsBF20, $iCont, PGSQL_ASSOC);

        $aCSVBF20 = array();
        $aCSVBF20['si207_tiporegistro']                     = $this->padLeftZero($aBF20['si207_tiporegistro'], 2);
        $aCSVBF20['si207_vldesporcamenrecurordinarios']     = $this->sicomNumberReal($aBF20['si207_vldesporcamenrecurordinarios'], 2);
        $aCSVBF20['si207_vldesporcamenrecurvincueducacao']  = $this->sicomNumberReal($aBF20['si207_vldesporcamenrecurvincueducacao'], 2);
        $aCSVBF20['si207_vldesporcamenrecurvincusaude']     = $this->sicomNumberReal($aBF20['si207_vldesporcamenrecurvincusaude'], 2);
        $aCSVBF20['si207_vldesporcamenrecurvincurpps']      = $this->sicomNumberReal($aBF20['si207_vldesporcamenrecurvincurpps'], 2);
        $aCSVBF20['si207_vldesporcamenrecurvincuassistsoc'] = $this->sicomNumberReal($aBF20['si207_vldesporcamenrecurvincuassistsoc'], 2);
        $aCSVBF20['si207_vloutrasdesporcamendestrecursos']  = $this->sicomNumberReal($aBF20['si207_vloutrasdesporcamendestrecursos'], 2);
        $aCSVBF20['si207_vltransfinanconcexecorcamentaria'] = $this->sicomNumberReal($aBF20['si207_vltransfinanconcexecorcamentaria'], 2);
        $aCSVBF20['si207_vltransfinanconcindepenexecorc']   = $this->sicomNumberReal($aBF20['si207_vltransfinanconcindepenexecorc'], 2);
        $aCSVBF20['si207_vltransfinanconcaportesrecurpps']  = $this->sicomNumberReal($aBF20['si207_vltransfinanconcaportesrecurpps'], 2);
        $aCSVBF20['si207_vlpagrspnaoprocessado']            = $this->sicomNumberReal($aBF20['si207_vlpagrspnaoprocessado'], 2);
        $aCSVBF20['si207_vlpagrspprocessado']               = $this->sicomNumberReal($aBF20['si207_vlpagrspprocessado'], 2);
        $aCSVBF20['si207_vldeposrestvinculados']            = $this->sicomNumberReal($aBF20['si207_vldeposrestvinculados'], 2);
        $aCSVBF20['si207_vloutrospagextraorcamentarios']    = $this->sicomNumberReal($aBF20['si207_vloutrospagextraorcamentarios'], 2);
        $aCSVBF20['si207_vlsaldoexeratualcaixaequicaixa']   = $this->sicomNumberReal($aBF20['si207_vlsaldoexeratualcaixaequicaixa'], 2);
        $aCSVBF20['si207_vlsaldoexeratualdeporestvinc']     = $this->sicomNumberReal($aBF20['si207_vlsaldoexeratualdeporestvinc'], 2);
        $aCSVBF20['si207_vltotaldispendios']                = $this->sicomNumberReal($aBF20['si207_vltotaldispendios'], 2);

        $this->sLinha = $aCSVBF20;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
