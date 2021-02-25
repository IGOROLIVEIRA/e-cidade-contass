<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

include("fpdf151/pdf.php");
include("libs/db_utils.php");
include("std/DBDate.php");


$oParam = db_utils::postMemory($HTTP_GET_VARS);
$valor_formatado = str_replace(',', '.', str_replace('.', '', $oParam->valor));
$valor = $oParam->valor;
$texto2 = $oParam->valor2;
$empenho = split('/', $oParam->empenho);
$numero_empenho = $empenho[0];
$credor = utf8_decode($oParam->credor);

$sSql = "select munic from db_config where codigo = ".db_getsession('DB_instit');
$rsSql = pg_query($sSql);
db_fieldsMemory($rsSql);

$rsEmpenho = pg_query($sDataEmpenho);
db_fieldsMemory($rsEmpenho);
$texto1 = trim(strtoupper(db_extenso($valor_formatado, TRUE)));
$text_transformado = ucfirst("$texto1");

$emissao = preg_split('/\//',date('d/m/y'));

$oDate = new DBDate(date('d/m/y'));
$dia_emissao = $emissao[0];
$mes_emissao = $oDate->getMesExtenso($emissao[1]);
$ano_emissao = substr($emissao[2], -2);

$pdf_cabecalho = false;
$pdf = new FPDF("P", "mm", array(175, 80));
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetTextColor(0,0,0);
$pdf->setfillcolor(235);
$pdf->SetMargins(0, 0, 0);

$pdf->AddPage('P');
$pdf->setXY(135, 3);
$pdf->SetFont('Courier', 'b', 10);
$valor_inserido ="R$ ".$valor;

$pdf->ln(2);
$pdf->SetLeftMargin(5);

$pdf->Cell(150, 5, $valor_inserido, "", 1, "R", 0);
$pdf->SetFont('Times', 'b', 9);

// Textos do cheque

for($count = strlen($text_transformado); $count < 160; $count++){
  if(strlen($text_transformado) < 160)
    $text_transformado .= ' X';
}
$pdf->setXY(5,13);
$pdf->MultiCell(165, 6, $text_transformado, 0, "L", 0, 20);
$pdf->ln(1);
$pdf->setx(6);
$pdf->Cell(0 , 6, $credor, "", 1, "L", 0);

// Rodapé do cheque
$pdf->setXY(72, 33);

$size_munic = strlen($munic);
$pdf->Cell(15, 5, $munic,"", 0,"L", 0);
$pdf->setXY(100, 33);
$pdf->Cell(13, 5, $dia_emissao, "", 0, "R", 0);
$pdf->Cell(28, 5, $mes_emissao, "", 0, "C", 0);
$pdf->Cell(26, 5, "$ano_emissao", "", 0,"R", 0);

$pdf->Output();

?>
