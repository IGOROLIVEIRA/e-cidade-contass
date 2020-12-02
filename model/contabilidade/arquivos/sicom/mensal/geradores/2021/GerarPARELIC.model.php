<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarPARELIC extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "PARELIC";
    $this->abreArquivo();
    
    $sSql = "select * from parelic102020 where si66_mes = " . $this->iMes . " and si66_instit=" . db_getsession("DB_instit");
    $rsPARELIC10 = db_query($sSql);

    if (pg_num_rows($rsPARELIC10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();
      
    } else {

      for ($iCont = 0; $iCont < pg_num_rows($rsPARELIC10); $iCont++) {

        $aPARELIC10 = pg_fetch_array($rsPARELIC10, $iCont);

        $aCSVPARELIC10['si66_tiporegistro']           = $this->padLeftZero($aPARELIC10['si66_tiporegistro'], 2);
        $aCSVPARELIC10['si66_codorgao']               = $this->padLeftZero($aPARELIC10['si66_codorgao'], 2);
        $aCSVPARELIC10['si66_codunidadesub']          = $this->padLeftZero($aPARELIC10['si66_codunidadesub'], 5);
        $aCSVPARELIC10['si66_exerciciolicitacao']     = $this->padLeftZero($aPARELIC10['si66_exerciciolicitacao'], 4);
        $aCSVPARELIC10['si66_nroprocessolicitatorio'] = substr($aPARELIC10['si66_nroprocessolicitatorio'], 0, 12);
        $aCSVPARELIC10['si66_dataparecer']            = $this->sicomDate($aPARELIC10['si66_dataparecer']);
        $aCSVPARELIC10['si66_tipoparecer']            = $this->padLeftZero($aPARELIC10['si66_tipoparecer'], 1);
        $aCSVPARELIC10['si66_nrocpf']                 = $this->padLeftZero($aPARELIC10['si66_nrocpf'], 11);

        $this->sLinha = $aCSVPARELIC10;
        $this->adicionaLinha();

      }

    }
    $this->fechaArquivo();
  }

} 
