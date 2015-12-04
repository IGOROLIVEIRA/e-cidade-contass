<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_historicompsfora_classe.php");
include("classes/db_alunocurso_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clhistoricompsfora = new cl_historicompsfora;
$clalunocurso = new cl_alunocurso;
$db_opcao = 2;
$db_opcao1 = 3;
$db_botao = false;
if(isset($alterar)){
 $vinculo = false;
 $db_botao = true;
 if($ed99_c_situacao=="AMPARADO"){
  $ed99_c_resultadofinal = "A";
  if(DiscVinc($ed99_i_codigo)>0){
   $vinculo = true;
  }
 }elseif($ed99_c_situacao=="CONCLUÍDO"){
  $ed99_c_resultadofinal = $ed99_c_resultadofinal;
 }else{
  $ed99_c_resultadofinal = "R";
  if(DiscVinc($ed99_i_codigo)>0){
   $vinculo = true;
  }
 }
 if($vinculo==true){
  db_msgbox("Série com situação diferente de CONCLUÍDO não deve ter disciplinas vinculadas!");
 }else{
  db_inicio_transacao();
  $db_opcao = 2;
  $db_opcao1 = 3;
  $clhistoricompsfora->ed99_c_resultadofinal = $ed99_c_resultadofinal;
  $clhistoricompsfora->alterar($ed99_i_codigo);
  db_fim_transacao();
 }
}elseif(isset($chavepesquisa)){
 $db_opcao = 2;
 $db_opcao1 = 3;
 $result = $clhistoricompsfora->sql_record($clhistoricompsfora->sql_query($chavepesquisa));
 db_fieldsmemory($result,0);
 $result = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_c_situacao",""," ed56_i_aluno = $ed61_i_aluno"));
 if($clalunocurso->numrows>0){
  db_fieldsmemory($result,0);
  $situacao = $ed56_c_situacao=="CONCLUÍDO"?"CONCLUÍDO":"EM ANDAMENTO";
 }else{
  $situacao = "CADASTRADO";
 }
 $db_botao = true;
}
if(isset($excluir)){
 db_inicio_transacao();
 $db_opcao = 3;
 $clhistoricompsfora->excluir($ed99_i_codigo);
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
   <fieldset style="width:95%;height:360px;"><legend><b>Série cursada fora da Rede Municipal</b></legend>
    <?include("forms/db_frmhistoricompsfora.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
 if($clhistoricompsfora->erro_status=="0"){
  $clhistoricompsfora->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clhistoricompsfora->erro_campo!=""){
   echo "<script> document.form1.".$clhistoricompsfora->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clhistoricompsfora->erro_campo.".focus();</script>";
  }
 }else{
  $clhistoricompsfora->erro(true,false);
  ?>
  <script>
   location.href = "edu1_historicompsfora002.php?chavepesquisa=<?=$ed99_i_codigo?>";
  </script>
  <?
 }
}
if(isset($excluir)){
 if($clhistoricompsfora->erro_status=="0"){
  $clhistoricompsfora->erro(true,false);
 }else{
  $clhistoricompsfora->erro(true,false);
  ?>
  <script>
   location.href = "edu1_historicompsfora001.php?ed99_i_historico=<?=$ed99_i_historico?>&ed29_c_descr=<?=$ed29_c_descr?>&ed29_i_codigo=<?=$ed29_i_codigo?>";
   parent.arvore.location.href = "edu1_historicoarvore.php?ed61_i_aluno=<?=$ed61_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>";
  </script>
  <?
 }
}
function DiscVinc($ed99_i_codigo){
 $sql = "SELECT ed100_i_codigo
         FROM histmpsdiscfora
         WHERE ed100_i_historicompsfora = $ed99_i_codigo
        ";
 $result = pg_query($sql);
 $linhas = pg_num_rows($result);
 return $linhas;
}
?>
