<?php
//echo "<pre>";ini_set("display_errors", true);
require_once("model/relatorios/Relatorio.php");
require_once("libs/db_utils.php");
require_once("std/DBDate.php");


parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);
$protocolo;
$aCabecalho;
$aAutEmpenhos   = array();
$aEmpenhos      = array();
$aAutCompras    = array();
$aAutPagamentos = array();
$aSlips         = array();
try {
  if (isset($aFiltros['protocolo']) && !empty($aFiltros['protocolo'])) {
    $protocolo      = $aFiltros['protocolo'];
    $aCabecalho     = cabecalho($protocolo);
    $aAutEmpenhos   = buscaAutEmpenhos($protocolo);
    $aEmpenhos      = buscaEmpenhos($protocolo);
    $aAutCompras    = buscaAutCompras($protocolo);
    $aAutPagamentos = buscaAutPagamentos($protocolo);
    $aSlips         = buscaSlips($protocolo);
  }


} catch (Exception $e) {

  db_redireciona('db_erros.php?fechar=true&db_erro='. $e->getMessage());

}

function cabecalho($protocolo) {
  $sSQL = "
    SELECT p.p101_sequencial,
      to_char(p.p101_dt_protocolo,'DD/MM/YYYY') p101_dt_protocolo,
       p.p101_hora,
       p.p101_observacao,
       to_char(p.p101_dt_anulado,'DD/MM/YYYY') p101_dt_anulado,
       o.descrdepto origem,
       d.descrdepto destino,
       u.nome
    FROM protocolos p
    INNER JOIN db_depart o ON o.coddepto = p.p101_coddeptoorigem
    INNER JOIN db_depart d ON d.coddepto = p.p101_coddeptodestino
    INNER JOIN db_usuarios u ON u.id_usuario = p.p101_id_usuario
    WHERE p.p101_sequencial = {$protocolo}
  ";

  $rsConsulta = db_query($sSQL);
  $oCabecalho = db_utils::fieldsMemory($rsConsulta,0);
  return $oCabecalho;
}

function buscaAutEmpenhos($protocolo) {
  $sSQL = "
    SELECT e54_autori,
       z01_nome,
       sum(e55_vltot) AS e55_vltot
        FROM
            (SELECT distinct(e54_autori),
                    e54_emiss,
                    e54_anulad,
                    e54_numcgm,
                    z01_nome,
                    e54_instit
             FROM empautoriza
             INNER JOIN cgm ON cgm.z01_numcgm = empautoriza.e54_numcgm
             INNER JOIN db_config ON db_config.codigo = empautoriza.e54_instit
             INNER JOIN db_usuarios ON db_usuarios.id_usuario = empautoriza.e54_login
             INNER JOIN db_depart ON db_depart.coddepto = empautoriza.e54_depto
             INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = empautoriza.e54_codcom
             INNER JOIN concarpeculiar ON concarpeculiar.c58_sequencial = empautoriza.e54_concarpeculiar
             INNER JOIN protempautoriza ON protempautoriza.p102_autorizacao = empautoriza.e54_autori
             INNER JOIN protocolos on protocolos.p101_sequencial = protempautoriza.p102_protocolo
             LEFT JOIN empempaut ON empautoriza.e54_autori = empempaut.e61_autori
             LEFT JOIN empempenho ON empempenho.e60_numemp = empempaut.e61_numemp
             LEFT JOIN empautidot ON e56_autori = empautoriza.e54_autori
             AND e56_anousu=e54_anousu
             LEFT JOIN orcdotacao ON e56_Coddot = o58_coddot
             AND e56_anousu = o58_anousu
             WHERE  protocolos.p101_sequencial = {$protocolo}
            ) AS x
        INNER JOIN empautitem ON e54_autori = e55_autori
          GROUP BY e54_autori,
                   e54_emiss,
                   e54_anulad,
                   z01_nome,
                   e54_instit
          ORDER BY e54_autori
  ";
  $rsConsulta = db_query($sSQL);
  $oAutEmpenhos = pg_fetch_all($rsConsulta);
  return $oAutEmpenhos;
}

function buscaEmpenhos($protocolo) {
  $sSQL = "
    SELECT e60_numemp,
                z01_nome,
                e60_vlremp,
                e60_codemp || '/' || e60_anousu as e60_codemp
    FROM empempenho
    INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
    INNER JOIN protempenhos ON protempenhos.p103_numemp = empempenho.e60_numemp
    INNER JOIN protocolos ON protocolos.p101_sequencial = protempenhos.p103_protocolo
    WHERE protocolos.p101_sequencial = {$protocolo}
    ORDER BY e60_anousu, CAST (e60_codemp AS INTEGER)
  ";
  $rsConsulta = db_query($sSQL);
  $oEmpenhos = pg_fetch_all($rsConsulta);
  return $oEmpenhos;
}

