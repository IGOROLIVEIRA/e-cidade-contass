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
include("libs/PHPExcel/Classes/PHPExcel.php");
$oGet        = db_utils::postMemory($_GET);
$clpcorcam   = new cl_pcorcam();
$objPHPExcel = new PHPExcel;

/**
 * matriz de entrada
 */
$what = array(
    '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�',
    '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�',
    '�', '�', '�', '�', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '=', '?', '~', '^', '>', '<', '�', '�', "�", chr(13), chr(10), "'"
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
 * Verifica as datas de cria��o do registro informadas no formulario.
 */
$dtIniCrg = implode("-", array_reverse(explode("/", $oGet->dtinicrg)));
$dtFimCrg = implode("-", array_reverse(explode("/", $oGet->dtfimcrg)));

if ((trim($dtIniCrg) != "") && (trim($dtFimCrg) != "")) {

    $sHeaderDtCriacao = "Cria��o do Registro: " . $oGet->dtinicrg . " at� " . $oGet->dtfimcrg;
    $sWhere          .= "{$sAnd} solicita.pc10_data  between '{$oGet->dtinicrg}' and '{$oGet->dtfimcrg}' ";
    $sAnd             = " and ";
} else if (trim($oGet->dtinicrg) != "") {

    $sHeaderDtCriacao = "Cria��o do Registro: " . $oGet->dtinicrg;
    $sWhere .= "{$sAnd} ( solicita.pc10_data >= '{$oGet->dtinicrg}' ) ";
    $sAnd    = " and ";
} else if (trim($oGet->dtfimcrg) != "") {

    $sHeaderDtCriacao = "Cria��o do Registro: " . $oGet->dtfimcrg;
    $sWhere .= "{$sAnd} ( solicita.pc10_data <= '{$oGet->dtfimcrg}' ) ";
    $sAnd    = " and ";
}

/**
 * Verifica as datas de validade do registro informadas no formulario.
 */
$dtIniVlrg = implode("-", array_reverse(explode("/", $oGet->dtinivlrg)));
$dtFimVlrg = implode("-", array_reverse(explode("/", $oGet->dtfimvlrg)));

if ((trim($dtIniVlrg) != "") && (trim($dtFimVlrg) != "")) {

    $sHeaderDtVal = "Validade do Registro: " . $dtIniVlrg . " at� " . $dtFimVlrg;
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
 * Verifica os numeros da solicita��o informados no formulario.
 */
if ((trim($oGet->numini) != "") && (trim($oGet->numfim) != "")) {

    $sHeaderNum = "Compila��o: " . $oGet->numini . " � " . $oGet->numfim;
    $sWhere    .= "{$sAnd} solicita.pc10_numero between '{$oGet->numini}' and '{$oGet->numfim}' ";
    $sAnd       = " and ";
} else if (trim($oGet->numini) != "") {

    $sHeaderNum = "Compila��o: " . $oGet->numini;
    $sWhere .= "{$sAnd} ( solicita.pc10_numero >= '{$oGet->numini}' ) ";
    $sAnd    = " and ";
} else if (trim($oGet->numfim) != "") {

    $sHeaderNum = "Compila��o: " . $oGet->numfim;
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
    db_redireciona('db_erros.php?fechar=true&db_erro=N�o existem registros cadastrados.');
}

$styleCabecalho = array(
    'font' => array(
        'size' => 9,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);

$styleRespostaCabecalho = array(
    'font' => array(
        'size' => 9,
        'bold' => false,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);


$styleCabecalhoCenter = array(
    'font' => array(
        'size' => 9,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);



?>



<?php

//header('Content-Type: application/octet-stream');

//header("Content-type: application/vnd.oasis.opendocument.text; charset=UTF-8");
//header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=Registro de Pre�o.doc");



//header("Content-type: application/vnd.ms-word; charset=UTF-8");

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">

<head>
    <title>Relat�rio</title>
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
            <strong>Posi��o do Registro de Pre�o</strong>
        </div>
        <table>

            <?php
            //ini_set('display_errors', 1);
            //error_reporting(E_ALL);
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
                $oDadosEstimativa->sDescrItem     = $oSolicita->pc01_descrmater;
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
                 * Verifica se controla o registro de pre�o por valor e altera o conte�do das colunas
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
                 * Se escolher quebra por departamento, desmembramos as compila��es nas suas estimativas
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


                    $objWorkSheet = $objPHPExcel->createSheet($contsheet);

                    $nTotalRegistros   = 0;
                    $nTotalSolicitada  = 0;
                    $nTotalEmpenhada   = 0;
                    $nTotalSolicitar   = 0;
                    $nTotalEmpenhar    = 0;

                    //Iniciando planilha
                    $objWorkSheet->setCellValue('A1', 'Abertura:');
                    $objWorkSheet->setCellValue('C1', $aDados['oAbertura']);
                    $objWorkSheet->setCellValue('A2', 'Compilacao:');
                    $objWorkSheet->setCellValue('C2', $aDados['oCompilacao']);
                    $objWorkSheet->setCellValue('A3', 'Licitacao:');
                    $objWorkSheet->setCellValue('C3', iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDados['sLicitacao'])));
                    $objWorkSheet->mergeCells('C3:F3');

                    $objWorkSheet->setCellValue('A4', 'Seq.');
                    $objWorkSheet->setCellValue('B4', 'Item.');
                    $objWorkSheet->setCellValue('C4', 'Descricao');
                    $objWorkSheet->setCellValue('F4', 'Complemento');
                    $objWorkSheet->setCellValue('I4', 'Unidade');
                    $objWorkSheet->setCellValue('J4', 'Vlr. Unit.');
                    $objWorkSheet->setCellValue('K4', 'Fornecedor');
                    $objWorkSheet->setCellValue('N4', 'Qtd. Max/Min');
                    $objWorkSheet->setCellValue('O4', 'Solicitada');
                    $objWorkSheet->setCellValue('P4', 'Empenhada');
                    $objWorkSheet->setCellValue('Q4', 'a Solicitar');
                    $objWorkSheet->setCellValue('R4', 'a Empenhar');

                    $objWorkSheet->mergeCells('A1:B1');
                    $objWorkSheet->mergeCells('A2:B2');
                    $objWorkSheet->mergeCells('A3:B3');
                    $objWorkSheet->mergeCells('C4:E4');
                    $objWorkSheet->mergeCells('F4:H4');
                    $objWorkSheet->mergeCells('K4:M4');

                    //cabe�alho
                    $objWorkSheet->getStyle('A1:A3')->applyFromArray($styleCabecalho);
                    $objWorkSheet->getStyle('C1:C3')->applyFromArray($styleRespostaCabecalho);
                    $objWorkSheet->getStyle('A4:A4')->applyFromArray($styleCabecalho);
                    $objWorkSheet->getStyle('B4:M4')->applyFromArray($styleCabecalhoCenter);
                    $objWorkSheet->getStyle('N4:R4')->applyFromArray($styleCabecalho);

                    $lPreenchimento = 1;

                    /**
                     * Percore os registros por dados compila��o
                     */
                    foreach ($aDados as $iIndice => $aDadosCompilacao) {



                        if (is_array($aDadosCompilacao)) {
                            $sIndice = 0;

                            echo "<tr class=\"header\">";
                            echo "<td class=\"header\" colspan=\"7\"> <strong> Abertura: </strong>" .  $aDados['oAbertura'] . " <strong> Compila��o: </strong>" .  $aDados['oCompilacao']  . " <strong> Licita��o: </strong>" .  iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDados['sLicitacao']))  . " </td>";
                            echo "<td class=\"header\" colspan=\"3\"> <strong> Quantidade  </strong>";
                            echo "<td class=\"header\" colspan=\"2\"> <strong> Saldos  </strong>";
                            echo "<tr>";
                            echo <<<HTML
        
            <tr>
            <td><strong>SEQ</strong></td>
                <td><strong>ITEM</strong></td>
                <td><strong>DESCRI��O</strong></td>
                <td><strong>COMPLEMENTO</strong></td>
                <td><strong>UN</strong></td>
                <td><strong>VLR. UNIT.</strong></td>
                <td><strong>FORNECEDOR</strong></td>
                <td><strong>QTD. MIN/MAX</strong></td>
                <td><strong>SOLICITADA</strong></td>
                <td><strong>EMPENHADA</strong></td>
                <td><strong>A SOLICITAR</strong></td>
                <td><strong>A EMPENHAR</strong></td>
            </tr>

HTML;

                            foreach ($aDadosCompilacao as $sIndice => $aDadosSolicita) {
                                $sIndice = $sIndice + 4;

                                //Coordenadas
                                $collA = 'A' . $sIndice;
                                $collB = 'B' . $sIndice;
                                $collC = 'C' . $sIndice;
                                $collD = 'D' . $sIndice;
                                $collE = 'E' . $sIndice;
                                $collF = 'F' . $sIndice;
                                $collG = 'G' . $sIndice;
                                $collH = 'H' . $sIndice;
                                $collI = 'I' . $sIndice;
                                $collJ = 'J' . $sIndice;
                                $collK = 'K' . $sIndice;
                                $collL = 'L' . $sIndice;
                                $collM = 'M' . $sIndice;
                                $collN = 'N' . $sIndice;
                                $collO = 'O' . $sIndice;
                                $collP = 'P' . $sIndice;
                                $collQ = 'Q' . $sIndice;
                                $collR = 'R' . $sIndice;


                                $lPreenchimento = $lPreenchimento == 0 ? 1 : 0;
                                echo "<tr>";
                                echo "<td>" . $aDadosSolicita['oDados']->iSeq . "</td>";
                                echo "<td>" . $aDadosSolicita['oDados']->iCodItem . "</td>";
                                echo "<td>" . substr($aDadosSolicita['oDados']->sDescrItem, 0, 20)  . "</td>";
                                echo "<td>" . str_replace("\\n", "\n", substr(trim($aDadosSolicita['oDados']->sCompl), 0, 20)) . "</td>";
                                echo "<td>" . $aDadosSolicita['oDados']->sUnidade . "</td>";
                                echo "<td>" . $aDadosSolicita['nTotalVlrUnid'] . "</td>";
                                echo "<td>" . iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDadosSolicita['oDados']->sFornecedor)) . "</td>";







                                $objWorkSheet->setCellValue($collA, $aDadosSolicita['oDados']->iSeq);
                                $objWorkSheet->setCellValue($collB, $aDadosSolicita['oDados']->iCodItem);
                                $objWorkSheet->mergeCells($collC . ':' . $collE);
                                $objWorkSheet->setCellValue($collC, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDadosSolicita['oDados']->sDescrItem)));
                                $objWorkSheet->mergeCells($collF . ':' . $collH);
                                $objWorkSheet->setCellValue($collF, str_replace("\\n", "\n", substr(trim($aDadosSolicita['oDados']->sCompl), 0, 20)));
                                $objWorkSheet->setCellValue($collI, $aDadosSolicita['oDados']->sUnidade);
                                $objWorkSheet->getStyle($collJ)->getNumberFormat()->setFormatCode('[$R$ ]#,##0.00_-');
                                $objWorkSheet->setCellValue($collJ, $aDadosSolicita['nTotalVlrUnid']);
                                $objWorkSheet->mergeCells($collK . ':' . $collM);
                                $objWorkSheet->setCellValue($collK, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDadosSolicita['oDados']->sFornecedor)));

                                if (!$aDadosSolicita['oDados']->lControlaValor) {
                                    echo "<td>" . $aDadosSolicita['oDados']->nQuantMin . "/" . $aDadosSolicita['oDados']->nQuantMax . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iSolicitada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iEmpenhada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nSolicitar . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nEmpenhar . "</td>";
                                    $objWorkSheet->setCellValue($collN, 0);
                                    $objWorkSheet->setCellValue($collO, $aDadosSolicita['oDados']->iSolicitada);
                                    $objWorkSheet->setCellValue($collP, $aDadosSolicita['oDados']->iEmpenhada);
                                    $objWorkSheet->setCellValue($collQ, $aDadosSolicita['oDados']->nSolicitar);
                                    $objWorkSheet->setCellValue($collR, $aDadosSolicita['oDados']->nEmpenhar);
                                } else {
                                    echo "<td>" . $aDadosSolicita['oDados']->nQuantMin . "/" . $aDadosSolicita['oDados']->nQuantMax  . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iSolicitada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->iEmpenhada . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nSolicitar . "</td>";
                                    echo "<td>" . $aDadosSolicita['oDados']->nEmpenhar . "</td>";
                                    $objWorkSheet->setCellValue($collN, 0);
                                    $objWorkSheet->setCellValue($collO, $aDadosSolicita['oDados']->iSolicitada);
                                    $objWorkSheet->setCellValue($collP, $aDadosSolicita['oDados']->iEmpenhada);
                                    $objWorkSheet->setCellValue($collQ, $aDadosSolicita['oDados']->nSolicitar);
                                    $objWorkSheet->setCellValue($collR, $aDadosSolicita['oDados']->nEmpenhar);
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





                                $objWorkSheet->getStyle($collA . ':' . $collR)->applyFromArray($styleRespostaCabecalho);
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

                    // Rename sheet
                    $abertura = "Abertura" . $aDados['oAbertura'];

                    $objWorkSheet->setTitle("$abertura");

                    $contsheet++;
                }
            } else {

                $sIndice = 0;

                $objWorkSheet = $objPHPExcel->createSheet($contsheet);

                foreach ($aCgms as $index => $oFornecedor) {

                    echo "<tr class=\"header\" >";
                    echo "<td class=\"header\" colspan=\"7\"> <strong> Abertura: </strong>" .  $oFornecedor['oAbertura'] . " <strong> Compila��o: </strong>" .  $oFornecedor['oCompilacao']  . " <strong> Licita��o: </strong>" .  iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oFornecedor['sLicitacao']))  . " </td>";
                    echo "<td class=\"header\" colspan=\"3\"> <strong> Quantidade  </strong>";
                    echo "<td class=\"header\" colspan=\"2\">  <strong> Saldos  </strong>";
                    echo "<tr>";
                    echo <<<HTML
        
            <tr>
            <td><strong>SEQ</strong></td>
                <td><strong>ITEM</strong></td>
                <td><strong>DESCRI��O</strong></td>
                <td><strong>COMPLEMENTO</strong></td>
                <td><strong>UN</strong></td>
                <td><strong>VLR. UNIT.</strong></td>
                <td><strong>FORNECEDOR</strong></td>
                <td><strong>QTD. MIN/MAX</strong></td>
                <td><strong>SOLICITADA</strong></td>
                <td><strong>EMPENHADA</strong></td>
                <td><strong>A SOLICITAR</strong></td>
                <td><strong>A EMPENHAR</strong></td>
            </tr>

