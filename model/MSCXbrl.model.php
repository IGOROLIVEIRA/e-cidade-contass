<?php
class MSCXbrl extends XMLWriter {
  function __construct() { }
  
  //@var integer
  private $iConta;
  //@var integer
  private $iIC1;
  //@var string
  private $sTipoIC1;
  //@var integer
  private $iIC2;
  //@var string
  private $sTipoIC2;
  //@var integer
  private $iIC3;
  //@var string
  private $sTipoIC3;
  //@var integer
  private $iIC4;
  //@var string
  private $sTipoIC4;
  //@var integer
  private $iIC5;
  //@var string
  private $sTipoIC5;
  //@var integer
  private $iIC6;
  //@var string
  private $sTipoIC6;
  //@var integer
  private $iIC7;
  //@var string
  private $sTipoIC7;
  //@var integer
  private $iValor;
  //@var string
  private $sTipoValor;
  //@var string
  private $sNaturezaValor;
  //@var string
  private $sIndetifier;
  //@var string
  private $sInstant;
  //@var string
  private $sEntriesType;
  //@var string
  private $sPeriodIdentifier;
  //@var string
  private $sPeriodDescription;
  //@var string
  private $sPeriodStart;
  //@var string
  private $sPeriodEnd;
  //@var integer
  private $iLineNumberCounter = 0;
  //@var string
  private $aRegistros = array();
  //@var string
  private $sNomeArq;
  //@var string
  private $sCaminhoArq;
  
  //Conta
  public function setConta($iConta) {
    $this->iConta = $iConta;
  }
  public function getConta() {
    return $this->iConta;
  }
  //IC1
  public function setIC1($iIC1) {
    $this->iIC1 = $iIC1;
  }
  public function getIC1() {
    return $this->iIC1;
  }
  //Tipo1
  public function setTipoIC1($sTipoIC1) {
    $this->sTipoIC1 = $sTipoIC1;
  }
  public function getTipoIC1() {
    return $this->sTipoIC1;
  }
  //IC2
  public function setIC2($iIC2) {
    $this->iIC2 = $iIC2;
  }
  public function getIC2() {
    return $this->iIC2;
  }
  //Tipo2
  public function setTipoIC2($sTipoIC2) {
    $this->sTipoIC2 = $sTipoIC2;
  }
  public function getTipoIC2() {
    return $this->sTipoIC2;
  }
  //IC3
  public function setIC3($iIC3) {
    $this->iIC3 = $iIC3;
  }
  public function getIC3() {
    return $this->iIC3;
  }
  //Tipo3
  public function setTipoIC3($sTipoIC3) {
    $this->sTipoIC3 = $sTipoIC3;
  }
  public function getTipoIC3() {
    return $this->sTipoIC3;
  }
  //IC4
  public function setIC4($iIC4) {
    $this->iIC4 = $iIC4;
  }
  public function getIC4() {
    return $this->iIC4;
  }
  //Tipo4
  public function setTipoIC4($sTipoIC4) {
    $this->sTipoIC4 = $sTipoIC4;
  }
  public function getTipoIC4() {
    return $this->sTipoIC4;
  }
  //IC5
  public function setIC5($iIC5) {
    $this->iIC5 = $iIC5;
  }
  public function getIC5() {
    return $this->iIC5;
  }
  //Tipo5
  public function setTipoIC5($sTipoIC5) {
    $this->sTipoIC5 = $sTipoIC5;
  }
  public function getTipoIC5() {
    return $this->sTipoIC5;
  }
  //IC6
  public function setIC6($iIC6) {
    $this->iIC6 = $iIC6;
  }
  public function getIC6() {
    return $this->iIC6;
  }
  //Tipo6
  public function setTipoIC6($sTipoIC6) {
    $this->sTipoIC6 = $sTipoIC6;
  }
  public function getTipoIC6() {
    return $this->sTipoIC6;
  }
  //IC7
  public function setIC7($iIC7) {
    $this->iIC7 = $iIC7;
  }
  public function getIC7() {
    return $this->iIC7;
  }
  //Tipo7
  public function setTipoIC7($sTipoIC7) {
    $this->sTipoIC7 = $sTipoIC7;
  }
  public function getTipoIC7() {
    return $this->sTipoIC7;
  }
  //Valor
  public function setValor($iValor) {
    $this->iValor = $iValor;
  }
  public function getValor() {
    return $this->iValor;
  }
  //TipoValor
  public function setTipoValor($sTipoValor) {
    $this->sTipoValor = $sTipoValor;
  }
  public function getTipoValor() {
    return $this->sTipoValor;
  }
  //NaturezaValor
  public function setNaturezaValor($sNaturezaValor) {
    $this->sNaturezaValor = $sNaturezaValor;
  }
  public function getNaturezaValor() {
    return $this->sNaturezaValor;
  }
  //Indetifier
  public function setIndetifier($sIndetifier) {
    $this->sIndetifier = $sIndetifier;
  }
  public function getIndetifier() {
    return $this->sIndetifier;
  }
  //Instant
  public function setInstant($sInstant) {
    $this->sInstant = $sInstant;
  }
  public function getInstant() {
    return $this->sInstant;
  }
  //EntriesType
  public function setEntriesType($sEntriesType) {
    $this->sEntriesType = $sEntriesType;
  }
  public function getEntriesType() {
    return $this->sEntriesType;
  }
  //PeriodIdentifier
  public function setPeriodIdentifier($sPeriodIdentifier) {
    $this->sPeriodIdentifier = $sPeriodIdentifier;
  }
  public function getPeriodIdentifier() {
    return $this->sPeriodIdentifier;
  }
  //PeriodDescription
  public function setPeriodDescription($sPeriodDescription) {
    $this->sPeriodDescription = $sPeriodDescription;
  }
  public function getPeriodDescription() {
    return $this->sPeriodDescription;
  }
  //PeriodStart;
  public function setPeriodStart($sPeriodStart) {
    $this->sPeriodStart = $sPeriodStart;  
  }
  public function getPeriodStart() {
    return $this->sPeriodStart;
  }
  //PeriodEnd;
  public function setPeriodEnd($sPeriodEnd) {
    $this->sPeriodEnd = $sPeriodEnd;
  }
  public function getPeriodEnd() {
    return $this->sPeriodEnd;
  }
  //Nome do arquivo;
  public function setNomeArq($sNomeArq) {
    $this->sNomeArq = $sNomeArq;
  }
  public function getNomeArq() {
    return $this->sNomeArq;
  }
  //Caminho do arquivo;
  public function setCaminhoArq($sCaminhoArq) {
    $this->sCaminhoArq = $sCaminhoArq;
  }
  public function getCaminhoArq() {
    return $this->sCaminhoArq;
  }

