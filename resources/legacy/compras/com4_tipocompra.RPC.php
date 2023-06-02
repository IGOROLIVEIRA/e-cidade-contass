<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
require_once("model/compras/TipoCompra.model.php");
require_once("classes/db_pctipocompra_classe.php");

$oJson    = new services_json();
$oRetorno = new stdClass();
$oParam   = json_decode(str_replace('\\', '', $_POST["json"]));
$oRetorno->status   = 1;
$oRetorno->message  = '';
$oRetorno->tipocompratribunal = null;

switch($oParam->sExecucao) {

    case "getTipocompratribunal":

        $oTipocompra = new TipoCompra($oParam->Codtipocom);
        $oRetorno->tipocompratribunal = $oTipocompra->getCodigoTribunal();
        $oRetorno->tipocompra = $oTipocompra->getCodigo();
        break;

    /**
     * aqui pego tipo compra pelo codigo do tribunal
     */

    case "getTipocompra":
        $clpctipocompra = new cl_pctipocompra();
        $result = $clpctipocompra->sql_record($clpctipocompra->sql_query_file("","pc50_codcom",null,"pc50_pctipocompratribunal = {$oParam->oTipocompratribunal}"));
        db_fieldsmemory($result,0);
        if($result != null){
            $oRetorno->tipocompra = $pc50_codcom;
        }else{
            $oRetorno->tipocompra = 7;
        }
        break;
}
echo $oJson->encode($oRetorno);
?>