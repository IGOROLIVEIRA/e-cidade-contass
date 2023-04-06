<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_linhafrequencia_classe.php");
include("dbforms/db_funcoes.php");

require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");

db_postmemory($HTTP_POST_VARS);
$cllinhafrequencia = new cl_linhafrequencia;
$db_opcao = 1;
$db_botao = true;

if(isset($incluir)){
  db_inicio_transacao();
  $cllinhafrequencia->incluir();
  db_fim_transacao();
}
if(isset($mudarAba)){

}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<?php
      db_app::load("prototype.js, scripts.js, strings.js, arrays.js, DBAbas.widget.js, datagrid.widget.js");
      db_app::load("prototype.maskedinput.js");
      db_app::load("estilos.css");
  ?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
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
	require_once ("forms/db_frmlinhafrequencia.php");
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
<script>
// js_tabulacaoforms("form1","tre13_linhatransporte",true,1,"tre13_linhatransporte",true);
</script>
<?
if(isset($incluir)){
  if($cllinhafrequencia->erro_status=="0"){
    $cllinhafrequencia->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllinhafrequencia->erro_campo!=""){
      echo "<script> document.form1.".$cllinhafrequencia->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllinhafrequencia->erro_campo.".focus();</script>";
    }
  }else{
    $cllinhafrequencia->erro(true,true);
  }
}
?>
