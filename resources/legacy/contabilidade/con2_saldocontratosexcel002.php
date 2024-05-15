<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/PHPExcel/Classes/PHPExcel.php");
require_once("classes/db_acordoitem_classe.php");

function saldoDisponivel($oItem)
{
  if ($oItem->valorautorizado < ($oItem->vlrunitario * $oItem->quantidadeautorizada)) {
    if (($oItem->valorautorizado / $oItem->vlrunitario) < 1) {
      return $oItem->qtd_total;
    }

    return $oItem->qtd_total - floor(($oItem->valorautorizado / $oItem->vlrunitario));
  }

  return ($oItem->qtd_total - $oItem->quantidadeautorizada);
}

function montagemWhere($oParametros)
{
  $sWhere = " where  ac16_instit = " . db_getsession("DB_instit") . " and ac26_sequencial = (select max(ac26_sequencial) from acordoposicao where ac26_acordo = ac16_sequencial) ";

  if ($oParametros->ac02_acordonatureza != "") {
    $sWhere .= " AND ac16_acordogrupo = '$oParametros->ac02_acordonatureza' ";
  }

  if ($oParametros->ac16_datainicio != "") {
    $ac16_datainicio = implode("-", (array_reverse(explode("/", $oParametros->ac16_datainicio))));
    $sWhere .= " AND ac16_datainicio >= '$ac16_datainicio'" . '::date ';
  }

  if ($oParametros->ac16_datafim != "") {
    $ac16_datafim = implode("-", (array_reverse(explode("/", $oParametros->ac16_datafim))));
    $sWhere .= " AND ac16_datafim <= '$ac16_datafim'" . '::date ';
  }

  if ($oParametros->iAgrupamento == '1' && $oParametros->ac16_sequencial != "") {
    $sWhere .= "AND ac26_sequencial = (SELECT max(ac26_sequencial) FROM acordoposicao WHERE ac26_acordo = '$oParametros->ac16_sequencial') ";
    return $sWhere;
  }

  if ($oParametros->iAgrupamento == "2" && $oParametros->sDepartsInclusao != '') {
    $sWhere .= $sWhere ? ' AND ' : ' ';
    $sWhere .= ' ac16_coddepto in (' . $oParametros->sDepartsInclusao . ') ';
    return $sWhere;
  }

  if ($oParametros->iAgrupamento == "2" && $oParametros->sDepartsResponsavel != '') {
    $sWhere .= $sWhere ? ' AND ' : ' ';
    $sWhere .= ' ac16_deptoresponsavel in (' . $oParametros->sDepartsResponsavel . ') ';
    return $sWhere;
  }

  if ($oParametros->iAgrupamento == "3" && $oParametros->ac16_licitacao != '') {
    $sWhere .= " AND ac16_licitacao = $oParametros->ac16_licitacao";
    return $sWhere;
  }

  return $sWhere;
}

function montagemOrderBy($ordem)
{
  $sOrder = " ORDER BY ac16_sequencial, ac26_sequencial, ac20_ordem, ";
  if ($ordem == '1') return $sOrder .= " ac16_datafim ";
  if ($ordem == '2') return $sOrder .= " ac16_contratado ";
  if ($ordem == '3') return $sOrder .= " ac16_numero ";
  if ($ordem == '4') return $sOrder .= " ac16_sequencial ";
}

function montagemCabecalhoAcordo($sheet, $oItem, &$iCelula)
{

  $iCelula++;

  $sheet->getStyle("A:C")->getFont()->setBold(true);
  $sheet->setCellValue("A" . $iCelula, mb_convert_encoding("Cód do Acordo: ", 'UTF-8') . $oItem->acordo);
  $sheet->setCellValue("B" . $iCelula, mb_convert_encoding("Departamento Responsavel: ", 'UTF-8') . $oItem->departamento);
  $sheet->setCellValue("C" . $iCelula, "Data de Assinatura: " . (($oItem->ac16_dataassinatura != null && $oItem->ac16_dataassinatura != "") ? date("d/m/Y", strtotime($oItem->ac16_dataassinatura)) : 'Nao informado'));

  $iCelula++;

  $sheet->setCellValue("A" . $iCelula, mb_convert_encoding("Nº Contrato: ", 'UTF-8') . $oItem->ac16_numero . "/" . $oItem->ac16_anousu);

  $oItem->datainicio = date("d/m/Y", strtotime($oItem->datainicio));
  $oItem->datafim = date("d/m/Y", strtotime($oItem->datafim));

  $tituloVigencia = $oItem->ac16_vigenciaindeterminada == "t" ? mb_convert_encoding("Vigência Inicial: ", 'UTF-8') : mb_convert_encoding("Período de Vigência: ", 'UTF-8');
  $dataVigencia = $oItem->ac16_vigenciaindeterminada == "t" ? $oItem->datainicio : $oItem->datainicio . mb_convert_encoding(" Até: ", 'UTF-8') . $oItem->datafim;

  $sheet->setCellValue("B" . $iCelula, $tituloVigencia . $dataVigencia);
  $sheet->setCellValue("C" . $iCelula, "Natureza: $oItem->natureza");

  $iCelula++;

  $sheet->setCellValue("A" . $iCelula, "Contratado: $oItem->nome_contratado");
  $sheet->setCellValue("C" . $iCelula, mb_convert_encoding("Processo Licitatório: ", 'UTF-8') . "$oItem->licitacao/$oItem->ano_processo_licitatorio");
}

