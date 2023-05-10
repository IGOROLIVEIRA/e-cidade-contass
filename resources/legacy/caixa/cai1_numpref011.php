<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_numpref_classe.php");
require_once("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clnumpref = new cl_numpref;
$db_opcao = 1;
$db_botao = true;
$instit = db_getsession("DB_instit");
$ano = db_getsession('DB_anousu');
$clnumpref->k03_instit = $instit;
$rsResult = $clnumpref->sql_record($clnumpref->sql_query($ano,$instit));
$intNumrows = $clnumpref->numrows;
if($intNumrows > 0){
  db_redireciona('cai1_numpref022.php');
}
if(isset($incluir)){
  db_inicio_transacao();
  $clnumpref->k03_instit = $instit;
  $clnumpref->incluir($k03_anousu,$instit);
  db_fim_transacao();
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="430" align="center" valign="top" bgcolor="#CCCCCC">
    <center>
        <?php
	include("forms/db_frmnumpref.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?php
if(isset($incluir)){
  if($clnumpref->erro_status=="0"){
    $clnumpref->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clnumpref->erro_campo!=""){
      echo "<script> document.form1.".$clnumpref->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clnumpref->erro_campo.".focus();</script>";
    };
  }else{
    $clnumpref->erro(true,true);
  };
};
?>