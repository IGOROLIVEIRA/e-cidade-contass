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
include("libs/db_sql.php");
include("classes/db_orccenarioeconomicoparam_classe.php");

$oGet = db_utils::postMemory($_GET);


$clorccenarioeconomicoparam = new cl_orccenarioeconomicoparam;

$sWhere               = "o03_instit = " . db_getsession("DB_instit");

$sCampos           = "o03_sequencial,   	";
$sCampos          .= "o03_descricao,    	";
$sCampos          .= "o03_anoreferencia,	";
$sCampos          .= "case    				";
$sCampos          .= "	 when o03_tipovalor = 1 then 'Percentual' else 'Quantidade' ";
$sCampos          .= "end as o03_tipovalor, ";
$sCampos          .= "o03_valorparam    	";

$sSqlCenario        = $clorccenarioeconomicoparam->sql_query("", $sCampos, "o03_sequencial", $sWhere);
$rsConsultaCenario = $clorccenarioeconomicoparam->sql_record($sSqlCenario);
$iLinhasCenario       = $clorccenarioeconomicoparam->numrows;
$aDadosCenario     = array();

if ($iLinhasCenario > 0) {

    for ($iInd = 0; $iInd < $iLinhasCenario; $iInd++) {

        $oDadosCenario = db_utils::fieldsMemory($rsConsultaCenario, $iInd);

        $aDadosCenario[$oDadosCenario->o03_descricao][$oDadosCenario->o03_tipovalor][$oDadosCenario->o03_anoreferencia]['nValor'] = $oDadosCenario->o03_valorparam;
    }
}

$head2 = "CENÁRIO MACROECONÔMICO";

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setfillcolor(235);

$alt = "4";

$pdf->setfont('arial', 'B', 8);

$pdf->Cell(65, $alt, "Descrição", "TR", 0, "C", 1);
$pdf->Cell(25, $alt, "Tipo Valor", 1, 0, "C", 1);
$pdf->Cell(100, $alt, "Valores", "TL", 1, "C", 1);

$pdf->Cell(65, $alt, "", "BR", 0, "C", 1);
$pdf->Cell(25, $alt, "", "BRL", 0, "C", 1);
$pdf->Cell(25, $alt, $ano, 1, 0, "C", 1);
$pdf->Cell(25, $alt, $ano + 1, 1, 0, "C", 1);
$pdf->Cell(25, $alt, $ano + 2, 1, 0, "C", 1);
$pdf->Cell(25, $alt, $ano + 3, "TBL", 1, "C", 1);

$pdf->setfont('arial', '', 8);

foreach ($aDadosCenario as $sDescricao => $aDadosTipoVal) {

    foreach ($aDadosTipoVal as $sTipoVal => $aDadosVal) {
        if (($aDadosVal[$ano]["nValor"] + $aDadosVal[$ano + 1]["nValor"] + $aDadosVal[$ano + 2]["nValor"] + $aDadosVal[$ano + 3]["nValor"]) > 0) {
            $pdf->Cell(65, $alt, $sDescricao, "BR", 0, "L", 0);
            $pdf->Cell(25, $alt, $sTipoVal, "BRL", 0, "C", 0);
            $pdf->Cell(25, $alt, $aDadosVal[$ano]["nValor"], "TBL", 0, "C", 0);
            $pdf->Cell(25, $alt, $aDadosVal[$ano + 1]["nValor"], "TBL", 0, "C", 0);
            $pdf->Cell(25, $alt, $aDadosVal[$ano + 2]["nValor"], "TBL", 0, "C", 0);
            $pdf->Cell(25, $alt, $aDadosVal[$ano + 3]["nValor"], "TBL", 0, "C", 0);
            $pdf->ln();
        }
    }
}


$pdf->Output();
