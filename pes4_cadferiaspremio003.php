<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_cadferiaspremio_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clcadferiaspremio = new cl_cadferiaspremio;
if(isset($excluir)){
  db_inicio_transacao();
  $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query($r95_sequencial));
  db_fieldsmemory($result,0);
  $clcadferiaspremio->excluir(null, "r95_regist = {$r95_regist} and r95_perai = '{$r95_perai}' and r95_peraf = '{$r95_peraf}'");
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $result = $clcadferiaspremio->sql_record($clcadferiaspremio->sql_query($chavepesquisa));
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="360" height="30">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<center>
<table width="40%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
	<?
	include("forms/db_frmcadferiaspremio003.php");
	?>
	</td>
  </tr>
</table>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($excluir)){
  if($clcadferiaspremio->erro_status=="0"){
    $clcadferiaspremio->erro(true,false);
  }else{
    db_msgbox("Exclusão efetuada com sucesso! \n\n Considere recalcular a folha para a matrícula $r95_regist.");
    echo "<script>location.href = 'pes4_cadferiaspremio003.php';</script>";
  }
}
if(!isset($chavepesquisa)) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
