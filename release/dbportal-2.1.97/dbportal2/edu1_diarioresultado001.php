<?
require("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_diarioresultado_classe.php");
include("classes/db_diariofinal_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_conceito_classe.php");
include("classes/db_procresultado_classe.php");
include("classes/db_avalcompoeres_classe.php");
include("classes/db_rescompoeres_classe.php");
db_postmemory($HTTP_POST_VARS);
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$cldiarioresultado = new cl_diarioresultado;
$cldiarioavaliacao = new cl_diarioavaliacao;
$cldiariofinal = new cl_diariofinal;
$clregencia = new cl_regencia;
$clconceito = new cl_conceito;
$clprocresultado = new cl_procresultado;
$clavalcompoeres = new cl_avalcompoeres;
$clrescompoeres = new cl_rescompoeres;
$db_botao = true;
$corsim = "#BBFFBB";
$cornao = "#FF9B9B";
$codescola = db_getsession("DB_coddepto");
$resultedu = eduparametros(db_getsession("DB_coddepto"));
$permitenotaembranco = VerParametroNota(db_getsession("DB_coddepto"));
$escola = db_getsession("DB_nomedepto");
$campos = "ed40_i_percfreq as percfreq,
           ed43_c_minimoaprov as minimoaprov,
           ed43_c_obtencao as obtencao,
           ed43_c_arredmedia as arredmedia,
           ed43_c_tipoarred as tipoarred,
           ed43_i_sequencia as sequencia,
           ed37_c_tipo as formaaval,
           ed43_i_formaavaliacao as formaavaliacao
          ";
