<?php

require_once("model/relatorios/Relatorio.php");
require_once("libs/db_utils.php");
require_once("classes/db_controleextvlrtransf_classe.php");
require_once("classes/db_controleext_classe.php");
require_once("std/DBDate.php");


$oControleExt = new cl_controleext();
$aConsulta = array();

parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);
//print_r($aFiltros);die();

try {

  $oDatas = new stdClass();

  if (isset($aFiltros['datas_inicio']) && isset($aFiltros['datas_final'])) {

    $oDatas->inicio  = new DBDate($aFiltros['datas_inicio']);
    $oDatas->final   = new DBDate($aFiltros['datas_final']);
    $oDatas->inicio  = $oDatas->inicio->getDate();
    $oDatas->final   = $oDatas->final->getDate();

  }

  if (isset($aFiltros['conta']) && !empty($aFiltros['conta'])) {
    $iCodConta = $aFiltros['conta'];
  } else {
    $iCodConta = '';
  }

  $aConsulta = $oControleExt->getRecebimentosELancamentos($iCodConta, $oDatas);
//  print_r($aConsulta);die();

} catch (Exception $e) {

  db_redireciona('db_erros.php?fechar=true&db_erro='. $e->getMessage());

}


$aContas = array();

foreach ($aConsulta as $aConta) {
//  print_r($aConta);die();
  $iConta = $aConta['k167_codcon'];
  $iMes   = $aConta['k168_mescompet'];
  $iLancamento = $aConta['lancamento'];
  if (!isset($aContas[$iConta])) {

    $oNovaConta = new stdClass();
    $oNovaConta->codigo     = $iConta;
    $oNovaConta->descricao  = $aConta['c60_descr'];
    $oNovaConta->previsao   = $aConta['k167_prevanu'];

    $oNovaConta->previsoesMensais = array();

    $aContas[$iConta] = $oNovaConta;

  }

  if (!isset($aContas[$iConta]->previsoesMensais[$iMes])) {

    $oNovaPrevisao = new stdClass();
    $oNovaPrevisao->mes = $iMes;
    $oNovaPrevisao->dataInicio    = $aConta['k168_previni'];
    $oNovaPrevisao->dataFinal     = $aConta['k168_prevfim'];
    $oNovaPrevisao->valorPrevisto = $aConta['k168_vlrprev'];

    $oNovaPrevisao->lancamentos   = array();

    $aContas[$iConta]
      ->previsoesMensais[$iMes] = $oNovaPrevisao;

  }


  if (!isset($aContas[$iConta]->previsoesMensais[$iMes]->lancamentos[$iLancamento])) {

    $oNovoLancamento = new stdClass();
    $oNovoLancamento->lancamento        = $iLancamento;
    $oNovoLancamento->codSlip           = $aConta['cod_slip'];
    $oNovoLancamento->dataRecebimento   = $aConta['data_recebimento'];
    $oNovoLancamento->valorRecebido     = $aConta['valor_recebido'];

    $aContas[$iConta]
      ->previsoesMensais[$iMes]
      ->lancamentos[$iLancamento] = $oNovoLancamento;

  }

}


$aMeses = array(
  1 => 'Janeiro',
    'Fevereiro',
    'Março',
    'Abril',
    'Maio',
    'Junho',
    'Julho',
    'Agosto',
    'Setembro',
    'Outubro',
    'Novembro',
    'Dezembro'
);


// Configurações do relatório
$head3 = "Controle de Contas Extra-Orçamentárias";

$mPDF = new Relatorio('', 'A4-L');

$mPDF->addInfo($head3, 2);

