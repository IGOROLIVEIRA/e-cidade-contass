<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - DVP
 * @author gabriel
 * @package Contabilidade
 */
class GerarDVP extends GerarAM
{

  public function gerarDados()
  {

    $this->sArquivo = "DVP";
    $this->abreArquivo();

    $sSql = "select * from dvpdcasp102017 where 1 = 1";
    $rsDVP10 = db_query($sSql);

    $sSql = "select * from dvpdcasp202017 where 1 = 1";
    $rsDVP20 = db_query($sSql);

    $sSql = "select * from dvpdcasp302017 where 1 = 1";
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
        $aCSVDVP10['si216_exercicio']                           = $this->padLeftZero($aDVP10['si216_exercicio'], 1);
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
        $aCSVDVP20['si216_tiporegistro']                        = $this->padLeftZero($aDVP20['si216_tiporegistro'], 2);
        $aCSVDVP20['si216_exercicio']                           = $this->padLeftZero($aDVP20['si216_exercicio'], 1);
        $aCSVDVP20['si216_vlimpostos']                          = $this->sicomNumberReal($aDVP20['si216_vlimpostos'], 2);
        $aCSVDVP20['si216_vlcontribuicoes']                     = $this->sicomNumberReal($aDVP20['si216_vlcontribuicoes'], 2);
        $aCSVDVP20['si216_vlexploracovendasdireitos']           = $this->sicomNumberReal($aDVP20['si216_vlexploracovendasdireitos'], 2);
        $aCSVDVP20['si216_vlvariacoesaumentativasfinanceiras']  = $this->sicomNumberReal($aDVP20['si216_vlvariacoesaumentativasfinanceiras'], 2);
        $aCSVDVP20['si216_vltransfdelegacoesrecebidas']         = $this->sicomNumberReal($aDVP20['si216_vltransfdelegacoesrecebidas'], 2);
        $aCSVDVP20['si216_vlvalorizacaoativodesincorpassivo']   = $this->sicomNumberReal($aDVP20['si216_vlvalorizacaoativodesincorpassivo'], 2);
        $aCSVDVP20['si216_vloutrasvariacoespatriaumentativas']  = $this->sicomNumberReal($aDVP20['si216_vloutrasvariacoespatriaumentativas'], 2);
        $aCSVDVP20['si216_vltotalvpaumentativas']               = $this->sicomNumberReal($aDVP20['si216_vltotalvpaumentativas'], 2);

        $this->sLinha = $aCSVDVP20;
        $this->adicionaLinha();

      }


      /** Registro 30 */
      for ($iCont = 0; $iCont < pg_num_rows($rsDVP30); $iCont++) {

        $aDVP30 = pg_fetch_array($rsDVP30, $iCont, PGSQL_ASSOC);

        $aCSVDVP30 = array();
        $aCSVDVP30['si218_tiporegistro']                  = $this->padLeftZero($aDVP30['si218_tiporegistro'], 2);
        $aCSVDVP30['si218_exercicio']                     = $this->padLeftZero($aDVP30['si218_exercicio'], 1);
        $aCSVDVP30['si218_vlresultadopatrimonialperiodo'] = $this->sicomNumberReal($aDVP30['si218_vlresultadopatrimonialperiodo'], 2);

        $this->sLinha = $aCSVDVP30;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
