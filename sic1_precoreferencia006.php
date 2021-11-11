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
$criterio    = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
$sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";

$rsLotes = db_query("select distinct  pc68_sequencial,pc68_nome
                        from
                            pcproc
                        join pcprocitem on
                            pc80_codproc = pc81_codproc
                        left join processocompraloteitem on
                            pc69_pcprocitem = pcprocitem.pc81_codprocitem
                        left join processocompralote on
                            pc68_sequencial = pc69_processocompralote
                        where
                            pc80_codproc = {$codigo_preco}
                            and pc68_sequencial is not null
                            order by pc68_sequencial asc");

if (pg_num_rows($rsLotes) == 0) {

    $sSql = "select * from (SELECT
                pc01_codmater,
                case when pc01_complmater is not null and pc01_complmater != pc01_descrmater then pc01_descrmater ||'. '|| pc01_complmater
		     else pc01_descrmater end as pc01_descrmater,
                m61_abrev,
                sum(pc11_quant) as pc11_quant,
                pc11_reservado
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
                m61_usaquant,
                pc11_reservado
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
                pc01_descrmater,pc01_complmater,m61_abrev,pc11_reservado ) as matquan join
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
                si01_justificativa,
                pc80_codproc
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
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa,pc80_codproc
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by pc11_seq";
    //die($sSql);

    $rsResult = db_query($sSql) or die(pg_last_error());
    $oLinha = null;

    $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $cl_docparag = new cl_db_docparag;

    $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rs = $cl_docparag->sql_record($sAssinatura);
    $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


    $sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
    $sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;

    //echo $sSql; db_criatabela($rsResult);exit;
    $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->pc80_criterioadjudicacao;

    $data = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResult, 0)->si01_datacotacao)));

    $mPDF = new Relatorio('', 'A4-L', 0, "", 7, 7, 50);

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
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <style>
        div {
            font-size: 14px;
            text-align: center;
            border: 1px solid black;
        }

        table {
            font-size: 12px;
            border: 1px solid black;
        }
    </style>

    <body>
        <center>
            <div>
                <strong>Preço de Referência</strong>
            </div>
            <div>
                <p>Processo de Compras: <?= $codigo_preco ?></p>
            </div>
            <div>
                <p>Data: <?= $data ?></p>
            </div>
            <?php
            if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
                echo <<<HTML
        <table>
            <tr>
                <td><strong>SEQ</strong></td>
                <td><strong>ITEM</strong></td>
                <td><strong>DESCRIÇÃO DO ITEM</strong></td>
                <td><strong>TAXA/TABELA</strong></td>
                <td><strong>VALOR UN</strong></td>
                <td><strong>QUANT</strong></td>
                <td><strong>UN</strong></td>
                <td><strong>TOTAL/VLR ESTIMADO</strong></td>
            </tr>

HTML;
            } else {
                echo <<<HTML
        <table>
            <tr>
                <td><strong>SEQ</strong></td>
                <td><strong>ITEM</strong></td>
                <td><strong>DESCRIÇÃO DO ITEM</strong></td>
                <td><strong>VALOR UN</strong></td>
                <td><strong>QUANT</strong></td>
                <td><strong>UN</strong></td>
                <td><strong>TOTAL</strong></td>
            </tr>
HTML;
            }

            $nTotalItens = 0;

            for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                $oResult = db_utils::fieldsMemory($rsResult, $iCont);
                $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->pc11_quant;

                $nTotalItens += $lTotal;
                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->seq = $iCont + 1;
                $oDadosDaLinha->item = $oResult->pc01_codmater;
                $oDadosDaLinha->pc80_codproc = $oResult->pc80_codproc;
                if ($oResult->pc11_reservado == 't') {
                    $oDadosDaLinha->descricao = '[ITEM ME/EPP] - ' . str_replace(';', "", $oResult->pc01_descrmater);
                } else {
                    $oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
                }
                //$oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
                if ($oResult->pc01_tabela == "t" || $oResult->pc01_taxa == "t") {
                    $oDadosDaLinha->valorUnitario = "-";
                    $oDadosDaLinha->quantidade = "-";
                    if ($oResult->mediapercentual == 0) {
                        $oDadosDaLinha->mediapercentual = "";
                    } else {
                        $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                    }
                    $oDadosDaLinha->unidadeDeMedida = "-";
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                } else {
                    $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
                    $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                    if ($oResult->mediapercentual == 0) {
                        $oDadosDaLinha->mediapercentual = "-";
                    } else {
                        $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                    }
                    $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                }

                if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                    echo <<<HTML
        <tr>
          <td>{$oDadosDaLinha->seq}</td>
          <td>{$oDadosDaLinha->item}</td>
          <td>{$oDadosDaLinha->descricao}</td>
          <td>{$oDadosDaLinha->mediapercentual}</td>
          <td>{$oDadosDaLinha->valorUnitario}</td>
          <td>{$oDadosDaLinha->quantidade}</td>
          <td>{$oDadosDaLinha->unidadeDeMedida}</td>
          <td>{$oDadosDaLinha->total}</td>
        </tr>
        </table>
