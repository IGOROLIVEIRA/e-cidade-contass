<?php

require_once("model/relatorios/Relatorio.php");


/**
 * Arquivo responsável pela consulta SQL.
 * Como esta consulta é compartilhada, é melhor estar separado
 */
require_once("mat2_relatoriosaidasmateriasdepto003.php");

$aResultadoBusca = array();

try {

  $rsSaidas = db_query($sSqlSaidas);
  $iNumRows = pg_num_rows($rsSaidas);

  if ($iNumRows == 0) {
    throw new Exception("Não existem dados para esta busca", 1);
  }

  $aResultadoBusca = db_utils::getCollectionByRecord($rsSaidas);

} catch (Exception $e) {
  db_redireciona('db_erros.php?fechar=true&db_erro='. $e->getMessage());
}



$aDepartamentos = array();

foreach ($aResultadoBusca as $key => $oItem) {

  $iOrigem   = $oItem->m70_coddepto;
  $iDestino  = $oItem->m40_depto;

  if (!isset($aDepartamentos[$iOrigem])) {

    $oOrigem = new stdClass();
    $oOrigem->titulo = substr($iOrigem . " - " . $oItem->descrdepto, 0, 25);
    $oOrigem->destinos = array();

    $aDepartamentos[$iOrigem] = $oOrigem;

  }


  if ($oItem->m83_coddepto != "") {
    $iDestino = $oItem->m83_coddepto;
  }


  if (!isset($aDepartamentos[$iOrigem]->destinos[$iDestino])) {

    $oDestino = new stdClass();
    $oDestino->materiais  = array();
    $oDestino->valorTotal = 0;
    $oDestino->qtdTotal   = 0;
    $oDestino->titulo     = "";

    if ($iDestino != "") {

      $sSqlDeptoDestino = "SELECT descrdepto FROM db_depart WHERE coddepto = {$iDestino}";
      $rsDeptoDestino   = db_query($sSqlDeptoDestino);

      $oDestino->titulo = "{$iDestino} - " . db_utils::fieldsMemory($rsDeptoDestino, 0)->descrdepto;

    }

    $aDepartamentos[$iOrigem]->destinos[$iDestino] = $oDestino;

  }


  $oMaterial = new stdClass();
  $oMaterial->codigo    = $oItem->m70_codmatmater;
  $oMaterial->descricao = $oItem->m60_descr;
  $oMaterial->unidade   = $oItem->m61_abrev;

  $iLancamento = $oItem->m41_codmatrequi;

  if ($oItem->m41_codmatrequi == "") {
    $iLancamento = $oItem->m80_codigo;
  }

  $oMaterial->lancamento  = substr($oItem->m81_descr,0,30 ) . "({$iLancamento})";
  $oMaterial->data        = db_formatar($oItem->m80_data, 'd');
  $oMaterial->precoMedio  = number_format($oItem->precomedio, $iParametroNumeroDecimal);
  $oMaterial->quantidade  = $oItem->qtde;
  $oMaterial->valorTotal  = db_formatar($oItem->m89_valorfinanceiro, 'f');


  $aDepartamentos[$iOrigem]
    ->destinos[$iDestino]
      ->qtdTotal += $oItem->qtde;


  $aDepartamentos[$iOrigem]
    ->destinos[$iDestino]
      ->valorTotal += $oItem->m89_valorfinanceiro;


  $aDepartamentos[$iOrigem]
    ->destinos[$iDestino]
      ->materiais[] = $oMaterial;

}



$mPDF = new Relatorio('', 'A4-L');

$mPDF->addInfo($head3, 3);
$mPDF->addInfo($head4, 4);
$mPDF->addInfo($head5, 5);
$mPDF->addInfo($head7, 7);

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Relatório</title>
<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">

