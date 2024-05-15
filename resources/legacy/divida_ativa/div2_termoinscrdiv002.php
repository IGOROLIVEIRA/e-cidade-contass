<?php
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

require_once("fpdf151/pdf3.php");
require_once("fpdf151/impmodelos/especificos/termoinscrdiv.php");
require_once("libs/db_utils.php");
require_once("libs/db_sql.php");
require_once("libs/db_libdocumento.php");
require_once("classes/db_db_modulos_classe.php");

$oGet = db_utils::postMemory($_GET, 0);

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

$cl_db_modulos = new cl_db_modulos;

$sWhere = "";
$sAnd = "";
$pdf = new pdftermoinscr();

if (isset($iDbInstit)) {
    if ($iDbInstit != "") {
        $sWhere .= " {$sAnd} divida.v01_instit = {$iDbInstit} ";
        $sAnd = " and ";
    }
}

if (isset($oGet->z01_numcgm)) {
    if ($oGet->z01_numcgm != "") {
        $sWhere .= " {$sAnd} arrenumcgm.k00_numcgm = {$oGet->z01_numcgm} ";
        $sAnd = " and ";
        $pdf->cgmorigem = $oGet->z01_numcgm;
    }
}

if (isset($oGet->j01_matric)) {
    if ($oGet->j01_matric != "") {
        $sWhere .= " {$sAnd} arrematric.k00_matric = {$oGet->j01_matric} ";
        $sAnd = " and ";
    }
}

if (isset($oGet->q02_inscr)) {
    if ($oGet->q02_inscr != "") {
        $sWhere .= " {$sAnd} arreinscr.k00_inscr = {$oGet->q02_inscr} ";
        $sAnd = " and ";
    }
}

$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(235);
$pdf->addpage();
$pdf->drawDevedores();
$pdf->drawCertifico();
$pdf->drawDebitos();
$pdf->drawTextoPadrao();
$pdf->drawAssinaturas();
$pdf->output();