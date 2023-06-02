<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_consdispcaixaano_classe.php");
include("classes/db_consconsorcios_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconsdispcaixaano = new cl_consdispcaixaano;
$clconsconsorcios = new cl_consconsorcios;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clconsdispcaixaano->c203_sequencial = $c203_sequencial;
$clconsdispcaixaano->c203_consconsorcios = $c203_consconsorcios;
$clconsdispcaixaano->c203_valor = $c203_valor;
$clconsdispcaixaano->c203_anousu = $c203_anousu;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsdispcaixaano->incluir($c203_sequencial);
    $erro_msg = $clconsdispcaixaano->erro_msg;
    if($clconsdispcaixaano->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsdispcaixaano->alterar($c203_sequencial);
    $erro_msg = $clconsdispcaixaano->erro_msg;
    if($clconsdispcaixaano->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsdispcaixaano->excluir($c203_sequencial);
    $erro_msg = $clconsdispcaixaano->erro_msg;
    if($clconsdispcaixaano->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}//else if(isset($opcao)){
   $result = $clconsdispcaixaano->sql_record($clconsdispcaixaano->sql_query(null,"*",null,"c203_consconsorcios = $c203_consconsorcios"));
   //db_criatabela($result);echo "teste";exit;
   if($result!=false && $clconsdispcaixaano->numrows>0){
     db_fieldsmemory($result,0);
     $opcao = "alterar";
   } else {
   	 $c203_sequencial = "";
     $c203_valor = "";
     $c203_anousu = "";
   }
//}

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
	include("forms/db_frmconsdispcaixaano.php");
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
    if($clconsdispcaixaano->erro_campo!=""){
        echo "<script> document.form1.".$clconsdispcaixaano->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clconsdispcaixaano->erro_campo.".focus();</script>";
    }
}
?>
