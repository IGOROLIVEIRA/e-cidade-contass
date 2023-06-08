<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("fpdf151/pdf.php");


/**
 * Arquivo responsável pela consulta SQL.
 * Como esta consulta é compartilhada, é melhor estar separado
 */
require_once("mat2_relatoriosaidasmateriasdepto003.php");


$rsSaidas = db_query($sSqlSaidas);
$iNumRows = pg_num_rows($rsSaidas);
$aLinhas  = array();
for ($i = 0; $i < $iNumRows; $i++) {

  $oItem = db_utils::fieldsMemory($rsSaidas, $i);

	//$oMaterialEstoque = new materialEstoque($oItem->m70_codmatmater);
  array_push($aLinhas, $oItem);
  unset($oItem);
}

$pdf = new PDF("L");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->SetAutoPageBreak(false);
$lEscreveHeader = true;
$nTotalItens    = 0;
$nValorTotal    = 0;
foreach ($aLinhas as $oLinha) {

  //$oItem    = new Item($oLinha->m70_codmatmater);
  $sUnidade = $oLinha->m61_abrev;//$oItem->getUnidade()->getAbreviacao();

  if ($pdf->gety() > $pdf->h -20 || $lEscreveHeader) {

    $pdf->AddPage();
    $pdf->setfont('arial', 'b', 8);
    $pdf->Cell(15, $iAlt, "Material","RTB", 0, "C", 1);
    $pdf->Cell(70, $iAlt, "Descrição do Material", 1, 0, "C", 1);
    $pdf->Cell(18, $iAlt, "Unidade", 1, 0, "C", 1);
    $pdf->Cell(32, $iAlt, "Depto Origem", 1, 0, "C", 1);
    $pdf->Cell(32, $iAlt, "Depto Destino", 1, 0, "C", 1);
    $pdf->Cell(45, $iAlt, "Lançamento", 1, 0, "C", 1);
    $pdf->Cell(15, $iAlt, "Data", 1, 0, "C", 1);
    $pdf->Cell(18, $iAlt, "Preço Médio", 1, 0, "C", 1);
    $pdf->Cell(15, $iAlt, "Quant.", 1, 0, "C", 1);
    $pdf->Cell(20, $iAlt, "Valor Total", "LTB", 1, "C", 1);
    $lEscreveHeader = false;
    $pdf->setfont('arial', '', 6);
  }
  $pdf->Cell(15, $iAlt, substr($oLinha->m70_codmatmater, 0, 40), "RTB", 0, "R");
  $pdf->Cell(70, $iAlt, substr($oLinha->m60_descr, 0, 50), 1, 0, "L");
  $pdf->Cell(18, $iAlt, $sUnidade, 1, 0, "l", 0);
  $pdf->Cell(32, $iAlt, substr($oLinha->m70_coddepto." - ".$oLinha->descrdepto, 0, 25), 1, 0, "L");


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

  $pdf->Cell(32, $iAlt, substr($iDeptoDestino, 0, 24), 1, 0, "L");
  $iCodigoLancamento = $oLinha->m41_codmatrequi;
  if ($oLinha->m41_codmatrequi == "") {
    $iCodigoLancamento = $oLinha->m80_codigo;
  }
  $pdf->Cell(45, $iAlt, substr($oLinha->m81_descr,0,30 )."(".$iCodigoLancamento.")", 1, 0, "L");
  $pdf->Cell(15, $iAlt, db_formatar($oLinha->m80_data, "d"), 1, 0, "C");
  $pdf->Cell(18, $iAlt, number_format($oLinha->precomedio, $iParametroNumeroDecimal), 1, 0, "R");
  $pdf->Cell(15, $iAlt, $oLinha->qtde, 1, 0, "R");
  $pdf->Cell(20, $iAlt, db_formatar($oLinha->m89_valorfinanceiro, 'f'), "LTB", 1, "R");
  $nValorTotal += $oLinha->m89_valorfinanceiro;
  $nTotalItens += $oLinha->qtde;
}

$pdf->setfont('arial', 'b', 6);
$pdf->Cell(240, $iAlt, "Total", "RTB", 0, "R", 1);
$pdf->Cell(20, $iAlt, $nTotalItens, 1, 0, "R", 1);
$pdf->Cell(20, $iAlt, db_formatar($nValorTotal, "f"), "LTB", 1, "R", 1);
$pdf->Output();
?>