$result = $clprocresultado->sql_record($clprocresultado->sql_query("",$campos,"","ed43_i_codigo = $ed43_i_codigo"));
db_fieldsmemory($result,0);
$result1 = $clregencia->sql_record($clregencia->sql_query("","*","","ed59_i_codigo = $regencia"));
db_fieldsmemory($result1,0);
if(trim($obtencao)!="AT"){
 $result3 = $clavalcompoeres->sql_record($clavalcompoeres->sql_query_file("","ed44_i_procavaliacao as componentes","","ed44_i_procresultado = $ed43_i_codigo"));
 $n_periodos = $clavalcompoeres->numrows;
 $avalcomp = "";
 $vir = "";
 for($y=0;$y<$clavalcompoeres->numrows;$y++){
  db_fieldsmemory($result3,$y);
  $avalcomp .= $vir.$componentes;
  $vir = ",";
 }
 $avalcomp = $avalcomp==""?0:$avalcomp;
 $result_r = $clrescompoeres->sql_record($clrescompoeres->sql_query_file("","ed68_i_procresultcomp as rescomponentes","","ed68_i_procresultado = $ed43_i_codigo"));
 $rescomp = "";
 $vir = "";
 for($y=0;$y<$clrescompoeres->numrows;$y++){
  db_fieldsmemory($result_r,$y);
  $rescomp .= $vir.$rescomponentes;
  $vir = ",";
 }
 $rescomp = $rescomp==""?0:$rescomp;
 //pega codigo da ultimo elemento para cálculo(obtencao=ULTIMA NOTA)
 $sql_ult = "SELECT ed43_i_sequencia,ed43_i_codigo as ultima,case when ed43_i_codigo>0 then 'R' end as tipoultima
             FROM procresultado
             WHERE ed43_i_codigo in ($rescomp)
             UNION
             SELECT ed41_i_sequencia,ed41_i_codigo as ultima,case when ed41_i_codigo>0 then 'A' end as tipoultima
             FROM procavaliacao
             WHERE ed41_i_codigo in ($avalcomp)
             ORDER BY ed43_i_sequencia DESC
            ";
 $result_ult = pg_query($sql_ult);
 if($result_ult){
  db_fieldsmemory($result_ult,0);
 }
}
if(isset($alterar)){
 $result_min = $cldiarioresultado->sql_record($cldiarioresultado->sql_query("","ed73_i_procresultado as avalia,ed43_i_formaavaliacao,ed37_c_minimoaprov",""," ed73_i_codigo = $codigo"));
 db_fieldsmemory($result_min,0);
 if($tipo=="NIVEL"){
  $conceito = $valor;
  $nota = "";
  if($conceito!=""){
   $result_dig = $clconceito->sql_record($clconceito->sql_query("","ed39_i_sequencia as dig","","ed39_i_formaavaliacao = $ed43_i_formaavaliacao AND ed39_c_conceito = '$conceito'"));
   db_fieldsmemory($result_dig,0);
   $result_reg = $clconceito->sql_record($clconceito->sql_query("","ed39_i_sequencia as reg","","ed39_i_formaavaliacao = $ed43_i_formaavaliacao AND ed39_c_conceito = '$ed37_c_minimoaprov'"));
   db_fieldsmemory($result_reg,0);
   if($dig>=$reg){
    $minimo = "S";
   }else{
    $minimo = "N";
   }
  }else{
   $minimo = "N";
  }
 }elseif($tipo=="NOTA"){
  $nota = $valor;
  $conceito = "";
  if($nota!=""){
   if($nota>=$ed37_c_minimoaprov){
    $minimo = "S";
   }else{
    $minimo = "N";
   }
  }else{
   $minimo = "N";
  }
 }elseif($tipo=="PARECER"){
  $nota = "";
  $conceito = "";
  $minimo = "S";
 }
 db_inicio_transacao();
 $cldiarioresultado->ed73_c_aprovmin = $minimo;
 $cldiarioresultado->ed73_c_valorconceito = $conceito;
 $cldiarioresultado->ed73_i_valornota = $nota;
 $cldiarioresultado->ed73_i_codigo = $codigo;
 $cldiarioresultado->alterar($codigo);
 db_fim_transacao();
 $dataatualiz = date("Y-m-d");
 $sql = "UPDATE regencia SET
          ed59_d_dataatualiz = '$dataatualiz'
         WHERE ed59_i_codigo = $regencia
        ";
 $result = pg_query($sql);
}
if(isset($aprovminimo)){
 $sql = "UPDATE diarioresultado SET ed73_c_aprovmin = '$valor' WHERE ed73_i_codigo = $codigo";
 $query = pg_query($sql);
 $result_df = $cldiarioresultado->sql_record($cldiarioresultado->sql_query("","ed95_i_codigo as coddiariodeste",""," ed73_i_codigo = $codigo"));
 db_fieldsmemory($result_df,0);
 if($valor=="S"){
  $valoraprov = "A";
  $valordescrito = "Parecer";
 }elseif($valor=="N"){
  $valoraprov = "R";
  $valordescrito = "Parecer";
 }else{
  $valoraprov = "";
  $valordescrito = "";
 }
 $result_df1 = $cldiariofinal->sql_record($cldiariofinal->sql_query("","ed74_c_resultadofreq,ed74_i_procresultadofreq,ed74_i_percfreq",""," ed74_i_diario = $coddiariodeste"));
 db_fieldsmemory($result_df1,0);
 if($ed74_c_resultadofreq=="A" && $valoraprov=="A"){
  $res_final = "A";
 }elseif($ed74_c_resultadofreq=="" || $valoraprov==""){
  $res_final = "";
 }else{
  $res_final = "R";
 }
 $ed74_i_procresultadofreq = $ed74_i_procresultadofreq==""?"null":$ed74_i_procresultadofreq;
 $ed74_i_percfreq = $ed74_i_percfreq==""?"null":$ed74_i_percfreq;
 $sql = "UPDATE diariofinal SET
          ed74_i_procresultadoaprov = $ed43_i_codigo,
          ed74_c_resultadoaprov = '$valoraprov',
          ed74_c_valoraprov = '$valordescrito',
          ed74_i_procresultadofreq = $ed74_i_procresultadofreq,
          ed74_c_resultadofreq = '$ed74_c_resultadofreq',
          ed74_i_percfreq = $ed74_i_percfreq,
          ed74_c_resultadofinal = '$res_final'
         WHERE ed74_i_diario = $coddiariodeste";
 $query = pg_query($sql);
 $dataatualiz = date("Y-m-d");
 $sql = "UPDATE regencia SET
           ed59_d_dataatualiz = '$dataatualiz'
         WHERE ed59_i_codigo = $regencia
        ";
 $result = pg_query($sql);
 $cldiarioresultado->numrows = 0;
 ?>
 <script>
  parent.iframe_RF.location.href = "edu1_diariofinal001.php?regencia=<?=$regencia?>";
 </script>
 <?
 $valoralterado = $valor;
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
 font-size: 9;

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
<form name="form1" method="post" action="">
<input name="ed43_i_codigo" type="hidden" value="<?=$ed43_i_codigo?>">
<input name="regencia" type="hidden" value="<?=$regencia?>">
<?
$sql = "SELECT ed60_c_situacao,
               ed60_c_concluida,
               ed60_i_codigo,
	       ed60_c_ativa,
	       ed60_d_datamatricula,
               diarioresultado.*,
               ed60_i_numaluno,
               ed60_c_parecer,
               ed47_v_nome,
               ed47_i_codigo,
               ed42_c_descr,
               ed37_c_tipo,
               ed37_i_menorvalor,
               ed37_i_maiorvalor,
               ed37_i_variacao,
               ed43_i_formaavaliacao,
               ed81_c_todoperiodo,
               ed81_i_justificativa,
               ed81_i_convencaoamp,
               ed95_c_encerrado,
               convencaoamp.*,
               case
                when ed60_c_situacao = 'TRANSFERIDO REDE' then
                 (select to_char(ed103_d_data,'DD/MM/YYYY') from transfescolarede where ed103_i_matricula = ed60_i_codigo order by ed103_d_data desc limit 1)
                when ed60_c_situacao = 'TRANSFERIDO FORA' then
                 (select to_char(ed104_d_data,'DD/MM/YYYY') from transfescolafora where ed104_i_aluno = ed60_i_aluno and ed104_i_escolaorigem = $codescola order by ed104_d_data desc limit 1)
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
                else null end as datasaida
        FROM matricula
         inner join aluno on ed47_i_codigo = ed60_i_aluno
         inner join diario on ed95_i_aluno = ed47_i_codigo
         inner join diarioresultado on ed73_i_diario = ed95_i_codigo
         inner join procresultado on ed43_i_codigo = ed73_i_procresultado
         inner join formaavaliacao on ed37_i_codigo = ed43_i_formaavaliacao
         inner join resultado on ed42_i_codigo = ed43_i_resultado
         left join amparo on ed81_i_diario = ed95_i_codigo
         left join convencaoamp on ed250_i_codigo = ed81_i_convencaoamp
        WHERE ed95_i_regencia = $regencia
        AND ed73_i_procresultado = $ed43_i_codigo
        AND ed60_i_turma = $ed59_i_turma
        ORDER BY ed60_i_numaluno,to_ascii(ed47_v_nome),ed60_c_ativa
       ";
$result2 = pg_query($sql);
$linhas = pg_num_rows($result2);
//db_criatabela($result2);
//exit;
?>
<table border='0' width="96%" bgcolor="#cccccc" style="" cellspacing="0" cellpading="0">
 <tr>
  <td class='titulo'>
   &nbsp;<?=$ed232_c_descr?> - <?=pg_result($result2,0,'ed42_c_descr')?> <br> Turma <?=$ed57_c_descr?> - Calendário <?=$ed52_c_descr?>
  </td>
  <td class='titulo' align="center">
   Forma de Obtenção:<br>
   <?
   if(trim(pg_result($result2,0,'ed37_c_tipo'))=="NOTA"){
    if(trim($obtencao)=="AT"){
     $formaobtencao = "ATRIBUÍDO";
    }elseif(trim($obtencao)=="ME"){
     $formaobtencao = "MÉDIA ARITMÉTICA";
    }elseif(trim($obtencao)=="SO"){
     $formaobtencao = "SOMA";
    }elseif(trim($obtencao)=="MN"){
     $formaobtencao = "MAIOR NOTA";
    }elseif(trim($obtencao)=="UN"){
     $formaobtencao = "ÚLTIMA NOTA";
    }elseif(trim($obtencao)=="MP"){
     $formaobtencao = "MÉDIA PONDERADA";
    }
   }elseif(trim(pg_result($result2,0,'ed37_c_tipo'))=="NIVEL"){
    if(trim($obtencao)=="AT"){
     $formaobtencao = "ATRIBUÍDO";
    }elseif(trim($obtencao)=="MC"){
     $formaobtencao = "MAIOR NIVEL";
    }elseif(trim($obtencao)=="UC"){
     $formaobtencao = "ÚLTIMO NIVEL";
    }
   }else{
    $formaobtencao = "ATRIBUÍDO";
   }
   echo $formaobtencao;
   ?>
  </td>
  <td class='titulo' width="25%" align="right">
   <table border='0px' style="" cellspacing="0px" cellpading="0px">
    <tr>
     <td class='titulo' align="center">
      Mínimo para Aprovação:
      <table border="0" cellspacing="0px" cellpading="0px">
       <tr>
        <td width="40" bgcolor="#f3f3f3" width="40" align="center">
         <font face="tahoma" color="#008000" size="1">
          <?if($resultedu=="S"){?>
           <b><?=(trim($formaaval)=="NOTA")?number_format($minimoaprov,2,".","."):(trim($formaaval)=="NIVEL"?$minimoaprov:"----")?></b>
          <?}else{?>
           <b><?=(trim($formaaval)=="NOTA")?number_format(str_replace(".00","",$minimoaprov),0):(trim($formaaval)=="NIVEL"?$minimoaprov:"----")?></b>
          <?}?>
         </font>
        </td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td colspan="3">
   <table border='1px' width="100%" bgcolor="#cccccc" style="" cellspacing="0px">
    <tr>
     <td colspan="6" width="55%" align="center" class='cabec1'>Alunos</td>
     <td align="center" class='cabec1'><?=pg_result($result2,0,'ed42_c_descr')?></td>
    </tr>
    <tr align="center">
     <td class="cabec1">N°</td>
     <td class="cabec1">Nome</td>
     <td class="cabec1">Situação</td>
     <td class="cabec1">Dt. Matrícula</td>
     <td class="cabec1">Dt. Saída</td>
     <td class="cabec1">Código</td>
     <td class="cabec1"><?=pg_result($result2,0,'ed37_c_tipo')?></td>
    </tr>
    <?
    if($linhas>0){
     $cor1 = "#f3f3f3";
     $cor2 = "#DBDBDB";
     $cor = "";
     for($x=0;$x<$linhas;$x++){
      db_fieldsmemory($result2,$x);
      if($ed60_c_parecer=="S"){
       $obtencao_ant = $obtencao;
       $ed37_c_tipo = "PARECER";
       $obtencao = "AT";
       $neeparecer = "S";
       $up_diario = pg_query("UPDATE diarioresultado SET ed73_i_valornota = null,ed73_c_valorconceito = '' WHERE ed73_i_codigo = $ed73_i_codigo");
       if(trim($ed81_c_todoperiodo)=="" && trim($ed60_c_concluida)=="N"){
        $up_diario = pg_query("UPDATE diarioresultado SET ed73_c_amparo = 'N' WHERE ed73_i_codigo = $ed73_i_codigo");
        $ed73_c_amparo = "N";
       }
      }else{
       $neeparecer = "N";
      }
      if($cor==$cor1){
       $cor = $cor2;
      }else{
       $cor = $cor1;
      }
      if(trim($ed60_c_situacao)!="MATRICULADO" || trim($ed73_c_amparo)=="S"){
       if(trim($ed60_c_situacao)=="TRANSFERIDO FORA" && $ed60_c_ativa=="S"){
        $disabled = "";
        $cordisabled = "#FFD5AA";
        $ed95_c_encerrado = "N";
       }elseif(trim($ed60_c_situacao)=="TRANSFERIDO FORA" && $ed60_c_ativa=="N"){
        $disabled = "disabled";
        $cordisabled = "#FFD5AA";
        $ed73_i_valornota = "";
        $ed73_c_valorconceito = "";
        $ed73_t_parecer = "";
       }else{
        $disabled = "disabled";
        $cordisabled = "#FFD5AA";
       }
      }else{
       $disabled = "";
       $cordisabled = "#FFFFFF";
      }
      ?>
      <tr bgcolor="<?=$cor?>" <?=trim($ed60_c_concluida)=="S"?"":"height='33'"?>>
       <td align="right" class='aluno'><?=$ed60_i_numaluno?></td>
       <td class='aluno'>
        <a class="aluno" href="javascript:js_movimentos(<?=$ed60_i_codigo?>)"><?=$ed47_v_nome?></a>
        <?=$ed60_c_parecer=="S"?"<b>&nbsp;&nbsp;&nbsp;(NEE - Parecer)</b>":""?>
       </td>
       <td align="center" class='aluno'>
        <?
        if(trim($ed81_c_todoperiodo)=="S" && $ed60_c_ativa=="S"){
         if($ed81_i_justificativa!=""){
          echo "AMPARADO";
         }else{
          echo "$ed250_c_abrev";
         }
        }else{
         echo Situacao($ed60_c_situacao,$ed60_i_codigo);
        }
        ?>
       </td>
       <td align="center" class='aluno'><?=db_formatar($ed60_d_datamatricula,'d')?></td>
       <td align="center" class='aluno'><?=$datasaida==""?"&nbsp;":$datasaida?></td>
       <td align="right" class='aluno'><b><?=$ed47_i_codigo?></b></td>
       <?
       if(trim($ed81_c_todoperiodo)=="S"){
        if($ed60_c_ativa=="S"){
         if($ed81_i_justificativa!=""){
          ?><td align="center" class='aluno'>Amparo - Justificativa Legal n° <?=$ed81_i_justificativa?></td><?
         }elseif($ed81_i_convencaoamp!=""){
          ?><td align="center" class='aluno'><?=$ed250_c_abrev?></td><?
         }
        }else{
         ?><td align="center" class='aluno'>&nbsp;</td><?
        }
        if(trim($ed60_c_concluida)=="N"){
         db_inicio_transacao();
         $cldiarioresultado->ed73_c_amparo = "S";
         $cldiarioresultado->ed73_c_valorconceito = "";
         $cldiarioresultado->ed73_i_valornota = "";
         $cldiarioresultado->ed73_t_parecer = "";
         $cldiarioresultado->ed73_i_codigo = $ed73_i_codigo;
         $cldiarioresultado->alterar($ed73_i_codigo);
         db_fim_transacao();
        }
       }else{
        if(trim($ed60_c_concluida)=="S"){
         if(trim($ed37_c_tipo)=="NIVEL"){?>
          <td class='aluno' align="center">
           <?=$formaobtencao?>:<br>
           <select name="ed73_c_valorconceito" style="background:<?=$cordisabled?>;width:50px;height:15px;font-size:10px;text-align:center;padding:0px;" onclick="alert('Aluno já possui avaliações encerradas para esta disciplina!')" <?=trim($ed95_c_encerrado)=="S"?"disabled":$disabled?>>
            <option value=""></option>
            <?for($z=0;$z<$clconceito->numrows;$z++){
              db_fieldsmemory($result3,$z);?>
             <option value="<?=trim($ed39_c_conceito)?>" <?=trim($ed39_c_conceito)==trim($ed73_c_valorconceito)?"selected":""?>><?=trim($ed39_c_conceito)?></option>
            <?}?>
          </select>
          </td>
         <?}elseif(trim($ed37_c_tipo)=="PARECER"){?>
          <td class='aluno' align="center">
           <input name="ed73_t_parecer" value="<?=@$ed73_t_parecer!=''?substr(@$ed73_t_parecer,0,20).'...':''?>" type="text" size="20" maxlength="20" style="background:<?=$cordisabled?>;height:14px;text-align:left;border: 1px solid #000000;font-size:11px;padding:0px;" onclick="js_parecer(this,<?=$ed73_i_codigo?>,<?=$ed73_i_procresultado?>,'<?=$ed42_c_descr?>','<?=$ed47_v_nome?>','<?=$ed95_c_encerrado?>',<?=$ed59_i_turma?>,<?=$ed47_i_codigo?>);" <?=trim($ed95_c_encerrado)=="S"?"readonly":$disabled?>>
           <select name="ed73_c_aprovmin" style="background:<?=$cordisabled?>;width:95px;height:17px;font-size:10px;text-align:center;padding:0px;" onclick="alert('Aluno já possui avaliações encerradas para esta disciplina!')" <?=trim($ed95_c_encerrado)=="S"?"disabled":$disabled?>>
            <option value="" <?=$ed73_c_aprovmin==""?"selected":""?>></option>
            <option value="S" <?=$ed73_c_aprovmin=="S"?"selected":""?>>APROVADO</option>
            <option value="N" <?=$ed73_c_aprovmin=="N"?"selected":""?>>REPROVADO</option>
          </select>
          </td>
         <?}elseif(trim($ed37_c_tipo)=="NOTA"){?>
          <?if($resultedu=="S"){?>
           <td class='aluno' align="center"><?=$formaobtencao?>:<br><input name="ed73_i_valornota" value="<?=@$ed73_i_valornota!=''?number_format($ed73_i_valornota,2,'.','.'):''?>" type="text" size="6" maxlength="6" style="background:<?=$cordisabled?>;width:45px;height:14px;border: 1px solid #000000;font-size:11px;text-align:right;padding:0px;" onclick="alert('Aluno já possui avaliações encerradas para esta disciplina!')" <?=trim($ed95_c_encerrado)=="S"?"readonly":$disabled?>></td>
          <?}else{?>
           <td class='aluno' align="center"><?=$formaobtencao?>:<br><input name="ed73_i_valornota" value="<?=@$ed73_i_valornota!=''?number_format($ed73_i_valornota,0):''?>" type="text" size="6" maxlength="6" style="background:<?=$cordisabled?>;width:45px;height:14px;border: 1px solid #000000;font-size:11px;text-align:right;padding:0px;" onclick="alert('Aluno já possui avaliações encerradas para esta disciplina!')" <?=trim($ed95_c_encerrado)=="S"?"readonly":$disabled?>></td>
          <?}?>
         <?}
        }else{
           if(trim($obtencao)=="AT"){
            if(trim($ed37_c_tipo)=="NIVEL"){
             if(isset($conc) && $conc=="" && $ed60_c_situacao=="MATRICULADO"){?>
              <td class='aluno' align="center"><?=$ed42_c_abrev?> ainda não foi concluído.</td>
             <?}else{
              $result3 = $clconceito->sql_record($clconceito->sql_query("","ed39_c_conceito","ed39_i_sequencia","ed39_i_formaavaliacao = $ed43_i_formaavaliacao"));
              ?>
              <td class='aluno' align="center">
              <select name="ed73_c_valorconceito<?=$x?>" style="background:<?=$cordisabled?>;width:50px;height:15px;font-size:10px;text-align:center;padding:0px;" <?=trim($ed95_c_encerrado)=="S"?"onclick=\"alert('Aluno já possui avaliações encerradas para esta disciplina!')\"":"onchange=\"js_conceito(this.value,$ed73_i_codigo,'NIVEL');\""?> <?=trim($ed95_c_encerrado)=="S"?"disabled":$disabled?>>
               <option value=""></option>
               <?for($z=0;$z<$clconceito->numrows;$z++){
                 db_fieldsmemory($result3,$z);?>
                <option value="<?=trim($ed39_c_conceito)?>" <?=trim($ed39_c_conceito)==trim($ed73_c_valorconceito)?"selected":""?>><?=trim($ed39_c_conceito)?></option>
               <?}?>
              </select>
              <?}?>
             </td>
            <?}elseif(trim($ed37_c_tipo)=="PARECER"){
             if($cldiarioresultado->numrows>0){
              //db_fieldsmemory($result_ant,0);
             }
             if(isset($parec) && $parec==""){?>
              <td class='aluno' align="center"><?=$ed42_c_abrev?> ainda não foi concluído.</td>
             <?}else{
              if($ed57_c_aprovauto=="S"){
               $ed73_c_aprovmin = "S";
               $result = pg_query("update diarioresultado set ed73_c_aprovmin = 'S' where ed73_i_codigo = $ed73_i_codigo");
               $onchange = "";
              }else{
               $onchange = "onchange=\"js_aprovmin(this,$ed73_i_codigo,'$neeparecer')\"";
              }
              ?>
              <td class='aluno' align="center">
               <input name="ed73_t_parecer<?=$x?>" value="<?=@$ed73_t_parecer!=''?substr(@$ed73_t_parecer,0,20).'...':''?>" type="text" size="20" maxlength="20" style="background:<?=$cordisabled?>;height:14px;text-align:left;border: 1px solid #000000;font-size:11px;padding:0px;" onclick="js_parecer(this,<?=$ed73_i_codigo?>,<?=$ed73_i_procresultado?>,'<?=$ed42_c_descr?>','<?=$ed47_v_nome?>','<?=$ed95_c_encerrado?>',<?=$ed59_i_turma?>,<?=$ed47_i_codigo?>);" <?=trim($ed95_c_encerrado)=="S"?"readonly":$disabled?>>
               <select name="ed73_c_aprovmin" style="background:<?=$cordisabled?>;width:95px;height:17px;font-size:10px;text-align:center;padding:0px;" <?=trim($ed95_c_encerrado)=="S"?"onclick=\"alert('Aluno já possui avaliações encerradas para esta disciplina!')\"":$onchange?> <?=trim($ed95_c_encerrado)=="S"?"disabled":$disabled?>>
                <?if($ed57_c_aprovauto=="S"){?>
                 <option value="S" <?=$ed73_c_aprovmin=="S"?"selected":""?>>APROVADO</option>
                <?}else{?>
                 <option value="" <?=$ed73_c_aprovmin==""?"selected":""?>></option>
                 <option value="S" <?=$ed73_c_aprovmin=="S"?"selected":""?>>APROVADO</option>
                 <option value="N" <?=$ed73_c_aprovmin=="N"?"selected":""?>>REPROVADO</option>
                <?}?>
              </select>
              </td>
             <?}?>
            <?}elseif(trim($ed37_c_tipo)=="NOTA"){?>
             <?if($resultedu=="S"){?>
              <td class='aluno' align="center"><input name="ed73_i_valornota<?=$x?>" value="<?=@$ed73_i_valornota!=''?number_format($ed73_i_valornota,2,'.','.'):''?>" type="text" size="6" maxlength="6" style="background:<?=$cordisabled?>;width:45px;height:14px;border: 1px solid #000000;font-size:11px;text-align:right;padding:0px;" <?=trim($ed95_c_encerrado)=="S"?"onclick=\"alert('Aluno já possui avaliações encerradas para esta disciplina!')\"":"onChange=\"js_formatavalor(this,$ed37_i_variacao,$ed37_i_menorvalor,$ed37_i_maiorvalor,$ed73_i_codigo,'NOTA');\""?> <?=trim($ed95_c_encerrado)=="S"?"readonly":$disabled?>></td>
             <?}else{?>
              <td class='aluno' align="center"><input name="ed73_i_valornota<?=$x?>" value="<?=@$ed73_i_valornota!=''?number_format($ed73_i_valornota,0):''?>" type="text" size="6" maxlength="6" style="background:<?=$cordisabled?>;width:45px;height:14px;border: 1px solid #000000;font-size:11px;text-align:right;padding:0px;" <?=trim($ed95_c_encerrado)=="S"?"onclick=\"alert('Aluno já possui avaliações encerradas para esta disciplina!')\"":"onChange=\"js_formatavalor(this,$ed37_i_variacao,$ed37_i_menorvalor,$ed37_i_maiorvalor,$ed73_i_codigo,'NOTA');\""?> <?=trim($ed95_c_encerrado)=="S"?"readonly":$disabled?>></td>
             <?}?>
            <?}
           }else{
            $disabled = "disabled";
            ?><td class='aluno' align="center"><?
            $campo = trim($ed37_c_tipo)=="NIVEL"?"ed72_c_valorconceito":"ed72_i_valornota";
            $campo1 = trim($ed37_c_tipo)=="NIVEL"?"ed73_c_valorconceito":"ed73_i_valornota";
            $sql_r = "SELECT ed72_i_codigo as nada,ed09_c_abrev as abrev,$campo as tipocampo,ed72_c_amparo,ed41_i_procavalvinc as avalvinc,ed41_i_procresultvinc as resultvinc,ed44_i_peso
                      FROM diarioavaliacao
                       inner join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                       inner join periodoavaliacao on ed09_i_codigo = ed41_i_periodoavaliacao
                       left join avalcompoeres on ed44_i_procavaliacao = ed41_i_codigo
                      WHERE ed72_i_procavaliacao in ($avalcomp) AND ed72_i_diario = $ed73_i_diario
                      UNION
                      SELECT ed73_i_codigo as nada,ed42_c_abrev as abrev,$campo1 as tipocampo,ed73_c_amparo,case when ed73_i_codigo>0 then 0 end as avalvinc,case when ed73_i_diario>0 then 0 end as resultvinc,ed68_i_peso
                      FROM diarioresultado
                       inner join procresultado on ed43_i_codigo = ed73_i_procresultado
                       inner join resultado on ed42_i_codigo = ed43_i_resultado
                       left join rescompoeres on ed68_i_procresultcomp = ed43_i_codigo
                      WHERE ed73_i_procresultado in ($rescomp) AND ed73_i_diario = $ed73_i_diario
                     ";
            $result_verif = pg_query($sql_r);
            $linhas_verif = pg_num_rows($result_verif);
            $n_periodos = $linhas_verif;
            $n_amparos = $linhas_verif;
            //db_criatabela($result_verif);
            //exit;
            ?><table border="0" width="100%" cellspacing="1" cellpading="0"></tr><?
            $embranco = "";
            $qtdamparos = 0;
            $texto = "";
            $pesobranco = "";
            for($y=0;$y<$linhas_verif;$y++){
             db_fieldsmemory($result_verif,$y);
             if(trim($ed72_c_amparo)=="S"){
              $valor = "AMPARADO";
              $bgcolor = $cornao;
              $embranco .= "N";
              $n_periodos--;
              $qtdamparos++;
             }else{
              if($tipocampo==""){
               if($avalvinc!=0 || $resultvinc!=0){
                if($avalvinc!=0){
                 if(trim($ed60_c_situacao)!="MATRICULADO"){
                  $valor = trim(Situacao($ed60_c_situacao,$ed60_i_codigo));
                  $bgcolor = $cornao;
                  $embranco .= "S";
                 }elseif(VerAprovAvalAnt($avalvinc,$ed73_i_diario,"A")=="N"){
                  $valor = "EM BRANCO";
                  $bgcolor = $cornao;
                  $embranco .= VerAprovAvalAnt($avalvinc,$ed73_i_diario,"A")=="S"?"N":"S";
                 }elseif(VerAprovAvalAnt($avalvinc,$ed73_i_diario,"A")=="S"){
                  $valor = "DISPENSADO";
                  $bgcolor = $corsim;
                  $embranco .= VerAprovAvalAnt($avalvinc,$ed73_i_diario,"A")=="S"?"N":"S";
                 }
                }elseif($resultvinc!=0){
                 $embranco .= VerAprovAvalAnt($resultvinc,$ed73_i_diario,"R")=="N"?"S":"N";
                 if(trim($ed60_c_situacao)!="MATRICULADO"){
                  $valor = trim(Situacao($ed60_c_situacao,$ed60_i_codigo));
                  $bgcolor = $cornao;
                 }elseif(VerAprovAvalAnt($resultvinc,$ed73_i_diario,"R")=="N"){
                  $valor = "EM BRANCO";
                  $bgcolor = $cornao;
                 }elseif(VerAprovAvalAnt($resultvinc,$ed73_i_diario,"R")=="S"){
                  $valor = "DISPENSADO";
                  $bgcolor = $corsim;
                 }
                }
                $n_periodos--;
               }else{
                $valor = trim($ed60_c_situacao)!="MATRICULADO"?trim(Situacao($ed60_c_situacao,$ed60_i_codigo)):"EM BRANCO";
                $embranco .= $tipocampo==""?"S":"N";
                $bgcolor = $tipocampo==""||trim($ed60_c_situacao)!="MATRICULADO"?$cornao:$corsim;
                $n_periodos--;
               }
              }elseif($tipocampo!="" && trim($ed37_c_tipo)=="NOTA" && trim($ed60_c_situacao)=="MATRICULADO"){
               if($resultedu=="S"){
                $valor = number_format($tipocampo,2,".",".");
               }else{
                $valor = number_format($tipocampo,0);
               }
               $embranco .= $tipocampo==""?"S":"N";
               $bgcolor = $tipocampo==""||trim($ed60_c_situacao)!="MATRICULADO"?$cornao:$corsim;
              }elseif($tipocampo!="" && trim($ed37_c_tipo)=="NIVEL" && trim($ed60_c_situacao)=="MATRICULADO"){
               $embranco .= $tipocampo==""?"S":"N";
               $bgcolor = $tipocampo==""||trim($ed60_c_situacao)!="MATRICULADO"?$cornao:$corsim;
               $valor = $tipocampo;
              }else{
               $embranco .= $tipocampo==""?"S":"N";
               $bgcolor = $tipocampo==""||trim($ed60_c_situacao)!="MATRICULADO"?$cornao:$corsim;
               $valor = trim(Situacao($ed60_c_situacao,$ed60_i_codigo));
              }
             }
             if($obtencao=="MP" && $ed44_i_peso==0){
              $texto .= "<td align='center' width='75' class='alunopq' bgcolor='$cornao' style='border:1px solid #444444'>".$abrev."".($obtencao=="MP"?" - Peso: $ed44_i_peso":"")."<br><b>Peso Não Informado</b></td>";
              $pesobranco .= "S";
             }else{
              $texto .= "<td align='center' width='75' class='alunopq' bgcolor='$bgcolor' style='border:1px solid #444444'>".$abrev."".($obtencao=="MP"?" - Peso: $ed44_i_peso":"")."<br><b>".$valor."</b></td>";
             }
             $resultvinc = 0;
             $avalvinc = 0;
             $valor = "";
            }
            if($qtdamparos==$n_amparos){
             if($ed60_c_ativa=="S"){
              if($ed81_i_justificativa!=""){
               echo "<td class='aluno' align='center'>Amparo - Justificativa Legal n° $ed81_i_justificativa</td></tr></table></td>";
              }else{
               echo "<td class='aluno' align='center'>$ed250_c_abrev</td></tr></table></td>";
              }
             }else{
               echo "<td class='aluno' align='center'>&nbsp;</td></tr></table></td>";
             }
             db_inicio_transacao();
             $cldiarioresultado->ed73_c_amparo = "S";
             $cldiarioresultado->ed73_c_aprovmin = "S";
             $cldiarioresultado->ed73_c_valorconceito = null;
             $cldiarioresultado->ed73_i_valornota = null;
             $cldiarioresultado->ed73_i_codigo = $ed73_i_codigo;
             $cldiarioresultado->alterar($ed73_i_codigo);
             db_fim_transacao();
             $qtdamparos = 0;
             continue;
            }else{
             $cldiarioresultado->ed73_c_amparo = "N";
             echo $texto;
            }
            if(strstr($embranco,"S")){
             if($permitenotaembranco=="N"){
              $disabled = "disabled";
              $cordisabled = "#FFD5AA";
              ?>
              <td class='aluno' align="center"> <?=$formaobtencao?>: <br><input name="nulo" value="" type="text" size="6" maxlength="6" style="background:<?=$cordisabled?>;width:45px;height:14px;border: 1px solid #000000;padding:0px;" <?=$disabled?>></td>
              <?
              $embranco = "";
              db_inicio_transacao();
              $cldiarioresultado->ed73_c_amparo = "N";
              $cldiarioresultado->ed73_c_aprovmin = "N";
              $cldiarioresultado->ed73_c_valorconceito = null;
              $cldiarioresultado->ed73_i_valornota = null;
              $cldiarioresultado->ed73_i_codigo = $ed73_i_codigo;
              $cldiarioresultado->alterar($ed73_i_codigo);
              db_fim_transacao();
             }
            }else{
             $embranco = "S";
            }
            $resfinal = "";
            if(($permitenotaembranco=="S" || strstr($embranco,"S")) && !strstr($pesobranco,"S")){
             if(trim($ed37_c_tipo)=="NIVEL"){
              $result_conc = $clconceito->sql_record($clconceito->sql_query("","ed39_i_sequencia as regra","ed39_i_sequencia"," ed39_c_conceito = '$minimoaprov' AND ed39_i_formaavaliacao = $ed43_i_formaavaliacao"));
              db_fieldsmemory($result_conc,0);
              if(trim($obtencao)=="MC"){
               if($rescomp!=0){
                $sql_r = "SELECT b.ed39_i_sequencia,
                                 d.ed39_i_sequencia,
                                 case when b.ed39_i_sequencia>d.ed39_i_sequencia then b.ed39_i_sequencia else d.ed39_i_sequencia end as max
                         FROM diario
                          left join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                          left join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                          left join formaavaliacao as a on a.ed37_i_codigo = ed41_i_formaavaliacao
                          left join conceito as b on b.ed39_c_conceito = ed72_c_valorconceito
                          left join diarioresultado on ed73_i_diario = ed95_i_codigo
                          left join procresultado on ed43_i_codigo = ed73_i_procresultado
                          left join formaavaliacao as c on c.ed37_i_codigo = ed43_i_formaavaliacao
                          left join conceito as d on d.ed39_c_conceito = ed73_c_valorconceito
                         WHERE ed73_i_procresultado in ($rescomp)
                         AND ed72_i_procavaliacao in ($avalcomp)
                         AND ed95_i_codigo = $ed73_i_diario
                         AND ed72_c_amparo = 'N'
                        ";
                $result_maior = pg_query($sql_r);
               }else{
                $sql_r = "SELECT max(ed39_i_sequencia)
                         FROM diario
                          inner join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                          inner join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                          inner join formaavaliacao on ed37_i_codigo = ed41_i_formaavaliacao
                          inner join conceito on ed39_c_conceito = ed72_c_valorconceito
                         WHERE ed72_i_procavaliacao in ($avalcomp)
                         AND ed95_i_codigo = $ed73_i_diario
                         AND ed72_c_amparo = 'N'
                        ";
                $result_maior = pg_query($sql_r);;
               }
               db_fieldsmemory($result_maior,0);
               if($max!=""){
                $result_conc = $clconceito->sql_record($clconceito->sql_query("","ed39_c_conceito as maiorconceito","ed39_i_sequencia"," ed39_i_sequencia = $max AND ed39_i_formaavaliacao = $ed43_i_formaavaliacao"));
                db_fieldsmemory($result_conc,0);
               }else{
                $maiorconceito = "";
               }
               $resfinal = $maiorconceito;
              }elseif(trim($obtencao)=="UC"){
               $sql_r = "SELECT max(ed39_i_sequencia)
                        FROM diario
                         inner join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                         inner join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                         inner join formaavaliacao on ed37_i_codigo = ed41_i_formaavaliacao
                         inner join conceito on ed39_c_conceito = ed72_c_valorconceito
                        WHERE ed72_i_procavaliacao in ($ultima)
                        AND ed95_i_codigo = $ed73_i_diario
                        AND ed72_c_amparo = 'N'
                       ";
               $result_ultimo = pg_query($sql_r);
               db_fieldsmemory($result_ultimo,0);
               if($max!=""){
                $result_conc = $clconceito->sql_record($clconceito->sql_query("","ed39_c_conceito as maiorconceito","ed39_i_sequencia"," ed39_i_sequencia = $max AND ed39_i_formaavaliacao = $ed43_i_formaavaliacao"));
                db_fieldsmemory($result_conc,0);
               }else{
                $maiorconceito = "";
               }
               $resfinal = $maiorconceito;
              }
              $minimo = $max>=$regra?"S":"N";
              db_inicio_transacao();
              $cldiarioresultado->ed73_c_aprovmin = $minimo;
              $cldiarioresultado->ed73_c_valorconceito = $resfinal;
              $cldiarioresultado->ed73_i_valornota = null;
              $cldiarioresultado->ed73_i_codigo = $ed73_i_codigo;
              $cldiarioresultado->alterar($ed73_i_codigo);
              db_fim_transacao();
              ?>
              <td class='aluno' align="center"> <?=$formaobtencao?>: <br><input name="ed73_i_valorconceito" value="<?=$resfinal?>" type="text" size="6" maxlength="6" style="background:<?=$cordisabled?>;width:45px;height:14px;border: 1px solid #000000;font-size:11px;text-align:center;padding:0px;" readonly></td>
             <?}elseif(trim($ed37_c_tipo)=="NOTA"){
              $n_periodos = $n_periodos==0?1:$n_periodos;
              if(trim($obtencao)=="ME"){
               if($rescomp!=0 && $avalcomp!=0){
                $sql_r = "SELECT ((case when sum(ed72_i_valornota) is null then 0 else sum(ed72_i_valornota) end)+
                                 (case when sum(ed73_i_valornota) is null then 0 else sum(ed73_i_valornota) end))/$n_periodos as media
                          FROM diario
                           left join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                           left join diarioresultado on ed73_i_diario = ed95_i_codigo
                          WHERE ed73_i_procresultado in ($rescomp)
                          AND ed72_i_procavaliacao in ($avalcomp)
                          AND ed95_i_codigo = $ed73_i_diario
                          AND ed72_c_amparo = 'N'
                          AND (ed72_i_valornota is not null
                          OR ed73_i_valornota is not null)
                         ";
                $result_media = pg_query($sql_r);
               }elseif($rescomp!=0 && $avalcomp==0){
                $result_media = $cldiarioresultado->sql_record($cldiarioresultado->sql_query_file("","sum(ed73_i_valornota)/$n_periodos as media",""," ed73_i_procresultado in ($rescomp) AND ed73_i_diario = $ed73_i_diario "));
               }elseif($avalcomp!=0 && $rescomp==0){
                $result_media = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query_file("","sum(ed72_i_valornota)/$n_periodos as media",""," ed72_i_procavaliacao in ($avalcomp) AND ed72_i_diario = $ed73_i_diario AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null"));
               }
               db_fieldsmemory($result_media,0);
               if($media!=""){
                if($arredmedia=="S"){
                 if($resultedu=="S"){
                  $resfinal = number_format(round($media),2,".",".");
                 }else{
                  $resfinal = number_format(round($media),0);
                 }
                }else{
                 if($resultedu=="S"){
                  $resfinal = number_format($media,2,".",".");
                 }else{
                  $resfinal = number_format($media,0);
                 }
                }
               }
               $minimo = $resfinal>=$minimoaprov?"S":"N";
              }elseif(trim($obtencao)=="MP"){
               if($rescomp!=0 && $avalcomp!=0){
                $sql_r = "SELECT (
                                  (case when sum(ed72_i_valornota) is null
                                    then 0 else sum(ed72_i_valornota) end) +
                                  (case when sum(ed73_i_valornota) is null
                                    then 0 else sum(ed73_i_valornota) end))/sum(ed44_i_peso+ed68_i_peso) as media
                          FROM diario
                           left join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                           left join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                           left join avalcompoeres on ed44_i_procavaliacao = ed41_i_codigo
                           left join diarioresultado on ed73_i_diario = ed95_i_codigo
                           left join procresultado on ed43_i_codigo = ed73_i_procresultado
                           left join rescompoeres on ed68_i_procresultcomp = ed43_i_codigo
                          WHERE ed73_i_procresultado in ($rescomp)
                          AND ed72_i_procavaliacao in ($avalcomp)
                          AND ed95_i_codigo = $ed73_i_diario
                          AND ed72_c_amparo = 'N'
                          AND (ed72_i_valornota is not null
                          OR ed73_i_valornota is not null)
                         ";
                $result_media = pg_query($sql_r);
               }elseif($rescomp!=0 && $avalcomp==0){
                $sql_r = "SELECT sum(ed73_i_valornota*ed68_i_peso)/sum(ed44_i_peso)
                          FROM diario
                           left join diarioresultado on ed73_i_diario = ed95_i_codigo
                           left join procresultado on ed43_i_codigo = ed73_i_procresultado
                           left join rescompoeres on ed68_i_procresultcomp = ed43_i_codigo
                          WHERE ed73_i_procresultado in ($rescomp)
                          AND ed73_i_diario = $ed73_i_diario
                          AND ed73_i_valornota is not null
                         ";
                $result_media = pg_query($sql_r);
               }elseif($avalcomp!=0 && $rescomp==0){
                $sql_r = "SELECT sum(ed72_i_valornota*ed44_i_peso)/sum(ed44_i_peso) as media
                          FROM diario
                           left join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                           left join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                           left join avalcompoeres on ed44_i_procavaliacao = ed41_i_codigo
                          WHERE ed72_i_procavaliacao in ($avalcomp)
                          AND ed72_i_diario = $ed73_i_diario
                          AND ed72_c_amparo = 'N'
                          AND ed72_i_valornota is not null
                         ";
                $result_media = pg_query($sql_r);
               }
               db_fieldsmemory($result_media,0);
               if($media!=""){
                if($arredmedia=="S"){
                 if($resultedu=="S"){
                  $resfinal = number_format(round($media),2,".",".");
                 }else{
                  $resfinal = number_format(round($media),0);
                 }
                }else{
                 if($resultedu=="S"){
                  $resfinal = number_format($media,2,".",".");
                 }else{
                  $resfinal = number_format($media,0);
                 }
                }
               }
               $minimo = $resfinal>=$minimoaprov?"S":"N";
               //$resfinal = $resfinal==0.00?"":number_format($media,0);
              }elseif(trim($obtencao)=="SO"){
               if($rescomp!=0 && $avalcomp!=0){
                $sql_r = "SELECT ((case when sum(ed72_i_valornota) is null then 0 else sum(ed72_i_valornota) end)+
                                 (case when sum(ed73_i_valornota) is null then 0 else sum(ed73_i_valornota) end)) as soma,
                                 (select sum(to_number(ed37_c_minimoaprov,999)) as somaminimo
                                  from formaavaliacao
                                   inner join procresultado on ed43_i_formaavaliacao = ed37_i_codigo
                                   inner join diarioresultado on ed73_i_procresultado = ed43_i_codigo
                                  where ed73_i_procresultado in ($rescomp)
                                  and ed73_c_amparo = 'N')
                          FROM diario
                           left join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                           left join procavaliacao on ed41_i_codigo = ed72_i_procavaliacao
                           left join formaavaliacao as formadaval on formadaval.ed37_i_codigo = ed41_i_formaavaliacao
                           left join diarioresultado on ed73_i_diario = ed95_i_codigo
                           left join procresultado on ed43_i_codigo = ed73_i_procresultado
                           left join formaavaliacao on formaavaliacao.ed37_i_codigo = ed43_i_formaavaliacao
                          WHERE ed73_i_procresultado in ($rescomp)
                          AND ed72_i_procavaliacao in ($avalcomp)
                          AND ed95_i_codigo = $ed73_i_diario
                          AND ed72_c_amparo = 'N'
                          AND (ed72_i_valornota is not null
                          OR ed73_i_valornota is not null)
                        ";
                $result_soma = pg_query($sql_r);
               }elseif($rescomp!=0 && $avalcomp==0){
                $result_soma = $cldiarioresultado->sql_record($cldiarioresultado->sql_query("","sum(ed73_i_valornota) as soma,(select sum(ed37_i_maiorvalor) from formaavaliacao inner join procresultado on ed43_i_formaavaliacao = ed37_i_codigo inner join diarioresultado on ed73_i_procresultado = ed43_i_codigo where ed73_i_procresultado in ($rescomp) and ed73_c_amparo = 'N' AND ed73_i_diario = $ed73_i_diario) as somaminimo",""," ed73_i_procresultado in ($rescomp) AND ed73_i_diario = $ed73_i_diario"));
               }elseif($avalcomp!=0 && $rescomp==0){
                $result_soma = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","sum(ed72_i_valornota) as soma,sum(to_number(ed37_c_minimoaprov,999)) as somaminimo",""," ed72_i_procavaliacao in ($avalcomp) AND ed72_i_diario = $ed73_i_diario AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null"));
               }
               db_fieldsmemory($result_soma,0);
               if($soma!=""){
                if($arredmedia=="S"){
                 if($resultedu=="S"){
                  $resfinal = number_format(round($soma),2,".",".");
                 }else{
                  $resfinal = number_format(round($soma),0);
                 }
                }else{
                 if($resultedu=="S"){
                  $resfinal = number_format($soma,2,".",".");
                 }else{
                  $resfinal = number_format($soma,0);
                 }
                }
               }
               $minimo = $resfinal>=$minimoaprov?"S":"N";
              }elseif(trim($obtencao)=="MN"){
               if($rescomp!=0 && $avalcomp!=""){
                $sql_r = "SELECT case when max(ed73_i_valornota) is null then 0 else max(ed73_i_valornota) end as result,
                                 case when max(ed72_i_valornota) is null then 0 else max(ed72_i_valornota) end as avalia,
                                 case
                                  when (case when max(ed73_i_valornota) is null then 0 else max(ed73_i_valornota) end) > (case when max(ed72_i_valornota) is null then 0 else max(ed72_i_valornota) end)
                                  then (case when max(ed73_i_valornota) is null then 0 else max(ed73_i_valornota) end)
                                  else (case when max(ed72_i_valornota) is null then 0 else max(ed72_i_valornota) end)
                                 end as maiornota
                         FROM diario
                          left join diarioavaliacao on ed72_i_diario = ed95_i_codigo
                          left join diarioresultado on ed73_i_diario = ed95_i_codigo
                         WHERE (ed73_i_procresultado in ($rescomp)
                         AND ed72_i_procavaliacao in ($avalcomp))
                         AND ed95_i_codigo = $ed73_i_diario
                         AND ed72_c_amparo = 'N'
                         AND (ed72_i_valornota is not null
                          OR ed73_i_valornota is not null)
                        ";
                $result_maior = pg_query($sql_r);
               }elseif($rescomp!=0 && $avalcomp==0){
                $result_maior = $cldiarioresultado->sql_record($cldiarioresultado->sql_query_file("","max(ed73_i_valornota) as maiornota",""," ed73_i_procresultado in ($rescomp) AND ed73_i_diario = $ed73_i_diario"));
               }elseif($avalcomp!=0 && $rescomp==0){
                $result_maior = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query_file("","max(ed72_i_valornota) as maiornota",""," ed72_i_procavaliacao in ($avalcomp) AND ed72_i_diario = $ed73_i_diario AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null"));
               }
               db_fieldsmemory($result_maior,0);
               if($maiornota!=""){
                if($arredmedia=="S"){
                 if($resultedu=="S"){
                  $resfinal = number_format(round($maiornota),2,".",".");
                 }else{
                  $resfinal = number_format(round($maiornota),0);
                 }
                }else{
                 if($resultedu=="S"){
                  $resfinal = number_format($maiornota,2,".",".");
                 }else{
                  $resfinal = number_format($maiornota,0);
                 }
                }
               }
               $minimo = $resfinal>=$minimoaprov?"S":"N";
              }elseif(trim($obtencao)=="UN"){
               if($tipoultima=="R"){
                $result_ultima = $cldiarioresultado->sql_record($cldiarioresultado->sql_query_file("","ed73_i_valornota as ultimanota",""," ed73_i_procresultado in ($ultima) AND ed73_i_diario = $ed73_i_diario"));
               }elseif($tipoultima=="A"){
                $result_ultima = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query_file("","ed72_c_amparo as ultamparo,ed72_i_valornota as ultimanota",""," ed72_i_procavaliacao in ($ultima) AND ed72_i_diario = $ed73_i_diario"));
               }
               db_fieldsmemory($result_ultima,0);
               if($ultimanota!=""){
                if($arredmedia=="S"){
                 if($resultedu=="S"){
                  $resfinal = number_format(round($ultimanota),2,".",".");
                 }else{
                  $resfinal = number_format(round($ultimanota),0);
                 }
                }else{
                 if($resultedu=="S"){
                  $resfinal = number_format($ultimanota,2,".",".");
                 }else{
                  $resfinal = number_format($ultimanota,0);
                 }
                }
               }
               if(trim($ed72_c_amparo=="S")){
                $minimo = "S";
                $resfinal = null;
                $cordisabled = "#DEB887";
                $sql_todo = "UPDATE amparo SET ed81_c_todoperiodo = 'S' where ed81_i_diario = $ed73_i_diario";
                $query_todo = pg_query($sql_todo);
               }else{
                $minimo = $resfinal>=$minimoaprov?"S":"N";
               }
              }
              $resfinal = trim($ed60_c_situacao)!="MATRICULADO"?"":$resfinal;
              db_inicio_transacao();
              $cldiarioresultado->ed73_c_amparo = "N";
              $cldiarioresultado->ed73_c_aprovmin = $minimo;
              $cldiarioresultado->ed73_c_valorconceito = null;
              $cldiarioresultado->ed73_i_valornota = $resfinal;
              $cldiarioresultado->ed73_i_codigo = $ed73_i_codigo;
              $cldiarioresultado->alterar($ed73_i_codigo);
              db_fim_transacao();
              ?>
              <td class='aluno' align="center"> <?=$formaobtencao?>: <br><input name="ed73_i_valornota" value="<?=$resfinal?>" type="text" size="6" maxlength="6" style="background:<?=$cordisabled?>;width:45px;height:14px;border: 1px solid #000000;font-size:11px;text-align:right;padding:0px;" readonly></td>
             <?
             }
            }
            $cordisabled = "#FFFFFF"?>
            </tr></table>
            </td>
           <?
           }
         //}
       }
      }?>
      </tr>
      <?
      if($ed60_c_parecer=="S"){
       $obtencao = $obtencao_ant;
      }
     }
    }else{?>
     <td colspan="3" class='aluno' align="center">NENHUM ALUNO MATRICULADO NESTA TURMA.</td>
    <?}?>
   </table>
  </td>
 </tr>
