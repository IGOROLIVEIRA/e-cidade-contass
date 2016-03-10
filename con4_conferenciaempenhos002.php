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
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("libs/db_sessoes.php");
include("dbforms/db_funcoes.php");
include("libs/db_utils.php");

db_postmemory($_GET);
db_postmemory($HTTP_POST_VARS);

$head3 = "Conferência de Empenhos";

db_inicio_transacao();

$sSqlEmpenhosSicom = "create temp table empsicom on commit drop as  
                        select nroempenho, empenhado as empenhadosicom, vlranulado as vlranuladosicom,
                               vlrliquidado  as vlrliquidadosicom,vlrliquidadoanulado as vlrliquidadoanuladosicom, vlrpago as vlrpagosicom,vlrpagoanulado as vlrpagoanuladosicom
                          from (select  si106_nroempenho as nroempenho,
                                        si106_vlbruto as empenhado,
                                        round(coalesce((select sum(si110_vlanulacao)  from anl10{$anousu} 
                                                         where si110_instit = " . db_getsession('DB_instit') . " and si110_mes between {$mesini} and {$mesfim}
                                                           and anl10{$anousu}.si110_nroempenho = emp10{$anousu}.si106_nroempenho),0),2) as vlranulado,
                                        round(coalesce((select sum(si118_vlliquidado) from lqd10{$anousu}
                                                         where si118_instit = " . db_getsession('DB_instit') . " and si118_mes between {$mesini} and {$mesfim}
                                                           and lqd10{$anousu}.si118_dtempenho  = emp10{$anousu}.si106_dtempenho
                                                           and lqd10{$anousu}.si118_nroempenho = emp10{$anousu}.si106_nroempenho),0),2) as vlrliquidado,
                                        round(coalesce((select sum(si121_vlanulado)   from alq10{$anousu}
                                                         where si121_instit = " . db_getsession('DB_instit') . " and si121_mes between {$mesini} and {$mesfim}
                                                         and alq10{$anousu}.si121_dtempenho  = emp10{$anousu}.si106_dtempenho
                                                         and alq10{$anousu}.si121_nroempenho = emp10{$anousu}.si106_nroempenho),0),2) as vlrliquidadoanulado,
                                        round(coalesce((select sum(si133_valorfonte)  from ops11{$anousu}
                                                         where si133_instit = " . db_getsession('DB_instit') . " and si133_mes between {$mesini} and {$mesfim}
                                                           and ops11{$anousu}.si133_dtempenho  = emp10{$anousu}.si106_dtempenho
                                                           and ops11{$anousu}.si133_nroempenho = emp10{$anousu}.si106_nroempenho),0),2) as vlrpago,
                                        round(coalesce((select sum(si137_vlanulacaoop)
                                                          from aop10{$anousu}
                                                    inner join ops10{$anousu} on si132_nroop = si137_nroop
                                                    inner join ops11{$anousu} on si133_nroop =  si137_nroop
                                                         where si137_instit = " . db_getsession('DB_instit') . " and si137_mes between {$mesini} and {$mesfim}
                                                           and ops11{$anousu}.si133_dtempenho  = emp10{$anousu}.si106_dtempenho
                                                           and ops11{$anousu}.si133_nroempenho = emp10{$anousu}.si106_nroempenho),0),2) as vlrpagoanulado
                                  from emp10{$anousu}
                            inner join emp11{$anousu} on emp10{$anousu}.si106_nroempenho = emp11{$anousu}.si107_nroempenho
                                 where emp10{$anousu}.si106_instit = " . db_getsession('DB_instit') . "
                                   and emp11{$anousu}.si107_instit = " . db_getsession('DB_instit') . "
                                   and emp10{$anousu}.si106_mes between {$mesini} and {$mesfim}
                                   and emp11{$anousu}.si107_mes between {$mesini} and {$mesfim}
                        ) as xx
                        order by nroempenho";
$rsSqlEmpenhosSicom = db_query($sSqlEmpenhosSicom) or die(pg_last_error());

$sSqlEmpenhosEcidade = "create temp table empecidade on commit drop as
                             select  e60_codemp as nroempenho,
                                     round(coalesce(sum(case when c71_coddoc IN (select c53_coddoc from conhistdoc where c53_tipo = 10) then round(c70_valor,2) else 0 end),0),2) as vlremp,
                                     round(coalesce(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 11) then round(c70_valor,2) else 0 end),0),2) as vlranu,
                                     round(coalesce(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 20) then round(c70_valor,2) else 0 end),0),2) as vlrliq,
                                     round(coalesce(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 21) then round(c70_valor,2) else 0 end),0),2) as vlrliqanl,
                                     round(coalesce(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 30) then round(c70_valor,2) else 0 end),0),2) as vlrpag,
                                     round(coalesce(sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 31) then round(c70_valor,2) else 0 end),0),2) as vlrpaganl
                               from empempenho
                         inner join conlancamemp on e60_numemp = c75_numemp
                         inner join conlancamdoc on c75_codlan = c71_codlan
                         inner join conlancam    on c75_codlan = c70_codlan
                              where e60_instit = " . db_getsession('DB_instit') . "
                                and e60_anousu = {$anousu}
                                and DATE_PART('YEAR',c70_data) = {$anousu}
                                and DATE_PART('MONTH',c70_data) between '{$mesini}' and '{$mesfim}'
                           group by e60_codemp
                           order by e60_codemp::integer";
$rsSqlEmpenhosEcidade = db_query($sSqlEmpenhosEcidade) or die(pg_last_error());