HTML;

                    $nTotalRegistros   = 0;
                    $nTotalSolicitada  = 0;
                    $nTotalEmpenhada   = 0;
                    $nTotalSolicitar   = 0;
                    $nTotalEmpenhar    = 0;

                    //Iniciando planilha

                    $objWorkSheet->setCellValue('A1', 'Abertura:');
                    $objWorkSheet->setCellValue('C1', $oFornecedor['oAbertura']);
                    $objWorkSheet->setCellValue('A2', 'Compilacao:');
                    $objWorkSheet->setCellValue('C2', $oFornecedor['oCompilacao']);
                    $objWorkSheet->setCellValue('A3', 'Licitacao:');
                    $objWorkSheet->setCellValue('C3', iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oFornecedor['sLicitacao'])));
                    $objWorkSheet->mergeCells('C3:F3');

                    $objWorkSheet->setCellValue('A4', 'Seq.');
                    $objWorkSheet->setCellValue('B4', 'Item.');
                    $objWorkSheet->setCellValue('C4', 'Descricao');
                    $objWorkSheet->setCellValue('F4', 'Complemento');
                    $objWorkSheet->setCellValue('I4', 'Unidade');
                    $objWorkSheet->setCellValue('J4', 'Vlr. Unit.');
                    $objWorkSheet->setCellValue('K4', 'Fornecedor');
                    $objWorkSheet->setCellValue('N4', 'Qtd. Max/Min');
                    $objWorkSheet->setCellValue('O4', 'Solicitada');
                    $objWorkSheet->setCellValue('P4', 'Empenhada');
                    $objWorkSheet->setCellValue('Q4', 'a Solicitar');
                    $objWorkSheet->setCellValue('R4', 'a Empenhar');

                    $objWorkSheet->mergeCells('A1:B1');
                    $objWorkSheet->mergeCells('A2:B2');
                    $objWorkSheet->mergeCells('A3:B3');
                    $objWorkSheet->mergeCells('C4:E4');
                    $objWorkSheet->mergeCells('F4:H4');
                    $objWorkSheet->mergeCells('K4:M4');

                    //cabe�alho
                    $objWorkSheet->getStyle('A1:A3')->applyFromArray($styleCabecalho);
                    $objWorkSheet->getStyle('C1:C3')->applyFromArray($styleRespostaCabecalho);
                    $objWorkSheet->getStyle('A4:A4')->applyFromArray($styleCabecalho);
                    $objWorkSheet->getStyle('B4:M4')->applyFromArray($styleCabecalhoCenter);
                    $objWorkSheet->getStyle('N4:R4')->applyFromArray($styleCabecalho);

                    $lPreenchimento = 1;

                    $sIndice += !$sIndice ? 5 : 2;

                    foreach ($oFornecedor['itens'] as $indice => $aDadosPosRegPreco) {

                        //Coordenadas
                        $collA = 'A' . $sIndice;
                        $collB = 'B' . $sIndice;
                        $collC = 'C' . $sIndice;
                        $collD = 'D' . $sIndice;
                        $collE = 'E' . $sIndice;
                        $collF = 'F' . $sIndice;
                        $collG = 'G' . $sIndice;
                        $collH = 'H' . $sIndice;
                        $collI = 'I' . $sIndice;
                        $collJ = 'J' . $sIndice;
                        $collK = 'K' . $sIndice;
                        $collL = 'L' . $sIndice;
                        $collM = 'M' . $sIndice;
                        $collN = 'N' . $sIndice;
                        $collO = 'O' . $sIndice;
                        $collP = 'P' . $sIndice;
                        $collQ = 'Q' . $sIndice;
                        $collR = 'R' . $sIndice;

                        $lPreenchimento = $lPreenchimento == 0 ? 1 : 0;

                        $objWorkSheet->setCellValue($collA, $aDadosPosRegPreco['oDados']->iSeq);
                        $objWorkSheet->setCellValue($collB, $aDadosPosRegPreco['oDados']->iCodItem);
                        $objWorkSheet->mergeCells($collC . ':' . $collE);
                        $objWorkSheet->setCellValue($collC, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDadosPosRegPreco['oDados']->sDescrItem)));
                        $objWorkSheet->mergeCells($collF . ':' . $collH);
                        $objWorkSheet->setCellValue($collF, str_replace("\\n", "\n", substr(trim($aDadosPosRegPreco['oDados']->sCompl), 0, 20)));
                        $objWorkSheet->setCellValue($collI, $aDadosPosRegPreco['oDados']->sUnidade);
                        $objWorkSheet->getStyle($collJ)->getNumberFormat()->setFormatCode('[$R$ ]#,##0.00_-');
                        $objWorkSheet->setCellValue($collJ, $aDadosPosRegPreco['nTotalVlrUnid']);
                        $objWorkSheet->mergeCells($collK . ':' . $collM);
                        $objWorkSheet->setCellValue($collK, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $aDadosPosRegPreco['oDados']->sFornecedor)));


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
                            $objWorkSheet->setCellValue($collN, 0);
                            $objWorkSheet->setCellValue($collO, $aDadosPosRegPreco['oDados']->iSolicitada);
                            $objWorkSheet->setCellValue($collP, $aDadosPosRegPreco['oDados']->iEmpenhada);
                            $objWorkSheet->setCellValue($collQ, $aDadosPosRegPreco['oDados']->nSolicitar);
                            $objWorkSheet->setCellValue($collR, $aDadosPosRegPreco['oDados']->nEmpenhar);
                        } else {

                            echo "<td>" . $aDadosPosRegPreco['oDados']->nQuantMin . "/" . $aDadosPosRegPreco['oDados']->nQuantMax . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->iSolicitada . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->iEmpenhada . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->nSolicitar . "</td>";
                            echo "<td>" . $aDadosPosRegPreco['oDados']->nEmpenhar . "</td>";
                            $objWorkSheet->setCellValue($collN, 0);
                            $objWorkSheet->setCellValue($collO, $aDadosPosRegPreco['oDados']->iSolicitada);
                            $objWorkSheet->setCellValue($collP, $aDadosPosRegPreco['oDados']->iEmpenhada);
                            $objWorkSheet->setCellValue($collQ, $aDadosPosRegPreco['oDados']->nSolicitar);
                            $objWorkSheet->setCellValue($collR, $aDadosPosRegPreco['oDados']->nEmpenhar);
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

                        $objWorkSheet->getStyle($collA . ':' . $collR)->applyFromArray($styleRespostaCabecalho);

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

                    // Rename sheet
                    $abertura = "Abertura" . $oFornecedor['oAbertura'];

                    $objWorkSheet->setTitle("$abertura");

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



//header("Content-Disposition: attachment; Filename=Registro de Pre�o.doc");

/*
$nomefile = "registro de preco" . '_' . db_getsession('DB_instit') . ".xlsx";
header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=$nomefile");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
*/