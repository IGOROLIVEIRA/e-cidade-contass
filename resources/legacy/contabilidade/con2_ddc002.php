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
db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);
foreach($aInstits as $iInstit){
  $oInstit = new Instituicao($iInstit);
  if($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA){
    break;
  }
}
//db_inicio_transacao();
//
//$sWhereDespesa      = " o58_instit in({$instits})";
//$rsBalanceteDespesa = db_dotacaosaldo( 8,2,2, true, $sWhereDespesa,
//    $anousu,
//    $dtini,
//    $datafin);
//if (pg_num_rows($rsBalanceteDespesa) == 0) {
//  db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado, verifique as datas e tente novamente');
//}
//
//$sWhereReceita      = "o70_instit in ({$instits})";
//$rsBalanceteReceita = db_receitasaldo( 3, 1, 3, true,
//    $sWhereReceita, $anousu,
//    $dtini,
//    $datafin );

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
    'margin_left' => 10,
    'margin_right' => 10,
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
      <th>TRANSFERÊNCIAS BANCÁRIAS</th>
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
//$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
//$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

?>

  <html>
  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
      .ritz .waffle a { color : inherit; }
      .ritz .waffle .s9 { background-color : #bfbfbf; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #bfbfbf; border-right : 1px solid #000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #bfbfbf; border-right : 1px solid #000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s15 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s18 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s3 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s19 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #bfbfbf; border-right : 1px solid #000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #bfbfbf; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s16 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s17 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s4 { background-color : #bfbfbf; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #bfbfbf; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 9pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
    </style>
  </head>
  <body>

  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
        <th id="0C0" style="width:67px" class="column-headers-background">&nbsp;</th>
        <th id="0C1" style="width:83px" class="column-headers-background">&nbsp;</th>
        <th id="0C2" style="width:80px" class="column-headers-background">&nbsp;</th>
        <th id="0C3" style="width:83px" class="column-headers-background">&nbsp;</th>
        <th id="0C4" style="width:320px" class="column-headers-background">&nbsp;</th>
        <th id="0C5" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C6" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C7" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C8" style="width:95px" class="column-headers-background">&nbsp;</th>
        <th id="0C9" style="width:93px" class="column-headers-background">&nbsp;</th>
        <th id="0C10" style="width:93px" class="column-headers-background">&nbsp;</th>
        <th id="0C11" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C12" style="width:115px" class="column-headers-background">&nbsp;</th>
        <th id="0C13" style="width:126px" class="column-headers-background">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <tr style='height:20px;'>
        <td class="s0" colspan="14">PREFEITURA MUNICIPAL DE TESTE</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1" colspan="14">CONSOLIDADO - PORTARIA 733/2014</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1" colspan="14">ANEXO 16 - Balanço Geral</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1" colspan="14">Demonstrativo Das Dívidas Fundadas Internas e Externas</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1" colspan="14">Exercício de 2016</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s2" colspan="14">Lei 4.320/64, Art. 101 e 105, inc. IV, §4º, Portaria STN Nº 437/2012</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s0" colspan="14">DEMONSTRATIVOS DAS DÍVIDAS FUNDADAS INTERNAS</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3">&nbsp;</td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s3"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s4 bdleft"></td>
        <td class="s5" colspan="5">ATUALIZAÇÕES</td>
        <td class="s6">Saldo do </td>
        <td class="s7" colspan="3">MOVIMENTAÇÃO NO EXERCÍCIO - ACRÉSCIMOS</td>
        <td class="s7" colspan="3">MOVIMENTAÇÃO NO EXERCÍCIO - DECRÉSCIMOS</td>
        <td class="s8">Saldo p/ o</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">Nr.</td>
        <td class="s9">Lei</td>
        <td class="s9">Data</td>
        <td class="s9">Contrato</td>
        <td class="s9">Credor</td>
        <td class="s9">Valor</td>
        <td class="s6">Exercício</td>
        <td class="s6">Contratação</td>
        <td class="s10">Atualização</td>
        <td class="s11">CAPITALIZAÇÃO</td>
        <td class="s10">Amortização</td>
        <td class="s12">Pagto. Encargos</td>
        <td class="s12">Resgate Escritural</td>
        <td class="s12">Exercício Seguinte</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft"></td>
        <td class="s13"></td>
        <td class="s13"></td>
        <td class="s13"></td>
        <td class="s13"></td>
        <td class="s13"></td>
        <td class="s10 bdbottom">Anterior(A)</td>
        <td class="s11 bdbottom">
          Encampação(B)
        </td>
        <td class="s7">(C)</td>
        <td class="s7">(D)</td>
        <td class="s7">(E)</td>
        <td class="s7">(F)</td>
        <td class="s10 bdbottom">(G)</td>
        <td class="s12 bdbottom">
          H=(A+B+C+D-E-F-G)
        </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">01</td>
        <td class="s14">12810/2013</td>
        <td class="s14">8/31/2013</td>
        <td class="s14">-</td>
        <td class="s15">
          INSS - INSTITUTO NACIONAL DE SEGURIDADE SOCIAL
        </td>
        <td class="s16">1.200.000,00 </td>
        <td class="s16">610.000,00 </td>
        <td class="s16">590.000,00 </td>
        <td class="s16">36.000,00 </td>
        <td class="s16">0,00 </td>
        <td class="s16">156.000,00 </td>
        <td class="s16">21.000,00 </td>
        <td class="s16">0,00 </td>
        <td class="s16">1.059.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">02</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">03</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">04</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">05</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">06</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">07</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft">08</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft">09</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft">10</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft">11</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft">12</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft">13</td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s15 bdleft"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s15 bdleft"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s15 bdleft"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s15"></td>
        <td class="s16">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s18 bdleft" colspan="5">TOTAIS</td>
        <td class="s19">1.200.000,00 </td>
        <td class="s19">610.000,00 </td>
        <td class="s19">590.000,00 </td>
        <td class="s19">36.000,00 </td>
        <td class="s19">0,00 </td>
        <td class="s19">156.000,00 </td>
        <td class="s19">21.000,00 </td>
        <td class="s19">0,00 </td>
        <td class="s19">1.059.000,00 </td>
      </tr>
      </tbody>
    </table>
  </div>

  </body>
  </html>

<?php

$html = ob_get_contents();
ob_end_clean();
//db_query("drop table if exists work_dotacao");
//db_query("drop table if exists work_receita");
//db_fim_transacao();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
//echo $html;


?>
