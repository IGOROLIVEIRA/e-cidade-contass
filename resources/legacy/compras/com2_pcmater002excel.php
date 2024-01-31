<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/PHPExcel/Classes/PHPExcel.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clpcmater = new cl_pcmater;
$objPHPExcel = new PHPExcel;
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

/* Funções utilizadas durante preenchimento dos  */

function preenchimentoElementoSelecionado($i,$sheet,$item,$linhaAtual){

    if($i!=0) return false;

    $elemento = "$item->o56_codele - $item->o56_elemento - $item->o56_descr";
	$sheet->getStyle('B'.$linhaAtual)->getFont()->setBold(true);
    $sheet->setCellValue('B'.$linhaAtual, mb_convert_encoding($elemento,'UTF-8'));
    return true;

}

function imprimeSubgrupo($sheet,$item,$subgrupoAtual,$linhaAtual){

    if($item->pc04_codsubgrupo == $subgrupoAtual) return false;

    $subgrupo = "$item->pc04_codsubgrupo $item->pc03_descrgrupo =>  $item->pc04_descrsubgrupo";
    $sheet->setCellValue('B'.$linhaAtual, mb_convert_encoding($subgrupo,'UTF-8'));
    $sheet->getStyle('B'.$linhaAtual)->getFont()->setBold(true);
    return true;

}

function imprimeTotalSubgrupo ($i,$sheet,$item,$subgrupoAtual,$linhaAtual,$quantidadeItensSubgrupo){

	if ($i == 0) return false;
    if($item->pc04_codsubgrupo == $subgrupoAtual) return false;

	$sheet->getStyle('B'.$linhaAtual)->getFont()->setBold(true);
    $sheet->setCellValue('B'.$linhaAtual, "Total: $quantidadeItensSubgrupo");
    return true;

}

function parseUtf8ToIso88591($string){
    $what = array("°", chr(13), chr(10), 'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'Ã', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');
    $by = array('', '', '', 'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ');
    return iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $string));
}

/* Consulta dos itens*/

$aOrderBy= array(
    "geral"    => $ordem == "a" ? "pc01_descrmater,pc01_codmater" : "pc01_codmater",
    "sub_grupo" => $ordem == "a" ? "pc04_descrsubgrupo,pc01_descrmater" : "pc04_codsubgrupo,pc01_codmater",
    "elemento" => $ordem == "a" ? "o56_descr,pc01_descrmater" : "o56_codele,pc01_codmater"
    );
$sOrderBy = $aOrderBy[$grupo];

$sWhere = "pc01_ativo='f' and pc01_conversao is false and o56_anousu = ".db_getsession("DB_anousu");
$sWhere.= $elemento != "" ? " and o56_elemento = '$elemento'" : "";

$rsPcmater = $clpcmater->sql_record($clpcmater->sql_query_desdobra("","*",$sOrderBy,$sWhere));
$quantidadeDeItens = $clpcmater->numrows;

/* Estilização de células */

