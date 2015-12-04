<?php

 
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_liborcamento.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_libpostgres.php");
require_once("libs/db_sessoes.php");


$oJson    = new services_json();
$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));

$oRetorno = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$oRetorno->itens   = array();


if (count($oParam->arquivos) > 0) {

	/*
     * Definindo o periodo em que sera selecionado os dados
     */
    $iUltimoDiaMes = date("d", mktime(0,0,0,$oParam->mesReferencia+1,0,db_getsession("DB_anousu")));
    $sDataInicial = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-01";
    $sDataFinal   = db_getsession("DB_anousu")."-{$oParam->mesReferencia}-{$iUltimoDiaMes}";
	  
		$sSql  = "SELECT db21_codigomunicipoestado FROM db_config WHERE codigo = ".db_getsession('DB_instit');
    	
    	$rsInst = db_query($sSql);
    	$sInst  = str_pad(db_utils::fieldsMemory($rsInst, 0)->db21_codigomunicipoestado, 5, "0", STR_PAD_LEFT);
    	   	
        $iAnoReferencia = db_getsession('DB_anousu');
      	$aItens = array();
      
      foreach ($oParam->arquivos as $sArquivo) {
        
	        if (file_exists("$sArquivo.php")) {
	        
		         try {
		         
		            require_once("$sArquivo.php");
		            
		            $oArquivo = new $sArquivo;
		            
		            $obj = new stdClass();
		            $obj->nome = $oArquivo->gerarDados($sDataInicial,$sDataFinal);
		            
		            $aItens[] = $obj;
		            
		          } catch (Exception $eErro) {
		          	
		            $oRetorno->status  = 2;
		            $sGetMessage       = "Arquivo:{$oArquivo->getNomeArquivo()} retornou com erro: \\n \\n {$eErro->getMessage()}";
		            $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));
		          
		        }
	        
	      }
      }
      
      $oRetorno->itens = $aItens;
      
}
echo $oJson->encode($oRetorno);