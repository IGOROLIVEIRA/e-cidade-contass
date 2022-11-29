<?php
//ini_set('display_errors','on');
//require_once("fpdf151/fpdf.php");
include("fpdf151/pdf.php");
require_once("std/DBDate.php");
include("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_pcproc_classe.php");
db_postmemory($HTTP_GET_VARS);



$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(235);
$pdf->addpage('P');
$alt = 3;
$pdf->SetFont('arial', 'B', 14);
$pdf->ln($alt + 6);
$pdf->x = 30;
$pdf->Cell(160, 6, "ITENS IMPORTADOS", 0, 1, "C", 0);

$pdf->SetFont('arial', 'B', 7);

$pdf->ln($alt + 3);
$pdf->x = 10;

$pdf->cell(30, 6, "Código do Item", 1, 0, "C", 1);
$pdf->cell(60, 6, "Descrição", 1, 0, "C", 1);
$pdf->cell(60, 6, "Complemento", 1, 0, "C", 1);
$pdf->cell(40, 6, "Desdobramento", 1, 1, "C", 1);
$pdf->setfont('arial', '', 9);
$pdf->x = 10;


$pdf->cell(30, 6, "teste", 1, 0, "C", 0);
$pdf->cell(60, 6, "teste", 1, 0, "C", 0);
$pdf->cell(60, 6, "teste",     1, 0, "C", 0);
$pdf->cell(40, 6, "teste",    1, 1, "C", 0);


$pdf->Output();
