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
 * busca todos os veiculos cadastrados para a instituição atual
 */
$sql = "SELECT ve01_codigo codigo,
               si04_tipoveiculo||' - '||si04_descricao tipo,
               ve01_placa placa,
               ve40_veiccadcentral central,
               ve36_coddepto||' - '||descrdepto departamento
        FROM veiculos
        INNER JOIN tipoveiculos ON si04_veiculos=ve01_codigo
        INNER JOIN veiccentral ON ve40_veiculos=ve01_codigo
        INNER JOIN veiccadcentral ON ve36_sequencial=ve40_veiccadcentral
        INNER JOIN db_depart ON coddepto = ve36_coddepto
        WHERE ve01_instit = " . db_getsession('DB_instit'). "
        ORDER BY coddepto, ve01_codigo";

$resultVeic = db_query($sql);

if (pg_num_rows(db_query($sql)) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não foi encontrado nenhum veiculo para essa instituição.');
}

/*
 * busca dados da instituição atual
 */
$sqlInst = "SELECT codigo inst,
                   nomeinst nome
            FROM db_config
            WHERE codigo = " .db_getsession('DB_instit');

$resultInst = db_query($sqlInst);

db_fieldsmemory($resultInst,0);


/*
 * construção do relatório
 */
$head1 = "Geral Veiculos (Novo)";
$head3 = $inst ." - ". $nome;

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$alt = 5;
$total = 0;
$pdf->setfillcolor(235);
$pdf->addpage("L");
$pdf->setfont('arial', 'b', 10);

$pdf->cell(30, $alt, "Veículo", 1, 0, "C",1);
$pdf->cell(100, $alt, "Tipo", 1, 0, "C",1);
$pdf->cell(30, $alt, "Placa", 1, 0, "C",1);
$pdf->cell(19, $alt, "Central", 1, 0, "C",1);
$pdf->cell(100, $alt, "Departamento", 1, 1, "C",1);

for($i = 0; $i < pg_num_rows($resultVeic); $i++){
    
    db_fieldsmemory($resultVeic,$i);
    $pdf->setfont('arial', '', 8);
    $pdf->cell(30, $alt, $codigo, 1, 0, "C",0);
    $pdf->cell(100, $alt, $tipo, 1, 0, "L",0);
    $pdf->cell(30, $alt, $placa, 1, 0, "C",0);
    $pdf->cell(19, $alt, $central, 1, 0, "C",0);
    $pdf->cell(100, $alt, $departamento, 1, 1, "L",0);
}


$pdf->Output();