<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_histmpsdiscfora_classe.php");
include("classes/db_historicompsfora_classe.php");
include("classes/db_alunocurso_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clhistmpsdiscfora = new cl_histmpsdiscfora;
$clhistoricompsfora = new cl_historicompsfora;
$clalunocurso = new cl_alunocurso;
$db_opcao = 2;
$db_botao = false;
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
  $clhistmpsdiscfora->ed100_i_codigo        = $array_campos[1];
  $clhistmpsdiscfora->ed100_i_historicompsfora  = $ed100_i_historicompsfora;
  $clhistmpsdiscfora->ed100_i_disciplina    = $array_campos[2];
  $clhistmpsdiscfora->ed100_i_justificativa = $array_campos[3];
  $clhistmpsdiscfora->ed100_i_qtdch         = $array_campos[4];
  $clhistmpsdiscfora->ed100_c_resultadofinal= $array_campos[5];
  $clhistmpsdiscfora->ed100_t_resultobtido  = $array_campos[6];
  $clhistmpsdiscfora->ed100_c_situacao      = $array_campos[7];
  $clhistmpsdiscfora->ed100_c_tiporesultado = $array_campos[8];
  if($array_campos[0]=="true"){
   if($array_campos[1]==""){
    db_inicio_transacao();
    $clhistmpsdiscfora->incluir($array_campos[1]);
    db_fim_transacao();
   }else{
    db_inicio_transacao();
    $clhistmpsdiscfora->alterar($array_campos[1]);
    db_fim_transacao();
   }
  }elseif($array_campos[0]=="false"){
   if($array_campos[1]!=""){
    db_inicio_transacao();
    $clhistmpsdiscfora->excluir($array_campos[1]);
    db_fim_transacao();
   }
  }
 }
 db_msgbox("Alteração efetuada com sucesso!");
 $result = $clhistoricompsfora->sql_record($clhistoricompsfora->sql_query($ed100_i_historicompsfora));
 db_fieldsmemory($result,0);
 ?>
 <script>
  parent.arvore.location.href = "edu1_historicoarvore.php?ed61_i_aluno=<?=$ed61_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>";
 </script>
 <?
 db_redireciona("edu1_histmpsdiscfora002.php?ed100_i_historicompsfora=$ed100_i_historicompsfora");
 $db_opcao = 2;
 $db_botao = true;
}else if(isset($ed100_i_historicompsfora)){
 $result = $clhistoricompsfora->sql_record($clhistoricompsfora->sql_query($ed100_i_historicompsfora));
 db_fieldsmemory($result,0);
 $result = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_c_situacao",""," ed56_i_aluno = $ed61_i_aluno"));
 if($clalunocurso->numrows>0){
  db_fieldsmemory($result,0);
  $situacao = $ed56_c_situacao=="CONCLUÍDO"?"CONCLUÍDO":"EM ANDAMENTO";
 }else{
  $situacao = "CADASTRADO";
 }
 $db_opcao = 2;
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="left" valign="top" bgcolor="#CCCCCC">
   <center>
   <fieldset style="width:95%;"><legend><b>Disciplina - Série cursada fora da Rede Municipal</b></legend>
    <?include("forms/db_frmhistmpsdiscfora.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","ed100_i_historicompsfora",true,1,"ed100_i_historicompsfora",true);
</script>
