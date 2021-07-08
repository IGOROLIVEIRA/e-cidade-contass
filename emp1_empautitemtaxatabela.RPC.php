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
$oDaoSysArqCamp    = new cl_db_sysarqcamp();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->itens   = array();
$dtDia             = date("Y-m-d", db_getsession("DB_datausu"));

switch ($_GET['Param']) {

  case 'BuscaItens':


    $sSqlSysArqCamp = $oDaoSysArqCamp->sql_query($oParam->iArquivo, '', '', 'db_syscampo.*');
    $rsSysArqCamp   = $oDaoSysArqCamp->sql_record($sSqlSysArqCamp);
    if ($oDaoSysArqCamp->numrows > 0) {
      for ($i = 0; $i < pg_numrows($rsSysArqCamp); $i++) {

        $oDados = db_utils::fieldsMemory($rsSysArqCamp, $i);
        $oDados->descricao = utf8_encode($oDados->descricao);
        $oRetorno = $oDados;
      }
    }
    break;
}
echo $oJson->encode($oRetorno);
