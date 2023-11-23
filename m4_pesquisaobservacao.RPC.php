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

$iInstituicao = db_getsession("DB_instit");

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
        $rsSolicitacao = $clpcproc->sql_record($clpcproc->sql_query_file($sequencial,"pc10_resumo"));
        $oRetorno->observacao = urlencode(db_utils::fieldsMemory($rsSolicitacao, 0)->pc10_resumo);
        break;

    case "empautoriza":
        echo "i equals 2";
        break;
    case "empautoriza":
        echo "i equals 2";
        break;
    case "empempenho":
        echo "i equals 2";
        break;
    case "matordem":
        echo "i equals 2";
        break;
  }

} catch (Exception $e) {
  $oRetorno->erro   = urlencode($e->getMessage());
  $oRetorno->status = 2;
}

echo $oJson->encode($oRetorno);