  public function gerarArquivo($ano, $mes) {

    # Cria memoria para armazenar a saida
    $this->openMemory();
    
    $this->startDocument( '1.0' , 'iso-8859-1' );
    
    $this->startElement("xbrli:xbrl");
    $this->writeAttribute('xmlns', 'http://www.xbrl.org/2003/instance'); $this->writeAttribute('xmlns:gl-bus', 'http://www.xbrl.org/int/gl/bus/2015-03-25'); $this->writeAttribute('xmlns:gl-cor', 'http://www.xbrl.org/int/gl/cor/2015-03-25'); $this->writeAttribute('xmlns:iso4217', 'http://www.xbrl.org/2003/iso4217'); $this->writeAttribute('xmlns:link', 'http://www.xbrl.org/2003/linkbase'); $this->writeAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink'); $this->writeAttribute('xmlns:xbrli', 'http://www.w3.org/2001/XMLSchema-instance'); 
    
    $this->startElement("link:schemaRef");
    $this->writeAttribute("xlink:href", "SICONFI/cor/ext/gl/plt/case-c-b-m-u-t-s/gl-plt-all-2015-03-25.xsd");
    $this->endElement();//link:schemaRef
    
    $this->startElement("xbrli:context");
    $this->writeAttribute("id", "C1");
    
    $this->startElement("xbrli:entity");
    $this->writeElement("xbrli:indetifier", $this->getIndetifier());//4214805EX
    $this->writeAttribute("scheme", "http://siconfi.tesouro.gov.br");
    $this->endElement();//xbrli:entity
    
    $this->startElement("xbrli:period");
    $this->writeElement("xbrli:instant", $this->getInstant());//2015-12-31
    $this->endElement();//xbrli:period
    $this->endElement();//xbrli:context
    
    $this->startElement("xbrli:unit");
    $this->writeAttribute("id", "BRL");
    $this->writeElement("xbrli:measure","iso4217:BRL");
    $this->endElement();//xbrli:unit
    
    $this->startElement("xbrli:unit");
    $this->writeAttribute("id", "u");
    $this->writeElement("xbrli:measure","xbrli:pure");
    $this->endElement();//xbrli:unit
  
        $this->startElement("gl-cor:accountingEntries");
        $this->startElement("gl-cor:documentInfo");
          $this->writeElement("gl-cor:entriesType", $this->getEntriesType());//trialbalance
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:documentInfo
        
        $this->startElement("gl-cor:entityInformation");
          $this->startElement("gl-bus:reportingCalendar");
          $this->startElement("gl-bus:reportingCalendarPeriod");
              $this->writeElement("gl-bus:periodIdentifier", $this->getPeriodIdentifier());//2015-01
              $this->writeElement("gl-bus:periodDescription", $this->getPeriodDescription());//2015-01-01
              $this->writeElement("gl-bus:periodStart", $this->getPeriodStart());//2015-01-01
              $this->writeElement("gl-bus:periodEnd", $this->getPeriodEnd());//2015-01-31
          $this->endElement();//gl-bus:reportingCalendarPeriod
          $this->endElement();//gl-bus:reportingCalendar
        $this->endElement();//gl-cor:entityInformation

        $oRegistros = $this->getConsulta($ano, $mes);
        for($iRow = 0; $iRow < pg_num_rows($oRegistros); $iRow++) {
          $aRow = pg_fetch_array($oRegistros, $iRow, PGSQL_NUM);
          $this->aRegistros += $this->gerarLinhas($aRow);
        }

        $this->startElement("gl-cor:entryHeader");
          $this->startElement("gl-cor:entryDetail");
            $this->writeElement("gl-cor:lineNumberCounter", $this->iLineNumberCounter);
            $this->writeAttribute("contextRef", "C1");
            $this->writeAttribute("decimals", "0");
            $this->writeAttribute("unitRef", "u");
          //echo "<pre>"; print_r($this->aRegistros);die;
          foreach($this->aRegistros as $aRegistros) {     
            foreach ($aRegistros->registros as $account) {
              $this->setRegistrosContas($account);
              $this->addLinhas();//Registros
            }
          }
          $this->endElement();//gl-cor:entryDetail
        $this->endElement();//gl-cor:entryHeader
        
        $this->endElement();//gl-cor:accountingEntries
        
        $this->endElement();//xbrli:xbrl
    $this->endDocument();
    
    //header( 'Content-type: text/xml' );
    //print $this->outputMemory(true);
    $this->setCaminhoArq("/tmp/{$this->getNomeArq()}.xml");
    $file = fopen("/tmp/{$this->getNomeArq()}.xml",'w+');
    fwrite($file,$this->outputMemory(true));
    fclose($file);
    
  }
  
