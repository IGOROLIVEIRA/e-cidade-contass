<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarCRONEM extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "CRONEM";
    $this->abreArquivo();
    
    $sSql = "select * from cronem102021 where si170_mes = " . $this->iMes." and si170_instit = ".db_getsession("DB_instit");
    $rsCRONEM10 = db_query($sSql);


    if (pg_num_rows($rsCRONEM10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsCRONEM10); $iCont++) {

        $aCRONEM10 = pg_fetch_array($rsCRONEM10, $iCont);
        
        $aCSVCRONEM10['si170_tiporegistro']   = $this->padLeftZero($aCRONEM10['si170_tiporegistro'], 2);
        $aCSVCRONEM10['si170_codorgao']       = $this->padLeftZero($aCRONEM10['si170_codorgao'], 2);
        $aCSVCRONEM10['si170_codunidadesub']  = $this->padLeftZero($aCRONEM10['si170_codunidadesub'], strlen($aCRONEM10['si170_codunidadesub']) > 5 ? 8 : 5);
        $aCSVCRONEM10['si170_grupodespesa']   = $this->padLeftZero($aCRONEM10['si170_grupodespesa'], 1);
        $aCSVCRONEM10['si170_vldotmensal']    = $this->sicomNumberReal($aCRONEM10['si170_vldotmensal'], 2);
        
        $this->sLinha = $aCSVCRONEM10;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }
  }
}
