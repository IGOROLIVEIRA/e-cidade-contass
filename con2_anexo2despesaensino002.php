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
require_once("classes/db_cgm_classe.php");
require_once("classes/db_slip_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");
require_once("classes/db_empresto_classe.php");
$clempresto = new cl_empresto;
$clrotulo = new rotulocampo;

db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
$clSlip = new cl_slip();

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

/**
 * pego todas as instituições;
 */
$rsInstits = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_instit,si09_tipoinstit", null, null));

$ainstitunticoes = array();
for ($i = 0; $i < pg_num_rows($rsInstits); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsInstits, $i);
    $ainstitunticoes[] = $odadosInstint->si09_instit;
}
$iInstituicoes = implode(',', $ainstitunticoes);

$rsTipoinstit = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_sequencial,si09_tipoinstit", null, "si09_instit in( {$instits})"));

/**
 * busco o tipo de instituicao
 */
$ainstitunticoes = array();
$aTipoistituicao = array();

for ($i = 0; $i < pg_num_rows($rsTipoinstit); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsTipoinstit, $i);
    $aTipoistituicao[] = $odadosInstint->si09_tipoinstit;
    $iCont = pg_num_rows($rsTipoinstit);
}


$sWhereDespesa      = " o58_instit in({$instits})";
db_query("drop table if exists work_dotacao");
criaWorkDotacao($sWhereDespesa,array($anousu), $dtini, $dtfim);

$sWhereReceita      = "o70_instit in ({$instits})";
$rsReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anousu, $dtini, $dtfim, false, ' * ', true, 0);
$aReceitas = db_utils::getColectionByRecord($rsReceitas);
db_query("drop table if exists work_receita");
criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);


//$result = db_planocontassaldo_matriz(db_getsession("DB_anousu"),($DBtxt21_ano.'-'.$DBtxt21_mes.'-'.$DBtxt21_dia),$dtfim,false,$where);


// echo "<pre>";print_r($aReceitas);exit;


/**
 * mPDF
 * @param string $mode | padrão: BLANK
 * @param mixed $format | padrão: A4
 * @param float $default_font_size | padrão: 0
 * @param string $default_font | padrão: ''
 * @param float $margin_left | padrão: 15
 * @param float $margin_right | padrão: 15
 * @param float $margin_top | padrão: 16
 * @param float $margin_bottom | padrão: 16
 * @param float $margin_header | padrão: 9
 * @param float $margin_footer | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */


$mPDF = new mpdf('', '', 0, '', 10, 10, 20, 10, 5, 11);


$header = "
<header>
    <div style=\" height: 120px; font-family:Arial\">
        <div style=\"width:33%; float:left; padding:5px; font-size:10px;\">
            <b><i>{$oInstit->getDescricao()}</i></b><br/>
            <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
            <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
            <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
            <i>{$oInstit->getSite()}</i>
        </div>
        <div style=\"width:25%; float:right\" class=\"box\">
            <b>Relatório Despesa Ensino - Anexo III</b><br/>
            <b>INSTITUIÇÕES:</b> ";
            foreach ($aInstits as $iInstit) {
                $oInstituicao = new Instituicao($iInstit);
                $header .= "(" . trim($oInstituicao->getCodigo()) . ") " . $oInstituicao->getDescricao() . " ";
            }
            $header .= "<br/> <b>PERÍODO:</b> {$DBtxt21} A {$DBtxt22} <br/>
        </div>
    </div>
</header>";

$footer = "
<footer>
    <div style='border-top:1px solid #000;width:100%;font-family:sans-serif;font-size:10px;height:10px;'>
        <div style='text-align:left;font-style:italic;width:90%;float:left;'>
            Financeiro>Contabilidade>Relatórios de Acompanhamento>Receita Despesa Ensino - Anexo III
            Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu"))  . "
        <div style='text-align:right;float:right;width:10%;'>
            {PAGENO}
        </div>
    </div>
</footer>";


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);
$mPDF->shrink_tables_to_fit = 1;

ob_start();
$nTotalReceitasRecebidasFundeb = 0;
$nContribuicaoFundeb = 0;

