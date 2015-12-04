<?
include("fpdf151/pdf1.php");
$pdf = new PDF1(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
//$pdf->AddPage(); 
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
$head1 = "RELATÓRIO DO IPTU CALCULADO";
$sql = "
select j21_receit,
       k02_drecei,
       round(sum(j21_valor),2) as valor
from iptucalv
     inner join tabrec on j21_receit = k02_codigo
group by j21_receit,k02_drecei;
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
      $pdf->Cell(15,6,"RECEITA",1,0,"C",1);
      $pdf->Cell(80,6,"DESCRIÇÃO",1,0,"C",1);
      $pdf->Cell(25,6,"VALOR",1,1,"L",1);
      $pagina = $pdf->PageNo();
   }
   if($linha % 2 == 0){
     $pre = 0;
   }else {
     $pre = 1;
   }
   db_fieldsmemory($result,$i);
   $pdf->SetFont('Arial','',7);
   $pdf->cell(15,4,$j21_receit,0,0,"R",$pre);
   $pdf->cell(80,4,$k02_drecei,0,0,"L",$pre);
   $pdf->cell(25,4,db_formatar($valor,'f'),0,1,"R",$pre);
   $total += $valor;
}
$pdf->Ln(5);
$pdf->Cell(95,6,"           Total : ",0,0,"L",0);
$pdf->Cell(25,6,db_formatar($total,'f'),0,1,"L",0);
$pdf->Output();

?>