  public function addLinhas() {
  
    $this->startElement("gl-cor:account");
          
      $this->writeElement("gl-cor:accountMainID", $this->getConta());
        $this->writeAttribute("contextRef", "C1");        
            
      if (!empty($this->iIC1)) {
        $this->startElement("gl-cor:accountSub");
          $this->writeElement("gl-cor:accountSubID", $this->getIC1());
          $this->writeAttribute("contextRef", "C1");
          $this->writeElement("gl-cor:accountType", $this->getTipoIC1());
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:accountSub
      }
      if (!empty($this->iIC2)) {
        $this->startElement("gl-cor:accountSub");
          $this->writeElement("gl-cor:accountSubID", $this->getIC2());
          $this->writeAttribute("contextRef", "C1");
          $this->writeElement("gl-cor:accountType", $this->getTipoIC2());
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:accountSub
      }
      if (!empty($this->iIC3)) {
        $this->startElement("gl-cor:accountSub");
          $this->writeElement("gl-cor:accountSubID", $this->getIC3());
          $this->writeAttribute("contextRef", "C1");
          $this->writeElement("gl-cor:accountType", $this->getTipoIC3());
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:accountSub
      }
      if (!empty($this->iIC4)) {
        $this->startElement("gl-cor:accountSub");
          $this->writeElement("gl-cor:accountSubID", $this->getIC4());
          $this->writeAttribute("contextRef", "C1");
          $this->writeElement("gl-cor:accountType", $this->getTipoIC4());
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:accountSub
      }
      if (!empty($this->iIC5)) {
        $this->startElement("gl-cor:accountSub");
          $this->writeElement("gl-cor:accountSubID", $this->getIC5());
          $this->writeAttribute("contextRef", "C1");
          $this->writeElement("gl-cor:accountType", $this->getTipoIC5());
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:accountSub
      }
      if (!empty($this->iIC6)) {
        $this->startElement("gl-cor:accountSub");
          $this->writeElement("gl-cor:accountSubID", $this->getIC6());
          $this->writeAttribute("contextRef", "C1");
          $this->writeElement("gl-cor:accountType", $this->getTipoIC6());
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:accountSub
      }
      if (!empty($this->iIC7)) {
        $this->startElement("gl-cor:accountSub");
          $this->writeElement("gl-cor:accountSubID", $this->getIC7());
          $this->writeAttribute("contextRef", "C1");
          $this->writeElement("gl-cor:accountType", $this->getTipoIC7());
          $this->writeAttribute("contextRef", "C1");
        $this->endElement();//gl-cor:accountSub
      }
     
      $this->endElement();//gl-cor:account
  
      $this->writeElement("gl-cor:amount", $this->getValor());
      $this->writeAttribute("contextRef", "C1");
      $this->writeAttribute("decimals", "2");
      $this->writeAttribute("unitRef", "BRL"); 

      $this->writeElement("gl-cor:debitCreditCode", $this->getNaturezaValor());
      $this->writeAttribute("contextRef", "C1");

      $this->startElement("gl-cor:xbrlInfo");
        $this->writeElement("gl-cor:xbrlInclude", $this->getTipoValor());
        $this->writeAttribute("contextRef", "C1");
      $this->endElement();//gl-cor:xbrlInfo
  
  }

