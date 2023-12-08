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
include("libs/db_sql.php");

/*
 * query que busca os dados para retorno do relatório
 */
use \App\Repositories\Patrimonial\Fornecedores\PcForneRepository;
$pcForneRepository = new PcForneRepository();

$fornecedores = $pcForneRepository->getForneByStatusBlockWithCgm($tipo_fornecedor);

/*
 * construção do relatório
 */
$head1 = "Fornecedores";
$head3 = $inst ." - ". $nome;

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$alt = 4;
$total = 0;
$pdf->setfillcolor(235);
$pdf->addpage("L");
$pdf->setfont('arial', 'b', 8);

/** @var \App\Models\PcFoner $fornecedor */
foreach($fornecedores as $fornecedor) {
    $pdf->setfont('arial', 'b', 8);

    $pdf->cell(280, $alt, "Objeto Solcial", 1, 1, "C",1);

    $pdf->setfont('arial', '', 6);
    $pdf->cell(280, $alt, $fornecedor->pc60_objsocial, 1, 0, "C",1);

    $pdf->cell(280, $alt, "Dados", 1, 1, "C",1);

    $pdf->setfont('arial', '', 6);
    $pdf->cell(140, $alt, "Estado: " + $fornecedor->cgm->z01_uf, 1, 0, "C",0);
    $pdf->cell(140, $alt, "Município: " + $fornecedor->cgm->z01_munic, 1, 0, "C",1);

    $pdf->cell(140, $alt, "Cep: " + $fornecedor->cgm->z01_cepcon, 1, 0, "C",0);
    $pdf->cell(70, $alt, "Bairro: " + $fornecedor->cgm->z01_bairro, 1, 0, "L",0);
    $pdf->cell(70, $alt, "N°: " + $fornecedor->cgm->z01_numero, 1, 0, "C",1);
    $pdf->cell(280, $alt, "N°: " + $fornecedor->cgm->z01_ender, 1, 0, "C",1);

    $pdf->cell(140, $alt, "Telefone: " + $fornecedor->cgm->z01_telcel, 1, 0, "C",0);
    $pdf->cell(140, $alt, "Email: " + $fornecedor->cgm->z01_email, 1, 0, "C",1);
    $pdf->cell(280, $alt, "Motivo " + $fornecedor->pc60_motivobloqueio, 1, 0, "C",1);


    $pdf->cell(279, $alt, "", 0, 1, "C");
}

$pdf->Output();
