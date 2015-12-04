<?
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_libsys.php");
include("dbforms/db_funcoes.php");
include("libs/JSON.php");
include("dbagata/classes/core/AgataAPI.class");
include("classes/db_db_relatorio_classe.php");
include("classes/db_db_geradorrelatoriotemplate_classe.php");
include("model/dbColunaRelatorio.php");
include("model/dbFiltroRelatorio.php");
include("model/dbVariaveisRelatorio.php");
include("model/dbGeradorRelatorio.model.php");
include("model/dbOrdemRelatorio.model.php");
include("model/dbPropriedadeRelatorio.php");
ini_set("error_reporting","E_ALL & ~NOTICE");


$oPost   		   			   = db_utils::postMemory($_POST);
$oJson   		   			   = new services_json();
$cldb_relatorio    			   = new cl_db_relatorio();
$oGeradorRelatorio 			   = new dbGeradorRelatorio($oPost->iCodRelatorio);
$cldb_geradorrelatoriotemplate = new cl_db_geradorrelatoriotemplate();

$lSqlErro = false;
$lErro    = false;


// Consulta XML e o Tipo do relatório 
$rsConsultaRelatorio = $cldb_relatorio->sql_record($cldb_relatorio->sql_query($oPost->iCodRelatorio,"db63_db_tiporelatorio,db63_xmlestruturarel"));


if( $cldb_relatorio->numrows > 0 ){
	
  $oRelatorio = db_utils::fieldsMemory($rsConsultaRelatorio,0);
  
  // Gera arquivo .agt e salva no tmp do dbportal
  $sCaminhoRelatorio = $oGeradorRelatorio->geraArquivoAgt($oRelatorio->db63_xmlestruturarel);

  
  $clagata = new cl_dbagata();
  $api = $clagata->api;
  $api->setReportPath($sCaminhoRelatorio);
  
  
  $oPropriedades = $oGeradorRelatorio->getPropriedades();
  
  $api->setParameter('$head1',$oPropriedades->getNome());
  
  $aOrdem 	  = $oGeradorRelatorio->getOrdem();
  
  if (!empty($aOrdem)) {
  	
    $aNomeOrdem = array();
  
    foreach ($aOrdem as $iInd1 => $aOrdem2){
      foreach ($aOrdem2 as $iInd2 => $oOrdem ){
        $aNomeOrdem[] = $oOrdem->getAlias();
      }	
    }

    if (!empty($aNomeOrdem)) {
  	
      $sNomeOrdem = implode(", ",$aNomeOrdem);
      $iLinha     = 2;

      for($iIni=0; $iIni < strlen($sNomeOrdem); $i++ ){
	
        $iFim = 52;
  
        if ($iLinha == 2) {
  	      $sPrefix = "Ordem : ";
  	      $iFim	  -= 8; 
        } else {
          $sPrefix = "";
        }
    
        $api->setParameter('$head'.$iLinha,$sPrefix.(substr($sNomeOrdem,$iIni,$iFim)));
        $iLinha++;
        $iIni += $iFim;
    
        if ($iLinha == 7) {
  	      break;	
        }
      }
    }
  }
  
  if (isset($oPost->aParametros)){
  	
    $aObjVariaveis = $oJson->decode(str_replace("\\","",$oPost->aParametros));
    
  	foreach ( $aObjVariaveis as $iInd => $oVariavel) {
 	  $api->setParameter($oVariavel->sNome,$oVariavel->sValor);
  	}
  	
  }
  
  
  // Verifica o tipo de relatório 1-Relatório,  2-Documento Template e utiliza o método da API do Agata referente ao tipo 
  if ( $oRelatorio->db63_db_tiporelatorio == 2 ) {
	
  	$rsConsultaTemplate = $cldb_geradorrelatoriotemplate->sql_record($cldb_geradorrelatoriotemplate->sql_query(null,"db15_documento",null, " db15_db_relatorio = {$oPost->iCodRelatorio}"));

    if ($cldb_geradorrelatoriotemplate->numrows > 0) {
	  
      $oArquivoSxw = db_utils::fieldsMemory($rsConsultaTemplate,0);
     
   	  db_inicio_transacao();
   	 
   	  $sArquivoSxw      = "docTamplate".date("YmdHis").db_getsession("DB_id_usuario").".sxw";
	  $sCaminhoTemplate = "tmp/".$sArquivoSxw;
	  
   	  $lGeraSxw 		= pg_lo_export($oArquivoSxw->db15_documento,$sCaminhoTemplate,$conn);
   	     	 
   	  if (!$lGeraSxw) {   	 	
   	    $lSqlErro = true;
   	    $lErro	  = true;   	 	
   	    $sRetorno = "Erro ao gerar aquivo Sxw!";
      }
      
      db_fim_transacao($lSqlErro);

      $sCaminhoSalvoSxw = "tmp/docSalvoSxw".date("YmdHis").db_getsession("DB_id_usuario").".sxw";
      
      $api->setOutputPath($sCaminhoSalvoSxw);
		
	  ob_start();
		
	  $ok = $api->parseOpenOffice($sCaminhoTemplate);

	  if (!$ok){
	  	$lErro    = true; 
 		$sRetorno = $api->getError();
  	  }else{
		ob_end_clean();
		
		if ($api->getRowNum() == 0){
 		  $aRetorno = array("sMsg"=>urlencode("Nenhum registro encontrado!"),"erro"=>true);
		  echo $oJson->encode($aRetorno);
		  exit;			
		}
		
		$sNomeRelatorio   = "tmp/geraRelatorio".date("YmdHis").db_getsession("DB_id_usuario").".pdf";
		$sComandoConverte = `bin/oo2pdf/oo2pdf.sh {$sCaminhoSalvoSxw} {$sNomeRelatorio}`;
		
		if (trim($sComandoConverte) != "") {
 		  $aRetorno = array("sMsg"=>urlencode("Operação abortada, verifique as configurações do gerador de relatórios!"),"erro"=>true);
		  echo $oJson->encode($aRetorno);
		  exit;
		} else {
		  $sRetorno = $sNomeRelatorio;
		}
  		
  	  }
      
    } else {
    	
      $lErro 	= true;
  	  $sRetorno = "Nenhum template cadastrado!";
  	  
    }
  	
  } else {
  	
    $api->setFormat("pdf");
    $sNomeRelatorio   = "tmp/geraRelatorio".date("YmdHis").db_getsession("DB_id_usuario").".pdf";
    $api->setOutputPath($sNomeRelatorio);
  	
  	ob_start();
  	$ok = $api->generateReport();
	
    if(!$ok){
      $lErro    = true; 	
      $sRetorno = $api->getError();
    }else{ 
      ob_end_clean();
   	  if ($api->getRowNum() == 0){
 		 $aRetorno = array("sMsg"=>urlencode("Nenhum registro encontrado!"),"erro"=>true);
		 echo $oJson->encode($aRetorno);
		 exit;			
	  }      
	  $sRetorno = $sNomeRelatorio;
    }
       	
    
  }

} else {
  $lErro 	= true;
  $sRetorno = "Nenhum relatório emcontrado!";  	
}
 
 $aRetorno = array("sMsg"=>urlencode($sRetorno),"erro"=>$lErro);
 
 echo $oJson->encode($aRetorno);

?>
