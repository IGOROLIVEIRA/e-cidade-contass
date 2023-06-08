<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobraslicitacao_classe.php");
include("classes/db_pctipocompratribunal_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllicobraslicitacao = new cl_licobraslicitacao;
$clpctipocompratribunal = new cl_pctipocompratribunal;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $cllicobraslicitacao->obr07_processo        = $obr07_processo;
  $cllicobraslicitacao->obr07_exercicio       = $obr07_exercicio;
  $cllicobraslicitacao->obr07_objeto          = $obr07_objeto;
  $cllicobraslicitacao->obr07_tipoprocesso    = $obr07_tipoprocesso;
  $cllicobraslicitacao->obr07_instit          = db_getsession("DB_instit");
  $cllicobraslicitacao->incluir();
  db_fim_transacao();
}
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>
    #obr07_objeto{
        width: 510px;
        height: 70px;
    }
    #formulariolicitacao{
        margin-left: 30%;
        margin-top: 5%;
    }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmlicobraslicitacao.php");
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
js_tabulacaoforms("form1","obr07_processo",true,1,"obr07_processo",true);
</script>
<?
if(isset($incluir)){
  if($cllicobraslicitacao->erro_status=="0"){
    $cllicobraslicitacao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicobraslicitacao->erro_campo!=""){
      echo "<script> document.form1.".$cllicobraslicitacao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicobraslicitacao->erro_campo.".focus();</script>";
    }
  }else{
    $cllicobraslicitacao->erro(true,true);
  }
}
?>
