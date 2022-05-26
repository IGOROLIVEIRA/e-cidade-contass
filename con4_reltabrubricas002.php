<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("libs/db_utils.php");
//db_postmemory($HTTP_SERVER_VARS);

$sql = "select distinct avaliacaogrupopergunta.* from avaliacao 
        left join avaliacaogrupopergunta on db102_avaliacao = db101_sequencial
        left join avaliacaopergunta on db103_avaliacaogrupopergunta = db102_sequencial
        left join avaliacaoperguntaopcao on db104_avaliacaopergunta = db103_sequencial
        left join avaliacaoresposta on db106_avaliacaoperguntaopcao = db104_sequencial
        left join avaliacaogrupoperguntaresposta ON db106_sequencial = db108_avaliacaoresposta
        left join avaliacaogruporesposta ON db107_sequencial = db108_avaliacaogruporesposta
        where db101_sequencial = 3000016";

$rsAvaliacaoGrupoPergunta = pg_query($sql);
//db_criatabela($result);exit;
db_fieldsmemory($result,0);

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image("imagens/files/".$logo,90,7,30);
//$this->Image('imagens/files/'.$logo,2,3,30);
$pdf->Ln(30);
$pdf->SetFont('Arial','',8);
for($AvGrup = 0; $AvGrup < pg_num_rows($rsAvaliacaoGrupoPergunta); $AvGrup ++){
    $oDadosAvaliacaoGrupoPergunta = db_utils::fieldsMemory($rsAvaliacaoGrupoPergunta, $AvGrup);
}
/*
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
$pdf->Cell(190,10,"Processo Licitatório: {$oLicitacao->getEdital()}/{$oLicitacao->getAno()}",1,1,"C",0);
$pdf->Ln();
$pdf->MultiCell(0,4,"{$oLicitacao->getModalidade()->getDescricao()} No:{$oLicitacao->getNumeroLicitacao()}/{$oLicitacao->getAno()}",0,"C",0);
$pdf->Ln(12);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,4,"Objeto: {$oLicitacao->getObjeto()}",0,"C",0);
$pdf->Ln(7);
$arrayDispensa = array(100,101,102);
if(!in_array($oLicitacao->iTipoCompraTribunal, $arrayDispensa)){
    $pdf->MultiCell(0,4,"Comissão:",0,"C",0);
    $pdf->Ln();
    $pdf->SetFont('Arial','',8);
    foreach($oLicitacao->getComissao() as $oMembro) {
        $pdf->MultiCell(0, 4, "{$oMembro->z01_nome} - {$oMembro->l46_tipo}", 0, "C", 0);
    }
}*/
$pdf->Output();
?>