<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_libsys.php");
require_once("std/db_stdClass.php");
require_once("classes/db_pcorcam_classe.php");
require_once("classes/db_matestoque_classe.php");
require_once("classes/db_matestoqueitem_classe.php");
require_once("classes/db_db_almox_classe.php");
require_once("classes/materialestoque.model.php");
require_once("classes/db_empparametro_classe.php");
require_once "libs/db_app.utils.php";
include("libs/PHPExcel/Classes/PHPExcel.php");


db_app::import("contabilidade.contacorrente.ContaCorrenteFactory");
db_app::import("Acordo");
db_app::import("AcordoComissao");
db_app::import("CgmFactory");
db_app::import("financeiro.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.lancamento.*");
db_app::import("Dotacao");
db_app::import("contabilidade.planoconta.*");
db_app::import("contabilidade.contacorrente.*");
$oParametros      = db_utils::postMemory($_GET);
$clmatestoque     = new cl_matestoque;
$clmatestoqueitem = new cl_matestoqueitem;
$cldb_almox       = new cl_db_almox;

$clrotulo = new rotulocampo;
$clrotulo->label('m60_descr');
$clrotulo->label('descrdepto');

/**
 * busca o parametro de casas decimais para formatar o valor jogado na grid
 */

$oDaoParametros          = new cl_empparametro;
$iAnoSessao              = db_getsession("DB_anousu");
$sWherePeriodoParametro  = " e39_anousu = {$iAnoSessao} ";
$sSqlPeriodoParametro    = $oDaoParametros->sql_query_file(null, "e30_numdec", null, $sWherePeriodoParametro);
$rsPeriodoParametro      = $oDaoParametros->sql_record($sSqlPeriodoParametro);
$iParametroNumeroDecimal = db_utils::fieldsMemory($rsPeriodoParametro, 0)->e30_numdec;

$iAlt = 4;
$sOrderBy = "m80_data";
if (isset($oParametros->quebra) && $oParametros->quebra == "S") {

  $sOrderBy = 'm80_coddepto, m60_descr, m80_data';
} else if ($oParametros->ordem == 'a') {
  $sOrderBy = 'm70_codmatmater, m80_data';
} else	if ($oParametros->ordem == 'b') {
	$sOrderBy = 'm80_coddepto, m60_descr, m80_data';
} else	if ($oParametros->ordem == 'c') {
	$sOrderBy = 'm60_descr';
} else  if ($oParametros->ordem == 'd') {
  $sOrderBy = "m80_data";
}

if ($oParametros->listamatestoquetipo != "") {
  $sWhere  = " m80_codtipo in ({$oParametros->listamatestoquetipo}) ";
}else{
  $sWhere  = " m81_tipo  = 1 ";
}

$sWhere .= " and instit=".db_getsession('DB_instit');
$sWhere .= " and m71_servico = false";
if ($oParametros->listaorgao!= "") {

 $sWhere .= " and o40_orgao in ({$oParametros->listaorgao}) ";
 $sWhere .= " and o40_anousu = ".db_getsession('DB_anousu');
 $sWhere .= " and o40_instit=".db_getsession('DB_instit');
}

if ($oParametros->listadepart != "") {
	if (isset ($oParametros->verdepart) && $oParametros->verdepart == "com") {
		$sWhere .= " and m80_coddepto in ({$oParametros->listadepart})";
	} else {
	  $sWhere .= " and m80_coddepto not in ({$oParametros->listadepart})";
	}
}

if ($oParametros->listamat != "") {
	if (isset ($oParametros->vermat) && $oParametros->vermat == "com") {
		$sWhere .= " and m70_codmatmater in ({$oParametros->listamat})";
	} else {
		$sWhere .= " and m70_codmatmater not in ({$oParametros->listamat})";
	}
}

if ($oParametros->listausu != "") {
	if (isset ($oParametros->verusu) && $oParametros->verusu == "com") {
		$sWhere .= " and m80_login in ({$oParametros->listausu})";
	} else {
		$sWhere .= " and m80_login not in ({$oParametros->listausu})";
	}
}


/*
 * implementado logica para ir até os grupos caso eles venham selecionados
*/

$sInnerJoinGrupos = '';
$sFiltroGrupo     = '';

if ( isset($oParametros->grupos) && trim($oParametros->grupos) != "" )  {

	$sWhere  .= " and materialestoquegrupo.m65_db_estruturavalor in ({$oParametros->grupos}) ";
	$sInnerJoinGrupos = " 
         inner join matmatermaterialestoquegrupo on matmater.m60_codmater = matmatermaterialestoquegrupo.m68_matmater 
	       inner join materialestoquegrupo on matmatermaterialestoquegrupo.m68_materialestoquegrupo = materialestoquegrupo.m65_sequencial 
	";
	
	$sFiltroGrupo     = 'Filtro por Grupos/Subgrupos';
	$head4 = $sFiltroGrupo;//"Relatório de Saída de Material por Departamento";

}

