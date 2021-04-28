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

//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
require("vendor/mpdf/mpdf/mpdf.php");

$clselorcdotacao = new cl_selorcdotacao();
$clempresto = new cl_empresto;
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

db_inicio_transacao();

$db_filtro = " o70_instit in({$instits}) ";
$anousu = db_getsession("DB_anousu");



$oReceitas = db_receitasaldo(11,1,3,true,$db_filtro,$anousu,$dtini,$dtfim,false,' * ',true,0);
$aReceitas = db_utils::getColectionByRecord($oReceitas);
//417580111000000
//417580121000000
//4321001118 | 432100111
$fRFMD = 0;
$fRCUF = 0;
$fRDBR = 0;
foreach ($aReceitas as $Receitas) {
    if(strstr($Receitas->o57_fonte, '417580111000000'))$fRFMD+=$Receitas->saldo_arrecadado;
    if(strstr($Receitas->o57_fonte, '417580121000000'))$fRCUF+=$Receitas->saldo_arrecadado;
    if(strstr($Receitas->o57_fonte, '413210011180000'))$fRDBR+=$Receitas->saldo_arrecadado;
    if(strstr($Receitas->o57_fonte, '413210011190000'))$fRDBR+=$Receitas->saldo_arrecadado;
}

db_query("drop table if exists work_receita");

$sWhereDespesa      = " o58_instit in({$instits})";
criaWorkDotacao($sWhereDespesa,array($anousu), $dtini, $dtfim);

$sWhereReceita      = "o70_instit in ({$instits})";
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

/*
 * inicio OC
 */



$where = " c61_instit in ({$instits})" ;
$where .= " and (c61_codigo = '118' or c61_codigo = '1118') ";

$result = db_planocontassaldo_matriz(db_getsession("DB_anousu"),($DBtxt21_ano.'-'.$DBtxt21_mes.'-'.$DBtxt21_dia),$dtfim,false,$where);

$total_anterior    = 0;
$total_debitos  = 0;
$total_creditos = 0;
$total_final    = 0;
$iAjustePcasp   = 0;

if (USE_PCASP) {
    $iAjustePcasp = 8;
}

