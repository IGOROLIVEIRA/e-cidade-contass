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
$by = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u',
    'A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U',
    'n','N','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ', " "," "," "," ");

$result_fornecedores = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"DISTINCT pc22_codorc,pc81_codproc,pc80_criterioadjudicacao,pc80_resumo",null,"pc20_codorc = $pc22_codorc limit 1"));
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
$sheet->setCellValue('A2','Codigo do Orcamento:');
$sheet->setCellValue('A3','Objeto:');
$sheet->setCellValue('A4','Codigo do Orcamento do Fornecedor:');
$sheet->setCellValue('A5','CPF / CNPJ:');
$sheet->setCellValue('A6','Nome / Razao Social:');
$sheet->setCellValue('E2',$pc22_codorc);
$sheet->setCellValue('E3',iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $pc80_resumo)));
//merge das cells
$sheet->mergeCells('A1:S1');
$sheet->mergeCells('A2:D2');
$sheet->mergeCells('A3:D3');
$sheet->mergeCells('A4:D4');
$sheet->mergeCells('A5:D5');
$sheet->mergeCells('A6:D6');
$sheet->mergeCells('E2:S2');
$sheet->mergeCells('E3:S3');
$sheet->mergeCells('E4:S4');
$sheet->mergeCells('E5:S5');
$sheet->mergeCells('E6:S6');
//cabeçalho
$sheet->getStyle('A1:S1')->applyFromArray($styleTitulo);
$sheet->getStyle('A2:A6')->applyFromArray($styleTitulo1);
$sheet->getStyle('B2:B6')->applyFromArray($styleTitulo1);
$sheet->getStyle('C2:C6')->applyFromArray($styleTitulo1);
$sheet->getStyle('D2:D6')->applyFromArray($styleTitulo1);
//resposta cabeçalho
$sheet->getStyle('E2:S6')->applyFromArray($styleResTitulo1);
//itens
$sheet->setCellValue('A7','Cod. Item');
$sheet->setCellValue('B7','Seq. Item');
$sheet->setCellValue('C7','Servico Material');
$sheet->setCellValue('M7','UN');
$sheet->setCellValue('N7','Qtde');
if($pc80_criterioadjudicacao == 3){
    $sheet->setCellValue('O7','Valor Unit.');
}else{
    $sheet->setCellValue('O7','Taxa/Tabela %');
}
$sheet->setCellValue('P7','Valor Total');
$sheet->setCellValue('R7','Marca');
$sheet->mergeCells('C7:L7');
$sheet->mergeCells('P7:Q7');
$sheet->mergeCells('R7:S7');
$sheet->getStyle('A7:S7')->applyFromArray($styleItens2);
//cria protecao na planilha
//senha para alteração
$sheet->getProtection()->setPassword('PHPExcel');
$sheet->getProtection()->setSheet(true);
$sheet->getProtection()->setSort(true);
$sheet->getProtection()->setInsertRows(true);
$sheet->getProtection()->setFormatCells(true);
//$sheet->getStyle('E3')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$sheet->getStyle('E4')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
$sheet->getStyle('E5')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$sheet->getStyle('E6')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
//itens orcamento
$result_itens = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"distinct pc22_codorc,pc01_codmater,pc11_seq,pc01_descrmater,pc01_complmater,m61_abrev,pc11_quant","pc11_seq","pc20_codorc = $pc22_codorc"));
$numrows_itens = $clpcorcam->numrows;

for ($i = 0; $i < $numrows_itens; $i ++){
    db_fieldsmemory($result_itens, $i);
    $numrow = $i + 8;
    $collA = 'A'.$numrow;
    $collB = 'B'.$numrow;
    $collC = 'C'.$numrow;
    $collF = 'F'.$numrow;
    $collG = 'G'.$numrow;
    $collH = 'H'.$numrow;
    $collI = 'I'.$numrow;
    $collJ = 'J'.$numrow;
    $collK = 'K'.$numrow;
    $collL = 'L'.$numrow;
    $collM = 'M'.$numrow;
    $collN = 'N'.$numrow;
    $collO = 'O'.$numrow;
    $collP = 'P'.$numrow;
    $collQ = 'Q'.$numrow;
    $collR = 'R'.$numrow;
    $collS = 'S'.$numrow;
    $pc01_descrmater = $pc01_descrmater.'-'.$pc01_complmater;
    $sheet->setCellValue($collA,$pc01_codmater);
    $sheet->setCellValue($collB,$pc11_seq);
    $sheet->setCellValue($collC,iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, $pc01_descrmater)));
    $sheet->getStyle($collC)->getAlignment()->setWrapText(false);
    $sheet->setCellValue($collM,$m61_abrev);
    $sheet->setCellValue($collN,$pc11_quant);

    //merge das cells
    $sheet->mergeCells($collC.':'.$collL);
    $sheet->mergeCells($collP.':'.$collQ);
    $sheet->mergeCells($collR.':'.$collS);

    if($pc80_criterioadjudicacao == 3) {
        //formatacao na cell valor unitario
        //http://apigen.juzna.cz/doc/ouardisoft/PHPExcel/class-PHPExcel_Style_NumberFormat.html
        $sheet->getStyle($collO)->getNumberFormat()->setFormatCode('[$R$ ]#,####0.0000_-');
        //formula multiplicacao
        $sheet->setCellValue($collP,'='.$collN.'*'.$collO);
        $sheet->getStyle($collP)->getNumberFormat()->setFormatCode('[$R$ ]#,##0.00_-');
        //formatando os itens
        $sheet->getStyle($collA.':'.$collS)->applyFromArray($styleItens);
        //libera celulas para alteracao
        $sheet->getStyle($collO)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle($collR)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    }else{
        //formatando os itens
        $sheet->getStyle($collA.':'.$collS)->applyFromArray($styleItens);
        //libera celulas para alteracao
        $sheet->getStyle($collO)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle($collP)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle($collR)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
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
        'bold' => true,
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    ),
);

//ultima linha itens
$lastCell = 'P'.($numrows_itens + 7);

//linha texto valor total
$totalCellN = 'N'.($numrows_itens + 8);
$totalCellO = 'O'.($numrows_itens + 8);
$totalCellG = 'G'.($numrows_itens + 8);

//linha valor total
$totalCellP = 'P'.($numrows_itens + 8);
$totalCellQ = 'Q'.($numrows_itens + 8);
$sheet->mergeCells($totalCellP.':'.$totalCellQ);
$sheet->mergeCells($totalCellN.':'.$totalCellO);

$sheet->getStyle($totalCellN.':'.$totalCellQ)->applyFromArray($styleTotal);

$sheet->setCellValue($totalCellN,iconv('UTF-8', 'ISO-8859-1//IGNORE',str_replace($what, $by, 'Valor Orçamento').':'));

$formula = '=(SUM(P7:'.$lastCell.'))';
//valor Total
$sheet->setCellValue($totalCellP,$formula);
$sheet->getStyle($totalCellP)->getNumberFormat()->setFormatCode('[$R$ ]#,##0.00_-');

$nomefile = "prc_".$pc81_codproc.'_'.db_getsession('DB_instit').".xlsx";


    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=$nomefile" );
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
    $objWriter->save('php://output');

?>