HTML;
                } else {
                    echo <<<HTML
        <tr>
            <td> $oDadosDaLinha->seq               </td>
            <td> {$oDadosDaLinha->item}            </td>
            <td> {$oDadosDaLinha->descricao}       </td>
            <td> {$oDadosDaLinha->valorUnitario}   </td>
            <td> {$oDadosDaLinha->quantidade}      </td>
            <td> {$oDadosDaLinha->unidadeDeMedida} </td>
            <td> {$oDadosDaLinha->total}           </td>
        </tr>

HTML;
                }
            }
            ?>
            </table>
        </center>
    </body>

    </html>

<?php
} else {

    $sSql = "select si01_datacotacao FROM pcproc
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
    WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0";

    $rsResultData = db_query($sSql) or die(pg_last_error());

    $oLinha = null;

    $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $cl_docparag = new cl_db_docparag;

    $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rs = $cl_docparag->sql_record($sAssinatura);
    $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


    $sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
    $sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;


    $data = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResultData, 0)->si01_datacotacao)));

    $mPDF = new Relatorio('', 'A4-L', 0, "", 7, 7, 50);

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
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <style>
        div {
            font-size: 14px;
            text-align: center;
            border: 1px solid black;
        }

        table {
            font-size: 12px;
            border: 1px solid black;
        }
    </style>

    <body>
        <center>
            <div>
                <strong>Preço de Referência</strong>
            </div>
            <div>
                <p>Processo de Compras: <?= $codigo_preco ?></p>
            </div>
            <div>
                <p>Data: <?= $data ?></p>
            </div>
            <?php


            for ($i = 0; $i < pg_num_rows($rsLotes); $i++) {
                $oLotes = db_utils::fieldsMemory($rsLotes, $i);


                $sSql = "select * from (SELECT
            pc01_codmater,
            case when pc01_complmater is not null and pc01_complmater != pc01_descrmater then pc01_descrmater ||'. '|| pc01_complmater
		     else pc01_descrmater end as pc01_descrmater,
            m61_abrev,
            sum(pc11_quant) as pc11_quant,
            pc69_seq,
            pc11_seq
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
            m61_usaquant,
            pc69_seq
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
left join processocompraloteitem on
    pc69_pcprocitem = pcprocitem.pc81_codprocitem
left join processocompralote on
        pc68_sequencial = pc69_processocompralote
AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
WHERE pc81_codproc = {$codigo_preco}
AND pc68_sequencial = $oLotes->pc68_sequencial
AND pc10_instit = " . db_getsession("DB_instit") . "
ORDER BY pc11_seq) as x GROUP BY
            pc01_codmater,
            pc11_seq,
            pc01_descrmater,pc01_complmater,m61_abrev,pc69_seq ) as matquan join
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
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by matquan.pc11_seq asc";
                //die($sSql);

                $rsResult = db_query($sSql) or die(pg_last_error());

                $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->pc80_criterioadjudicacao;
                $oLotes->pc68_nome = strtoupper($oLotes->pc68_nome);
                if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
                    echo <<<HTML
        <table>

            <tr>
                <th colspan="7"><strong>{$oLotes->pc68_nome}</strong></th>
            </tr>
            <tr>
                <td align= "left"><strong>ITEM LOTE</strong></td>
                <td align= "left"><strong>CODIGO</strong></td>
                <td align= "left"><strong>DESCRIÇÃO DO ITEM</strong></td>
                <td align= "left"><strong>TAXA/TABELA</strong></td>
                <td align= "left"><strong>VALOR UN</strong></td>
                <td align= "left"><strong>QUANT</strong></td>
                <td align= "left"><strong>UN</strong></td>
                <td align= "left"><strong>TOTAL/VLR ESTIMADO</strong></td>
            </tr>
