<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarAOB extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "AOB";
    $this->abreArquivo();
    
    $sSql = "select * from aob102015 where si141_mes = ". $this->iMes;
    $rsAOB10    = db_query($sSql);

    $sSql2 = "select * from aob112015 where si142_mes = ". $this->iMes;
    $rsAOB11    = db_query($sSql2);


  if (pg_num_rows($rsAOB10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10, 11
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsAOB10); $iCont++) {

        $aAOB10  = pg_fetch_array($rsAOB10,$iCont);
        
        $aCSVAOB10['si141_tiporegistro']               =   str_pad($aAOB10['si141_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVAOB10['si141_codreduzido']                =   substr($aAOB10['si141_nroop'], 0, 15);
        $aCSVAOB10['si141_codorgao']                   =   str_pad($aAOB10['si141_codunidadesubresp'], 2, "0", STR_PAD_LEFT);
        $aCSVAOB10['si141_codunidadesub']              =   str_pad($aAOB10['si141_codunidadesub'], 8, "0", STR_PAD_LEFT);
        $aCSVAOB10['si141_nroLancamento']              =   substr($aAOB10['si141_nroLancamento'], 0, 22);
        $aCSVAOB10['si141_dtlancamento']               =   implode("", array_reverse(explode("-", $aAOB10['si141_dtlancamento'])));
        $aCSVAOB10['si141_nroanulacaolancamento']      =   substr($aAOB10['si141_nroanulacaolancamento'], 0, 22);
        $aCSVAOB10['si141_dtanulacaolancamento']       =   implode("", array_reverse(explode("-", $aAOB10['si141_dtanulacaolancamento'])));
        $aCSVAOB10['si141_nroempenho']                 =   substr($aAOB10['si141_nroempenho'], 0, 22);
        $aCSVAOB10['si141_dtempenho']                  =   implode("", array_reverse(explode("-", $aAOB10['si141_dtempenho'])));
        $aCSVAOB10['si141_nroliquidacao']              =   substr($aAOB10['si141_nroliquidacao'], 0, 22);
        $aCSVAOB10['si141_dtliquidacao']               =   implode("", array_reverse(explode("-", $aAOB10['si141_dtliquidacao'])));
        $aCSVAOB10['si141_valoranulacaolancamento']    =   number_format($aAOB10['si141_valoranulacaolancamento'], 2, ",", "");
        
        $this->sLinha = $aCSVAOB10;
        $this->adicionaLinha();

        for ($iCont2 = 0;$iCont2 < pg_num_rows($rsAOB11); $iCont2++) {        

          $aAOB11  = pg_fetch_array($rsAOB11,$iCont2);
          
          if ($aAOB10['si141_sequencial'] == $aAOB11['si142_reg10']) {

            $aCSVAOB11['si142_tiporegistro']             =    str_pad($aAOB11['si142_tiporegistro'], 2, "0", STR_PAD_LEFT);
            $aCSVAOB11['si142_codreduzido']              =    substr($aAOB11['si142_codreduzido'], 0, 15);
            $aCSVAOB11['si142_codfontrecursos']          =    str_pad($aAOB11['si142_codfontrecursos'], 3, "0", STR_PAD_LEFT);
            $aCSVAOB11['si142_valoranulacaofonte']       =    number_format($aAOB11['si142_valoranulacaofonte'], 2, ",", "");

            $this->sLinha = $aCSVAOB11;
            $this->adicionaLinha();
            
          }

        }

      }

      $this->fechaArquivo();

    }

  } 

}