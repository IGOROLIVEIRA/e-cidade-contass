<?php

require_once 'interfaces/GeradorRelatorio.interface.php';

final class dbColunaRelatorio implements iGeradorRelatorio {
	
  public $iId   			= "";
  public $sNome 			= "";
  public $sAlias 			= "";
  public $iLargura 		    = "";
  public $sAlinhamento  	= "";
  public $sAlinhamentoCab   = "";
  public $sMascara 			= "";
  public $sTotalizar 		= "";
  public $oxml      		= "";
  
  
  
  /**
   * Método construtor da classe
   *
   * @param string  $iId
   * @param string  $sNome
   * @param string  $sAlias
   * @param string  $iLargura
   * @param string  $sAlinhamento
   * @param string  $sAlinhamentoCab
   * @param string  $sMascara
   * 
   */
  
  public function __construct($iId="",$sNome="",$sAlias="",$iLargura="",$sAlinhamento="",$sAlinhamentoCab="",$sMascara="",$sTotalizar=""){
  	 	
	$this->setId($iId);  	
  	$this->setNome($sNome);
	$this->setAlias($sAlias);
	$this->setLargura($iLargura);
	$this->setAlinhamento($sAlinhamento);
	$this->setAlinhamentoCab($sAlinhamentoCab);
	$this->setMascara($sMascara);	
    $this->setTotalizar($sTotalizar);
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
   * Retorna largura do campo
   *
   * @return integer
   */
  public function getLargura() {
    return $this->iLargura;
  }
  
  /**
   * Retorna alias do Campo
   *
   * @return string
   */
  public function getAlias() {
    return $this->sAlias;
  }
  
  /**
   * Retorna alinhamento do campo
   *
   * @return string
   */
  public function getAlinhamento() {
    return $this->sAlinhamento;
  }
  
  /**
   * Retorna alinhamento do cabeçalho referente ao campo no relatório
   *
   * @return string
   */
  public function getAlinhamentoCab() {
    return $this->sAlinhamentoCab;
  }
  
  /**
   * Retorna a máscara do campo
   *
   * @return string
   */
  public function getMascara() {
    return $this->sMascara;
  }
  
  /**
   * Retorna a totalizador do campo
   *
   * @return string
   */
  public function getTotalizar() {
    return $this->sTotalizar;
  }  
  
    
  /**
   * @param integer $iId
   */
  public function setId($iId) {
    $this->iId = $iId;
  }
  
  /**
   * @param integer $iLargura
   */
  public function setLargura($iLargura) {
    $this->iLargura = $iLargura;
  }
  
  /**
   * @param string $sAlias
   */
  public function setAlias($sAlias) {
    $this->sAlias = $sAlias;
  }
  
  /**
   * @param string $sAlinhamento
   */
  public function setAlinhamento($sAlinhamento) {
    $this->sAlinhamento = $sAlinhamento;
  }
  
  /**
   * @param string $sAlinhamentoCab
   */
  public function setAlinhamentoCab($sAlinhamentoCab) {
    $this->sAlinhamentoCab = $sAlinhamentoCab;
  }
  
  /**
   * @param string $sMascara
   */
  public function setMascara($sMascara) {
    $this->sMascara = $sMascara;
  }
  
  /**
   * @param string $sNome
   */
  public function setNome($sNome) {
    $this->sNome = $sNome;
  }
  
  
  /**
   * @param string $sTotalizar
   */
  public function setTotalizar($sTotalizar) {
    $this->sTotalizar = $sTotalizar;
  }  
  
  
  /**
   * Retorna estrutura XML das propriedades da classe
   *
   * @return unknown
   */
  
  public function toXml( XMLWriter $oXmlWriter) {
  	
  	$oXmlWriter->startElement('Campo');

  	$oXmlWriter->writeAttribute('id'     		 ,utf8_encode($this->iId));
  	$oXmlWriter->writeAttribute('nome'   		 ,utf8_encode($this->sNome));
  	$oXmlWriter->writeAttribute('alias'  		 ,utf8_encode($this->sAlias));
  	$oXmlWriter->writeAttribute('largura'		 ,utf8_encode($this->iLargura));
  	$oXmlWriter->writeAttribute('alinhamento'	 ,utf8_encode($this->sAlinhamento));  	
  	$oXmlWriter->writeAttribute('alinhamentocab' ,utf8_encode($this->sAlinhamentoCab));
	$oXmlWriter->writeAttribute('mascara'		 ,utf8_encode($this->sMascara));
	$oXmlWriter->writeAttribute('totalizar'		 ,utf8_encode($this->sTotalizar));	
	
  	$oXmlWriter->endElement();  	
	
  	return true;
  	
  }
  
}


?>