<?php

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

$itens = db_query("select distinct on (pc01_codmater) pc01_codmater, * from pcmater
inner join pcmaterele on pc01_codmater = pc07_codmater
inner join orcelemento on pc07_codele = o56_codele where pc01_codmater in ($codigoitens)");

$head3 = "RELATÓRIO DOS ITENS IMPORTADOS";
$head5 = "DATA: $data";
$head6 = "IMPORTAÇÃO: $codigoimportacao - " . utf8_decode($descricao);

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
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

$pdf->cell(20, 6, "Código do Item", 1, 0, "C", 1);
$pdf->cell(70, 6, "Descrição", 1, 0, "C", 1);
$pdf->cell(70, 6, "Complemento", 1, 0, "C", 1);
$pdf->cell(30, 6, "Desdobramento", 1, 1, "C", 1);
$pdf->setfont('arial', '', 7);
$pdf->x = 10;

for ($i = 0; $i < pg_numrows($itens); $i++) {
    $item = db_utils::fieldsmemory($itens, $i);
    $pdf->cell(20, 6, $item->pc01_codmater, 1, 0, "C", 0);
    if (strlen($item->pc01_descrmater) > 43) {
        $pdf->cell(70, 6, substr($item->pc01_descrmater, 0, 43) . "...", 1, 0, "L", 0);
    } else {
        $pdf->cell(70, 6, substr($item->pc01_descrmater, 0, 43), 1, 0, "L", 0);
    }
    if (strlen($item->pc01_complmater) > 43) {
        $pdf->cell(70, 6, substr($item->pc01_complmater, 0, 43) . "...", 1, 0, "L", 0);
    } else {
        $pdf->cell(70, 6, substr($item->pc01_complmater, 0, 43), 1, 0, "L", 0);
    }
    $pdf->cell(30, 6, $item->o56_elemento,    1, 1, "C", 0);
}




$pdf->Output();
