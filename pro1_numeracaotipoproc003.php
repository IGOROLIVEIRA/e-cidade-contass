<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_numeracaotipoproc_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clnumeracaotipoproc = new cl_numeracaotipoproc;
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $clnumeracaotipoproc->excluir($p200_codigo);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clnumeracaotipoproc->sql_record($clnumeracaotipoproc->sql_query($chavepesquisa)); 
   db_fieldsmemory($result,0);
   $p200_ano = db_getsession("DB_anousu");
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmnumeracaotipoproc.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($excluir)){
  if($clnumeracaotipoproc->erro_status=="0"){
    $clnumeracaotipoproc->erro(true,false);
  }else{
    $clnumeracaotipoproc->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
