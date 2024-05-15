<?php

include("model/relatorios/Relatorio.php");
include("libs/db_utils.php");
include("std/DBDate.php");
include("libs/db_conecta.php");
include("dbforms/db_funcoes.php");

$aConsulta = array();

parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

try {

  if (isset($aFiltros['transferencias']) && !empty($aFiltros['transferencias'])) {
        $cd_transferencias = $aFiltros['transferencias'];
        $sSQL = "
            SELECT t.ve80_sequencial,
                   v.ve81_codigo,
                   a.descrdepto atual,
                   d.descrdepto destino,
                   t.ve80_motivo,
                   v.ve81_placa,
                   CASE tipoveiculos.si04_tipoveiculo
                       WHEN 1 THEN 'Aeronaves'
                       WHEN 2 THEN 'Embarcações'
                       WHEN 3 THEN 'Veículos'
                       WHEN 4 THEN 'Maquinário'
                       WHEN 5 THEN 'Equipamentos'
                       WHEN 99 THEN 'Outros'
                   END AS si04_tipoveiculo,
                   tipoveiculos.si04_descricao,
                   a.nomeresponsavel ratual,
                   d.nomeresponsavel rdestino,
                   t.ve80_dt_transferencia
            FROM veiculos
            INNER JOIN veiculostransferencia v ON v.ve81_codigo     = veiculos.ve01_codigo
            INNER JOIN transferenciaveiculos t ON t.ve80_sequencial = v.ve81_transferencia
            INNER JOIN db_depart a             ON a.coddepto        = t.ve80_coddeptoatual
            INNER JOIN db_depart d             ON d.coddepto        = t.ve80_coddeptodestino
            INNER JOIN tipoveiculos            ON tipoveiculos.si04_veiculos = veiculos.ve01_codigo
            WHERE t.ve80_sequencial IN (".$cd_transferencias.")
            ORDER BY t.ve80_sequencial, si04_tipoveiculo, tipoveiculos.si04_descricao
          ";  //print_r($sSQL); die;

  }

  $rsConsulta = db_query($sSQL);
  $aConsulta = pg_fetch_all($rsConsulta);

  if ($aConsulta === false) {
    throw new Exception("Não foi possível imprimir comprovante! Entrar em contato com o setor de Desenvolvimento", 1);
  }

} catch (Exception $e) {
    echo $e->getMessage();
  }

$aTransferencias = array();

  foreach ($aConsulta as $aTransferencia) {

    $iTransferencia = trim($aTransferencia['ve80_sequencial']);
    $iVeiculo       = trim($aTransferencia['ve81_codigo']);

    if (!isset($aTransferencias[$iTransferencia])) {
      $oNovaTransferencia = new stdClass();
      $oNovaTransferencia->ve80_sequencial       = trim($iTransferencia);
      $oNovaTransferencia->ve80_dt_transferencia = trim(implode("/",array_reverse(explode("-",$aTransferencia['ve80_dt_transferencia']))));
      $oNovaTransferencia->ve80_motivo           = trim($aTransferencia['ve80_motivo']);
      $oNovaTransferencia->atual                 = trim($aTransferencia['atual']);
      $oNovaTransferencia->destino               = trim($aTransferencia['destino']);
      $oNovaTransferencia->ratual                = trim($aTransferencia['ratual']);
      $oNovaTransferencia->rdestino              = trim($aTransferencia['rdestino']);
      $oNovaTransferencia->veiculos        = array();

      $aTransferencias[$iTransferencia]    = $oNovaTransferencia;
    }

    if (!isset($aTransferencias[$iTransferencia]->veiculos[$iVeiculo])) {
       $oNovoVeiculo = new stdClass();
       $oNovoVeiculo->ve81_codigo      = trim($iVeiculo);
       $oNovoVeiculo->ve81_placa       = trim($aTransferencia['ve81_placa']);
       $oNovoVeiculo->si04_tipoveiculo = trim($aTransferencia['si04_tipoveiculo']);
       $oNovoVeiculo->si04_descricao   = trim($aTransferencia['si04_descricao']);

       $aTransferencias[$iTransferencia]->veiculos[$iVeiculo] = $oNovoVeiculo;
    }
  }

