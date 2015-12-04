<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_historicomps_classe.php");
include("classes/db_alunocurso_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clhistoricomps = new cl_historicomps;
$clalunocurso = new cl_alunocurso;
$db_opcao = 2;
$db_opcao1 = 3;
$db_botao = false;
if(isset($alterar)){
 $vinculo = false;
 $db_botao = true;
 if($ed62_c_situacao=="AMPARADO"){
  $ed62_c_resultadofinal = "A";
  if(DiscVinc($ed62_i_codigo)>0){
   $vinculo = true;
  }
 }elseif($ed62_c_situacao=="CONCLUÍDO"){
  $ed62_c_resultadofinal = $ed62_c_resultadofinal;
 }else{
  $ed62_c_resultadofinal = "R";
  if(DiscVinc($ed62_i_codigo)>0){
   $vinculo = true;
  }
 }
 if($vinculo==true){
  db_msgbox("Série com situação diferente de CONCLUÍDO não deve ter disciplinas vinculadas!");
 }else{
  db_inicio_transacao();
  $db_opcao = 2;
  $db_opcao1 = 3;
  $clhistoricomps->ed62_c_resultadofinal = $ed62_c_resultadofinal;
  $clhistoricomps->alterar($ed62_i_codigo);
  db_fim_transacao();
 }
}elseif(isset($chavepesquisa)){
 $db_opcao = 2;
 $db_opcao1 = 3;
 $result = $clhistoricomps->sql_record($clhistoricomps->sql_query($chavepesquisa));
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
 $clhistoricomps->excluir($ed62_i_codigo);
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
   <fieldset style="width:95%;height:360px;"><legend><b>Série cursada na Rede Municipal</b></legend>
    <?include("forms/db_frmhistoricomps.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
 if($clhistoricomps->erro_status=="0"){
  $clhistoricomps->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clhistoricomps->erro_campo!=""){
   echo "<script> document.form1.".$clhistoricomps->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clhistoricomps->erro_campo.".focus();</script>";
  }
 }else{
  $clhistoricomps->erro(true,false);
  ?>
  <script>
   location.href = "edu1_historicomps002.php?chavepesquisa=<?=$ed62_i_codigo?>";
  </script>
  <?
 }
}
if(isset($excluir)){
 if($clhistoricomps->erro_status=="0"){
  $clhistoricomps->erro(true,false);
 }else{
  $clhistoricomps->erro(true,false);
  ?>
  <script>
   location.href = "edu1_historicomps001.php?ed62_i_historico=<?=$ed62_i_historico?>&ed29_c_descr=<?=$ed29_c_descr?>&ed29_i_codigo=<?=$ed29_i_codigo?>";
   parent.arvore.location.href = "edu1_historicoarvore.php?ed61_i_aluno=<?=$ed61_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>";
  </script>
  <?
 }
}
function DiscVinc($ed62_i_codigo){
 $sql = "SELECT ed65_i_codigo
         FROM histmpsdisc
         WHERE ed65_i_historicomps = $ed62_i_codigo
        ";
 $result = pg_query($sql);
 $linhas = pg_num_rows($result);
 return $linhas;
}
?>