$nDevolucaoRecursoFundeb = 0;
$rsSlip = $clSlip->sql_record($clSlip->sql_query_fundeb($dtini, $dtfim, $instits));
$nDevolucaoRecursoFundeb = db_utils::fieldsMemory($rsSlip, 0)->k17_valor;

$nTransferenciaRecebidaFundeb = 0;
$aTransferenciasRecebidasFundeb = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417580111%'");
$nTransferenciaRecebidaFundeb = count($aTransferenciasRecebidasFundeb) > 0 ? $aTransferenciasRecebidasFundeb[0]->saldo_arrecadado_acumulado : 0;

$aTotalContribuicaoFundeb = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '495%'");
$nTotalContribuicaoFundeb = count($aTotalContribuicaoFundeb) > 0 ? $aTotalContribuicaoFundeb[0]->saldo_arrecadado_acumulado : 0;


$nTotalReceitasRecebidasFundeb = abs($nDevolucaoRecursoFundeb) + abs($nTransferenciaRecebidaFundeb);

$nResulatadoLiquidoTransfFundeb = $nTotalReceitasRecebidasFundeb+abs($nTotalContribuicaoFundeb);


$fSubTotal = 0;
$aSubFuncoes = array(122,272,271,361,365,366,367,843);
$sFuncao     = "12";
$aFonte      = array("'101'");
$aFonteFundeb      = array("'118','119'");

$sele_work = ' e60_instit in (' . $instits . ') ';
$sql_order = " order by o58_orgao, e60_anousu, e60_codemp::integer";
$sql_where_externo .= "  ";
$sql_where_externo .= ' and e60_anousu < ' . db_getsession("DB_anousu");
$sql_where_externo .= " and o15_codtri in ('')";
$sqlempresto = $clempresto->sql_rp_novo(db_getsession("DB_anousu"), $sele_work, $dtini, $dtfim, '', $sql_where_externo, "$sql_order ");
$res = $clempresto->sql_record($sqlempresto);
//db_criatabela($res);
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
    $total_rp_nproc += round($vlrpagnproc,2);
    $total_mov_pagmento += ($vlrpag+$vlrpagnproc);
  }

  if(($total_rp_proc + $total_rp_nproc) < $total_anterior || $total_mov_pagmento < $total_anterior){
    $iRestosAPagar = db_formatar(0,"f");
  }
  else{
    $iRestosAPagar = $total_mov_pagmento-$total_anterior;
  }

?>
<html>

