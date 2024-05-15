<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");
require_once("classes/db_pcorcam_classe.php");
require_once("model/compilacaoRegistroPreco.model.php");
require_once("model/estimativaRegistroPreco.model.php");
require_once("model/configuracao/DBDepartamento.model.php");
$oGet        = db_utils::postMemory($_GET);
$clpcorcam   = new cl_pcorcam();

/**
 * matriz de entrada
 */
$what = array(
    'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û',
    'Ä', 'Ã', 'À', 'Á', 'Â', 'Ê', 'Ë', 'È', 'É', 'Ï', 'Ì', 'Í', 'Ö', 'Õ', 'Ò', 'Ó', 'Ô', 'Ü', 'Ù', 'Ú', 'Û',
    'ñ', 'Ñ', 'ç', 'Ç', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '=', '?', '~', '^', '>', '<', 'ª', '°', "°", chr(13), chr(10), "'"
);

/**
 * matriz de saida
 */
$by = array(
    'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
    'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U',
    'n', 'N', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', " ", " ", " ", " "
);

/**
 * Verifica as datas de criação do registro informadas no formulario.
 */
$dtIniCrg = implode("-", array_reverse(explode("/", $oGet->dtinicrg)));
$dtFimCrg = implode("-", array_reverse(explode("/", $oGet->dtfimcrg)));

if ((trim($dtIniCrg) != "") && (trim($dtFimCrg) != "")) {

    $sHeaderDtCriacao = "Criação do Registro: " . $oGet->dtinicrg . " até " . $oGet->dtfimcrg;
    $sWhere          .= "{$sAnd} solicita.pc10_data  between '{$oGet->dtinicrg}' and '{$oGet->dtfimcrg}' ";
    $sAnd             = " and ";
} else if (trim($oGet->dtinicrg) != "") {

    $sHeaderDtCriacao = "Criação do Registro: " . $oGet->dtinicrg;
    $sWhere .= "{$sAnd} ( solicita.pc10_data >= '{$oGet->dtinicrg}' ) ";
    $sAnd    = " and ";
} else if (trim($oGet->dtfimcrg) != "") {

    $sHeaderDtCriacao = "Criação do Registro: " . $oGet->dtfimcrg;
    $sWhere .= "{$sAnd} ( solicita.pc10_data <= '{$oGet->dtfimcrg}' ) ";
    $sAnd    = " and ";
}

/**
 * Verifica as datas de validade do registro informadas no formulario.
 */
$dtIniVlrg = implode("-", array_reverse(explode("/", $oGet->dtinivlrg)));
$dtFimVlrg = implode("-", array_reverse(explode("/", $oGet->dtfimvlrg)));

if ((trim($dtIniVlrg) != "") && (trim($dtFimVlrg) != "")) {

    $sHeaderDtVal = "Validade do Registro: " . $dtIniVlrg . " até " . $dtFimVlrg;
    $sWhere      .= "{$sAnd} ( pc54_datainicio >= '{$dtIniVlrg}' and pc54_datatermino <= '{$dtFimVlrg}' )  ";
    $sAnd         = " and ";
} else if (trim($dtIniVlrg) != "") {

    $sHeaderDtVal = "Validade do Registro: " . $dtIniVlrg;
    $sWhere      .= "{$sAnd} ( pc54_datainicio >= '{$dtIniVlrg}' ) ";
    $sAnd         = " and ";
} else if (trim($dtFimVlrg) != "") {

    $sHeaderDtVal = "Validade do Registro: " . $dtFimVlrg;
    $sWhere .= "{$sAnd} ( pc54_datatermino <= '{$dtFimVlrg}' ) ";
    $sAnd    = " and ";
}

/**
 * Verifica os numeros da solicitação informados no formulario.
 */
