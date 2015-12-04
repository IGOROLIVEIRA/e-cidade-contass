<?php
class dbGeradorRelatorio {

  private $oXmlWriter    = null;
  private $aPropriedades = array();
  private $sCabecalho    = "";
  private $sRodape       = "";
  public  $aVariaveis    = array();
  public  $aColunas      = array();
  public  $aConsulta  	 = array();
  public  $aFiltros		 = array();
  public  $aOrdem		 = array();
  private $aAgrupamento  = array();
  private $sBuffer       = "";
  private $sBufferAgt    = "";
  const VERSAOXML        = "1.0";
  
  
  function __construct($iCodRelatorio="") {

  	if(!empty($iCodRelatorio)){
		$this->loadRelatorio($iCodRelatorio);  		
  	}
  	
  }

  
  private function loadRelatorio($iCodRelatorio){
  	
  	if(empty($iCodRelatorio)){
  	  throw new Exception("Código do relatório vazio!");		  		
  	}
  	
  	$cldb_relatorio = new cl_db_relatorio();
  	  		
	$rsConsultaRelatorio = $cldb_relatorio->sql_record($cldb_relatorio->sql_query($iCodRelatorio));
	
	if( $cldb_relatorio->numrows > 0 ){
	
  	  $oRelatorio = db_utils::fieldsMemory($rsConsultaRelatorio,0);
      
  	  $oDomXml	= new DOMDocument();
    
      $oDomXml->loadXML($oRelatorio->db63_xmlestruturarel);	
  	  
      
      $aPropriedades = $oDomXml->getElementsByTagName('Propriedades');
      
      foreach ($aPropriedades as $oXMLPropriedades) {
      	
      	$oPropriedades = new dbPropriedadeRelatorio();
      	
      	$oPropriedades->setVersao 	 ($oXMLPropriedades->getAttribute('versao')); 
      	$oPropriedades->setFormato   ($oXMLPropriedades->getAttribute('formato'));
      	$oPropriedades->setLayout 	 ($oXMLPropriedades->getAttribute('layout'));
      	$oPropriedades->setMargemDir ($oXMLPropriedades->getAttribute('margemdir'));
      	$oPropriedades->setMargemEsq ($oXMLPropriedades->getAttribute('margemesq'));
      	$oPropriedades->setMargemInf ($oXMLPropriedades->getAttribute('margeminf'));
      	$oPropriedades->setMargemSup ($oXMLPropriedades->getAttribute('margemsup'));
      	$oPropriedades->setNome		 ($oXMLPropriedades->getAttribute('nome'));
      	$oPropriedades->setOrientacao($oXMLPropriedades->getAttribute('orientacao'));
      	
      	$this->addPropriedades($oPropriedades);
      }	      

      
      $aCabecalho = $oDomXml->getElementsByTagName("Cabecalho");      
      if(!empty($aCabecalho)){
        foreach ($aCabecalho as $oXMLCabecalho) {
          if ($oXMLCabecalho->nodeValue) {	
      	    $this->addCabecalho($oXMLCabecalho->nodeValue);
          }
        }
      }
      
	  $aRodape = $oDomXml->getElementsByTagName("Rodape");      
	  if(!empty($aRodape)){
	    foreach ($aRodape as $oXMLRodape) {
	      if($oXMLRodape->nodeValue){
	  	    $this->addRodape($oXMLRodape->nodeValue);
	      } 
	    }
	  }
	  
	  $aVariavel = $oDomXml->getElementsByTagName("Variavel");      
	  if (!empty($aVariavel)){
	    foreach ( $aVariavel as $oXMLVariavel ){
	      $oVariavel = new dbVariaveisRelatorio();
		  $oVariavel->setNome ($oXMLVariavel->getAttribute('nome'));
		  $oVariavel->setLabel($oXMLVariavel->getAttribute('label'));
		  $oVariavel->setValor($oXMLVariavel->getAttribute('valor'));
		  $this->addVariavel($oXMLVariavel->getAttribute('nome'),$oVariavel);		    	
	    }
	  }
	  
	  $aConsulta = $oDomXml->getElementsByTagName("Consulta");      
	  
	  foreach ( $aConsulta as $oXMLConsulta ){
	  	$aSelect = $oXMLConsulta->getElementsByTagName('Select');
	  	foreach ($aSelect as $oXMLCamposSelect ){
	  	  $aCampoSelect = $oXMLCamposSelect->getElementsByTagName('Campo');
   		  foreach ( $aCampoSelect as $oXMLCampoSelect){
   		  	$aCampos = $oDomXml->getElementsByTagName("Campos");
	  	    foreach ($aCampos as $oXMLCampos) {
	  	      $aCampo = $oXMLCampos->getElementsByTagName("Campo");
	          foreach ($aCampo as $oXMLCampo){
	            if ( $oXMLCampo->getAttribute('id') == $oXMLCampoSelect->getAttribute('id')){
				  
		    	  $oCampo = new dbColunaRelatorio();
		    	  
		    	  $oCampo->setId			($oXMLCampo->getAttribute('id'));
		    	  $oCampo->setNome		    ($oXMLCampo->getAttribute('nome'));
		    	  $oCampo->setAlias		    (utf8_decode($oXMLCampo->getAttribute('alias')));
		    	  $oCampo->setAlinhamento	($oXMLCampo->getAttribute('alinhamento'));
		    	  $oCampo->setAlinhamentoCab($oXMLCampo->getAttribute('alinhamentocab'));
		    	  $oCampo->setLargura		($oXMLCampo->getAttribute('largura'));
		    	  $oCampo->setMascara		($oXMLCampo->getAttribute('mascara'));
		    	  $oCampo->setTotalizar		($oXMLCampo->getAttribute('totalizar'));
		    	  
		    	  $this->addColuna($oCampo,$oXMLConsulta->getAttribute('tipo'));
				  
	            }
	          }
	        }			  	
	  	  }
	  	}	

	  	$aWhere	 = $oXMLConsulta->getElementsByTagName('Filtro');
		foreach ($aWhere as $oXMLWhere){
			$oFiltro = new dbFiltroRelatorio();
			$oFiltro->setOperador($oXMLWhere->getAttribute('operador'));
			$oFiltro->setCampo	 ($oXMLWhere->getAttribute('campo'));
			$oFiltro->setCondicao($oXMLWhere->getAttribute('condicao'));
			$oFiltro->setValor   ($oXMLWhere->getAttribute('valor'));
			$this->addFiltro($oFiltro,$oXMLConsulta->getAttribute('tipo'));
		}	  	
	  	
	    $aGroup	 = $oXMLConsulta->getElementsByTagName('Group');
	  	foreach ($aGroup as $oXMLGroup){
		}
		
	    $aOrder	 = $oXMLConsulta->getElementsByTagName('Ordem');
	  	foreach ($aOrder as $oXMLOrder){
	  	  $oOrdem = new dbOrdemRelatorio();
		  $oOrdem->setId     ($oXMLOrder->getAttribute('id'));
		  $oOrdem->setNome   ($oXMLOrder->getAttribute('nome'));
		  $oOrdem->setAscDesc($oXMLOrder->getAttribute('ascdesc'));
		  $oOrdem->setAlias  ($oXMLOrder->getAttribute('alias'));
		  $this->addOrdem($oOrdem,$oXMLConsulta->getAttribute('tipo'));	  		
		}
		
	  	$aFrom	 = $oXMLConsulta->getElementsByTagName('From');
	    foreach ($aFrom as $oXMLFrom){
	      $this->addConsulta($oXMLFrom->nodeValue,$oXMLConsulta->getAttribute('tipo'));
	    }		
	  
	  }	

	}
  	
  }
  
  
  public function addPropriedades(dbPropriedadeRelatorio $oPropriedade) {

  	if (empty($oPropriedade)) {
      throw new Exception("Inclusão de propriedades abortada, valor nulo ou vazio.");
    }
    
    $this->aPropriedades = $oPropriedade;
    
  }
  
