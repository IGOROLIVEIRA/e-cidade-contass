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
require_once "classes/db_fornemensalemp_classe.php";
require_once("classes/db_cgm_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");
include("libs/db_sql.php");
require_once("dbforms/db_funcoes.php");
use \Mpdf\Mpdf;
use \Mpdf\MpdfException;

$clFornecedores = new cl_fornemensalemp();
$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
$cldadosexecicioanterior = new cl_dadosexercicioanterior();
db_postmemory($HTTP_POST_VARS);

$instits = str_replace('-', ', ', db_getsession("DB_instit"));
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

try {
    $mPDF = new Mpdf([
        'mode' => '',
        'format' => 'A4-L',
        'orientation' => 'L',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 20,
        'margin_bottom' => 15,
        'margin_header' => 5,
        'margin_footer' => 11,
    ]);
/*Nome do relatório.*/
$header = " <header>
                <div style=\" height: 120px; font-family:Arial\">
                    <div style=\"width:33%; float:left; padding:5px; font-size:10px;\">
                        <b><i>{$oInstit->getDescricao()}</i></b><br/>
                        <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
                        <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
                        <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
                        <i>{$oInstit->getSite()}</i>
                    </div>
                    <div style=\"width:40%; float:right\" class=\"box\">
                    <b>Relatório Faturamento dos Fornecedores Mensais</b><br/>  ";
foreach ($aInstits as $iInstit) {
    $oInstituicao = new Instituicao($iInstit);
    $header .= "<b>Instituição: </b>".trim($oInstituicao->getCodigo()) . " - " . $oInstituicao->getDescricao();
}

/*Período do relatório.*/
$header .= "<br/><b>Período:</b> {$dtDataInicial} <b>A</b> {$dtDataFinal}
                    </div>
                </div>
            </header>";


$footer  = "<footer style='padding-top: 150px;'>";
$footer .= "   <div style='border-top:1px solid #000; width:100%; font-family:sans-serif; font-size:7px; height:5px;padding-bottom: -12px;'>";
$footer .= "    <div style='text-align:left;font-style:italic;width:90%;float:left;padding-bottom: -82px;'>";
$footer .= "       Financeiro>Empenho>Relatorios de Conferencia>Fornecedoers Mensais de Empenhos";
$footer .= "       Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu"))  . "";
$footer .= "      <div style='text-align:right;float:right;width:10%;padding-bottom: -122px;'>";
$footer .= "                        {PAGENO}";
$footer .= "      </div>";
$footer .= "    </div>";
$footer .= "   </div>";
$footer .= "</footer>";


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O');

ob_start();

$tipoImpressao = $sTipoImpressao;

$dataInicial = str_replace("/","-",db_formatar($dtDataInicial, "d"));
$dataFinal = str_replace("/","-",db_formatar($dtDataFinal, "d"));

$whereDatas = $clFornecedores->validaDatas($dataInicial, $dataFinal);

if (isset($whereDatas)) {
    if($sCredoresSelecionados)
        $resultFornecedoresTotais = $clFornecedores->sql_record($clFornecedores->sql_query(null, "fm101_sequencial,fm101_numcgm,z01_nome,fm101_datafim", "z01_nome", " fm101_numcgm in ($sCredoresSelecionados) and (fm101_datafim >= '$dataInicial' or fm101_datafim is null ) "));
    else
        $resultFornecedoresTotais = $clFornecedores->sql_record($clFornecedores->sql_query(null, "fm101_sequencial,fm101_numcgm,z01_nome,fm101_datafim", "z01_nome", " fm101_datafim >= '$dataInicial' or fm101_datafim is null "));
    $resultFornecedores = $clFornecedores->sql_record($clFornecedores->sqlNotasFiscais(null, "", null, $whereDatas, $tipoImpressao, $sCredoresSelecionados));
}
    $aFornecedoresTotais = pg_fetch_all($resultFornecedoresTotais);
    $aFornecedores = pg_fetch_all($resultFornecedores);

