<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");

$clrotulo = new rotulocampo;
$clrotulo->label('r06_codigo');
$clrotulo->label('r06_descr');
$clrotulo->label('r06_elemen');
$clrotulo->label('r06_pd');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;
$ano = 2005;
$mes = 7;


$head3 = "CADASTRO DE CÓDIGOS";
$head5 = "PERÍODO : ".$mes." / ".$ano;

$sql = "
select r70_codigo,r70_estrut,r70_descr,substr(r70_estrut,8,2) as tipo from rhlota where substr(r70_estrut,8,2) in ('25','26') order by substr(r70_estrut,8,2),r70_codigo 
       ";
//echo $sql ; exit;

$result = pg_exec($sql);
$xxnum = pg_numrows($result);
if ($xxnum == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Códigos cadastrados no período de '.$mes.' / '.$ano);

}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
for($x = 0; $x < pg_numrows($result);$x++){
   db_fieldsmemory($result,$x);
   if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
      $pdf->addpage();
      $pdf->setfont('arial','b',8);
      $pdf->cell(15,$alt,'CÓDIGO',1,0,"C",1);
      $pdf->cell(25,$alt,'ESTRUTURAL',1,0,"C",1);
      $pdf->cell(80,$alt,'DESCRIÇÃO',1,0,"C",1);
      $pdf->cell(20,$alt,'REDUZ',1,1,"C",1);
      $total = 0;
      $troca = 0;
   }
   $pdf->setfont('arial','',7);
   $pdf->cell(15,$alt,$r70_codigo,0,0,"C",0);
   $pdf->cell(25,$alt,$r70_estrut,0,0,"L",0);
   $pdf->cell(80,$alt,$r70_descr,0,0,"L",0);
   $pdf->cell(20,$alt,$tipo,0,1,"L",0);
}
//$pdf->setfont('arial','b',8);
//$pdf->cell(80,$alt,'TOTAL DO BANCO',"T",0,"C",0);
//$pdf->cell(20,$alt,'',"T",0,"C",0);
//$pdf->cell(30,$alt,db_formatar($total,'f'),"T",1,"R",0);

$pdf->Output();
   
?>
