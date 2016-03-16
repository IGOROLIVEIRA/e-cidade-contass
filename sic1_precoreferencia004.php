<?
include("fpdf151/pdf.php");
require("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

/*$sSql = "select distinct pc11_seq,pc01_codmater,pc01_descrmater,si02_vlprecoreferencia,pc23_quant from pcproc
join pcprocitem on pc80_codproc = pc81_codproc
join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
join pcorcamitem on pc31_orcamitem = pc22_orcamitem
join pcorcamval on pc22_orcamitem = pc23_orcamitem
join solicitem on pc81_solicitem = pc11_codigo
join solicitempcmater on pc11_codigo = pc16_solicitem
join pcmater on pc16_codmater = pc01_codmater
join itemprecoreferencia on pc23_orcamitem = si02_itemproccompra
where pc80_codproc = $codigo_preco order by pc11_seq";*/

$sSql = "select * from (SELECT
                pc01_codmater,
                pc01_descrmater||'. '||pc01_complmater as pc01_descrmater,
                m61_abrev,
                sum(pc11_quant) as pc11_quant
from (
SELECT DISTINCT pc01_servico,
                pc11_codigo,
                pc11_seq,
                pc11_quant,
                pc11_prazo,
                pc11_pgto,
                pc11_resum,
                pc11_just,
                m61_abrev,
                m61_descr,
                pc17_quant,
                pc01_codmater,
                pc01_descrmater,pc01_complmater,
                pc10_numero,
                pc90_numeroprocesso AS processo_administrativo,
                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                m61_usaquant
FROM solicitem
INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
WHERE pc81_codproc = $codigo_preco
  AND pc10_instit = " . db_getsession("DB_instit") . "
ORDER BY pc11_seq) as x GROUP BY 
                pc01_codmater,
                pc01_descrmater,pc01_complmater,m61_abrev ) as matquan join
(SELECT DISTINCT 
                pc11_seq,
                round(si02_vlprecoreferencia,2) as si02_vlprecoreferencia,
                pc01_codmater,
                si01_datacotacao
FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = $codigo_preco 
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by pc11_seq";

$rsResult = db_query($sSql) or die(pg_last_error());//db_criatabela($rsResult);exit;

$head3 = "Preço de Referência";
$head5 = "Processo de Compra: $codigo_preco";

//$head5= "Mês de Referência: $sMes";

//$head7 = "Nº: {$oResult0->k00_codigo}";
$head8 = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResult, 0)->si01_datacotacao)));

$pdf = new PDF('Landscape', 'mm', 'A4'); // abre a classe

$pdf->Open(); // abre o relatorio
$pdf->AliasNbPages(); // gera alias para as paginas

$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(235);
$tam = '04';

$pdf->SetFont("", "B", "");

//$pdf->Cell(250,$tam,"Nº: ".$oResult0->k00_codigo,1,1,"R",1);
//$pdf->Cell(250,$tam,"DATA: ".$oResult->k00_dtpagamento,1,1,"R",1);

$pdf->Cell(13, $tam, "ITEM", 1, 0, "C", 1);
$pdf->Cell(180, $tam, "DESCRIÇÃO DO ITEM", 1, 0, "C", 1);
$pdf->Cell(25, $tam, "VALOR UN", 1, 0, "C", 1);
$pdf->Cell(15, $tam, "QUANT", 1, 0, "C", 1);
$pdf->Cell(20, $tam, "UN", 1, 0, "C", 1);
$pdf->Cell(25, $tam, "TOTAL", 1, 1, "C", 1);
$pdf->SetFont("", "", "");
$nTotalItens = 0;
$iContItem = 1;



for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

    $oResult = db_utils::fieldsMemory($rsResult, $iCont);

    if (strlen($oResult->pc01_descrmater) > 120) {
        $aDescmater = quebrar_texto($oResult->pc01_descrmater, 120);
        $alt_novo = count($aDescmater);
    } else {
        $alt_novo = 1;
    }

    $pdf->Cell(13, $tam * $alt_novo, $iContItem, 1, 0, "C", 0);

    if (strlen($oResult->pc01_descrmater) > 120) {

        $pos_x = $pdf->x;
        $pos_y = $pdf->y;
        $pdf->Cell(180, $tam * $alt_novo, "", 1, 0, "L", 0);
        $pdf->x = $pos_x;
        $pdf->y = $pos_y;
        foreach ($aDescmater as $oDescmater) {
            $pdf->cell(180, ($tam), $oDescmater, 0, 1, "L", 0);
            $pdf->x = $pos_x;
        }
        $pdf->x = $pos_x + 180;
        $pdf->y = $pos_y;

    } else {
        $pdf->Cell(180, $tam*$alt_novo, $oResult->pc01_descrmater, 1, 0, "L", 0);
    }
    $pdf->Cell(25, $tam*$alt_novo, "R$" . number_format($oResult->si02_vlprecoreferencia, 2, ",", "."), 1, 0, "R", 0);
    $pdf->Cell(15, $tam*$alt_novo, $oResult->pc11_quant, 1, 0, "C", 0);
    $pdf->Cell(20, $tam*$alt_novo, $oResult->m61_abrev, 1, 0, "C", 0);
    $lTotal = round($oResult->si02_vlprecoreferencia, 2) * $oResult->pc11_quant;
    $pdf->Cell(25, $tam*$alt_novo, "R$" . number_format($lTotal, 2, ",", "."), 1, 1, "R", 0);
    $nTotalItens += $lTotal;
    $iContItem++;

}
$pdf->Cell(253, $tam, "VALOR TOTAL DOS ITENS", 1, 0, "C", 1);
$pdf->Cell(25, $tam, "R$" . number_format($nTotalItens, 2, ",", "."), 1, 1, "R", 1);
$pdf->output();

function quebrar_texto($texto, $tamanho)
{

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {
        $string_ant = $string_atual;
        $string_atual .= " " . $word;
        if (strlen($string_atual) > $tamanho) {
            $aTextoNovo[] = trim($string_ant);
            $string_ant = "";
            $string_atual = $word;
        }
    }
    $aTextoNovo[] = trim($string_atual);
    return $aTextoNovo;

}

?>
