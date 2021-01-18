<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Editais
 * @author Victor Felipe
 * @package Contabilidade
 */
class GerarIDEEDITAL extends GerarAM
{

  /**
   *
   * Mes de referência
   * @var Integer
   */
  public $iMes;

  public function gerarDados()
  {

    $this->sArquivo = "IDE";
    $this->abreArquivo();

    $sSql = "select * from ideedital2021 where si186_mes = {$this->iMes} and si186_instit = " . db_getsession("DB_instit");
    $rsIDEEDITAL = db_query($sSql);

    if (pg_num_rows($rsIDEEDITAL) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    }
    else {

      for ($iCont = 0; $iCont < pg_num_rows($rsIDEEDITAL); $iCont++) {

        $aIDEEDITAL = pg_fetch_array($rsIDEEDITAL, $iCont, PGSQL_ASSOC);

        unset($aIDEEDITAL['si186_sequencial']);
        unset($aIDEEDITAL['si186_mes']);
        unset($aIDEEDITAL['si186_instit']);

        $aIDEEDITAL['si186_codidentificador']    = $this->padLeftZero(intval($aIDEEDITAL['si186_codidentificador']), 5);
        $aIDEEDITAL['si186_cnpj']                = $this->padLeftZero($aIDEEDITAL['si186_cnpj'], 14);
        $aIDEEDITAL['si186_codorgao']            = $this->padLeftZero($aIDEEDITAL['si186_codorgao'], 3);
        $aIDEEDITAL['si186_tipoorgao']           = $this->padLeftZero($aIDEEDITAL['si186_tipoorgao'], 2);
        $aIDEEDITAL['si186_exercicioreferencia'] = $this->padLeftZero($aIDEEDITAL['si186_exercicioreferencia'], 4);
        $aIDEEDITAL['si186_mesreferencia']       = $this->padLeftZero($aIDEEDITAL['si186_mesreferencia'], 2);
        $aIDEEDITAL['si186_datageracao']         = $this->sicomDate($aIDEEDITAL['si186_datageracao']);
        $aIDEEDITAL['si186_codcontroleremessa']  = substr($aIDEEDITAL['si186_codcontroleremessa'], 0, 20);
        $aIDEEDITAL['si186_codseqremessames']    = substr($aIDEEDITAL['si186_codseqremessames'], 0, 20);

        $this->sLinha = $aIDEEDITAL;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
