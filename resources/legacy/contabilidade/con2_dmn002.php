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
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
include_once("dbforms/db_funcoes.php");

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

$mPDF = new \Mpdf\Mpdf([
    'mode' => '',
    'format' => 'A4-L',
    'orientation' => 'L',
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 5,
    'margin_bottom' => 15,
    'margin_header' => 5,
    'margin_footer' => 11,
]);
$footer = <<<FOOTER
<div style='border-top:1px solid #000;width:100%;text-align:right;font-family:sans-serif;font-size:10px;height:10px;'>
  {PAGENO}
</div>
FOOTER;


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();
$aDadosRelatorio = getDados($dtini, $dtfim, $aInstits, $anousu,$contas,$o15_codigo);

?>

  <html>
  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
      .ritz .waffle a { color : inherit; }
      .ritz .waffle .s37 { background-color : #ffffff; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s43 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s34 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #bfbfbf; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Arial Black',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s18 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s39 { background-color : #d8d8d8; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s42 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s23 { background-color : #d8d8d8; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s21 { background-color : #d8d8d8; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s45 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s20 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s17 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s30 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s32 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s28 { background-color : #ffffff; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s33 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s16 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s25 { background-color : #ffffff; border-bottom : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s46 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s31 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s44 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s35 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 14pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s38 { background-color : #ffffff; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s41 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s22 { background-color : #d8d8d8; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s26 { background-color : #ffffff; border-bottom : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s36 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s27 { background-color : #ffffff; border-bottom : 0; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s4 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s19 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s40 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s24 { background-color : #d8d8d8; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s29 { background-color : #d8d8d8; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s15 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s3 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
    </style>
  </head>
  <body>

  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
        <th id="0C0" style="width:120px" class="column-headers-background">&nbsp;</th>
        <th id="0C1" style="width:301px" class="column-headers-background">&nbsp;</th>
        <th id="0C2" style="width:44px" class="column-headers-background">&nbsp;</th>
        <th id="0C3" style="width:48px" class="column-headers-background">&nbsp;</th>
        <th id="0C4" style="width:247px" class="column-headers-background">&nbsp;</th>
        <th id="0C5" style="width:190px" class="column-headers-background">&nbsp;</th>
        <th id="0C6" style="width:90px" class="column-headers-background">&nbsp;</th>
        <th id="0C7" style="width:116px" class="column-headers-background">&nbsp;</th>
        <th id="0C8" style="width:247px" class="column-headers-background">&nbsp;</th>
        <th id="0C9" style="width:114px" class="column-headers-background">&nbsp;</th>
        <th id="0C10" style="width:85px" class="column-headers-background">&nbsp;</th>
        <th id="0C11" style="width:117px" class="column-headers-background">&nbsp;</th>
        <th id="0C12" style="width:86px" class="column-headers-background">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <tr style='height:20px;'>
        <td class="s0 bdtop bdright bdleft bdbottom" colspan="13">DEMONSTRATIVO DE MOVIMENTO BANCÁRIO</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1 bdleft" colspan="4"><?=$oInstit->getDescricao()?></td>
        <td class="s2" colspan="4">ENTRADAS</td>
        <td class="s2" colspan="5">SAÍDAS</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3 bdleft" colspan="4">CNPJ: <?=db_formatar($oInstit->getCNPJ(),'cnpj')?></td>
        <td class="s4">RECEITAS</td>
        <td class="s4">Orçamentárias</td>
        <td class="s5"></td>
        <td class="s6"><?php $fTotalReceitaOrcamentaria = RelatorioDMN::getTotalReceitaOrcamentaria($aDadosRelatorio); echo db_formatar($fTotalReceitaOrcamentaria,"f"); $aTotalEntradas[] = $fTotalReceitaOrcamentaria; ?></td>
        <td class="s4">DESPESAS</td>
        <td class="s4">Orçamentárias</td>
        <td class="s5"></td>
        <td class="s6" colspan="2"><?php $fTotalDespesaOrcamentaria = RelatorioDMN::getTotalDespesaOrcamentaria($aDadosRelatorio); echo db_formatar($fTotalDespesaOrcamentaria,"f"); $aTotalSaidas[] = $fTotalDespesaOrcamentaria; ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3 bdleft" colspan="4"><?=$oInstit->getLogradouro().", ".$oInstit->getNumero()." - ".$oInstit->getBairro()?></td>
        <td class="s5"></td>
        <td class="s4">Extras</td>
        <td class="s5"></td>
        <td class="s6"><?php $fTotalReceitaExtra = RelatorioDMN::getTotalReceitaExtra($aDadosRelatorio); echo db_formatar($fTotalReceitaExtra,"f"); $aTotalEntradas[] = $fTotalReceitaExtra; ?></td>
        <td class="s5"></td>
        <td class="s4">Extras</td>
        <td class="s5"></td>
        <td class="s6" colspan="2"><?php $fTotalDespesaExtra = RelatorioDMN::getTotalDespesaExtra($aDadosRelatorio); echo db_formatar($fTotalDespesaExtra,"f"); $aTotalSaidas[] = $fTotalDespesaExtra; ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3 bdleft" colspan="4">CEP: <?=db_formatar($oInstit->getCep(),'cep')?></td>
        <td class="s5"></td>
        <td class="s4">Inscrição Restos a Pagar</td>
        <td class="s5"></td>
        <td class="s6"><?php $fTotalInscricaoRP = 0; if($dtfim == "{$anousu}-12-31" || $dtini == "{$anousu}-12-31") { $fTotalInscricaoRP = RelatorioDMN::getDadosInscricaoRP($aInstits); } echo db_formatar($fTotalInscricaoRP,"f"); $aTotalEntradas[] = $fTotalInscricaoRP;  ?></td>
        <td class="s5"></td>
        <td class="s4">Restos a Pagar</td>
        <td class="s5"></td>
        <td class="s6" colspan="2"><?php $fTotalRP = RelatorioDMN::getTotalRP($aDadosRelatorio); echo db_formatar($fTotalRP,"f"); $aTotalSaidas[] = $fTotalRP; ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s7 bdleft" colspan="4"></td>
        <td class="s8">TRANSFERÊNCIAS DEPÓSITOS</td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s10"><?php $fTotalTransferenciasDepositos = RelatorioDMN::getTotalTransferenciasDepositos($aDadosRelatorio); echo db_formatar($fTotalTransferenciasDepositos,"f"); $aTotalEntradas[] = $fTotalTransferenciasDepositos; ?></td>
        <td class="s8">TRANSFERÊNCIAS RETIRADAS</td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s10" colspan="2"><?php $fTotalTransferenciasRetiradas = RelatorioDMN::getTotalTransferenciasRetiradas($aDadosRelatorio); echo db_formatar($fTotalTransferenciasRetiradas,"f"); $aTotalSaidas[] = $fTotalTransferenciasRetiradas; ?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft" colspan="4">EXERCÍCIO FINANCEIRO DE <?=$anousu?></td>
        <td class="s12" colspan="3">SALDO ANT.</td>
        <td class="s13"><?php $fTotalSaldoAnterior = RelatorioDMN::getTotalSaldoAnterior($aDadosRelatorio); echo db_formatar($fTotalSaldoAnterior,"f"); $aTotalEntradas[] = $fTotalSaldoAnterior;?></td>
        <td class="s12" colspan="3">SALDO ATUAL</td>
        <td class="s13" colspan="2"><?php $fTotalSaldoFinal = RelatorioDMN::getTotalSaldoFinal($aDadosRelatorio); echo db_formatar($fTotalSaldoFinal,"f"); $aTotalSaidas[] = $fTotalSaldoFinal;?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft" colspan="4">PERÍODO DE REFERÊNCIA: <?=db_formatar($dtini,'d')." à ".db_formatar($dtfim,'d')?></td>
        <td class="s15" colspan="3">TOTAL:</td>
        <td class="s16"><?=db_formatar(array_sum($aTotalEntradas),'f')?></td>
        <td class="s15" colspan="4">TOTAL:</td>
        <td class="s17"><?=db_formatar(array_sum($aTotalSaidas),'f')?></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s18"></td>
        <td class="s19" colspan="3">ENTRADAS</td>
        <td class="s19" colspan="5">SAÍDAS</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s18"></td>
        <td class="s20">Saldo</td>
        <td class="s2" colspan="2">Receitas</td>
        <td class="s20">Transferências</td>
        <td class="s2" colspan="3">Despesas</td>
        <td class="s20">Transferências</td>
        <td class="s20">Saldo</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s2 bdleft">Conta</td>
        <td class="s2">Descrição</td>
        <td class="s2">TIPO</td>
        <td class="s2">Fonte</td>
        <td class="s2">Anterior</td>
        <td class="s2">Orçamentária</td>
        <td class="s2">Extra</td>
        <td class="s2">Depósitos</td>
        <td class="s2">Orçamentária</td>
        <td class="s2">RP</td>
        <td class="s2">Extra</td>
        <td class="s2">Retiradas</td>
        <td class="s2">Atual</td>
      </tr>

      <?php

      $bFil = false;
      $sBackGround = "style='background-color: #d8d8d8;'";
      $fTotalSaldoAnterior = 0;
      $fTotalReceitaOrcamentaria = 0;
      $fTotalReceitaExtra = 0;
      $fTotalTransferenciasDepositos = 0;
      $fTotalDespesaOrcamentaria = 0;
      $fTotalRP = 0;
      $fTotalDespesaExtra = 0;
      $fTotalTransferenciasRetiradas = 0;
      $fTotalSaldoFinal = 0;

      foreach ($aDadosRelatorio as $oDadosAgrupados) {

        $aPrimeiroElemento = array_shift($oDadosAgrupados->aDadosAgrupados);
        if($aPrimeiroElemento->fValorReceitaOrcamentaria == 0 && $aPrimeiroElemento->fValorReceitaExtra == 0 && $aPrimeiroElemento->fValorDespesaExtra == 0 && $aPrimeiroElemento->fValorDespesaOrcamentaria == 0 &&
            $aPrimeiroElemento->fValorRP == 0 && $aPrimeiroElemento->fValorTransferenciasRetiradas == 0 && $aPrimeiroElemento->fValorTransferenciasDepositos == 0 && $aPrimeiroElemento->fSaldoAnterior == 0 && $aPrimeiroElemento->fSaldoFinal == 0){
          continue;
        }

        ?>
        <tr style='height:20px;'>
          <td  class="s25 bdleft"><?= $aPrimeiroElemento->iConta ?></td>
          <td  class="s25"><?= $aPrimeiroElemento->sDescricao ?></td>
          <td  class="s25"><?= $aPrimeiroElemento->sDescTipoConta ?></td>
          <td  class="s26"><?= $aPrimeiroElemento->iFonte ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fSaldoAnterior, "f") ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fValorReceitaOrcamentaria, "f") ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fValorReceitaExtra, "f") ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fValorTransferenciasDepositos, "f") ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fValorDespesaOrcamentaria, "f") ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fValorRP, "f") ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fValorDespesaExtra, "f") ?></td>
          <td  class="s27"><?= db_formatar($aPrimeiroElemento->fValorTransferenciasRetiradas, "f") ?></td>
          <td  class="s28"><?= db_formatar($aPrimeiroElemento->fSaldoFinal, "f") ?></td>
        </tr>

        <?php
        $fSubTotalSaldoAnterior = $aPrimeiroElemento->fSaldoAnterior;
        $fSubTotalReceitaOrcamentaria = $aPrimeiroElemento->fValorReceitaOrcamentaria;
        $fSubTotalReceitaExtra = $aPrimeiroElemento->fValorReceitaExtra;
        $fSubTotalTransferenciasDepositos = $aPrimeiroElemento->fValorTransferenciasDepositos;
        $fSubTotalDespesaOrcamentaria = $aPrimeiroElemento->fValorDespesaOrcamentaria;
        $fSubTotalRP = $aPrimeiroElemento->fValorRP;
        $fSubTotalDespesaExtra = $aPrimeiroElemento->fValorDespesaExtra;
        $fSubTotalTransferenciasRetiradas = $aPrimeiroElemento->fValorTransferenciasRetiradas;
        $fSubTotalSaldoFinal = $aPrimeiroElemento->fSaldoFinal;
          $bFil = false;
        foreach ($oDadosAgrupados->aDadosAgrupados as $oDadosAgrupadosFonte) {

          $bFil = $bFil ? false : true;
          $sBackGround = $bFil ? "style='background-color: #d8d8d8;'" : "";
          ?>
          <tr style='height:20px;'>
            <td <?= $sBackGround ?> class="s25 bdleft"></td>
            <td <?= $sBackGround ?> class="s25"></td>
            <td <?= $sBackGround ?> class="s25"></td>
            <td <?= $sBackGround ?> class="s26"><?= $oDadosAgrupadosFonte->iFonte ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fSaldoAnterior, "f") ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fValorReceitaOrcamentaria, "f") ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fValorReceitaExtra, "f") ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fValorTransferenciasDepositos, "f") ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fValorDespesaOrcamentaria, "f") ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fValorRP, "f") ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fValorDespesaExtra, "f") ?></td>
            <td <?= $sBackGround ?> class="s27"><?= db_formatar($oDadosAgrupadosFonte->fValorTransferenciasRetiradas, "f") ?></td>
            <td <?= $sBackGround ?> class="s28"><?= db_formatar($oDadosAgrupadosFonte->fSaldoFinal, "f") ?></td>
          </tr>

        <?php
          $fSubTotalSaldoAnterior += $oDadosAgrupadosFonte->fSaldoAnterior;
          $fSubTotalReceitaOrcamentaria += $oDadosAgrupadosFonte->fValorReceitaOrcamentaria;
          $fSubTotalReceitaExtra += $oDadosAgrupadosFonte->fValorReceitaExtra;
          $fSubTotalTransferenciasDepositos += $oDadosAgrupadosFonte->fValorTransferenciasDepositos;
          $fSubTotalDespesaOrcamentaria += $oDadosAgrupadosFonte->fValorDespesaOrcamentaria;
          $fSubTotalRP += $oDadosAgrupadosFonte->fValorRP;
          $fSubTotalDespesaExtra += $oDadosAgrupadosFonte->fValorDespesaExtra;
          $fSubTotalTransferenciasRetiradas += $oDadosAgrupadosFonte->fValorTransferenciasRetiradas;
          $fSubTotalSaldoFinal += $oDadosAgrupadosFonte->fSaldoFinal;
          }
        ?>
        <tr style='height:20px;'>
          <td class="s30 bdleft"></td>
          <td class="s31" colspan="3">Sub Total</td>
          <td class="s31"><?=db_formatar($fSubTotalSaldoAnterior,"f")?></td>
          <td class="s31"><?=db_formatar($fSubTotalReceitaOrcamentaria,"f")?></td>
          <td class="s31"><?=db_formatar($fSubTotalReceitaExtra,"f")?></td>
          <td class="s31"><?=db_formatar($fSubTotalTransferenciasDepositos,"f")?></td>
          <td class="s31"><?=db_formatar($fSubTotalDespesaOrcamentaria,"f")?></td>
          <td class="s31"><?=db_formatar($fSubTotalRP,"f")?></td>
          <td class="s31"><?=db_formatar($fSubTotalDespesaExtra,"f")?></td>
          <td class="s31"><?=db_formatar($fSubTotalTransferenciasRetiradas,"f")?></td>
          <td class="s32"><?=db_formatar($fSubTotalSaldoFinal,"f")?></td>
        </tr>
      <?php
        $fTotalSaldoAnterior += $fSubTotalSaldoAnterior;
        $fTotalReceitaOrcamentaria += $fSubTotalReceitaOrcamentaria;
        $fTotalReceitaExtra += $fSubTotalReceitaExtra;
        $fTotalTransferenciasDepositos += $fSubTotalTransferenciasDepositos;
        $fTotalDespesaOrcamentaria += $fSubTotalDespesaOrcamentaria;
        $fTotalRP += $fSubTotalRP;
        $fTotalDespesaExtra += $fSubTotalDespesaExtra;
        $fTotalTransferenciasRetiradas += $fSubTotalTransferenciasRetiradas;
        $fTotalSaldoFinal += $fSubTotalSaldoFinal;
      }
      ?>
      <tr style='height:20px;'>
        <td class="s33 bdleft" colspan="4">TOTAL GERAL</td>
        <td class="s33"><?=db_formatar($fTotalSaldoAnterior,"f")?></td>
        <td class="s33"><?=db_formatar($fTotalReceitaOrcamentaria,"f")?></td>
        <td class="s33"><?=db_formatar($fTotalReceitaExtra,"f")?></td>
        <td class="s33"><?=db_formatar($fTotalTransferenciasDepositos,"f")?></td>
        <td class="s33"><?=db_formatar($fTotalDespesaOrcamentaria,"f")?></td>
        <td class="s33"><?=db_formatar($fTotalRP,"f")?></td>
        <td class="s33"><?=db_formatar($fTotalDespesaExtra,"f")?></td>
        <td class="s33"><?=db_formatar($fTotalTransferenciasRetiradas,"f")?></td>
        <td class="s34"><?=db_formatar($fTotalSaldoFinal,"f")?></td>
      </tr>
      <tr style='height:50px;'>
        <td class="s5" colspan="13">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s35 bdtop" colspan="2">RESUMOS</td>
        <td class="s2 bdtop">SALDO INICIAL</td>
        <td class="s2 bdtop">ENTRADAS</td>
        <td class="s2 bdtop">SAÍDAS</td>
        <td class="s2 bdtop">SALDO ATUAL</td>
        <td class="s5"></td>
      </tr>
      <?php
      $aTotalPorFonte = RelatorioDMN::getTotalPorFonte($aDadosRelatorio);
      $oPrimeira = array_shift($aTotalPorFonte);
      ?>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s36">FONTES:</td>
        <td class="s26"><?= $oPrimeira->iFonte ?></td>
        <td class="s25"><?= db_formatar($oPrimeira->fSaldoInicial, 'f') ?></td>
        <td class="s25"><?= db_formatar($oPrimeira->fTotalEntradas, 'f') ?></td>
        <td class="s25"><?= db_formatar($oPrimeira->fTotalSaidas, 'f') ?></td>
        <td class="s37"><?= db_formatar($oPrimeira->fSaldoAtual, 'f') ?></td>
        <td class="s5"></td>
      </tr>
      <?php
      $fTotalInicialPorFonte = $oPrimeira->fSaldoInicial;
      $fTotalEntradasPorFonte = $oPrimeira->fTotalEntradas;
      $fTotalSaidasPorFonte = $oPrimeira->fTotalSaidas;
      $fTotalFinalPorFonte = $oPrimeira->fSaldoAtual;
      $bFil = false;
      foreach ($aTotalPorFonte as $oTotalPorFonte) {
        $bFil = $bFil ? false : true;
        $sBackGround = $bFil ? "style='background-color: #d8d8d8;'" : "";
        ?>
        <tr style='height:20px;'>
          <td class="s5"></td>
          <td class="s5"></td>
          <td class="s5"></td>
          <td class="s5"></td>
          <td class="s5"></td>
          <td class="s7"></td>
          <td class="s36"></td>
          <td <?= $sBackGround ?> class="s26"><?= $oTotalPorFonte->iFonte ?></td>
          <td <?= $sBackGround ?> class="s25"><?= db_formatar($oTotalPorFonte->fSaldoInicial, 'f') ?></td>
          <td <?= $sBackGround ?> class="s25"><?= db_formatar($oTotalPorFonte->fTotalEntradas, 'f') ?></td>
          <td <?= $sBackGround ?> class="s25"><?= db_formatar($oTotalPorFonte->fTotalSaidas, 'f') ?></td>
          <td <?= $sBackGround ?> class="s37"><?= db_formatar($oTotalPorFonte->fSaldoAtual, 'f') ?></td>
          <td class="s5"></td>
        </tr>
      <?php
        $fTotalInicialPorFonte += $oTotalPorFonte->fSaldoInicial;
        $fTotalEntradasPorFonte += $oTotalPorFonte->fTotalEntradas;
        $fTotalSaidasPorFonte += $oTotalPorFonte->fTotalSaidas;
        $fTotalFinalPorFonte += $oTotalPorFonte->fSaldoAtual;
      }
      ?>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s40"></td>
        <td class="s44">TOTAL...:</td>
        <td class="s45"><?=db_formatar($fTotalInicialPorFonte,'f')?></td>
        <td class="s45"><?=db_formatar($fTotalEntradasPorFonte,'f')?></td>
        <td class="s45"><?=db_formatar($fTotalSaidasPorFonte,'f')?></td>
        <td class="s46"><?=db_formatar($fTotalFinalPorFonte,'f')?></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5">&nbsp;</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s5"></td>
      </tr>
      <?php
      $oTotalContaCorrente = RelatorioDMN::getTotalPorTipoConta($aDadosRelatorio);
      ?>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s8">CONTAS CORRENTES</td>
        <td class="s18"></td>
        <td class="s9"><?=db_formatar($oTotalContaCorrente->fValorAnteriorContaCorrente,'f')?></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s18"><?=db_formatar($oTotalContaCorrente->fValorFinalContaCorrente,'f')?></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s8">CONTAS APLIC.FINANCEIRAS</td>
        <td class="s18"></td>
        <td class="s9"><?=db_formatar($oTotalContaCorrente->fValorAnteriorContaAplic,'f')?></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s18"><?=db_formatar($oTotalContaCorrente->fValorFinalContaAplic,'f')?></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s10">TOTAL...:</td>
        <td class="s9"><?=db_formatar($oTotalContaCorrente->fValorAnteriorContaCorrente+$oTotalContaCorrente->fValorAnteriorContaAplic,'f')?></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s18"><?=db_formatar($oTotalContaCorrente->fValorFinalContaCorrente+$oTotalContaCorrente->fValorFinalContaAplic,'f')?></td>
        <td class="s5"></td>
      </tr>
      </tbody>
    </table>
  </div>

  </body>
  </html>

