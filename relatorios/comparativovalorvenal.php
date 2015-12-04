<?
include("fpdf151/scpdf.php");
$pdf = new SCPDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$pdf->AddPage(); 
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
$head1 = "COMPARATIVO DO VALOR VENAL";
$sql = "
	select j23_matric, z01_nome, percentual, valordb, valorsap, diferenca from
		(select * from 
			(select j23_matric, round(valordb / valorsap * 100 - 100,2) as percentual, valordb, valorsap, round(valordb - valorsap,2) as diferenca from 
				(select j23_matric, valordb, valorsap from 
					(select j23_matric, valordb, case when valorsap is null then case when valordb is null then 1 else valordb end else valorsap end as valorsap from 
						(select j23_matric, valordb, val as valorsap from 
							(select j23_matric, sum(j23_vlrter) as valordb from 
								(select j23_matric, sum(j23_vlrter) as j23_vlrter from 
									iptucalc group by j23_matric
								union
								select j22_matric, sum(j22_valor) as j22_valor from 
									iptucale group by j22_matric)
							as x group by j23_matric)
						as y left outer join listagem on j23_matric = matric)
					 as z where valorsap <> 0)
				as a where valorsap <> 0)
			 as c order by percentual desc) as d
		order by diferenca desc) as e
	inner join iptubase on j23_matric = j01_matric inner join cgm on z01_numcgm = j01_numcgm
order by z01_nome 
       ";
//where abs(percentual) > 5
//    ";
$result = pg_exec($sql);
$num = pg_numrows($result);
// j23_matric, z01_nome, percentual, valordb, valorsap, diferenca
$linha = 0;
//$pdf->MultiCell(0,4,"teste",0,"J",0,0);
$pre = 0;
$total = 0;
$pagina = 0;

$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(0,10,"COMPARATIVO DO VALOR VENAL",0,"C",0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,6,"MATRICULA",1,0,"C",0);
$pdf->Cell(80,6,"NOME",1,0,"C",0);
$pdf->Cell(20,6,"PERC.",1,0,"C",0);
$pdf->Cell(20,6,"VENAL 2004",1,0,"C",0);
$pdf->Cell(20,6,"VENAL 2003",1,0,"C",0);
$pdf->Cell(20,6,"DIFERENÇA",1,1,"C",0);

for($i=0;$i<$num;$i++) {
   if($pdf->GetY() > ( $pdf->h - 30 )){
      $pdf->Text($pdf->w-20,$pdf->h-5, $pdf->PageNo());
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',10);
      $pdf->MultiCell(0,10,"COMPARATIVO DO VALOR VENAL",0,"C",0);
      $pdf->SetFont('Arial','B',9);
      $pdf->Cell(20,6,"MATRICULA",1,0,"C",0);
      $pdf->Cell(80,6,"NOME",1,0,"C",0);
      $pdf->Cell(20,6,"PERC.",1,0,"C",0);
      $pdf->Cell(20,6,"VENAL 2004",1,0,"C",0);
      $pdf->Cell(20,6,"VENAL 2003",1,0,"C",0);
      $pdf->Cell(20,6,"DIFERENÇA",1,1,"C",0);
      $linha = 0;
   }
   if($linha % 2 == 0){
     $pre = 1;
   }else {
     $pre = 0;
   }
   db_fieldsmemory($result,$i);
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(20,4,$j23_matric,0,0,"C",$pre);
   $pdf->cell(80,4,$z01_nome,0,0,"c",$pre);
   $pdf->Cell(20,4,db_formatar($percentual,'f'),0,0,"R",$pre);
   $pdf->Cell(20,4,db_formatar($valordb,'f'),0,0,"R",$pre);
   $pdf->Cell(20,4,db_formatar($valorsap,'f'),0,0,"R",$pre);
   $pdf->Cell(20,4,db_formatar($diferenca,'f'),0,1,"R",$pre);
   $total += 1;
   $linha += 1;
}
$pdf->Ln(5);
$pdf->Cell(100,6,"Total de Registros : ".$total,0,1,"L",0);
$pdf->Output();

?>
