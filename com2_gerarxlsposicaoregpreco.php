<?php
//ini_set('display_errors','on');
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
$what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û',
    'Ä','Ã','À','Á','Â','Ê','Ë','È','É','Ï','Ì','Í','Ö','Õ','Ò','Ó','Ô','Ü','Ù','Ú','Û',
    'ñ','Ñ','ç','Ç','-','(',')',',',';',':','|','!','"','#','$','%','&','=','?','~','^','>','<','ª','°', "°",chr(13),chr(10),"'");

/**
 * matriz de saida
 */
$by = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u',
    'A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U',
    'n','N','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ', " "," "," "," ");

/**
 * Verifica as datas de criação do registro informadas no formulario.
 */
$dtIniCrg = implode("-", array_reverse(explode("/", $oGet->dtinicrg)));
$dtFimCrg = implode("-", array_reverse(explode("/", $oGet->dtfimcrg)));

if ((trim($dtIniCrg) != "") && (trim($dtFimCrg) != "")) {

    $sHeaderDtCriacao = "Criação do Registro: ".$oGet->dtinicrg." até ".$oGet->dtfimcrg;
    $sWhere          .= "{$sAnd} solicita.pc10_data  between '{$oGet->dtinicrg}' and '{$oGet->dtfimcrg}' ";
    $sAnd             = " and ";
} else if (trim($oGet->dtinicrg) != "") {

    $sHeaderDtCriacao = "Criação do Registro: ".$oGet->dtinicrg;
    $sWhere .= "{$sAnd} ( solicita.pc10_data >= '{$oGet->dtinicrg}' ) ";
    $sAnd    = " and ";
} else if (trim($oGet->dtfimcrg) != "") {

    $sHeaderDtCriacao = "Criação do Registro: ".$oGet->dtfimcrg;
    $sWhere .= "{$sAnd} ( solicita.pc10_data <= '{$oGet->dtfimcrg}' ) ";
    $sAnd    = " and ";
}

/**
 * Verifica as datas de validade do registro informadas no formulario.
 */
$dtIniVlrg = implode("-", array_reverse(explode("/", $oGet->dtinivlrg)));
$dtFimVlrg = implode("-", array_reverse(explode("/", $oGet->dtfimvlrg)));

if ((trim($dtIniVlrg) != "") && (trim($dtFimVlrg) != "")) {

    $sHeaderDtVal = "Validade do Registro: ".$dtIniVlrg." até ".$dtFimVlrg;
    $sWhere      .= "{$sAnd} ( pc54_datainicio >= '{$dtIniVlrg}' and pc54_datatermino <= '{$dtFimVlrg}' )  ";
    $sAnd         = " and ";
} else if (trim($dtIniVlrg) != "") {

    $sHeaderDtVal = "Validade do Registro: ".$dtIniVlrg;
    $sWhere      .= "{$sAnd} ( pc54_datainicio >= '{$dtIniVlrg}' ) ";
    $sAnd         = " and ";
} else if (trim($dtFimVlrg) != "") {

    $sHeaderDtVal = "Validade do Registro: ".$dtFimVlrg;
    $sWhere .= "{$sAnd} ( pc54_datatermino <= '{$dtFimVlrg}' ) ";
    $sAnd    = " and ";
}

/**
 * Verifica os numeros da solicitação informados no formulario.
 */
if ((trim($oGet->numini) != "") && (trim($oGet->numfim) != "")) {

    $sHeaderNum = "Compilação: ".$oGet->numini." á ".$oGet->numfim;
    $sWhere    .= "{$sAnd} solicita.pc10_numero between '{$oGet->numini}' and '{$oGet->numfim}' ";
    $sAnd       = " and ";
} else if (trim($oGet->numini) != "") {

    $sHeaderNum = "Compilação: ".$oGet->numini;
    $sWhere .= "{$sAnd} ( solicita.pc10_numero >= '{$oGet->numini}' ) ";
    $sAnd    = " and ";
} else if (trim($oGet->numfim) != "") {

    $sHeaderNum = "Compilação: ".$oGet->numfim;
    $sWhere .= "{$sAnd} ( solicita.pc10_numero <= '{$oGet->numfim}' ) ";
    $sAnd    = " and ";
}

/**
 * Verifica os itens selecionados no formulario.
 */
