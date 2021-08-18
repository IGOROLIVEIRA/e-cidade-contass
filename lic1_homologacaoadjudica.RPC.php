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
require_once("classes/db_homologacaoadjudica_classe.php");

db_app::import("configuracao.DBDepartamento");
$oJson             = new services_json();
//$oParam          = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;


switch($oParam->exec) {
    case 'adjudicar':

        break;

    case 'getItens':
        $clhomologacaoadjudica = new cl_homologacaoadjudica();
        $campos = "DISTINCT pc01_codmater,pc01_descrmater,cgmforncedor.z01_nome,m61_descr,pc11_quant,pc23_valor";
        $sWhere = " liclicitem.l21_codliclicita = {$oParam->iLicitacao} and pc24_pontuacao = 1 ";
        $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens(null,$campos,null,$sWhere));
        for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {
            $oItensLicitacao = db_utils::fieldsMemory($result, $iCont);

            $oRetorno->itens[] = $oItensLicitacao;
        }
        break;
}
echo json_encode($oRetorno);
