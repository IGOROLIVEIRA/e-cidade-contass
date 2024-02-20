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
require_once("dbforms/db_funcoes.php");
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
use \Mpdf\Mpdf;
use \Mpdf\MpdfException;

db_postmemory($HTTP_POST_VARS);
$anousu = $anousu-1;
$dtini = "{$anousu}-01-01";
$dtfim = "{$anousu}-12-31";

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

$sWhereReceita      = "o70_instit in ({$instits})";
criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);

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

try {
    $mPDF = new Mpdf([
        'mode' => '',
        'format' => 'A4',
        'orientation' => 'L',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 20,
        'margin_bottom' => 15,
        'margin_header' => 5,
        'margin_footer' => 11,
    ]);

$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>REPASSE CÂMARA</th>
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
      .ritz .waffle .s14 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s3 { background-color : #f2f2f2; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s18 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; text-decoration : underline; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s22 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 14pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s21 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID transparent; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 14pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #d8d8d8; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #d8d8d8; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #d8d8d8; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s15 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s19 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID transparent; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s20 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s4 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID transparent; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #d8d8d8; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s16 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s17 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
    </style>
  </head>
  <body>

  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
        <th id="0C0" style="width:149px" class="column-headers-background">&nbsp;</th>
        <th id="0C1" style="width:439px" class="column-headers-background">&nbsp;</th>
        <th id="0C2" style="width:130px" class="column-headers-background">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <tr style='height:20px;'>
        <td class="s0">&nbsp;</td>
        <td class="s0"></td>
        <td class="s0"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1" colspan="3">Arrecadação   Municipal   Conforme  Art. 29A da Constituiçao Federal</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s2">Exercício : <?=$anousu?></td>
        <td class="s3 bdtop">Município : <?= $oInstit->getMunicipio()?></td>
        <td class="s0"></td>
      </tr>
      <tr style='height:20px;'>
        <td style="border-right:0;" class="s4" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">1- Receita Tributária + Transferências</td>
        <td class="s6">(R$)</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s7 bdleft" colspan="3">A -  Tributária:</td>
      </tr>

        <?php
            $aGrupoReceita = array(
                        array('Imposto sobre a Propriedade Territorial Rural - ITR', '41112011%'),
                        array('Imposto sobre a Renda - Retido na Fonte - Trabalho', '41113031%'),
                        array('Imposto sobre a Renda - Retido na Fonte - Outros Rendimentos', '41113034%'),
                        array('Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU', '41118011%'),
                        array('Imposto sobre Transmissão "Inter Vivos" de Bens Imóveis e de Direitos Reais s/ Imóveis - ITBI', '41118014%'),
                        array('Imposto sobre Serviços de Qualquer Natureza - ISS', '41118023%'),
                        array('Taxas', '4112%'),
            );

            if ($anousu >= 2022) {
                $aGrupoReceita = array(
                    array('Imposto sobre a Propriedade Territorial Rural - ITR',
                        '4111201%'),
                    array('Imposto sobre a Renda - Retido na Fonte - Trabalho',
                        '411130311%\'
                        OR o57_fonte like \'411130312%\'
                        OR o57_fonte like \'411130313%\'
                        OR o57_fonte like \'411130314%'),
                    array('Imposto sobre a Renda - Retido na Fonte - Outros Rendimentos',
                        '411130341%'),
                    array('Imposto sobre a Propriedade Predial e Territorial Urbana - IPTU', '4111250%'),
                    array('Imposto sobre Transmissão "Inter Vivos" de Bens Imóveis e de Direitos Reais s/ Imóveis - ITBI', '4111253%'),
                    array('Imposto sobre Serviços de Qualquer Natureza - ISS', '4111451%'),
                    array('Taxas', '4112%'),
                );
            }
      $aPrefixosDeducoes = array('491','492','493','496','498','499');

      $fSubTotalImpostos = 0.0;
      foreach($aGrupoReceita as $iK => $aGrupo){

        $aDadosReceita = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte like '$aGrupo[1]'");
        $dDadosReceita = 0.0;
        $sDeducao = '';
        foreach($aDadosReceita as $oReceita) {

          $dTotalDeducoes = 0.0;
          // Busca deduções
          foreach($aPrefixosDeducoes as $sPrefixo){
            $sDeducao = '';
            $sDeducao = $sPrefixo.substr($oReceita->o57_fonte,1,strlen($oReceita->o57_fonte)-3);

            $aDadosDeducao = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte = '$sDeducao'");

            foreach ($aDadosDeducao as $oDeducao){
              $dTotalDeducoes += (double)$oDeducao->saldo_arrecadado_acumulado >= 0 ? (double)$oDeducao->saldo_arrecadado_acumulado : (-1 * (double)$oDeducao->saldo_arrecadado_acumulado);
            }
          }

          $dDadosReceita += (double)$oReceita->saldo_arrecadado_acumulado - $dTotalDeducoes;

        }
        $fSubTotalImpostos += $dDadosReceita;
        ?>

      <tr style='height:20px;'>
        <td class="s9 softmerge" colspan="2" style="border-left: 1px solid #000;">
          <div class="softmerge-inner"><?=$aGrupo[0]?></div>
        </td>
        <td class="s10" colspan="1">
          <?=db_formatar($dDadosReceita,"f")?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>

      <?php } ?>

<!--      Subtotal    -->
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16"><?=db_formatar($fSubTotalImpostos,"f"); ?></td>
      </tr>


<!--      TRANFERÊNCIAS     -->
      <tr style='height:20px;'>
        <td class="s7 bdleft" colspan="3">B -  Transferências:</td>
      </tr>
      <?php
      $aGrupoTransferencias = array(
        array('Cota-Parte do FPM - Cota Mensal', '41718012%'),
        array('Cota-Parte do FPM - 1% dezembro', '41718013%'),
        array('Cota-Parte do FPM - 1% julho', '41718014%'),
        array('Cota-Parte do ITR', '41718015%'),
        array('Transferência Financeira do ICMS - Desoneração - LC 87/96', '41718061%'),
        array('Cota-Parte do ICMS', '41728011%'),
        array('Cota-Parte do IPVA', '41728012%'),
        array('Cota-Parte do IPI - Municípios', '41728013%'),
        array('Cota-Parte da CIDE', '41728014%'),
      );

      if ($anousu >= 2022) {
        $aGrupoTransferencias = array(
            array('Cota-Parte do FPM - Cota Mensal', '417115111%'),
            array('Cota-Parte do FPM - 1% dezembro', '417115121%'),
            array('Cota-Parte do FPM - 1% julho', '417115131%'),
            array('Cota-Parte do ITR', '4171152%'),
            array('Transferência Financeira do ICMS - Desoneração - LC 87/96', '4171951%'),
            array('Cota-Parte do ICMS', '4172150%'),
            array('Cota-Parte do IPVA', '4172151%'),
            array('Cota-Parte do IPI - Municípios', '4172152%'),
            array('Cota-Parte da CIDE', '4172153%'),
          );
      }

      $fSubTotalTransferencias = 0.0;
      foreach($aGrupoTransferencias as $iK => $aGrupo){

        $aDadosReceita = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte like '$aGrupo[1]'");
        $dDadosReceita = 0.0;
        foreach($aDadosReceita as $oReceita) {
          $dDadosReceita += (double)$oReceita->saldo_arrecadado_acumulado;
        }
        $fSubTotalTransferencias += $dDadosReceita;
        ?>

        <tr style='height:20px;'>
          <td class="s9 softmerge" colspan="2" style="border-left: 1px solid #000;">
            <div class="softmerge-inner"><?=$aGrupo[0]?></div>
          </td>
          <td class="s10" colspan="1">
            <?=db_formatar($dDadosReceita,"f")?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s8 bdleft" colspan="3">&nbsp;</td>
        </tr>

      <?php } ?>

      <!--      Subtotal    -->
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16"><?=db_formatar($fSubTotalTransferencias,"f"); ?></td>
      </tr>


<!--      TOTAL     -->
      <?php
      $dPorcentagem = 0.0;
      if ((int)$oInstit->getHabitantes() < 100000){
        $dPorcentagem = 0.07;
        $sPorcentagem = '7.00 %';
      }
      if ((int)$oInstit->getHabitantes() >= 100000 && (int)$oInstit->getHabitantes() <= 300000 ){
        $dPorcentagem = 0.06;
        $sPorcentagem = '6.00 %';
      }
      if ((int)$oInstit->getHabitantes() >= 300001 && (int)$oInstit->getHabitantes() <= 500000 ){
        $dPorcentagem = 0.05;
        $sPorcentagem = '5.00 %';
      }
      if ((int)$oInstit->getHabitantes() >= 500001 && (int)$oInstit->getHabitantes() <= 3000000 ){
        $dPorcentagem = 0.045;
        $sPorcentagem = '4.50 %';
      }
      if ((int)$oInstit->getHabitantes() >= 3000001 && (int)$oInstit->getHabitantes() <= 8000000 ){
        $dPorcentagem = 0.04;
        $sPorcentagem = '4.00 %';
      }
      if ((int)$oInstit->getHabitantes() > 8000001){
        $dPorcentagem = 0.035;
        $sPorcentagem = '3.50 %';
      }

      ?>
      <tr style='height:20px;'>
        <td class="s19 bdleft" colspan="2">TOTAL:</td>
        <td class="s20"><?=db_formatar($fSubTotalTransferencias+$fSubTotalImpostos,"f") ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">2 - População do Município: <?=$oInstit->getHabitantes()?> habitantes.</td>
        <td class="s18"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">3 - Percentual conforme população: <?=$sPorcentagem?></td>
        <td class="s18"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">4 - Limite conforme art. 29A, CF/88</td>
        <td class="s16"><?=db_formatar(($fSubTotalTransferencias+$fSubTotalImpostos)*$dPorcentagem,"f")?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s21 bdleft" colspan="2">REPASSE MENSAL ==&gt;</td>
        <td class="s22">
          <?=db_formatar((($fSubTotalTransferencias+$fSubTotalImpostos)*$dPorcentagem)/12,"f")?>
        </td>
      </tr>
      </tbody>
    </table>
  </div>

  </body>
  </html>

<?php

$html = ob_get_contents();
ob_end_clean();
//echo $html;
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
} catch (MpdfException $e) {
    db_redireciona('db_erros.php?fechar=true&db_erro='.$e->getMessage());
}
?>
