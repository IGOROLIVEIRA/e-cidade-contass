<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");
require_once("classes/db_pcorcam_classe.php");
include("libs/PHPExcel/Classes/PHPExcel.php");

$styleItens1 = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => 'FF000000'),
        ),
    ),
    'font' => array(
        'size' => 9,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => '00f703'
        )
    ),
    'font' => array(
        'size' => 10,
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
);

//ini_set("display_errors", "on");

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();




// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setCellValue('A1', 'Sequencia');
$sheet->setCellValue('B1', 'Cod. Material');
$sheet->setCellValue('C1', 'Quantidade');


$sheet->getStyle('A1:C1')->applyFromArray($styleItens2);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);


$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->protectCells('A1:C1', 'PHPExcel');
$objPHPExcel->getActiveSheet()
    ->getStyle('C2:C2000')
    ->getProtection()->setLocked(
        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
    );

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Dados do item');



$result = db_query("select pc11_seq,pc16_codmater,pc17_unid from solicitem
inner join solicitempcmater on pc16_solicitem = pc11_codigo
inner join solicitemunid on pc17_codigo = pc11_codigo
where pc11_numero = $pc11_numero");
if (pg_numrows($result) != 0) {
    $numrows = pg_numrows($result);
    $numcell = 1;
    for ($i = 0; $i < $numrows; $i++) {

        $celulaA = "A" . ($numcell + 1);
        $celulaB = "B" . ($numcell + 1);


        $item = db_utils::fieldsMemory($result, $i);
        $sheet->setCellValue($celulaA, $item->pc11_seq);
        $sheet->setCellValue($celulaB, $item->pc16_codmater);
        $numcell++;
    }
}


$sheet->getStyle('A2:C1000')->applyFromArray($styleItens1);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);


$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=planilha_itens_estimativa.xlsx");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
