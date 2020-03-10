<?php

require_once("model/contabilidade/arquivos/msc/".db_getsession("DB_anousu")."/MSC.model.php");

class MSCXbrl extends MSC {

  public function gerarArquivoXBRL($aXbrlRegistros) {

    $xbrl = new XMLWriter;

    $xbrl->openMemory();

    $xbrl->startDocument('1.0' , 'iso-8859-1');

      $xbrl->startElement("xbrli:xbrl");
        $xbrl->writeAttribute('xmlns:xbrli', 'http://www.xbrl.org/2003/instance');
        $xbrl->writeAttribute('xmlns:gl-bus', 'http://www.xbrl.org/int/gl/bus/2015-03-25');
        $xbrl->writeAttribute('xmlns:gl-cor', 'http://www.xbrl.org/int/gl/cor/2015-03-25');
        $xbrl->writeAttribute('xmlns:iso4217', 'http://www.xbrl.org/2003/iso4217');
        $xbrl->writeAttribute('xmlns:link', 'http://www.xbrl.org/2003/linkbase');
        $xbrl->writeAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');
        $xbrl->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');

        $xbrl->startElement('link:schemaRef');
          $xbrl->writeAttribute('xlink:href', 'SICONFI/cor/ext/gl/plt/case-c-b-m-u-t-s/gl-plt-all-2015-03-25.xsd');
        $xbrl->endElement();//link:schemaRef

        $xbrl->startElement('xbrli:context');
          $xbrl->writeAttribute('id', 'C1');

          $xbrl->startElement('xbrli:entity');
            $xbrl->startElement('xbrli:identifier');
            $xbrl->writeAttribute('scheme', 'http://siconfi.tesouro.gov.br');
            $xbrl->text($this->getIdentifier());
            $xbrl->endElement();//xbrli:identifier
          $xbrl->endElement();//xbrli:entity

          $xbrl->startElement('xbrli:period');
            $xbrl->writeElement('xbrli:instant', $this->getInstant());
          $xbrl->endElement();//xbrli:period
        $xbrl->endElement();//xbrli:context

        $xbrl->startElement('xbrli:unit');
          $xbrl->writeAttribute('id', 'BRL');
          $xbrl->writeElement('xbrli:measure','iso4217:BRL');
        $xbrl->endElement();//xbrli:unit

        $xbrl->startElement('xbrli:unit');
          $xbrl->writeAttribute('id', 'u');
          $xbrl->writeElement('xbrli:measure','xbrli:pure');
        $xbrl->endElement();//xbrli:unit

        $xbrl->startElement('gl-cor:accountingEntries');
          $xbrl->startElement('gl-cor:documentInfo');
            $xbrl->startElement('gl-cor:entriesType');
            $xbrl->writeAttribute('contextRef', 'C1');
            $xbrl->text($this->getEntriesType());
          $xbrl->endElement();//gl-cor:entriesType
        $xbrl->endElement();//gl-cor:documentInfo

          $xbrl->startElement('gl-cor:entityInformation');
            $xbrl->startElement('gl-bus:reportingCalendar');
            $xbrl->startElement('gl-bus:reportingCalendarPeriod');

                $xbrl->startElement('gl-bus:periodIdentifier');
                  $xbrl->writeAttribute('contextRef', 'C1');
                  $xbrl->text($this->getPeriodIdentifier());
                $xbrl->endElement();//gl-bus:periodIdentifier

                $xbrl->startElement('gl-bus:periodDescription');
                  $xbrl->writeAttribute('contextRef', 'C1');
                  $xbrl->text($this->getPeriodDescription());
                $xbrl->endElement();//gl-bus:periodDescription

                $xbrl->startElement('gl-bus:periodStart');
                  $xbrl->writeAttribute('contextRef', 'C1');
                  $xbrl->text($this->getPeriodStart());
                $xbrl->endElement();//gl-bus:periodStart

                $xbrl->startElement('gl-bus:periodEnd');
                  $xbrl->writeAttribute('contextRef', 'C1');
                  $xbrl->text($this->getPeriodEnd());
                $xbrl->endElement();//gl-bus:periodEnd

            $xbrl->endElement();//gl-bus:reportingCalendarPeriod
            $xbrl->endElement();//gl-bus:reportingCalendar
          $xbrl->endElement();//gl-cor:entityInformation

          $xbrl->startElement('gl-cor:entryHeader');
            $lineNumberCounter = 0;
            foreach($aXbrlRegistros as $aRegistros) {
              foreach ($aRegistros->registros as $account) {
                $this->setRegistrosContas($account);
                $this->addLinhas($xbrl, ++$lineNumberCounter);
              }
            }

          $xbrl->endElement();//gl-cor:entryHeader

        $xbrl->endElement();//gl-cor:accountingEntries

      $xbrl->endElement();//xbrli:xbrl
    $xbrl->endDocument();

    $this->setCaminhoArq($this->getNomeArq());
    $file = fopen("{$this->getNomeArq()}.xml",'w');
    fwrite($file,$xbrl->outputMemory(true));
    fclose($file);

  }

