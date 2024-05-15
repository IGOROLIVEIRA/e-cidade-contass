<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_percentualaquisicao_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clpercentualaquisicao = new cl_percentualaquisicao;
$db_opcao = 1;
$db_botao = true;
$result = $clpercentualaquisicao->sql_record($clpercentualaquisicao->sql_query(null,"*",null,"si90_anoreferencia = ".db_getsession("DB_anousu")));
if(isset($incluir) && pg_num_rows($result) == 0){
  db_inicio_transacao();
  $clpercentualaquisicao->incluir($si90_sequencial);
  db_fim_transacao();
} else if(isset($incluir) && pg_num_rows($result) > 0){
  db_inicio_transacao();
  $clpercentualaquisicao->alterar($si90_sequencial);
  db_fim_transacao();
} else if(isset($excluir)){
  db_inicio_transacao();
  $clpercentualaquisicao->excluir($si90_sequencial);
  db_fim_transacao();
}
$result = db_query($clpercentualaquisicao->sql_query(null,"*",null,"si90_anoreferencia = ".db_getsession("DB_anousu")));
if (pg_num_rows($result) > 0) {
  db_fieldsmemory($result, 0);
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmpercentualaquisicao.php");
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
js_tabulacaoforms("form1","si90_contemplaperc",true,1,"si90_contemplaperc",true);
</script>
<?
if(isset($incluir)){
  if($clpercentualaquisicao->erro_status=="0"){
    $clpercentualaquisicao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clpercentualaquisicao->erro_campo!=""){
      echo "<script> document.form1.".$clpercentualaquisicao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clpercentualaquisicao->erro_campo.".focus();</script>";
    }
  }else{
    $clpercentualaquisicao->erro(true,true);
  }
}
if(isset($excluir)){
  if($clpercentualaquisicao->erro_status=="0"){
    $clpercentualaquisicao->erro(true,false);
  }else{
    $clpercentualaquisicao->erro(true,true);
  }
}
?>
