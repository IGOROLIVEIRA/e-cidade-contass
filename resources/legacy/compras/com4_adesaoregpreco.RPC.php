<?php

require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

require_once("classes/db_itensregpreco_classe.php");

db_postmemory($_POST);

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;

$nAnoUsu = db_getsession('DB_anousu');
$nInstit = db_getsession('DB_instit');

try {

  switch ($oParam->exec) {

    case "salvar":

      foreach ($oParam->itens as $oItem) {

        $oItemRegPreco = new cl_itensregpreco();

        $oItemRegPreco->si07_item               = $oItem->si07_item;
        $oItemRegPreco->si07_codunidade         = $oItem->si07_codunidade;
        $oItemRegPreco->si07_fornecedor         = $oItem->si07_fornecedor;
        $oItemRegPreco->si07_numeroitem         = $oItem->si07_numeroitem;
        $oItemRegPreco->si07_numerolote         = $oItem->si07_numerolote;
        $oItemRegPreco->si07_sequencial         = $oItem->si07_sequencial;
        $oItemRegPreco->si07_descricaolote      = $oItem->si07_descricaolote;
        $oItemRegPreco->si07_precounitario      = str_replace(',', '.', $oItem->si07_precounitario);
        $oItemRegPreco->si07_sequencialadesao   = $oItem->si07_sequencialadesao;
        $oItemRegPreco->si07_quantidadeaderida  = $oItem->si07_quantidadeaderida;
        $oItemRegPreco->si07_quantidadelicitada = $oItem->si07_quantidadelicitada;
        $oItemRegPreco->si07_percentual = $oItem->si07_percentual;
        db_inicio_transacao();

        if (empty($oItem->si07_sequencial)) {
          $oItemRegPreco->incluir($oItem->si07_sequencial);
        } else {
          $oItemRegPreco->alterar($oItem->si07_sequencial);
        }

        db_fim_transacao();

        if ($oItemRegPreco->erro_status != 1) {
          throw new Exception(
            $oItemRegPreco->erro_msg,
            $oItemRegPreco->erro_status
          );
        }

        $oRetorno->sucesso = utf8_encode("Informações salvas com sucesso!");
      }

      break; // salvar


    case 'excluir':

      $oItemRegPreco = new cl_itensregpreco();

      db_inicio_transacao();

      $oItemRegPreco->excluir($oParam->itemregpreco);

      db_fim_transacao();

      if ($oItemRegPreco->erro_status != 1) {
        throw new Exception(
          $oItemRegPreco->erro_msg,
          $oItemRegPreco->erro_status
        );
      }

      $oRetorno->sucesso = utf8_encode("Item excluído do processo de adesão de registro de preço!");

      break;
  }
} catch (Exception $e) {

  $oRetorno->erro   = utf8_encode($e->getMessage());
  $oRetorno->status = $e->getCode();
}

echo $oJson->encode($oRetorno);
