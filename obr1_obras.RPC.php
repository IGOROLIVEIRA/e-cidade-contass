<?php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/DBTime.php");
require_once("std/DBDate.php");
require_once("classes/db_licobrasmedicao_classe.php");

db_app::import("configuracao.DBDepartamento");

$oJson             = new services_json();
//$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam           = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oErro             = new stdClass();

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$oRetorno->itens   = array();

switch($oParam->exec) {
  case 'salvarAnexo':

    echo "<pre>"; print_r($oParam);exit;
    $cllicobrasmedicao = new cl_licobrasmedicao();

    $cllicobrasmedicao->obr04_licobrasmedicao = $oParam->obr03_seqobra;
    $cllicobrasmedicao->obr04_codimagem       = 1;
    $cllicobrasmedicao->obr04_legenda         = $oParam->descricao;



    break;
}



?>
