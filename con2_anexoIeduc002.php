<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("vendor/mpdf/mpdf/mpdf.php");
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
require_once("classes/db_empresto_classe.php");
$clselorcdotacao = new cl_selorcdotacao();
$clempresto = new cl_empresto;


db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",", $instits);
if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}
db_inicio_transacao();

$sWhereReceita      = "o70_instit in ({$instits})";
$sWhereReceita = " o70_instit in({$instits}) ";

$oReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anousu, $dtini, $dtfim, false, ' * ', true, 0);
$aReceitas = db_utils::getColectionByRecord($oReceitas);

$fIPTR  = 0;
$fIPTU  = 0;
$fIRRF  = 0;
$fIRRFO = 0;
$fITBI  = 0;
$fISS = 0;
$fFPM = 0;
$fFPM1DEZ = 0;
$fFPM1JUL = 0;
$fITR = 0;
$fICMS  = 0;
$fPARTICMS  = 0;
$fIPVA  = 0;
$fIPI = 0;
$fMJITR = 0;
$fMJIPTU  = 0;
$fMJTIBI  = 0;
$fMJISS = 0;
$fMJDA  = 0;
$fMJDAIPTU  = 0;
$fMJDAITBI  = 0;
$fMJDAISS = 0;
$fMJDAITR = 0;
$fRJDAIPTU  = 0;
$fRJDAITBI  = 0;
$fRJDAISS = 0;

foreach ($aReceitas as $Receitas) {

    if (strstr($Receitas->o57_fonte, '411120111000000')) $fIPTR += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180111000000')) $fIPTU += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411130311000000')) $fIRRF += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411130341000000')) $fIRRFO += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180141000000')) $fITBI += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180231000000')) $fISS += $Receitas->saldo_arrecadado;

    if (strstr($Receitas->o57_fonte, '417180121000000')) $fFPM += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '417180131000000')) $fFPM1DEZ += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '417180141000000')) $fFPM1JUL += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '417180151000000')) $fITR += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '417180611000000')) $fICMS += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '417280111000000')) $fPARTICMS += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '417280121000000')) $fIPVA += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '417280131000000')) $fIPI += $Receitas->saldo_arrecadado;

    if (strstr($Receitas->o57_fonte, '411120112000000')) $fMJITR += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180112000000')) $fMJIPTU += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180142000000')) $fMJTIBI += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180232000000')) $fMJISS += $Receitas->saldo_arrecadado;

    if (strstr($Receitas->o57_fonte, '411180114000000')) $fMJDAIPTU += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180144000000')) $fMJDAITBI += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180234000000')) $fMJDAISS += $Receitas->saldo_arrecadado;

    if (strstr($Receitas->o57_fonte, '411180113000000')) $fRJDAIPTU += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180143000000')) $fRJDAITBI += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '411180233000000')) $fRJDAISS += $Receitas->saldo_arrecadado;
}
db_query("drop table if exists work_receita");
criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);
/**
 * mPDF
 * @param string $mode              | padrão: BLANK
 * @param mixed $format             | padrão: A4
 * @param float $default_font_size  | padrão: 0
 * @param string $default_font      | padrão: ''
 * @param float $margin_left        | padrão: 15
 * @param float $margin_right       | padrão: 15
 * @param float $margin_top         | padrão: 16
 * @param float $margin_bottom      | padrão: 16
 * @param float $margin_header      | padrão: 9
 * @param float $margin_footer      | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */

/*OC7063*/
//echo '<pre>';ini_set("display_errors",true);
$where = " c61_instit in ({$instits})";
$where .= " and (c61_codigo = '101' or c61_codigo = '1101') ";

$result = db_planocontassaldo_matriz(db_getsession("DB_anousu"), ($DBtxt21_ano . '-' . $DBtxt21_mes . '-' . $DBtxt21_dia), $dtfim, false, $where);

$total_anterior    = 0;
$total_debitos  = 0;
$total_creditos = 0;
$total_final    = 0;
$iAjustePcasp   = 0;

if (USE_PCASP) {
    $iAjustePcasp = 8;
}

