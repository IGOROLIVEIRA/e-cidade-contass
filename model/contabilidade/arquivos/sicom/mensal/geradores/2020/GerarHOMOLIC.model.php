<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarHOMOLIC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "HOMOLIC";
    $this->abreArquivo();
    
    $sSql = "select * from homolic102020 where si63_mes = " . $this->iMes . " and si63_instit=" . db_getsession("DB_instit");
    $rsHOMOLIC10 = db_query($sSql);

    $sSql2 = "select * from homolic202020 where si64_mes = " . $this->iMes . " and si64_instit=" . db_getsession("DB_instit");
    $rsHOMOLIC20 = db_query($sSql2);

    $sSql3 = "select * from homolic402020 where si65_mes = " . $this->iMes . " and si65_instit=" . db_getsession("DB_instit");
    $rsHOMOLIC40 = db_query($sSql3);

    if (pg_num_rows($rsHOMOLIC10) == 0 && pg_num_rows($rsHOMOLIC20) == 0 && pg_num_rows($rsHOMOLIC40) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsHOMOLIC10); $iCont++) {

        $aHOMOLIC10 = pg_fetch_array($rsHOMOLIC10, $iCont);

        $aCSVHOMOLIC10['si63_tiporegistro']           = $this->padLeftZero($aHOMOLIC10['si63_tiporegistro'], 2);
        $aCSVHOMOLIC10['si63_codorgao']               = $this->padLeftZero($aHOMOLIC10['si63_codorgao'], 2);
        $aCSVHOMOLIC10['si63_codunidadesub']          = $this->padLeftZero($aHOMOLIC10['si63_codunidadesub'], 5);
        $aCSVHOMOLIC10['si63_exerciciolicitacao']     = $this->padLeftZero($aHOMOLIC10['si63_exerciciolicitacao'], 4);
        $aCSVHOMOLIC10['si63_nroprocessolicitatorio'] = substr($aHOMOLIC10['si63_nroprocessolicitatorio'], 0, 12);
        $aCSVHOMOLIC10['si63_tipodocumento']          = $this->padLeftZero($aHOMOLIC10['si63_tipodocumento'], 1);
        $aCSVHOMOLIC10['si63_nrodocumento']           = substr($aHOMOLIC10['si63_nrodocumento'], 0, 14);
        $aCSVHOMOLIC10['si63_nrolote']                = $aHOMOLIC10['si63_nrolote'] == 0 ? ' ' : substr($aHOMOLIC10['si63_nrolote'], 0, 4);
        $aCSVHOMOLIC10['si63_coditem']                = substr($aHOMOLIC10['si63_coditem'], 0, 15);
        $aCSVHOMOLIC10['si63_quantidade']             = $this->sicomNumberReal($aHOMOLIC10['si63_quantidade'], 4);
        $aCSVHOMOLIC10['si63_vlunitariohomologado']   = $this->sicomNumberReal($aHOMOLIC10['si63_vlunitariohomologado'], 4);

        $this->sLinha = $aCSVHOMOLIC10;
        $this->adicionaLinha();

      }

      /**
       *
       * Registros 20
       */
      for ($iCont2 = 0; $iCont2 < pg_num_rows($rsHOMOLIC20); $iCont2++) {

        $aHOMOLIC20 = pg_fetch_array($rsHOMOLIC20, $iCont2);

        $aCSVHOMOLIC20['si64_tiporegistro']           = $this->padLeftZero($aHOMOLIC20['si64_tiporegistro'], 2);
        $aCSVHOMOLIC20['si64_codorgao']               = $this->padLeftZero($aHOMOLIC20['si64_codorgao'], 2);
        $aCSVHOMOLIC20['si64_codunidadesub']          = $this->padLeftZero($aHOMOLIC20['si64_codunidadesub'], 5);
        $aCSVHOMOLIC20['si64_exerciciolicitacao']     = $this->padLeftZero($aHOMOLIC20['si64_exerciciolicitacao'], 4);
        $aCSVHOMOLIC20['si64_nroprocessolicitatorio'] = substr($aHOMOLIC20['si64_nroprocessolicitatorio'], 0, 12);
        $aCSVHOMOLIC20['si64_tipodocumento']          = $this->padLeftZero($aHOMOLIC20['si64_tipodocumento'], 1);
        $aCSVHOMOLIC20['si64_nrodocumento']           = substr($aHOMOLIC20['si64_nrodocumento'], 0, 14);
        $aCSVHOMOLIC20['si64_nrolote']                = !$aHOMOLIC20['si64_nrolote'] ? '' : substr($aHOMOLIC20['si64_nrolote'], 0, 4);
        $aCSVHOMOLIC20['si64_coditem']                = substr($aHOMOLIC20['si64_coditem'], 0, 15);
        $aCSVHOMOLIC20['si64_percdesconto']           = $this->sicomNumberReal($aHOMOLIC20['si64_percdesconto'], 2);
        
        $this->sLinha = $aCSVHOMOLIC20;
        $this->adicionaLinha();

      }

      /**
       *
       * Registros 40
       */
      for ($iCont3 = 0; $iCont3 < pg_num_rows($rsHOMOLIC40); $iCont3++) {

        $aHOMOLIC40 = pg_fetch_array($rsHOMOLIC40, $iCont3);

        $aCSVHOMOLIC40['si65_tiporegistro']           = $this->padLeftZero($aHOMOLIC40['si65_tiporegistro'], 2);
        $aCSVHOMOLIC40['si65_codorgao']               = $this->padLeftZero($aHOMOLIC40['si65_codorgao'], 2);
        $aCSVHOMOLIC40['si65_codunidadesub']          = $this->padLeftZero($aHOMOLIC40['si65_codunidadesub'], 5);
        $aCSVHOMOLIC40['si65_exerciciolicitacao']     = $this->padLeftZero($aHOMOLIC40['si65_exerciciolicitacao'], 4);
        $aCSVHOMOLIC40['si65_nroprocessolicitatorio'] = substr($aHOMOLIC40['si65_nroprocessolicitatorio'], 0, 12);
        $aCSVHOMOLIC40['si65_dthomologacao']          = $this->sicomDate($aHOMOLIC40['si65_dthomologacao']);
        $aCSVHOMOLIC40['si65_dtadjudicacao']          = $this->sicomDate($aHOMOLIC40['si65_dtadjudicacao']);
        
        $this->sLinha = $aCSVHOMOLIC40;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }
}
