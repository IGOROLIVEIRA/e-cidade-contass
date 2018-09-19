<?php

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
require ("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_liborcamento.php");
include("classes/db_empautidot_classe.php");
include("classes/db_orcsuplemval_classe.php");
include("classes/db_orcdotacao_classe.php");
include("classes/db_orcreserva_classe.php");
include("classes/db_orcreservaaut_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_empautitem_classe.php");
include("classes/db_condataconf_classe.php");

require_once("libs/JSON.php");

$x = str_replace('\\','',$_POST);
$x = json_decode($x['json']);

$clcondataconf = new cl_condataconf;
$resultControle = $clcondataconf->sql_record($clcondataconf->sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit'),'c99_data'));
db_fieldsmemory($resultControle,0);
$dtSistema = date("Y-m-d", db_getsession("DB_datausu"));

if($x->consultarDataDoSistema == true){

  echo json_encode(array(
    "dataDoSistema" => $dtSistema,
    "dataFechamentoContabil" => $c99_data,
    "chave1" => $x->chave1
  ));
}