<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("libs/db_utils.php");
//db_postmemory($HTTP_SERVER_VARS);

$sqlRubricasRespostas = "SELECT DISTINCT avaliacaoresposta.*
FROM avaliacao
LEFT JOIN avaliacaogrupopergunta ON db102_avaliacao = db101_sequencial
LEFT JOIN avaliacaopergunta ON db103_avaliacaogrupopergunta = db102_sequencial
LEFT JOIN avaliacaoperguntaopcao ON db104_avaliacaopergunta = db103_sequencial
LEFT JOIN avaliacaoresposta ON db106_avaliacaoperguntaopcao = db104_sequencial
LEFT JOIN avaliacaogrupoperguntaresposta ON db106_sequencial = db108_avaliacaoresposta
LEFT JOIN avaliacaogruporesposta ON db107_sequencial = db108_avaliacaogruporesposta
WHERE db103_sequencial = 3000944";
$rsRubricasResposta = pg_query($sqlRubricasRespostas);

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
//RUBRICAS INFORMADAS 
for($rRubricas = 0; $rRubricas < pg_num_rows($rsRubricasResposta); $rRubricas ++){
    $pdf->AddPage();
    $sql = "select distinct avaliacaogrupopergunta.* from avaliacao 
        left join avaliacaogrupopergunta on db102_avaliacao = db101_sequencial
        left join avaliacaopergunta on db103_avaliacaogrupopergunta = db102_sequencial
        left join avaliacaoperguntaopcao on db104_avaliacaopergunta = db103_sequencial
        left join avaliacaoresposta on db106_avaliacaoperguntaopcao = db104_sequencial
        left join avaliacaogrupoperguntaresposta ON db106_sequencial = db108_avaliacaoresposta
        left join avaliacaogruporesposta ON db107_sequencial = db108_avaliacaogruporesposta
        where db101_sequencial = 3000016";
    $rsAvaliacaoGrupoPergunta = pg_query($sql);
    //GRUPO
    for($AvGrup = 0; $AvGrup < pg_num_rows($rsAvaliacaoGrupoPergunta); $AvGrup ++){
        $pdf->SetFont('Arial','b',12);
        $oDadosAvaliacaoGrupoPergunta = db_utils::fieldsMemory($rsAvaliacaoGrupoPergunta, $AvGrup);
        $pdf->Cell(190,5,$oDadosAvaliacaoGrupoPergunta->db102_descricao,1,1,"L",0);
        //PERGUNTAS
        $sqlPerguntas = "SELECT db103_sequencial,
                    db103_descricao
                FROM avaliacaopergunta
                WHERE db103_avaliacaogrupopergunta = $oDadosAvaliacaoGrupoPergunta->db102_sequencial
                ORDER BY db103_sequencial";
        $rsAvaliacaoPergunta = pg_query($sqlPerguntas);
        for($Avpergunta = 0; $Avpergunta < pg_num_rows($rsAvaliacaoPergunta); $Avpergunta ++){
            $pdf->SetFont('Arial','b',9);
            $oDadosAvaliacaoPergunta = db_utils::fieldsMemory($rsAvaliacaoPergunta, $Avpergunta);
            $pdf->Cell(190,5,$oDadosAvaliacaoPergunta->db103_descricao,1,1,"L",0);
            
            //RESPOSTA
            $sqlResposta = "SELECT DISTINCT avaliacaoresposta.*
            FROM avaliacao
            LEFT JOIN avaliacaogrupopergunta ON db102_avaliacao = db101_sequencial
            LEFT JOIN avaliacaopergunta ON db103_avaliacaogrupopergunta = db102_sequencial
            LEFT JOIN avaliacaoperguntaopcao ON db104_avaliacaopergunta = db103_sequencial
            LEFT JOIN avaliacaoresposta ON db106_avaliacaoperguntaopcao = db104_sequencial
            LEFT JOIN avaliacaogrupoperguntaresposta ON db106_sequencial = db108_avaliacaoresposta
            LEFT JOIN avaliacaogruporesposta ON db107_sequencial = db108_avaliacaogruporesposta
            WHERE db103_sequencial = $oDadosAvaliacaoPergunta->db103_sequencial and db106_sequencial is not null
            ";
            $rsAvaliacaoResposta = pg_query($sqlResposta);
            $oDadosResposta = db_utils::fieldsMemory($rsAvaliacaoResposta, $rRubricas);
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(190,5,$oDadosResposta->db106_resposta,1,1,"L",0);
        }
    }
}
$pdf->Output();
?>