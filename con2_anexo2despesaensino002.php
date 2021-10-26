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


// $sWhereReceita      = "o70_instit in ({$instits})";
// $rsReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anousu, $dtini, $dtfim, false, ' * ', true, 0);
// $aReceitas = db_utils::getColectionByRecord($rsReceitas);
// db_query("drop table if exists work_receita");
// criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);


//$result = db_planocontassaldo_matriz(db_getsession("DB_anousu"),($DBtxt21_ano.'-'.$DBtxt21_mes.'-'.$DBtxt21_dia),$dtfim,false,$where);


//echo "<pre>";print_r($relatorioReceitas);exit;


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
    <div style=\"font-family:Arial\">
        <div style=\"width:33%;float:left;padding:5px;font-size:10px;\">
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
?>
<html>

<head>
    <style type="text/css">
        .ritz .waffle a {
            color: inherit;
            font-family: 'Arial';
            font-size: 12px;
            width: 100%;
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
            font-size: 10px;
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
            font-size: 10px;
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

        .title-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .subtitle-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .text-row-valor {
            height: 20px;
            background-color: #ffffff;
            width: 20%;
            font-family: 'Arial', Calibre;
            border-right: 1px SOLID #000000;
            font-size: 10px;
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
            font-size: 10px;
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
            font-size: 10px;
            padding: 2px 3px 2px 30px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .text-row {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 60px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
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
            <br/>
            <strong>Anexo III</strong><br />
            <strong>Demonstrativo dos Gastos com Manutenção e Desenvolvimento do Ensino</strong><br />
            <strong> (Art. 212 da CR/88; EC nº53/06, Leis 9.394/96, 14.113/2020 e IN 05/2012)</strong><br /><br />
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
