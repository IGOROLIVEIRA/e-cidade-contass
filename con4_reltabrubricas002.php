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
        where db101_sequencial = 3000016 ORDER BY db102_sequencial";
    $rsAvaliacaoGrupoPergunta = pg_query($sql);
    //GRUPO
    for($AvGrup = 0; $AvGrup < pg_num_rows($rsAvaliacaoGrupoPergunta); $AvGrup ++){
        $pdf->SetFont('Arial','b',9);
        $oDadosAvaliacaoGrupoPergunta = db_utils::fieldsMemory($rsAvaliacaoGrupoPergunta, $AvGrup);
        $pdf->Cell(190,5,$oDadosAvaliacaoGrupoPergunta->db102_descricao,1,1,"L",0);
        //PERGUNTAS
        $sqlPerguntas = "SELECT *
                FROM avaliacaopergunta
                WHERE db103_avaliacaogrupopergunta = $oDadosAvaliacaoGrupoPergunta->db102_sequencial
                ORDER BY db103_sequencial";
        $rsAvaliacaoPergunta = pg_query($sqlPerguntas);
        //db_criatabela($rsAvaliacaoPergunta);
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
            WHERE db103_sequencial = $oDadosAvaliacaoPergunta->db103_sequencial ORDER BY db106_sequencial";
            $rsAvaliacaoResposta = pg_query($sqlResposta);
            //db_criatabela($rsAvaliacaoResposta);
            $oDadosResposta = db_utils::fieldsMemory($rsAvaliacaoResposta, $rRubricas);
            $pdf->SetFont('Arial','',9);
            //DESCRICAO DA RESPOSATA
            if($oDadosAvaliacaoPergunta->db103_tipo == 1){
                $sqlDescResposta = "
                    SELECT db104_descricao
                    FROM avaliacaoperguntaopcao
                    WHERE db104_sequencial = $oDadosResposta->db104_sequencial
                ";
                $rsDescrResposta = pg_query($sqlDescResposta);
                $oDadosDescrResposta = db_utils::fieldsMemory($rsDescrResposta, 0);
                $pdf->Cell(190,5,$oDadosDescrResposta->db104_descricao,1,1,"L",0);
            }else{
                $pdf->Cell(190,5,$oDadosResposta->db106_resposta,1,1,"L",0);
            }
        }
    }
}
exit;
$pdf->Output();
?>