if(trim($oGet->itens) != "") {

    $sHeaderItens = "Itens: ( ".$oGet->itens." )";
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
//db_criatabela($rsSql);exit;

$iRsSql  = pg_num_rows($rsSql);

if ($iRsSql == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
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
//    'borders' => array(
//        'allborders' => array(
//            'style' => PHPExcel_Style_Border::BORDER_THIN,
//            'color' => array('argb' => 'FF000000'),
//        ),
//    ),
//    'fill' => array(
//        'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
//        'rotation' => 90,
//        'startcolor' => array(
//            'argb' => 'FFA0A0A0',
//        ),
//        'endcolor' => array(
//            'argb' => 'FFFFFFFF',
//        ),
//    ),
    'font' => array(
        'size' => 9,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

/**
 * Agrupa os registros do record set retornado pelo sql
 */
for ( $iInd = 0; $iInd  < $iRsSql; $iInd++ ) {

    $oSolicita   = db_utils::fieldsMemory($rsSql, $iInd);
    $oCompilacao = new compilacaoRegistroPreco($oSolicita->pc11_numero);
    $oLicitacao  = $oCompilacao->getLicitacao();

    $sLicitacao = "";
    if ($oLicitacao) {

        $sLicitacao  = "{$oLicitacao->getEdital()} / {$oLicitacao->getAno()} - ";
        $sLicitacao .= "{$oLicitacao->getModalidade()->getDescricao()}";
    }

    $oSolicita->oDadosFornecedor   = $oCompilacao->getFornecedorItem($oSolicita->pc01_codmater, $oSolicita->pc11_codigo);
    if (empty($oSolicita->oDadosFornecedor->vencedor)) {
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

    if ( !isset($aDadosPosRegPreco[$oSolicita->pc10_numero][$oSolicita->pc11_numero][$oSolicita->pc11_seq]) ) {

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
foreach ($aDadosPosRegPreco as $iNroSolicitacao => $aDados ) {

    $nTotalRegistros   = 0;
    $nTotalSolicitada  = 0;
    $nTotalEmpenhada   = 0;
    $nTotalSolicitar   = 0;
    $nTotalEmpenhar    = 0;

    //Inicio
    $sheet = $objPHPExcel->getActiveSheet();

//Iniciando planilha
    $sheet->setCellValue('A1','Abertura:');
    $sheet->setCellValue('C1',$aDados['oAbertura']);
    $sheet->setCellValue('A2','Compilacao:');
    $sheet->setCellValue('C2',$aDados['oCompilacao']);
    $sheet->setCellValue('A3','Licitacao:');
    $sheet->setCellValue('C3',iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $aDados['sLicitacao'])));
    $sheet->mergeCells('C3:F3');

    $sheet->setCellValue('A4','Seq.');
    $sheet->setCellValue('B4','Item.');
    $sheet->setCellValue('C4','Descricao');
    $sheet->setCellValue('F4','Complemento');
    $sheet->setCellValue('I4','Unidade');
    $sheet->setCellValue('J4','Vlr. Unit.');
    $sheet->setCellValue('K4','Fornecedor');
    $sheet->setCellValue('N4','Qtd. Max/Min');
    $sheet->setCellValue('O4','Solicitada');
    $sheet->setCellValue('P4','Empenhada');
    $sheet->setCellValue('Q4','a Solicitar');
    $sheet->setCellValue('R4','a Empenhar');

    $sheet->mergeCells('A1:B1');
    $sheet->mergeCells('A2:B2');
    $sheet->mergeCells('A3:B3');
    $sheet->mergeCells('C4:E4');
    $sheet->mergeCells('F4:H4');
    $sheet->mergeCells('K4:M4');

//cabeçalho
    $sheet->getStyle('A1:A3')->applyFromArray($styleCabecalho);
    $sheet->getStyle('C1:C3')->applyFromArray($styleRespostaCabecalho);
    $sheet->getStyle('A4:A4')->applyFromArray($styleCabecalho);
    $sheet->getStyle('B4:M4')->applyFromArray($styleCabecalhoCenter);
    $sheet->getStyle('N4:R4')->applyFromArray($styleCabecalho);

    $lPreenchimento = 1;

    /**
     * Percore os registros por dados compilação
     */
    foreach ($aDados as $iIndice => $aDadosCompilacao ) {

        if (is_array($aDadosCompilacao)) {

            foreach ($aDadosCompilacao as $sIndice => $aDadosSolicita) {
                $sIndice = $sIndice + 4;

                //Coordenadas
                $collA = 'A'.$sIndice;
                $collB = 'B'.$sIndice;
                $collC = 'C'.$sIndice;
                $collD = 'D'.$sIndice;
                $collE = 'E'.$sIndice;
                $collF = 'F'.$sIndice;
                $collG = 'G'.$sIndice;
                $collH = 'H'.$sIndice;
                $collI = 'I'.$sIndice;
                $collJ = 'J'.$sIndice;
                $collK = 'K'.$sIndice;
                $collL = 'L'.$sIndice;
                $collM = 'M'.$sIndice;
                $collN = 'N'.$sIndice;
                $collO = 'O'.$sIndice;
                $collP = 'P'.$sIndice;
                $collQ = 'Q'.$sIndice;
                $collR = 'R'.$sIndice;


                $lPreenchimento = $lPreenchimento == 0 ? 1 : 0;

                $sheet->setCellValue($collA,$aDadosSolicita['oDados']->iSeq);
                $sheet->setCellValue($collB,$aDadosSolicita['oDados']->iCodItem);
                $sheet->mergeCells($collC.':'.$collE);
                $sheet->setCellValue($collC,$aDadosSolicita['oDados']->sDescrItem);
                $sheet->mergeCells($collF.':'.$collH);
                $sheet->setCellValue($collF,str_replace("\\n", "\n",substr(trim($aDadosSolicita['oDados']->sCompl), 0, 20)));
                $sheet->setCellValue($collI,$aDadosSolicita['oDados']->sUnidade);
                $sheet->getStyle($collJ)->getNumberFormat()->setFormatCode('[$R$ ]#,##0.00_-');
                $sheet->setCellValue($collJ,$aDadosSolicita['nTotalVlrUnid']);
                $sheet->mergeCells($collK.':'.$collM);
                $sheet->setCellValue($collK,iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $aDadosSolicita['oDados']->sFornecedor)));

                if (!$aDadosSolicita['oDados']->lControlaValor) {
                    $sheet->setCellValue($collN,0);
                    $sheet->setCellValue($collO,$aDadosSolicita['oDados']->iSolicitada);
                    $sheet->setCellValue($collP,$aDadosSolicita['oDados']->iEmpenhada);
                    $sheet->setCellValue($collQ,$aDadosSolicita['oDados']->nSolicitar);
                    $sheet->setCellValue($collR,$aDadosSolicita['oDados']->nEmpenhar);

                }else{
                    $sheet->setCellValue($collN,0);
                    $sheet->setCellValue($collO,$aDadosSolicita['oDados']->iSolicitada);
                    $sheet->setCellValue($collP,$aDadosSolicita['oDados']->iEmpenhada);
                    $sheet->setCellValue($collQ,$aDadosSolicita['oDados']->nSolicitar);
                    $sheet->setCellValue($collR,$aDadosSolicita['oDados']->nEmpenhar);
                }

                /**
                 * Total de cada numero de solicitacao
                 */
                $iCodigoCompilacao   = $aDados['oCompilacao'];
                $nTotalSolicitada   += $aDadosSolicita['oDados']->iSolicitada;
                $nTotalEmpenhada    += $aDadosSolicita['oDados']->iEmpenhada;
                $nTotalSolicitar    += $aDadosSolicita['oDados']->nSolicitar;
                $nTotalEmpenhar     += $aDadosSolicita['oDados']->nEmpenhar;
                $nTotalRegistros++;
                $sheet->getStyle($collA.':'.$collR)->applyFromArray($styleRespostaCabecalho);

            }
        }
    }

//    $oPdf->setfont('arial','b',8);
//    $oPdf->cell(279, 1,    ''                                                                            , "T", 1, "L", 0);
//    $oPdf->cell(113, $alt, 'TOTAL DO REGISTRO DE PRECO:'                                                 ,   0, 0, "R", 0);
//    $oPdf->cell(16,  $alt, $iCodigoCompilacao                                                            ,   0, 0, "R", 0);
//    $oPdf->cell(32,  $alt, $nTotalRegistros                                                              ,   0, 0, "R", 0);
//    $oPdf->cell(18,  $alt, ''                                                                            ,   0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, ($aDadosSolicita['oDados']->lControlaValor ? db_formatar($nTotalSolicitada, 'v', " ", $casadec) : $nTotalSolicitada),   0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, ($aDadosSolicita['oDados']->lControlaValor ? db_formatar($nTotalEmpenhada, 'v', " ", $casadec) : $nTotalEmpenhada),   0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, ($aDadosSolicita['oDados']->lControlaValor ? db_formatar($nTotalSolicitar, 'v', " ", $casadec) : $nTotalSolicitar),   0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, ($aDadosSolicita['oDados']->lControlaValor ? db_formatar($nTotalEmpenhar, 'v', " ", $casadec) : $nTotalEmpenhar),   0, 1, "R", 0);

    /**
     * Total Geral soma os totais de cada solicitacao
     */

    $nTotalGeralRegistros   += $nTotalRegistros;
    $nTotalGeralSolicitada  += $nTotalSolicitada;
    $nTotalGeralEmpenhada   += $nTotalEmpenhada;
    $nTotalGeralSolicitar   += $nTotalSolicitar;
    $nTotalGeralEmpenhar    += $nTotalEmpenhar;

}

//if ($lTotalGeral) {
//    $oPdf->cell(113, $alt, 'TOTAL GERAL:'                                                                 , 0, 0, "R", 0);
//    $oPdf->cell(16,  $alt, ''                                                                             , 0, 0, "R", 0);
//    $oPdf->cell(32,  $alt, $nTotalGeralRegistros                                                          , 0, 0, "R", 0);
//    $oPdf->cell(18,  $alt, ''                                                                             , 0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, $nTotalGeralSolicitada                                                         , 0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, $nTotalGeralEmpenhada                                                          , 0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, $nTotalGeralSolicitar                                                          , 0, 0, "R", 0);
//    $oPdf->cell(25,  $alt, $nTotalGeralEmpenhar                                                           , 0, 1, "R", 0);
//}


$nomefile = "registro de preco".'_'.db_getsession('DB_instit').".xlsx";


header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=$nomefile" );
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
