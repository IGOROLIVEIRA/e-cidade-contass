<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_tipoquestaoaudit_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);

$cltipoquestaoaudit = new cl_tipoquestaoaudit;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  $sqlerro = false;
  db_inicio_transacao();
  $cltipoquestaoaudit->ci01_instit = db_getsession('DB_instit');
  $cltipoquestaoaudit->incluir($ci01_codtipo);
  if($cltipoquestaoaudit->erro_status=="0"){
    $sqlerro = true;
  }
  db_fim_transacao($sqlerro);
  
  $ci01_codtipo = $cltipoquestaoaudit->ci01_codtipo;
  $db_opcao = 1;
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
<table width="390" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmtipoquestaoaudit.php");
	?>
    </center>
	</td>
  </tr>
</table>

</body>
</html>
<script>
js_tabulacaoforms("form1","ci01_tipoaudit",true,1,"ci01_tipoaudit",true);
</script>
<?
if(isset($incluir)){
  if($cltipoquestaoaudit->erro_status=="0"){

    $cltipoquestaoaudit->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cltipoquestaoaudit->erro_campo!=""){
      echo "<script> document.form1.".$cltipoquestaoaudit->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cltipoquestaoaudit->erro_campo.".focus();</script>";
    }
  }else{
    db_msgbox($cltipoquestaoaudit->erro_msg);
    db_redireciona("cin1_tipoquestaoaudit002.php?chavepesquisa=$ci01_codtipo");
  }
}
?>
