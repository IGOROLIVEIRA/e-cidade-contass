<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarAOP extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "AOP";
    $this->abreArquivo();
    
    $sSql = "select * from aop102014 where si137_mes = ". $this->iMes . " and si137_instit = ".db_getsession("DB_instit");
    $rsAOP10    = db_query($sSql);

    $sSql2 = "select * from aop112014 where si138_mes = ". $this->iMes . " and si138_instit = ".db_getsession("DB_instit");
    $rsAOP11    = db_query($sSql2);


  if (pg_num_rows($rsAOP10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsAOP10); $iCont++) {

        $aAOP10  = pg_fetch_array($rsAOP10,$iCont);
        
        $aCSVAOP10['si137_tiporegistro']               =   str_pad($aAOP10['si137_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVAOP10['si137_codreduzido']                =   substr($aAOP10['si137_codreduzido'], 0, 15);
        $aCSVAOP10['si137_codorgao']                   =   str_pad($aAOP10['si137_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVAOP10['si137_codunidadesub']              =   str_pad($aAOP10['si137_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVAOP10['si137_nroop']                      =   substr($aAOP10['si137_nroop'], 0, 22);
        $aCSVAOP10['si137_dtpagamento']                =   implode("", array_reverse(explode("-", $aAOP10['si137_dtpagamento'])));
        $aCSVAOP10['si137_nroanulacaoop']              =   substr($aAOP10['si137_nroanulacaoop'], 0, 22);
        $aCSVAOP10['si137_dtanulacaoop']               =   implode("", array_reverse(explode("-", $aAOP10['si137_dtanulacaoop'])));
        $aCSVAOP10['si137_justificativaanulacao']      =   substr($aAOP10['si137_justificativaanulacao'], 0, 500);
        $aCSVAOP10['si137_vlanulacaoop']               =   number_format($aAOP10['si137_vlanulacaoop'], 2, ",", "");
        
        $this->sLinha = $aCSVAOP10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsAOP11); $iCont2++) {        

          $aAOP11  = pg_fetch_array($rsAOP11,$iCont2);
          
          if ($aAOP10['si137_sequencial'] == $aAOP11['si138_reg10']) {

            $aCSVAOP11['si138_tiporegistro']             =    str_pad($aAOP11['si138_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVAOP11['si138_codreduzido']              =    substr($aAOP11['si138_codreduzido'], 0, 15);
            $aCSVAOP11['si138_tipopagamento']            =    str_pad($aAOP11['si138_tipopagamento'], 1, "0", STR_PAD_LEFT);
            $aCSVAOP11['si138_nroempenho']               =    substr($aAOP11['si138_nroempenho'], 0, 22);
            $aCSVAOP11['si138_dtempenho']                =    implode("", array_reverse(explode("-", $aAOP11['si138_dtempenho'])));
            $aCSVAOP11['si138_nroliquidacao']            =    substr($aAOP11['si138_nroliquidacao'], 0, 22);
            $aCSVAOP11['si138_dtliquidacao']             =    implode("", array_reverse(explode("-", $aAOP11['si138_dtliquidacao'])));
            $aCSVAOP11['si138_codfontrecursos']          =    str_pad($aAOP11['si138_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVAOP11['si138_valoranulacaofonte']       =    number_format($aAOP11['si138_valoranulacaofonte'], 2, ",", "");
            $aCSVAOP11['si138_codorgaoempop']            =    $aAOP11['si138_codorgaoempop'];
            $aCSVAOP11['si138_codunidadeempop']          =    $aAOP11['si138_codunidadeempop'];

            $this->sLinha = $aCSVAOP11;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 
  }
}