if ((trim($oGet->numini) != "") && (trim($oGet->numfim) != "")) {

    $sHeaderNum = "Compilação: " . $oGet->numini . " á " . $oGet->numfim;
    $sWhere    .= "{$sAnd} solicita.pc10_numero between '{$oGet->numini}' and '{$oGet->numfim}' ";
    $sAnd       = " and ";
} else if (trim($oGet->numini) != "") {

    $sHeaderNum = "Compilação: " . $oGet->numini;
    $sWhere .= "{$sAnd} ( solicita.pc10_numero >= '{$oGet->numini}' ) ";
    $sAnd    = " and ";
} else if (trim($oGet->numfim) != "") {

    $sHeaderNum = "Compilação: " . $oGet->numfim;
    $sWhere .= "{$sAnd} ( solicita.pc10_numero <= '{$oGet->numfim}' ) ";
    $sAnd    = " and ";
}

/**
 * Verifica os itens selecionados no formulario.
 */
if (trim($oGet->itens) != "") {

    $sHeaderItens = "Itens: ( " . $oGet->itens . " )";
    $sWhere      .= "{$sAnd} pc01_codmater in ($oGet->itens) ";
    $sAnd         = " and ";
}

$sWhere .= "{$sAnd} solicita.pc10_solicitacaotipo = 6 ";

$sSql  = "  select solicita.*,                                                                                                     ";
$sSql .= "         solicitaregistropreco.*,                                                                                        ";
$sSql .= "         solicitem.*,                                                                                                    ";
$sSql .= "         solicitemregistropreco.*,                                                                                       ";
$sSql .= "         solicitemunid.*,                                                                                                ";
$sSql .= "         matunid.*,                                                                                                      ";
$sSql .= "         solicitempcmater.*,                                                                                             ";
$sSql .= "         pcmater.*                                                                                                       ";
$sSql .= "    from solicita                                                                                                        ";
$sSql .= "         inner join solicitaregistropreco  on solicita.pc10_numero           = solicitaregistropreco.pc54_solicita       ";
$sSql .= "         inner join solicitem              on solicita.pc10_numero           = solicitem.pc11_numero                     ";
$sSql .= "         inner join solicitemregistropreco on solicitem.pc11_codigo          = solicitemregistropreco.pc57_solicitem     ";
$sSql .= "         inner join solicitemunid          on solicitem.pc11_codigo          = solicitemunid.pc17_codigo                 ";
$sSql .= "         inner join matunid                on solicitemunid.pc17_unid        = matunid.m61_codmatunid                    ";
$sSql .= "         inner join solicitempcmater       on solicitem.pc11_codigo          = solicitempcmater.pc16_solicitem           ";
$sSql .= "         inner join pcmater                on solicitempcmater.pc16_codmater = pcmater.pc01_codmater                     ";
$sSql .= "   where {$sWhere} {$sOrder}";

$rsSql   = db_query($sSql);
$iRsSql  = pg_num_rows($rsSql);

if ($iRsSql == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
}

?>



<?php
header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=Registro de Preço.doc");

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">

<head>
    <title>Relatório</title>
    <meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1">
    <style>
        @page Section1 {
            size: 595.45pt 841.7pt;
            margin: .5in .5in .5in .5in;
            mso-header-margin: .5in;
            mso-footer-margin: .5in;
            mso-paper-source: 0;
        }

        div.Section1 {
            page: Section1;
        }

        @page Section2 {
            size: 841.7pt 595.45pt;
            mso-page-orientation: landscape;
            margin: .5in .5in .5in .5in;
            mso-header-margin: .5in;
            mso-footer-margin: .5in;
            mso-paper-source: 0;
        }

        div.Section2 {
            page: Section2;
        }

        td {
            font-size: 10px;
            text-align: center;
        }

        .header {
            border: 1px solid black;
            background-color: #DCDCDC;
            margin-top: 10px;
            font-size: 11px;
        }

        .footer {
            margin-top: 10px;
        }
    </style>
</head>