  public function addLinhas($xbrl, $lineNumberCounter) {

    $xbrl->startElement('gl-cor:entryDetail');
      $xbrl->startElement('gl-cor:lineNumberCounter');
        $xbrl->writeAttribute('contextRef', 'C1');
        $xbrl->writeAttribute('decimals', '0');
        $xbrl->writeAttribute('unitRef', 'u');
        $xbrl->text($lineNumberCounter);
      $xbrl->endElement();//gl-cor:lineNumberCounter

      $xbrl->startElement('gl-cor:account');

        $xbrl->startElement('gl-cor:accountMainID');
          $xbrl->writeAttribute('contextRef', 'C1');
          $xbrl->text($this->getConta());
        $xbrl->endElement();//gl-cor:accountMainID

        for ($ic = 1; $ic <= 7; $ic++) {
            $IC = "iIC".$ic;
            $getIC = "getIC".$ic;
            $getTipoIC = "getTipoIC".$ic;
          if (!empty($this->{$IC})) {
            $xbrl->startElement('gl-cor:accountSub');

              $xbrl->startElement('gl-cor:accountSubID');
                $xbrl->writeAttribute('contextRef', 'C1');
                $xbrl->text($this->{$getIC}());
              $xbrl->endElement();//gl-cor:accountSubID

              $xbrl->startElement('gl-cor:accountSubType');
                $xbrl->writeAttribute('contextRef', 'C1');
                $xbrl->text($this->{$getTipoIC}());
              $xbrl->endElement();//gl-cor:accountType

            $xbrl->endElement();//gl-cor:accountSub
          }
        }

      $xbrl->endElement();//gl-cor:account

      $xbrl->startElement('gl-cor:amount');
        $xbrl->writeAttribute('contextRef', 'C1');
        $xbrl->writeAttribute('decimals', '2');
        $xbrl->writeAttribute('unitRef', 'BRL');
        $xbrl->text($this->getValor());
      $xbrl->endElement();//gl-cor:amount

      $signOfAmount = ($this->getValor() > 0) ? '+' : '-';

      $xbrl->startElement('gl-cor:signOfAmount');
        $xbrl->writeAttribute('contextRef', 'C1');
        $xbrl->text($signOfAmount);
      $xbrl->endElement();///gl-cor:signOfAmount

      $xbrl->startElement('gl-cor:debitCreditCode');
        $xbrl->writeAttribute('contextRef', 'C1');
        $xbrl->text($this->getNaturezaValor());
      $xbrl->endElement();//gl-cor:debitCreditCode

      $xbrl->startElement('gl-cor:xbrlInfo');
        $xbrl->startElement('gl-cor:xbrlInclude');
          $xbrl->writeAttribute('contextRef', 'C1');
          $xbrl->text($this->getTipoValor());
        $xbrl->endElement();//gl-cor:xbrlInclude
      $xbrl->endElement();//gl-cor:xbrlInfo

    $xbrl->endElement();//gl-cor:entryDetail

  }

  public function setRegistrosContas($oRegistro) {

    $this->limpaRegistrosContas();

    $this->setConta($oRegistro->conta);

    for ($ic = 1; $ic <= 7; $ic++) {
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

  public function limpaRegistrosContas() {

    $this->iConta = "";

    for ($ic = 1; $ic <= 7; $ic++) {
      $IC     = "iIC".$ic;
      $TipoIC = "sTipoIC".$ic;
      $this->{$IC} = "";
      $this->{$TipoIC} = "";
    }

    $this->iValor = "";
    $this->sTipoValor = "";
    $this->sNaturezaValor = "";

  }

}