HTML;
                } else {
                    echo <<<HTML
        <table>
            <tr>
            <th colspan="7"><strong>{$oLotes->pc68_nome}</strong></th>
            </tr>
            <tr>
                <td align= "left"><strong>ITEM LOTE</strong></td>
                <td align= "left"><strong>CODIGO</strong></td>
                <td align= "left"><strong>DESCRIÇÃO DO ITEM</strong></td>
                <td align= "left"><strong>VALOR UN</strong></td>
                <td align= "left"><strong>QUANT</strong></td>
                <td align= "left"><strong>UN</strong></td>
                <td align= "left"><strong>TOTAL</strong></td>
            </tr>
HTML;
                }

                $nTotalItens = 0;

                for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                    $oResult = db_utils::fieldsMemory($rsResult, $iCont);
                    $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->pc11_quant;

                    $nTotalItens += $lTotal;
                    $oDadosDaLinha = new stdClass();
                    $oDadosDaLinha->seq = $iCont + 1;
                    $oDadosDaLinha->item = $oResult->pc01_codmater; //$oResult->pc11_seq;
                    $oDadosDaLinha->pc80_codproc = $oResult->pc80_codproc;
                    if ($oResult->pc11_reservado == 't') {
                        $oDadosDaLinha->descricao = '[ITEM ME/EPP] - ' . str_replace(';', "", $oResult->pc01_descrmater);
                    } else {
                        $oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
                    }
                    //$oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
                    if ($oResult->pc01_tabela == "t" || $oResult->pc01_taxa == "t") {
                        $oDadosDaLinha->valorUnitario = "-";
                        $oDadosDaLinha->quantidade = "-";
                        if ($oResult->mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = "-";
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    } else {
                        $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
                        $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                        if ($oResult->mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "-";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    }

                    if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                        echo <<<HTML
        <tr>
          <td>{$oDadosDaLinha->seq}</td>
          <td>{$oDadosDaLinha->item}</td>
          <td>{$oDadosDaLinha->descricao}</td>
          <td>{$oDadosDaLinha->mediapercentual}</td>
          <td>{$oDadosDaLinha->valorUnitario}</td>
          <td>{$oDadosDaLinha->quantidade}</td>
          <td>{$oDadosDaLinha->unidadeDeMedida}</td>
          <td>{$oDadosDaLinha->total}</td>
        </tr>
        </table>

HTML;
                    } else {
                        echo <<<HTML
        <tr>
            <td> $oDadosDaLinha->seq               </td>
            <td> {$oDadosDaLinha->item}            </td>
            <td> {$oDadosDaLinha->descricao}       </td>
            <td> {$oDadosDaLinha->valorUnitario}   </td>
            <td> {$oDadosDaLinha->quantidade}      </td>
            <td> {$oDadosDaLinha->unidadeDeMedida} </td>
            <td> {$oDadosDaLinha->total}           </td>
        </tr>

HTML;
                    }
                }
            }

            ?>
            </table>
        </center>
    </body>

    </html>
<?php
}

header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=Preco_de_Referencia_PRC_" . $codigo_preco . ".doc");
?>
