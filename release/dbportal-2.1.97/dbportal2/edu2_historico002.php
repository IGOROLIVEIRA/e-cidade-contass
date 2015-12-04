<?
require("libs/db_stdlibwebseller.php");
include("fpdf151/pdfwebseller.php");
include("classes/db_historico_classe.php");
include("classes/db_aluno_classe.php");
include("classes/db_aprovconselho_classe.php");
include("classes/db_trocaserie_classe.php");
$escola = db_getsession("DB_coddepto");
$resultedu= eduparametros(db_getsession("DB_coddepto"));
$clhistorico = new cl_historico;
$claluno = new cl_aluno;
$claprovconselho = new cl_aprovconselho;
$cltrocaserie = new cl_trocaserie;
$result = $claluno->sql_record($claluno->sql_query("","ed47_i_codigo","ed47_v_nome"," ed47_i_codigo in ($alunos)"));
if($claluno->numrows==0){?>
 <table width='100%'>
  <tr>
   <td align='center'>
    <font color='#FF0000' face='arial'>
     <b>Nenhum histórico para o(s) aluno(s) selecionados<br>
     <input type='button' value='Fechar' onclick='window.close()'></b>
    </font>
   </td>
  </tr>
 </table>
 <?
 exit;
}
function Abreviar($nome,$max){
  if(strlen(trim($nome))>$max){
  $strinv = strrev(trim($nome));
  $ultnome = substr($strinv,0,strpos($strinv," "));
  $ultnome = strrev($ultnome);
  $nome = strrev($strinv);
  $prinome = substr($nome,0,strpos($nome," "));
  $nomes = strtok($nome, " ");
  $iniciais = "";
  while($nomes):
   if(($nomes == 'E') || ($nomes == 'DE') || ($nomes == 'DOS') ||
     ($nomes == 'DAS') || ($nomes == 'DA') || ($nomes == 'DO')){
     $iniciais .= " ".$nomes;
     $nomes = strtok(" ");
   }elseif (($nomes == $ultnome) || ($nomes == $prinome)){
     $nome = "";
     $nomes = strtok(" ");
   }else{
     $iniciais .= " ".$nomes[0].".";
     $nomes = strtok(" ");
   }
  endwhile;
  $nome =  $prinome;
  $nome .= $iniciais;
  $nome .= " ".$ultnome;
 }
 return trim($nome);
}
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
for($v=0;$v<$claluno->numrows;$v++){
 db_fieldsmemory($result,$v);
 $result1 = $clhistorico->sql_record($clhistorico->sql_query("","*","ed47_v_nome"," ed61_i_aluno in ($ed47_i_codigo)"));
 $codigo_hist = "";
 $sep = "";
 for($x=0;$x<$clhistorico->numrows;$x++){
  db_fieldsmemory($result1,$x);
  $codigo_hist .= $sep.$ed61_i_codigo;
  $sep = ",";
 }
 $sql_ano = "SELECT max(ed62_i_anoref) as ultimoano
             FROM histmpsdisc
              inner join historicomps on ed62_i_codigo = ed65_i_historicomps
              inner join historico on ed61_i_codigo = ed62_i_historico
             WHERE ed61_i_codigo in ($codigo_hist)
             AND ed62_i_escola = $escola
            ";
 $result_ano = pg_query($sql_ano);
 $linhas_ano = pg_num_rows($result_ano);
 if($linhas_ano>0){
  db_fieldsmemory($result_ano,0);
  if($ultimoano!=""){
   $ultimoano = $ultimoano;
  }else{
   $ultimoano = date("Y");
  }
  $sql_anofora = "SELECT max(ed99_i_anoref) as ultimoanofora
                  FROM histmpsdiscfora
                   inner join historicompsfora on ed99_i_codigo = ed100_i_historicompsfora
                   inner join historico on ed61_i_codigo = ed99_i_historico
                  WHERE ed61_i_codigo in ($codigo_hist)
             ";
  $result_anofora = pg_query($sql_anofora);
  $linhas_anofora = pg_num_rows($result_anofora);
  if($linhas_anofora>0){
   db_fieldsmemory($result_anofora,0);
   if($ultimoanofora>$ultimoano){
    $ultimoano = $ultimoanofora;
   }
  }
 }else{
  $sql_ano = "SELECT ed52_i_ano as ultimoano
              FROM matricula
               inner join turma on ed57_i_codigo = ed60_i_turma
               inner join calendario on ed52_i_codigo = ed57_i_calendario
              WHERE ed57_i_escola = $escola
              AND ed60_i_aluno = $ed61_i_aluno
              ORDER BY ed60_i_codigo DESC
              LIMIT 1
             ";
  $result_ano = pg_query($sql_ano);
  $linhas_ano = pg_num_rows($result_ano);
  if($linhas_ano>0){
   db_fieldsmemory($result_ano,0);
  }else{
   $ultimoano = date("Y");
  }
 }
 $sql_ch = "SELECT sum(
             (SELECT sum(ed62_i_qtdch) FROM historico
             left join historicomps on ed62_i_historico = ed61_i_codigo
             WHERE ed61_i_codigo in ($codigo_hist) AND ed62_i_anoref <= $ultimoano AND ed62_c_resultadofinal = 'A')
             +
             (SELECT sum(ed99_i_qtdch) FROM historico
             left join historicompsfora on ed99_i_historico = ed61_i_codigo
             WHERE ed61_i_codigo in ($codigo_hist) AND ed99_i_anoref <= $ultimoano AND ed99_c_resultadofinal = 'A')
             ) as chtotal
           ";
 $result_ch = pg_query($sql_ch);
 db_fieldsmemory($result_ch,0);
 $pdf->setfillcolor(223);
 $head1 = "HISTÓRICO ESCOLAR";
 $head2 = "Nome: $ed47_v_nome";
 $head3 = "Nascido em: ".db_formatar($ed47_d_nasc,'d');
 $ed47_i_nacion = $ed47_i_nacion==1?"BRASILEIRO":"ESTRANGEIRO";
 $head4 = "Nacionalidade: $ed47_i_nacion";
 $head5 = "Nome do Pai: ".Abreviar($ed47_v_pai,30);
 $head6 = "Nome da Mãe: ".Abreviar($ed47_v_mae,30);
 $head7 = "Naturalidade: $ed47_c_naturalidade";
 $head8 = "Identidade: $ed47_v_ident";
 $head9 = "Carga Horária Total: $chtotal";
 $pdf->addpage('L');
 $pdf->setfont('arial','b',7);
 $pdf->cell(36,4,"Disciplina",1,0,"C",0);
 $pdf->cell(8,4,"Série",1,0,"C",0);
 $pdf->cell(10,4,"Ap.",1,0,"C",0);
 $pdf->cell(10,4,"CH",1,0,"C",0);
 $pdf->cell(8,4,"RF",1,0,"C",0);
 $pdf->cell(10,4,"PE",1,0,"C",0);
 $pdf->cell(10,4,"ESC",1,0,"C",0);
 $pdf->cell(36,4,"Disciplina",1,0,"C",0);
 $pdf->cell(8,4,"Série",1,0,"C",0);
 $pdf->cell(10,4,"Ap.",1,0,"C",0);
 $pdf->cell(10,4,"CH",1,0,"C",0);
 $pdf->cell(8,4,"RF",1,0,"C",0);
 $pdf->cell(10,4,"PE",1,0,"C",0);
 $pdf->cell(10,4,"ESC",1,0,"C",0);
 $pdf->cell(36,4,"Disciplina",1,0,"C",0);
 $pdf->cell(8,4,"Série",1,0,"C",0);
 $pdf->cell(10,4,"Ap.",1,0,"C",0);
 $pdf->cell(10,4,"CH",1,0,"C",0);
 $pdf->cell(8,4,"RF",1,0,"C",0);
 $pdf->cell(10,4,"PE",1,0,"C",0);
 $pdf->cell(10,4,"ESC",1,1,"C",0);
 $sql1 = "SELECT ed11_i_sequencia,ed62_i_anoref,ed62_i_escola,ed232_c_descr,ed11_c_abrev,ed65_i_disciplina,ed65_i_justificativa,ed65_i_qtdch,ed65_c_resultadofinal,ed65_t_resultobtido,ed65_c_situacao,ed65_c_tiporesultado
          FROM histmpsdisc
           inner join disciplina on ed12_i_codigo = ed65_i_disciplina
           inner join caddisciplina on ed232_i_codigo= ed12_i_caddisciplina
           inner join historicomps on ed62_i_codigo = ed65_i_historicomps
           inner join serie on ed11_i_codigo = ed62_i_serie
           inner join historico on ed61_i_codigo = ed62_i_historico
          WHERE ed61_i_codigo in ($codigo_hist)
          AND ed62_i_anoref <= $ultimoano
          AND ed62_c_resultadofinal = 'A'
          AND ed65_c_situacao = 'CONCLUÍDO'
          UNION
          SELECT ed11_i_sequencia,ed99_i_anoref,ed99_i_escolaproc,ed232_c_descr,ed11_c_abrev,ed100_i_disciplina,ed100_i_justificativa,ed100_i_qtdch,ed100_c_resultadofinal,ed100_t_resultobtido,ed100_c_situacao,ed100_c_tiporesultado
          FROM histmpsdiscfora
           inner join disciplina on ed12_i_codigo = ed100_i_disciplina
           inner join caddisciplina on ed232_i_codigo= ed12_i_caddisciplina
           inner join historicompsfora on ed99_i_codigo = ed100_i_historicompsfora
           inner join serie on ed11_i_codigo = ed99_i_serie
           inner join historico on ed61_i_codigo = ed99_i_historico
          WHERE ed61_i_codigo in ($codigo_hist)
          AND ed99_i_anoref <= $ultimoano
          AND ed99_c_resultadofinal = 'A'
          AND ed100_c_situacao = 'CONCLUÍDO'
          ORDER BY ed62_i_anoref ASC
         ";
 $result1 = pg_query($sql1);
 $linhas1 = pg_num_rows($result1);
 $cor1 = 0;
 $cor2 = 1;
 $cor = "";
 $cont = 0;
 $limite = 17;
 $limitepag = 53;
 $passou = 0;
 $abc = 39;
 $atual = 0;
 for($y=0;$y<$linhas1;$y++){
  db_fieldsmemory($result1,$y);
  if($cor==$cor1){
   $cor = $cor2;
  }else{
   $cor = $cor1;
  }
  if($passou==1){
   $pdf->setY($abc);
   $pdf->setX(102);
   $abc += 4;
  }
  if($passou==2){
   $pdf->setY($abc);
   $pdf->setX(194);
   $abc += 4;
  }
  if(is_numeric($ed65_t_resultobtido)){
   if($resultedu=='S'){
    $ed65_t_resultobtido = number_format($ed65_t_resultobtido,2,".",".");
   }else{
    $ed65_t_resultobtido = number_format($ed65_t_resultobtido,0,".",".");
   }
  }
  $pdf->setfont('arial','',7);
  $pdf->cell(36,4,substr($ed232_c_descr,0,20),"LR",0,"L",$cor);
  $pdf->cell(8,4,$ed11_c_abrev,"LR",0,"C",$cor);
  $pdf->setfont('arial','',6);
  $pdf->cell(10,4,($ed65_c_situacao!="CONCLUÍDO")?"Amparo":($ed65_t_resultobtido==""?"-":$ed65_t_resultobtido),"LR",0,"C",$cor);
  $pdf->setfont('arial','',7);
  $pdf->cell(10,4,$ed65_i_qtdch==""?"0":$ed65_i_qtdch,"LR",0,"C",$cor);
  $pdf->cell(8,4,$ed65_c_resultadofinal=="A"?"APR":"REP","LR",0,"C",$cor);
  $pdf->cell(10,4,$ed62_i_anoref,"LR",0,"C",$cor);
  $pdf->cell(10,4,$ed62_i_escola,"LR",1,"C",$cor);
  if($cont==$limite){
   $limite += 18;
   $passou += 1;
   $atual = ($passou==1||$passou==2)?-4:0;
   $abc = 39;
  }
  if($cont==$limitepag && $linhas1!=($limitepag+1)){
   //escolas do aluno no historico
   $pdf->setfont('arial','b',7);
   $pdf->cell(20,4,"Escola",1,0,"C",0);
   $pdf->cell(100,4,"Nome",1,0,"C",0);
   $pdf->cell(80,4,"Localidade",1,0,"C",0);
   $pdf->cell(76,4,"Observações",1,1,"C",0);
   $sql2 = "SELECT ed11_i_sequencia,ed62_i_anoref,ed18_i_codigo,ed18_c_nome,ed18_c_cidade,ed18_c_estado
            FROM historicomps
             inner join serie on ed11_i_codigo = ed62_i_serie
             inner join escola  on  escola.ed18_i_codigo = historicomps.ed62_i_escola
             inner join bairro  on  bairro.j13_codi = escola.ed18_i_bairro
             inner join ruas  on  ruas.j14_codigo = escola.ed18_i_rua
             inner join db_depart  on  db_depart.coddepto = escola.ed18_i_codigo
             left join ruascep on ruascep.j29_codigo = ruas.j14_codigo
             left join logradcep on logradcep.j65_lograd = ruas.j14_codigo
             left join ceplogradouros on ceplogradouros.cp06_codlogradouro = logradcep.j65_ceplog
             left join ceplocalidades on ceplocalidades.cp05_codlocalidades = ceplogradouros.cp06_codlocalidade
            WHERE ed62_i_historico in ($codigo_hist)
            AND ed62_i_anoref <= $ultimoano
            UNION
            SELECT ed11_i_sequencia,ed99_i_anoref,ed82_i_codigo,ed82_c_nome,ed82_c_cidade,ed82_c_estado
            FROM historicompsfora
             inner join serie on ed11_i_codigo = ed99_i_serie
             inner join escolaproc  on  ed82_i_codigo = ed99_i_escolaproc
            WHERE ed99_i_historico in ($codigo_hist)
            AND ed99_i_anoref <= $ultimoano
            ORDER BY ed18_i_codigo
		   ";
   $result2 = pg_query($sql2);
   $linhas2 = pg_num_rows($result2);
   $abcatual = $pdf->getY();
   $cont1 = 0;
   $priesc = "";
   for($z=0;$z<$linhas2;$z++){
    db_fieldsmemory($result2,$z);
    if($priesc!=$ed18_i_codigo){
     $pdf->setfont('arial','',7);
     $pdf->cell(20,4,$ed18_i_codigo,"LR",0,"C",0);
     $pdf->cell(100,4,$ed18_c_nome,"LR",0,"L",0);
     $pdf->cell(80,4,$ed18_c_cidade." - ".$ed18_c_estado,"LR",1,"L",0);
     $cont1++;
     $priesc = $ed18_i_codigo;
    }
   }
   //completa quadro das escolas
   for($z=$cont1;$z<8;$z++){
    $pdf->cell(20,4,"","LR",0,"C",0);
    $pdf->cell(100,4,"","LR",0,"C",0);
    $pdf->cell(80,4,"","LR",1,"C",0);
   }
   $abcserie = $pdf->getY();
   //series do historico
   $pdf->setfont('arial','b',7);
   $pdf->cell(15,4,"Série",1,0,"C",0);
   $pdf->cell(15,4,"Período",1,0,"C",0);
   $pdf->cell(15,4,"CH",1,0,"C",0);
   $pdf->cell(15,4,"DL",1,0,"C",0);
   $pdf->cell(15,4,"RF",1,0,"C",0);
   $pdf->cell(15,4,"Obs.",1,0,"C",0);
   $pdf->cell(15,4,"Escola",1,0,"C",0);
   $pdf->cell(15,4,"Turma",1,1,"C",0);
   $sql3 = "SELECT ed11_i_sequencia,ed11_c_abrev,ed62_i_anoref,ed62_i_qtdch,ed62_i_diasletivos,ed62_c_resultadofinal,ed62_i_escola,ed62_i_turma
            FROM historicomps
             inner join serie on ed11_i_codigo = ed62_i_serie
            WHERE ed62_i_historico in ($codigo_hist)
            AND ed62_i_anoref <= $ultimoano
            AND ed62_c_resultadofinal = 'A'
            UNION
            SELECT ed11_i_sequencia,ed11_c_abrev,ed99_i_anoref,ed99_i_qtdch,ed99_i_diasletivos,ed99_c_resultadofinal,ed99_i_escolaproc,ed99_c_turma
            FROM historicompsfora
             inner join serie on ed11_i_codigo = ed99_i_serie
            WHERE ed99_i_historico in ($codigo_hist)
            AND ed99_i_anoref <= $ultimoano
            AND ed99_c_resultadofinal = 'A'
            ORDER BY ed62_i_anoref ASC
           ";
   $result3 = pg_query($sql3);
   $linhas3 = pg_num_rows($result3);
   $cont2 = 0;
   for($t=0;$t<$linhas3;$t++){
    db_fieldsmemory($result3,$t);
    $pdf->setfont('arial','',7);
    $pdf->cell(15,4,$ed11_c_abrev,"LR",0,"C",0);
    $pdf->cell(15,4,$ed62_i_anoref,"LR",0,"C",0);
    $pdf->cell(15,4,$ed62_i_qtdch,"LR",0,"C",0);
    $pdf->cell(15,4,$ed62_i_diasletivos,"LR",0,"C",0);
    $pdf->cell(15,4,$ed62_c_resultadofinal=="A"?"APR":"REP","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,$ed62_i_escola,"LR",0,"C",0);
    $pdf->cell(15,4,$ed62_i_turma,"LR",1,"C",0);
    $cont2++;
   }
   //completa quadro series
   for($t=$cont2;$t<9;$t++){
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",0,"C",0);
    $pdf->cell(15,4,"","LR",1,"C",0);
   }
   //Assinaturas
   $pdf->setfont('arial','',7);
   $pdf->cell(276,1,"",1,0,"C",0);
   $pdf->setY($abcserie);
   $pdf->setX(130);
   $pdf->cell(80,10,"","LRT",1,"C",0);
   $pdf->setY($abcserie+10);
   $pdf->setX(130);
   $pdf->cell(80,4,"_______________________","LR",1,"C",0);
   $pdf->setY($abcserie+14);
   $pdf->setX(130);
   $pdf->cell(80,4,"SECRETÁRIO(A)","LR",1,"C",0);
   $pdf->setY($abcserie+18);
   $pdf->setX(130);
   $pdf->cell(80,10,"","LR",1,"C",0);
   $pdf->setY($abcserie+28);
   $pdf->setX(130);
   $pdf->cell(80,4,"_______________________","LR",1,"C",0);
   $pdf->setY($abcserie+32);
   $pdf->setX(130);
   $pdf->cell(80,4,"DIRETOR(A)","LR",1,"C",0);
   $pdf->setY($abcserie+36);
   $pdf->setX(130);
   $pdf->cell(80,4,"","LR",1,"C",0);
   //Observações
   $pdf->setY($abcatual);
   $pdf->setX(210);
   $pdf->cell(76,72,"","LR",1,"C",0);
   $pdf->setY($abcatual);
   $pdf->setX(210);
   //aprovado pelo conselho
   $obs_cons = "";
   $result_cons = $claprovconselho->sql_record($claprovconselho->sql_query("","z01_nome,ed253_i_data,ed232_c_descr as disc_conselho,ed253_t_obs,ed47_v_nome,ed11_c_descr as serie_conselho","ed232_c_descr","ed95_i_aluno = $ed61_i_aluno AND ed31_i_curso = $ed61_i_curso"));
   if($claprovconselho->numrows>0){
    $sepobs = "";
    for($g=0;$g<$claprovconselho->numrows;$g++){
     db_fieldsmemory($result_cons,$g);
     $obs_cons .= $sepobs."-Disciplina $disc_conselho na Série $serie_conselho foi aprovado pelo Conselho de Classe. Justificativa: $ed253_t_obs";
     $sepobs = "\n";
    }
   }
   $campos_prog = "serieorig.ed11_c_descr as ed11_c_origem,
                   seriedest.ed11_c_descr as ed11_c_destino,
                   trocaserie.ed101_d_data,
                   trocaserie.ed101_c_tipo
                  ";
   $result_prog = $cltrocaserie->sql_record($cltrocaserie->sql_query("",$campos_prog,"ed101_d_data","ed101_i_aluno = $ed61_i_aluno"));
   $obs_prog = "";
   $sep_prog = "";
   if($cltrocaserie->numrows>0){
    for($g=0;$g<$cltrocaserie->numrows;$g++){
     db_fieldsmemory($result_prog,$g);
     $obs_prog .= $sep_prog."-".($ed101_c_tipo=="A"?"AVANÇADO":"CLASSIFICADO")."(A) DA SÉRIE ".(trim($ed11_c_origem))." PARA SÉRIE ".(trim($ed11_c_destino))." EM ".substr($ed101_d_data,8,2)."/".substr($ed101_d_data,5,2)."/".substr($ed101_d_data,0,4).", CONFORME LEI FEDERAL N° 9394/96 - ARTIGO 23, § 1o , PARECER CEED N° 740/99 E REGIMENTO ESCOLAR";
     $sep_prog = "\n";
    }
   }
   $pdf->multicell(76,4,($ed61_t_obs!=""?$ed61_t_obs."\n":"").($obs_prog!=""?$obs_prog."\n":"").($obs_cons!=""?$obs_cons."\n":""),"LR","J",0,0);
   $pdf->line(10,39,286,39);
   $pdf->addpage('L');
   //$pdf->ln(5);
   $pdf->setfont('arial','b',7);
   $pdf->cell(36,4,"Disciplina",1,0,"C",0);
   $pdf->cell(8,4,"Série",1,0,"C",0);
   $pdf->cell(10,4,"Ap.",1,0,"C",0);
   $pdf->cell(10,4,"CH",1,0,"C",0);
   $pdf->cell(8,4,"RF",1,0,"C",0);
   $pdf->cell(10,4,"PE",1,0,"C",0);
   $pdf->cell(10,4,"ESC",1,0,"C",0);
   $pdf->cell(36,4,"Disciplina",1,0,"C",0);
   $pdf->cell(8,4,"Série",1,0,"C",0);
   $pdf->cell(10,4,"Ap.",1,0,"C",0);
   $pdf->cell(10,4,"CH",1,0,"C",0);
   $pdf->cell(8,4,"RF",1,0,"C",0);
   $pdf->cell(10,4,"PE",1,0,"C",0);
   $pdf->cell(10,4,"ESC",1,0,"C",0);
   $pdf->cell(36,4,"Disciplina",1,0,"C",0);
   $pdf->cell(8,4,"Série",1,0,"C",0);
   $pdf->cell(10,4,"Ap.",1,0,"C",0);
   $pdf->cell(10,4,"CH",1,0,"C",0);
   $pdf->cell(8,4,"RF",1,0,"C",0);
   $pdf->cell(10,4,"PE",1,0,"C",0);
   $pdf->cell(10,4,"ESC",1,1,"C",0);
   $passou = 0;
   $cont = -1;
   $atual = ($passou==1||$passou==2)?0:-4;
   $limite = 17;
   $abc = 39;
  }
  $cont++;
  $atual += 4;
 }
 $pdf->line(10,39,286,39);
 $abc = $atual+39;
 $comeco = $cont;
 for($y=$comeco;$y<=$limitepag;$y++){
  if($passou==0){
   $pdf->setY($abc);
   $pdf->setX(10);
   $abc += 4;
  }
  if($passou==1){
   $pdf->setY($abc);
   $pdf->setX(102);
   $abc += 4;
  }
  if($passou==2){
   $pdf->setY($abc);
   $pdf->setX(194);
   $abc += 4;
  }
  if($cont==$limite){
   $limite += 18;
   $passou += 1;
   $abc = 39;
  }
  $pdf->cell(36,4,"","LR",0,"L",0);
  $pdf->cell(8,4,"","LR",0,"C",0);
  $pdf->cell(10,4,"","LR",0,"C",0);
  $pdf->cell(10,4,"","LR",0,"C",0);
  $pdf->cell(8,4,"","LR",0,"C",0);
  $pdf->cell(10,4,"","LR",0,"C",0);
  $pdf->cell(10,4,"","LR",1,"C",0);
  $cont++;
 }
 //escolas do aluno no historico
 $pdf->setfont('arial','b',7);
 $pdf->cell(20,4,"Escola",1,0,"C",0);
 $pdf->cell(100,4,"Nome",1,0,"C",0);
 $pdf->cell(80,4,"Localidade",1,0,"C",0);
 $pdf->cell(76,4,"Observações",1,1,"C",0);
 $sql2 = "SELECT ed11_i_sequencia,ed62_i_anoref,ed18_i_codigo,ed18_c_nome,ed18_c_cidade,ed18_c_estado
          FROM historicomps
           inner join serie on ed11_i_codigo = ed62_i_serie
           inner join escola  on  escola.ed18_i_codigo = historicomps.ed62_i_escola
           inner join bairro  on  bairro.j13_codi = escola.ed18_i_bairro
           inner join ruas  on  ruas.j14_codigo = escola.ed18_i_rua
           inner join db_depart  on  db_depart.coddepto = escola.ed18_i_codigo
           left join ruascep on ruascep.j29_codigo = ruas.j14_codigo
           left join logradcep on logradcep.j65_lograd = ruas.j14_codigo
           left join ceplogradouros on ceplogradouros.cp06_codlogradouro = logradcep.j65_ceplog
           left join ceplocalidades on ceplocalidades.cp05_codlocalidades = ceplogradouros.cp06_codlocalidade
          WHERE ed62_i_historico in ($codigo_hist)
          AND ed62_i_anoref <= $ultimoano
          UNION
          SELECT ed11_i_sequencia,ed99_i_anoref,ed82_i_codigo,ed82_c_nome,ed82_c_cidade,ed82_c_estado
          FROM historicompsfora
           inner join serie on ed11_i_codigo = ed99_i_serie
           inner join escolaproc  on  ed82_i_codigo = ed99_i_escolaproc
          WHERE ed99_i_historico in ($codigo_hist)
          AND ed99_i_anoref <= $ultimoano
          ORDER BY ed18_i_codigo
         ";
 $result2 = pg_query($sql2);
 $linhas2 = pg_num_rows($result2);
 $abcatual = $pdf->getY();
 $cont1 = 0;
 $priesc = "";
 for($z=0;$z<$linhas2;$z++){
  db_fieldsmemory($result2,$z);
  if($priesc!=$ed18_i_codigo){
   $pdf->setfont('arial','',7);
   $pdf->cell(20,4,$ed18_i_codigo,"LR",0,"C",0);
   $pdf->cell(100,4,$ed18_c_nome,"LR",0,"L",0);
   $pdf->cell(80,4,$ed18_c_cidade." - ".$ed18_c_estado,"LR",1,"L",0);
   $cont1++;
   $priesc = $ed18_i_codigo;
  }
 }
 //completa quadro das escolas
 for($z=$cont1;$z<8;$z++){
  $pdf->cell(20,4,"","LR",0,"C",0);
  $pdf->cell(100,4,"","LR",0,"C",0);
  $pdf->cell(80,4,"","LR",1,"C",0);
 }
 $abcserie = $pdf->getY();
 //series do historico
 $pdf->setfont('arial','b',7);
 $pdf->cell(15,4,"Série",1,0,"C",0);
 $pdf->cell(15,4,"Período",1,0,"C",0);
 $pdf->cell(15,4,"CH",1,0,"C",0);
 $pdf->cell(15,4,"DL",1,0,"C",0);
 $pdf->cell(15,4,"RF",1,0,"C",0);
 $pdf->cell(15,4,"Obs.",1,0,"C",0);
 $pdf->cell(15,4,"Escola",1,0,"C",0);
 $pdf->cell(15,4,"Turma",1,1,"C",0);
 $sql3 = "SELECT ed11_i_sequencia,ed11_c_abrev,ed62_i_anoref,ed62_i_qtdch,ed62_i_diasletivos,ed62_c_resultadofinal,ed62_i_escola,ed62_i_turma
          FROM historicomps
           inner join serie on ed11_i_codigo = ed62_i_serie
          WHERE ed62_i_historico in ($codigo_hist)
          AND ed62_i_anoref <= $ultimoano
          AND ed62_c_resultadofinal = 'A'
          UNION
          SELECT ed11_i_sequencia,ed11_c_abrev,ed99_i_anoref,ed99_i_qtdch,ed99_i_diasletivos,ed99_c_resultadofinal,ed99_i_escolaproc,ed99_c_turma
          FROM historicompsfora
           inner join serie on ed11_i_codigo = ed99_i_serie
          WHERE ed99_i_historico in ($codigo_hist)
          AND ed99_i_anoref <= $ultimoano
          AND ed99_c_resultadofinal = 'A'
          ORDER BY ed62_i_anoref ASC
         ";
 $result3 = pg_query($sql3);
 $linhas3 = pg_num_rows($result3);
 $cont2 = 0;
 for($t=0;$t<$linhas3;$t++){
  db_fieldsmemory($result3,$t);
  $pdf->setfont('arial','',7);
  $pdf->cell(15,4,$ed11_c_abrev,"LR",0,"C",0);
  $pdf->cell(15,4,$ed62_i_anoref,"LR",0,"C",0);
  $pdf->cell(15,4,$ed62_i_qtdch,"LR",0,"C",0);
  $pdf->cell(15,4,$ed62_i_diasletivos,"LR",0,"C",0);
  $pdf->cell(15,4,$ed62_c_resultadofinal=="A"?"APR":"REP","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,$ed62_i_escola,"LR",0,"C",0);
  $pdf->cell(15,4,$ed62_i_turma,"LR",1,"C",0);
  $cont2++;
 }
 //completa quadro series
 for($t=$cont2;$t<9;$t++){
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",0,"C",0);
  $pdf->cell(15,4,"","LR",1,"C",0);
 }
 $pdf->cell(276,1,"",1,0,"C",0);
 //Assinaturas
 $pdf->setfont('arial','',7);
 $pdf->setY($abcserie);
 $pdf->setX(130);
 $pdf->cell(80,10,"","LRT",1,"C",0);
 $pdf->setY($abcserie+10);
 $pdf->setX(130);
 $pdf->cell(80,4,"_______________________","LR",1,"C",0);
 $pdf->setY($abcserie+14);
 $pdf->setX(130);
 $pdf->cell(80,4,"SECRETÁRIO(A)","LR",1,"C",0);
 $pdf->setY($abcserie+18);
 $pdf->setX(130);
 $pdf->cell(80,10,"","LR",1,"C",0);
 $pdf->setY($abcserie+28);
 $pdf->setX(130);
 $pdf->cell(80,4,"_______________________","LR",1,"C",0);
 $pdf->setY($abcserie+32);
 $pdf->setX(130);
 $pdf->cell(80,4,"DIRETOR(A)","LR",1,"C",0);
 $pdf->setY($abcserie+36);
 $pdf->setX(130);
 $pdf->cell(80,4,"","LR",1,"C",0);
 //Observações
 $pdf->setY($abcatual);
 $pdf->setX(210);
 $pdf->cell(76,72,"","LR",1,"C",0);
 $pdf->setY($abcatual);
 $pdf->setX(210);
 //aprovado pelo conselho
 $obs_cons = "";
 $result_cons = $claprovconselho->sql_record($claprovconselho->sql_query("","z01_nome,ed253_i_data,ed232_c_descr as disc_conselho,ed253_t_obs,ed47_v_nome,ed11_c_descr as serie_conselho","ed232_c_descr","ed95_i_aluno = $ed61_i_aluno AND ed31_i_curso = $ed61_i_curso"));
 if($claprovconselho->numrows>0){
  $sepobs = "";
  for($g=0;$g<$claprovconselho->numrows;$g++){
   db_fieldsmemory($result_cons,$g);
   $obs_cons .= $sepobs."-Disciplina $disc_conselho na Série $serie_conselho foi aprovado pelo Conselho de Classe. Justificativa: $ed253_t_obs";
   $sepobs = "\n";
  }
 }
 $campos_prog = "serieorig.ed11_c_descr as ed11_c_origem,
                 seriedest.ed11_c_descr as ed11_c_destino,
                 trocaserie.ed101_d_data,
                 trocaserie.ed101_c_tipo
                ";
 $result_prog = $cltrocaserie->sql_record($cltrocaserie->sql_query("",$campos_prog,"ed101_d_data","ed101_i_aluno = $ed61_i_aluno"));
 $obs_prog = "";
 $sep_prog = "";
 if($cltrocaserie->numrows>0){
  for($g=0;$g<$cltrocaserie->numrows;$g++){
   db_fieldsmemory($result_prog,$g);
   $obs_prog .= $sep_prog."-".($ed101_c_tipo=="A"?"AVANÇADO":"CLASSIFICADO")."(A) DA SÉRIE ".(trim($ed11_c_origem))." PARA SÉRIE ".(trim($ed11_c_destino))." EM ".substr($ed101_d_data,8,2)."/".substr($ed101_d_data,5,2)."/".substr($ed101_d_data,0,4).", CONFORME LEI FEDERAL N° 9394/96 - ARTIGO 23, § 1o , PARECER CEED N° 740/99 E REGIMENTO ESCOLAR";
   $sep_prog = "\n";
  }
 }
 $pdf->multicell(76,4,($ed61_t_obs!=""?$ed61_t_obs."\n":"").($obs_prog!=""?$obs_prog."\n":"").($obs_cons!=""?$obs_cons."\n":""),"LR","J",0,0);
}
$pdf->Output();
?>
