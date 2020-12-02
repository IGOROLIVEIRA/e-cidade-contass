<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - DVP
 * @author gabriel
 * @package Contabilidade
 */
class GerarDVP extends GerarAM
{
  public $iAno;
  public $iPeriodo;

  public function gerarDados()
  {

    $this->sArquivo = "DVP";
    $this->abreArquivo();
    $sSql = "select * from dvpdcasp102021 where si216_ano = {$this->iAno} AND si216_periodo = {$this->iPeriodo} AND si216_institu = " . db_getsession("DB_instit");
    $rsDVP10 = db_query($sSql);

    $sSql = "select * from dvpdcasp202121 where si217_ano = {$this->iAno} AND si217_periodo = {$this->iPeriodo} AND si217_institu = " . db_getsession("DB_instit");
    $rsDVP20 = db_query($sSql);

    $sSql = "select * from dvpdcasp302021 where si218_ano = {$this->iAno} AND si218_periodo = {$this->iPeriodo} AND si218_institu = " . db_getsession("DB_instit");
    $rsDVP30 = db_query($sSql);


    if (pg_num_rows($rsDVP10) == 0
      && pg_num_rows($rsDVP20) == 0
      && pg_num_rows($rsDVP30) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {


      /** Registro 10 */
      for ($iCont = 0; $iCont < pg_num_rows($rsDVP10); $iCont++) {

        $aDVP10 = pg_fetch_array($rsDVP10, $iCont, PGSQL_ASSOC);

        $aCSVDVP10 = array();
        $aCSVDVP10['si216_tiporegistro']                        = $this->padLeftZero($aDVP10['si216_tiporegistro'], 2);
        $aCSVDVP10['si216_vlimpostos']                          = $this->sicomNumberReal($aDVP10['si216_vlimpostos'], 2);
        $aCSVDVP10['si216_vlcontribuicoes']                     = $this->sicomNumberReal($aDVP10['si216_vlcontribuicoes'], 2);
        $aCSVDVP10['si216_vlexploracovendasdireitos']           = $this->sicomNumberReal($aDVP10['si216_vlexploracovendasdireitos'], 2);
        $aCSVDVP10['si216_vlvariacoesaumentativasfinanceiras']  = $this->sicomNumberReal($aDVP10['si216_vlvariacoesaumentativasfinanceiras'], 2);
        $aCSVDVP10['si216_vltransfdelegacoesrecebidas']         = $this->sicomNumberReal($aDVP10['si216_vltransfdelegacoesrecebidas'], 2);
        $aCSVDVP10['si216_vlvalorizacaoativodesincorpassivo']   = $this->sicomNumberReal($aDVP10['si216_vlvalorizacaoativodesincorpassivo'], 2);
        $aCSVDVP10['si216_vloutrasvariacoespatriaumentativas']  = $this->sicomNumberReal($aDVP10['si216_vloutrasvariacoespatriaumentativas'], 2);
        $aCSVDVP10['si216_vltotalvpaumentativas']               = $this->sicomNumberReal($aDVP10['si216_vltotalvpaumentativas'], 2);

        $this->sLinha = $aCSVDVP10;
        $this->adicionaLinha();

      }


      /** Registro 20 */
      for ($iCont = 0; $iCont < pg_num_rows($rsDVP20); $iCont++) {

        $aDVP20 = pg_fetch_array($rsDVP20, $iCont, PGSQL_ASSOC);

        $aCSVDVP20 = array();
        $aCSVDVP20['si217_tiporegistro']                      = $this->padLeftZero($aDVP20['si217_tiporegistro'], 2);
        $aCSVDVP20['si217_vldiminutivapessoaencargos']        = $this->sicomNumberReal($aDVP20['si217_vldiminutivapessoaencargos'], 2);
        $aCSVDVP20['si217_vlprevassistenciais']               = $this->sicomNumberReal($aDVP20['si217_vlprevassistenciais'], 2);
        $aCSVDVP20['si217_vlservicoscapitalfixo']             = $this->sicomNumberReal($aDVP20['si217_vlservicoscapitalfixo'], 2);
        $aCSVDVP20['si217_vldiminutivavariacoesfinanceiras']  = $this->sicomNumberReal($aDVP20['si217_vldiminutivavariacoesfinanceiras'], 2);
        $aCSVDVP20['si217_vltransfconcedidas']                = $this->sicomNumberReal($aDVP20['si217_vltransfconcedidas'], 2);
        $aCSVDVP20['si217_vldesvaloativoincorpopassivo']      = $this->sicomNumberReal($aDVP20['si217_vldesvaloativoincorpopassivo'], 2);
        $aCSVDVP20['si217_vltributarias']                     = $this->sicomNumberReal($aDVP20['si217_vltributarias'], 2);
        $aCSVDVP20['si217_vlmercadoriavendidoservicos']       = $this->sicomNumberReal($aDVP20['si217_vlmercadoriavendidoservicos'], 2);
        $aCSVDVP20['si217_vloutrasvariacoespatridiminutivas'] = $this->sicomNumberReal($aDVP20['si217_vloutrasvariacoespatridiminutivas'], 2);
        $aCSVDVP20['si217_vltotalvpdiminutivas']              = $this->sicomNumberReal($aDVP20['si217_vltotalvpdiminutivas'], 2);

        $this->sLinha = $aCSVDVP20;
        $this->adicionaLinha();

      }


      /** Registro 30 */
      for ($iCont = 0; $iCont < pg_num_rows($rsDVP30); $iCont++) {

        $aDVP30 = pg_fetch_array($rsDVP30, $iCont, PGSQL_ASSOC);

        $aCSVDVP30 = array();
        $aCSVDVP30['si218_tiporegistro']                  = $this->padLeftZero($aDVP30['si218_tiporegistro'], 2);
        $aCSVDVP30['si218_vlresultadopatrimonialperiodo'] = $this->sicomNumberReal($aDVP30['si218_vlresultadopatrimonialperiodo'], 2);

        $this->sLinha = $aCSVDVP30;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
