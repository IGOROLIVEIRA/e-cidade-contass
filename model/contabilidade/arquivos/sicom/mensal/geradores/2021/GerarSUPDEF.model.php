<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class GerarSUPDEF extends GerarAM
{

  /**
   *
   * Mes de referÍncia
   * @var Integer
   */
  public $iMes;
  
  public function gerarDados()
  {

    $this->sArquivo = "SUPDEF";
    $this->abreArquivo();
    
    $sSql = "select * from supdef102021 where si141_mes = " . $this->iMes;
    $rsSUPDEF10 = db_query($sSql);

    $sSql2 = "select * from supdef112021 where si142_mes = " . $this->iMes;
    $rsSUPDEF11 = db_query($sSql2);

    $aCSV['tiporegistro'] = '99';
    $this->sLinha = $aCSV;
    $this->adicionaLinha();
  }
}
