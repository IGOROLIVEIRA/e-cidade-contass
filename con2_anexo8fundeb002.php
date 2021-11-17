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
require_once("classes/db_slip_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");
include("libs/db_sql.php");
require("vendor/mpdf/mpdf/mpdf.php");

$clselorcdotacao = new cl_selorcdotacao();
$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
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

$aSubFuncoes = array(122, 272, 271, 361, 365, 366, 367, 843);
$sFuncao     = "12";
$aFonte      = array("'101','201'");

$aReceitasImpostos = array(
    array('1 - FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS', 'title', array('413210011%', '413210051%', '417580111%'), "'118','119'"),
    array('1.1 - TRANSFERÊNCIAS DE RECURSOS DO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS  PROFISSIONAIS DA EDUCAÇÃO  - FUNDEB  (NR 1.7.5.8.01.1.1 )', 'text', array('417580111%'), "'118','119'"),
    array('1.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 + NR 1.3.2.1.00.5.1 )', 'text', array('413210011%', '413210051%'), "'118','119'"),
    array('2 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT', 'title', array('413210011%', '413210051%', '417580111%'), "'166','167'"),
    array('2.1 - TRANSFERÊNCIAS DE RECURSOS DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS PROFISISONAIS DA EDUCAÇÃO - FUNDEB (VAAT) (NR 1.7.1.8.09.1.1 )', 'text', array('417180911%'), "'166','167'"),
    array('2.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 + NR 1.3.2.1.00.5.1 )', 'text', array('413210011%', '413210051%'), "'166','167'"),
);

function getValorNaturezaReceita($aNaturecaReceita, $aFontes, $anoUsu, $dtIni, $dtFim, $instits)
{
    $nReceitaTotal = 0;
    $sWhereReceita      = " o70_instit in ({$instits}) ";
    $sWhereReceita      .= " and o70_codigo in ( select o15_codigo from orctiporec where o15_codtri in ({$aFontes}) )";
    $rsReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anoUsu, $dtIni, $dtFim, false, ' * ', true, 0);
    $aReceitas = db_utils::getColectionByRecord($rsReceitas);
    db_query("drop table if exists work_receita");
    criarWorkReceita($sWhereReceita, array($anoUsu), $dtIni, $dtFim);
    foreach ($aNaturecaReceita as $sNatureza) {
        $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '{$sNatureza}'");
        $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
        $nReceitaTotal = $nReceitaTotal + $nReceita;
    }

    db_query("drop table if exists work_receita");
    return $nReceitaTotal;
}

