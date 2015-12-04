<?
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
define('FPDF_FONTPATH','fpdf151/font/');
require('fpdf151/fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
    //Logo
    $this->Image('imagens/logocampobom.png',8,4,30);
    //Arial bold 15
//    $this->SetFont('Arial','B',15);
    //Move to the right
  //  $this->Cell(80);
    //Title
 //   $this->Cell(30,10,'Title',1,0,'C');
    //Line break
    $this->Ln(10);
}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'página '.$this->PageNo().' de {nb}',0,0,'C');
}
}

if(!file_exists($arquivo)) {
  echo "<script> 
  alert('Codigo nao Encontrado.');
  window.close();
  </script>";
  exit;
}
//Instanciation of inherited class
$pdf=new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$arq = file($arquivo);
$tam = sizeof($arq);
$tamfonte = 6.5;
$pdf->SetFont('Courier','',$tamfonte);
for($i = 0;$i < $tam;$i++) {
  $xarq = $arq[$i];
  $arq[$i] = str_replace("C".chr(8).",","Ç",$arq[$i]);
  $arq[$i] = str_replace("c".chr(8).",","ç",$arq[$i]);
  $arq[$i] = str_replace(chr(15),"",$arq[$i]);
  $arq[$i] = str_replace(chr(18),"",$arq[$i]);
  $arq[$i] = str_replace(chr(8),"",$arq[$i]);
  $arq[$i] = str_replace(chr(12),"",$arq[$i]);
  $arq[$i] = str_replace("\n","",$arq[$i]);
  if(strrchr($xarq,chr(18)) && strpos($xarq,chr(18)) < (strlen($xarq)/2)) {
    $tamfonte = 10.5;
  }
  if(strrchr($xarq,chr(15)) && strpos($xarq,chr(15)) < (strlen($xarq)/2)) {
    $tamfonte = 6.5;
  }
  $pdf->SetFont('Courier','',$tamfonte);
  $pdf->Cell(0,3,$arq[$i],0,1);
  if(strrchr($xarq,chr(18)) && strpos($xarq,chr(18)) == (strlen($xarq) - 2)) {
    $tamfonte = 10.5;
  }
  if(strrchr($xarq,chr(15)) && strpos($xarq,chr(15)) == (strlen($xarq) - 2)) {
    $tamfonte = 6.5;
  }	
  if(strrchr($xarq,chr(12)) && $i != ($tam - 1)) {
     $pdf->AddPage();
  }
}

$pdf->Output();
//header('Content-Type: application/pdf');
?> 