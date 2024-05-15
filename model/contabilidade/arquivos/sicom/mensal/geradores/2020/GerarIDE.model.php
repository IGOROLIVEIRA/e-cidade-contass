<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarIDE extends GerarAM
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

    $sSql = "select * from ide2020 where si11_mes = {$this->iMes} and si11_instit = " . db_getsession("DB_instit");
    $rsIDE = db_query($sSql);

    if (pg_num_rows($rsIDE) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    }
    else {

      for ($iCont = 0; $iCont < pg_num_rows($rsIDE); $iCont++) {

        $aIDE = pg_fetch_array($rsIDE, $iCont, PGSQL_ASSOC);

        unset($aIDE['si11_sequencial']);
        unset($aIDE['si11_mes']);
        unset($aIDE['si11_instit']);

        $aIDE['si11_codmunicipio']        = $this->padLeftZero($aIDE['si11_codmunicipio'], 5);
        $aIDE['si11_cnpjmunicipio']       = $this->padLeftZero($aIDE['si11_cnpjmunicipio'], 14);
        $aIDE['si11_codorgao']            = $this->padLeftZero($aIDE['si11_codorgao'], 2);
        $aIDE['si11_tipoorgao']           = $this->padLeftZero($aIDE['si11_tipoorgao'], 2);
        $aIDE['si11_exercicioreferencia'] = $this->padLeftZero($aIDE['si11_exercicioreferencia'], 4);
        $aIDE['si11_mesreferencia']       = $this->padLeftZero($aIDE['si11_mesreferencia'], 2);
        $aIDE['si11_datageracao']         = $this->sicomDate($aIDE['si11_datageracao']);
        $aIDE['si11_codcontroleremessa']  = substr($aIDE['si11_codcontroleremessa'], 0, 20);

        $this->sLinha = $aIDE;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
