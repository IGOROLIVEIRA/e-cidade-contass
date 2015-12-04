<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas = new cl_criaabas;
$db_opcao = 1;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="18"  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
 <tr>
  <td>&nbsp;</td>
 </tr>
</table>
<form name="formaba">
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
   <?
   MsgAviso(db_getsession("DB_coddepto"),"escola");
   $clcriaabas->identifica = array("a1"=>"Dados Pessoais","a2"=>"Outros Dados","a3"=>"Cursos","a4"=>"Documentos Pendentes","a5"=>"Necessidades Especiais","a6"=>"Histórico");
   $clcriaabas->sizecampo  = array("a1"=>"15","a2"=>"10","a3"=>"15","a4"=>"25","a5"=>"25","a6"=>"15");
   $clcriaabas->src        = array("a1"=>"edu1_alunodados003.php","a2"=>"","a3"=>"","a4"=>"","a5"=>"","a6"=>"");
   $clcriaabas->disabled   = array("a2"=>"true","a3"=>"true","a4"=>"true","a5"=>"true","a6"=>"true");
   $clcriaabas->cordisabled = "#9b9b9b";
   $clcriaabas->scrolling = "no";
   $clcriaabas->cria_abas();
   ?>
  </td>
 </tr>
</table>
</form>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
