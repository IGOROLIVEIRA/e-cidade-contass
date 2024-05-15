<?php
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("std/db_stdClass.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("dbforms/db_funcoes.php");
include("libs/JSON.php");
include("model/empenhoFolha.model.php");
include("libs/db_liborcamento.php");
$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";
$oRetorno->itens   = array();
if ($oParam->exec == "anularEmpenho") {
  
  /**
   * selecionamos todos os empenhos do tipo que tenham empenho gerados e anulamos
   */
  $sSqlEmpenhos   = "SELECT rh72_sequencial, ";
  $sSqlEmpenhos  .= "       rh72_coddot, ";
  $sSqlEmpenhos  .= "       rh72_codele, ";
  $sSqlEmpenhos  .= "       rh72_unidade, ";
  $sSqlEmpenhos  .= "       rh72_orgao, ";
  $sSqlEmpenhos  .= "       rh72_projativ, ";
  $sSqlEmpenhos  .= "       rh72_anousu, ";
  $sSqlEmpenhos  .= "       rh72_mesusu, ";
  $sSqlEmpenhos  .= "       rh72_recurso, ";
  $sSqlEmpenhos  .= "       rh72_siglaarq,";
  $sSqlEmpenhos  .= "       round(sum(rh73_valor), 2) as valorretencao ";
  $sSqlEmpenhos  .= "  from rhempenhofolha "; 
  $sSqlEmpenhos  .= "       inner join rhempenhofolharhemprubrica        on rh81_rhempenhofolha = rh72_sequencial "; 
  $sSqlEmpenhos  .= "       inner join rhempenhofolharubrica  on rh73_sequencial     = rh81_rhempenhofolharubrica ";
  $sSqlEmpenhos  .= "       inner join rhpessoalmov           on rh73_seqpes     = rh02_seqpes  ";
  $sSqlEmpenhos  .= "                                        and rh73_instit     = rh02_instit ";
  $sSqlEmpenhos  .= "       inner join  rhempenhofolhaempenho on rh72_sequencial = rh76_rhempenhofolha ";
  $sSqlEmpenhos  .= "     and rh72_tipoempenho = {$oParam->iTipo}";
  $sSqlEmpenhos  .= "     and rh73_tiporubrica = 1";
  $sSqlEmpenhos  .= "     and rh73_instit = " . db_getsession("DB_instit");
  $sSqlEmpenhos  .= "     and rh72_anousu      = {$oParam->iAnoFolha}"; 
  $sSqlEmpenhos  .= "     and rh72_mesusu      = {$oParam->iMesFolha}"; 
  $sSqlEmpenhos  .= "     and rh72_siglaarq    = '{$oParam->sSigla}'";
  if ($oParam->sSigla == 'r20' && $oParam->iTipo == 1) {
    
    $sListaRescisoes = implode(",", $oParam->aRescisoes);
    $sSqlEmpenhos .= " and rh73_seqpes in({$sListaRescisoes})"; 
  }
  $sSqlEmpenhos  .= "   group by rh72_sequencial,  ";
  $sSqlEmpenhos  .= "            rh72_coddot,  ";
  $sSqlEmpenhos  .= "            rh72_codele, ";
  $sSqlEmpenhos  .= "            rh72_unidade, ";
  $sSqlEmpenhos  .= "            rh72_orgao, ";
  $sSqlEmpenhos  .= "            rh72_projativ, ";
  $sSqlEmpenhos  .= "            rh72_mesusu, ";
  $sSqlEmpenhos  .= "            rh72_anousu, ";
  $sSqlEmpenhos  .= "            rh72_recurso, ";
  $sSqlEmpenhos  .= "            rh72_siglaarq";
  $rsDadosEmpenho     = db_query($sSqlEmpenhos);
  $aEmpenhos          = db_utils::getColectionByRecord($rsDadosEmpenho);
  if (count($aEmpenhos) == 0) {
   
    $oRetorno->status  = 2;    
    $oRetorno->message = "Não foram encontrados empenhos gerados";
        
  } else {
    
    try {

      db_inicio_transacao();
      foreach ($aEmpenhos as $oEmpenho) {
        
        $oEmpenhoFolha = new empenhoFolha($oEmpenho->rh72_sequencial);
        $oEmpenhoFolha->estornarEmpenho();
        
      }
      /**
       * Marcamos as rescisoes como não Empenhadas
       */
      if ($oParam->sSigla == 'r20' && $oParam->iTipo == 1) {
     
        foreach ($oParam->aRescisoes as $iRescisao) {
        
          $oDaoPesRescisao = db_utils::getDao("rhpesrescisao");
          $oDaoPesRescisao->rh05_empenhado = "false";
          $oDaoPesRescisao->rh05_seqpes    = $iRescisao;
          $oDaoPesRescisao->alterar($iRescisao);
        }
      }
      db_fim_transacao(false);
    } catch (Exception $eErro) {
      
      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
      
    }
  }
}
echo $oJson->encode($oRetorno);
?>