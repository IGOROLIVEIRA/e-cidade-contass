<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");
include("libs/PHPExcel/Classes/PHPExcel.php");
$oGet        = db_utils::postMemory($_GET);
$objPHPExcel = new PHPExcel;

/**
 * matriz de entrada
 */
$what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û',
    'Ä','Ã','À','Á','Â','Ê','Ë','È','É','Ï','Ì','Í','Ö','Õ','Ò','Ó','Ô','Ü','Ù','Ú','Û',
    'ñ','Ñ','ç','Ç','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','°', "°",chr(13),chr(10),"'");

/**
 * matriz de saida
 */
$by = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u',
    'A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U',
    'n','N','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ', " "," "," "," ");

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
$sheet->setCellValue('A1',str_replace($what, $by, 'IMPORTAÇÃO DE ABASTECIMENTO'));

//merge das cells
$sheet->mergeCells('A1:O5');
//cabeçalho
$sheet->getStyle('A1:O5')->applyFromArray($styleTitulo);

//itens
$sheet->setCellValue('A6','Cod. Abast.');
$sheet->setCellValue('B6','Data');
$sheet->setCellValue('C6','Horario');
$sheet->setCellValue('D6','Placa');
$sheet->setCellValue('E6','Motorista');
$sheet->setCellValue('F6','CPF');
$sheet->setCellValue('G6','Unidade');
$sheet->setCellValue('H6','Subunidade');
$sheet->setCellValue('I6','Combustivel');
$sheet->setCellValue('J6','KM Abast');
$sheet->setCellValue('K6','Qtde. Litros');
$sheet->setCellValue('L6','Preco Unit');
$sheet->setCellValue('M6','Valor');
$sheet->setCellValue('N6','Status');
$sheet->setCellValue('O6','Produto');


$sheet->getStyle('A6:O6')->applyFromArray($styleItens2);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(60);

$objPHPExcel->getActiveSheet()->protectCells('A6:O6', 'php');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true); 

$sheet->getStyle('A7:O1000')->applyFromArray($styleItens);
$sheet->getStyle('A7:O1000')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);    
$objPHPExcel->getActiveSheet()->getStyle("B1:B1000")->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );


$nomefile = "Abastecimento_".db_getsession('DB_instit').".xlsx";


    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=$nomefile" );
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');

?>