<?
include("fpdf151/pdf.php");
$pdf = new PDF();
function iniciar($cols = 1) {
  global $pdf;
  $pdf->Open();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  if($cols == 1)
    $pdf->SetFont('Courier','',11);
  else
    $pdf->SetFont('Courier','',6.8);
}
function linha($str="") {
  global $pdf;
  if($str == "P")
    $pdf->AddPage();  
  else {
    $pdf->SetY(($pdf->GetY() + 3));
    $pdf->Text(10,$pdf->GetY(),$str);
  }
}
function fim($arq = "") {
  global $pdf;
  if($arq != "")
    $pdf->Output($arq);
  $pdf->Output();  
}
?>