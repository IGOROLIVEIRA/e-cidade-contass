<?
require("libs/db_stdlib.php");
require("libs/db_stdlibwebseller.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_alunopossib_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_serie_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_historicomps_classe.php");
include("classes/db_logmatricula_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clalunocurso = new cl_alunocurso;
$clalunopossib = new cl_alunopossib;
$clserie = new cl_serie;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clhistoricomps = new cl_historicomps;
$clregencia = new cl_regencia;
$cldiarioavaliacao = new cl_diarioavaliacao;
$cllogmatricula = new cl_logmatricula;
$db_opcao = 1;
$db_botao = true;
$ed56_i_escola = db_getsession("DB_coddepto");
$ed18_c_nome = db_getsession("DB_nomedepto");
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$clrotulo = new rotulocampo;
$clrotulo->label("ed56_i_aluno");
$clrotulo->label("ed56_i_escola");
$clrotulo->label("ed60_i_turma");
$clrotulo->label("ed31_i_curso");
$clrotulo->label("ed57_i_base");
$clrotulo->label("ed57_i_calendario");
$clrotulo->label("ed57_i_serie");
$clrotulo->label("ed57_i_turno");
$clrotulo->label("ed60_d_datamatricula");
$clrotulo->label("ed57_i_nummatr");
$clrotulo->label("ed57_i_numvagas");
if(!isset($ano_matr)){
 $ano_matr = date("Y");
}
if(isset($incluirmatricula)){
 $result_verif = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_codigo as jatem,ed47_v_nome as nometem,turma.ed57_c_descr as turmatem,calendario.ed52_c_descr as caltem,ed60_c_situacao as sitmatricula",""," ed60_i_aluno = $ed56_i_aluno AND turma.ed57_i_calendario = $ed57_i_calendario"));
 $erromat = false;
 if($clmatricula->numrows>0){
  db_fieldsmemory($result_verif,0);
  db_msgbox("Aluno $nometem já pertence a turma $turmatem no calendário $caltem,\\ncom situação de $sitmatricula !\\nPara reativar esta matrícula acesse:\\n  Procedimentos -> Matrículas -> Alterar Situação da Matrícula");
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
    db_redireciona("edu1_matriculatransffora001.php?ed56_i_aluno=$ed56_i_aluno&ed47_v_nome=$ed47_v_nome");
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
   $clmatricula->ed60_c_tipo = "N";
   $clmatricula->ed60_c_parecer = "N";
   $clmatricula->incluir(null);
   $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
   $ultima = pg_result($result,0,0);
   $clmatriculamov->ed229_i_matricula = $ultima;
   $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
   $clmatriculamov->ed229_c_procedimento = "MATRICULAR ALUNO";
   $clmatriculamov->ed229_t_descr = "ALUNO MATRICULADO NA TURMA ".trim($ed57_c_descr).". SITUAÇÂO ANTERIOR: ".trim($sitanterior);
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
    db_redireciona("edu1_matriculatransffora002.php?ed56_i_aluno=$ed56_i_aluno&ed47_v_nome=$ed47_v_nome&desabilita&matricula=$matricula&turmaorigem=$turmaorigem&turmadestino=$ed60_i_turma");
   }else{
    db_redireciona("edu1_matriculatransffora001.php");
   }
   exit;
  }
 }
}
if(isset($reativar)){
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
 $sql3 = "UPDATE matricula SET
           ed60_c_situacao = 'MATRICULADO',
           ed60_c_concluida = 'N',
           ed60_d_datamodif = '".$ed60_d_datamatricula_ano."-".$ed60_d_datamatricula_mes."-".$ed60_d_datamatricula_dia."',
           ed60_c_ativa = 'S'
          WHERE ed60_i_codigo = $matrant
         ";
 $query3 = pg_query($sql3);
 $sql4 = "DELETE FROM transfescolafora
          WHERE ed104_i_aluno = $ed56_i_aluno
          AND ed104_d_data = '$datasaida_ano-$datasaida_mes-$datasaida_dia'
         ";
 $query4 = pg_query($sql4);
 $sql5 = "DELETE FROM matriculamov
          WHERE ed229_i_matricula = $matrant
          AND ed229_c_procedimento = 'TRANSFERÊNCIA PARA OUTRA ESCOLA'
         ";
 $query5 = pg_query($sql5);
 $sql6 = "UPDATE diario SET
           ed95_c_encerrado = 'N'
          WHERE ed95_i_aluno = $ed56_i_aluno
          AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $ed60_i_turma)
         ";
 $query6 = pg_query($sql6);
 $descr_origem = "Matrícula n°: $matrant\nTurma: $ed57_c_descr\nEscola: ".db_getsession("DB_nomedepto")."\nCalendário: $ed52_c_descr\n RETORNO em ".$ed60_d_datamatricula_ano."-".$ed60_d_datamatricula_mes."-".$ed60_d_datamatricula_dia."";
 $cllogmatricula->ed248_i_usuario = db_getsession("DB_id_usuario");
 $cllogmatricula->ed248_i_motivo  = null;
 $cllogmatricula->ed248_i_aluno   = $ed56_i_aluno;
 $cllogmatricula->ed248_t_origem  = $descr_origem;
 $cllogmatricula->ed248_t_obs     = "";
 $cllogmatricula->ed248_d_data    = date("Y-m-d",db_getsession("DB_datausu"));
 $cllogmatricula->ed248_c_hora    = date("H:i");
 $cllogmatricula->ed248_c_tipo    = "R";
 $cllogmatricula->incluir(null);
 db_fim_transacao();
 db_msgbox("Reativação efetuada com sucesso!");
 //pg_query("rollback");
 db_redireciona("edu1_matriculatransffora001.php");
 exit;
}
if(isset($novamatricula)){
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
 $sql3 = "UPDATE matricula SET
           ed60_c_concluida = 'S',
           ed60_c_ativa = 'N'
          WHERE ed60_i_codigo = $matrant
         ";
 $query3 = pg_query($sql3);
 $result2 = $clmatricula->sql_record($clmatricula->sql_query_file("","ed60_i_numaluno",""," ed60_i_turma = $ed60_i_turma AND ed60_i_aluno = $ed56_i_aluno "));
 db_fieldsmemory($result2,0);
 $ed60_i_numaluno = $ed60_i_numaluno==""?"":$ed60_i_numaluno;
 $ed79_i_turmaant = $ed79_i_turmaant==""?"null":$ed79_i_turmaant;
 $ed60_i_codigo = "";
 $clmatricula->ed60_i_aluno = $ed56_i_aluno;
 $clmatricula->ed60_i_turma = $ed60_i_turma;
 $clmatricula->ed60_i_numaluno = $ed60_i_numaluno;
 $clmatricula->ed60_c_situacao = "MATRICULADO";
 $clmatricula->ed60_c_concluida = "N";
 $clmatricula->ed60_i_turmaant = $ed79_i_turmaant;
 $clmatricula->ed60_c_rfanterior = $ed79_c_resulant;
 $clmatricula->ed60_d_datamatricula = $ed60_d_datamatricula_ano."-".$ed60_d_datamatricula_mes."-".$ed60_d_datamatricula_dia;
 $clmatricula->ed60_d_datamodif = $ed60_d_datamatricula_ano."-".$ed60_d_datamatricula_mes."-".$ed60_d_datamatricula_dia;
 $clmatricula->ed60_t_obs = "";
 $clmatricula->ed60_c_ativa = "S";
 $clmatricula->ed60_c_tipo = "N";
 $clmatricula->ed60_c_parecer = "N";
 $clmatricula->incluir(null);
 $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
 $ultima = pg_result($result,0,0);
 $clmatriculamov->ed229_i_matricula = $ultima;
 $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
 $clmatriculamov->ed229_c_procedimento = "MATRICULAR ALUNO";
 $clmatriculamov->ed229_t_descr = "ALUNO MATRICULADO NA TURMA ".trim($ed57_c_descr).". SITUAÇÂO ANTERIOR: ".trim($sitanterior);
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
 $sql6 = "UPDATE diario SET
           ed95_c_encerrado = 'N'
          WHERE ed95_i_aluno = $ed56_i_aluno
          AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $ed60_i_turma)
         ";
 $query6 = pg_query($sql6);
 db_fim_transacao();
 db_msgbox("Inclusão efetuada com sucesso!");
 //pg_query("rollback");
 db_redireciona("edu1_matriculatransffora001.php");
 exit;
}
$ed60_d_datamatricula_dia = date("d",db_getsession("DB_datausu"));
$ed60_d_datamatricula_mes = date("m",db_getsession("DB_datausu"));
$ed60_d_datamatricula_ano = date("Y",db_getsession("DB_datausu"));
$ed60_d_datamatricula = $ed60_d_datamatricula_dia."/".$ed60_d_datamatricula_mes."/".$ed60_d_datamatricula_ano;
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
<form name="form2" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
   <?MsgAviso(db_getsession("DB_coddepto"),"escola");?>
   <br>
   <center>
   <fieldset style="width:95%"><legend><b>Matricular Alunos Transferidos (FORA)</b></legend>
   <table border="0" align="center" width="100%">
    <tr>
     <td>
      <b>Ano do Calendario da matricula: </b>
     </td>
     <td>
      <?db_input('ano_matr',4,$ano_matr,true,'text',1,"onchange='js_anomatr(this.value)';")?>
     </td>
    </tr>
    <tr>
     <td nowrap title="<?=@$Ted56_i_aluno?>">
      <?db_ancora(@$Led56_i_aluno,"js_pesquisatransf();",$db_opcao);?>
     </td>
     <td>
      <?db_input('ed56_i_aluno',15,$Ied56_i_aluno,true,'text',3,"")?>
      <?db_input('ed47_v_nome',50,@$Ied47_v_nome,true,'text',3,'')?>
      <?db_input('descrserie',20,@$Idescrserie,true,'text',3,'')?>
      <?db_input('codserietransf',10,@$codserietransf,true,'text',3,'')?>
     </td>
    </tr>
    <?if(isset($ed56_i_aluno)){
    $datahj = date("Y-m-d");
    if(strstr($datasaida,"/")){
     $datasaida_dia = substr($datasaida,0,2);
     $datasaida_mes = substr($datasaida,3,2);
     $datasaida_ano = substr($datasaida,6,4);
    }else{
     $datasaida_dia = substr($datasaida,8,2);
     $datasaida_mes = substr($datasaida,5,2);
     $datasaida_ano = substr($datasaida,0,4);
    }
    $data_in = mktime(0,0,0,$datasaida_mes,$datasaida_dia,$datasaida_ano);
    $data_out = mktime(0,0,0,substr($datahj,5,2),substr($datahj,8,2),substr($datahj,0,4));
    $data_entre = $data_out - $data_in;
    $dias = ceil($data_entre/86400);
    ?>
    <tr>
     <td>
      <b>Data Saída:</b>
     </td>
     <td>
      <?db_inputdata('datasaida',@$datasaida_dia,@$datasaida_mes,@$datasaida_ano,true,'text',3,"")?>
     </td>
    </tr>
    <?
    $camposant = "matricula.ed60_i_codigo as matrant,
                  matricula.ed60_i_turma,
                  matricula.ed60_d_datamatricula as datainicialmatr,
                  turma.ed57_c_descr,
                  base.ed31_i_curso,
                  cursoedu.ed29_c_descr,
                  turma.ed57_i_base,
                  base.ed31_c_descr,
                  turma.ed57_i_calendario,
                  calendario.ed52_i_ano,
                  calendario.ed52_c_descr,
                  turma.ed57_i_serie,
                  serie.ed11_c_descr,
                  serie.ed11_i_sequencia,
                  turma.ed57_i_turno,
                  turno.ed15_c_nome,
                  turma.ed57_i_numvagas,
                  turma.ed57_i_nummatr,
                  turma.ed57_i_numvagas-turma.ed57_i_nummatr as restantes
                 ";

    $result_verif = $clmatricula->sql_record($clmatricula->sql_query("",$camposant,""," ed60_i_aluno = $ed56_i_aluno AND calendario.ed52_i_ano = $ano_matr AND ed60_c_situacao = 'TRANSFERIDO FORA' AND turma.ed57_i_escola = ".db_getsession("DB_coddepto")." AND ed60_c_ativa ='S'"));
    $linhas_verif = $clmatricula->numrows;
    if($clmatricula->numrows>0){
     db_fieldsmemory($result_verif,0);
     ?>
     <tr>
      <td colspan="2">
       <br>
       <font color="red"><b>Aluno (<?=$ed56_i_aluno?>) já possui matrícula nesta escola na turma abaixo relacionada, com situação de TRANSFERIDO FORA a <?=$dias?> dia<?=$dias>1?"(s)":""?>.</b></font>
       <br><br>
      </td>
     </tr>
     <?
    }
    ?>
    <?if($clmatricula->numrows>0){?>
     <tr>
      <td>
       <b>Matrícula:</b>
      </td>
      <td>
       <?db_input('matrant',10,@$matrant,true,'text',3,'')?>
       <?db_inputdata('datainicialmatr',@$datainicialmatr_dia,@$datainicialmatr_mes,@$datainicialmatr_ano,true,'text',3)?>
      </td>
     </tr>
    <?}?>
    <tr>
     <td nowrap title="<?=@$Ted56_i_escola?>" width="15%">
      <?db_ancora(@$Led56_i_escola,"",3);?>
     </td>
     <td>
      <?db_input('ed56_i_escola',15,$Ied56_i_escola,true,'text',3,"")?>
      <?db_input('ed18_c_nome',50,@$Ied18_c_nome,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td nowrap title="<?=@$Ted60_i_turma?>">
      <?$opcaoturma = $linhas_verif==0?1:3?>
      <?db_ancora(@$Led60_i_turma,"js_pesquisaed60_i_turma();",$opcaoturma);?>
     </td>
     <td>
      <?db_input('ed60_i_turma',15,$Ied60_i_turma,true,'text',3,'')?>
      <?db_input('ed57_c_descr',20,@$Ied57_c_descr,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td nowrap title="<?=@$Ted31_i_curso?>">
      <?=@$Led31_i_curso?>
     </td>
     <td>
      <?db_input('ed31_i_curso',15,@$Ied31_i_curso,true,'text',3,'')?>
      <?db_input('ed29_c_descr',40,@$Ied29_c_descr,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <?=@$Led57_i_base?>
     </td>
     <td>
      <?db_input('ed57_i_base',15,@$Ied57_i_base,true,'text',3,'')?>
      <?db_input('ed31_c_descr',40,@$Ied31_c_descr,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <?=@$Led57_i_calendario?>
     </td>
     <td>
      <?db_input('ed57_i_calendario',15,@$Ied57_i_calendario,true,'text',3,'')?>
      <?db_input('ed52_c_descr',40,@$Ied52_c_descr,true,'text',3,'')?>
      <?db_input('ed52_i_ano',5,@$Ied52_i_ano,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <?=@$Led57_i_serie?>
     </td>
     <td>
      <?db_input('ed57_i_serie',15,@$Ied57_i_serie,true,'text',3,'')?>
      <?db_input('ed11_c_descr',40,@$Ied11_c_descr,true,'text',3,'')?>
      <?db_input('ed11_i_sequencia',10,@$Ied11_i_sequencia,true,'hidden',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <?=@$Led57_i_turno?>
     </td>
     <td>
      <?db_input('ed57_i_turno',15,@$Ied57_i_turno,true,'text',3,'')?>
      <?db_input('ed15_c_nome',20,@$Ied15_c_nome,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <?=@$Led57_i_numvagas?>
     </td>
     <td>
      <?db_input('ed57_i_numvagas',15,@$Ied57_i_numvagas,true,'text',3,'')?>
      <?=@$Led57_i_nummatr?>
      <?db_input('ed57_i_nummatr',15,@$Ied57_i_nummatr,true,'text',3,'')?>
      <b>Vagas Restantes:</b>
      <?db_input('restantes',15,@$Irestantes,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td nowrap title="<?=@$Ted60_d_datamatricula?>">
      <?=@$Led60_d_datamatricula?>
     </td>
     <td>
      <?db_inputdata('ed60_d_datamatricula',@$ed60_d_datamatricula_dia,@$ed60_d_datamatricula_mes,@$ed60_d_datamatricula_ano,true,'text',$db_opcao," onchange=\"js_data();\"","","","parent.js_data();","js_data();")?>
     </td>
    </tr>
    <?
    if(isset($ed60_i_turma) && $linhas_verif==0){
    $campos = "ed18_c_nome as ed18_c_nomeorigem,
               matricula.ed60_i_codigo as matricula,
               turma.ed57_i_codigo as turmaorigem,
               turma.ed57_c_descr as ed57_c_descrorigem,
               serie.ed11_c_descr as ed11_c_descrorigem
              ";
    $sql_imp = "SELECT $campos FROM transfescolafora
                 inner join escola  on  escola.ed18_i_codigo = transfescolafora.ed104_i_escolaorigem
                 inner join aluno  on  aluno.ed47_i_codigo = transfescolafora.ed104_i_aluno
                 inner join escolaproc  on  escolaproc.ed82_i_codigo = transfescolafora.ed104_i_escoladestino
                 inner join matricula on matricula.ed60_i_aluno = transfescolafora.ed104_i_aluno
                 inner join turma on turma.ed57_i_codigo = matricula.ed60_i_turma AND turma.ed57_i_escola = transfescolafora.ed104_i_escolaorigem
                 inner join serie on serie.ed11_i_codigo = turma.ed57_i_serie
                 inner join calendario on calendario.ed52_i_codigo = turma.ed57_i_calendario
                WHERE matricula.ed60_c_situacao = 'TRANSFERIDO FORA'
                AND ed104_i_aluno = $ed56_i_aluno
                AND ed52_i_ano = $ed52_i_ano
                AND ed60_c_ativa = 'S'
                ORDER BY ed104_i_codigo DESC
                LIMIT 1
               ";
    $result_imp = pg_query($sql_imp);
    $linhas_imp = pg_num_rows($result_imp);
    if($linhas_imp>0){
     ?>
     <tr>
      <td colspan="2">
       Este aluno foi transferido para fora da Rede Municipal neste ano.<br>
       Caso queira importar o aproveitamento deste aluno na turma abaixo relacionada, informe no campo abaixo:
      </td>
     </tr>
     <tr>
      <td>
       <b>Importar aproveitamento:</b>
      </td>
      <td>
       <select name="importaaprov">
        <option value="S" selected>SIM</option>
        <option value="N">NÃO</option>
       </select>
      </td>
     </tr>
     <?
      for($y=0;$y<$linhas_imp;$y++){
       db_fieldsmemory($result_imp,$y);
       $checked = $y==0?"checked":"";
       ?>
       <tr>
        <td style="text-decoration:underline;" onmouseover="document.getElementById('aprov<?=$turmaorigem?>').style.visibility = 'visible'" onmouseout="document.getElementById('aprov<?=$turmaorigem?>').style.visibility = 'hidden'">
         <?db_input('turmaorigem',15,@$Iturmaorigem,true,'radio',3,$checked)?>
         Turma Anterior:
        </td>
        <td>
         <?db_input('ed57_c_descrorigem',10,@$Ied57_c_descrorigem,true,'text',3,'')?>
         <?db_input('ed11_c_descrorigem',20,@$Ied11_c_descrorigem,true,'text',3,'')?>
         <?db_input('ed18_c_nomeorigem',50,@$Ied18_c_nomeorigem,true,'text',3,'')?>
         Matrícula:
         <?db_input('matricula',10,@$Imatricula,true,'text',3,'')?><br>
         <table border="1" cellspacing="0" cellpadding="0" id="aprov<?=$turmaorigem?>" style="position:absolute;visibility:hidden;">
          <?
          $veraprovnulo = "";
          $primeira = "";
          $result_diario = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed59_i_codigo as regenciaorigem,ed232_c_descr,ed232_c_abrev,ed09_c_abrev,ed72_i_valornota,ed72_c_valorconceito,ed72_t_parecer,ed37_c_tipo","ed232_c_descr,ed41_i_sequencia ASC"," ed95_i_aluno = $ed56_i_aluno AND ed59_i_turma = $turmaorigem AND ed09_c_somach = 'S'"));
          if($cldiarioavaliacao->numrows==0){
           echo "<tr><td width='160px' style='background:#f3f3f3;'>Nenhum registro de aproveitamento.</td></tr>";
          }else{
           for($t=0;$t<$cldiarioavaliacao->numrows;$t++){
            db_fieldsmemory($result_diario,$t);
            if($primeira!=$regenciaorigem){
             echo "</tr><tr><td style='background:#444444;color:#DEB887'><b>$ed232_c_descr</b></td>";
             $primeira = $regenciaorigem;
            }
            if(trim($ed37_c_tipo)=="NOTA"){
             if($resultedu=='S'){
              $aproveitamento = $ed72_i_valornota!=""?number_format($ed72_i_valornota,2,",","."):"";
             }else{
              $aproveitamento = $ed72_i_valornota!=""?number_format($ed72_i_valornota,0):"";
             }
            }elseif(trim($ed37_c_tipo)=="NIVEL"){
             $aproveitamento = $ed72_c_valorconceito;
            }else{
             $aproveitamento = "";
            }
            $veraprovnulo .= $aproveitamento;
            echo "<td style='background:#f3f3f3;'><b>$ed09_c_abrev:</b></td>
                  <td width='50px' style='background:#f3f3f3;' align='center'>".($aproveitamento==""?"&nbsp;":$aproveitamento)."</td>";
           }
          }
          ?>
         </table>
        </td>
       </tr>
       <?
      }
     }
    }
    ?>
    <tr>
     <td colspan="2" align="center">
      <?if($linhas_verif==0){?>
       <input name="incluirmatricula" type="submit" value="Incluir" disabled onclick="return js_validaturma();">
      <?}else{?>
       <input name="reativar" type="submit" value="Reativar Matrícula n° <?=$matrant?>" disabled onclick="return confirm('Confirmar reativação da matrícula n° <?=$matrant?> ?')">
       <input name="novamatricula" type="submit" value="Gerar Nova Matrícula" disabled onclick="return js_validaturma();">
      <?}?>
     </td>
    </tr>
    <?}?>
   </table>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</form>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
function js_pesquisatransf(){
 js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_transfescolafora','func_transfescolaforamatr.php?funcao_js=parent.js_mostraaluno|ed104_i_aluno|ed47_v_nome|descrserie|codserietransf|ed104_d_data','Pesquisa de alunos transferidos para fora da rede',true);
}
function js_mostraaluno(chave1,chave2,chave3,chave4,chave5){
 db_iframe_transfescolafora.hide();
 location.href = 'edu1_matriculatransffora001.php?ed56_i_aluno='+chave1+'&ed47_v_nome='+chave2+'&descrserie='+chave3+'&codserietransf='+chave4+'&datasaida='+chave5+'&ano_matr='+document.form2.ano_matr.value;
}
function js_pesquisaed60_i_turma(){
 if(document.form2.ano_matr.value==""){
  alert("Informe o ano do calendário da matrícula!");
  document.form2.ano_matr.style.backgroundColor='#99A9AE';
  document.form2.ano_matr.focus();
 }else{
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_turma','func_turmamatrtransffora.php?codserietransf='+document.form2.codserietransf.value+'&anocalendario='+document.form2.ano_matr.value+'&aluno='+document.form2.ed56_i_aluno.value+'&funcao_js=parent.js_mostraturma1|ed57_i_codigo|ed57_c_descr|ed11_c_descr|ed52_c_descr|ed29_c_descr|ed31_c_descr|ed15_c_nome|ed11_i_codigo|ed52_i_codigo|ed29_i_codigo|ed31_i_codigo|ed15_i_codigo|ed57_i_nummatr|ed57_i_numvagas|ed11_i_sequencia|ed52_i_ano','Pesquisa de Turmas',true);
 }
}
function js_mostraturma1(chave1,chave2,chave3,chave4,chave5,chave6,chave7,chave8,chave9,chave10,chave11,chave12,chave13,chave14,chave15,chave16){
 document.form2.ed60_i_turma.value = chave1;
 document.form2.ed57_c_descr.value = chave2;
 document.form2.ed11_c_descr.value = chave3;
 document.form2.ed52_c_descr.value = chave4;
 document.form2.ed29_c_descr.value = chave5;
 document.form2.ed31_c_descr.value = chave6;
 document.form2.ed15_c_nome.value = chave7;
 document.form2.ed57_i_serie.value = chave8;
 document.form2.ed57_i_calendario.value = chave9;
 document.form2.ed31_i_curso.value = chave10;
 document.form2.ed57_i_base.value = chave11;
 document.form2.ed57_i_turno.value = chave12;
 document.form2.ed57_i_nummatr.value = chave13;
 document.form2.ed57_i_numvagas.value = chave14;
 document.form2.ed11_i_sequencia.value = chave15;
 document.form2.ed52_i_ano.value = chave16;
 document.form2.restantes.value = parseInt(chave14)-parseInt(chave13);
 db_iframe_turma.hide();
 if(parseInt(chave13)>=parseInt(chave14)){
  alert("Turma sem vagas disponíveis!");
 }else{
  document.form2.incluirmatricula.disabled = false;
  <?if(!isset($ed60_i_turma)){?>
   document.form2.submit();
  <?}?>
 }
}
function js_validaturma(){
 if(document.form2.ed60_d_datamatricula.value==""){
  alert("Informe a data para matricular o aluno!");
  document.form2.ed60_d_datamatricula.focus();
  document.form2.ed60_d_datamatricula.style.backgroundColor='#99A9AE';
  return false;
 }
 return true;
}
function js_anomatr(valor){
 if(valor==""){
  location.href = "edu1_matriculatransffora001.php";
 }else{
  if(document.form2.ed56_i_aluno.value!=""){
   location.href = 'edu1_matriculatransffora001.php?ed56_i_aluno='+document.form2.ed56_i_aluno.value+'&ed47_v_nome='+document.form2.ed47_v_nome.value+'&descrserie='+document.form2.descrserie.value+'&datasaida='+document.form2.datasaida.value+'&ano_matr='+valor+'&codserietransf='+document.form2.codserietransf.value;
  }
 }
}
<?if(isset($ed60_i_turma) && $linhas_verif==0){?>
 document.form2.incluirmatricula.disabled = false;
<?}else{?>
 <?if(isset($linhas_verif) && $linhas_verif>0){?>
  document.form2.reativar.disabled = false;
  document.form2.novamatricula.disabled = false;
 <?}?>
<?}?>
</script>
