<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarSUPDEF.model.php");

/**
 * @author Marcelo
 * @package Contabilidade
 */
class SicomArquivoSuperavitFinanceiro extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'SUPDEF';
  
  /**
   *
   * Construtor da classe
   */
  public function __construct()
  {
    
  }
  
  /**
   * Retorna o codigo do layout
   *
   * @return Integer
   */
  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }
  
  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

  }
  
  /**
   * selecionar os dados
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    $oGerarSUPDEF = new GerarSUPDEF();
    $oGerarSUPDEF->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarSUPDEF->gerarDados();

  }

}
