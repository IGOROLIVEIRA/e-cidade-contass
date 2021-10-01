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

db_postmemory($HTTP_POST_VARS);
$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));
$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",", $instits);

$RPPS = 0;

foreach ($aInstits as $iInstit) {
    $oInstit = new Instituicao($iInstit);
    if ($oInstit->getTipoInstit() == 5)
        $RPPS = 1;
}


if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}

$sWhereReceita      = "o70_instit in ({$instits})";


$oReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anousu, $dtini, $dtfim, false, ' * ', true, 0);
$aReceitas = db_utils::getColectionByRecord($oReceitas);

$fTC1 = 0;
$fTC2 = 0;
$fTC3 = 0;
$fTC4 = 0;
$fTCons = 0;
$fPFM = 0;
$fFEP = 0;
$fICMS = 0;
$fITR = 0;
$fCFM = 0;
$fCIDE = 0;
$fCFH = 0;
$fFEX = 0;
$fIPM = 0;
$fSTN = 0;
$fTEUEDM = 0;
$fTRCI = 0;
$fRIRPPS = 0;

// Filtrando a conta contábil 362110300000000
$where = " p.c60_estrut LIKE '362110300000000%' AND c61_instit IN ({$instits}) ";
$result = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $dtini, $dtfim, false, $where, '', false, 'false');
for ($x = 0; $x < pg_numrows($result); $x++) {
    db_fieldsmemory($result, $x);

    if ($c61_reduz != 0) {
        $fRIRPPS += $saldo_anterior_debito - $saldo_anterior_credito;
    }
}

foreach ($aReceitas as $Receitas) {

    if (strstr($Receitas->o57_fonte, '17181000000000')) $fTC1 += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17281000000000')) $fTC2 += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '24181000000000')) $fTC3 += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '24281000000000')) $fTC4 += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17380211000000')) $fTCons += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17180121000000') || strstr($Receitas->o57_fonte, '17180131000000') || strstr($Receitas->o57_fonte, '17180141000000')) $fPFM += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17180261000000')) $fFEP += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17180611000000')) $fICMS += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17180151000000')) $fITR += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17280221000000') || strstr($Receitas->o57_fonte, '17180221000000')) $fCFM += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17280141000000')) $fCIDE += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17180211000000')) $fCFH += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17189911000000')) $fFEX += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '17280131000000')) $fIPM += $Receitas->saldo_arrecadado;
    if (strstr($Receitas->o57_fonte, '49500000000000')) $fTEUEDM += abs($Receitas->saldo_arrecadado);
    if (strstr($Receitas->o57_fonte, '47000000000000')) $fRCI += abs($Receitas->saldo_arrecadado);
    // if (strstr($Receitas->o57_fonte, '49813210041000') || strstr($Receitas->o57_fonte, '49813210401000')) $fRIRPPS += $Receitas->saldo_arrecadado;
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

