<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/JSON.php");
require_once("libs/db_utils.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
 //header("Content-Type: text/html;  charset=ISO-8859-1",true);

//$observacao=utf8_decode($_POST['observacao']);

$codigo=$_POST['codigo'];

$sql =" update solicita set pc10_resumo='".utf8_decode($observacao)."' where pc10_numero in(select pc10_numero from solicita ";      
$sql.=" inner join solicitem    on  solicita.pc10_numero = solicitem.pc11_numero ";      
$sql.=" left  join pcprocitem   on  solicitem.pc11_codigo = pcprocitem.pc81_solicitem ";      
$sql.=" left  join liclicitem   on  pcprocitem.pc81_codprocitem = l21_codpcprocitem  ";
$sql.=" left  join liclicita    on  l21_codliclicita = l20_codigo     ";
$sql.=" where l20_codigo =$codigo	) "; 

 
 $result = db_query($sql);

?>