<?php
/**
 * Função que busca todos os dados necessários para a geração do relatório e agrupa tudo em um array
 * @param $sDtIni
 * @param $sDtFim
 * @param $aInstit
 * @param $iAnousu
 * @param $aContas
 * @param $sFonte
 * @return array
 */
function getDados($sDtIni, $sDtFim, $aInstit, $iAnousu,$aContas, $sFonte)
{

  $aDadosgeral = RelatorioDMN::getContas($iAnousu, $aInstit, $sDtIni, $sDtFim,$aContas, $sFonte);

  foreach ($aDadosgeral as $oConta) {

    $aDadosAgrupados = array();

    foreach ($oConta->aFontes as $oContaPorFonte) {

      if (!isset($aDadosAgrupados[$oConta->iConta . $oContaPorFonte->fonte])) {
        $oDados = new RelatorioDMN($oConta->iConta,$oContaPorFonte->fonte,$oConta->iInstit,$oConta->iContaBancaria);
        $oDados->fValorReceitaOrcamentaria= RelatorioDMN::getDadosReceitaOrcamentaria($iAnousu, $oConta->iInstit, $sDtIni, $sDtFim, $oConta->iConta, $oContaPorFonte->fonte);
        $oDados->fValorReceitaExtra = RelatorioDMN::getDadosReceitaExtra($iAnousu, $oConta->iInstit, $sDtIni, $sDtFim,$oConta->iConta, $oContaPorFonte->fonte);
        $oDados->fValorDespesaExtra = RelatorioDMN::getDadosDespesaExtra($iAnousu, $oConta->iInstit, $sDtIni, $sDtFim,$oConta->iConta, $oContaPorFonte->fonte);
        $oDados->fValorDespesaOrcamentaria = RelatorioDMN::getDadosDespesaOrcamentaria($iAnousu, $oConta->iInstit, $sDtIni, $sDtFim,$oConta->iConta, $oContaPorFonte->fonte);
        $oDados->fValorRP = RelatorioDMN::getDadosRP($iAnousu, $oConta->iInstit, $sDtIni, $sDtFim,$oConta->iConta, $oContaPorFonte->fonte);
        $oDados->fValorTransferenciasRetiradas = RelatorioDMN::getDadosTransferenciasRetiradas($iAnousu, $oConta->iInstit, $sDtIni, $sDtFim,$oConta->iConta, $oContaPorFonte->fonte);
        $oDados->fValorTransferenciasDepositos = RelatorioDMN::getDadosTransferenciasDepositos($iAnousu, $oConta->iInstit, $sDtIni, $sDtFim,$oConta->iConta, $oContaPorFonte->fonte);
        $oRetorno = RelatorioDMN::getSaldoCtbFonte($iAnousu, $oConta->iConta, $oContaPorFonte->fonte, $sDtIni, $sDtFim, $oConta->iInstit);
        $oDados->fSaldoAnterior = $oRetorno->fSaldoInicialMes;
        $oDados->fSaldoFinal = $oRetorno->fSaldoFinal;
        if($oDados->fValorReceitaOrcamentaria != 0 || $oDados->fValorReceitaExtra != 0 || $oDados->fValorDespesaExtra != 0 || $oDados->fValorDespesaOrcamentaria != 0 ||
            $oDados->fValorRP != 0 || $oDados->fValorTransferenciasRetiradas != 0 || $oDados->fValorTransferenciasDepositos != 0 || $oDados->fSaldoAnterior != 0 || $oDados->fSaldoFinal != 0) {
          $aDadosAgrupados[$oConta->iConta . $oContaPorFonte->fonte] = $oDados;
          $oConta->fSubTotalSaldoAnterior += $oDados->fSaldoAnterior;
          $oConta->fSubTotalSaldoFinal += $oDados->fSaldoFinal;
          $oConta->fSubTotalReceitaOrcamentaria += $oDados->fValorReceitaOrcamentaria;
          $oConta->fSubTotalReceitaExtra += $oDados->fValorReceitaExtra;
          $oConta->fSubTotalRP += $oDados->fValorRP;
          $oConta->fSubTotalTransferenciasDepositos += $oDados->fValorTransferenciasDepositos;
          $oConta->fSubTotalDespesaOrcamentaria += $oDados->fValorDespesaOrcamentaria;
          $oConta->fSubTotalDespesaExtra += $oDados->fValorDespesaExtra;
          $oConta->fSubTotalTransferenciasRetiradas += $oDados->fValorTransferenciasRetiradas;
          $oConta->aDadosAgrupados = $aDadosAgrupados;
        }

      }
    }
  }
  return $aDadosgeral;
}


$html = ob_get_contents();
ob_end_clean();
//echo $html;
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

?>
