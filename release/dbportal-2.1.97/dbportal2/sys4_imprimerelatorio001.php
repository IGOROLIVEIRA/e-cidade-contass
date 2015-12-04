<?
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_libsys.php");
include("libs/JSON.php");
include("dbagata/classes/core/AgataAPI.class");
include("model/dbVariaveisRelatorio.php");
include("model/dbOrdemRelatorio.model.php");
include("model/dbGeradorRelatorio.model.php");

ini_set("error_reporting","E_ALL & ~NOTICE");

$oGet  = db_utils::postMemory($_GET);
$oJson = new services_json();

$clagata = new cl_dbagata();

$api = $clagata->api;

$api->setReportPath($oGet->caminhorelatorio);

$xml = $api->getReport();

$sNomeRelatorio  = $xml["Report"]["Properties"]["Title"];
$api->setParameter('$head1',$sNomeRelatorio);

$oGeradorRelatorios = unserialize($_SESSION['objetoXML']); 

$aOrdem = $oGeradorRelatorios->getOrdem();

if (!empty($aOrdem)) {
  	
  foreach ($aOrdem as $iInd1 => $aOrdem2){
    foreach ($aOrdem2 as $iInd2 => $oOrdem ){
      $aNomeOrdem[] = $oOrdem->getAlias();
    }	
  }

  $sNomeOrdem = implode(", ",$aNomeOrdem);
  $iLinha     = 2;

  for($iIni=0; $iIni < strlen($sNomeOrdem); $i++ ){
	
    $iFim = 52;
  
    if ($iLinha == 2) {
  	  $sPrefix = "Ordem : ";
  	  $iFim	-= 8; 
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

if (isset($oGet->variaveis)){
  
  $aObjVariaveis = $oJson->decode(str_replace("\\","",$oGet->variaveis));
    
  foreach ( $aObjVariaveis as $iInd => $oVariavel) {

 	 $api->setParameter($oVariavel->sNome,$oVariavel->sValor);
  	  
  }
  
}


$ok = $api->generateReport();
	
if(!$ok){
    echo $api->getError();
}else{ 
	db_redireciona($clagata->arquivo);
}


?>
