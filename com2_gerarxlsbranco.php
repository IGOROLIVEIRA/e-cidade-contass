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
$oGet        = db_utils::postMemory($_GET);
$clpcorcam   = new cl_pcorcam();
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
$by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u',
    'A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U',
    'n','N','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ', " "," "," "," ");

$result_fornecedores = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"DISTINCT pc22_codorc,pc81_codproc,pc80_criterioadjudicacao",null,"pc20_codorc = $pc22_codorc limit 1"));
db_fieldsmemory($result_fornecedores,0);

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
            'argb' => 'FFA0A0A0',
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
            'argb' => 'FFA0A0A0',
        ),
        'endcolor' => array(
            'argb' => 'FFFFFFFF',
        ),
    ),
    'font' => array(
        'size' => 10,
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
$sheet->setCellValue('A1','Orcamento de Processo de Compra Numero: '.$pc81_codproc.' do Processo de Compra');
$sheet->getStyle('A1:K1')->applyFromArray($styleTitulo);
$sheet->mergeCells('A1:K1');
$sheet->setCellValue('E2',$pc22_codorc);
$sheet->setCellValue('A2','Codigo do Orcamento:');
$sheet->mergeCells('A2:D2');
$sheet->mergeCells('E2:k2');
$sheet->setCellValue('A3','Codigo do Orcamento do Fornecedor:');
$sheet->mergeCells('A3:D3');
$sheet->mergeCells('E3:K3');
$sheet->setCellValue('A4','CPF / CNPJ:');
$sheet->mergeCells('A4:D4');
$sheet->mergeCells('E4:K4');
$sheet->setCellValue('A5','Nome / Razao Social:');
$sheet->mergeCells('A5:D5');
$sheet->mergeCells('E5:K5');
//cabeçalho
$sheet->getStyle('A2:A5')->applyFromArray($styleTitulo1);
$sheet->getStyle('B2:B5')->applyFromArray($styleTitulo1);
$sheet->getStyle('C2:C5')->applyFromArray($styleTitulo1);
$sheet->getStyle('D2:D5')->applyFromArray($styleTitulo1);
//resposta cabeçalho
$sheet->getStyle('E2:K5')->applyFromArray($styleResTitulo1);

$sheet->setCellValue('A6','Cod. Item');
$sheet->setCellValue('B6','Seq. Item');
$sheet->setCellValue('C6','Servico Material');
$sheet->mergeCells('C6:F6');
$sheet->setCellValue('G6','UN');
$sheet->setCellValue('H6','Qtde');
if($pc80_criterioadjudicacao == 3){
    $sheet->setCellValue('I6','Valor Unit.');
}else{
    $sheet->setCellValue('I6','Taxa/Tabela %');
}
$sheet->setCellValue('J6','Valor Total');
$sheet->setCellValue('K6','Marca');
$sheet->getStyle('A6:K6')->applyFromArray($styleItens2);

//cria protecao na planilha
//senha para alteração
$sheet->getProtection()->setPassword('PHPExcel');
$sheet->getProtection()->setSheet(true);
$sheet->getProtection()->setSort(true);
$sheet->getProtection()->setInsertRows(true);
$sheet->getProtection()->setFormatCells(true);
$sheet->getStyle('E4')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$sheet->getStyle('E4')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$sheet->getStyle('E5')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

//itens orcamento
$result_itens = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"distinct pc22_codorc,pc01_codmater,pc11_seq,pc01_descrmater,m61_abrev,pc11_quant",null,"pc20_codorc = $pc22_codorc"));
$numrows_itens = $clpcorcam->numrows;

for ($i = 0; $i < $numrows_itens; $i ++){
    db_fieldsmemory($result_itens, $i);
    $numrow = $i + 7;
    $collA = 'A'.$numrow;
    $collB = 'B'.$numrow;
    $collC = 'C'.$numrow;
    $collF = 'F'.$numrow;
    $collG = 'G'.$numrow;
    $collH = 'H'.$numrow;
    $collI = 'I'.$numrow;
    $collJ = 'J'.$numrow;
    $collK = 'K'.$numrow;
    $sheet->mergeCells($collC.':'.$collF);
    $sheet->setCellValue($collA,$pc01_codmater);
    $sheet->setCellValue($collB,$pc11_seq);
    $sheet->setCellValue($collC,iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $pc01_descrmater)));
    $sheet->setCellValue($collG,$m61_abrev);
    $sheet->setCellValue($collH,$pc11_quant);
    if($pc80_criterioadjudicacao == 3) {
        //formatacao na cell valor unitario
        $sheet->getStyle($collI)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
        //formula multiplicacao
        $sheet->setCellValue($collJ,'='.$collH.'*'.$collI);
        //formatando os itens
        $sheet->getStyle($collA.':'.$collK)->applyFromArray($styleItens);
        //libera celulas para alteracao
        $sheet->getStyle($collI)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle($collK)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    }else{
        //formatando os itens
        $sheet->getStyle($collA.':'.$collK)->applyFromArray($styleItens);
        //libera celulas para alteracao
        $sheet->getStyle($collI)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle($collJ)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle($collK)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    }
}
$styleTotal = array(
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

//ultima linha itens
$lastCell = 'J'.($numrows_itens + 6);

//linha texto valor total
$totalCellH = 'H'.($numrows_itens + 7);
$totalCellI = 'I'.($numrows_itens + 7);

//linha valor total
$totalCellJ = 'J'.($numrows_itens + 7);
$totalCellK = 'K'.($numrows_itens + 7);

$sheet->getStyle($totalCellI.':'.$totalCellJ)->applyFromArray($styleTotal);

$sheet->setCellValue($totalCellI,'Valor Total:');

$formula = '=(SUM(J7:'.$lastCell.'))';
//valor Total
$sheet->setCellValue($totalCellJ,$formula);
$sheet->getStyle($totalCellJ)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

$nomefile = "prc_".$pc81_codproc.'_'.db_getsession('DB_instit').".xlsx";


    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=$nomefile" );
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');

?>