<?
include("fpdf151/scpdf.php");
db_postmemory($HTTP_SERVER_VARS);

$oPcproc = new ProcessoCompras($pc80_codproc);

$sql = "select uf, db12_extenso, logo, munic, cgc, ender, bairro, numero, codigo, nomeinst
			from db_config
				inner join db_uf on db12_uf = uf
			where codigo = ".db_getsession("DB_instit");

$result = pg_query($sql);
db_fieldsmemory($result,0);

$dataEmissao = explode("/",$oPcproc->getDataEmissao());
$ano = $dataEmissao[2];
$modalidade = "Dispença sem Disputa";
if ($oPcproc->getModalidadeContratacao() == "9"){
    $modalidade = "Inexigibilidade";
}

$pdf = new SCPDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image("imagens/files/".$logo,90,7,30);
$pdf->Ln(30);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,4,$db12_extenso,0,"C",0);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(0,6,strtoupper($nomeinst),0,"C",0);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,4,'CNPJ: '.db_formatar($cgc,'cnpj'),0,"C",0);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,4,"{$ender} No {$numero} {$bairro}",0,"C",0);
$pdf->Ln(32);
$pdf->SetFont('Arial','B',14);
$pdf->SetFillColor(235);
$pdf->MultiCell(0,8,"Processo de Compra:" . $oPcproc->getDataEmissao(),"TLR","C",0);
$pdf->MultiCell(0,8,"$modalidade Nº:".$oPcproc->getNumerodispensa()."/".$ano,"BLR","C",0);
$pdf->Ln(12);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,4,"Resumo do Processo: {$oPcproc->getResumo()}",0,"C",0);
$pdf->Ln(7);
if($oPcproc->getDadosComplementares()){
$pdf->MultiCell(0,4,"Dados Complementares:{$oPcproc->getDadosComplementares()}",0,"C",0);
}
$pdf->Output();
?>
