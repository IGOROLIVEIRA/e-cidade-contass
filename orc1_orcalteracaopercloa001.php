<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcalteracaopercloa_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clorcalteracaopercloa = new cl_orcalteracaopercloa;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clorcalteracaopercloa->incluir($o201_sequencial);
    $erro_msg = $clorcalteracaopercloa->erro_msg;
    if($clorcalteracaopercloa->erro_status==0){
      $sqlerro=true;
    } else {
    	echo "<script>CurrentWindow.corpo.iframe_orcprojetolei.form1.suplementacao.disabled = false</script>";
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clorcalteracaopercloa->alterar($o201_sequencial);
    $erro_msg = $clorcalteracaopercloa->erro_msg;
    if($clorcalteracaopercloa->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clorcalteracaopercloa->excluir($o201_sequencial);
    $erro_msg = $clorcalteracaopercloa->erro_msg;
    if($clorcalteracaopercloa->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clorcalteracaopercloa->sql_record($clorcalteracaopercloa->sql_query($o201_sequencial));
   if($result!=false && $clorcalteracaopercloa->numrows>0){
     db_fieldsmemory($result,0);
   }
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
	include("forms/db_frmorcalteracaopercloa.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","o201_orcprojetolei",true,1,"o201_orcprojetolei",true);
</script>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clorcleialtorcamentaria->erro_campo!=""){
        echo "<script> document.form1.".$clorcalteracaopercloa->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clorcalteracaopercloa->erro_campo.".focus();</script>";
    }
}
?>
