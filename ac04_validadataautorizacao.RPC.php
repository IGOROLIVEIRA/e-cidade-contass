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

  /* Valida��o data de autoriza��o de empenho */

  $rsSituacaoAcordo = db_query("select ac16_acordosituacao from acordo where ac16_sequencial = $oParam->ac16_sequencial");
  $ac16_acordosituacao = db_utils::fieldsMemory($rsSituacaoAcordo, 0)->ac16_acordosituacao;
  $rsAcordo = db_query("select ac16_sequencial from acordo where (select ac18_datafim from acordovigencia where ac18_acordoposicao = (select ac26_sequencial from acordoposicao where ac26_acordo = ac16_sequencial order by ac26_sequencial desc limit 1)) >= '$e54_emiss' and '$e54_emiss' >= (select ac18_datainicio from acordovigencia where ac18_acordoposicao = (select ac26_sequencial from acordoposicao where ac26_acordo = ac16_sequencial order by ac26_sequencial limit 1)) and ac16_sequencial = $oParam->ac16_sequencial  and ac16_instit = $iInstituicao");
  if (pg_num_rows($rsAcordo) == 0 && $ac16_acordosituacao != 1) {
    throw new Exception("Usuario: A data da autoriza��o de empenho nao esta dentro do periodo de vigencia do contrato");
  }

    /* Valida��o tipo de origem de contrato */

  $rsAcordo = db_query("select ac16_tipoorigem,ac16_licitacao,ac16_adesaoregpreco,ac16_licoutroorgao from acordo where ac16_sequencial = $oParam->ac16_sequencial;");
  $ac16_tipoorigem = db_utils::fieldsMemory($rsAcordo, 0)->ac16_tipoorigem;
  $ac16_licitacao = db_utils::fieldsMemory($rsAcordo, 0)->ac16_licitacao;
  $ac16_adesaoregpreco = db_utils::fieldsMemory($rsAcordo, 0)->ac16_adesaoregpreco;
  $aTipoorigem = array(
    0 => 'Selecione',
    1 => '1 - N�o ou dispensa por valor',
    2 => '2 - Licita��o',
    3 => '3 - Dispensa ou Inexigibilidade',
    4 => '4 - Ades�o � ata de registro de pre�os',
    5 => '5 - Licita��o realizada por outro �rg�o ou entidade',
    6 => '6 - Dispensa ou Inexigibilidade realizada por outro �rg�o ou entidade',
    7 => '7 - Licita��o - Regime Diferenciado de Contrata��es P�blicas - RDC',
    8 => '8 - Licita��o realizada por consorcio p�blico',
    9 => '9 - Licita��o realizada por outro ente da federa��o',
  );

  if(($ac16_tipoorigem == 2 || $ac16_tipoorigem == 3) && $ac16_licitacao == null){
    throw new Exception("Usu�rio: Inclus�o abortada. Contrato de origem {$aTipoorigem[$ac16_tipoorigem]} sem v�nculo com Licita��o. Gentileza entrar em contato com o suporte para a vincula��o correta.");
  }

  if($ac16_tipoorigem == 4 && $ac16_adesaoregpreco == null){
    throw new Exception("Usu�rio: Inclus�o abortada. Contrato de origem {$aTipoorigem[$ac16_tipoorigem]} sem v�nculo com Ades�o de Registro de Pre�o. Gentileza entrar em contato com o suporte para a vincula��o correta.");
  }

  if(($ac16_tipoorigem == 5 || $ac16_tipoorigem == 6 || $ac16_tipoorigem == 7 || $ac16_tipoorigem == 8 || $ac16_tipoorigem == 9) && $ac16_licoutroorgao == null){
    throw new Exception("Usu�rio: Inclus�o abortada. Contrato de origem {$aTipoorigem[$ac16_tipoorigem]} sem v�nculo com Licita��o de Outros �rg�os. Gentileza entrar em contato com o suporte para a vincula��o correta.");
  }


} catch (Exception $e) {
  $oRetorno->erro   = urlencode($e->getMessage());
  $oRetorno->status = 2;
}

echo json_encode($oRetorno);
