<?php
require_once 'model/relatorios/Relatorio.php';

// include("fpdf151/pdf.php");
require("libs/db_utils.php");
$oGet = db_utils::postMemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

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
                pc01_codmater,
                si01_datacotacao
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
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by pc11_seq"
;

$rsResult = db_query($sSql) or die(pg_last_error());

$head3 = "Preço de Referência";
$head5 = "Processo de Compra: $codigo_preco";
$head8 = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResult, 0)->si01_datacotacao)));

$mPDF = new Relatorio('', 'A4-L');

$mPDF
  ->addInfo($head3, 2)
  ->addInfo($head5, 4)
  ->addInfo($head8, 7);

ob_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>Relatório</title>
<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
<style type="text/css">
.content {
  width: 1070px;
}

.table {
  font-size: 10px;
  background: url("imagens/px_preto.jpg") repeat center;
  background-repeat: repeat-y;
  background-position: 0 50px;
}

.table .tr {
}
.col-valor_total-valor,
.col-valor_total-text {
}

.col-item { width: 45px; }
.col-descricao_item {
  width: 695px;
}
.col-valor_un {
  width: 80px;
  padding-right: 5px;
}
.col-quant {
  width: 60px;
}
.col-un {
  width: 45px;
}
.col-total {
  width: 95px;
  padding-left: 5px;
}
.col-valor_total-text {
  width: 925px;
  padding-left: 5px;
}
.col-valor_total-valor {
  width: 120px;
  padding-right: 5px;
}

.row .col-un,
.row .col-total,
.row .col-quant,
.row .col-valor_un,
.row .col-valor_un {
}
.linha-vertical {
    border-top: 2px solid;
    text-align: center;
    margin-top: 80px;
    margin-left: 19%;
    width: 50%;

}
</style>
</head>
<body>

<div class="content">

  <div class="table" autosize="1">
    <div class="tr bg_eb">
      <div class="th col-item align-center">ITEM</div>
      <div class="th col-descricao_item align-center">DESCRIÇÃO DO ITEM</div>
      <div class="th col-valor_un align-right">VALOR UN</div>
      <div class="th col-quant align-center">QUANT</div>
      <div class="th col-un align-center">UN</div>
      <div class="th col-total align-right">TOTAL</div>
    </div>

    <?php

    $nTotalItens = 0;

    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

      $oResult = db_utils::fieldsMemory($rsResult, $iCont);

//      if($quant_casas == 2){
        $lTotal = round($oResult->si02_vlprecoreferencia,$quant_casas) * $oResult->pc11_quant;
//      }
//      else $lTotal = round($oResult->si02_vlprecoreferencia,3) * $oResult->pc11_quant;

      $nTotalItens += $lTotal;
      $oDadosDaLinha = new stdClass();
      $oDadosDaLinha->item = $iCont + 1;
      $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
      $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $quant_casas, ",", ".");
      $oDadosDaLinha->quantidade = $oResult->pc11_quant;
      $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
      $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");

      echo <<<HTML
        <div class="tr row">
          <div class="td col-item align-center">
            {$oDadosDaLinha->item}
          </div>
          <div class="td col-descricao_item align-justify">
            {$oDadosDaLinha->descricao}
          </div>
          <div class="td col-valor_un align-right">
            R$ {$oDadosDaLinha->valorUnitario}
          </div>
          <div class="td col-quant align-center">
            {$oDadosDaLinha->quantidade}
          </div>
          <div class="td col-un align-center">
            {$oDadosDaLinha->unidadeDeMedida}
          </div>
          <div class="td col-total align-right">
            R$ {$oDadosDaLinha->total}
          </div>
        </div>
HTML;


    }

    ?>

    <div class="tr bg_eb">
      <div class="th col-valor_total-text align-left">
        VALOR TOTAL DOS ITENS
      </div>
      <div class="th col-valor_total-valor align-right">
        <?= "R$" . number_format($nTotalItens, 2, ",", ".") ?>
      </div>
    </div>
  </div>

</div>

<div class="linha-vertical">
    <strong>RESPONSÁVEL PELA COTAÇÃO</strong>
</div>

</body>
</html>

<?php

$html = ob_get_contents();

ob_end_clean();

$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

?>
