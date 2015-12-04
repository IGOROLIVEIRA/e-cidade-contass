<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_liborcamento.php");
include("dbforms/db_classesgenericas.php");

$clcriaabas      = new cl_criaabas;

$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt21');
$clrotulo->label('DBtxt22');


db_postmemory($HTTP_POST_VARS);

$abas    = array();
$titulos = array();
$fontes  = array();
$sizecp  = array();

if (db_getsession("DB_anousu") == 2008){
  $codrel = 27; // relatorio de gastos com MDE	

}elseif(db_getsession("DB_anousu") < 2008){
  $codrel = 5;
}elseif(db_getsession("DB_anousu") > 2008){
$codrel = 59;
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
    <?
    $clcriaabas->identifica = array("relatorio"=>"Relatorio", "notas"=>"Notas Explicativas", "parametro"=>"Parametros");
    $clcriaabas->title      = array("relatorio"=>"Relatorio","parametro"=>"Parametros");
    $clcriaabas->src  = array("relatorio" => "con2_lrfreceitacorrente011.php",
	                  		      "parametro" => "con2_conrelparametros.php?c83_codrel=$codrel",
                              "notas"     => "con2_conrelnotas.php?c83_codrel=$codrel",
                             );
    $clcriaabas->sizecampo= array("relatorio"=>"23","notas" => 23, "parametro"=>"23");
    $clcriaabas->cria_abas();    
    ?>
    </center>
  </td>
  </tr>
</table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
