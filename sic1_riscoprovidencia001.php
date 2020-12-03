<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_riscoprovidencia_classe.php");
include("classes/db_riscofiscal_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clriscofiscal = new cl_riscofiscal;
$clriscoprovidencia = new cl_riscoprovidencia;

$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clriscoprovidencia->si54_sequencial = $si54_sequencial;
$clriscoprovidencia->si54_codProvidencia = $si54_codProvidencia;
$clriscoprovidencia->si54_dscprovidencia = $si54_dscprovidencia;
$clriscoprovidencia->si54_valorassociado = $si54_valorassociado;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clriscoprovidencia->incluir($si54_sequencial);
    $erro_msg = $clriscoprovidencia->erro_msg;
    if($clriscoprovidencia->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clriscoprovidencia->alterar($si54_sequencial);
    $erro_msg = $clriscoprovidencia->erro_msg;
    if($clriscoprovidencia->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clriscoprovidencia->excluir($si54_sequencial);
    $erro_msg = $clriscoprovidencia->erro_msg;
    if($clriscoprovidencia->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clriscoprovidencia->sql_record($clriscoprovidencia->sql_query_file($si54_sequencial));
   if($result!=false && $clriscoprovidencia->numrows>0){
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
	include("forms/db_frmriscoprovidencia.php");
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
    if($clriscoprovidencia->erro_campo!=""){
        echo "<script> document.form1.".$clriscoprovidencia->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clriscoprovidencia->erro_campo.".focus();</script>";
    }
}
?>