  public function getPropriedades(){
	return $this->aPropriedades;  	
  }
  
  
  public function addCabecalho($sValor) {

  	if (empty($sValor)) {
      throw new Exception("Inclusão de cabeçalho abortada, valor nulo ou vazio.");
    }
    
    $this->sCabecalho = $sValor;
    
  }
  
  public function addRodape($sValor) {

  	if (empty($sValor)) {
      throw new Exception("Inclusão de rodapé abortada, valor nulo ou vazio.");
    }
    
    $this->sRodape = $sValor;
    
  }
  
  
  public function addVariavel($sNome, dbVariaveisRelatorio $oVariavel) {

    if (empty($sNome)) {
      throw new Exception("Inclusão de variável abortada, nome nulo ou vazio.");
    }
  	
  	if (empty($oVariavel)) {
      throw new Exception("Inclusão de variável abortada, valor nulo ou vazio.");
    }
    
    $this->aVariaveis[$sNome] = $oVariavel;
    
  }

  
  public function getVariaveis($sNome=""){
  	
    if (empty($sNome)) {
	  return $this->aVariaveis;
  	} else {
  	  return $this->aVariaveis[$sNome];
  	}
	   	
  }
  
  
  
  
  public function addColuna( dbColunaRelatorio $oColuna, $sTipoRel="Principal") {
  	
  	if (empty($oColuna)) {
      throw new Exception("Inclusão de coluna abortada, valor nulo ou vazio.");
    }
    
    $this->aColunas[$sTipoRel][$oColuna->getNome()] = $oColuna;
    
  }

  
  
  public function getColunas($sNome="",$sTipoRel="Principal") {
    
  	if (empty($sNome)) {
  	  return $this->aColunas[$sTipoRel];
  	} else {
  	  return $this->aColunas[$sTipoRel][$sNome];	
  	}
  	
  }

  
  public function converteColunaDocumento($aColunas){
  	
	 foreach ($aColunas as $sNome => $oColuna) {
	   $oColuna->setAlias("");   
   	   $this->addColuna($oColuna);
	 }
	 
  }
  
  
  