  public function gerarLinhas($oRegistro) {
    /*'conta'=>'0', 'po'=>'1', 'fr'=>'2', 'nd'=>'3', 'fs'=>'4', 'fp'=>'5', 'nr'=>'6', 'al'=>'7'
    'valor'=>'8', 'tipovalor'=>'9' , 'nat_vlr'=>'10', 'valor'=>'11', 'tipovalor'=>'12'
    'valor'=>'13', 'tipovalor'=>'14', 'valor'=>'15', 'tipovalor'=>'16', 'nat_vlr'=>'17'*/

    $aLinhas = array('beginning_balance','period_change_deb','period_change_cred','ending_balance');
    $aRegistros = array();
    $indice = "";

    for ($ind = 0; $ind < 7; $ind++) {
      $indice .= $oRegistro[$ind];
    }

    $oContas = new stdClass;
    $oContas->registros = array();
    $aRegistros[$indice] = $oContas;

    for ($i=0; $i < 4; $i++) {
      if (in_array($aLinhas[$i], $oRegistro)) {
        $oNovoResgistro = new stdClass;
        $oNovoResgistro->conta = $oRegistro[0];
        if ($aLinhas[$i] == 'beginning_balance' || $aLinhas[$i] == 'ending_balance') {
          $key = array_search($aLinhas[$i], $oRegistro);
          $oNovoResgistro->tipoValor = $aLinhas[$i];
          $oNovoResgistro->valor     = $oRegistro[$key-1];
          $oNovoResgistro->nat_vlr   = $oRegistro[$key+1];
        } 

        if ($aLinhas[$i] == 'period_change_deb' || $aLinhas[$i] == 'period_change_cred') {
          $key = array_search($aLinhas[$i], $oRegistro);
          $nat_valor = explode("_", $aLinhas[$i]);
          $oNovoResgistro->nat_vlr = $nat_valor[2] == 'deb' ? 'D' : 'C'; 
          $oNovoResgistro->tipoValor = 'period_change';
          $oNovoResgistro->valor     = $oRegistro[$key-1];
        }
        
        $aTipoIC = array("PO","FP","FR","NR","ND","FS","AI");
        $IC = "IC";
        $TipoIC = "TipoIC";
        for ($ii = 1; $ii < 8; $ii++) {
          if (!empty($oRegistro[$ii]) || $oRegistro[$ii] != 0) {
            $oNovoResgistro->{$IC.$ii} = $oRegistro[$ii];
            $oNovoResgistro->{$TipoIC.$ii} = $aTipoIC[$ii-1];
          }
        }
        $aRegistros[$indice]->registros[$i] = $oNovoResgistro;
        $this->iLineNumberCounter++;
      }
    }
    
    return $aRegistros;

  }

