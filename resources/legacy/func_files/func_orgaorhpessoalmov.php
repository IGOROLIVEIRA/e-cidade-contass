<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$sql = "select o40_orgao,o40_descr from rhlotaexe inner join orcunidade on orcunidade.o41_anousu = rhlotaexe.rh26_anousu and orcunidade.o41_orgao = rhlotaexe.rh26_orgao and orcunidade.o41_unidade = rhlotaexe.rh26_unidade inner join orcorgao on orcorgao.o40_anousu = orcunidade.o41_anousu and orcorgao.o40_orgao = orcunidade.o41_orgao where rhlotaexe.rh26_anousu = ". db_getsession("DB_anousu") ." and rhlotaexe.rh26_codigo = ".$codigolota.";"; 
$result_orgao = db_query($sql);
$obj = db_utils::fieldsMemory($result_orgao, 0);

echo json_encode($obj);
 