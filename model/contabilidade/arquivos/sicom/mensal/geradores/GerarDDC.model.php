<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarDDC extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "DDC";
    $this->abreArquivo();
    
    $sSql = "select * from ddc102014 where si150_mes = ". $this->iMes;
    $rsDDC10    = db_query($sSql);

    $sSql2 = "select * from ddc202014 where si153_mes = ". $this->iMes;
    $rsDDC20    = db_query($sSql2);

    $sSql3 = "select * from ddc302014 where si154_mes = ". $this->iMes;
    $rsDDC30    = db_query($sSql3);


  if (pg_num_rows($rsDDC10) == 0 && pg_num_rows($rsDDC20) == 0 && pg_num_rows($rsDDC30) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsDDC10); $iCont++) {

        $aDDC10  = pg_fetch_array($rsDDC10,$iCont);
        
        $aCSVDDC10['si150_tiporegistro']               =   str_pad($aDDC10['si150_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVDDC10['si150_codorgao']                   =   str_pad($aDDC10['si150_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVDDC10['si150_nroleiautorizacao']          =   substr($aDDC10['si150_nroleiautorizacao'], 0, 6);
        $aCSVDDC10['si150_dtleiautorizacao']           =   implode("", array_reverse(explode("-", $aDDC10['si150_dtleiautorizacao'])));
        $aCSVDDC10['si150_dtpublicacaoleiautorizacao'] =   implode("", array_reverse(explode("-", $aDDC10['si150_dtleiautorizacao'])));
        
        $this->sLinha = $aCSVDDC10;
        $this->adicionaLinha();

      }

      for ($iCont2 = 0;$iCont2 < pg_num_rows($rsDDC20); $iCont2++) {

        $aDDC20  = pg_fetch_array($rsDDC20,$iCont2);
        
        $aCSVDDC20['si153_tiporegistro']                =   str_pad($aDDC20['si153_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVDDC20['si153_codorgao']                    =   str_pad($aDDC20['si153_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVDDC20['si153_nrocontratodivida']           =   substr($aDDC20['si153_nrocontratodivida'], 0, 30);
        $aCSVDDC20['si153_dtassinatura']                =   implode("", array_reverse(explode("-", $aDDC20['si153_dtassinatura'])));
        $aCSVDDC20['si153_contratodeclei']              =   str_pad($aDDC20['si153_contratodeclei'], 1, "0", STR_PAD_LEFT);
        $aCSVDDC20['si153_nroleiautorizacao']           =   substr($aDDC20['si153_nroleiautorizacao'], 0, 6);
        $aCSVDDC20['si153_dtleiautorizacao']            =   implode("", array_reverse(explode("-", $aDDC20['si153_dtleiautorizacao'])));
        $aCSVDDC20['si153_objetocontratodivida']        =   substr($aDDC20['si153_objetocontratodivida'], 0, 1000);
        $aCSVDDC20['si153_especificacaocontratodivida'] =   substr($aDDC20['si153_objetocontratodivida'], 0, 500);
        
        $this->sLinha = $aCSVDDC20;
        $this->adicionaLinha();

      }

      for ($iCont3 = 0;$iCont3 < pg_num_rows($rsDDC30); $iCont3++) {

        $aDDC30  = pg_fetch_array($rsDDC30,$iCont3);
        
        $aCSVDDC30['si154_tiporegistro']                =   str_pad($aDDC30['si154_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVDDC30['si154_codorgao']                    =   str_pad($aDDC30['si154_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVDDC30['si154_nrocontratodivida']           =   substr($aDDC30['si154_nrocontratodivida'], 0, 30);
        $aCSVDDC30['si154_dtassinatura']                =   implode("", array_reverse(explode("-", $aDDC30['si154_dtassinatura'])));
        $aCSVDDC30['si154_tipolancamento']              =   str_pad($aDDC30['si154_tipolancamento'], 2, "0", STR_PAD_LEFT);
        $aCSVDDC30['si154_tipodocumentocredor']         =   str_pad($aDDC30['si154_tipodocumentocredor'], 1, "0", STR_PAD_LEFT);
        $aCSVDDC30['si154_nrodocumentocredor']          =   substr($aDDC30['si154_nrodocumentocredor'], 0, 14);
        $aCSVDDC30['si154_justificativacancelamento']   =   substr($aDDC30['si154_justificativacancelamento'], 0, 500);
        $aCSVDDC30['si154_vlsaldoanterior']             =   number_format($aDDC30['si154_vlsaldoanterior'], 2, ",", "");
        $aCSVDDC30['si154_vlcontratacao']               =   number_format($aDDC30['si154_vlcontratacao'], 2, ",", "");
        $aCSVDDC30['si154_vlamortizacao']               =   number_format($aDDC30['si154_vlamortizacao'], 2, ",", "");
        $aCSVDDC30['si154_vlcancelamento']              =   number_format($aDDC30['si154_vlcancelamento'], 2, ",", "");
        $aCSVDDC30['si154_vlencampacao']                =   number_format($aDDC30['si154_vlencampacao'], 2, ",", "");
        $aCSVDDC30['si154_vlatualizacao']               =   number_format($aDDC30['si154_vlatualizacao'], 2, ",", "");
        $aCSVDDC30['si154_vlsaldoatual']                =   number_format($aDDC30['si154_vlsaldoatual'], 2, ",", "");
        
        $this->sLinha = $aCSVDDC30;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  } 

}