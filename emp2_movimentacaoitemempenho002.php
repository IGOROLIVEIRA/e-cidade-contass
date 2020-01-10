<?php
//echo '<pre>';ini_set("display_errors", true);
include("model/relatorios/Relatorio.php");
include("libs/db_utils.php");
include("std/DBDate.php");
include("libs/db_conecta.php");
include("dbforms/db_funcoes.php");

$aConsulta = array();
$instituicao    = db_getsession('DB_instit');
$ano            = db_getsession('DB_anousu');
$condicoes      = "";
$e60_numemp     = "";
$z01_numcgm     = "";
$e60_codemp     = "";
$o58_coddot     = "";
$pc01_codmater  = "";
$e53_codord     = "";
$d1             = "";
$d2             = "";
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

try {

  if (isset($aFiltros['e60_numemp']) && !empty($aFiltros['e60_numemp'])) {
    $e60_numemp = $aFiltros['e60_numemp'];
    $condicoes .= " e60_numemp = {$e60_numemp} ";
  }

  if (isset($aFiltros['e60_codemp']) && !empty($aFiltros['e60_codemp'])) {
    $e60_codemp_ano = $aFiltros['e60_codemp'];
    $e60_codemp = explode("/",$e60_codemp_ano);
    $e60_codemp = $e60_codemp[0];
    if ($condicoes != "") {
      $condicoes .= " AND e60_codemp = '{$e60_codemp}' ";
    } else {
      $condicoes .= " e60_codemp = '{$e60_codemp}' ";
    }
  }

  if (isset($aFiltros['e60_coddot']) && !empty($aFiltros['e60_coddot'])) {
    $e60_coddot = $aFiltros['e60_coddot'];
    if ($condicoes != "") {
      $condicoes .= " AND e60_coddot = {$e60_coddot} ";
    } else {
      $condicoes .= " e60_coddot = {$e60_coddot} ";
    }
  }

  if (isset($aFiltros['pc01_codmater']) && !empty($aFiltros['pc01_codmater'])) {
    $pc01_codmater = $aFiltros['pc01_codmater'];
    if ($condicoes != "") {
      $condicoes .= " AND pc01_codmater = {$pc01_codmater} ";
    } else {
      $condicoes .= " pc01_codmater = {$pc01_codmater} ";
    }
  }

  if (isset($aFiltros['e50_codord']) && !empty($aFiltros['e50_codord'])) {
    $e50_codord = $aFiltros['e50_codord'];
    if ($condicoes != "") {
      $condicoes .= " AND e50_codord = {$e50_codord} ";
    } else {
      $condicoes .= " e50_codord = {$e50_codord} ";
    }
  }

  if (isset($aFiltros['z01_numcgm']) && !empty($aFiltros['z01_numcgm'])) {
    $z01_numcgm = $aFiltros['z01_numcgm'];
    if ($condicoes != "") {
      $condicoes .= " AND z01_numcgm = {$z01_numcgm} ";
    } else {
      $condicoes .= " z01_numcgm = {$z01_numcgm} ";
    }
  }

  if (isset($aFiltros['dt1']) && !empty($aFiltros['dt1']) && isset($aFiltros['dt2']) && !empty($aFiltros['dt2'])) {
    $dt1 = $aFiltros['dt1'];
    $dt2 = $aFiltros['dt2'];
    if ($condicoes != "") {
      $condicoes .= " AND e60_emiss between '{$dt1}' and '{$dt2}' ";
    } else {
      $condicoes .= "  e60_emiss between '{$dt1}' and '{$dt2}' ";
    }
  }

  if ($condicoes == "") {
    $condicoes  .= " e60_anousu = {$ano} ";
  }

  $sSQL = "
  SELECT e62_vltot,
         e60_numemp,
         z01_numcgm,
         z01_nome,
         pc01_codmater,
         pc01_descrmater,
         qtd_alq,
         substr(saldoitens,1,10) e62_quant,
         e62_vlrun1,

         CASE
             WHEN desp_invest
                  AND sum(round(substr(saldoitens,36,14)::float8,2) + round(substr(saldoitens,51,14)::float8,2)) = round(e62_vltot,2) 
                    THEN 0
             WHEN desp_invest
                  AND sum(round(substr(saldoitens,36,14)::float8,2) + round(substr(saldoitens,51,14)::float8,2)) < round(e62_vltot,2) 
                    THEN sum((round(e62_vltot,2) - round(substr(saldoitens,36,14)::float8,2) - round(substr(saldoitens,51,14)::float8,2)) / round(substr(saldoitens,21,14)::float8,2))
             WHEN (pc01_servico, e62_servicoquantidade,desp_invest) = ('t', 'f', 'f')
                  AND sum(e62_vltot - round(substr(saldoitens,51,14)::float8,2)) > 0 
                    THEN sum((round(e62_vltot,2) - round(substr(saldoitens,36,14)::float8,2) - round(substr(saldoitens,51,14)::float8,2)) / round(substr(saldoitens,21,14)::float8,2))
             WHEN (pc01_servico, e62_servicoquantidade) = ('t', 'f')
                  AND sum(e62_vltot - round(substr(saldoitens,51,14)::float8,2)) = 0 THEN 0
             ELSE substr(saldoitens,11,10)::float8
         END saldo_item,
    
         CASE
             WHEN (pc01_servico, e62_servicoquantidade,desp_invest) = ('t', 'f', 'f')
                  AND round(substr(saldoitens,51,14)::float8,2) > 0 THEN 1::float8
             WHEN (pc01_servico, e62_servicoquantidade) = ('t', 'f')
                  AND round(substr(saldoitens,51,14)::float8,2) = 0 THEN 0::float8
             ELSE sum(round(substr(saldoitens,51,14)::float8,2) / e62_vlrun1)
         END qtd_lqd,

         round(substr(saldoitens,21,14)::float8,2) e62_vlrun,
         round(substr(saldoitens,36,14)::float8,2) vlr_anl,
         round(substr(saldoitens,51,14)::float8,2) vlr_lqd
  FROM
  (SELECT DISTINCT ON (e62_numemp, e62_item)
         e62_sequencial,
         round(e62_vlrun,2) e62_vlrun1,
         e62_vlrun,
         e62_vltot,
         e60_codemp||'/'||e60_anousu AS e60_numemp,
         z01_numcgm,
         substr(z01_nome,1,35) AS z01_nome,
         pc01_codmater,
         substr(pc01_descrmater,1,40) AS pc01_descrmater,
         pc01_servico,
         e62_servicoquantidade,
         e72_qtd,
         
         CASE
             WHEN substr(o56_elemento,1,3) = '344' THEN TRUE
             ELSE FALSE
         END AS desp_invest,

         CASE
             WHEN e37_qtd > 0 THEN e37_qtd
             ELSE 0
         END AS qtd_alq,
         (SELECT TO_CHAR(ABS(rnquantini),'999999999')
               ||TO_CHAR(ABS(rnsaldoitem),'999999999')
               ||TO_CHAR(ABS(rnvaloruni),'9999999999.99')
               ||TO_CHAR(ABS(rnvaloranul),'9999999999.99')
               ||TO_CHAR(ABS(rnvalorliq),'9999999999.99') saldoitensempenho 
       FROM fc_saldoitensempenho(e62_numemp, e62_sequencial)) saldoitens
  FROM empempenho
  LEFT JOIN pagordem ON e50_numemp = e60_numemp
  LEFT JOIN empempitem ON e62_numemp = e60_numemp
  LEFT JOIN empnotaitem ON e72_empempitem = e62_sequencial
  LEFT JOIN pcmater ON e62_item = pc01_codmater
  LEFT JOIN empanulado ON e94_numemp = e60_numemp
  LEFT JOIN cgm ON z01_numcgm = e60_numcgm
  LEFT JOIN empanuladoitem ON e37_empanulado = e94_codanu
  INNER JOIN empelemento ON e64_numemp = e60_numemp
  INNER JOIN orcelemento ON (o56_codele, o56_anousu) = (e64_codele,e60_anousu)
  WHERE {$condicoes}
  GROUP BY e72_empempitem, e37_empempitem, e72_vlranu, e37_vlranu, e72_sequencial, e37_sequencial, e62_numemp, e62_sequen,
           e62_quant, e62_vlrun, e62_vltot, e62_item, e62_sequencial, pc01_servico, e60_codemp, e60_anousu, z01_numcgm, pc01_codmater,o56_elemento) x
  GROUP BY e62_quant, e62_vlrun, e62_vltot, e60_numemp, z01_numcgm, z01_nome, pc01_codmater, pc01_descrmater, qtd_alq, saldoitens, e72_qtd, pc01_servico, e62_servicoquantidade, e62_vlrun1,desp_invest";
  // die($sSQL);
  $rsConsulta = db_query($sSQL);
  // db_criatabela($rsConsulta);
  $aConsulta = pg_fetch_all($rsConsulta);

  if ($aConsulta === false) {

    throw new Exception("Erro ao realizar consulta!", 1);

  }

} catch (Exception $e) {
  echo $e->getMessage();
  //db_redireciona('db_erros.php?fechar=true&db_erro='. $e->getMessage());
}


