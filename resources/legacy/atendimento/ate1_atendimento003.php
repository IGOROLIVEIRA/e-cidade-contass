<?
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
if(!isset($abas)){
  echo "<script>location.href='ate1_atendimento005.php?db_opcao=3'</script>";
  exit;
}
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_atendimentolanc_classe.php");
include("classes/db_tecnico_classe.php");
include("classes/db_atendimento_classe.php");
include("classes/db_atenditem_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clatendimentolanc = new cl_atendimentolanc;
$clatendimento     = new cl_atendimento;
$clatenditem       = new cl_atenditem;
$db_opcao = 33;
$db_botao = false;
echo "<script>parent.document.formaba.atenditem.disabled=true;</script>";
if((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Excluir"){
  $db_opcao = 3;
  db_inicio_transacao();
  $result = $clatenditem->sql_record($clatenditem->sql_query("",$at02_codatend));
  for($i=0;$i<$clatenditem->numrows;$i++){
    db_fieldsmemory($result,$i);
//    $clatenditem->at05_codatend = $at05_codatend;
	if(isset($at05_seq)&&$at05_seq!="") {
    	$clatenditem->at05_seq = $at05_seq;
	    $clatenditem->excluir($at05_seq);
	}
  }
  $cltecnico = new cl_tecnico;
  $cltecnico->at03_codatend   = $at02_codatend;
  $cltecnico->at03_id_usuario = $at03_id_usuario;
  $cltecnico->excluir($at02_codatend,$at03_id_usuario);
  $clatendimentolanc->excluir($at02_codatend);
  $clatendimento->excluir($at02_codatend);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clatendimento->sql_record($clatendimento->sql_query($chavepesquisa)); 
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmatendimento.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Excluir"){
  if($clatendimento->erro_status=="0"){
    $clatendimento->erro(true,false);
  }else{
    $clatendimento->erro(true,false);
    echo "<script>parent.iframe_atendimento.location.href='ate1_atendimento003.php?abas=1'</script>";
  };
}
if($db_opcao == 33){
    echo "<script>document.form1.pesquisar.click();</script>";
}
?>
