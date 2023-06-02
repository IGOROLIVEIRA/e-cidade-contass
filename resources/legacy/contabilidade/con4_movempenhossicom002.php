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

$head3 = "Movimentaчуo Empenhos Sicom";

db_inicio_transacao();
$sWhereEmpenho = "";
if ($numemp != "") {
    $sWhereEmpenho = "and si106_nroempenho = {$numemp}";
}
$sSqlGeral = "select nroempenho, dotacao,si106_dtempenho,empenhado, vlranulado,vlrliquidado,vlrliquidadoanulado,vlrpago,vlrpagoanulado,
                       round(coalesce((((vlrliquidado - vlrliquidadoanulado) - (vlrpago - vlrpagoanulado))),0),2) as apagarliquidado,
                       round(coalesce((((empenhado - vlranulado) - (vlrliquidado - vlrliquidadoanulado))),0),2) as apagarnaoliquidado
                  from (select  si106_nroempenho as nroempenho,
                                si106_dtempenho,
                                concat (lpad(si106_codorgao,2,0),'.',si106_codunidadesub,'.',lpad(si106_codfuncao,2,0),'.',lpad(si106_codsubfuncao,3,0),'.',lpad(si106_codprograma,4,0),'.',
                                lpad(si106_idacao,4,0),'.',lpad(si106_naturezadespesa::varchar,6,0),'.',lpad(si106_subelemento,2,0) ) as dotacao,
                                si106_vlbruto as empenhado,
                                round(coalesce((select sum(si110_vlanulacao)  from anl10{$anousu} where si110_mes between {$mesini} and {$mesfim} and anl10{$anousu}.si110_nroempenho = emp10{$anousu}.si106_nroempenho),0),2) as vlranulado,
                                round(coalesce((select sum(si118_vlliquidado) from lqd10{$anousu} where si118_mes between {$mesini} and {$mesfim} and lqd10{$anousu}.si118_nroempenho = emp10{$anousu}.si106_nroempenho and lqd10{$anousu}.si118_dtempenho = emp10{$anousu}.si106_dtempenho),0),2) as vlrliquidado,
                                round(coalesce((select sum(si121_vlanulado)   from alq10{$anousu} where si121_mes between {$mesini} and {$mesfim} and alq10{$anousu}.si121_nroempenho = emp10{$anousu}.si106_nroempenho and alq10{$anousu}.si121_dtempenho = emp10{$anousu}.si106_dtempenho),0),2) as vlrliquidadoanulado,
                                round(coalesce((select sum(si133_valorfonte)  from ops11{$anousu} where si133_mes between {$mesini} and {$mesfim} and ops11{$anousu}.si133_nroempenho = emp10{$anousu}.si106_nroempenho and ops11{$anousu}.si133_dtempenho = emp10{$anousu}.si106_dtempenho),0),2) as vlrpago,
                                round(coalesce((select sum(si137_vlanulacaoop)
                                                  from aop10{$anousu}
                                            inner join ops10{$anousu} on si132_nroop = si137_nroop
                                            inner join ops11{$anousu} on si133_nroop =  si137_nroop
                                                 where si133_nroempenho = emp10{$anousu}.si106_nroempenho and ops11{$anousu}.si133_dtempenho = emp10{$anousu}.si106_dtempenho ),0),2) as vlrpagoanulado
                          from emp10{$anousu}
                    inner join emp11{$anousu} on emp10{$anousu}.si106_nroempenho = emp11{$anousu}.si107_nroempenho and emp10{$anousu}.si106_instit = emp11{$anousu}.si107_instit
                         where emp10{$anousu}.si106_mes between {$mesini} and {$mesfim}
                           {$sWhereEmpenho}
                           and emp10{$anousu}.si106_instit = " . db_getsession('DB_instit') . "
                ) as xx
                order by nroempenho;";

$rsGeral = db_query($sSqlGeral) or die(pg_last_error());

db_fim_transacao();

