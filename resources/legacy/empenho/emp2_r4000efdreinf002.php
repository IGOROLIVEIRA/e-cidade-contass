<?php
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
include("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_contacorrentedetalhe_classe.php");
use \Mpdf\Mpdf;
use \Mpdf\MpdfException;

$oGet = db_utils::postMemory($_GET);

try {
    $dtDataInicial = App\Support\String\DateFormatter::convertDateFormatBRToISO($dtDataInicial);
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    $dtDataFinal = App\Support\String\DateFormatter::convertDateFormatBRToISO($dtDataFinal);
} catch (Exception $e) {
    echo $e->getMessage();
}


switch ($sTipo) {
    case '2':
        $validaTipoPfPj = " AND length(cgm.z01_cgccpf) = 11 ";
        $tipoCabecalho = "Pessoa Física (4010)";
        break;
    case '3':
        $validaTipoPfPj = " AND length(cgm.z01_cgccpf) = 14 ";
        $tipoCabecalho = "Pessoa Jurídica (4020)";
        break;
    default:
        $validaTipoPfPj = " ";
        $tipoCabecalho = "Todos";
}

if ($sCredoresSelecionados) {

    switch ($sCredorSelect) {
        case '1':
            $filtroCredores = " AND e60_numcgm IN ({$sCredoresSelecionados})";
            break;
        case '2':
            $filtroCredores = " AND e60_numcgm NOT IN ({$sCredoresSelecionados})";
            break;
        default:
            $filtroCredores = "";
    }
}

function tipoQuebra($sQuebra, $sSqlNota): string
{
    if ($sQuebra == 1) {
        $sSqlNota .= "  order by cgm.z01_cgccpf  ";
        return $sSqlNota;
    }
    $sSqlNota .= "  order by o58_projativ,o58_codigo";
    return $sSqlNota;
}

$clcontacorrentedetalhe = new cl_contacorrentedetalhe();
$instituicao = db_getsession("DB_instit");
$anoSessao = db_getsession("DB_anousu");
$sSqlNota1 = $clcontacorrentedetalhe->consultaEfdReinf($instituicao, $validaTipoPfPj, $filtroCredores, $anoSessao);
$rsNota1 = $clcontacorrentedetalhe->sql_record($sSqlNota1);

if ($clcontacorrentedetalhe->numrows > 0) {
    $oNotas = db_utils::FieldsMemory($rsNota1, 0);
}
$aFornecedores = pg_fetch_all($rsNota1);
db_postmemory($HTTP_POST_VARS);

try {
    $oInstit = new Instituicao($instituicao);
} catch (DBException $e) {
    echo $e->getMessage();
}


db_inicio_transacao();


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
                <div style=\" height: 120px; font-family:Arial,serif\">
                    <div style=\"width:50%; float:left; padding:5px; font-size:10px;\">
                        <b><i>{$oInstit->getDescricao()}</i></b><br/>
                        <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
                        <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
                        <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
                        <i>{$oInstit->getSite()}</i>
                    </div>
                    <div style=\"width:40%; float:right\" class=\"box\">
                    <b>Relatório: EFD-Reinf R-4000</b><br/>  ";
try {
    $oInstituicao = new Instituicao($instituicao);
} catch (DBException $e) {
}
$header .= "<b>Instituição: </b>" . trim($oInstituicao->getCodigo()) . " - " . $oInstituicao->getDescricao();

/*Período do relatório.*/
$header .= "<br/><b>Período:</b> {$dtDataInicial} <b>A</b> {$dtDataFinal}
                 <b>  | Tipo:</b> {$tipoCabecalho}
                    </div>
                </div>
            </header>";


$footer = "<footer style='padding-top: 150px;'>";
$footer .= "   <div style='border-top:1px solid #000; width:100%; font-family:sans-serif; font-size:7px; height:5px;padding-bottom: -12px;'>";
$footer .= "    <div style='text-align:left;font-style:italic;width:90%;float:left;padding-bottom: -82px;'>";
$footer .= "       Financeiro>Empenho>Relatórios de Conferência>EFD-Reinf R-4000";

/**
 * @param string $footer
 * @param mPDF $mPDF
 * @param string $header
 * @return void
 */
function footer(string $footer, mPDF $mPDF, string $header): void
{
    $footer .= "       Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu")) . "";
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
}

footer($footer, $mPDF, $header);

