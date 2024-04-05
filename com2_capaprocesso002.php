<?
include("fpdf151/scpdf.php");
db_postmemory($HTTP_SERVER_VARS);

$sql = "select uf, db12_extenso, logo, munic, cgc, ender, bairro, numero, codigo, nomeinst
			from db_config
				inner join db_uf on db12_uf = uf
			where codigo = " . db_getsession("DB_instit");

$result = pg_query($sql);
db_fieldsmemory($result, 0);

$sqlProcesso = "SELECT pc80_codproc
FROM pcproc
WHERE pc80_codproc BETWEEN $pc80_codprocini AND $pc80_codprocfim";
$rsProcs = db_query($sqlProcesso);
$pdf = new SCPDF();
$pdf->Open();
$pdf->AliasNbPages();
for ($proc = 0; $proc < pg_num_rows($rsProcs); $proc++) {

    $aProcesosselecionados = db_utils::fieldsMemory($rsProcs, $proc);
    var_dump($aProcesosselecionados->pc80_codproc);
    echo "<br>";
    $oPcproc = new ProcessoCompras($aProcesosselecionados->pc80_codproc);

    $dataEmissao = explode("/", $oPcproc->getDataEmissao());
    $ano = $dataEmissao[2];
    $modalidade = "Dispença sem Disputa";
    if ($oPcproc->getModalidadeContratacao() == "9") {
        $modalidade = "Inexigibilidade";
    }
    $dadoscomplementares = utf8_decode($oPcproc->getDadosComplementares());

    $pdf->AddPage();
    $pdf->Image("imagens/files/" . $logo, 90, 7, 30);
    $pdf->Ln(30);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(0, 4, $db12_extenso, 0, "C", 0);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->MultiCell(0, 6, strtoupper($nomeinst), 0, "C", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(0, 4, 'CNPJ: ' . db_formatar($cgc, 'cnpj'), 0, "C", 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(0, 4, "{$ender} No {$numero} {$bairro}", 0, "C", 0);
    $pdf->Ln(32);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetFillColor(235);
    $pdf->roundedrect(10, 80, 190, 35, 2, 'df', 1234);
    $pdf->MultiCell(0, 8, "Processo de Compra:" . $oPcproc->getCodigo(), "", "C", 0);
    if($oPcproc->getNumerodispensa() > 0){
        $pdf->MultiCell(0, 8, "$modalidade Nº:" . $oPcproc->getNumerodispensa() . "/" . $ano, "", "C", 0);
    }
    $pdf->Ln(14);
    $pdf->roundedrect(10, 110, 190, 5, 2, 'DF', 12);
    $pdf->sety(109);
    $pdf->SetFont('Arial', 'b', 12);
    $pdf->cell(180, 8, 'Objeto', 0, 1, "C");
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 4, "{$oPcproc->getResumo()}", 0, "L", 0);
    $pdf->roundedrect(10, 110, 190, 35, 2, 'df', 1234);
    $pdf->sety(144);
    $pdf->roundedrect(10, 145, 190, 5, 2, 'DF', 12);
    $pdf->SetFont('Arial', 'b', 12);
    $pdf->cell(180, 8, 'Dados Complementares', 0, 1, "C");
    $pdf->roundedrect(10, 145, 190, 35, 2, 'df', 1234);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 4, $dadoscomplementares, 0, "L", 0);
}
    $pdf->Output();
?>
