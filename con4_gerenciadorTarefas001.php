<?php
$HTTP_SERVER_VARS["PHP_SELF"] = "";

require_once("libs/db_stdlib.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");

db_app::import("exceptions.*");

try{

  db_app::import('configuracao.TaskManager');
  $oTaskManager = TaskManager::getInstance();

  if ( !$oTaskManager->iniciarServico() ) {

    echo "Serviço esta sendo Executado: ";
    echo " \n  Processo    - ".$oTaskManager->getPIDProcesso();
    echo " \n  Data Inicio - ".$oTaskManager->getDataInicio() . " desde as " . $oTaskManager->getHoraInicio();
  }
} catch( BusinessException $eErroRegraNegocio) {
  echo  "Erro Sistema : " . $eErroRegraNegocio->getMessage();
} catch( DBException       $eErroDataBase) {
  echo  "Erro no Banco: " . $eErroDataBase->getMessage();
}
echo "\n\n\n";
