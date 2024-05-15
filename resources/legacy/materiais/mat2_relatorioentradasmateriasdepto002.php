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
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
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

$pdf = new PDF("L");
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->SetAutoPageBreak(false);
$lEscreveHeader = true;
$nTotalItens    = 0;
$nValorTotal    = 0;
$iAlt = 4;
foreach ($aLinhas as $oLinha) {

  if ($pdf->gety() > $pdf->h -20 || $lEscreveHeader) {

    $pdf->AddPage();
    $pdf->setfont('arial', 'b', 8);
    $pdf->Cell(15, $iAlt, "Material",1, 0, "C", 1);
    $pdf->Cell(75, $iAlt, "Descrição do Material", 1, 0, "C", 1);
    $pdf->Cell(32, $iAlt, "Depto Origem", 1, 0, "C", 1);
    $pdf->Cell(32, $iAlt, "Depto Destino", 1, 0, "C", 1);
    $pdf->Cell(50, $iAlt, "Lançamento", 1, 0, "C", 1);
    $pdf->Cell(18, $iAlt, "Data", 1, 0, "C", 1);
    $pdf->Cell(18, $iAlt, "Preço Médio", 1, 0, "C", 1);
    $pdf->Cell(20, $iAlt, "Quantidade", 1, 0, "C", 1);
    $pdf->Cell(20, $iAlt, "Valor Total", 1, 1, "C", 1);
    $lEscreveHeader = false;
    $pdf->setfont('arial', '', 6);
  }
  $iAltLinha = $pdf->NbLines(75, mb_strtoupper($oLinha->m60_descr,'ISO-8859-1'));
  $iAltLinha = $iAltLinha * $iAlt;
  
  $pdf->Cell(15, $iAltLinha, substr($oLinha->m70_codmatmater, 0, 40), 1, 0, "C");
  $y =  $pdf->GetY();
  $x =  $pdf->GetX();
  $pdf->MultiCell(75, $iAlt, mb_strtoupper($oLinha->m60_descr,'ISO-8859-1'), 1, "C", 2);
  $pdf->SetY($y);
  $pdf->SetX(100);
  $pdf->Cell(32, $iAltLinha, substr($oLinha->m70_coddepto." - ".$oLinha->descrdepto, 0, 25), 1, 0, "C");
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
  $pdf->Cell(32, $iAltLinha, substr($iDeptoDestino, 0, 24), 1, 0, "C");
  $iCodigoLancamento = $oLinha->m41_codmatrequi;
  if ($oLinha->m41_codmatrequi == "") {
    $iCodigoLancamento = "$oLinha->m80_codigo";
  }
  if($oLinha->m80_codtipo == 12){
    $iCodigoLancamento = "$oLinha->m52_codordem";
  }
  $pdf->Cell(50, $iAltLinha, substr($oLinha->m81_descr,0,30 )."(".$iCodigoLancamento.")", 1, 0, "C");
  $pdf->Cell(18, $iAltLinha, db_formatar($oLinha->m80_data, "d"), 1, 0, "C");
  $pdf->Cell(18, $iAltLinha, number_format($oLinha->precomedio, $iParametroNumeroDecimal), 1, 0, "C");
  $pdf->Cell(20, $iAltLinha, $oLinha->qtde, 1, 0, "C");
  $pdf->Cell(20, $iAltLinha, db_formatar($oLinha->m89_valorfinanceiro, 'f'), 1, 1, "C");
  $nValorTotal += $oLinha->m89_valorfinanceiro;
  $nTotalItens += $oLinha->qtde;
}
$pdf->setfont('arial', 'b', 6);
$pdf->Cell(240, $iAlt, "Total", "RTB", 0, "C", 1);
$pdf->Cell(20, $iAlt, $nTotalItens, 1, 0, "C", 1);
$pdf->Cell(20, $iAlt, db_formatar($nValorTotal, "f"), "LTB", 1, "C", 1);
$pdf->Output();
?>