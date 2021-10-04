<?php
require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");

$oJson                = new services_json();
$oParam               = $oJson->decode(str_replace("\\", "", $_POST["json"]));

switch ($_POST["action"]) {

    case 'getFornecedores':

        $licitacao       = $_POST["l212_licitacao"];
        $iAnoSessao      = db_getsession('DB_anousu');

        $sqlFornecedor = "SELECT z01_numcgm,
                                 z01_nome
            FROM credenciamento
            INNER JOIN cgm ON z01_numcgm = l205_fornecedor
            WHERE l205_licitacao ={$licitacao}";
        $rsFornecedor  = db_query($sqlFornecedor);

        $oFornecedor = db_utils::getCollectionByRecord($rsFornecedor);
        $oRetorno->fornecedores = $oFornecedor;

    break;
}
echo $oJson->encode($oRetorno);
