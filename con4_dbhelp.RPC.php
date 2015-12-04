<?php

require_once ("libs/db_stdlib.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_conecta.php");
require_once ("dbforms/db_funcoes.php");
require_once ("libs/JSON.php");

$oJson                  = new services_json();
$oParam                 = $oJson->decode(str_replace("\\","",$_GET["json"]));
$oRetorno               = new stdClass();
$oRetorno->iStatus      = 1;
$oRetorno->sMessage     = '';

try {

    switch ($oParam->exec) {

    case "getHelpData":

      $oDBHelp = new DBHelp();

      $oRetorno->aHelps = $oDBHelp->getHelpData();
      $oRetorno->sVersao = $oDBHelp->getVersao();

    break;

  }

} catch (Exception $eErro){

  $oRetorno->iStatus  = 2;
  $oRetorno->sMessage = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);