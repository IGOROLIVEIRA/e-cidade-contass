<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
include("libs/db_libcontabilidade.php");
include("classes/db_projecaoatuarial20_classe.php");
include("classes/db_projecaoatuarial10_classe.php");

$clprojecaoatuarial20 = new cl_projecaoatuarial20;
$clprojecaoatuarial10 = new cl_projecaoatuarial10;

$oJson    = new services_json();
$oRetorno = new stdClass();

$oParam   = json_decode(str_replace('\\', '',$_POST["json"]));
$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';

try{
    switch($oParam->exec) {

        case "salvar":
            echo "<pre>"; print_r($oParam);exit;
        break;

        case "getItens":

            $aItens      = array();

            $result = $clprojecaoatuarial20->sql_record($clprojecaoatuarial20->sql_query(null,"*",null,"si169_projecaoatuarial10={$oParam->codigo} and si169_tipoplano = {$oParam->tipoplano} order by si169_exercicio"));          
            for ($iContItens = 0; $iContItens < pg_num_rows($result); $iContItens++) {
                $oItens = db_utils::fieldsMemory($result, $iContItens);
                $aItens[] = $oItens;

                $oRetorno->itens  = $aItens;
            }
        break;
    }

} catch (Exception $eErro) {

    db_fim_transacao (true);
    $oRetorno->erro  = true;
    $oRetorno->message = urlencode($eErro->getMessage());
}

echo $oJson->encode($oRetorno);
