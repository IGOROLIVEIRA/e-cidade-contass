<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conn.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));
//echo '<pre>';var_dump($oParam);exit;
$oRetorno = new stdClass();
$oRetorno->status  = 1;
$erro = false;

$instituicao = db_getsession("DB_instit");
$sql = "SELECT si09_tipoinstit FROM infocomplementaresinstit WHERE si09_instit = {$instituicao}";
$iTipoInstit = db_utils::fieldsMemory(db_query($sql), 0)->si09_tipoinstit;

$oDaoDadoscomplementareslrf = db_utils::getDao('dadoscomplementareslrf');
$oDaoOperacoesdecreditolrf = db_utils::getDao('operacoesdecreditolrf');
$oDaoPublicacaoeperiodicidaderreo = db_utils::getDao('publicacaoeperiodicidaderreo');
$oDaoPublicacaoeperiodicidadergf = db_utils::getDao('publicacaoeperiodicidadergf');

switch ($oParam->exec) {

  case "salvarDados":

  unset($oParam->exec);


  $oDaoinfocomplementaresinstit = db_utils::getDao('infocomplementaresinstit');



  db_inicio_transacao();
  // PEGA CODIGO DO ORGAO
  $oInstituicao = $oDaoinfocomplementaresinstit->sql_query_file(null,"*",null,"si09_instit = ".db_getsession('DB_instit'));
  $oInstituicao = $oDaoinfocomplementaresinstit->sql_record($oInstituicao);
  $oInstituicao = db_utils::fieldsMemory($oInstituicao);
  $iCodOrgao = $oInstituicao->si09_codorgaotce;

  // REGISTRO 10
  $oDaoDadoscomplementareslrf->c218_codorgao = $iCodOrgao;
  $oDaoDadoscomplementareslrf->c218_anousu = db_getsession('DB_anousu');
  $oDaoDadoscomplementareslrf->c218_mesusu = $oParam->dadoscomplementares->c218_mesusu;
  $oDaoDadoscomplementareslrf->c218_passivosreconhecidos = $oParam->dadoscomplementares->c218_passivosreconhecidos;
  $oDaoDadoscomplementareslrf->c218_vlsaldoatualconcgarantiainterna = $oParam->dadoscomplementares->c218_vlsaldoatualconcgarantiainterna;
  $oDaoDadoscomplementareslrf->c218_vlsaldoatualconcgarantia = $oParam->dadoscomplementares->c218_vlsaldoatualconcgarantia;
  $oDaoDadoscomplementareslrf->c218_vlsaldoatualcontragarantiainterna = $oParam->dadoscomplementares->c218_vlsaldoatualcontragarantiainterna;
  $oDaoDadoscomplementareslrf->c218_vlsaldoatualcontragarantiaexterna = $oParam->dadoscomplementares->c218_vlsaldoatualcontragarantiaexterna;
  $oDaoDadoscomplementareslrf->c218_medidascorretivas = $oParam->dadoscomplementares->c218_medidascorretivas;
  $oDaoDadoscomplementareslrf->c218_recalieninvpermanente = $oParam->dadoscomplementares->c218_recalieninvpermanente;
  $oDaoDadoscomplementareslrf->c218_vldotatualizadaincentcontrib = $oParam->dadoscomplementares->c218_vldotatualizadaincentcontrib;
  $oDaoDadoscomplementareslrf->c218_vlempenhadoicentcontrib = $oParam->dadoscomplementares->c218_vlempenhadoicentcontrib;
  $oDaoDadoscomplementareslrf->c218_vldotatualizadaincentinstfinanc = $oParam->dadoscomplementares->c218_vldotatualizadaincentinstfinanc;
  $oDaoDadoscomplementareslrf->c218_vlempenhadoincentinstfinanc = $oParam->dadoscomplementares->c218_vlempenhadoincentinstfinanc;
  $oDaoDadoscomplementareslrf->c218_vlliqincentcontrib = $oParam->dadoscomplementares->c218_vlliqincentcontrib;
  $oDaoDadoscomplementareslrf->c218_vlliqincentinstfinanc = $oParam->dadoscomplementares->c218_vlliqincentinstfinanc;
  $oDaoDadoscomplementareslrf->c218_vlirpnpincentcontrib = $oParam->dadoscomplementares->c218_vlirpnpincentcontrib;
  $oDaoDadoscomplementareslrf->c218_vlirpnpincentinstfinanc = $oParam->dadoscomplementares->c218_vlirpnpincentinstfinanc;
  $oDaoDadoscomplementareslrf->c218_vlrecursosnaoaplicados = $oParam->dadoscomplementares->c218_vlrecursosnaoaplicados;
  $oDaoDadoscomplementareslrf->c218_vlapropiacaodepositosjudiciais = $oParam->dadoscomplementares->c218_vlapropiacaodepositosjudiciais;
  $oDaoDadoscomplementareslrf->c218_vloutrosajustes = $oParam->dadoscomplementares->c218_vloutrosajustes;
  $oDaoDadoscomplementareslrf->c218_metarrecada = $oParam->dadoscomplementares->c218_metarrecada;
  $oDaoDadoscomplementareslrf->c218_dscmedidasadotadas = $oParam->dadoscomplementares->c218_dscmedidasadotadas;

  if($oParam->alteracao){
    $oDaoDadoscomplementareslrf->alterar($oParam->dadoscomplementares->c218_sequencial);
  }else{
    $oDaoDadoscomplementareslrf->incluir(null);
  }
      //print_r($oDaoDadoscomplementareslrf);exit;
  if($oDaoDadoscomplementareslrf->erro_status == 0){
    $erro = true;
    $oRetorno->status = 2;
    $oRetorno->msg = $oDaoDadoscomplementareslrf->erro_msg;
  }else{

    if($iTipoInstit == 2){


      //INCLUI DO 20 E 30 SOMENTE SE FOR PREFEITURA

      if($oParam->dadoscomplementares->c218_mesusu == 12){
      //SÓ INCLUI SE O MES FOR 12

        //REGISTRO 20
        $oDaoOperacoesdecreditolrf->c219_dadoscomplementareslrf = $oDaoDadoscomplementareslrf->c218_sequencial;
        $oDaoOperacoesdecreditolrf->c219_contopcredito = $oParam->operacoesdecredito->c219_contopcredito;
        $oDaoOperacoesdecreditolrf->c219_dsccontopcredito = $oParam->operacoesdecredito->c219_dsccontopcredito;
        $oDaoOperacoesdecreditolrf->c219_realizopcredito = $oParam->operacoesdecredito->c219_realizopcredito;
        $oDaoOperacoesdecreditolrf->c219_tiporealizopcreditocapta = $oParam->operacoesdecredito->c219_tiporealizopcreditocapta;
        $oDaoOperacoesdecreditolrf->c219_tiporealizopcreditoreceb = $oParam->operacoesdecredito->c219_tiporealizopcreditoreceb;
        $oDaoOperacoesdecreditolrf->c219_tiporealizopcreditoassundir = $oParam->operacoesdecredito->c219_tiporealizopcreditoassundir;
        $oDaoOperacoesdecreditolrf->c219_tiporealizopcreditoassunobg = $oParam->operacoesdecredito->c219_tiporealizopcreditoassunobg;
        if($oParam->alteracao){
          $oDaoOperacoesdecreditolrf->alterar($oParam->dadoscomplementares->c218_sequencial);
        }else{
          $oDaoOperacoesdecreditolrf->incluir(null);
        }



        if($oDaoOperacoesdecreditolrf->erro_status == 0){
          $erro = true;
          $oRetorno->status = 2;
          $oRetorno->msg = $oDaoOperacoesdecreditolrf->erro_msg;
        }

      }
      if(!$erro){
        //REGISTRO 30
        $oDaoPublicacaoeperiodicidaderreo->c220_dadoscomplementareslrf = $oDaoDadoscomplementareslrf->c218_sequencial;
        $oDaoPublicacaoeperiodicidaderreo->c220_publiclrf = $oParam->publicacaoeperiodicidaderreo->c220_publiclrf;
        $oDaoPublicacaoeperiodicidaderreo->c220_dtpublicacaorelatoriolrf = $oParam->publicacaoeperiodicidaderreo->c220_dtpublicacaorelatoriolrf;
        $oDaoPublicacaoeperiodicidaderreo->c220_localpublicacao = $oParam->publicacaoeperiodicidaderreo->c220_localpublicacao;
        $oDaoPublicacaoeperiodicidaderreo->c220_tpbimestre = $oParam->publicacaoeperiodicidaderreo->c220_tpbimestre;
        $oDaoPublicacaoeperiodicidaderreo->c220_exerciciotpbimestre = $oParam->publicacaoeperiodicidaderreo->c220_exerciciotpbimestre;
        if($oParam->alteracao){
          $oDaoPublicacaoeperiodicidaderreo->alterar($oParam->dadoscomplementares->c218_sequencial);
        }else{
          $oDaoPublicacaoeperiodicidaderreo->incluir(null);
        }
        if($oDaoPublicacaoeperiodicidaderreo->erro_status == 0){
          $erro = true;
          $oRetorno->status = 2;
          $oRetorno->msg = $oDaoPublicacaoeperiodicidaderreo->erro_msg;
        }
      }
    }
    if(!$erro){

      //$result = $oDaoPublicacaoeperiodicidadergf->sql_record($oDaoPublicacaoeperiodicidadergf->sql_query_file(null,"c221_dadoscomplementareslrf",null,"c221_dadoscomplementareslrf = {$oDaoDadoscomplementareslrf->c218_sequencial}"));
      if(empty($oParam->dadoscomplementares->c218_sequencial)){
          $oDaoPublicacaoeperiodicidadergf->c221_dadoscomplementareslrf = $oDaoDadoscomplementareslrf->c218_sequencial;
      }else{
          $oDaoPublicacaoeperiodicidadergf->c221_dadoscomplementareslrf = $oParam->dadoscomplementares->c218_sequencial;
      }
      $oDaoPublicacaoeperiodicidadergf->c221_publicrgf = $oParam->publicacaoeperiodicidadergf->c221_publicrgf;
      $oDaoPublicacaoeperiodicidadergf->c221_dtpublicacaorelatoriorgf = $oParam->publicacaoeperiodicidadergf->c221_dtpublicacaorelatoriorgf;
      $oDaoPublicacaoeperiodicidadergf->c221_localpublicacaorgf = $oParam->publicacaoeperiodicidadergf->c221_localpublicacaorgf;
      $oDaoPublicacaoeperiodicidadergf->c221_tpperiodo = $oParam->publicacaoeperiodicidadergf->c221_tpperiodo;
      $oDaoPublicacaoeperiodicidadergf->c221_exerciciotpperiodo = $oParam->publicacaoeperiodicidadergf->c221_exerciciotpperiodo;

      if($oParam->alteracao){
          $oDaoPublicacaoeperiodicidadergf->alterar($oParam->dadoscomplementares->c218_sequencial);
      }else{
          $oDaoPublicacaoeperiodicidadergf->incluir();
     }


     if($oDaoPublicacaoeperiodicidadergf->erro_status == 0){
      $erro = true;
      $oRetorno->status = 2;
      $oRetorno->msg = $oDaoPublicacaoeperiodicidadergf->erro_msg;
    }

  }

  if(!$erro){
    $oRetorno->msg = "Inclusão realizada com sucesso.";
    if($oParam->alteracao){
      $oRetorno->msg = "Alteração realizada com sucesso.";
    }
  }

}
db_fim_transacao($erro);

break;
case 'excluirDados':
db_inicio_transacao();
if($iTipoInstit == 2){
  if($oParam->dadoscomplementares->c218_mesusu == 12){
    $oDaoOperacoesdecreditolrf->excluir($oParam->dadoscomplementares->c218_sequencial);
    if($oDaoOperacoesdecreditolrf->erro_status == 0){
      $erro = true;
      $oRetorno->status = 2;
      $oRetorno->msg = $oDaoOperacoesdecreditolrf->erro_msg;
    }
  }
  $oDaoPublicacaoeperiodicidaderreo->excluir($oParam->dadoscomplementares->c218_sequencial);
  if($oDaoPublicacaoeperiodicidaderreo->erro_status == 0){
    $erro = true;
    $oRetorno->status = 2;
    $oRetorno->msg = $oDaoPublicacaoeperiodicidaderreo->erro_msg;
  }
}
$oDaoPublicacaoeperiodicidadergf->excluir($oParam->dadoscomplementares->c218_sequencial);
if($oDaoPublicacaoeperiodicidadergf->erro_status == 0){
  $erro = true;
  $oRetorno->status = 2;
  $oRetorno->msg = $oDaoPublicacaoeperiodicidadergf->erro_msg;
}

$oDaoDadoscomplementareslrf->excluir($oParam->dadoscomplementares->c218_sequencial);
if($oDaoDadoscomplementareslrf->erro_status == 0){
  $erro = true;
  $oRetorno->status = 2;
  $oRetorno->msg = $oDaoDadoscomplementareslrf->erro_msg;
}

db_fim_transacao($erro);
if(!$erro){

 $oRetorno->msg = "Excluído";

}
break;
case 'getSaldo':

$oDaoDividaconsolidada = db_utils::getDao('dividaconsolidada');
//$oDividaconsolidada = $oDaoDividaconsolidada->sql_query_file(null,"*",null,'si167_mesreferencia = '.$oParam->mesReferencia.' AND si167_anoreferencia = '.db_getsession('DB_anousu').' AND si167_instit = '.db_getsession('DB_instit').' ');
$sSQL = "
  SELECT SUM(si167_vlsaldoatual) si167_vlsaldoatual
    FROM dividaconsolidada
     WHERE si167_anoreferencia = ".db_getsession('DB_anousu')."
      AND si167_mesreferencia = {$oParam->mesReferencia}
";

$oDividaconsolidada = $oDaoDividaconsolidada->sql_record($sSQL);
$oDividaconsolidada = db_utils::fieldsMemory($oDividaconsolidada);

$si167_vlsaldoatual = $oDividaconsolidada->si167_vlsaldoatual;
$oRetorno->si167_vlsaldoatual = $si167_vlsaldoatual;


break;
case 'getDados':


$oDadosComplementares = $oDaoDadoscomplementareslrf->sql_query($oParam->c218_sequencial);
$oDadosComplementares = $oDaoDadoscomplementareslrf->sql_record($oDadosComplementares);
$oDadosComplementares = db_utils::fieldsMemory($oDadosComplementares);

$oRetorno->dadoscomplementares = $oDadosComplementares;

break;
}
$oRetorno->msg = utf8_encode($oRetorno->msg);
echo $oJson->encode($oRetorno);
?>