function getDevolucaoRecursoFundeb($dtIni, $dtFim, $aInstits)
{
    $clSlip = new cl_slip();
    $nDevolucaoRecursoFundeb = 0;
    $rsSlip = $clSlip->sql_record($clSlip->sql_query_fundeb($dtIni, $dtFim, $aInstits));
    $nDevolucaoRecursoFundeb = db_utils::fieldsMemory($rsSlip, 0)->k17_valor;
    return $nDevolucaoRecursoFundeb;
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
        .ritz .waffle a {
            color: inherit;
        }

        .ritz .waffle .s16 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s32 {
            border-left: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s27 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
        }

        .ritz .waffle .s41 {
            border-bottom: 1px SOLID #808080;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s2 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s45 {
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s25 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s29 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s18 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s9 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s1 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s0 {
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s38 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s43 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: right;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s28 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s6 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s3 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s26 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s23 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s13 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s7 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s15 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s44 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s17 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s11 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s42 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s34 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s12 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s40 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s30 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #808080;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s47 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s35 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s8 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s31 {
            border-right: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s48 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s10 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s36 {
            border-right: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s14 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: right;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s19 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s21 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s22 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s37 {
            border-left: none;
            border-bottom: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s5 {
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s20 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s39 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s33 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: top;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s24 {
            border-bottom: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: 'Arial', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s4 {
            border-right: 1px SOLID #000000;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }

        .ritz .waffle .s46 {
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'Arial';
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }
        .body-relatorio {
            width: 100%;
            height: 80%;
        }
    </style>
</head>

<body>
    <div>
        <div class="title-relatorio">
            <p><strong>Anexo VIII</strong></p>
            <p><strong>Fundo Manutenção e Desenvolvimento da Educação Básica e de Valorização Dos Profissionais da Educação - FUNDEB</strong></p>
            <p><strong> (Art. 212 - A DA CR/88, LEIS 9.394/96, 14.113/2020 E IN 05/2012) </strong></p>
        </div>
        <div class="body-relatorio">
            <!-- <table class="waffle" width="600px" cellspacing="0" cellpadding="0" style="border: 1px #000" autosize="1">
                    <thead>
                        <tr>
                            <th id="0C0" style="width:100%"  class="column-headers-background">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title-topo-row">I - RECURSOS</td>
                        </tr>
                        <tr>
                            <td class="th-receita">NATUREZA RECEITA</td>
                            <td class="th-valor">VALOR</td>
                        </tr>
                        <?php
                        $nTotalReceitaRecurso = 0;
                        foreach ($aReceitasImpostos as $receita) {
                            echo "<tr>";
                            echo "<td class='{$receita[1]}-row'>{$receita[0]}</td>";
                            echo "<td class='{$receita[1]}-row-valor'> ";
                            $nReceita = getValorNaturezaReceita($receita[2], $receita[3], $anousu, $dtini, $dtfim, $instits);
                            if ($receita[1] == 'title') {
                                $nTotalReceitaRecurso += $nReceita;
                            }
                            echo db_formatar(abs($nReceita), "f");
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                        <tr>
                            <td class="title-footer-row">3 - TOTAL ( 1 - 2 )</td>
                            <td class="title-footer-row-valor">
                                <?php echo db_formatar($nTotalReceitaRecurso, "f"); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-footer-row">4 - DEVOLUÇÃO DE RECURSOS DO FUNDEB, RECEBIDOS EM ATRASO, PARA AS CONTAS DE ORIGEM DOS RECURSOS (CONSULTA 1047710)</td>
                                <td class="title-footer-row-valor">
                                    <?php
                                    $nDevolucaoFundeb = getDevolucaoRecursoFundeb($dtini, $dtfim, $aInstits);
                                    echo db_formatar($nDevolucaoFundeb, "f");
                                    ?>
                                </td>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-footer-row">5 - RECEITA TOTAL (3 - 4)</td>
                                <td class="title-footer-row-valor">
                                    <?php
                                    echo db_formatar($nTotalReceitaRecurso - $nDevolucaoFundeb, "f");
                                    ?>
                                </td>
                            </td>
                        </tr>
                    </tbody>
            </table> -->
            <div class="ritz grid-container" dir="ltr">
                <table class="waffle no-grid" cellspacing="0" cellpadding="0">
                    <tr style="height: 20px">
                        <td class="s0" dir="ltr"></td>
                        <td class="s1" dir="ltr">I - RECURSOS</td>
                        <td class="s1" dir="ltr"></td>
                        <td class="s1" dir="ltr"></td>
                        <td class="s1" dir="ltr"></td>
                        <td class="s1" dir="ltr"></td>
                        <td class="s1" dir="ltr"></td>
                        <td class="s1" dir="ltr"></td>
                        <td class="s1" dir="ltr"></td>
                        <td class="s1" dir="ltr"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr" colspan="8">NATUREZA DA RECEITA</td>
                        <td class="s3" dir="ltr">VALOR</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s5" dir="ltr" colspan="8">1 - FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS</td>
                        <td class="s6" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s7" dir="ltr"></td>
                        <td class="s7" dir="ltr" colspan="8">1.1 - TRANSFERÊNCIAS DE RECURSOS DO FUNDO DE MANUTENÇÃO E
                            DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS PROFISSIONAIS DA EDUCAÇÃO - FUNDEB
                            (NR 1.7.5.8.01.1.1 )</td>
                        <td class="s8" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="8">1.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 + NR
                            1.3.2.1.00.5.1 )</td>
                        <td class="s8" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s5" dir="ltr" colspan="8">2 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT</td>
                        <td class="s6" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s10" dir="ltr"></td>
                        <td class="s10" dir="ltr" colspan="8">2.1 - TRANSFERÊNCIAS DE RECURSOS DA COMPLEMENTAÇÃO DA UNIÃO AO
                            FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO DOS PROFISISONAIS
                            DA EDUCAÇÃO - FUNDEB (VAAT) (NR 1.7.1.8.09.1.1 )</td>
                        <td class="s8" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s11" dir="ltr" colspan="8">2.2 - RENDIMENTOS DE APLICAÇÃO FINANCEIRA (NR 1.3.2.1.00.1.1 +
                            NR 1.3.2.1.00.5.1 )</td>
                        <td class="s12" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="8">3 - TOTAL (1 + 2)</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="8">4 - DEVOLUÇÃO DE RECURSOS DO FUNDEB, RECEBIDOS EM ATRASO, PARA
                            AS CONTAS DE ORIGEM DOS RECURSOS (CONSULTA 1047710)</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="8">5 - RECEITA TOTAL (3 - 4)</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s0" dir="ltr"></td>
                        <td class="s1" dir="ltr" colspan="9">II - APLICAÇÃO DA EDUCAÇÃO BÁSICA</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr" colspan="5" rowspan="2">FUNÇÃO / SUBFUNÇÃO / PROGRAMA</td>
                        <td class="s16" dir="ltr" colspan="2">DESPESAS CUSTEADAS COM RECURSOS FUNDEB - IMPOSTOS E
                            TRANSFERÊNCIAS DE IMPOSTOS</td>
                        <td class="s16" dir="ltr" colspan="2">DESPESAS CUSTEADAS COM RECURSOS FUNDEB - COMPLEMENTAÇÃO DA
                            UNIÃO - VAAT</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr">118</td>
                        <td class="s3" dir="ltr">119</td>
                        <td class="s3" dir="ltr">166</td>
                        <td class="s3" dir="ltr">167</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s17" dir="ltr" colspan="5">EDUCAÇÃO</td>
                        <td class="s18" dir="ltr">1,00</td>
                        <td class="s18" dir="ltr">1,00</td>
                        <td class="s18" dir="ltr">1,00</td>
                        <td class="s18" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s7" dir="ltr"></td>
                        <td class="s7" dir="ltr" colspan="5">272 - PREVIDÊNCIA DO REGIME ESTATUTÁRIO (trazer aqui a listagem
                            das subfunções com valor pago na função 12, de acordo com a fonte de cada coluna)</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s7" dir="ltr"></td>
                        <td class="s7" dir="ltr" colspan="5">0000 - OPERAÇÃO ESPECIAL (trazer aqui os programas dentro das
                            subfunções com VALOR PAGO de acordo com a fonte de cada coluna))</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s20" dir="ltr"></td>
                        <td class="s21" dir="ltr" colspan="3">361 - ENSINO FUNDAMENTAL (subfunções, exemplo)</td>
                        <td class="s15"></td>
                        <td class="s22"></td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s20" dir="ltr"></td>
                        <td class="s23" dir="ltr" colspan="3">0002 - JF + EDUCAÇÃO (programas exemplo)</td>
                        <td class="s24"></td>
                        <td class="s25"></td>
                        <td class="s26" dir="ltr">1,00</td>
                        <td class="s26" dir="ltr">1,00</td>
                        <td class="s26" dir="ltr">1,00</td>
                        <td class="s26" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="5">6 - SUBTOTAL VALOR PAGO</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s27"></td>
                        <td class="s28" colspan="9"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s27"></td>
                        <td class="s29" colspan="5"></td>
                        <td class="s30" dir="ltr">INSCRITAS NA FONTE 118</td>
                        <td class="s31" dir="ltr">INSCRITAS NA FONTE 119</td>
                        <td class="s32 softmerge" dir="ltr">
                            <div class="softmerge-inner" style="width:152px;left:-3px">INSCRITAS NA FONTE 166</div>
                        </td>
                        <td class="s3" dir="ltr">INSCRITAS NA FONTE 167</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s20" dir="ltr"></td>
                        <td class="s20" dir="ltr" colspan="5">7 - RESTOS A PAGAR PROCESSADOS DO EXERCÍCIO</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                        <td class="s19" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s20" dir="ltr"></td>
                        <td class="s33" dir="ltr" colspan="5">8 - RESTOS A PAGAR NÃO PROCESSADOS DO EXERCÍCIO</td>
                        <td class="s34" dir="ltr">1,00</td>
                        <td class="s34" dir="ltr">1,00</td>
                        <td class="s34" dir="ltr">1,00</td>
                        <td class="s34" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="5">9 - SUBTOTAL RESTOS A PAGAR (7 + 8)</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="5">10 - TOTAL (6 + 9)</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s22"></td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                        <td class="s25"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s27"></td>
                        <td class="s35" colspan="5"></td>
                        <td class="s36" dir="ltr">INSCRITOS NA FONTE 118 (A)</td>
                        <td class="s37 softmerge" dir="ltr">
                            <div class="softmerge-inner" style="width:182px;left:-3px">INSCRITOS NA FONTE 119 (B)</div>
                        </td>
                        <td class="s38" dir="ltr">INSCRITOS NA FONTE 166 (D)</td>
                        <td class="s38" dir="ltr">INSCRITOS NA FONTE 167 (E)</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="5">11 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE
                            FINANCEIRA</td>
                        <td class="s18" dir="ltr">1,00</td>
                        <td class="s18" dir="ltr">1,00</td>
                        <td class="s18" dir="ltr">1,00</td>
                        <td class="s18" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s7" dir="ltr"></td>
                        <td class="s39" dir="ltr" colspan="5">12 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE
                            FINANCEIRA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932736)</td>
                        <td class="s40" dir="ltr">1,00</td>
                        <td class="s41" dir="ltr">1,00</td>
                        <td class="s34" dir="ltr">1,00</td>
                        <td class="s41" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s42" dir="ltr" colspan="5">13 - TOTAL (10 - 11 + 12)</td>
                        <td class="s43" dir="ltr">1,00</td>
                        <td class="s43" dir="ltr">1,00</td>
                        <td class="s43" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="body-relatorio">
            <div class="ritz grid-container" dir="ltr">
                <table class="waffle no-grid" cellspacing="0" cellpadding="0">
                    <tr style="height: 20px">
                        <td class="s0" dir="ltr"></td>
                        <td class="s1" dir="ltr" colspan="9">III - GASTOS COM PROFISSIONAIS DA EDUCAÇÃO BÁSICA EM EFETIVO
                            EXERCÍCIO</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr" colspan="7">DESCRIÇÃO</td>
                        <td class="s3" dir="ltr">NO EXERCÍCIO</td>
                        <td class="s3" dir="ltr">PERCENTUAL</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="7">14 - RECEITA TOTAL DO FUNDEB (= 5)</td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">100%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s11" dir="ltr" colspan="7">15 - VALOR LEGAL MÍNIMO</td>
                        <td class="s12" dir="ltr">1,00</td>
                        <td class="s12" dir="ltr">70%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="7">16 - VALOR APLICADO NA REMUNERAÇÃO DE PROFISSIONAIS DA
                            EDUCAÇÃO BÁSICA - FONTES 118 E 166 (13A + 13D)</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s0" dir="ltr"></td>
                        <td class="s1" dir="ltr" colspan="9">IV ? APURAÇÃO DO VALOR NÃO APLICADO, CONFORME ART. 25, §3º
                            DA LEI 14.113/2020</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr" colspan="5">DESCRIÇÃO</td>
                        <td class="s3" dir="ltr">VALOR</td>
                        <td class="s3" dir="ltr">PERCENTUAL</td>
                        <td class="s3" dir="ltr" colspan="2">VALOR MÁXIMO PERMITIDO (10%)</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s5" dir="ltr" colspan="5">17 - RECURSOS RECEBIDOS DO FUNDEB NO EXERCÍCIO QUE NÃO FORAM
                            UTILIZADOS</td>
                        <td class="s6" dir="ltr">1,00</td>
                        <td class="s6" dir="ltr">1,00</td>
                        <td class="s6" dir="ltr" colspan="2">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="5">17.1 - FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS (1 - 4 ?
                            13A ? 13B)</td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s11" dir="ltr" colspan="5">17.2 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT (2 -13D ? 13E)
                        </td>
                        <td class="s12" dir="ltr">1,00</td>
                        <td class="s12" dir="ltr">1,00</td>
                        <td class="s12" dir="ltr" colspan="2">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s0" dir="ltr"></td>
                        <td class="s1" dir="ltr" colspan="9">V - VALOR MÍNIMO LEGAL DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDEB -
                            VAAT EM DESPESA DE CAPITAL</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr" colspan="6">DESCRIÇÃO</td>
                        <td class="s3" dir="ltr" colspan="2">NO EXERCÍCIO</td>
                        <td class="s3" dir="ltr">PERCENTUAL</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">18 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT (= 2)</td>
                        <td class="s19" dir="ltr" colspan="2">1,00</td>
                        <td class="s8" dir="ltr">100%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">19 - VALOR MÍNIMO LEGAL</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                        <td class="s8" dir="ltr">15%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">20 - TOTAL APLICADO</td>
                        <td class="s19" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">20.1 - VALOR PAGO</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">20.2 - RESTOS A PAGAR (PROCESSADOS E NÃO PROCESSADOS)</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">21 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE
                            FINANCEIRA</td>
                        <td class="s18" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s11" dir="ltr" colspan="6">22 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE
                            FINANCEIRA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932736)</td>
                        <td class="s44" dir="ltr" colspan="2">1,00</td>
                        <td class="s44" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="6">23 -TOTAL DE GASTOS COM DESPESA DE CAPITAL (20 - 21 + 22 )</td>
                        <td class="s14" dir="ltr" colspan="2">1,00</td>
                        <td class="s14" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s45"></td>
                        <td class="s45"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s0" dir="ltr"></td>
                        <td class="s1" dir="ltr" colspan="9">VI - VALOR MÍNIMO LEGAL DA COMPLEMENTAÇÃO DA UNIÃO AO FUNDEB -
                            VAAT EM EDUCAÇÃO INFANTIL</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr" colspan="6">DESCRIÇÃO</td>
                        <td class="s3" dir="ltr" colspan="2">NO EXERCÍCIO</td>
                        <td class="s3" dir="ltr">PERCENTUAL</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">24 - FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT (= 2)</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                        <td class="s8" dir="ltr">100%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">25 - VALOR MÍNIMO LEGAL</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                        <td class="s8" dir="ltr">50%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">26 - TOTAL APLICADO</td>
                        <td class="s19" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">26.1 - VALOR PAGO</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">26.2 - RESTOS A PAGAR (PROCESSADOS E NÃO PROCESSADOS)</td>
                        <td class="s8" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s9" dir="ltr" colspan="6">27 - RESTOS A PAGAR INSCRITOS NO EXERCÍCIO SEM DISPONIBILIDADE
                            FINANCEIRA</td>
                        <td class="s18" dir="ltr" colspan="2">1,00</td>
                        <td class="s18" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s11" dir="ltr" colspan="6">28 - RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE
                            DE CAIXA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932736)</td>
                        <td class="s44" dir="ltr" colspan="2">1,00</td>
                        <td class="s44" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="6">29 -TOTAL DE GASTOS COM EDUCAÇÃO INFANTIL (26 - 27 + 28 )</td>
                        <td class="s14" dir="ltr" colspan="2">1,00</td>
                        <td class="s14" dir="ltr">100,00%</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                        <td class="s15"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s0" dir="ltr"></td>
                        <td class="s1" dir="ltr" colspan="7">VII - CONTROLE DA UTILIZAÇÃO DE RECURSOS RECEBIDOS EM EXERCÍCIOS
                            ANTERIORES E NÃO UTILIZADOS (SUPERÁVIT)</td>
                        <td class="s24"></td>
                        <td class="s24"></td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s2" dir="ltr"></td>
                        <td class="s3" dir="ltr" colspan="6">DESCRIÇÃO</td>
                        <td class="s16" dir="ltr">FUNDEB - IMPOSTOS E TRANSFERÊNCIAS DE IMPOSTOS</td>
                        <td class="s38" dir="ltr">FUNDEB - COMPLEMENTAÇÃO DA UNIÃO - VAAT</td>
                        <td class="s46" dir="ltr">TOTAL</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s47" dir="ltr" colspan="5">30 - VALOR DO SUPERÁVIT PERMITIDO NO EXERCICIO ANTERIOR (5% DO
                            VALOR RECEBIDO DE RECEITA)</td>
                        <td class="s22"></td>
                        <td class="s18" dir="ltr"></td>
                        <td class="s18" dir="ltr"></td>
                        <td class="s8" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s47" dir="ltr" colspan="5">31 - VALOR NÃO APLICADO NO EXERCÍCIO ANTERIOR</td>
                        <td class="s22"></td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s47" dir="ltr" colspan="5">32 - VALOR DE SUPERÁVIT APLICADO ATÉ O PRIMEIRO QUADRIMESTRE
                        </td>
                        <td class="s22"></td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s47" dir="ltr" colspan="5">33 - VALOR APLICADO ATÉ O PRIMEIRO QUADRIMESTRE QUE INTEGRARÁ O
                            LIMITE CONSTITUCIONAL</td>
                        <td class="s22"></td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">1,00</td>
                        <td class="s8" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s9" dir="ltr"></td>
                        <td class="s48" dir="ltr" colspan="5">34 - VALOR APLICADO APÓS O PRIMEIRO QUADRIMESTRE</td>
                        <td class="s25"></td>
                        <td class="s12" dir="ltr">1,00</td>
                        <td class="s12" dir="ltr">1,00</td>
                        <td class="s12" dir="ltr">1,00</td>
                    </tr>
                    <tr style="height: 20px">
                        <td class="s4" dir="ltr"></td>
                        <td class="s13" dir="ltr" colspan="6">35 - VALOR NÃO APLICADO (31 - (32 + 34))</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                        <td class="s14" dir="ltr">1,00</td>
                    </tr>
                </table>
            </div>
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

db_fim_transacao();

?>
