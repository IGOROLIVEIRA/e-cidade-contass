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
include("classes/db_veiculos_classe.php");
include("classes/db_veiculoscomb_classe.php");
include("classes/db_veiccaddestino_classe.php");

$clveiculos = new cl_veiculos;
$clveiculoscomb = new cl_veiculoscomb;

$clveiculos->rotulo->label();

$clrotulo = new rotulocampo;

$clrotulo->label("ve06_veiccadcomb");
$clrotulo->label("ve40_veiccadcentral");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

//$where=" ve36_coddepto = " . db_getsession("DB_coddepto");
$where = " 1 = 1 ";
if ($iVeiculo != "") {
    $where .= " and ve01_codigo = $iVeiculo ";
}
if ($sPlaca != "") {
    $where .= " and ve01_placa = '$sPlaca' ";
}
if ($iMotorista != "") {
    $where .= " and ve60_veicmotoristas = $iMotorista ";
}

if ($iCentral != "") {
    $where .= " and ve40_veiccadcentral = $iCentral ";
}

if ($sDestino != "0") {
    $where .= " and ve60_destinonovo = $sDestino ";
}

if (($sDataIni != "--") && ($sDataFim != "--")) {
    $where .= " and  ve60_datasaida  between '$sDataIni' and '$sDataFim'  ";
    $sDataIni = db_formatar($sDataIni, "d");
    $sDataFim = db_formatar($sDataFim, "d");
    $info = "Período De $sDataIni até $sDataFim.";
} else if ($sDataIni != "--") {
    $where .= " and  ve60_datasaida >= '$sDataIni'  ";
    $sDataIni = db_formatar($sDataIni, "d");
    $info = "Período Apartir de $sDataIni.";
} else if ($sDataFim != "--") {
    $where .= "and ve60_datasaida <= '$sDataFim'   ";
    $sDataFim = db_formatar($sDataFim, "d");
    $info = "Período Até $sDataFim.";
} else if ($sDestino != "0") {
    $clveiccaddestino = new cl_veiccaddestino;
    $rsDestino = $clveiccaddestino->sql_record($clveiccaddestino->sql_query_file($sDestino, "ve75_destino"));
    db_fieldsmemory($rsDestino, 0);
    $info = "DESTINO: " . $ve75_destino;
}

$head3 = "MOVIMENTAÇÃO DE VEÍCULOS";
$head4 = @$info;
$sGroupBy = " group BY ve60_codigo,
                ve60_datasaida,
                ve60_horasaida,
                ve60_medidasaida,
                z01_nome,
                ve60_destino,
                ve61_codigo,
                ve61_datadevol,
                ve61_horadevol,
                ve61_medidadevol,
                ve60_coddepto,
                descrdepto,ve01_codigo,ve01_placa ";
$sOrderBy = " ve60_coddepto, ve01_codigo, ve60_datasaida ";
$campos = " DISTINCT
                ve60_codigo,
                ve60_datasaida,
                ve60_horasaida,
                ve60_medidasaida,
                z01_nome as motorista,
                ve60_destino as destino,
                ve61_codigo,
                ve61_datadevol,
                ve61_horadevol,
                ve61_medidadevol,
                ve60_coddepto,
                descrdepto as departamento,
                ve01_codigo,ve01_placa,
                (max(ve61_medidadevol))-(min(ve60_medidasaida)) as percoreu ";
$sSqlGeral = $clveiculos->sql_query_movimentacao(null, $campos, $sOrderBy, $where . $sGroupBy);

$result = db_query(" drop table if exists w_movveiculos; create table w_movveiculos as {$sSqlGeral} ") or die(pg_last_error());

if (pg_num_rows(db_query("select * from w_movveiculos")) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não foi encontrado nenhuma movimentação com esses filtros.');
}

//db_criatabela($result);

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca = 1;
$alt = 5;
$total = 0;
$p = 0;
$tam = 1;
$iCodDptoAtual = 0;
$bMostraDpto = false;
$iCodigoVeiculoAtual = 0;
$bMostraVeiculo = false;

/**
 * Seleciona todos os departamento para agrupar
 */
$sSqlDepartamentos = "select distinct ve60_coddepto,departamento from w_movveiculos";
$rSqlDepartamentos = db_query($sSqlDepartamentos);

$pdf->addpage("L");
$pdf->setfont('arial', 'b', 10);
/**
 * Para cada departamento...
 */
