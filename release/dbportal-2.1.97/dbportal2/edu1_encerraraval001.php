<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_diariofinal_classe.php");
include("classes/db_diario_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_regenciaperiodo_classe.php");
include("classes/db_turma_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_historico_classe.php");
include("classes/db_historicompd_classe.php");
include("classes/db_historicomps_classe.php");
include("classes/db_histmpsdisc_classe.php");
include("classes/db_alunopossib_classe.php");
include("classes/db_baseserie_classe.php");
include("classes/db_serie_classe.php");
include("classes/db_escolabase_classe.php");
db_postmemory($HTTP_POST_VARS);
$cldiariofinal = new cl_diariofinal;
$cldiario = new cl_diario;
$clregencia = new cl_regencia;
$clregenciaperiodo = new cl_regenciaperiodo;
$clturma = new cl_turma;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clhistorico = new cl_historico;
$clhistoricompd = new cl_historicompd;
$clhistoricomps = new cl_historicomps;
$clhistmpsdisc = new cl_histmpsdisc;
$clalunopossib = new cl_alunopossib;
$clbaseserie = new cl_baseserie;
$clescolabase = new cl_escolabase;
$clserie = new cl_serie;
$db_botao = true;
$escola = db_getsession("DB_coddepto");
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$result = $clregencia->sql_record($clregencia->sql_query("","ed59_i_turma,ed57_c_descr,ed52_c_descr,ed57_i_calendario as calend,ed57_i_serie as serie1","","ed59_i_turma = $turma"));
db_fieldsmemory($result,0);
if(isset($confirmar)){
 //pg_query("begin");
 db_inicio_transacao();
 $result5 = $clturma->sql_record($clturma->sql_query("","ed57_i_codigo as codturma,ed57_c_regime as regime,ed31_i_curso as curso,ed57_i_escola as escola,ed57_i_calendario as calendario,ed57_i_base as base,ed57_i_serie as serie,ed57_i_disciplina as disciplina,ed57_c_medfreq as medfrequencia,ed57_i_turno as turno,ed52_i_ano as ano,ed52_i_periodo as periodo,ed52_i_diasletivos as diasletivos,ed52_i_semletivas as semletivas",""," ed57_i_codigo = $ed59_i_turma"));
 db_fieldsmemory($result5,0);
 $result6 = $clmatricula->sql_record($clmatricula->sql_query("","ed47_v_nome,ed60_i_codigo,ed60_i_aluno,ed60_c_situacao,ed60_c_parecer",""," ed60_c_ativa = 'S' AND (ed60_i_turma = $ed59_i_turma AND ed60_i_codigo in ($alunos) AND ed60_c_concluida = 'N') OR (ed60_i_turma = $ed59_i_turma AND ed60_c_situacao != 'MATRICULADO')"));
 //db_criatabela($result6);
 for($x=0;$x<$clmatricula->numrows;$x++){
  db_fieldsmemory($result6,$x);
  $result7 = $clhistorico->sql_record($clhistorico->sql_query_file("","ed61_i_codigo",""," ed61_i_aluno = $ed60_i_aluno AND ed61_i_curso = $curso"));
  if(trim($ed60_c_situacao)=="MATRICULADO"){
   if($clhistorico->numrows==0){
    $ed61_i_codigo = "";
    $clhistorico->ed61_i_escola = $escola;
    $clhistorico->ed61_i_aluno = $ed60_i_aluno;
    $clhistorico->ed61_i_curso = $curso;
    $clhistorico->incluir($ed61_i_codigo);
    $result8 = $clhistorico->sql_record($clhistorico->sql_query_file("","ed61_i_codigo",""," ed61_i_aluno = $ed60_i_aluno AND ed61_i_curso = $curso"));
    db_fieldsmemory($result8,0);
   }else{
    db_fieldsmemory($result7,0);
   }
  }
  $sql4 = "SELECT ed95_i_codigo
           FROM diario
            inner join aluno on ed47_i_codigo = ed95_i_aluno
            inner join diariofinal on ed74_i_diario = ed95_i_codigo
            inner join regencia on ed59_i_codigo = ed95_i_regencia
           WHERE ed95_i_aluno = $ed60_i_aluno
           AND ed95_i_calendario = $calend
           AND ed95_i_serie = $serie1
           AND ed74_c_resultadofinal != 'A'
           AND ed59_c_condicao = 'OB'
          ";
  $result4 = pg_query($sql4);
  $linhas4 = pg_num_rows($result4);
  //db_criatabela($result4);
  if(trim($ed60_c_situacao=="MATRICULADO")){
   if(MatriculaPosterior($ed59_i_turma,$ed60_i_aluno)=="NAO"){
    if($linhas4==0){
     $resultadoserie = "A";
     $result_possib = $clalunopossib->sql_record($clalunopossib->sql_query("","ed56_i_codigo,ed79_i_codigo,ed11_i_ensino,ed11_i_sequencia,ed56_i_calendario",""," ed56_i_escola = $escola AND ed56_i_aluno = $ed60_i_aluno"));
     if($clalunopossib->numrows>0){
      db_fieldsmemory($result_possib,0);
      $proxseq = ($ed11_i_sequencia+1);
      $result_baseserie = $clbaseserie->sql_record($clbaseserie->sql_query("","si.ed11_i_sequencia as inicial,sf.ed11_i_sequencia as final",""," ed87_i_codigo = $base"));
      db_fieldsmemory($result_baseserie,0);
      if($proxseq>=$inicial && $proxseq<=$final){
       $result_serie = $clserie->sql_record($clserie->sql_query("","ed11_i_codigo as proximaserie",""," ed11_i_ensino = $ed11_i_ensino AND ed11_i_sequencia = $proxseq"));
       db_fieldsmemory($result_serie,0);
       $situacao = "APROVADO";
       $where = "";
      }else{
       $result_basecont = $clescolabase->sql_record($clescolabase->sql_query("","ed77_i_basecont as basecont,cursoeducont.ed29_i_codigo as cursocont",""," ed77_i_base = $base AND ed77_i_escola = $escola"));
       db_fieldsmemory($result_basecont,0);
       if($basecont!=""){
        $situacao = "APROVADO";
        $where = " ed56_i_base = $basecont, ";
        $result_baseserie = $clbaseserie->sql_record($clbaseserie->sql_query("","si.ed11_i_sequencia as inicial,sf.ed11_i_sequencia as final,si.ed11_i_ensino as ensino",""," ed87_i_codigo = $basecont"));
        db_fieldsmemory($result_baseserie,0);
        $result_serie = $clserie->sql_record($clserie->sql_query("","ed11_i_codigo as proximaserie",""," ed11_i_ensino = $ensino AND ed11_i_sequencia = $inicial"));
        db_fieldsmemory($result_serie,0);
        $sql1 = "UPDATE alunocurso SET
                  ed56_c_situacao = '$situacao',
                  ed56_i_escola = $escola,
                  ed56_i_base = $basecont,
                  ed56_i_calendario = $ed56_i_calendario,
                  ed56_i_baseant = null,
                  ed56_i_calendarioant = null,
                  ed56_c_situacaoant = '$ed60_c_situacao'
                 WHERE ed56_i_codigo = $ed56_i_codigo
                ";
         $result1 = pg_query($sql1);
         $sql2 = "UPDATE alunopossib SET
                   ed79_i_serie = $proximaserie,
                   ed79_i_turno = $turno,
                   ed79_i_turmaant = $ed59_i_turma,
                   ed79_c_resulant = '$resultadoserie',
                   ed79_c_situacao = 'A'
                  WHERE ed79_i_alunocurso = $ed56_i_codigo
                 ";
        $result2 = pg_query($sql2);
       }else{
        $situacao = "ENCERRADO";
        $proximaserie = $serie;
        $where = "";
       }
      }
      //altera possibilidade de matrícula para próxima série
      $sql_upposs = "UPDATE alunopossib SET
                      ed79_i_serie = $proximaserie,
                      ed79_c_resulant = '$resultadoserie',
                      ed79_i_turmaant = $ed59_i_turma
                     WHERE ed79_i_codigo = $ed79_i_codigo
                    ";
      $result_upposs = pg_query($sql_upposs);
       //altera situação do curso
      $sql_upcurso = "UPDATE alunocurso SET
                      $where
                      ed56_c_situacao = '$situacao',
                      ed56_c_situacaoant = '$ed60_c_situacao'
                     WHERE ed56_i_codigo = $ed56_i_codigo
                    ";
      $result_upcurso = pg_query($sql_upcurso);
     }
    }else{
     $resultadoserie = "R";
     $result_possib = $clalunopossib->sql_record($clalunopossib->sql_query("","ed56_i_codigo,ed79_i_codigo",""," ed56_i_escola = $escola AND ed56_i_aluno = $ed60_i_aluno"));
     if($clalunopossib->numrows>0){
      db_fieldsmemory($result_possib,0);
      //informa resultados anteriores
      $sql_upposs = "UPDATE alunopossib SET
                      ed79_c_resulant = '$resultadoserie',
                      ed79_i_turmaant = $ed59_i_turma
                     WHERE ed79_i_codigo = $ed79_i_codigo
                    ";
      $result_upposs = pg_query($sql_upposs);
      //altera situação do curso para candidato a mesma série
      if(trim($ed60_c_situacao)=="MATRICULADO"){
       $situacao_rep = "REPETENTE";
      }else{
       $situacao_rep = trim($ed60_c_situacao);
      }
      $sql_upcurso = "UPDATE alunocurso SET
                       ed56_c_situacao = '$situacao_rep',
                       ed56_c_situacaoant = '$ed60_c_situacao'
                      WHERE ed56_i_codigo = $ed56_i_codigo
                     ";
      $result_upcurso = pg_query($sql_upcurso);
     }
    }
   }
  }
  $situacaoserie = trim($ed60_c_situacao)=="MATRICULADO"?"CONCLUÍDO":$ed60_c_situacao;
  if(trim($regime)=="SÉRIE"){
   if(trim($ed60_c_situacao=="MATRICULADO")){
    $ed62_i_codigo = "";
    $clhistoricomps->ed62_i_historico = $ed61_i_codigo;
    $clhistoricomps->ed62_i_escola = $escola;
    $clhistoricomps->ed62_i_serie = $serie;
    $clhistoricomps->ed62_i_turma = $ed57_c_descr;
    $clhistoricomps->ed62_i_anoref = $ano;
    $clhistoricomps->ed62_i_periodoref = $periodo;
    $clhistoricomps->ed62_c_resultadofinal = $resultadoserie;
    $clhistoricomps->ed62_c_situacao = $situacaoserie;
    $clhistoricomps->ed62_i_diasletivos = $diasletivos;
    $clhistoricomps->ed62_i_qtdch = 0;
    $clhistoricomps->incluir($ed62_i_codigo);
   }
   if(trim($ed60_c_situacao=="MATRICULADO")){
    $result_his = $clhistoricomps->sql_record($clhistoricomps->sql_query_file("","ed62_i_codigo as histmps","","ed62_i_historico = $ed61_i_codigo AND ed62_i_escola = $escola AND ed62_i_serie = $serie"));
    db_fieldsmemory($result_his,0);
    $result_reg = $clregencia->sql_record($clregencia->sql_query_file("","ed59_i_codigo as codregencia,ed59_i_disciplina as discregencia,ed59_c_freqglob as freqregencia,ed59_i_qtdperiodo as qtdperiodo,ed59_c_condicao as tipocondicao","","ed59_i_turma = $ed59_i_turma"));
    //db_criatabela($result_reg);
    $somacargah = 0;
    for($w=0;$w<$clregencia->numrows;$w++){
     db_fieldsmemory($result_reg,$w);
     $sql_val = "SELECT ed74_i_diario,
                        ed74_c_resultadofinal,
                        ed74_c_valoraprov,
                        substr(ed37_c_tipo,1,1) as ed37_c_tipo,
                        case when ed81_c_todoperiodo = 'S' then 'AMPARADO' else 'CONCLUÍDO' end as situacaodisc,
                        ed81_i_justificativa,
                        ed81_c_aprovch
                 FROM diario
                  inner join diariofinal on ed74_i_diario = ed95_i_codigo
                  left join amparo on ed81_i_diario = ed95_i_codigo
                  left join procresultado on ed43_i_codigo = ed74_i_procresultadoaprov
                  left join formaavaliacao on ed37_i_codigo = ed43_i_formaavaliacao
                 WHERE ed95_i_regencia = $codregencia
                 AND ed95_i_aluno = $ed60_i_aluno
                ";

     $result_val = pg_query($sql_val);
     db_fieldsmemory($result_val,0);
     if($ed60_c_parecer=="S"){
      $ed37_c_tipo = "P";
     }
     $ed74_c_resultadofinal = $situacaodisc=="AMPARADO"?"A":$ed74_c_resultadofinal;
     $ed74_c_valoraprov = $situacaodisc=="AMPARADO"?"":$ed74_c_valoraprov;
     $ed37_c_tipo = $situacaodisc=="AMPARADO"?"A":$ed37_c_tipo;
     $sql3= $clregenciaperiodo->sql_query("","sum(ed78_i_aulasdadas) as aulas",""," ed78_i_regencia = $codregencia AND ed09_c_somach = 'S'");
     $result3 = $clregenciaperiodo->sql_record($sql3);
     db_fieldsmemory($result3,0);
     $aulas = $aulas==""?0:$aulas;
     if($situacaodisc=="AMPARADO" && $ed81_c_aprovch=="N"){
      $cargah = 0;
     }else{
      $cargah = $aulas;
     }
     if($tipocondicao=="OB"){
      $ed65_i_codigo = "";
      $clhistmpsdisc->ed65_i_historicomps = $histmps;
      $clhistmpsdisc->ed65_i_disciplina = $discregencia;
      $clhistmpsdisc->ed65_i_justificativa = $ed81_i_justificativa;
      $clhistmpsdisc->ed65_i_qtdch = $cargah;
      $clhistmpsdisc->ed65_c_resultadofinal = $ed74_c_resultadofinal;
      $clhistmpsdisc->ed65_t_resultobtido = $ed74_c_valoraprov;
      $clhistmpsdisc->ed65_c_situacao = $situacaodisc;
      $clhistmpsdisc->ed65_c_tiporesultado = $ed37_c_tipo;
      $clhistmpsdisc->incluir($ed65_i_codigo);
     }
     //finaliza diario,se situacao for MATRICULADO
     $sql_updiario = "UPDATE diario SET ed95_c_encerrado = 'S' where ed95_i_codigo = $ed74_i_diario";
     $result_updiario = pg_query($sql_updiario);
     $somacargah += $cargah;
    }
    if($medfrequencia=="DIAS LETIVOS"){
     $somacargah = $diasletivos*4;
    }else{
     $somacargah = $somacargah;
    }
    $sql_mps = "UPDATE historicomps SET ed62_i_qtdch = '$somacargah' where ed62_i_codigo = $histmps";
    $result_mps = pg_query($sql_mps);
   }else{
    //finaliza diario,se situacao for diferente de MATRICULADO
    $sql_updiario = "UPDATE diario SET ed95_c_encerrado = 'S' where ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $ed59_i_turma)";
    $result_updiario = pg_query($sql_updiario);
   }
  }
  //finaliza matricula
  $sql_upmat = "UPDATE matricula SET ed60_c_concluida = 'S',ed60_d_datamodif = '".date("Y-m-d",db_getsession("DB_datausu"))."' where ed60_i_codigo = $ed60_i_codigo";
  $result_upmat = pg_query($sql_upmat);
  $ed229_i_codigo = "";
  $clmatriculamov->ed229_i_matricula = $ed60_i_codigo;
  $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
  $clmatriculamov->ed229_c_procedimento = "ENCERRAR AVALIAÇÕES";
  $clmatriculamov->ed229_t_descr = "MATRÍCULA ENCERRADA EM ".date("d/m/Y",db_getsession("DB_datausu"))." COM SITUAÇÃO DE ".((trim($ed60_c_situacao)!="MATRICULADO")?trim($ed60_c_situacao):($resultadoserie=="A"?"APROVADO":"REPROVADO"));
  $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
  $clmatriculamov->incluir($ed229_i_codigo);
 }
 //finaliza regencia
 $result_reg = $clregencia->sql_record($clregencia->sql_query_file("","ed59_i_codigo as codregencia","","ed59_i_turma = $ed59_i_turma"));
 for($i=0;$i<$clregencia->numrows;$i++){
  db_fieldsmemory($result_reg,$i);
  $result_dia = $cldiario->sql_record($cldiario->sql_query_file("","ed95_i_regencia as fimregencia","","ed95_i_regencia = $codregencia AND ed95_c_encerrado = 'N'"));
  if($cldiario->numrows==0){
   //se todos diarios foram encerrados , finaliza regencia
   $sql_upreg = "UPDATE regencia SET ed59_c_encerrada = 'S' where ed59_i_codigo = $codregencia";
   $result_upreg = pg_query($sql_upreg);
  }
 }
 //pg_query("rollback");
 db_fim_transacao();
 ?>
 <script>
  alert("Encerramento de Avaliações concluído!");
  parent.dados.location.href = "edu1_diarioclasse004.php?turma=<?=$turma?>&ed57_c_descr=<?=$ed57_c_descr?>&ed52_c_descr=<?=$ed52_c_descr?>";
  parent.db_iframe_encerrar<?=$turma?>.hide();
 </script>
 <?
 exit;
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
.alunopq{
 color: #000000;
 font-family : Tahoma;
 font-size: 9;
 padding-top: 0px;
 padding-bottom: 0px;
}
</style>
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<?
$result1 = $clregenciaperiodo->sql_record($clregenciaperiodo->sql_query("","ed78_i_regencia,ed78_i_procavaliacao,ed78_i_aulasdadas,ed09_c_descr,ed232_c_descr","ed232_c_descr"," ed59_i_turma = $ed59_i_turma AND ed59_c_freqglob!='A' AND ed09_c_somach = 'S' AND ed59_c_condicao = 'OB'"));
//db_criatabela($result1);
$embranco = "";
$mensagem = "";
$sep = "";
$faltaaprov = false;
$mudaregencia = "";
for($x=0;$x<$clregenciaperiodo->numrows;$x++){
 db_fieldsmemory($result1,$x);
 if($mudaregencia!=$ed78_i_regencia){
  $mensagem .= "<hr>";
  $mudaregencia = $ed78_i_regencia;
 }
 if($ed78_i_aulasdadas==""){
  $embranco .= "S";
  $mensagem .= $sep." * Falta informar aulas dadas no período $ed09_c_descr para disciplina $ed232_c_descr";
  $sep = "|";
 }
}
if(strstr($embranco,"S")){
 $mensagens = explode("|",$mensagem);
 ?>
 <table border='0' width="100%" bgcolor="#cccccc" style="" cellspacing="0" cellpading="0">
 <tr>
  <td class='titulo'>
   Não foi possível encerrar as avaliações da turma <?=$ed57_c_descr?>
  </td>
 </tr>
 <?
 for($x=0;$x<count($mensagens);$x++){
  ?>
  <tr>
   <td class='aluno'>
    <?=$mensagens[$x]?>
   </td>
  </tr>
  <?
 }
 ?></table><?
}else{
 $sql2 = "SELECT DISTINCT ed60_i_codigo,to_ascii(ed47_v_nome) as ed47_v_nome,ed60_i_numaluno
          FROM matricula
           inner join aluno on ed47_i_codigo = ed60_i_aluno
           inner join diario on ed95_i_aluno = ed47_i_codigo
           inner join regencia on ed59_i_codigo = ed95_i_regencia
           inner join disciplina on ed12_i_codigo = ed59_i_disciplina
           inner join caddisciplina on ed232_i_codigo= ed12_i_caddisciplina
           inner join diariofinal on ed74_i_diario = ed95_i_codigo
          WHERE ed60_i_turma = $ed59_i_turma
          AND ed60_c_situacao = 'MATRICULADO'
          AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $turma)
          AND ed60_c_concluida = 'N'
          AND ed95_c_encerrado = 'N'
          AND ed59_c_condicao = 'OB'
          AND ( ed74_c_resultadofreq = '' OR ed74_c_resultadoaprov = '' )
          ORDER BY ed60_i_numaluno,to_ascii(ed47_v_nome)
         ";
 $result2 = pg_query($sql2);
 $linhas2 = pg_num_rows($result2);
 //db_criatabela($result2);
 //exit;
 $naopode = 0;
 $sep = "";
 if($linhas2>0){
  $faltaaprov = true;
  ?>
  <table border='1' width="100%" bgcolor="#cccccc" style="" cellspacing="0" cellpading="0">
  <tr>
   <td class='titulo' colspan="3">
    Não foi possível encerrar as avaliações dos seguintes alunos:
   </td>
  </tr>
  <tr>
   <td class='cabec1'>N°</td>
   <td class='cabec1'>Aluno</td>
   <td class='cabec1'>Detalhes</td>
  </tr>
  <?
  $cor1 = "#f3f3f3";
  $cor2 = "#DBDBDB";
  $cor = "";
  for($x=0;$x<$linhas2;$x++){
   db_fieldsmemory($result2,$x);
   $naopode .= $sep.$ed60_i_codigo;
   $sep = ",";
   if($cor==$cor1){
    $cor = $cor2;
   }else{
    $cor = $cor1;
   }
   ?>
   <tr bgcolor="<?=$cor?>">
    <td class='aluno'>
     <?=$ed60_i_numaluno==""||$ed60_i_numaluno==null?"&nbsp;":$ed60_i_numaluno?>
    </td>
    <td class='aluno'>
     <?=$ed47_v_nome?>
    </td>
    <td class='aluno'>
     <?
     $sql2a = "SELECT DISTINCT ed60_i_numaluno,ed60_i_aluno,
                      to_ascii(ed47_v_nome) as ed47_v_nome,
                      ed60_c_situacao,
                      ed232_c_descr,
                      ed59_c_freqglob,
                      ed74_c_resultadofinal
               FROM matricula
                inner join aluno on ed47_i_codigo = ed60_i_aluno
                inner join diario on ed95_i_aluno = ed47_i_codigo
                inner join regencia on ed59_i_codigo = ed95_i_regencia
                inner join disciplina on ed12_i_codigo = ed59_i_disciplina
                inner join caddisciplina on ed232_i_codigo= ed12_i_caddisciplina
                inner join diariofinal on ed74_i_diario = ed95_i_codigo
               WHERE ed60_i_codigo = $ed60_i_codigo
               AND ed59_i_turma = $turma
               AND ed60_c_situacao = 'MATRICULADO'
               AND ed95_c_encerrado = 'N'
               AND ed59_c_condicao = 'OB'
               AND ( ed74_c_resultadofreq = '' OR ed74_c_resultadoaprov = '' )
               ORDER BY ed60_i_numaluno,to_ascii(ed47_v_nome)
              ";
     $result2a = pg_query($sql2a);
     $linhas2a = pg_num_rows($result2a);
     //db_criatabela($result2a);
     for($t=0;$t<$linhas2a;$t++){
      db_fieldsmemory($result2a,$t);
      if(trim($ed59_c_freqglob)=="F"){?>
         Falta informar resultado final relativo a frequência para a disciplina <?=$ed232_c_descr?>.<br>
      <?}else{?>
         Falta informar resultado final relativo ao aproveitamento para a disciplina <?=$ed232_c_descr?>.<br>
      <?}?>
     <?}?>
    </td>
   </tr>
   <?
  }
  ?></table><br><?
 }
 $sql3 = "SELECT DISTINCT
                 ed60_i_codigo,
                 ed60_i_numaluno,
                 ed60_i_aluno,
                 ed60_c_situacao,
                 to_ascii(ed47_v_nome) as ed47_v_nome
          FROM matricula
           inner join aluno on ed47_i_codigo = ed60_i_aluno
           inner join diario on ed95_i_aluno = ed47_i_codigo
           inner join regencia on ed59_i_codigo = ed95_i_regencia
           inner join disciplina on ed12_i_codigo = ed59_i_disciplina
           inner join caddisciplina on ed232_i_codigo= ed12_i_caddisciplina
           inner join diariofinal on ed74_i_diario = ed95_i_codigo
          WHERE ed60_i_turma = $ed59_i_turma
          AND ed60_i_codigo not in ($naopode)
          AND ed60_c_situacao = 'MATRICULADO'
          AND ed60_c_ativa = 'S'
          AND ed60_c_concluida = 'N'
          AND ed95_c_encerrado = 'N'
          AND ed59_c_condicao = 'OB'
          AND ed74_c_resultadofreq != ''
          AND ed74_c_resultadoaprov != ''
          UNION
          SELECT DISTINCT
                 ed60_i_codigo,
                 ed60_i_numaluno,
                 ed60_i_aluno,
                 ed60_c_situacao,
                 to_ascii(ed47_v_nome) as ed47_v_nome
          FROM matricula
           inner join aluno on ed47_i_codigo = ed60_i_aluno
           inner join turma on ed57_i_codigo = ed60_i_turma
           inner join regencia on ed59_i_turma = ed57_i_codigo
           inner join disciplina on ed12_i_codigo = ed59_i_disciplina
           inner join caddisciplina on ed232_i_codigo= ed12_i_caddisciplina
          WHERE ed60_i_turma = $ed59_i_turma
          AND ed60_c_situacao != 'MATRICULADO'
          AND ed60_c_situacao != 'AVANÇADO'
          AND ed60_c_situacao != 'CLASSIFICADO'
          AND ed60_c_ativa = 'S'
          AND ed60_c_concluida = 'N'
          AND ed59_c_condicao = 'OB'
          ORDER BY ed60_i_numaluno,ed47_v_nome
         ";
 $result3 = pg_query($sql3);
 $linhas3 = pg_num_rows($result3);
 //db_criatabela($result3);
 //exit;
 if($linhas3>0){
  ?>
  <table border='1' width="100%" bgcolor="#cccccc" style="" cellspacing="0" cellpading="0">
  <tr>
   <td class='titulo' colspan="3">
    O sistema vai encerrar as matrículas dos seguintes alunos desta turma:
   </td>
  </tr>
  <tr>
   <td class='cabec1'>N°</td>
   <td class='cabec1'>Aluno</td>
   <td class='cabec1'>Resultado Final</td>
  </tr>
  <?
  $cor1 = "#f3f3f3";
  $cor2 = "#DBDBDB";
  $cor = "";
  $alunos = "";
  $sep = "";
  for($x=0;$x<$linhas3;$x++){
   db_fieldsmemory($result3,$x);
   $alunos .= $sep.$ed60_i_codigo;
   $sep = ",";
   if($cor==$cor1){
    $cor = $cor2;
   }else{
    $cor = $cor1;
   }
   ?>
   <tr bgcolor="<?=$cor?>">
    <td class='aluno'><?=$ed60_i_numaluno==""||$ed60_i_numaluno==null?"&nbsp;":$ed60_i_numaluno?></td>
    <td class='aluno'><?=$ed60_i_aluno?> - <?=$ed47_v_nome?></td>
    <td class='aluno'>
     <?
     if($ed60_c_situacao!="MATRICULADO"){
      echo trim($ed60_c_situacao);
     }else{
      $sql4 = "SELECT ed95_i_codigo
               FROM diario
                inner join aluno on ed47_i_codigo = ed95_i_aluno
                inner join diariofinal on ed74_i_diario = ed95_i_codigo
                inner join regencia on ed59_i_codigo = ed95_i_regencia
               WHERE ed95_i_aluno = $ed60_i_aluno
               AND ed95_i_calendario = $calend
               AND ed95_i_serie = $serie1
               AND ed59_c_condicao = 'OB'
               AND ed74_c_resultadofinal != 'A'
               ORDER BY to_ascii(ed47_v_nome)
               ";
      $result4 = pg_query($sql4);
      $linhas4 = pg_num_rows($result4);
      //db_criatabela($result4);
      if($linhas4==0){
       echo "APROVADO";
      }else{
       echo "REPROVADO";
      }
     }
     ?>
    </td>
   </tr>
   <?
  }
  ?>
  <tr bgcolor="#f3f3f3">
   <td align="center" class='aluno' colspan="3">
    <form name="form1" method="post" action="">
    <input type="submit" name="confirmar" value="Confirmar">
    <input name="fechar" type="button" value="Fechar" onclick="parent.db_iframe_encerrar<?=$turma?>.hide();">
    <input type="hidden" name="alunos" value="<?=$alunos?>">
    <input type="hidden" name="turma" value="<?=$turma?>">
    <input type="hidden" name="ed57_c_descr" value="<?=$ed57_c_descr?>">
    </form>
   </td>
  </tr>
  </table><?
 }elseif($linhas3==0 && $faltaaprov==false){
  ?>
  <table border='1' width="100%" bgcolor="#cccccc" style="" cellspacing="0" cellpading="0">
  <tr>
   <td class='titulo'>
    Todos os alunos já possuem avaliações encerradas.
   </td>
  </tr>
  <tr>
   <td align="center">
    <input type="button" name="fechar" value="Fechar" onclick="parent.db_iframe_encerrar<?=$turma?>.hide();">
   </td>
  </tr>
  <?
 }
}
?>
</body>
</html>