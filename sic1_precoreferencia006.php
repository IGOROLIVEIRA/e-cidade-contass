<?php
require_once 'model/relatorios/Relatorio.php';
include("classes/db_db_docparag_classe.php");

// include("fpdf151/pdf.php");
require("libs/db_utils.php");
$oGet = db_utils::postMemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

switch ($oGet->tipoprecoreferencia) {
    case '2':
        $tipoReferencia = " MAX(pc23_vlrun) ";
        break;

    case '3':
        $tipoReferencia = " MIN(pc23_vlrun) ";
        break;

    default:
        $tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";
        break;
}

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

$rsResultado = db_query("select pc80_criterioadjudicacao from pcproc where pc80_codproc = {$codigo_preco}");
$criterio    = db_utils::fieldsMemory($rsResultado,0)->pc80_criterioadjudicacao;
$sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";

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
WHERE pc81_codproc = {$codigo_preco}
  AND pc10_instit = " . db_getsession("DB_instit") . "
ORDER BY pc11_seq) as x GROUP BY
                pc01_codmater,
                pc11_seq,
                pc01_descrmater,pc01_complmater,m61_abrev ) as matquan join
(SELECT DISTINCT
                pc11_seq,
                {$tipoReferencia} as si02_vlprecoreferencia,
                                     case when pc80_criterioadjudicacao = 1 then
                     round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                     when pc80_criterioadjudicacao = 2 then
                     round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                     end as mediapercentual,
                pc01_codmater,
                si01_datacotacao,
                pc80_criterioadjudicacao,
                pc01_tabela,
                pc01_taxa,
                si01_justificativa
FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa 
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by pc11_seq";
// die($sSql);
$rsResult = db_query($sSql) or die(pg_last_error());
$oLinha = null;

$sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
//$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
$sWhere .= " AND db03_instit = db02_instit ";
$sWhere .= " AND db02_instit = ".db_getsession('DB_instit');

$cl_docparag = new cl_db_docparag;

$sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
$rs = $cl_docparag->sql_record($sAssinatura);
$oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


$sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
//$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
$sWhere .= " AND db03_instit = db02_instit ";
$sWhere .= " AND db02_instit = ".db_getsession('DB_instit');

$sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
$rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
$sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;

//echo $sSql; db_criatabela($rsResult);exit;
$pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->pc80_criterioadjudicacao;
$head3 = "Preço de Referência";
$head5 = "Processo de Compra: $codigo_preco";
$head8 = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResult, 0)->si01_datacotacao)));

$mPDF = new Relatorio('', 'A4-L',0,"",7,7,50);

$mPDF
    ->addInfo($head3, 2)
    ->addInfo($head5, 4)
    ->addInfo($head8, 7);

ob_start();

?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Relatório</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
<?php
if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){ //OC8365
    echo <<<HTML

        <table>
            <tr>
                <td>SEQ</td>
                <td>ITEM</td>
                <td>DESCRIÇÃO DO ITEM</td>
                <td><strong>TAXA/TABELA</strong></td>
                <td>VALOR UN</td>
                <td>QUANT</td>
                <td>UN</td>
                <td>TOTAL/VLR ESTIMADO</td>
            </tr>
        </table>
HTML;
}else{
    echo <<<HTML
        <table>
            <tr>
                <td>SEQ</td>
                <td>ITEM</td>
                <td>DESCRIÇÃO DO ITEM</td>
                <td>VALOR UN</td>
                <td>QUANT</td>
                <td>TOTAL</td>
            </tr>
HTML;
}
echo <<<HTML
    </body>
    </html>
HTML;

$nTotalItens = 0;

for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

    $oResult = db_utils::fieldsMemory($rsResult, $iCont);
    $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->pc11_quant;

    $nTotalItens += $lTotal;
    $oDadosDaLinha = new stdClass();
    $oDadosDaLinha->seq = $iCont + 1;
    $oDadosDaLinha->item = $oResult->pc01_codmater;
    $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
    if($oResult->pc01_tabela == "t" || $oResult->pc01_taxa == "t"){
        $oDadosDaLinha->valorUnitario = "-";
        $oDadosDaLinha->quantidade = "-";
        if($oResult->mediapercentual == 0){
            $oDadosDaLinha->mediapercentual = "";
        }else{
            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual ,2)."%";
        }
        $oDadosDaLinha->unidadeDeMedida = "-";
        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
    }else{
        $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
        $oDadosDaLinha->quantidade = $oResult->pc11_quant;
        if($oResult->mediapercentual == 0){
            $oDadosDaLinha->mediapercentual = "-";
        }else{
            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual ,2)."%";
        }
        $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
    }

    if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){
        echo <<<HTML
        <tr>
              <td {$oDadosDaLinha->seq}</td>
              <td {$oDadosDaLinha->item}</td>
              <td {$oDadosDaLinha->descricao}</td>
              <td {$oDadosDaLinha->mediapercentual}</td>
              <td {$oDadosDaLinha->valorUnitario}</td>          
              <td {$oDadosDaLinha->quantidade}</td>
              <td {$oDadosDaLinha->unidadeDeMedida}</td>
              <td {$oDadosDaLinha->total}</td>
        </tr>
        </table>
HTML;
    }else{
        echo <<<HTML
          <tr>
              <td {$oDadosDaLinha->seq}</td>
              <td {$oDadosDaLinha->item}</td>
              <td {$oDadosDaLinha->descricao}</td>
              <td {$oDadosDaLinha->mediapercentual}</td>
              <td R$ {$oDadosDaLinha->valorUnitario}</td>          
              <td {$oDadosDaLinha->quantidade}</td>
              <td {$oDadosDaLinha->unidadeDeMedida}</td>
              <td R$ {$oDadosDaLinha->total}</td>
        </tr>
        </table>
HTML;
    }

}
?>

<?php
header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=teste.doc");
?>