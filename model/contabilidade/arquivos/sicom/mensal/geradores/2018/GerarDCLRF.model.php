<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarDCLRF extends GerarAM {

   /**
  *
  * Mes de referência
  * @var Integer
  */
  public $iMes;

  public function gerarDados() {

    $this->sArquivo = "DCLRF";
    $this->abreArquivo();

    $sSql = "select * from dclrf102018 where si157_mes = ". $this->iMes;
    $rsDCLRF10    = db_query($sSql);

    $sSql = "select * from dclrf202018 where si169_mes = ". $this->iMes;
    $rsDCLRF20    = db_query($sSql);

    $sSql = "select * from dclrf302018 where si178_mes = ". $this->iMes;
    $rsDCLRF30    = db_query($sSql);


  if (pg_num_rows($rsDCLRF10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsDCLRF10); $iCont++) {

        $aDCLRF10  = pg_fetch_array($rsDCLRF10,$iCont);

        $aCSVDCLRF10['si157_tiporegistro']                        =   str_pad($aDCLRF10['si157_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVDCLRF10['si157_codorgao']                            =   str_pad($aDCLRF10['si157_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVDCLRF10['si157_vlsaldoatualconcgarantiainterna']     =   number_format($aDCLRF10['si157_vlsaldoatualconcgarantiainterna'], 2, ",", "");
        $aCSVDCLRF10['si157_vlsaldoatualconcgarantia']            =   number_format($aDCLRF10['si157_vlsaldoatualconcgarantia'], 2, ",", "");
        $aCSVDCLRF10['si157_vlsaldoatualcontragarantiainterna']   =   number_format($aDCLRF10['si157_vlsaldoatualcontragarantiainterna'], 2, ",", "");
        $aCSVDCLRF10['si157_vlsaldoatualcontragarantiaexterna']   =   number_format($aDCLRF10['si157_vlsaldoatualcontragarantiaexterna'], 2, ",", "");
        $aCSVDCLRF10['si157_medidascorretivas']                   =   $aDCLRF10['si157_medidascorretivas'] == 0 ? '' : substr($aDCLRF10['si157_medidascorretivas'], 0, 4000);
        $aCSVDCLRF10['si157_recprivatizacao']                     =   number_format($aDCLRF10['si157_recprivatizacao'], 2, ",", "");
        $aCSVDCLRF10['si157_vlliqincentcontrib']                  =   number_format($aDCLRF10['si157_vlliqincentcontrib'], 2, ",", "");
        $aCSVDCLRF10['si157_vlliqincentinstfinanc']               =   number_format($aDCLRF10['si157_vlliqincentinstfinanc'], 2, ",", "");
        $aCSVDCLRF10['si157_vlirpnpincentcontrib']                =   number_format($aDCLRF10['si157_vlirpnpincentcontrib'], 2, ",", "");
        $aCSVDCLRF10['si157_vlirpnpincentinstfinanc']             =   number_format($aDCLRF10['si157_vlirpnpincentinstfinanc'], 2, ",", "");
        $aCSVDCLRF10['si157_vlcompromissado']                     =   number_format($aDCLRF10['si157_vlcompromissado'], 2, ",", "");
        $aCSVDCLRF10['si157_vlrecursosnaoaplicados']              =   number_format($aDCLRF10['si157_vlrecursosnaoaplicados'], 2, ",", "");
        $aCSVDCLRF10['si157_publiclrf']                           =   $aDCLRF10['si157_publiclrf'] == 0 ? '' : $aDCLRF10['si157_publiclrf'];
        $aCSVDCLRF10['si157_dtpublicacaorelatoriolrf']            =   implode("", array_reverse(explode("-", $aDCLRF10['si157_dtpublicacaorelatoriolrf'])));
        $aCSVDCLRF10['si157_tpbimestre']                          =   $aDCLRF10['si157_tpbimestre'] == 0 ? '' : $aDCLRF10['si157_tpbimestre'];
        $aCSVDCLRF10['si157_metarrecada']                         =   $aDCLRF10['si157_metarrecada'] == 0 ? '' : $aDCLRF10['si157_metarrecada'];
        $aCSVDCLRF10['si157_dscmedidasadotadas']                  =   $aDCLRF10['si157_dscmedidasadotadas'] == 0 ? '' : substr($aDCLRF10['si157_dscmedidasadotadas'], 0, 4000);

        $this->sLinha = $aCSVDCLRF10;
        $this->adicionaLinha();

      }

      /**
       *
       * Registros 20
       */
      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDCLRF20); $iCont2++) {

          $aDCLRF20  = pg_fetch_array($rsDCLRF20,$iCont2);

          $aCSVDCLRF20['si169_tiporegistro']                        =   str_pad($aDCLRF20['si169_tiporegistro'], 2, "0", STR_PAD_LEFT);
          $aCSVDCLRF20['si169_contopcredito']                       =   str_pad($aDCLRF20['si169_contopcredito'], 1, "0", STR_PAD_LEFT);
          $aCSVDCLRF20['si169_dsccontopcredito']                    =   substr($aDCLRF20['si169_dsccontopcredito'], 0, 1000);
          $aCSVDCLRF20['si169_realizopcredito']                     =   str_pad($aDCLRF20['si169_realizopcredito'], 1, "0", STR_PAD_LEFT);
          $aCSVDCLRF20['si169_tiporealizopcreditocapta']            =   str_pad($aDCLRF20['si169_tiporealizopcreditocapta'], 1, "0", STR_PAD_LEFT);
          $aCSVDCLRF20['si169_tiporealizopcreditoreceb']            =   str_pad($aDCLRF20['si169_tiporealizopcreditoreceb'], 1, "0", STR_PAD_LEFT);
          $aCSVDCLRF20['si169_tiporealizopcreditoassundir']         =   str_pad($aDCLRF20['si169_tiporealizopcreditoassundir'], 1, "0", STR_PAD_LEFT);
          $aCSVDCLRF20['si169_tiporealizopcreditoassunobg']         =   str_pad($aDCLRF20['si169_tiporealizopcreditoassunobg'], 1, "0", STR_PAD_LEFT);

          $this->sLinha = $aCSVDCLRF20;
          $this->adicionaLinha();

      }


      /**
       *
       * Registros 30
       */
      for ($iCont3 = 0;$iCont3 < pg_num_rows($rsDCLRF30); $iCont3++) {

          $aDCLRF30 = pg_fetch_array($rsDCLRF30,$iCont3);

          $aCSVDCLRF30['si178_tiporegistro']              = $this->padLeftZero($aDCLRF30['si178_tiporegistro'], 2);
          $aCSVDCLRF30['si178_publiclrf']                 = $this->padLeftZero($aDCLRF30['si178_publiclrf'], 2);
          $aCSVDCLRF30['si178_dtpublicacaorelatoriolrf']  = $this->sicomDate($aDCLRF30['si178_dtpublicacaorelatoriolrf']);
          $aCSVDCLRF30['si178_localpublicacao']           = strlen($aDCLRF30['si178_localpublicacao']) > 0 ? $aDCLRF30['si178_localpublicacao'] : ' ';
          $aCSVDCLRF30['si178_tpbimestre']                = substr($aDCLRF30['si178_tpbimestre'], 0, 1);
          $aCSVDCLRF30['si178_mes']                       = $aDCLRF30['si178_mes'];
          $aCSVDCLRF30['si178_instit']                    = $aDCLRF30['si178_instit'];

          $this->sLinha = $aCSVDCLRF30;
          $this->adicionaLinha();

      }


      $this->fechaArquivo();

    }

  }

}
