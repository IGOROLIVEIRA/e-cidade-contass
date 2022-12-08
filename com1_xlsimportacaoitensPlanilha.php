<?php
//ini_set('display_errors', 'on');
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");
require_once("classes/db_pcorcam_classe.php");
include("libs/PHPExcel/Classes/PHPExcel.php");
$oGet        = db_utils::postMemory($_GET);
$clpcorcam   = new cl_pcorcam();
$objPHPExcel = new PHPExcel;

/**
 * matriz de entrada
 */
$what = array(
    'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û',
    'Ä', 'Ã', 'À', 'Á', 'Â', 'Ê', 'Ë', 'È', 'É', 'Ï', 'Ì', 'Í', 'Ö', 'Õ', 'Ò', 'Ó', 'Ô', 'Ü', 'Ù', 'Ú', 'Û',
    'ñ', 'Ñ', 'ç', 'Ç', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', '°', "°", chr(13), chr(10), "'"
);

/**
 * matriz de saida
 */
$by = array(
    'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
    'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U',
    'n', 'N', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', " ", " ", " ", " "
);

//Inicio
$sheet = $objPHPExcel->getActiveSheet();

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
            'argb' => 'FFFFFFFF',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
    'font' => array(
        'size' => 12,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    ),
);
$styleTitulo1 = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
    'font' => array(
        'size' => 10,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);
$styleResTitulo1 = array(
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
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);
$styleItens2 = array(
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
$styleItens = array(
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
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);

//Iniciando planilha
$sheet->setCellValue('A1', str_replace($what, $by, 'IMPORTAÇÃO DE ITENS'));

//merge das cells
$sheet->mergeCells('A1:H5');
//cabeçalho
$sheet->getStyle('A1:H5')->applyFromArray($styleTitulo);

//itens
$sheet->setCellValue('A6', 'Descricao do Material');
$sheet->setCellValue('B6', 'Complemento Material');
$sheet->setCellValue('C6', 'Material Permanente/Servico');
$sheet->setCellValue('D6', 'Cod do Subgrupo');
$sheet->setCellValue('E6', 'Material de Obra');
$sheet->setCellValue('F6', 'Tabela');
$sheet->setCellValue('G6', 'Taxa');
$sheet->setCellValue('H6', 'Reduzido do Desdobramento');


$sheet->getStyle('A6:H6')->applyFromArray($styleItens2);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);


$objPHPExcel->getActiveSheet()->protectCells('A6:H6', 'php');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);


for ($i = 0; $i < 1; $i++) {
    $numrow = $i + 7;
    $collA = 'A' . $numrow;
    $collB = 'B' . $numrow;
    $collC = 'C' . $numrow;
    $collD = 'D' . $numrow;
    $collE = 'E' . $numrow;
    $collF = 'F' . $numrow;
    $collG = 'G' . $numrow;
    $collH = 'H' . $numrow;
    $collI = 'I' . $numrow;
    $collJ = 'J' . $numrow;
    $collK = 'K' . $numrow;
    $collL = 'L' . $numrow;
    $collM = 'M' . $numrow;
}


$sheet->getStyle('A7:H1000')->applyFromArray($styleItens);
$sheet->getStyle('A7:H1000')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$sheet
    ->getStyle('A7:H1000')
    ->getAlignment()
    ->setWrapText(true);

$nomefile = "Itens" . db_getsession('DB_instit') . ".xlsx";


header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=$nomefile");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
