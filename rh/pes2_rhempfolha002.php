<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("classes/db_rhempfolha_classe.php");
include("classes/db_rhrubelementoprinc_classe.php");
include("classes/db_rhlotaexe_classe.php");
include("classes/db_rhlotavinc_classe.php");
include("classes/db_rhlotavincele_classe.php");
include("classes/db_rhlotavincativ_classe.php");
include("classes/db_orcdotacao_classe.php");
include("classes/db_orcelemento_classe.php");
include("classes/db_orcparametro_classe.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_orcunidade_classe.php");
include("classes/db_orcprojativ_classe.php");
include("classes/db_orctiporec_classe.php");
$clrhrubelementoprinc = new cl_rhrubelementoprinc;
$clrhlotaexe = new cl_rhlotaexe;
$clrhempfolha = new cl_rhempfolha;
$clrhlotavinc = new cl_rhlotavinc;
$clrhlotavincele = new cl_rhlotavincele;
$clrhlotavincativ = new cl_rhlotavincativ;
$clorcdotacao = new cl_orcdotacao;
$clorcelemento = new cl_orcelemento;
$clorcparametro = new cl_orcparametro;
$clorcorgao = new cl_orcorgao;
$clorcunidade = new cl_orcunidade;
$clorcprojativ = new cl_orcprojativ;
$clorctiporec = new cl_orctiporec;
db_postmemory($HTTP_POST_VARS);

$passa = false;

if($ponto == 's'){
  $descrarq = "Salário";
  $arquivo = 'gerfsal';
  $sigla   = 'r14_';
  $siglaarq= 'r14';
}elseif($ponto == 'c'){
  $descrarq = "Complementar";
  $arquivo = 'gerfcom';
  $sigla   = 'r48_';
  $siglaarq= 'r48';
}elseif($ponto == 'a'){
  $descrarq = "Adiantamento";
  $arquivo = 'gerfadi';
  $sigla   = 'r22_';
  $siglaarq= 'r22';
}elseif($ponto == 'r'){
  $descrarq = "Rescisão";
  $arquivo = 'gerfres';
  $sigla   = 'r20_';
  $siglaarq= 'r20';
}elseif($ponto == 'd'){
  $descrarq = "13o. Salário";
  $arquivo = 'gerfs13';
  $sigla   = 'r35_';
  $siglaarq= 'r35';
}

if($tipo=="n"){
  $descrtipo = "Salário";
}else if($tipo=="p"){
  $descrtipo = "Previdência";
}else{
  $descrtipo = "FGTS";
}

$head2 = "RELATÓRIO DE EMPENHOS DA FOLHA";
$head4 = "ANO / MÊS: $ano / $mes";
$head5 = "ARQUIVO: $descrarq";
$head6 = "TIPO EMPENHO: $descrtipo";

if($mostra=="a"){
  $head8 = "Analítico";
  $groupby = " rh40_orgao, rh40_unidade, rh40_projativ, rh40_codele, rh40_recurso ";
  $campos  = " rh40_orgao, rh40_unidade, rh40_projativ, rh40_codele, rh40_recurso, sum(rh40_provento) as rh40_provento, sum(rh40_desconto) as rh40_desconto ";
}else{
  $head8 = "Sintético";
  $groupby = " rh40_orgao, rh40_unidade, rh40_projativ, rh40_codele, rh40_recurso, rh40_rubric,rh40_coddot ";
  $campos  = " rh40_orgao, rh40_unidade, rh40_projativ, rh40_codele, rh40_recurso, rh40_rubric,rh40_coddot, sum(rh40_provento) as rh40_provento, sum(rh40_desconto) as rh40_desconto";
}

