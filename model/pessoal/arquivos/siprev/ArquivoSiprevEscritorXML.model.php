<?php
require_once ("ArquivoSiprevEscritor.model.php");
class ArquivoSiprevEscritorXML  extends ArquivoSiprevEscritor {
  
  /**
   * 
   */
  function __construct() {

  }
  
  /**
   * Transforma os dados passados para XML 
   * @param $oArquivo
   * @return caminho do Arquivo 
   */
  public function criarArquivo(ArquivoSiprevBase $oArquivo) {
    
  	  //echo "<pre>";
      //print_r($oArquivo);
      //echo "</pre>";
      //echo $oArquivo->getCnpj();
      //die();
  	
    $oXmlWriter = new XMLWriter();
    $oXmlWriter->openMemory();
    $oXmlWriter->setIndent(true);
    $oXmlWriter->startDocument('1.0','ISO-8859-1',"yes");
    //$oXmlWriter->startDocument('1.0','UTF-8');
    $oXmlWriter->startElementNs('ns2', 'siprev',"http://www.dataprev.gov.br/siprev");
    $oXmlWriter->endDtd();
    
    //$oXmlWriter->startElement($oArquivo->getNomeArquivo());
      $oXmlWriter->startElement('ente');
      $oXmlWriter->writeAttribute("siafi",$oArquivo->getSiafi());
      $oXmlWriter->writeAttribute("cnpj",$oArquivo->getCnpj());
      $oXmlWriter->endElement();
      
    foreach ($oArquivo->getDados() as $oLinha) {
    	$oXmlWriter->startElement($oArquivo->getNomeArquivo());
    	$oXmlWriter->writeAttribute("operacao", "I");
    	
      foreach ($oArquivo->getElementos() as $aElemento) {
        $this->escreveElemento($oLinha, $oXmlWriter, $aElemento);
      }
     $oXmlWriter->endElement();
      
    }
    
   // $oXmlWriter->endElement();
    $oXmlWriter->endElement();
    $sNomeArquivo = "tmp/{$oArquivo->getNomeArquivo()}.xml";
    $rsArquivoXML = fopen($sNomeArquivo, "w");
    fputs($rsArquivoXML, $oXmlWriter->outputMemory());
    fclose($rsArquivoXML);
    unset($oXmlWriter);
    return $sNomeArquivo;
  }
  
  public function escreveElemento($oLinha, $oXmlWriter, $oElemento, $sNome = '') {
   
    if (empty($oLinha->$oElemento["nome"])) {
      return false;
    }

    $oXmlWriter->startElement($oElemento["nome"]);
    foreach ($oElemento["propriedades"] as $sPropriedade) {
    	
      if (!is_array($sPropriedade)) {        
        $sValor  = '';
        if (isset($oLinha->$oElemento["nome"]->$sPropriedade)) {
          $sValor = $oLinha->$oElemento["nome"]->$sPropriedade;
        }
        $oXmlWriter->writeAttribute($sPropriedade, utf8_encode($sValor));
      } else {
        $this->escreveElemento($oLinha->$oElemento["nome"], $oXmlWriter, $sPropriedade);
      }
      
      
    }
    $oXmlWriter->endElement();    
  }
}

?>
