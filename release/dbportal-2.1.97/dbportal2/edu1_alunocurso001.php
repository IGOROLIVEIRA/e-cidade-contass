<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_alunopossib_classe.php");
include("classes/db_escola_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_serie_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_historicomps_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clalunocurso = new cl_alunocurso;
$clalunopossib = new cl_alunopossib;
$clescola = new cl_escola;
$clserie = new cl_serie;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clhistoricomps = new cl_historicomps;
$clregencia = new cl_regencia;
$cldiarioavaliacao = new cl_diarioavaliacao;
$db_opcao = 1;
$db_botao = true;
$ed56_i_escola = db_getsession("DB_coddepto");
$ed18_c_nome = db_getsession("DB_nomedepto");
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$result10 = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_i_escola as escolaatual,ed56_c_situacao as sitatual","ed52_i_ano desc,ed56_i_codigo desc"," ed56_i_aluno = $ed56_i_aluno"));
$linhas_alunocurso = $clalunocurso->numrows;
if($clalunocurso->numrows==0){
 $liberamatricula = true;
 $sitatual = "CANDIDATO";
}else{
 db_fieldsmemory($result10,0);
 if($escolaatual!=$ed56_i_escola){
  $liberamatricula = false;
 }elseif($sitatual=="MATRICULADO" || $sitatual=="TRANSFERIDO REDE"){
  $liberamatricula = false;
 }else{
  $liberamatricula = true;
 }
}
if(isset($incluir)){
 db_inicio_transacao();
 $clalunocurso->ed56_c_situacao = "CANDIDATO";
 $clalunocurso->incluir($ed56_i_codigo);
 $result = @pg_query("select last_value from alunocurso_ed56_i_codigo_seq");
 $max = pg_result($result,0,0);
 if(trim($matricula)=="SÉRIE"){
  $clalunopossib->ed79_i_alunocurso = $max;
  $clalunopossib->ed79_c_situacao = "A";
  $clalunopossib->incluir(@$ed79_i_codigo);
 }
}
if(isset($alterar)){
 if($ed56_i_calendario==""){
  $clalunocurso->erro_status = "0";
  $clalunocurso->erro_msg = "Campo Calendário Não Informado.";
 }else{
  $result = $clmatricula->sql_record($clmatricula->sql_query("","turma.ed57_c_descr as turdescr, calendario.ed52_c_descr as caldescr,ed60_c_situacao",""," ed60_i_aluno = $ed56_i_aluno AND turma.ed57_i_calendario = $ed56_i_calendario AND ed60_c_situacao != 'AVANÇADO' AND ed60_c_situacao != 'CLASSIFICADO'"));
  if($clmatricula->numrows>0){
   db_fieldsmemory($result,0);
   if(trim($ed60_c_situacao)=="TRANSFERIDO FORA"){
    db_msgbox("ATENÇÃO! Aluno(a) ".trim($ed47_v_nome)." já possui matrícula\\nno calendário ".trim($caldescr).", na turma ".trim($turdescr)." com situação de ".trim($ed60_c_situacao).".\\nPara reativar esta matrícula acesse:\\n  Procedimentos -> Transferências -> Matricular Alunos Transferidos (FORA)");
    ?><script>parent.location.href = "edu1_matriculatransffora001.php";</script>;<?
    exit;
   }else{
    db_msgbox("ATENÇÃO! Aluno(a) ".trim($ed47_v_nome)." já possui matrícula\\nno calendário ".trim($caldescr).", na turma ".trim($turdescr)." com situação de ".trim($ed60_c_situacao).".\\nPara reativar esta matrícula acesse:\\n  Procedimentos -> Matrículas -> Alterar Situação da Matrícula");
   }
  }else{
   db_inicio_transacao();
   $db_opcao = 2;
   $clalunocurso->ed56_c_situacao = "CANDIDATO";
   $clalunocurso->alterar($ed56_i_codigo);
   $clalunopossib->ed79_i_alunocurso = $ed56_i_codigo;
   $clalunopossib->ed79_c_situacao = "A";
   if($ed79_i_codigo==""){
    $clalunopossib->incluir(@$ed79_i_codigo);
   }else{
    $clalunopossib->alterar(@$ed79_i_codigo);
   }
  }
 }
}
if(isset($excluir)){
 db_inicio_transacao();
 $db_opcao = 3;
 $clalunopossib->excluir(""," ed79_i_alunocurso = $ed56_i_codigo");
 $clalunocurso->excluir($ed56_i_codigo);
 db_fim_transacao();
}
if(isset($incluirmatricula)){
 $result_verif = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_codigo as jatem,ed47_v_nome as nometem,turma.ed57_c_descr as turmatem,calendario.ed52_c_descr as caltem,ed60_c_situacao as sitmatricula",""," ed60_i_aluno = $ed56_i_aluno AND turma.ed57_i_calendario = $ed57_i_calendarioAND AND ed60_c_situacao != 'AVANÇADO' AND ed60_c_situacao != 'CLASSIFICADO'"));
 $erromat = false;
 if($clmatricula->numrows>0){
  db_fieldsmemory($result_verif,0);
  if(trim($sitmatricula)=="TRANSFERIDO FORA"){
   db_msgbox("Aluno(a) ".trim($nometem)." já possui matrícula na turma $turmatem no calendário $caltem,\\ncom situação de $sitmatricula!\\nPara reativar esta matrícula acesse:\\n  Procedimentos -> Transferências -> Matricular Alunos Transferidos (FORA)");
   ?><script>parent.location.href = "edu1_matriculatransffora001.php";</script>;<?
   exit;
  }else{
   db_msgbox("Aluno(a) ".trim($nometem)." já possui matrícula na turma $turmatem no calendário $caltem,\\ncom situação de $sitmatricula!\\nPara reativar esta matrícula acesse:\\n  Procedimentos -> Matrículas -> Alterar Situação da Matrícula");
  }
  $erromat = true;
 }else{
  $errohist = false;
  $sql_hist = "SELECT ed11_i_sequencia as ultima_seq,
                      ed11_c_descr as d_ult_serie,
                      ed11_i_ensino as ult_ensino,
                      ed62_c_resultadofinal as ult_resfinal
               FROM historicomps
                inner join historico on ed61_i_codigo = ed62_i_historico
                inner join serie on ed11_i_codigo = ed62_i_serie
               WHERE ed61_i_aluno = $ed56_i_aluno
               AND ed61_i_curso = $ed31_i_curso
               UNION
               SELECT ed11_i_sequencia as ultima_seq,
                      ed11_c_descr as d_ult_serie,
                      ed11_i_ensino as ult_ensino,
                      ed99_c_resultadofinal as ult_resfinal
               FROM historicompsfora
                inner join historico on ed61_i_codigo = ed99_i_historico
                inner join serie on ed11_i_codigo = ed99_i_serie
               WHERE ed61_i_aluno = $ed56_i_aluno
               AND ed61_i_curso = $ed31_i_curso
               ORDER BY ultima_seq desc,ult_resfinal asc
               LIMIT 1
              ";
  $result_hist = pg_query($sql_hist);
  $linhas_hist = pg_num_rows($result_hist);
  if($linhas_hist>0){
   db_fieldsmemory($result_hist,0);
   if($ult_resfinal=="A"){
    $proxima_seq = ($ultima_seq==""?0:$ultima_seq)+1;
    $descr_situacao = "APROVADO";
   }else{
    $descr_situacao = "REPROVADO";
    $proxima_seq = $ultima_seq;
   }
   if($ed11_i_sequencia!=$proxima_seq){
    $errohist = true;
    $result_serie = $clserie->sql_record($clserie->sql_query("","ed11_c_descr as descr_proximaserie",""," ed11_i_ensino = $ult_ensino AND ed11_i_sequencia = $proxima_seq"));
    db_fieldsmemory($result_serie,0);
    db_msgbox("ATENÇÃO:\\n\\nAluno(a) $ed47_v_nome\\ntem a série/ano $d_ult_serie, situação de $descr_situacao, como a última cursada\\nno Curso $ed29_c_descr.\\n\\nSelecione uma turma de $descr_proximaserie para matricular este aluno.");
    db_redireciona("edu1_alunocurso001.php?ed56_i_aluno=$ed56_i_aluno&ed47_v_nome=$ed47_v_nome");
    exit;
   }
  }
  if($errohist==false){
   //pg_query("begin");
   db_inicio_transacao();
   $result1 = $clalunopossib->sql_record($clalunopossib->sql_query("","ed79_i_codigo as codalunopossib,ed56_i_codigo as codalunocurso,ed56_c_situacao as sitanterior,ed79_c_resulant,ed79_i_turmaant",""," ed56_i_aluno = $ed56_i_aluno"));
   if($clalunopossib->numrows==0){
    $clalunocurso->ed56_i_escola = $ed56_i_escola;
    $clalunocurso->ed56_i_aluno = $ed56_i_aluno;
    $clalunocurso->ed56_i_base = $ed57_i_base;
    $clalunocurso->ed56_i_calendario = $ed57_i_calendario;
    $clalunocurso->ed56_c_situacao = "MATRICULADO";
    $clalunocurso->ed56_i_baseant = null;
    $clalunocurso->ed56_i_calendarioant = null;
    $clalunocurso->ed56_c_situacaoant = "";
    $clalunocurso->incluir(null);
    $result11 = @pg_query("select last_value from alunocurso_ed56_i_codigo_seq");
    $ultimo = pg_result($result11,0,0);
    $clalunopossib->ed79_i_alunocurso = $ultimo;
    $clalunopossib->ed79_i_serie = $ed57_i_serie;
    $clalunopossib->ed79_i_turno = $ed57_i_turno;
    $clalunopossib->ed79_i_turmaant = null;
    $clalunopossib->ed79_c_resulant = "";
    $clalunopossib->ed79_c_situacao = "A";
    $clalunopossib->incluir(null);
    $ed79_c_resulant = "";
    $ed79_i_turmaant = null;
    $sitanterior = "CANDIDATO";
   }else{
    db_fieldsmemory($result1,0);
    $ed79_i_turmaant = $ed79_i_turmaant=="0"?"":$ed79_i_turmaant;
    $sql1 = "UPDATE alunocurso SET
              ed56_c_situacao = 'MATRICULADO',
              ed56_i_calendario = $ed57_i_calendario,
              ed56_i_base = $ed57_i_base,
              ed56_i_escola = $ed56_i_escola
             WHERE ed56_i_codigo = $codalunocurso
            ";
    $query1 = pg_query($sql1);
    $sql11 = "UPDATE alunopossib SET
               ed79_i_serie = $ed57_i_serie,
               ed79_i_turno = $ed57_i_turno
              WHERE ed79_i_codigo = $codalunopossib
             ";
    $query11 = pg_query($sql11);
   }
   $sql2 = "UPDATE historico SET
             ed61_i_escola = $ed56_i_escola
            WHERE ed61_i_aluno = $ed56_i_aluno
            AND ed61_i_curso = $ed31_i_curso
           ";
   $query2 = pg_query($sql2);
   $result2 = $clmatricula->sql_record($clmatricula->sql_query_file("","max(ed60_i_numaluno)",""," ed60_i_turma = $ed60_i_turma"));
   db_fieldsmemory($result2,0);
   $max = $max==""?"":($max+1);
   $ed79_i_turmaant = $ed79_i_turmaant==""?"null":$ed79_i_turmaant;
   $ed60_i_codigo = "";
   $tipomatricula = trim($sitanterior)=="CANDIDATO"?"N":"R";
   $clmatricula->ed60_i_aluno = $ed56_i_aluno;
   $clmatricula->ed60_i_turma = $ed60_i_turma;
   $clmatricula->ed60_i_numaluno = $max;
   $clmatricula->ed60_c_situacao = "MATRICULADO";
   $clmatricula->ed60_c_concluida = "N";
   $clmatricula->ed60_i_turmaant = $ed79_i_turmaant;
   $clmatricula->ed60_c_rfanterior = $ed79_c_resulant;
   $clmatricula->ed60_d_datamatricula = $ed60_d_datamatricula_ano."-".$ed60_d_datamatricula_mes."-".$ed60_d_datamatricula_dia;
   $clmatricula->ed60_d_datamodif = $ed60_d_datamatricula_ano."-".$ed60_d_datamatricula_mes."-".$ed60_d_datamatricula_dia;
   $clmatricula->ed60_t_obs = "";
   $clmatricula->ed60_c_ativa = "S";
   $clmatricula->ed60_c_tipo = $tipomatricula;
   $clmatricula->ed60_c_parecer = "N";
   $clmatricula->incluir(null);
   $sitmatricula = trim($sitanterior)=="CANDIDATO"?"MATRICULAR":"REMATRICULAR";
   $sitmatricula1 = trim($sitanterior)=="CANDIDATO"?"MATRICULADO":"REMATRICULADO";
   $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
   $ultima = pg_result($result,0,0);
   $clmatriculamov->ed229_i_matricula = $ultima;
   $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
   $clmatriculamov->ed229_c_procedimento = "$sitmatricula ALUNO";
   $clmatriculamov->ed229_t_descr = "ALUNO $sitmatricula1 NA TURMA ".trim($ed57_c_descr).". SITUAÇÂO ANTERIOR: ".trim($sitanterior);
   $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
   $clmatriculamov->incluir(null);
   $result_qtd = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $ed60_i_turma AND ed60_c_situacao = 'MATRICULADO'"));
   db_fieldsmemory($result_qtd,0);
   $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
   $sql1 = "UPDATE turma SET
             ed57_i_nummatr = $qtdmatricula
            WHERE ed57_i_codigo = $ed60_i_turma
           ";
   $query1 = pg_query($sql1);
   //pg_query("rollback");
   db_fim_transacao();
   if($importaaprov=="S"){
    db_redireciona("edu1_alunocurso002.php?ed56_i_aluno=$ed56_i_aluno&ed47_v_nome=$ed47_v_nome&desabilita&matricula=$matricula&turmaorigem=$turmaorigem&turmadestino=$ed60_i_turma");
   }else{
    db_redireciona("edu1_alunocurso001.php?ed56_i_aluno=$ed56_i_aluno&ed47_v_nome=$ed47_v_nome&desabilita");
   }
   exit;
  }
 }
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
   <br>
   <center>
   <fieldset style="width:95%;height:450">
    <?if($liberamatricula==true){?>
     <legend>
     <select id="escolha" name="escolha" style="font-weight:bold;font-size:9px;" onchange="js_escolha(this.value);">
      <option value="C">Cursos do Aluno</option>
      <option value="M">Matricular Aluno</option>
     </select>
     </legend>
     <?include("forms/db_frmalunocursomatr.php");?>
     <?include("forms/db_frmalunocurso.php");?>
     <?if($sitatual=="CANDIDATO" && !isset($opcao)){?>
      <script>
           document.getElementById("escolha").value = "M";
           document.getElementById("alunomatricula").style.visibility = "visible";
           document.getElementById("alunocurso").style.visibility = "hidden";
      </script>
     <?}else{?>
      <script>
           document.getElementById("escolha").value = "C";
           document.getElementById("alunomatricula").style.visibility = "hidden";
           document.getElementById("alunocurso").style.visibility = "visible";
      </script>
     <?}?>
    <?}else{?>
     <legend><b>Cursos do Aluno</b></legend>
     <?include("forms/db_frmalunocurso.php");?>
    <?}?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<script>
function js_escolha(valor){
 if(valor=="C"){
  document.getElementById("alunomatricula").style.visibility = "hidden";
  document.getElementById("alunocurso").style.visibility = "visible";
 }else{
  document.getElementById("alunomatricula").style.visibility = "visible";
  document.getElementById("alunocurso").style.visibility = "hidden";
 }
}
</script>
<?
if(isset($incluir)){
 $temerro = false;
 if($clalunocurso->erro_status=="0"){
  $clalunocurso->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clalunocurso->erro_campo!=""){
   echo "<script> document.form1.".$clalunocurso->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clalunocurso->erro_campo.".focus();</script>";
  }
  $temerro = true;
  if(trim($matricula)=="DISCIPLINA"){
   ?>
   <script>
    document.getElementById('Serie').style.visibility = "hidden";
    document.getElementById('Turno').style.visibility = "hidden";
    document.form1.matricula.value = '<?=$matricula?>';
   </script>
   <?
  }else{
   echo "<script> document.form1.matricula.value = '".$matricula."';</script>";
  }
 }
 if($clalunopossib->erro_status=="0"){
  $clalunopossib->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clalunopossib->erro_campo!=""){
   echo "<script> document.form1.".$clalunopossib->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clalunopossib->erro_campo.".focus();</script>";
  };
  $temerro = true;
  if(trim($matricula)=="SÉRIE"){
   echo "<script> document.form1.matricula.value = '".$matricula."';</script>";
  }
 }
 if($temerro==true){
  db_fim_transacao($temerro);
 }else{
  db_fim_transacao();
  ?>
  <script>
  CurrentWindow.corpo.iframe_a1.location.href='edu1_alunodados002.php?chavepesquisa=<?=$ed56_i_aluno?>';
  CurrentWindow.corpo.iframe_a2.location.href='edu1_aluno002.php?chavepesquisa=<?=$ed56_i_aluno?>';
  CurrentWindow.corpo.iframe_a4.location.href='edu1_docaluno001.php?ed49_i_aluno=<?=$ed56_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>';
  CurrentWindow.corpo.iframe_a5.location.href='edu1_alunonecessidade001.php?ed214_i_aluno=<?=$ed56_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>';
  CurrentWindow.corpo.iframe_a6.location.href='edu1_historico000.php?ed61_i_aluno=<?=$ed56_i_aluno?>&ed47_v_nome=<?=$ed47_v_nome?>';
  </script>
  <?
  $clalunocurso->erro(true,true);
 }
};
if(isset($alterar)){
 $temerro = false;
 if($clalunocurso->erro_status=="0"){
  $clalunocurso->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clalunocurso->erro_campo!=""){
   echo "<script> document.form1.".$clalunocurso->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clalunocurso->erro_campo.".focus();</script>";
  };
  $temerro = true;
 }
 if($clalunopossib->erro_status=="0"){
  $clalunopossib->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  if($clalunopossib->erro_campo!=""){
   echo "<script> document.form1.".$clalunopossib->erro_campo.".style.backgroundColor='#99A9AE';</script>";
   echo "<script> document.form1.".$clalunopossib->erro_campo.".focus();</script>";
  };
  $temerro = true;
 }
 if($temerro==true){
  db_fim_transacao($temerro);
 }else{
  db_fim_transacao();
  $clalunocurso->erro(true,true);
 }
};
if(isset($excluir)){
  if($clalunocurso->erro_status=="0"){
    $clalunocurso->erro(true,false);
  }else{
    $clalunocurso->erro(true,true);
  };
};
if(isset($cancelar)){
 echo "<script>location.href='".$clalunocurso->pagina_retorno."'</script>";
}
if(isset($incluirmatricula)){
 if($erromat==true){
  ?>
  <script>
   js_OpenJanelaIframe('','db_iframe_movimentos','edu1_matricula005.php?matricula=<?=$jatem?>','Movimentação da Matrícula',true);
   document.form2.incluirmatricula.disabled = false;
   document.getElementById("escolha").value = "M";
   document.getElementById("alunomatricula").style.visibility = "visible";
   document.getElementById("alunocurso").style.visibility = "hidden";
   document.form1.ed31_i_curso.value = "";
   document.form1.ed29_c_descr.value = "";
   document.form1.ed31_c_descr.value = "";
   document.form1.ed52_c_descr.value = "";
   document.form1.ed11_c_descr.value = "";
   document.form1.ed15_c_nome.value = "";
  </script>
  <?
 }
}
if(isset($ed60_i_turma) && $ed60_i_turma!=""){
 ?>
 <script>
  document.getElementById("escolha").value = "M";
  document.getElementById("alunomatricula").style.visibility = "visible";
  document.getElementById("alunocurso").style.visibility = "hidden";
  document.form1.ed31_i_curso.value = "";
  document.form1.ed29_c_descr.value = "";
  document.form1.ed31_c_descr.value = "";
  document.form1.ed52_c_descr.value = "";
  document.form1.ed11_c_descr.value = "";
  document.form1.ed15_c_nome.value = "";
 </script>
 <?
}
?>
