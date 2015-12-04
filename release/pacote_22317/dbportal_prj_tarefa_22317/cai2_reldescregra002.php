<?
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_libsys.php");
include_once 'dbagata/classes/core/AgataAPI.class';

ini_set("error_reporting","E_ALL & ~NOTICE");

$oGet = db_utils::postMemory($_GET); 

  if($oGet->seltipo == "s"){
		$clagata = new cl_dbagata("caixa/cai2_reldescregrasintetico002.agt");
		$cabTipo = " SINTÉTICO";
	}else{
		$clagata = new cl_dbagata("caixa/cai2_reldescregraanalitico002.agt");
		$cabTipo = " ANALÍTICO";
	}

	$api = $clagata->api;
	$api->setParameter('$head1', "RELATÓRIO DE DESCONTOS CONCEDIDOS");
	$api->setParameter('$head2', "PERÍODO DE PAGAMENTO: ".db_formatar($oGet->datai,"d")." À ".db_formatar($oGet->dataf,"d"));
	$api->setParameter('$head3', "TIPO :".$cabTipo);
	$api->setParameter('$anousu', db_getsession('DB_anousu'));
	$api->setParameter('$datai', $oGet->datai);
	$api->setParameter('$dataf', $oGet->dataf);
	$api->setParameter('$instit', db_getsession('DB_instit'));

	$ok = $api->generateReport();
	
	if(!$ok){
    echo $api->getError();
	}else{ 
    db_redireciona($clagata->arquivo);
	}

?>