function montagemCabecalhoItens($sheet, &$iCelula)
{
  $iCelula++;
  $styleCabecalhoItens = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'),),), 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => 'd3d3d3')), 'font' => array('size' => 10, 'bold' => true,), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
  $sheet->getStyle("A$iCelula:H$iCelula")->applyFromArray($styleCabecalhoItens);
  $sheet->getStyle("A:H")->getFont()->setBold(true);
  $sheet->setCellValue("A" . $iCelula, "Seq");
  $sheet->setCellValue("B" . $iCelula, mb_convert_encoding("Código", 'UTF-8'));
  $sheet->setCellValue("C" . $iCelula, mb_convert_encoding("Descrição", 'UTF-8'));
  $sheet->setCellValue("D" . $iCelula, "Quantidade ");
  $sheet->setCellValue("E" . $iCelula, mb_convert_encoding("Vlr. Unitário", 'UTF-8'));
  $sheet->setCellValue("F" . $iCelula, "Vlr. Total ");
  $sheet->setCellValue("G" . $iCelula, "Saldo ");
  $sheet->setCellValue("H" . $iCelula, mb_convert_encoding("Vlr Disponível", 'UTF-8'));
  $iCelula++;
}

function listarItens($sheet, $oItem, &$iCelula)
{
  $styleItens = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'),),), 'font' => array('size' => 10, 'bold' => false,), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),);
  $sheet->getStyle("A:H")->getFont()->setBold(false);
  $sheet->getStyle("A$iCelula:H$iCelula")->applyFromArray($styleItens);
  $sheet->setCellValue("A" . $iCelula, "$oItem->ordem");
  $sheet->setCellValue("B" . $iCelula, "$oItem->codigomaterial");
  $sheet->setCellValue("C" . $iCelula, mb_convert_encoding($oItem->material, 'UTF-8'));
  $sheet->setCellValue("D" . $iCelula, "$oItem->qtd_total");
  $sheet->setCellValue("E" . $iCelula, 'R$' . number_format(($oItem->vlrunitario), 2, ',', '.'));
  $sheet->setCellValue("F" . $iCelula, 'R$' . number_format($oItem->total, 2, ',', '.'));
  $sheet->setCellValue("G" . $iCelula, saldoDisponivel($oItem));
  $sheet->setCellValue("H" . $iCelula, 'R$' . number_format(($oItem->total - $oItem->valorautorizado), 2, ',', '.'));
  $iCelula++;
}

function montarCabecalhos($iAcordoAtual, $acordoAnterior)
{
  if ($iAcordoAtual != $acordoAnterior) return true;
}

function listarValorTotalAcordo($iAcordoAtual, $iProximoAcordo){
  if ($iAcordoAtual != $iProximoAcordo) return true;
}

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();
$objPHPExcel->getActiveSheet()->setTitle('Saldo de Contratos');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$sheet->getStyle('C')->getAlignment()->setWrapText(true);

$iCodigoAcordoAnterior = 0;
$iTotalItensAcordo = 0;
$nTotalValorAcordo = 0;
$iCelula = 1;

$oParametros      = db_utils::postMemory($_GET);
$sWhere = montagemWhere($oParametros);
$sOrder = montagemOrderBy($oParametros->ordem);
$clacordoitem = new cl_acordoitem;
$sSql = $clacordoitem->sqlQuerySaldocontratos($sWhere, $sOrder);
$rsMateriais = db_query($sSql);

if (pg_num_rows($rsMateriais) == 0) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
}

for ($i = 0; $i < pg_num_rows($rsMateriais); $i++) {

  $oItem  = db_utils::fieldsMemory($rsMateriais, $i);

  if (montarCabecalhos($oItem->acordo, $iCodigoAcordoAnterior)) {

    montagemCabecalhoAcordo($sheet, $oItem, $iCelula);
    montagemCabecalhoItens($sheet, $iCelula);
    $iCodigoAcordoAnterior = $oItem->acordo;
  }

  listarItens($sheet, $oItem, $iCelula);

  $iTotalItensAcordo++;
  $nTotalValorAcordo += ($oItem->total - $oItem->valorautorizado);

  $iProximoAcordo = db_utils::fieldsMemory($rsMateriais, $i + 1)->acordo;

  if (listarValorTotalAcordo($oItem->acordo, $iProximoAcordo)) {
    $objPHPExcel->getActiveSheet()->getStyle("A:H")->getFont()->setBold(true);
    $sheet->setCellValue("A" . $iCelula, "Total de itens: $iTotalItensAcordo");
    $sheet->setCellValue("F" . $iCelula, "Valor total: " . number_format($nTotalValorAcordo, 2, ',', '.'));
    $iTotalItensAcordo = 0;
    $nTotalValorAcordo = 0;
    $iCelula++;
  }
}

$sheet->setCellValue("A" . ($iCelula + 1), "Total de Registros: " . pg_num_rows($rsMateriais));

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=saldocontratos.xlsx");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