  public function setRegistrosContas($oRegistro) {

    $this->setConta($oRegistro->conta);

    if (isset($oRegistro->IC1)) {
      $this->setIC1($oRegistro->IC1);
      $this->setTipoIC1($oRegistro->TipoIC1);
    }
    if (isset($oRegistro->IC2)) {
      $this->setIC2($oRegistro->IC2);
      $this->setTipoIC2($oRegistro->TipoIC2);
    }
    if (isset($oRegistro->IC3)) {
      $this->setIC3($oRegistro->IC3);
      $this->setTipoIC3($oRegistro->TipoIC3);
    }
    if (isset($oRegistro->IC4)) {
      $this->setIC4($oRegistro->IC4);
      $this->setTipoIC4($oRegistro->TipoIC4);
    }
    if (isset($oRegistro->IC5)) {
      $this->setIC5($oRegistro->IC5);
      $this->setTipoIC5($oRegistro->TipoIC5);
    }
    if (isset($oRegistro->IC6)) {
      $this->setIC6($oRegistro->IC6);
      $this->setTipoIC6($oRegistro->TipoIC6);
    }
    if (isset($oRegistro->IC7)) {
      $this->setIC7($oRegistro->IC7);
      $this->setTipoIC7($oRegistro->TipoIC7);
    }

    $this->setValor($oRegistro->valor);
    $this->setTipoValor($oRegistro->tipoValor);
    $this->setNaturezaValor($oRegistro->nat_vlr); 

  }
  
