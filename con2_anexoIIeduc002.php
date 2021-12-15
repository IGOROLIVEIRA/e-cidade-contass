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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("vendor/mpdf/mpdf/mpdf.php");
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
require_once("classes/db_empresto_classe.php");
include("libs/db_sql.php");
db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);
if(count($aInstits) > 1){
  $oInstit = new Instituicao();
  $oInstit = $oInstit->getDadosPrefeitura();
} else {
  foreach ($aInstits as $iInstit) {
    $oInstit = new Instituicao($iInstit);
  }
}
db_inicio_transacao();

$sWhereDespesa      = " o58_instit in({$instits})";
criaWorkDotacao($sWhereDespesa,array($anousu), $dtini, $dtfim);

$sWhereReceita      = "o70_instit in ({$instits})";
criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);

$nRPInscritosExercicio = 0;

function getSaldoPlanoContaFonte($sFonte, $dtIni, $dtFim, $aInstits){
    db_inicio_transacao();

    $where = " c61_instit in ({$aInstits})" ;
    $where .= " and c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ($sFonte) ) ";
    $result = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $dtIni, $dtFim, false, $where, '111');
    $nTotalFinal = 0;
    for($x = 0; $x < pg_numrows($result); $x++){
        $oPlanoConta = db_utils::fieldsMemory($result, $x);
        if( ( $oPlanoConta->movimento == "S" )
            && ( ( $oPlanoConta->saldo_anterior + $oPlanoConta->saldo_anterior_debito + $oPlanoConta->saldo_anterior_credito) == 0 ) ) {
            continue;
        }
        if(substr($oPlanoConta->estrutural,1,14) == '00000000000000'){
            if($oPlanoConta->saldo_final == "C"){
                $nTotalFinal -= $oPlanoConta->saldo_final;
            }else {
                $nTotalFinal += $oPlanoConta->saldo_final;
            }
        }
    }
    db_query("drop table if exists work_pl");
    db_fim_transacao();
    return $nTotalFinal;
}

function getRestosSemDisponilibidade($sFontes, $dtIni, $dtFim, $aInstits) {
    db_inicio_transacao();

    $clEmpResto = new cl_empresto();
    $sSqlOrder = "";
    $sCampos = " o15_codtri, sum(vlrpag) as pagorpp, sum(vlrpagnproc) as pagorpnp ";
    $sSqlWhere = " o15_codtri in ($sFontes) group by 1 ";
    $aEmpRestos = $clEmpResto->getRestosPagarFontePeriodo(db_getsession("DB_anousu"), $dtIni, $dtFim, $aInstits, $sCampos, $sSqlWhere, $sSqlOrder);

    $nValorRpPago = 0;
    foreach($aEmpRestos as $oEmpResto){
        $nValorRpPago += $oEmpResto->pagorpp + $oEmpResto->pagorpnp;
    }

    $dtIni = db_getsession("DB_anousu")."-01-01";
    $where = " c61_instit in ({$aInstits})" ;
    $where .= " and c61_codigo in ( select o15_codigo from orctiporec where o15_codtri in ($sFontes) ) ";
    $result = db_planocontassaldo_matriz(db_getsession("DB_anousu"), $dtIni, $dtFim, false, $where, '111');

    $nTotalAnterior = 0;
    for($x = 0; $x < pg_numrows($result); $x++){
        $oPlanoConta = db_utils::fieldsMemory($result, $x);
        if( ( $oPlanoConta->movimento == "S" )
            && ( ( $oPlanoConta->saldo_anterior + $oPlanoConta->saldo_anterior_debito + $oPlanoConta->saldo_anterior_credito) == 0 ) ) {
            continue;
        }
        if(substr($oPlanoConta->estrutural,1,14) == '00000000000000'){
            if($oPlanoConta->sinal_anterior == "C"){
                $nTotalAnterior -= $oPlanoConta->saldo_anterior;
            }else {
                $nTotalAnterior += $oPlanoConta->saldo_anterior;
            }
        }
    }

    $iSaldoRestosAPagarSemDisponibilidade = 0;
    if($nValorRpPago > $nTotalAnterior){
        $iSaldoRestosAPagarSemDisponibilidade = $nValorRpPago - $nTotalAnterior ;
    }
    db_query("drop table if exists work_pl");
    db_fim_transacao();
    return  $iSaldoRestosAPagarSemDisponibilidade;
}

