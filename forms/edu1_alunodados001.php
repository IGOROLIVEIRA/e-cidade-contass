<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_aluno_classe.php");
include("classes/db_escola_classe.php");
include("dbforms/db_funcoes.php");
require("libs/db_stdlibwebseller.php");
db_postmemory($HTTP_POST_VARS);
$claluno = new cl_aluno;
$clescola = new cl_escola;
$db_opcao = 1;
$db_opcao1 = 1;
$db_botao = true;
$result = $clescola->sql_record($clescola->sql_query("","ed18_c_cidade as ed47_v_munic,ed18_c_estado as ed47_v_uf,ed18_c_cep as ed47_v_cep",""," ed18_i_codigo = ".db_getsession("DB_coddepto").""));
@db_fieldsmemory($result,0);
$ed47_d_cadast_dia = date("d");
$ed47_d_cadast_mes = date("m");
$ed47_d_cadast_ano = date("Y");
$ed47_d_ultalt_dia = date("d");
$ed47_d_ultalt_mes = date("m");
$ed47_d_ultalt_ano = date("Y");
if(isset($incluir)){
 if($ed47_v_nome!=""){
  $result2 = $claluno->sql_record($claluno->sql_query("","ed47_i_codigo as jatem",""," ed47_v_nome = '$ed47_v_nome'"));
  if($claluno->numrows>0){
   db_fieldsmemory($result2,0);
   db_msgbox("Este nome ($ed47_v_nome) já possui cadastro! Redirecionando para visualização...");
   db_redireciona("edu1_alunodados002.php?chavepesquisa=$jatem");
  }else{
   db_inicio_transacao();
   $claluno->incluir($ed47_i_codigo);
   db_fim_transacao();
  }
 }else{
  db_inicio_transacao();
  $claluno->incluir($ed47_i_codigo);
  db_fim_transacao();
 }
 $db_botao = false;
}elseif(isset($chavepesquisa)){
 db_redireciona("edu1_alunodados002.php?chavepesquisa=$chavepesquisa");
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
  <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
   <center>
   <fieldset style="width:95%"><legend><b>Inclusão de Aluno</b></legend>
    <?include("forms/db_frmalunodados.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if(isset($incluir)){
 if($claluno->erro_status=="0"){
  $claluno->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($claluno->erro_campo!=""){
   echo "<script> document.form1.".$claluno->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$claluno->erro_campo.".focus();</script>";
  };
 }else{
  $claluno->erro(true,false);
  $result = @pg_query("select last_value from aluno_ed47_i_codigo_seq");
  $ultimo = pg_result($result,0,0);
  ?>
  <script>
   CurrentWindow.corpo.iframe_a1.location.href='edu1_alunodados002.php?chavepesquisa=<?=$ultimo?>';
  </script>
  <?
 }
}
?>
