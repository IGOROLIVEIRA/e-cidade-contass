<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");


 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarALQ extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "ALQ";
    $this->abreArquivo();
    
    $sSql = "select * from alq102015 where si121_mes = ". $this->iMes ." and si121_instit = ".db_getsession("DB_instit");
    $rsALQ10    = db_query($sSql);

    $sSql2 = "select * from alq112015 where si122_mes = ". $this->iMes ." and si122_instit = ".db_getsession("DB_instit");
    $rsALQ11    = db_query($sSql2);
    

    $sSql3 = "select * from alq122015 where si123_mes = ". $this->iMes ." and si123_instit = ".db_getsession("DB_instit");
    $rsALQ12    = db_query($sSql3);


  if (pg_num_rows($rsALQ10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsALQ10); $iCont++) {

        $aALQ10  = pg_fetch_array($rsALQ10,$iCont);
        
        $aCSVALQ10['si121_tiporegistro']                    =   str_pad($aALQ10['si121_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVALQ10['si121_codreduzido']                     =   substr($aALQ10['si121_codreduzido'], 0, 15);
        $aCSVALQ10['si121_codorgao']                        =   str_pad($aALQ10['si121_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVALQ10['si121_codunidadesub']                   =   str_pad($aALQ10['si121_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVALQ10['si121_nroempenho']                      =   substr($aALQ10['si121_nroempenho'], 0, 22);
        $aCSVALQ10['si121_dtempenho']                       =   implode("", array_reverse(explode("-", $aALQ10['si121_dtempenho'])));
        $aCSVALQ10['si121_dtliquidacao']                    =   implode("", array_reverse(explode("-", $aALQ10['si121_dtliquidacao'])));
        $aCSVALQ10['si121_nroliquidacao']                   =   substr($aALQ10['si121_nroliquidacao'], 0, 22);
        $aCSVALQ10['si121_dtanulacaoliq']                   =   implode("", array_reverse(explode("-", $aALQ10['si121_dtanulacaoliq'])));
        $aCSVALQ10['si121_nroliquidacaoanl']                =   substr($aALQ10['si121_nroliquidacao'], 0, 22);
        $aCSVALQ10['si121_tpliquidacao']                    =   str_pad($aALQ10['si121_tpliquidacao'], 1, "0", STR_PAD_LEFT);
        $aCSVALQ10['si121_justificativaanulacao']           =   substr($aALQ10['si121_justificativaanulacao'], 0, 500);
        $aCSVALQ10['si121_vlanulado']                       =   number_format($aALQ10['si121_vlanulado'], 2, ",", "");
        
        $this->sLinha = $aCSVALQ10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsALQ11); $iCont2++) {        

          $aALQ11  = pg_fetch_array($rsALQ11,$iCont2);
          
          if ($aALQ10['si121_sequencial'] == $aALQ11['si122_reg10']) {

            $aCSVALQ11['si122_tiporegistro']             =    str_pad($aALQ11['si122_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVALQ11['si122_codreduzido']              =    substr($aALQ11['si122_codreduzido'], 0, 15);
            $aCSVALQ11['si122_codfontrecursos']          =    str_pad($aALQ11['si122_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVALQ11['si122_valoranuladofonte']        =    number_format($aALQ11['si122_valoranuladofonte'], 2, ",", "");
            
            $this->sLinha = $aCSVALQ11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsALQ12); $iCont3++) {        

          $aALQ12  = pg_fetch_array($rsALQ12,$iCont3);
          
          if ($aALQ10['si121_sequencial'] == $aALQ12['si123_reg10']) {

            $aCSVALQ12['si123_tiporegistro']             =    str_pad($aALQ12['si123_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVALQ12['si123_codreduzido']              =    substr($aALQ12['si123_codreduzido'], 0, 15);
            $aCSVALQ12['si123_mescompetencia']           =    str_pad($aALQ12['si123_mescompetencia'], 2, "0", STR_PAD_LEFT);
            $aCSVALQ12['si123_exerciciocompetencia']     =    str_pad($aALQ12['si123_exerciciocompetencia'], 4, "0", STR_PAD_LEFT);
            $aCSVALQ12['si123_vlanuladodspexerant']      =    number_format($aALQ12['si123_vlanuladodspexerant'], 2, ",", "");

            $this->sLinha = $aCSVALQ12;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 

}
}
