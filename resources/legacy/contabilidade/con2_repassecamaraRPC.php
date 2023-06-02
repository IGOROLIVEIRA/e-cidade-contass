<?php

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");


$oParams = json_decode(str_replace('\\','',$_POST['json']));

switch($oParams->sExec) {
  case 'consultarDataDaSessao':
    $oRetorno = new stdClass();
    $oRetorno->iTipo = $oParams->iTipo;
    $oRetorno->iAno = (int)db_getsession("DB_anousu");
    echo json_encode($oRetorno);
    break;
}