?>

    <html lang="pt">

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

            .ritz .waffle .s2 {
                border-bottom: 1px SOLID #000000;
                background-color: #f3f3f3;
                text-align: left;
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

            .ritz .waffle .s4 {
                border-bottom: 1px SOLID #000000;
                border-right: 1px SOLID #000000;
                border-left: 1px SOLID #000000;
                background-color: #ffffff;
                text-align: center;
                color: #000000;
                font-family: 'Arial';
                font-size: 10pt;
                vertical-align: bottom;
                white-space: nowrap;
                direction: ltr;
                padding: 2px 3px 2px 3px;
            }
        </style>
        <title></title>
    </head>

    <body>
    <div class="ritz grid-container" dir="ltr">
        <div class="title-relatorio"><br/>
            <strong>
                <font size="-1">Relatório EFD-Reinf R-4000</font>
            </strong><br/><br/>

        </div>
        <table class="waffle" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th class="row-header freezebar-origin-ltr"></th>
                <th id="0C0" style="width:100px;" class="column-headers-background"></th>
                <th id="0C1" style="width:100px;" class="column-headers-background"></th>
                <th id="0C2" style="width:100px;" class="column-headers-background"></th>
            </tr>
            </thead>
            <tbody>
            <tr style="height: 30px">
                <th id="0R0" style="height: 30px;"></th>

                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Empenho </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> OP </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Data OP </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Número da NF </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Valor da NF </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Data Pagamento  </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Valor Bruto </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Valor Base IR </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Valor IRRF </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Natureza Rendimento </span></td>
                <td class="s0" dir="ltr"><span style="font-size: smaller; "> Retenção Terceiro </span></td>

            </tr>


            <?php

            $objetos = [];

            foreach ($aFornecedores as $oNotas) {
                $chave = $oNotas['op'] . $oNotas['beneficiario'];
                if (!isset($objetos[$chave])) {
                    $objetos[$chave] = $oNotas;
                }
            }

            $itens = [];

            foreach ($objetos as $item) {
                $itens[] = $item;
            }

            $cont = 0;
            $oNotasCabecalho = '';
            $notaCredor = '';

            foreach ($itens as $itensFiltrados) {

                $chave2 = $itensFiltrados['credor_emp'] . $itensFiltrados['beneficiario'];

                $or = $cont >= 1 ? "OR" . $cont : "";

                $dataNota = date('d/m/Y', strtotime($itensFiltrados['data_nota']));
                $dataPgto = date('d/m/Y', strtotime($itensFiltrados['data_pgto']));

                $dataPgtoBanco = DateTime::createFromFormat('d/m/Y', $dataPgto);
                $dataPgtoBanco = $dataPgtoBanco->format('Y-m-d');

                $dataInicialFiltro = DateTime::createFromFormat('d/m/Y', $dtDataInicial);
                $dataInicialFiltro = $dataInicialFiltro->format('Y-m-d');

                $dataFinalFiltro = DateTime::createFromFormat('d/m/Y', $dtDataFinal);
                $dataFinalFiltro = $dataFinalFiltro->format('Y-m-d');

                if (($dataPgtoBanco >= $dataInicialFiltro) && ($dataPgtoBanco <= $dataFinalFiltro)) {

                    $itensFiltrados['reten_terceiros'] = $itensFiltrados['reten_terceiros'] == 't' ? 'Sim' : 'Não';

                    $valor_nota = db_formatar($itensFiltrados['valor_op'], "f");
                    $valorBase_irrf = db_formatar($itensFiltrados['valor_base'], "f");
                    $valor_bruto = db_formatar($itensFiltrados['valor_bruto'], "f");
                    $valor_irrf = db_formatar($itensFiltrados['valor_irrf'], "f");
                    $credoresFiltrados = $itensFiltrados['credor_emp'];
                    $beneficiariosFiltrados = $itensFiltrados['beneficiario'];
                    $beneficiario = "";
                    $credor = "";

                    if (($oNotasCabecalho == "") || ($oNotasCabecalho != $chave2)) {

                        if ($itensFiltrados['credor_emp'] != $notaCredor) {

                            $credor = <<<HTML
                        <tr>
                            <td class="s2" colspan="20"><b>Credor do Empenho: $credoresFiltrados</b></td>
                        </tr>
HTML;
                        }
                        $notaCredor = $itensFiltrados['credor_emp'];

                        $beneficiario = <<<HTML
                        <tr>
                            <td class="s1" colspan="20"><b>Beneficiário: $beneficiariosFiltrados</b></td>
                        </tr>
HTML;

                    }

                    $oNotasCabecalho = $chave2;

                    $empenho = $itensFiltrados['empenho'];
                    $op = $itensFiltrados['op'];
                    $nro_nota = $itensFiltrados['nro_nota'];
                    $natureza_rendimento = $itensFiltrados['natureza_rendimento'];
                    $reten_terceiros = $itensFiltrados['reten_terceiros'];

                    echo <<<HTML
                        $credor
                        $beneficiario
                        <tr style="height: 20px">
                            <th id="0R{$or}" style="height: 20px;" class="row-headers-background">
                            <div class="row-header-wrapper" style="line-height: 20px">
                            </th>
                            <td class="s4" dir="ltr">$empenho</td>
                            <td class="s4" dir="ltr">$op</td>
                            <td class="s4" dir="ltr">$dataNota</td>
                            <td class="s1" dir="ltr">$nro_nota</td>
                            <td class="s1" dir="ltr">R$ $valor_nota</td>
                            <td class="s4" dir="ltr">$dataPgto</td>
                            <td class="s1" dir="ltr">R$ $valor_bruto</td>
                            <td class="s1" dir="ltr">R$ $valorBase_irrf</td>
                            <td class="s1" dir="ltr">R$ $valor_irrf</td>

                            <td class="s4" dir="ltr">$natureza_rendimento</td>
                            <td class="s4" dir="ltr">$reten_terceiros</td>
                        </tr>
                        </br>
HTML;

                    $cont++;
                }
            }
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
$mPDF->Output('EFD-Reinf R-4000.pdf', 'I');
} catch (MpdfException $e) {
    db_redireciona('db_erros.php?fechar=true&db_erro='.$e->getMessage());
}
db_fim_transacao();

