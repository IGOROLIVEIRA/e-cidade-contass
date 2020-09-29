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
require_once("classes/db_veicabast_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_SERVER_VARS);

function imprimir_cabecalho($pdf, $alt)
{
    $pdf->AddPage("L");
    $pdf->SetFont('Arial', 'B', 8);

    $pdf->cell(44, $alt, "Veículo", 1, 0, "L", 1);
    $pdf->cell(15, $alt, "Placa", 1, 0, "C", 1);
    $pdf->cell(15, $alt, "Ano", 1, 0, "C", 1);
    $pdf->cell(34, $alt, "Observações", 1, 0, "L", 1);
    $pdf->cell(22, $alt, "Combústivel", 1, 0, "L", 1);
    $pdf->cell(15, $alt, "Data", 1, 0, "C", 1);
    $pdf->cell(10, $alt, "Hora", 1, 0, "C", 1);
    $pdf->cell(22, $alt, "Medida Inicial", 1, 0, "C", 1);
    $pdf->cell(22, $alt, "Medida Final", 1, 0, "C", 1);
    $pdf->cell(22, $alt, "Medida Rodada", 1, 0, "C", 1);
    $pdf->cell(22, $alt, "Qtde. Comb.", 1, 0, "C", 1);
    $pdf->cell(22, $alt, "Valor Comb.", 1, 0, "C", 1);
    $pdf->cell(22, $alt, "Cons. Médio", 1, 1, "C", 1);
    $pdf->cell(44, $alt, "Marca/Modelo", 1, 0, "C", 1);
    $pdf->cell(44, $alt, "Tipo", 1, 1, "C", 1);

    $pdf->SetFont('Arial', '', 8);
}

$clveicabast = new cl_veicabast;

$periodo = "";
$quebrar = "";
$dbwhere = "";
$and = " and ";

if (isset($ve70_dataini) && trim($ve70_dataini) != "") {
    $dbwhere .= "ve70_dtabast between '$ve70_dataini' and '$ve70_datafin' ";
    $periodo = db_formatar($ve70_dataini, "d") . " a " . db_formatar($ve70_datafin, "d");
}


$iCoddepto = null;
if (isset($idCentral) && trim($idCentral) != 0) {

    if ($dbwhere != "") {
        $dbwhere .= $and;
    }
    $dbwhere .= "ve40_veiccadcentral = {$idCentral} ";
    $sQuery = "SELECT coddepto
						     FROM veiccadcentral
																	   INNER JOIN db_depart ON ve36_coddepto = coddepto
  							WHERE ve36_sequencial = {$idCentral} ";
    $resQuery = db_query($sQuery);
    if (pg_num_rows($resQuery) > 0) {
        $rowQuery = pg_fetch_object($resQuery);
        $iCoddepto = $rowQuery->coddepto;
    }
}

if (isset($ve01_codigo) && trim($ve01_codigo) != "") {
    if ($dbwhere != "") {
        $dbwhere .= $and;
    }
    $dbwhere .= "ve01_codigo in (" . $ve01_codigo . ") ";
}

if (isset($ve01_veiccadtipo) && trim($ve01_veiccadtipo) != "") {

    if ($dbwhere != "") {
        $dbwhere .= $and;
    }
    $dbwhere .= "ve01_veiccadtipo=" . $ve01_veiccadtipo;
}

if (isset($ve71_veiccadposto) && trim($ve71_veiccadposto) != "") {
    if ($dbwhere != "") {
        $dbwhere .= $and;
    }

    $dbwhere .= "ve71_veiccadposto=" . $ve71_veiccadposto;
}

if (isset($ve06_veiccadcomb) && trim($ve06_veiccadcomb) != "") {
    if ($dbwhere != "") {
        $dbwhere .= $and;
    }

    $dbwhere .= "ve06_veiccadcomb=" . $ve06_veiccadcomb;
}

switch ($situacao) {
    case 0:
        $head6 = "Todos os Abastecimentos";
        break;
    case 1:
        if ($dbwhere != "") {
            $dbwhere .= $and;
        }
        $head6 = "Somente Ativos";
        $dbwhere .= " ve70_ativo = 1 ";
        break;
    case 2:
        if ($dbwhere != "") {
            $dbwhere .= $and;
        }
        $head6 = "Somente Anulados";
        $dbwhere .= " ve70_ativo = 0 ";
        break;
}
/**if ($dbwhere != "") {
    $dbwhere .= $and;
}
$dbwhere .= " ve01_veictipoabast = 1 ";*/
$sCampos = " distinct
	      coddepto,
	      descrdepto,
	      ve70_origemgasto,
	      ve01_codigo,
	      ve01_placa,
	      z01_numcgm cgmposto,
	      case when ve71_nota is null or ve71_nota = '' then 'INTERNO' else z01_nome end as posto,
              ve70_codigo,
              ve70_dtabast as ve70_data,
              ve70_hora,
              ve26_descr,
              coalesce(ve60_medidasaida, ve70_medida) as medida_retirada,
              coalesce(ve70_medida,0) as medida_devolucao,
              case
                when coalesce(ve60_medidasaida, ve70_medida) > coalesce(ve70_medida,0) then
                  0
                else
                  coalesce(ve70_medida,0) - coalesce(ve60_medidasaida,0)
              end as medida_rodada,
              case
                when coalesce(ve60_medidasaida, ve70_medida) > coalesce(ve70_medida,0) then
                  0
                else
                  ve70_litros
              end as ve70_litros,
              ve70_valor,
              e60_codemp||'/'||e60_anousu as numemp ";

if($exibir_cupom){
    $sCampos .= ', ve71_nota';
}

$sSqlBuscaAbastecimentos = $clveicabast->sql_query_abast_novo(null, $sCampos, $ordem, $dbwhere, $iCoddepto);
$result = db_query(" drop table if exists w_relabastecimentoveiculos; create table w_relabastecimentoveiculos as {$sSqlBuscaAbastecimentos} ") or die(pg_last_error());

                    if (pg_num_rows(db_query("select * from w_relabastecimentoveiculos")) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não foi encontrado nenhuma abastecimento com esses filtros.');
}

$head2 = "RELATÓRIO DE ABASTECIMENTO";

if ($periodo != "") {
    $head3 = "PERIODO: " . $periodo;
}

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetFillColor(235);
$pdf->lMargin = 3;
$pdf->SetFont('Arial', 'B', 8);
//quebra de página
$nTotalCombustivel = 0;
$nTotalValorAbastecido = 0;
$nTotalConsumoMedio = 0;
$conta = 0;
$mostra = false;
//
$troca = 1;
$p = 0;
$alt = 4;

/**
 * Seleciona todos os departamento para agrupar
 */
$sSqlDepartamentos = "select distinct coddepto,descrdepto from w_relabastecimentoveiculos";
$rSqlDepartamentos = db_query($sSqlDepartamentos) or die(pg_last_error());

$pdf->addpage("L");
$pdf->setfont('arial', 'b', 10);
/**
 * Para cada departamento...
 */
for ($iContDep = 0; $iContDep < pg_num_rows($rSqlDepartamentos); $iContDep++) {
    db_fieldsmemory($rSqlDepartamentos, $iContDep);

    $pdf->cell(0, $alt, "Secretaria: {$coddepto} - {$descrdepto}", 1, 1, "L", true);

    /**
     * Seleciono todos os veículso de cada departamento para agrupar por veículos
     */
    $sSqlVeiculos = "select distinct ve01_codigo,ve01_placa from w_relabastecimentoveiculos where coddepto = {$coddepto}";
    $rSqlveiculos = db_query($sSqlVeiculos) or die(pg_last_error());
    for ($iContVeic = 0; $iContVeic < pg_num_rows($rSqlveiculos); $iContVeic++) {
        db_fieldsmemory($rSqlveiculos, $iContVeic);

        /**
         * Seleciono todas as origens de gasto do veiculo de cada iteração do loop
         */
        db_query("update w_relabastecimentoveiculos set ve70_origemgasto =3 where ve70_origemgasto is null");
        $sSqlOrigem = "select distinct case when ve70_origemgasto=1 then 'ESTOQUE' when ve70_origemgasto=3 then 'NÃO INFORMADO' else 'CONSUMO IMEDIATO' end as origemgasto, ve70_origemgasto from w_relabastecimentoveiculos where ve01_codigo = {$ve01_codigo}";
        $rSqlOrigem = db_query($sSqlOrigem) or die(pg_last_error());
        for ($iContOrig = 0; $iContOrig < pg_num_rows($rSqlOrigem); $iContOrig++) {
            db_fieldsmemory($rSqlOrigem, $iContOrig);

            /**
             * Seleciono os postos do veiculo no loop
             */
            $sSqlPostos = "select distinct cgmposto, posto from w_relabastecimentoveiculos where ve01_codigo = {$ve01_codigo} and ve70_origemgasto = {$ve70_origemgasto}";
            $rSqlPostos = db_query($sSqlPostos) or die(pg_last_error());
            for ($iContPosto = 0; $iContPosto < pg_num_rows($rSqlPostos); $iContPosto++) {
                db_fieldsmemory($rSqlPostos, $iContPosto);

                $moreWidth = !$exibir_cupom ? 3 : 0;

                $pdf->cell(0, $alt, "Código do Veículo: {$ve01_codigo} Placa: {$ve01_placa} - Origem Gasto: {$origemgasto} - Posto: {$posto}", 1, 1, "L", true);
                $pdf->cell(30, $alt, "Abastecimento", 1, 0, "C", 1);
                $pdf->cell(19+$moreWidth, $alt, "Data", 1, 0, "C", 1);
                $pdf->cell(20, $alt, "H. Saída", 1, 0, "C", 1);
                $pdf->cell(25+$moreWidth, $alt, "Combustível", 1, 0, "C", 1);
                $pdf->cell(23+$moreWidth, $alt, "Km Inicial", 1, 0, "C", 1);
                $pdf->cell(23+$moreWidth, $alt, "Km Final", 1, 0, "C", 1);
                $pdf->cell(30, $alt, "Km Percorrido", 1, 0, "C", 1);
                if($exibir_cupom){
                    $pdf->cell(18, $alt, "Cupom", 1, 0, "C", 1);
                }
                $pdf->cell(25+$moreWidth, $alt, "Qtde Comb.", 1, 0, "C", 1);
                $pdf->cell(27+$moreWidth, $alt, "Valor Abastec.", 1, 0, "C", 1);
                $pdf->cell(20, $alt, "Empenho", 1, 0, "C", 1);
                $pdf->cell(24, $alt, "Cons. Médio", 1, 1, "C", 1);

                /**
                 * Busca as movimentações de cada veiculo
                 */

                $sSqlMov = "select * from w_relabastecimentoveiculos where ve01_codigo = {$ve01_codigo} and coddepto = {$coddepto} and ve70_origemgasto = {$ve70_origemgasto} and cgmposto = {$cgmposto}";
                $rSqlMov = db_query($sSqlMov);
                $total = 0;
                $nTotalCombustivel = 0;
                $nTotalValorAbastecido = 0;
                $nTotalConsumoMedio = 0;
                for ($iContMov = 0; $iContMov < pg_num_rows($rSqlMov); $iContMov++) {
                    db_fieldsmemory($rSqlMov, $iContMov);

                    $pdf->setfont('arial', '', 8);
                    $pdf->cell(30, $alt, $ve70_codigo, 1, 0, "C", 1);
                    $pdf->cell(19+$moreWidth, $alt, db_formatar($ve70_data, "d"), 1, 0, "C", 1);
                    $pdf->cell(20, $alt, $ve70_hora, 1, 0, "C", 1);
                    $pdf->cell(25+$moreWidth, $alt, $ve26_descr, 1, 0, "C", 1);
                    $pdf->cell(23+$moreWidth, $alt, $medida_retirada, 1, 0, "C", 1);
                    $pdf->cell(23+$moreWidth, $alt, $medida_devolucao, 1, 0, "C", 1);
                    $pdf->cell(30, $alt, $medida_rodada, 1, 0, "C", 1);
                    if($exibir_cupom){
                        $pdf->cell(18, $alt, $ve71_nota, 1, 0, "C", 1);
                    }
                    $pdf->cell(25+$moreWidth, $alt, $ve70_litros . " L", 1, 0, "C", 1);
                    $pdf->cell(27+$moreWidth, $alt, "R$ " . number_format($ve70_valor, 2, ',', '.'), 1, 0, "C", 1);
                    $pdf->cell(20, $alt, $numemp, 1, 0, "C", 1);
                    $pdf->cell(24, $alt, number_format(($medida_rodada / $ve70_litros), 2, ',', '') . " Km/L", 1, 1, "C", 1);
                    $nTotalCombustivel += $ve70_litros;
                    $nTotalValorAbastecido += $ve70_valor;
                    $nTotalConsumoMedio += ($medida_rodada / $ve70_litros);
                }

                $pdf->setfont('arial', 'b', 10);
                $pdf->cell(180, $alt, "Totalizadores", 1, 0, "L", 0);
                $pdf->cell(30, $alt, "{$nTotalCombustivel} Litros", 1, 0, "C", 0);
                $pdf->cell(30, $alt, "R$ " . number_format($nTotalValorAbastecido, 2, ',', '.'), 1, 0, "C", 0);
                $pdf->cell(20, $alt, "Média:", "LTB", 0, "R", 0);
                $pdf->cell(24, $alt, number_format(($nTotalConsumoMedio / $iContMov), 2, ',', '') . " Km/L", "BRT", 1, "R", 0);
                $pdf->ln();
            }
        }
    }
}

$pdf->Output();
?>
