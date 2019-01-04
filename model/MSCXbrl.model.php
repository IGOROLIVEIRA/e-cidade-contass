<?php

require_once("model/MSC.model.php");

class MSCXbrl extends MSC {
  
  public function gerarArquivoXBRL($aXbrlRegistros) {//echo "<pre>";ini_set("display_errors",true);
    
    $xbrl = new XMLWriter;

    # Cria memoria para armazenar a saida
    $xbrl->openMemory();
    
    $xbrl->startDocument( '1.0' , 'iso-8859-1' );
    
    $xbrl->startElement("xbrli:xbrl");
    $xbrl->writeAttribute('xmlns', 'http://www.xbrl.org/2003/instance'); $xbrl->writeAttribute('xmlns:gl-bus', 'http://www.xbrl.org/int/gl/bus/2015-03-25'); $xbrl->writeAttribute('xmlns:gl-cor', 'http://www.xbrl.org/int/gl/cor/2015-03-25'); $xbrl->writeAttribute('xmlns:iso4217', 'http://www.xbrl.org/2003/iso4217'); $xbrl->writeAttribute('xmlns:link', 'http://www.xbrl.org/2003/linkbase'); $xbrl->writeAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink'); $xbrl->writeAttribute('xmlns:xbrli', 'http://www.w3.org/2001/XMLSchema-instance'); 
    
    $xbrl->startElement("link:schemaRef");
    $xbrl->writeAttribute("xlink:href", "SICONFI/cor/ext/gl/plt/case-c-b-m-u-t-s/gl-plt-all-2015-03-25.xsd");
    $xbrl->endElement();//link:schemaRef
    
    $xbrl->startElement("xbrli:context");
    $xbrl->writeAttribute("id", "C1");
    
    $xbrl->startElement("xbrli:entity");
    $xbrl->writeElement("xbrli:indetifier", $this->getIndetifier());//4214805EX//
    $xbrl->writeAttribute("scheme", "http://siconfi.tesouro.gov.br");
    $xbrl->endElement();//xbrli:entity
    
    $xbrl->startElement("xbrli:period");
    $xbrl->writeElement("xbrli:instant", $this->getInstant());//2015-12-31
    $xbrl->endElement();//xbrli:period
    $xbrl->endElement();//xbrli:context
    
    $xbrl->startElement("xbrli:unit");
    $xbrl->writeAttribute("id", "BRL");
    $xbrl->writeElement("xbrli:measure","iso4217:BRL");
    $xbrl->endElement();//xbrli:unit
    
    $xbrl->startElement("xbrli:unit");
    $xbrl->writeAttribute("id", "u");
    $xbrl->writeElement("xbrli:measure","xbrli:pure");
    $xbrl->endElement();//xbrli:unit

        $xbrl->startElement("gl-cor:accountingEntries");
        $xbrl->startElement("gl-cor:documentInfo");
          $xbrl->writeElement("gl-cor:entriesType", $this->getEntriesType());//trialbalance
          $xbrl->writeAttribute("contextRef", "C1");
        $xbrl->endElement();//gl-cor:documentInfo
        
        $xbrl->startElement("gl-cor:entityInformation");
          $xbrl->startElement("gl-bus:reportingCalendar");
          $xbrl->startElement("gl-bus:reportingCalendarPeriod");
              $xbrl->writeElement("gl-bus:periodIdentifier", $this->getPeriodIdentifier());//2015-01
              $xbrl->writeElement("gl-bus:periodDescription", $this->getPeriodDescription());//2015-01-01
              $xbrl->writeElement("gl-bus:periodStart", $this->getPeriodStart());//2015-01-01
              $xbrl->writeElement("gl-bus:periodEnd", $this->getPeriodEnd());//2015-01-31
          $xbrl->endElement();//gl-bus:reportingCalendarPeriod
          $xbrl->endElement();//gl-bus:reportingCalendar
        $xbrl->endElement();//gl-cor:entityInformation

        $xbrl->startElement("gl-cor:entryHeader");
          $xbrl->startElement("gl-cor:entryDetail");
            $xbrl->writeElement("gl-cor:lineNumberCounter", $this->getLineNumberCounter());
            $xbrl->writeAttribute("contextRef", "C1");
            $xbrl->writeAttribute("decimals", "0");
            $xbrl->writeAttribute("unitRef", "u");

          foreach($aXbrlRegistros as $aRegistros) {     
            foreach ($aRegistros->registros as $account) {
              $this->setRegistrosContas($account);
              $this->addLinhas($xbrl);//Registros
            }
          }
          $xbrl->endElement();//gl-cor:entryDetail
        $xbrl->endElement();//gl-cor:entryHeader
        
        $xbrl->endElement();//gl-cor:accountingEntries
        
        $xbrl->endElement();//xbrli:xbrl
    $xbrl->endDocument();

    $this->setCaminhoArq($this->getNomeArq());
    $file = fopen("{$this->getNomeArq()}.xml",'w');
    fwrite($file,$xbrl->outputMemory(true));
    fclose($file);
    
  }
  
  public function addLinhas($xbrl) {
  
    $xbrl->startElement("gl-cor:account");
          
      $xbrl->writeElement("gl-cor:accountMainID", $this->getConta());
        $xbrl->writeAttribute("contextRef", "C1");        
            
        for ($ic = 1; $ic <= 6; $ic++) {         
            $IC = "iIC".$ic;
            $getIC = "getIC".$ic;
            $getTipoIC = "getTipoIC".$ic;
          if (!empty($this->{$IC})) {
            $xbrl->startElement("gl-cor:accountSub");
              $xbrl->writeElement("gl-cor:accountSubID", $this->{$getIC}());
              $xbrl->writeAttribute("contextRef", "C1");
              $xbrl->writeElement("gl-cor:accountType", $this->{$getTipoIC}());
              $xbrl->writeAttribute("contextRef", "C1");
            $xbrl->endElement();//gl-cor:accountSub
          }
        }
     
        $xbrl->endElement();//gl-cor:account
  
      $xbrl->writeElement("gl-cor:amount", $this->getValor());
      $xbrl->writeAttribute("contextRef", "C1");
      $xbrl->writeAttribute("decimals", "2");
      $xbrl->writeAttribute("unitRef", "BRL"); 

      $xbrl->writeElement("gl-cor:debitCreditCode", $this->getNaturezaValor());
      $xbrl->writeAttribute("contextRef", "C1");

      $xbrl->startElement("gl-cor:xbrlInfo");
        $xbrl->writeElement("gl-cor:xbrlInclude", $this->getTipoValor());
        $xbrl->writeAttribute("contextRef", "C1");
      $xbrl->endElement();//gl-cor:xbrlInfo
  
  }

  public function setRegistrosContas($oRegistro) {

    $this->setConta($oRegistro->conta);

    for ($ic = 1; $ic <= 6; $ic++) {         
      $IC = "IC".$ic;
      $TipoIC = "TipoIC".$ic;
      $setIC = "setIC".$ic;
      $setTipoIC = "setTipoIC".$ic;
      if (isset($oRegistro->{$IC})) {
        $this->{$setIC}($oRegistro->{$IC});
        $this->{$setTipoIC}($oRegistro->{$TipoIC});
      }
    }
    
    $this->setValor($oRegistro->valor);
    $this->setTipoValor($oRegistro->tipoValor);
    $this->setNaturezaValor($oRegistro->nat_vlr); 

  }  

}

