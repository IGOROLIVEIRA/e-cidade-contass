<?php
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once("std/DBDate.php");
require_once("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
require_once('model/Siope.model.php');
require_once("classes/db_orcorgao_classe.php");

db_postmemory($_POST);

$oJson              = new services_json();

$oParam             = $oJson->decode(str_replace("\\","",$_POST["json"]));
$iBimestre          = (!empty($oParam->bimestre)) ? $oParam->bimestre : '';

$iInstit            = db_getsession('DB_instit');
$iAnoUsu            = date("Y", db_getsession("DB_datausu"));

$oRetorno           = new stdClass();
$oRetorno->status   = 1;
$sNomeArq           = "Siope";

switch ($oParam->exec) {

    case 'gerarSiope':

        try {

            $siope = new Siope;
            $siope->setAno($iAnoUsu);
            $siope->setInstit($iInstit);
            $siope->setBimestre($iBimestre);
            $siope->setPeriodo($iBimestre);
            $siope->setFiltros();
            $siope->setDespesas();
            $siope->montaTabela();

        } catch(Exception $eErro) {

            $oRetorno->status  = 2;
            $sGetMessage       = "Arquivo:{$sNomeArq} retornou com erro: \n \n {$eErro->getMessage()}";
            $oRetorno->message = $sGetMessage;

        }

        break;

}

if ($oRetorno->status == 2) {
    $oRetorno->message = utf8_encode($oRetorno->message);
}
echo $oJson->encode($oRetorno);
