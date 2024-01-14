<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

/**
 * Dados Complementares Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoConsideracoes extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 100218;
  
  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CONSID';
  
  protected $iCodigoPespectiva;
  
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
    
    $aElementos = array("tiporegistro");
    
    return $aElementos;
  }
  
  /**
   * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {
    
    $oDados = new stdClass();
    
    $oDados->tiporegistro = 99;
    
    $this->aDados[] = $oDados;
    
  }
  
  public function setCodigoPespectiva($iCodigoPespectiva)
  {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }
  
  public function getCodigoPespectiva()
  {
    return $this->iCodigoPespectiva;
  }
  
}
