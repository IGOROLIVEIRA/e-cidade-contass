<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_turma_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$ed60_d_datamodif_dia = date("d",db_getsession("DB_datausu"));
$ed60_d_datamodif_mes = date("m",db_getsession("DB_datausu"));
$ed60_d_datamodif_ano = date("Y",db_getsession("DB_datausu"));
db_postmemory($HTTP_POST_VARS);
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clturma = new cl_turma;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
 db_inicio_transacao();
 $db_opcao = 2;
 $clmatricula->alterar($ed60_i_codigo);
 if(trim($ed60_c_situacao)=="MATRICULADO"){
  $sql11 = "SELECT ed59_i_codigo as regturma FROM regencia WHERE ed59_i_turma = $ed60_i_turma";
  $result11 = pg_query($sql11);
  $linhas11 = pg_num_rows($result11);
  for($f=0;$f<$linhas11;$f++){
   db_fieldsmemory($result11,$f);
   $sql12 = "UPDATE diario SET
              ed95_c_encerrado = 'N'
             WHERE ed95_i_aluno = $ed60_i_aluno
             AND ed95_i_regencia = $regturma
          ";
   $result12 = pg_query($sql12);
  }
  $clmatriculamov->ed229_t_descr = "REATIVAÇÃO DA MATRÍCULA. SITUAÇÃO DA MATRÍCULA MODIFICADA DE ".trim($ed60_c_situacaoatual)." PARA ".trim($ed60_c_situacao);
 }else{
  $clmatriculamov->ed229_t_descr = "SITUAÇÃO DA MATRÍCULA MODIFICADA DE ".trim($ed60_c_situacaoatual)." PARA ".trim($ed60_c_situacao);
  LimpaResultadofinal($ed60_i_codigo);
 }
 $ed229_i_codigo = "";
 $clmatriculamov->ed229_i_matricula = $ed60_i_codigo;
 $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
 $clmatriculamov->ed229_c_procedimento = "ALTERAR SITUAÇÂO DA MATRÍCULA";
 $clmatriculamov->ed229_d_data = $ed60_d_datamodif_ano."-".$ed60_d_datamodif_mes."-".$ed60_d_datamodif_dia;
 $clmatriculamov->incluir($ed229_i_codigo);
 $sql1 = "UPDATE alunocurso SET
           ed56_c_situacao = '$ed60_c_situacao'
          WHERE ed56_i_aluno = $ed60_i_aluno
         ";
 $query1 = pg_query($sql1);
 $result_qtd = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $ed60_i_turma AND ed60_c_situacao = 'MATRICULADO'"));
 db_fieldsmemory($result_qtd,0);
 $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
 $sql1 = "UPDATE turma SET
           ed57_i_nummatr = $qtdmatricula
          WHERE ed57_i_codigo = $ed60_i_turma
          ";
 $query1 = pg_query($sql1);
 db_fim_transacao();
}else if(isset($chavepesquisa)){
 $db_opcao = 2;
 $db_botao = false;
 $result = $clturma->sql_record($clturma->sql_query($chavepesquisa));
 db_fieldsmemory($result,0);
 $ed60_i_turma = $ed57_i_codigo;
 $result1 = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) ",""," ed60_i_turma = $ed60_i_turma AND ed60_c_situacao = 'MATRICULADO'"));
 db_fieldsmemory($result1,0);
 $ed57_i_nummatr = $count;
 ?>
  <script>
   parent.document.formaba.a2.disabled = false;
   parent.document.formaba.a2.style.color = "black";
   CurrentWindow.corpo.iframe_a2.location.href='edu1_alunoturma001.php?ed60_i_turma=<?=$ed57_i_codigo?>&ed57_c_descr=<?=$ed57_c_descr?>&ed52_c_descr=<?=$ed52_c_descr?>';
  </script>
 <?
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
   <?MsgAviso(db_getsession("DB_coddepto"),"escola");?>
   <br>
   <center>
   <fieldset style="width:95%"><legend><b>Alterar Situação da Matrícula</b></legend>
    <?include("forms/db_frmmatricula.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
 if($clmatricula->erro_status=="0"){
  $clmatricula->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clmatricula->erro_campo!=""){
   echo "<script> document.form1.".$clmatricula->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clmatricula->erro_campo.".focus();</script>";
  }
 }else{
  $clmatricula->erro(true,false);
  ?>
  <script>
   parent.document.formaba.a2.disabled = false;
   parent.document.formaba.a2.style.color = "black";
   CurrentWindow.corpo.iframe_a2.location.href='edu1_alunoturma001.php?ed60_i_turma=<?=$ed60_i_turma?>&ed57_c_descr=<?=$ed57_c_descr?>&ed52_c_descr=<?=$ed52_c_descr?>';
  </script>
  <?
  db_redireciona("edu1_matricula002.php?chavepesquisa=$ed60_i_turma");
 }
}
if($db_opcao==22){
 echo "<script>js_pesquisaed60_i_turma();</script>";
}
?>
