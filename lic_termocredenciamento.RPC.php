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

        $sqlFornecedor = "SELECT DISTINCT z01_numcgm,
                                          z01_nome
                        FROM liclicita
                        INNER JOIN liclicitem ON l21_codliclicita=l20_codigo
                        INNER JOIN pcorcamitemlic ON pc26_liclicitem=l21_codigo
                        INNER JOIN pcorcamitem ON pc22_orcamitem=pc26_orcamitem
                        INNER JOIN pcorcamjulg ON pc24_orcamitem=pc22_orcamitem
                        INNER JOIN pcorcamforne ON pc21_orcamforne=pc24_orcamforne
                        INNER JOIN pcorcamval ON pc23_orcamitem=pc22_orcamitem
                        INNER JOIN cgm ON z01_numcgm=pc21_numcgm
                        WHERE l20_codigo={$licitacao} and pc24_pontuacao=1;";
        $rsFornecedor  = db_query($sqlFornecedor);

        $oFornecedor = db_utils::getCollectionByRecord($rsFornecedor);
        $oRetorno->fornecedores = $oFornecedor;

    break;
}
echo $oJson->encode($oRetorno);
