<?php
require_once 'model/relatorios/Relatorio.php';
require("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);//
db_postmemory($HTTP_POST_VARS);
$oGet = db_utils::postmemory($_GET);

switch ($oGet->tipoprecoreferencia) {
  case 2:
    $tipoReferencia = " MAX(pc23_vlrun) ";
    break;

  case 3:
    $tipoReferencia = " MIN(pc23_vlrun) ";
    break;

  default:
    $tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";
    break;
}

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
                pc01_codmater,
                si01_datacotacao,
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
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao, si01_justificativa ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by pc11_seq"
;

$rsResult = db_query($sSql) or die(pg_last_error());//db_criatabela($rsResult);exit;

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");

echo "Preço de Referência \n";
echo "Processo de Compra: $codigo_preco \n";
echo "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResult, 0)->si01_datacotacao))) ." \n";

echo "SEQ;";
echo "ITEM;";
echo "DESCRICAO DO ITEM;";
echo "VALOR UN;";
echo "QUANT;";
echo "UN;";
echo "TOTAL;\n";


$nTotalItens = 0;

  for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

    $oResult = db_utils::fieldsMemory($rsResult, $iCont);

    //if($quant_casas == 2){
      $lTotal = round($oResult->si02_vlprecoreferencia,$quant_casas) * $oResult->pc11_quant;
    //}else $lTotal = round($oResult->si02_vlprecoreferencia,3) * $oResult->pc11_quant;

    $nTotalItens += $lTotal;

    $oDadosDaLinha = new stdClass();
    $oDadosDaLinha->seq = $iCont + 1;
    $oDadosDaLinha->item = $oResult->pc01_codmater;
    $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
    $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia,$quant_casas, ",", ".");
    $oDadosDaLinha->quantidade = $oResult->pc11_quant;
    $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");


    echo "$oDadosDaLinha->seq;";
    echo "$oDadosDaLinha->item;";
    echo "$oDadosDaLinha->descricao;";
    echo "R$ $oDadosDaLinha->valorUnitario;";
    echo "$oDadosDaLinha->quantidade;";
    echo "$oDadosDaLinha->unidadeDeMedida;";
    echo "R$ $oDadosDaLinha->total;\n";

  }

  
  //    echo "VALOR TOTAL DOS ITENS;";
  //    echo "R$" . number_format($nTotalItens, 2, ",", ".").";";
  if ($oGet->impjust == 's') {
    echo "JUSTIFICATIVA;\n";
    echo str_replace(array(';','.',','), "", db_utils::fieldsMemory($rsResult, 0)->si01_justificativa);
  }
  
