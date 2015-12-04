<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_alunotransfturma_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_turma_classe.php");
include("classes/db_procavaliacao_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_diario_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_diarioresultado_classe.php");
include("classes/db_diariofinal_classe.php");
include("classes/db_pareceraval_classe.php");
include("classes/db_parecerresult_classe.php");
include("classes/db_abonofalta_classe.php");
include("classes/db_amparo_classe.php");
include("classes/db_transfescolarede_classe.php");
include("classes/db_transfaprov_classe.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_aprovconselho_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$ed69_d_datatransf_dia = date("d",db_getsession("DB_datausu"));
$ed69_d_datatransf_mes = date("m",db_getsession("DB_datausu"));
$ed69_d_datatransf_ano = date("Y",db_getsession("DB_datausu"));
db_postmemory($HTTP_POST_VARS);
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$clalunotransfturma = new cl_alunotransfturma;
$clregencia = new cl_regencia;
$clturma = new cl_turma;
$clprocavaliacao = new cl_procavaliacao;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$cldiario = new cl_diario;
$cldiarioavaliacao = new cl_diarioavaliacao;
$cldiarioresultado = new cl_diarioresultado;
$cldiariofinal = new cl_diariofinal;
$clpareceraval = new cl_pareceraval;
$clparecerresult = new cl_parecerresult;
$clabonofalta = new cl_abonofalta;
$clamparo = new cl_amparo;
$cltransfescolarede = new cl_transfescolarede;
$cltransfaprov = new cl_transfaprov;
$clalunocurso = new cl_alunocurso;
$claprovconselho = new cl_aprovconselho;
$clalunotransfturma->rotulo->label();
$db_opcao = 22;
$db_botao = false;
?>
<table width="300" height="100" id="tab_aguarde" style="border:2px solid #444444;position:absolute;top:100px;left:250px;" cellspacing="1" cellpading="2">
 <tr>
  <td bgcolor="#DEB887" align="center" style="border:1px solid #444444;">
   <b>Aguarde...Carregando.</b>
  </td>
 </tr>
</table>
<?
if(!isset($incluir)&&!isset($incluir2)){
 ?>
 <html>
 <head>
 <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <meta http-equiv="Expires" CONTENT="0">
 <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
 <link href="estilos.css" rel="stylesheet" type="text/css">
 </head>
 <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
 <form name="form1" METHOD="POST" action="">
 <table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td colspan="4" valign="top" bgcolor="#CCCCCC">
   <br>
   <b>
   Caso as turmas de origem e destino tenham disciplinas e/ou períodos de avaliação diferentes,
   informe abaixo quais disciplinas e períodos de avaliação da turma de destino que vão receber
   as informações do aluno.
   </b>
   <br><br>
  </td>
 </tr>
 <tr>
  <td width="28%" valign="top" bgcolor="#CCCCCC">
   <b>Disciplinas TURMA DE ORIGEM:</b>
  </td>
  <td width="20"></td>
  <td width="28%" valign="top" bgcolor="#CCCCCC">
   <b>Disciplinas TURMA DE DESTINO:</b>
  </td>
  <td valign="top" bgcolor="#CCCCCC">
   <b>Aproveitamento na TURMA DE ORIGEM:</b>
  </td>
 </tr>
 <?
 $result_cod = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_aluno",""," ed60_i_codigo = $matricula"));
 db_fieldsmemory($result_cod,0);
 $result = $clregencia->sql_record($clregencia->sql_query("","ed59_i_codigo,ed232_i_codigo,ed232_c_descr,ed232_c_abrev,ed57_i_procedimento as procorigem","ed232_c_descr"," ed59_i_turma = $turmaorigem"));
 $procorigem = pg_result($result,0,'procorigem');
 $linhas = $clregencia->numrows;
 $result1 = $clregencia->sql_record($clregencia->sql_query("","ed59_i_codigo as regdestino,ed232_i_codigo as coddestino,ed232_c_descr as descrdestino,ed57_i_procedimento as procdestino","ed232_c_descr"," ed59_i_turma = $turmadestino"));
 $procdestino = pg_result($result1,0,'procdestino');
 $linhas1 = $clregencia->numrows;
 $regmarcadas = "";
 for($t=0;$t<$linhas;$t++){
  db_fieldsmemory($result,$t);
  ?>
  <tr>
   <td valign="top" bgcolor="#CCCCCC">
    <input name="regenciaorigem" type="text" value="<?=$ed59_i_codigo?>" size="10" readonly style="width:75px">
    <input name="regorigemdescr" type="text" value="<?=$ed232_c_descr?>" size="30" readonly style="width:180px">
   </td>
   <td align="center">--></td>
   <td>
    <?
    $temreg = false;
    for($w=0;$w<$linhas1;$w++){
     db_fieldsmemory($result1,$w);
     if($ed232_i_codigo==$coddestino){
      $temreg = true;
      $regenciadestino = $regdestino;
      $regdestinodescr = $descrdestino;
      $regmarcadas .= "#".$regdestino."#";
     }
    }
    if($temreg==true){
     ?>
      <input name="regenciadestino" type="text" value="<?=$regenciadestino?>" size="10" readonly style="width:75px">
      <input name="regdestinodescr" type="text" value="<?=$regdestinodescr?>" size="30" readonly style="width:180px">
     <?
    }else{
     $sql2 = "select ed59_i_codigo as regsobra,trim(ed232_c_descr) as descrsobra
              from regencia
              inner join disciplina on ed12_i_codigo = ed59_i_disciplina
              inner join caddisciplina on ed232_i_codigo = ed12_i_caddisciplina
              where ed59_i_turma = $turmadestino
              and ed232_i_codigo not in(select ed232_i_codigo from regencia
                                        inner join disciplina on ed12_i_codigo = ed59_i_disciplina
                                        inner join caddisciplina on ed232_i_codigo = ed12_i_caddisciplina
                                        where ed59_i_turma = $turmaorigem)";
     $result2 = pg_query($sql2);
     $linhas2 = pg_num_rows($result2);
     ?>
     <select name="regenciadestino" style="padding:0px;width:75px;height:16px;font-size:12px;" onchange="js_eliminareg(this.value,<?=$t?>)">
     <option value=""></option>
     <?
     for($w=0;$w<$linhas2;$w++){
      db_fieldsmemory($result2,$w);
      echo "<option value='$regsobra'>$regsobra</option>";
     }
     ?>
     </select>
     <select name="regdestinodescr" style="padding:0px;width:180px;height:16px;font-size:12px;" onchange="js_eliminareg(this.value,<?=$t?>)">
     <option value=""></option>
     <?
     for($w=0;$w<$linhas2;$w++){
      db_fieldsmemory($result2,$w);
      echo "<option value='$regsobra'>$descrsobra</option>";
     }
     ?>
     </select>
     <input type="hidden" name="combo" value="<?=$t?>">
     <input type="hidden" name="comboselect<?=$t?>" value="">
     <?
    }
    ?>
  </td>
  <td>
   <table border="1" cellspacing="0" cellpadding="0">
    <tr>
     <?
     $result_diario = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed09_c_abrev,ed72_i_valornota,ed72_c_valorconceito,ed72_t_parecer,ed37_c_tipo","ed41_i_sequencia ASC"," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $ed59_i_codigo AND ed09_c_somach = 'S'"));
     echo "<td width='40px' style='background:#444444;color:#DEB887'><b>$ed232_c_abrev</b></td>";
     if($cldiarioavaliacao->numrows==0){
      echo "<td width='160px' style='background:#f3f3f3;'>Nenhum registro.</td>";
     }else{
      for($v=0;$v<$cldiarioavaliacao->numrows;$v++){
       db_fieldsmemory($result_diario,$v);
       if(trim($ed37_c_tipo)=="NOTA"){
        if($resultedu=='S'){
         $aproveitamento = $ed72_i_valornota!=""?number_format($ed72_i_valornota,2,",","."):"";
        }else{
         $aproveitamento = $ed72_i_valornota!=""?number_format($ed72_i_valornota,0):"";
        }
       }elseif(trim($ed37_c_tipo)=="NIVEL"){
        $aproveitamento = $ed72_c_valorconceito;
       }else{
        $aproveitamento = "Parecer";
       }
       echo "<td width='40px' style='background:#f3f3f3;'><b>$ed09_c_abrev:</b></td>
             <td width='40px' align='center'>".($aproveitamento==""?"&nbsp;":$aproveitamento)."</td>";
      }
     }
     ?>
    </tr>
   </table>
  </td>
 </tr>
  <?
 }
 ?>
 <tr>
  <td valign="top" bgcolor="#CCCCCC">
   <b>Períodos de Avaliação TURMA DE ORIGEM:</b>
  </td>
  <td width="10"></td>
  <td valign="top" bgcolor="#CCCCCC">
   <b>Períodos de Avaliação  TURMA DE DESTINO:</b>
  </td>
 </tr>
 <?
 $result = $clprocavaliacao->sql_record($clprocavaliacao->sql_query("","ed41_i_codigo,ed09_i_codigo,ed09_c_descr,ed37_c_tipo,ed37_i_menorvalor,ed37_i_maiorvalor","ed41_i_sequencia"," ed41_i_procedimento = $procorigem"));
 $linhas = $clprocavaliacao->numrows;
 $result1 = $clprocavaliacao->sql_record($clprocavaliacao->sql_query("","ed41_i_codigo as codaval,ed09_i_codigo as codperaval,ed09_c_descr as descraval,ed37_c_tipo as tipodest,ed37_i_menorvalor as menordest,ed37_i_maiorvalor as maiordest","ed41_i_sequencia"," ed41_i_procedimento = $procdestino"));
 $linhas1 = $clprocavaliacao->numrows;
 for($t=0;$t<$linhas;$t++){
  db_fieldsmemory($result,$t);
  $tipoavaliacao = $ed37_c_tipo.($ed37_c_tipo=='NOTA'?' ('.$ed37_i_menorvalor.' a '.$ed37_i_maiorvalor.')':'');
  ?>
  <tr>
   <td valign="top" bgcolor="#CCCCCC">
    <input name="periodoorigem" type="text" value="<?=$ed41_i_codigo?>" size="10" readonly style="width:75px">
    <input name="perorigemdescr" type="text" value="<?=$ed09_c_descr.' - '.$tipoavaliacao?>" size="30" readonly style="width:180px">
   </td>
   <td align="center">--></td>
   <td>
    <?
    $temper = false;
    for($w=0;$w<$linhas1;$w++){
     db_fieldsmemory($result1,$w);
     if($ed09_i_codigo==$codperaval){
      $temper = true;
      $periododestino = $codaval;
      $tipoavaliacao1 = $tipodest.($tipodest=='NOTA'?' ('.$menordest.' a '.$maiordest.')':'');
      $perdestinodescr = $descraval.' - '.$tipoavaliacao1;
     }
    }
    if($temper==true){
     ?>
      <input name="periododestino" type="text" value="<?=$periododestino?>" size="10" readonly style="width:75px">
      <input name="perdestinodescr" type="text" value="<?=$perdestinodescr?>" size="30" readonly style="width:180px">
     <?
    }else{
     $sql2 = "select ed41_i_codigo as persobra,ed09_c_descr as descrsobra,ed37_c_tipo as tipodest,ed37_i_menorvalor as menordest,ed37_i_maiorvalor as maiordest
              from procavaliacao
               inner join periodoavaliacao on ed09_i_codigo = ed41_i_periodoavaliacao
               inner join formaavaliacao on ed37_i_codigo = ed41_i_formaavaliacao
               inner join procedimento on ed40_i_codigo = ed41_i_procedimento
               inner join turma on ed57_i_procedimento = ed40_i_codigo
              where ed57_i_codigo = $turmadestino
              and ed09_i_codigo not in(select ed09_i_codigo from procavaliacao
                                       inner join periodoavaliacao on ed09_i_codigo = ed41_i_periodoavaliacao
                                       inner join procedimento on ed40_i_codigo = ed41_i_procedimento
                                       inner join turma on ed57_i_procedimento = ed40_i_codigo
                                       where ed57_i_codigo = $turmaorigem)";
     $result2 = pg_query($sql2);
     $linhas2 = pg_num_rows($result2);
     ?>
     <select name="periododestino" style="padding:0px;width:75px;height:16px;font-size:12px;" onchange="js_eliminaper(this.value,<?=$t?>)">
     <option value=""></option>
     <?
     for($w=0;$w<$linhas2;$w++){
      db_fieldsmemory($result2,$w);
       echo "<option value='$persobra'>$persobra</option>";
     }
     ?>
     </select>
     <select name="perdestinodescr" style="padding:0px;width:180px;height:16px;font-size:12px;" onchange="js_eliminaper(this.value,<?=$t?>)">
     <option value=""></option>
     <?
     for($w=0;$w<$linhas2;$w++){
      db_fieldsmemory($result2,$w);
       $tipoavaliacao2 = $tipodest.($tipodest=='NOTA'?' ('.$menordest.' a '.$maiordest.')':'');
       echo "<option value='$persobra'>$descrsobra - $tipoavaliacao2</option>";
     }
     ?>
     </select>
     <input type="hidden" name="pcombo" value="<?=$t?>">
     <input type="hidden" name="pcomboselect<?=$t?>" value="">
     <?
    }
    ?>
  </td>
  <td></td>
  </tr>
  <?
 }
 ?>
 <tr>
  <td height="10" colspan="3"></td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted69_d_datatransf?>" colspan="3">
   <?=@$Led69_d_datatransf?>
   <?db_inputdata('ed69_d_datatransf',@$ed69_d_datatransf_dia,@$ed69_d_datatransf_mes,@$ed69_d_datatransf_ano,true,'text',1,"")?>
  </td>
 </tr>
 <tr>
  <td colspan="3">
   <b>Importar aproveitamento da turma de origem:</b>
   <select name="import" onchange="js_importar(this.value);">
    <option value="S">SIM</option>
    <option value="N">NÃO</option>
   </select>
  </td>
 </tr>
 <tr>
  <td height="10" colspan="3"></td>
 </tr>
 <tr>
  <td colspan="3">
   <input type="button" name="incluir" value="Incluir" onclick="js_processar();" <?=isset($incluir)||isset($incluir2)?"style='visibility:hidden;'":"style='position:absolute;visibility:visible;'"?>>
   <input type="button" name="incluir2" value="Incluir2" onclick="js_processar2();" <?=isset($incluir)||isset($incluir2)?"style='visibility:hidden;'":"style='position:absolute;visibility:hidden;'"?>>
  </td>
 </tr>
 </table>
 </form>
 </body>
 </html>
 <script>
 function js_eliminareg(valor,seq){
  C = document.form1.combo;
  RD = document.form1.regenciadestino;
  RDC = document.form1.regdestinodescr;
  tamC = C.length;
  tamC = tamC==undefined?1:tamC;
  campo = "comboselect"+seq;
  valorant = eval("document.form1."+campo+".value");
  if(tamC==1){
   tamRD = RD.length;
   for(r=0;r<tamRD;r++){
    if(parseInt(RD.options[r].value)==parseInt(valor) || parseInt(RDC.options[r].value)==parseInt(valor)){
     RD.options[r].selected = true;
     RDC.options[r].selected = true;
    }
    if(parseInt(RD.options[r].value)==parseInt(valorant) || parseInt(RDC.options[r].value)==parseInt(valorant)){
     RD.options[r].selected = false;
     RDC.options[r].selected = false;
    }
   }
  }else{
   for(i=0;i<tamC;i++){
    tamRD = RD[C[i].value].length;
    if(parseInt(C[i].value)!=parseInt(seq)){
     for(r=0;r<tamRD;r++){
      if(parseInt(RD[C[i].value].options[r].value)==parseInt(valor) || parseInt(RDC[C[i].value].options[r].value)==parseInt(valor)){
       RD[C[i].value].options[r].disabled = true;
       RDC[C[i].value].options[r].disabled = true;
      }
      if(parseInt(RD[C[i].value].options[r].value)==parseInt(valorant) || parseInt(RDC[C[i].value].options[r].value)==parseInt(valorant)){
       RD[C[i].value].options[r].disabled = false;
       RDC[C[i].value].options[r].disabled = false;
      }
     }
    }else{
     for(r=0;r<tamRD;r++){
      if(parseInt(RD[C[i].value].options[r].value)==parseInt(valor) || parseInt(RDC[C[i].value].options[r].value)==parseInt(valor)){
       RD[C[i].value].options[r].selected = true;
       RDC[C[i].value].options[r].selected = true;
      }
      if(parseInt(RD[C[i].value].options[r].value)==parseInt(valorant) || parseInt(RDC[C[i].value].options[r].value)==parseInt(valorant)){
       RD[C[i].value].options[r].selected = false;
               RDC[C[i].value].options[r].selected = false;
      }
     }
    }
   }
  }
  eval("document.form1."+campo+".value = valor");
 }
 function js_eliminaper(valor,seq){
  C = document.form1.pcombo;
  PD = document.form1.periododestino;
  PDC = document.form1.perdestinodescr;
  tamC = C.length;
  tamC = tamC==undefined?1:tamC;
  campo = "pcomboselect"+seq;
  valorant = eval("document.form1."+campo+".value");
  if(tamC==1){
   tamPD = PD.length;
   for(r=0;r<tamPD;r++){
    if(parseInt(PD.options[r].value)==parseInt(valor) || parseInt(PDC.options[r].value)==parseInt(valor)){
     PD.options[r].selected = true;
     PDC.options[r].selected = true;
    }
    if(parseInt(PD.options[r].value)==parseInt(valorant) || parseInt(PDC.options[r].value)==parseInt(valorant)){
     PD.options[r].selected = false;
     PDC.options[r].selected = false;
    }
   }
  }else{
   for(i=0;i<tamC;i++){
    tamPD = PD[C[i].value].length;
    if(parseInt(C[i].value)!=parseInt(seq)){
     for(r=0;r<tamPD;r++){
      if(parseInt(PD[C[i].value].options[r].value)==parseInt(valor) || parseInt(PDC[C[i].value].options[r].value)==parseInt(valor)){
       PD[C[i].value].options[r].disabled = true;
       PDC[C[i].value].options[r].disabled = true;
       }
      if(parseInt(PD[C[i].value].options[r].value)==parseInt(valorant) || parseInt(PDC[C[i].value].options[r].value)==parseInt(valorant)){
       PD[C[i].value].options[r].disabled = false;
       PDC[C[i].value].options[r].disabled = false;
      }
     }
    }else{
      for(r=0;r<tamPD;r++){
      if(parseInt(PD[C[i].value].options[r].value)==parseInt(valor) || parseInt(PDC[C[i].value].options[r].value)==parseInt(valor)){
       PD[C[i].value].options[r].selected = true;
       PDC[C[i].value].options[r].selected = true;
      }
      if(parseInt(PD[C[i].value].options[r].value)==parseInt(valorant) || parseInt(PDC[C[i].value].options[r].value)==parseInt(valorant)){
       PD[C[i].value].options[r].selected = false;
       PDC[C[i].value].options[r].selected = false;
      }
     }
    }
   }
  }
  eval("document.form1."+campo+".value = valor");
 }
 function js_processar(){
  RO = document.form1.regenciaorigem;
  RD = document.form1.regenciadestino;
  RC = document.form1.regorigemdescr;
  PO = document.form1.periodoorigem;
  PD = document.form1.periododestino;
  PC = document.form1.perorigemdescr;
  tamRO = RO.length;
  tamRO = tamRO==undefined?1:tamRO;
  regequiv = "";
  sepreg = "";
  msgreg = "Atenção:\nAs informações das seguintes disciplinas não serão transportadas, pois as mesmas não contém disciplinas equivalentes na turma de destino:\n\n";
  regnull = false;
  for(i=0;i<tamRO;i++){
   if(tamRO==1){
    if(RD.value!=""){
     regequiv += sepreg+RO.value+"|"+RD.value;
     sepreg = "X";
    }else{
     msgreg += RC.value+"\n";
     regnull = true;
    }
   }else{
    if(RD[i].value!=""){
     regequiv += sepreg+RO[i].value+"|"+RD[i].value;
     sepreg = "X";
    }else{
     msgreg += RC[i].value+"\n";
     regnull = true;
    }
   }
  }
  tamPO = PO.length;
  tamPO = tamPO==undefined?1:tamPO;
  perequiv = "";
  sepper = "";
  msgper = "Atenção:\nAs informações dos seguintes períodos de avaliação não serão transportadas, pois os mesmos não contém períodos de avaliação equivalentes na turma de destino:\n\n";
  pernull = false;
  for(i=0;i<tamPO;i++){
   if(tamPO==1){
    if(PD.value!=""){
     perequiv += sepper+PO.value+"|"+PD.value;
     sepper = "X";
    }else{
     msgper += PC.value+"\n";
     pernull = true;
    }
   }else{
    if(PD[i].value!=""){
     perequiv += sepper+PO[i].value+"|"+PD[i].value;
     sepper = "X";
    }else{
     msgper += PC[i].value+"\n";
     pernull = true;
    }
   }
  }
  msggeral = "";
  if(regnull==true){
   msggeral += msgreg+"\n";
  }
  if(pernull==true){
   msggeral += msgper;
  }
  tamRO = RO.length;
  tamRO = tamRO==undefined?1:tamRO;
  regselec = false;
  for(t=0;t<tamRO;t++){
   if(tamRO==1){
    if(RD.value!=""){
     regselec = true;
     break;
    }
   }else{
    if(RD[t].value!=""){
     regselec = true;
     break;
    }
   }
  }
  if(regselec==false){
   alert("Informe alguma disciplina da turma de destino para receber as informações da origem!");
   return false;
  }
  tamPO = PO.length;
  tamPO = tamPO==undefined?1:tamPO;
  perselec = false;
  for(t=0;t<tamPO;t++){
   if(tamPO==1){
    if(PD.value!=""){
     perselec = true;
     break;
    }
   }else{
    if(PD[t].value!=""){
     perselec = true;
     break;
    }
   }
  }
  if(perselec==false){
   alert("Informe algum período de avaliação da turma de destino para receber as informações da origem!");
   return false;
  }
  if(document.form1.ed69_d_datatransf.value==""){
   alert("Informe a data da transferência!");
   return false;
  }
  if(msggeral!=""){
   if(confirm(msggeral+"\n\nConfirmar Troca de Turma para o aluno?")){
    document.form1.incluir.style.visibility = "hidden";
    location.href = "edu1_alunotransfturma002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&data="+document.form1.ed69_d_datatransf.value;
   }
  }else{
   document.form1.incluir.style.visibility = "hidden";
   location.href = "edu1_alunotransfturma002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&data="+document.form1.ed69_d_datatransf.value;
  }
 }
 function js_importar(valor){
  if(valor=="N"){
   document.form1.incluir.style.visibility = "hidden";
   document.form1.incluir2.style.visibility = "visible";
   alert("Importar aproveitamento da turma de origem está marcado como NÃO. Caso este aluno tenha algum aproveitamento na turma de origem, este terá quer ser digitado manualmente!");
  }else{
   document.form1.incluir.style.visibility = "visible";
   document.form1.incluir2.style.visibility = "hidden";
  }
 }
 function js_processar2(){
  if(document.form1.ed69_d_datatransf.value==""){
   alert("Informe a data da transferência!");
   return false;
  }
  location.href = "edu1_alunotransfturma002.php?incluir2&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&data="+document.form1.ed69_d_datatransf.value;
 }
 </script>
 <?
}
if(isset($incluir)){
  //pg_query("begin");
  db_inicio_transacao();
  $result = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_aluno,ed60_c_rfanterior as rfanterior",""," ed60_i_codigo = $matricula"));
  db_fieldsmemory($result,0);
  $result0 = $clmatricula->sql_record($clmatricula->sql_query_file("","ed60_i_codigo as codmatrjatem",""," ed60_i_turma = $turmadestino AND ed60_i_aluno = $ed60_i_aluno"));
  if($clmatricula->numrows>0){
   db_fieldsmemory($result0,0);
  }else{
   $codmatrjatem = "";
  }
  if($codmatrjatem!=""){
   $transfmatricula = $codmatrjatem;
  }else{
   $transfmatricula = $matricula;
  }
  $clalunotransfturma->ed69_i_matricula = $transfmatricula;
  $clalunotransfturma->ed69_i_turmaorigem = $turmaorigem;
  $clalunotransfturma->ed69_i_turmadestino = $turmadestino;
  $clalunotransfturma->ed69_d_datatransf = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  $clalunotransfturma->incluir(null);
  $result = $clturma->sql_record($clturma->sql_query("","ed57_i_calendario,ed57_i_escola,ed57_i_serie",""," ed57_i_codigo = $turmadestino"));
  db_fieldsmemory($result,0);

  $periodos = explode("X",$perequiv);
  $msg_conversao = "";
  $sep_conversao = "";
  for($x=0;$x<count($periodos);$x++){
   $divideperiodos = explode("|",$periodos[$x]);
   $periodoorigem = $divideperiodos[0];
   $periododestino = $divideperiodos[1];
   $result_per = $clprocavaliacao->sql_record($clprocavaliacao->sql_query("","ed09_i_codigo,ed09_c_descr as perdestdescricao,ed37_c_tipo as tipodestino,ed37_i_maiorvalor as mvdestino",""," ed41_i_codigo = $periododestino"));
   db_fieldsmemory($result_per,0);
   $result_per1 = $clprocavaliacao->sql_record($clprocavaliacao->sql_query("","ed37_c_tipo as tipoorigem,ed37_i_maiorvalor as mvorigem",""," ed41_i_codigo = $periodoorigem"));
   db_fieldsmemory($result_per1,0);
   if(trim($tipoorigem)!=trim($tipodestino) || (trim($tipoorigem)==trim($tipodestino) && $mvorigem!=$mvdestino) ){
    $msg_conversao .= $sep_conversao." ".$perdestdescricao;
    $sep_conversao  = ",";
   }
   $regencias = explode("X",$regequiv);
   for($r=0;$r<count($regencias);$r++){
    $divideregencias = explode("|",$regencias[$r]);
    $regenciaorigem = $divideregencias[0];
    $regenciadestino = $divideregencias[1];
    $result11 = $cldiario->sql_record($cldiario->sql_query_file("","ed95_i_codigo as coddiarioorigem",""," ed95_i_regencia = $regenciaorigem AND ed95_i_aluno = $ed60_i_aluno"));
    if($cldiario->numrows>0){
     db_fieldsmemory($result11,0);
    }else{
     $coddiarioorigem = 0;
    }
    $result2 = $cldiario->sql_record($cldiario->sql_query_file("","ed95_i_codigo",""," ed95_i_regencia = $regenciadestino AND ed95_i_aluno = $ed60_i_aluno"));
    if($cldiario->numrows==0){
     $cldiario->ed95_c_encerrado = "N";
     $cldiario->ed95_i_escola = $ed57_i_escola;
     $cldiario->ed95_i_calendario = $ed57_i_calendario;
     $cldiario->ed95_i_aluno = $ed60_i_aluno;
     $cldiario->ed95_i_serie = $ed57_i_serie;
     $cldiario->ed95_i_regencia = $regenciadestino;
     $cldiario->incluir(null);
     $ed95_i_codigo = $cldiario->ed95_i_codigo;
    }else{
     db_fieldsmemory($result2,0);
     $sql21 = "UPDATE diario SET
                ed95_c_encerrado = 'N'
               WHERE ed95_i_codigo = $ed95_i_codigo
              ";
     $result21 = pg_query($sql21);
    }
    $result6 = $clamparo->sql_record($clamparo->sql_query_file("","ed81_i_codigo as codamparoorigem,ed81_i_justificativa,ed81_i_convencaoamp,ed81_c_todoperiodo,ed81_c_aprovch",""," ed81_i_diario = $coddiarioorigem"));
    if($clamparo->numrows>0){
     db_fieldsmemory($result6,0);
     $result7 = $clamparo->sql_record($clamparo->sql_query_file("","ed81_i_codigo",""," ed81_i_diario = $ed95_i_codigo"));
     if($clamparo->numrows==0){
      $clamparo->ed81_i_diario = $ed95_i_codigo;
      $clamparo->ed81_c_aprovch = $ed81_c_aprovch;
      $clamparo->ed81_c_todoperiodo = $ed81_c_todoperiodo;
      $clamparo->ed81_i_justificativa = $ed81_i_justificativa;
      $clamparo->ed81_i_convencaoamp = $ed81_i_convencaoamp;
      $clamparo->incluir(null);
     }else{
      db_fieldsmemory($result7,0);
      $clamparo->ed81_i_diario = $ed95_i_codigo;
      $clamparo->ed81_c_aprovch = $ed81_c_aprovch;
      $clamparo->ed81_c_todoperiodo = $ed81_c_todoperiodo;
      $clamparo->ed81_i_justificativa = $ed81_i_justificativa;
      $clamparo->ed81_i_convencaoamp = $ed81_i_convencaoamp;
      $clamparo->ed81_i_codigo = $ed81_i_codigo;
      $clamparo->alterar($ed81_i_codigo);
     }
    }
    $result9 = $cldiariofinal->sql_record($cldiariofinal->sql_query_file("","ed74_i_diario",""," ed74_i_diario = $ed95_i_codigo"));
    if($cldiariofinal->numrows==0){
     $cldiariofinal->ed74_i_diario = $ed95_i_codigo;
     $cldiariofinal->incluir(null);
    }
    $result3 = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query_file("","ed72_i_codigo as codavalorigem,ed72_i_numfaltas,ed72_i_valornota,ed72_c_valorconceito,ed72_t_parecer,ed72_c_aprovmin,ed72_c_amparo,ed72_t_obs,ed72_i_escola,ed72_c_tipo",""," ed72_i_diario = $coddiarioorigem AND ed72_i_procavaliacao = $periodoorigem"));
    if($cldiarioavaliacao->numrows>0){
     db_fieldsmemory($result3,0);
    }else{
     $codavalorigem = "";
     $ed72_i_numfaltas = null;
     $ed72_i_valornota = null;
     $ed72_c_valorconceito = "";
     $ed72_t_parecer = "";
     $ed72_c_aprovmin = "N";
     $ed72_c_amparo = "N";
     $ed72_t_obs = "";
     $ed72_i_escola = db_getsession("DB_coddepto");
     $ed72_c_tipo = "M";
    }
    if(trim($tipoorigem)!=trim($tipodestino) || (trim($tipoorigem)==trim($tipodestino) && $mvorigem!=$mvdestino) ){
     if($ed72_i_valornota=="" && $ed72_c_valorconceito=="" && $ed72_t_parecer==""){
      $ed72_c_convertido = "N";
     }else{
      $ed72_c_convertido = "S";
     }
    }else{
     $ed72_c_convertido = "N";
    }
    $result4 = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query_file("","ed72_i_codigo",""," ed72_i_diario = $ed95_i_codigo AND ed72_i_procavaliacao = $periododestino"));
    if($cldiarioavaliacao->numrows==0){
     $cldiarioavaliacao->ed72_i_diario = $ed95_i_codigo;
     $cldiarioavaliacao->ed72_i_procavaliacao = $periododestino;
     $cldiarioavaliacao->ed72_i_numfaltas = $ed72_i_numfaltas;
     $cldiarioavaliacao->ed72_i_valornota = $ed72_i_valornota;
     $cldiarioavaliacao->ed72_c_valorconceito = $ed72_c_valorconceito;
     $cldiarioavaliacao->ed72_t_parecer = $ed72_t_parecer;
     $cldiarioavaliacao->ed72_c_aprovmin = $ed72_c_aprovmin;
     $cldiarioavaliacao->ed72_c_amparo = $ed72_c_amparo;
     $cldiarioavaliacao->ed72_t_obs = $ed72_t_obs;
     $cldiarioavaliacao->ed72_i_escola = $ed72_i_escola;
     $cldiarioavaliacao->ed72_c_tipo = $ed72_c_tipo;
     $cldiarioavaliacao->ed72_c_convertido = $ed72_c_convertido;
     $cldiarioavaliacao->incluir(null);
     $ed72_i_codigo = $cldiarioavaliacao->ed72_i_codigo;
    }else{
     db_fieldsmemory($result4,0);
     $cldiarioavaliacao->ed72_i_diario = $ed95_i_codigo;
     $cldiarioavaliacao->ed72_i_procavaliacao = $periododestino;
     $cldiarioavaliacao->ed72_i_numfaltas = $ed72_i_numfaltas;
     $cldiarioavaliacao->ed72_i_valornota = $ed72_i_valornota;
     $cldiarioavaliacao->ed72_c_valorconceito = $ed72_c_valorconceito;
     $cldiarioavaliacao->ed72_t_parecer = $ed72_t_parecer;
     $cldiarioavaliacao->ed72_c_aprovmin = $ed72_c_aprovmin;
     $cldiarioavaliacao->ed72_c_amparo = $ed72_c_amparo;
     $cldiarioavaliacao->ed72_t_obs = $ed72_t_obs;
     $cldiarioavaliacao->ed72_i_escola = $ed72_i_escola;
     $cldiarioavaliacao->ed72_c_tipo = $ed72_c_tipo;
     $cldiarioavaliacao->ed72_c_convertido = $ed72_c_convertido;
     $cldiarioavaliacao->ed72_i_codigo = $ed72_i_codigo;
     $cldiarioavaliacao->alterar($ed72_i_codigo);
    }
    if($codavalorigem!=""){
     $result_transfaprov = $cltransfaprov->sql_record($cltransfaprov->sql_query_file("","ed251_i_codigo",""," ed251_i_diariodestino = $codavalorigem"));
     if($cltransfaprov->numrows>0){
      db_fieldsmemory($result_transfaprov,0);
      $cltransfaprov->ed251_i_diariodestino = $ed72_i_codigo;
      $cltransfaprov->ed251_i_codigo = $ed251_i_codigo;
      $cltransfaprov->alterar($ed251_i_codigo);
     }else{
      if($ed72_c_convertido=="S"){
       $cltransfaprov->ed251_i_diariodestino = $ed72_i_codigo;
       $cltransfaprov->ed251_i_diarioorigem = $codavalorigem;
       $cltransfaprov->incluir(null);
      }
     }
    }
    if($codavalorigem!=""){
     $result41 = $clpareceraval->sql_record($clpareceraval->sql_query_file("","ed93_t_parecer",""," ed93_i_diarioavaliacao = $codavalorigem"));
     $linhas41 = $clpareceraval->numrows;
     if($linhas41>0){
      $clpareceraval->excluir(""," ed93_i_diarioavaliacao = $ed72_i_codigo");
      for($w=0;$w<$linhas41;$w++){
       db_fieldsmemory($result41,$w);
       $clpareceraval->ed93_i_diarioavaliacao = $ed72_i_codigo;
       $clpareceraval->ed93_t_parecer = $ed93_t_parecer;
       $clpareceraval->incluir(null);
      }
     }
     $result42 = $clabonofalta->sql_record($clabonofalta->sql_query_file("","ed80_i_codigo",""," ed80_i_diarioavaliacao = $codavalorigem"));
     $linhas42 = $clabonofalta->numrows;
     if($linhas42>0){
      for($w=0;$w<$linhas42;$w++){
       db_fieldsmemory($result42,$w);
       $clabonofalta->ed80_i_diarioavaliacao = $ed72_i_codigo;
       $clabonofalta->ed80_i_codigo = $ed80_i_codigo;
       $clabonofalta->alterar($ed80_i_codigo);
      }
     }
    }
   }
  }
  $result_orig = $clturma->sql_record($clturma->sql_query("","ed57_c_descr as ed57_c_descrorig,ed57_i_base as baseorig,ed57_i_calendario as calorig,ed57_i_serie as serieorig,ed57_i_turno as turnoorig,ed10_i_codigo as ensinorigem",""," ed57_i_codigo = $turmaorigem"));
  db_fieldsmemory($result_orig,0);
  $result_alu = $clalunocurso->sql_record($clalunocurso->sql_query_file("","ed56_i_codigo",""," ed56_i_aluno = $ed60_i_aluno"));
  db_fieldsmemory($result_alu,0);
  $result_dest = $clturma->sql_record($clturma->sql_query("","ed57_c_descr as ed57_c_descrdest,ed57_i_base as basedest,ed57_i_calendario as caldest,ed57_i_serie as seriedest,ed57_i_turno as turnodest, ed10_i_codigo as ensinodestino",""," ed57_i_codigo = $turmadestino"));
  db_fieldsmemory($result_dest,0);
  $result1 = $clmatricula->sql_record($clmatricula->sql_query_file("","max(ed60_i_numaluno)",""," ed60_i_turma = $turmadestino"));
  db_fieldsmemory($result1,0);
  $max = $max==""?"null":($max+1);
  $ed60_d_datamodif = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  if($ensinorigem==$ensinodestino){
   $result_del = $cldiario->sql_record($cldiario->sql_query_file("","ed95_i_codigo as coddiariodel",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $turmaorigem)"));
   $linhas_del = $cldiario->numrows;
   for($z=0;$z<$linhas_del;$z++){
    db_fieldsmemory($result_del,$z);
    $clamparo->excluir(""," ed81_i_diario = $coddiariodel");
    $cldiariofinal->excluir(""," ed74_i_diario = $coddiariodel");
    $result5 = pg_query("select ed73_i_codigo from diarioresultado where ed73_i_diario = $coddiariodel");
    $linhas5 = pg_num_rows($result5);
    for($t=0;$t<$linhas5;$t++){
     db_fieldsmemory($result5,$t);
     $clparecerresult->excluir(""," ed63_i_diarioresultado = $ed73_i_codigo");
    }
    $cldiarioresultado->excluir(""," ed73_i_diario = $coddiariodel");
    $result6 = pg_query("select ed72_i_codigo from diarioavaliacao where ed72_i_diario = $coddiariodel");
    $linhas6 = pg_num_rows($result6);
    for($t=0;$t<$linhas6;$t++){
     db_fieldsmemory($result6,$t);
     $clpareceraval->excluir(""," ed93_i_diarioavaliacao = $ed72_i_codigo");
     $clabonofalta->excluir(""," ed80_i_diarioavaliacao = $ed72_i_codigo");
    }
    $cldiarioavaliacao->excluir(""," ed72_i_diario = $coddiariodel");
    $claprovconselho->excluir(""," ed253_i_diario = $coddiariodel");
    $cldiario->excluir(""," ed95_i_codigo = $coddiariodel");
   }
   if($codmatrjatem!=""){
    $sql = "UPDATE matricula SET
             ed60_i_turma = $turmadestino,
             ed60_i_numaluno = $max,
             ed60_d_datamodif = '$ed60_d_datamodif',
             ed60_c_concluida = 'N',
             ed60_c_situacao = 'MATRICULADO'
            WHERE ed60_i_codigo = $codmatrjatem
           ";
    $query = pg_query($sql);
    $sql11 = "UPDATE matriculamov SET
               ed229_i_matricula = $codmatrjatem
              WHERE ed229_i_matricula = $matricula
             ";
    $query11 = pg_query($sql11);
    $clalunotransfturma->excluir("","ed69_i_matricula  = $matricula ");
    $cltransfescolarede->excluir("","ed103_i_matricula  = $matricula ");
    $clmatricula->excluir($matricula);
    $matrmov = $codmatrjatem;
    LimpaResultadofinal($codmatrjatem);
   }else{
    $sql = "UPDATE matricula SET
             ed60_i_turma = $turmadestino,
             ed60_i_numaluno = $max,
             ed60_d_datamodif = '$ed60_d_datamodif'
            WHERE ed60_i_codigo = $matricula
           ";
    $query = pg_query($sql);
    $matrmov = $matricula;
    LimpaResultadofinal($matricula);
   }
  }else{     ///termina ensino igual else
   $sql = "UPDATE matricula SET
            ed60_d_datamodif = '$ed60_d_datamodif',
            ed60_c_situacao= 'TROCA DE TURMA',
            ed60_c_concluida='S'
           WHERE ed60_i_codigo = $matricula
          ";
   $query = pg_query($sql);
   LimpaResultadofinal($matricula);
   $clmatricula->ed60_d_datamodif =  substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
   $clmatricula->ed60_d_datamatricula = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
   $clmatricula->ed60_t_obs = "";
   $clmatricula->ed60_i_aluno = $ed60_i_aluno;
   $clmatricula->ed60_i_turma = $turmadestino;
   $clmatricula->ed60_i_turmaant = $turmaorigem;
   $clmatricula->ed60_c_rfanterior = $rfanterior;
   $clmatricula->ed60_i_numaluno = $max;
   $clmatricula->ed60_c_situacao = "MATRICULADO";
   $clmatricula->ed60_c_concluida = "N";
   $clmatricula->ed60_c_ativa = "S";
   $clmatricula->ed60_c_tipo = "N";
   $clmatricula->ed60_c_parecer = "N";
   $clmatricula->incluir(null);
   $matrmov= $clmatricula->ed60_i_codigo;
  }
  $clmatriculamov->ed229_i_matricula = $matrmov;
  $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
  $clmatriculamov->ed229_c_procedimento = "TROCAR ALUNO DE TURMA";
  $clmatriculamov->ed229_t_descr = "ALUNO TROCOU DE TURMA, PASSANDO DA TURMA ".trim($ed57_c_descrorig)." PARA A TURMA ".trim($ed57_c_descrdest);
  $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
  $clmatriculamov->incluir(null);
  $result_qtd = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $turmadestino AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result_qtd,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql1 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $turmadestino
           ";
  $query1 = pg_query($sql1);
  $result_qtd = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $turmaorigem AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result_qtd,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql1 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $turmaorigem
           ";
  $query1 = pg_query($sql1);
  $sql_alunocurso = "UPDATE alunocurso SET
                      ed56_i_base = $basedest,
                      ed56_i_calendario = $caldest
                     WHERE ed56_i_codigo = $ed56_i_codigo
                    ";
  $result_alunocurso = pg_query($sql_alunocurso);
  $sql_alunopossib = "UPDATE alunopossib SET
                       ed79_i_serie = $seriedest,
                       ed79_i_turno = $turnodest
                      WHERE ed79_i_alunocurso = $ed56_i_codigo
                     ";
  $result_alunopossib = pg_query($sql_alunopossib);
  db_fim_transacao();
  //pg_query("rollback");
  if($msg_conversao!=""){
   $mensagem = "ATENÇÃO!\\n\\n Caso o aluno tenha algum aproveitamento nos períodos abaixo relacionados, os mesmos deverão ser convertidos no Diário de Classe, devido a forma de avaliação da turma de origem ser diferente da turma de destino:\\n\\n$msg_conversao";
   db_msgbox($mensagem);
  }
  $clalunotransfturma->erro(true,false);
  ?><script>parent.location.href = "edu1_alunotransfturma001.php";</script><?
}