<body>
    <div class="Section2">
        <div>
            <strong>Posição do Registro de Preço</strong>
        </div>
        <table>

            <?php

            if ($oGet->lQuebraFornecedor == 't') {
                $aCgms = array();
            }

            /**
             * Agrupa os registros do record set retornado pelo sql
             */
            for ($iInd = 0; $iInd  < $iRsSql; $iInd++) {

                $oSolicita   = db_utils::fieldsMemory($rsSql, $iInd);
                $oCompilacao = new compilacaoRegistroPreco($oSolicita->pc11_numero);
                $oLicitacao  = $oCompilacao->getLicitacao();

                $sLicitacao = "";
                if ($oLicitacao) {

                    $sLicitacao  = "{$oLicitacao->getEdital()} / {$oLicitacao->getAno()} - ";
                    $sLicitacao .= "{$oLicitacao->getModalidade()->getDescricao()}";
                }

                $oSolicita->oDadosFornecedor   = $oCompilacao->getFornecedorItem($oSolicita->pc01_codmater, $oSolicita->pc11_codigo);
                if (
                    empty($oSolicita->oDadosFornecedor->vencedor) ||
                    (strlen($oGet->fornecedores) && !in_array($oSolicita->oDadosFornecedor->codigocgm, explode(',', $oGet->fornecedores)))
                ) {
                    continue;
                }

                $oSolicita->empenhada          = $oCompilacao->getValorEmpenhadoItem($oSolicita->pc11_codigo);
                $oSolicita->solicitada         = $oCompilacao->getValorSolicitadoItem($oSolicita->pc11_codigo);

                $oDadosEstimativa                 = new stdClass();
                $oDadosEstimativa->iSeq           = $oSolicita->pc11_seq;
                $oDadosEstimativa->iCodItem       = $oSolicita->pc01_codmater;
                $oDadosEstimativa->sDescrItem     = $oSolicita->pc01_descrmater." ".$oSolicita->pc01_complmater;
                $oDadosEstimativa->sCompl         = $oSolicita->pc11_resum;
                $oDadosEstimativa->sUnidade       = $oSolicita->m61_descr;
                $oDadosEstimativa->sFornecedor    = $oSolicita->oDadosFornecedor->vencedor;
                $oDadosEstimativa->iEmpenhada     = $oSolicita->empenhada;
                $oDadosEstimativa->iSolicitada    = $oSolicita->solicitada;
                $oDadosEstimativa->lControlaValor = ($oCompilacao->getFormaDeControle() == aberturaRegistroPreco::CONTROLA_VALOR);

                $oDadosEstimativa->nSolicitar    = ($oSolicita->pc11_quant - $oSolicita->solicitada);
                $oDadosEstimativa->nEmpenhar     = ($oSolicita->solicitada - $oSolicita->empenhada);

                $nQuantMin                     = (empty($oSolicita->pc57_quantmin)                   ? '0' : $oSolicita->pc57_quantmin);
                $nQuantMax                     = (empty($oSolicita->pc11_quant)                      ? '0' : $oSolicita->pc11_quant);
                $nVlrUnitario                  = (empty($oSolicita->oDadosFornecedor->valorunitario) ? '0' : $oSolicita->oDadosFornecedor->valorunitario);

                $oDadosEstimativa->nQuantMin = (empty($oSolicita->pc57_quantmin)                   ? '0' : $oSolicita->pc57_quantmin);
                $oDadosEstimativa->nQuantMax                     = (empty($oSolicita->pc11_quant)                      ? '0' : $oSolicita->pc11_quant);

                /**
                 * Verifica se controla o registro de preço por valor e altera o conteúdo das colunas
                 */
                if ($oDadosEstimativa->lControlaValor) {

                    $oDadosEstimativa->nSolicitar = ($oSolicita->pc11_vlrun - $oSolicita->solicitada);
                    $nVlrUnitario = $oSolicita->pc11_vlrun;
                }

                $aDadosPosRegPreco[$oSolicita->pc10_numero]['oAbertura']      = $oCompilacao->getCodigoAbertura();
                $aDadosPosRegPreco[$oSolicita->pc10_numero]['oCompilacao']    = $oSolicita->pc11_numero;
                $aDadosPosRegPreco[$oSolicita->pc10_numero]['lControlaValor'] = $oDadosEstimativa->lControlaValor;
                $aDadosPosRegPreco[$oSolicita->pc10_numero]['sLicitacao']     = $sLicitacao;

                /**
                 * Se escolher quebra por departamento, desmembramos as compilações nas suas estimativas
                 * e agrupamos as estimativas por departamentos
                 */

                if (!isset($aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq])) {

                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['oDados']          = $oDadosEstimativa;
                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalQntMin']    = $nQuantMin;
                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalQntMax']    = $nQuantMax;
                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalVlrUnid']   = $nVlrUnitario;
                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalQntSolic']  = $oSolicita->pc11_quant;
                } else {

                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalQntMin']   += $nQuantMin;
                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalQntMax']   += $nQuantMax;
                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalVlrUnid']  += $nVlrUnitario;
                    $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]['nTotalQntSolic'] += $oSolicita->pc11_quant;
                }

                if ($oGet->fornecedores || $oGet->lQuebraFornecedor == 't') {
                    if (!in_array($oSolicita->oDadosFornecedor->codigocgm, array_keys($aCgms))) {
                        $aCgms[$oSolicita->oDadosFornecedor->codigocgm]['itens'] = array();
                        $aCgms[$oSolicita->oDadosFornecedor->codigocgm]['oAbertura']      = $oCompilacao->getCodigoAbertura();
                        $aCgms[$oSolicita->oDadosFornecedor->codigocgm]['oCompilacao']    = $oSolicita->pc11_numero;
                        $aCgms[$oSolicita->oDadosFornecedor->codigocgm]['lControlaValor'] = $oDadosEstimativa->lControlaValor;
                        $aCgms[$oSolicita->oDadosFornecedor->codigocgm]['sLicitacao']       = $sLicitacao;
                        array_push($aCgms[$oSolicita->oDadosFornecedor->codigocgm]['itens'], $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]);
                    } else {
                        array_push($aCgms[$oSolicita->oDadosFornecedor->codigocgm]['itens'], $aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]);
                    }
                }

                if ($lUltimoControle != null && $lUltimoControle != $oDadosEstimativa->lControlaValor) {
                    $lTotalGeral = false;
                }

                $lUltimoControle = $oDadosEstimativa->lControlaValor;
            }

            $nTotalGeralRegistros   = 0;
            $nTotalGeralSolicitada  = 0;
            $nTotalGeralEmpenhada   = 0;
            $nTotalGeralSolicitar   = 0;
            $nTotalGeralEmpenhar    = 0;


            /**
             * Percore o array $aDadosPosRegPreco agrupando pelo departamento
             */
            $contsheet = 0;

            if (!$oGet->fornecedores && $oGet->lQuebraFornecedor == 'f') {

                foreach ($aDadosPosRegPreco as $iNroSolicitacao => $aDados) {


                    $nTotalRegistros   = 0;
                    $nTotalSolicitada  = 0;
                    $nTotalEmpenhada   = 0;
                    $nTotalSolicitar   = 0;
                    $nTotalEmpenhar    = 0;

                    /**
                     * Percore os registros por dados compilação
                     */
                    foreach ($aDados as $iIndice => $aDadosCompilacao) {



                        if (is_array($aDadosCompilacao)) {
                            $sIndice = 0;

                            echo "<tr class=\"header\">";
                            echo "<td class=\"header\" colspan=\"7\"> <strong> Abertura: </strong>" .  $aDados['oAbertura'] . " <strong> Compilação: </strong>" .  $aDados['oCompilacao']  . " <strong> Licitação: </strong>" .  iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDados['sLicitacao']))  . " </td>";
                            echo "<td class=\"header\" colspan=\"3\"> <strong> Quantidade  </strong>";
                            echo "<td class=\"header\" colspan=\"2\"> <strong> Saldos  </strong>";
                            echo "<tr>";

                            echo
                            " <tr>
                                <td><strong>SEQ</strong></td>
                                <td><strong>ITEM</strong></td>
                                <td><strong>DESCRIÇÃO</strong></td>
                                <td><strong>UN</strong></td>
                                <td><strong>VLR. UNIT.</strong></td>
                                <td><strong>FORNECEDOR</strong></td>
                                <td><strong>QTD. MIN/MAX</strong></td>
                                <td><strong>SOLICITADA</strong></td>
                                <td><strong>EMPENHADA</strong></td>
                                <td><strong>A SOLICITAR</strong></td>
                                <td><strong>A EMPENHAR</strong></td>
                            </tr>";

                            foreach ($aDadosCompilacao as $sIndice => $aDadosSolicita) {
                                $sIndice = $sIndice + 4;

                                echo "<tr>";
                                echo "<td>" . $aDadosSolicita['oDados']->iSeq . "</td>";
                                echo "<td>" . $aDadosSolicita['oDados']->iCodItem . "</td>";
                                echo "<td>" . $aDadosSolicita['oDados']->sDescrItem  . "</td>";
                                //echo "<td>" . str_replace("\\n", "\n", substr(trim($aDadosSolicita['oDados']->sCompl), 0, 20)) . "</td>";
                                echo "<td>" . $aDadosSolicita['oDados']->sUnidade . "</td>";
                                echo "<td>" . $aDadosSolicita['nTotalVlrUnid'] . "</td>";
                                echo "<td>" . iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDadosSolicita['oDados']->sFornecedor)) . "</td>";


                                if (!$aDadosSolicita['oDados']->lControlaValor) {
                                    echo "<td>" . $aDadosSolicita['oDados']->nQuantMin . "/" . $aDadosSolicita['oDados']->nQuantMax . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iSolicitada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iEmpenhada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nSolicitar . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nEmpenhar . "</td>";
                                } else {
                                    echo "<td>" . $aDadosSolicita['oDados']->nQuantMin . "/" . $aDadosSolicita['oDados']->nQuantMax  . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iSolicitada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iEmpenhada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nSolicitar . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nEmpenhar . "</td>";
                                }

                                echo "</tr>";




                                /**
                                 * Total de cada numero de solicitacao
                                 */
                                $iCodigoCompilacao   = $aDados['oCompilacao'];
                                $nTotalSolicitada   += $aDadosSolicita['oDados']->iSolicitada;
                                $nTotalEmpenhada    += $aDadosSolicita['oDados']->iEmpenhada;
                                $nTotalSolicitar    += $aDadosSolicita['oDados']->nSolicitar;
                                $nTotalEmpenhar     += $aDadosSolicita['oDados']->nEmpenhar;
                                $nTotalRegistros++;
                            }

                            echo "<tr>";
                            echo "<td class=\"footer\" colspan=\"7\">  </td>";
                            echo "<td class=\"footer\"> <strong> Total: </strong> </td>";
                            echo "<td class=\"footer\"> <strong> " . $nTotalSolicitada . " </strong> </td>";
                            echo "<td class=\"footer\"> <strong> " . $$nTotalEmpenhada . " </strong> </td>";
                            echo "<td class=\"footer\"> <strong> " . $nTotalSolicitar  . " </strong> </td>";
                            echo "<td class=\"footer\"> <strong> " . $nTotalEmpenhar . " </strong> </td>";
                            echo "</tr>";
                        }
                    }

                    /**
                     * Total Geral soma os totais de cada solicitacao
                     */

                    $nTotalGeralRegistros   += $nTotalRegistros;
                    $nTotalGeralSolicitada  += $nTotalSolicitada;
                    $nTotalGeralEmpenhada   += $nTotalEmpenhada;
                    $nTotalGeralSolicitar   += $nTotalSolicitar;
                    $nTotalGeralEmpenhar    += $nTotalEmpenhar;


                    $contsheet++;
                }
            } else {

                $sIndice = 0;

                foreach ($aCgms as $index => $oFornecedor) {

                    echo "<tr class=\"header\" >";
                    echo "<td class=\"header\" colspan=\"7\"> <strong> Abertura: </strong>" .  $oFornecedor['oAbertura'] . " <strong> Compilação: </strong>" .  $oFornecedor['oCompilacao']  . " <strong> Licitação: </strong>" .  iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oFornecedor['sLicitacao']))  . " </td>";
                    echo "<td class=\"header\" colspan=\"3\"> <strong> Quantidade  </strong>";
                    echo "<td class=\"header\" colspan=\"2\">  <strong> Saldos  </strong>";
                    echo "<tr>";

                    echo
                    " <tr>
                        <td><strong>SEQ</strong></td>
                        <td><strong>ITEM</strong></td>
                        <td><strong>DESCRIÇÃO</strong></td>
                        <td><strong>COMPLEMENTO</strong></td>
                        <td><strong>UN</strong></td>
                        <td><strong>VLR. UNIT.</strong></td>
                        <td><strong>FORNECEDOR</strong></td>
                        <td><strong>QTD. MIN/MAX</strong></td>
                        <td><strong>SOLICITADA</strong></td>
                        <td><strong>EMPENHADA</strong></td>
                        <td><strong>A SOLICITAR</strong></td>
                        <td><strong>A EMPENHAR</strong></td>
                    </tr>";

                    $nTotalRegistros   = 0;
                    $nTotalSolicitada  = 0;
                    $nTotalEmpenhada   = 0;
                    $nTotalSolicitar   = 0;
                    $nTotalEmpenhar    = 0;


                    $sIndice += !$sIndice ? 5 : 2;

                    foreach ($oFornecedor['itens'] as $indice => $aDadosPosRegPreco) {




                        echo "<tr>";
                        echo "<td>" . $aDadosPosRegPreco['oDados']->iSeq . "</td>";
                        echo "<td>" . $aDadosPosRegPreco['oDados']->iCodItem . "</td>";
                        echo "<td>" . substr($aDadosPosRegPreco['oDados']->sDescrItem, 0, 20)  . "</td>";
                        echo "<td>" . str_replace("\\n", "\n", substr(trim($aDadosPosRegPreco['oDados']->sCompl), 0, 20)) . "</td>";
                        echo "<td>" . $aDadosPosRegPreco['oDados']->sUnidade . "</td>";
                        echo "<td>" . $aDadosPosRegPreco['nTotalVlrUnid'] . "</td>";
                        echo "<td>" . iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDadosPosRegPreco['oDados']->sFornecedor)) . "</td>";


                        if (!$aDadosPosRegPreco['oDados']->lControlaValor) {
                            echo "<td>" . $aDadosPosRegPreco['oDados']->nQuantMin . "/" . $aDadosPosRegPreco['oDados']->nQuantMax . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->iSolicitada . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->iEmpenhada . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->nSolicitar . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->nEmpenhar . "</td>";
                        } else {

                            echo "<td>" . $aDadosPosRegPreco['oDados']->nQuantMin . "/" . $aDadosPosRegPreco['oDados']->nQuantMax . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->iSolicitada . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->iEmpenhada . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->nSolicitar . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->nEmpenhar . "</td>";
                        }

                        /**
                         * Total de cada numero de solicitacao
                         */

                        $iCodigoCompilacao   = $oFornecedor['oCompilacao'];
                        $nTotalSolicitada   += $aDadosPosRegPreco['oDados']->iSolicitada;
                        $nTotalEmpenhada    += $aDadosPosRegPreco['oDados']->iEmpenhada;
                        $nTotalSolicitar    += $aDadosPosRegPreco['oDados']->nSolicitar;
                        $nTotalEmpenhar     += $aDadosPosRegPreco['oDados']->nEmpenhar;
                        $nTotalRegistros++;


                        $sIndice += 1;
                    }

                    //			$sIndice += 3;
                    /**
                     * Total Geral soma os totais de cada solicitacao
                     */

                    echo "</tr>";

                    $nTotalGeralRegistros   += $nTotalRegistros;
                    $nTotalGeralSolicitada  += $nTotalSolicitada;
                    $nTotalGeralEmpenhada   += $nTotalEmpenhada;
                    $nTotalGeralSolicitar   += $nTotalSolicitar;
                    $nTotalGeralEmpenhar    += $nTotalEmpenhar;

                    $contsheet++;
                }

                echo "<tr>";
                echo "<td class=\"footer\" colspan=\"7\">  </td>";
                echo "<td class=\"footer\"> <strong> Total: </strong> </td>";
                echo "<td class=\"footer\"> <strong> " . $nTotalSolicitada . " </strong> </td>";
                echo "<td class=\"footer\"> <strong> " . $nTotalEmpenhada . " </strong> </td>";
                echo "<td class=\"footer\"> <strong> " . $nTotalSolicitar  . " </strong> </td>";
                echo "<td class=\"footer\"> <strong> " . $nTotalEmpenhar . " </strong> </td>";
                echo "</tr>";
            }


            ?>


        </table>
    </div>
</body>

</html>

<?php
