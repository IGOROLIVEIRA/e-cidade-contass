<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/PHPExcel/Classes/PHPExcel.php");
require_once("classes/materialestoque.model.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_matestoqueini_classe.php");

$oParametros      = db_utils::postMemory($_GET);
$clmatestoqueini = new cl_matestoqueini;

/**
 * busca o parametro de casas decimais para formatar o valor jogado na grid
 */

$oDaoParametros          = new cl_empparametro;
$iAnoSessao              = db_getsession("DB_anousu");
$sWherePeriodoParametro  = " e39_anousu = {$iAnoSessao} ";
$sSqlPeriodoParametro    = $oDaoParametros->sql_query_file(null, "e30_numdec", null, $sWherePeriodoParametro);
$rsPeriodoParametro      = $oDaoParametros->sql_record($sSqlPeriodoParametro);
$iParametroNumeroDecimal = db_utils::fieldsMemory($rsPeriodoParametro, 0)->e30_numdec;


$infoData = function($oParametros) {

  $sDataIni = implode('-',array_reverse(explode('/',$oParametros->dataini)));
  $sDataFin = implode('-',array_reverse(explode('/',$oParametros->datafin)));

  if ((trim($oParametros->dataini) != "--") && ( trim($oParametros->datafin) != "--")) return "De ".$oParametros->dataini." até ".$oParametros->datafin;
  if (trim($oParametros->dataini) != "--") return "Apartir de ".$oParametros->dataini;
  if (trim($oParametros->datafin) != "--") return "Até ".$oParametros->datafin;
  if ($sDataIni == $sDataFin) return "Dia: ".$oParametros->datafin;
  
};

$info .= $infoData($oParametros);

if ( isset($oParametros->grupos) && trim($oParametros->grupos) != "" )  {
	$head4 = 'Filtro por Grupos/Subgrupos';
}

$info .= $infoData($oParametros);
$info_listar_serv = " LISTAR: TODOS";
$head3 = "Relatório de Entrada de Material por Departamento";
$head5 = "$info";
$head7 = "$info_listar_serv";

$sSqlSaidas  = $clmatestoqueini->sqlQueryRelatorioEntradasMateriais($oParametros);
$rsSaidas = db_query($sSqlSaidas);
$iNumRows = pg_num_rows($rsSaidas);
$aLinhas  = array();
for ($i = 0; $i < $iNumRows; $i++) {

  $oItem = db_utils::fieldsMemory($rsSaidas, $i);

	$oMaterialEstoque = new materialEstoque($oItem->m70_codmatmater);
  array_push($aLinhas, $oItem);
  unset($oItem);
}

$styleCabecalho = array(
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

$styleCelulas = array(
  'borders' => array(
      'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
      ),
  ),
  'alignment' => array(
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
  ),
);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setCellValue('A1', 'Material');
$sheet->setCellValue('B1', mb_convert_encoding("Descrição do Material",'UTF-8'));
$sheet->setCellValue('C1', 'Depto Origem');
$sheet->setCellValue('D1', 'Depto Destino');
$sheet->setCellValue('E1', mb_convert_encoding("Lançamento",'UTF-8'));
$sheet->setCellValue('F1', 'Data');
$sheet->setCellValue('G1', mb_convert_encoding("Preço Médio",'UTF-8'));
$sheet->setCellValue('H1', 'Quantidade');
$sheet->setCellValue('I1', 'Valor Total');

$sheet->getStyle('A1:I1')->applyFromArray($styleCabecalho);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->protectCells('A1:I1', 'PHPExcel');
$objPHPExcel->getActiveSheet()
    ->getStyle('A2:I2000')
    ->getProtection()->setLocked(
        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
    );

$sheet->getStyle('A2:I2000')->applyFromArray($styleCelulas);


// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Entrada de materiais');
$i = 0;
$numcell = 1;

foreach ($aLinhas as $oLinha) {

    $celulaA = "A" . ($numcell + 1);
    $celulaB = "B" . ($numcell + 1);
    $celulaC = "C" . ($numcell + 1);
    $celulaD = "D" . ($numcell + 1);
    $celulaE = "E" . ($numcell + 1);
    $celulaF = "F" . ($numcell + 1);
    $celulaG = "G" . ($numcell + 1);
    $celulaH = "H" . ($numcell + 1);
    $celulaI = "I" . ($numcell + 1);

    $sheet->setCellValue($celulaA, substr($oLinha->m70_codmatmater, 0, 40));
    $sheet->setCellValue($celulaB, mb_convert_encoding($oLinha->m60_descr,'UTF-8'));
    $sheet->setCellValue($celulaC, substr($oLinha->m70_coddepto." - ".mb_convert_encoding($oLinha->descrdepto,'UTF-8'), 0, 25));
    $iDeptoDestino = $oLinha->m40_depto;
    if ($oLinha->m83_coddepto != "") {
      $iDeptoDestino = $oLinha->m83_coddepto;
    }
    /**
     * consultamos a descricao do departamento de origem.
     */
    if ($iDeptoDestino !="") {
  
      $sSqlDeptoDestino = "select descrdepto from db_depart where coddepto = {$iDeptoDestino}";
      $rsDeptoDestino   = db_query($sSqlDeptoDestino);
      $iDeptoDestino    = "{$iDeptoDestino} - ".db_utils::fieldsMemory($rsDeptoDestino, 0)->descrdepto;
    }
    if($iDeptoDestino == "") $iDeptoDestino = " ";
    $sheet->setCellValue($celulaD, substr(mb_convert_encoding($iDeptoDestino,'UTF-8'), 0, 24));

    $iCodigoLancamento = $oLinha->m41_codmatrequi;
    if ($oLinha->m41_codmatrequi == "") {
      $iCodigoLancamento = "$oLinha->m80_codigo";
    }
    if($oLinha->m80_codtipo == 12){
      $iCodigoLancamento = "$oLinha->m52_codordem";
    }
    $sheet->setCellValue($celulaE, substr(mb_convert_encoding($oLinha->m81_descr,'UTF-8'),0,30)."(".$iCodigoLancamento.")");
    $sheet->setCellValue($celulaF, db_formatar($oLinha->m80_data, "d"));
    $sheet->setCellValue($celulaG, number_format($oLinha->precomedio, $iParametroNumeroDecimal));
    $sheet->setCellValue($celulaH, $oLinha->qtde);
    $sheet->setCellValue($celulaI, db_formatar($oLinha->m89_valorfinanceiro, 'f'));

    $numcell++;

}

$sheet->getStyle('B2:B1000')->getAlignment()->setWrapText(true);

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=entradasmateriaisdepto.xlsx");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
