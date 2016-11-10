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
include("libs/db_sql.php");

db_postmemory($HTTP_POST_VARS);
$oPeriodo = new Periodo($o116_periodo);
$aDecendios = DBDate::getDecendio($oPeriodo->getMesInicial(),$anousu);
$aDecendios[0][2] = "Depositar at� o dia 20";
$aDecendios[1][2] = "Depositar at� o dia 30";
$aDecendios[2][2] = "Depositar at� o dia 10 do m�s subsequente";

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);
if(count($aInstits) > 1){
  $oInstit = new Instituicao(db_getsession("db_instit"));
} else {
  foreach ($aInstits as $iInstit) {
    $oInstit = new Instituicao($iInstit);
  }
}

/**
 * mPDF
 * @param string $mode              | padr�o: BLANK
 * @param mixed $format             | padr�o: A4
 * @param float $default_font_size  | padr�o: 0
 * @param string $default_font      | padr�o: ''
 * @param float $margin_left        | padr�o: 15
 * @param float $margin_right       | padr�o: 15
 * @param float $margin_top         | padr�o: 16
 * @param float $margin_bottom      | padr�o: 16
 * @param float $margin_header      | padr�o: 9
 * @param float $margin_footer      | padr�o: 9
 *
 * Nenhum dos par�metros � obrigat�rio
 */

