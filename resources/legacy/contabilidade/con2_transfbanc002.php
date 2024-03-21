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
use \Mpdf\Mpdf;
use \Mpdf\MpdfException;
db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);
if(count($aInstits) > 1){
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}

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

$mPDF = new Mpdf([
    'mode' => '',
    'format' => 'A4-L',
    'orientation' => 'L',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 20,
    'margin_bottom' => 10,
    'margin_header' => 5,
    'margin_footer' => 11,
]);

$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>TRANSFERÊNCIAS BANCÁRIAS</th>
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
            .ritz .waffle a { color : inherit; }
            .ritz .waffle .s3 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s4 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s5 { background-color : #d8d8d8; border-bottom : none; border-right : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-style : italic; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s16 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s18 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s6 { background-color : #d8d8d8; border-bottom : none; border-right : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s9 { background-color : #ffffff; border-bottom : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s10 { background-color : #ffffff; border-bottom : none; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s11 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s14 { background-color : #ffffff; border-bottom : none; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s17 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s12 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 14pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s7 { background-color : #d8d8d8; border-bottom : none; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s13 { background-color : #ffffff; border-bottom : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s15 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
            .ritz .waffle .s8 { background-color : #ffffff; border-bottom : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
        </style>
    </head>
    <body>

    <div class="ritz grid-container" dir="ltr">
        <table class="waffle" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th id="0C0" style="width:118px" class="column-headers-background">&nbsp;</th>
                <th id="0C1" style="width:93px" class="column-headers-background">&nbsp;</th>
                <th id="0C2" style="width:401px" class="column-headers-background">&nbsp;</th>
                <th id="0C3" style="width:134px" class="column-headers-background">&nbsp;</th>
                <th id="0C4" style="width:138px" class="column-headers-background">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <tr style='height:20px;'>
                <td class="s3 bdleft"></td>
                <td class="s4" colspan="4">BANCOS</td>
            </tr>
            <tr style='height:20px;'>
                <td class="s4 bdleft">Data</td>
                <td class="s4">Red.</td>
                <td class="s4">Conta/Descrição</td>
                <td class="s4">Retiradas</td>
                <td class="s4">Depositos</td>
            </tr>
            <?php
            $bFil = false;
            $sBackGround = "style='background-color: #d8d8d8;'";
            $oDadosAgrupados = getDados($dtini, $dtfim, $aInstits, $anousu,$contas,$o15_codigo);
            $fTotalGeralR = 0;
            $fTotalGeralD = 0;
            foreach ($oDadosAgrupados as $oDadosRelatorio) {
                $fSubTotalR = 0;
                $fSubTotalD = 0;
                foreach ($oDadosRelatorio as $oValores) {
                    $bFil = $bFil ? false : true;
                    $sBackGround = $bFil ? "style='background-color: #d8d8d8;'" : "";
                    ?>
                    <tr style='height:20px;'>
                        <td <?= $sBackGround ?> class="s8 bdleft"><?=db_formatar($oValores->sData,'d')?></td>
                        <td <?= $sBackGround ?> class="s8"><?=$oValores->iReduz."-".$oValores->iFonte?></td>
                        <td <?= $sBackGround ?> class="s9"><?=$oValores->sDescr?></td>
                        <td <?= $sBackGround ?> class="s10"><?=db_formatar($oValores->fValorRetirada,'f')?></td>
                        <td <?= $sBackGround ?> class="s10"><?=db_formatar($oValores->fValorDeposito,'f')?></td>
                    </tr>
                    <?php
                    $fSubTotalR += $oValores->fValorRetirada;
                    $fSubTotalD += $oValores->fValorDeposito;
                }
                $fTotalGeralR += $fSubTotalR;
                $fTotalGeralD += $fSubTotalD;
                ?>
                <tr style='height:20px;'>
                    <td class="s13 bdleft" colspan="3">SubTotal=</td>
                    <td class="s14"><?=db_formatar($fSubTotalR,'f')?> </td>
                    <td class="s14"><?=db_formatar($fSubTotalD,'f')?> </td>
                </tr>
                <?php
            }
            ?>
            <tr style='height:20px;'>
                <td class="s17 bdleft" colspan="3">TOTAL GERAL =</td>
                <td class="s18"><?=db_formatar($fTotalGeralR,'f')?> </td>
                <td class="s18"><?=db_formatar($fTotalGeralD,'f')?> </td>
            </tr>
            </tbody>
        </table>
    </div>
    </body>
    </html>

<?php

function getDados($sDtIni, $sDtFim, $aInstit, $iAnousu, $aContas, $sFonte)
{
    $oDadosAgrupados = Array();
    foreach(getContasPorFonte($aInstit, $iAnousu, $aContas, $sFonte) as $oContaFonte){

        $oDado = new stdClass();
        $oDado->iReduz = $oContaFonte->c61_reduz;
        $oDado->iFonte = $oContaFonte->o15_codtri;
        $oDado->sDescr = $oContaFonte->c60_descr;
        $oDado->aValores = getTransValorTferencias($sDtIni, $sDtFim, $oDado->iReduz);

        $oDadosAgrupados[] = $oDado;


    }
    $aDadosRetorno = array();
    foreach ($oDadosAgrupados as $oDadosRelatorio) {

        foreach ($oDadosRelatorio->aValores as $oValores) {

            $oDadoRetorno = new stdClass();
            $oDadoRetorno->sData = $oValores->c69_data;
            $oDadoRetorno->iReduz = $oDadosRelatorio->iReduz;
            $oDadoRetorno->sDescr = $oDadosRelatorio->sDescr;
            $oDadoRetorno->iFonte = $oDadosRelatorio->iFonte;
            $oDadoRetorno->fValorRetirada = $oValores->saida;
            $oDadoRetorno->fValorDeposito = $oValores->entrada;
            $aDadosRetorno[$oValores->c69_data][] = $oDadoRetorno;
        }
    }

    return $aDadosRetorno;
}

function getContasPorFonte($aInstit, $iAnousu, $aContas, $sFonte){

    if(!empty($sFonte)){
        $sWhereFonte = " and o15_codtri = '{$sFonte}' ";
    }

    if(!empty($aContas)){
        $sWhereContas = " and c61_reduz in (".implode(',',$aContas).") ";
    }

    $sSqlContas  = " select distinct c61_reduz,c60_descr,o15_codtri ";
    $sSqlContas .= " from conplanoreduz ";
    $sSqlContas .= " inner join conplano on c61_codcon = c60_codcon and c61_anousu = c60_anousu ";
    $sSqlContas .= " inner join orctiporec on c61_codigo = o15_codigo ";
    $sSqlContas .= " where c61_anousu = {$iAnousu} and c61_instit in (".implode(',',$aInstit).") $sWhereFonte $sWhereContas ";

    return db_utils::getCollectionByRecord(db_query($sSqlContas));

}

function getTransValorTferencias($sDtIni, $sDtFim,$iConta){

    $sSqlTransf = "SELECT  c69_codlan,
                           c69_data,
                           sum(saida)AS saida,
                           sum(entrada) AS entrada
                    FROM
                      (SELECT CASE
                                  WHEN c69_credito = {$iConta} THEN c69_valor
                                  ELSE 0
                              END AS saida,
                              CASE
                                  WHEN c69_debito = {$iConta} THEN c69_valor
                                  ELSE 0
                              END AS entrada,
                              c69_debito,
                              c69_credito,
                              c69_data,
                              c69_codlan
                       FROM conlancamval
                       INNER JOIN conlancamdoc ON c71_codlan = c69_codlan
                       WHERE (c69_credito in ({$iConta})
                              OR c69_debito in ({$iConta}))
                         AND c69_data BETWEEN '{$sDtIni}' AND '{$sDtFim}' and c71_coddoc in (140,141)) AS xx group by 1,2";

    return db_utils::getCollectionByRecord(db_query($sSqlTransf));
}

$html = ob_get_contents();
ob_end_clean();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
//echo $html;


?>
