<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("dbforms/db_layouttxt.php");

db_sel_instit();

$nomearq = "tmp/CAGED.TXT";
$cldb_layouttxr = new db_layouttxt(6,$nomearq,"C,X");


//////////////////////////////////////////////////////////////////
//   PARA CADA TIPO LINHA, DEVE IR ESTE CÓDIGO COMENTADO
//   *** Se tiver identificador da linha, utiliza o código abaixo:
//       --- $cldb_layouttxr->setCampoIdentLinha("X"); 
$cldb_layouttxr->setCampoTipoLinha(1);
//////////////////////////////////////////////////////////////////


$cldb_layouttxr->setCampo("cgc",$cgc);
$cldb_layouttxr->setCampo("nomeinst",$nomeinst);
$cldb_layouttxr->setCampo("ender",$ender);
$cldb_layouttxr->setCampo("uf",$uf);
$cldb_layouttxr->setCampo("cep",$cep);
$cldb_layouttxr->setCampo("telefone","34580497");
$cldb_layouttxr->setCampo("autorizacao",11111111);
$cldb_layouttxr->setCampo("digautoriza",22222222);
$cldb_layouttxr->setCampo("mesano","2006-01-01");
$cldb_layouttxr->setCampo("alteracao",33333333);
$cldb_layouttxr->setCampo("sequencia",44444444);
$cldb_layouttxr->setCampo("totalmovimentos",55555555);
$cldb_layouttxr->geraDadosLinha();
?>