$aEmpenhos = db_utils::getColectionByRecord($rsGeral);

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca = 1;
$alt = 4;
$nVlEmp = 0;
$nVlAnu = 0;
$nVlLiq = 0;
$nVlLiqAnu = 0;
$nVlPago = 0;
$nPgAnu = 0;
$nVlrLiquiAnulado = 0;
$nVlrNaoLiquiAnulado = 0;
foreach ($aEmpenhos as $oEmpenho) {
    if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
        $pdf->addpage();
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(15, $alt, "Empenho", 1, 0, "C", 1);
        $pdf->cell(57, $alt, "Dotaчуo", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Dt Empenho", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "Vl Empenhado", 1, 0, "C", 1);
        $pdf->cell(18, $alt, "Vl Anulado", 1, 0, "C", 1);
        $pdf->cell(22, $alt, "Vl Liquidado", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Vl Liq Anu", 1, 0, "C", 1);
        $pdf->cell(22, $alt, "Vl Pago", 1, 0, "C", 1);
        $pdf->cell(23, $alt, "Pg Anu", 1, 0, "C", 1);
        $pdf->cell(25, $alt, "A Pagar Liq", 1, 0, "C", 1);
        $pdf->cell(25, $alt, "A Pagar N Liq", 1, 1, "C", 1);
        /*$pdf->cell(25, $alt, "Pg Sicom", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Pg/Anu Sicom", 1, 0, "C", 1);
        $pdf->cell(20, $alt, "Anu. Sicom", 1, 0, "C", 1);*/
        $troca = 0;
    }
    $pdf->setfont('arial', '', 7);
    $pdf->cell(15, $alt, $oEmpenho->nroempenho, 1, 0, "C", 0);
    $pdf->cell(57, $alt, $oEmpenho->dotacao, 1, 0, "C", 0);
    $pdf->cell(20, $alt, implode("/", array_reverse(explode("-", $oEmpenho->si106_dtempenho))), 1, 0, "C", 0);
    $pdf->cell(30, $alt, number_format($oEmpenho->empenhado, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(18, $alt, number_format($oEmpenho->vlranulado, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(22, $alt, number_format($oEmpenho->vlrliquidado, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(20, $alt, number_format($oEmpenho->vlrliquidadoanulado, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(22, $alt, number_format($oEmpenho->vlrpago, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(23, $alt, number_format($oEmpenho->vlrpagoanulado, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(25, $alt, number_format($oEmpenho->apagarliquidado, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(25, $alt, number_format($oEmpenho->apagarnaoliquidado, 2, ",", "."), 1, 1, "R", 0);
    /*$pdf->cell(20, $alt, number_format($oEmpenho->vlrliqanl, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(22, $alt, number_format($oEmpenho->vlrpag, 2, ",", "."), 1, 0, "R", 0);
    $pdf->cell(23, $alt, number_format($oEmpenho->vlrpaganl, 2, ",", "."), 1, 1, "R", 0);*/

    $nVlEmp += $oEmpenho->empenhado;
    $nVlAnu += $oEmpenho->vlranulado;
    $nVlLiq += $oEmpenho->vlrliquidado;
    $nVlLiqAnu += $oEmpenho->vlrliquidadoanulado;
    $nVlPago += $oEmpenho->vlrpago;
    $nPgAnu += $oEmpenho->vlrpagoanulado;
    $nVlrLiquiAnulado += $oEmpenho->apagarliquidado;
    $nVlrNaoLiquiAnulado += $oEmpenho->apagarnaoliquidado;
}
$pdf->setfont('arial', 'b', 8);
$pdf->ln();
$pdf->cell(15, $alt, "Total:", 1, 0, "C", 1);
$pdf->cell(77, $alt, "", 1, 0, "R", 0);
$pdf->cell(30, $alt, number_format($nVlEmp, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(18, $alt, number_format($nVlAnu, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(22, $alt, number_format($nVlLiq, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(20, $alt, number_format($nVlLiqAnu, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(22, $alt, number_format($nVlPago, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(23, $alt, number_format($nPgAnu, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(25, $alt, number_format($nVlrLiquiAnulado, 2, ",", "."), 1, 0, "R", 0);
$pdf->cell(25, $alt, number_format($nVlrNaoLiquiAnulado, 2, ",", "."), 1, 1, "R", 0);
$pdf->output();
?>