// Configurações do relatório
$head1 = "Comprovante de Transferência de Veículo(s).";
//$head3 = "Data: {$aFiltros['data']}";

$mPDF = new Relatorio('', 'A4');
//$mPDF->addPage();
$mPDF->addInfo($head1, 1);
//$mPDF->addInfo($head3, 3);

ob_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Relatório</title>
  <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
  <style type="text/css">
  body {
    font-family: Arial;
  }
    .text-center { text-align: center;  }
    .table { border: 1px solid #bbb; margin-top: 20px; margin-bottom: 30px;  background-color: #fff; }
    .table th, .table td { padding: 2px 6px;  border: 1px solid #bbb;  font-size: 11px;  }
    .table th { background-color: #ddd;  }
    .th_size { font-size: 12px;  }
    .table .th_tipo { width: 470px;  font-size: 11px;  }
    .texto { text-align: justify;  padding: 0;}
    div .atual { border-top: 1px solid #000;  float: left;  margin-bottom: 0;  text-align: center;  width: 35%;  font-size: 11px; }
    div .destino { border-top: 1px solid #000;  float: right; margin-bottom: 0; text-align: center;  width: 35%;  font-size: 11px; }
    div .atual span { display: block; }
    .datamanual { text-align: right;  margin-bottom: 8%; }
    .data { text-align: right;  font-weight: bold;}
    .pagina { clear: both;  height: 100%; margin-bottom: 0; padding: 0; page-break-after: initial;}

  </style>
</head>
<body>
<?php $nContador = count($aTransferencias); ?>
<?php foreach($aTransferencias as $aTransferencia): ?>
  <div class="pagina">
    <h2>Transferência: <?= $aTransferencia->ve80_sequencial ?></h2>
    <p class="data">DATA: <?= $aTransferencia->ve80_dt_transferencia ?></p>
    <p class="texto">
      O Chefe do Departamento <?= strtoupper($aTransferencia->atual) ?>, no uso de suas atribuições, autoriza a transferência do(s) veículo(s) listado(s) abaixo para o Departamento <?= strtoupper($aTransferencia->destino) ?> mediante motivo: <?= strtoupper($aTransferencia->ve80_motivo) ?>.
    </p>
    <table class="table">
        <thead>
          <tr>
            <th class="th_size">Placa</th>
            <th class="th_size">Tipo</th>
            <th class="th_tipo">Especificação</th>
          </tr>
        </thead>
        <tbody id="table_veiculos">
          <?php foreach ($aTransferencia->veiculos as $veiculo):  ?>
            <tr>
              <td class="text-center"><?= $veiculo->ve81_placa ?></td>
              <td class="text-center"><?= $veiculo->si04_tipoveiculo ?></td>
              <td><?= $veiculo->si04_descricao ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>&nbsp;</tfoot>
    </table>
    <div class="datamanual">
        _____ de __________________ de ________
    </div>
    <div class="atual">
      <div><span><?php if(!empty($aTransferencia->ratual)){$aTransferencia->ratual;} else {echo "Responsável";} ?></span></div>
      <span><?= $aTransferencia->atual ?></span>
    </div>
    <div class="destino">
      <div><span><?php if(!empty($aTransferencia->rdestino)){$aTransferencia->rdestino;} else {echo "Responsável";} ?></span></div>
      <span><?= $aTransferencia->destino ?></span>
    </div>
  </div>

    <?php if (--$nContador > 0): ?>
      <pagebreak resetpagenum="1" pagenumstyle="1" suppress="off">
    <?php endif; ?>

  <?php endforeach; ?>
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