$aItensEmpenhos = array();


foreach ($aConsulta as $aItensEmpenho) {

  $iCredor = $aItensEmpenho['z01_numcgm'];
  $iEmp    = $aItensEmpenho['e60_numemp'];
  $iCodMat = $aItensEmpenho['pc01_codmater'];

  if (!isset($aItensEmpenhos[$iCredor])) {

    $oNovoCredor = new stdClass();
    $oNovoCredor->z01_numcgm = $iCredor;
    $oNovoCredor->z01_nome   = $aItensEmpenho['z01_nome'];
    $oNovoCredor->empenhos   = array();
    $aItensEmpenhos[$iCredor] = $oNovoCredor;

  }

  if (!isset($aItensEmpenhos[$iCredor]->empenhos[$iEmp])) {

    $oNovoEmpenho = new stdClass();
    $oNovoEmpenho->e60_numemp = $iEmp;
    $oNovoEmpenho->itens      = array();
    $aItensEmpenhos[$iCredor]->empenhos[$iEmp] = $oNovoEmpenho;

  }

  if (!isset($aItensEmpenhos[$iCredor]->empenhos[$iEmp]->itens[$iCodMat])) {

    $oNovoEmpenhoItem = new stdClass();
    $oNovoEmpenhoItem->pc01_codmater   = $iCodMat;
    $oNovoEmpenhoItem->pc01_descrmater = $aItensEmpenho['pc01_descrmater'];
    $oNovoEmpenhoItem->e62_quant       = $aItensEmpenho['e62_quant'];
    $oNovoEmpenhoItem->e62_vlrun       = $aItensEmpenho['e62_vlrun'];
    $oNovoEmpenhoItem->e62_vltot       = $aItensEmpenho['e62_vltot'];
    $oNovoEmpenhoItem->qtd_lqd         = $aItensEmpenho['qtd_lqd'];
    $oNovoEmpenhoItem->vlr_lqd         = $aItensEmpenho['vlr_lqd'];
    $oNovoEmpenhoItem->vlr_anl         = $aItensEmpenho['vlr_anl'];
    $oNovoEmpenhoItem->saldo_item      = $aItensEmpenho['saldo_item'];

    $aItensEmpenhos[$iCredor]->empenhos[$iEmp]->itens[$iCodMat] = $oNovoEmpenhoItem;

  }

}
//echo '<pre>';ini_set("display_errors", true);
//print_r($aItensEmpenhos);die;
// Configurações do relatório