  public function addFiltro( dbFiltroRelatorio $oFiltro, $sTipoRel="Principal") {

  	if (empty($oFiltro)) {  		
      throw new Exception("Inclusão de filtro abortada, valor nulo ou vazio.");
    }
    
    $this->aFiltros[$sTipoRel]["{$oFiltro->getCampo()}{$oFiltro->getCondicao()}{$oFiltro->getValor()}"] = $oFiltro;
    
  }

  public function getFiltros($sTipoRel=""){
  	if (empty($sTipoRel)){
  	  return $this->aFiltros;
  	} else {
  	  return $this->aFiltros[$sTipoRel];
  	}
  }
  
  
  
  
  public function addOrdem(dbOrdemRelatorio $oOrdem, $sTipoRel="Principal") {

  	if (empty($oOrdem)) {
      throw new Exception("Inclusão de ordem abortada, valor nulo ou vazio.");
    }
    
    $this->aOrdem[$sTipoRel][$oOrdem->getNome()] = $oOrdem;
    
  }
  
  public function getOrdem($sNome="",$sTipoRel="Principal") {
    
  	if (empty($sNome)) {
  	  return $this->aOrdem;
  	} else {
  	  return $this->aOrdem[$sTipoRel][$sNome];	
  	}
  	
  }  

  
  public function addAgrupamento(dbColunaRelatorio $oColuna, $sTipoRel="Principal") {

  	if (empty($oColuna)) {
      throw new Exception("Inclusão de agrupamento abortada, valor nulo ou vazio.");
    }
    
    $this->aAgrupamento[$sTipoRel][] = $oColuna->getId();
    
  }
  
  
  
  public function addConsulta( $sSqlFrom="", $sTipoRel="Principal") {
	
  	$aConsulta 	  = array();
  	$aFiltro  	  = array();
  	$aOrdem       = array();
  	$aAgrupamento = array(); 
  	
  	if (empty($this->aColunas[$sTipoRel])) {
      throw new Exception("Inclusão de consulta abortada, nenhum coluna definida.");
    }
	
  	if (empty($sTipoRel)) {
      throw new Exception("Inclusão abortada, valor nulo ou vazio.");
    }

    if (empty($sSqlFrom)) {
      throw new Exception("Inclusão abortada, valor nulo ou vazio.");
    }
    
    foreach ($this->aColunas as $sTipo => $aColunas) {
      foreach ($aColunas as $iIndice => $oColunas) {
        if ( $sTipo == $sTipoRel ) {
  	      $aConsulta[] = $oColunas->getId();
        }
      }
    }
    
    foreach ($this->aFiltros as $sTipo => $aFiltros) {
      foreach ($aFiltros as $iIndice => $oFiltros) {
        if ( $sTipo == $sTipoRel ) {
          $aFiltro[] = $oFiltros;
        }
      }  
    }    
	
    foreach ($this->aOrdem as $sTipo => $aOrdens) {
      foreach ($aOrdens as $iIndice => $oOrdem) {    	
        if ( $sTipo == $sTipoRel ) {
          $aOrdem[] = $oOrdem;
        }
      }
    }  
    
    foreach ($this->aAgrupamento as $sTipo => $aAgrupamentos) {
      foreach ($aAgrupamentos as $iIndice => $oAgrupamento) {    	
        if ( $sTipo == $sTipoRel ) {
          $aAgrupamento[] = $oAgrupamento;
        }
      }
    }      
        
    
    $this->aConsulta[$sTipoRel]['Select'] = $aConsulta;    
    $this->aConsulta[$sTipoRel]['From']   = $sSqlFrom;
    $this->aConsulta[$sTipoRel]['Where']  = $aFiltro;
    $this->aConsulta[$sTipoRel]['Group']  = $aAgrupamento;
    $this->aConsulta[$sTipoRel]['Order']  = $aOrdem;
    
  }
  
  
  
  
  public function getBuffer(){
  	return $this->sBuffer;
  }  
  