function buscaAutCompras($protocolo) {
  $sSQL = "
    SELECT DISTINCT matordem.m51_codordem,
                cgm.z01_nome,
                matordem.m51_valortotal
    FROM matordem
    INNER JOIN protmatordem ON protmatordem.p104_codordem = matordem.m51_codordem
    INNER JOIN protocolos ON protocolos.p101_sequencial = protmatordem.p104_protocolo
    INNER JOIN cgm ON cgm.z01_numcgm = matordem.m51_numcgm
    INNER JOIN db_depart ON db_depart.coddepto = matordem.m51_depto
    INNER JOIN matordemitem ON matordemitem.m52_codordem = matordem.m51_codordem
    INNER JOIN empempenho ON empempenho.e60_numemp = matordemitem.m52_numemp
    LEFT JOIN matordemanu ON matordemanu.m53_codordem = matordem.m51_codordem
    WHERE protocolos.p101_sequencial = {$protocolo}
    ORDER BY m51_codordem
  ";
  $rsConsulta = db_query($sSQL);
  $oAutCompras = pg_fetch_all($rsConsulta);
  return $oAutCompras;
}

function buscaAutPagamentos($protocolo) {
  $sSQL = "
    SELECT pagordem.e50_codord,
       cgm.z01_nome,
       pagordemele.e53_valor
    FROM pagordemele
    INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
    INNER JOIN protpagordem ON protpagordem.p105_codord = pagordem.e50_codord
    INNER JOIN protocolos    ON protocolos.p101_sequencial = protpagordem.p105_protocolo
    INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
    INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
    INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
    AND orcelemento.o56_anousu = empempenho.e60_anousu
    WHERE e60_instit = 1
        AND protocolos.p101_sequencial = {$protocolo}
    ORDER BY e50_codord
  ";
  $rsConsulta = db_query($sSQL);
  $oAutPagamentos = pg_fetch_all($rsConsulta);
  return $oAutPagamentos;
}

