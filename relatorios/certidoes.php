<?
include("fpdf151/pdf1.php");
$pdf = new PDF1(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
//$pdf->AddPage(); 
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
$head1 = "RELATÓRIO DE CERTIDÕES EMITIDAS";
$sql = "
select a.*, cgm.z01_nome from (
   select certid.v13_certid, inicialcert.inicial,
           case when divida.v01_numcgm is not null then divida.v01_numcgm else termo.v07_numcgm end as numcgm,
           case when divida.v01_numcgm is not null then 'divida normal' else 'parcelamento' end as tipo,
           case when divida.v01_numcgm is not null then certdiv.v14_coddiv else certter.v14_parcel end as origem
           from certid
           left outer join certdiv on certdiv.v14_certid = certid.v13_certid
                   left outer join divida on divida.v01_coddiv = certdiv.v14_coddiv
           left outer join certter on certter.v14_certid = certid.v13_certid
                   left outer join termo on termo.v07_parcel = certter.v14_parcel
           left outer join inicialcert on inicialcert.certidao = certid.v13_certid
) as a

        inner join cgm on cgm.z01_numcgm = a.numcgm
order by z01_nome
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
      $pdf->Cell(15,6,"NUMCGM",1,0,"C",1);
      $pdf->Cell(80,6,"NOME",1,0,"C",1);
      $pdf->Cell(15,6,"CERT.",1,0,"L",1);
      $pdf->Cell(30,6,"TIPO",1,0,"C",1);
      $pdf->Cell(15,6,"ORIGEM",1,0,"C",1);
      $pdf->Cell(15,6,"INICIAL",1,1,"C",1);
      $pagina = $pdf->PageNo();
   }
   if($linha % 2 == 0){
     $pre = 0;
   }else {
     $pre = 1;
   }
   db_fieldsmemory($result,$i);
   $pdf->SetFont('Arial','',7);
   $pdf->cell(15,4,$numcgm,0,0,"R",$pre);
   $pdf->cell(80,4,$z01_nome,0,0,"L",$pre);
   $pdf->cell(15,4,$v13_certid,0,0,"R",$pre);
   $pdf->cell(30,4,$tipo,0,0,"L",$pre);
   $pdf->cell(15,4,$origem,0,0,"R",$pre);
   $pdf->cell(15,4,$inicial,0,1,"R",$pre);
   $total += 1;
}
$pdf->Ln(5);
$pdf->Cell(100,6,"Total de Registros : ".$total,0,1,"L",0);
$pdf->Output();

?>
