<?php

abstract class ArquivoSiprevEscritor {

  protected $sFile;
  
  protected $sOutPut;
  
  protected $aListaArquivos = array();
  
  /**
   * 
   */
  function __construct() {

  }
  
  /**
   * Retorna o Caminho do arquivo criado
   *
   */
  public function criarArquivo(ArquivoSiprevBase $oArquivo) {
    
    
  } 
  
  function adicionarArquivo($sCaminho, $sNomeArquivo) {
    
    $oArquivo               = new stdClass();
    $oArquivo->nome         = $sNomeArquivo;
    $oArquivo->caminho      = $sCaminho;
    $this->aListaArquivos[] = $oArquivo; 
  }
  
  public function getListaArquivos() {
    return $this->aListaArquivos;
  }
  
  public function zip ($sArquivo) {
    
    $aListaArquivos = '';
    foreach ($this->aListaArquivos as $oArquivo){
      $aListaArquivos .= " ".$oArquivo->caminho;
    }
    system("rm -f tmp/{$sArquivo}.zip");
    system("bin/zip -q tmp/{$sArquivo}.zip $aListaArquivos");
    return "{$sArquivo}.zip";
  }
}

?>