$mPDF = new mpdf('', 'A4', 0, '', 10, 10, 20, 15, 8, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;padding-bottom:6px;">
    <tr>
      <td>{$oInstit->getDescricao()}</td>
    </tr>
    <tr>
      <th></th>
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

        .ritz .waffle .s3 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
        }

        .ritz .waffle .s4 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s6 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s1 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s9 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s10 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s8 {
            background-color: #bfbfbf;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s7 {
            background-color: #bfbfbf;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: left;
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
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s0 {
            background-color: #bfbfbf;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s2 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Arial';
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }
    </style>

</head>

<body>
    <?php if (db_getsession('DB_anousu') < 2018) : ?>
        <div class="ritz grid-container" dir="ltr">
            <table class="waffle" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr style=''>
                        <td class="s0 bdtop bdleft" colspan="2">CÁLCULO PARA CONTRIBUIÇÃO DO PASEP</td>
                    </tr>
                    <tr style=''>
                        <td class="s0 bdleft" colspan="2">I - RECEITAS</td>
                    </tr>
                    <tr style=''>
                        <td class="s0 bdleft" colspan="2">Inc. III, do art. 2º, da Lei n.º 9.715/98</td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft" style="width:700px">Receitas Correntes</td>
                        <td class="s2" style="width:172px">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1100.00.00.00 - Receitas Tributárias</td>
                        <td class="s4">
                            <?php
                            $aDadosRT = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '411%'");
                            $fRT = count($aDadosRT) > 0 ? $aDadosRT[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRT, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1200.00.00.00 - Receita de Contribuições </td>
                        <td class="s4">
                            <?php
                            $aDadosRC = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '412%'");
                            $fRC = count($aDadosRC) > 0 ? $aDadosRC[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRC, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1300.00.00.00 - Receita Patrimonial </td>
                        <td class="s4">
                            <?php
                            $aDadosRP = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '413%'");
                            $fRP = count($aDadosRP) > 0 ? $aDadosRP[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRP, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1400.00.00.00 - Receita Agropecuária </td>
                        <td class="s4">
                            <?php
                            $aDadosRA = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '414%'");
                            $fRA = count($aDadosRA) > 0 ? $aDadosRA[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRA, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1500.00.00.00 - Receita Industrial </td>
                        <td class="s4">
                            <?php
                            $aDadosRI = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '415%'");
                            $fRI = count($aDadosRI) > 0 ? $aDadosRI[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1600.00.00.00 - Receita de Serviços </td>
                        <td class="s4">
                            <?php
                            $aDadosRS = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '416%'");
                            $fRS = count($aDadosRS) > 0 ? $aDadosRS[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1700.00.00.00 - Transferências Correntes</td>
                        <td class="s4">
                            <?php
                            $aDadosTC = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417%'");
                            $fTC = count($aDadosTC) > 0 ? $aDadosTC[0]->saldo_arrecadado : 0;
                            echo db_formatar($fTC, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1900.00.00.00 - Outras receitas correntes </td>
                        <td class="s4">
                            <?php
                            $aDadosORC = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '419%'");
                            $fORC = count($aDadosORC) > 0 ? $aDadosORC[0]->saldo_arrecadado : 0;
                            echo db_formatar($fORC, "f");
                            ?>
                        </td>
                    </tr>
                    <?php if ($RPPS) { ?>
                        <tr style=''>
                            <td class="s3 bdleft">7000.00.00.00 - Receitas Correntes Intraorçamentárias </td>
                            <td class="s4">
                                <?php
                                $aDadosRCI = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '47%'");
                                $fRCI = count($aDadosRCI) > 0 ? $aDadosRCI[0]->saldo_arrecadado : 0;
                                echo db_formatar($fRCI, "f");
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr style=''>
                        <td class="s1 bdleft">Sub-Total I </td>
                        <td class="s5">
                            <?php
                            $fSubTutalI = array_sum(array($fRT, $fRC, $fRP, $fRA, $fRI, $fRS, $fTC, $fORC, $fRCI));
                            echo db_formatar($fSubTutalI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">2400.00.00.00 - Transferências de Capital</td>
                        <td class="s4">
                            <?php
                            $aDadosTCA = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '424%'");
                            $fTCA = count($aDadosTCA) > 0 ? $aDadosTCA[0]->saldo_arrecadado : 0;
                            echo db_formatar($fTCA, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft">Sub-Total II </td>
                        <td class="s5">
                            <?php
                            $fSubTutalII = $fTCA;
                            echo db_formatar($fSubTutalII, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft">Total das Receitas (I) </td>
                        <td class="s5">
                            <?php
                            $fTotalReceitasI = $fSubTutalI + $fSubTutalII;
                            echo db_formatar($fTotalReceitasI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s0 bdleft" colspan="2">II - EXCLUSÕES DA RECEITA</td>
                    </tr>
                    <tr style=''>
                        <td class="s6 bdleft">Base Legal </td>
                        <td class="s6">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">Transferências de Convênios (§ 7º, do art. 2º, da Lei n.º 9.715/98)</td>
                        <td class="s4">
                            <?php
                            $aDadosTC1 = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '41761%'");
                            $fTC1 = count($aDadosTC1) > 0 ? $aDadosTC1[0]->saldo_arrecadado : 0;
                            $aDadosTC2 = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '41762%'");
                            $fTC2 = count($aDadosTC2) > 0 ? $aDadosTC2[0]->saldo_arrecadado : 0;
                            $aDadosTC3 = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '42471%'");
                            $fTC3 = count($aDadosTC3) > 0 ? $aDadosTC3[0]->saldo_arrecadado : 0;
                            $aDadosTC4 = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '42472%'");
                            $fTC4 = count($aDadosTC4) > 0 ? $aDadosTC4[0]->saldo_arrecadado : 0;
                            $fTotalTC = array_sum(array($fTC1, $fTC2, $fTC3, $fTC4));
                            echo db_formatar($fTotalTC, "f");
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td class="s3 bdleft" dir="ltr">
                            Contrato de repasse ou instrumento congênere com objeto definido (§ 7º, do art. 2º, da Lei n.º 9.715/98)
                        </td>
                        <td class="s4">
                            <?= db_formatar($fCRICOD = 0, "f") ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">Transferências a outras Entidades de Direito Público Interno (art. 7º, da Lei n.º 9.715/98)</td>
                        <td class="s4"><?= db_formatar($fTOEDPI = 0, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">
                            Transferências efetuadas à União, aos Estados, ao Distrito Federal e a outros Municípios, bem como às autarquias dessas entidades (Solução de Consulta RFB n.º 278 - de 01 de junho 2017 - D.O.U: 06.06.2017)
                        </td>
                        <td class="s4"><?= db_formatar($fTEUEDM, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">
                            Transferências efetuadas à Instituições Multigovernamentais Nacionais (criadas e mantidas por dois ou mais entes da Federação) de caráter público, criadas por lei. (Solução de Consulta RFB n.º 31, de 28 de fevereiro de 2013 - 6ª Região Fiscal - D.O.U.: 05.03.2013)
                        </td>
                        <td class="s4"><?= db_formatar($fTEIMN = 0, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">
                            Transferências de Municípios a Consórcios Públicos
                        </td>

                        <td class="s4">
                            <?php
                            $aDadosCons = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '4173802%'");
                            $fTCons = count($aDadosCons) > 0 ? $aDadosCons[0]->saldo_arrecadado : 0;
                            echo db_formatar($fTCons, "f");
                            ?>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft">Total das exclusões da Receita (II) </td>
                        <td class="s5">
                            <?php
                            $fTotalExclusaoReceitaII = array_sum(array($fTotalTC, $fCRICOD, $fTOEDPI, $fTEUEDM, $fTEIMN, $fTCons));
                            echo db_formatar($fTotalExclusaoReceitaII, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s7 bdleft">III - TOTAL RECEITA LÍQUIDA (BASE DE CÁLCULO) (I-II) </td>
                        <td class="s8">
                            <?php
                            $fTotalRecLiqIII = $fTotalReceitasI - $fTotalExclusaoReceitaII;
                            echo db_formatar($fTotalRecLiqIII, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s9 bdleft">IV - RECEITAS COM RETENÇÕES DO PASEP NA FONTE</td>
                        <td class="s6">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">FPM - Fundo de Participação dos Municípios</td>
                        <td class="s4">
                            <?php
                            $aDadosFPM = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '4172101%' AND o57_fonte not in ('417210105010000','417210105020000','417210105030000')");
                            $fPFM = count($aDadosFPM) > 0 ? $aDadosFPM[0]->saldo_arrecadado : 0;
                            echo db_formatar($fPFM, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">F.E.P. - Fundo Especial Petróleo</td>
                        <td class="s4">
                            <?php
                            $aDadosFEP = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417212270%'");
                            $fFEP = count($aDadosFEP) > 0 ? $aDadosFEP[0]->saldo_arrecadado : 0;
                            echo db_formatar($fFEP, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">ICMS - Desoneração das Exportações - LC n.º 87/96</td>
                        <td class="s4">
                            <?php
                            $aDadosICMS = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '4172136%'");
                            $fICMS = count($aDadosICMS) > 0 ? $aDadosICMS[0]->saldo_arrecadado : 0;
                            echo db_formatar($fICMS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">ITR - Imposto Territorial Rural</td>
                        <td class="s4">
                            <?php
                            $aDadosITR = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417210105%'");
                            $fITR = count($aDadosITR) > 0 ? $aDadosITR[0]->saldo_arrecadado : 0;
                            echo db_formatar($fITR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">CFM - Depto Nacional de Produção Mineral</td>
                        <td class="s4">
                            <?php
                            $aDadosCFM = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417222220%'");
                            $fCFM = count($aDadosCFM) > 0 ? $aDadosCFM[0]->saldo_arrecadado : 0;
                            echo db_formatar($fCFM, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">CIDE - Contribuições de Intervenção no Domínio Econômico</td>
                        <td class="s4">
                            <?php
                            $aDadosCIDE = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417220113%'");
                            $fCIDE = count($aDadosCIDE) > 0 ? $aDadosCIDE[0]->saldo_arrecadado : 0;
                            echo db_formatar($fCIDE, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">CFH - Cota parte Compensação Finan. Rec. Hídricos</td>
                        <td class="s4">
                            <?php
                            $aDadosCFH = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417212211%'");
                            $fCFH = count($aDadosCFH) > 0 ? $aDadosCFH[0]->saldo_arrecadado : 0;
                            echo db_formatar($fCFH, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">FEX - Auxílio Financeiro para Fomento Exportações / AFM - Apoio Financeiro aos Municípios</td>
                        <td class="s4">
                            <?php
                            $aDadosFEX = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '4172199%'");
                            $fFEX = count($aDadosFEX) > 0 ? $aDadosFEX[0]->saldo_arrecadado : 0;
                            echo db_formatar($fFEX, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft" dir="ltr">
                            Outras transferências correntes e de capital recebidas, se comprovada a retenção na fonte, pela Secretaria do Tesouro Nacional - STN, da contribuição incidente sobre tais valores.
                        </td>
                        <td class="s4">
                            <?php
                            $aDadosSTN = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417220104%'");
                            $fSTN = count($aDadosSTN) > 0 ? $aDadosSTN[0]->saldo_arrecadado : 0;
                            echo db_formatar($fSTN, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft">TOTAL DAS RECEITAS COM RETENÇÕES DO PASEP NA FONTE (IV)</td>
                        <td class="s5">
                            <?php
                            $fTotalRetidosIV = array_sum(array($fPFM, $fFEP, $fICMS, $fITR, $fCFM, $fCIDE, $fCFH, $fFEX, $fSTN));
                            echo db_formatar($fTotalRetidosIV, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s6 bdleft">RESUMO</td>
                        <td class="s6">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">a) Total da Receita Líquida (III) </td>
                        <td class="s5"><?= db_formatar($fTotalRecLiqIII, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">b) 1% sobre total das Receitas (a*1%) </td>
                        <td class="s5"><?= db_formatar($fTotalRecLiqIII * 0.01, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">c) PASEP retido na Fonte (IV*1%)</td>
                        <td class="s5"><?= db_formatar($fTotalRetidosIV * 0.01, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s7 bdleft">RESULTADO DO CÁLCULO (b-c)</td>
                        <td class="s8"><?= db_formatar(($fTotalRecLiqIII * 0.01) - ($fTotalRetidosIV * 0.01), "f") ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="ritz grid-container" dir="ltr">
            <table class="waffle" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr style=''>
                        <td class="s0 bdtop bdleft" colspan="2">CÁLCULO PARA CONTRIBUIÇÃO DO PASEP</td>
                    </tr>
                    <tr style=''>
                        <td class="s0 bdleft" colspan="2">I - RECEITAS</td>
                    </tr>
                    <tr style=''>
                        <td class="s0 bdleft" colspan="2">Inc. III, do art. 2º, da Lei n.º 9.715/98</td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft" style="width:700px">Receitas Correntes</td>
                        <td class="s2" style="width:172px">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1100.00.00.00 - Impostos, Taxas e Contribuições de Melhoria</td>
                        <td class="s4">
                            <?php
                            $aDadosRT = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '411%'");
                            $fRT = count($aDadosRT) > 0 ? $aDadosRT[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRT, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1200.00.00.00 - Receita de Contribuições </td>
                        <td class="s4">
                            <?php
                            $aDadosRC = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '412%'");
                            $fRC = count($aDadosRC) > 0 ? $aDadosRC[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRC, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1300.00.00.00 - Receita Patrimonial </td>
                        <td class="s4">
                            <?php
                            $aDadosRP = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '413%'");
                            $fRP = count($aDadosRP) > 0 ? $aDadosRP[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRP, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1400.00.00.00 - Receita Agropecuária </td>
                        <td class="s4">
                            <?php
                            $aDadosRA = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '414%'");
                            $fRA = count($aDadosRA) > 0 ? $aDadosRA[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRA, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1500.00.00.00 - Receita Industrial </td>
                        <td class="s4">
                            <?php
                            $aDadosRI = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '415%'");
                            $fRI = count($aDadosRI) > 0 ? $aDadosRI[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1600.00.00.00 - Receita de Serviços </td>
                        <td class="s4">
                            <?php
                            $aDadosRS = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '416%'");
                            $fRS = count($aDadosRS) > 0 ? $aDadosRS[0]->saldo_arrecadado : 0;
                            echo db_formatar($fRS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1700.00.00.00 - Transferências Correntes</td>
                        <td class="s4">
                            <?php
                            $aDadosTC = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '417%'");
                            $fTC = count($aDadosTC) > 0 ? $aDadosTC[0]->saldo_arrecadado : 0;
                            echo db_formatar($fTC, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">1900.00.00.00 - Outras receitas correntes </td>
                        <td class="s4">
                            <?php
                            $aDadosORC = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '419%'");
                            $fORC = count($aDadosORC) > 0 ? $aDadosORC[0]->saldo_arrecadado : 0;
                            echo db_formatar($fORC, "f");
                            ?>
                        </td>
                    </tr>
                    <?php if ($RPPS) { ?>
                        <tr style=''>
                            <td class="s3 bdleft">7000.00.00.00 - Receitas Correntes Intraorçamentárias </td>
                            <td class="s4">
                                <?php
                                $aDadosRCI = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '47%'");
                                $fRCI = count($aDadosRCI) > 0 ? $aDadosRCI[0]->saldo_arrecadado : 0;
                                echo db_formatar($fRCI, "f");
                                ?>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr style=''>
                        <td class="s1 bdleft">Sub-Total I </td>
                        <td class="s5">
                            <?php
                            $fSubTutalI = array_sum(array($fRT, $fRC, $fRP, $fRA, $fRI, $fRS, $fTC, $fORC, $fRCI));
                            echo db_formatar($fSubTutalI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">2400.00.00.00 - Transferências de Capital</td>
                        <td class="s4">
                            <?php
                            $aDadosTCA = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '424%'");
                            $fTCA = count($aDadosTCA) > 0 ? $aDadosTCA[0]->saldo_arrecadado : 0;
                            echo db_formatar($fTCA, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft">Sub-Total II </td>
                        <td class="s5">
                            <?php
                            $fSubTutalII = $fTCA;
                            echo db_formatar($fSubTutalII, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft">Total das Receitas (I) </td>
                        <td class="s5">
                            <?php
                            $fTotalReceitasI = $fSubTutalI + $fSubTutalII;
                            echo db_formatar($fTotalReceitasI, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s0 bdleft" colspan="2">II - EXCLUSÕES DA RECEITA</td>
                    </tr>
                    <tr style=''>
                        <td class="s6 bdleft">Base Legal </td>
                        <td class="s6">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">Transferências de Convênios (§ 7º, do art. 2º, da Lei n.º 9.715/98)</td>
                        <td class="s4">
                            <?php

                            $fTotalTC = array_sum(array($fTC1, $fTC2, $fTC3, $fTC4));
                            echo db_formatar($fTotalTC, "f");
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td class="s3 bdleft" dir="ltr">
                            Contrato de repasse ou instrumento congênere com objeto definido (§ 7º, do art. 2º, da Lei n.º 9.715/98)
                        </td>
                        <td class="s4">
                            <?= db_formatar($fCRICOD = 0, "f") ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">Transferências a outras Entidades de Direito Público Interno (art. 7º, da Lei n.º 9.715/98)</td>
                        <td class="s4"><?= db_formatar($fTOEDPI = 0, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">
                            Transferências efetuadas à União, aos Estados, ao Distrito Federal e a outros Municípios, bem como às autarquias dessas entidades (Solução de Consulta RFB n.º 278 - de 01 de junho 2017 - D.O.U: 06.06.2017)
                        </td>
                        <td class="s4"><?= db_formatar($fTEUEDM, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">
                            Transferências efetuadas à Instituições Multigovernamentais Nacionais (criadas e mantidas por dois ou mais entes da Federação) de caráter público, criadas por lei. (Solução de Consulta RFB n.º 31, de 28 de fevereiro de 2013 - 6ª Região Fiscal - D.O.U.: 05.03.2013)
                        </td>
                        <td class="s4"><?= db_formatar($fTEIMN = 0, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">
                            Transferências de Municípios a Consórcios Públicos
                        </td>

                        <td class="s4">
                            <?php
                            echo db_formatar($fTCons, "f");
                            ?>
                    </tr>

                    <?php if ($RPPS) { ?>
                        <tr style=''>
                            <td class="s3 bdleft">
                                Receitas Correntes Intraorçamentária
                            </td>

                            <td class="s4">
                                <?php
                                echo db_formatar($fTRCI, "f");
                                ?>
                        </tr>

                        <tr style=''>
                            <td class="s3 bdleft">
                                Perdas com Investimentos do RPPS
                            </td>

                            <td class="s4">
                                <?php
                                echo db_formatar($fRIRPPS, "f");
                                ?>
                        </tr>
                    <?php } ?>
                    <tr style=''>
                        <td class="s1 bdleft">Total das exclusões da Receita (II) </td>
                        <td class="s5">
                            <?php
                            $fTotalExclusaoReceitaII = array_sum(array($fTotalTC, $fCRICOD, $fTOEDPI, $fTEUEDM, $fTEIMN, $fTCons, $fRIRPPS, $fTRCI));
                            echo db_formatar($fTotalExclusaoReceitaII, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s7 bdleft">III - TOTAL RECEITA LÍQUIDA (BASE DE CÁLCULO) (I-II) </td>
                        <td class="s8">
                            <?php
                            $fTotalRecLiqIII = $fTotalReceitasI - $fTotalExclusaoReceitaII;
                            echo db_formatar($fTotalRecLiqIII, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s9 bdleft">IV - RECEITAS COM RETENÇÕES DO PASEP NA FONTE</td>
                        <td class="s6">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">FPM - Fundo de Participação dos Municípios</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fPFM, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">F.E.P. - Fundo Especial Petróleo</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fFEP, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">ICMS - Desoneração das Exportações - LC n.º 87/96</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fICMS, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">ITR - Imposto Territorial Rural</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fITR, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">CFM - Depto Nacional de Produção Mineral</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fCFM, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">CIDE - Contribuições de Intervenção no Domínio Econômico</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fCIDE, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">CFH - Cota parte Compensação Finan. Rec. Hídricos</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fCFH, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">FEX - Auxílio Financeiro para Fomento Exportações / AFM - Apoio Financeiro aos Municípios</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fFEX, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">IPM - IPI Exportação</td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fIPM, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft" dir="ltr">
                            Outras transferências correntes e de capital recebidas, se comprovada a retenção na fonte, pela Secretaria do Tesouro Nacional - STN, da contribuição incidente sobre tais valores.
                        </td>
                        <td class="s4">
                            <?php
                            echo db_formatar($fSTN, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s1 bdleft">TOTAL DAS RECEITAS COM RETENÇÕES DO PASEP NA FONTE (IV)</td>
                        <td class="s5">
                            <?php
                            $fTotalRetidosIV = array_sum(array($fPFM, $fFEP, $fICMS, $fITR, $fCFM, $fCIDE, $fCFH, $fFEX, $fIPM, $fSTN));
                            echo db_formatar($fTotalRetidosIV, "f");
                            ?>
                        </td>
                    </tr>
                    <tr style=''>
                        <td class="s6 bdleft">RESUMO</td>
                        <td class="s6">VALOR</td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">a) Total da Receita Líquida (III) </td>
                        <td class="s5"><?= db_formatar($fTotalRecLiqIII, "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">b) 1% sobre total das Receitas (a*1%) </td>
                        <td class="s5"><?= db_formatar(floatval(number_format(($fTotalRecLiqIII * 0.01), 2, '.', '')), "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s3 bdleft">c) PASEP retido na Fonte</td>
                        <?php $fPASEPRETIDO = (($fPFM + $fFEP + $fICMS +  $fCFM + $fCIDE + $fCFH + $fFEX + $fSTN) * 0.01) + (($fITR + $fIPM) * 0.008) ?>
                        <td class="s5"><?= db_formatar(floatval(number_format($fPASEPRETIDO, 2, '.', '')), "f") ?></td>
                    </tr>
                    <tr style=''>
                        <td class="s7 bdleft">RESULTADO DO CÁLCULO (b-c)</td>
                        <td class="s8"><?= db_formatar(floatval(number_format(($fTotalRecLiqIII * 0.01), 2, '.', '')) - floatval(number_format($fPASEPRETIDO, 2, '.', '')), 'f') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body>

</html>

<?php

$html = ob_get_contents();
ob_end_clean();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
//echo $html;

?>
