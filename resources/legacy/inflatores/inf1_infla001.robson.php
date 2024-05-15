<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_infla_classe.php");
include("classes/db_inflan_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clinfla = new cl_infla;
$clinflan = new cl_inflan;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clinfla->i02_codigo = $i02_codigo;
$clinfla->i02_data = $i02_data;
$clinfla->i02_valor = $i02_valor;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clinfla->incluir($i02_codigo,$i02_data);
    $erro_msg = $clinfla->erro_msg;
    if($clinfla->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clinfla->alterar($i02_codigo,$i02_data);
    $erro_msg = $clinfla->erro_msg;
    if($clinfla->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clinfla->excluir($i02_codigo,$i02_data);
    $erro_msg = $clinfla->erro_msg;
    if($clinfla->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clinfla->sql_record($clinfla->sql_query($i02_codigo,$i02_data));
   if($result!=false && $clinfla->numrows>0){
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
	include("forms/db_frminfla.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clpagordemrec->erro_campo!=""){
        echo "<script> document.form1.".$clinfla->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clinfla->erro_campo.".focus();</script>";
    }
}
?>