for ($iContDep = 0; $iContDep < pg_num_rows($rSqlDepartamentos); $iContDep++) {
    db_fieldsmemory($rSqlDepartamentos, $iContDep);

    $pdf->cell(0, $alt, "Secretaria: {$ve60_coddepto} - {$departamento}", 1, 1, "L", true);

    /**
     * Seleciono todos os veículso de cada departamento para agrupar por veículos
     */
    $sSqlVeiculos = "select distinct ve01_codigo,ve01_placa from w_movveiculos where ve60_coddepto = {$ve60_coddepto}";
    $rSqlveiculos = db_query($sSqlVeiculos);
    for ($iContVeic = 0; $iContVeic < pg_num_rows($rSqlveiculos); $iContVeic++) {
        db_fieldsmemory($rSqlveiculos, $iContVeic);

        $pdf->cell(0, $alt, "Código do Veículo: {$ve01_codigo} Placa: {$ve01_placa} ", 1, 1, "L", true);
        $pdf->cell(16, $alt, "Retirada", 1, 0, "C", 1);
        $pdf->cell(18, $alt, "Saída", 1, 0, "C", 1);
        $pdf->cell(15, $alt, "H. Saída", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Km Saída", 1, 0, "C", 1);
        $pdf->cell(54, $alt, "Motorista", 1, 0, "C", 1);
        $pdf->cell(74, $alt, "Observação", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Devolução", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Retorno", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "H. Dev.", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "KM Dev.", 1, 1, "C", 1);

        /**
         * Busca as movimentações de cada veiculo
         */

        $sSqlMov = "select * from w_movveiculos where ve01_codigo = {$ve01_codigo}";
        $rSqlMov = db_query($sSqlMov);
        $total = 0;
        for ($iContMov = 0; $iContMov < pg_num_rows($rSqlMov); $iContMov++) {
            db_fieldsmemory($rSqlMov, $iContMov);
            $tam = 1;
            if (strlen($motorista) > 29 || strlen($destino) > 30) {
                $amotorista = quebrar_texto($motorista, 29);
                $tam1 = count($amotorista);
                $adestino = quebrar_texto($destino, 35);
                $tam2 = count($adestino);
                $tam = ($tam1 > $tam2 ? $tam1 : $tam2);
            }

            $pdf->setfont('arial', '', 8);
            $pdf->cell(16, $alt * $tam, $ve60_codigo, 1, 0, "C", $p);
            $pdf->cell(18, $alt * $tam, db_formatar($ve60_datasaida, "d"), 1, 0, "C", $p);
            $pdf->cell(15, $alt * $tam, $ve60_horasaida, 1, 0, "C", $p);
            $pdf->cell(20, $alt * $tam, $ve60_medidasaida, 1, 0, "C", $p);
            if (strlen($motorista) > 29) {
                $pos_x = $pdf->x;
                $pos_y = $pdf->y;
                $pdf->Cell(54, $alt * $tam, "", 1, 0, "L", $p);
                $pdf->x = $pos_x;
                $pdf->y = $pos_y;
                foreach ($amotorista as $motorista_novo) {
                    $motorista_novo = ltrim($motorista_novo);
                    $pdf->cell(54, $alt, $motorista_novo, 0, 1, "L", $p);
                    $pdf->x = $pos_x;
                }
                $pdf->x = $pos_x + 54;
                $pdf->y = $pos_y;
            } else {
                $pdf->cell(54, $alt * $tam, $motorista, 1, 0, "L", $p);
            }
            if (strlen($destino) > 35) {
                $pos_x = $pdf->x;
                $pos_y = $pdf->y;
                $pdf->Cell(74, $alt * $tam, "", 1, 0, "L", $p);
                $pdf->x = $pos_x;
                $pdf->y = $pos_y;
                foreach ($adestino as $destino_novo) {
                    $destino_novo = ltrim($destino_novo);
                    $pdf->cell(74, $alt, $destino_novo, 0, 1, "L", $p);
                    $pdf->x = $pos_x;
                }
                $pdf->x = $pos_x + 74;
                $pdf->y = $pos_y;
            } else {
                $pdf->cell(74, $alt * $tam, $destino, 1, 0, "L", $p);
            }
            $pdf->cell(20, $alt * $tam, $ve61_codigo, 1, 0, "C", $p);
            $pdf->cell(20, $alt * $tam, db_formatar($ve61_datadevol, "d"), 1, 0, "C", $p);
            $pdf->cell(20, $alt * $tam, $ve61_horadevol, 1, 0, "C", $p);
            $pdf->cell(20, $alt * $tam, $ve61_medidadevol, 1, 1, "C", $p);
            $total += $percoreu;
        }

        $pdf->setfont('arial', 'b', 10);
        $pdf->cell(257, $alt, "TOTAL DE KM RODADOS:", 1, 0, "L", 0);
        $pdf->cell(20, $alt, "{$total}", "TRB", 1, "C", 0);
        $pdf->ln();
    }
}
$pdf->Output();

function quebrar_texto($texto, $tamanho)
{

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {

        if (strlen($word) > $tamanho) {

            $aTextoNovo = str_split($word, $tamanho);
        } else {

            $string_ant = $string_atual;
            $string_atual .= " " . $word;
            if (strlen($string_atual) > $tamanho) {
                $aTextoNovo[] = $string_ant;
                $string_ant = "";
                $string_atual = $word;
            }
        }
    }

    if ($string_atual != '') {

        $aTextoNovo[] = $string_atual;
    }
    return $aTextoNovo;
}