<style type="text/css">
.ritz { width: 100%; font-size: 8pt; margin-bottom: 10px; }
.ritz .s5   { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; padding: 2px 3px 2px 3px; text-align: center; }
.ritz .s10  { background-color: #cccccc; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; font-weight: bold; padding: 2px 3px 2px 3px; text-align: right; }
.ritz .s1   { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; padding: 2px 3px 2px 3px; text-align: center; }
.ritz .s4   { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; overflow: hidden; padding: 2px 3px 2px 3px; text-align: left; white-space: normal; word-wrap: break-word; }
.ritz .s2   { background-color: #cccccc; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; font-weight: bold; padding: 2px 3px 2px 3px; text-align: center; }
.ritz .s6   { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; padding: 2px 3px 2px 3px; text-align: center; }
.ritz .s0   { background-color: #ffffff; border: 1px SOLID #000000; color: #000000; font-family: 'Arial'; padding: 2px 3px 2px 3px; text-align: center; }
.ritz .s7   { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; padding: 2px 3px 2px 3px; text-align: right; }
.ritz .s9   { background-color: #ffffff; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; padding: 2px 3px 2px 3px; text-align: left; }
.ritz .s3   { background-color: #cccccc; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; font-family: 'Arial'; font-weight: bold; overflow: hidden; padding: 2px 3px 2px 3px; text-align: center; white-space: normal; word-wrap: break-word; }
.ritz .s8   { background-color: #ffffff; color: #000000; font-family: 'Arial'; padding: 2px 3px 2px 3px; text-align: left; }

.borda-top { border-top: 1px SOLID #000; }
.borda-left { border-left: 1px SOLID #000; }
.borda-right { border-right: 1px SOLID #000; }
.borda-bottom { border-bottom: 1px SOLID #000; }
</style>

</head>
<body>

<div class="content">

<?php
foreach($aDepartamentos as $iOrigem => $oOrigem):
  foreach ($oOrigem->destinos as $iDestino => $oDestino):
?>
    <table class="ritz" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th style="width: 100px;">&nbsp;<!-- material --></th>
          <th style="width: 300px;">&nbsp;<!-- descr. material --></th>
          <th style="width: 90px;">&nbsp;<!-- unidade --></th>
          <th style="width: 250px;">&nbsp;<!-- lançamento --></th>
          <th style="width: 90px;">&nbsp;<!-- data --></th>
          <th style="width: 107px;">&nbsp;<!-- preço médio --></th>
          <th style="width: 90px;">&nbsp;<!-- quantidade --></th>
          <th style="width: 100px;">&nbsp;<!-- valor total --></th>
        </tr>
      </thead>
      <tbody>
        <tr style='height:20px;'>
          <td class="s0" colspan="3">Departamento Origem: <?= $oOrigem->titulo ?></td>
          <td class="s1 borda-top" colspan="5">Departamento Destino: <?= $oDestino->titulo ?></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s2 borda-left">Material</td>
          <td class="s3">Descrição do Material</td>
          <td class="s2">Unidade</td>
          <td class="s2">Lançamento</td>
          <td class="s2">Data</td>
          <td class="s2">Preço Médio</td>
          <td class="s2">Quant.</td>
          <td class="s2">Valor Total</td>
        </tr>

        <?php foreach($oDestino->materiais as $oItem): ?>
          <tr style='height:20px;'>
            <td class="s1 borda-left"><?= $oItem->codigo ?></td>
            <td class="s4"><?= $oItem->descricao ?></td>
            <td class="s5"><?= $oItem->unidade ?></td>
            <td class="s6"><?= $oItem->lancamento ?></td>
            <td class="s1"><?= $oItem->data ?></td>
            <td class="s7"><?= $oItem->precoMedio ?></td>
            <td class="s1"><?= $oItem->quantidade ?></td>
            <td class="s7"><?= $oItem->valorTotal ?></td>
          </tr>
        <?php endforeach; ?>

        <tr style='height:20px;'>
          <td class="s8"></td>
          <td class="s8"></td>
          <td class="s8"></td>
          <td class="s8"></td>
          <td class="s9"></td>
          <td class="s2">Total:</td>
          <td class="s2"><?= $oDestino->qtdTotal ?></td>
          <td class="s10"><?= $oDestino->valorTotal ?></td>
        </tr>
      </tbody>
    </table>

<?php
  endforeach;
endforeach;
?>

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
