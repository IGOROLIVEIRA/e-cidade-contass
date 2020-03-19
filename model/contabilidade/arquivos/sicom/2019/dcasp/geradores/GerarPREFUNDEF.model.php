<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom DCASP - PREFUNDEF
 * @author gabriel
 * @package Contabilidade
 */
class GerarPREFUNDEF extends GerarAM
{

  public $iAnousu;
  public $iCodInstit;

  public function gerarDados()
  {
    $this->sArquivo = "PREFUNDEF";
    $this->abreArquivo();

    $aCSV['tiporegistro'] = '99';
    $this->sLinha = $aCSV;
    $this->adicionaLinha();

    $this->fechaArquivo();
  }

}
