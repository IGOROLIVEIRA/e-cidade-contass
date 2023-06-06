<?php

require_once("fpdf151/pdf.php");

/* Consulta para informações da licitação. */

$rsLicitacao = db_query("
select
	l20_edital,
	l20_numero,
	l03_descr,
	l20_dtpubratificacao,
	l20_objeto,
    l20_anousu
from
	liclicita
inner join cflicita on
	l20_codtipocom = l03_codigo
where
	l20_codigo = $l20_codigo;");

$liclicita = db_utils::fieldsMemory($rsLicitacao, 0);

$rsItensCredenciados = db_query("
select
	*
from
	liclicitem
inner join pcprocitem on
	pc81_codprocitem = l21_codpcprocitem
inner join pcorcamitemproc on
	pc31_pcprocitem = pc81_codprocitem
inner join itemprecoreferencia on
	si02_itemproccompra = pc31_orcamitem
inner join credenciamento on
	l205_item = l21_codpcprocitem
inner join cgm on
	l205_fornecedor = z01_numcgm
inner join solicitempcmater on
	pc16_solicitem = pc81_solicitem
inner join solicitem on 
	pc11_codigo = pc16_solicitem
inner join pcmater on
	pc16_codmater = pc01_codmater
inner join matunid on
	si02_codunidadeitem = m61_codmatunid
where
	l21_codliclicita = $l20_codigo
order by
	pc11_seq,l205_fornecedor;
");


$head3 = "RELATÓRIO DE CREDENCIADOS";

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(235);
$pdf->addpage('P');
$alt = 3;
$pdf->SetFont('arial', 'B', 12);
$pdf->ln(6);

$pdf->setfont('arial', 'b', 8);
$pdf->cell(20, 3, 'PROCESSO:', 0, 0, "R", 0);
$pdf->setfont('arial', '', 8);
$pdf->cell(60, 3, "$liclicita->l20_edital/$liclicita->l20_anousu", 0, 1, "L", 0);
$pdf->ln(1);

$pdf->setfont('arial', 'b', 8);
$pdf->cell(36.6, 3, 'DATA DE RATIFICAÇÃO:', 0, 0, "R", 0);
$pdf->setfont('arial', '', 8);
$pdf->cell(60, 3, implode('/', array_reverse(explode('-', $liclicita->l20_dtpubratificacao))), 0, 1, "L", 0);
$pdf->ln(1);

$pdf->setfont('arial', 'b', 8);
$pdf->cell(23, 3, 'MODALIDADE:', 0, 0, "R", 0);
$pdf->setfont('arial', '', 8);
$pdf->cell(60, 3, "$liclicita->l20_numero - $liclicita->l03_descr", 0, 1, "L", 0);
$pdf->ln(1);

$pdf->setfont('arial', 'b', 8);
$pdf->cell(15.4, 3, 'OBJETO:', 0, 0, "R", 0);
$pdf->setfont('arial', '', 8);
$pdf->MultiCell(180, 3, $liclicita->l20_objeto, 0, "L", 0);

$pdf->Line(10,  $pdf->GetY(), 200,  $pdf->GetY());

$pdf->ln(5);

$fornecedor;
$total = 0;

for ($i = 0; $i < pg_numrows($rsItensCredenciados); $i++) {
    $item = db_utils::fieldsMemory($rsItensCredenciados, $i);

    if ($fornecedor != $item->l205_fornecedor) {
        $pdf->ln(3);
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(160, 6, "$item->z01_nome - CNPJ: $item->z01_cgccpf - Data do Credenciamento: " . implode('/', array_reverse(explode('-', $item->l205_datacred))), 0, 1, "L", 0);
        $pdf->setfont('arial', 'B', 7);
        $pdf->cell(20, 6, "Item", 1, 0, "C", 1);
        $pdf->cell(90, 6, "Descrição", 1, 0, "C", 1);
        $pdf->cell(20, 6, "Unidade", 1, 0, "C", 1);
        $pdf->cell(20, 6, "Quantidade", 1, 0, "C", 1);
        $pdf->cell(20, 6, "Valor Unitário", 1, 0, "C", 1);
        $pdf->cell(20, 6, "Valor Total", 1, 0, "C", 1);
        $fornecedor = $item->l205_fornecedor;
        $total = 0;
        $pdf->ln(6);
    }

    $altura = $pdf->NbLines(90, $item->pc01_descrmater);

    $pdf->cell(20, 5 * $altura, $item->pc11_seq, 1, 0, "C", 0);
    $y =  $pdf->GetY();
    $pdf->MultiCell(90, 5, $item->pc01_descrmater, 1, "L", 2);
    $pdf->SetY($y);
    $pdf->SetX(120);
    $pdf->cell(20, 5 * $altura, $item->m61_descr, 1, 0, "C", 0);
    $pdf->cell(20, 5 * $altura, $item->si02_qtditem, 1, 0, "C", 0);
    $pdf->cell(20, 5 * $altura, 'R$ ' . number_format($item->si02_vlprecoreferencia, 2, ',', '.'), 1, 0, "C", 0);
    $pdf->cell(20, 5 * $altura, 'R$ ' . number_format($item->si02_vltotalprecoreferencia, 2, ',', '.'), 1, 1, "C", 0);

    $total += $item->si02_vltotalprecoreferencia;
    $proximofornecedor = db_utils::fieldsMemory($rsItensCredenciados, $i + 1)->l205_fornecedor;

    if ($proximofornecedor != $item->l205_fornecedor) {
        $total = 'R$ ' . number_format($total, 2, ',', '.');
        $pdf->cell(20, 6, "Total:  $total", 0, 0, "L", 0);
        $pdf->ln(6);
    }
}

$pdf->Output();