  public function getConsulta($ano, $mes) {
    $sSQL = "
      SELECT si177_contacontaabil AS conta,
      po,
      fp,
      fr,
      '' AS nr,
      '' AS nd,
      '' AS fs,
      '' AS al,
      round(si177_saldoinicial,2) AS valor,
      'beginning_balance' AS tipovalor,
      CASE
          WHEN si177_saldoinicial < 0 THEN 'C'
          ELSE 'D'
      END nat_vlr,
      CASE
          WHEN round(si177_totaldebitos,2) = 0 THEN NULL
          ELSE round(si177_totaldebitos,2)
      END AS valor,
      CASE
          WHEN round(si177_totaldebitos,2) = 0 THEN NULL
          ELSE 'period_change_deb'
      END AS tipovalor,
      CASE
          WHEN round(si177_totalcreditos,2) = 0 THEN NULL
          ELSE round(si177_totalcreditos,2)
      END AS valor,
      CASE
          WHEN round(si177_totalcreditos,2) = 0 THEN NULL
          ELSE 'period_change_cred'
      END AS tipovalor,
      round(ending_balance,2) AS valor,
      'ending_balance' AS tipovalor,
      CASE
          WHEN ending_balance < 0 THEN 'C'
          ELSE 'D'
      END nat_vlr
      FROM
      (SELECT si177_contacontaabil,
            CASE
                WHEN db21_tipoinstit IN (6) THEN 10132
                WHEN db21_tipoinstit IN (2) THEN 20231
                ELSE 10131
            END AS po,
            CASE
                WHEN balancete15{$ano}.si182_atributosf IS NOT NULL THEN balancete15{$ano}.si182_atributosf
                WHEN balancete16{$ano}.si183_atributosf IS NOT NULL THEN balancete16{$ano}.si183_atributosf
                WHEN balancete17{$ano}.si184_atributosf IS NOT NULL THEN balancete17{$ano}.si184_atributosf
                WHEN balancete22{$ano}.si189_atributosf IS NOT NULL THEN balancete22{$ano}.si189_atributosf
                WHEN balancete25{$ano}.si194_atributosf IS NOT NULL THEN balancete25{$ano}.si194_atributosf
                WHEN balancete26{$ano}.si193_atributosf IS NOT NULL THEN balancete26{$ano}.si193_atributosf
                ELSE NULL
            END AS fp,
            CASE
                WHEN balancete11{$ano}.si178_codfontrecursos IS NOT NULL THEN balancete11{$ano}.si178_codfontrecursos
                WHEN balancete12{$ano}.si179_codfontrecursos IS NOT NULL THEN balancete12{$ano}.si179_codfontrecursos
                WHEN balancete14{$ano}.si181_codfontrecursos IS NOT NULL THEN balancete14{$ano}.si181_codfontrecursos
                WHEN balancete16{$ano}.si183_codfontrecursos IS NOT NULL THEN balancete16{$ano}.si183_codfontrecursos
                WHEN balancete17{$ano}.si184_codfontrecursos IS NOT NULL THEN balancete17{$ano}.si184_codfontrecursos
                WHEN balancete18{$ano}.si185_codfontrecursos IS NOT NULL THEN balancete18{$ano}.si185_codfontrecursos
                WHEN balancete20{$ano}.si187_codfontrecursos IS NOT NULL THEN balancete20{$ano}.si187_codfontrecursos
                WHEN balancete21{$ano}.si188_codfontrecursos IS NOT NULL THEN balancete21{$ano}.si188_codfontrecursos
                ELSE NULL
            END AS fr,
            sum(CASE
                    WHEN si177_naturezasaldoinicial = 'D' THEN si177_saldoinicial
                    WHEN si177_naturezasaldoinicial = 'C' THEN si177_saldoinicial *-1
                    ELSE 0
                END) AS si177_saldoinicial,
            sum(si177_totaldebitos) AS si177_totaldebitos,
            sum(si177_totalcreditos) AS si177_totalcreditos,
            sum(si177_saldofinal) AS ending_balance
      FROM balancete10{$ano}
      INNER JOIN db_config ON codigo = si177_instit
      LEFT JOIN balancete11{$ano} ON (si178_reg10) = (si177_sequencial)
      LEFT JOIN balancete12{$ano} ON (si179_reg10) = (si177_sequencial)
      LEFT JOIN balancete13{$ano} ON (si180_reg10) = (si177_sequencial)
      LEFT JOIN balancete14{$ano} ON (si181_reg10) = (si177_sequencial)
      LEFT JOIN balancete15{$ano} ON (si182_reg10) = (si177_sequencial)
      LEFT JOIN balancete16{$ano} ON (si183_reg10) = (si177_sequencial)
      LEFT JOIN balancete17{$ano} ON (si184_reg10) = (si177_sequencial)
      LEFT JOIN balancete18{$ano} ON (si185_reg10) = (si177_sequencial)
      LEFT JOIN balancete20{$ano} ON (si187_reg10) = (si177_sequencial)
      LEFT JOIN balancete21{$ano} ON (si188_reg10) = (si177_sequencial)
      LEFT JOIN balancete22{$ano} ON (si189_reg10) = (si177_sequencial)
      LEFT JOIN balancete23{$ano} ON (si190_reg10) = (si177_sequencial)
      LEFT JOIN balancete24{$ano} ON (si191_reg10) = (si177_sequencial)
      LEFT JOIN balancete25{$ano} ON (si194_reg10) = (si177_sequencial)
      LEFT JOIN balancete26{$ano} ON (si193_reg10) = (si177_sequencial)
      WHERE si177_mes = {$mes}
      GROUP BY 1, 2,
      si182_atributosf, si183_atributosf, si184_atributosf, si189_atributosf, si194_atributosf, si193_atributosf,
      si178_codfontrecursos, si179_codfontrecursos, si181_codfontrecursos, si183_codfontrecursos, si184_codfontrecursos, si185_codfontrecursos, si187_codfontrecursos, si188_codfontrecursos
      ORDER BY si177_contacontaabil) AS x ORDER BY conta, 2
    ";
    $rsResult = db_query($sSQL);
    return $rsResult;
  }
  
  

}

