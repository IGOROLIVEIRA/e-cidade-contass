<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");


 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarLQD extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "LQD";
    $this->abreArquivo();
    
    $sSql = "select * from lqd102016 where si118_mes = ". $this->iMes ." and si118_instit = ".db_getsession("DB_instit");
    $rsLQD10    = db_query($sSql);

    $sSql2 = "select * from lqd112016 where si119_mes = ". $this->iMes ." and si119_instit = ".db_getsession("DB_instit");
    $rsLQD11    = db_query($sSql2);

    $sSql3 = "select * from lqd122016 where si120_mes = ". $this->iMes ." and si120_instit = ".db_getsession("DB_instit");
    $rsLQD12    = db_query($sSql3);

  if (pg_num_rows($rsLQD10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11, 12
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsLQD10); $iCont++) {

        $aLQD10  = pg_fetch_array($rsLQD10,$iCont);
        
        $aCSVLQD10['si118_tiporegistro']                    =   str_pad($aLQD10['si118_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVLQD10['si118_codreduzido']                     =   substr($aLQD10['si118_codreduzido'], 0, 15);
        $aCSVLQD10['si118_codorgao']                        =   str_pad($aLQD10['si118_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVLQD10['si118_codunidadesub']                   =   str_pad($aLQD10['si118_codunidadesub'], 5, "0", STR_PAD_LEFT);
        $aCSVLQD10['si118_tpliquidacao']                    =   str_pad($aLQD10['si118_tpliquidacao'], 1, "0", STR_PAD_LEFT);
        $aCSVLQD10['si118_nroempenho']                      =   substr($aLQD10['si118_nroempenho'], 0, 22);
        $aCSVLQD10['si118_dtempenho']                       =   implode("", array_reverse(explode("-", $aLQD10['si118_dtempenho'])));
        $aCSVLQD10['si118_dtliquidacao']                    =   implode("", array_reverse(explode("-", $aLQD10['si118_dtliquidacao'])));
        $aCSVLQD10['si118_nroliquidacao']                   =   substr($aLQD10['si118_nroliquidacao'], 0, 22);
        $aCSVLQD10['si118_vlliquidado']                     =   number_format($aLQD10['si118_vlliquidado'], 2, ",", "");
        $aCSVLQD10['si118_cpfliquidante']                   =   str_pad($aLQD10['si118_cpfliquidante'], 11, "0", STR_PAD_LEFT);
        
        $this->sLinha = $aCSVLQD10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsLQD11); $iCont2++) {        

          $aLQD11  = pg_fetch_array($rsLQD11,$iCont2);
          
          if ($aLQD10['si118_sequencial'] == $aLQD11['si119_reg10']) {

            $aCSVLQD11['si119_tiporegistro']             =    str_pad($aLQD11['si119_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVLQD11['si119_codreduzido']              =    substr($aLQD11['si119_codreduzido'], 0, 15);
            $aCSVLQD11['si119_codfontrecursos']          =    str_pad($aLQD11['si119_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVLQD11['si119_valorfonte']               =    number_format($aLQD11['si119_valorfonte'], 2, ",", "");
            
            $this->sLinha = $aCSVLQD11;
            $this->adicionaLinha();
          }

        }

        for ($iCont3 = 0;$iCont3 < pg_num_rows($rsLQD12); $iCont3++) {        

          $aLQD12  = pg_fetch_array($rsLQD12,$iCont3);
          
          if ($aLQD10['si118_sequencial'] == $aLQD12['si120_reg10']) {

            $aCSVLQD12['si120_tiporegistro']             =    str_pad($aLQD12['si120_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVLQD12['si120_codreduzido']              =    substr($aLQD12['si120_codreduzido'], 0, 15);
            $aCSVLQD12['si120_mescompetencia']           =    str_pad($aLQD12['si120_mescompetencia'], 2, "0", STR_PAD_LEFT);
            $aCSVLQD12['si120_exerciciocompetencia']     =    str_pad($aLQD12['si120_exerciciocompetencia'], 4, "0", STR_PAD_LEFT);
            $aCSVLQD12['si120_vldspexerant']             =    number_format($aLQD12['si120_vldspexerant'], 2, ",", "");

            $this->sLinha = $aCSVLQD12;
            $this->adicionaLinha();
          }

        }

      }

      $this->fechaArquivo();

  } 
  }
}