//echo $clrhempfolha->sql_query_file(null,null,null,null,null,null,null,null,"$campos","$groupby","rh40_anousu=$ano and rh40_mesusu=$mes and rh40_tipo='$tipo' and rh40_siglaarq='$siglaarq' group by $groupby "); exit;
$result_confirma = $clrhempfolha->sql_record($clrhempfolha->sql_query_file(null,null,null,null,null,null,null,null,"$campos","$groupby","rh40_anousu=$ano and rh40_mesusu=$mes and rh40_tipo='$tipo' and rh40_siglaarq='$siglaarq' group by $groupby "));
//db_criatabela($result_confirma); 
$numrows_confirma = $clrhempfolha->numrows;
if($clrhempfolha->numrows==0){
  db_redireciona("db_erros.php?fechar=true&db_erro=Arquivo não encontrado.");
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->addpage();
$total = 0;
$troca = 1;
$alt = 4;

// Variáveis que testam código anterior impresso e se devem ou não imprimir
$iorgao = false;
$oorgao = "";
$iunida = false;
$ounida = "";
$iproja = false;
$oproja = "";
$ieleme = false; 
$oeleme = "";
$irecur = false; 
$orecur = "";

$totalorgao = 0;
for($i==0;$i<$numrows_confirma;$i++){
  db_fieldsmemory($result_confirma,$i);  

  // Busca orgao
  $result_orgao = $clorcorgao->sql_record($clorcorgao->sql_query_file($ano,$rh40_orgao,"o40_codtri,o40_descr"));
  if($clorcorgao->numrows==0){
    continue;
  }
  db_fieldsmemory($result_orgao,0);
  ////////////////////////



  // Busca unidade
  $result_unida = $clorcunidade->sql_record($clorcunidade->sql_query_file($ano,$rh40_orgao,$rh40_unidade,"o41_codtri,o41_descr"));
  if($clorcunidade->numrows==0){
    continue;
  }
  db_fieldsmemory($result_unida,0);
  ////////////////////////



  // Busca proj/ativ
  $result_proja = $clorcprojativ->sql_record($clorcprojativ->sql_query_file($ano,$rh40_projativ,"o55_projativ,o55_descr"));
  if($clorcprojativ->numrows==0){
    continue;
  }
  db_fieldsmemory($result_proja,0);
  ////////////////////////



  // Busca elemento
  $result_eleme = $clorcelemento->sql_record($clorcelemento->sql_query_file($rh40_codele,db_getsession("DB_anousu"),"o56_elemento,o56_descr"));
  if($clorcelemento->numrows==0){
    continue;
  }
  db_fieldsmemory($result_eleme,0);
  ////////////////////////



  // Busca recurso
  $result_recur = $clorctiporec->sql_record($clorctiporec->sql_query_file($rh40_recurso,"o15_codtri,o15_descr"));
  if($clorctiporec->numrows==0){
    continue;
  }
  db_fieldsmemory($result_recur,0);
  ////////////////////////

  $pdf->setfont('arial','b',8);
  if($oorgao!=$rh40_orgao){ 
    // Imprime orgao
    if($oorgao!=""){
      $pdf->cell(135,$alt,"Valor total","B",0,"R",1);
      $pdf->cell( 25,$alt,db_formatar($totalorgao,"f"),"B",1,"R",1);
      $pdf->cell(160, 0.1,"       ",0,1,"L",0);
      $pdf->ln(1);
      $totalorgao = 0;
    }
    $pdf->cell( 10,$alt,$o40_codtri,"T",0,"L",1);
    $pdf->cell(150,$alt,$o40_descr ,"T",1,"L",1);
    $oorgao = $rh40_orgao;
    $iunida = true;
    ////////////////////////
  }


  
  $pdf->setfont('arial','b',7);
  if($ounida!=$rh40_unidade || $iunida==true){
    // Imprime unidade
    $linhaT = "";
    $parent = "";
    if($iunida==false){
      $linhaT = "T";
      $parent = "($o40_codtri - $o40_descr)";
    }
    $pdf->cell(10,$alt,$o40_codtri.$o41_codtri,"B$linhaT",0,"L",1);
    $pdf->cell(90,$alt,$o41_descr             ,"B$linhaT",0,"L",1);
    $pdf->setfont('arial','b',4);
    $pdf->cell(60,$alt,$parent               ,"B$linhaT",1,"R",1);
    $ounida = $rh40_unidade;
    $iunida = false;
    $iproja = true; 
    ////////////////////////
  }



  $pdf->setfont('arial','b',7);  
  if($oproja!=$rh40_projativ || $iproja==true){
    // Imprime proj/ativ
    $pdf->cell( 10,$alt,$o55_projativ,0,0,"L",0);
    $pdf->cell(150,$alt,$o55_descr   ,0,1,"L",0);
    $oproja = $rh40_projativ;
    $iproja = false;
    $ieleme = true;
    ////////////////////////
  } 



  $pdf->setfont('arial','b',6);
  if($oeleme!=$rh40_codele || $ieleme==true){
    // Imprime elemento
    $pdf->cell( 20,$alt,$o56_elemento,0,0,"L",0);
    $pdf->cell( 80,$alt,$o56_descr   ,0,0,"L",0);
    $pdf->cell( 10,$alt,'Dotação :  '.$rh40_coddot ,0,1,"L",0);
    $oeleme = $rh40_codele;
    $ieleme = false;
    $irecur = true;
    ////////////////////////
  }


  
  $pdf->setfont('arial','',6);
  if($orecur!=$rh40_recurso || $irecur==true){
    // Imprime recurso
    $pdf->cell(  5,$alt,"                                              ",0,0,"C",0);
    $pdf->cell(120,$alt,$o15_codtri." - ".$o15_descr                    ,0,0,"L",0);
    $pdf->cell( 25,$alt,db_formatar(($rh40_provento-$rh40_desconto),"f"),0,1,"R",0);
    $orecur = $rh40_recurso;
    $irecur = false;
    ////////////////////////
  }
  $totalorgao += ($rh40_provento-$rh40_desconto);
}
$pdf->setfont('arial','b',8);
$pdf->cell(135,$alt,"Valor total","B",0,"R",1);
$pdf->cell( 25,$alt,db_formatar($totalorgao,"f"),"B",1,"R",1);
$pdf->cell(160,0.2,"","T",1,"C",0);
$pdf->Output();
?>