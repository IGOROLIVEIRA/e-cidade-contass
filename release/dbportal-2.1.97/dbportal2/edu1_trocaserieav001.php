<?
require("libs/db_stdlib.php");
require("libs/db_stdlibwebseller.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_trocaserie_classe.php");
include("classes/db_turma_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_diario_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_diarioresultado_classe.php");
include("classes/db_diariofinal_classe.php");
include("classes/db_historico_classe.php");
include("classes/db_historicomps_classe.php");
include("classes/db_histmpsdisc_classe.php");
include("classes/db_regenciaperiodo_classe.php");
include("classes/db_procedimento_classe.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_alunopossib_classe.php");
include("classes/db_amparo_classe.php");
include("dbforms/db_funcoes.php");
$ed101_d_data_dia = date("d",db_getsession("DB_datausu"));
$ed101_d_data_mes = date("m",db_getsession("DB_datausu"));
$ed101_d_data_ano = date("Y",db_getsession("DB_datausu"));
$ed101_t_obs = "AVANÇO EM ".$ed101_d_data_dia." DE ".db_mes($ed101_d_data_mes,1)." DE ".$ed101_d_data_ano.", CONFORME LEI FEDERAL N° 9394/96, ALÍNEA C, PARECER CEED N° 740/99 E REGIMENTO ESCOLAR. LEIS N° 11114/2005 E 11274/2006.";
db_postmemory($HTTP_POST_VARS);
$cltrocaserie = new cl_trocaserie;
$clalunocurso = new cl_alunocurso;
$clalunopossib = new cl_alunopossib;
$clturma = new cl_turma;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clregencia = new cl_regencia;
$cldiario = new cl_diario;
$clamparo = new cl_amparo;
$cldiarioavaliacao = new cl_diarioavaliacao;
$cldiarioresultado = new cl_diarioresultado;
$cldiariofinal = new cl_diariofinal;
$clhistorico = new cl_historico;
$clhistoricomps = new cl_historicomps;
$clhistmpsdisc = new cl_histmpsdisc;
$clregenciaperiodo = new cl_regenciaperiodo;
$clprocedimento = new cl_procedimento;
$db_opcao = 1;
$db_botao = true;
$escola = db_getsession("DB_coddepto");
if(isset($incluir)){
 db_inicio_transacao();
 $cltrocaserie->ed101_c_tipo = "A";
 $cltrocaserie->incluir($ed101_i_codigo);
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
   <fieldset style="width:95%"><legend><b>Avanço de Aluno</b></legend>
    <?include("forms/db_frmtrocaserieav.php");?>
   </fieldset>
   </center>
  </td>
 </tr>
</table>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
js_tabulacaoforms("form1","ed101_i_aluno",true,1,"ed101_i_aluno",true);
</script>
<?
if(isset($incluir)){
 if($cltrocaserie->erro_status=="0"){
  $cltrocaserie->erro(true,false);
  $db_botao=true;
  echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
  echo "<script> document.form1.db_opcao.style.visibility='visible';</script>  ";
  if($cltrocaserie->erro_campo!=""){
    echo "<script> document.form1.".$cltrocaserie->erro_campo.".style.backgroundColor='#99A9AE';</script>";
    echo "<script> document.form1.".$cltrocaserie->erro_campo.".focus();</script>";
  }
 }else{
  $cltrocaserie->erro(true,false);
  $sql11 = "SELECT ed59_i_codigo as regturma FROM regencia WHERE ed59_i_turma = $ed101_i_turmaorig";
  $result11 = pg_query($sql11);
  $linhas11 = pg_num_rows($result11);
  for($f=0;$f<$linhas11;$f++){
   db_fieldsmemory($result11,$f);
   $sql12 = "UPDATE diario SET
              ed95_c_encerrado = 'S'
             WHERE ed95_i_aluno = $ed101_i_aluno
             AND ed95_i_regencia = $regturma
          ";
   $result12 = pg_query($sql12);
  }
  $result1 = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_codigo as codmatricula,ed29_i_codigo as codcurso,serie.ed11_i_codigo as seriemps,turma.ed57_c_descr as nometurma,calendario.ed52_i_ano as anoref,calendario.ed52_i_semletivas as semanas,turma.ed57_i_procedimento as codproc,turma.ed57_i_base as baseant",""," ed60_i_aluno = $ed101_i_aluno AND ed60_i_turma = $ed101_i_turmaorig"));
  db_fieldsmemory($result1,0);
  $result6 = $clmatricula->sql_record($clmatricula->sql_query_file("","max(ed60_i_numaluno)",""," ed60_i_turma = $ed101_i_turmadest"));
  db_fieldsmemory($result6,0);
  $max = $max==""?"null":($max+1);
  $ed60_d_datamodif = $ed101_d_data_ano."-".$ed101_d_data_mes."-".$ed101_d_data_dia;
  $observ = "AVANÇADO(A) DA SÉRIE ".(trim($ed11_c_origem))." PARA SÉRIE ".(trim($ed11_c_destino))." EM ".$ed101_d_data_dia."/".$ed101_d_data_mes."/".$ed101_d_data_ano.", CONFORME LEI FEDERAL N° 9394/96 - ARTIGO 23, § 1o , PARECER CEED N° 740/99 E REGIMENTO ESCOLAR";
  //incluir matricula do aluno para turma de destino
  $clmatricula->ed60_i_aluno = $ed101_i_aluno;
  $clmatricula->ed60_i_turma = $ed101_i_turmadest;
  $clmatricula->ed60_i_numaluno = $max;
  $clmatricula->ed60_c_situacao = "MATRICULADO";
  $clmatricula->ed60_c_concluida = "N";
  $clmatricula->ed60_i_turmaant = $ed101_i_turmaorig;
  $clmatricula->ed60_c_rfanterior = "A";
  $clmatricula->ed60_d_datamatricula = $ed60_d_datamodif;
  $clmatricula->ed60_d_datamodif = $ed60_d_datamodif;
  $clmatricula->ed60_t_obs = $observ;
  $clmatricula->ed60_c_ativa = "S";
  $clmatricula->ed60_c_tipo = "N";
  $clmatricula->ed60_c_parecer = "N";
  $clmatricula->incluir(null);
  if($clmatricula->erro_status=="0"){
   $clmatricula->erro(true,false);
  }
  $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
  $ultima = pg_result($result,0,0);
  $ed229_i_codigo = "";
  $clmatriculamov->ed229_i_matricula = $ultima;
  $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
  $clmatriculamov->ed229_c_procedimento = "PROGRESSÃO DE ALUNO -> AVANÇO";
  $clmatriculamov->ed229_t_descr = "ALUNO AVANÇADO DA TURMA ".trim($ed57_c_descrorig)." / ".trim($ed11_c_origem)." PARA A TURMA ".trim($ed57_c_descrdest)." / ".trim($ed11_c_destino);
  $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
  $clmatriculamov->incluir($ed229_i_codigo);
  //Atualiza matricula de origem
  $sql = "UPDATE matricula SET
           ed60_c_situacao = 'AVANÇADO',
           ed60_c_concluida = 'S',
           ed60_t_obs = '$observ',
           ed60_d_datamodif = '".date("Y-m-d",db_getsession("DB_datausu"))."'
          WHERE ed60_i_codigo = $codmatricula
         ";
  $result7 = pg_query($sql);
  $ed229_i_codigo = "";
  $clmatriculamov->ed229_i_matricula = $codmatricula;
  $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
  $clmatriculamov->ed229_c_procedimento = "PROGRESSÃO DE ALUNO -> AVANÇO";
  $clmatriculamov->ed229_t_descr = "ALUNO AVANÇADO DA TURMA ".trim($ed57_c_descrorig)." / ".trim($ed11_c_origem)." PARA A TURMA ".trim($ed57_c_descrdest)." / ".trim($ed11_c_destino);
  $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
  $clmatriculamov->incluir($ed229_i_codigo);
  //atualiza qtd de matriculas turma de destino
  $result8 = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $ed101_i_turmadest AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result8,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql1 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $ed101_i_turmadest
           ";
  $result9 = pg_query($sql1);
  //atualiza qtd de matriculas turma de origem
  $result8 = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $ed101_i_turmaorig AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result8,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql1 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $ed101_i_turmaorig
           ";
  $result9 = pg_query($sql1);
  //incluir no histórico
  $result12 = $clhistorico->sql_record($clhistorico->sql_query_file("","ed61_i_codigo",""," ed61_i_aluno = $ed101_i_aluno AND ed61_i_curso = $codcurso"));
  if($clhistorico->numrows==0){
   $ed61_i_codigo = "";
   $clhistorico->ed61_i_escola = $escola;
   $clhistorico->ed61_i_aluno = $ed101_i_aluno;
   $clhistorico->ed61_i_curso = $codcurso;
   $clhistorico->ed61_t_obs = "";
   $clhistorico->incluir($ed61_i_codigo);
   $result13 = $clhistorico->sql_record($clhistorico->sql_query_file("","ed61_i_codigo",""," ed61_i_aluno = $ed101_i_aluno AND ed61_i_curso = $codcurso"));
   db_fieldsmemory($result13,0);
  }else{
   db_fieldsmemory($result12,0);
  }
  //incluir serie do historico
  $ed62_i_codigo = "";
  $clhistoricomps->ed62_i_historico = $ed61_i_codigo;
  $clhistoricomps->ed62_i_escola = $escola;
  $clhistoricomps->ed62_i_serie = $seriemps;
  $clhistoricomps->ed62_i_turma = $nometurma;
  $clhistoricomps->ed62_i_anoref = $anoref;
  $clhistoricomps->ed62_i_justificativa = null;
  $clhistoricomps->ed62_i_periodoref = "0";
  $clhistoricomps->ed62_c_resultadofinal = "A";
  $clhistoricomps->ed62_c_situacao = "CONCLUÍDO";
  $clhistoricomps->ed62_i_diasletivos = 200;
  $clhistoricomps->ed62_i_qtdch = 0;
  $clhistoricomps->incluir($ed62_i_codigo);
  if($clhistoricomps->erro_status=="0"){
   $clhistoricomps->erro(true,false);
  }
  $result14 = $clhistoricomps->sql_record($clhistoricomps->sql_query_file("","ed62_i_codigo as histmps","","ed62_i_historico = $ed61_i_codigo AND ed62_i_escola = $escola AND ed62_i_serie = $seriemps"));
  db_fieldsmemory($result14,0);
  $result15 = $clprocedimento->sql_record($clprocedimento->sql_query("","substr(ed37_c_tipo,1,1) as ed37_c_tipo",""," ed40_i_codigo = $codproc"));
  db_fieldsmemory($result15,0);
  $result16 = $clregencia->sql_record($clregencia->sql_query("","ed59_i_codigo as regencia,ed12_i_codigo as disciplina,ed59_i_qtdperiodo",""," ed59_i_turma = $ed101_i_turmaorig"));
  for($x=0;$x<$clregencia->numrows;$x++){
   db_fieldsmemory($result16,$x);
   $aulas = $semanas*$ed59_i_qtdperiodo;
   $ed65_i_codigo = "";
   //incluir disciplinas na série
   $clhistmpsdisc->ed65_i_historicomps = $histmps;
   $clhistmpsdisc->ed65_i_disciplina = $disciplina;
   $clhistmpsdisc->ed65_i_justificativa = null;
   $clhistmpsdisc->ed65_i_qtdch = $aulas;
   $clhistmpsdisc->ed65_c_resultadofinal = "A";
   $clhistmpsdisc->ed65_t_resultobtido = "AVANÇO";
   $clhistmpsdisc->ed65_c_situacao = "CONCLUÍDO";
   $clhistmpsdisc->ed65_c_tiporesultado = "A";
   $clhistmpsdisc->incluir($ed65_i_codigo);
  }
  //atualiza alunocurso
  $result18 = $clturma->sql_record($clturma->sql_query_file("","*",""," ed57_i_codigo = $ed101_i_turmadest"));
  db_fieldsmemory($result18,0);
  $result19 = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_i_codigo",""," ed56_i_aluno = $ed101_i_aluno"));
  db_fieldsmemory($result19,0);
  $clalunocurso->ed56_i_codigo = $ed56_i_codigo;
  $clalunocurso->ed56_c_situacao = "MATRICULADO";
  $clalunocurso->ed56_i_base = $ed57_i_base;
  $clalunocurso->ed56_i_baseant = $baseant;
  $clalunocurso->alterar($ed56_i_codigo);
  $sql = "SELECT ed79_i_codigo FROM alunopossib WHERE ed79_i_alunocurso = $ed56_i_codigo";
  $result20 = pg_query($sql);
  db_fieldsmemory($result20,0);
  $clalunopossib->ed79_i_codigo = $ed79_i_codigo;
  $clalunopossib->ed79_i_alunocurso = $ed56_i_codigo;
  $clalunopossib->ed79_i_serie = $ed57_i_serie;
  $clalunopossib->ed79_i_turno = $ed57_i_turno;
  $clalunopossib->ed79_i_turmaant = $ed101_i_turmaorig;
  $clalunopossib->ed79_c_resulant = "A";
  $clalunopossib->ed79_c_situacao = "A";
  $clalunopossib->alterar($ed79_i_codigo);
  db_redireciona("edu1_trocaserieav001.php");
 }
}
?>