ob_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Relatório</title>
<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
<style type="text/css">
.ritz .waffle { color: #000000; }
.ritz .waffle a { color: inherit; }
.ritz .waffle .s3 { background-color: #b7e1cd; font-family: 'Arial'; font-size: 10pt; font-weight: bold; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s2 { font-family: 'Arial'; font-size: 10pt; font-weight: bold; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s1 { font-family: 'Arial'; font-size: 12pt; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s6 { font-family: 'Arial'; font-size: 8pt; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s8 { font-family: 'Arial'; font-size: 10pt; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s7 { font-family: 'Arial'; font-size: 8pt; font-weight: bold; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s9 { font-family: 'Arial'; font-size: 10pt; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s0 { font-family: 'Arial'; font-size: 12pt; font-weight: bold; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s4 { font-family: 'Arial'; font-size: 10pt; font-weight: bold; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
.ritz .waffle .s5 { font-family: 'Arial'; font-size: 10pt; padding: 2px 3px 2px 3px; text-align: left; vertical-align: bottom; }
</style>
</head>
<body>
<div class="content">

<?php foreach($aContas as $aConta): ?>
<?php
$totalRecebidos = 0;
$totalPrevistos = 0;
?>


  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th style="width:155px">&nbsp;</th>
          <th style="width:130px">&nbsp;</th>
          <th style="width:150px">&nbsp;</th>
          <th style="width:130px">&nbsp;</th>
          <th style="width:210px">&nbsp;</th>
          <th style="width:210px">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="s0" colspan="6">
            Conta: <?= $aConta->codigo ?> - <?= $aConta->descricao ?>
          </td>
        </tr>
        <tr>
          <td class="s0" colspan="2">Valor Previsto (anual):</td>
          <td class="s1" colspan="4">
            R$ <?= db_formatar($aConta->previsao, 'f') ?>
          </td>
        </tr>

        <!-- recebimentos mensais -->


        <?php foreach ($aConta->previsoesMensais as $recebimento): ?>
        <?php $valorTotalPrevisao = 0; ?>

        <tr>
          <td class="s1" colspan="6">&nbsp;</td>
        </tr>
        <tr>
          <td class="s2">
            Mês: <?= $aMeses[$recebimento->mes] ?>
          </td>
          <td class="s2" colspan="3">
            Previsão de Recebimento:
            <?= db_formatar($recebimento->dataInicio, 'd') ?> a
            <?= db_formatar($recebimento->dataFinal, 'd') ?>
          </td>
          <td class="s2">Valor Previsto:</td>
          <td class="s3">R$ <?= db_formatar($recebimento->valorPrevisto, 'f') ?></td>
        </tr>
        <tr>
          <td class="s2">Lançamentos</td>
          <td class="s2">Cod. SLIP</td>
          <td class="s2">Data Recebimento</td>
          <td class="s2">Valor Recebido</td>
          <td class="s2">Diferença Previsto (mensal)</td>
          <td class="s4">Diferença Previsto (anual)</td>
        </tr>


          <?php foreach ($recebimento->lancamentos as $lancamento): ?>
            <?php
            $valorTotalPrevisao += $lancamento->valorRecebido;
            $totalRecebidos += $lancamento->valorRecebido;
          ?>
          <tr>
            <td class="s5">
              <?= $lancamento->lancamento ?>
            </td>
            <td class="s5">
              <?= $lancamento->codSlip ?>
            </td>
            <td class="s5">
              <?= db_formatar($lancamento->dataRecebimento, 'd') ?>
            </td>
            <td class="s5">
              R$ <?= db_formatar($lancamento->valorRecebido, 'f') ?>
            </td>
            <td class="s5">
              R$ <?= db_formatar(($recebimento->valorPrevisto - $valorTotalPrevisao), 'f') ?>
            </td>
            <td class="s5">
              R$ <?= db_formatar(($aConta->previsao - $totalRecebidos), 'f') ?>
            </td>
          </tr>
          <?php endforeach; // lancamentos ?>

        <tr>
          <td class="s6" colspan="2">Total de Recebimentos no período:</td>
          <td class="s7" colspan="4">
            R$ <?= db_formatar($valorTotalPrevisao, 'f') ?>
          </td>
        </tr>

        <?php
          $totalPrevistos += $recebimento->valorPrevisto;
//          print_r($totalPrevistos);
        ?>
        <?php endforeach; // recebimentos mensais ?>

        <tr>
          <td class="s1" colspan="6">&nbsp;</td>
        </tr>
        <tr>
          <td class="s6" colspan="2">Total de Recebimentos até o período:</td>
          <td class="s7">
            R$ <?= db_formatar($totalRecebidos, 'f') ?>
          </td>
          <td class="s1"></td>
          <td class="s1"></td>
          <td class="s1"></td>
        </tr>
        <tr>
          <td class="s6" colspan="2">Total de Recebimentos previsto até o período:</td>
          <td class="s7">
            R$ <?= db_formatar($totalPrevistos, 'f') ?>
          </td>
          <td class="s1"></td>
          <td class="s1"></td>
          <td class="s1"></td>
        </tr>
      </tbody>
    </table>
  </div>
<?php endforeach; // contas ?>

</div>
</body>
</html>

<?php

$html = ob_get_contents();

ob_end_clean();

try {

  $mPDF->WriteHTML(utf8_encode($html));
  $mPDF->Output();

} catch (Exception $e) {

  print_r($e->getMessage());

}


?>
