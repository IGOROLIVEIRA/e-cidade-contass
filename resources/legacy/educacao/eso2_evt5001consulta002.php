<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$sWhere = " rh218_instit = " . db_getsession("DB_instit");

$head3 = "Evento 5001 Consulta";
if (!empty($rh218_perapurmes) && !empty($rh218_perapurano)) {
  $head4 = "PERÍODO : " . $rh218_perapurmes . " / " . $rh218_perapurano;
}
if (!empty($z01_cgccpf)) {
  $sWhere .= " and z01_cgccpf = '$z01_cgccpf' ";
  $head5 = "CPF : " . db_formatar($z01_cgccpf, "cpf");
}
if (!empty($rh218_numcgm)) {
  $sWhere .= " and rh218_numcgm = '$rh218_numcgm' ";
  $head6 = "CMG : " . $rh218_numcgm;
}
if (!empty($rh218_regist)) {
  $sWhere .= " and rh218_regist = $rh218_regist ";
  $head7 = "Matrícula : " . $rh218_regist;
}

if (!empty($rh218_perapurano)) {
  $sWhere .= " and rh218_perapurano = $rh218_perapurano ";
}
if (!empty($rh218_perapurmes)) {
  $sWhere .= " and rh218_perapurmes = $rh218_perapurmes ";
}
if (!empty($rh218_perapurano) && empty($rh218_perapurmes)) {
  $sWhere .= " and rh218_perapurmes is null ";
}

$oEvt5001Consulta = db_utils::getDao('evt5001consulta');

$campos = $oEvt5001Consulta->getCamposRelConsulta();
$sSql = $oEvt5001Consulta->sql_query(null, $campos, "rh218_sequencial desc", $sWhere);
$rsDados = $oEvt5001Consulta->sql_record($sSql);

if ($oEvt5001Consulta->numrows == 0) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Não existem dados nesse período");
}

$pdf   = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);

$troca = 1;
$alt   = 4;
$totalBaseSistema = 0;
$totalContribSocial = 0;
$totalDescRealizado = 0;
$totalValorDevido = 0;
$totalDiferenca = 0;
$totalDiferencaBase = 0;

for ($iCont = 0; $iCont < pg_num_rows($rsDados); $iCont++) {

  $oDados = db_utils::fieldsMemory($rsDados, $iCont);

  if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {

    $pdf->addpage("L");
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(20, $alt, 'CPF', 1, 0, "L", 1);
    $pdf->cell(75, $alt, 'Nome/Razão Social', 1, 0, "L", 1);
    $pdf->cell(15, $alt, 'Matrícula', 1, 0, "L", 1);
    $pdf->cell(10, $alt, 'Categ', 1, 0, "L", 1);
    $pdf->cell(30, $alt, 'Base Sistema', 1, 0, "L", 1);
    $pdf->cell(30, $alt, 'Base eSocial', 1, 0, "L", 1);
    $pdf->cell(20, $alt, 'Dif. Base', 1, 0, "L", 1);
    $pdf->cell(30, $alt, 'Desc Realizado', 1, 0, "L", 1);
    $pdf->cell(30, $alt, 'Valor Devido', 1, 0, "L", 1);
    $pdf->cell(20, $alt, 'Diferença', 1, 1, "L", 1);

    $troca = 0;
    $preenche = true;
  }

  $aNome = quebraTexto($oDados->z01_nome, 47);
  $altlinha = ($alt * count($aNome));

  $preenche = !$preenche;
  $pdf->setfont('arial', '', 7);
  $pdf->cell(20, $altlinha, db_formatar($oDados->z01_cgccpf, "cpf"), 1, 0, "L", intval($preenche));
  multiCell($pdf, $aNome, $alt, $altlinha, 75, $preenche);
  $pdf->cell(15, $altlinha, $oDados->rh218_regist, 1, 0, "C", intval($preenche));
  $pdf->cell(10, $altlinha, $oDados->rh218_codcateg, 1, 0, "C", intval($preenche));
  $pdf->cell(30, $altlinha, db_formatar($oDados->vlr_sistema, "f"), 1, 0, "R", intval($preenche));
  $pdf->cell(30, $altlinha, db_formatar($oDados->rh218_vlrbasecalc, "f"), 1, 0, "R", intval($preenche));
  $pdf->cell(20, $altlinha, db_formatar($oDados->vlr_sistema - $oDados->rh218_vlrbasecalc, "f"), 1, 0, "R", intval($preenche));
  $pdf->cell(30, $altlinha, db_formatar($oDados->rh218_vrdescseg, "f"), 1, 0, "R", intval($preenche));
  $pdf->cell(30, $altlinha, db_formatar($oDados->rh218_vrcpseg, "f"), 1, 0, "R", intval($preenche));
  $pdf->cell(20, $altlinha, db_formatar($oDados->diferenca, "f"), 1, 1, "R", intval($preenche));

  $totalContribSocial += $oDados->rh218_vlrbasecalc;
  $totalDescRealizado += $oDados->rh218_vrdescseg;
  $totalValorDevido += $oDados->rh218_vrcpseg;
  $totalDiferenca += $oDados->diferenca;
  $totalBaseSistema += $oDados->vlr_sistema;
  $totalDiferencaBase += ($oDados->vlr_sistema - $oDados->rh218_vlrbasecalc);
}

$pdf->setfont('arial', 'b', 8);
$preenche = !$preenche;
$pdf->cell(120, $alt, 'TOTAL DE REGISTROS :  ' . pg_num_rows($rsDados), 1, 0, "C", intval($preenche));
$pdf->cell(30, $alt, db_formatar($totalBaseSistema, "f"), 1, 0, "R", intval($preenche));
$pdf->cell(30, $alt, db_formatar($totalContribSocial, "f"), 1, 0, "R", intval($preenche));
$pdf->cell(20, $alt, db_formatar($totalDiferencaBase, "f"), 1, 0, "R", intval($preenche));
$pdf->cell(30, $alt, db_formatar($totalDescRealizado, "f"), 1, 0, "R", intval($preenche));
$pdf->cell(30, $alt, db_formatar($totalValorDevido, "f"), 1, 0, "R", intval($preenche));
$pdf->cell(20, $alt, db_formatar($totalDiferenca, "f"), 1, 1, "R", intval($preenche));

$pdf->Output();


function quebraTexto($texto, $tamanho)
{

  $aTexto = explode(" ", $texto);
  $string_atual = "";
  foreach ($aTexto as $word) {
    $string_ant = $string_atual;
    $string_atual .= " " . $word;
    if (strlen($string_atual) > $tamanho) {
      $aTextoNovo[] = $string_ant;
      $string_ant   = "";
      $string_atual = $word;
    }
  }
  $aTextoNovo[] = $string_atual;
  return $aTextoNovo;
}

function multiCell($oPdf, $aTexto, $iTamFixo, $iTam, $iTamCampo, $bPreenche)
{

  if (count($aTexto) == 1) {
    $oPdf->cell($iTamCampo, $iTam, $aTexto[0], 1, 0, "L", intval($bPreenche));
    return;
  }
  $pos_x = $oPdf->x;
  $pos_y = $oPdf->y;
  $oPdf->cell($iTamCampo, $iTam, "", 1, 0, 'L', 0);
  $oPdf->x = $pos_x;
  $oPdf->y = $pos_y;
  foreach ($aTexto as $sProcedimento) {
    $sProcedimento = ltrim($sProcedimento);
    $oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L', intval($bPreenche));
    $oPdf->x = $pos_x;
  }
  $oPdf->x = $pos_x + $iTamCampo;
  $oPdf->y = $pos_y;
}
