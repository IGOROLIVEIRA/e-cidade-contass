<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
require_once("libs/JSON.php");

db_postmemory($_POST);

$oJson             = new services_json();
$oParam            =  json_decode(str_replace('\\', '', $_POST["json"]));

$sequencial = $oParam->sequencial;
$tabela = $oParam->tabela;

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->erro  = '';

try {

  switch ($tabela) {

    case "solicita":

        $clsolicita = new cl_solicita;
        $rsSolicitacao = $clsolicita->sql_record($clsolicita->sql_query_file($sequencial,"pc10_resumo"));
        $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsSolicitacao, 0)->pc10_resumo);
        break;

    case "pcproc":

        $clpcproc = new cl_pcproc;
        $rsProcesso = $clpcproc->sql_record($clpcproc->sql_query_file($sequencial,"pc80_resumo"));
        $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsProcesso, 0)->pc80_resumo);
        break;

    case "empautoriza":

        $clempautoriza = new cl_empautoriza;
        $rsAutorizacao = $clempautoriza->sql_record($clempautoriza->sql_query_file($sequencial,"e54_resumo"));
        $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsAutorizacao, 0)->e54_resumo);
        break;

    case "empempenho":

        $aEmpenho  = explode("/", $sequencial);
        $e60_codemp = $aEmpenho[0];
        $e60_anousu = $aEmpenho[1];
        $clempempenho = new cl_empempenho;
        $rsEmpempenho = $clempempenho->sql_record($clempempenho->sql_query_file("","e60_resumo","","e60_codemp = '$e60_codemp' and e60_anousu = $e60_anousu"));
        $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsEmpempenho, 0)->e60_resumo);
        break;

    case "matordem":

        $clmatordem = new cl_matordem;
        $rsOrdem = $clmatordem->sql_record($clmatordem->sql_query_file($sequencial,"m51_obs"));
        $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsOrdem, 0)->m51_obs);
        break;
  }

} catch (Exception $e) {
  $oRetorno->erro   = urlencode($e->getMessage());
  $oRetorno->status = 2;
}

echo $oJson->encode($oRetorno);
