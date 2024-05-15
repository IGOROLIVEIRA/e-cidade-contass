<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarAOB extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "AOB";
    $this->abreArquivo();
    
    $sSql = "select * from aob102021 where si141_mes = " . $this->iMes;
    $rsAOB10 = db_query($sSql);

    $sSql2 = "select * from aob112021 where si142_mes = " . $this->iMes;
    $rsAOB11 = db_query($sSql2);


    if (pg_num_rows($rsAOB10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10, 11
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsAOB10); $iCont++) {

        $aAOB10 = pg_fetch_array($rsAOB10, $iCont);

        $aCSVAOB10['si141_tiporegistro']            = $this->padZeroLeft($aAOB10['si141_tiporegistro'], 2);
        $aCSVAOB10['si141_codreduzido']             = substr($aAOB10['si141_nroop'], 0, 15);
        $aCSVAOB10['si141_codorgao']                = $this->padZeroLeft($aAOB10['si141_codunidadesubresp'], 2);
        $aCSVAOB10['si141_codunidadesub']           = $this->padZeroLeft($aAOB10['si141_codunidadesub'], 5);
        $aCSVAOB10['si141_nroLancamento']           = substr($aAOB10['si141_nroLancamento'], 0, 22);
        $aCSVAOB10['si141_dtlancamento']            = $this->sicomDate($aAOB10['si141_dtlancamento']);
        $aCSVAOB10['si141_tipolancamento']          = $this->padZeroLeft($aAOB10['si141_tipolancamento'], 1);
        $aCSVAOB10['si141_nroanulacaolancamento']   = substr($aAOB10['si141_nroanulacaolancamento'], 0, 22);
        $aCSVAOB10['si141_dtanulacaolancamento']    = $this->sicomDate($aAOB10['si141_dtanulacaolancamento']);
        $aCSVAOB10['si141_nroempenho']              = substr($aAOB10['si141_nroempenho'], 0, 22);
        $aCSVAOB10['si141_dtempenho']               = $this->sicomDate($aAOB10['si141_dtempenho']);
        $aCSVAOB10['si141_nroliquidacao']           = substr($aAOB10['si141_nroliquidacao'], 0, 22);
        $aCSVAOB10['si141_dtliquidacao']            = $this->sicomDate($aAOB10['si141_dtliquidacao']);
        $aCSVAOB10['si141_valoranulacaolancamento'] = $this->sicomNumberReal($aAOB10['si141_valoranulacaolancamento'], 2);
        
        $this->sLinha = $aCSVAOB10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsAOB11); $iCont2++) {

          $aAOB11 = pg_fetch_array($rsAOB11, $iCont2);
          
          if ($aAOB10['si141_sequencial'] == $aAOB11['si142_reg10']) {

            $aCSVAOB11['si142_tiporegistro']        = $this->padZeroLeft($aAOB11['si142_tiporegistro'], 2);
            $aCSVAOB11['si142_codreduzido']         = substr($aAOB11['si142_codreduzido'], 0, 15);
            $aCSVAOB11['si142_codfontrecursos']     = $this->padZeroLeft($aAOB11['si142_codfontrecursos'], 3);
            $aCSVAOB11['si142_valoranulacaofonte']  = $this->sicomNumberReal($aAOB11['si142_valoranulacaofonte'], 2);

            $this->sLinha = $aCSVAOB11;
            $this->adicionaLinha();
            
          }

        }

      }

      $this->fechaArquivo();

    }

  }

}
