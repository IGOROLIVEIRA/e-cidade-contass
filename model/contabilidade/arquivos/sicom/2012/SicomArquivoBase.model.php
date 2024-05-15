<?php

abstract class SicomArquivoBase {
  
  /**
   *nome do arquivo que sera gerado
   * @var String
   */
  protected $sNomeAquivo;
  
  /**
   *extensao do arquivo a ser gerado
   * @var String
   */
  protected $sOutPut = 'csv';
  
  /**
   *dados a serem escritos no arquivo
   * @var ArrayIterator::
   */
  protected $aDados;
  
  /**
   *data inicial da emissao dos dados 
   * @var String
   */
  protected $sDataInicial;
  
  /**
   *data final da emissao dos dados 
   * @var String
   */
  protected $sDataFinal;
  
  protected  $rsLogger;
  
  /**
     *retorna array de dados
     */
  public function  getDados() {
    
    return $this->aDados;
  }
  
/**
   * 
   * @see iPadArquivoBase::setDataFinal()
   */
  public function setDataFinal($sDataFinal) {
    
    if (strpos($sDataFinal, "/", 0)) {
      $sDataFinal = implode("-", array_reverse(explode("/", $sDataFinal)));
    }
    $this->sDataFinal = $sDataFinal;
  }
  
  /**
   * 
   * @see iPadArquivoBase::setDataInicial()
   */
  public function setDataInicial($sDataInicial) {
   
  if (strpos($sDataInicial, "/",0)) {
      $sDataInicial = implode("-", array_reverse(explode("/", $sDataInicial)));
    }
    $this->sDataInicial = $sDataInicial;
  }
  
  /**
   * Retorna o nome do arquivo
   *
   * @return string
   */
  function getNomeArquivo() {

    return $this->sNomeArquivo;
  }
  
  /**
   *retorna o Tipo de saida o arquivo 
   */
  function getOutPut() {
    return  $this->sOutPut;
  }
  
public function addLog($sLog) {
    fputs($this->rsLogger, $sLog);
  }
}