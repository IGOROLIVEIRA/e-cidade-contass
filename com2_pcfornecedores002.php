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
 * query que busca os dados para retorno do relat�rio
 */
use \App\Repositories\Patrimonial\Fornecedores\PcForneRepository;
$pcForneRepository = new PcForneRepository();

$fornecedores = $pcForneRepository->getForneByStatusBlockWithCgm($bloqueado);

/*
 * constru��o do relat�rio
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
    $pdf->cell(20, $alt, "Fornecedor:", 0, 0, "L");
    $pdf->setfont('arial', '', 6);
    $pdf->cell(120, $alt, $fornecedor->cgm->z01_nome, 0, 0, "L");
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(17, $alt, "CNPJ:", 0, 0, "C");
    $pdf->setfont('arial', '', 6);
    $pdf->cell(122, $alt, $fornecedor->cgm->z01_cgccpf, 0, 1, "L",0);


    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(279, $alt, "Objeto Social:", 1, 1, "C",1);
    $pdf->setfont('arial', '', 6);
    $pdf->MultiCell(279, $alt,$fornecedor->pc60_obs, 1, 'L', false);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(279, $alt, "Dados:", 1, 1, "C",1);

    $pdf->cell(20, $alt, "Estado: " , 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(120, $alt, $fornecedor->cgm->z01_uf , 1, 0, "L",0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(17, $alt, "Munic�pio:  ", 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(122, $alt, $fornecedor->cgm->z01_munic, 1, 1, "L",0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(20, $alt, "CEP:  ", 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(120, $alt,$fornecedor->cgm->z01_cep , 1, 0, "L",0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(17, $alt, "Bairro:  " , 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(53, $alt, $fornecedor->cgm->z01_bairro , 1, 0, "L",0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(7, $alt, "N�:  ", 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(62, $alt,$fornecedor->cgm->z01_numero , 1, 1, "L",0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(20, $alt, "Logradouro:  ", 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(259, $alt, $fornecedor->cgm->z01_ender , 1, 1, "L",0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(20, $alt, "Telefone:  " , 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(120, $alt, $fornecedor->cgm->z01_telef , 1, 0, "L",0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(17, $alt, "Email: ", 1, 0, "L",0);
    $pdf->setfont('arial', '', 6);
    $pdf->cell(122, $alt,  $fornecedor->cgm->z01_email , 1, 1, "L",0);

    if ($fornecedor->pc60_bloqueado == 'f') {
        $dataInicio = DateTime::createFromFormat('Y-m-d', $fornecedor->pc60_databloqueio_ini);
        $dataFim = DateTime::createFromFormat('Y-m-d', $fornecedor->pc60_databloqueio_fim);

        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(279, $alt, "Bloqueado no per�odo {$dataInicio->format('d/m/Y')} � {$dataFim->format('d/m/Y')}", 1, 1, "L",0);
        $pdf->cell(20, $alt,"Motivo: " , 1, 0, "L",0);
        $pdf->setfont('arial', '', 6);
        $pdf->cell(259, $alt,  $fornecedor->pc60_motivobloqueio ?? "" , 1, 1, "L",0);
    }

    $pdf->cell(279, $alt, "", 0, 1, "C");
}

$pdf->Output();
