<?
require("libs/db_stdlibwebseller.php");
include("fpdf151/pdfwebseller.php");
include("classes/db_matricula_classe.php");
include("classes/db_regencia_classe.php");
include("classes/db_escola_classe.php");
include("classes/db_regenteconselho_classe.php");
include("classes/db_diarioavaliacao_classe.php");
include("classes/db_procavaliacao_classe.php");
include("classes/db_procresultado_classe.php");
include("classes/db_pareceraval_classe.php");
include("classes/db_aprovconselho_classe.php");
include("classes/db_trocaserie_classe.php");
include("classes/db_periodocalendario_classe.php");
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$permitenotaembranco = VerParametroNota(db_getsession("DB_coddepto"));
$clmatricula = new cl_matricula;
$clregencia = new cl_regencia;
$clescola = new cl_escola;
$clregenteconselho = new cl_regenteconselho;
$cldiarioavaliacao = new cl_diarioavaliacao;
$clprocavaliacao = new cl_procavaliacao;
$clprocresultado = new cl_procresultado;
$clpareceraval = new cl_pareceraval;
$claprovconselho = new cl_aprovconselho;
$cltrocaserie = new cl_trocaserie;
$clperiodocalendario = new cl_periodocalendario;
$escola = db_getsession("DB_coddepto");
$discglob = false;
$result = $clmatricula->sql_record($clmatricula->sql_query("","*","ed60_i_numaluno,to_ascii(ed47_v_nome)"," ed60_i_codigo in ($alunos) AND ed60_i_turma = $turma"));
if($clmatricula->numrows==0){?>
 <table width='100%'>
  <tr>
   <td align='center'>
    <font color='#FF0000' face='arial'>
     <b>Nenhuma matrícula para a turma selecionada<br>
     <input type='button' value='Fechar' onclick='window.close()'></b>
    </font>
   </td>
  </tr>
 </table>
 <?
 exit;
}

$ed57_i_procedimento = pg_result($result,0,'ed57_i_procedimento');
$result_max = $clprocavaliacao->sql_record($clprocavaliacao->sql_query("","max(ed41_i_sequencia) as ultimoperiodo",""," ed41_i_procedimento = $ed57_i_procedimento AND ed09_c_somach = 'S'"));
db_fieldsmemory($result_max,0);
$sql2 = "SELECT ed41_i_codigo,
                ed09_c_abrev,
                ed09_c_descr,
                ed09_i_codigo,
                ed41_i_sequencia,
                case
                 when ed41_i_codigo>0 then 'A' end as tipo,
                case
                 when ed41_i_codigo>0 then '' end as arredmedia,
                ed37_c_tipo,
                ed37_c_minimoaprov
         FROM procavaliacao
          inner join periodoavaliacao on periodoavaliacao.ed09_i_codigo = procavaliacao.ed41_i_periodoavaliacao
          inner join formaavaliacao on formaavaliacao.ed37_i_codigo = procavaliacao.ed41_i_formaavaliacao
         WHERE ed41_i_procedimento = $ed57_i_procedimento
         AND ed41_c_boletim = 'S'
         UNION
         SELECT ed43_i_codigo,
                ed42_c_abrev,
                ed42_c_descr,
                ed42_i_codigo,
                ed43_i_sequencia,
                case
                 when ed43_i_codigo>0 then 'R' end as tipo,
                case
                 when ed43_i_codigo>0 then ed43_c_arredmedia end as arredmedia,
                ed37_c_tipo,
                ed37_c_minimoaprov
         FROM procresultado
          inner join resultado on resultado.ed42_i_codigo = procresultado.ed43_i_resultado
          inner join formaavaliacao on formaavaliacao.ed37_i_codigo = procresultado.ed43_i_formaavaliacao
         WHERE ed43_i_procedimento = $ed57_i_procedimento
         AND ed43_c_boletim = 'S'
         ORDER BY ed41_i_sequencia
        ";
