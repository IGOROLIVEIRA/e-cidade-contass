<?php 

require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

 /**
  * Sicom Acompanhamento Mensal
  * @author marcelo
  * @package Contabilidade
  */

class GerarCRONEM extends GerarAM {

   /**
  * 
  * Mes de referência
  * @var Integer
  */
  public $iMes;
  
  public function gerarDados() {

    $this->sArquivo = "CRONEM";
    $this->abreArquivo();
    
    $sSql = "select * from cronem102016 where si170_mes = ". $this->iMes;
    $rsCRONEM10    = db_query($sSql);


  if (pg_num_rows($rsCRONEM10) == 0) {

      $aCSV['tiporegistro']       =   '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

  } else {

      /**
      *
      * Registros 10
      */
      for ($iCont = 0;$iCont < pg_num_rows($rsCRONEM10); $iCont++) {

        $aCRONEM10  = pg_fetch_array($rsCRONEM10,$iCont);
        
        $aCSVCRONEM10['si170_tiporegistro']                        =   str_pad($aCRONEM10['si170_tiporegistro'], 2, "0", STR_PAD_LEFT);
        $aCSVCRONEM10['si170_codorgao']                            =   str_pad($aCRONEM10['si170_codorgao'], 2, "0", STR_PAD_LEFT);
        $aCSVCRONEM10['si170_codunidadesub']                       =   str_pad($aCRONEM10['si170_codunidadesub'], 8, "0", STR_PAD_LEFT);
        $aCSVCRONEM10['si170_grupodespesa']                        =   str_pad($aCRONEM10['si170_grupodespesa'], 1, "0", STR_PAD_LEFT);
        $aCSVCRONEM10['si170_vldotmensal']                         =   number_format($aCRONEM10['si170_vldotmensal'], 2, ",", "");
        
        $this->sLinha = $aCSVCRONEM10;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  } 

}
