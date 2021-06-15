<?php

require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_db_sysarqcamp_classe.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->itens   = array();
$dtDia             = date("Y-m-d", db_getsession("DB_datausu"));

switch ($oParam->exec) {

  case 'verificaModulo':

    $oDaoSysArqCamp = new cl_db_sysarqcamp();
    $sSqlSysArqCamp = $oDaoSysArqCamp->sql_query_modulo('', '', '', '*', '', "db_sysmodulo.codmod = $oParam->iModulo");
    $rsSysArqCamp   = $oDaoSysArqCamp->sql_record($sSqlSysArqCamp);
    if ($oDaoSysArqCamp->numrows > 0) {
      $oDados = db_utils::fieldsMemory($rsSysArqCamp, 0);
      $oRetorno->itens = $oDados;
    }


    break;
}
echo $oJson->encode($oRetorno);
