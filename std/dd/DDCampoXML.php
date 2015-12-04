<?php
class DDCampoXML {
	
	private $oCampoXml    = null;
	public  $oSequenceXml = null;

	public function __construct(DOMNode $oDomNode){
		
    $this->oCampoXml = $oDomNode;    
    $aSequenceXML    = $this->oCampoXml->getElementsByTagName("sequence");
    
    foreach ( $aSequenceXML as $oSequence ) {
    	
      $this->oSequenceXml = new DDSequenceXML( $oSequence );
      break;
      
    }
    
	}
	
  public function __get($sName){    
    return $this->oCampoXml->getAttribute($sName);   
  }
  
  public function getSequence() {
    if (empty($this->oSequenceXml)) {
    	return false;        	
    }
    return $this->oSequenceXml;    
  }
  
  public function isPk() {  	
  	if ($this->ispk == 't') {
  		return  true;
  	}
  	return false;  	
  }
  
}