<head>
    <style type="text/css">
        .ritz .waffle {
            color: inherit;
            font-family: 'Arial';
            font-size: 10px;
            width: 100%;
        }

        .title-relatorio {
            text-align: center;
            padding-top: 50px;
        }

        .tr-table{
            height:20px;
        }


        .body-relatorio {
            width: 100%;
            height: 80%;
        }


        .footer-row {
            height: 20px;
            background-color: #d8d8d8;
            width: 80%;
            border: 1px SOLID #000000;
            font-family: 'Arial';
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-top: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-total-row {
            height: 20px;
            background-color: #d8d8d8;
            width: 80%;
            border: 1px SOLID #000000;
            font-family: 'Arial';
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-total-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-top: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }


        .title-row {
            background-color: #ffffff;
            direction: ltr;
            padding: 2px 3px 2px 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .subtitle-2-row {
            background-color: #d8d8d8;
            direction: ltr;
            padding: 2px 3px 2px 3px;
            font-size: 10px;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            font-weight: bold;
        }
        .subtitle-4-row {
            background-color: #d8d8d8;
            direction: ltr;
            padding: 2px 3px 2px 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .subtitle-3-row {
            background-color: #d8d8d8;
            direction: ltr;
            padding: 2px 3px 2px 3px;
            font-size: 10px;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            font-weight: bold;
        }

        .subtitle-row {
            background-color: #d8d8d8;
            direction: ltr;
            border: 0.5px SOLID #000000;
            font-size: 10px;
            padding: 2px 3px 2px 3px;
            font-weight: bold;
        }

        .text-row {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-size: 10px;
            vertical-align: bottom;
            white-space: nowrap;
            padding: 2px 2px 2px 2px;
        }

        .ritz .waffle .clear {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="ritz " >
        <div class="title-relatorio">
            <strong>Anexo III</strong><br />
            <strong>Demonstrativo dos Gastos com Manutenção e Desenvolvimento do Ensino</strong><br />
            <strong> (Art. 212 da CR/88; EC nº53/06, Leis 9.394/96, 14.113/2020 e IN 05/2012)</strong><br /><br />
        </div>

        <div class="body-relatorio">
            <table class="waffle" width="600px" cellspacing="0" cellpadding="0" style="border: 1px #000" autosize="1">
                <tbody>
                    <tr>
                        <td class="title-row" colspan="5">I - DESPESAS</td>
                    </tr>
                    <tr>
                        <td class="subtitle-row" style="width: 300px;">FUNÇÃO / SUBFUNÇÃO/ PROGRAMA</td>
                        <td class="subtitle-row" style="text-align: center;">VALOR PAGO</td>
                        <td class="subtitle-row" style="text-align: center;">VALOR EMPENHADO E NÃO LIQUIDADO</td>
                        <td class="subtitle-row" style="text-align: center;">VALOR LIQUIDADO A PAGAR</td>
                        <td class="subtitle-row" style="width: 100px; text-align: center;">TOTAL</td>
                    </tr>
                    <tr>
                        <td class="subtitle-2-row" colspan="5">1 - EDUCAÇÃO 12 - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS (FONTE 101)</td>
                    </tr>
                    <?php
                    /**
                     * @todo loop de cada subfuncao
                     *
                     */

                    $nValorTotalPago = 0;
                    $nValorTotalEmpenhadoENaoLiquidado = 0;
                    $nValorTotalLiquidadoAPagar = 0;
                    $nValorTotalGeral = 0;
                    foreach ($aSubFuncoes as $iSubFuncao) {
                        $sDescrSubfuncao = db_utils::fieldsMemory(db_query("select o53_descr from orcsubfuncao where o53_codtri = '{$iSubFuncao}'"), 0)->o53_descr;

                        $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$sFuncao} and o58_subfuncao in ({$iSubFuncao}) and o15_codtri in (".implode(",",$aFonte).") and o58_instit in ($instits) group by 1,2");
                        $aDespesasSubFuncao = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$sFuncao} and o58_subfuncao in ({$iSubFuncao}) and o15_codtri in (".implode(",",$aFonte).") and o58_instit in ($instits) group by 1,2");
                        $nValorPagoSubFuncao = $aDespesasSubFuncao[0]->pago;
                        $nValorEmpenhadoENaoLiquidadoSubFuncao = $aDespesasSubFuncao[0]->empenhado - $aDespesasSubFuncao[0]->anulado - $aDespesasSubFuncao[0]->liquidado;
                        $nValorLiquidadoAPagarSubFuncao = $aDespesasSubFuncao[0]->liquidado - $aDespesasSubFuncao[0]->pago;
                        $nValorTotalSubFuncao = $nValorPagoSubFuncao + $nValorEmpenhadoENaoLiquidadoSubFuncao + $nValorLiquidadoAPagarSubFuncao;
                        if (count($aDespesasProgramas) > 0) {

                        ?>
                            <tr>
                                <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; width: 300px;"><?php echo db_formatar($iSubFuncao, 'subfuncao')." ".$sDescrSubfuncao ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorPagoSubFuncao, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorEmpenhadoENaoLiquidadoSubFuncao, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorLiquidadoAPagarSubFuncao, "f"); ?></td>
                                <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar($nValorTotalSubFuncao, "f"); ?></td>
                            </tr>
                        <?php
                        /**
                         * @todo para cada subfuncao lista os programas
                         */
                        foreach ($aDespesasProgramas as $oDespesaPrograma) {
                            $oPrograma = new Programa($oDespesaPrograma->o58_programa, $oDespesaPrograma->o58_anousu);
                            $fSubTotal += $oDespesaPrograma->pago;
                            $nValorPago = $oDespesaPrograma->pago;
                            $nValorEmpenhadoENaoLiquidado = $oDespesaPrograma->empenhado - $oDespesaPrograma->anulado - $oDespesaPrograma->liquidado;
                            $nValorLiquidadoAPagar = $oDespesaPrograma->liquidado - $oDespesaPrograma->pago;
                            $nValorTotal = $nValorPago + $nValorEmpenhadoENaoLiquidado + $nValorLiquidadoAPagar;

                            $nValorTotalPago += $nValorPago;
                            $nValorTotalEmpenhadoENaoLiquidado += $nValorEmpenhadoENaoLiquidado;
                            $nValorTotalLiquidadoAPagar += $nValorLiquidadoAPagar;
                            $nValorTotalGeral += $nValorTotal;
                            ?>
                             <tr>
                                <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; width: 300px;"><?php echo db_formatar($oPrograma->getCodigoPrograma(), "programa")." ".$oPrograma->getDescricao(); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorPago, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorEmpenhadoENaoLiquidado, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorLiquidadoAPagar, "f"); ?></td>
                                <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar($nValorTotal, "f"); ?></td>
                            </tr>
                        <?php }
                        ?>
                        <tr>
                            <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; width: 300px;">&nbsp;</td>
                            <td class="text-row"></td>
                            <td class="text-row"></td>
                            <td class="text-row"></td>
                            <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"></td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                    <tr>
                        <td class="subtitle-2-row" colspan="5">2 - EDUCAÇÃO 12 - FUNDEB (FONTES 118 e 119)</td>
                    </tr>
                    <?php
                    /**
                     * @todo loop de cada subfuncao
                     *
                     */

                    foreach ($aSubFuncoes as $iSubFuncao) {
                        $sDescrSubfuncao = db_utils::fieldsMemory(db_query("select o53_descr from orcsubfuncao where o53_codtri = '{$iSubFuncao}'"), 0)->o53_descr;

                        $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$sFuncao} and o58_subfuncao in ({$iSubFuncao}) and o15_codtri in (".implode(",",$aFonteFundeb).") and o58_instit in ($instits) group by 1,2");
                        $aDespesasSubFuncao = getSaldoDespesa(null, "o58_subfuncao, o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(empenhado),0) as empenhado, coalesce(sum(anulado),0) as anulado, coalesce(sum(liquidado),0) as liquidado", null, "o58_funcao = {$sFuncao} and o58_subfuncao in ({$iSubFuncao}) and o15_codtri in (".implode(",",$aFonteFundeb).") and o58_instit in ($instits) group by 1,2");
                        $nValorPagoSubFuncao = $aDespesasSubFuncao[0]->pago;
                        $nValorEmpenhadoENaoLiquidadoSubFuncao = $aDespesasSubFuncao[0]->empenhado - $aDespesasSubFuncao[0]->anulado - $aDespesasSubFuncao[0]->liquidado;
                        $nValorLiquidadoAPagarSubFuncao = $aDespesasSubFuncao[0]->liquidado - $aDespesasSubFuncao[0]->pago;
                        $nValorTotalSubFuncao = $nValorPagoSubFuncao + $nValorEmpenhadoENaoLiquidadoSubFuncao + $nValorLiquidadoAPagarSubFuncao;
                        if (count($aDespesasProgramas) > 0) {

                        ?>
                            <tr>
                                <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; width: 300px;"><?php echo db_formatar($iSubFuncao, 'subfuncao')." ".$sDescrSubfuncao ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorPagoSubFuncao, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorEmpenhadoENaoLiquidadoSubFuncao, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorLiquidadoAPagarSubFuncao, "f"); ?></td>
                                <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar($nValorTotalSubFuncao, "f"); ?></td>
                            </tr>
                        <?php
                        /**
                         * @todo para cada subfuncao lista os programas
                         */
                        foreach ($aDespesasProgramas as $oDespesaPrograma) {
                            $oPrograma = new Programa($oDespesaPrograma->o58_programa, $oDespesaPrograma->o58_anousu);
                            $nValorPago = $oDespesaPrograma->pago;
                            $nValorEmpenhadoENaoLiquidado = $oDespesaPrograma->empenhado - $oDespesaPrograma->anulado - $oDespesaPrograma->liquidado;
                            $nValorLiquidadoAPagar = $oDespesaPrograma->liquidado - $oDespesaPrograma->pago;
                            $nValorTotal = $nValorPago + $nValorEmpenhadoENaoLiquidado + $nValorLiquidadoAPagar;
                            $nValorTotalPago += $nValorPago;
                            $nValorTotalEmpenhadoENaoLiquidado += $nValorEmpenhadoENaoLiquidado;
                            $nValorTotalLiquidadoAPagar += $nValorLiquidadoAPagar;
                            $nValorTotalGeral += $nValorTotal;
                            ?>
                             <tr>
                                <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; width: 300px;"><?php echo db_formatar($oPrograma->getCodigoPrograma(), "programa")." ".$oPrograma->getDescricao(); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorPago, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorEmpenhadoENaoLiquidado, "f"); ?></td>
                                <td class="text-row" style="text-align: right; "><?php echo db_formatar($nValorLiquidadoAPagar, "f"); ?></td>
                                <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar($nValorTotal, "f"); ?></td>
                            </tr>
                        <?php }
                        ?>
                            <tr>
                                <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; width: 300px;">&nbsp;</td>
                                <td class="text-row"></td>
                                <td class="text-row"></td>
                                <td class="text-row"></td>
                                <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"></td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    <tr>
                        <td class="subtitle-row" style="width: 300px;">3 - TOTAL DESPESAS (1 + 2)</td>
                        <td class="subtitle-row" style="text-align: center;"><?php echo db_formatar($nValorTotalPago, "f"); ?></td>
                        <td class="subtitle-row" style="text-align: center;"><?php echo db_formatar($nValorTotalEmpenhadoENaoLiquidado, "f"); ?></td>
                        <td class="subtitle-row" style="text-align: center;"><?php echo db_formatar($nValorTotalLiquidadoAPagar, "f"); ?></td>
                        <td class="subtitle-row" style="width: 100px; text-align: center;"><?php echo db_formatar($nValorTotalGeral, "f"); ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="waffle" width="600px" cellspacing="0" cellpadding="0" style="border: 1px #000; margin-top: 20px;" autosize="1">
                <tbody>
                    <tr>
                        <td class="title-row" >II - TOTAL DA APLICAÇÃO NO ENSINO</td>
                    </tr>
                    <tr>
                        <td class="subtitle-row" style="width: 300px; text-align: center;">DESCRIÇÃO</td>
                        <td class="subtitle-row" style="width: 100px; text-align: center;">VALOR</td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000;">4 - VALOR PAGO </td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar($nValorTotalPago, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000;">5 - RESULTADO LÍQUIDO DAS TRANSFERÊNCIAS DO FUNDEB</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(abs($nResulatadoLiquidoTransfFundeb), "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000;">6 - DESPESAS CUSTEADAS COM SUPERÁVIT DO FUNDEB ATÉ O PRIMEIRO QUADRIMESTRE - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000;">7 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(0.00, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">7.1 - RECURSOS DE IMPOSTOS</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(0.00, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">7.2 - RECURSOS DO FUNDEB</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(0.00, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000;">8 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE FINANCEIRA</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(0.00, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">8.1 - RECURSOS DE IMPOSTOS (7.1 - 16.1)</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(0.00, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">8.2 - RECURSOS DO FUNDEB (7.2 - 16.2)</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(0.00, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000;">9 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE FINANCEIRA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932.736)</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">9.1 - RECURSOS DE IMPOSTOS</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">9.2 - RECURSOS DO FUNDEB</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000;">10 - CANCELAMENTO, NO EXERCÍCIO, DE RESTOS A PAGAR INSCRITOS COM DISPONIBILIDADE FINANCEIRA</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">10.1 - RECURSOS DE IMPOSTOS</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: left; border-left: 1px SOLID #000000; padding-left: 20px;">10.2 - RECURSOS DO FUNDEB</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="subtitle-row" style="width: 300px;">11 - TOTAL APLICADO ((4 + 6 + 7 +9) - ( 5 + 8 + 10))</td>
                        <td class="subtitle-row" style="width: 100px; text-align: center;"><?php echo db_formatar(120000000.40, "f"); ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="body-relatorio" style="padding-top: 1px;">
            <table class="waffle" width="600px" cellspacing="0" cellpadding="0" style="border: 1px #000; margin-top: 30px;" autosize="1">
                <tbody>
                    <tr>
                        <td class="title-row" >IV - RESULTADO LÍQUIDO DAS TRANSFERÊNCIAS DO FUNDEB</td>
                    </tr>
                    <tr>
                        <td class="subtitle-row" style="width: 300px; text-align: center;">DESCRIÇÃO</td>
                        <td class="subtitle-row" style="width: 100px; text-align: center;">VALOR</td>
                    </tr>
                    <tr>
                        <td class="subtitle-4-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px;">17 - RECEITAS RECEBIDAS DO FUNDEB NO EXERCÍCIO</td>
                        <td class="subtitle-4-row" style="text-align: right; border-right: 1px SOLID #000000;">
                            <?php echo db_formatar(abs($nTotalReceitasRecebidasFundeb), "f");?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px; padding-left: 20px;">17.1 - TRANSFERÊNCIAS DE RECURSOS DO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO <br/>DOS  PROFISSIONAIS DA EDUCAÇÃO  - FUNDEB  (NR 1.7.5.8.01.1.1 )</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar($nTransferenciaRecebidaFundeb, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px; padding-left: 20px;">17.2 - DEVOLUÇÃO DE RECURSOS DO FUNDEB, RECEBIDOS EM ATRASOS, PARA AS CONTAS DE ORIGEM DOS RECURSOS (CONSULTA 1.047.710)</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php echo db_formatar($nDevolucaoRecursoFundeb, "f"); ?></td>
                    </tr>
                    <tr>
                        <td class="subtitle-4-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px;">18 - CONTRIBUIÇÃO AO FUNDEB (LEI Nº 14.113/2020) </td>
                        <td class="subtitle-4-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php
                            echo db_formatar(abs($nTotalContribuicaoFundeb), "f");
                        ?></td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px; padding-left: 20px;">18.1 - COTA-PARTE FPM</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php
                            $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4951718012101%'");
                            $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
                            $nContribuicaoFundeb += abs($nReceita);
                            echo db_formatar(abs($nReceita), "f"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px; padding-left: 20px;">18.2 - COTA-PARTE ICMS</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php
                            $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4951728011101%'");
                            $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
                            $nContribuicaoFundeb += abs($nReceita);
                            echo db_formatar(abs($nReceita), "f"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px; padding-left: 20px;">18.3 - COTA-PARTE IPI - EXPORTAÇÃO</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php
                            $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4951728013101%'");
                            $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
                            $nContribuicaoFundeb += abs($nReceita);
                            echo db_formatar(abs($nReceita), "f"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px; padding-left: 20px;">18.4 - COTA-PARTE ITR</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php
                            $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4951718015101%'");
                            $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
                            $nContribuicaoFundeb += abs($nReceita);
                            echo db_formatar(abs($nReceita), "f"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-row" style="text-align: lefth; border-left: 1px SOLID #000000; width: 300px; padding-left: 20px;">18.5 - COTA-PARTE IPVA</td>
                        <td class="text-row" style="text-align: right; border-right: 1px SOLID #000000;"><?php
                            $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '4951728012101%'");
                            $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
                            $nContribuicaoFundeb += abs($nReceita);
                            echo db_formatar(abs($nReceita), "f"); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="subtitle-row" style="width: 300px;">19 - TOTAL DO RESULTADO LÍQUIDO DAS TRANSFERÊNCIAS DO FUNDEB ( 17 - 18 )</td>
                        <td class="subtitle-row" style="width: 100px; text-align: right;">
                        <?php echo db_formatar(abs($nContribuicaoFundeb+$nTotalReceitasRecebidasFundeb), "f"); ?></td>
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
//echo $html;

$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

/* ---- */


db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");

db_fim_transacao();
