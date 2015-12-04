<?

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("model/dbGeradorRelatorio.model.php");
require_once("model/dbColunaRelatorio.php");
require_once("model/dbFiltroRelatorio.php");
require_once("model/dbOrdemRelatorio.model.php");
require_once("model/dbPropriedadeRelatorio.php");
require_once("model/dbVariaveisRelatorio.php");
require_once("classes/db_db_relatorio_classe.php");
require_once("classes/db_db_relatoriousuario_classe.php"); 
require_once("classes/db_db_relatoriodepart_classe.php");
require_once("classes/db_db_geradorrelatoriotemplate_classe.php");

$oPost  = db_utils::postMemory($_POST);

if (!isset($_SESSION['objetoXML'])) {
  $oXML = new dbGeradorRelatorio();
}else{
  $oXML = unserialize($_SESSION['objetoXML']); 
}

$oJson  = new services_json();


  if ( $oPost->tipo == "consultaView" ) {
	
  	$aRetornaCampos = array();
  	
    $sSqlConsultaCampos  = " select db_syscampo.codcam, 															  ";
    $sSqlConsultaCampos .= " 	    db_syscampo.nomecam,  															  ";    
    $sSqlConsultaCampos .= " 	    db_syscampo.rotulorel as rotulo, 												  ";
    $sSqlConsultaCampos .= " 	    db_syscampo.aceitatipo,  														  ";    
    $sSqlConsultaCampos .= " 	    db_syscampo.nulo, 																  ";    
    $sSqlConsultaCampos .= " 	    db_syscampo.conteudo  															  ";    
    $sSqlConsultaCampos .= "   from pg_class  																		  ";
    $sSqlConsultaCampos .= "        inner join pg_attribute on pg_attribute.attrelid 	 = pg_class.oid 			  ";
    $sSqlConsultaCampos .= "        inner join db_syscampo  on trim(db_syscampo.nomecam) = trim(pg_attribute.attname) ";
    $sSqlConsultaCampos .= "  where pg_class.relkind = 'v'::\"char\" 											 	  ";
    $sSqlConsultaCampos .= "    and pg_class.relname = '{$oPost->view}'												  ";
    $sSqlConsultaCampos .= "  order by pg_class.oid											 						  ";    
   							  
   
    $rsConsultaCampos  = pg_query($sSqlConsultaCampos) or die($sSqlConsultaCampos);
    $iNroLinhas        = pg_num_rows($rsConsultaCampos);
    
    if ( $iNroLinhas > 0 ) {
	
   	  $aRetornaCampos = db_utils::getColectionByRecord($rsConsultaCampos,false,false,true);

    } else {
    	
      $sMensagem 	  = "Campos não encontrados";
      $iStatus   	  = 2;
      $aRetornaCampos = array("iStatus"=>$iStatus, "sMensagem"=>urlencode($sMensagem));
      
    } 
    
    echo $oJson->encode($aRetornaCampos);

    
    
    
  //************************************************************************************************************************//  
  // Inclui colunas e seus atributos    
  //************************************************************************************************************************//    
    
  } else if ($oPost->tipo == "incluirCampos") {

	$aObjCampos = $oJson->decode(str_replace("\\","",$oPost->aObjCampos));

	foreach ($aObjCampos as $oCampos){
		
	  $oColunaRelatorio = new dbColunaRelatorio($oCampos->codcam,$oCampos->nomecam,$oCampos->rotulo,10,"c","c","","n");
	  
	  $oXML->addColuna($oColunaRelatorio);

	  $oRetornoColuna = new stdClass();
	  
  	  $oRetornoColuna->iId       		= urlencode($oColunaRelatorio->getId());
	  $oRetornoColuna->sNome    		= urlencode($oColunaRelatorio->getNome());  	    	  
      $oRetornoColuna->sAlias    		= urlencode($oColunaRelatorio->getAlias());	
      $oRetornoColuna->iLargura  	    = urlencode($oColunaRelatorio->getLargura());
  	  $oRetornoColuna->sAlinhamento 	= urlencode($oColunaRelatorio->getAlinhamento());
	  $oRetornoColuna->sAlinhamentoCab  = urlencode($oColunaRelatorio->getAlinhamentoCab()); 
	  $oRetornoColuna->sMascara 	    = urlencode($oColunaRelatorio->getMascara());
	  $oRetornoColuna->sTotalizar 	    = urlencode($oColunaRelatorio->getTotalizar());

	  
	  $aRetornaCampos[] = $oRetornoColuna;
	  
	}
	
	$_SESSION['objetoXML'] = serialize($oXML);
	

	echo $oJson->encode($aRetornaCampos);
	
	
	
	
  //************************************************************************************************************************//
  // Altera uma coluna do relatório	
  //************************************************************************************************************************//
  	
	
	
  } else if ($oPost->tipo == "alterarCampos") {
  	
  	$aReplace = array("\\","(",")");
  	
  	$objCampo = $oJson->decode(str_replace($aReplace,"",$oPost->objCampo));
  	
  	echo urldecode($objCampo->sAlias)."\n";
  	
  	$oColuna  = new dbColunaRelatorio( $objCampo->iId,
  	                                   $objCampo->sNome,
  	                                   $objCampo->sAlias,
  	                                   $objCampo->iLargura,
  	                                   $objCampo->sAlinhamento,
  	                                   $objCampo->sAlinhamentoCab,
  	                                   $objCampo->sMascara,
  	                                   $objCampo->sTotalizar);
    
    $oXML->addColuna($oColuna);
       		
  	$_SESSION['objetoXML'] = serialize($oXML);
	
  	
  	
  //************************************************************************************************************************//
  // Exclui uma coluna do relatório	
  //************************************************************************************************************************//
  	
  	
  } else if ($oPost->tipo == "excluirCampos") {

  	
  	$aCampos = split(",",$oPost->aCampos);
  	
  	foreach ( $aCampos as $sNomeCampo){
 	  unset($oXML->aColunas["Principal"][$sNomeCampo]);	
  	}
  	
  	$_SESSION['objetoXML'] = serialize($oXML);
  	
  	
  	
  //************************************************************************************************************************//  	
  // Inclui um filtro no relatório	
  //************************************************************************************************************************//
    	
  } else if ($oPost->tipo == "incluirFiltro") {

  	
   	if ($oPost->tipoCampo == "date"){
	  $aData  = explode("/",$oPost->sValor);
	  $sValor = implode("-",array_reverse($aData));  				
  	} else {
  	  $sValor = $oPost->sValor; 	
  	}
  	
  	switch ($oPost->sCondicao){
  	  case "Igual":
  		$sCond = " = ";  
  	  break;
  	  case "Diferente":
  	  	$sCond = " <> ";
  	  break;
  	  case "Maior":
  	  	$sCond = " > ";
  	  break;
  	  case "Menor":
  	  	$sCond = " < ";
  	  break;
  	  case "MaiorIgual":
  	  	$sCond = " >= ";
  	  break;
  	  case "MenorIgual":
  	  	$sCond = " <= ";
  	  break;
  	  case "Contendo":
  	  	$sCond  = " in ";
  	  break;
  	  case "Nulo":
  	  	$sCond = " is null ";
  	  break;
  	  case "Preenchido":
  	  	$sCond = " is not null ";
  	  break;
  	}
  	
  	$oFiltroRelatorio = new dbFiltroRelatorio($oPost->sCampo,utf8_decode($sCond),utf8_decode($sValor),$oPost->sOperador);
  	
  	$oXML->addFiltro($oFiltroRelatorio);
  	
  	$oFiltros = new stdClass();
  	
  	$oFiltros->sCampo 	  = $oFiltroRelatorio->getCampo();
  	$oFiltros->sCondicao  = $oFiltroRelatorio->getCondicao();	
	$oFiltros->sOperador  = $oFiltroRelatorio->getOperador();  	    	  
  	$oFiltros->sValor     = $oPost->sValor;	
	
  	$aFiltros[] = $oFiltros;
  	
  	$_SESSION['objetoXML'] = serialize($oXML);
  	
	echo $oJson->encode($aFiltros);


		
	
  //************************************************************************************************************************//
  // Exclui um filtro do relatório
  //************************************************************************************************************************//	
  	
  } else if ($oPost->tipo == "excluirFiltro") {
    
	
	$aObjFiltros = $oJson->decode(str_replace("\\","",$oPost->aObjFiltros));

	
	foreach ($aObjFiltros as $sInd => $oFiltros){
	  unset($oXML->aFiltros["Principal"]["{$oFiltros->sCampo}{$oFiltros->sCondicao}{$oFiltros->sValor}"]);
	}

	
	$_SESSION['objetoXML'] = serialize($oXML);

		

	
  //************************************************************************************************************************//  
  // Inclui variáveis    
  //************************************************************************************************************************//    
    
  } else if ($oPost->tipo == "incluirVariaveis") {

  	
	$oPostVariavel = $oJson->decode(str_replace("\\","",$oPost->objVariavel));

	$oVariavel = new dbVariaveisRelatorio( $oPostVariavel->sNome,
	  								       $oPostVariavel->sLabel,
										   $oPostVariavel->sValor);	
	  
	$oXML->addVariavel($oPostVariavel->sNome,$oVariavel);
	
    $oRetornoVariavel = new stdClass();
	$oRetornoVariavel->sNome  = $oVariavel->getNome();
	$oRetornoVariavel->sLabel = $oVariavel->getLabel();
	$oRetornoVariavel->sValor = $oVariavel->getValor();
	  
    $aRetornaVariaveis[] = $oRetornoVariavel;
	  
	$_SESSION['objetoXML'] = serialize($oXML);

	echo $oJson->encode($aRetornaVariaveis);
	
	
  //************************************************************************************************************************//  
  // Exclui variáveis    
  //************************************************************************************************************************//    
    
  } else if ($oPost->tipo == "excluirVariaveis") {

	  	
  	$aReplace = array("\\","(",")");
	$aPostVar = $oJson->decode(str_replace($aReplace	,"",$oPost->aObjVariavel));
	
	foreach ( $aPostVar as $sInd => $oPostVariavel ) {
	  unset($oXML->aVariaveis[$oPostVariavel->sNome]);
	}
	
	$_SESSION['objetoXML'] = serialize($oXML);
	
	
	

  //************************************************************************************************************************//	
  // Incluir as propriedades do relatório
  //************************************************************************************************************************//	
	
  } else if ($oPost->tipo == "incluirPropriedades") {	
	
	
  	$objPostPropriedades = $oJson->decode(str_replace("\\","",$oPost->objPropriedades));

  	
	$oPropriedades = new dbPropriedadeRelatorio( utf8_decode($objPostPropriedades->sNome),
												 $objPostPropriedades->iVersao,
												 $objPostPropriedades->sLayout,
												 $objPostPropriedades->sFormato,
												 $objPostPropriedades->sOrientacao,
												 $objPostPropriedades->iMargemSup,
												 $objPostPropriedades->iMargemInf,
												 $objPostPropriedades->iMargemEsq,
												 $objPostPropriedades->iMargemDir);

	$oXML->addPropriedades($oPropriedades);
	
	$_SESSION['objetoXML'] = serialize($oXML);

	
  //************************************************************************************************************************//	
  // Incluir ordem do relatório
  //************************************************************************************************************************//	
	
  } else if ($oPost->tipo == "incluirOrdem") {	
	
  	
  	$aReplace = array("\\","(",")");
	$aObjCampos = $oJson->decode(str_replace($aReplace,"",$oPost->aObjCampos));
	
	if (isset($oXML->aOrdem["Principal"])) {
	  unset($oXML->aOrdem["Principal"]);
	}
	
	foreach ($aObjCampos as $sInd => $oCampos){
	  
	  $oOrdemRelatorio = new dbOrdemRelatorio($oCampos->iId,$oCampos->sNome,$oCampos->sAscDesc,utf8_decode($oCampos->sAlias));
	  $oXML->addOrdem($oOrdemRelatorio);
	  
	  $aRetornaOrdem[] = $oOrdemRelatorio;
	  
	}
	
	$_SESSION['objetoXML'] = serialize($oXML);
	
	var_dump($oXML);
	
	
	
  //************************************************************************************************************************//
  // Visualiza um relatório apartir do objeto em sessão, sem salvar nada no banco	
  //************************************************************************************************************************//
  	
  } else if ($oPost->tipo == "visualizarRelatorio") {
	
	$lErro = false; 
	
	try {
	  $oXML->addConsulta($oPost->view);
	} catch (Exception $e){
  	  $sMsgErro = $e->getMessage();
  	  $lErro = true;
	}
	
	try {
	  $oXML->buildXML();
	} catch (Exception $e){
  	  $sMsgErro = $e->getMessage();
  	  $lErro = true;
	}
	 
	
	if (!$lErro) {
		
	  
	  $oXML->converteAgt($oXML->getBuffer());
		
	  $sArquivo   	     = "geraRelatorio".date("YmdHis").db_getsession("DB_id_usuario").".agt";
	  $sCaminhoRelatorio = "tmp/".$sArquivo;
	
	  $rsRelatorioTemp   = fopen($sCaminhoRelatorio,"w");
    
	  fputs($rsRelatorioTemp ,$oXML->getBufferAgt());
	  fclose($rsRelatorioTemp );

	  
	  $aObjVariaveis = $oXML->getVariaveis();
	  $aVariaveis	 = array();
	  
	  foreach ($aObjVariaveis as $sNome => $oVariavel){
	    
	  	$oRetornoVariavel = new stdClass();
	    $oRetornoVariavel->sNome  = $oVariavel->getNome();
	    $oRetornoVariavel->sLabel = $oVariavel->getLabel();
	    $oRetornoVariavel->sValor = $oVariavel->getValor();
	  
	    $aVariaveis[] = $oRetornoVariavel;
	    
	  }

	  
	  
	  
	  $aRetorno = array("caminho"=>$sCaminhoRelatorio,"erro"=>false,"variaveis"=>$aVariaveis);
	  	
	} else {
		
	  $aRetorno = array("msg"=>urlencode($sMsgErro)  ,"erro"=>true);
	  
	}
	
	echo $oJson->encode($aRetorno);
	
	
	
	
  //************************************************************************************************************************//
  // Inclui o relatório no banco
  //************************************************************************************************************************//
  	
  } else if ($oPost->tipo == "salvarRelatorio") {
	
	$cldb_relatorio 	   = new cl_db_relatorio();
	$cldb_relatoriousuario = new cl_db_relatoriousuario();
	$cldb_relatoriodepart  = new cl_db_relatoriodepart();
	
	$lErro = false;
	
	// Retira alias dos campos do relatório
	if( $oPost->tipoRelatorio == 2 ){
	  $oXML->converteColunaDocumento($oXML->getColunas());
	}
	
	try {
	  $oXML->addConsulta($oPost->view);
	} catch (Exception $e){
  	  $sMsgErro = $e->getMessage();
  	  $lErro = true;
	}
	
	try {
	  $oXML->buildXML();
	} catch (Exception $e){
  	  $sMsgErro = $e->getMessage();
  	  $lErro = true;
	}
  	  
	$aObjVariaveis = $oXML->getVariaveis();
	$aVariaveis	   = array();
	
	foreach ($aObjVariaveis as $sNome => $oVariavel){
	    
	  $oRetornoVariavel = new stdClass();
	  $oRetornoVariavel->sNome  = $oVariavel->getNome();
	  $oRetornoVariavel->sLabel = $oVariavel->getLabel();
	  $oRetornoVariavel->sValor = $oVariavel->getValor();
	  
	  $aVariaveis[] = $oRetornoVariavel;
	    
	}
	
	$oPropriedades = $oXML->getPropriedades();
	
	if (trim($oPropriedades->getNome()) == ""){
	  $sMsgErro = "Inclusão abortada, favor incluir Nome do Relatório";
  	  $lErro    = true;
	}
		
	if (!$lErro) {
	  
	  db_inicio_transacao();
	
	  $cldb_relatorio->db63_db_gruporelatorio = $oPost->grupoRelatorio;
	  $cldb_relatorio->db63_db_tiporelatorio  = $oPost->tipoRelatorio;
	  $cldb_relatorio->db63_nomerelatorio	  = "{$oPropriedades->getNome()}";
	  $cldb_relatorio->db63_versao_xml		  = $oPropriedades->getVersao();
	  $cldb_relatorio->db63_data		  	  = date("Y-m-d",db_getsession("DB_datausu"));
	  $cldb_relatorio->db63_xmlestruturarel   = $oXML->getBuffer();
	  $cldb_relatorio->incluir(null);
	
	  if($cldb_relatorio->erro_status == 0){
	    $lErro = true;	
	    $sMsgErro = $cldb_relatorio->erro_msg;	
	  }
	
	  if (!$lErro) {
	  	  
	 	$cldb_relatoriousuario->db09_db_relatorio = $cldb_relatorio->db63_sequencial;
	  	$cldb_relatoriousuario->db09_db_usuarios  = db_getsession("DB_id_usuario");
	  	$cldb_relatoriousuario->incluir(null);
	  
	  	if($cldb_relatoriousuario->erro_status == 0){
	      $lErro = true;	
	      $sMsgErro = $cldb_relatoriousuario->erro_msg;	
        }

	    $cldb_relatoriodepart->db07_db_relatorio = $cldb_relatorio->db63_sequencial;
	    $cldb_relatoriodepart->db07_db_depart	 = db_getsession("DB_coddepto");
	    $cldb_relatoriodepart->incluir(null);
	  
	    if($cldb_relatoriodepart->erro_status == 0){
	      $lErro = true;	
	      $sMsgErro = $cldb_relatoriodepart->erro_msg;
        }
	  }

	  db_fim_transacao($lErro);	
	}
	
	if (!$lErro){
			
	  $oXML->converteAgt($oXML->getBuffer());
	  
	  $sArquivo 	     = "geraRelatorio".date("YmdHis").db_getsession("DB_id_usuario").".agt";
	  $sCaminhoRelatorio = "tmp/".$sArquivo;
	  $rsRelatorioTemp   = fopen($sCaminhoRelatorio,"w");
	  
	  
	  fputs($rsRelatorioTemp ,$oXML->getBufferAgt());
	  
	  fclose($rsRelatorioTemp );
	  
	  $aRetorno = array("caminho"=>$sCaminhoRelatorio,"erro"=>false,"variaveis"=>$aVariaveis);
	  echo $oJson->encode($aRetorno);
	  	
	} else {
	  
	  $aRetorno = array("msg"=>urlencode($sMsgErro),"erro"=>true);
	  echo $oJson->encode($aRetorno);
		
	}

 
    
  //************************************************************************************************************************//
  // Altera o registros do relatório no banco
  //************************************************************************************************************************//	
      
  } else if ($oPost->tipo == "alterarRelatorio") {

	
	$cldb_relatorio = new cl_db_relatorio();
	
	$lErro = false;
	
	try {
	  $oXML->addConsulta($oPost->view);
	} catch (Exception $e){
  	  $sMsgErro = $e->getMessage();
  	  $lErro = true;
	}
	
	try {
	  $oXML->buildXML();
	} catch (Exception $e){
  	  $sMsgErro = $e->getMessage();
  	  $lErro = true;
	}
	
  	$aObjVariaveis = $oXML->getVariaveis();
	$aVariaveis	   = array();
	
	foreach ($aObjVariaveis as $sNome => $oVariavel){
	    
	  $oRetornoVariavel = new stdClass();
	  $oRetornoVariavel->sNome  = $oVariavel->getNome();
	  $oRetornoVariavel->sLabel = $oVariavel->getLabel();
	  $oRetornoVariavel->sValor = $oVariavel->getValor();
	  
	  $aVariaveis[] = $oRetornoVariavel;
	    
	}
	
	
	
	$oPropriedades = $oXML->getPropriedades();
	
	if (trim($oPropriedades->getNome()) == ""){
	  $sMsgErro = "Inclusão abortada, favor incluir Nome do Relatório";
  	  $lErro    = true;
	}
		
	if (!$lErro) {
	  
	  db_inicio_transacao();
	
	  $cldb_relatorio->db63_db_gruporelatorio = $oPost->grupoRelatorio;
	  $cldb_relatorio->db63_db_tiporelatorio  = $oPost->tipoRelatorio;
	  $cldb_relatorio->db63_nomerelatorio	  = "{$oPropriedades->getNome()}";
	  $cldb_relatorio->db63_versao_xml		  = $oPropriedades->getVersao();
	  $cldb_relatorio->db63_data		  	  = date("Y-m-d",db_getsession("DB_datausu"));
	  $cldb_relatorio->db63_xmlestruturarel   = $oXML->getBuffer();
	  $cldb_relatorio->db63_sequencial		  = $oPost->codRelatorio;
	  $cldb_relatorio->alterar($oPost->codRelatorio);
									   
	  if($cldb_relatorio->erro_status == 0){
	    $lErro = true;	
	    $sMsgErro = $cldb_relatorio->erro_msg;	
	  }

	  db_fim_transacao($lErro);	
	}
	
	if (!$lErro){
		
	  $sCaminhoRelatorio = $oXML->geraArquivoAgt($oXML->getBuffer());
	  $aRetorno = array("caminho"=>$sCaminhoRelatorio,"erro"=>false,"variaveis"=>$aVariaveis);
		  	
	} else {
		
	  $aRetorno = array("msg"=>urlencode($sMsgErro),"erro"=>true);
	  
	}
 	
    echo $oJson->encode($aRetorno);

    
    
    
  //************************************************************************************************************************//
  // Exclui o relatório do banco
  //************************************************************************************************************************//    
    	
  } else if ($oPost->tipo == "excluirRelatorio") {	

    $cldb_relatorio 	   			= new cl_db_relatorio();
	$cldb_relatoriousuario 			= new cl_db_relatoriousuario();
	$cldb_relatoriodepart  			= new cl_db_relatoriodepart();
 	$cldb_geradorrelatoriotemplate  = new cl_db_geradorrelatoriotemplate();
	
 	$lSqlErro = false;
 	
 	db_inicio_transacao();
 	
 	$cldb_relatoriodepart->excluir(null," db07_db_relatorio = {$oPost->codRelatorio}");
 	
 	if ($cldb_relatoriodepart->erro_status == 0){
 	  $lSqlErro = true;
 	  $sMsgErro = urlencode($cldb_relatoriodepart->erro_msg); 
 	}
 	
 	
 	$cldb_relatoriousuario->excluir(null," db09_db_relatorio = {$oPost->codRelatorio}");
  	
 	if ($cldb_relatoriousuario->erro_status == 0){
 	  $lSqlErro = true;
 	  $sMsgErro = urlencode($cldb_relatoriousuario->erro_msg); 
 	}
	
 	
	$rsConsultaTemplate = $cldb_geradorrelatoriotemplate->sql_record($cldb_geradorrelatoriotemplate->sql_query(null,"db15_sequencial",null," db15_db_relatorio = {$oPost->codRelatorio}")); 
 	
	if ($cldb_geradorrelatoriotemplate->numrows > 0 ){
	  $oTemplate = db_utils::fieldsMemory($rsConsultaTemplate,0);
	  $cldb_geradorrelatoriotemplate->excluir($oTemplate->db15_sequencial);
	}
	
	$cldb_relatorio->excluir($oPost->codRelatorio);
  	
	if ($cldb_relatorio->erro_status == 0){
 	  $lSqlErro = true;
 	  $sMsgErro = urlencode($cldb_relatorio->erro_msg); 
 	}
	
	db_fim_transacao($lSqlErro);
	
 	if (!$lSqlErro){
	  $aRetorno = array("idRel"=>$oPost->codRelatorio,"erro"=>false);
	} else {
	  $aRetorno = array("msg"=>$sMsgErro,"erro"=>true);
	}
	
    echo $oJson->encode($aRetorno);	

    
    
    
  //************************************************************************************************************************//
  // Retorna as informações do relatório apartir do código e monta um objeto na sessão
  //************************************************************************************************************************//    
  
  } else if ($oPost->tipo == "carregaRelatorio") {	
	
 	
  	$aRetornaCampos    = array();
  	$aRetornaOrdem     = array();
 	$aRetornaFiltros   = array();
 	$aRetornoVariaveis = array();
  	
 	$cldb_relatorio = new cl_db_relatorio();

 	$oXML      = new dbGeradorRelatorio($oPost->codRelatorio);
 	$sNomeView = $oXML->aConsulta["Principal"]["From"];
 	
	$aColunas  = $oXML->getColunas();
 	foreach ($aColunas as $sNomeCampo => $oCampo) {
 	  $oRetornoColuna = new stdClass();
  	  $oRetornoColuna->iId       		= $oCampo->getId();
	  $oRetornoColuna->sNome    		= $oCampo->getNome();  	    	  
      $oRetornoColuna->sAlias    		= utf8_encode($oCampo->getAlias());	
      $oRetornoColuna->iLargura  	    = $oCampo->getLargura();
  	  $oRetornoColuna->sAlinhamento 	= $oCampo->getAlinhamento();
	  $oRetornoColuna->sAlinhamentoCab  = $oCampo->getAlinhamentoCab(); 
	  $oRetornoColuna->sMascara 	    = $oCampo->getMascara();
	  $oRetornoColuna->sTotalizar 	    = $oCampo->getTotalizar();
	  $aRetornaCampos[] = $oRetornoColuna;
 	}

 	
 	$aOrdens = $oXML->getOrdem();
 	
 	foreach ($aOrdens as $iInd => $aOrdem){
 	  foreach ($aOrdem as $sInd => $oOrdem){
 	    $aRetornaOrdem[] = $oOrdem;
 	  }
 	}
	
 	
	$aFiltros = $oXML->getFiltros();

 	foreach ($aFiltros as $iInd => $aFiltro){
 	  foreach ($aFiltro as $sInd => $oFiltro){
 	    $oRetornoFiltro = new stdClass();
 	    $oRetornoFiltro->sOperador = $oFiltro->getOperador();
 	    $oRetornoFiltro->sCampo    = $oFiltro->getCampo();
 	    $oRetornoFiltro->sCondicao = $oFiltro->getCondicao();
 	    $oRetornoFiltro->sValor	   = $oFiltro->getValor();
  	    $aRetornaFiltros[] = $oRetornoFiltro; 	
 	  }
 	}
 	
 	$oPropriedades = $oXML->getPropriedades();
	
	$oRetornoPropriedades = new stdClass();
	$oRetornoPropriedades->iVersao	   = $oPropriedades->getVersao();
	$oRetornoPropriedades->sNome	   = $oPropriedades->getNome();
  	$oRetornoPropriedades->sOrientacao = $oPropriedades->getOrientacao();
  	$oRetornoPropriedades->sFormato	   = $oPropriedades->getFormato();
  	$oRetornoPropriedades->sLayout	   = $oPropriedades->getLayout();
  	$oRetornoPropriedades->iMargemDir  = $oPropriedades->getMargemDir();
  	$oRetornoPropriedades->iMargemEsq  = $oPropriedades->getMargemEsq();
  	$oRetornoPropriedades->iMargemInf  = $oPropriedades->getMargemInf();
  	$oRetornoPropriedades->iMargemSup  = $oPropriedades->getMargemSup();

  	
  	$aVariaveis = $oXML->getVariaveis();
  	
  	foreach ($aVariaveis as $sNomeVar => $oVariavel ){
  	  $oRetornoVariaveis = new stdClass();
  	  $oRetornoVariaveis->sNome  = $oVariavel->getNome();
  	  $oRetornoVariaveis->sLabel = $oVariavel->getLabel();
  	  $oRetornoVariaveis->sValor = $oVariavel->getValor();
  	  
  	  $aRetornoVariaveis[] = $oRetornoVariaveis;
  	}
  	
  	
  	$rsConsultaTipoGrupo = $cldb_relatorio->sql_record($cldb_relatorio->sql_query_file($oPost->codRelatorio,"db63_db_tiporelatorio as tiporel,db63_db_gruporelatorio as gruporel "));
  	$oRetornoTipoGrupo   = db_utils::fieldsMemory($rsConsultaTipoGrupo,0);
  	
 	$aRetorno = array(
 					  "campos"	    =>$aRetornaCampos,
 					  "ordem"	    =>$aRetornaOrdem,
 					  "filtros"	    =>$aRetornaFiltros,
 					  "propriedades"=>$oRetornoPropriedades,
 					  "variaveis"   =>$aRetornoVariaveis,
 					  "view"		=>$sNomeView,
 					  "tipogrupo"	=>$oRetornoTipoGrupo
 					 );
 	
 					 
	$_SESSION['objetoXML'] = serialize($oXML); 					 
 	echo $oJson->encode($aRetorno);
	
 	
 	
  //************************************************************************************************************************//
  // Retorna todos relatório por departamento ou usuário
  //************************************************************************************************************************// 	
   	
  } else if ($oPost->tipo == "consultaRelatorios") {    
    
    
  	$cldb_relatoriousuario = new cl_db_relatoriousuario();
	$cldb_relatoriodepart  = new cl_db_relatoriodepart();
  	
  	
	if ($oPost->sTipoPesquisa == "Depto"){
	  $rsConsultaRelatorios = $cldb_relatoriodepart->sql_record($cldb_relatoriodepart->sql_query(null,"db63_nomerelatorio as nomeRelatorio, db63_sequencial as idRel","db63_sequencial"," db07_db_depart = ".$oPost->codDepto));	
	  $iNroLinhas = $cldb_relatoriodepart->numrows;
	} else {
	  $rsConsultaRelatorios = $cldb_relatoriousuario->sql_record($cldb_relatoriousuario->sql_query(null,"db63_nomerelatorio as nomeRelatorio, db63_sequencial as idRel","db63_sequencial","db09_db_usuarios = ".$oPost->idUsuario)); 
	  $iNroLinhas = $cldb_relatoriousuario->numrows;
	}	
	
 	if ( $iNroLinhas > 0 ){
 	  $aRetornaRel = db_utils::getColectionByRecord($rsConsultaRelatorios,false,false,true); 		
 	  $aRetorno    = array("objRel"=>$aRetornaRel,"erro"=>false);
	} else {
	  $aRetorno    = array("msg"=>urlencode("Nenhum relatório cadastrado!"),"erro"=>true);
	}
	
    echo $oJson->encode($aRetorno);  	
    
    
    
  //************************************************************************************************************************//
  // Remove o objeto da sessão
  //************************************************************************************************************************//
    
    
  } else if ($oPost->tipo == "retiraObjetoSessao") {    
    
  	
    if( isset($_SESSION['objetoXML']) ){
  	  unset($_SESSION['objetoXML']);
    }
  
    
    
  //************************************************************************************************************************//
  // Remove o objeto da sessão
  //************************************************************************************************************************//    
  
  
  } else if ($oPost->tipo == "consultaVariaveis") {        


  	$aRetorno   = array();
  	$aVariaveis = $oXML->getVariaveis();
  	
  	foreach ( $aVariaveis as $sInd => $objVariavel ){
  		
  	  $objRetornoVariavel = new stdClass();
  	  $objRetornoVariavel->sNome  = $objVariavel->getNome();
  	  $objRetornoVariavel->sLabel = $objVariavel->getLabel();
  	  $objRetornoVariavel->sValor = $objVariavel->getValor();

  	  $aRetorno[] = $objRetornoVariavel;
    }
    
  	echo $oJson->encode($aRetorno);
  	
  }
?>
