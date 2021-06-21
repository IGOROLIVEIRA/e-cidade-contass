<?php

require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_relatorios_classe.php");
require_once("classes/db_db_sysarqcamp_classe.php");
require_once("classes/db_db_sysarquivo_classe.php");

$clrelatorios = new cl_relatorios;
$oDaoSysArqCamp = new cl_db_sysarqcamp();
$oDaoSysArquivo = new cl_db_sysarquivo();
$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->itens   = array();
$dtDia             = date("Y-m-d", db_getsession("DB_datausu"));

switch ($oParam->exec) {

  case 'verificaArquivo':

    $sSqlSysArqCamp = $oDaoSysArqCamp->sql_query($oParam->iArquivo, '', '', 'db_syscampo.*');
    $rsSysArqCamp   = $oDaoSysArqCamp->sql_record($sSqlSysArqCamp);
    if ($oDaoSysArqCamp->numrows > 0) {
      for ($i = 0; $i < pg_numrows($rsSysArqCamp); $i++) {

        $oDados = db_utils::fieldsMemory($rsSysArqCamp, $i);
        $oRetorno->itens[] = $oDados;
      }
    }
    break;

  case 'getArquivo':

    $sSqlSysArqCamp = $oDaoSysArquivo->sql_query_buscaCamposPorTabela($oParam->iArquivo);
    $rsSysArqCamp   = $oDaoSysArqCamp->sql_record($sSqlSysArqCamp);
    $oDados = db_utils::fieldsMemory($rsSysArqCamp, 0);
    $oRetorno->arquivo = $oDados;
    break;
}
echo $oJson->encode($oRetorno);