/**
 * mPDF
 * @param string $mode              | padrão: BLANK
 * @param mixed $format             | padrão: A4
 * @param float $default_font_size  | padrão: 0
 * @param string $default_font      | padrão: ''
 * @param float $margin_left        | padrão: 15
 * @param float $margin_right       | padrão: 15
 * @param float $margin_top         | padrão: 16
 * @param float $margin_bottom      | padrão: 16
 * @param float $margin_header      | padrão: 9
 * @param float $margin_footer      | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */

$mPDF = new mpdf('', '', 0, '', 15, 15, 20, 15, 5, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>ANEXO II</th>
    </tr>
    <tr>
      <td style="text-align:right;font-size:10px;font-style:oblique;">Período: De {$DBtxt21} a {$DBtxt22}</td>
    </tr>
  </table>
</header>
HEADER;

$footer = <<<FOOTER
<div style='border-top:1px solid #000;width:100%;text-align:right;font-family:sans-serif;font-size:10px;height:10px;'>
  {PAGENO}
</div>
FOOTER;


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

?>

  <html>
  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
      .ritz .waffle a { color : inherit; }
      .ritz .waffle .s3 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s4 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; overflow : hidden; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : normal; word-wrap : break-word; }
      .ritz .waffle .s10 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s18 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s15 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-style : italic; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s19 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Helvetica Neue',Arial; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s16 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Helvetica Neue',Arial; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s17 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID transparent; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 14pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
    </style>
  </head>
  <body>

  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
        <th id="0C0" style="width:72px" class="column-headers-background">&nbsp;</th>
        <th id="0C1" style="width:92px" class="column-headers-background">&nbsp;</th>
        <th id="0C2" style="width:87px" class="column-headers-background">&nbsp;</th>
        <th id="0C3" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C4" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C5" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C6" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C7" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C8" style="width:100px" class="column-headers-background">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <tr style='height:20px;'>
        <td class="s3 bdleft" colspan="9">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s4 bdleft" colspan="9">DEMONSTRATIVO DOS GASTOS COM A MANUTENÇÃO E DESENVOLVIMENTO DO<br>ENSINO</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s6 bdleft" colspan="9">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s7 bdleft">Função</td>
        <td class="s7">SubFunções</td>
        <td class="s7">Programas</td>
        <td class="s8" colspan="5">Especificação</td>
        <?php
            if(db_getsession("DB_anousu") >= 2021){
                echo  "<td class='s9'>Valor Pago</td>";
            }else{
                echo  "<td class='s9'>Despesa (1)</td>";
            }
        ?>
      </tr>
      <tr style='height:20px;'>
        <td class="s6 bdleft"></td>
        <td class="s6"></td>
        <td class="s6"></td>
        <td class="s10" colspan="5"></td>
        <td class="s11">R$</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">12</td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s12" colspan="5">EDUCAÇÃO</td>
        <td class="s3"></td>
      </tr>
      <?php

      /**
       * @todo loop de cada subfuncao
       *
       */
      $fSubTotal = 0;
      $aSubFuncoes = array(122,272,271,361,365,366,367,843);
      $sFuncao     = "12";
      $aFonte      = array("'101'");
      foreach ($aSubFuncoes as $iSubFuncao) {
        $sDescrSubfunao = db_utils::fieldsMemory(db_query("select o53_descr from orcsubfuncao where o53_codtri = '{$iSubFuncao}'"), 0)->o53_descr;

        $aDespesasProgramas = getSaldoDespesa(null, "o58_programa,o58_anousu, coalesce(sum(pago),0) as pago, coalesce(sum(atual_a_pagar+atual_a_pagar_liquidado),0) as apagar", null, "o58_funcao = {$sFuncao} and o58_subfuncao in ({$iSubFuncao}) and o15_codtri in (".implode(",",$aFonte).") and o58_instit in ($instits) group by 1,2");
        if (count($aDespesasProgramas) > 0) {

          ?>
          <tr style='height:20px;'>
            <td class="s3 bdleft"></td>
            <td class="s9"><?= db_formatar($iSubFuncao, 'subfuncao') ?></td>
            <td class="s3"></td>
            <td class="s12" colspan="5"><?= $sDescrSubfunao ?></td>
            <td class="s3"></td>
          </tr>
          <?php
          /**
           * @todo para cada subfuncao lista os programas
           */
          foreach ($aDespesasProgramas as $oDespesaPrograma) {
            $oPrograma = new Programa($oDespesaPrograma->o58_programa, $oDespesaPrograma->o58_anousu);
            $fSubTotal += $oDespesaPrograma->pago;
            if($dtfim == db_getsession("DB_anousu")."-12-31" ){
                $nRPInscritosExercicio += $oDespesaPrograma->apagar;
            }
            ?>
            <tr style='height:20px;'>
              <td class="s3 bdleft"></td>
              <td class="s3"></td>
              <td class="s9"><?php echo db_formatar($oPrograma->getCodigoPrograma(), "programa"); ?></td>
              <td class="s12" colspan="5"><?= $oPrograma->getDescricao() ?></td>
              <td class="s13"><?= db_formatar($oDespesaPrograma->pago, "f") ?></td>
            </tr>
          <?php }
          ?>
          <tr style='height:20px;'>
            <td class="s3 bdleft">&nbsp;</td>
            <td class="s3"></td>
            <td class="s3"></td>
            <td class="s3" colspan="5"></td>
            <td class="s3"></td>
          </tr>
          <?php
        }
      }
      ?>
      <tr style='height:20px;'>
        <?php
            if(db_getsession("DB_anousu") >= 2021){
                echo  "<td class='s15 bdleft' colspan='8'>VALOR PAGO (A)</td>";
            }else{
                echo  "<td class='s15 bdleft' colspan='8'>SUBTOTAL</td>";
            }
        ?>

        <td class="s15"><?=db_formatar($fSubTotal,"f")?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s16 bdleft" colspan="8">Contribuição ao FUNDEB - art. 1º, Lei Federal n. 11 .494/07 (2)</td>
        <td class="s15">
          <?php
          $aDadoDeducao = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '495%'");
          echo db_formatar(abs($aDadoDeducao[0]->saldo_arrecadado_acumulado),"f");
          ?>
        </td>
      </tr>
      <?php
            if(db_getsession("DB_anousu") >= 2021){
                if($dtfim < db_getsession("DB_anousu")."-12-31" ){
                    echo "<tr style='height:20px;'>";
                    echo "    <td class='s16 bdleft' colspan='8'>Restos a Pagar Inscritos No Exercício (B)</td>";
                    echo "    <td class='s15'></td>";
                    echo "</tr>";
                }else{
                    echo "<tr style='height:20px;'>";
                    echo "    <td class='s16 bdleft' colspan='8'>Restos a Pagar Inscritos No Exercício (B)</td>";
                    echo "    <td class='s15'>"; echo db_formatar($nRPInscritosExercicio, "f");echo "</td>";
                    echo "</tr>";
                }
            }
            if(db_getsession("DB_anousu") < 2021){
                echo "<tr style='height:20px;'>";
                echo "    <td class='s16 bdleft' colspan='8'>Restos a Pagar Não Processados de Exercícios Anteriores</td>";
                echo "    <td class='s15'></td>";
                echo "</tr>";
                echo  "<td class='s15 bdleft' colspan='8'>VALOR PAGO (A)</td>";
                echo  "<tr style='height:20px;'>";
                echo  "<td class='s16 bdleft' colspan='8'>Processados no Exercício Atual (3)</td>";
                echo  "<td class='s15'>";
                $fSaldoRP = getSaldoRP($instits,$dtini,$dtfim,$sFuncao,$aSubFuncoes,$aFonte);
                echo db_formatar($fSaldoRP,"f");
                echo  "</td>";
                echo  "</tr>";
            }
      ?>

      <tr style='height:20px;'>
        <?php
            $nSubTotalC = $fSubTotal+abs($aDadoDeducao[0]->saldo_arrecadado_acumulado)+$nRPInscritosExercicio;
            if(db_getsession("DB_anousu") >= 2021){
                echo  "<td class='s17 bdleft' colspan='8'>SUBTOTAL (C = A + FUNDEB + B)</td>";
                echo "<td class='s18'>";
                echo db_formatar($nSubTotalC,"f");
                echo "</td>";
            }else{
                echo  "<td class='s17 bdleft' colspan='8'>TOTAL</td>";
                echo "<td class='s18'>";
                echo db_formatar($nSubTotalC,"f");
                echo "</td>";
            }
        ?>
      </tr>

        <?php
            if(db_getsession("DB_anousu") >= 2021){
                $nSaldoFonteAno = getSaldoPlanoContaFonte("'101'", $dtini, $dtfim, $instits);
                $nRPSEMDisponibilidade = $nRPInscritosExercicio - $nSaldoFonteAno;
                if($nRPSEMDisponibilidade < 0){
                    $nRPSEMDisponibilidade = 0;
                }
                if($dtfim < db_getsession("DB_anousu")."-12-31" ){
                    $nRPSEMDisponibilidade = 0;
                }
                echo "<tr style='height:20px;'>";
                echo  "<td class='s16 bdleft' colspan='8'>RESTO A PAGAR (PROCESSADOS E NÃO PROCESSADOS) INSCRITOS SEM DISPONIBILIDADE DE CAIXA (D)</td>";
                echo "<td class='s15'>";
                echo db_formatar($nRPSEMDisponibilidade,"f");
                echo "</td>";
                echo "</tr>";

                $nRPAnteriorSEMDisponibilidade = getRestosSemDisponilibidade("'101'", $dtini, $dtfim, $instits);
                echo "<tr style='height:20px;'>";
                echo  "<td class='s16 bdleft' colspan='8'>RESTOS A PAGAR DE EXERCÍCIOS ANTERIORES SEM DISPONIBILIDADE DE CAIXA PAGOS NO EXERCÍCIO ATUAL (CONSULTA 932.736)(E)</td>";
                echo "<td class='s15'>";
                echo db_formatar($nRPAnteriorSEMDisponibilidade,"f");
                echo "</td>";
                echo "</tr>";

                $nTotalAPlicado = $nSubTotalC - ($nRPSEMDisponibilidade + $nRPAnteriorSEMDisponibilidade);
                echo "<tr style='height:20px;'>";
                echo  "<td class='s17 bdleft' colspan='8'>TOTAL APLICADO (F = C - D + E)</td>";
                echo "<td class='s18'>";
                echo db_formatar($nTotalAPlicado,"f");
                echo "</td>";
                echo "</tr>";
            }
        ?>

      <tr style='height:20px;'>
        <td class="s19 bdleft" colspan="9">(1) Art. 70 da Lei Federal n. 9394/96.</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s19 bdleft" colspan="9">(2) O valor a ser demonstrado corresponderá à contribuição ao FUNDEB, contabilizado</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s19 bdleft" colspan="9">como conta retificadora da receita.</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s16 bdleft" colspan="9">(3) Parágrafo Único do Artigo 6º da Instrução Normativa Nº 13/2008</td>
      </tr>
      </tbody>
    </table>
  </div>


  </body>
  </html>

<?php

$html = ob_get_contents();
ob_end_clean();
db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");
db_fim_transacao();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();



?>
