<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_turma_classe.php");
include("classes/db_calendario_classe.php");
include("classes/db_aluno_classe.php");
include("classes/db_base_classe.php");
include("classes/db_serie_classe.php");
include("classes/db_alunopossib_classe.php");
include("classes/db_historicomps_classe.php");
include("dbforms/db_funcoes.php");
$ed60_d_datamatricula_dia = date("d",db_getsession("DB_datausu"));
$ed60_d_datamatricula_mes = date("m",db_getsession("DB_datausu"));
$ed60_d_datamatricula_ano = date("Y",db_getsession("DB_datausu"));
db_postmemory($HTTP_POST_VARS);
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clcalendario = new cl_calendario;
$clturma = new cl_turma;
$claluno = new cl_aluno;
$clbase = new cl_base;
$clserie = new cl_serie;
$clalunopossib = new cl_alunopossib;
$clhistoricomps = new cl_historicomps;
$db_opcao = 1;
$db_botao = false;
if(isset($incluir)){
 $tam = sizeof($alunos);
 if($tam>$restantes){
  db_msgbox("Número de alunos selecionados é maior que as vagas disponíveis");
  db_redireciona("edu1_matricula001.php?chavepesquisa=$ed60_i_turma");
 }else{
  $msg_mat = "";
  $result_seq = $clturma->sql_record($clturma->sql_query("","ed11_i_sequencia",""," ed57_i_codigo = $ed60_i_turma"));
  db_fieldsmemory($result_seq,0);
  for($i=0;$i<$tam;$i++){
   $erro_mat = false;
   $result_base = $clbase->sql_record($clbase->sql_query("","ed31_i_curso as codcurso",""," ed31_i_codigo = $ed57_i_base"));
   db_fieldsmemory($result_base,0);
   $sql_hist = "SELECT ed11_i_sequencia as ultima_seq,
                       ed11_c_descr as d_ult_serie,
                       ed11_i_ensino as ult_ensino,
                       ed62_c_resultadofinal as ult_resfinal,
                       ed47_v_nome
                FROM historicomps
                 inner join historico on ed61_i_codigo = ed62_i_historico
                 inner join aluno on ed47_i_codigo = ed61_i_aluno
                 inner join serie on ed11_i_codigo = ed62_i_serie
                WHERE ed61_i_aluno = $alunos[$i]
                AND ed61_i_curso = $codcurso
                UNION
                SELECT ed11_i_sequencia as ultima_seq,
                       ed11_c_descr as d_ult_serie,
                       ed11_i_ensino as ult_ensino,
                       ed99_c_resultadofinal as ult_resfinal,
                       ed47_v_nome
                FROM historicompsfora
                 inner join historico on ed61_i_codigo = ed99_i_historico
                 inner join aluno on ed47_i_codigo = ed61_i_aluno
                 inner join serie on ed11_i_codigo = ed99_i_serie
                WHERE ed61_i_aluno = $alunos[$i]
                AND ed61_i_curso = $codcurso
                ORDER BY ultima_seq desc,ult_resfinal asc
                LIMIT 1
               ";
   $result_hist = pg_query($sql_hist);
   $linhas_hist = pg_num_rows($result_hist);
   $result_verif = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_codigo as jatem,ed47_v_nome as nometem,turma.ed57_c_descr as turmatem,calendario.ed52_c_descr as caltem",""," ed60_i_aluno = $alunos[$i] AND turma.ed57_i_calendario = $ed57_i_calendario"));
   if($clmatricula->numrows>0){
    db_fieldsmemory($result_verif,0);
    $msg_mat .= "ATENÇÃO:\\n\\nAluno(a) $nometem já está matriculado(a) na turma $turmatem no calendário $caltem!\\n\\n";
    $erro_mat = true;
   }elseif($linhas_hist>0){
    db_fieldsmemory($result_hist,0);
    if($ult_resfinal=="A"){
     $proxima_seq = ($ultima_seq==""?0:$ultima_seq)+1;
     $descr_situacao = "APROVADO";
    }else{
     $descr_situacao = "REPROVADO";
     $proxima_seq = $ultima_seq;
    }
    if($ed11_i_sequencia!=$proxima_seq){
     $erro_mat = true;
     $result_serie = $clserie->sql_record($clserie->sql_query("","ed11_c_descr as descr_proximaserie",""," ed11_i_ensino = $ult_ensino AND ed11_i_sequencia = $proxima_seq"));
     db_fieldsmemory($result_serie,0);
     $msg_mat .= "ATENÇÃO:\\n\\nAluno(a) $ed47_v_nome\\ntem a série/ano $d_ult_serie, situação de $descr_situacao, como a última cursada\\nno Curso $ed29_c_descr.\\n\\nSelecione uma turma de $descr_proximaserie para matricular este aluno.\\n\\n";
    }
   }
   if($erro_mat==false){
    $result1 = $clalunopossib->sql_record($clalunopossib->sql_query("","ed56_i_codigo,ed79_c_resulant,ed79_i_turmaant",""," ed56_i_aluno = $alunos[$i]"));
    db_fieldsmemory($result1,0);
    $ed79_i_turmaant = $ed79_i_turmaant=="0"?"":$ed79_i_turmaant;
    $result2 = $clmatricula->sql_record($clmatricula->sql_query_file("","max(ed60_i_numaluno)",""," ed60_i_turma = $ed60_i_turma"));
    db_fieldsmemory($result2,0);
    $max = $max==""?"":($max+1);
    db_inicio_transacao();
    $result3 = pg_query("SELECT ed56_c_situacao as sitanterior FROM alunocurso
                         WHERE ed56_i_aluno = $alunos[$i]");
    $sitanterior = pg_result($result3,0,0);
    $sitmatricula = trim($sitanterior)=="CANDIDATO"?"MATRICULAR":"REMATRICULAR";
    $sitmatricula1 = trim($sitanterior)=="CANDIDATO"?"MATRICULADO":"REMATRICULADO";
    $tipomatricula = trim($sitanterior)=="CANDIDATO"?"N":"R";
    $ed79_i_turmaant = $ed79_i_turmaant==""?"null":$ed79_i_turmaant;
    $ed60_i_codigo = "";
    $clmatricula->ed60_i_numaluno = $max;
    $clmatricula->ed60_i_aluno = $alunos[$i];
    $clmatricula->ed60_c_situacao = "MATRICULADO";
    $clmatricula->ed60_c_concluida = "N";
    $clmatricula->ed60_t_obs = "";
    $clmatricula->ed60_i_turmaant = $ed79_i_turmaant;
    $clmatricula->ed60_c_rfanterior = $ed79_c_resulant;
    $clmatricula->ed60_d_datamodif = $ed60_d_datamatricula_ano."-".$ed60_d_datamatricula_mes."-".$ed60_d_datamatricula_dia;
    $clmatricula->ed60_c_ativa = "S";
    $clmatricula->ed60_c_tipo = $tipomatricula;
    $clmatricula->ed60_c_parecer = "N";
    $clmatricula->incluir($ed60_i_codigo);
    $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
    $ultima = pg_result($result,0,0);
    $ed229_i_codigo = "";
    $clmatriculamov->ed229_i_matricula = $ultima;
    $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
    $clmatriculamov->ed229_c_procedimento = "$sitmatricula ALUNO";
    $clmatriculamov->ed229_t_descr = "ALUNO $sitmatricula1 NA TURMA $ed57_c_descr. SITUAÇÂO ANTERIOR: ".trim($sitanterior);
    $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
    $clmatriculamov->incluir($ed229_i_codigo);
    $sql1 = "UPDATE alunocurso SET
              ed56_c_situacao = 'MATRICULADO',
              ed56_i_calendario = $ed57_i_calendario,
              ed56_i_base = $ed57_i_base,
              ed56_i_escola = $ed57_i_escola
             WHERE ed56_i_codigo = $ed56_i_codigo
            ";
    $query1 = pg_query($sql1);
    $sql11 = "UPDATE alunopossib SET
               ed79_i_serie = $ed57_i_serie,
               ed79_i_turno = $ed57_i_turno
              WHERE ed79_i_alunocurso = $ed56_i_codigo
             ";
    $query11 = pg_query($sql11);
    $sql2 = "UPDATE historico SET
              ed61_i_escola = $ed57_i_escola
             WHERE ed61_i_aluno = $alunos[$i]
             AND ed61_i_curso = $codcurso
            ";
    $query2 = pg_query($sql2);
    db_fim_transacao();
   }
  }
  $result_qtd = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $ed60_i_turma AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result_qtd,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql1 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $ed60_i_turma
           ";
  $query1 = pg_query($sql1);
  if($msg_mat!=""){
   db_msgbox($msg_mat);
   db_redireciona("edu1_matricula001.php?chavepesquisa=$ed60_i_turma");
  }
 }
}elseif(isset($chavepesquisa)){
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
   <fieldset style="width:95%"><legend><b>Matricular Aluno</b></legend>
    <?include("forms/db_frmmatricula.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","ed60_i_turma",true,1,"ed60_i_turma",true);
</script>
<?
if(isset($incluir)){
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
   CurrentWindow.corpo.iframe_a1.location.href='edu1_matricula001.php?chavepesquisa=<?=$ed60_i_turma?>';
  </script>
  <?
 }
}
?>