for ($x = 0; $x < pg_numrows($result); $x++) {
    db_fieldsmemory($result, $x);

    if (($tipo == "S") && ($c61_reduz != 0)) {
        continue;
    }

    if (USE_PCASP) {
    } else {
        if (substr($estrutural, 0, 1) == '3') {
            if (substr($estrutural, 2) + 0 > 0)
                continue;
        }
        if (substr($estrutural, 0, 1) == '4') {
            if (substr($estrutural, 2) + 0 > 0)
                continue;
        }
    }

    if (($movimento == "S") && (($saldo_anterior + $saldo_anterior_debito + $saldo_anterior_credito) == 0)) {
        continue;
    }

    if (substr($estrutural, 1, 14) == '00000000000000') {

        if ($sinal_anterior == "C")
            $total_anterior -= $saldo_anterior;
        else
            $total_anterior += $saldo_anterior;

        if ($sinal_final == "C")
            $total_final -= $saldo_final;
        else
            $total_final += $saldo_final;

        $total_debitos  += $saldo_anterior_debito;
        $total_creditos += $saldo_anterior_credito;
    }
}
$total_final = $total_anterior + $total_debitos - $total_creditos;

$sInst = '';
foreach ($aInstits as $inst) {
    $sInst .= 'instit_' . $inst . '-';
}
$filtra_despesa = $sInst . "recurso_101-recurso_1101";
$clselorcdotacao->setDados($filtra_despesa);
$sql_filtro = $clselorcdotacao->getDados(false);

function retorna_desdob($elemento, $e64_codele, $clorcelemento)
{
    return pg_query($clorcelemento->sql_query_file(null, null, "o56_elemento as estrutural,o56_descr as descr", null, "o56_codele = $e64_codele and o56_elemento like '$elemento%'"));
}


$resultinst = pg_exec("select codigo,nomeinstabrev from db_config where codigo in (" . $instits . ") ");


$sele_work = ' e60_instit in (' . $instits . ') ';
$sele_work1 = ''; //tipo de recurso
$anoatual = db_getsession("DB_anousu");
$tipofiltro = "Órgão";
$commovfiltro = "Todos";

$sOpImpressao = 'Sintético';

$sql_order = " order by o58_orgao,e60_anousu,e60_codemp::integer";
$sql_where_externo .= "  ";
$sql_where_externo .= ' and e60_anousu < ' . db_getsession("DB_anousu");
$sql_where_externo .= " and " . $sql_filtro;

$sqlempresto = $clempresto->sql_rp_novo(db_getsession("DB_anousu"), $sele_work, $dtini, $dtfim, $sele_work1, $sql_where_externo, "$sql_order ");
$res = $clempresto->sql_record($sqlempresto);

if ($clempresto->numrows == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Sem movimentação de restos a pagar.");
    exit;
}

$rows = $clempresto->numrows;

$total_rp_proc = 0;
$total_rp_nproc = 0;
$total_mov_pagmento = 0;

for ($x = 0; $x < $rows; $x++) {
    db_fieldsmemory($res, $x);
    $total_rp_proc += ($e91_vlrliq - $e91_vlrpag);
    $total_rp_nproc += round($vlrpagnproc, 2);
    $total_mov_pagmento += ($vlrpag + $vlrpagnproc);
}

if (($total_rp_proc + $total_rp_nproc) < $total_anterior || $total_mov_pagmento < $total_anterior) {
    $iRestosAPagar = db_formatar(0, "f");
} else {
    $iRestosAPagar = $total_mov_pagmento - $total_anterior;
}
/*FIM - OC7063*/

