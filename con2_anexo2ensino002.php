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
require_once("classes/db_infocomplementaresinstit_classe.php");
$clrotulo = new rotulocampo;

db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$clinfocomplementaresinstit = new cl_infocomplementaresinstit();

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


$sWhereReceita      = "o70_instit in ({$instits})";
// $oReceitas = db_receitasaldo(11,1,3,true,$sWhereReceita,$anousu,$dtini, $dtfim,false,' * ',true,0);
// $aReceitas = db_utils::getColectionByRecord($oReceitas);

// ini_set('display_errors', 'On');
// error_reporting(E_ALL);





// db_query("drop table if exists work_receita");
// criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);


// $result = db_planocontassaldo_matriz(db_getsession("DB_anousu"),($DBtxt21_ano.'-'.$DBtxt21_mes.'-'.$DBtxt21_dia),$dtfim,false,$where);



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


$mPDF = new mpdf('', 'A4', 0, '', 15, 15, 23.5, 15, 5, 11);


$header = "
<header>
    <div style=\"font-family:Arial\">
        <div style=\"width:33%;float:left;padding:5px;font-size:10px;\">
            <b><i>{$oInstit->getDescricao()}</i></b><br/>
            <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
            <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
            <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
            <i>{$oInstit->getSite()}</i>
        </div>
        <div style=\"width:25%; float:right\" class=\"box\">
            <b>Relatório Ensino - Anexo II</b><br/>
            <b>INSTITUIÇÕES:</b> ";
foreach ($aInstits as $iInstit) {
    $oInstituicao = new Instituicao($iInstit);
    $header .= "(" . trim($oInstituicao->getCodigo()) . ") " . $oInstituicao->getDescricao() . " ";
}
$header .= "<br/> <b>PERÍODO:</b> {$dtini} A {$dtfim} <br/>
        </div>
    </div>
</header>";

$footer = "
<footer>
    <div style='border-top:1px solid #000;width:100%;font-family:sans-serif;font-size:10px;height:10px;'>
        <div style='text-align:left;font-style:italic;width:90%;float:left;'>
            Financeiro>Contabilidade>Relatórios de Acompanhamento>Receita Ensino - Anexo II
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
        .ritz .waffle a {
            color: inherit;
            font-family: 'Arial';
            font-size: 12px;
        }
        .title-relatorio {
            text-align: center;
        }
        .th-receita {
            height: 20px;
            background-color: #d8d8d8;
            width: 80%;
            border: 1px SOLID #000000;
            font-family: 'Arial';
            font-size: 12pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }
        .th-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-top: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 12pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-row {
            height: 20px;
            background-color: #d8d8d8;
            width: 80%;
            border: 1px SOLID #000000;
            font-family: 'Arial';
            font-size: 11pt;
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
            font-size: 11pt;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .title-row-valor{
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 12pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }
        .subtitle-row-valor{
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 12pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .table-row-valor{
            height: 20px;
            background-color: #ffffff;
            width: 20%;
            font-family: 'Arial', Calibre;
            border-right: 1px SOLID #000000;
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }
        .ritz .title-row {
            background-color: #d8d8d8;
            color: #000000;
            direction: ltr;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 11pt;
            padding: 2px 3px 2px 3px;
            text-align: left;
        }

        .ritz .subtitle-row {
            background-color: #d8d8d8;
            color: #000000;
            direction: ltr;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 11pt;
            padding: 2px 3px 2px 30px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .table-row {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 11pt;
            padding: 2px 3px 2px 60px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="ritz grid-container" dir="ltr">
        <br />
        <div class="title-relatorio">
            <strong>Anexo II</strong><br />
            <strong>Demonstrativo das Receitas e Despesas com Manutenção e Desenvolvimento do Ensino</strong><br />
            <strong>(Art.212 da C.F; Emenda Constitucional nº 53/06, leis nº 9.394/96 e 11.494/07)</strong><br /><br />
        </div>
        <table class="waffle" cellspacing="0" cellpadding="0" style="border: 1px #000">
            <thead>
                <tr>
                    <th class="th-receita" colspan="8">Receitas</th>
                    <th class="th-valor">Valor</th>
                </tr>
            </thead>
            <tbody>
                <tr style='height:20px;'>
                    <td class="title-row" colspan="8">01 - Receitas de Impostos </td>
                    <td class="title-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <!-- 1.1 - Receita resultante do Imposto sobre a Propriedade Predial e Territorial Urbana (IPTU) -->
                <tr style='height:20px;'>
                    <td class="subtitle-row" colspan="8">1.1 - Receita resultante do Imposto sobre a Propriedade Predial e Territorial Urbana (IPTU)</td>
                    <td class="subtitle-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">11120101 - Imposto s/a Propriedade Territorial Rural - Munic.Conv.</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">11120101 - Imposto s/a Propriedade Territorial Rural - Munic.Conv.</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">11120101 - Imposto s/a Propriedade Territorial Rural - Munic.Conv.</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <!-- 1.2 - Receita resultante do Imposto sobre Transmissão Inter Vivos (ITBI) -->
                <tr style='height:20px;'>
                    <td class="subtitle-row" colspan="8">1.2 - Receita resultante do Imposto sobre Transmissão Inter Vivos (ITBI)</td>
                    <td class="subtitle-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">111208 - Imposto sobre Transmissão "Inter Vivos" de Bens Imóveis e de Direitos Reais sobre Imóveis</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">111208 - Imposto sobre Transmissão "Inter Vivos" de Bens Imóveis e de Direitos Reais sobre Imóveis</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">111208 - Imposto sobre Transmissão "Inter Vivos" de Bens Imóveis e de Direitos Reais sobre Imóveis</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>

                <!-- 1.3 - Receita resultante do Imposto sobre Serviços de Qualquer Natureza (ISS) -->
                <tr style='height:20px;'>
                    <td class="subtitle-row" colspan="8">1.3 - Receita resultante do Imposto sobre Serviços de Qualquer Natureza (ISS)</td>
                    <td class="subtitle-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">1113.05.01 - Imposto sobre Serviços de Qualquer Natureza</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">1113.05.01 - Imposto sobre Serviços de Qualquer Natureza</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">1113.05.01 - Imposto sobre Serviços de Qualquer Natureza</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>


                <!-- 1.5 - Receita resultante do Imposto Territorial Rural (ITR) (CF, ART. 153, §4º, inciso III) -->
                <tr style='height:20px;'>
                    <td class="subtitle-row" colspan="8">1.5 - Receita resultante do Imposto Territorial Rural (ITR) (CF, ART. 153, §4º, inciso III)</td>
                    <td class="subtitle-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">1112.01.01 ? Imposto sobre a Propriedade Territorial Rural ? Municípios Conveniados</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">1112.01.01 ? Imposto sobre a Propriedade Territorial Rural ? Municípios Conveniados</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="table-row" colspan="8">1112.01.01 ? Imposto sobre a Propriedade Territorial Rural ? Municípios Conveniados</td>
                    <td class="table-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="footer-row" colspan="8">Subtotal</td>
                    <td class="footer-row-valor"><?php echo db_formatar("12000.00", "f"); ?></td>
                </tr>
            </tbody>
        </table>
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