$head1 = "Movimentação de itens no empenho";
$head2 = "";
$head3 = "";
if (isset($aFiltros['dt1']) && !empty($aFiltros['dt1']) && isset($aFiltros['dt2']) && !empty($aFiltros['dt2'])) {
  $data1 = implode("/",array_reverse(explode("-",$aFiltros['dt1'] )));
  $data2 = implode("/",array_reverse(explode("-",$aFiltros['dt2'] )));
  $head2 = "Data: {$data1} à {$data2}";
}
if (isset($aFiltros['e60_codemp']) && !empty($aFiltros['e60_codemp'])) {
  $e60_codemp = $aFiltros['e60_codemp'];
  $head3 = "Número do empenho: {$data1} à {$data2}";
}

$mPDF = new Relatorio('', 'A4-P');

$mPDF->addInfo($head1, 1);
$mPDF->addInfo($head2, 2);
$mPDF->addInfo($head3, 3);
//$mPDF->addInfo($head7, 7);

ob_start();

?>
<!DOCTYPE html>
<html>
<head>
<title>Relatório</title>
<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
<style type="text/css">
tbody {
  .pagina { clear: both; margin-bottom: 0; padding: 0; page-break-after: initial;}
}
.ritz .waffle a { color: inherit; }
.ritz .waffle .s5  {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s12 {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d9d9d9;text-align:left;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s0  {border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';font-size:18pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s9  {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s13 {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d9d9d9;text-align:right;font-weight:bold;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s8  {font-size:16pt;border-left: none;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s3  {font-size:16pt;border-left: none;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s10 {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s2  {font-size:16pt;border-right: none;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s11 {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d9d9d9;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s1  {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s7  {font-size:16pt;border-left: none;border-right: none;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s6  {font-size:16pt;border-right: none;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s4  {font-size:16pt;border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}

</style>
</head>
  <body>
    <div class="ritz grid-container">
      <table class="waffle" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th id="0C0" style="width:130px; border:none;">&nbsp;</th>
            <th id="0C1" style="width:112px; border:none;">&nbsp;</th>
            <th id="0C2" style="width:100px; border:none;">&nbsp;</th>
            <th id="0C3" style="width:100px; border:none;">&nbsp;</th>
            <th id="0C4" style="width:100px; border:none;">&nbsp;</th>
            <th id="0C5" style="width:100px; border:none;">&nbsp;</th>
            <th id="0C6" style="width:100px; border:none;">&nbsp;</th>
          </tr>
        </thead>
        <?php $e62_vltot = 0; $vlr_lqd = 0; $vlr_anl = 0;?>
        <?php foreach($aItensEmpenhos as $aItensEmpenho) : ?>
        <?php foreach($aItensEmpenho->empenhos as $empenhos) : ?>
        <tbody style="margin-bottom: 20px;">
          <tr>
            <td class="s0" style="border-bottom:none; width: 100px;">Empenho</td>
            <td class="s0" style="border-bottom:none;border-right:none;">Credor</td>
          </tr>
          <tr>
            <td class="s1" style="border-bottom:none;"><?= $empenhos->e60_numemp ?></td>
            <td colspan="4" class="s2" style="border-bottom:none;">
              <div style="width: 280px; left: -1px;"><?= $aItensEmpenho->z01_numcgm ?> - <?=$aItensEmpenho->z01_nome ?></div>
            </td>
          </tr>
          <tr>
            <td colspan="4" class="s4" style="border:none;">Cod./Desc. Material</td>
            <td class="s1" style="border:none;"></td>
            <td class="s1" style="border:none;"></td>
            <td class="s1" style="border:none;"></td>
          </tr>
          <?php foreach($empenhos->itens as $itens) : ?>
          <tr>
            <td colspan="4" class="s2" style="border-bottom:1px SOLID #000000;">
              <div style="width: 280px; left: -1px;"><?= $itens->pc01_codmater ?> - <?= $itens->pc01_descrmater ?></div>
            </td>
            <td class="s3" style="border-bottom:1px SOLID #000000; border-right: none;"></td>
            <td class="s3" style="border-bottom:1px SOLID #000000; border-right: none;"></td>
            <td class="s1" style="border-right: none;"></td>
            <td></td>
          </tr>
          <tr>
            <td class="s5" style="border-left: 1px solid #000000">Qtd. Empenho</td>
            <td class="s5">Vlr. Unitário</td>
            <td class="s6" style="border-bottom:1px SOLID #000000; border-right: 1px SOLID #000000;">Vlr. Total</td>
            <td class="s7" style="border-bottom:1px SOLID #000000; border-right: 1px SOLID #000000;">
              <div style="text-align:center">Qtd. Liquidada</div>
            </td>
            <td class="s8" style="border-bottom:1px SOLID #000000; border-right: 1px SOLID #000000;">
              <div style="text-align:center">Vlr. Liquidado</div>
            </td>
            <td class="s6" style="border-bottom:1px SOLID #000000; border-right: 1px SOLID #000000;">Vlr. Anulado</td>
            <td class="s7" style="border-bottom:1px SOLID #000000; border-right: 1px SOLID #000000;">
              <div style="text-align: center">Saldo do Item</div>
            </td>
          </tr>

          <?php
            $e62_vltot += $itens->e62_vltot;
            $vlr_lqd   += $itens->vlr_lqd;
            $vlr_anl   += $itens->vlr_anl;
          ?>

          <tr>
            <td class="s9" style="border-left: 1px solid #000000"><?= $itens->e62_quant ?></td>
            <td class="s10">R$ <?= number_format($itens->e62_vlrun, 2, ',', '.') ?></td>
            <td class="s10">R$ <?= number_format($itens->e62_vltot, 2, ',', '.') ?></td>
            <td class="s9"><?= $itens->qtd_lqd ?></td>
            <td class="s10">R$ <?= number_format($itens->vlr_lqd, 2, ',', '.') ?></td>
            <td class="s10">R$ <?= number_format($itens->vlr_anl, 2, ',', '.') ?></td>
            <td class="s9"><?= $itens->saldo_item ?></td>
          </tr>

          <?php endforeach; ?>
          <tr>
            <td class="s11" style="border-left: 1px solid #000000">Total Geral: </td>
            <td class="s12"></td>
            <td class="s13">R$ <?= number_format($e62_vltot, 2, ',', '.');  ?> </td>
            <td class="s11" style="border-left: 1px solid #000000"></td>
            <td class="s13">R$ <?= number_format($vlr_lqd, 2, ',', '.');  ?></td>
            <td class="s13">R$ <?= number_format($vlr_anl, 2, ',', '.');  ?></td>
            <td class="s11" style="border-left: 1px solid #000000"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php
            $e62_vltot = 0;
            $vlr_lqd   = 0;
            $vlr_pg    = 0;
            $vlr_anl   = 0;
          ?>
        </tbody>
        <?php endforeach; ?>
        <?php endforeach; ?>
      </table>
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