if(isset($incluir2)){
  //pg_query("begin");
  db_inicio_transacao();
  $result = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_aluno,ed60_c_rfanterior as rfanterior",""," ed60_i_codigo = $matricula"));
  db_fieldsmemory($result,0);
  $result0 = $clmatricula->sql_record($clmatricula->sql_query_file("","ed60_i_codigo as codmatrjatem",""," ed60_i_turma = $turmadestino AND ed60_i_aluno = $ed60_i_aluno"));
  if($clmatricula->numrows>0){
   db_fieldsmemory($result0,0);
  }else{
   $codmatrjatem = "";
  }
  if($codmatrjatem!=""){
   $transfmatricula = $codmatrjatem;
  }else{
   $transfmatricula = $matricula;
  }
  $clalunotransfturma->ed69_i_matricula = $transfmatricula;
  $clalunotransfturma->ed69_i_turmaorigem = $turmaorigem;
  $clalunotransfturma->ed69_i_turmadestino = $turmadestino;
  $clalunotransfturma->ed69_d_datatransf = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  $clalunotransfturma->incluir(null);
  $result = $clturma->sql_record($clturma->sql_query("","ed57_i_calendario,ed57_i_escola,ed57_i_serie",""," ed57_i_codigo = $turmadestino"));
  db_fieldsmemory($result,0);
  $result_orig = $clturma->sql_record($clturma->sql_query("","ed57_c_descr as ed57_c_descrorig,ed57_i_base as baseorig,ed57_i_calendario as calorig,ed57_i_serie as serieorig,ed57_i_turno as turnoorig,ed10_i_codigo as ensinorigem",""," ed57_i_codigo = $turmaorigem"));
  db_fieldsmemory($result_orig,0);
  $result_alu = $clalunocurso->sql_record($clalunocurso->sql_query_file("","ed56_i_codigo",""," ed56_i_aluno = $ed60_i_aluno"));
  db_fieldsmemory($result_alu,0);
  $result_dest = $clturma->sql_record($clturma->sql_query("","ed57_c_descr as ed57_c_descrdest,ed57_i_base as basedest,ed57_i_calendario as caldest,ed57_i_serie as seriedest,ed57_i_turno as turnodest, ed10_i_codigo as ensinodestino",""," ed57_i_codigo = $turmadestino"));
  db_fieldsmemory($result_dest,0);
  $result1 = $clmatricula->sql_record($clmatricula->sql_query_file("","max(ed60_i_numaluno)",""," ed60_i_turma = $turmadestino"));
  db_fieldsmemory($result1,0);
  $max = $max==""?"null":($max+1);
  $ed60_d_datamodif = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  if($ensinorigem==$ensinodestino){
   $result_del = $cldiario->sql_record($cldiario->sql_query_file("","ed95_i_codigo as coddiariodel",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia in (select ed59_i_codigo from regencia where ed59_i_turma = $turmaorigem)"));
   $linhas_del = $cldiario->numrows;
   for($z=0;$z<$linhas_del;$z++){
    db_fieldsmemory($result_del,$z);
    $clamparo->excluir(""," ed81_i_diario = $coddiariodel");
    $cldiariofinal->excluir(""," ed74_i_diario = $coddiariodel");
    $result5 = pg_query("select ed73_i_codigo from diarioresultado where ed73_i_diario = $coddiariodel");
    $linhas5 = pg_num_rows($result5);
    for($t=0;$t<$linhas5;$t++){
     db_fieldsmemory($result5,$t);
     $clparecerresult->excluir(""," ed63_i_diarioresultado = $ed73_i_codigo");
    }
    $cldiarioresultado->excluir(""," ed73_i_diario = $coddiariodel");
    $result6 = pg_query("select ed72_i_codigo from diarioavaliacao where ed72_i_diario = $coddiariodel");
    $linhas6 = pg_num_rows($result6);
    for($t=0;$t<$linhas6;$t++){
     db_fieldsmemory($result6,$t);
     $clpareceraval->excluir(""," ed93_i_diarioavaliacao = $ed72_i_codigo");
     $clabonofalta->excluir(""," ed80_i_diarioavaliacao = $ed72_i_codigo");
    }
    $cldiarioavaliacao->excluir(""," ed72_i_diario = $coddiariodel");
    $claprovconselho->excluir(""," ed253_i_diario = $coddiariodel");
    $cldiario->excluir(""," ed95_i_codigo = $coddiariodel");
   }
   if($codmatrjatem!=""){
    $sql = "UPDATE matricula SET
             ed60_i_turma = $turmadestino,
             ed60_i_numaluno = $max,
             ed60_d_datamodif = '$ed60_d_datamodif',
             ed60_c_concluida = 'N',
             ed60_c_situacao = 'MATRICULADO'
            WHERE ed60_i_codigo = $codmatrjatem
           ";
    $query = pg_query($sql);
    $sql11 = "UPDATE matriculamov SET
               ed229_i_matricula = $codmatrjatem
              WHERE ed229_i_matricula = $matricula
             ";
    $query11 = pg_query($sql11);
    $clalunotransfturma->excluir("","ed69_i_matricula  = $matricula ");
    $cltransfescolarede->excluir("","ed103_i_matricula  = $matricula ");
    $clmatricula->excluir($matricula);
    $matrmov = $codmatrjatem;
    LimpaResultadofinal($codmatrjatem);
   }else{
    $sql = "UPDATE matricula SET
             ed60_i_turma = $turmadestino,
             ed60_i_numaluno = $max,
             ed60_d_datamodif = '$ed60_d_datamodif'
            WHERE ed60_i_codigo = $matricula
           ";
    $query = pg_query($sql);
    $matrmov = $matricula;
    LimpaResultadofinal($matricula);
   }
  }else{     ///termina ensino igual else
   $sql = "UPDATE matricula SET
            ed60_d_datamodif = '$ed60_d_datamodif',
            ed60_c_situacao= 'TROCA DE TURMA',
            ed60_c_concluida='S'
           WHERE ed60_i_codigo = $matricula
          ";
   $query = pg_query($sql);
   LimpaResultadofinal($matricula);
   $clmatricula->ed60_d_datamodif =  substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
   $clmatricula->ed60_d_datamatricula = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
   $clmatricula->ed60_t_obs = "";
   $clmatricula->ed60_i_aluno = $ed60_i_aluno;
   $clmatricula->ed60_i_turma = $turmadestino;
   $clmatricula->ed60_i_turmaant = $turmaorigem;
   $clmatricula->ed60_c_rfanterior = $rfanterior;
   $clmatricula->ed60_i_numaluno = $max;
   $clmatricula->ed60_c_situacao = "MATRICULADO";
   $clmatricula->ed60_c_concluida = "N";
   $clmatricula->ed60_c_ativa = "S";
   $clmatricula->ed60_c_tipo = "N";
   $clmatricula->ed60_c_parecer = "N";
   $clmatricula->incluir(null);
   $matrmov = $clmatricula->ed60_i_codigo;
  }
  $clmatriculamov->ed229_i_matricula = $matrmov;
  $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
  $clmatriculamov->ed229_c_procedimento = "TROCAR ALUNO DE TURMA";
  $clmatriculamov->ed229_t_descr = "ALUNO TROCOU DE TURMA, PASSANDO DA TURMA ".trim($ed57_c_descrorig)." PARA A TURMA ".trim($ed57_c_descrdest);
  $clmatriculamov->ed229_d_data = date("Y-m-d",db_getsession("DB_datausu"));
  $clmatriculamov->incluir(null);
  $result_qtd = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $turmadestino AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result_qtd,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql1 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $turmadestino
           ";
  $query1 = pg_query($sql1);
  $result_qtd = $clmatricula->sql_record($clmatricula->sql_query_file(""," count(*) as qtdmatricula",""," ed60_i_turma = $turmaorigem AND ed60_c_situacao = 'MATRICULADO'"));
  db_fieldsmemory($result_qtd,0);
  $qtdmatricula = $qtdmatricula==""?0:$qtdmatricula;
  $sql1 = "UPDATE turma SET
            ed57_i_nummatr = $qtdmatricula
           WHERE ed57_i_codigo = $turmaorigem
           ";
  $query1 = pg_query($sql1);
  $sql_alunocurso = "UPDATE alunocurso SET
                      ed56_i_base = $basedest,
                      ed56_i_calendario = $caldest
                     WHERE ed56_i_codigo = $ed56_i_codigo
                    ";
  $result_alunocurso = pg_query($sql_alunocurso);
  $sql_alunopossib = "UPDATE alunopossib SET
                       ed79_i_serie = $seriedest,
                       ed79_i_turno = $turnodest
                      WHERE ed79_i_alunocurso = $ed56_i_codigo
                     ";
  $result_alunopossib = pg_query($sql_alunopossib);
  db_fim_transacao();
  //pg_query("rollback");
  $clalunotransfturma->erro(true,false);
  ?><script>parent.location.href = "edu1_alunotransfturma001.php";</script><?
}
?>
<script>document.getElementById("tab_aguarde").style.visibility = "hidden";</script>