<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_controleextvlrtransf_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clcontroleextvlrtransf = new cl_controleextvlrtransf;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $clcontroleextvlrtransf->incluir($k168_codprevisao,$k168_mescompet);
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
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin-left: auto; margin-right: auto; margin-top: 20px;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
  include("forms/db_frmcontroleextvlrtransf.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","k168_mescompet",true,1,"k168_mescompet",true);
</script>
<?
if(isset($incluir)){
  if($clcontroleextvlrtransf->erro_status=="0"){
    $clcontroleextvlrtransf->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcontroleextvlrtransf->erro_campo!=""){
      echo "<script> document.form1.".$clcontroleextvlrtransf->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcontroleextvlrtransf->erro_campo.".focus();</script>";
    }
  }else{
    $clcontroleextvlrtransf->erro(true, false);
    echo "<script>location.href='cai1_controleextvlrtransf002.php?controleext={$controleext}&mes_compet={$sAndMesCompet}'</script>";
  }
}
?>
