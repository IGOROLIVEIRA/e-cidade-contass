<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_controleext_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clcontroleext = new cl_controleext;
$db_opcao = 22;
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clcontroleext->alterar($k167_sequencial);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clcontroleext->sql_record($clcontroleext->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);
   $db_botao = true;
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin-left: auto; margin-right: auto; margin-top: 20px;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmcontroleext.php");
  ?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){

  if($clcontroleext->erro_status=="0"){
    $clcontroleext->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcontroleext->erro_campo!=""){
      echo "<script> document.form1.".$clcontroleext->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcontroleext->erro_campo.".focus();</script>";
    }

  }else{
    $clcontroleext->erro(true,false);
  }

}
if ($db_opcao == 22) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","k167_codcon",true,1,"k167_codcon",true);
</script>
