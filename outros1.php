<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$ano = 2006;
$mes = 4;


$head2 = "BENS CADASTRADOS";
//$head3 = "LOTACOES ENTRE 1400 E 1499";


$sql = "
select t52_dtaqu,trim(t64_class) as t64_class,t52_ident,t52_descr,t52_obs,t52_valaqu
from bens inner join clabens on t52_codcla=t64_codcla order by t52_descr
"; 
$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if($xxnum == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não nenhum registro encontrado no período de '.$mes.' / '.$ano);
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfont('arial','b',8);
$troca = 1;
$total = 0;
$alt = 4;
$xsec = 0;
$pdf->setfillcolor(235);
$xtot =  '';
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,'CLASSIF',1,0,"C",1);
      $pdf->cell(15,$alt,'PLACA',1,0,"C",1);
      $pdf->cell(105,$alt,'DESCRIÇÃO',1,0,"C",1);
      $pdf->cell(20,$alt,'AQUISICAO',1,0,"C",1);
      $pdf->cell(20,$alt,'VALOR',1,1,"C",1);
      $troca = 0;
      $pre = 1;
   }
   if($pre == 1){
     $pre = 0;
   }else{
     $pre = 1;
   }  
   if($xtot != $t52_descr && $x > 0){
     $xtot = $t52_descr;
     $pdf->setfont('arial','b',8);
     $pdf->cell(175,$alt,'TOTAL DE REGISTROS '.$total,"T",1,"L",0);
     $total = 0;
     
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$t64_class,0,0,"C",$pre);
   $pdf->cell(15,$alt,$t52_ident,0,0,"L",$pre);
   $pdf->cell(105,$alt,$t52_descr,0,0,"L",$pre);
   $pdf->cell(20,$alt,db_formatar($t52_dtaqu,'d'),0,0,"L",$pre);
   $pdf->cell(20,$alt,db_formatar($t52_valaqu,'f'),0,1,"R",$pre);
   $total++;
}
$pdf->setfont('arial','b',8);
$pdf->cell(175,$alt,'TOTAL DE REGISTROS '.$total,"T",0,"L",0);
$pdf->Output();
?>
