<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_historico_classe.php");
include("classes/db_alunocurso_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clhistorico = new cl_historico;
$clalunocurso = new cl_alunocurso;
$db_opcao = 2;
$db_opcao1 = 3;
$db_opcao2 = 3;
$db_botao = false;
if(isset($alterar)){
 db_inicio_transacao();
 $db_opcao = 2;
 $db_opcao1 = 3;
 $db_opcao2 = 3;
 $clhistorico->alterar($ed61_i_codigo);
 db_fim_transacao();
}else if(isset($chavepesquisa)){
 $db_opcao = 2;
 $db_opcao1 = 3;
 $db_opcao2 = 3;
 $result = $clhistorico->sql_record($clhistorico->sql_query($chavepesquisa));
 db_fieldsmemory($result,0);
 $result = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_c_situacao",""," ed56_i_aluno = $ed61_i_aluno"));
 if($clalunocurso->numrows>0){
  db_fieldsmemory($result,0);
  $situacao = $ed56_c_situacao=="CONCLU�DO"?"CONCLU�DO":"EM ANDAMENTO";
 }else{
  $situacao = "CADASTRADO";
 }
 $db_botao = true;
}
if(isset($excluir)){
 db_inicio_transacao();
 $db_opcao = 3;
 $clhistorico->excluir($ed61_i_codigo);
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
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="left" valign="top" bgcolor="#CCCCCC">
   <center>
   <fieldset style="width:95%;height:360px;"><legend><b>Curso</b></legend>
    <?include("forms/db_frmhistoricoesc.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
 if($clhistorico->erro_status=="0"){
  $clhistorico->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clhistorico->erro_campo!=""){
   echo "<script> document.form1.".$clhistorico->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clhistorico->erro_campo.".focus();</script>";
  }
 }else{
  $clhistorico->erro(true,false);
  ?>
  <script>
   location.href = "edu1_historico002.php?chavepesquisa=<?=$ed61_i_codigo?>";
   parent.arvore.location.href = "edu1_historicoarvore.php?ed61_i_aluno=<?=$ed61_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>";
  </script>
  <?
 }
}
if(isset($excluir)){
 if($clhistorico->erro_status=="0"){
  $clhistorico->erro(true,false);
 }else{
  $clhistorico->erro(true,false);
  ?>
  <script>
   location.href = "edu1_historico001.php?ed61_i_aluno=<?=$ed61_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>";
   parent.arvore.location.href = "edu1_historicoarvore.php?ed61_i_aluno=<?=$ed61_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>";
  </script>
  <?
 }
}
?>
<script>
js_tabulacaoforms("form1","ed61_i_escola",true,1,"ed61_i_escola",true);
</script>
