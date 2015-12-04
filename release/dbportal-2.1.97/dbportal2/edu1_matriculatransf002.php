<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
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
include("classes/db_alunocurso_classe.php");
include("classes/db_alunopossib_classe.php");
include("classes/db_periodocalendario_classe.php");
include("classes/db_transfaprov_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$datamatricula_dia = date("d",db_getsession("DB_datausu"));
$datamatricula_mes = date("m",db_getsession("DB_datausu"));
$datamatricula_ano = date("Y",db_getsession("DB_datausu"));
db_postmemory($HTTP_POST_VARS);
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$escola = db_getsession("DB_coddepto");
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
$clalunocurso = new cl_alunocurso;
$clalunopossib = new cl_alunopossib;
$clperiodocalendario = new cl_periodocalendario;
$cltransfaprov = new cl_transfaprov;
?>
<table width="300" height="100" id="tab_aguarde" style="border:2px solid #444444;position:absolute;top:100px;left:250px;" cellspacing="1" cellpading="2">
 <tr>
  <td bgcolor="#DEB887" align="center" style="border:1px solid #444444;">
   <b>Aguarde...Carregando.</b>
  </td>
 </tr>
</table>
<?
if(!isset($incluir) && !isset($incluir2)){
 $result_cod = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_aluno,ed60_c_concluida",""," ed60_i_codigo = $matricula"));
 db_fieldsmemory($result_cod,0);
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
 <?if($ed60_c_concluida=="S"){?>
  <br>
  <b>Data da Matrícula:</b>
  <?db_inputdata('datamatricula',@$datamatricula_dia,@$datamatricula_mes,@$datamatricula_ano,true,'text',1,"")?>
  <br><br>
  <input name="incluir2" type="button" value="Confirmar Transferência" onclick="js_processar2();"<?=isset($incluir2)?"style='visibility:hidden;'":""?>>
 <?}else{?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
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
      if($linhas==1){
       echo "<option value='0'>TODAS</option>";
      }
      for($w=0;$w<$linhas2;$w++){
       db_fieldsmemory($result2,$w);
       echo "<option value='$regsobra'>$regsobra</option>";
      }
      ?>
      </select>
      <select name="regdestinodescr" style="padding:0px;width:180px;height:16px;font-size:12px;" onchange="js_eliminareg(this.value,<?=$t?>)">
      <option value=""></option>
      <?
      if($linhas==1){
       echo "<option value='0'>TODAS</option>";
      }
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
              <td width='35px' align='center'>".($aproveitamento==""?"&nbsp;":$aproveitamento)."</td>";
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
   <td valign="top" bgcolor="#CC CCCC">
    <b>Períodos de Avaliação TURMA DE ORIGEM:</b>
   </td>
   <td width="10"></td>
   <td valign="top" bgcolor="#CCCCCC">
    <b>Períodos de Avaliação  TURMA DE DESTINO:</b>
   </td>
   <td></td>
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
        echo "<option value='$persobra'>$descrsobra.' - '.$tipoavaliacao2</option>";
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
   <td nowrap colspan="4">
    <b>Data da Matrícula:</b>
    <?db_inputdata('datamatricula',@$datamatricula_dia,@$datamatricula_mes,@$datamatricula_ano,true,'text',1,"")?>
   </td>
  </tr>
  <tr>
   <td colspan="4">
    <b>Importar aproveitamento da turma de origem:</b>
    <select name="import" onchange="js_importar(this.value);">
     <option value="S">SIM</option>
     <option value="N">NÃO</option>
    </select>
   </td>
  </tr>
  <tr>
   <td height="10" colspan="4"></td>
  </tr>
  <tr>
   <td colspan="4">
    <?if(isset($matriculaante)){?>
     <input name="reativar" type="button" value="Reativar Matrícula n° <?=$matriculaante?>" onclick="js_processar(3);" <?=isset($incluir)?"style='visibility:hidden;'":""?>>
     <input name="novamatricula" type="button" value="Gerar Nova Matrícula" onclick="js_processar(2);" <?=isset($incluir)?"style='visibility:hidden;'":""?>>
    <?}else{?>
     <input name="incluir" type="button" value="Confirmar Transferência" onclick="js_processar(1);" <?=isset($incluir)?"style='visibility:hidden;'":""?>>
    <?}?>
   </td>
  </tr>
  </table>
 <?}?>
 <form>
 </body>
 </html>
 <script>
 function js_eliminareg(valor,seq){
  if(valor=="0" && document.form1.import.value=="S"){
   alert("Aproveitamento da disciplina de origem será transportado para todas as disciplinas da turma de destino!");
  }
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
 function js_processar(botao){
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
     if(RD.value!=0){
      regequiv += sepreg+RO.value+"|"+RD.value;
      sepreg = "X";
     }else{
      tamRD = document.form1.regenciadestino.options.length;
      for(t=2;t<tamRD;t++){
       regequiv += sepreg+RO.value+"|"+RD.options[t].value;
       sepreg = "X";
      }
     }
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
  if(regselec==false && document.form1.import.value=="S"){
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
  if(perselec==false && document.form1.import.value=="S"){
   alert("Informe algum período de avaliação da turma de destino para receber as informações da origem!");
   return false;
  }
  if(msggeral!="" && document.form1.import.value=="S"){
   if(confirm(msggeral+"\n\nConfirmar Transferência do aluno?")){
    <?if(isset($matriculaante)){?>
     document.form1.reativar.style.visibility = "hidden";
     document.form1.novamatricula.style.visibility = "hidden";
    <?}else{?>
     document.form1.incluir.style.visibility = "hidden";
    <?}?>
    if(botao==1){
     location.href = "edu1_matriculatransf002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&ed103_i_codigo=<?=$ed103_i_codigo?>&importaprov="+document.form1.import.value+"&data="+document.form1.datamatricula.value;
    }else if(botao==2){
     location.href = "edu1_matriculatransf002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&ed103_i_codigo=<?=$ed103_i_codigo?>&novamatricula=<?=@$matriculaante?>&importaprov="+document.form1.import.value+"&data="+document.form1.datamatricula.value;
    }else if(botao==3){
     location.href = "edu1_matriculatransf002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&ed103_i_codigo=<?=$ed103_i_codigo?>&reativar=<?=@$matriculaante?>&importaprov="+document.form1.import.value+"&data="+document.form1.datamatricula.value;
    }
   }
  }else{
   <?if(isset($matriculaante)){?>
    document.form1.reativar.style.visibility = "hidden";
    document.form1.novamatricula.style.visibility = "hidden";
   <?}else{?>
    document.form1.incluir.style.visibility = "hidden";
   <?}?>
   if(botao==1){
    location.href = "edu1_matriculatransf002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&ed103_i_codigo=<?=$ed103_i_codigo?>&importaprov="+document.form1.import.value+"&data="+document.form1.datamatricula.value;
   }else if(botao==2){
    location.href = "edu1_matriculatransf002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&ed103_i_codigo=<?=$ed103_i_codigo?>&novamatricula=<?=@$matriculaante?>&importaprov="+document.form1.import.value+"&data="+document.form1.datamatricula.value;
   }else if(botao==3){
    location.href = "edu1_matriculatransf002.php?incluir&regequiv="+regequiv+"&perequiv="+perequiv+"&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&ed103_i_codigo=<?=$ed103_i_codigo?>&reativar=<?=@$matriculaante?>&importaprov="+document.form1.import.value+"&data="+document.form1.datamatricula.value;
   }
  }
 }
 function js_processar2(){
  document.form1.incluir2.style.visibility = "hidden";
  location.href = "edu1_matriculatransf002.php?incluir2&matricula=<?=$matricula?>&turmaorigem=<?=$turmaorigem?>&turmadestino=<?=$turmadestino?>&ed103_i_codigo=<?=$ed103_i_codigo?>&data="+document.form1.datamatricula.value;
 }
 function js_importar(valor){
  if(valor=="N"){
   alert("Importar aproveitamento da turma de origem está marcado como NÃO. Caso este aluno tenha algum aproveitamento na turma de origem, este terá quer ser digitado manualmente!");
  }
 }
 </script>
 <?
}
if(isset($incluir)){
 //pg_query("begin");
 db_inicio_transacao();
 $result = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_aluno",""," ed60_i_codigo = $matricula"));
 db_fieldsmemory($result,0);
 $result0 = $clmatricula->sql_record($clmatricula->sql_query_file("","ed60_i_codigo as codmatrjatem",""," ed60_i_turma = $turmadestino AND ed60_i_aluno = $ed60_i_aluno AND ed60_c_ativa ='S'"));
 if($clmatricula->numrows>0){
  db_fieldsmemory($result0,0);
 }else{
  $codmatrjatem = "";
 }
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
  $result_fimper = $clperiodocalendario->sql_record($clperiodocalendario->sql_query_file("","ed53_d_fim,ed53_d_inicio",""," ed53_i_calendario = $ed57_i_calendario AND ed53_i_periodoavaliacao = $ed09_i_codigo"));
  db_fieldsmemory($result_fimper,0);
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
    $result_last = @pg_query("select last_value from diario_ed95_i_codigo_seq");
    $ed95_i_codigo = pg_result($result_last,0,0);
   }else{
    db_fieldsmemory($result2,0);
    $sql21 = "UPDATE diario SET
               ed95_c_encerrado = 'N'
              WHERE ed95_i_codigo = $ed95_i_codigo
             ";
    $result21 = pg_query($sql21);
   }
   if($importaprov=="S"){
    $result6 = $clamparo->sql_record($clamparo->sql_query_file("","ed81_i_codigo as codamparoorigem,ed81_i_justificativa,ed81_c_todoperiodo,ed81_i_convencaoamp,ed81_c_aprovch",""," ed81_i_diario = $coddiarioorigem"));
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
   }
   $result9 = $cldiariofinal->sql_record($cldiariofinal->sql_query_file("","ed74_i_diario",""," ed74_i_diario = $ed95_i_codigo"));
   if($cldiariofinal->numrows==0){
    $cldiariofinal->ed74_i_diario = $ed95_i_codigo;
    $cldiariofinal->incluir(null);
   }
   $result3 = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query_file("","ed72_i_codigo as codavalorigem,ed72_i_numfaltas,ed72_i_valornota,ed72_c_valorconceito,ed72_t_parecer,ed72_c_aprovmin,ed72_c_amparo,ed72_t_obs,ed72_i_escola,ed72_c_tipo,ed72_c_convertido",""," ed72_i_diario = $coddiarioorigem AND ed72_i_procavaliacao = $periodoorigem"));
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
    $ed72_i_escola = $escola;
    $ed72_c_tipo = "M";
    $ed72_c_convertido = "N";
   }
   $datahj = date("Ymd");
   $datafimperiodo = str_replace("-","",$ed53_d_fim);
   if($datafimperiodo>=$datahj && ($ed72_i_valornota=="" && $ed72_c_valorconceito=="" && $ed72_t_parecer=="")){
    $ed72_i_escola = $escola;
    $ed72_c_tipo = "M";
   }
   $result_tr = $cltransfaprov->sql_record($cltransfaprov->sql_query("","ed251_i_codigo as pranada",""," ed251_i_diariodestino = ".($codavalorigem==""?0:$codavalorigem).""));
   if(trim($tipoorigem)!=trim($tipodestino) || (trim($tipoorigem)==trim($tipodestino) && $mvorigem!=$mvdestino) ){
    if(($ed72_i_escola!=$escola && $ed72_c_tipo=="M") || $cltransfaprov->numrows>0){
     $ed72_c_convertido = "S";
    }else{
     $ed72_c_convertido = "N";
    }
   }else{
    $ed72_c_convertido = "N";
   }
   if($importaprov=="N"){
    $ed72_i_numfaltas = null;
    $ed72_i_valornota = null;
    $ed72_c_valorconceito = "";
    $ed72_t_parecer = "";
    $ed72_c_aprovmin = "N";
    $ed72_c_amparo = "N";
    $ed72_t_obs = "";
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
    $result_last = @pg_query("select last_value from diarioavaliacao_ed72_i_codigo_seq");
    $ed72_i_codigo = pg_result($result_last,0,0);
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
   if(($ed72_i_escola!=$escola && $ed72_c_tipo=="M") || $cltransfaprov->numrows>0){
    $cltransfaprov->ed251_i_diarioorigem = $codavalorigem==""?null:$codavalorigem;
    $cltransfaprov->ed251_i_diariodestino = $ed72_i_codigo;
    $cltransfaprov->incluir(null);
   }
   if($codavalorigem!="" && $importaprov=="S"){
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
 $result_orig = $clturma->sql_record($clturma->sql_query("","ed57_c_descr as ed57_c_descrorig,ed57_i_base as baseorig,ed57_i_calendario as calorig,ed57_i_serie as serieorig,ed57_i_turno as turnoorig,escola.ed18_c_nome as nomeescolaorig,ed31_i_curso as cursoorig,ed57_i_escola as escolaorig",""," ed57_i_codigo = $turmaorigem"));
 db_fieldsmemory($result_orig,0);
 $result_alu = $clalunopossib->sql_record($clalunopossib->sql_query("","ed56_i_codigo,ed79_c_resulant",""," ed56_i_aluno = $ed60_i_aluno"));
 db_fieldsmemory($result_alu,0);
 $result_dest = $clturma->sql_record($clturma->sql_query_file("","ed57_c_descr as ed57_c_descrdest,ed57_i_base as basedest,ed57_i_calendario as caldest,ed57_i_serie as seriedest,ed57_i_turno as turnodest,ed57_i_escola as escoladest",""," ed57_i_codigo = $turmadestino"));
 db_fieldsmemory($result_dest,0);
 $result1 = $clmatricula->sql_record($clmatricula->sql_query_file("","max(ed60_i_numaluno)",""," ed60_i_turma = $turmadestino"));
 db_fieldsmemory($result1,0);
 $max = $max==""?"null":($max+1);
 if(isset($novamatricula)){
  $sql3 = "UPDATE matricula SET
            ed60_c_concluida = 'S',
            ed60_c_ativa = 'N'
           WHERE ed60_i_codigo = $novamatricula
          ";
  $query3 = pg_query($sql3);
  $result2 = $clmatricula->sql_record($clmatricula->sql_query_file("","ed60_i_numaluno",""," ed60_i_turma = $turmadestino AND ed60_i_aluno = $ed60_i_aluno "));
  db_fieldsmemory($result2,0);
  $ed60_i_numaluno = $ed60_i_numaluno==""?"":$ed60_i_numaluno;
  $clmatricula->ed60_d_datamodif =  substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  $clmatricula->ed60_d_datamatricula = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  $clmatricula->ed60_t_obs = "";
  $clmatricula->ed60_i_aluno = $ed60_i_aluno;
  $clmatricula->ed60_i_turma = $turmadestino;
  $clmatricula->ed60_i_turmaant = $turmaorigem;
  $clmatricula->ed60_c_rfanterior = $ed79_c_resulant;
  $clmatricula->ed60_i_numaluno = $ed60_i_numaluno;
  $clmatricula->ed60_c_situacao = "MATRICULADO";
  $clmatricula->ed60_c_concluida = "N";
  $clmatricula->ed60_c_ativa = "S";
  $clmatricula->ed60_c_tipo = "N";
  $clmatricula->ed60_c_parecer = "N";
  $clmatricula->incluir(null);
  $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
  $matrmov = pg_result($result,0,0);
 }else{
  if($codmatrjatem!=""){
   $data_modif = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
   $sql = "UPDATE matricula SET
            ed60_i_turmaant = $turmaorigem,
            ed60_c_rfanterior = '$ed79_c_resulant',
            ed60_d_datamodif = '$data_modif',
            ed60_c_concluida = 'N',
            ed60_c_situacao = 'MATRICULADO'
           WHERE ed60_i_codigo = $codmatrjatem
          ";
   $query = pg_query($sql);
   $matrmov = $codmatrjatem;
  }else{
   $clmatricula->ed60_d_datamodif =  substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
   $clmatricula->ed60_d_datamatricula = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
   $clmatricula->ed60_t_obs = "";
   $clmatricula->ed60_i_aluno = $ed60_i_aluno;
   $clmatricula->ed60_i_turma = $turmadestino;
   $clmatricula->ed60_i_turmaant = $turmaorigem;
   $clmatricula->ed60_c_rfanterior = $ed79_c_resulant;
   $clmatricula->ed60_i_numaluno = $max;
   $clmatricula->ed60_c_situacao = "MATRICULADO";
   $clmatricula->ed60_c_concluida = "N";
   $clmatricula->ed60_c_ativa = "S";
   $clmatricula->ed60_c_tipo = "N";
   $clmatricula->ed60_c_parecer = "N";
   $clmatricula->incluir(null);
   $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
   $matrmov = pg_result($result,0,0);
  }
 }
 $clmatriculamov->ed229_i_matricula = $matrmov;
 $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
 $clmatriculamov->ed229_c_procedimento = "MATRICULAR ALUNOS TRANSFERIDOS";
 $clmatriculamov->ed229_t_descr = "ALUNO MATRICULADO NA TURMA ".trim($ed57_c_descrdest)." VINDO DA ESCOLA ".trim($nomeescolaorig);
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
 $sql1 = "UPDATE alunocurso SET
           ed56_c_situacao = 'MATRICULADO',
           ed56_i_escola = $escoladest,
           ed56_i_base = $basedest,
           ed56_i_calendario = $caldest,
           ed56_i_baseant = null,
           ed56_i_calendarioant = null,
           ed56_c_situacaoant = ''
          WHERE ed56_i_codigo = $ed56_i_codigo
        ";
 $result1 = pg_query($sql1);
 //atualiza serie do curso
 $sql2 = "UPDATE alunopossib SET
           ed79_i_serie = $seriedest,
           ed79_i_turno = $turnodest,
           ed79_i_turmaant = $turmaorigem,
           ed79_c_resulant = '$ed79_c_resulant',
           ed79_c_situacao = 'A'
          WHERE ed79_i_alunocurso = $ed56_i_codigo
        ";
 $result2 = pg_query($sql2);
 //atualiza historico e transfere para escola destino
 $sql3 = "UPDATE historico SET
           ed61_i_escola = $escoladest
          WHERE ed61_i_curso = $cursoorig
          AND ed61_i_aluno = $ed60_i_aluno
        ";
 $result3 = pg_query($sql3);
 //atualiza situacao da transferencia para fechada(F)
 $sql4 = "UPDATE transfescolarede SET
           ed103_c_situacao = 'F'
          WHERE ed103_i_codigo = $ed103_i_codigo
        ";
 $result4 = pg_query($sql4);
 $sql_del = "DELETE FROM docaluno
             WHERE ed49_i_aluno = $ed60_i_aluno
             AND ed49_i_escola = $escolaorig
            ";
 $result_del = pg_query($sql_del);
 $sql10 = "SELECT * FROM escola_sequencias
           WHERE ed129_i_escola = $escola
          ";
 $result10 = pg_query($sql10);
 $linhas10 = pg_num_rows($result10);
 if($linhas10>0){
  $result = @pg_query("select nextval('transflocal_ed131_i_codigo_seq')");
  $transflocal_cod = pg_result($result,0,0);
  $sql_tr = "INSERT INTO transflocal
             VALUES($transflocal_cod,
                    $escoladest,
                    $ed56_i_codigo,
                    $cursoorig,
                    $ed103_i_codigo,
                    'A')";
  $result_tr = pg_query($sql_tr);
 }
 //pg_query("rollback");
 db_fim_transacao();
 if($msg_conversao!=""){
  $mensagem = "ATENÇÃO!\\n\\n Caso o aluno tenha algum aproveitamento nos períodos abaixo relacionados, os mesmos deverão ser convertidos no Diário de Classe, devido a forma de avaliação da turma de origem ser diferente da turma de destino:\\n\\n$msg_conversao";
  db_msgbox($mensagem);
 }
 db_msgbox("Transferência realizada com sucesso!");
 ?><script>parent.location.href = "edu1_matriculatransf001.php";</script><?
}

if(isset($incluir2)){
 //pg_query("begin");
 db_inicio_transacao();
 $result = $clmatricula->sql_record($clmatricula->sql_query("","ed60_i_aluno,ed60_c_concluida",""," ed60_i_codigo = $matricula"));
 db_fieldsmemory($result,0);
 $result0 = $clmatricula->sql_record($clmatricula->sql_query_file("","ed60_i_codigo as codmatrjatem",""," ed60_i_turma = $turmadestino AND ed60_i_aluno = $ed60_i_aluno AND ed60_c_ativa ='S'"));
 if($clmatricula->numrows>0){
  db_fieldsmemory($result0,0);
 }else{
  $codmatrjatem = "";
 }
 $result = $clturma->sql_record($clturma->sql_query("","ed57_i_calendario,ed57_i_escola,ed57_i_serie",""," ed57_i_codigo = $turmadestino"));
 db_fieldsmemory($result,0);
 $result_orig = $clturma->sql_record($clturma->sql_query("","ed57_c_descr as ed57_c_descrorig,ed57_i_base as baseorig,ed57_i_calendario as calorig,ed57_i_serie as serieorig,ed57_i_turno as turnoorig,escola.ed18_c_nome as nomeescolaorig,ed31_i_curso as cursoorig,ed57_i_escola as escolaorig",""," ed57_i_codigo = $turmaorigem"));
 db_fieldsmemory($result_orig,0);
 if($ed60_c_concluida=="S"){
  $sql1 = "SELECT ed56_i_base as baseorig
           FROM alunocurso
           WHERE ed56_i_aluno = $ed60_i_aluno
          ";
  $result1 = pg_query($sql1);
  db_fieldsmemory($result1,0);
 }
 $result_alu = $clalunopossib->sql_record($clalunopossib->sql_query("","ed56_i_codigo,ed79_c_resulant",""," ed56_i_aluno = $ed60_i_aluno"));
 db_fieldsmemory($result_alu,0);
 $result_dest = $clturma->sql_record($clturma->sql_query_file("","ed57_c_descr as ed57_c_descrdest,ed57_i_base as basedest,ed57_i_calendario as caldest,ed57_i_serie as seriedest,ed57_i_turno as turnodest,ed57_i_escola as escoladest",""," ed57_i_codigo = $turmadestino"));
 db_fieldsmemory($result_dest,0);
 $result1 = $clmatricula->sql_record($clmatricula->sql_query_file("","max(ed60_i_numaluno)",""," ed60_i_turma = $turmadestino"));
 db_fieldsmemory($result1,0);
 $max = $max==""?"null":($max+1);
 if($codmatrjatem!=""){
  $data_modif = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  $sql = "UPDATE matricula SET
           ed60_i_turmaant = $turmaorigem,
           ed60_c_rfanterior = '$ed79_c_resulant',
           ed60_d_datamodif = '$data_modif',
           ed60_c_concluida = 'N',
           ed60_c_situacao = 'MATRICULADO'
          WHERE ed60_i_codigo = $codmatrjatem
         ";
  $query = pg_query($sql);
  $matrmov = $codmatrjatem;
 }else{
  $clmatricula->ed60_d_datamodif =  substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  $clmatricula->ed60_d_datamatricula = substr($data,6,4)."-".substr($data,3,2)."-".substr($data,0,2);
  $clmatricula->ed60_t_obs = "";
  $clmatricula->ed60_i_aluno = $ed60_i_aluno;
  $clmatricula->ed60_i_turma = $turmadestino;
  $clmatricula->ed60_i_turmaant = $turmaorigem;
  $clmatricula->ed60_c_rfanterior = $ed79_c_resulant;
  $clmatricula->ed60_i_numaluno = $max;
  $clmatricula->ed60_c_situacao = "MATRICULADO";
  $clmatricula->ed60_c_concluida = "N";
  $clmatricula->ed60_c_ativa = "S";
  $clmatricula->ed60_c_tipo = "N";
  $clmatricula->ed60_c_parecer = "N";
  $clmatricula->incluir(null);
  $result = @pg_query("select last_value from matricula_ed60_i_codigo_seq");
  $matrmov = pg_result($result,0,0);
 }
 $clmatriculamov->ed229_i_matricula = $matrmov;
 $clmatriculamov->ed229_i_usuario = db_getsession("DB_id_usuario");
 $clmatriculamov->ed229_c_procedimento = "MATRICULAR ALUNOS TRANSFERIDOS";
 $clmatriculamov->ed229_t_descr = "ALUNO MATRICULADO NA TURMA ".trim($ed57_c_descrdest)." VINDO DA ESCOLA ".trim($nomeescolaorig);
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
 $sql1 = "UPDATE alunocurso SET
           ed56_c_situacao = 'MATRICULADO',
           ed56_i_escola = $escoladest,
           ed56_i_base = $basedest,
           ed56_i_calendario = $caldest,
           ed56_i_baseant = null,
           ed56_i_calendarioant = null,
           ed56_c_situacaoant = ''
          WHERE ed56_i_codigo = $ed56_i_codigo
        ";
 $result1 = pg_query($sql1);
 //atualiza serie do curso
 $sql2 = "UPDATE alunopossib SET
           ed79_i_serie = $seriedest,
           ed79_i_turno = $turnodest,
           ed79_i_turmaant = $turmaorigem,
           ed79_c_resulant = '$ed79_c_resulant',
           ed79_c_situacao = 'A'
          WHERE ed79_i_alunocurso = $ed56_i_codigo
        ";
 $result2 = pg_query($sql2);
 //atualiza historico e transfere para escola destino
 $sql3 = "UPDATE historico SET
           ed61_i_escola = $escoladest
          WHERE ed61_i_curso = $cursoorig
          AND ed61_i_aluno = $ed60_i_aluno
        ";
 $result3 = pg_query($sql3);
 //atualiza situacao da transferencia para fechada(F)
 $sql4 = "UPDATE transfescolarede SET
           ed103_c_situacao = 'F'
          WHERE ed103_i_codigo = $ed103_i_codigo
        ";
 $result4 = pg_query($sql4);
 $sql_del = "DELETE FROM docaluno
             WHERE ed49_i_aluno = $ed60_i_aluno
             AND ed49_i_escola = $escolaorig
            ";
 $result_del = pg_query($sql_del);
 $sql10 = "SELECT * FROM escola_sequencias
           WHERE ed129_i_escola = $escola
          ";
 $result10 = pg_query($sql10);
 $linhas10 = pg_num_rows($result10);
 if($linhas10>0){
  $result = @pg_query("select nextval('transflocal_ed131_i_codigo_seq')");
  $transflocal_cod = pg_result($result,0,0);
  $sql_tr = "INSERT INTO transflocal
             VALUES($transflocal_cod,
                    $escoladest,
                    $ed56_i_codigo,
                    $cursoorig,
                    $ed103_i_codigo,
                    'A')";
  $result_tr = pg_query($sql_tr);
 }
 //pg_query("rollback");
 db_fim_transacao();
 db_msgbox("Transferência realizada com sucesso!");
 ?><script>parent.location.href = "edu1_matriculatransf001.php";</script><?
}
?>
<script>document.getElementById("tab_aguarde").style.visibility = "hidden";</script>