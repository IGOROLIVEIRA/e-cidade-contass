<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/PHPExcel/Classes/PHPExcel.php");
require_once("classes/materialestoque.model.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_matestoqueini_classe.php");

$oParametros      = db_utils::postMemory($_GET);


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

db_postmemory($HTTP_GET_VARS);

$instituicao = db_getsession("DB_instit");
$sWhere = " where  ac16_instit = $instituicao and ac26_sequencial = (select max(ac26_sequencial) from acordoposicao where ac26_acordo = ac16_sequencial) ";
$sOrder = " ORDER BY ac16_sequencial, ac26_sequencial, ac20_ordem, ";

if ($iAgrupamento == 1) {
  //selecionado o filtro acordos
  if (isset($ac16_sequencial) && $ac16_sequencial != "") {
    $sWhere .= "AND ac26_sequencial =
    (SELECT max(ac26_sequencial)
    FROM acordoposicao
    WHERE ac26_acordo = '$ac16_sequencial') ";
  }
} else {
  /*
 * Filtro pelo departamento de Inclusão
 * */

  if (isset($sDepartsInclusao) && $sDepartsInclusao != '') {
    $sWhere .= $sWhere ? ' AND ' : ' ';
    $sWhere .= ' ac16_coddepto in (' . $sDepartsInclusao . ') ';
  }

  /*
    * Filtro pelo departamento Responsável
    * */

  if (isset($sDepartsResponsavel) && $sDepartsResponsavel != '') {
    $sWhere .= $sWhere ? ' AND ' : ' ';
    $sWhere .= ' ac16_deptoresponsavel in (' . $sDepartsResponsavel . ') ';
  }
}
if (isset($ac02_acordonatureza) && $ac02_acordonatureza != "") {
  $sWhere .= " AND ac16_acordogrupo = '$ac02_acordonatureza' ";
}
if (isset($ac16_datainicio) && $ac16_datainicio != "") {
  $ac16_datainicio = implode("-", (array_reverse(explode("/", $ac16_datainicio))));
  $sWhere .= " AND ac16_datainicio >= '$ac16_datainicio'" . '::date ';
}
if (isset($ac16_datafim) && $ac16_datafim != "") {
  $ac16_datafim = implode("-", (array_reverse(explode("/", $ac16_datafim))));
  $sWhere .= " AND ac16_datafim <= '$ac16_datafim'" . '::date ';
}
switch ($ordem) {
  case '1':
    $sOrder .= " ac16_datafim ";
    break;

  case '2':
    $sOrder .= " ac16_contratado ";
    break;

  case '3':
    $sOrder .= " ac16_numero ";
    break;

  case '4':
    $sOrder .= " ac16_sequencial ";
    break;
}

$sSql = "SELECT
ac16_sequencial as acordo,
ac26_sequencial as posicao_acordo,
ac29_acordoitem as item,
l20_edital as licitacao,
ac02_descricao as natureza,
z01_nome as nome_contratado,
descrdepto as departamento,
coddepto as codigo_dpto,
ac26_data as data_posicao,
ac16_datainicio as datainicio,
ac16_datafim as datafim,
pc01_codmater as codigomaterial,
pc01_descrmater as material,
ac20_quantidade as qtd_total,
ac20_valorunitario as vlrunitario,
ac20_valortotal as total,
ac20_sequencial as sequencial,
ac20_ordem as ordem,
ac16_valor as valor_contrato,
l20_anousu as ano_processo_licitatorio,
ac16_numero,
ac16_anousu,
ac16_dataassinatura,

coalesce(sum(CASE WHEN ac29_tipo = 1 THEN ac29_valor END), 0) AS valorAutorizado,
coalesce(sum(CASE WHEN ac29_tipo = 1 THEN ac29_quantidade END), 0) AS quantidadeautorizada,
coalesce(sum(CASE WHEN ac29_tipo = 1 THEN (ac20_quantidade - ac29_quantidade) END), 0) AS restante,
coalesce(sum(CASE WHEN ac29_tipo = 2 THEN ac29_valor END),0) AS valorExecutado,
coalesce(sum(CASE WHEN ac29_tipo = 2 THEN ac29_quantidade END),0) AS quantidadeexecutada,
coalesce(sum(CASE WHEN ac29_tipo = 1
AND ac29_automatico IS FALSE THEN ac29_valor END), 0) AS valorAutorizadoManual,
coalesce(sum(CASE WHEN ac29_tipo = 1
AND ac29_automatico IS FALSE THEN ac29_quantidade END), 0) AS quantidadeautorizadaManual

