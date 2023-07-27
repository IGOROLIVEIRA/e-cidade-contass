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

    /* Validação tipo de origem de contrato */

  $rsAcordo = db_query("select ac16_tipoorigem,ac16_licitacao,ac16_adesaoregpreco,ac16_licoutroorgao from acordo where ac16_sequencial = $oParam->ac16_sequencial;");
  $ac16_tipoorigem = db_utils::fieldsMemory($rsAcordo, 0)->ac16_tipoorigem;
  $ac16_licitacao = db_utils::fieldsMemory($rsAcordo, 0)->ac16_licitacao;
  $ac16_adesaoregpreco = db_utils::fieldsMemory($rsAcordo, 0)->ac16_adesaoregpreco;
  $aTipoorigem = array(
    0 => 'Selecione',
    1 => '1 - Não ou dispensa por valor',
    2 => '2 - Licitação',
    3 => '3 - Dispensa ou Inexigibilidade',
    4 => '4 - Adesão à ata de registro de preços',
    5 => '5 - Licitação realizada por outro órgão ou entidade',
    6 => '6 - Dispensa ou Inexigibilidade realizada por outro órgão ou entidade',
    7 => '7 - Licitação - Regime Diferenciado de Contratações Públicas - RDC',
    8 => '8 - Licitação realizada por consorcio público',
    9 => '9 - Licitação realizada por outro ente da federação',
  );

  if(($ac16_tipoorigem == 2 || $ac16_tipoorigem == 3) && $ac16_licitacao == null){
    throw new Exception("Usuário: Inclusão abortada. Contrato de origem {$aTipoorigem[$ac16_tipoorigem]} sem vínculo com Licitação. Gentileza entrar em contato com o suporte para a vinculação correta.");
  }

  if($ac16_tipoorigem == 4 && $ac16_adesaoregpreco == null){
    throw new Exception("Usuário: Inclusão abortada. Contrato de origem {$aTipoorigem[$ac16_tipoorigem]} sem vínculo com Adesão de Registro de Preço. Gentileza entrar em contato com o suporte para a vinculação correta.");
  }

  if(($ac16_tipoorigem == 5 || $ac16_tipoorigem == 6 || $ac16_tipoorigem == 7 || $ac16_tipoorigem == 8 || $ac16_tipoorigem == 9) && $ac16_licoutroorgao == null){
    throw new Exception("Usuário: Inclusão abortada. Contrato de origem {$aTipoorigem[$ac16_tipoorigem]} sem vínculo com Licitação de Outros Órgãos. Gentileza entrar em contato com o suporte para a vinculação correta.");
  }


} catch (Exception $e) {
  $oRetorno->erro   = urlencode($e->getMessage());
  $oRetorno->status = 2;
}

echo json_encode($oRetorno);
