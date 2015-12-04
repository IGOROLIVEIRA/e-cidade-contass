<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

if(isset($HTTP_POST_VARS["enviar"])) {
  db_postmemory($HTTP_POST_VARS);
  $k13_saldo = $k13_saldo==""?"null":$k13_saldo;
  $k13_vlratu = $k13_vlratu==""?"null":$k13_vlratu;
  $k13_datvlr = $k13_datvlr_ano."-".$k13_datvlr_mes."-".$k13_datvlr_dia;
  $k13_datvlr = trim($k13_datvlr)=="--"?"null":"'$k13_datvlr'";
  pg_exec("BEGIN");
  $result = pg_exec("select c01_estrut,c01_descr from plano where c01_anousu = ".db_getsession("DB_anousu")." and c01_reduz = $k13_conta");
  db_fieldsmemory($result,0);
  pg_exec("insert into saltes(k13_conta,k13_saldo,k13_ident,k13_vlratu,k13_datvlr,k13_descr)
                       values($k13_conta,$k13_saldo,'$k13_ident',$k13_vlratu,$k13_datvlr,'$c01_descr')") or die("Erro(14) inserindo em saltes:");
  pg_exec("insert into saltesplan (k13_conta,c01_anousu,c01_reduz,c01_estrut)  
                       values($k13_conta,".db_getsession("DB_anousu").",$k13_conta,$c01_estrut)") or die("Erro(14) inserindo em saltesplan:");
  pg_exec("END");
  db_redireciona();
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
<?
    include("forms/db_frmsaltes.php");
?>	
	</td>
  </tr>
</table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>  
</body>
</html>
