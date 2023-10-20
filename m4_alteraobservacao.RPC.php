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
$observacao = utf8_decode(db_stdClass::db_stripTagsJson($oParam->observacao));
//$observacao = rawurldecode(mb_convert_encoding($oParam->observacao, "ISO-8859-1", "UTF-8"));//addslashes(stripslashes(chop($oParam->observacao)));
//$observacao = nl2br(mb_convert_encoding($oParam->observacao, "ISO-8859-1", "UTF-8"));

$iInstituicao = db_getsession("DB_instit");

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->erro  = '';

try {

  switch ($tabela) {

    case "solicita":

        db_query("update solicita set pc10_resumo= '$observacao' where pc10_numero = $sequencial;");
        break;

    case "pcproc":

      db_query("update pcproc set pc80_resumo = '$observacao' where pc80_codproc = $sequencial;");
      break;

    case "empautoriza":

      db_query("update empautoriza set e54_resumo = '$observacao' where e54_autori = $sequencial;");
      break;

    case "empempenho":

      db_query("update empempenho set e60_resumo = '$observacao' where e60_numemp = $sequencial;");
      break;

    case "matordem":

      db_query("update matordem set m51_obs = '$observacao' where m51_codordem = $sequencial;");
      break;
  }

} catch (Exception $e) {
  $oRetorno->erro   = urlencode($e->getMessage());
  $oRetorno->status = 2;
}

echo $oJson->encode($oRetorno);
