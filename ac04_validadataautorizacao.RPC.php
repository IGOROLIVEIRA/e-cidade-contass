<?php

require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

db_postmemory($_POST);

$oJson             = new services_json();
$oParam            =  json_decode(str_replace('\\', '', $_POST["json"]));

$e54_emiss = implode('-', array_reverse(explode('/', "$oParam->e54_emiss")));
$ac16_sequencial = $oParam->ac16_sequencial;
$iInstituicao = db_getsession("DB_instit");

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->erro  = '';


try {

  /* Validação data de autorização de empenho */

  $rsSituacaoAcordo = db_query("select ac16_acordosituacao from acordo where ac16_sequencial = $oParam->ac16_sequencial");
  $ac16_acordosituacao = db_utils::fieldsMemory($rsSituacaoAcordo, 0)->ac16_acordosituacao;
  $rsAcordo = db_query("select ac16_sequencial from acordo where (select ac18_datafim from acordovigencia where ac18_acordoposicao = (select ac26_sequencial from acordoposicao where ac26_acordo = ac16_sequencial order by ac26_sequencial desc limit 1)) >= '$e54_emiss' and '$e54_emiss' >= (select ac18_datainicio from acordovigencia where ac18_acordoposicao = (select ac26_sequencial from acordoposicao where ac26_acordo = ac16_sequencial order by ac26_sequencial limit 1)) and ac16_sequencial = $oParam->ac16_sequencial  and ac16_instit = $iInstituicao");
  if (pg_num_rows($rsAcordo) == 0 && $ac16_acordosituacao != 1) {
    throw new Exception("Usuario: A data da autorização de empenho nao esta dentro do periodo de vigencia do contrato");
  }

} catch (Exception $e) {
  $oRetorno->erro   = urlencode($e->getMessage());
  $oRetorno->status = 2;
}

echo json_encode($oRetorno);
