<?
require("libs/db_stdlib.php");
require("libs/db_stdlibwebseller.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_transfescolafora_classe.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_escoladiretor_classe.php");
include("dbforms/db_funcoes.php");
$ed104_d_data_dia = date("d",db_getsession("DB_datausu"));
$ed104_d_data_mes = date("m",db_getsession("DB_datausu"));
$ed104_d_data_ano = date("Y",db_getsession("DB_datausu"));
db_postmemory($HTTP_POST_VARS);
$cltransfescolafora = new cl_transfescolafora;
$clalunocurso = new cl_alunocurso;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clescoladiretor = new cl_escoladiretor;
$db_opcao = 1;
$db_botao = true;
$ed104_i_escolaorigem = db_getsession("DB_coddepto");
$ed18_c_nome = db_getsession("DB_nomedepto");
if(isset($incluir)){
 db_inicio_transacao();
 $cltransfescolafora->ed104_i_usuario = db_getsession("DB_id_usuario");
 $cltransfescolafora->incluir($ed104_i_codigo);
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
 <tr>
  <td width="360" height="18">&nbsp;</td>
  <td width="263">&nbsp;</td>
  <td width="25">&nbsp;</td>
  <td width="140">&nbsp;</td>
 </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
   <?MsgAviso(db_getsession("DB_coddepto"),"escola");?>
   <br>
   <center>
   <fieldset style="width:95%"><legend><b>Transferência para outras escolas</b></legend>
    <?include("forms/db_frmtransfescolafora.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
js_tabulacaoforms("form1","ed104_i_aluno",true,1,"ed104_i_aluno",true);
</script>
<?
if(isset($incluir)){
 if($cltransfescolafora->erro_status=="0"){
  $cltransfescolafora->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  echo "<script> document.form1.db_opcao.style.visibility='visible';</script>  ";
  if($cltransfescolafora->erro_campo!=""){
   echo "<script> document.form1.".$cltransfescolafora->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$cltransfescolafora->erro_campo.".focus();</script>";
  }
 }else{
  $result = $clmatricula->sql_record($clmatricula->sql_query("","ed60_c_situacao,ed60_i_turma,ed60_i_aluno,turma.ed57_i_calendario,turma.ed57_i_escola,turma.ed57_i_base,turma.ed57_i_turno as turnoturma",""," ed60_i_codigo = $matricula"));
  db_fieldsmemory($result,0);
  $sql11 = "SELECT ed59_i_codigo as regturma FROM regencia WHERE ed59_i_turma = $ed60_i_turma";
  $result11 = pg_query($sql11);
  $linhas11 = pg_num_rows($result11);
  for($f=0;$f<$linhas11;$f++){
   db_fieldsmemory($result11,$f);
   $sql12 = "UPDATE diario SET
              ed95_c_encerrado = 'S'
             WHERE ed95_i_aluno = $ed60_i_aluno
             AND ed95_i_regencia = $regturma
          ";
   $result12 = pg_query($sql12);
  }
  $result1 = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_i_codigo",""," ed56_i_escola = $ed57_i_escola AND ed56_i_aluno = $ed60_i_aluno AND ed56_i_base = $ed57_i_base AND ed56_i_calendario = $ed57_i_calendario"));
  db_fieldsmemory($result1,0);
  $clalunocurso->ed56_i_codigo = $ed56_i_codigo;
  $clalunocurso->ed56_c_situacao = "TRANSFERIDO FORA";
  $clalunocurso->ed56_c_situacaoant = $ed60_c_situacao;
  $clalunocurso->alterar($ed56_i_codigo);
  if($concluida=="N"){
   $clmatricula->ed60_i_codigo = $matricula;
   $clmatricula->ed60_c_situacao = "TRANSFERIDO FORA";
   $clmatricula->ed60_d_datamodif = date("Y-m-d",db_getsession("DB_datausu"));
   $clmatricula->alterar($matricula);
   $ed229_i_codigo = "";
   $clmatriculamov->ed229_i_matricula = $matricula;
   $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
   $clmatriculamov->ed229_c_procedimento = "TRANSFERÊNCIA PARA OUTRA ESCOLA";
   $clmatriculamov->ed229_t_descr = "ALUNO DA TURMA ".trim($turma)." TRANSFERIDO PARA ESCOLA ".trim($ed82_c_nome)."";
   $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
   $clmatriculamov->incluir($ed229_i_codigo);
   //atualiza qtd de matriculas turma de origem
   $result2 = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $ed60_i_turma AND ed60_c_situacao = 'MATRICULADO'"));
   db_fieldsmemory($result2,0);
   $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
   $sql3 = "UPDATE turma SET
             ed57_i_nummatr = $qtdmatricula
            WHERE ed57_i_codigo = $ed60_i_turma
            ";
   $result3 = pg_query($sql3);
   LimpaResultadofinal($matricula);
   $result4 = $clescoladiretor->sql_record($clescoladiretor->sql_query("","ed254_i_rechumano,z01_nome,ed15_c_nome","ed15_i_sequencia"," ed254_i_escola = $ed104_i_escolaorigem AND ed254_i_turno = $turnoturma AND ed254_c_tipo = 'A'"));
   if($clescoladiretor->numrows>0){
    db_fieldsmemory($result4,0);
    $diretor = $ed254_i_rechumano;
   }else{
    $diretor = "";
   }
   $alunos = $cltransfescolafora->ed104_i_codigo;
   ?>
   <script>
    jan = window.open('edu2_guiatransf002.php?alunos=<?=$alunos?>&tipo=TF&diretor=<?=$diretor?>','','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
   </script>
   <?
  }
  db_redireciona("edu1_transfescolafora001.php");
 }
}
?>