?>

    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link type="text/css" rel="stylesheet" href="resources/sheet.css">
        <style type="text/css">
            .ritz .waffle a {
                color: inherit;
            }

            .title-relatorio {
                border-top: 1px SOLID #000000;
                text-align: center;
            }

            .ritz .waffle .s1 {
                border-bottom: 1px SOLID #000000;
                border-right: 1px SOLID #000000;
                border-left: 1px SOLID #000000;
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

            .ritz .waffle .s0 {
                border-bottom: 1px SOLID #000000;
                border-left: 0.5px SOLID #000000;
                border-top: 1px SOLID #000000;
                border-right: 1px solid #000000;
                background-color: #efefef;
                text-align: center;
                font-weight: bold;
                font-family: 'Arial';
                font-size: 10pt;
                vertical-align: middle;
                white-space: nowrap;
                direction: ltr;
                padding: 2px 3px 2px 3px;
            }

            .ritz .waffle .s3 {
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

            .ritz .waffle .s2 {
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
        </style>
    </head>

    <body>
    <div class="ritz grid-container" dir="ltr">
        <div class="title-relatorio"><br/>
            <strong>
                <font size="-1">Relatório de Faturamento</font>
            </strong><br/>
            <strong>
                <font size="-1">Fornecedores Mensais</font>
            </strong><br/>
        </div>
        <table class="waffle" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th class="row-header freezebar-origin-ltr"></th>
                <th id="0C0" style="width:500px;" class="column-headers-background"></th>
                <th id="0C1" style="width:180px;" class="column-headers-background"></th>
                <th id="0C2" style="width:100px;" class="column-headers-background"></th>
            </tr>
            </thead>
            <tbody>
            <tr style="height: 20px">
                <th id="0R0" style="height: 20px;"></th>
                <td class="s0" dir="ltr"><font size="-1"> FORNECEDOR </font></td>
                <td class="s0" dir="ltr" colspan="2"><font size="-1"> VALOR DO FATURAMENTO </font></td>
            </tr>
            <?php

            $pagina = 0;
            $contador = 1;
            $control = 0;

            for ($cont = 0; $cont < count($aFornecedoresTotais); $cont++) {

                $oFornecedores = db_utils::fieldsMemory($resultFornecedores, $cont);
                $oFornecedoresTotais = db_utils::fieldsMemory($resultFornecedoresTotais, $cont);
                $hash = $oFornecedoresTotais->z01_nome;
                // $hash1 = $oFornecedoresTotais->z01_nome;

                foreach ($oFornecedoresTotais as $fornecedor) {

                    $fornecedorMensal = new stdClass();
                    // echo $oFornecedores->fm101_numcgm."-".$oFornecedoresTotais->fm101_numcgm."<br/>";
                    if ((!isset($aFornecedores[$hash]) && $oFornecedoresTotais->fm101_numcgm)) {
                        if($oFornecedores->fm101_numcgm == $oFornecedoresTotais->fm101_numcgm){
                            // echo "aqeui";
                            $fornecedorMensal->fm101_numcgm = $oFornecedores->fm101_numcgm;
                            $fornecedorMensal->fm101_fornecedor = $oFornecedores->z01_nome;
                            $fornecedorMensal->fm101_valor = db_formatar($oFornecedores->e70_valor, "f");
                        }else{
                            // echo "la";
                            $fornecedorMensal->fm101_numcgm = $oFornecedoresTotais->fm101_numcgm;
                            $fornecedorMensal->fm101_fornecedor = $oFornecedoresTotais->z01_nome;
                            $fornecedorMensal->fm101_valor = db_formatar(0, "f");
                        }

                        if ($cont >= 1) {
                            $or = "OR" . $cont;
                        }

                        echo <<<HTML
                        <tr style="height: 20px">
                            <th id="0R{$or}" style="height: 20px;" class="row-headers-background">
                            <div class="row-header-wrapper" style="line-height: 20px"></div>
                            </th>
                            <td class="s1" dir="ltr">$fornecedorMensal->fm101_numcgm - $fornecedorMensal->fm101_fornecedor</td>
                            <td class="s2" dir="ltr">R$</td>
                            <td class="s3" dir="ltr">$fornecedorMensal->fm101_valor</td>
                        </tr> </br>
HTML;

                        if ($control >= 50) {
                            if (($control % $pagina) == 1) {
                                $pagina = $cont;
                                $contador++;
                                $control++;
                                $mPDF->addPage();
                                echo <<<HTML
                                <tr style="height: 20px">
                                    <th id="0R0" style="height: 20px;"></th>
                                    <td class="s0" dir="ltr"><font size="-1"> FORNECEDOR </font></td>
                                    <td class="s0" dir="ltr" colspan="2"><font size="-1"> VALOR DO FATURAMENTO </font>
                                    </td>
                                </tr>
HTML;

                            }
                        } elseif ($cont == 49 || ($cont / $pagina) == $contador) {
                            $pagina = $cont;
                            $contador++;
                            if ($cont == 49) {
                                $control = 50;
                            }
                            $control++;
                            $mPDF->addPage();
                            echo <<<HTML
                                <tr style="height: 20px">
                                    <th id="0R0" style="height: 20px;"></th>
                                    <td class="s0" dir="ltr"><font size="-1"> FORNECEDOR </font></td>
                                    <td class="s0" dir="ltr" colspan="2"><font size="-1"> VALOR DO FATURAMENTO </font>
                                    </td>
                                </tr>
HTML;

                        }
                        $aFornecedores[$hash] = $fornecedorMensal->fm101_fornecedor;
                    }
                }

            }
        //  exit;
            ?>
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
} catch (MpdfException $e) {
    db_redireciona('db_erros.php?fechar=true&db_erro='.$e->getMessage());
}
db_fim_transacao();

?>
