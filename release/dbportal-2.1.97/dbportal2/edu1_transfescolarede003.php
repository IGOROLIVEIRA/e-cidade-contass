<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_transfescolarede_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_logmatricula_classe.php");
$escola = db_getsession("DB_coddepto");
$cltransfescolarede = new cl_transfescolarede;
$clmatricula        = new cl_matricula;
$cllogmatricula     = new cl_logmatricula;
if(isset($incluir)){
 db_inicio_transacao();
 $result = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_turma,ed60_c_concluida as concluida,turma.ed57_i_turno as turnoturma",""," ed60_i_codigo = $matriculaorig"));
 db_fieldsmemory($result,0);
 if($concluida=="N"){
  $sql11 = "SELECT ed59_i_codigo as regturma FROM regencia WHERE ed59_i_turma = $codturmaorig";
  $result11 = pg_query($sql11);
  $linhas11 = pg_num_rows($result11);
  for($f=0;$f<$linhas11;$f++){
   db_fieldsmemory($result11,$f);
   $sql12 = "UPDATE diario SET
              ed95_c_encerrado = 'N'
             WHERE ed95_i_aluno = $codigoaluno
             AND ed95_i_regencia = $regturma
          ";
   $result12 = pg_query($sql12);
  }
 }
 $sql0 = "SELECT ed56_i_codigo,ed56_c_situacaoant as sitanterior
          FROM alunocurso
          WHERE ed56_i_aluno = $codigoaluno
          AND ed56_c_situacao = 'TRANSFERIDO REDE'";
 $result0 = pg_query($sql0);
 db_fieldsmemory($result0,0);
 $sitanterior = $sitanterior==""?"MATRICULADO":$sitanterior;
 if($concluida=="N"){
  $sql1 = "UPDATE matricula SET
            ed60_c_situacao = '$sitanterior',
            ed60_d_datamodif = '".date("Y-m-d",db_getsession("DB_datausu"))."'
           WHERE ed60_i_codigo = $matriculaorig
          ";
  $result1 = pg_query($sql1);
  //atualiza qtd de matriculas turma de origem
  $result2 = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $codturmaorig AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result2,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql3 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $codturmaorig
           ";
  $result3 = pg_query($sql3);
  $sql5 = "DELETE FROM matriculamov
           WHERE ed229_i_matricula = $matriculaorig
           AND ed229_c_procedimento = 'TRANSFERÊNCIA ENTRE ESCOLAS DA REDE'
          ";
  $query5 = pg_query($sql5);

 }
 if($concluida=="S"){
  if(trim($sitanterior)=="MATRICULADO"){
   $resfinal = ResultadoFinal($matriculaorig,$codigoaluno,$codturmaorig,$sitanterior,$concluida);
   $situacaoatual = $resfinal=="REPROVADO"?"REPETENTE":"APROVADO";
  }else{
   $situacaoatual = $sitanterior;
  }
 }else{
  $situacaoatual = $sitanterior;
 }
 $sql4 = "UPDATE alunocurso SET
           ed56_i_escola   = $codescolaorig,
           ed56_c_situacao = '$situacaoatual',
           ed56_c_situacaoant = '$sitanterior'
          WHERE ed56_i_codigo = $ed56_i_codigo
        ";
 $result4 = pg_query($sql4);
 $sql5 = "DELETE FROM transfescolarede
          WHERE ed103_i_codigo = $codigotransf
        ";
 $result5 = pg_query($sql5);
 $descr_origem = "Matrícula n°: $matriculaorig\nTurma: $descrturmaorig\nEscola: $descrescolaorig";
 $cllogmatricula->ed248_i_usuario = db_getsession("DB_id_usuario");
 $cllogmatricula->ed248_i_motivo  = null;
 $cllogmatricula->ed248_i_aluno   = $codigoaluno;
 $cllogmatricula->ed248_t_origem  = $descr_origem;
 $cllogmatricula->ed248_t_obs     = "Cancelamento de TRANSFERÊNCIA REDE( Escola Origem: $descrescolaorig Escola Destino: $descrescoladest )";
 $cllogmatricula->ed248_d_data    = date("Y-m-d",db_getsession("DB_datausu"));
 $cllogmatricula->ed248_c_hora    = date("H:i");
 $cllogmatricula->ed248_c_tipo    = "T";
 $cllogmatricula->incluir(null);
 //pg_query("rollback");
 db_fim_transacao();
 db_msgbox("Cancelamento efetuado com sucesso!");
 db_redireciona("edu1_transfescolarede003.php");
 exit;
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" height="18"  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
 <tr>
  <td>&nbsp;</td>
 </tr>
</table>
<form name="form1" method="post">
<?MsgAviso(db_getsession("DB_coddepto"),"escola");?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
 <tr>
  <td valign="top">
   <br>
   <fieldset style="width:95%"><legend><b>Cancelar Transferência entre Escolas da Rede</b></legend>
   <table border="0" align="left">
    </tr>
     <td colspan="2">
      <?
      $campos = "ed103_i_codigo,ed47_i_codigo,ed47_v_nome,ed103_d_data,escoladestino.ed18_c_nome as escoladestino";
      $result = $cltransfescolarede->sql_record($cltransfescolarede->sql_query("",$campos,"ed103_d_data desc"," ed103_i_escolaorigem = $escola AND ed103_c_situacao = 'A'"));
      ?>
      <b>Alunos Transferidos:</b>
      <select name="aluno" style="font-size:9px;" onchange="js_pesquisa(this.value);">
       <?
       if($cltransfescolarede->numrows==0){
        echo "<option value=''>Nenhum registro de transferência em aberto.</option>";
       }else{
        echo "<option value=''></option>";
        for($x=0;$x<$cltransfescolarede->numrows;$x++){
         db_fieldsmemory($result,$x);
         echo "<option value='$ed103_i_codigo' ".($ed103_i_codigo==@$aluno?"selected":"").">".db_formatar($ed103_d_data,'d')." -> $ed47_i_codigo - $ed47_v_nome ( Destino: $escoladestino )</option>";
        }
       }
       ?>
      </select>
     </td>
    </tr>
    <?if(isset($aluno)){
    $campos = "transfescolarede.ed103_d_data,
               transfescolarede.ed103_c_situacao,
               transfescolarede.ed103_t_obs,
               transfescolarede.ed103_i_codigo,
               transfescolarede.ed103_i_matricula,
               aluno.ed47_i_codigo as codigoaluno,
               serie.ed11_c_descr||' - '||ensino.ed10_c_abrev as descrseriedest,
               base.ed31_c_descr as descrbasedest,
               calendario.ed52_c_descr as descrcalendariodest,
               escoladestino.ed18_c_nome as descrescoladest,
               turno.ed15_c_nome as descrturnodest
              ";
    $result1 = $cltransfescolarede->sql_record($cltransfescolarede->sql_query("",$campos,""," ed103_i_codigo = $aluno"));
    db_fieldsmemory($result1,0);
    $campos1 = "turma.ed57_i_codigo as codturmaorig,
                turma.ed57_c_descr as descrturmaorig,
                serie.ed11_i_codigo as codserieorig,
                serie.ed11_c_descr ||' - '||ensino.ed10_c_abrev as descrserieorig,
                base.ed31_i_codigo as codbaseorig,
                calendario.ed52_i_codigo as codcalendarioorig,
                escola.ed18_i_codigo as codescolaorig,
                escola.ed18_c_nome as descrescolaorig,
                turno.ed15_i_codigo as codturnoorig,
                ed60_i_codigo as matriculaorig,
                ed60_c_situacao as situacaoorig,
                ed60_c_concluida as conclusaoorig,
                cursoedu.ed29_i_codigo as codcursoorig";
    $result2 = $clmatricula->sql_record($clmatricula->sql_query("",$campos1,""," ed60_i_codigo = $ed103_i_matricula"));
    if($clmatricula->numrows>0){
     db_fieldsmemory($result2,0);
     $conclusaoorig = $conclusaoorig=="S"?"SIM":"NAO";
    }
    ?>
    <tr>
     <td valign="top">
       <fieldset style="width:95%;"><legend><b>Dados de Origem</b></legend>
        <table>
         <tr>
          <td>
           <b>Escola:</b>
          </td>
          <td>
           <?db_input('descrescolaorig',40,@$descrescolaorig,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Matrícula:</b>
          </td>
          <td>
           <?db_input('codescolaorig',15,@$codescolaorig,true,'hidden',3,'')?>
           <?db_input('codbaseorig',15,@$codbaseorig,true,'hidden',3,'')?>
           <?db_input('codcalendarioorig',15,@$codcalendarioorig,true,'hidden',3,'')?>
           <?db_input('codturnoorig',15,@$codturnoorig,true,'hidden',3,'')?>
           <?db_input('codserieorig',15,@$codserieorig,true,'hidden',3,'')?>
           <?db_input('codcursoorig',15,@$codcursoorig,true,'hidden',3,'')?>
           <?db_input('matriculaorig',15,@$matriculaorig,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Situação:</b>
          </td>
          <td>
           <?db_input('situacaoorig',40,@$situacaoorig,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Concluida:</b>
          </td>
          <td>
           <?db_input('conclusaoorig',40,@$conclusaorig,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Série:</b>
          </td>
          <td>
           <?db_input('codserieorig',15,@$codserieorig,true,'hidden',3,'')?>
           <?db_input('descrserieorig',40,@$descrserieorig,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Turma:</b>
          </td>
          <td>
           <?db_input('codturmaorig',15,@$codturmaorig,true,'hidden',3,'')?>
           <?db_input('descrturmaorig',40,@$descrturmaorig,true,'text',3,'')?>
          </td>
         </tr>
        </table>
       </fieldset>
      </td>
      <td valign="top">
       <fieldset style="width:95%;"><legend><b>Dados de Destino</b></legend>
        <table>
         <tr>
          <td>
           <b>Escola:</b>
          </td>
          <td>
           <?db_input('descrescoladest',40,@$descrescoladest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Calendário:</b>
          </td>
          <td>
           <?db_input('descrcalendariodest',40,@$descrcalendariodest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Base:</b>
          </td>
          <td>
           <?db_input('descrbasedest',40,@$descrbasedest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Série:</b>
          </td>
          <td>
           <?db_input('descrseriedest',40,@$descrseriedest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Turno:</b>
          </td>
          <td>
           <?db_input('descrturnodest',40,@$descrturnodest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Transferido em:</b>
          </td>
          <td>
           <?db_inputdata('ed103_d_data',@$ed103_d_data_dia,@$ed103_d_data_mes,@$ed103_d_data_ano,true,'text',3,"")?>
          </td>
         </tr>
        </table>
       </fieldset>
     </td>
    </tr>
    <tr>
     <td colspan="2">
      <?
      $negado = false;
      $sql1 = "SELECT ed18_c_nome,ed56_c_situacao,ed11_c_descr
               FROM alunocurso
                inner join alunopossib on ed79_i_alunocurso = ed56_i_codigo
                inner join serie on ed11_i_codigo = ed79_i_serie
                inner join escola on ed18_i_codigo = ed56_i_escola
               WHERE ed56_i_aluno = $codigoaluno
               AND ed56_i_calendario = $codcalendarioorig
              ";
      $result1 = pg_query($sql1);
      $linhas1 = pg_num_rows($result1);
      if($linhas1==0){
       $negado = true;
      }else{
       db_fieldsmemory($result1,0);
       if(trim($ed56_c_situacao)!="TRANSFERIDO REDE"){
        $negado = true;
       }
      }
      if($negado==true){
       $sql1 = "SELECT ed18_c_nome,ed56_c_situacao,ed11_c_descr
                FROM alunocurso
                 inner join alunopossib on ed79_i_alunocurso = ed56_i_codigo
                 inner join serie on ed11_i_codigo = ed79_i_serie
                 inner join escola on ed18_i_codigo = ed56_i_escola
                WHERE ed56_i_aluno = $codigoaluno
                ";
       $result1 = pg_query($sql1);
       db_fieldsmemory($result1,0);
       echo "Transferência já foi concretizada no destino. Cancelamento da transferência não permitido.<br>
             Situação atual do aluno:<br>
             Escola: $ed18_c_nome<br>
             Situação: $ed56_c_situacao<br>
             Série: $ed11_c_descr<br>
            ";
      }
      if($conclusaoorig=="SIM" && $situacaoorig=="TRANSFERIDO REDE"){
       $negado = true;
       echo "<b>ATENÇÃO! Matrícula com situação de TRANSFERIDO REDE já está concluída na turma de origem. Cancelamento da transferência não permitido.</b><br><br>";
      }
      ?>
      <input type="hidden" name="codigotransf" value="<?=$ed103_i_codigo?>">
      <input type="hidden" name="codigoaluno" value="<?=$codigoaluno?>">
      <input type="submit" name="incluir" value="Confirmar Cancelamento" onclick="return js_confirma();" <?=$negado==true?"disabled":""?>>
     </td>
    </tr>
    <?}?>
   </table>
   </fieldset>
  </td>
 </tr>
</table>
</form>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
function js_pesquisa(){
 if(document.form1.aluno.value==""){
  location.href = 'edu1_transfescolarede003.php';
 }else{
  location.href = 'edu1_transfescolarede003.php?aluno='+document.form1.aluno.value;
 }
}
function js_confirma(){
 if(confirm('Confirmar cancelamento de transferência para este aluno?')){
  document.form1.incluir.style.visibility = "hidden";
  return true;
 }else{
  return false;
 }
}
</script>