$mPDF = new mpdf('', 'A4-L', 0, '', 10, 10, 20, 15, 8, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;padding-bottom:6px;">
    <tr>
      <td>{$oInstit->getDescricao()}</td>
    </tr>
    <tr>
      <th>"DEPOSITOS DECENDIAIS EDUCA��O & SA�DE"</th>
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
      .ritz .waffle .s12 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : center; text-decoration : underline; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : center; text-decoration : underline; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; font-style : italic; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; text-decoration : underline; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s4 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; font-style : italic; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s3 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 9pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .wrapper { width: 32%; margin-left:1%; margin-right:1%; float:left; }
      .ritz .wrapper .waffle { width: 100%; }
    </style>
  
  </head>
  <body>
  
  
  <div class="ritz grid-container" dir="ltr">
    <?php
    foreach($aDecendios as $aPeriodo){
      db_inicio_transacao();

      $sWhereReceita      = "o70_instit in ({$instits})";
      criarWorkReceita($sWhereReceita, $anousu, $aPeriodo[0], $aPeriodo[1]);

    ?>
    <div class="wrapper">
      <table class="waffle" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
          <th id="0C0" style="width:23%" class="column-headers-background">&nbsp;</th>
          <th id="0C1" style="width:37%" class="column-headers-background">&nbsp;</th>
          <th id="0C2" style="width:20%" class="column-headers-background">&nbsp;</th>
          <th id="0C3" style="width:20%" class="column-headers-background">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr style='height:20px;'>
          <td class="s0 bdtop bdleft" colspan="4">DE <?=db_formatar($aPeriodo[0],"d")." A ".db_formatar($aPeriodo[1],"d")?></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s1 bdleft" colspan="3"><?=$aPeriodo[2]?></td>
          <td class="s2">&quot;Cheque&quot;</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s3 bdleft" colspan="2">IMPOSTOS</td>
          <td class="s4">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11120101</td>
          <td class="s7">IPTR</td>
          <td class="s6">
            <?php
            $aDadosIPTR = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '411120101%'");
            $fIPTR = count($aDadosIPTR) > 0 ? $aDadosIPTR[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fIPTR, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11120200</td>
          <td class="s7">IPTU</td>
          <td class="s6">
            <?php
            $aDadosIPTU = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '411120200%'");
            $fIPTU = count($aDadosIPTU) > 0 ? $aDadosIPTU[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fIPTU, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11120430</td>
          <td class="s7">IRRF</td>
          <td class="s6">
            <?php
            $aDadosIRRF = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '41112043%'");
            $fIRRF = count($aDadosIRRF) > 0 ? $aDadosIRRF[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fIRRF, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11120800</td>
          <td class="s7">ITBI</td>
          <td class="s6">
            <?php
            $aDadosITBI = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '411120800%'");
            $fITBI = count($aDadosITBI) > 0 ? $aDadosITBI[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fITBI, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11130500</td>
          <td class="s7">ISSQN</td>
          <td class="s6">
            <?php
            $aDadosISS = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '411130500%'");
            $fISS = count($aDadosISS) > 0 ? $aDadosISS[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fISS, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s5 bdleft" colspan="4">&nbsp;</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s3 bdleft" colspan="2">TRANSF.CONTITUCIONAIS</td>
          <td class="s4">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17210102</td>
          <td class="s7">FPM</td>
          <td class="s6">
            <?php
            $aDadosFPM = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417210102%'");
            $fFPM = count($aDadosFPM) > 0 ? $aDadosFPM[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fFPM, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17210105</td>
          <td class="s7">ITR</td>
          <td class="s6">
            <?php
            $aDadosITR = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417210105%'");
            $fITR = count($aDadosITR) > 0 ? $aDadosITR[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fITR, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17213600</td>
          <td class="s7">ICMS EXP.</td>
          <td class="s6">
            <?php
            $aDadosICMS = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417213600%'");
            $fICMS = count($aDadosICMS) > 0 ? $aDadosICMS[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fICMS, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17220101</td>
          <td class="s7">ICMS EST.</td>
          <td class="s6">
            <?php
            $aDadosPARTICMS = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417220101%'");
            $fPARTICMS = count($aDadosPARTICMS) > 0 ? $aDadosPARTICMS[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fPARTICMS, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17220102</td>
          <td class="s7">IPVA</td>
          <td class="s6">
            <?php
            $aDadosIPVA = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417220102%'");
            $fIPVA = count($aDadosIPVA) > 0 ? $aDadosIPVA[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fIPVA, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17220104</td>
          <td class="s7">IPI</td>
          <td class="s6">
            <?php
            $aDadosIPI = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417220104%'");
            $fIPI = count($aDadosIPI) > 0 ? $aDadosIPI[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fIPI, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s5 bdleft" colspan="4">&nbsp;</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s3 bdleft" colspan="2">OUT.REC.CORRENTES</td>
          <td class="s4">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19110801</td>
          <td class="s7">Multas IPTR</td>
          <td class="s6">
            <?php
            $aDadosMJITR = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '419110801%'");
            $fMJITR = count($aDadosMJITR) > 0 ? $aDadosMJITR[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fMJITR, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19113800</td>
          <td class="s7">Multas IPTU</td>
          <td class="s6">
            <?php
            $aDadosMJIPTU = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '419113800%'");
            $fMJIPTU = count($aDadosMJIPTU) > 0 ? $aDadosMJIPTU[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fMJIPTU, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19113900</td>
          <td class="s7">Multas ITBI</td>
          <td class="s6">
            <?php
            $aDadosMJITBI = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '419113900%'");
            $fMJTIBI = count($aDadosMJITBI) > 0 ? $aDadosMJITBI[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fMJTIBI, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19114000</td>
          <td class="s7">Multas ISSQN</td>
          <td class="s6">
            <?php
            $aDadosMJISS = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '419114000%'");
            $fMJISS = count($aDadosMJISS) > 0 ? $aDadosMJISS[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fMJISS, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19311100</td>
          <td class="s7">D�v.Ativa IPTU</td>
          <td class="s6">
            <?php
            $aDadosRDAIPTU = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '419311100%'");
            $fMJDAIPTU = count($aDadosRDAIPTU) > 0 ? $aDadosRDAIPTU[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fMJDAIPTU, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19311200</td>
          <td class="s7">D�v.Ativa ITBI</td>
          <td class="s6">
            <?php
            $aDadosRDAITBI = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '419311200%'");
            $fMJDAITBI = count($aDadosRDAITBI) > 0 ? $aDadosRDAITBI[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fMJDAITBI, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19311300</td>
          <td class="s7">D�v.Ativa ISSQN</td>
          <td class="s6">
            <?php
            $aDadosRDAISS = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '419311300%'");
            $fMJDAISS = count($aDadosRDAISS) > 0 ? $aDadosRDAISS[0]->saldo_arrecadado_acumulado : 0;
            echo db_formatar($fMJDAISS, "f");
            ?>
          </td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s5 bdleft" colspan="4">&nbsp;</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s8 bdleft"></td>
          <td class="s8"></td>
          <td class="s9">Educ.</td>
          <td class="s10">Sa�de</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">Tributos Mun.</td>
          <td class="s7"></td>
          <td class="s6">
            <?php
            $fTotalTribMunEduc = (array_sum(array($fIPTR,$fIPTU,$fIRRF,$fITBI,$fISS,$fMJITR,$fMJIPTU,$fMJTIBI,$fMJISS,$fMJDAIPTU,$fMJDAITBI,$fMJDAISS)))*0.25;
            echo db_formatar($fTotalTribMunEduc,"f");
            ?>
          </td>
          <td class="s11">
            <?php
            $fTotalTribMunSaude = (array_sum(array($fIPTR,$fIPTU,$fIRRF,$fITBI,$fISS,$fMJITR,$fMJIPTU,$fMJTIBI,$fMJISS,$fMJDAIPTU,$fMJDAITBI,$fMJDAISS)))*0.15;
            echo db_formatar($fTotalTribMunSaude,"f");
            ?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">FPM</td>
          <td class="s7"></td>
          <td class="s6">
            <?php
            $fTotalFPMEduc = $fFPM*0.05;
            echo db_formatar($fTotalFPMEduc, "f");
            ?>
          </td>
          <td class="s11">
            <?php
            $fTotalFPMSaude = $fFPM*0.15;
            echo db_formatar($fTotalFPMSaude, "f");
            ?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">ITR</td>
          <td class="s7"></td>
          <td class="s6">
            <?php
            $fTotalITREduc = $fITR*0.05;
            echo db_formatar($fTotalITREduc,"f");
            ?>
          </td>
          <td class="s11">
            <?php
            $fTotalITRSaude = $fITR*0.15;
            echo db_formatar($fTotalITRSaude,"f");
            ?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">ICMS Export</td>
          <td class="s7 softmerge">
            <div class="softmerge-inner" style="width: 131px; left: -1px;"></div>
          </td>
          <td class="s6">
            <?php
            $fTotalICMSEduc = $fICMS*0.05;
            echo db_formatar($fTotalICMSEduc,"f");
            ?>
          </td>
          <td class="s11">
            <?php
            $fTotalICMSSaude = $fICMS*0.15;
            echo db_formatar($fTotalICMSSaude,"f");
            ?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">ICMS Est. &amp; IPI</td>
          <td class="s7"></td>
          <td class="s6">
            <?php
            $fTotalICMSIPIEduc = ($fPARTICMS + $fIPI)*0.05;
            echo db_formatar($fTotalICMSIPIEduc,"f");
            ?>
          </td>
          <td class="s11">
            <?php
            $fTotalICMSIPISaude = ($fPARTICMS + $fIPI)*0.15;
            echo db_formatar($fTotalICMSIPISaude,"f");
            ?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">IPVA</td>
          <td class="s7"></td>
          <td class="s12">
            <?php
            $fTotalIPVAEduc = $fIPVA*0.05;
            echo db_formatar($fTotalIPVAEduc,"f");
            ?>
          </td>
          <td class="s13">
            <?php
            $fTotalIPVASaude = $fIPVA*0.05;
            echo db_formatar($fTotalIPVASaude,"f");
            ?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s14 bdleft"></td>
          <td class="s14"></td>
          <td class="s12"><?=db_formatar(array_sum(array($fTotalFPMEduc,$fTotalITREduc,$fTotalICMSEduc,$fTotalICMSIPIEduc,$fTotalIPVAEduc)),"f") ?></td>
          <td class="s13"><?=db_formatar(array_sum(array($$fTotalFPMSaude,$fTotalITRSaude,$fTotalICMSSaude,$fTotalICMSIPISaude,$fTotalIPVASaude)),"f")?></td>
        </tr>
        </tbody>
      </table>
    </div>
    <?php
      db_query("drop table if exists work_receita");
      db_fim_transacao();
    }
    ?>
  </div>
  
  </body>
  </html>

<?php

$html = ob_get_contents();
ob_end_clean();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
//echo $html;

?>