for($x = 0; $x < pg_numrows($result);$x++){
    db_fieldsmemory($result,$x);

    if( ( $tipo == "S" ) && ( $c61_reduz != 0 ) ) {
        continue;
    }

    if (USE_PCASP) {
    } else {
        if(substr($estrutural,0,1) == '3' ) {
            if(substr($estrutural,2)+0 > 0 )
                continue;
        }
        if(substr($estrutural,0,1) == '4' ) {
            if(substr($estrutural,2)+0 > 0 )
                continue;
        }
    }

    if( ( $movimento == "S" ) && ( ( $saldo_anterior + $saldo_anterior_debito + $saldo_anterior_credito) == 0 ) ) {
        continue;
    }

    if(substr($estrutural,1,14) == '00000000000000'){

        if($sinal_anterior == "C")
            $total_anterior -= $saldo_anterior;
        else
            $total_anterior += $saldo_anterior;

        if($sinal_final == "C")
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
    $sInst .='instit_'.$inst.'-';
}
$filtra_despesa = $sInst."recurso_118-recurso_1118";
$clselorcdotacao->setDados($filtra_despesa);
$sql_filtro = $clselorcdotacao->getDados(false);
function retorna_desdob($elemento, $e64_codele, $clorcelemento)
{
    return pg_query($clorcelemento->sql_query_file(null, null, "o56_elemento as estrutural,o56_descr as descr", null, "o56_codele = $e64_codele and o56_elemento like '$elemento%'"));
}


$resultinst = pg_exec("select codigo,nomeinstabrev from db_config where codigo in (" .$instits. ") ");

$sele_work = ' e60_instit in (' . $instits . ') ';
$sele_work1 = '';//tipo de recurso
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

$rows = $clempresto->numrows;

$total_rp_proc = 0;
$total_rp_nproc = 0;
$total_mov_pagmento = 0;

for ($x = 0; $x < $rows; $x++) {
    db_fieldsmemory($res, $x);
    $total_rp_proc += ($e91_vlrliq - $e91_vlrpag);
    $total_rp_nproc += round($vlrpagnproc,2);
    $total_mov_pagmento += ($vlrpag+$vlrpagnproc);
}

if(($total_rp_proc + $total_rp_nproc) < $total_anterior || $total_mov_pagmento < $total_anterior){
    $iRestosAPagar = db_formatar(0,"f");
}
else{
    $iRestosAPagar = $total_mov_pagmento-$total_anterior;
}

/*
 * fim OC
 *
 */


$mPDF = new mpdf('', '', 0, '', 15, 15, 20, 15, 5, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>ANEXO III</th>
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

$aRecursos      = array();
$aPago          = array();
$aPagoAcumulado = array();
?>
<html>
<head>
    <style type="text/css">.ritz .waffle a { color: inherit; }.ritz .waffle .s20{border-bottom:1px SOLID transparent;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s22{border-bottom:1px SOLID transparent;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s11{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s26{border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s9{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s12{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s18{border-bottom:1px SOLID transparent;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s10{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s25{background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s4{border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s28{border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s15{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:right;font-weight:bold;text-decoration:underline;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s17{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s5{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:center;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:normal;overflow:hidden;word-wrap:break-word;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s8{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s21{border-bottom:1px SOLID transparent;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s19{border-bottom:1px SOLID transparent;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:center;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s23{border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s7{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:center;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s30{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:8pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s27{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s3{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:right;font-style:italic;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s13{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s24{background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s1{background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:12pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s14{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;font-weight:bold;text-decoration:underline;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s6{border-bottom:1px SOLID #000000;border-right:1px SOLID transparent;background-color:#d8d8d8;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s29{border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:8pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s0{background-color:#ffffff;text-align:center;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:14pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s2{background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s16{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}</style>
</head>
<body>
<div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th id="0C0" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="0C1" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="0C2" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="0C3" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="0C4" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="0C5" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="0C6" style="width:100px" class="column-headers-background">&nbsp;</th>
            <th id="0C7" style="width:100px" class="column-headers-background">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr style='height:20px;'>
            <td class="s4 bdleft" colspan="8">FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO</td>
        </tr>
        <tr style='height:20px;'>
            <td class="s4 bdleft" colspan="8">DOS PROFISSIONAIS DA EDUCAÇÃO - FUNDEB </td>
        </tr>
        <tr style='height:20px;'>
            <td class="s5 bdleft" colspan="8">DEMONSTRATIVO DOS RECURSOS RECEBIDOS E SUA APLICAÇÃO </td>
        </tr>
        <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="7">01 - RECURSOS:</td>
            <td class="s7">R$</td>
        </tr>
        <!-- OC5513 - ALTERACACAO DE ESTRUTURAIS APÓS 2018 -->
        <?php if(db_getsession('DB_anousu')<2018): ?>
            <tr style='height:20px;'>
                <td class="s8 bdleft" colspan="7">A - Transferências Multigovernamentais:</td>
                <td class="s9"></td>
            </tr>
            <tr style='height:20px;'>
                <td class="s10 bdleft" colspan="7" rowspan="2">1724.01.00 - Transferências de Recursos do Fundo de Manuteção e Desenvolv. Da
                    Educação Básica e de Valorização dos Profissionais da Educação - FUNDEB
                </td>
                <td class="s12" rowspan="2">
                    <?
                    $aDadosRFMD = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '4172401%'");
                    $fRFMD = count($aDadosRFMD) > 0 ? $aDadosRFMD[0]->saldo_arrecadado : 0;
                    echo db_formatar($fRFMD, "f");
                    $aRecursos[] = $fRFMD;
                    ?>

                </td>
            </tr>
            <tr>
                <td colspan="7"></td>
                <td ></td>
            </tr>
            <tr style='height:20px;'>
                <td class="s8 bdleft" colspan="7">1724.02.00 - Transf.de Recursos da Complementação da União ao FUNDEB</td>
                <td class="s13" >
                    <?
                    $aDadosRCUF = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '4172402%'");
                    $fRCUF = count($aDadosRCUF) > 0 ? $aDadosRCUF[0]->saldo_arrecadado : 0;
                    echo db_formatar($fRCUF, "f");
                    $aRecursos[] = $fRCUF;
                    ?>
                </td>
            </tr>
            <tr style='height:20px;'>
                <td class="s10 bdleft" colspan="7">B - Receitas de Aplicações Financeiras (art. 20, § único, Lei Federal 11494/2007)</td>
                <td class="s11"></td>
            </tr>
            <tr style='height:20px;'>
                <td class="s8 bdleft" colspan="7">1325.01.02- Receita de Remuneração de Depósitos Bancários de Rec.Vinc.FUNDEB</td>
                <td class="s14">
                    <?
                    $aDadosRDBR = getSaldoReceita(null, "sum(saldo_arrecadado) as saldo_arrecadado", null, "o57_fonte like '413250102%'");
                    $fRDBR = count($aDadosRDBR) > 0 ? $aDadosRDBR[0]->saldo_arrecadado : 0;
                    echo db_formatar($fRDBR, "f");
                    $aRecursos[] = $fRDBR;
                    ?>
                </td>
            </tr>
        <?php else: ?>
            <tr style='height:20px;'>
                <td class="s8 bdleft" colspan="7">A - Transferências Multigovernamentais:</td>
                <td class="s9"></td>
            </tr>
            <tr style='height:20px;'>
                <td class="s10 bdleft" colspan="7" rowspan="2">1758.01.11 - Transferências de Recursos do Fundo de Manuteção e Desenvolv. Da
                    Educação Básica e de Valorização dos Profissionais da Educação - FUNDEB
                </td>
                <td class="s12" valign="middle" style="vertical-align:middle;" rowspan="2">
                    <?
                    echo db_formatar($fRFMD, "f");
                    $aRecursos[] = $fRFMD;
                    ?>

                </td>
            </tr>
            <tr style='height:20px;'>

            </tr>
            <tr style='height:20px;'>
                <td class="s8 bdleft" colspan="7">1758.01.21 - Transf.de Recursos da Complementação da União ao FUNDEB</td>
                <td class="s13">
                    <?
                    echo db_formatar($fRCUF, "f");
                    $aRecursos[] = $fRCUF;
                    ?>
                </td>
            </tr>
            <tr style='height:20px;'>
                <td class="s10 bdleft" colspan="7">B - Receitas de Aplicações Financeiras (art. 20, § único, Lei Federal 11494/2007)</td>
                <td class="s11"></td>
            </tr>
            <tr style='height:20px;'>
                <td class="s8 bdleft" colspan="7">1321.00.11.18/1321.00.11.19 - Receita de Remuneração de Depósitos Bancários de Rec.Vinc.FUNDEB</td>
                <td class="s14">
                    <?
                    echo db_formatar($fRDBR, "f");
                    $aRecursos[] = $fRDBR;
                    ?>
                </td>
            </tr>
        <?php endif; ?>
        <!-- FIM OC5513 -->
        <tr style='height:20px;'>
            <td class="s10 bdleft" colspan="7">C - Recursos não aplicados no exercicio anterior (art. 21, § único, Lei Federal 11494/2007) </td>
            <td class="s12">
                <?php
                $fRNAEA = getSaldoTesolraria($anousu, $aInstits);
                $aRecursos[] = $fRNAEA;
                echo db_formatar($fRNAEA,"f");
                ?>
            </td>
        </tr>
        <tr style='height:20px;'>
            <td class="s12 bdleft" colspan="7">TOTAL DO ITEM 01:</td>
            <td class="s15"><? echo db_formatar(array_sum($aRecursos), "f"); ?></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s9 bdleft" colspan="8"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s16 bdleft" colspan="8">02 - APLICAÇÃO NA EDUCAÇÃO BÁSICA PÚBLICA:</td>
        </tr>
        <tr style='height:20px;'>
            <td class="s17 bdleft">Função</td>
            <td class="s17">Subfunções</td>
            <td class="s17">Programas</td>
            <td class="s17" colspan="3">Especificação</td>
            <td class="s17" colspan="2">DESPESA</td>
        </tr>
        <tr style='height:20px;'>
            <td class="s9 bdleft"></td>
            <td class="s9"></td>
            <td class="s9"></td>
            <td class="s9" colspan="3"></td>
            <td class="s17">Parcial</td>
            <td class="s17">Total</td>
        </tr>
        <tr style='height:20px;'>
            <td class="s17 bdleft">12</td>
            <td class="s9"></td>
            <td class="s9"></td>
            <td class="s8" colspan="3">EDUCAÇÃO</td>
            <td class="s9"></td>
            <td class="s9"></td>
        </tr>
        <?php
        /**
         * @todo loop de cada subfuncao
         *
         */
        $fSubTotal = 0;
        $aSubFuncoes = array(122,272,271,361,365,366,367);
        $sFuncao     = "12";
        $aFonte      = array("'118'","'119'");
        foreach ($aSubFuncoes as $iSubFuncao) {
            $sDescrSubfunao = db_utils::fieldsMemory(db_query("select o53_descr from orcsubfuncao where o53_codtri = '{$iSubFuncao}'"), 0)->o53_descr;
            $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago,coalesce(sum(pago_acumulado),0) as pago_acumulado", null, "o58_funcao = {$sFuncao} and o58_subfuncao in ({$iSubFuncao}) and o15_codtri in (".implode(",",$aFonte).") and o58_instit in ($instits) group by 1,2");
            if (count($aDespesasProgramas) > 0) {

                ?>
                <tr style='height:20px;'>
                    <td class="s17 bdleft"></td>
                    <td class="s9"><?= db_formatar($iSubFuncao, 'subfuncao') ?></td>
                    <td class="s9"></td>
                    <td class="s8" colspan="3"><?= $sDescrSubfunao ?></td>
                    <td class="s9"></td>
                    <td class="s9"></td>
                </tr>
                <?php
                /**
                 * @todo para cada subfuncao lista os programas
                 */
                foreach ($aDespesasProgramas as $oDespesaPrograma) {
                    $oPrograma = new Programa($oDespesaPrograma->o58_programa, $oDespesaPrograma->o58_anousu);
                    $fSubTotal += $oDespesaPrograma->pago;
                    ?>
                    <tr style='height:20px;'>
                        <td class="s18 bdleft"></td>
                        <td class="s19"></td>
                        <td class="s19"><?php echo db_formatar($oPrograma->getCodigoPrograma(), "programa"); ?></td>
                        <td class="s20" colspan="3"><?= $oPrograma->getDescricao() ?></td>
                        <td class="s21"><?= db_formatar($oDespesaPrograma->pago, "f"); $aPago[] =  $oDespesaPrograma->pago; ?></td>
                        <td class="s21"><?= db_formatar($oDespesaPrograma->pago_acumulado, "f");$aPagoAcumulado[] =  $oDespesaPrograma->pago_acumulado; ?></td>
                    </tr>
                <?php }
                ?>
                <tr style='height:20px;'>
                    <td class="s3 bdleft">&nbsp;</td>
                    <td class="s3"></td>
                    <td class="s3"></td>
                    <td class="s3" colspan="5"></td>
                </tr>
                <?php
            }
        }
        ?>

        <tr style='height:20px;'>
            <td class="s12 bdleft" colspan="6">TOTAL</td>
            <td class="s12"><? echo db_formatar(array_sum($aPago), "f"); ?></td>
            <td class="s12"><? echo db_formatar(array_sum($aPagoAcumulado), "f"); ?></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s23 bdleft" colspan="8">GASTOS COM PROFISSIONAIS DO MAGISTÉRIO DA EDUCAÇÃO BÁSICA: </td>
        </tr>
        <tr style='height:20px;'>
            <td class="s24 bdleft" colspan="7">Receita Total do Fundo (Anexo III, Item 01) .................................................................................=</td>
            <td class="s26"><? echo db_formatar(array_sum($aRecursos), "f"); ?></td>
        </tr>
        <tr style='height:20px;'>
            <? $porcentagem = $anousu >= 2021 ? 70 : 60; ?>

            <td class="s24 bdleft" colspan="7">Valor Legal Mínimo <?= $porcentagem ?> % ..............................................................................................................=</td>
            <?
            $valorLegal = array_sum($aRecursos) * ($porcentagem/100);
            ?>
            <td class="s26"><? echo db_formatar($valorLegal,'f') ?></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s24 bdleft" colspan="7">Aplicação no exercício ..................................................................................................................=</td>
            <td class="s28">
                <?php
                foreach ($aSubFuncoes as $iSubFuncao) {
                    $aDespesasProgramasFonte118 = getSaldoDespesa(null, "coalesce(sum(pago),0) as pago", null, "o58_funcao = {$sFuncao} and o58_subfuncao in ({$iSubFuncao}) and o15_codtri in ('118') and o58_instit in ($instits)");
                    if (count($aDespesasProgramasFonte118) > 0) {
                        foreach ($aDespesasProgramasFonte118 as $oDespesaPrograma118) {
                            $fSubTotalFont118 += $oDespesaPrograma118->pago;
                        }

                    }
                }
                echo db_formatar($fSubTotalFont118,'f');
                ?>
            </td>
            <?
//            $iPercentual = ($iTotalAplicado*100)/array_sum($aRecursos);
              $iTotalApli = $fSubTotalFont118 + $iRestosAPagar;
              $iPercentual = ($iTotalApli/array_sum($aRecursos))*100;
            ?>
        </tr>
        <tr style='height:20px;'>
            <td class="s24 bdleft" colspan="7">
                Restos a pagar pagos inscritos sem disponibilidade - Consulta N. 932.736/2015 ........................=
            </td>
            <td class="s28">
                <?php echo db_formatar($iRestosAPagar,"f");?>
            </td>
        </tr>
        <tr style='height:20px;'>
            <td class="s24 bdleft" colspan="7">
                Valor total aplicado .......................................................................................................................=
            </td>
            <td class="s28">
                <?php
                $iTotalAplicado = $fSubTotalFont118 + $iRestosAPagar;
                echo db_formatar($iTotalAplicado,'f');
                ?>
            </td>
        </tr>
        <tr style='height:20px;'>
            <td class="s26 bdleft" colspan="8"></td>
        </tr>
        <tr style='height:20px;'>
            <td class="s29 bdleft" colspan="8">(O Valor Aplicado é composto pelas despesas com os profissionais do magistério da educação básica, em efetivo exercício de </td>
        </tr>
        <tr style='height:20px;'>
            <td class="s30 bdleft" colspan="7">suas atividades na rede pública e corresp. aos comprovantes de despesas organizados de acordo c/a alínea a, artigo 15 desta IN).</td>
            <td style="font-weight: bold; border:1px solid; background-color:#d8d8d8; font-family: 'Calibri',Arial; font-size: 11pt; text-align: center">
                <? echo sprintf("%.2f%%", $iPercentual) ?>
            </td>
        </tr>
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


db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");

db_fim_transacao();

function getSaldoTesolraria($anousu,$aInstits){
    $iAnousuAnt = $anousu-1;
    $sql = "select k13_conta, k13_descr, c60_estrut,c61_instit
 from saltes
 inner join conplanoexe on c62_anousu = {$anousu}
 and c62_reduz = k13_conta
 inner join conplanoreduz on c61_anousu= {$anousu} and
 c61_reduz = c62_reduz and
 c61_instit in (".implode(",",$aInstits).")
 inner join conplano on c61_codcon = c60_codcon and c61_anousu=c60_anousu
 inner join orctiporec on o15_codigo = c61_codigo
 where orctiporec.o15_codtri in ('118','119')
 and c60_codsis in (5,6)
 order by k13_descr";
    $result_contas = db_utils::getColectionByRecord(db_query($sql));
    foreach($result_contas as $oDados){
        $result1 = db_query("select fc_saltessaldo($oDados->k13_conta,'$iAnousuAnt-12-31','$iAnousuAnt-12-31',null,{$oDados->c61_instit})");
        $valor = pg_result($result1, 0, 0);
        $valor = preg_split("/\s+/", $valor);
        if ($valor[0] != "2" || $valor[0] != "3") {
            $tval1 += (float) str_replace(",", "", $valor[1]);
            $tval2 += (float) str_replace(",", "", $valor[2]);
            $tval3 += (float) str_replace(",", "", $valor[3]);
            $tval4 += (float) str_replace(",", "", $valor[4]);
        }

    }
    return $tval4;
}
?>
