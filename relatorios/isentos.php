<?
include("fpdf151/pdf1.php");
$pdf = new PDF1(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
//$pdf->AddPage(); 
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
$head1 = "RELATÓRIO DE ISENÇÕES";
/*$sql = "
select distinct proprietario.*
from iptuisen
     inner join proprietario on j46_matric = j01_matric
where j46_tipo = 2
order by z01_nome;

";*/
$sql = "
select distinct proprietario.*
from iptuisen
     inner join proprietario on j46_matric = j01_matric

order by z01_nome;

";

$result = pg_exec($sql);
$num = pg_numrows($result);
// j23_matric, z01_nome, percentual, valordb, valorsap, diferenca
$linha = 60;
//$pdf->MultiCell(0,4,"teste",0,"J",0,0);
$pre = 0;
$total = 0;
$pagina = 0;
for($i=0;$i<$num;$i++) {
   if($linha++>45){
      $linha = 0;
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',10);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(12,6,"INSC.",1,0,"C",1);
      $pdf->Cell(60,6,"NOME",1,0,"C",1);
      $pdf->Cell(12,6,"ZONA",1,0,"C",1);
      $pdf->Cell(12,6,"SETOR",1,0,"C",1);
      $pdf->Cell(12,6,"QUAD",1,0,"C",1);
      $pdf->Cell(12,6,"LOTE",1,0,"C",1);
      $pdf->Cell(60,6,"ENDEREÇO",1,1,"C",1);
//      $pdf->Cell(25,6,"VALOR",1,1,"L",1);
      $pagina = $pdf->PageNo();
   }
   if($linha % 2 == 0){
     $pre = 0;
   }else {
     $pre = 1;
   }
   db_fieldsmemory($result,$i);
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(12,4,$j01_matric,0,0,"C",0);
   $pdf->Cell(60,4,$z01_nome,0,0,"L",0);
   $pdf->Cell(12,4,$j37_zona,0,0,"C",0);
   $pdf->Cell(12,4,$j34_setor,0,0,"C",0);
   $pdf->Cell(12,4,$j34_quadra,0,0,"C",0);
   $pdf->Cell(12,4,$j34_lote,0,0,"C",0);
   $pdf->Cell(60,4,$z01_ender.', '.$z01_numero,0,1,"L",0);
   $total += 1;
}
$pdf->Ln(5);
$pdf->Cell(95,6,"Total :    ".$total,0,1,"L",0);
$pdf->Output();

?>
