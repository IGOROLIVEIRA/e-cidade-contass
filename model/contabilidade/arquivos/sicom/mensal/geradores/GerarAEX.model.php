<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");


 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarAEX extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "AEX";
    $this->abreArquivo();
    
    $sSql = "select * from aex102014 where si129_mes = ". $this->iMes;
    $rsAEX10    = db_query($sSql);
    
    $sSql2 = "select * from aex112014 where si130_mes = ". $this->iMes;
    $rsAEX11    = db_query($sSql2);
    



  if (pg_num_rows($rsAEX10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsAEX10); $iCont++) {

        $aAEX10  = pg_fetch_array($rsAEX10,$iCont);
        
        $aCSVAEX10['si129_tiporegistro']                    =   str_pad($aAEX10['si129_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVAEX10['si129_codreduzidoaex']                  =   substr($aAEX10['si129_codreduzidoaex'], 0, 15);
        $aCSVAEX10['si129_codorgao']                        =   str_pad($aAEX10['si129_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVAEX10['si129_codext']                          =   substr($aAEX10['si129_codext'], 0, 15);
        $aCSVAEX10['si129_codfontrecursos']                 =   str_pad($aAEX10['si129_codfontrecursos'], 3, "0", STR_PAD_LEFT);
        $aCSVAEX10['si129_categoria']                       =   str_pad($aAEX10['si129_categoria'], 1, "0", STR_PAD_LEFT);
        $aCSVAEX10['si129_dtlancamento']                    =   implode("", array_reverse(explode("-", $aAEX10['si129_dtlancamento'])));
        $aCSVAEX10['si129_dtanulacaoextra']                 =   implode("", array_reverse(explode("-", $aAEX10['si129_dtanulacaoextra'])));
        $aCSVAEX10['si129_justificativaanulacao']           =   substr($aAEX10['si129_justificativaanulacao'], 0, 500);
        $aCSVAEX10['si129_vlanulacao']                      =   number_format($aAEX10['si129_vlanulacao'], 2, ",", "");
        
        $this->sLinha = $aCSVAEX10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsAEX11); $iCont2++) {        

          $aAEX11  = pg_fetch_array($rsAEX11,$iCont2);
          
          if ($aAEX10['si129_sequencial'] == $aAEX11['si130_reg10']) {

            $aCSVAEX11['si130_tiporegistro']             =    str_pad($aAEX11['si130_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVAEX11['si130_codreduzidoaex']           =    substr($aAEX11['si130_codreduzidoaex'], 0, 15);
            $aCSVAEX11['si130_nroop']                    =    substr($aAEX11['si130_nroop'], 0, 22);
            $aCSVAEX11['si130_dtPagamento']              =    implode("", array_reverse(explode("-", $aAEX11['si130_dtpagamento'])));
            $aCSVAEX11['si130_nroanulacaoop']            =    substr($aAEX11['si130_nroanulacaoop'], 0, 22);
            $aCSVAEX11['si130_dtanulacaoop']             =    implode("", array_reverse(explode("-", $aAEX11['si130_dtanulacaoop'])));
            $aCSVAEX11['si130_vlanulacaoop']             =    number_format($aAEX11['si130_vlanulacaoop'], 2, ",", "");
            
            $this->sLinha = $aCSVAEX11;
            $this->adicionaLinha();
          }

        }

      
     }
     $this->fechaArquivo();
  }
 }
}