FROM acordoitem
LEFT JOIN acordoitemexecutado ON ac29_acordoitem = ac20_sequencial
JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
JOIN acordo ON ac16_sequencial = ac26_acordo
JOIN pcmater ON pc01_codmater = ac20_pcmater
JOIN db_depart ON coddepto = ac16_deptoresponsavel
JOIN cgm ON ac16_contratado = z01_numcgm
LEFT JOIN liclicita ON l20_codigo = ac16_licitacao
LEFT JOIN acordogrupo ON ac16_acordogrupo = ac02_sequencial
JOIN acordocategoria ON ac16_acordocategoria = ac50_sequencial" . $sWhere . " GROUP BY
ac20_quantidade,
ac20_valorunitario,
ac20_valortotal,
ac20_sequencial,
ac20_ordem,
ac16_datainicio,
ac16_valor,
ac16_dataassinatura,
ac16_licitacao,
ac16_datafim,
z01_nome,
pc01_descrmater,
descrdepto,
ac29_acordoitem,
ac16_sequencial,
ac26_sequencial,
ac26_data,
coddepto,
pc01_codmater,
l20_edital,
l20_anousu,
ac02_descricao,
ac16_numero,
ac16_anousu,
ac20_ordem " . $sOrder;

$materiais = db_utils::getColectionByRecord(db_query($sSql));


// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$sheet->setCellValue('A1', 'Material');
$sheet->setCellValue('B1', mb_convert_encoding("Descrio do Material",'UTF-8'));
$sheet->setCellValue('C1', 'Depto Origem');
$sheet->setCellValue('D1', 'Depto Destino');
$sheet->setCellValue('E1', mb_convert_encoding("Lanamento",'UTF-8'));
$sheet->setCellValue('F1', 'Data');
$sheet->setCellValue('G1', mb_convert_encoding("Preo Mdio",'UTF-8'));
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


$objPHPExcel->getActiveSheet()->setTitle('Saldo de Contratos');
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

function imprimirCabecalhoAcordos($lImprime, $material, $total, $i, $totaldeitens)
{

  if ($lImprime) {


    if ($i != 0) {
      $oPdf->Cell(225, $iAlt, 'Total de itens: ' . $totaldeitens, 0, 0, 'L', 0);
      $oPdf->Cell(30, $iAlt, 'Total: ', 1, 0, 'C', 0);
      $oPdf->Cell(25, $iAlt, 'R$' . number_format($total, 2, ',', '.'), 1, 0, 'C', 0);
      $oPdf->Ln();
      $oPdf->Ln();
    }

    $oPdf->Cell(50, $iAlt, 'Cód. do Acordo: ' . $material->acordo, 0, 0, 'L', 0);
    $oPdf->Cell(150, $iAlt, 'Departamento Responsável: ' . $material->departamento, 0, 0, 'L', 0);
    $oPdf->Cell(80, $iAlt, 'Data de Assinatura: ' . (($material->ac16_dataassinatura != null && $material->ac16_dataassinatura != "") ? date("d/m/Y", strtotime($material->ac16_dataassinatura)) : 'Não informado'), 0, 0, 'L', 0);

    $oPdf->Ln();
    $oPdf->Cell(50, $iAlt, 'Nº Contrato: ' . $material->ac16_numero . '/' . $material->ac16_anousu/*date("m/Y", strtotime($material->data_posicao))*/, 0, 0, 'L', 0);

    $oPdf->Cell(150, $iAlt, 'Vigência: ' . date("d/m/Y", strtotime($material->datainicio)) . ' a ' . date("d/m/Y", strtotime($material->datafim)), 0, 0, 'L', 0);

    $oPdf->Cell(100, $iAlt, 'Natureza: ' . $material->natureza, 0, 0, 'L', 0);

    $oPdf->Ln();
    $oPdf->Cell(200, $iAlt, 'Contratado: ' . $material->nome_contratado, 0, 0, 'L', 0);
    if ($material->licitacao != "") {
      $oPdf->Cell(50, $iAlt, 'Processo Licitatorio: ' . $material->licitacao . '/' . $material->ano_processo_licitatorio, 0, 0, 'L', 0);
    }
    $oPdf->SetMargins(2, 0, 0);

    $oPdf->Ln();
    $oPdf->Ln();
    if ($oPdf->GetY() > 190) {
      $oPdf->AddPage('L');
    }

    $oPdf->Cell(15, $iAlt, 'Seq', 1, 0, 'C', 1);
    $oPdf->Cell(20, $iAlt, 'Código', 1, 0, 'C', 1);
    $oPdf->Cell(140, $iAlt, 'Descrição', 1, 0, 'C', 1);
    $oPdf->Cell(23, $iAlt, 'Quantidade', 1, 0, 'C', 1);
    $oPdf->Cell(25, $iAlt, 'Vlr. Unitário', 1, 0, 'C', 1);
    $oPdf->Cell(25, $iAlt, 'Vlr. Total', 1, 0, 'C', 1);
    $oPdf->Cell(20, $iAlt, 'Saldo', 1, 0, 'C', 1);
    $oPdf->Cell(25, $iAlt, 'Vlr. Disponível', 1, 0, 'C', 1);
    $oPdf->Ln();
  }
}

$sheet->getStyle('B2:B1000')->getAlignment()->setWrapText(true);

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=saldocontratos.xlsx");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