</table>
</form>
</body>
</html>
<?
if(isset($aprovminimo) && !isset($neeparecer)){
 ?>
 <script>
  js_OpenJanelaIframe('','db_iframe_outrasdisc','func_outrasdisc.php?regencia=<?=$regencia?>&ed43_i_codigo=<?=$ed43_i_codigo?>&codigo=<?=$codigo?>&valor=<?=$valoralterado?>','Informar este resultado para outras disciplinas',true);
 </script>
 <?
}
function VerAprovAvalAnt($aval,$diario,$tipo){
 $campo = $tipo=="A"?"ed72_c_aprovmin":"ed73_c_aprovmin";
 $avaliacao = $tipo=="A"?"ed72_i_procavaliacao":"ed73_i_procresultado";
 $where = $tipo=="A"?"ed72_i_diario":"ed73_i_diario";
 $tabela = $tipo=="A"?"diarioavaliacao":"diarioresultado";
 $sql = "SELECT $campo FROM $tabela WHERE $where = $diario AND $avaliacao = $aval";
 $result = pg_query($sql);
 //db_criatabela($result);
 return pg_result($result,0,$campo);
}
?>
<script>
parent.iframe_RF.location.href = "edu1_diariofinal001.php?regencia=<?=$regencia?>";
function js_formatavalor(campo,variacao,menor,maior,codigo,tipo){
 if(campo.value!=""){
  valor = campo.value.replace(",",".");
  var expre = new RegExp("[^0-9\.]+");
  if(!valor.match(expre)){
   if(valor<menor || valor>maior){
    alert("Nota deve ser entre "+menor+" e "+maior+"!");
    campo.value = "";
    campo.focus();
   }else{
    if((valor % variacao)==0){
     var expr = new RegExp("[^0-9]+");
     if(valor.match(expr)){
      campo.value = valor;
      adiante = valor;
     }else{
      campo.value = js_cent(valor);
      adiante = js_cent(valor);
     }
     location.href = "edu1_diarioresultado001.php?regencia=<?=$regencia?>&ed43_i_codigo=<?=$ed43_i_codigo?>&tipo="+tipo+"&codigo="+codigo+"&valor="+adiante+"&alterar";
    }else{
     alert("Intervalos da Nota devem ser de "+js_cent(variacao)+"");
     campo.value = "";
     campo.focus();
    }
   }
  }else{
   alert("Nota deve ser um número!");
   campo.value = "";
   campo.focus();
  }
 }else{
  location.href = "edu1_diarioresultado001.php?regencia=<?=$regencia?>&ed43_i_codigo=<?=$ed43_i_codigo?>&tipo="+tipo+"&codigo="+codigo+"&valor="+campo.value+"&alterar";
 }
}
function js_conceito(valor,codigo,tipo){
 location.href = "edu1_diarioresultado001.php?regencia=<?=$regencia?>&ed43_i_codigo=<?=$ed43_i_codigo?>&tipo="+tipo+"&codigo="+codigo+"&valor="+valor+"&alterar";
}
function js_aprovmin(campo,codigo,neeparecer){
 location.href = "edu1_diarioresultado001.php?regencia=<?=$regencia?>&ed43_i_codigo=<?=$ed43_i_codigo?>&codigo="+codigo+"&valor="+campo.value+"&neeparecer="+neeparecer+"&aprovminimo";
}
function js_parecer(campo,codigo,resultado,periodo,aluno,encerrado,turma,codaluno){
 js_OpenJanelaIframe('','db_iframe_parecer','edu1_parecerresult001.php?regencia=<?=$regencia?>&ed43_i_codigo='+resultado+'&ed63_i_diarioresultado='+codigo+'&campo='+campo.name+'&periodo='+periodo+'&aluno='+aluno+'&encerrado='+encerrado+'&turma='+turma+'&codaluno='+codaluno,'Parecer',true,0,0,screen.availWidth-50,screen.availHeight);
}
function js_movimentos(matricula){
 js_OpenJanelaIframe('','db_iframe_movimentos','edu1_matricula005.php?matricula='+matricula,'Movimentação da Matrícula',true,0,0,screen.availWidth-50,screen.availHeight);
}
</script>