$result2 = pg_query($sql2);
$linhas2 = pg_num_rows($result2);
if($linhas2==0){?>
 <table width='100%'>
  <tr>
   <td align='center'>
    <font color='#FF0000' face='arial'>
     <b>Nenhum resultado cadastrado no procedimento de avaliação desta turma<br>
	 ou nenhum periodo de avaliação está marcado para aparecer no Boletim<br>
	 (Cadastros -> Procedimentos de Avaliação)<br>
     <input type='button' value='Fechar' onclick='window.close()'></b>
    </font>
   </td>
  </tr>
 </table>
 <?
 exit;
}
$result_per = $clprocavaliacao->sql_record($clprocavaliacao->sql_query("","ed09_i_codigo,ed09_c_descr,ed41_i_sequencia as seqatual",""," ed41_i_codigo = $periodo"));
db_fieldsmemory($result_per,0);
function SomaFaltas($codigo,$diario,$regencia,$tipo){
 $sql = "SELECT sum(ed72_i_numfaltas) as faltas,
                sum(ed78_i_aulasdadas) as aulas,
                sum(ed80_i_numfaltas) as abonos
         FROM diarioavaliacao
          inner join avalfreqres on ed67_i_procavaliacao = ed72_i_procavaliacao
          inner join regenciaperiodo on ed78_i_procavaliacao = ed72_i_procavaliacao
          left join abonofalta on ed80_i_diarioavaliacao = ed72_i_codigo
         WHERE ed67_i_procresultado = $codigo
         AND ed78_i_regencia = $regencia
         AND ed72_i_diario = $diario
         AND ed72_c_amparo = 'N'
        ";
 $result5 = pg_query($sql);
 $linhas5 = pg_num_rows($result5);
 if($linhas5>0){
  $faltas = pg_result($result5,0,'faltas')==""?0:pg_result($result5,0,'faltas');
  $aulas = pg_result($result5,0,'aulas')==""?0:pg_result($result5,0,'aulas');
  $abonos = pg_result($result5,0,'abonos')==""?0:pg_result($result5,0,'abonos');
  if($aulas==0){
   $perc_presenca = 0;
  }else{
   $presenca = $aulas-$faltas+$abonos;
   $perc_presenca = $presenca==0?1:$presenca/$aulas;
  }
  if($tipo=="P"){
   return ($perc_presenca*100);
  }else{
   return ($faltas);
  }
 }else{
  return 100;
 }
}
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
for($x=0;$x<$clmatricula->numrows;$x++){
 db_fieldsmemory($result,$x);
 $pdf->setfillcolor(223);
 $obs2 = "";
 $result5 = $clregenteconselho->sql_record($clregenteconselho->sql_query("","z01_nome as regente",""," ed235_i_turma = $ed60_i_turma"));
 if($clregenteconselho->numrows>0){
  db_fieldsmemory($result5,0);
 }else{
  $regente = "";
 }
 $head1 = "BOLETIM DE DESEMPENHO";
 $head2 = "Nome: $ed47_v_nome";
 $head3 = "Curso: $ed29_i_codigo - $ed29_c_descr";
 $head4 = "Código Aluno: $ed47_i_codigo";
 $head5 = "Matrícula: $ed60_i_codigo";
 $head6 = "Série: $ed11_c_descr Ano: $ed52_i_ano";
 $head7 = "Turma: $ed57_c_descr";
 $situacao = trim($ed60_c_concluida)=="S"?"CONCLUÍDO":Situacao($ed60_c_situacao,$ed60_i_codigo);
 $head8 = "Situação: $situacao";
 $head9 = "Regente: $regente";
 $pdf->addpage('L');
 $pdf->ln(5);
 if($grade=="yes"){
  $result_gr = $clprocresultado->sql_record($clprocresultado->sql_query_file("","ed43_i_codigo as codprocgeraresultado,ed43_c_obtencao as obtencao,ed43_c_minimoaprov as minimoaprovres",""," ed43_i_procedimento = $ed57_i_procedimento AND ed43_c_geraresultado = 'S'"));
  if($clprocresultado->numrows>0){
   db_fieldsmemory($result_gr,0);
  }else{
   $codprocgeraresultado = 0;
   $obtencao = "";
   $minimoaprovres = 0;
  }
  $pdf->setfont('arial','b',7);
  $pdf->cell(60,4,"",1,0,"C",0);
  $cont = 0;
  for($y=0;$y<$linhas2;$y++){
   db_fieldsmemory($result2,$y);
   $pdf->cell(19,4,$ed09_c_abrev,1,0,"C",0);
   $cont++;
   $codperiodos[] = $ed41_i_codigo;
   $tipoaval[] = $tipo;
   $formaaval[] = $ed37_c_tipo;
   $minimo_aprov[] = $ed37_c_minimoaprov;
   $codpercalend[] = $ed09_i_codigo;
  }
  if($permitenotaembranco=="S"){
   $pdf->cell(19,4,"Nota Parcial",1,0,"C",0);
   $cont++;
  }
  for($y=$cont;$y<9;$y++){
   $pdf->cell(19,4,"",1,0,"C",0);
  }
  if($ultimoperiodo==$seqatual){
   $pdf->cell(19,4,"Total Faltas",1,0,"C",0);
  }else{
   $pdf->cell(19,4,"",1,0,"C",0);
  }
  $pdf->cell(15,4,"Frequencia",1,0,"C",0);
  $pdf->cell(15,4,"Res. Final",1,1,"C",0);
  $pdf->cell(60,4,"Disciplinas",1,0,"C",0);
  $cont = 0;
  for($y=0;$y<$linhas2;$y++){
   db_fieldsmemory($result2,$y);
   $pdf->cell(14,4,$ed37_c_tipo,1,0,"C",0);
   $pdf->cell(5,4,$tipo=="A"?"Ft":"",1,0,"C",0);
   $cont++;
  }
  if($permitenotaembranco=="S"){
   $pdf->cell(19,4,"",1,0,"C",0);
   $cont++;
  }
  for($y=$cont;$y<9;$y++){
   $pdf->cell(14,4,"",1,0,"C",0);
   $pdf->cell(5,4,"",1,0,"C",0);
  }
  if($ultimoperiodo==$seqatual){
   $pdf->cell(19,4,"",1,0,"C",0);
  }else{
   $pdf->cell(19,4,"",1,0,"C",0);
  }
  $pdf->cell(15,4,"% Freq",1,0,"C",0);
  $pdf->cell(10,4,substr($ed37_c_tipo,0,5),1,0,"C",0);
  $pdf->cell(5,4,"RF",1,1,"C",0);
  $cont4 = 0;
  $result3 = $clregencia->sql_record($clregencia->sql_query("","ed59_i_codigo as codregencia,ed232_c_descr as discregencia,ed59_c_freqglob as tipofreq,ed89_i_disciplina as codregglob","ed232_c_descr"," ed59_i_turma = $ed57_i_codigo AND ed59_c_condicao = 'OB'"));
  $linhas3 = $clregencia->numrows;
  for($z=0;$z<$linhas3;$z++){
   $cont4++;
   db_fieldsmemory($result3,$z);
   if(trim($ed37_c_tipo)=="NOTA"){
    $campoaval = "ed72_i_valornota is null";
   }elseif(trim($ed37_c_tipo)=="NIVEL"){
    $campoaval = "ed72_c_valorconceito = ''";
   }elseif(trim($ed37_c_tipo)=="PARECER"){
    $campoaval = "ed72_t_parecer = '' ";
   }
   $result33 = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed72_i_codigo","ed41_i_sequencia"," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $codregencia AND $campoaval AND ed72_c_amparo = 'N' AND ed09_c_somach = 'S'  AND ed37_c_tipo = '$ed37_c_tipo'"));
   $linhas33 = $cldiarioavaliacao->numrows;
   if($codregglob!=""){
    $result10 = $clregencia->sql_record($clregencia->sql_query(""," ed59_i_codigo as codregglob",""," ed12_i_codigo = $codregglob AND ed59_i_turma = $ed57_i_codigo"));
    db_fieldsmemory($result10,0);
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(60,4,$discregencia,1,0,"L",0);
   $qtd_per = count($codperiodos);
   $cont3 = 0;
   for($c=0;$c<$qtd_per;$c++){
    if($ed60_c_parecer=="S"){
     $formaaval[$c] = "PARECER";
     $ed37_c_tipo = "PARECER";
    }
    if(trim($tipofreq)=="F" && $tipoaval[$c]=="R"){
     $pdf->cell(14,4,"",1,0,"C",0);
     $pdf->cell(5,4,"",1,0,"C",0);
    }else{
     if($tipoaval[$c]=="R"){
      if(trim($formaaval[$c])=="PARECER"){
       $campos = "ed73_t_parecer as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo,ed73_i_diario as codiario";
      }elseif(trim($formaaval[$c])=="NOTA"){
       if($resultedu=='S'){
        $campos = "to_char(ed73_i_valornota,'999.99') as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo,ed73_i_diario as codiario";
       }else{
        $campos = "to_char(ed73_i_valornota,'999') as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo,ed73_i_diario as codiario";
       }
      }else{
       $campos = "ed73_c_valorconceito as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo,ed73_i_diario as codiario";
      }
      $tabela = "diarioresultado";
      $ligacao = "ed73_i_diario";
      $where = "ed73_i_procresultado";
      $qual = "R";
      //if($permitenotaembranco=="S" && $linhas33>0){
       //$codperiodos[$c] = 0;
      // }
     }else{
      if(trim($formaaval[$c])=="PARECER"){
       $campos = "ed72_i_numfaltas,ed72_t_parecer as aprov,ed72_c_amparo,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed72_i_diario as codiario";
      }elseif(trim($formaaval[$c])=="NOTA"){
       if($resultedu=='S'){
        $campos = "ed72_i_numfaltas,to_char(ed72_i_valornota,'999.99') as aprov,ed72_c_amparo,ed72_t_parecer,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed72_i_diario as codiario";
       }else{
        $campos = "ed72_i_numfaltas,to_char(ed72_i_valornota,'999') as aprov,ed72_c_amparo,ed72_t_parecer,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed72_i_diario as codiario";
       }
      }else{
       $campos = "ed72_i_numfaltas,ed72_c_valorconceito as aprov,ed72_c_amparo,ed72_t_parecer,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed72_i_diario as codiario";
      }
      $tabela = "diarioavaliacao";
      $ligacao = "ed72_i_diario";
      $where = "ed72_i_procavaliacao";
      $qual = "A";
     }
     $sql4 = "SELECT $campos
              FROM $tabela
               inner join diario on ed95_i_codigo = $ligacao
               left join amparo on ed81_i_diario = ed95_i_codigo
               left join convencaoamp on ed250_i_codigo = ed81_i_convencaoamp
              WHERE ed95_i_aluno = $ed60_i_aluno
              AND ed95_i_regencia = $codregencia
              AND $where = ".$codperiodos[$c]."
            ";
     $result4 = pg_query($sql4);
     //db_criatabela($result4);exit;
     $linhas4 = pg_num_rows($result4);
     if($linhas4>0){
      db_fieldsmemory($result4,0);
      if($qual=="A" && trim($ed72_c_amparo)=="S"){
       if($ed81_i_justificativa!=""){
        $aprov = "Amparado";
       }else{
        $aprov = $ed250_c_abrev;
       }
      }elseif($qual=="R" && trim($ed73_c_amparo)=="S"){
       if($ed81_i_justificativa!=""){
        $aprov = "Amparado";
       }else{
        $aprov = $ed250_c_abrev;
       }
      }elseif(trim($formaaval[$c])=="PARECER"){
       $aprov = $aprov!=""?"Parecer":"";
      }
      if($qual=="R"){
       $ed72_i_numfaltas = "";
      }elseif($ed72_i_numfaltas=="" && $aprov=="" && $tipofreq=="F"){
       $ed72_i_numfaltas = 0;
      }elseif($ed72_i_numfaltas=="" && $aprov=="" && $tipofreq!="F"){
       $ed72_i_numfaltas = "";
      }elseif($ed72_i_numfaltas=="" && $aprov!=""){
       $ed72_i_numfaltas = 0;
      }elseif($ed72_i_numfaltas!=""){
       $ed72_i_numfaltas = $ed72_i_numfaltas;
      }
      if($codregglob!=""){
       if($codregglob==$codregencia && $tipofreq=="F"){
        $aprov = "-";
        $ed72_i_numfaltas = $ed72_i_numfaltas;
       }elseif($codregglob==$codregencia && $tipofreq=="FA"){
        $aprov = $aprov;
        $ed72_i_numfaltas = $ed72_i_numfaltas;
       }else{
        $aprov = $aprov;
        $ed72_i_numfaltas = "-";
       }
      }
      if($ed60_c_situacao=="AVANÇADO" || $ed60_c_situacao=="CLASSIFICADO"){
       $result10 = $cltrocaserie->sql_record($cltrocaserie->sql_query("","ed101_d_data",""," ed101_i_aluno = $ed60_i_aluno AND ed101_i_turmaorig = $ed60_i_turma"));
       db_fieldsmemory($result10,0);
       $result11 = $clperiodocalendario->sql_record($clperiodocalendario->sql_query("","ed53_d_inicio,ed53_d_fim",""," ed53_i_periodoavaliacao = $codpercalend[$c] AND ed53_i_calendario = $ed57_i_calendario"));
       if($clperiodocalendario->numrows>0){
        db_fieldsmemory($result11,0);
        if($ed101_d_data>=$ed53_d_inicio && $ed101_d_data<=$ed53_d_fim){
         $aprov = substr($ed60_c_situacao,0,5);
         $ed72_i_numfaltas = "";
        }
       }
      }
      $pdf->setfont('arial','',10);
      if(trim($formaaval[$c])=="NOTA" && $aprov<$minimo_aprov[$c]){
       $pdf->setfont('arial','b',10);
       $pdf->cell(14,4,$aprov,1,0,"C",0);
       $pdf->setfont('arial','',10);
      }else{
       if( $aprov == "Amparo" || $aprov == "Amparado" || $aprov == "Parecer"){
        $pdf->setfont('arial','',7);
       }
       $pdf->cell(14,4,$aprov,1,0,"C",0);
       $pdf->setfont('arial','',10);
      }
      $pdf->cell(5,4,$ed72_i_numfaltas==0||$ed72_i_numfaltas==""?"":$ed72_i_numfaltas,1,0,"C",0);
      @$aprov = "";
      @$ed72_i_numfaltas = "";
     }else{
      if($ed60_c_situacao=="AVANÇADO" || $ed60_c_situacao=="CLASSIFICADO"){
       $result10 = $cltrocaserie->sql_record($cltrocaserie->sql_query("","ed101_d_data",""," ed101_i_aluno = $ed60_i_aluno AND ed101_i_turmaorig = $ed60_i_turma"));
       db_fieldsmemory($result10,0);
       $result11 = $clperiodocalendario->sql_record($clperiodocalendario->sql_query("","ed53_d_inicio,ed53_d_fim",""," ed53_i_periodoavaliacao = $codpercalend[$c] AND ed53_i_calendario = $ed57_i_calendario"));
       if($clperiodocalendario->numrows>0){
        db_fieldsmemory($result11,0);
        if($ed101_d_data>=$ed53_d_inicio && $ed101_d_data<=$ed53_d_fim){
         $aprov = substr($ed60_c_situacao,0,5);
         $ed72_i_numfaltas = "";
         $pdf->cell(14,4,$aprov,1,0,"C",0);
         $pdf->cell(5,4,$ed72_i_numfaltas,1,0,"C",0);
        }else{
         $pdf->cell(14,4,"",1,0,"C",0);
         $pdf->cell(5,4,"",1,0,"C",0);
        }
       }else{
        $pdf->cell(14,4,"",1,0,"C",0);
        $pdf->cell(5,4,"",1,0,"C",0);
       }
      }else{
       $pdf->cell(14,4,"",1,0,"C",0);
       $pdf->cell(5,4,"",1,0,"C",0);
      }
     }
    }
    $cont3++;
   }
   $sql66 = "SELECT ed74_c_resultadofinal as verificarf,ed74_i_diario as codiario
            FROM diariofinal
             inner join diario on ed95_i_codigo = ed74_i_diario
            WHERE ed95_i_aluno = $ed60_i_aluno
            AND ed95_i_regencia = $codregencia
          ";
   $result66 = pg_query($sql66);
   $linhas66 = pg_num_rows($result66);
   if($linhas66>0){
    db_fieldsmemory($result66,0);
   }else{
    $verificarf = "";
   }
   if($permitenotaembranco=="S" && $linhas33>0 && $verificarf==""){
    if(trim($ed37_c_tipo)=="NOTA"){
     if(trim($obtencao)=="ME"){
      $result_media = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","sum(ed72_i_valornota)/count(ed72_i_valornota) as aprvto",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $codregencia AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null AND ed09_c_somach = 'S'"));
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
                AND ed95_i_regencia = $codregencia
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
      $result_soma = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","sum(ed72_i_valornota) as aprvto,sum(to_number(ed37_c_minimoaprov,999)) as somaminimo",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $codregencia AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null AND ed09_c_somach = 'S'"));
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
      $result_maior = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","max(ed72_i_valornota) as aprvto",""," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $codregencia AND ed72_c_amparo = 'N' AND ed72_i_valornota is not null"));
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
      $result_ultima = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed72_c_amparo as ultamparo,ed72_i_valornota as aprvto","ed41_i_sequencia DESC LIMIT 1"," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $codregencia"));
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
     $pdf->setfont('arial','',10);
     $resfinal = trim($ed60_c_situacao)!="MATRICULADO"||@$aprvto==""?"":$resfinal;
     if(trim($ed37_c_tipo)=="NOTA" && $resfinal<$minimoaprovres){
      $pdf->setfont('arial','b',10);
      $pdf->cell(19,4,$resfinal,1,0,"C",0);
      $pdf->setfont('arial','',10);
     }else{
      $pdf->cell(19,4,$resfinal,1,0,"C",0);
     }
     $cont3++;
    }
   }else{
    $cont3++;
    $pdf->cell(19,4,"",1,0,"C",0);
   }
   for($c=$cont3;$c<9;$c++){
    $pdf->cell(14,4,"",1,0,"C",0);
    $pdf->cell(5,4,"",1,0,"C",0);
   }
   if($ultimoperiodo==$seqatual){
    $pdf->cell(19,4,SomaFaltas($codprocgeraresultado,(!isset($codiario)?0:$codiario),$codregencia,"S"),1,0,"C",0);
   }else{
    $pdf->cell(19,4,"",1,0,"C",0);
   }
   $ultimo = end($formaaval);
   $sql6 = "SELECT ed74_i_percfreq,ed74_c_valoraprov,ed74_c_resultadofinal,ed81_c_todoperiodo,ed74_i_diario,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr
            FROM diariofinal
             inner join diario on ed95_i_codigo = ed74_i_diario
             left join amparo on ed81_i_diario = ed95_i_codigo
             left join convencaoamp on ed250_i_codigo = ed81_i_convencaoamp
            WHERE ed95_i_aluno = $ed60_i_aluno
            AND ed95_i_regencia = $codregencia
          ";
   $result6 = pg_query($sql6);
   $linhas6 = pg_num_rows($result6);
   if($linhas6>0){
    db_fieldsmemory($result6,0);
    if(trim($ed81_c_todoperiodo)=="S"){
     if($ed81_i_justificativa!=""){
      $ed74_c_valoraprov = "Amparo";
      $ed74_i_percfreq = "Amparo";
     }else{
      $ed74_c_valoraprov = $ed250_c_abrev;
      $ed74_i_percfreq = $ed250_c_abrev;
      if($obs2==""){
       $obs2 = $ed250_c_abrev." - ".$ed250_c_descr;
      }
     }
    }
    if(trim($ultimo)=="PARECER" && trim($ed74_c_valoraprov)!="" && trim($ed81_c_todoperiodo)!="S"){
     $ed74_c_valoraprov = "Parec";
    }
    if($codregglob!=""){
     if($codregglob==$codregencia && $tipofreq=="F"){
      $ed74_c_valoraprov = "-";
      $ed74_i_percfreq = $ed74_i_percfreq;
     }elseif($codregglob==$codregencia && $tipofreq=="FA"){
      $ed74_c_valoraprov = $ed74_c_valoraprov;
      $ed74_i_percfreq = $ed74_i_percfreq;
     }else{
      $ed74_c_valoraprov = $ed74_c_valoraprov;
      $ed74_i_percfreq = "-";
     }
    }
    if($ed74_c_resultadofinal=="A"){
     $ed74_c_resultadofinal = "Apr";
    }elseif($ed74_c_resultadofinal=="R"){
     $ed74_c_resultadofinal = "Rep";
    }else{
     $ed74_c_resultadofinal = "";
    }
    if($linhas33>0 && $codprocgeraresultado!=0){
     $ed74_i_percfreq = SomaFaltas($codprocgeraresultado,$ed74_i_diario,$codregencia,"P");
    }else{
     $ed74_i_percfreq = $ed74_i_percfreq;
    }
    if( $ed74_c_valoraprov == "Amparo" || $ed74_c_valoraprov == "Amparado" || $ed74_c_valoraprov == "Parecer" || $ed74_c_valoraprov == "Parec"){
     $pdf->setfont('arial','',7);
    }
    if($resultedu=='S'){
     $pdf->cell(15,4,(trim($tipofreq)!="F"&&$ed81_c_todoperiodo!="S"&&$ed74_i_percfreq!=""&&$ed74_i_percfreq!="-")?number_format($ed74_i_percfreq,2,".","."):$ed74_i_percfreq,1,0,"C",0);
    }else{
     $pdf->cell(15,4,(trim($tipofreq)!="F"&&$ed81_c_todoperiodo!="S"&&$ed74_i_percfreq!=""&&$ed74_i_percfreq!="-")?number_format($ed74_i_percfreq,0):$ed74_i_percfreq,1,0,"C",0);
    }
    if($ed60_c_situacao=="AVANÇADO" || $ed60_c_situacao=="CLASSIFICADO"){
     $ed74_c_valoraprov = substr($ed60_c_situacao,0,4);
     $ed74_c_resultadofinal = "Apr";
     $tipofreq = "F";
    }
    if($resultedu=='S'){
     $pdf->cell(10,4,(trim($ultimo)=="NOTA"&&trim($tipofreq)!="F"&&$ed81_c_todoperiodo!="S"&&$ed74_c_valoraprov!=""&&$ed74_c_valoraprov!="-")?number_format($ed74_c_valoraprov,2,".","."):$ed74_c_valoraprov,1,0,"C",0);
    }else{
     $pdf->cell(10,4,(trim($ultimo)=="NOTA"&&trim($tipofreq)!="F"&&$ed81_c_todoperiodo!="S"&&$ed74_c_valoraprov!=""&&$ed74_c_valoraprov!="-")?number_format($ed74_c_valoraprov,0):$ed74_c_valoraprov,1,0,"C",0);
    }
    $pdf->setfont('arial','',10);
    $pdf->setfont('arial','',8);
    $pdf->cell(5,4,$ed74_c_resultadofinal,1,1,"C",0);
    $pdf->setfont('arial','',10);
   }else{
    if($ed60_c_situacao=="AVANÇADO" || $ed60_c_situacao=="CLASSIFICADO"){
     $ed74_c_valoraprov = substr($ed60_c_situacao,0,4);
     $ed74_c_resultadofinal = "Apr";
     $pdf->cell(15,4,"",1,0,"C",0);
     $pdf->cell(10,4,$ed74_c_valoraprov,1,0,"C",0);
     $pdf->cell(5,4,$ed74_c_resultadofinal,1,1,"C",0);
    }else{
     $pdf->cell(15,4,"",1,0,"C",0);
     $pdf->cell(10,4,"",1,0,"C",0);
     $pdf->cell(5,4,"",1,1,"C",0);
    }
   }
  }
  if(trim($ultimo)!="PARECER"){
   $pdf->setfont('arial','b',8);
   $pdf->cell(35,4,"Mínimo para Aprovação:","LT",0,"L",0);
   if($resultedu=='S'){
    $pdf->cell(245,4,(trim($ultimo)=="NOTA")?number_format($ed37_c_minimoaprov,2,".","."):$ed37_c_minimoaprov,"RT",1,"L",0);
   }else{
    $pdf->cell(245,4,(trim($ultimo)=="NOTA")?number_format($ed37_c_minimoaprov,0):$ed37_c_minimoaprov,"RT",1,"L",0);
   }
   $pdf->setfont('arial','',7);
  }
 }
 $result_obs = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed72_t_obs",""," ed95_i_aluno = $ed60_i_aluno AND ed59_i_turma = $turma AND ed72_i_procavaliacao = $periodo"));
 if($cldiarioavaliacao->numrows>0){
  db_fieldsmemory($result_obs,0);
 }else{
  $ed72_t_obs = "";
 }
 $impresso = false;
 if($ultimoperiodo==$seqatual){
  $pdf->setfont('arial','b',7);
  $pdf->cell(280,4,"Resultado Final: ",1,1,"L",1);
  $pdf->setfont('arial','',7);
  $pdf->cell(280,4,"   ".(ResultadoFinal($ed60_i_codigo,$ed60_i_aluno,$ed60_i_turma,$ed60_c_situacao,$ed60_c_concluida)),1,1,"L",0);
 }
 if($padrao=="yes"){
  $result_par = $clpareceraval->sql_record($clpareceraval->sql_query("","ed93_t_parecer","ed93_i_codigo"," ed95_i_aluno = $ed60_i_aluno AND ed72_i_procavaliacao = $periodo"));
  if($clpareceraval->numrows>0){
   $pdf->cell(280,4,"Parecer Padronizado $ed09_c_descr: ",1,1,"L",1);
   if($padraotipo=="L"){
    $pdf->cell(280,4,"Seq - Parecer => Legenda",1,1,"L",0);
   }
   $seq = "";
   $sep = "";
   $parpadrao = "";
   $seppadrao = "";
   for($g=0;$g<$clpareceraval->numrows;$g++){
    db_fieldsmemory($result_par,$g);
    if(!strstr($seq,"#".$ed93_t_parecer."#")){
     $parpadrao .= $seppadrao.$ed93_t_parecer;
     $seq .= $sep."#".$ed93_t_parecer."#";
     $sep = ",";
     $seppadrao = "    ";
     if($padraotipo=="L"){
      $explode_parecer = explode("**",$ed93_t_parecer);
      for($b=0;$b<count($explode_parecer);$b++){
       $pdf->cell(280,4,trim($explode_parecer[$b]),1,1,"L",0);
      }
     }
    }
   }
   if($padraotipo=="C"){
    $pdf->multicell(280,4,str_replace("**","  ",$parpadrao),1,"L",0,0);
   }
   $impresso = true;
   }
 }
 if($descritivo=="yes"){
  $result_pardescr = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","DISTINCT ed72_t_parecer as pardescr",""," ed95_i_aluno = $ed60_i_aluno AND ed59_i_turma = $turma AND ed72_i_procavaliacao = $periodo AND ed72_t_parecer != ''"));
  if($cldiarioavaliacao->numrows>0){
   $pardescr = trim(pg_result($result_pardescr,0,'pardescr'));
   if($pardescr!=""){
    //$pdf->cell(280,4,"Parecer Descritivo $ed09_c_descr:",1,1,"L",1);
    $pdf->cell(280,4,"Parecer Descritivo:",1,1,"L",1);
    for($g=0;$g<$cldiarioavaliacao->numrows;$g++){
     db_fieldsmemory($result_pardescr,$g);
     $pdf->multicell(280,4,$pardescr,1,"L",0,0);
    }
    $impresso = true;
   }
  }
 }
 if($impresso==false){
  $pdf->cell(280,4,"","LTR",1,"L",0);
 }
 $obs3 = "";
 $result_cons = $claprovconselho->sql_record($claprovconselho->sql_query("","z01_nome,ed253_i_data,ed232_c_descr as disc_conselho,ed253_t_obs","ed232_c_descr"," ed95_i_aluno = $ed60_i_aluno AND ed59_i_turma = $turma"));
 if($claprovconselho->numrows>0){
  $sepobs = "";
  for($g=0;$g<$claprovconselho->numrows;$g++){
   db_fieldsmemory($result_cons,$g);
   $obs3 .= $sepobs."-Disciplina $disc_conselho: aprovado pelo Conselho de Classe. Justificativa: $ed253_t_obs";
   $sepobs = "\n";
  }
 }
 $completar = 160-$pdf->getY();
 $pdf->cell(280,$completar,"",1	,1,"L",0);
 $pdf->setfont('arial','b',7);
 $pdf->cell(140,4,"Observações / Mensagens",1,0,"C",0);
 $pdf->cell(140,4,"Convenções",1,1,"C",0);
 $posy = $pdf->getY();
 $pdf->Rect($pdf->getX(),$pdf->getY(),140,30,$style='');
 $pdf->multicell(140,4,(trim($ed60_t_obs)!=""?$ed60_t_obs."\n":"").(trim($ed72_t_obs)!=""?$ed72_t_obs."\n":"").(trim($obs1)!=""?$obs1."\n":"").(trim($obs2)!=""?$obs2."\n":"").(trim($obs3)!=""?$obs3."\n":""),"LRT","L",0,0);
 if($grade=="yes"){
  $pdf->line(10,48,290,48);
  $pdf->setY($posy);
  $pdf->setX(150);
  $pdf->cell(140,4,"Ft - FALTAS","RL",1,"L",0);
  $pdf->setX(150);
  for($y=0;$y<$linhas2;$y++){
   db_fieldsmemory($result2,$y);
   $pdf->cell(70,4,$ed09_c_abrev." - ".$ed09_c_descr,0,2,"L",0);
   if($y==4){
    $pdf->setY($posy+4);
    $pdf->setX(220);
   }
  }
 }
 $pdf->Rect(150,$posy,140,30,$style='');
 unset($codperiodos);
 unset($tipoaval);
 unset($formaaval);
 unset($codregglob);
}
$pdf->Output();
?>
