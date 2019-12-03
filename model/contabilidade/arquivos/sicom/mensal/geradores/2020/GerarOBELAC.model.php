<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");


/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarOBELAC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "OBELAC";
    $this->abreArquivo();
    
    $sSql = "select * from obelac102020 where si139_mes = " . $this->iMes;
    $rsOBELAC10 = db_query($sSql);

    $sSql2 = "select * from obelac112020 where si140_mes = " . $this->iMes;
    $rsOBELAC11 = db_query($sSql2);


    if (pg_num_rows($rsOBELAC10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10, 11
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsOBELAC10); $iCont++) {

        $aOBELAC10 = pg_fetch_array($rsOBELAC10, $iCont);

        $aCSVOBELAC10['si139_tiporegistro']     = $this->padLeftZero($aOBELAC10['si139_tiporegistro'], 2);
        $aCSVOBELAC10['si139_codreduzido']      = substr($aOBELAC10['si139_nroop'], 0, 15);
        $aCSVOBELAC10['si139_codorgao']         = $this->padLeftZero($aOBELAC10['si139_codunidadesubresp'], 2);
        $aCSVOBELAC10['si139_codunidadesub']    = $this->padLeftZero($aOBELAC10['si139_codunidadesub'], 5);
        $aCSVOBELAC10['si139_nroLancamento']    = substr($aOBELAC10['si139_nroLancamento'], 0, 22);
        $aCSVOBELAC10['si139_dtlancamento']     = $this->sicomDate($aOBELAC10['si139_dtlancamento']);
        $aCSVOBELAC10['si139_tipolancamento']   = $this->padLeftZero($aOBELAC10['si139_tipolancamento'], 1);
        $aCSVOBELAC10['si139_nroempenho']       = substr($aOBELAC10['si139_nroempenho'], 0, 22);
        $aCSVOBELAC10['si139_dtempenho']        = $this->sicomDate($aOBELAC10['si139_dtempenho']);
        $aCSVOBELAC10['si139_nroliquidacao']    = substr($aOBELAC10['si139_nroliquidacao'], 0, 22);
        $aCSVOBELAC10['si139_dtliquidacao']     = $this->sicomDate($aOBELAC10['si139_dtliquidacao']);
        $aCSVOBELAC10['si139_esplancamento']    = substr($aOBELAC10['si139_esplancamento'], 0, 200);
        $aCSVOBELAC10['si139_valorlancamento']  = $this->sicomNumberReal($aOBELAC10['si139_valorlancamento'], 2);
        
        $this->sLinha = $aCSVOBELAC10;
        $this->adicionaLinha();

        for ($iCont2 = 0; $iCont2 < pg_num_rows($rsOBELAC11); $iCont2++) {

          $aOBELAC11 = pg_fetch_array($rsOBELAC11, $iCont2);
          
          if ($aOBELAC10['si139_sequencial'] == $aOBELAC11['si140_reg10']) {

            $aCSVOBELAC11['si140_tiporegistro']     = $this->padLeftZero($aOBELAC11['si140_tiporegistro'], 2);
            $aCSVOBELAC11['si140_codreduzido']      = substr($aOBELAC11['si140_codreduzido'], 0, 15);
            $aCSVOBELAC11['si140_codfontrecursos']  = $this->padLeftZero($aOBELAC11['si140_codfontrecursos'], 3);
            $aCSVOBELAC11['si136_valorfonte']       = $this->sicomNumberReal($aOBELAC11['si136_valorfonte'], 2);

            $this->sLinha = $aCSVOBELAC11;
            $this->adicionaLinha();
          }
        }
      }

      $this->fechaArquivo();
    }
  }
}
