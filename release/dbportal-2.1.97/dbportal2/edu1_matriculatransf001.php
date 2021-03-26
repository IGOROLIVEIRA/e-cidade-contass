<?
require("libs/db_stdlib.php");
require("libs/db_stdlibwebseller.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_transfescolarede_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_alunocurso_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_diario_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_diarioresultado_classe.php");
include("classes/db_diariofinal_classe.php");
include("classes/db_amparo_classe.php");
include("classes/db_turma_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$cltransfescolarede = new cl_transfescolarede;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clalunocurso = new cl_alunocurso;
$clregencia = new cl_regencia;
$clturma = new cl_turma;
$cldiario = new cl_diario;
$cldiarioavaliacao = new cl_diarioavaliacao;
$cldiarioresultado = new cl_diarioresultado;
$cldiariofinal = new cl_diariofinal;
$clamparo = new cl_amparo;
$db_opcao = 1;
$db_botao = true;
$escola = db_getsession("DB_coddepto");
if(isset($chavepesquisa)){
 $campos = "transfescolarede.ed103_i_codigo,
            transfescolarede.ed103_i_matricula,
            aluno.ed47_i_codigo,
            aluno.ed47_v_nome,
            escola.ed18_i_codigo as codescolaorig,
            escola.ed18_c_nome as nomeescolaorig,
            escoladestino.ed18_i_codigo as codescoladest,
            escoladestino.ed18_c_nome as nomeescoladest,
            atestvaga.ed102_i_base as codbasedest,
            base.ed31_c_descr as nomebasedest,
            atestvaga.ed102_i_calendario as codcaldest,
            calendario.ed52_c_descr as nomecaldest,
            atestvaga.ed102_i_serie as codseriedest,
            serie.ed11_c_descr||' - '||ensino.ed10_c_abrev as nomeseriedest,
            atestvaga.ed102_i_turno as codturnodest,
            turno.ed15_c_nome as nometurnodest
           ";
 $result = $cltransfescolarede->sql_record($cltransfescolarede->sql_query("",$campos,""," ed103_i_codigo = $chavepesquisa"));
 db_fieldsmemory($result,0);
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
   <form name="form1" method="post" action="">
   <fieldset style="width:95%"><legend><b>Matricular Alunos Transferidos (REDE)</b></legend>
    <table border="0" width="100%">
     <tr>
      <td colspan="2">
       <?db_input('ed103_i_codigo',15,@$Ied103_i_codigo,true,'hidden',3,"")?>
       <?db_ancora("<b>Aluno:</b>","js_pesquisatransf();",$db_opcao);?>
       <?db_input('ed47_i_codigo',15,@$Ied47_i_codigo,true,'text',3,'')?>
       <?db_input('ed47_v_nome',50,@$Ied47_v_nome,true,'text',3,'')?>
      </td>
     </tr>
     <?if(isset($chavepesquisa)){
     $campos = "matricula.ed60_c_concluida,
                serie.ed11_i_codigo as codserieorig,
                serie.ed11_c_descr||' - '||ensino.ed10_c_abrev as nomeserieorig,
                base.ed31_i_codigo as codbaseorig,
                calendario.ed52_i_codigo as codcalorig,
                cursoedu.ed29_i_codigo as codcursoorig,
                turma.ed57_i_codigo as codturmaorig,
                turma.ed57_c_descr as nometurmaorig,
                matricula.ed60_i_aluno
               ";
     $result = $clmatricula->sql_record($clmatricula->sql_query("",$campos,""," ed60_i_codigo = $ed103_i_matricula"));
     db_fieldsmemory($result,0);
     $concluida = $ed60_c_concluida=="S"?"CONCLUÍDA":"NÂO CONCLUÍDA";
     if($ed60_c_concluida=="S"){
      $sql1 = "SELECT ed56_i_base as codbaseorig
               FROM alunocurso
               WHERE ed56_i_aluno = $ed47_i_codigo
              ";
      $result1 = pg_query($sql1);
      db_fieldsmemory($result1,0);
     }
     $result1 = $clalunocurso->sql_record($clalunocurso->sql_query_file("","ed56_i_codigo, ed56_c_situacao",""," ed56_i_aluno = $ed47_i_codigo"));
     db_fieldsmemory($result1,0);
     ?>
     <tr>
      <td>
       <fieldset style="width:95%;"><legend><b>Dados de Origem</b></legend>
        <table>
         <tr>
          <td>
           <b>Matrícula:</b>
          </td>
          <td>
           <?db_input('ed103_i_matricula',15,@$ed103_i_matricula,true,'text',3,'')?>
           <?db_input('concluida',23,@$concluida,true,'text',3,'')?>
           <?db_input('ed60_c_concluida',10,@$ed60_c_concluida,true,'hidden',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Escola:</b>
          </td>
          <td>
           <?db_input('codescolaorig',15,@$codescolaorig,true,'hidden',3,'')?>
           <?db_input('nomeescolaorig',40,@$nomeescolaorig,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Situação:</b>
          </td>
          <td>
           <?db_input('ed56_c_situacao',40,@$ed56_c_situacao,true,'text',3,'')?>
           <?db_input('codcursoorig',50,@$codcursoorig,true,'hidden',3,'')?>
           <?db_input('ed56_i_codigo',50,@$ed56_i_codigo,true,'hidden',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Série:</b>
          </td>
          <td>
           <?db_input('codserieorig',15,@$codserieorig,true,'hidden',3,'')?>
           <?db_input('nomeserieorig',40,@$nomeserieorig,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Turma:</b>
          </td>
          <td>
           <?db_input('codturmaorig',15,@$codturmaorig,true,'hidden',3,'')?>
           <?db_input('nometurmaorig',40,@$nometurmaorig,true,'text',3,'')?>
          </td>
         </tr>
        </table>
       </fieldset>
      </td>
      <td>
       <fieldset style="width:95%;"><legend><b>Dados de Destino</b></legend>
        <table>
         <tr>
          <td>
           <b>Escola:</b>
          </td>
          <td>
           <?db_input('codescoladest',15,@$codescoladest,true,'hidden',3,'')?>
           <?db_input('nomeescoladest',40,@$nomeescoladest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Série:</b>
          </td>
          <td>
           <?db_input('codseriedest',15,@$codseriedest,true,'hidden',3,'')?>
           <?db_input('nomeseriedest',40,@$nomeseriedest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Base:</b>
          </td>
          <td>
           <?db_input('codbasedest',15,@$codbasedest,true,'hidden',3,'')?>
           <?db_input('nomebasedest',40,@$nomebasedest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Calendário:</b>
          </td>
          <td>
           <?db_input('codcaldest',15,@$codcaldest,true,'hidden',3,'')?>
           <?db_input('nomecaldest',40,@$nomecaldest,true,'text',3,'')?>
          </td>
         </tr>
         <tr>
          <td>
           <b>Turno:</b>
          </td>
          <td>
           <?db_input('codturnodest',15,@$codturnodest,true,'hidden',3,'')?>
           <?db_input('nometurnodest',40,@$nometurnodest,true,'text',3,'')?>
          </td>
         </tr>
        </table>
       </fieldset>
      </td>
     </tr>
     <?
     $camposant="turma.ed57_i_codigo as codturmadest,
                 turma.ed57_c_descr as nometurmadest,
                 case
                  when ed60_c_situacao = 'TRANSFERIDO REDE' then
                   (select to_char(ed103_d_data,'DD/MM/YYYY') from transfescolarede where ed103_i_matricula = ed60_i_codigo order by ed103_d_data desc limit 1)
                  when ed60_c_situacao = 'TRANSFERIDO FORA' then
                   (select to_char(ed104_d_data,'DD/MM/YYYY') from transfescolafora where ed104_i_aluno = ed60_i_aluno and ed104_i_escolaorigem = turma.ed57_i_escola and extract(year from ed104_d_data) = calendario.ed52_i_ano order by ed104_d_data desc limit 1)
                  when ed60_c_situacao = 'AVANÇADO' OR ed60_c_situacao = 'CLASSIFICADO' then
                   (select to_char(ed101_d_data,'DD/MM/YYYY') from trocaserie where ed101_i_aluno = ed60_i_aluno and ed101_i_turmaorig = ed60_i_turma order by ed101_d_data desc limit 1)
                  when ed60_c_situacao = 'CANCELADO' then
                   case when (select to_char(ed229_d_data,'DD/MM/YYYY') from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA CANCELADO%' order by ed229_d_data desc limit 1) is null
                    then to_char(ed60_d_datamodif,'DD/MM/YYYY') else
                    (select to_char(ed229_d_data,'DD/MM/YYYY') from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA CANCELADO%' order by ed229_d_data desc limit 1)
                   end
                  when ed60_c_situacao = 'EVADIDO' then
                   case when (select to_char(ed229_d_data,'DD/MM/YYYY') from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA EVADIDO%' order by ed229_d_data desc limit 1) is null
                   then to_char(ed60_d_datamodif,'DD/MM/YYYY') else
                   (select to_char(ed229_d_data,'DD/MM/YYYY') from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA EVADIDO%' order by ed229_d_data desc limit 1)
                   end
                  when ed60_c_situacao = 'FALECIDO' then
                   case when (select to_char(ed229_d_data,'DD/MM/YYYY') from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA FALECIDO%' order by ed229_d_data desc limit 1) is null
                   then to_char(ed60_d_datamodif,'DD/MM/YYYY') else
                   (select to_char(ed229_d_data,'DD/MM/YYYY') from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA FALECIDO%' order by ed229_d_data desc limit 1)
                   end
                  else null end as datasaida,
                  ed60_i_codigo as matriculaante
                  ";
     $result_verif = $clmatricula->sql_record($clmatricula->sql_query("",$camposant,""," ed60_i_aluno = $ed60_i_aluno AND calendario.ed52_i_codigo= $codcaldest AND ed60_c_situacao = 'TRANSFERIDO REDE' AND turma.ed57_i_escola = ".db_getsession("DB_coddepto")." AND ed60_c_ativa ='S'"));
     $linhas_verif = $clmatricula->numrows;
     if($clmatricula->numrows>0){
      db_fieldsmemory($result_verif,0);
      $datahj = date("Y-m-d");
      $datasaida_dia = substr($datasaida,0,2);
      $datasaida_mes = substr($datasaida,3,2);
      $datasaida_ano = substr($datasaida,6,4);
      $data_in = mktime(0,0,0,$datasaida_mes,$datasaida_dia,$datasaida_ano);
      $data_out = mktime(0,0,0,substr($datahj,5,2),substr($datahj,8,2),substr($datahj,0,4));
      $data_entre = $data_out - $data_in;
      $dias = ceil($data_entre/86400);
      ?>
      <tr>
       <td colspan="2">
        <font color="red"><b>Aluno (<?=$ed60_i_aluno?>) já possui matrícula nesta escola na turma abaixo relacionada, com situação de TRANSFERIDO REDE a <?=@$dias?> dia<?=@$dias>1?"(s)":""?>.</b></font>
       </td>
      </tr>
      <?
     }
     ?>
     <tr>
      <td colspan="2">
       <?db_ancora("<b>Turma Destino:</b>","js_pesquisaturmadest(true);",isset($datasaida)?3:1)?>
       <?db_input('codturmadest',15,@$Icodturmadest,true,'text',3,'')?>
       <?db_input('nometurmadest',50,@$Inometurmadest,true,'text',3,'')?>
       <?if($clmatricula->numrows>0){?>
        <b>Matrícula:</b>
        <?db_input('matriculaante',10,@$Imatriculaante,true,'text',3,'')?>
        <b>Data Sáida:</b>
        <?db_inputdata('datasaida',@$datasaida_dia,@$datasaida_mes,@$datasaida_ano,true,'text',3,"")?>
       <?}?>
      </td>
     </tr>
     <tr>
      <td colspan="2">
       <iframe id="iframe_trocaturma" name="iframe_trocaturma" src="" width="100%" height="800" frameborder="0"></iframe>
      </td>
     </tr>
    <?}?>
    </table>
   </fieldset>
   </form>
  </td>
 </tr>
</table>
<?if($clmatricula->numrows>0){?>
 <script>
  iframe_trocaturma.location.href = 'edu1_matriculatransf002.php?ed103_i_codigo=<?=$ed103_i_codigo?>&matricula=<?=$ed103_i_matricula?>&turmaorigem=<?=$codturmaorig?>&turmadestino=<?=$codturmadest?>&matriculaante=<?=$matriculaante?>';
  document.getElementById("iframe_trocaturma").style.visibility = "visible";
 </script>
<?}?>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
 js_tabulacaoforms("form1","ed103_i_codigo",true,1,"ed103_i_codigo",true);
 function js_pesquisaturmadest(mostra){
  document.getElementById("iframe_trocaturma").style.visibility = "hidden";
  if(mostra==true){
   js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_turma','func_turmatransfrede.php?aluno='+document.form1.ed47_v_nome.value+'&serie='+document.form1.codseriedest.value+'&calendario='+document.form1.codcaldest.value+'&funcao_js=parent.js_mostraturma1|ed57_i_codigo|ed57_c_descr','Pesquisa de Turma de Destino',true);
  }
 }
 function js_mostraturma1(chave1,chave2){
  document.form1.codturmadest.value = chave1;
  document.form1.nometurmadest.value = chave2;
  db_iframe_turma.hide();
  iframe_trocaturma.location.href = 'edu1_matriculatransf002.php?ed103_i_codigo='+document.form1.ed103_i_codigo.value+'&matricula='+document.form1.ed103_i_matricula.value+'&turmaorigem='+document.form1.codturmaorig.value+'&turmadestino='+document.form1.codturmadest.value;
  document.getElementById("iframe_trocaturma").style.visibility = "visible";
 }
 function js_pesquisatransf(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_transfescolarede','func_transfescolarede.php?funcao_js=parent.js_preenchepesquisa|ed103_i_codigo','Pesquisa',true);
 }
 function js_preenchepesquisa(chave){
  db_iframe_transfescolarede.hide();
  <?
   echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  ?>
 }
</script>
