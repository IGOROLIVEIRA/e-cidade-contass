<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_diario_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_diarioresultado_classe.php");
include("classes/db_diariofinal_classe.php");
include("classes/db_turma_classe.php");
include("classes/db_pareceraval_classe.php");
include("classes/db_parecerresult_classe.php");
include("classes/db_abonofalta_classe.php");
include("classes/db_amparo_classe.php");
include("classes/db_alunopossib_classe.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_alunotransfturma_classe.php");
include("classes/db_transfescolarede_classe.php");
include("classes/db_logmatricula_classe.php");
include("classes/db_aprovconselho_classe.php");
include("classes/db_trocaserie_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clturma = new cl_turma;
$clpareceraval = new cl_pareceraval;
$clparecerresult = new cl_parecerresult;
$clabonofalta = new cl_abonofalta;
$clalunocurso = new cl_alunocurso;
$clalunopossib = new cl_alunopossib;
$clalunotransfturma = new cl_alunotransfturma;
$cltransfescolarede = new cl_transfescolarede;
$cldiario = new cl_diario;
$clamparo = new cl_amparo;
$cldiarioavaliacao = new cl_diarioavaliacao;
$cldiarioresultado = new cl_diarioresultado;
$cldiariofinal = new cl_diariofinal;
$cllogmatricula = new cl_logmatricula;
$claprovconselho = new cl_aprovconselho;
$cltrocaserie = new cl_trocaserie;
$db_botao = false;
$db_opcao = 33;
$db_opcao1 = 3;
if(isset($excluir)){
 $db_opcao = 3;
 $db_opcao1 = 1;
 $result_prog = $cltrocaserie->sql_record($cltrocaserie->sql_query("","ed101_i_codigo",""," ed101_i_aluno = $ed60_i_aluno AND ed101_i_turmadest = $ed60_i_turma"));
 if($cltrocaserie->numrows>0){
  $clmatricula->erro_status = "0";
  $clmatricula->erro_msg = "Aluno selecionado foi progredido para esta turma.\\nPara excluir sua matrícula, esta progressão deve ser cancelada.\\nAcesse Procedimentos -> Progressão de Aluno -> Cancelar Progressão";
 }else{
  db_inicio_transacao();
  $sql_exc = "SELECT DISTINCT ed95_i_codigo as coddiario
              FROM diarioavaliacao
               inner join diario on ed95_i_codigo = ed72_i_diario
              WHERE ed95_i_aluno = $ed60_i_aluno
              AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $ed60_i_turma)
             ";
  $result_exc = pg_query($sql_exc);
  $linhas_exc = pg_num_rows($result_exc);
  for($z=0;$z<$linhas_exc;$z++){
   db_fieldsmemory($result_exc,$z);
   $clamparo->excluir(""," ed81_i_diario = $coddiario");
   $cldiariofinal->excluir(""," ed74_i_diario = $coddiario");
   $result5 = pg_query("select ed73_i_codigo from diarioresultado where ed73_i_diario = $coddiario");
   $linhas5 = pg_num_rows($result5);
   for($t=0;$t<$linhas5;$t++){
    db_fieldsmemory($result5,$t);
    $clparecerresult->excluir(""," ed63_i_diarioresultado = $ed73_i_codigo");
   }
   $cldiarioresultado->excluir(""," ed73_i_diario = $coddiario");
   $result6 = pg_query("select ed72_i_codigo from diarioavaliacao where ed72_i_diario = $coddiario");
   $linhas6 = pg_num_rows($result6);
   for($t=0;$t<$linhas6;$t++){
    db_fieldsmemory($result6,$t);
    $clpareceraval->excluir(""," ed93_i_diarioavaliacao = $ed72_i_codigo");
    $clabonofalta->excluir(""," ed80_i_diarioavaliacao = $ed72_i_codigo");
   }
   $cldiarioavaliacao->excluir(""," ed72_i_diario = $coddiario");
   $claprovconselho->excluir(""," ed253_i_diario = $coddiario");
   $cldiario->excluir(""," ed95_i_codigo = $coddiario");
  }
  //db_criatabela($result_exc);
  //exit;
  $clmatriculamov->excluir(""," ed229_i_matricula = $ed60_i_codigo ");
  $clalunotransfturma->excluir("","ed69_i_matricula  = $ed60_i_codigo ");
  $cltransfescolarede->excluir("","ed103_i_matricula  = $ed60_i_codigo ");
  $clmatricula->excluir($ed60_i_codigo);
  $sql1 = "SELECT ed56_i_codigo FROM alunocurso
           WHERE ed56_i_aluno = $ed60_i_aluno
          ";
  $query1 = pg_query($sql1);
  $linhas1 = pg_num_rows($query1);
  if($linhas1>0){
   db_fieldsmemory($query1,0);
   $sql0 = "SELECT ed60_i_codigo as matrant,
                   ed57_i_escola as escolaant,
                   ed57_i_base as baseant,
                   ed57_i_calendario as calant,
                   ed60_c_situacao as sitant,
                   ed60_c_concluida as concant,
                   ed57_i_serie as serieant,
                   ed57_i_turno as turnoant,
                   ed60_i_turma as turmaant
            FROM matricula
             inner join turma on ed57_i_codigo = ed60_i_turma
             left join matriculamov on ed229_i_matricula = ed60_i_codigo
            WHERE ed60_i_aluno = $ed60_i_aluno
            AND ed229_d_data is not null
            ORDER BY ed60_i_codigo desc LIMIT 1
           ";
   $result0 = pg_query($sql0);
   $linhas0 = pg_num_rows($result0);
   if($linhas0>0){
    db_fieldsmemory($result0,0);
    if(trim($sitant)!="TROCA DE TURMA" && trim($sitant)!="AVANÇADO" && trim($sitant)!="CLASSIFICADO"){
     if($concant=="S"){
      if(trim($sitant)=="MATRICULADO"){
       $resfinal = ResultadoFinal($matrant,$ed60_i_aluno,$turmaant,$sitant,$concant);
       $sitant = $resfinal=="REPROVADO"?"REPETENTE":"APROVADO";
      }
     }
     if(trim($sitant)=="TRANSFERIDO REDE"){
      $escolaant = $ed57_i_escola;
     }
     $sql1 = "UPDATE alunocurso SET
               ed56_i_escola = $escolaant,
               ed56_i_base = $baseant,
               ed56_i_calendario = $calant,
               ed56_c_situacao = '$sitant',
               ed56_i_baseant = null,
               ed56_i_calendarioant = null,
               ed56_c_situacaoant = ''
              WHERE ed56_i_codigo = $ed56_i_codigo
             ";
     $result1 = pg_query($sql1);
     $sql1 = "UPDATE alunopossib SET
               ed79_i_serie = $serieant,
               ed79_i_turno = $turnoant,
               ed79_i_turmaant = null,
               ed79_c_resulant = '',
               ed79_c_situacao = 'A'
              WHERE ed79_i_alunocurso = $ed56_i_codigo
             ";
     $result1 = pg_query($sql1);
     if(trim($sitant)=="TRANSFERIDO REDE"){
      $sql2 = "UPDATE transfescolarede SET
                ed103_c_situacao = 'A'
               WHERE ed103_i_codigo = (select ed103_i_codigo from transfescolarede where ed103_i_matricula = $matrant)
              ";
      $result2 = pg_query($sql2);
     }
    }else{
     $sql1 = "UPDATE alunocurso SET
               ed56_c_situacao = 'CANDIDATO'
              WHERE ed56_i_codigo = $ed56_i_codigo
             ";
     $result1 = pg_query($sql1);
    }
   }else{
    $sql1 = "UPDATE alunocurso SET
              ed56_c_situacao = 'CANDIDATO'
             WHERE ed56_i_codigo = $ed56_i_codigo
           ";
    $result1 = pg_query($sql1);
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
  $descr_origem = "Matrícula n°: $ed60_i_codigo\nTurma: $ed57_c_descr\nEscola: ".db_getsession("DB_nomedepto")."\nCalendário: $ed52_c_descr";
  $cllogmatricula->ed248_i_usuario = db_getsession("DB_id_usuario");
  $cllogmatricula->ed248_i_motivo  = $ed248_i_motivo;
  $cllogmatricula->ed248_i_aluno   = $ed60_i_aluno;
  $cllogmatricula->ed248_t_origem  = $descr_origem;
  $cllogmatricula->ed248_t_obs     = $ed248_t_obs;
  $cllogmatricula->ed248_d_data    = date("Y-m-d",db_getsession("DB_datausu"));
  $cllogmatricula->ed248_c_hora    = date("H:i");
  $cllogmatricula->ed248_c_tipo    = "E";
  $cllogmatricula->incluir(null);
  db_fim_transacao();
 }
}elseif(isset($chavepesquisa)){
 $db_opcao = 3;
 $db_opcao1 = 1;
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
   <fieldset style="width:95%"><legend><b>Exclusão de Matrícula</b></legend>
    <?include("forms/db_frmmatricula.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
</body>
</html>
<?
if(isset($excluir)){
 if($clmatricula->erro_status=="0"){
  $clmatricula->erro(true,false);
 }else{
  ?>
  <script>
   parent.document.formaba.a2.disabled = false;
   parent.document.formaba.a2.style.color = "black";
   CurrentWindow.corpo.iframe_a2.location.href='edu1_alunoturma001.php?ed60_i_turma=<?=$ed60_i_turma?>&ed57_c_descr=<?=$ed57_c_descr?>&ed52_c_descr=<?=$ed52_c_descr?>';
  </script>
  <?
  $clmatricula->erro(true,true);
 }
}
if($db_opcao==33){
 echo "<script>js_pesquisaed60_i_turma();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
