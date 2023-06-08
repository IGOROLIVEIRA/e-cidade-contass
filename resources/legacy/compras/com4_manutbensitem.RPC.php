<?php

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once "libs/JSON.php";
require_once("libs/db_utils.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->erro    = false;
$oRetorno->message = '';

try {

  db_inicio_transacao();

  switch ($oParam->exec) {

    case "getItens":

      $cl_manutbensitem = new cl_manutbensitem;

      $rsResultItens = db_query($cl_manutbensitem->sql_query($oParam->t98_sequencial, "t99_sequencial,t99_itemsistema,t99_codpcmater,t99_descricao,t99_valor", "t99_sequencial", ""));
      $aItens          = array();

      for ($i = 0; $i < pg_numrows($rsResultItens); $i++) {
        $oItem = new stdClass();
        $item = db_utils::fieldsMemory($rsResultItens, $i);
        $oItem->t99_sequencial =  $item->t99_sequencial;
        $oItem->t99_itemsistema =  $item->t99_itemsistema == "1" ? "Sim" : urlencode("Não");
        $oItem->t99_codpcmater =    $item->t99_codpcmater == null ? "-" : $item->t99_codpcmater;
        $oItem->t99_descricao =  urlencode($item->t99_descricao);
        $oItem->t99_valor = $item->t99_valor;
        $oItem->t99_codbensdispensatombamento = $item->t99_codbensdispensatombamento;
        $aItens[] = $oItem;
      }

      $oRetorno->aItens = $aItens;
      break;
  }

  db_fim_transacao(false);
} catch (Exception $eErro) {
  db_fim_transacao(true);
  $oRetorno->erro  = true;
  $oRetorno->message = urlencode($eErro->getMessage());
}

echo json_encode($oRetorno);
