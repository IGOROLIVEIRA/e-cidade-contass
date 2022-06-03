<?
require("fpdf151/pdf.php");

class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

  function SetWidths($w)
  {
    //Set the array of column widths
    $this->widths = $w;
  }

  function SetAligns($a)
  {
    //Set the array of column alignments
    $this->aligns = $a;
  }



  function CheckPageBreak($h)
  {
    //If the height h would cause an overflow, add a new page immediately
    if ($this->GetY() + $h > $this->PageBreakTrigger)
      $this->AddPage($this->CurOrientation);
  }

  function NbLines($w, $txt)
  {
    //Computes the number of lines a MultiCell of width w will take
    $cw = &$this->CurrentFont['cw'];
    if ($w == 0)
      $w = $this->w - $this->rMargin - $this->x;
    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
    $s = str_replace("\r", '', $txt);
    $nb = strlen($s);
    if ($nb > 0 and $s[$nb - 1] == "\n")
      $nb--;
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $nl = 1;
    while ($i < $nb) {
      $c = $s[$i];
      if ($c == "\n") {
        $i++;
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
        continue;
      }
      if ($c == ' ')
        $sep = $i;
      $l += $cw[$c];
      if ($l > $wmax) {
        if ($sep == -1) {
          if ($i == $j)
            $i++;
        } else
          $i = $sep + 1;
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
      } else
        $i++;
    }
    return $nl;
  }
}




$pdf = new PDF_MC_Table();

$pdf->AddPage();
$pdf->SetFont('Arial', '', 16);
$pdf->Cell(20, 7, 'Hi1', 1);
$pdf->Cell(20, 7, 'Hi2', 1);
$pdf->Cell(20, 7, 'Hi3', 1);

$pdf->Ln();

$pdf->Cell(20, 7, 'Hi4', 1);
$pdf->Cell(20, 7, 'Hi5(xtra)', 1);
$pdf->Cell(20, 7, 'Hi5', 1);

$pdf->Output();
