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
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
require_once("classes/db_cgm_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");
include("libs/db_sql.php");
require("vendor/mpdf/mpdf/mpdf.php");

$clselorcdotacao = new cl_selorcdotacao();
$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
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

/**
 * pego todas as instituições;
 */
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
$rsInstits = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_instit, si09_tipoinstit", null, null));

$ainstitunticoes = array();
for ($i = 0; $i < pg_num_rows($rsInstits); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsInstits, $i);
    $ainstitunticoes[] = $odadosInstint->si09_instit;
}
$iInstituicoes = implode(',', $ainstitunticoes);

$rsTipoinstit = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_sequencial, si09_tipoinstit", null, "si09_instit in( {$instits})"));

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

$db_filtro = " o70_instit in({$instits}) ";
$anousu = db_getsession("DB_anousu");

$aFontes      = array("'118','119'");
$aFontesComplemento      = array("'166','167'");
$aTodasFontes = array("'118','119','166','167'");
$sWhereReceita      = "o70_instit in ({$instits})";
$sWhereReceita      .= " and o70_codigo in ( select o15_codigo from orctiporec where o15_codtri in (".implode(",",$aTodasFontes).") )";
$rsReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anousu, $dtini, $dtfim, false, ' * ', true, 0);
$aReceitas = db_utils::getColectionByRecord($rsReceitas);
db_query("drop table if exists work_receita");
criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);

$aReceitasImpostos = array(
    array('1 - FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS', 'title', '', '', ''),
    array('1.1 - TRANSFERÊNCIAS DE RECURSOS DO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS  PROFISSIONAIS DA EDUCAÇÃO  - FUNDEB  (NR 1.7.5.8.01.1.1 )', 'text', '417580111%', '', '118','119'),
    array('1.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 + NR 1.3.2.1.00.5.1 )', 'text', '413210011%', '413210051%', '118','119'),
    array('2 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT', 'title', '',''),
    array('2.1 - TRANSFERÊNCIAS DE RECURSOS DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS PROFISISONAIS DA EDUCAÇÃO - FUNDEB (VAAT) (NR 1.7.1.8.09.1.1 )', 'text', '417580111%', '', '166','167'),
    array('2.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 + NR 1.3.2.1.00.5.1 )', 'text', '413210011%', '413210051%', '166','167'),
);

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

$mPDF = new mpdf('', '', 0, '', 15, 15, 20, 15, 5, 11);

$header = " <header>
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

$footer = "<footer>
                <div style='border-top:1px solid #000;width:100%;font-family:sans-serif;font-size:10px;height:10px;'>
                    <div style='text-align:left;font-style:italic;width:90%;float:left;'>
                        Financeiro>Contabilidade>Relatórios de Acompanhamento>Fundeb - Anexo VIII
                        Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu"))  . "
                    <div style='text-align:right;float:right;width:10%;'>
                        {PAGENO}
                    </div>
                </div>
          </footer>";

$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

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
    <div class="ritz">
        <div class="title-relatorio">
            <strong>Anexo VIII</strong><br />
            <strong>Fundo Manutenção e Desenvolvimento da Educação Básica e de Valorização Dos Profissionais da Educação - FUNDEB</strong><br />
            <strong> (Art. 212 - A DA CR/88, LEIS 9.394/96, 14.113/2020 E IN 05/2012) </strong><br /><br />
        </div>
        <div class="body-relatorio">
            <table class="waffle" width="600px" cellspacing="0" cellpadding="0" style="border: 1px #000; margin-top: 20px;" autosize="1">
                    <tbody>
                        <tr>
                            <td class="title-row" >I - RECURSOS</td>
                        </tr>
                        <tr>
                            <td class="subtitle-row" style="width: 300px; text-align: center;">NATUREZA RECEITA</td>
                            <td class="subtitle-row" style="width: 100px; text-align: center;">VALOR</td>
                        </tr>
                        <?php
                            $nTotalReceita = 0;
                            foreach ($aReceitasImpostos as $receita) {
                                echo "<tr style='height:20px;'>";
                                echo "<td class='{$receita[1]}-row' colspan='8'>{$receita[0]}</td>";
                                echo "    <td class='{$receita[1]}-row-valor'>";
                                $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '{$receita[2]}'");
                                $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;

                                $nReceitaSecundaria = 0;
                                if($receita[3] != ''){
                                    $aReceitasSecundaria = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '{$receita[3]}'");
                                    $nReceitaSecundaria = count($aReceitasSecundaria) > 0 ? $aReceitasSecundaria[0]->saldo_arrecadado_acumulado : 0;
                                }
                                $nTotalReceita = $nReceita + $nReceitaSecundaria;
                                //$receita[1] == 'subtitle' ? $nTotalReceitaImpostos += $nTotalReceita : $nTotalReceitaImpostos += 0;
                                if ($receita[1] == 'title') {
                                    echo "";
                                } else {
                                    echo db_formatar(abs($nTotalReceita), "f");
                                }
                                echo "    </td>";
                                echo " </tr>";
                            }
                        ?>
                        <tr>
                            <td class="subtitle-row" style="width: 300px;">3 - TOTAL ( 1 - 2 )</td>
                            <td class="subtitle-row" style="width: 100px; text-align: right;">
                            <?php echo db_formatar(100292.00, "f"); ?></td>
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
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();


db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");

db_fim_transacao();

?>
