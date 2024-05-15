<?php

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcony
  * @package Contabilidade
  */

 class GerarDCLRF extends GerarAM {

   /**
  *
  * Mes de referência
  * @var Integer
  */
   public $iMes;
   /**
  *
  * Código do órgão
  * @var Integer
  */
   public $iOrgao;
   public $iTipoIntint;

   public function gerarDados() {

    $this->sArquivo = "DCLRF";
    $this->abreArquivo();

    $sSql = "select * from dclrf102018  ";
    $sSql .= " left join dclrf202018 on si190_sequencial = si191_reg10 ";
    $sSql .= " left join dclrf302018 on si190_sequencial = si192_reg10 ";
    $sSql .= " left join dclrf402018 on si190_sequencial = si193_reg10 ";
    $sSql .= " where si190_mes = '".$this->iMes."' and si190_codorgao = '".$this->iOrgao."'";
    $rsDCLRF    = db_query($sSql);

    if (pg_num_rows($rsDCLRF) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      for ($iCont = 0;$iCont < pg_num_rows($rsDCLRF); $iCont++) {

        $aDCLRF  = pg_fetch_array($rsDCLRF,$iCont);
        if($this->iTipoIntint == 2):
          $aCSVDCLRF10['si190_tiporegistro']                      = str_pad($aDCLRF['si190_tiporegistro'], 2, "0", STR_PAD_LEFT);
          $aCSVDCLRF10['si190_codorgao']                          = str_pad((int)$aDCLRF['si190_codorgao'], 2, "0", STR_PAD_LEFT);
          $aCSVDCLRF10['si190_passivosreconhecidos']              = number_format($aDCLRF['si190_passivosreconhecidos'], 2, ",", "");
          $aCSVDCLRF10['si190_vlsaldoatualconcgarantiainterna']   = number_format($aDCLRF['si190_vlsaldoatualconcgarantiainterna'], 2, ",", "");
          $aCSVDCLRF10['si190_vlsaldoatualconcgarantia']          = number_format($aDCLRF['si190_vlsaldoatualconcgarantia'], 2, ",", "");
          $aCSVDCLRF10['si190_vlsaldoatualcontragarantiainterna'] = number_format($aDCLRF['si190_vlsaldoatualcontragarantiainterna'], 2, ",", "");
          $aCSVDCLRF10['si190_vlsaldoatualcontragarantiaexterna'] = number_format($aDCLRF['si190_vlsaldoatualcontragarantiaexterna'], 2, ",", "");
          $aCSVDCLRF10['si190_medidascorretivas']                 = $aDCLRF['si190_medidascorretivas'] == '' ? ' ': substr($aDCLRF['si190_medidascorretivas'], 0, 4000) ;
          $aCSVDCLRF10['si190_recalieninvpermanente']             = number_format($aDCLRF['si190_recalieninvpermanente'], 2, ",", "");
          $aCSVDCLRF10['si190_vldotatualizadaincentcontrib']      = number_format($aDCLRF['si190_vldotatualizadaincentcontrib'], 2, ",", "");
          $aCSVDCLRF10['si190_vlempenhadoicentcontrib']           = number_format($aDCLRF['si190_vlempenhadoicentcontrib'], 2, ",", "");
          $aCSVDCLRF10['si190_vldotatualizadaincentinstfinanc']   = number_format($aDCLRF['si190_vldotatualizadaincentinstfinanc'], 2, ",", "");
          $aCSVDCLRF10['si190_vlempenhadoincentinstfinanc']       = number_format($aDCLRF['si190_vlempenhadoincentinstfinanc'], 2, ",", "");
          $aCSVDCLRF10['si190_vlliqincentcontrib']                = number_format($aDCLRF['si190_vlliqincentcontrib'], 2, ",", "");
          $aCSVDCLRF10['si190_vlliqincentinstfinanc']             = number_format($aDCLRF['si190_vlliqincentinstfinanc'], 2, ",", "");
          $aCSVDCLRF10['si190_vlirpnpincentcontrib']              = number_format($aDCLRF['si190_vlirpnpincentcontrib'], 2, ",", "");
          $aCSVDCLRF10['si190_vlirpnpincentinstfinanc']           = number_format($aDCLRF['si190_vlirpnpincentinstfinanc'], 2, ",", "");
          $aCSVDCLRF10['si190_vlrecursosnaoaplicados']            = number_format($aDCLRF['si190_vlrecursosnaoaplicados'], 2, ",", "");
          $aCSVDCLRF10['si190_vlapropiacaodepositosjudiciais']    = number_format($aDCLRF['si190_vlapropiacaodepositosjudiciais'], 2, ",", "");
          $aCSVDCLRF10['si190_vloutrosajustes']                   = number_format($aDCLRF['si190_vloutrosajustes'], 2, ",", "");
          $aCSVDCLRF10['si190_metarrecada']                       = ($aDCLRF['si190_metarrecada'] == 0 || $aDCLRF['si190_metarrecada'] == "") ? ' ' : $aDCLRF['si190_metarrecada'] ;
          $aCSVDCLRF10['si190_dscmedidasadotadas']                = $aDCLRF['si190_dscmedidasadotadas'] == '' ? ' ' : substr($aDCLRF['si190_dscmedidasadotadas'], 0, 4000);
          $this->sLinha = $aCSVDCLRF10;
          $this->adicionaLinha();
        endif;
        if($this->iMes == 12){
          if($aDCLRF['si191_reg10'] != null || $aDCLRF['si191_reg10'] != ""){

            $aCSVDCLRF20['si191_tiporegistro']                = str_pad($aDCLRF['si191_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVDCLRF20['si191_contopcredito']               = $aDCLRF['si191_contopcredito'] == 0 ? ' ' : $aDCLRF['si191_contopcredito'];
            $aCSVDCLRF20['si191_dsccontopcredito']            = $aDCLRF['si191_dsccontopcredito'];
            $aCSVDCLRF20['si191_realizopcredito']             = $aDCLRF['si191_realizopcredito'] == 0 ? ' ' : $aDCLRF['si191_realizopcredito'];
            $aCSVDCLRF20['si191_tiporealizopcreditocapta']    = $aDCLRF['si191_tiporealizopcreditocapta'] == 0 ? ' ' : $aDCLRF['si191_tiporealizopcreditocapta'];
            $aCSVDCLRF20['si191_tiporealizopcreditoreceb']    = $aDCLRF['si191_tiporealizopcreditoreceb'] == 0 ? ' ' : $aDCLRF['si191_tiporealizopcreditoreceb'];
            $aCSVDCLRF20['si191_tiporealizopcreditoassundir'] = $aDCLRF['si191_tiporealizopcreditoassundir'] == 0 ? ' ' : $aDCLRF['si191_tiporealizopcreditoassundir'];
            $aCSVDCLRF20['si191_tiporealizopcreditoassunobg'] = $aDCLRF['si191_tiporealizopcreditoassunobg'] == 0 ? ' ' : $aDCLRF['si191_tiporealizopcreditoassunobg'];
            $this->sLinha = $aCSVDCLRF20;
            $this->adicionaLinha();

          }
        }

        if($aDCLRF['si192_reg10'] != null || $aDCLRF['si192_reg10'] != ""){
            $aCSVDCLRF30['si192_tiporegistro']              = $aDCLRF['si192_tiporegistro'];
            $aCSVDCLRF30['si192_publiclrf']                 = $aDCLRF['si192_publiclrf'];
            $aCSVDCLRF30['si192_dtpublicacaorelatoriolrf']  = ($aDCLRF['si192_dtpublicacaorelatoriolrf'] != '' || $aDCLRF['si192_dtpublicacaorelatoriolrf'] != null) ? date('dmY', strtotime($aDCLRF['si192_dtpublicacaorelatoriolrf'])) : '';
            $aCSVDCLRF30['si192_localpublicacao']           = $aDCLRF['si192_localpublicacao'] == '' ? ' ': substr($aDCLRF['si192_localpublicacao'], 0, 1000);
            $aCSVDCLRF30['si192_tpbimestre']                = $aDCLRF['si192_tpbimestre'] == 0 ? ' ' : $aDCLRF['si192_tpbimestre'] ;
            $aCSVDCLRF30['si192_exerciciotpbimestre']       = $aDCLRF['si192_exerciciotpbimestre'] == '' ? ' ' : substr($aDCLRF['si192_exerciciotpbimestre'], 0, 4) ;
            $this->sLinha = $aCSVDCLRF30;
            $this->adicionaLinha();
        }

        if($aDCLRF['si193_reg10'] != null || $aDCLRF['si193_reg10'] != ""){
            $aCSVDCLRF40['si193_tiporegistro']              = $aDCLRF['si193_tiporegistro'];
            $aCSVDCLRF40['si193_publicrgf']                 = $aDCLRF['si193_publicrgf'];
            $aCSVDCLRF40['si193_dtpublicacaorelatoriorgf']  = ($aDCLRF['si193_dtpublicacaorelatoriorgf'] != '' || $aDCLRF['si193_dtpublicacaorelatoriorgf'] != null) ? date('dmY', strtotime($aDCLRF['si193_dtpublicacaorelatoriorgf'])) : '';
            $aCSVDCLRF40['si193_localpublicacaorgf']        = $aDCLRF['si193_localpublicacaorgf'] == '' ? ' ': substr($aDCLRF['si193_localpublicacaorgf'], 0, 1000);
            $aCSVDCLRF40['si193_tpperiodo']                 = $aDCLRF['si193_tpperiodo'] == 0 ? ' ' : $aDCLRF['si193_tpperiodo'] ;
            $aCSVDCLRF40['si193_exerciciotpperiodo']        = $aDCLRF['si193_exerciciotpperiodo'] == '' ? ' ' : substr($aDCLRF['si193_exerciciotpperiodo'], 0, 4) ;
            $this->sLinha = $aCSVDCLRF40;
            $this->adicionaLinha();
        }
      }
      $this->fechaArquivo();
    }
  }
}