  public function getBufferAgt(){
  	return $this->sBufferAgt;
  }
  
  
  public function buildXML() {
	
  	if (empty($this->aPropriedades)) {
      throw new Exception("Construção do XML abortada, propriedades do relatório não definidas");  		
  	}
    if (empty($this->aColunas)){
      throw new Exception("Construção do XML abortada, colunas do relatório não definidas");    	
    }
    if (empty($this->aConsulta)){
       throw new Exception("Construção do XML abortada, consulta não definida");
    }
	
  	$this->sBuffer    = "";
  	$this->oXmlWriter = new XMLWriter();
  	$this->oXmlWriter->openMemory();
  	$this->oXmlWriter->setIndent(true);
  	$this->oXmlWriter->startDocument('1.0','ISO-8859-1');
  	$this->oXmlWriter->endDtd();
  	
  	// Início XML
  	$this->oXmlWriter->startElement('Relatorio');

  	
  	// Versão DBRelatório
  	$this->oXmlWriter->writeElement("Versao",self::VERSAOXML);
  	 	
    
  	
  	// Propriedades do Relatório
	
    $this->aPropriedades->toXml($this->oXmlWriter);				

    
	// Cabeçalho do Relatório
	$this->oXmlWriter->writeElement("Cabecalho",$this->sCabecalho);
	
	
	// Rodapé do Relatório
  	$this->oXmlWriter->writeElement("Rodape",$this->sRodape);
  	
  	
  	// Monta Variáveis 
  	if (!empty($this->aVariaveis)) {
  		
  	  $this->oXmlWriter->startElement('Variaveis');
  	  
  	  foreach ($this->aVariaveis as $sNomeVariavel => $oVariavel){
  	    $oVariavel->toXml($this->oXmlWriter); 
      }
      
  	  $this->oXmlWriter->endElement();//Variaveis
  		
  	}

  	
  	
  	// Monta Campos
  	$this->oXmlWriter->startElement('Campos');
    
  	foreach ($this->aColunas as $sTipo => $aColunas){
  	  foreach ($aColunas as $iIndice => $oColunas) {  		
	    $oColunas->toXml($this->oXmlWriter);
  	  }
  	}
  	
  	$this->oXmlWriter->endElement();//Campos
  	
	
  	// Monta Consultas (Query)
  	$this->oXmlWriter->startElement('Consultas');
	
  	foreach ( $this->aConsulta as $sTipo => $aConsulta ){
		
	  $this->oXmlWriter->startElement('Consulta');
	  $this->oXmlWriter->writeAttribute("tipo",$sTipo);
	  
	  foreach ($aConsulta as $sTagQuery => $aValores){
	  	
		switch ($sTagQuery){
			
		  case "Select":
		  	
		  	$this->oXmlWriter->startElement('Select');
		  	
			foreach ( $aValores as $iIndice => $oConsulta) {
			  $this->oXmlWriter->startElement('Campo');
  			  $this->oXmlWriter->writeAttribute("id",$oConsulta);
  			  $this->oXmlWriter->endElement();				
		  	}
		  	
			$this->oXmlWriter->endElement();
					  	
		  break;
		  
		  case "From":
			$this->oXmlWriter->writeElement("From",$aValores);
		  break;
		  
		  case "Where":
		  	
			if(!empty($aValores)){
				
		  	  $this->oXmlWriter->startElement('Where');
	
			  foreach ( $aValores as $iIndice => $oFiltro ) {
			     $oFiltro->toXml($this->oXmlWriter);	
		  	  }
		  	  
			  $this->oXmlWriter->endElement();
			  
			} else {
			  $this->oXmlWriter->writeElement("Where");				
			}
			
		  break;

		  case "Order":
		  	
			if(!empty($aValores)){
				
		  	  $this->oXmlWriter->startElement('Order');
			  foreach ( $aValores as $iIndice => $oOrdem ) {
			  	 $oOrdem->toXml($this->oXmlWriter);
		  	  }
		  	  
			  $this->oXmlWriter->endElement();
			  
			} else {
			  $this->oXmlWriter->writeElement("Order","");				
			}
						
		  break;
		  
	  	  case "Group":
	  	  	
			if(!empty($aValores)){
				
		  	  $this->oXmlWriter->startElement('Group');
		  	  		  
		  	  foreach ( $aValores as $iIndice => $oAgrupamento ) {
				$this->oXmlWriter->startElement('Campo');
	  			$this->oXmlWriter->writeAttribute("id",$oAgrupamento);				
			    $this->oXmlWriter->endElement();
		  	  }
		  	  
			  $this->oXmlWriter->endElement();
			  
			} else {
			  $this->oXmlWriter->writeElement("Group","");
			}
				
		  break;			
		}
					  	
	  }
	  
	  $this->oXmlWriter->endElement();//Consulta
	  
	}
	
	$this->oXmlWriter->endElement();//Consultas
	$this->oXmlWriter->endElement();//Relatorio

	// Fim XML
    $this->sBuffer .= $this->oXmlWriter->outputMemory();
    
  }
  
  
  public function converteAgt($sXml) {
  	
    if (empty($sXml)){
       throw new Exception("Conversão para AGT abortada, nenhum xml encontrado!");
    }


    $oXmlWriter = new XMLWriter();
    $oDomXml	= new DOMDocument();
    
    $oDomXml->loadXML($sXml);
    
    $aPropriedades = $oDomXml->getElementsByTagName('Propriedades');
    $aCabecalho	   = $oDomXml->getElementsByTagName("Cabecalho");
	$aRodape	   = $oDomXml->getElementsByTagName("Rodape");
	$aVariavel	   = $oDomXml->getElementsByTagName("Variavel");
	$aConsulta	   = $oDomXml->getElementsByTagName("Consulta");
	$aCampos	   = $oDomXml->getElementsByTagName("Campos");
	
    foreach ($aCampos as $oCampos){	
    	$aCampo	= $oCampos->getElementsByTagName("Campo");
    }	
    
    
  	$oXmlWriter->openMemory();
  	$oXmlWriter->setIndent(true);
  	$oXmlWriter->startDocument('1.0');
  	$oXmlWriter->endDtd();
  	
  	$oXmlWriter->startElement("Report");
  	
  	foreach ($aPropriedades as $oPropriedades) {
  		
  	  if ($oPropriedades->getAttribute('orientacao') == "landscape"){
  	  	$sCabecalho = '	#sety020
						#tab040
						#image $db_logo
						#sety020
						#setfaw10
						#setspace012
						#tab120$db_nomeinst
						#setfai10
						#tab120$db_enderinst
						#tab120$db_municinst - $db_ufinst
						#tab120$db_foneinst
						#tab120$db_emailinst
						#tab120$db_siteinst
						#sety100
						#tab40 #lineH770
						#sety020
						#tab610#rect*000*000*200*080*1*#e7e7e7*#000000
						#setfan07
						#sety025
						#tab620$head1
						#sety035
						#tab620$head2	
						#sety045
						#tab620$head3
						#sety055
						#tab620$head4
						#sety065
						#tab620$head5
						#sety075
						#tab620$head6
						#sety085
						#tab620$head7
						#sety095
						#tab005	';
  	  	$sRodape 	= ' #setfai07
						#tab40 
						#lineH770

						#setfan06
						#tab040 Base: $db_base  #tab260$db_programa  Emissor: $db_nomeusu  Exercício: $db_anousu  Data: $db_datausu  Hora: $db_horausu  #tab745 Página: $page de {nb}'; 
  	  } else {
  	  	$sCabecalho = ' #sety010
						#tab020
						#image $db_logo
						#sety010
						#setfaw10
						#setspace012
						#tab100$db_nomeinst
						#setfai10
						#tab100$db_enderinst
						#tab100$db_municinst - $db_ufinst
						#tab100$db_foneinst
						#tab100$db_emailinst
						#tab100$db_siteinst
						#sety90
						#tab20 #lineH500
						#sety010
						#tab375#rect*000*000*200*080*1*#e7e7e7*#000000
						#setfan07
						#sety020
						#tab385$head1
						#sety030
						#tab385$head2
						#sety040
						#tab385$head3
						#sety050
						#tab385$head4
						#sety060
						#tab385$head5
						#sety070
						#tab385$head6
						#sety080
						#tab385$head7
						#sety090
						#tab005';
  	  	$sRodape 	= ' #tab020
						#lineH550

						#setfan06
						#tab020 Base: $db_base  #tab165$db_programa    Emissor: $db_nomeusu    Exercício: $db_anousu    Data: $db_datausu    Hora: $db_horausu  #tab510 Página: $page de {nb}';  	  	
  	  }
  		
  		
  	  //Version
      $oXmlWriter->writeElement("Version",$oPropriedades->getAttribute('versao'));
      //Properties
      $oXmlWriter->startElement("Properties");
        $oXmlWriter->writeElement("Description","");
        $oXmlWriter->writeElement("Title",utf8_decode($oPropriedades->getAttribute('nome')));
        $oXmlWriter->writeElement("Author","");
        $oXmlWriter->writeElement("Keywords","");
        $oXmlWriter->writeElement("Date","");
        $oXmlWriter->writeElement("FrameSize","");
        $oXmlWriter->writeElement("Layout",utf8_decode($oPropriedades->getAttribute('layout')));
        $oXmlWriter->writeElement("UseTemplates","");
      $oXmlWriter->endElement();//Properties
  	}

  	
    foreach ($aCabecalho as $oCabecalho){
      $oXmlWriter->startElement("Header");
        $oXmlWriter->writeElement("Body",$sCabecalho);
        $oXmlWriter->writeElement("Align","center");
      $oXmlWriter->endElement();//Header
    }
    
    foreach ($aRodape as $oRodape){
      $oXmlWriter->startElement("Footer");
        $oXmlWriter->writeElement("Body",$sRodape);
        $oXmlWriter->writeElement("Align","center");
      $oXmlWriter->endElement();//Footer
    }
    
   
    if(!empty($aVariavel)){
      $oXmlWriter->startElement("Parameters");
	    foreach ($aVariavel as $oVariavel){
 	      $oXmlWriter->startElement(str_replace("$","",utf8_decode($oVariavel->getAttribute('nome'))));
      	    $oXmlWriter->writeElement("mask","");
      	    $oXmlWriter->writeElement("value","");
      	    $oXmlWriter->writeElement("source","");
      	    $oXmlWriter->writeElement("label","");      	
          $oXmlWriter->endElement();//TagNomeVariavel   
	    }
      $oXmlWriter->endElement();//Parameters    
    }
    
	foreach ($aConsulta as $oConsulta) {
		
	  if ($oConsulta->getAttribute('tipo') == "Principal"){

	  	$aSelect = $oConsulta->getElementsByTagName('Select');
	  	$aFrom   = $oConsulta->getElementsByTagName('From');
	  	$aWhere  = $oConsulta->getElementsByTagName('Where');
	  	$aGroup  = $oConsulta->getElementsByTagName('Group');
	  	$aOrder	 = $oConsulta->getElementsByTagName('Order');

	  	
	  	foreach ($aFrom as $oFrom){
	  	  $sFrom = $oFrom->nodeValue;	
	  	}
	  	
	  	$aTotalizador = array();
	  	$iIndiceCampo = 1;
	  	
	  	foreach ($aCampo as $oCampo){
	  	  	
	  	  $iIdCampo    = $oCampo->getAttribute('id');
	  	  $sNomeCampo  = $oCampo->getAttribute('nome');	
		  $sAliasCampo = $oCampo->getAttribute('alias');
		  
		  if ( $oCampo->getAttribute('totalizar') != "n" ) {
		  	
		  	if ($oCampo->getAttribute('totalizar') == "s") {
		  	  $aTotalizador[] = "sum({$iIndiceCampo})";
		  	} else if ($oCampo->getAttribute('totalizar') == "q") {
		  	  $aTotalizador[] = "count({$iIndiceCampo})"; 
		  	}
		  	 	
		  }
		  
	  	  foreach ($aSelect as $oSelect){
	  	    $aCampoSelect = $oSelect->getElementsByTagName('Campo');
	  	    foreach ($aCampoSelect as $oCampoSelect){
	  	  	  if ( $oCampoSelect->getAttribute('id') == $iIdCampo ) {
	  	  	  	 $aFields[] = $oCampo;
	  	    	 $sSelect[] = " {$sNomeCampo}".($sAliasCampo!=""?' as "'.$sAliasCampo.'" ':''); 
	  	  	  }	
	  	    }
	      }
	      
	      $sGroup = array();
	  	  foreach ($aGroup as $oGroup){

	  	    $aCampoGroup = $oGroup->getElementsByTagName('Campo');
	  	    foreach ($aCampoGroup as $oCampoGroup){
	  	  	  if ( $oCampoGroup->getAttribute('id') == $iIdCampo ) {
	  	    	 $sGroup[] = $sNomeCampo; 
	  	  	  }	
	  	    }
	      }
		  	      	  	
	      $sOrder = array();
	  	  foreach ($aOrder as $oOrder){
	  	    $aCampoOrdem = $oOrder->getElementsByTagName('Ordem');
	  	    foreach ($aCampoOrdem as $oCampoOrdem){
			  $sNomeCampo = $oCampoOrdem->getAttribute('nome');
			  $sAscDesc   = $oCampoOrdem->getAttribute('ascdesc');
			  $sOrder[]	  = "{$sNomeCampo} {$sAscDesc}";
	  	    }
	      }
	      
	      $iIndiceCampo++;
	  	}
	  	
	  	$sWhere = array();
	  	foreach ($aWhere as $oWhere){
	  	  $aCampoFiltro = $oWhere->getElementsByTagName('Filtro');
	  	  foreach ($aCampoFiltro as $oCampoFiltro){
	  	  	$sOperador  = $oCampoFiltro->getAttribute('operador');
 	  	    $sNomeCampo = $oCampoFiltro->getAttribute('campo');
	  	    $sCondicao  = $oCampoFiltro->getAttribute('condicao');
	  	  	$sValor     = $oCampoFiltro->getAttribute('valor');
	  	  	
	  	  	// Verifica primeira posição do where retirando o operador 
	  	    if(empty($sWhere)){
 	  	      $sOperador = "";
 	  	    }

  	        if ( trim($sValor)!= "" && is_string($sValor) && $sValor{0} != "$" ){
	  	      $sWhere[]  = $sOperador." ".$sNomeCampo." ".$sCondicao." '".$sValor."' ";
	  	    } else if (trim($sCondicao) == "in") {
 	  	      $sWhere[]  = $sOperador." ".$sNomeCampo." ".$sCondicao." (".$sValor.") ";
 	  	    } else {
   	  	      $sWhere[]  = $sOperador." ".$sNomeCampo." ".$sCondicao." ".$sValor." ";	
 	  	    }
	  	  }	
	  	} 
	 
	  	
    	$oXmlWriter->startElement("DataSet");
    	
      	  $oXmlWriter->startElement("DataSource");
      		$oXmlWriter->writeElement("Name","");
        	$oXmlWriter->writeElement("Remote","");
      	  $oXmlWriter->endElement();//DataSource
      	
      	  $oXmlWriter->writeElement("PreQuery","");
      	  $oXmlWriter->writeElement("PosQuery","");
      
      	  $oXmlWriter->startElement("Query");
      	    
      	    $oXmlWriter->writeElement("Select" ,utf8_decode(implode(",",$sSelect)));
            $oXmlWriter->writeElement("From"   ,utf8_decode($sFrom));
      	    $oXmlWriter->writeElement("Where"  ,utf8_decode(implode(" ",$sWhere)));
            $oXmlWriter->writeElement("GroupBy",utf8_decode(implode(",",$sGroup)));
      	    $oXmlWriter->writeElement("OrderBy",utf8_decode(implode(",",$sOrder)));
	
     	    $oXmlWriter->startElement("Config");
      	  	  $oXmlWriter->writeElement("Distinct","0");
          	  $oXmlWriter->writeElement("OffSet","0");
      	  	  $oXmlWriter->writeElement("Limit","0");  			                
            $oXmlWriter->endElement();//Config
          $oXmlWriter->endElement();//Query      
    
    
      	  $oXmlWriter->startElement("Groups");
        	$oXmlWriter->startElement("Config");
          	  $oXmlWriter->writeElement("ShowGroup","");
          	  $oXmlWriter->writeElement("ShowDetail","1");
          	  $oXmlWriter->writeElement("ShowLabel","");
          	  $oXmlWriter->writeElement("ShowNumber","1");
          	  $oXmlWriter->writeElement("ShowIndent","1");           			                
          	  $oXmlWriter->writeElement("ShowHeader","");
        	$oXmlWriter->endElement();//Config
  	       
            if(!empty($aTotalizador)){
              $oXmlWriter->startElement("Formulas");
                $oXmlWriter->writeElement("Group0",implode(",",$aTotalizador));
              $oXmlWriter->endElement();//Formulas
            }  
      	  $oXmlWriter->endElement();//Groups
    	  
      	  
      	  $oXmlWriter->startElement("Fields");
	      	foreach ($aFields as $iInd =>$oFields){
              $oXmlWriter->startElement("Column".($iInd+1));
          	    $oXmlWriter->writeElement("Chars" ,($oFields->getAttribute('largura')/2));
          	    $oXmlWriter->writeElement("Points",$oFields->getAttribute('largura'));
          	    switch ($oFields->getAttribute('alinhamento')){
	      			case "c":
	      			  $sAlign = "center";
	      			break;
	      			case "l":
	      			  $sAlign = "left";	
	      			break;
	      			case "r":
	      			  $sAlign = "right";	
	      			break;
	      		}
	      		
          	    $oXmlWriter->writeElement("Align",$sAlign);
          	    switch ($oFields->getAttribute('alinhamentocab')){
	      			case "c":
	      			  $sAlignCab = "center";
	      			break;
	      			case "l":
	      			  $sAlignCab = "left";	
	      			break;
	      			case "r":
	      			  $sAlignCab = "right";	
	      			break;
	      		}
	      		          	    
          	    $oXmlWriter->writeElement("HeadAlign",$sAlignCab);
          	    
				$sMascara = "";
				$sFuncao  = "";
				          	    
          	    switch ($oFields->getAttribute('mascara')) {
          	      case "m":
          	       $sMascara = "#  -9.999,99s";          	    		
          	      break;
          	      case "d":
				   $sFuncao = "/dbseller/a_formata_data.fun";          	    		
          	      break;	
          	    }
          	    
          	    $oXmlWriter->writeElement("Mask",$sMascara);
          	    $oXmlWriter->writeElement("Function",$sFuncao);
          	    $oXmlWriter->writeElement("Cross","");
          	    $oXmlWriter->writeElement("Conditional","");
          	    $oXmlWriter->writeElement("Hidden","");                        
              $oXmlWriter->endElement();//Column
	      	}
      	  $oXmlWriter->endElement();//Fields  
        $oXmlWriter->endElement();//DataSet
	  }
	}
    
    
	foreach ($aPropriedades as $oPropriedades) {
      $oXmlWriter->startElement("PageSetup");    
        $oXmlWriter->writeElement("Format",$oPropriedades->getAttribute('formato'));
        $oXmlWriter->writeElement("Orientation",$oPropriedades->getAttribute('orientacao'));
        $oXmlWriter->writeElement("LeftMargin",$oPropriedades->getAttribute('margemesq'));
        $oXmlWriter->writeElement("RightMargin",$oPropriedades->getAttribute('margemdir'));
        $oXmlWriter->writeElement("TopMargin",$oPropriedades->getAttribute('margemsup'));
        $oXmlWriter->writeElement("BottonMargin",$oPropriedades->getAttribute('margeminf'));      
        $oXmlWriter->writeElement("LineSpace","");     
      $oXmlWriter->endElement();//PageSetup
	}
    
    $oXmlWriter->startElement("Graph");    
    
      $oXmlWriter->writeElement("Title","");
      $oXmlWriter->writeElement("TitleX","");
      $oXmlWriter->writeElement("TitleY","");
      $oXmlWriter->writeElement("With","");
      $oXmlWriter->writeElement("Height","");
      $oXmlWriter->writeElement("Description","");      
      $oXmlWriter->writeElement("ShowData","");     
      $oXmlWriter->writeElement("ShowValues","");
      $oXmlWriter->writeElement("Orientation","");            
      $oXmlWriter->writeElement("PlottedColumns","");
      $oXmlWriter->writeElement("Legend","");            
    $oXmlWriter->endElement();//Graph    
    
    
    
    $oXmlWriter->startElement("Merge");
      
      $oXmlWriter->writeElement("ReportHeader","");
      
      $oXmlWriter->startElement("Details");
         $oXmlWriter->startElement("Detail1");
            
         	$oXmlWriter->writeElement("GroupHeader","");
            $oXmlWriter->writeElement("Body","");
            
            $oXmlWriter->startElement("DataSet");
              $oXmlWriter->startElement("Query");
              
		      	$oXmlWriter->writeElement("Select","");
		        $oXmlWriter->writeElement("From","");
		      	$oXmlWriter->writeElement("Where","");
		        $oXmlWriter->writeElement("GroupBy","");
		      	$oXmlWriter->writeElement("OrderBy","");
		  		
		      	$oXmlWriter->startElement("Config");
		      	  $oXmlWriter->writeElement("Distinct","1");
		          $oXmlWriter->writeElement("OffSet","0");
		      	  $oXmlWriter->writeElement("Limit","0");  			                
		        $oXmlWriter->endElement();//Config
	  			
              $oXmlWriter->endElement();//Query
              
              $oXmlWriter->writeElement("Fields","");
              
         	$oXmlWriter->endElement();//DataSet
         	
         	$oXmlWriter->writeElement("GroupFooter","");
         	
         $oXmlWriter->endElement();//Detail1
      $oXmlWriter->endElement();//Details   
    
      $oXmlWriter->writeElement("ReportFooter","");
      $oXmlWriter->writeElement("PageSetup","");
     
      $oXmlWriter->startElement("Config");
        $oXmlWriter->writeElement("RepeatHeader","");
        $oXmlWriter->writeElement("ShowFooter","");
      $oXmlWriter->endElement();//Config
    
    $oXmlWriter->endElement();//Merge
    
    
    $oXmlWriter->startElement("Label");
      $oXmlWriter->writeElement("Body","");
      $oXmlWriter->startElement("Config");
        $oXmlWriter->writeElement("HorizontalSpacing","15");
        $oXmlWriter->writeElement("VerticalSpacing","0");
        $oXmlWriter->writeElement("LabelWidth","288");
        $oXmlWriter->writeElement("LabelHeight","72");
        $oXmlWriter->writeElement("LeftMargin","11");
        $oXmlWriter->writeElement("TopMargin","36");
        $oXmlWriter->writeElement("Columns","2");
        $oXmlWriter->writeElement("Rows","10");
        $oXmlWriter->writeElement("PageFormat","A3");
        $oXmlWriter->writeElement("LineSpacing","14");
      $oXmlWriter->endElement();//Config
    $oXmlWriter->endElement();//Label
    
    
    
    $oXmlWriter->startElement("OpenOffice");
      $oXmlWriter->writeElement("Source","");
      $oXmlWriter->startElement("Config");
        $oXmlWriter->writeElement("FixedDetails","1");
        $oXmlWriter->writeElement("ExpandDetails","");
        $oXmlWriter->writeElement("printEmptyDetail","1");
        $oXmlWriter->writeElement("SumByTotal","1");
        $oXmlWriter->writeElement("RepeatHeader","1");
        $oXmlWriter->writeElement("RepeatFooter","1");
      $oXmlWriter->endElement();//Config
    $oXmlWriter->endElement();//OpenOffice 
    
    $oXmlWriter->endElement();//Report
	
 	$this->sBufferAgt = $oXmlWriter->outputMemory();
    
  }
	
