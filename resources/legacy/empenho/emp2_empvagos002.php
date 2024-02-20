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
require_once("classes/db_empempenho_classe.php");
include("libs/db_sql.php");
use \Mpdf\Mpdf;
use \Mpdf\MpdfException;

 ini_set('display_errors', 'On');
 error_reporting(E_ERROR);
db_postmemory($HTTP_POST_VARS);

$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
$clEmpenho = new cl_empempenho();

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$aInstits = array(db_getsession("DB_instit"));
$instits = implode(",", $aInstits);
if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}

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

$db_filtro = " o70_instit in({$instits}) ";
$anousu = db_getsession("DB_anousu");

$rsEmpenhosUtilizados = $clEmpenho->sql_record($clEmpenho->slq_ultimo_empenho($dtini, $dtfim, $instits));
$aEmpenhosVagos       = array();
$nUltimoEmpenhoUsado  = db_utils::fieldsMemory($rsEmpenhosUtilizados, 0)->e60_codemp;
$nUltimoEmpLivre      = 0;
$dDataEmpLivreInicial = null;

function getEmpenho($anousu, $codEmpVazio, $instits){
    $clEmpenho = new cl_empempenho();
    $sWhereVerificacaoEmpenho = "e60_codemp = '{$codEmpVazio}' ";
    $sWhereVerificacaoEmpenho .= "and e60_anousu = {$anousu} and e60_instit in ({$instits})";
    $sSqlEmpenhoExistente = $clEmpenho->sql_query_file(null, "e60_numemp, e60_emiss", null, $sWhereVerificacaoEmpenho);
    return  $clEmpenho->sql_record($sSqlEmpenhoExistente);
}

for( $codEmpVazio = 1; $codEmpVazio <= $nUltimoEmpenhoUsado; $codEmpVazio++ ){

    if (pg_numrows(getEmpenho($anousu, $codEmpVazio, $instits )) > 0) {
        $oEmpenhoUsado = db_utils::fieldsMemory(getEmpenho($anousu, $codEmpVazio, $instits ), 0);
        $dDataEmpLivreInicial = $oEmpenhoUsado->e60_emiss;
        continue;
    }
    $empLivre                     = new stdClass;
    $empLivre->codemp             = $codEmpVazio;
    $empLivre->dataLivreInicial   = $dDataEmpLivreInicial;
    for($proxEmp = $codEmpVazio; $proxEmp <= $nUltimoEmpenhoUsado ; $proxEmp++) {
        $oEmp = db_utils::fieldsMemory(getEmpenho($anousu, $proxEmp, $instits), 0);
        if(pg_numrows(getEmpenho($anousu, $proxEmp, $instits )) > 0){
            $empLivre->dataLivreFinal   = $oEmp->e60_emiss;
            break;
        }
    }
    $aEmpenhosVagos[$codEmpVazio] = $empLivre;
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
    'margin_left' => 20,
    'margin_right' => 15,
    'margin_top' => 20,
    'margin_bottom' => 15,
    'margin_header' => 1,
    'margin_footer' => 5,
]);

$header  = " <header> ";
$header .= "   <div style=' height: 120px; font-family:Arial'>";
$header .= "     <div style='width:33%; float:left; padding:5px; font-size:10px;'>";
$header .= "       <b><i>{$oInstit->getDescricao()}</i></b><br/>";
$header .= "          <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>";
$header .= "          <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>";
$header .= "          <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>";
$header .= "          <i>{$oInstit->getSite()}</i>";
$header .= "     </div>";
$header .= "     <div style='width:25%; float:right' class='box'>";
$header .= "       <b>Empenhos Vagos</b><br/>";
$header .= "       <b>INSTITUIÇÕES:</b> ";
foreach ($aInstits as $iInstit) {
    $oInstituicao = new Instituicao($iInstit);
    $header .= "(" . trim($oInstituicao->getCodigo()) . ") " . $oInstituicao->getDescricao() . " ";
}
$header .= "      <br/> <b>PERÍODO:</b> {$DBtxt21} A {$DBtxt22} <br/> ";
$header .= "    </div>";
$header .= "  </div>";
$header .= "</header>";

$footer  = "<footer style='padding-top: 20px;'>";
$footer .= "   <div style='border-top:1px solid #000; width:100%; font-family:sans-serif; font-size:10px; height:10px;'>";
$footer .= "    <div style='text-align:left;font-style:italic;width:90%;float:left;'>";
$footer .= "       Financeiro>Empenho>Relatórios de Conferência>Empenhos Vagos";
$footer .= "       Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu"))  . "";
$footer .= "      <div style='text-align:right;float:right;width:10%;'>";
$footer .= "                        {PAGENO}";
$footer .= "      </div>";
$footer .= "    </div>";
$footer .= "   </div>";
$footer .= "</footer>";

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

        .ritz .waffle .s22 {
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
            height: 20px;
        }

        .ritz .waffle .s2 {
            border-left: 1px SOLID #000000;
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
            height: 20px;
        }

        .ritz .waffle .s1 {
            border-top: 1px SOLID #000000;
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

        .ritz .waffle .s0 {
            border-top: 1px SOLID #000000;
            border-left: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            background-color: #cccccc;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: 'docs-sans-serif', Arial;
            font-size: 10pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 2px 3px 2px 3px;
        }
    </style>
</head>

<body>
    <div class="ritz grid-container" dir="ltr" >
        <table class="waffle" cellspacing="0" cellpadding="0" >
            <thead>
                <tr>
                    <th class="row-header freezebar-origin-ltr"></th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 20px">
                    <td class="s0" dir="ltr">Número do Empnho</td>
                    <td class="s1" dir="ltr">Intervalo de Datas para Ordem Cronológica</td>
                </tr>
                <?php
                    foreach($aEmpenhosVagos as $oEmpVago){
                        echo "<tr style='height: 20px'>";
                        echo "<td class='s2'>".$oEmpVago->codemp."</td>";
                        echo "<td class='s22'>".db_formatar($oEmpVago->dataLivreInicial,"d")." a ".db_formatar($oEmpVago->dataLivreFinal,"d")." </td>";
                        echo "</tr>";
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
$mPDF->Output();
} catch (MpdfException $e) {
    db_redireciona('db_erros.php?fechar=true&db_erro='.$e->getMessage());
}

?>