function buscaSlips($protocolo) {
  $sSQL = "
    SELECT DISTINCT slip.k17_codigo,
                to_char(k17_data,'DD/MM/YYYY') k17_data,
                k17_valor,
                z01_nome
      FROM slip
      INNER JOIN protslip ON protslip.p106_slip = slip.k17_codigo
      INNER JOIN protocolos ON protocolos.p101_sequencial = protslip.p106_protocolo
      LEFT JOIN conplanoreduz r1 ON r1.c61_reduz = k17_debito
        AND r1.c61_instit = k17_instit
      LEFT JOIN conplano c1 ON c1.c60_codcon = r1.c61_codcon
        AND c1.c60_anousu = r1.c61_anousu
      LEFT JOIN conplanoreduz r2 ON r2.c61_reduz = k17_credito
        AND r2.c61_instit = k17_instit
      LEFT JOIN conplano c2 ON c2.c60_codcon = r2.c61_codcon
        AND c2.c60_anousu = r2.c61_anousu
      LEFT JOIN slipnum ON slipnum.k17_codigo = slip.k17_codigo
      LEFT JOIN cgm ON cgm.z01_numcgm = slipnum.k17_numcgm
      LEFT JOIN slipprocesso ON slip.k17_codigo = slipprocesso.k145_slip
        WHERE protocolos.p101_sequencial = {$protocolo}
          ORDER BY slip.k17_codigo
  ";
  $rsConsulta = db_query($sSQL);
  $oSlips = pg_fetch_all($rsConsulta);
  return $oSlips;
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
//$head1 = "Protocolo: ".$protocolo."/".db_getsession("DB_anousu");
$head1 = "Protocolo: ".$protocolo."/".db_getsession("DB_anousu");
$head2 = "";
$head3 = "";
if($aCabecalho->p101_dt_anulado != '' || $aCabecalho->p101_dt_anulado != NULL) {
  $head2 = "Anulado: SIM";
  $head3 = "Data da anulação: ".$aCabecalho->p101_dt_anulado;
}

$mPDF = new Relatorio('', 'A4');

$mPDF->addInfo($head1, 1);
$mPDF->addInfo($head2, 2);
$mPDF->addInfo($head3, 3);

ob_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Relatório</title>
<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">
<style type="text/css">

.ritz .waffle a { color: inherit; }
.ritz .waffle .s16 {border-left: none;background-color:#ffffff;}
.ritz .waffle .s2 {border-bottom:1px SOLID #000000;background-color:#ffffff;}
.ritz .waffle .s9 {background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s5 {border-right:1px SOLID #000000;background-color:#ffffff;}
.ritz .waffle .s6 {border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s11 {border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#f3f3f3;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s3 {background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s13 {background-color:#ffffff;text-align:center;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s8 {border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s10 {background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s14 {background-color:#ffffff;text-align:right;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s17 {border-bottom:1px DASHED #000000;background-color:#ffffff;}
.ritz .waffle .s1 {border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:middle;white-space:normal;overflow:hidden;word-wrap:break-word;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s12 {border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#f3f3f3;text-align:center;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s0 {border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:middle;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s4 {border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s7 {border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}
.ritz .waffle .s15 {border-right: none;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Arial';font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}

.border-right { border-right: 1px solid #000; }
.border-bottom { border-bottom: 1px solid #000; }
.border-left { border-left: 1px solid #000; }
.border-top { border-top: 1px solid #000; }

</style>
</head>
<body>
<div class="content">

  <div class="ritz grid-container">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th id="0C0" style="width:146px">&nbsp;</th>
          <th id="0C1" style="width:121px">&nbsp;</th>
          <th id="0C2" style="width:100px">&nbsp;</th>
          <th id="0C3" style="width:100px">&nbsp;</th>
          <th id="0C4" style="width:100px">&nbsp;</th>
          <th id="0C5" style="width:100px">&nbsp;</th>
          <th id="0C6" style="width:100px">&nbsp;</th>
          <th id="0C7" style="width:100px">&nbsp;</th>
          <th id="0C8" style="width:100px">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr style='height:20px;'>
          <td class="s3 border-left border-top">Do</td>
          <td class="s3 border-top"></td>
          <td class="s3 border-top"></td>
          <td class="s4 border-top"></td>
          <td class="s5"></td>
          <td class="s3 border-top">Para</td>
          <td class="s3 border-top"></td>
          <td class="s3 border-top"></td>
          <td class="s4 border-top"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s3 border-left">Departamento:</td>
          <td class="s6" colspan="3"><?= $aCabecalho->origem ?></td>
          <td class="s5"></td>
          <td class="s3">Departamento:</td>
          <td class="s6" colspan="3"><?= $aCabecalho->destino ?></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 border-left">Data:</td>
          <td class="s7"><?= $aCabecalho->p101_dt_protocolo ?></td>
          <td class="s7">Hora:</td>
          <td class="s8"><?= $aCabecalho->p101_hora ?></td>
          <td class="s5"></td>
          <td class="s7"></td>
          <td class="s7"></td>
          <td class="s7"></td>
          <td class="s8"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s2" colspan="9">&nbsp;</td>
        </tr>
        <tr style='height:20px;'>
          <td class="border-left s3"><strong>&nbsp;</strong></td>
          <td class="s9">&nbsp;</td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s4"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="border-left s3">&nbsp;<?php //$aCabecalho->p101_sequencial."/".db_getsession("DB_anousu") ?></td>
          <td style="font-size: 9.6pt font-family:'Arial';"  colspan="4">Através deste faço entregue os seguintes processos abaixo relacionados:</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="s4"></td>
        </tr>

        <tr>
          <td class="border-left border-right" colspan="9">&nbsp;</td>
        </tr>

        <tr style='height:20px;'>
          <td class="border-left s10">Autorização:</td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s4"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="border-left s4"></td>
          <td class="s11 softmerge">Num. Autorização</td>
          <td class="s12" colspan="5">Credor</td>
          <td class="s11">Valor (R$)</td>
          <td class="s4"></td>
        </tr>

        <!-- autorizações -->
        <?php if (count($aAutEmpenhos)): ?>

          <?php foreach ($aAutEmpenhos as $aAutEmpenho): ?>
          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s13"><?= $aAutEmpenho['e54_autori'] ?></td>
            <td class="s3" colspan="5"><?= $aAutEmpenho['z01_nome'] ?></td>
            <td class="s14"><?= db_formatar($aAutEmpenho['e55_vltot'], 'f') ?></td>
            <td class="s4"></td>
          </tr>
          <?php endforeach; ?>

        <?php else: ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s3" colspan="7">-</td>
            <td class="s4"></td>
          </tr>

        <?php endif ?>
        <!-- autorizações -->

        <tr>
          <td class="border-left border-right" colspan="9">&nbsp;</td>
        </tr>

        <tr style='height:20px;'>
          <td class="border-left s10">Empenhos:</td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s4"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="border-left s4"></td>
          <td class="s11">Num. Empenho</td>
          <td class="s12" colspan="5">Credor</td>
          <td class="s11">Valor (R$)</td>
          <td class="s4"></td>
        </tr>

        <!-- empenhos -->
        <?php if (count($aEmpenhos)): ?>

          <?php foreach ($aEmpenhos as $aEmpenho): ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s13"><?= $aEmpenho['e60_codemp'] ?></td>
            <td class="s3" colspan="5"><?= $aEmpenho['z01_nome'] ?></td>
            <td class="s14"><?= db_formatar($aEmpenho['e60_vlremp'], 'f') ?></td>
            <td class="s4"></td>
          </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s3" colspan="7">-</td>
            <td class="s4"></td>
          </tr>

        <?php endif ?>
        <!-- empenhos -->

        <tr>
          <td class="border-left border-right" colspan="9">&nbsp;</td>
        </tr>

        <tr style='height:20px;'>
          <td class="border-left s10">Ordem de Compra:</td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s4"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="border-left s4"></td>
          <td class="s11">Num. OC</td>
          <td class="s12" colspan="5">Credor</td>
          <td class="s11">Valor (R$)</td>
          <td class="s4"></td>
        </tr>

        <!-- ordem de compra -->
        <?php if (count($aAutCompras)): ?>

          <?php foreach ($aAutCompras as $aAutCompra): ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s13"><?= $aAutCompra['m51_codordem'] ?></td>
            <td class="s3" colspan="5"><?= $aAutCompra['z01_nome'] ?></td>
            <td class="s14"><?= db_formatar($aAutCompra['m51_valortotal'], 'f') ?></td>
            <td class="s4"></td>
          </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s3" colspan="7">-</td>
            <td class="s4"></td>
          </tr>

        <?php endif ?>
        <!-- ordem de compra -->

        <tr>
          <td class="border-left border-right" colspan="9">&nbsp;</td>
        </tr>

        <tr style='height:20px;'>
          <td class="border-left s15 softmerge">Ordem de Pagamento:</td>
          <td class="s16 border-bottom"></td>
          <td class="s16 border-bottom"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s4"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="border-left s4"></td>
          <td class="s11">Num. OP</td>
          <td class="s12" colspan="5">Credor</td>
          <td class="s11">Valor (R$)</td>
          <td class="s4"></td>
        </tr>

        <!-- ordem de pagamento -->
        <?php if (count($aAutPagamentos)): ?>

          <?php foreach ($aAutPagamentos as $aAutPagamento): ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s13"><?= $aAutPagamento['e50_codord'] ?></td>
            <td class="s3" colspan="5"><?= $aAutPagamento['z01_nome'] ?></td>
            <td class="s14"><?= db_formatar($aAutPagamento['e53_valor'], 'f') ?></td>
            <td class="s4"></td>
          </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s3" colspan="7">-</td>
            <td class="s4"></td>
          </tr>

        <?php endif ?>
        <!-- ordem de pagamento -->

        <tr style='height:20px;'>
          <td class="border-left s15 softmerge">Slip:</td>
          <td class="s16 border-bottom"></td>
          <td class="s16 border-bottom"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s2"></td>
          <td class="s4"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="border-left s4"></td>
          <td class="s11">Num. Slip</td>
          <td class="s12" colspan="5">Credor</td>
          <td class="s11">Valor (R$)</td>
          <td class="s4"></td>
        </tr>

        <!-- Slip -->
        <?php if (count($aSlips)): ?>

          <?php foreach ($aSlips as $aSlip): ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s13"><?= $aSlip['k17_codigo'] ?></td>
            <td class="s3" colspan="5"><?= $aSlip['z01_nome'] ?></td>
            <td class="s14"><?= db_formatar($aSlip['k17_valor'], 'f') ?></td>
            <td class="s4"></td>
          </tr>

          <?php endforeach; ?>

        <?php else: ?>

          <tr style='height:20px;'>
            <td class="border-left s3"></td>
            <td class="s3" colspan="7">-</td>
            <td class="s4"></td>
          </tr>

        <?php endif ?>
        <!-- Slip -->

        <tr style='height:20px;'>
          <td colspan="1" class="border-left s3"><strong>Observação:</strong>&nbsp;</td>
          <td class="s9">&nbsp;</td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s3"></td>
          <td class="s4"></td>
        </tr>
        <tr style='height:20px;'>
          <td style="text-indent: justify;" class="border-left s3" colspan="4"><?= $aCabecalho->p101_observacao ?></td>
          <td class="s3" colspan="1">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="s4" ></td>
        </tr>

        <tr>
          <td class="border-left border-right" colspan="9">&nbsp;</td>
        </tr>

        <tr>
          <td class="border-left border-right border-bottom" colspan="9">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="9">&nbsp;</td>
        </tr>

        <tr style='height:20px;'>
          <td class="s17" colspan="4"></td>
          <td>&nbsp;</td>
          <td class="s17" colspan="4"></td>
        </tr>

        <tr style='height:1px;'>
          <td class="s13" colspan="4">
            <?= $aCabecalho->nome ?>
            <br>Enviado em: <code>___/___/______</code>
          </td>
          <td>&nbsp;</td>
          <td class="s13" colspan="4">
            Responsável pelo Recebimento
            <br>Recebido em: <code>___/___/______</code>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

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