$sDataIni = implode('-',array_reverse(explode('/',$oParametros->dataini)));
$sDataFin = implode('-',array_reverse(explode('/',$oParametros->datafin)));

if ((trim($oParametros->dataini) != "--") && ( trim($oParametros->datafin) != "--")) {

  $sWhere .= " and m80_data between '{$sDataIni}' and '{$sDataFin}' ";
  $info    = "De ".$oParametros->dataini." até ".$oParametros->datafin;
} else if (trim($oParametros->dataini) != "--") {

 	$sWhere .= " and m80_data >= '{$sDataIni}' ";
  $info  = "Apartir de ".$oParametros->dataini;
} else if (trim($oParametros->datafin) != "--") {

 	$sWhere .= " and m80_data <= '{$sDataFin}' ";
  $info   = "Até ".$oParametros->datafin;
} else if ( $sDataIni == $sDataFin ) {
 	$sWhere .= " and m80_data = '{$sDataFin}' ";
  $info   = "Dia: ".$oParametros->datafin;
}
$info_listar_serv = " LISTAR: TODOS";
$head3 = "Relatório de Entrada de Material por Departamento";
$head5 = "$info";
$head7 = "$info_listar_serv";

$sSqlSaidas   = "SELECT m80_codigo,  ";
$sSqlSaidas  .= "       m70_coddepto,  ";
$sSqlSaidas  .= "       m70_codmatmater, ";
$sSqlSaidas  .= "       m80_coddepto, ";
$sSqlSaidas  .= "       m60_descr,  ";
$sSqlSaidas  .= "       descrdepto,  ";
$sSqlSaidas  .= "       sum(m82_quant) as qtde, ";
$sSqlSaidas  .= "       m80_data,  ";
$sSqlSaidas  .= "       m80_codtipo,  ";
$sSqlSaidas  .= "       m83_coddepto,  ";
$sSqlSaidas  .= "       m81_descr,  ";
$sSqlSaidas  .= "       m41_codmatrequi, ";
$sSqlSaidas  .= "       m89_precomedio as precomedio, ";
$sSqlSaidas  .= "       sum(coalesce((m82_quant::numeric * m89_valorunitario::numeric),0)) as m89_valorfinanceiro, ";
$sSqlSaidas  .= "       m40_depto ";
$sSqlSaidas  .= "  from matestoqueini  ";
$sSqlSaidas  .= "       inner join matestoqueinimei    on m80_codigo              = m82_matestoqueini ";
$sSqlSaidas  .= "       inner join matestoqueinimeipm  on m82_codigo              = m89_matestoqueinimei ";
$sSqlSaidas  .= "       inner join matestoqueitem      on m82_matestoqueitem      = m71_codlanc  ";
$sSqlSaidas  .= "       inner join matestoque          on m70_codigo              = m71_codmatestoque ";
$sSqlSaidas  .= "       inner join matmater            on m70_codmatmater         = m60_codmater  ";
$sSqlSaidas  .= "       inner join matestoquetipo      on m80_codtipo             = m81_codtipo  ";
$sSqlSaidas  .= "       left  join db_depart           on m70_coddepto            = coddepto  ";
$sSqlSaidas  .= "       left  join db_departorg        on db01_coddepto           = db_depart.coddepto  ";
$sSqlSaidas  .= "                                     and db01_anousu             = ".db_getsession("DB_anousu");
$sSqlSaidas  .= "       left  join orcorgao            on o40_orgao               = db_departorg.db01_orgao ";
$sSqlSaidas  .= "                                     and o40_anousu              = ".db_getsession("DB_anousu");
$sSqlSaidas  .= "       left  join matestoquetransf    on m83_matestoqueini       = m80_codigo   ";
$sSqlSaidas  .= "       left  join matestoqueinimeiari on m49_codmatestoqueinimei = m82_codigo  ";
$sSqlSaidas  .= "       left  join atendrequiitem      on m49_codatendrequiitem   = m43_codigo  ";
$sSqlSaidas  .= "       left  join matrequiitem        on m41_codigo              = m43_codmatrequiitem ";

$sSqlSaidas  .= $sInnerJoinGrupos; // string de inner caso venha grupos selecionados

$sSqlSaidas  .= "       left  join matrequi            on m40_codigo              = m41_codmatrequi ";
$sSqlSaidas  .= " where {$sWhere} ";
$sSqlSaidas  .= " group by m80_codigo,  ";
$sSqlSaidas  .= "          m70_coddepto,  ";
$sSqlSaidas  .= "          m70_codmatmater, ";
$sSqlSaidas  .= "          m80_data,  ";
$sSqlSaidas  .= "          m40_depto,  ";
$sSqlSaidas  .= "          m81_descr,  ";
$sSqlSaidas  .= "          m80_codtipo,  ";
$sSqlSaidas  .= "          m80_coddepto,  ";
$sSqlSaidas  .= "          m83_coddepto,  ";
$sSqlSaidas  .= "          descrdepto,  ";
$sSqlSaidas  .= "          m89_precomedio,  ";
$sSqlSaidas  .= "          m60_descr,  ";
$sSqlSaidas  .= "          m41_codmatrequi ";
$sSqlSaidas  .= " order by {$sOrderBy} ";
$rsSaidas = db_query($sSqlSaidas);
$iNumRows = pg_num_rows($rsSaidas);
$aLinhas  = array();
for ($i = 0; $i < $iNumRows; $i++) {

  $oItem = db_utils::fieldsMemory($rsSaidas, $i);

	$oMaterialEstoque = new materialEstoque($oItem->m70_codmatmater);
  array_push($aLinhas, $oItem);
  unset($oItem);
}

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

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();


// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setCellValue('A1', 'Material');
$sheet->setCellValue('B1', 'Descrição do Material');
$sheet->setCellValue('C1', 'Depto Origem');
$sheet->setCellValue('D1', 'Depto Destino');
$sheet->setCellValue('E1', 'Lançamento');
$sheet->setCellValue('F1', 'Data');
$sheet->setCellValue('G1', 'Preço Médio');
$sheet->setCellValue('H1', 'Quantidade');
$sheet->setCellValue('I1', 'Valor Total');



$sheet->getStyle('A1:I1')->applyFromArray($styleItens2);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
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

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Relatório de entrada de materiais por departamentos');
$i = 0;
$numcell = 1;

foreach ($aLinhas as $oLinha) {

    $celulaA = "A" . ($numcell + 1);
    $celulaB = "B" . ($numcell + 1);
    $celulaC = "C" . ($numcell + 1);
    $celulaC = "D" . ($numcell + 1);
    $celulaC = "E" . ($numcell + 1);
    $celulaC = "F" . ($numcell + 1);
    $celulaC = "G" . ($numcell + 1);
    $celulaC = "H" . ($numcell + 1);
    $celulaC = "I" . ($numcell + 1);

    $sheet->setCellValue($celulaA, substr($oLinha->m70_codmatmater, 0, 40));
    $sheet->setCellValue($celulaB, $oLinha->m60_descr);
    $sheet->setCellValue($celulaC, substr($oLinha->m70_coddepto." - ".$oLinha->descrdepto, 0, 25));
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
    $sheet->setCellValue($celulaD, substr($iDeptoDestino, 0, 24));

    $iCodigoLancamento = $oLinha->m41_codmatrequi;
    if ($oLinha->m41_codmatrequi == "") {
      $iCodigoLancamento = "$oLinha->m80_codigo";
    }
    $sheet->setCellValue($celulaE, substr($oLinha->m81_descr,0,30 )."(".$iCodigoLancamento.")");
    $sheet->setCellValue($celulaF, db_formatar($oLinha->m80_data, "d"));
    $sheet->setCellValue($celulaG, number_format($oLinha->precomedio, $iParametroNumeroDecimal));
    $sheet->setCellValue($celulaH, $oLinha->qtde);
    $sheet->setCellValue($celulaH, db_formatar($oLinha->m89_valorfinanceiro, 'f'));


    $iAltLinha = $pdf->NbLines(75, $oLinha->m60_descr);
    $iAltLinha = $iAltLinha * $iAlt;
    $pdf->Cell(15, $iAltLinha, substr($oLinha->m70_codmatmater, 0, 40), "RTB", 0, "R");
    $y =  $pdf->GetY();
    $x =  $pdf->GetX();
    $pdf->MultiCell(75, $iAlt, $oLinha->m60_descr, 1, "L", 2);
    $pdf->SetY($y);
    $pdf->SetX(100);
    $pdf->Cell(32, $iAltLinha, substr($oLinha->m70_coddepto." - ".$oLinha->descrdepto, 0, 25), 1, 0, "L");
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
    $pdf->Cell(32, $iAltLinha, substr($iDeptoDestino, 0, 24), 1, 0, "L");
    $iCodigoLancamento = $oLinha->m41_codmatrequi;
    if ($oLinha->m41_codmatrequi == "") {
      $iCodigoLancamento = "$oLinha->m80_codigo";
    }
    $pdf->Cell(50, $iAltLinha, substr($oLinha->m81_descr,0,30 )."(".$iCodigoLancamento.")", 1, 0, "L");
    $pdf->Cell(18, $iAltLinha, db_formatar($oLinha->m80_data, "d"), 1, 0, "C");
    $pdf->Cell(18, $iAltLinha, number_format($oLinha->precomedio, $iParametroNumeroDecimal), 1, 0, "R");
    $pdf->Cell(20, $iAltLinha, $oLinha->qtde, 1, 0, "R");
    $pdf->Cell(20, $iAltLinha, db_formatar($oLinha->m89_valorfinanceiro, 'f'), "LTB", 1, "R");
    $nValorTotal += $oLinha->m89_valorfinanceiro;
    $nTotalItens += $oLinha->qtde;

    $i++;

}

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=entradasmateriaisdepto_$codigoimportacao.xlsx");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
