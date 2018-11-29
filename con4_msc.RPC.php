<?php
require_once ('model/MSCXbrl.model.php');
require_once ("std/db_stdClass.php");
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");
require_once ("libs/JSON.php");
require_once ("std/DBDate.php");
//echo "<pre>"; ini_set("display_errors", true);
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

$sIndetifier = "4214805EX";
$sEntriesType = "trialbalance";
$sPeriodIdentifier = "$iAnoUsu-$iMes"; //date("Y-m", strtotime("$iAnoUsu-$iMes"));//"2018-03";
$sPeriodStart = $sPeriodDescription = "$iAnoUsu-$iMes-01";//date("Y-m", strtotime("$iAnoUsu-$iMes-01"));//"2018-03-01"
$sPeriodEnd = "$iAnoUsu-$iMes-".cal_days_in_month(CAL_GREGORIAN, $iMes, $iAnoUsu);//"2018-03-31";
$sNomeArq = "msc";


switch ($oParam->exec){
  
  case 'gerarMsc':

      switch ($sFormato) {

        case 'xbrl' :

          try {

            $xbrl = new MSCXbrl;

            $xbrl->setIndetifier($sIndetifier);
            $xbrl->setEntriesType($sEntriesType);
            $xbrl->setPeriodIdentifier($sPeriodIdentifier);
            $xbrl->setPeriodDescription($sPeriodDescription);
            $xbrl->setPeriodStart($sPeriodStart);
            $xbrl->setPeriodEnd($sPeriodEnd);
            $xbrl->setNomeArq($sNomeArq);
            $xbrl->gerarArquivo($iAnoUsu, $iMes);
     
            $oRetorno->caminho = $xbrl->getCaminhoArq();
            $oRetorno->nome    = $sNomeArq;

          } catch(Exception $eErro) {

            $oRetorno->status  = 2;
            $sGetMessage       = "Arquivo:{$sNomeArq} retornou com erro: \\n \\n {$eErro->getMessage()}";
            $oRetorno->message = urlencode(str_replace("\\n", "\n",$sGetMessage));

          }

        break;

      }

    break;

}



if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);