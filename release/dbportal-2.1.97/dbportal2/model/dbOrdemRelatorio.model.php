<?php

require_once 'interfaces/GeradorRelatorio.interface.php';

final class dbOrdemRelatorio implements iGeradorRelatorio {
	
  public $iId      = null;
  public $sNome    = "";
  public $sAscDesc = "";
  public $sAlias   = "";
  
  
  /**
   * Método construtor da classe
   *
   * @param integer $iId
   * @param string  $sNome
   * @param string  $sAscDesc
   * 
   */
  
  public function __construct($iId="",$sNome="",$sAscDesc="",$sAlias=""){
	$this->setId($iId);  	
  	$this->setNome($sNome);
	$this->setAscDesc($sAscDesc);
	$this->setAlias($sAlias);
  }
  
  /**
   * Retorna ID do campo 
   *
   * @return integer
   */
  public function getId() {
    return $this->iId;
  }
  
  /**
   * Retorna o nome do campo
   *
   * @return string
   */
  public function getNome(){
  	return $this->sNome;
  }
  
  /**
   * Retorna ascdesc do Campo
   *
   * @return string
   */
  public function getAscDesc() {
    return $this->sAscDesc;
  }
  
  public function getAlias(){
  	return $this->sAlias;
  }  
       
  /**
   * @param integer $iId
   */
  public function setId($iId) {
    $this->iId = $iId;
  }
  
  /**
   * @param string $sNome
   */
  public function setNome($sNome) {
    $this->sNome = $sNome;
  }  
  
  /**
   * @param string $sAscDesc
   */
  public function setAscDesc($sAscDesc) {
    $this->sAscDesc = $sAscDesc;
  }

  /**
   * @param string $sAlias
   */
  public function setAlias($sAlias) {
    $this->sAlias = $sAlias;
  }
  

  
  /**
   * Retorna estrutura XML das propriedades da classe
   *
   * @return unknown
   */
  
  public function toXml( XMLWriter $oXmlWriter) {
  	
  	$oXmlWriter->startElement('Ordem');

  	$oXmlWriter->writeAttribute('id'       ,utf8_encode($this->iId));
  	$oXmlWriter->writeAttribute('nome'     ,utf8_encode($this->sNome));
  	$oXmlWriter->writeAttribute('ascdesc'  ,utf8_encode($this->sAscDesc));
  	$oXmlWriter->writeAttribute('alias'    ,utf8_encode($this->sAlias));	
  	$oXmlWriter->endElement();  	
	
  	return true;
  	
  }
  
}


?>