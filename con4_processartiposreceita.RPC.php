<?php

require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

require_once("classes/db_entesconsorciadosreceitas_classe.php");

db_postmemory($_POST);

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;

switch ($oParam->exec){

  case "adicionarReceita":

    try {

      $oNovoEntesReceitas = new cl_entesconsorciadosreceitas();

      $oNovoEntesReceitas->c216_enteconsorciado = $oParam->dados->enteConsorciado;
      $oNovoEntesReceitas->c216_tiporeceita     = $oParam->dados->tipoReceita;
      $oNovoEntesReceitas->c216_receita         = $oParam->dados->receita;
      $oNovoEntesReceitas->c216_saldo3112       = $oParam->dados->saldo;
      $oNovoEntesReceitas->c216_percentual      = $oParam->dados->percentual;
      $oNovoEntesReceitas->c216_anousu          = db_getsession('DB_anousu');

      $oNovoEntesReceitas->incluir(null);

      if ($oNovoEntesReceitas->erro_status != 1) {
        throw new Exception($oNovoEntesReceitas->msg, 1);
      } else {
        $oRetorno->atualizar = true;
        $oRetorno->msg = 'Inserido com sucesso.';
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
    }

  break; // adicionarReceita

  case "buscaReceitasCadastradas":

    try {

      $oEntesReceitas = new cl_entesconsorciadosreceitas();

      $sCampos = implode(', ', array(
        'DISTINCT c216_sequencial',
        'c216_tiporeceita',
        'c216_receita',
        'c216_saldo3112',
        'c216_percentual',
        'o57_descr',
      ));

      $sSql = $oEntesReceitas->sql_query(null, $sCampos, null,
          " c216_enteconsorciado = {$oParam->enteConsorciado} and c216_anousu = ".db_getsession("DB_anousu"));


      $rsReceitas = $oEntesReceitas->sql_record($sSql);

      $aReceitas = db_utils::getCollectionByRecord($rsReceitas);

      $oRetorno->receitas = array();

      foreach ($aReceitas as $oReceita) {

        $oNovaReceita = new stdClass();
        $oNovaReceita->sequencial   = $oReceita->c216_sequencial;
        $oNovaReceita->tipo         = $oReceita->c216_tiporeceita;
        $oNovaReceita->codReceita   = $oReceita->c216_receita;
        $oNovaReceita->descReceita  = urlencode($oReceita->o57_descr);
        $oNovaReceita->percentual   = $oReceita->c216_percentual;
        $oNovaReceita->saldo        = $oReceita->c216_saldo3112;

        $oRetorno->receitas[] = $oNovaReceita;

      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
    }

  break; // buscaTiposCadastrados

  case 'excluirReceita':

    try {

      $oEntesReceitas = new cl_entesconsorciadosreceitas();
      $oEntesReceitas->excluir($oParam->codigo);

      if ($oEntesReceitas->erro_status != 1) {
        throw new Exception($oEntesReceitas->erro_msg, 1);
      } else {
        $oRetorno->atualizar = true;
        $oRetorno->msg = urlencode('Excluído com sucesso.');
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
    }

  break; // excluirReceita

}

echo $oJson->encode($oRetorno);
?>