  public function geraArquivoAgt($DBXml=""){
  	
  	$lErro = false;
  	
  	if (empty($DBXml)) {
  	
  	  // Cria DBXML
  	  try {
  	    $this->buildXML();
  	  } catch (Exception $e){
  	    $lErro 	= true;
  	    $sMsgErro = $e->getMessage();
      }
  	
  	  if($lErro){
  	    throw new Exception($sMsgErro);
   	  }
  	
   	  $DBXml = $this->getBuffer();
   	  
  	}
  	
  	
  	// Cria AGT
  	try {	
  	  $this->converteAgt($DBXml);
  	} catch (Exception $e){
  	  $lErro 	= true;
  	  $sMsgErro = $e->getMessage();  	 	
  	}
  	
    if($lErro){
  	  throw new Exception($sMsgErro);
  	}  	
  	
  	$sArquivoAgt       = "geraRelatorio".date("YmdHis").db_getsession("DB_id_usuario").".agt";
	$sCaminhoRelatorio = "tmp/".$sArquivoAgt;
	$rsRelatorioTemp   = fopen($sCaminhoRelatorio,"w");
	
	fputs($rsRelatorioTemp ,$this->sBufferAgt);
	fclose($rsRelatorioTemp );
	
	return $sCaminhoRelatorio;
  	
  }
  

  
  
  
  
  
}