$sSqlGeral = "SELECT empsicom.nroempenho,
                       empenhadosicom,
                       vlranuladosicom AS vlranlsicom,
                       vlrliquidadosicom AS vlrlqdsicom,
                       vlrliquidadoanuladosicom AS vlrlqdanuladosicom,
                       vlrpagosicom,
                       vlrpagoanuladosicom AS vlrpagoanlsicom,
                       vlremp,
                       vlranu,
                       vlrliq,
                       vlrliqanl,
                       vlrpag,
                       vlrpaganl
                FROM empsicom
                INNER JOIN empecidade ON empsicom.nroempenho::integer = empecidade.nroempenho::integer
                WHERE empenhadosicom <> vlremp
                  OR vlranuladosicom <> vlranu
                  OR (vlrliquidadosicom - vlrliquidadoanuladosicom) <> (vlrliq - vlrliqanl)
                  OR (vlrpagosicom - vlrpagoanuladosicom) <> (vlrpag - vlrpaganl)
                ORDER BY nroempenho";
//echo $sSqlGeral;
$rsGeral = db_query($sSqlGeral) or die(pg_last_error());

db_fim_transacao();

$aEmpenhos = db_utils::getColectionByRecord($rsGeral);

$pdf = new PDF('Landscape','mm','A4');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca = 1;
$alt = 4;
$nEmpSicom = 0;
$nAnuSicom = 0;
$nLiqSicom = 0;
$nLiqAnuSicom = 0;
$nPgSicom = 0;
$nPgAnuSicom = 0;
$nVlEmp = 0;
$nVlAnu = 0;
$nVlLiq = 0;
$nVlLiqAnu = 0;
$nVlPago = 0;
$nPgAnu = 0;
foreach ($aEmpenhos as $oEmpenho) {
    if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
        $pdf->addpage();
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(15, $alt, "Empenho", 1, 0, "C", 1);
        $pdf->cell(25, $alt, "VlEmp Sicom", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Anu. Sicom", 1, 0, "C", 1);
        $pdf->cell(25, $alt, "Liquidado Sicom", 1, 0, "C", 1);
        $pdf->cell(25, $alt, "Liq/Anu Sicom", 1, 0, "C", 1);
        $pdf->cell(25, $alt, "Pg Sicom", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Pg/Anu Sicom", 1, 0, "C", 1);
        $pdf->cell(21, $alt, "Vl Empenhado", 1, 0, "C", 1);
        $pdf->cell(18, $alt, "Vl Anulado", 1, 0, "C", 1);
        $pdf->cell(22, $alt, "Vl Liquidado", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Vl Liq Anu", 1, 0, "C", 1);
        $pdf->cell(22, $alt, "Vl Pago", 1, 0, "C", 1);
        $pdf->cell(23, $alt, "Pg Anu", 1, 1, "C", 1);
        $troca = 0;
    }
    $pdf->setfont('arial', '', 7);
    $pdf->cell(15, $alt, $oEmpenho->nroempenho, 1, 0, "C", 0);
    $pdf->cell(25, $alt, number_format($oEmpenho->empenhadosicom, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(20, $alt, number_format($oEmpenho->vlranlsicom, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(25, $alt, number_format($oEmpenho->vlrlqdsicom, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(25, $alt, number_format($oEmpenho->vlrlqdanuladosicom, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(25, $alt, number_format($oEmpenho->vlrpagosicom, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(20, $alt, number_format($oEmpenho->vlrpagoanlsicom, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(21, $alt, number_format($oEmpenho->vlremp, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(18, $alt, number_format($oEmpenho->vlranu, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(22, $alt, number_format($oEmpenho->vlrliq, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(20, $alt, number_format($oEmpenho->vlrliqanl, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(22, $alt, number_format($oEmpenho->vlrpag, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(23, $alt, number_format($oEmpenho->vlrpaganl, 2, ",", "."), 1, 1, "R", 0);

    $nEmpSicom += $oEmpenho->empenhadosicom;
    $nAnuSicom += $oEmpenho->vlranlsicom;
    $nLiqSicom += $oEmpenho->vlrlqdsicom;
    $nLiqAnuSicom += $oEmpenho->vlrlqdanuladosicom;
    $nPgSicom += $oEmpenho->vlrpagosicom;
    $nPgAnuSicom += $oEmpenho->vlrpagoanlsicom;
    $nVlEmp += $oEmpenho->vlremp;
    $nVlAnu += $oEmpenho->vlranu;
    $nVlLiq += $oEmpenho->vlrliq;
    $nVlLiqAnu += $oEmpenho->vlrliqanl;
    $nVlPago += $oEmpenho->vlrpag;
    $nPgAnu += $oEmpenho->vlrpaganl;

}
$pdf->setfont('arial', 'b', 8);
$pdf->ln();
$pdf->cell(15, $alt, "Total:", 1, 0, "C", 1);
$pdf->cell(25, $alt, number_format($nEmpSicom, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(20, $alt, number_format($nAnuSicom, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(25, $alt, number_format($nLiqSicom, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(25, $alt, number_format($nLiqAnuSicom, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(25, $alt, number_format($nPgSicom, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(20, $alt, number_format($nPgAnuSicom, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(21, $alt, number_format($nVlEmp, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(18, $alt, number_format($nVlAnu, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(22, $alt, number_format($nVlLiq, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(20, $alt, number_format($nVlLiqAnu, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(22, $alt, number_format($nVlPago, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(23, $alt, number_format($nPgAnu, 2, ",", "."), 1, 1, "R", 0);
$pdf->output();
?>