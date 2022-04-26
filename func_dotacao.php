<?
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require("libs/db_liborcamento.php");
include("libs/db_usuariosonline.php");


$oParam            = json_decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->dotacao = $oParam->dotacao;
$elemento = null;
$secretaria = null;
$departamento = null;


$erro = "";
$clpermusuario_dotacao =  new cl_permusuario_dotacao(
  db_getsession('DB_anousu'),
  db_getsession('DB_id_usuario'),
  $elemento,
  $secretaria,
  $departamento,
  'M',
  "",
  $sWhere
);

if ($clpermusuario_dotacao->sql != "") {

  $result = pg_query($clpermusuario_dotacao->sql);
  $tem_perm = 0;
  for ($i = 0; $i < pg_numrows($result); $i++) {
    if ($oParam->dotacao == pg_result($result, $i, "o58_coddot")) {
      $tem_perm = 1;
    }
  }
  if ($tem_perm == 1) {
  } else {
    $erro = "Sem permissão para esta dotação!";
  }
}

$rsResult = db_query("select * from orcdotacao where o58_coddot = $oParam->dotacao");
$projativ = db_utils::fieldsMemory($rsResult, 0)->o58_projativ;
$result = db_query("select * from orcprojativ where o55_projativ = $projativ and o55_anousu = 2022 ");
$descricao = db_utils::fieldsMemory($result, 0)->o55_descr;

$oRetorno->dotacao = $projativ;
$oRetorno->descricao = $descricao;
$oRetorno->descricao = utf8_encode($descricao);
$oRetorno->erro = $erro;
echo json_encode($oRetorno);
