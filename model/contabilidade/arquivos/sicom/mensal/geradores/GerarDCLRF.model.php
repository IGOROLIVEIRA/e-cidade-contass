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
    
    $sSql = "select * from dclrf102014 where si157_mes = ". $this->iMes;
    $rsDCLRF10    = db_query($sSql);


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
        
        $aCSVDCLRF10['si157_tiporegistro']                 =   str_pad($aDCLRF10['si157_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVDCLRF10['si157_codorgao']                     =   str_pad($aDCLRF10['si157_codorgao'], 2, "0", STR_PAD_LEFT);       
        $aCSVDCLRF10['si157_vlsaldoatualconcgarantia']     =   number_format($aDCLRF10['si157_vlsaldoatualconcgarantia'], 2, ",", "");
        $aCSVDCLRF10['si157_recprivatizacao']              =   number_format($aDCLRF10['si157_recprivatizacao'], 2, ",", "");
        $aCSVDCLRF10['si157_vlliqincentcontrib']           =   number_format($aDCLRF10['si157_vlliqincentcontrib'], 2, ",", "");
        $aCSVDCLRF10['si157_vlliqincentinstfinanc']        =   number_format($aDCLRF10['si157_vlliqincentinstfinanc'], 2, ",", "");
        $aCSVDCLRF10['si157_vlirpnpincentcontrib']         =   number_format($aDCLRF10['si157_vlirpnpincentcontrib'], 2, ",", "");
        $aCSVDCLRF10['si157_vlirpnpincentinstfinanc']      =   number_format($aDCLRF10['si157_vlirpnpincentinstfinanc'], 2, ",", "");
        $aCSVDCLRF10['si157_vlcompromissado']              =   number_format($aDCLRF10['si157_vlcompromissado'], 2, ",", "");
        $aCSVDCLRF10['si157_vlrecursosnaoaplicados']       =   number_format($aDCLRF10['si157_vlrecursosnaoaplicados'], 2, ",", "");
        
        $this->sLinha = $aCSVDCLRF10;
        $this->adicionaLinha();

      }


      $this->fechaArquivo();

    }

  } 

}