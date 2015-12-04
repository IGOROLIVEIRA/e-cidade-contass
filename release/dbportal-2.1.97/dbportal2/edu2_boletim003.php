<?
require("libs/db_stdlibwebseller.php");
include("fpdf151/scpdf.php");
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
$sql = $clmatricula->sql_query("","*","ed60_i_numaluno,to_ascii(ed47_v_nome)"," ed60_i_codigo in ($alunos) AND ed60_i_turma = $turma");
$result = $clmatricula->sql_record($sql);
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
$result_per = $clprocavaliacao->sql_record($clprocavaliacao->sql_query("","ed09_c_descr,ed41_i_sequencia as seqatual",""," ed41_i_codigo = $periodo"));
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
$pdf = new scpdf();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->ln(5);
$dados = pg_exec($conn,"select nomeinst,ender,munic,uf,telef,email,url,logo from db_config where codigo = ".db_getsession("DB_instit"));
$url = @pg_result($dados,0,"url");
$dados1 = pg_exec($conn,"select ed18_c_nome,
                                   j14_nome,
                                   ed18_i_numero,
                                   j13_descr,
                                   ed18_c_cidade,
                                   ed18_c_estado,
                                   ed18_c_email,
                                   ed18_c_logo
                             from escola
                              inner join bairro  on  bairro.j13_codi = escola.ed18_i_bairro
                              inner join ruas  on  ruas.j14_codigo = escola.ed18_i_rua
                              inner join db_depart  on  db_depart.coddepto = escola.ed18_i_codigo
                              left join ruascep on ruascep.j29_codigo = ruas.j14_codigo
                              left join logradcep on logradcep.j65_lograd = ruas.j14_codigo
                              left join ceplogradouros on ceplogradouros.cp06_codlogradouro = logradcep.j65_ceplog
                              left join ceplocalidades on ceplocalidades.cp05_codlocalidades = ceplogradouros.cp06_codlocalidade
                             where ed18_i_codigo = ".db_getsession("DB_coddepto"));

$nomeescola = pg_result($dados1,0,"ed18_c_nome");
$ruaescola = trim(pg_result($dados1,0,"j14_nome"));
$numescola = trim(pg_result($dados1,0,"ed18_i_numero"));
$bairroescola = trim(pg_result($dados1,0,"j13_descr"));
$cidadeescola = trim(pg_result($dados1,0,"ed18_c_cidade"));
$estadoescola = trim(pg_result($dados1,0,"ed18_c_estado"));
$emailescola = trim(pg_result($dados1,0,"ed18_c_email"));
$dados2 = pg_exec($conn,"select ed26_i_numero from telefoneescola where ed26_i_escola = ".db_getsession("DB_coddepto")." LIMIT 1");
if(pg_num_rows($dados2)>0){
 $telefoneescola = trim(pg_result($dados2,0,"ed26_i_numero"));
}else{
 $telefoneescola = "";
}
$pdf->SetXY(1,1);
$nome = pg_result($dados,0,"nomeinst");
global $nomeinst;
$nomeinst = pg_result($dados,0,"nomeinst");
if(strlen($nome) > 42)
 $TamFonteNome = 8;
else
 $TamFonteNome = 9;
$y1=9;
$y2=14;
$y3=18;
$y4=22;
$y5=26;
$y6=30;
$y7=6;
$y8=5;
$y9=35;
$y10=33;
$y11=63;
$y12=3;
$y13=12;
$y14=43;
for($x=0;$x<$clmatricula->numrows;$x++){
 $obs2 = "";
 if(($x%2)==0){
  $pdf->addpage('P');
  $y1=9;
  $y2=14;
  $y3=18;
  $y4=22;
  $y5=26;
  $y6=30;
  $y7=6;
  $y8=5;
  $y9=35;
  $y10=33;
  $y11=63;
  $y12=3;
  $y13=12;
  $y14=43;
 }
 db_fieldsmemory($result,$x);
 $pdf->setfillcolor(223);
 /*
 $pdf->Image('imagens/files/'.pg_result($dados,0,"logo"),7,$y12,20);
 if(trim(pg_result($dados1,0,"ed18_c_logo"))!=""){
  $pdf->Image('imagens/'.trim(pg_result($dados1,0,"ed18_c_logo")),100,$y13,20);
 }
 */
 $pdf->SetFont('Arial','BI',$TamFonteNome);
 $pdf->Text(33,$y1,$nome);
 $pdf->SetFont('Arial','I',8);
 $pdf->Text(33,$y2,$nomeescola);
 $pdf->Text(33,$y3,$ruaescola.", ".$numescola." - ".$bairroescola);
 $pdf->Text(33,$y4,$cidadeescola." - ".$estadoescola);
 $pdf->Text(33,$y5,$telefoneescola);
 $comprim = ($pdf->w - $pdf->rMargin - $pdf->lMargin);
 $pdf->Text(33,$y6,($emailescola!=""?$emailescola." - ":"").$url);
 $Espaco = $pdf->w - 80 ;
 $pdf->SetFont('Arial','',7);
 $margemesquerda = $pdf->lMargin;
 $pdf->setleftmargin($Espaco);
 $pdf->sety($y7);
 $pdf->setfillcolor(235);
 $pdf->roundedrect($Espaco - 3,$y8,75,28,2,'DF','123');
 $pdf->line(10,$y10,$comprim,$y10);
 $result5 = $clregenteconselho->sql_record($clregenteconselho->sql_query("","z01_nome as regente",""," ed235_i_turma = $ed60_i_turma"));
 if($clregenteconselho->numrows>0){
  db_fieldsmemory($result5,0);
 }else{
  $regente = "";
 }
 $pdf->multicell(0,3,"BOLETIM DE DESEMPENHO",0,1,"J",0);
 $pdf->multicell(0,3,"Nome: $ed47_v_nome",0,1,"J",0);
 $pdf->multicell(0,3,"Curso: $ed29_i_codigo - $ed29_c_descr",0,1,"J",0);
 $pdf->multicell(0,3,"Código Aluno: $ed47_i_codigo",0,1,"J",0);
 $pdf->multicell(0,3,"Matrícula: $ed60_i_codigo",0,1,"J",0);
 $pdf->multicell(0,3,"Série: $ed11_c_descr Ano: $ed52_i_ano",0,1,"J",0);
 $pdf->multicell(0,3,"Turma: $ed57_c_descr",0,1,"J",0);
 $situacao = trim($ed60_c_concluida)=="S"?"CONCLUÍDO":Situacao($ed60_c_situacao,$ed60_i_codigo);
 $pdf->multicell(0,3,"Situação: $situacao",0,1,"J",0);
 $pdf->multicell(0,3,"Regente: $regente",0,1,"J",0);
 $pdf->setleftmargin($margemesquerda);
 $pdf->SetY($y9);
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
  if($ultimoperiodo==$seqatual){
   $largurafaltas= 15;
  }else{
   $largurafaltas=0;
  }
  $larguradisc= 190-(30+($linhas2*15)+15+$largurafaltas);
  $pdf->cell($larguradisc,4,"",1,0,"C",0);
  $cont = 0;
  for($y=0;$y<$linhas2;$y++){
   db_fieldsmemory($result2,$y);
   $pdf->cell(15,4,$ed09_c_abrev,1,0,"C",0);
   $cont++;
   $codperiodos[] = $ed41_i_codigo;
   $tipoaval[] = $tipo;
   $formaaval[] = $ed37_c_tipo;
   $minimo_aprov[] = $ed37_c_minimoaprov;
   $codpercalend[] = $ed09_i_codigo;
  }
  if($permitenotaembranco=="S"){
   $pdf->cell(15,4,"Nota Parcial",1,0,"C",0);
   $cont++;
  }else{
   $pdf->cell(15,4,"",1,0,"C",0);
  }
  if($ultimoperiodo==$seqatual){
   $pdf->cell(15,4,"Total Faltas",1,0,"C",0);
  }
  $pdf->cell(15,4,"Frequência",1,0,"C",0);
  $pdf->cell(15,4,"Res.Final",1,1,"C",0);
  $pdf->cell($larguradisc,4,"Disciplinas",1,0,"C",0);
  $cont = 0;
  for($y=0;$y<$linhas2;$y++){
   db_fieldsmemory($result2,$y);
   $pdf->cell(10,4,substr($ed37_c_tipo,0,5),1,0,"C",0);
   $pdf->cell(5,4,$tipo=="A"?"Ft":"",1,0,"C",0);
   $cont++;
  }if($ultimoperiodo==$seqatual){
    $pdf->cell(15,4,"",0,0,"C",0);
  }
  $pdf->cell(15,4,"",1,0,"C",0);
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
   $result33 = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","ed72_i_codigo","ed41_i_sequencia"," ed95_i_aluno = $ed60_i_aluno AND ed95_i_regencia = $codregencia AND $campoaval AND ed72_c_amparo = 'N' AND ed09_c_somach = 'S' AND ed37_c_tipo = '$ed37_c_tipo'"));
   $linhas33 = $cldiarioavaliacao->numrows;
   if($codregglob!=""){
    $result10 = $clregencia->sql_record($clregencia->sql_query(""," ed59_i_codigo as codregglob",""," ed12_i_codigo = $codregglob AND ed59_i_turma = $ed57_i_codigo"));
    db_fieldsmemory($result10,0);
   }
   $pdf->setfont('arial','',7);
   $qtd_per = count($codperiodos);
   $pdf->cell($larguradisc,4,$discregencia,1,0,"L",0);
   $cont3 = 0;
   for($c=0;$c<$qtd_per;$c++){
    if($ed60_c_parecer=="S"){
     $formaaval[$c] = "PARECER";
     $ed37_c_tipo = "PARECER";
    }
    if(trim($tipofreq)=="F" && $tipoaval[$c]=="R"){
     $pdf->cell(10,4,"",1,0,"C",0);
     $pdf->cell(5,4,"",1,0,"C",0);
    }else{
     if($tipoaval[$c]=="R"){
      if(trim($formaaval[$c])=="PARECER"){
       $campos = "ed73_t_parecer as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo";
      }elseif(trim($formaaval[$c])=="NOTA"){
      if($resultedu=='S'){
       $campos = "to_char(ed73_i_valornota,'999.99') as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo";
      }else{
       $campos = "to_char(ed73_i_valornota,'999') as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo";
      }
      }else{
       $campos = "ed73_c_valorconceito as aprov,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr,ed73_c_amparo";
      }
      $tabela = "diarioresultado";
      $ligacao = "ed73_i_diario";
      $where = "ed73_i_procresultado";
      $qual = "R";
      //if($permitenotaembranco=="S" && $linhas33>0){
      // $codperiodos[$c] = 0;
      //}
     }else{
      if(trim($formaaval[$c])=="PARECER"){
       $campos = "ed72_i_numfaltas,ed72_t_parecer as aprov,ed72_c_amparo,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr";
      }elseif(trim($formaaval[$c])=="NOTA"){
       if($resultedu=='S'){
        $campos = "ed72_i_numfaltas,to_char(ed72_i_valornota,'999.99') as aprov,ed72_c_amparo,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr";
       }else{
        $campos = "ed72_i_numfaltas,to_char(ed72_i_valornota,'999') as aprov,ed72_c_amparo,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr";
       }
      }else{
       $campos = "ed72_i_numfaltas,ed72_c_valorconceito as aprov,ed72_c_amparo,ed81_i_justificativa,ed81_i_convencaoamp,ed250_c_abrev,ed250_c_descr";
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
     //die($sql4);
     $result4 = pg_query($sql4);
     $linhas4 = pg_num_rows($result4);
     if($linhas4>0){
      db_fieldsmemory($result4,0);
      if($qual=="A" && trim($ed72_c_amparo)=="S"){
       if($ed81_i_justificativa!=""){
        $aprov = "Amparo";
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
       $aprov = $aprov!=""?"Parec":"";
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
         $aprov = substr($ed60_c_situacao,0,4);
         $ed72_i_numfaltas = "";
        }
       }
      }
      $pdf->setfont('arial','',10);
      if(trim($formaaval[$c])=="NOTA" && $aprov<$minimo_aprov[$c]){
       $pdf->setfont('arial','b',10);
       $pdf->cell(10,4,$aprov,1,0,"C",0);
       $pdf->setfont('arial','',10);
      }else{
       $pdf->cell(10,4,$aprov,1,0,"C",0);
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
         $aprov = substr($ed60_c_situacao,0,4);
         $ed72_i_numfaltas = "";
         $pdf->cell(10,4,$aprov,1,0,"C",0);
         $pdf->cell(5,4,$ed72_i_numfaltas,1,0,"C",0);
        }else{
         $pdf->cell(10,4,"",1,0,"C",0);
         $pdf->cell(5,4,"",1,0,"C",0);
        }
       }else{
        $pdf->cell(10,4,"",1,0,"C",0);
        $pdf->cell(5,4,"",1,0,"C",0);
       }
      }else{
       $pdf->cell(10,4,"",1,0,"C",0);
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
      $pdf->cell(15,4,$resfinal,1,0,"C",0);
      $pdf->setfont('arial','',10);
     }else{
      $pdf->cell(15,4,$resfinal,1,0,"C",0);
     }
     $cont3++;
    }else{
     $pdf->cell(15,4,"",1,0,"C",0);
    }
   }else{
    $pdf->cell(15,4,"",1,0,"C",0);
   }
   if($ultimoperiodo==$seqatual){
    $pdf->cell(15,4,SomaFaltas($codprocgeraresultado,(!isset($codiario)?0:$codiario),$codregencia,"S"),1,0,"C",0);
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
      $ed74_c_valoraprov = "Amp";
      $ed74_i_percfreq = "Amp";
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
    //funcao somar
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
    $pdf->cell(155,4,(trim($ultimo)=="NOTA")?number_format($ed37_c_minimoaprov,2,".","."):$ed37_c_minimoaprov,"RT",1,"L",0);
   }else{
    $pdf->cell(155,4,(trim($ultimo)=="NOTA")?number_format($ed37_c_minimoaprov,0):$ed37_c_minimoaprov,"RT",1,"L",0);
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
 ///result seqatual
 if($ultimoperiodo==$seqatual){
  $pdf->setfont('arial','b',7);
  $pdf->cell(190,4,"Resultado Final: ",1,1,"L",1);
  $pdf->setfont('arial','',7);
  $pdf->cell(190,4,"   ".(ResultadoFinal($ed60_i_codigo,$ed60_i_aluno,$ed60_i_turma,$ed60_c_situacao,$ed60_c_concluida)),1,1,"L",0);
 }
 if($padrao=="yes"){
  $result_par = $clpareceraval->sql_record($clpareceraval->sql_query("","ed93_t_parecer","ed93_i_codigo"," ed95_i_aluno = $ed60_i_aluno AND ed72_i_procavaliacao = $periodo"));
  if($clpareceraval->numrows>0){
   $pdf->setfont('arial','b',7);
   $pdf->cell(190,4,"Parecer Padronizado $ed09_c_descr:",1,1,"L",1);
   $pdf->setfont('arial','',7);
   if($padraotipo=="L"){
    $pdf->cell(190,4,"Seq - Parecer => Legenda",1,1,"L",0);
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
       $pdf->cell(190,4,trim($explode_parecer[$b]),1,1,"L",0);
      }
     }
    }
   }
   if($padraotipo=="C"){
    $pdf->multicell(190,4,str_replace("**","  ",$parpadrao),1,"L",0,0);
   }
   $impresso = true;
  }
 }
 if($descritivo=="yes"){
  $result_pardescr = $cldiarioavaliacao->sql_record($cldiarioavaliacao->sql_query("","DISTINCT ed72_t_parecer as pardescr",""," ed95_i_aluno = $ed60_i_aluno AND ed59_i_turma = $turma AND ed72_i_procavaliacao = $periodo AND ed72_t_parecer != ''"));
  if($cldiarioavaliacao->numrows>0){
   $pardescr = trim(pg_result($result_pardescr,0,'pardescr'));
   if($pardescr!=""){
    $pdf->setfont('arial','b',7);
    $pdf->cell(190,4,"Parecer Descritivo $ed09_c_descr:",1,1,"L",1);
    $pdf->setfont('arial','',7);
    for($g=0;$g<$cldiarioavaliacao->numrows;$g++){
     db_fieldsmemory($result_pardescr,$g);
     $pdf->multicell(190,4,$pardescr,1,"L",0,0);
    }
    $impresso = true;
   }
  }
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
 if(trim($ed60_t_obs)!="" || trim($ed72_t_obs)!="" || trim($obs1)!="" || trim($obs2)!="" || trim($obs3)!=""){
  $pdf->setfont('arial','b',7);
  $pdf->cell(190,4,"Observações / Mensagens",1,1,"L",1);
  $pdf->setfont('arial','',7);
  $pdf->multicell(190,4,($ed60_t_obs!=""?$ed60_t_obs."\n":"").($ed72_t_obs!=""?$ed72_t_obs."\n":"").($obs1!=""?$obs1."\n":"").($obs2!=""?$obs2."\n":"").($obs3!=""?$obs3."\n":""),1,"L",0,0);
  $impresso = true;
 }
 if($impresso==false){
  $pdf->cell(190,1,"",1,1,"L",0);
 }else{
  $pdf->cell(190,1,"","LRB",1,"L",0);
 }
 if($grade=="yes"){
  $pdf->line(10,$y14,200,$y14);
 }
 unset($codperiodos);
 unset($tipoaval);
 unset($formaaval);
 unset($codregglob);
 $y1=9+150;
 $y2=14+150;
 $y3=18+150;
 $y4=22+150;
 $y5=26+150;
 $y6=30+150;
 $y7=6+150;
 $y8=5+150;
 $y9=35+150;
 $y10=33+150;
 $y11=63+150;
 $y12=3+150;
 $y13=12+150;
 $y14=43+150;
}
$pdf->Output();
?>