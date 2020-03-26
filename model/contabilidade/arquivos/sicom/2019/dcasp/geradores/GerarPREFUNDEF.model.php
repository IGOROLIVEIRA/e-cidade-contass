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

  public function gerarDados($sTipoGeracao)
  {
    $this->sArquivo = "PREFUNDEF";
    $this->abreArquivo();

      if ($sTipoGeracao != 'CONSOLIDADO') {
          $aCSV['tiporegistro'] = '99';
      }else{
          $aCSV['tiporegistro']              = '10';
          $aCSV['recebfundef']               = '2';
          $aCSV['vlprecatoriofundef']        = '';
          $aCSV['banco']                     = '';
          $aCSV['agencia']                   = '';
          $aCSV['digitoverificadoragencia']  = '';
          $aCSV['contabancaria']             = '';
          $aCSV['digitoverificadorcontabancaria']  = '';
          $aCSV['rendaplicacao']  = '';
          $aCSV['vlrendimentoaplic']  = '';
          $aCSV['empfundef']  = '';
      }
    $this->sLinha = $aCSV;
    $this->adicionaLinha();

    $this->fechaArquivo();
  }

}
