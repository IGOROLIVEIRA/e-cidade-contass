<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarMETAREAL extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "METAREAL";
    $this->abreArquivo();

    $sSql = "select * from metareal102020 where si171_mes = " . $this->iMes;
    $rsMETAREAL10 = db_query($sSql);


    if (pg_num_rows($rsMETAREAL10) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    } else {

      /**
       *
       * Registros 10
       */
      for ($iCont = 0; $iCont < pg_num_rows($rsMETAREAL10); $iCont++) {

        $aMETAREAL10 = pg_fetch_array($rsMETAREAL10, $iCont);

        $aCSVMETAREAL10['si171_tiporegistro']   = $this->padLeftZero($aMETAREAL10['si171_tiporegistro'], 2);
        $aCSVMETAREAL10['si171_codorgao']       = $this->padLeftZero($aMETAREAL10['si171_codorgao'], 2);
        $aCSVMETAREAL10['si171_codunidadesub']  = $this->padLeftZero($aMETAREAL10['si171_codunidadesub'], 5);
        $aCSVMETAREAL10['si171_codfuncao']      = $this->padLeftZero($aMETAREAL10['si171_codfuncao'], 2);
        $aCSVMETAREAL10['si171_codsubfuncao']   = $this->padLeftZero($aMETAREAL10['si171_codsubfuncao'], 3);
        $aCSVMETAREAL10['si171_codprograma']    = $this->padLeftZero($aMETAREAL10['si171_codprograma'], 4);
        $aCSVMETAREAL10['si171_idacao']         = $this->padLeftZero($aMETAREAL10['si171_idacao'], 4);
        $aCSVMETAREAL10['si171_idsubacao']      = ($aMETAREAL10['si171_idsubacao'] == 0)? ' ' : $this->padLeftZero($aMETAREAL10['si171_idsubacao'], 4);
        $aCSVMETAREAL10['si171_metarealizada']  = $this->sicomNumberReal($aMETAREAL10['si171_metarealizada'], 2);
        $aCSVMETAREAL10['si171_justificativa']  = substr($aMETAREAL10['si171_justificativa'], 0, 1000);

        $this->sLinha = $aCSVMETAREAL10;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
