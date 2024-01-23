<?php
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

use App\Models\Acordo;
use App\Models\OrcDotacao;

require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$head3 = "RELATÓRIO ALTERAR DOTAÇÕES DE CONTRATOS";

$acordos = new Acordo();
$orcamentosDotacoes = new OrcDotacao();

$acordosDotacoesAnoOrigem = $acordos
    ->getAcordosDotacoesComPosicoes()
    ->where('ac16_instit', $codigoInstituicao)
    ->where('orcdotacao.o58_anousu', $anoOrigem)
    ->get();

$orcamentosDotacoesAnoDestino = $orcamentosDotacoes
    ->getOrcamentosDotacoesAnoDestino($anoDestino, $codigoInstituicao)
    ->get();

$dotacoesAcordosOrcamentosNaoInseridas = $acordosDotacoesAnoOrigem
    ->whereNotIn('estrutural', $orcamentosDotacoesAnoDestino->pluck('estrutural'));


$pdf = new PDF("L");
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$pdf->AddPage("L");
$alt = 5;
$total = 0;
$totalvalor = 0;

$codacordo = '';

foreach ($dotacoesAcordosOrcamentosNaoInseridas->toArray() as $naoInseridas) {
    $data_formatada = !empty($naoInseridas['vigenciafim'])
        ? DateTime::createFromFormat('Y-m-d', $naoInseridas['vigenciafim'])->format('d/m/Y')
        : '';

    if ($codacordo !== $naoInseridas['codacordo']) {
        $pdf->cell(140, $alt, "Contrato: {$naoInseridas['numerocontrato']}", "BLT", 0, "L", 1);
        $pdf->cell(140, $alt, "Vigência Final: $data_formatada", "RBT", 0, "L", 1);
        $pdf->Ln();
    }

    $pdf->setfont('arial', 'b', 8);

    if ($codacordo !== $naoInseridas['codacordo']) {
        $pdf->cell(15, $alt, "Item", "RBLT", 0, "C", 0);
        $pdf->cell(180, $alt, "Descrição", "RBLT", 0, "C", 0);
        $pdf->cell(15, $alt, "Dotação", "RBLT", 0, "C", 0);
        $pdf->cell(70, $alt, "Estrutural", "RBLT", 0, "C", 0);
    }

    $pdf->Ln();

    $pdf->setfont('arial', '', 8);

    $tamanhoDescricao = strlen($naoInseridas['descmaterial']);

    $altura = $pdf->CalculateCellHeight($tamanhoDescricao, 180);

    $descricaoMaterialGrande = $tamanhoDescricao > 60;

    if ($descricaoMaterialGrande) {
        $pdf->cell(15, $altura, $naoInseridas['codigomaterial'], "RBLT", 0, "C", 0);
        $pdf->MultiAlignCell(180, $alt, $naoInseridas['descmaterial'], 'RLT');

    } else {
        $pdf->cell(15, $alt, $naoInseridas['codigomaterial'], "RBLT", 0, "C", 0);
        $pdf->cell(180, $altura, $naoInseridas['descmaterial'], "RBLT", 0, "L", 0);
    }

    $pdf->cell(15, $altura, $naoInseridas['dotacao'], "RBLT", 0, "C", 0);
    $pdf->cell(70, $altura, $naoInseridas['estrutural'], "RBLT", 0, "C", 0);

    $pdf->Ln();
    $pdf->cell(280, 0, "", "RBLT", 0, "C", 0);
    $pdf->Ln();
    $pdf->setfont('arial', 'b', 8);

    $codacordo = $naoInseridas['codacordo'];
}

$pdf->Ln(1);

$pdf->Output();
