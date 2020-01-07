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
require_once("classes/db_licobrasanexo_classe.php");

db_app::import("configuracao.DBDepartamento");

$oJson             = new services_json();
//$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam           = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oErro             = new stdClass();

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;

switch($oParam->exec) {

  case 'getAnexos':

    $cllicobrasanexos = new cl_licobrasanexo();
    $resultAnexos = $cllicobrasanexos->sql_record($cllicobrasanexos->sql_query(null,"*",null,"obr04_licobrasmedicao = $oParam->codmedicao"));

    for ($iCont = 0; $iCont < pg_num_rows($resultAnexos); $iCont++) {
      $oDadosAnexo = db_utils::fieldsMemory($resultAnexos, $iCont);

        $oDocumentos      = new stdClass();
        $oDocumentos->iCodigo    = $oDadosAnexo->obr04_sequencial;
        $oDocumentos->sLegenda   = $oDadosAnexo->obr04_legenda;
        $oRetorno->dados[] = $oDocumentos;
    }

    $oRetorno->detalhe    = "documentos";

    break;
}
echo json_encode($oRetorno);


?>
