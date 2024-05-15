<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_contratos_classe.php");
require_once("libs/JSON.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clcontratos = new cl_contratos;

$oJson    = new services_json();
$oParam   = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$aNrocontrato = explode("/", $oParam->nrocontrato);
$sql = $clcontratos->sql_query_file(null,"si172_dataassinatura","contratos.si172_sequencial","si172_nrocontrato = {$aNrocontrato[0]} and si172_exerciciocontrato = {$aNrocontrato[1]}");
$result = db_query($sql);
$oRetorno->si172_dataassinatura = implode("/", array_reverse(explode("-", db_utils::fieldsMemory($result, 0)->si172_dataassinatura)));

echo $oJson->encode($oRetorno);