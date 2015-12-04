<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_histmpsdisc_classe.php");
include("classes/db_historicomps_classe.php");
include("classes/db_alunocurso_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clhistmpsdisc = new cl_histmpsdisc;
$clhistoricomps = new cl_historicomps;
$clalunocurso = new cl_alunocurso;
$db_opcao = 1;
$db_botao = true;
if(isset($registrodisc)){
 $array_registro = explode("|",$registrodisc);
 for($y=0;$y<count($array_registro);$y++){
  $array_campos = explode(";",$array_registro[$y]);
  if(is_numeric($array_campos[6]) || is_int($array_campos[6]) || is_float($array_campos[6])){
   $array_campos[8] = "N";
   $array_campos[6] = str_replace(",",".",$array_campos[6]);
   $array_campos[6] = number_format($array_campos[6],2,".",".");
  }else{
   $array_campos[8] = "";
  }
  if($array_campos[7]=="AMPARADO"){
   $array_campos[3] = $array_campos[3];
   $array_campos[8] = "A";
   $array_campos[5] = "A";
  }else{
   $array_campos[3] = "null";
  }
  $clhistmpsdisc->ed65_i_codigo        = $array_campos[1];
  $clhistmpsdisc->ed65_i_historicomps  = $ed65_i_historicomps;
  $clhistmpsdisc->ed65_i_disciplina    = $array_campos[2];
  $clhistmpsdisc->ed65_i_justificativa = $array_campos[3];
  $clhistmpsdisc->ed65_i_qtdch         = $array_campos[4];
  $clhistmpsdisc->ed65_c_resultadofinal= $array_campos[5];
  $clhistmpsdisc->ed65_t_resultobtido  = $array_campos[6];
  $clhistmpsdisc->ed65_c_situacao      = $array_campos[7];
  $clhistmpsdisc->ed65_c_tiporesultado = $array_campos[8];
  if($array_campos[0]=="true"){
   if($array_campos[1]==""){
    db_inicio_transacao();
    $clhistmpsdisc->incluir($array_campos[1]);
    db_fim_transacao();
   }else{
    db_inicio_transacao();
    $clhistmpsdisc->alterar($array_campos[1]);
    db_fim_transacao();
   }
  }elseif($array_campos[0]=="false"){
   if($array_campos[1]!=""){
    db_inicio_transacao();
    $clhistmpsdisc->excluir($array_campos[1]);
    db_fim_transacao();
   }
  }
 }
 db_msgbox("Inclusão efetuada com sucesso!");
 $result = $clhistoricomps->sql_record($clhistoricomps->sql_query($ed65_i_historicomps));
 db_fieldsmemory($result,0);
 ?>
 <script>
  parent.arvore.location.href = "edu1_historicoarvore.php?ed61_i_aluno=<?=$ed61_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>";
 </script>
 <?
 db_redireciona("edu1_histmpsdisc002.php?ed65_i_historicomps=$ed65_i_historicomps");
 $db_opcao = 1;
 $db_botao = true;
}
if(isset($ed65_i_historicomps)){
 $result = $clhistoricomps->sql_record($clhistoricomps->sql_query($ed65_i_historicomps));
 db_fieldsmemory($result,0);
 $result = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_c_situacao",""," ed56_i_aluno = $ed61_i_aluno"));
 if($clalunocurso->numrows>0){
  db_fieldsmemory($result,0);
  $situacao = $ed56_c_situacao=="CONCLUÍDO"?"CONCLUÍDO":"EM ANDAMENTO";
 }else{
  $situacao = "CADASTRADO";
 }
 $db_opcao = 1;
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
<style>
.titulo{
 font-size: 11;
 color: #DEB887;
 background-color:#444444;
 font-weight: bold;
}
.cabec1{
 font-size: 11;
 color: #000000;
 background-color:#999999;
 font-weight: bold;
}
.aluno{
 color: #000000;
 font-family : Tahoma;
 font-size: 10;
}
</style>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="440" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td height="360" align="left" valign="top" bgcolor="#CCCCCC">
   <center>
   <fieldset style="width:95%;"><legend><b>Disciplinas - Série cursada na Rede Municipal</b></legend>
    <?include("forms/db_frmhistmpsdisc.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","ed65_i_historicomps",true,1,"ed65_i_historicomps",true);
</script>
