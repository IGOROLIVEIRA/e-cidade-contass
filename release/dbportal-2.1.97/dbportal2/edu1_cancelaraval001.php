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
include("classes/db_alunocurso_classe.php");
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
$clalunocurso = new cl_alunocurso;
$clserie = new cl_serie;
$db_botao = true;
$escola = db_getsession("DB_coddepto");
$result = $clregencia->sql_record($clregencia->sql_query("","ed59_i_turma,ed57_c_descr,ed57_i_base,ed52_c_descr,ed57_i_calendario as codcalend,ed52_i_ano as anocal,ed52_i_periodo as percal,ed57_i_serie as codserie,ed57_i_turno as codturno,ed29_i_codigo as codcurso","","ed59_i_turma = $turma"));
db_fieldsmemory($result,0);
if(isset($proximo)){
 db_inicio_transacao();
 $tam = sizeof($alunos);
 for($x=0;$x<$tam;$x++){
  $result2 = $clalunocurso->sql_record($clalunocurso->sql_query("","ed56_i_codigo as codalunocurso,ed47_v_nome,ed56_c_situacao as sit_atual,ed56_i_base as base_atual,ed56_i_calendario as cal_atual",""," ed56_i_aluno = $alunos[$x]"));
  db_fieldsmemory($result2,0);
  if($sit_atual=="CONCLUÍDO"){
   db_msgbox("Aluno $ed47_v_nome já concluiu o curso, não sendo possível cancelar avaliações!");
  }else{
   db_fieldsmemory($result2,0);
   $result3 = $clregencia->sql_record($clregencia->sql_query("","ed59_i_codigo as regencia","","ed59_i_turma = $turma"));
   $sql5 = "UPDATE matricula SET
             ed60_c_concluida = 'N',
             ed60_d_datamodif = '".date("Y-m-d",db_getsession("DB_datausu"))."'
            WHERE ed60_i_aluno = $alunos[$x]
            AND ed60_i_turma = $turma
            AND ed60_c_ativa = 'S'
           ";
   $result5 = pg_query($sql5);
   $result55 = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_codigo as codmatricula","","ed60_i_turma = $turma AND ed60_i_aluno = $alunos[$x]"));
   db_fieldsmemory($result55,0);
   $ed229_i_codigo = "";
   $clmatriculamov->ed229_i_matricula = $codmatricula;
   $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
   $clmatriculamov->ed229_c_procedimento = "CANCELAR ENCERRAMENTO DE AVALIAÇÕES";
   $clmatriculamov->ed229_t_descr = "ENCERRAMENTO DE AVALIAÇÕES CANCELADO EM ".date("d/m/Y",db_getsession("DB_datausu"));
   $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
   $clmatriculamov->incluir($ed229_i_codigo);
   for($y=0;$y<$clregencia->numrows;$y++){
    db_fieldsmemory($result3,$y);
    $sql4 = "UPDATE regencia SET
              ed59_c_encerrada = 'N'
             WHERE ed59_i_codigo = $regencia
            ";
    $result4 = pg_query($sql4);
    $sql6 = "UPDATE diario SET
             ed95_c_encerrado = 'N'
            WHERE ed95_i_aluno = $alunos[$x]
            AND ed95_i_regencia = $regencia
           ";
    $result6 = pg_query($sql6);
   }
   $result7 = $clhistoricomps->sql_record($clhistoricomps->sql_query("","ed62_i_codigo as codhist",""," ed61_i_aluno = $alunos[$x] AND ed61_i_curso = $codcurso AND ed62_i_serie = $codserie AND ed62_i_anoref = $anocal AND ed62_i_periodoref = $percal"));
   if($clhistoricomps->numrows>0){
    db_fieldsmemory($result7,0);
    $sql8 = "DELETE from histmpsdisc
             WHERE ed65_i_historicomps = $codhist
            ";
    $result8 = pg_query($sql8);
    $sql8 = "DELETE from historicomps
             WHERE ed62_i_codigo = $codhist
            ";
    $result8 = pg_query($sql8);
   }
   if($codcalend==$cal_atual){
    $result9 = $clmatricula->sql_record($clmatricula->sql_query("","ed60_c_situacao as sit_ant,ed60_i_turmaant as turma_ant,ed60_c_rfanterior as rf_ant","","ed60_i_turma = $turma AND ed60_i_aluno = $alunos[$x] AND ed60_c_ativa = 'S'"));
    db_fieldsmemory($result9,0);
    $turma_ant = $turma_ant==""?"null":$turma_ant;
    $sql10 = "UPDATE alunocurso SET
               ed56_i_base = $ed57_i_base,
               ed56_i_calendario = $codcalend,
               ed56_c_situacao = '$sit_ant'
              WHERE ed56_i_codigo = $codalunocurso
             ";
    $result10 = pg_query($sql10);
    $sql11 = "UPDATE alunopossib SET
               ed79_i_serie = $codserie,
               ed79_i_turno = $codturno,
               ed79_i_turmaant = $turma_ant,
               ed79_c_resulant = '$rf_ant'
              WHERE ed79_i_alunocurso = $codalunocurso
             ";
    $result11 = pg_query($sql11);
   }
  }
 }
 db_fim_transacao();
 ?>
 <script>
  alert("Cancelamento do Encerramento de Avaliações concluído!");
  parent.dados.location.href = "edu1_diarioclasse004.php?turma=<?=$turma?>&ed57_c_descr=<?=$ed57_c_descr?>&ed52_c_descr=<?=$ed52_c_descr?>";
  parent.db_iframe_cancelar<?=$turma?>.hide();
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
$sql1 = "SELECT DISTINCT ed60_i_aluno,ed47_v_nome,ed60_i_numaluno,ed60_c_situacao,ed52_i_ano,ed52_d_inicio,ed52_i_codigo
         FROM matricula
          inner join aluno on ed47_i_codigo = ed60_i_aluno
          inner join turma on ed57_i_codigo = ed60_i_turma
          inner join calendario on ed52_i_codigo = ed57_i_calendario
          inner join diario on ed95_i_aluno = ed47_i_codigo
          inner join regencia on ed59_i_codigo = ed95_i_regencia
          inner join disciplina on ed12_i_codigo = ed59_i_disciplina
          inner join caddisciplina on ed232_i_codigo= ed12_i_caddisciplina
         WHERE ed60_i_turma = $ed59_i_turma
         AND ed60_c_concluida = 'S'
         AND ed95_c_encerrado = 'S'
         AND ed60_c_ativa = 'S'
         ORDER BY ed47_v_nome
        ";
$result1 = pg_query($sql1);
$linhas1 = pg_num_rows($result1);
//db_criatabela($result1);
//exit;
if($linhas1==0){
 ?>
 <table border='1' width="100%" bgcolor="#cccccc" style="" cellspacing="0" cellpading="0">
 <tr>
  <td class='titulo'>
   Não existem alunos com avaliações encerradas.
  </td>
 </tr>
 <tr>
  <td align="center">
   <input type="button" name="fechar" value="Fechar" onclick="parent.db_iframe_cancelar<?=$turma?>.hide();">
  </td>
 </tr>
 <?
}else{
 ?>
 <form name="form1" method="post" action="">
 <center>
 <table border="0" width="100%" align="center">
  <tr>
   <td valign="top" width="47%" align="center">
    <b>Alunos:</b><br>
    <select name="alunospossib" id="alunospossib" size="10" onclick="js_desabinc()" style="font-size:9px;width:320px;height:180px" multiple>
     <?
     if($linhas1>0){
      $alunos_nao = 0;
      for($i=0;$i<$linhas1;$i++) {
       db_fieldsmemory($result1,$i);
       $sql2 = "SELECT ed60_i_codigo
                FROM matricula
                 inner join turma on ed57_i_codigo = ed60_i_turma
                 inner join calendario on ed52_i_codigo = ed57_i_calendario
                WHERE ed60_i_aluno = $ed60_i_aluno
                AND ed52_i_ano >= $ed52_i_ano
                AND ed52_d_inicio > '$ed52_d_inicio'
                AND ed52_i_codigo != $ed52_i_codigo
               ";
       $result2 = pg_query($sql2);
       $linhas2 = pg_num_rows($result2);
       if($linhas2>0){
        $color = "red";
        $disabled = "disabled";
        $aster = "**";
        $alunos_nao++;
       }else{
        $color = "black";
        $disabled = "";
        $aster = "";
       }
       echo "<option style='color:$color' $disabled value='$ed60_i_aluno'>$aster $ed60_i_aluno - $ed47_v_nome ( $ed60_c_situacao )</option>\n";
      }
     }
     ?>
    </select>
   </td>
   <td align="center">
    <br>
    <table border="0">
     <tr>
      <td>
       <input name="incluirum" title="Incluir" type="button" value=">" onclick="js_alunospossib();" style="border:1px outset;border-top-color:#f3f3f3;border-left-color:#f3f3f3;background:#cccccc;font-size:15px;font-weight:bold;width:30px;height:20px;" disabled>
      </td>
     </tr>
     <tr><td height="1"></td></tr>
     <tr>
      <td>
       <input name="incluirtodos" title="Incluir Todos" type="button" value=">>" onclick="js_incluirtodos();" style="border:1px outset;border-top-color:#f3f3f3;border-left-color:#f3f3f3;background:#cccccc;font-size:15px;font-weight:bold;width:30px;height:20px;">
      </td>
     </tr>
    <tr><td height="8"></td></tr>
     <tr>
      <td>
       <hr>
      </td>
     </tr>
     <tr><td height="8"></td></tr>
     <tr>
      <td>
       <input name="excluirum" title="Excluir" type="button" value="<" onclick="js_excluir();" style="border:1px outset;border-top-color:#f3f3f3;border-left-color:#f3f3f3;background:#cccccc;font-size:15px;font-weight:bold;width:30px;height:20px;" disabled>
      </td>
     </tr>
     <tr><td height="1"></td></tr>
     <tr>
      <td>
       <input name="excluirtodos" title="Excluir Todos" type="button" value="<<" onclick="js_excluirtodos();" style="border:1px outset;border-top-color:#f3f3f3;border-left-color:#f3f3f3;background:#cccccc;font-size:15px;font-weight:bold;width:30px;height:20px;" disabled>
      </td>
     </tr>
    </table>
   </td>
   <td valign="top" width="47%" align="center">
    <b>Alunos para cancelar encerramento de avaliações:</b><br>
    <select name="alunos[]" id="alunos" size="10" onclick="js_desabexc()" style="font-size:9px;width:320px;height:180px" multiple>
    </select>
   </td>
  </tr>
  <?if($alunos_nao>0){?>
  <tr>
   <td colspan="3">
    <font color="red">
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <b>**Aluno(s) já matriculado(s) em um calendário posterior a desta turma. Cancelamento não permitido.</b>
    </font>
   </td>
  </tr>
  <?}?>
 </table>
 <input name="proximo" type="submit" value="Próximo" disabled onClick="js_selecionar();">
 <input name="fechar" type="button" value="Fechar" onclick="parent.db_iframe_cancelar<?=$turma?>.hide();">
 <input type="hidden" name="turma" value="<?=$turma?>">
 </form>
 </center>
<?}?>
</body>
</html>
<script>
function js_alunospossib() {
 var Tam = document.form1.alunospossib.length;
 var F = document.form1;
 for(x=0;x<Tam;x++){
  if(F.alunospossib.options[x].selected==true){
   F.elements['alunos[]'].options[F.elements['alunos[]'].options.length] = new Option(F.alunospossib.options[x].text,F.alunospossib.options[x].value)
   F.alunospossib.options[x] = null;
   Tam--;
   x--;
  }
 }
 var Tam = document.form1.alunospossib.length;
 var F = document.form1;
 for(x=0;x<Tam;x++){
  if(document.form1.alunospossib.options[x].disabled==false){
   document.form1.alunospossib.options[x].selected = true;
   break;
  }
 }
 if(document.form1.alunospossib.length==0){
  document.form1.incluirum.disabled = true;
  document.form1.incluirtodos.disabled = true;
 }
 document.form1.proximo.disabled = false;
 document.form1.excluirtodos.disabled = false;
 document.form1.alunospossib.focus();
}
function js_incluirtodos() {
 var Tam = document.form1.alunospossib.length;
 var F = document.form1;
 for(i=0;i<Tam;i++){
  if(F.elements['alunospossib'].options[0].disabled==true){
   F.elements['alunospossib'].options[F.elements['alunospossib'].options.length] = new Option(F.alunospossib.options[0].text,F.alunospossib.options[0].value);
   F.alunospossib.options[0] = null;
  }else{
   F.elements['alunos[]'].options[F.elements['alunos[]'].options.length] = new Option(F.alunospossib.options[0].text,F.alunospossib.options[0].value);
   F.alunospossib.options[0] = null;
  }
 }
 var Tam = document.form1.alunospossib.length;
 var F = document.form1;
 for(i=0;i<Tam;i++){
  F.elements['alunospossib'].options[i].disabled = true;
  F.elements['alunospossib'].options[i].style.color = "red";
 }
 document.form1.incluirum.disabled = true;
 document.form1.incluirtodos.disabled = true;
 document.form1.excluirtodos.disabled = false;
 document.form1.proximo.disabled = false;
 document.form1.alunos.focus();
}
function js_excluir() {
 var F = document.getElementById("alunos");
 Tam = F.length;
 for(x=0;x<Tam;x++){
  if(F.options[x].selected==true){
   document.form1.alunospossib.options[document.form1.alunospossib.length] = new Option(F.options[x].text,F.options[x].value);
   F.options[x] = null;
   Tam--;
   x--;
  }
 }
 if(document.form1.alunos.length>0){
  document.form1.alunos.options[0].selected = true;
 }
 if(F.length == 0){
  document.form1.proximo.disabled = true;
  document.form1.excluirum.disabled = true;
  document.form1.excluirtodos.disabled = true;
 }
 document.form1.incluirtodos.disabled = false;
 document.form1.alunos.focus();
}
function js_excluirtodos() {
 var Tam = document.form1.alunos.length;
 var F = document.getElementById("alunos");
 for(i=0;i<Tam;i++){
  document.form1.alunospossib.options[document.form1.alunospossib.length] = new Option(F.options[0].text,F.options[0].value);
  F.options[0] = null;
 }
 if(F.length == 0){
  document.form1.proximo.disabled = true;
  document.form1.excluirum.disabled = true;
  document.form1.excluirtodos.disabled = true;
  document.form1.incluirtodos.disabled = false;
 }
 document.form1.alunospossib.focus();
}
function js_selecionar(){
 var F = document.getElementById("alunos").options;
 for(var i = 0;i < F.length;i++) {
   F[i].selected = true;
 }
 return true;
}
function js_desabinc(){
 for(i=0;i<document.form1.alunospossib.length;i++){
  if(document.form1.alunospossib.length>0 && document.form1.alunospossib.options[i].selected){
   if(document.form1.alunos.length>0){
    document.form1.alunos.options[0].selected = false;
   }
   document.form1.incluirum.disabled = false;
   document.form1.excluirum.disabled = true;
  }
 }
}
function js_desabexc(){
 for(i=0;i<document.form1.alunos.length;i++){
  if(document.form1.alunos.length>0 && document.form1.alunos.options[i].selected){
   if(document.form1.alunospossib.length>0){
    document.form1.alunospossib.options[0].selected = false;
   }
   document.form1.incluirum.disabled = true;
   document.form1.excluirum.disabled = false;
  }
 }
}
</script>
