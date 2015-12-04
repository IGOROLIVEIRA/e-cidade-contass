<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

if(isset($HTTP_POST_VARS["excluir"])) {
  
  pg_exec("BEGIN");
  
  pg_exec("delete from saltesplan where k13_conta = ".$HTTP_POST_VARS["k13_conta"]) or die("Erro(8) excluindo saltesplan");
  pg_exec("delete from saltes where k13_conta = ".$HTTP_POST_VARS["k13_conta"]) or die("Erro(8) excluindo saltes");
  
  pg_exec("END");
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<form name="form1" method="post">
    <?=db_contas("k13_conta","",2)?>
    <input type="submit" name="excluir" value="Excluir" onClick="return confirm('Quer realmente excluir este registro?')">
  </form>
  </center>
	</td>
  </tr>
</table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
