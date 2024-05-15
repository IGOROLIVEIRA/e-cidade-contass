<?php
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
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");

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
        <td class="s7 bdleft" colspan="3">A -  Impostos:</td>
      </tr>
      <?php
      $fSubTotalImposto = 0;
      $aDadosReceita = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte like '4111%'");
      foreach($aDadosReceita as $oReceita){
        $fSubTotalImposto += $oReceita->saldo_arrecadado_acumulado;
        ?>
        <tr style='height:20px;'>
          <td class="s9 bdleft"><?=db_formatar($oReceita->o57_fonte,"sistema")?></td>
          <td class="s9 softmerge">
            <div class="softmerge-inner" style="width: 436px; left: -1px;"><?=$oReceita->o57_descr?></div>
          </td>
          <td class="s10">
            <?=db_formatar($oReceita->saldo_arrecadado_acumulado,"f")?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s8 bdleft" colspan="3">&nbsp;</td>
        </tr>
      <?php } ?>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16"><?=db_formatar($fSubTotalImposto,"f"); ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s7 bdleft" colspan="3">B - Taxas:</td>
      </tr>
      <?php
      $fSubTotalTaxas = 0;
      $aDadosTaxas = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte like '4112%'");
      foreach($aDadosTaxas as $oTaxa){
        $fSubTotalTaxas += $oTaxa->saldo_arrecadado_acumulado;
        ?>
        <tr style='height:20px;'>
          <td class="s9 bdleft"><?=db_formatar($oTaxa->o57_fonte,"sistema")?></td>
          <td class="s9 softmerge">
            <div class="softmerge-inner" style="width: 436px; left: -1px;"><?=$oTaxa->o57_descr?></div>
          </td>
          <td class="s10">
            <?=db_formatar($oTaxa->saldo_arrecadado_acumulado,"f")?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s8 bdleft" colspan="3">&nbsp;</td>
        </tr>
      <?php } ?>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16"><?=db_formatar($fSubTotalTaxas,"f"); ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft" colspan="3">C - Outras Receitas:</td>
      </tr>
      <?php
      $fSubTotalOutras = 0;
      $aDadosOutras1 = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte like '41911%'");
      foreach($aDadosOutras1 as $oOutras1){
        $fSubTotalOutras += $oOutras1->saldo_arrecadado_acumulado;
        ?>
        <tr style='height:20px;'>
          <td class="s9 bdleft"><?=db_formatar($oOutras1->o57_fonte,"sistema")?></td>
          <td class="s9 softmerge">
            <div class="softmerge-inner" style="width: 436px; left: -1px;"><?=$oOutras1->o57_descr?></div>
          </td>
          <td class="s10">
            <?=db_formatar($oOutras1->saldo_arrecadado_acumulado,"f")?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s8 bdleft" colspan="3">&nbsp;</td>
        </tr>
      <?php }
      $aDadosOutras2 = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte like '41913%'");
      foreach($aDadosOutras2 as $oOutras2){
        $fSubTotalOutras += $oOutras2->saldo_arrecadado_acumulado;
        ?>
        <tr style='height:20px;'>
          <td class="s9 bdleft"><?=db_formatar($oOutras2->o57_fonte,"sistema")?></td>
          <td class="s9 softmerge">
            <div class="softmerge-inner" style="width: 436px; left: -1px;"><?=$oOutras2->o57_descr?></div>
          </td>
          <td class="s10">
            <?=db_formatar($oOutras2->saldo_arrecadado_acumulado,"f")?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s8 bdleft" colspan="3">&nbsp;</td>
        </tr>
      <?php }
      $aDadosOutras3 = getSaldoReceita(null,"distinct o57_fonte,o57_descr,saldo_arrecadado_acumulado",null,"o57_fonte like '41931%'");
      foreach($aDadosOutras3 as $oOutras3){
        $fSubTotalOutras += $oOutras3->saldo_arrecadado_acumulado;
        ?>
        <tr style='height:20px;'>
          <td class="s9 bdleft"><?=db_formatar($oOutras3->o57_fonte,"sistema")?></td>
          <td class="s9 softmerge">
            <div class="softmerge-inner" style="width: 436px; left: -1px;"><?=$oOutras3->o57_descr?></div>
          </td>
          <td class="s10">
            <?=db_formatar($oOutras3->saldo_arrecadado_acumulado,"f")?>
          </td>
        </tr>
        <tr style='height:20px;'>
          <td class="s8 bdleft" colspan="3">&nbsp;</td>
        </tr>
      <?php } ?>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16"><?=db_formatar($fSubTotalOutras,"f"); ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft" colspan="3">D -  Transferências Correntes:</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172101030000","sistema")?></td>
        <td class="s9">Cota-parte do FPM - 1%  de Dezembro</td>
        <td class="s10">
          <?php
          $aDadosFPM1DEZ = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417210103%'");
          $fFPM1DEZ = count($aDadosFPM1DEZ) > 0 ? $aDadosFPM1DEZ[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fFPM1DEZ, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172101040000","sistema")?></td>
        <td class="s9">Cota-parte do FPM - 1%  de Julho</td>
        <td class="s10">
          <?php
          $aDadosFPM1JUL = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417210104%'");
          $fFPM1JUL = count($aDadosFPM1JUL) > 0 ? $aDadosFPM1JUL[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fFPM1JUL, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172101020000","sistema")?></td>
        <td class="s9">Cota-Parte do Fundo de Participação dos Municípios</td>
        <td class="s10">
          <?php
          $aDadosFPM = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417210102%'");
          $fFPM = count($aDadosFPM) > 0 ? $aDadosFPM[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fFPM, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172101050000","sistema")?></td>
        <td class="s9">Cota-Parte do Imposto sobre a Propriedade Territorial Rural</td>
        <td class="s10">
          <?php
          $aDadosITR = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417210105%'");
          $fITR = count($aDadosITR) > 0 ? $aDadosITR[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fITR, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172136000000","sistema")?></td>
        <td class="s9">Transferência Financeira do ICMS - Desoneração - LC 87/96</td>
        <td class="s10">
          <?php
          $aDadosICMS = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '4172136%'");
          $fICMS = count($aDadosICMS) > 0 ? $aDadosICMS[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fICMS, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172201010000","sistema")?></td>
        <td class="s9">Cota-Parte do ICMS</td>
        <td class="s10">
          <?php
          $aDadosPARTICMS = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417220101%'");
          $fPARTICMS = count($aDadosPARTICMS) > 0 ? $aDadosPARTICMS[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fPARTICMS, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172201020000","sistema")?></td>
        <td class="s9">Cota-Parte do Imposto sobre a Propriedade de Veículos</td>
        <td class="s12"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft"></td>
        <td class="s9">Automotores</td>
        <td class="s10">
          <?php
          $aDadosIPVA = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417220102%'");
          $fIPVA = count($aDadosIPVA) > 0 ? $aDadosIPVA[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fIPVA, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172201040000","sistema")?></td>
        <td class="s9">Cota-Parte do IPI sobre Exportação</td>
        <td class="s10">
          <?php
          $aDadosIPI = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417220104%'");
          $fIPI = count($aDadosIPI) > 0 ? $aDadosIPI[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fIPI, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"><?=db_formatar("4172201130000","sistema")?></td>
        <td class="s9">Cota-Parte da CIDE</td>
        <td class="s10">
          <?php
          $aDadosCIDE = getSaldoReceita(null,"sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado",null,"o57_fonte like '417220113%'");
          $fCIDE = count($aDadosCIDE) > 0 ? $aDadosCIDE[0]->saldo_arrecadado_acumulado : 0;
          echo db_formatar($fCIDE, "f");
          ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s18 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16">
          <?php $fSubTotalCorrentes = array_sum(array($fFPM,$fFPM1DEZ,$fFPM1JUL,$fITR,$fICMS,$fPARTICMS,$fIPVA,$fIPI,$fCIDE)); echo db_formatar($fSubTotalCorrentes,"f"); ?>
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s19 bdleft" colspan="2">TOTAL:</td>
        <td class="s20"><?=db_formatar($fSubTotalCorrentes+$fSubTotalImposto+$fSubTotalTaxas+$fSubTotalOutras,"f") ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">2 - População do Município: <?=$oInstit->getHabitantes()?> habitantes.</td>
        <td class="s18"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">3 - Percentual conforme população: 7,00 %</td>
        <td class="s18"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">4- Limite conforme art. 29A, CF/88</td>
        <td class="s16"><?=db_formatar(($fSubTotalCorrentes+$fSubTotalImposto+$fSubTotalTaxas+$fSubTotalOutras)*0.07,"f")?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s21 bdleft" colspan="2">REPASSE MENSAL ==&gt;</td>
        <td class="s22">
          <?=db_formatar((($fSubTotalCorrentes+$fSubTotalImposto+$fSubTotalTaxas+$fSubTotalOutras)*0.07)/12,"f")?>
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
