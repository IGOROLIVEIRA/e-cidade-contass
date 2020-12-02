<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - IDE
 * @author gabriel
 * @package Contabilidade
 */
class GerarIDE extends GerarAM
{

  public $iAnousu;
  public $iCodInstit;

  public function gerarDados()
  {
    $this->sArquivo = "IDE";
    $this->abreArquivo();

    $sSql = "select * from idedcasp$PROXIMO_ANO where si200_anousu = {$this->iAnousu} and si200_instit = {$this->iCodInstit}";
    $rsIDE = db_query($sSql);

    if (pg_num_rows($rsIDE) == 0) {

      $aCSV['tiporegistro'] = '99';
      $this->sLinha = $aCSV;
      $this->adicionaLinha();

    }
    else {

      for ($iCont = 0; $iCont < pg_num_rows($rsIDE); $iCont++) {

        $aIDE = pg_fetch_array($rsIDE, $iCont, PGSQL_ASSOC);

        unset($aIDE['si200_sequencial']);
        unset($aIDE['si200_anousu']);
        unset($aIDE['si200_instit']);

        $aIDE['si200_codmunicipio']         = $this->padLeftZero($aIDE['si200_codmunicipio'], 5);
        $aIDE['si200_cnpjorgao']            = $this->padLeftZero($aIDE['si200_cnpjorgao'], 14);
        $aIDE['si200_codorgao']             = $this->padLeftZero($aIDE['si200_codorgao'], 2);
        $aIDE['si200_tipoorgao']            = $this->padLeftZero($aIDE['si200_tipoorgao'], 2);
        $aIDE['si200_tipodemcontabil']      = $this->padLeftZero($aIDE['si200_tipodemcontabil'], 1);
        $aIDE['si200_exercicioreferencia']  = $this->padLeftZero($aIDE['si200_exercicioreferencia'], 4);
        $aIDE['si200_datageracao']          = $this->sicomDate($aIDE['si200_datageracao']);
        $sDataGeracao = trim($aIDE['si200_datageracao']);
        $aIDE['si200_codcontroleremessa']   = empty($sDataGeracao) ? ' ' : substr($aIDE['si200_datageracao'], 0, 20);

        $this->sLinha = $aIDE;
        $this->adicionaLinha();

      }

      $this->fechaArquivo();

    }

  }

}
