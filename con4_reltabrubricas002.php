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

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->Image("imagens/files/".$logo,90,7,30);
//$this->Image('imagens/files/'.$logo,2,3,30);

for($AvGrup = 0; $AvGrup < pg_num_rows($rsAvaliacaoGrupoPergunta); $AvGrup ++){
    $pdf->SetFont('Arial','b',12);
    $oDadosAvaliacaoGrupoPergunta = db_utils::fieldsMemory($rsAvaliacaoGrupoPergunta, $AvGrup);
    $pdf->Cell(190,5,$oDadosAvaliacaoGrupoPergunta->db102_descricao,1,1,"L",0);
    //busco as perguntas de acordo com o grupo
    $sqlPerguntas = "SELECT db103_sequencial,
                db103_descricao
            FROM avaliacaopergunta
            WHERE db103_avaliacaogrupopergunta = $oDadosAvaliacaoGrupoPergunta->db102_sequencial
            ORDER BY db103_sequencial";
    $rsAvaliacaoPergunta = pg_query($sqlPerguntas);

    for($Avpergunta = 0; $Avpergunta < pg_num_rows($rsAvaliacaoPergunta); $Avpergunta ++){
        $pdf->SetFont('Arial','',10);
        $oDadosAvaliacaoPergunta = db_utils::fieldsMemory($rsAvaliacaoPergunta, $Avpergunta);
        $pdf->Cell(190,5,$oDadosAvaliacaoPergunta->db103_descricao,1,1,"L",0);

        $sqlResposta = "SELECT DISTINCT avaliacaoresposta.*
        FROM avaliacao
        LEFT JOIN avaliacaogrupopergunta ON db102_avaliacao = db101_sequencial
        LEFT JOIN avaliacaopergunta ON db103_avaliacaogrupopergunta = db102_sequencial
        LEFT JOIN avaliacaoperguntaopcao ON db104_avaliacaopergunta = db103_sequencial
        LEFT JOIN avaliacaoresposta ON db106_avaliacaoperguntaopcao = db104_sequencial
        LEFT JOIN avaliacaogrupoperguntaresposta ON db106_sequencial = db108_avaliacaoresposta
        LEFT JOIN avaliacaogruporesposta ON db107_sequencial = db108_avaliacaogruporesposta
        WHERE db103_sequencial = 4000361 and db106_sequencial is not null
        ";
        $rsAvaliacaoResposta = pg_query($sqlResposta);

        for($AvResposta = 0;  $AvResposta < pg_num_rows($rsAvaliacaoResposta); $AvResposta ++){
            $oDadosResposta = db_utils::fieldsMemory($rsAvaliacaoResposta, $AvResposta);
            $pdf->SetFont('Arial','',8);
            $pdf->Cell(190,5,$oDadosResposta->db106_resposta,1,1,"L",0);
        }
    }
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