$styleTitulo = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startcolor' => array(
            'argb' => '00f703',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
    'font' => array(
        'size' => 10,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

$styleAlinhamentoVertical = array(
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$styleItensCentralizado = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
    'font' => array(
        'size' => 10,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

$objPHPExcel->getDefaultStyle()->applyFromArray($styleAlinhamentoVertical);

/* Montagem cabeçalho */

$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle('A1:H1')->applyFromArray($styleTitulo);

$aTextoCabecalho = array (
	"geral" => ["Material","Descrição do Material","Complemento","Subgrupo","Descrição do Subgrupo","Elemento","Descrição","Usuario"],
	"sub_grupo" => ["Material","Descrição do Material","Elemento","Descrição"],
	"elemento" => ["Material","Descrição do Material","Subgrupo","Descrição do Sub-Grupo"]
);

$aWidthColunas = array (
    "geral" => [10,40,40,10,40,17,40,50],
    "sub_grupo" => [10,70,17,50],
    "elemento" => [10,70,17,50]
);

$aQuantidadeColunas = array (
	"geral" => 8,
	"sub_grupo" => 4,
	"elemento" => 4
);

$quantidadeColunas = $aQuantidadeColunas[$grupo];
$aColunas = ["A","B","C","D","E","F","G","H"];
$aColunasCabecalho = ["A1","B1","C1","D1","E1","F1","G1","H1"];

for($i=0; $i < $quantidadeColunas;  $i++){
    $sTextoCabecalho = mb_convert_encoding($aTextoCabecalho[$grupo][$i],'UTF-8');
	$sheet->setCellValue($aColunasCabecalho[$i], $sTextoCabecalho);
    $sheet->getColumnDimension($aColunas[$i])->setWidth($aWidthColunas[$grupo][$i]);
}

/* Iniciaçização de variáveis*/
$quantidadeItensSubgrupo = 0;
$subgrupoAtual = 0;
$total = 0;
$linhaAtual = 1;

for ($i = 0; $i < $quantidadeDeItens; $i++) {

    if($grupo == "geral"){

        $linhaAtual = $i + 2;
        $item = db_utils::fieldsMemory($rsPcmater,$i);
        $sheet->setCellValue('A'.$linhaAtual, $item->pc01_codmater);
        $sheet->setCellValue('B'.$linhaAtual, parseUtf8ToIso88591($item->pc01_descrmater));
        $sheet->setCellValue('C'.$linhaAtual, parseUtf8ToIso88591($item->pc01_complmater));
        $sheet->setCellValue('D'.$linhaAtual, $item->pc04_codsubgrupo);
        $sheet->setCellValue('E'.$linhaAtual, parseUtf8ToIso88591($item->pc04_descrsubgrupo));
        $sheet->setCellValue('F'.$linhaAtual, $item->o56_elemento);
        $sheet->setCellValue('G'.$linhaAtual, parseUtf8ToIso88591($item->o56_descr));
        $sheet->setCellValue('H'.$linhaAtual, $item->nome,'UTF-8');

        $sheet->getStyle('A'.$linhaAtual)->applyFromArray($styleItensCentralizado);
        $sheet->getStyle('D'.$linhaAtual)->applyFromArray($styleItensCentralizado);
        $sheet->getStyle('F'.$linhaAtual)->applyFromArray($styleItensCentralizado);
        $sheet->getStyle('F'.$linhaAtual)->getNumberFormat()->setFormatCode('0');

    }

    if($grupo == "sub_grupo"){

        $linhaAtual++;

        $item = db_utils::fieldsMemory($rsPcmater,$i);

        $impressaoTotalSubgrupo = imprimeTotalSubgrupo($i,$sheet,$item,$subgrupoAtual,$linhaAtual,$quantidadeItensSubgrupo);
        $linhaAtual = $impressaoTotalSubgrupo ? $linhaAtual + 2 : $linhaAtual;

        $invocacaoFuncaoImprimeSubGrupo = imprimeSubgrupo($sheet,$item,$subgrupoAtual,$linhaAtual);
        $subgrupoAtual = $invocacaoFuncaoImprimeSubGrupo ? $item->pc04_codsubgrupo : $subgrupoAtual;
        $linhaAtual = $invocacaoFuncaoImprimeSubGrupo ? $linhaAtual + 2 : $linhaAtual;
        $quantidadeItensSubgrupo = $invocacaoFuncaoImprimeSubGrupo ? 0 : $quantidadeItensSubgrupo++;

        $sheet->setCellValue('A'.$linhaAtual, $item->pc01_codmater);
        $sheet->setCellValue('B'.$linhaAtual, parseUtf8ToIso88591($item->pc01_descrmater) );
        $sheet->setCellValue('C'.$linhaAtual, $item->o56_elemento,'UTF-8');
        $sheet->setCellValue('D'.$linhaAtual, parseUtf8ToIso88591($item->o56_descr));

        $sheet->getStyle('A'.$linhaAtual)->applyFromArray($styleItensCentralizado);
        $sheet->getStyle('C'.$linhaAtual)->applyFromArray($styleItensCentralizado);
        $sheet->getStyle('C'.$linhaAtual)->getNumberFormat()->setFormatCode('0');

        $quantidadeItensSubgrupo++;

    }

    if($grupo == "elemento"){

        $linhaAtual++;
        $item = db_utils::fieldsMemory($rsPcmater,$i);
        $preenchimentoElemento = preenchimentoElementoSelecionado($i,$sheet,$item,$linhaAtual);
        $linhaAtual = $preenchimentoElemento == true ? $linhaAtual + 2 : $linhaAtual;

        $sheet->setCellValue('A'.$linhaAtual, $item->pc01_codmater);
        $sheet->setCellValue('B'.$linhaAtual, parseUtf8ToIso88591($item->pc01_descrmater));
        $sheet->setCellValue('C'.$linhaAtual, $item->pc04_codsubgrupo,'UTF-8');
        $sheet->setCellValue('D'.$linhaAtual, parseUtf8ToIso88591($item->pc04_descrsubgrupo));

        $sheet->getStyle('A'.$linhaAtual)->applyFromArray($styleItensCentralizado);
        $sheet->getStyle('C'.$linhaAtual)->applyFromArray($styleItensCentralizado);

    }

}

$linhaAtual++;
$objPHPExcel->getActiveSheet()->getStyle('B'.$linhaAtual)->getFont()->setBold(true);
$sheet->setCellValue('B'.$linhaAtual, "Total Geral: $clpcmater->numrows");
$sheet->getStyle("B2:B".$quantidadeDeItens)->getAlignment()->setWrapText(true);

$namefile = "Itens" . db_getsession('DB_instit') . ".xlsx";

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=$namefile");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
