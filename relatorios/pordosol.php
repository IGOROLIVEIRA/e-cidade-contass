<?
include("fpdf151/pdf1.php");
$pdf = new PDF1(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
//$pdf->AddPage(); 
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
$head1 = "RELATÓRIO DEVEDORES LOTEAMENTO ";
$head2 = "POR DO SOL ATÉ 31/12/" . db_getsession("DB_anousu");
/*$sql = "
select distinct proprietario.*
from iptuisen
     inner join proprietario on j46_matric = j01_matric
where j46_tipo = 2
order by z01_nome;

";*/
$sql = "
select k00_numcgm,z01_nome,round(sum(sum),2) as valor from(
select a.k00_numcgm,
       z01_nome,
       sum(a.k00_valor)
from arrecad a
     inner join diversos b on a.k00_numpre = b.k00_numpre and b.procdiver = 221
     inner join cgm c on c.z01_numcgm = a.k00_numcgm
where a.k00_dtvenc < '" . db_getsession("DB_anousu") . "-01-01'
group by a.k00_numcgm,c.z01_nome
union
select a.k00_numcgm,
       z01_nome,
       sum(a.k00_valor)
from arrepaga a
     inner join diversos b on a.k00_numpre = b.k00_numpre and b.procdiver = 221
     inner join cgm c on c.z01_numcgm = a.k00_numcgm
where a.k00_dtpaga > '2003-12-31'
group by a.k00_numcgm,c.z01_nome) as x
group by k00_numcgm,z01_nome
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
      $pdf->Cell(20,6,"NUMCGM",1,0,"C",1);
      $pdf->Cell(60,6,"NOME",1,0,"C",1);
      $pdf->Cell(30,6,"VALOR",1,1,"C",1);
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
   $pdf->Cell(20,4,$k00_numcgm,0,0,"C",0);
   $pdf->Cell(60,4,$z01_nome,0,0,"L",0);
   $pdf->Cell(30,4,db_formatar($valor,'f'),0,1,"R",0);
   $total += $valor;
}
$pdf->Ln(5);
$pdf->Cell(80,6,"Total :",0,0,"C",0);
$pdf->Cell(30,6,db_formatar($total,'f'),0,1,"R",0);
$pdf->Output();

?>
