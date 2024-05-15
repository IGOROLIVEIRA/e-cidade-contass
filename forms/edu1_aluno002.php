<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_aluno_classe.php");
include("classes/db_alunocurso_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$claluno = new cl_aluno;
$clalunocurso = new cl_alunocurso;
$db_opcao = 2;
$db_opcao1 = 3;
$db_botao = true;
if(isset($alterar)){
 $db_opcao = 2;
 $db_opcao1 = 3;
 $db_botao = true;
 $ed47_c_foto = @trim($GLOBALS["HTTP_POST_VARS"]["ed47_o_oid"]);
 $ed47_o_oid = "tmp/".@trim($GLOBALS["HTTP_POST_VARS"]["ed47_o_oid"]);
 db_inicio_transacao();
 if($ed47_c_foto!=""){
  $oid_imagem = pg_loimport($conn,$ed47_o_oid) or die("Erro(15) importando imagem");
  $ed47_o_oid = $oid_imagem;
 }else{
  $oid_imagem = "0";
 }
 $claluno->ed47_c_foto = $ed47_c_foto;
 $claluno->ed47_o_oid = $oid_imagem;
 $claluno->alterar($ed47_i_codigo);
 db_fim_transacao();
}
if(isset($excluirfoto)){
 $sql = "UPDATE aluno SET
          ed47_c_foto = '',
          ed47_o_oid = 0
         WHERE ed47_i_codigo = $chavepesquisa
        ";
 $result = pg_query($sql);
}
if(isset($chavepesquisa)){
 $db_opcao = 2;
 $db_opcao1 = 3;
 $result = $claluno->sql_record($claluno->sql_query($chavepesquisa));
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
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
   <br>
   <center>
   <fieldset style="width:95%"><legend><b>Outros Dados</b></legend>
    <?include("forms/db_frmaluno.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
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
  db_redireciona("edu1_aluno002.php?chavepesquisa=$chavepesquisa");
 };
};
if(isset($excluirfoto)){
 db_redireciona("edu1_aluno002.php?chavepesquisa=$chavepesquisa");
}
?>
