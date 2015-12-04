<?
include("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_aluno_classe.php");
include("classes/db_alunoprimat_classe.php");
include("classes/db_alunonecessidade_classe.php");
include("classes/db_matricula_classe.php");
include("classes/db_matriculamov_classe.php");
include("classes/db_turma_classe.php");
include("classes/db_procavaliacao_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_regenciaperiodo_classe.php");
include("classes/db_historicomps_classe.php");
include("classes/db_historicompsfora_classe.php");
include("classes/db_histmpsdisc_classe.php");
include("classes/db_histmpsdiscfora_classe.php");
include("classes/db_logmatricula_classe.php");
include("classes/db_procresultado_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$permitenotaembranco = VerParametroNota(db_getsession("DB_coddepto"));
$claluno = new cl_aluno;
$clalunoprimat = new cl_alunoprimat;
$clalunonecessidade = new cl_alunonecessidade;
$clmatricula = new cl_matricula;
$clmatriculamov = new cl_matriculamov;
$clturma = new cl_turma;
$clprocavaliacao = new cl_procavaliacao;
$clregencia = new cl_regencia;
$cldiarioavaliacao = new cl_diarioavaliacao;
$clregenciaperiodo = new cl_regenciaperiodo;
$clhistoricomps = new cl_historicomps;
$clhistoricompsfora = new cl_historicompsfora;
$clhistmpsdisc = new cl_histmpsdisc;
$clhistmpsdiscfora = new cl_histmpsdiscfora;
$cllogmatricula = new cl_logmatricula;
$clprocresultado = new cl_procresultado;
$clrotulo = new rotulocampo;
$clrotulo->label("ed31_i_curso");
$claluno->rotulo->label();
$clmatricula->rotulo->label();
$clturma->rotulo->label();
$clalunoprimat->rotulo->label();
$cllogmatricula->rotulo->label();
$db_opcao = 1;
$db_botao = true;
if(isset($chavepesquisa)){
 $result = $claluno->sql_record($claluno->sql_query("","*",""," ed47_i_codigo = $chavepesquisa"));
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
<style>
.titulo{
 font-size: 11px;
 color: #DEB887;
 background-color:#444444;
 font-weight: bold;
 border: 1px solid #f3f3f3;
}
.cabec1{
 font-size: 11px;
 color: #000000;
 background-color:#999999;
 font-weight: bold;
}
.aluno{
 color: #000000;
 font-family : Tahoma;
 font-size: 10px;
 font-weight: bold;
}
.aluno1{
 color: #000000;
 font-family : Tahoma;
 font-weight: bold;
 text-align: center;
 font-size: 10px;
}
.aluno2{
 color: #000000;
 font-family : Verdana;
 font-size: 10px;
 font-weight: bold;
}
</style>
</style>
</head>
<body bgcolor="#f3f3f3" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table bgcolor="#f3f3f3" width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" bgcolor="#CCCCCC">
   <table border="0" bgcolor="#f3f3f3" width="100%" cellspacing="0" cellpading="0" height="800" >
    <?if($evento==1){?>
    <tr>
     <td valign="top" >
      <fieldset style="background:#f3f3f3;border:2px solid #000000"><legend class="cabec"><b>Documentos</b></legend>
      <table border="1" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="4">
       <tr>
        <td>
         <?=@$Led47_v_ident?> <?=@$ed47_v_ident==""?"Não Informado":$ed47_v_ident?>
         &nbsp;&nbsp;
         <?=@$Led47_v_cpf?> <?=@$ed47_v_cpf==""?"Não Informado":$ed47_v_cpf?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_c_certidaotipo?> <?=@$ed47_c_certidaotipo=="C"?"CASAMENTO":"NASCIMENTO"?>
         &nbsp;&nbsp;
         <?=@$Led47_c_certidaonum?> <?=@$ed47_c_certidaonum==""?"Não Informado":$ed47_c_certidaonum?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_c_certidaolivro?> <?=@$ed47_c_certidaolivro==""?"Não Informado":$ed47_c_certidaolivro?>
         &nbsp;&nbsp;
         <?=@$Led47_c_certidaofolha?> <?=@$ed47_c_certidaofolha==""?"Não Informado":$ed47_c_certidaofolha?>
         &nbsp;&nbsp;
         <?=@$Led47_c_certidaodata?> <?=@$ed47_c_certidaodata==""?"Não Informado":db_formatar($ed47_c_certidaodata,'d')?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_c_certidaocart?> <?=@$ed47_c_certidaocart==""?"Não Informado":$ed47_c_certidaocart?>
        </td>
       </tr>
      </table>
      </fieldset>
     </td>
    </tr>
    <?}
    if($evento==2){?>
    <tr>
     <td valign="top" >
      <fieldset style="background:#f3f3f3;border:2px solid #000000"><legend class="cabec"><b>Outras Informações</b></legend>
      <table border="1" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="4">
       <tr>
        <td>
         <?=@$Led47_v_pai?> <?=@$ed47_v_pai==""?"Não Informado":$ed47_v_pai?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_v_mae?> <?=@$ed47_v_mae==""?"Não Informado":$ed47_v_mae?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_c_bolsafamilia?> <?=@$ed47_c_bolsafamlia=="S"?"SIM":"NÃO"?>
         &nbsp;&nbsp;
         <?=@$Led47_c_nis?> <?=@$ed47_c_nis==""?"Não Informado":$ed47_c_nis?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_c_transporte?> <?=@$ed47_c_transporte==""?"NÃO":$ed47_c_transporte?>
         &nbsp;&nbsp;
         <?=@$Led47_c_zona?> <?=@$ed47_c_zona==""?"Não Informado":$ed47_c_zona?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_v_email?> <?=@$ed47_v_email==""?"Não Informado":$ed47_v_email?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_v_profis?> <?=@$ed47_v_profis==""?"Não Informado":$ed47_v_profis?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_c_nomeresp?> <?=@$ed47_c_nomeresp==""?"Não Informado":$ed47_c_nomeresp?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_c_emailresp?> <?=@$ed47_c_emailresp==""?"Não Informado":$ed47_c_emailresp?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_d_cadast?> <?=@db_formatar($ed47_d_cadast,'d')?>
         &nbsp;&nbsp;
         <?=@$Led47_d_ultalt?> <?=@db_formatar($ed47_d_ultalt,'d')?>
        </td>
       </tr>
       <tr>
        <td>
         <?=@$Led47_t_obs?> <?=@$ed47_t_obs==""?"Nenhuma":$ed47_t_obs?>
        </td>
       </tr>
      </table>
      </fieldset>
     </td>
    </tr>
    <?}
    if($evento==3){
    $result1 = $clmatricula->sql_record($clmatricula->sql_query("","*",""," ed60_i_codigo = $ed60_i_codigo"));
    ?>
    <tr>
     <td valign="top" >
      <fieldset style="background:#f3f3f3;border:2px solid #000000"><legend class="cabec"><b>Matrículas</b></legend>
      <table border="1" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="4">
       <?
       if($clmatricula->numrows>0){
        db_fieldsmemory($result1,0);
        $campos1 = "ed76_i_codigo,
                    ed76_i_escola,
                    ed76_d_data,
                    ed76_c_tipo,
                    case when ed76_c_tipo = 'M'
                     then ed18_c_nome else ed82_c_nome end as nomeescola
                   ";
        $result11 = $clalunoprimat->sql_record($clalunoprimat->sql_query("",$campos1,""," ed76_i_aluno = $ed60_i_aluno"));
        db_fieldsmemory($result11,0);
        ?>
        <tr>
         <td>
          <?=@$Led60_i_codigo?> <?=@$ed60_i_codigo?>
          &nbsp;&nbsp;
          <?=@$Led57_i_escola?> <?=@$ed18_c_nome?>
         </td>
        </tr>
        <tr>
         <td>
          <?=@$Led60_d_datamatricula?> <?=@db_formatar($ed60_d_datamatricula,'d')?>
          &nbsp;&nbsp;
          <b>Situaçao:</b> <?=@$ed60_c_concluida=="S"?"$ed60_c_situacao (CONCLUIDA)":Situacao($ed60_c_situacao,$ed60_i_codigo)?>
         </td>
        </tr>
        <?if(trim(Situacao($ed60_c_situacao,$ed60_i_codigo))!="MATRICULADO"){
         $camp = "case
                  when ed60_c_situacao = 'TRANSFERIDO REDE' then
                   (select ed103_d_data from transfescolarede where ed103_i_matricula = ed60_i_codigo order by ed103_d_data desc limit 1)
                  when ed60_c_situacao = 'TRANSFERIDO FORA' then
                   (select ed104_d_data from transfescolafora where ed104_i_aluno = ed60_i_aluno and ed104_i_escolaorigem = turma.ed57_i_escola and extract(year from ed104_d_data) = calendario.ed52_i_ano order by ed104_d_data desc limit 1)
                  when ed60_c_situacao = 'AVANÇADO' OR ed60_c_situacao = 'CLASSIFICADO' then
                   (select ed101_d_data from trocaserie where ed101_i_aluno = ed60_i_aluno and ed101_i_turmaorig = ed60_i_turma order by ed101_d_data desc limit 1)
                  when ed60_c_situacao = 'CANCELADO' then
                   case when (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA CANCELADO%' order by ed229_d_data desc limit 1) is null
                    then ed60_d_datamodif else
                    (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA CANCELADO%' order by ed229_d_data desc limit 1)
                   end
                  when ed60_c_situacao = 'EVADIDO' then
                   case when (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA EVADIDO%' order by ed229_d_data desc limit 1) is null
                   then ed60_d_datamodif else
                   (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA EVADIDO%' order by ed229_d_data desc limit 1)
                   end
                  when ed60_c_situacao = 'FALECIDO' then
                   case when (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA FALECIDO%' order by ed229_d_data desc limit 1) is null
                   then ed60_d_datamodif else
                   (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo and ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' AND ed229_t_descr like '%PARA FALECIDO%' order by ed229_d_data desc limit 1)
                   end
                  else null
                 end as datasaida,
                case
                  when ed60_c_situacao = 'TRANSFERIDO REDE' then
                   (select escoladestino.ed18_c_nome from transfescolarede
                     inner join atestvaga  on  atestvaga.ed102_i_codigo = transfescolarede.ed103_i_atestvaga
                     inner join escola  as escoladestino on  escoladestino.ed18_i_codigo = atestvaga.ed102_i_escola
                    where ed103_i_matricula = ed60_i_codigo order by ed103_d_data desc limit 1)
                  when ed60_c_situacao = 'TRANSFERIDO FORA' then
                   (select escolaproc.ed82_c_nome from transfescolafora
                     inner join escolaproc  on  escolaproc.ed82_i_codigo = transfescolafora.ed104_i_escoladestino
                    where ed104_i_aluno = ed60_i_aluno and ed104_i_escolaorigem = turma.ed57_i_escola and extract(year from ed104_d_data) = calendario.ed52_i_ano order by ed104_d_data desc limit 1)
                  else null
                 end as destinosaida
                ";
         $result1 = $clmatricula->sql_record($clmatricula->sql_query("",$camp,""," ed60_i_codigo = $ed60_i_codigo"));
         db_fieldsmemory($result1,0);
         ?>
         <tr>
          <td>
           <b>Data Sáida:</b> <?=@db_formatar($datasaida,'d')?>
           <b>Destino Sáida:</b> <?=@$destinosaida?>
          </td>
         </tr>
        <?}?>
        <tr>
         <td>
          <?=@$Led57_c_descr?> <?=@$ed57_c_descr?>
          &nbsp;&nbsp;
          <?=@$Led57_i_serie?> <?=@$ed11_c_descr?>
          &nbsp;&nbsp;
          <?=@$Led57_i_turno?> <?=@$ed15_c_nome?>
          &nbsp;&nbsp;
          <?=@$Led57_i_calendario?> <?=@$ed52_c_descr?>
         </td>
        </tr>
        <tr>
         <td>
          <?=@$Led76_i_escola?> <?=@$ed76_i_escola==""?"Não Informado":($ed76_i_escola."-".$nomeescola)?>
          &nbsp;&nbsp;
          <?=@$Led76_d_data?> <?=@$ed76_d_data==""?"Não Informado":db_formatar($ed76_d_data,'d')?>
         </td>
        </tr>
        <tr>
         <td>
          <table width="100%" border="1" cellspacing="0" cellpadding="2">
          <?if($ed60_c_ativa=="S"){?>
           <tr align="center">
            <td class="cabec1">&nbsp;</td>
            <?
             $result_gr = $clprocresultado->sql_record($clprocresultado->sql_query_file("","ed43_i_codigo as codprocgeraresultado,ed43_c_obtencao as obtencao,ed43_c_minimoaprov as minimoaprovres,ed43_c_arredmedia as arredmedia",""," ed43_i_procedimento = $ed57_i_procedimento AND ed43_c_geraresultado = 'S'"));
             if($clprocresultado->numrows>0){
              db_fieldsmemory($result_gr,0);
             }else{
              $codprocgeraresultado = 0;
              $obtencao = "";
              $minimoaprovres = 0;
             }
             $sql_d = $clprocavaliacao->sql_query("","ed37_c_tipo,ed41_i_codigo,ed09_i_codigo,ed09_c_abrev","ed41_i_sequencia"," ed41_i_procedimento = $ed57_i_procedimento");
             $result_d = $clprocavaliacao->sql_record($sql_d);
             for($y=0;$y<$clprocavaliacao->numrows;$y++){
              db_fieldsmemory($result_d,$y);
              ?>
              <td class="cabec1" colspan="2"><?=$ed09_c_abrev?></td>
              <?
             }
             if($permitenotaembranco=="S" && $ed60_c_situacao=="MATRICULADO" && $ed60_c_concluida=="N"){
              ?>
              <td class="cabec1">NP</td>
              <?
             }
             ?>
             <td class="cabec1" colspan="4">Resultado final</td>
            </tr>
            <tr align="center">
             <td class="cabec1" align="left">&nbsp;Disciplina</td>
             <?
             for($y=0;$y<$clprocavaliacao->numrows;$y++){
              ?>
              <td class="cabec1" ><?=substr($ed37_c_tipo,0,5)?></td>
              <td class="cabec1" >Ft</td>
              <?
             }
             if($permitenotaembranco=="S" && $ed60_c_situacao=="MATRICULADO" && $ed60_c_concluida=="N"){
              ?>
              <td class="cabec1">&nbsp;</td>
              <?
             }
             ?>
             <td class="cabec1"><?=$ed57_c_medfreq=="PERÌODOS"?"Aulas":"Dias"?></td>
             <td class="cabec1" >Aprov.</td>
             <td class="cabec1" >% Freq</td>
             <td class="cabec1" >RF</td>
            </tr>
            <?
            $sql = $clregencia->sql_query("","*","ed59_c_condicao,ed232_c_descr"," ed59_i_turma = $ed60_i_turma");
            $result = $clregencia->sql_record($sql);
            //db_criatabela($result);
            //exit;
            $cor1 = "#f3f3f3";
            $cor2 = "#DBDBDB";
            $cor = "";
            for($x=0;$x<$clregencia->numrows;$x++){
             db_fieldsmemory($result,$x);
             if($cor==$cor1){
              $cor = $cor2;
             }else{
              $cor = $cor1;
             }
             $sql2 = "SELECT ed95_i_codigo,
                             ed60_i_aluno,
                             ed60_c_parecer,
                             ed47_v_nome,
                             ed60_i_numaluno,
                             ed74_c_valoraprov,
                             ed74_i_codigo,
                             ed74_c_resultadofinal,
                             ed74_i_percfreq,
                             ed60_c_situacao,
                             ed81_c_todoperiodo,
                             ed81_i_justificativa,
                             ed81_i_convencaoamp,
                             ed250_c_abrev,
                             ed74_i_procresultadoaprov
                      FROM matricula
                       inner join aluno on ed47_i_codigo = ed60_i_aluno
                       inner join diario on ed95_i_aluno = ed47_i_codigo
                       inner join diariofinal on ed74_i_diario = ed95_i_codigo
                       left join amparo on ed81_i_diario = ed95_i_codigo
                       left join convencaoamp on ed250_i_codigo = ed81_i_convencaoamp
                      WHERE ed60_i_codigo = $ed60_i_codigo
                      AND ed95_i_regencia = $ed59_i_codigo
                      AND ed95_i_aluno = $ed60_i_aluno
                      ORDER BY ed47_v_nome
                     ";
             $result2 = pg_query($sql2);
             $linhas2 = pg_num_rows($result2);
             if($linhas2==0){
              ?>
              <tr bgcolor="<?=$cor?>">
               <td class="aluno">&nbsp;<?=$ed232_c_descr?></td>
               <td align="center" colspan="<?=($clprocavaliacao->numrows*2)+4?>">
                Nenhum registro para esta disciplina.
               </td>
              </tr>
              <?
             }else{
              for($y=0;$y<$linhas2;$y++){
               db_fieldsmemory($result2,$y);
               $descritivo = $ed74_c_valoraprov;
               ?>
               <tr bgcolor="<?=$cor?>">
                <td class="aluno">&nbsp;<?=$ed232_c_descr?></td>
                <?
                $result_p = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","*","ed41_i_sequencia"," ed41_i_procedimento = $ed57_i_procedimento AND ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $ed59_i_codigo"));
                $linhas_p = $cldiarioavaliacao->numrows;
                for($t=0;$t<$linhas_p;$t++){
                 db_fieldsmemory($result_p,$t);
                 if($ed60_c_parecer=="S"){
                  $ed37_c_tipo = "PARECER";
                 }
                 if(trim($ed37_c_tipo)=="PARECER" && $ed72_t_parecer!=""){
                  $aprov = "Parecer";
                 }elseif(trim($ed37_c_tipo)=="PARECER" && $ed72_t_parecer==""){
                  $aprov = "";
                 }elseif(trim($ed37_c_tipo)=="NOTA" && $ed72_i_valornota!=""){
                  if($resultedu=="S"){
                   $aprov = number_format(round($ed72_i_valornota),2,".",".");
                  }else{
                   $aprov = number_format(round($ed72_i_valornota),0);
                  }
                 }elseif(trim($ed37_c_tipo)=="NIVEL" && $ed72_c_valorconceito!=""){
                  $aprov = $ed72_c_valorconceito;
                 }else{
                  $aprov = "";
                 }
                 if(trim($ed72_c_amparo)=="S"){
                  if($ed81_i_justificativa!=""){
                   $aprov = "Amparado";
                  }else{
                   $aprov = $ed250_c_abrev;
                  }
                  $ed72_i_numfaltas = "";
                 }
                 if(trim($ed59_c_freqglob)=="A"){
                  $ed72_i_numfaltas = "-";
                 }elseif(trim($ed59_c_freqglob)=="F"){
                  $aprov = "-";
                 }
                 if($ed72_i_escola!=$ed57_i_escola||$ed72_c_tipo=="F"){
                  $NE = "*";
                 }else{
                  $NE = "";
                 }
                 if(trim($ed37_c_tipo)=="PARECER"){
                  ?>
                  <td style="Cursor='hand';" onmouseover="js_mostra('parecer<?=$ed72_i_codigo?>'); bgColor='#DEB887';" onmouseout="js_oculta('parecer<?=$ed72_i_codigo?>'); bgColor='<?=$cor?>';" class="aluno1">
                   <?=$aprov==""?"&nbsp;":$aprov?>
                    <table id="parecer<?=$ed72_i_codigo?>" width="150" border="1" cellspacing="2" cellpadding="3" style="position:absolute;visibility:hidden;">
                     <tr>
                      <td bgcolor="<?=$cor?>" class="aluno" align="justify">
                        <center>PARECER DESCRITIVO:</center><hr>
                        <?=$ed72_t_parecer?>
                      </td>
                     </tr>
                    </table>
                  </td>
                  <td class="aluno1"><?=$ed72_i_numfaltas==""?"&nbsp;":$ed72_i_numfaltas?></td>
                  <?
                 }else{
                  if($aprov==""){
                   $aprov = "&nbsp;";
                  }
                  ?>
                  <td class="aluno1"><?=$aprov==""?"":$NE.$aprov?></td>
                  <td class="aluno1"><?=$ed72_i_numfaltas==""?"&nbsp;":$ed72_i_numfaltas?></td>
                  <?
                 }
                 $aprov = "";
                 $ed72_i_numfaltas = "";
                 $tipo = $ed37_c_tipo;
                }
                if(trim($ed37_c_tipo)=="NOTA"){
                 $campoaval = "ed72_i_valornota is null";
                }elseif(trim($ed37_c_tipo)=="NIVEL"){
                 $campoaval = "ed72_c_valorconceito = ''";
                }elseif(trim($ed37_c_tipo)=="PARECER"){
                 $campoaval = "ed72_t_parecer = '' ";
                }
                $result33 = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed72_i_codigo","ed41_i_sequencia"," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $ed59_i_codigo AND $campoaval AND ed72_c_amparo = 'N' AND ed09_c_somach = 'S'  AND ed37_c_tipo = '$ed37_c_tipo'"));
                $linhas33 = $cldiarioavaliacao->numrows;
                if($permitenotaembranco=="S" && $linhas33>0 && $ed60_c_situacao=="MATRICULADO" && $ed60_c_concluida=="N"){
                 if(trim($ed37_c_tipo)=="NOTA"){
                  if(trim($obtencao)=="ME"){
                   $result_media = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","sum(ed72_i_valornota)/count(ed72_i_valornota) as aprvto",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $ed59_i_codigo AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null AND ed09_c_somach = 'S'"));
                   db_fieldsmemory($result_media,0);
                   if($arredmedia=="S"){
                    if($resultedu=="S"){
                     $resfinal = number_format(round($aprvto),2,".",".");
                    }else{
                     $resfinal = number_format(round($aprvto),0);
                    }
                   }else{
                    if($resultedu=="S"){
                     $resfinal = number_format($aprvto,2,".",".");
                    }else{
                     $resfinal = number_format($aprvto,0);
                    }
                   }
                  }elseif(trim($obtencao)=="MP"){
                   $sql_r = "SELECT sum(ed72_i_valornota*ed44_i_peso)/sum(ed44_i_peso) as aprvto
                             FROM diario
                              left join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                              left join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                              left join periodoavaliacao on ed09_i_codigo = ed41_i_periodoavaliacao
                              left join avalcompoeres on ed44_i_procavaliacao = ed41_i_codigo
                             WHERE ed95_i_aluno = $ed60_i_aluno
                             AND ed95_i_regencia = $ed59_i_codigo
                             AND ed72_c_amparo = 'N'
                             AND ed72_i_valornota is not null
                             AND ed09_c_somach = 'S'
                            ";
                   $result_media = pg_query($sql_r);
                   db_fieldsmemory($result_media,0);
                   if($arredmedia=="S"){
                    if($resultedu=="S"){
                     $resfinal = number_format(round($aprvto),2,".",".");
                    }else{
                     $resfinal = number_format(round($aprvto),0);
                    }
                   }else{
                    if($resultedu=="S"){
                     $resfinal = number_format($aprvto,2,".",".");
                    }else{
                     $resfinal = number_format($aprvto,0);
                    }
                   }
                  }elseif(trim($obtencao)=="SO"){
                   $result_soma = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","sum(ed72_i_valornota) as aprvto,sum(to_number(ed37_c_minimoaprov,999)) as somaminimo",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $ed59_i_codigo AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null AND ed09_c_somach = 'S'"));
                   db_fieldsmemory($result_soma,0);
                   if($arredmedia=="S"){
                    if($resultedu=="S"){
                     $resfinal = number_format(round($aprvto),2,".",".");
                    }else{
                     $resfinal = number_format(round($aprvto),0);
                    }
                   }else{
                    if($resultedu=="S"){
                     $resfinal = number_format($aprvto,2,".",".");
                    }else{
                     $resfinal = number_format($aprvto,0);
                    }
                   }
                  }elseif(trim($obtencao)=="MN"){
                   $result_maior = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","max(ed72_i_valornota) as aprvto",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $ed59_i_codigo AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null"));
                   db_fieldsmemory($result_maior,0);
                   if($arredmedia=="S"){
                    if($resultedu=="S"){
                     $resfinal = number_format(round($aprvto),2,".",".");
                    }else{
                     $resfinal = number_format(round($aprvto),0);
                    }
                   }else{
                    if($resultedu=="S"){
                     $resfinal = number_format($aprvto,2,".",".");
                    }else{
                     $resfinal = number_format($aprvto,0);
                    }
                   }
                  }elseif(trim($obtencao)=="UN"){
                   $result_ultima = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed72_c_amparo as ultamparo,ed72_i_valornota as aprvto","ed41_i_sequencia DESC LIMIT 1"," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $ed59_i_codigo"));
                   db_fieldsmemory($result_ultima,0);
                   if($arredmedia=="S"){
                    if($resultedu=="S"){
                     $resfinal = number_format(round($aprvto),2,".",".");
                    }else{
                     $resfinal = number_format(round($aprvto),0);
                    }
                   }else{
                    if($resultedu=="S"){
                     $resfinal = number_format($aprvto,2,".",".");
                    }else{
                     $resfinal = number_format($aprvto,0);
                    }
                   }
                  }
                  $resfinal = trim($ed60_c_situacao)!="MATRICULADO"||@$aprvto==""?"":$resfinal;
                  ?>
                   <td class="aluno1"><?=$resfinal?></td>
                  <?
                 }
                }elseif($permitenotaembranco=="S" && $linhas33==0 && $ed60_c_situacao=="MATRICULADO" && $ed60_c_concluida=="N"){
                 ?>
                  <td class="aluno1">&nbsp;</td>
                 <?
                }
                $sql_rp = $clregenciaperiodo->sql_query("","sum(ed78_i_aulasdadas) as aulasdadas",""," ed78_i_regencia = $ed59_i_codigo AND ed09_c_somach = 'S'");
                $result_rp = $clregenciaperiodo->sql_record($sql_rp);
                if($clregenciaperiodo->numrows>0){
                 db_fieldsmemory($result_rp,0);
		  if(trim($ed60_c_situacao)=="MATRICULADO"){
                  ?>
                  <td class="aluno1"><?=$aulasdadas==""?"&nbsp;":$aulasdadas?></td>
                  <?
		}else{
                 ?>
                 <td class="aluno1">&nbsp;</td>
                 <?
		 }
                }
                if(trim($ed60_c_situacao)=="MATRICULADO"){
                 if(trim($ed81_c_todoperiodo)=="S"){
                  if($ed81_i_justificativa!=""){
                   $ed74_c_valoraprov = "Amparado";
                  }else{
                   $ed74_c_valoraprov = $ed250_c_abrev;
                  }
                  $ed74_i_percfreq = "";
                 }else{
                  $ed74_i_percfreq = number_format($ed74_i_percfreq,2,".",".");
                  if(trim($ed37_c_tipo)=="NOTA"){
                   $ed74_c_valoraprov = number_format($ed74_c_valoraprov,2,".",".");
                  }elseif(trim($ed37_c_tipo)=="PARECER"){
                   $ed74_c_valoraprov = "Parecer";
                  }else{
                   $ed74_c_valoraprov = $ed74_c_valoraprov;
                  }
                 }
                 if(trim($ed59_c_freqglob)=="A"){
                  $sql_f = "SELECT ed74_i_percfreq
                            FROM diariofinal
                             inner join diario on ed95_i_codigo = ed74_i_diario
                             inner join regencia on ed59_i_codigo = ed95_i_regencia
                             inner join turma on ed57_i_codigo = ed59_i_turma
                            WHERE ed57_i_codigo = $ed57_i_codigo
                            AND ed59_c_freqglob = 'F'
                            AND ed95_i_aluno = $ed60_i_aluno
                           ";
                  $result_f = pg_query($sql_f);
                  $linhas_f = pg_num_rows($result_f);
                  if(trim($ed81_c_todoperiodo)!="S"){
                   $ed74_i_percfreq = number_format(pg_result($result_f,0,'ed74_i_percfreq'),2,".",".");
                  }
                 }elseif(trim($ed59_c_freqglob)=="F"){
                  $ed74_c_valoraprov = "-";
                 }
                 if($ed74_c_resultadofinal==""){
                  $ed74_c_resultadofinal = "";
                 }elseif($ed74_c_resultadofinal=="A"){
                  $ed74_c_resultadofinal = "<font color='green'>Apr</font>";
                 }elseif($ed74_c_resultadofinal=="R"){
                  $ed74_c_resultadofinal = "<font color='red'>Rep</font>";
                 }
                 if(trim($ed37_c_tipo)=="PARECER"){
                  ?>
                  <td style="Cursor='hand';" onmouseover="js_mostra('parecerr<?=$ed74_i_codigo?>'); bgColor='#DEB887';" onmouseout="js_oculta('parecerr<?=$ed74_i_codigo?>'); bgColor='<?=$cor?>';" class="aluno1">
                   <?=$ed74_c_resultadofinal==""?"&nbsp;":$ed74_c_valoraprov==""?"&nbsp;":$ed74_c_valoraprov?>
                   <div name="parecerr<?=$ed74_i_codigo?>" id="parecerr<?=$ed74_i_codigo?>" style="position:absolute;visibility:hidden;">
                    <table width="50" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                      <td height="5">
                      </td>
                     </tr>
                    </table>
                    <table align="left" width="130" border="1" cellspacing="2" cellpadding="3">
                     <tr>
                      <td bgcolor="<?=$cor?>" class="aluno" align="justify">
                        <center>PARECER DESCRITIVO:</center><hr>
                        <?
                        if($ed74_i_procresultadoaprov!=""){
                         $sql_par = "SELECT ed73_t_parecer
                                     FROM diarioresultado
                                     WHERE ed73_i_diario = $ed95_i_codigo
                                     AND ed73_i_procresultado = $ed74_i_procresultadoaprov
                                    ";
                         $result_par = pg_query($sql_par);
                         $linhas_par = pg_num_rows($result_par);
                         if($linhas_par>0){
                          db_fieldsmemory($result_par,0);
                          echo $ed73_t_parecer;
                         }
                        }
                        ?>
                       </td>
                     </tr>
                    </table>
                   </div>
                  </td>
                  <?
                 }else{
                  ?>
                  <td class="aluno1"><?=$ed74_c_resultadofinal==""?"&nbsp;":($ed74_c_valoraprov==""?"&nbsp;":$ed74_c_valoraprov)?></td>
                  <?
                 }?>
                 <td class="aluno1"><?=$ed74_c_resultadofinal==""?"&nbsp;":($ed74_i_percfreq==""?"&nbsp;":$ed74_i_percfreq)?></td>
                 <td class="aluno1"><?=$ed74_c_resultadofinal==""?"&nbsp;":$ed74_c_resultadofinal?></td>
                 <?
                }else{
                 ?>
                  <td class="aluno1"><?=substr(Situacao($ed60_c_situacao,$ed60_i_codigo),0,5)?></td>
                  <td class="aluno1"><?=$ed74_c_resultadofinal==""?"&nbsp;":($ed74_i_percfreq==""?"&nbsp;":$ed74_i_percfreq)?></td>
                  <td class="aluno1"><?=$ed74_c_resultadofinal==""?"&nbsp;":$ed74_c_resultadofinal?></td>
                 <?
                }
               }
              ?>
              </tr>
              <?
             }
            }
           }
            if(trim($ed60_c_situacao)=="CLASSIFICADO" || trim($ed60_c_situacao)=="AVANÇADO"){
             $resultado = "<font color='green'>APROVADO</font>";
             $encerrado = "ENCERRADO";
            }elseif(trim($ed60_c_situacao)=="TRANSFERIDO FORA" || trim($ed60_c_situacao)=="TRANSFERIDO REDE"){
             if($ed60_c_concluida=="S"){
              $resultado = "<font color='BLACK'>".Situacao($ed60_c_situacao,$ed60_i_codigo)."</font>";
              $encerrado = "ENCERRADO";
             }else{
              $resultado = "<font color='BLACK'>EM ANDAMENTO</font>";
              $encerrado = "";
             }
            }else{
             $sql4 = "SELECT ed95_c_encerrado
                      FROM diario
                       inner join aluno on ed47_i_codigo = ed95_i_aluno
                       inner join diariofinal on ed74_i_diario = ed95_i_codigo
                       inner join regencia on ed59_i_codigo = ed95_i_regencia
                      WHERE ed95_i_aluno = $ed60_i_aluno
                      AND ed95_i_regencia in (select ed59_i_codigo
                                              from regencia
                                              where ed59_i_turma = $ed60_i_turma
                                              and ed59_c_condicao = 'OB')
                     ";
             $result4 = pg_query($sql4);
             $linhas4 = pg_num_rows($result4);
             if($linhas4==0){
              $resultado = "<font color='BLACK'>EM ANDAMENTO</font>";
              $encerrado = "";
             }else{
              $reg_encerrada = "";
              $sep = "";
              for($f=0;$f<$linhas4;$f++){
               db_fieldsmemory($result4,$f);
               $reg_encerrada .= $sep.$ed95_c_encerrado;
               $sep = ",";
              }
              if(strstr($reg_encerrada,"N")){
               $resultado = "<font color='BLACK'>EM ANDAMENTO</font>";
               $encerrado = "";
              }else{
               $encerrado = "ENCERRADO";
               $sql41 = "SELECT ed74_c_resultadofinal
                         FROM diario
                          inner join aluno on ed47_i_codigo = ed95_i_aluno
                          inner join diariofinal on ed74_i_diario = ed95_i_codigo
                         WHERE ed95_i_aluno = $ed60_i_aluno
                         AND ed95_i_regencia in (select ed59_i_codigo
                                                 from regencia
                                                 where ed59_i_turma = $ed60_i_turma
                                                 and ed59_c_condicao = 'OB')
                         AND ed74_c_resultadofinal != 'A'
                        ";
               $result41 = pg_query($sql41);
               $linhas41 = pg_num_rows($result41);
               if($linhas41>0){
                $resultado = "<font color='red'>REPROVADO</font>";
               }else{
                $resultado = "<font color='green'>APROVADO</font>";
               }
              }
             }
            }
            ?>
           <tr>
            <td colspan="<?=(($clprocavaliacao->numrows)*2)+5?>">
             <table width="100%">
              <tr>
               <td>
                <b>Resultado final em <?=$ed11_c_descr?>: <?=$resultado?></b>&nbsp;&nbsp;
               </td>
               <td align="right">
                <?
                if($ed60_c_ativa=="S"){
                 echo "* <font size='2'>Nota Externa</font>";
                }
                ?>
               </td>
              </tr>
              <tr>
               <td colspan="2">
                <?if($encerrado!=""){?>
                 <b>Situação: <?=$encerrado?></b>&nbsp;&nbsp;
                <?}?>
               </td>
              </tr>
             </table>
            </td>
           </tr>
          </table>
         </td>
        </tr>
       </table>
       <br>
       <table>
        <tr>
         <td>
          <b>Outras Matrículas:</b>
         </td>
        </tr>
        <tr><td height="1" bgcolor="#000000"></td></tr>
        <tr>
         <td>
         <?
         $result2 = $clmatricula->sql_record($clmatricula->sql_query("","*","ed60_d_datamatricula desc"," ed60_i_codigo not in($ed60_i_codigo) AND ed60_i_aluno = $chavepesquisa"));
         if($clmatricula->numrows>0){
          for($x=0;$x<$clmatricula->numrows;$x++){
           db_fieldsmemory($result2,$x);
           ?>
           <a href="edu3_alunos002.php?chavepesquisa=<?=$chavepesquisa?>&evento=3&ed60_i_codigo=<?=$ed60_i_codigo?>">Matricula nº <?=$ed60_i_codigo?></a>
           ->&nbsp;&nbsp;<b>Ano:</b> <?=$ed52_i_ano?>&nbsp;&nbsp;<b>Escola:</b> <?=$ed18_c_nome?>
           <br>
           <?
          }
         }else{
          echo "Nenhum registro.";
         }
         ?>
         </td>
        </tr>
        <?
       }else{
        ?>
        <tr>
         <td>
          Nenhum registro.
         </td>
        </tr>
        <?
       }
       ?></table>
      </fieldset>
     </td>
    </tr>
    <?}
    if($evento==4){
    $sql3 = "SELECT ed29_c_descr,ed62_i_codigo,ed11_c_descr,ed11_i_codigo,ed62_i_anoref,ed62_i_periodoref,ed18_c_nome,ed11_i_sequencia,ed11_i_ensino,'REDE' as tipo
             FROM historicomps
              inner join serie on ed11_i_codigo = ed62_i_serie
              inner join historico on ed61_i_codigo = ed62_i_historico
              inner join cursoedu on ed29_i_codigo = ed61_i_curso
              inner join escola on ed18_i_codigo = ed62_i_escola
             WHERE ed61_i_aluno = $chavepesquisa
             UNION
             SELECT ed29_c_descr,ed99_i_codigo,ed11_c_descr,ed11_i_codigo,ed99_i_anoref,ed99_i_periodoref,ed82_c_nome,ed11_i_sequencia,ed11_i_ensino,'FORA' as tipo
             FROM historicompsfora
              inner join serie on ed11_i_codigo = ed99_i_serie
              inner join historico on ed61_i_codigo = ed99_i_historico
              inner join cursoedu on ed29_i_codigo = ed61_i_curso
              inner join escolaproc on ed82_i_codigo = ed99_i_escolaproc
             WHERE ed61_i_aluno = $chavepesquisa
             ORDER BY ed11_i_ensino,ed11_i_sequencia ASC
            ";
    $result3 = pg_query($sql3);
    $linhas3 = pg_num_rows($result3);
    ?>
    <tr>
     <td valign="top" >
      <fieldset style="background:#f3f3f3;border:2px solid #000000"><legend class="cabec"><b>Histórico</b></legend>
      <table border="1" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="0">
       <?
       if($linhas3>0){
        $primeiro = "";
        for($t=0;$t<$linhas3;$t++){
         db_fieldsmemory($result3,$t);
         if($primeiro!=$ed29_c_descr){
          ?>
          <tr>
           <td class="cabec1">
            <?=$ed29_c_descr?>
           </td>
          </tr>
          <?
          $primeiro = $ed29_c_descr;
         }
         if( ($t==0 && !isset($chaveserie)) || (@$chaveserie==$ed62_i_codigo)){
          $class = "titulo";
         }else{
          $class = "aluno";
         }
         ?>
         <tr>
          <td class="<?=$class?>">
           <?
           if( ($t==0 && !isset($chaveserie)) || (@$chaveserie==$ed62_i_codigo)){
            ?>
            Série: <?=$ed11_c_descr?>
            &nbsp;&nbsp;Ano: <?=$ed62_i_anoref?>&nbsp;&nbsp;Escola: <?=$ed18_c_nome?>
            <?
           }else{
            ?>
            <a class="<?=$class?>" href="edu3_alunos002.php?chavepesquisa=<?=$chavepesquisa?>&chaveserie=<?=$ed62_i_codigo?>&evento=4">
             Série: <?=$ed11_c_descr?>
            </a>
            &nbsp;&nbsp;Ano: <?=$ed62_i_anoref?>&nbsp;&nbsp;Escola: <?=$ed18_c_nome?>
            <?
           }
           ?>
          </td>
         </tr>
         <tr>
          <td>
          <?
          if( ($t==0 && !isset($chaveserie)) || (@$chaveserie==$ed62_i_codigo)){
           if($tipo=="REDE"){
            $campos = "ed65_i_codigo,
                       ed232_c_descr,
                       ed65_c_situacao,
                       case when ed65_c_situacao!='CONCLUÍDO' then '&nbsp;' else ed65_t_resultobtido end as ed65_t_resultobtido,
                       ed65_c_resultadofinal,
                       ed65_i_qtdch,
                       ed65_c_tiporesultado,
                       ed65_i_historicomps,
                       ed29_c_descr
                      ";
            $result = $clhistmpsdisc->sql_record($clhistmpsdisc->sql_query("","$campos","ed232_c_descr"," ed65_i_historicomps = $ed62_i_codigo"));
            ?>
            <?if($result){?>
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
             <tr class='titulo' align="center">
              <td>Disciplina</td>
              <td>Situação</td>
              <td>Aprov.</td>
              <td>RF</td>
              <td>CH</td>
              <td>TR</td>
             </tr>
             <?
             if($clhistmpsdisc->numrows>0){
              $cor1 = "#f3f3f3";
              $cor2 = "#DBDBDB";
              $cor = "";
              for($x=0;$x<$clhistmpsdisc->numrows;$x++){
               db_fieldsmemory($result,$x);
               if($cor==$cor1){
                $cor = $cor2;
               }else{
                 $cor = $cor1;
               }
               if(trim($ed65_c_situacao)=="AMPARADO"){
                $ed65_t_resultobtido = "&nbsp;";
               }elseif($ed65_c_tiporesultado=='N'){
               if($resultedu=='S'){
                 $ed65_t_resultobtido = number_format($ed65_t_resultobtido,2,".",".");
               }else{
                 $ed65_t_resultobtido = number_format($ed65_t_resultobtido,0,".",".");
               }

               }
               ?>
               <tr height="18" bgcolor="<?=$cor?>">
                <td class='aluno'><?=$ed232_c_descr?></td>
                <td class='aluno' align="center"><?=$ed65_c_situacao?></td>
                <td class='aluno' align="<?=$ed65_c_tiporesultado=='N'?'right':'center'?>"><?=$ed65_t_resultobtido?></td>
                <td class='aluno' align="center"><?=$ed65_c_resultadofinal=="R"?"REPROVADO":"APROVADO"?></td>
                <td class='aluno' align="right"><?=$ed65_i_qtdch==""?0:$ed65_i_qtdch?></td>
                <td class='aluno' align="center"><?=trim($ed65_c_tiporesultado)?></td>
               </tr>
               <?
              }
             }else{
              ?>
              <tr height="18" bgcolor="#f3f3f3">
               <td colspan="6" class="aluno" align="center">Nenhuma disciplina cadastrada para esta série.</td>
              </tr>
              <?
             }
             ?>
            </table>
            <?
            }
           }else{
            $campos = "ed100_i_codigo,
                       ed232_c_descr,
                       ed100_c_situacao,
                       case when ed100_c_situacao!='CONCLUÍDO' OR ed100_t_resultobtido = '' then '&nbsp;' else ed100_t_resultobtido end as ed100_t_resultobtido,
                       ed100_c_resultadofinal,
                       ed100_i_qtdch,
                       ed100_c_tiporesultado,
                       ed100_i_historicompsfora,
                       ed29_c_descr
                      ";
            $result = $clhistmpsdiscfora->sql_record($clhistmpsdiscfora->sql_query("","$campos","ed232_c_descr"," ed100_i_historicompsfora = $ed62_i_codigo"));
            ?>
            <?if($result){?>
            <table width="100%" border="1" cellspacing="0" cellpadding="0">
             <tr class='titulo'>
              <td>Disciplina</td>
              <td>Situação</td>
              <td>Aprov.</td>
              <td>RF</td>
              <td>CH</td>
              <td>TR</td>
             </tr>
             <?
             if($clhistmpsdiscfora->numrows>0){
              $cor1 = "#f3f3f3";
              $cor2 = "#DBDBDB";
              $cor = "";
              for($x=0;$x<$clhistmpsdiscfora->numrows;$x++){
               db_fieldsmemory($result,$x);
               if($cor==$cor1){
                $cor = $cor2;
               }else{
                 $cor = $cor1;
               }
               if(trim($ed100_c_situacao)=="AMPARADO"){
                $ed100_t_resultobtido = "&nbsp;";
               }elseif($ed100_c_tiporesultado=='N'){
                $ed100_t_resultobtido = number_format($ed100_t_resultobtido,2,".",".");
               }
               ?>
               <tr height="18" bgcolor="<?=$cor?>">
                <td class='aluno'><?=$ed232_c_descr?></td>
                <td class='aluno'><?=$ed100_c_situacao?></td>
                <td class='aluno' align="<?=$ed100_c_tiporesultado=='N'?'right':'center'?>"><?=$ed100_t_resultobtido?></td>
                <td class='aluno'><?=$ed100_c_resultadofinal=="R"?"REPROVADO":"APROVADO"?></td>
                <td class='aluno' align="right"><?=$ed100_i_qtdch==""?0:$ed100_i_qtdch?></td>
                <td class='aluno' align="right"><?=trim($ed100_c_tiporesultado)?></td>
               </tr>
               <?
              }
             }else{
              ?>
              <tr height="18" bgcolor="#f3f3f3">
               <td colspan="6" class="aluno" align="center">Nenhuma disciplina cadastrada para esta série.</td>
              </tr>
              <?
             }
             ?>
            </table>
            <?
            }
           }
          }
          ?>
         </td>
        </tr>
        <?
       }
      }else{
       ?>
       <tr>
        <td>
         Nenhum registro.
        </td>
       </tr>
       <?
      }
      ?>
     </table>
    </fieldset>
   <?}
   if($evento==5){?>
   <tr>
    <td valign="top" >
     <fieldset style="background:#f3f3f3;border:2px solid #000000"><legend class="cabec"><b>Necessidades Especiais</b></legend>
     <table border="1" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="0">
      <?
      $result = $clalunonecessidade->sql_record($clalunonecessidade->sql_query("","*","ed48_c_descr"," ed214_i_aluno = $chavepesquisa"));
      if($clalunonecessidade->numrows>0){
       ?>
       <tr>
        <td class="cabec1">
         <table width="100%" cellspacing="0" cellpading="0">
          <tr>
           <td width="40%" class="cabec1">
            Descrição:
           </td>
           <td class="cabec1">
            Necessidade Maior:
           </td>
          </tr>
         </table>
        </td>
       </tr>
       <?
       for($f=0;$f<$clalunonecessidade->numrows;$f++){
        db_fieldsmemory($result,$f);
        ?>
        <tr>
         <td>
          <table width="100%" cellspacing="0" cellpading="0">
           <tr>
            <td width="40%">
             <?=@$ed48_c_descr?>
            </td>
            <td>
             <?=@$ed214_c_principal?>
            </td>
           </tr>
          </table>
         </td>
        </tr>
       <?
       }
      }else{
       ?>
       <tr>
        <td>
         Nenhum registro.
        </td>
       </tr>
       <?
      }
      ?>
     </table>
     </fieldset>
    </td>
   </tr>
   <?}
   if($evento==6){
    if(!isset($ordem)){
     $ordem = "ASC";
   }
   ?>
   <tr>
    <td valign="top" >
     <fieldset style="background:#f3f3f3;border:2px solid #000000">
     <legend class="cabec"><b>Movimentação Escolar - Ordem: <select name="ordem" onchange="location.href='edu3_alunos002.php?chavepesquisa=<?=$chavepesquisa?>&evento=6&ordem='+this.value" style="height:15px;font-size:9px;"><option value="ASC" <?=$ordem=="ASC"?"selected":""?>>Crescente</option><option value="DESC" <?=$ordem=="DESC"?"selected":""?>>Decrescente</option></select></b></legend>
     <table border="1" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="0">
      <?
      $camp = "case
               when ed229_c_procedimento = 'TRANSFERÊNCIA ENTRE ESCOLAS DA REDE' then
                (select ed103_d_data from transfescolarede where ed103_i_matricula = ed229_i_matricula order by ed103_d_data desc limit 1)
               when ed229_c_procedimento = 'TRANSFERÊNCIA PARA OUTRA ESCOLA' then
                (select ed104_d_data from transfescolafora where ed104_i_aluno = ed60_i_aluno and ed104_i_escolaorigem = turma.ed57_i_escola and extract(year from ed104_d_data) = calendario.ed52_i_ano order by ed104_d_data desc limit 1)
               when ed229_c_procedimento = 'PROGRESSÃO DE ALUNO -> AVANÇO' OR ed229_c_procedimento = 'PROGRESSÃO DE ALUNO -> CLASSIFICAÇÂO' then
                (select ed101_d_data from trocaserie where ed101_i_aluno = ed60_i_aluno and ed101_i_turmaorig = ed60_i_turma order by ed101_d_data desc limit 1)
               when ed229_c_procedimento = 'TROCAR ALUNO DE TURMA' then
                (select ed69_d_datatransf from alunotransfturma where ed69_i_matricula = ed229_i_matricula order by ed69_d_datatransf desc limit 1)
               when ed229_c_procedimento = 'MATRICULAR ALUNO' OR ed229_c_procedimento = 'MATRICULAR ALUNOS TRANSFERIDOS' OR ed229_c_procedimento = 'REMATRICULAR ALUNO' then
                ed60_d_datamatricula
               when ed229_c_procedimento = 'ALTERAÇÃO DE DATA DA MATRÍCULA E/OU OBSERVAÇÕES' then
                ed60_d_datamodif
               when ed229_c_procedimento = 'ALTERAR SITUAÇÂO DA MATRÍCULA' then
                case
                 when ed60_c_situacao = 'CANCELADO'
                  then (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo AND ed229_t_descr like '%PARA CANCELADO%' order by ed229_d_data desc limit 1)
                 when ed60_c_situacao = 'EVADIDO'
                  then (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo AND ed229_t_descr like '%PARA EVADIDO%' order by ed229_d_data desc limit 1)
                 when ed60_c_situacao = 'FALECIDO'
                  then (select ed229_d_data from matriculamov where ed229_i_matricula = ed60_i_codigo AND ed229_t_descr like '%PARA FALECIDO%' order by ed229_d_data desc limit 1)
                end
               else ed229_d_data
              end as datareal,
             ";
      $result = $clmatriculamov->sql_record($clmatriculamov->sql_query("",$camp."ed18_i_codigo,ed18_c_nome,ed60_i_codigo,ed57_c_descr,ed52_i_ano,ed11_c_descr,ed229_c_procedimento,ed229_t_descr","ed229_i_codigo $ordem"," ed60_i_aluno = $chavepesquisa"));
      if($clmatriculamov->numrows>0){
       ?>
       <tr class="titulo" align="center">
        <td>Data</td>
        <td>Escola</td>
        <td>Matr.</td>
        <td>Turma</td>
        <td>Ano</td>
        <td>Série</td>
        <td>Procedimento</td>
       </tr>
       <?
       for($f=0;$f<$clmatriculamov->numrows;$f++){
        db_fieldsmemory($result,$f);
        ?>
	<tr><td height="1" bgcolor="black" colspan="7"></td></tr>
        <tr bgcolor="#dbdbdb">
         <td class="aluno2" align="center"><?=db_formatar($datareal,'d')?></td>
         <td class="aluno2"><?=$ed18_i_codigo?> - <?=substr($ed18_c_nome,0,30)?></td>
         <td class="aluno2" align="center"><?=$ed60_i_codigo?></td>
         <td class="aluno2" align="center"><?=$ed57_c_descr?></td>
         <td class="aluno2" align="center"><?=$ed52_i_ano?></td>
         <td class="aluno2" align="center"><?=$ed11_c_descr?></td>
         <td class="aluno2"><?=$ed229_c_procedimento?></td>
	</tr>
	<tr>
         <td>&nbsp;</td>
         <td bgcolor="#f3f3f3" colspan="6" class="aluno2"><?=$ed229_t_descr?></td>
        </tr>
       <?
       }
      }else{
       ?>
       <tr>
        <td>
         Nenhum registro.
        </td>
       </tr>
       <?
      }
      ?>
     </table><?
      $result_log = $cllogmatricula->sql_record($cllogmatricula->sql_query("","*","ed248_d_data,ed248_c_hora"," ed248_i_aluno = $chavepesquisa"));
      if($cllogmatricula->numrows>0){
       ?>
       <br>
       <table border="0" width="100%" bgcolor="#f3f3f3" cellspacing="0" cellpading="0">
        <tr>
         <td colspan="2">
          <b>Outras Movimentações:</b>
         </td>
        </tr>
        <tr><td colspan="2" height="1" bgcolor="#000000"></td></tr>
        <?for($q=0;$q<$cllogmatricula->numrows;$q++){
         db_fieldsmemory($result_log,$q);
         ?>
         <tr>
          <td colspan="2">
           <?
           if($ed248_c_tipo=="E"){
            $descrlog = "Matrícula Excluída";
           }elseif($ed248_c_tipo=="R"){
            $descrlog = "Reativação de Matrícula";
           }elseif($ed248_c_tipo=="T"){
            $descrlog = "Cancelamento de Transferência";
           }
           ?>
           <b><?=$descrlog?></b>
          </td>
         </tr>
         <tr>
          <td width="10"></td>
          <td>
           <?=$ed248_t_origem?><br>
           Data/Hora: <?=db_formatar($ed248_d_data,'d')."&nbsp;&nbsp;".$ed248_c_hora?>&nbsp;&nbsp;&nbsp;
           Usuário: <?=$nome?><br>
           <?=$ed248_c_tipo=="E"?"Motivo: ".($ed249_c_motivo==""?"Não Informado":$ed249_c_motivo):""?><br>
           <?=trim($ed248_t_obs)!=""?"Observações: $ed248_t_obs":""?>
          </td>
         </tr>
         <?
        }
        ?>
       </table>
       <?
      }
      ?>
     </fieldset>
    </td>
   </tr>
   <?}?>
   </table>
  </td>
 </tr>
</table>
</body>
</html>
