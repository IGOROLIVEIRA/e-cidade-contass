<?php
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("std/DBDate.php");
require_once('model/MSC.model.php');
db_postmemory($_POST);

$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

$iInstit = db_getsession('DB_instit');
$iAnoUsu = date("Y", db_getsession("DB_datausu"));

$iMes     = (!empty($oParam->mes))     ? $oParam->mes     : '';
$sMatriz  = (!empty($oParam->matriz))  ? $oParam->matriz  : '';
$sFormato = (!empty($oParam->formato)) ? $oParam->formato : '';

$sSQL = "select si09_instsiconfi from infocomplementaresinstit where si09_instit = ".db_getsession("DB_instit");


$sIndetifier = db_utils::fieldsMemory(db_query($sSQL),0)->si09_instsiconfi;
$sEntriesType = "trialbalance";
$sPeriodIdentifier = "$iAnoUsu-$iMes";
$sPeriodStart = $sPeriodDescription = "$iAnoUsu-$iMes-01";
$sPeriodEnd = "$iAnoUsu-$iMes-".cal_days_in_month(CAL_GREGORIAN, $iMes, $iAnoUsu);
$sNomeArq = "MSC";

switch ($oParam->exec) {
  
  case 'gerarMsc':

    try {
      
      $msc = new MSC;

      $msc->setIndetifier($sIndetifier);
      $msc->setEntriesType($sEntriesType);
      $msc->setPeriodIdentifier($sPeriodIdentifier);
      $msc->setPeriodDescription($sPeriodDescription);
      $msc->setPeriodStart($sPeriodStart);
      $msc->setPeriodEnd($sPeriodEnd);
      $msc->setNomeArq($sNomeArq."$iAnoUsu$iMes");
      $msc->gerarMSC($iAnoUsu, $iMes, $sFormato);
      
      if ($msc->getErroSQL()) {
        throw new Exception ("Ocorreu um erro na consulta!");
      }

      $oRetorno->caminho = $oRetorno->nome = ($sFormato == 'csv') ? "{$msc->getNomeArq()}.csv" : "{$msc->getNomeArq()}.xml";
      
      system("rm -f {$msc->getNomeArq()}.zip");
      system("bin/zip -q {$msc->getNomeArq()}.zip $oRetorno->caminho");
      $oRetorno->caminhoZip = $oRetorno->nomeZip = "{$msc->getNomeArq()}.zip";
    
    } catch(Exception $eErro) {

      $oRetorno->status  = 2;
      $sGetMessage       = "Arquivo:{$sNomeArq} retornou com erro: \\n \\n {$eErro->getMessage()}";
      $oRetorno->message = $sGetMessage;

    }

    break;

}

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);