$mPDF = new mpdf('', '', 0, '', 15, 15, 20, 15, 5, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>ANEXO I</th>
    </tr>
    <tr>
      <td style="text-align:right;font-size:10px;font-style:oblique;">Período: De {$DBtxt21} a {$DBtxt22}</td>
    </tr>
  </table>
</header>
HEADER;

$footer = <<<FOOTER
<div style='border-top:1px solid #000;width:100%;text-align:right;font-family:sans-serif;font-size:10px;height:10px;'>
  {PAGENO}
</div>
FOOTER;


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

?>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        .ritz .waffle a {
            color: inherit;
        }

        .ritz .waffle .s0 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 14pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s1 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 12pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s2 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-style: italic;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s3 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s4 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s5 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s6 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s7 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s8 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s9 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s10 {
            background-color: #d8d8d8;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s11 {
            background-color: #d8d8d8;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s12 {
            background-color: #d8d8d8;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s13 {
            background-color: #d8d8d8;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s14 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s15 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #ff0000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s16 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s17 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s18 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s19 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #ff0000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s20 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s21 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s22 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }
    </style>

</head>

<body>

    <div class="ritz grid-container" dir="ltr">
        <table class="waffle" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th id="0C0" style="width:40px" class="column-headers-background">&nbsp;</th>
                    <th id="0C1" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C2" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C3" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C4" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C5" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C6" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C7" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C8" style="width:100px" class="column-headers-background">&nbsp;</th>
                    <th id="0C9" style="width:100px" class="column-headers-background">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php if (db_getsession('DB_anousu') < 2018) : ?>
                    <tr style='height:20px;'>
                        <td class="s3 bdleft bdtop" colspan="10">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s4 bdleft" colspan="10">DEMONSTRATIVO DA APLICAÇÃO NA MANUTENÇÃO E DESENVOLVIMENTO DO ENSINO</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s4 bdleft" colspan="10">(ART. 212 DA CF, LEIS FEDERAIS Ns. 9.394/96 e 11.494/07, EC 53/06)</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s5 bdleft" colspan="10">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">01 - Receitas </td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">A - Impostos:</td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11120101</td>
                        <td class="s6" colspan="7">Imposto s/a Propriedade Territorial Rural - Munic.Conv.</td>
                        <td class="s9">
                            <?php
                            $aDadosIPTR = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '411120101%'");
                            $fIPTR = count($aDadosIPTR) > 0 ? $aDadosIPTR[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fIPTR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11120200</td>
                        <td class="s12" colspan="7">Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU</td>
                        <td class="s13">
                            <?php
                            $aDadosIPTU = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4111202%'");
                            $fIPTU = count($aDadosIPTU) > 0 ? $aDadosIPTU[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11120431</td>
                        <td class="s6" colspan="7">Imposto de Renda Retido nas Fontes - IRRF (Trab.Assalariado)</td>
                        <td class="s9">
                            <?php
                            $aDadosIRRF = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '411120431%'");
                            $fIRRF = count($aDadosIRRF) > 0 ? $aDadosIRRF[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fIRRF, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11120434</td>
                        <td class="s12" colspan="7">Imposto de Renda Retido nas Fontes - IRRF (Outros Rendimentos)</td>
                        <td class="s13">
                            <?php
                            $aDadosIRRFO = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '411120434%'");
                            $fIRRFO = count($aDadosIRRFO) > 0 ? $aDadosIRRFO[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fIRRFO, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11120800</td>
                        <td class="s6" colspan="7">Imposto sobre Transmissão Inter-Vivos de Bens Imóveis - ITBI</td>
                        <td class="s9">
                            <?php
                            $aDadosITBI = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4111208%'");
                            $fITBI = count($aDadosITBI) > 0 ? $aDadosITBI[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fITBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11130500</td>
                        <td class="s12" colspan="7">Imposto sobre Serviço de Qualquer Natureza - ISS</td>
                        <td class="s13">
                            <?php
                            $aDadosISS = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4111305%'");
                            $fISS = count($aDadosISS) > 0 ? $aDadosISS[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fISS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"><?php $fSubTotalImposto = array_sum(array($fIPTR, $fIPTU, $fIRRF, $fIRRFO, $fITBI, $fISS));
                                        echo db_formatar($fSubTotalImposto, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">&nbsp;</td>
                        <td class="s3">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">B - Transferências Correntes:</td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17210102</td>
                        <td class="s6" colspan="7">Cota-parte do FPM </td>
                        <td class="s9">
                            <?php
                            $aDadosFPM = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417210102%'");
                            $fFPM = count($aDadosFPM) > 0 ? $aDadosFPM[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fFPM, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17210103</td>
                        <td class="s12" colspan="7">Cota-parte do FPM - 1% de Dezembro</td>
                        <td class="s13">
                            <?php
                            $aDadosFPM1DEZ = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417210103%'");
                            $fFPM1DEZ = count($aDadosFPM1DEZ) > 0 ? $aDadosFPM1DEZ[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fFPM1DEZ, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17210104</td>
                        <td class="s6" colspan="7">Cota-parte do FPM - 1% de Julho</td>
                        <td class="s9">
                            <?php
                            $aDadosFPM1JUL = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417210104%'");
                            $fFPM1JUL = count($aDadosFPM1JUL) > 0 ? $aDadosFPM1JUL[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fFPM1JUL, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17210105</td>
                        <td class="s12" colspan="7">Transferência do ITR</td>
                        <td class="s13">
                            <?php
                            $aDadosITR = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417210105%'");
                            $fITR = count($aDadosITR) > 0 ? $aDadosITR[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fITR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17213600</td>
                        <td class="s6" colspan="7">Transferência Financ.? Lei Comp.n. 87/96 - ICMS Exp.</td>
                        <td class="s9">
                            <?php
                            $aDadosICMS = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4172136%'");
                            $fICMS = count($aDadosICMS) > 0 ? $aDadosICMS[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fICMS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17220101</td>
                        <td class="s12" colspan="7">Participação no ICMS</td>
                        <td class="s13">
                            <?php
                            $aDadosPARTICMS = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417220101%'");
                            $fPARTICMS = count($aDadosPARTICMS) > 0 ? $aDadosPARTICMS[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fPARTICMS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17220102</td>
                        <td class="s6" colspan="7">Imposto sobre IPVA</td>
                        <td class="s9">
                            <?php
                            $aDadosIPVA = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417220102%'");
                            $fIPVA = count($aDadosIPVA) > 0 ? $aDadosIPVA[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fIPVA, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17220104</td>
                        <td class="s12" colspan="7">Cota-parte do Imposto sobre Produtos Industrializados - IPI</td>
                        <td class="s13">
                            <?php
                            $aDadosIPI = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417220104%'");
                            $fIPI = count($aDadosIPI) > 0 ? $aDadosIPI[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fIPI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"><?php $fSubTotalCorrentes = array_sum(array($fFPM, $fFPM1DEZ, $fFPM1JUL, $fITR, $fICMS, $fPARTICMS, $fIPVA, $fIPI));
                                        echo db_formatar($fSubTotalCorrentes, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">&nbsp;</td>
                        <td class="s3">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">C - Outras Receitas Correntes</td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">19110801</td>
                        <td class="s6" colspan="7">Multas e Juros de Mora do ITR-Munic.Conv.</td>
                        <td class="s9">
                            <?php
                            $aDadosMJITR = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '419110801%'");
                            $fMJITR = count($aDadosMJITR) > 0 ? $aDadosMJITR[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJITR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">19113800</td>
                        <td class="s12" colspan="7">Multas e Juros de Mora do IPTU </td>
                        <td class="s13">
                            <?php
                            $aDadosMJIPTU = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4191138%'");
                            $fMJIPTU = count($aDadosMJIPTU) > 0 ? $aDadosMJIPTU[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">19113900</td>
                        <td class="s6" colspan="7">Multas e Juros de Mora do ITBI</td>
                        <td class="s9">
                            <?php
                            $aDadosMJITBI = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4191139%'");
                            $fMJTIBI = count($aDadosMJITBI) > 0 ? $aDadosMJITBI[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJTIBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">19114000</td>
                        <td class="s12" colspan="7"> Multas e Juros de Mora do ISS </td>
                        <td class="s13">
                            <?php
                            $aDadosMJISS = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4191140%'");
                            $fMJISS = count($aDadosMJISS) > 0 ? $aDadosMJISS[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJISS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">19130800</td>
                        <td class="s6" colspan="7">Multas e Juros de Mora da Dívida Ativa do ITR-Munic.Conv.</td>
                        <td class="s9">
                            <?php
                            $aDadosMJDA = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4191308%'");
                            $fMJDA = count($aDadosMJDA) > 0 ? $aDadosMJDA[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJDA, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">19131100</td>
                        <td class="s12" colspan="7">Multas e Juros de Mora da Dívida Ativa do IPTU </td>
                        <td class="s13">
                            <?php
                            $aDadosMJDAIPTU = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4191311%'");
                            $fMJDAIPTU = count($aDadosMJDAIPTU) > 0 ? $aDadosMJDAIPTU[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJDAIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">19131200</td>
                        <td class="s6" colspan="7">Multas e Juros de Mora da Dívida Ativa do ITBI </td>
                        <td class="s9">
                            <?php
                            $aDadosMJDAITBI = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4191312%'");
                            $fMJDAITBI = count($aDadosMJDAITBI) > 0 ? $aDadosMJDAITBI[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJDAITBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">19131300</td>
                        <td class="s12" colspan="7">Multas e Juros de Mora da Dívida Ativa do ISS </td>
                        <td class="s13">
                            <?php
                            $aDadosMJDAISS = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4191313%'");
                            $fMJDAISS = count($aDadosMJDAISS) > 0 ? $aDadosMJDAISS[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fMJDAISS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">19310400</td>
                        <td class="s6" colspan="7">Receita da Dívida Ativa do ITR - Munic.Conveniado</td>
                        <td class="s9">
                            <?php
                            $aDadosRDAITR = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4193104%'");
                            $fRJDAITR = count($aDadosRDAITR) > 0 ? $aDadosRDAITR[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fRJDAITR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">19311100</td>
                        <td class="s12" colspan="7">Receita da Dívida Ativa do IPTU </td>
                        <td class="s13">
                            <?php
                            $aDadosRDAIPTU = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4193111%'");
                            $fRJDAIPTU = count($aDadosRDAIPTU) > 0 ? $aDadosRDAIPTU[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fRJDAIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">19311200</td>
                        <td class="s6" colspan="7">Receita da Dívida Ativa do ITBI </td>
                        <td class="s9">
                            <?php
                            $aDadosRDAITBI = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4193112%'");
                            $fRJDAITBI = count($aDadosRDAITBI) > 0 ? $aDadosRDAITBI[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fRJDAITBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">19311300</td>
                        <td class="s12" colspan="7">Receita da Dívida Ativa do ISS </td>
                        <td class="s13">
                            <?php
                            $aDadosRDAISS = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4193113%'");
                            $fRJDAISS = count($aDadosRDAISS) > 0 ? $aDadosRDAISS[0]->saldo_arrecadado_acumulado : 0;
                            echo db_formatar($fRJDAISS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"> <?php
                                        $fSubTotalOutrasCorrentes = array_sum(array($fMJITR, $fMJIPTU, $fMJTIBI, $fMJISS, $fMJDA, $fMJDAIPTU, $fMJDAITBI, $fMJDAISS, $fRJDAITR, $fRJDAIPTU, $fRJDAITBI, $fRJDAISS));
                                        echo db_formatar($fSubTotalOutrasCorrentes, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s3 bdleft" colspan="9">&nbsp;</td>
                        <td class="s3">
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">D - Deduções das Receitas (exceto FUNDEB)</td>
                        <td class="s3"></td>
                    </tr>
                    <?php
                    $fTotalDeducoes = 0;
                    $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '498%'");
                    foreach ($aDadoDeducao as $oDeducao) {
                    ?>
                        <tr style='height:20px;'>
                            <td class="s7 bdleft"></td>
                            <td class="s14"><?php echo db_formatar($oDeducao->o57_fonte, "receita"); ?></td>
                            <td class="s6" colspan="7"><?= $oDeducao->o57_descr; ?></td>
                            <td class="s15">
                                <?php
                                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                                echo db_formatar($oDeducao->saldo_arrecadado, "f");
                                ?>
                            </td>
                        </tr>
                    <?php }
                    $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '499%'");
                    foreach ($aDadoDeducao as $oDeducao) {
                    ?>
                        <tr style='height:20px;'>
                            <td class="s7 bdleft"></td>
                            <td class="s14"><?php echo db_formatar($oDeducao->o57_fonte, "receita"); ?></td>
                            <td class="s6" colspan="7"><?= $oDeducao->o57_descr; ?></td>
                            <td class="s15">
                                <?php
                                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                                echo db_formatar($oDeducao->saldo_arrecadado, "f");
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"><?= db_formatar($fTotalDeducoes, "f") ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft bdbottom" colspan="9">&nbsp;</td>
                        <td class="s3 bdbottom">&nbsp;</td>
                    </tr>

                    <tr style='height:20px;'>
                        <td class="s20 bdleft" colspan="9">02 - Total das Receitas (A+B+C-D)</td>
                        <td class="s21"><?php $fTotalReceitas = ($fSubTotalImposto + $fSubTotalCorrentes + $fSubTotalOutrasCorrentes) - $fTotalDeducoes;
                                        echo db_formatar($fTotalReceitas, "f"); ?> </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s20 bdleft" colspan="9">03 - Valor Legal Mínimo (art. 212 da CF) 25 % =</td>
                        <td class="s21"><?php echo db_formatar($fTotalReceitas * 0.25, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <?php
                        db_query("drop table if exists work_receita");
                        db_fim_transacao();
                        $fTotalAnexoII = getTotalAnexoIIEducacao($instits, $dtini, $dtfim, $anousu);
                        ?>
                        <td class="s20 bdleft" colspan="9">04 - Aplicação no Exercício</td>
                        <td class="s21"><?php echo db_formatar($fTotalAnexoII, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <?php
                        db_query("drop table if exists work_receita");
                        db_fim_transacao();
                        $fTotalAnexoII = getTotalAnexoIIEducacao($instits, $dtini, $dtfim, $anousu);
                        ?>
                        <td class="s20 bdleft" colspan="9">05 - Restos a pagar pagos inscritos sem disponibilidade - (Consulta 932.736/2015)</td>
                        <td class="s21"><?php echo db_formatar($iRestosAPagar, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <?php
                        db_query("drop table if exists work_receita");
                        db_fim_transacao();
                        $fTotalAnexoII = getTotalAnexoIIEducacao($instits, $dtini, $dtfim, $anousu);
                        ?>
                        <td class="s20 bdleft" dir="ltr" colspan="9">06 - Aplicação na Manut. e Desenv. Ensino (Anexo II) % = <?php echo db_formatar((($fTotalAnexoII + $iRestosAPagar) * 100) / $fTotalReceitas, "f"); //echo db_formatar((($fTotalAnexoII/($fTotalReceitas*0.25))*0.25)*100,"f");
                                                                                                                                ?></td>
                        <td class="s21"><?= db_formatar(($fTotalAnexoII + $iRestosAPagar), "f") ?></td>
                    </tr>
                <?php else : ?>
                    <tr style='height:20px;'>
                        <td class="s3 bdleft bdtop" colspan="10">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s4 bdleft" colspan="10">DEMONSTRATIVO DA APLICAÇÃO NA MANUTENÇÃO E DESENVOLVIMENTO DO ENSINO</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s4 bdleft" colspan="10">(ART. 212 DA CF, LEIS FEDERAIS Ns. 9.394/96 e 11.494/07, EC 53/06)</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s5 bdleft" colspan="10">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">01 - Receitas </td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">A - Impostos:</td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11120111</td>
                        <td class="s6" colspan="7">Imposto s/a Propriedade Territorial Rural - Munic.Conv.</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fIPTR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180111</td>
                        <td class="s12" colspan="7">Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU</td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11130311</td>
                        <td class="s6" colspan="7">Imposto de Renda Retido nas Fontes - IRRF (Trab.Assalariado)</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fIRRF, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11130341</td>
                        <td class="s12" colspan="7">Imposto de Renda Retido nas Fontes - IRRF (Outros Rendimentos)</td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fIRRFO, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11180141</td>
                        <td class="s6" colspan="7">Imposto sobre Transmissão Inter-Vivos de Bens Imóveis - ITBI</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fITBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180231</td>
                        <td class="s12" colspan="7">Imposto sobre Serviço de Qualquer Natureza - ISS</td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fISS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"><?php $fSubTotalImposto = array_sum(array($fIPTR, $fIPTU, $fIRRF, $fIRRFO, $fITBI, $fISS));
                                        echo db_formatar($fSubTotalImposto, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s3 bdleft" colspan="9">&nbsp;</td>
                        <td class="s3">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">B - Transferências Correntes:</td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17180121</td>
                        <td class="s6" colspan="7">Cota-parte do FPM </td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fFPM, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17180131</td>
                        <td class="s12" colspan="7">Cota-parte do FPM - 1% de Dezembro</td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fFPM1DEZ, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17180141</td>
                        <td class="s6" colspan="7">Cota-parte do FPM - 1% de Julho</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fFPM1JUL, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17180151</td>
                        <td class="s12" colspan="7">Transferência do ITR</td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fITR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17180611</td>
                        <td class="s6" colspan="7">Transferência Financ.? Lei Comp.n. 87/96 - ICMS Exp.</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fICMS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17280111</td>
                        <td class="s12" colspan="7">Participação no ICMS</td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fPARTICMS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">17280121</td>
                        <td class="s6" colspan="7">Imposto sobre IPVA</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fIPVA, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">17280131</td>
                        <td class="s12" colspan="7">Cota-parte do Imposto sobre Produtos Industrializados - IPI</td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fIPI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"><?php $fSubTotalCorrentes = array_sum(array($fFPM, $fFPM1DEZ, $fFPM1JUL, $fITR, $fICMS, $fPARTICMS, $fIPVA, $fIPI));
                                        echo db_formatar($fSubTotalCorrentes, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s3 bdleft" colspan="9">&nbsp;</td>
                        <td class="s3">&nbsp;</td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">C - Outras Receitas Correntes</td>
                        <td class="s3"></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11120112</td>
                        <td class="s6" colspan="7">Multas e Juros de Mora do ITR-Munic.Conv.</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fMJITR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180112</td>
                        <td class="s12" colspan="7">Multas e Juros de Mora do IPTU </td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fMJIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11180142</td>
                        <td class="s6" colspan="7">Multas e Juros de Mora do ITBI</td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fMJTIBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180232</td>
                        <td class="s12" colspan="7"> Multas e Juros de Mora do ISS </td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fMJISS, "f");
                            ?>
                        </td>
                    </tr>
                    <!--               <tr style='height:20px;'>
                <td class="s7 bdleft"></td>
                <td class="s8">19130800</td>
                <td class="s6" colspan="7">Multas e Juros de Mora da Dívida Ativa do ITR-Munic.Conv.</td>
                <td class="s9">
                  <?php
                    echo db_formatar($fMJDA, "f");
                    ?>
                </td>
              </tr> -->
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180114</td>
                        <td class="s12" colspan="7">Multas e Juros de Mora da Dívida Ativa do IPTU </td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fMJDAIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11180144</td>
                        <td class="s6" colspan="7">Multas e Juros de Mora da Dívida Ativa do ITBI </td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fMJDAITBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180234</td>
                        <td class="s12" colspan="7">Multas e Juros de Mora da Dívida Ativa do ISS </td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fMJDAISS, "f");
                            ?>
                        </td>
                    </tr>
                    <!--   <tr style='height:20px;'>
                <td class="s7 bdleft"></td>
                <td class="s8">19310400</td>
                <td class="s6" colspan="7">Receita da Dívida Ativa do ITR - Munic.Conveniado</td>
                <td class="s9">
                  <?php
                    echo db_formatar($fMJDAITR, "f");
                    ?>
                </td>
              </tr> -->
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180113</td>
                        <td class="s12" colspan="7">Receita da Dívida Ativa do IPTU </td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fRJDAIPTU, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s7 bdleft"></td>
                        <td class="s8">11180143</td>
                        <td class="s6" colspan="7">Receita da Dívida Ativa do ITBI </td>
                        <td class="s9">
                            <?php
                            echo db_formatar($fRJDAITBI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s10 bdleft"></td>
                        <td class="s11">11180233</td>
                        <td class="s12" colspan="7">Receita da Dívida Ativa do ISS </td>
                        <td class="s13">
                            <?php
                            echo db_formatar($fRJDAISS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"><?php
                                        $fSubTotalOutrasCorrentes = array_sum(array($fMJITR, $fMJIPTU, $fMJTIBI, $fMJISS, $fMJDA, $fMJDAIPTU, $fMJDAITBI, $fMJDAISS, $fMJDAITR, $fRJDAIPTU, $fRJDAITBI, $fRJDAISS));
                                        echo db_formatar($fSubTotalOutrasCorrentes, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s3 bdleft" colspan="9">&nbsp;</td>
                        <td class="s3">

                        </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">D - Deduções das Receitas (exceto FUNDEB)</td>
                        <td class="s3"></td>
                    </tr>
                    <?php
                    $fTotalDeducoes = 0;
                    $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '491%'");
                    foreach ($aDadoDeducao as $oDeducao) {
                    ?>
                        <tr style='height:20px;'>
                            <td class="s7 bdleft"></td>
                            <td class="s14"><?php echo db_formatar($oDeducao->o57_fonte, "receita"); ?></td>
                            <td class="s6" colspan="7"><?= $oDeducao->o57_descr; ?></td>
                            <td class="s15">
                                <?php
                                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                                echo db_formatar($oDeducao->saldo_arrecadado, "f");
                                ?>
                            </td>
                        </tr>
                    <?php }
                    $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '492%'");
                    foreach ($aDadoDeducao as $oDeducao) {
                    ?>
                        <tr style='height:20px;'>
                            <td class="s7 bdleft"></td>
                            <td class="s14"><?php echo db_formatar($oDeducao->o57_fonte, "receita"); ?></td>
                            <td class="s6" colspan="7"><?= $oDeducao->o57_descr; ?></td>
                            <td class="s15">
                                <?php
                                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                                echo db_formatar($oDeducao->saldo_arrecadado, "f");
                                ?>
                            </td>
                        </tr>
                    <?php }
                    $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '493%'");
                    foreach ($aDadoDeducao as $oDeducao) {
                    ?>
                        <tr style='height:20px;'>
                            <td class="s7 bdleft"></td>
                            <td class="s14"><?php echo db_formatar($oDeducao->o57_fonte, "receita"); ?></td>
                            <td class="s6" colspan="7"><?= $oDeducao->o57_descr; ?></td>
                            <td class="s15">
                                <?php
                                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                                echo db_formatar($oDeducao->saldo_arrecadado, "f");
                                ?>
                            </td>
                        </tr>
                    <?php }
                    $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '498%'");
                    foreach ($aDadoDeducao as $oDeducao) {
                    ?>
                        <tr style='height:20px;'>
                            <td class="s7 bdleft"></td>
                            <td class="s14"><?php echo db_formatar($oDeducao->o57_fonte, "receita"); ?></td>
                            <td class="s6" colspan="7"><?= $oDeducao->o57_descr; ?></td>
                            <td class="s15">
                                <?php
                                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                                echo db_formatar($oDeducao->saldo_arrecadado, "f");
                                ?>
                            </td>
                        </tr>
                    <?php }
                    $aDadoDeducao = getSaldoReceita(null, "o57_fonte,o57_descr,saldo_arrecadado", null, "o57_fonte like '499%'");
                    foreach ($aDadoDeducao as $oDeducao) {
                    ?>
                        <tr style='height:20px;'>
                            <td class="s7 bdleft"></td>
                            <td class="s14"><?php echo db_formatar($oDeducao->o57_fonte, "receita"); ?></td>
                            <td class="s6" colspan="7"><?= $oDeducao->o57_descr; ?></td>
                            <td class="s15">
                                <?php
                                $fTotalDeducoes += $oDeducao->saldo_arrecadado;
                                echo db_formatar($oDeducao->saldo_arrecadado, "f");
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft" colspan="9">Subtotal</td>
                        <td class="s3"><?= db_formatar($fTotalDeducoes, "f") ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s6 bdleft bdbottom" colspan="9">&nbsp;</td>
                        <td class="s3 bdbottom">&nbsp;</td>
                    </tr>

                    <tr style='height:20px;'>
                        <td class="s20 bdleft" colspan="9">02 - Total das Receitas (A+B+C-D)</td>
                        <td class="s21"><?php $fTotalReceitas = ($fSubTotalImposto + $fSubTotalCorrentes + $fSubTotalOutrasCorrentes) - $fTotalDeducoes;
                                        echo db_formatar($fTotalReceitas, "f"); ?> </td>
                    </tr>
                    <tr style='height:20px;'>
                        <td class="s20 bdleft" colspan="9">03 - Valor Legal Mínimo (art. 212 da CF) 25 % =</td>
                        <td class="s21"><?php echo db_formatar($fTotalReceitas * 0.25, "f"); ?></td>
                    </tr>
                    <tr style='height:20px;'>
                        <?php
                        db_query("drop table if exists work_receita");
                        db_fim_transacao();
                        $fTotalAnexoII = getTotalAnexoIIEducacao($instits, $dtini, $dtfim, $anousu);
                        ?>
                        <td class="s20 bdleft" colspan="9">04 - Aplicação no Exercício</td>
                        <td class="s21"><?php echo db_formatar($fTotalAnexoII, "f"); ?></td>
                    </tr>
                    <?php if(db_getsession("DB_anousu") > 2020) { ?>
                    <tr style='height:20px;'>
                        <?php
                        db_query("drop table if exists work_receita");
                        db_fim_transacao();
                        $fTotalAnexoII = getTotalAnexoIIEducacao($instits, $dtini, $dtfim, $anousu);
                        ?>
                        <td class="s20 bdleft" colspan="9">05 - Restos a pagar pagos inscritos sem disponibilidade - (Consulta 932.736/2015)</td>
                        <td class="s21"><?php echo db_formatar($iRestosAPagar, "f"); ?></td>
                    </tr>
                    <?php } ?>
                    <tr style='height:20px;'>
                        <?php
                        db_query("drop table if exists work_receita");
                        db_fim_transacao();
                        $fTotalAnexoII = getTotalAnexoIIEducacao($instits, $dtini, $dtfim, $anousu);
                        ?>
                        <td class="s20 bdleft" dir="ltr" colspan="9">06 - Aplicação na Manut. e Desenv. Ensino (Anexo II) % = <?php echo db_formatar((($fTotalAnexoII + $iRestosAPagar) * 100) / $fTotalReceitas, "f"); //echo db_formatar((($fTotalAnexoII/($fTotalReceitas*0.25))*0.25)*100,"f");
                                                                                                                                ?></td>
                        <td class="s21"><?= db_formatar(($fTotalAnexoII + $iRestosAPagar), "f") ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>

<?php

$html = ob_get_contents();
ob_end_clean();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

?>
