<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_consretiradaexclusao_classe.php");
include("classes/db_consconsorcios_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconsretiradaexclusao = new cl_consretiradaexclusao;
$clconsconsorcios = new cl_consconsorcios;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clconsretiradaexclusao->c204_sequencial = $c204_sequencial;
$clconsretiradaexclusao->c204_consconsorcios = $c204_consconsorcios;
$clconsretiradaexclusao->c204_tipoencerramento = $c204_tipoencerramento;
$clconsretiradaexclusao->c204_dataencerramento = $c204_dataencerramento;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsretiradaexclusao->incluir($c204_sequencial);
    $erro_msg = $clconsretiradaexclusao->erro_msg;
    if($clconsretiradaexclusao->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsretiradaexclusao->alterar($c204_sequencial);
    $erro_msg = $clconsretiradaexclusao->erro_msg;
    if($clconsretiradaexclusao->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsretiradaexclusao->excluir($c204_sequencial);
    $erro_msg = $clconsretiradaexclusao->erro_msg;
    if($clconsretiradaexclusao->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}//else if(isset($opcao)){
   $result = $clconsretiradaexclusao->sql_record($clconsretiradaexclusao->sql_query(null,"*",null,"c204_consconsorcios=$c204_consconsorcios"));
   if($result!=false && $clconsretiradaexclusao->numrows>0){
     db_fieldsmemory($result,0);$opcao = "alterar";
   } else {
   	 $c204_sequencial = "";
     $c204_tipoencerramento = "";
     $c204_dataencerramento = "";
     $c204_dataencerramento_dia = "";
     $c204_dataencerramento_mes = "";
     $c204_dataencerramento_ano = "";
     $c204_tipoencerramento_select_descr = "";
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
	include("forms/db_frmconsretiradaexclusao.php");
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
    if($clconsretiradaexclusao->erro_campo!=""){
        echo "<script> document.form1.".$clconsretiradaexclusao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clconsretiradaexclusao->erro_campo.".focus();</script>";
    }
}
?>
