<?
include("fpdf151/pdf1.php");
$pdf = new PDF1(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
//$pdf->AddPage(); 
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
$head1 = "RELATÓRIO DO CGM (OUTROS)";
$sql = "
       select j01_matric, 
              z01_numcgm, 
	      z01_nome 
       from iptubase 
            inner join cgm 
                  on z01_numcgm = j01_numcgm 
       where z01_nome like '%OUTRO%'";

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
//      $pdf->MultiCell(0,10,"RELATÓRIO DO CGM (OUTROS)",0,"C",0);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(20,6,"MATRICULA",1,0,"C",1);
      $pdf->Cell(20,6,"NUMCGM",1,0,"C",1);
      $pdf->Cell(80,6,"NOME",1,1,"C",1);
      $pagina = $pdf->PageNo();
   }
   if($linha % 2 == 0){
     $pre = 0;
   }else {
     $pre = 1;
   }
   db_fieldsmemory($result,$i);
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(20,4,$j01_matric,0,0,"R",$pre);
   $pdf->cell(20,4,$z01_numcgm,0,0,"R",$pre);
   $pdf->cell(80,4,$z01_nome,0,1,"c",$pre);
   $total += 1;
}
$pdf->Ln(5);
$pdf->Cell(100,6,"Total de Registros : ".$total,0,1,"L",0);
$pdf->Output();

?>
