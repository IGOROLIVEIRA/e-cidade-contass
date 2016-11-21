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
db_inicio_transacao();

$sWhereReceita      = "o70_instit in ({$instits})";
$rsBalanceteReceita = db_receitasaldo( 3, 1, 3, true,
  $sWhereReceita, $anousu,
  $dtini,
  $datafin );

if (pg_num_rows($rsBalanceteReceita) == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado, verifique as datas e tente novamente');
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

$mPDF = new mpdf('', 'A4-L', 0, '', 5, 5, 21, 15, 5, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>DEMONSTRATIVO DE MOVIMENTO NUMERÁRIO</th>
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
      .ritz .waffle .s37 { background-color : #ffffff; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s43 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s34 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #bfbfbf; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Arial Black',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s18 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Cantata One',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
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
        <td class="s0 bdtop bdright bdleft bdbottom" colspan="13">DEMONSTRATIVO DE MOVIMENTO NUMERÁRIO</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s1 bdleft" colspan="4">PREFEITURA MUNICIPAL DE MODELO</td>
        <td class="s2" colspan="4">ENTRADAS</td>
        <td class="s2" colspan="5">SAÍDAS</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3 bdleft" colspan="4">CNPJ: 25.224.304/0001-63</td>
        <td class="s4">RECEITAS</td>
        <td class="s4">Orçamentárias</td>
        <td class="s5"></td>
        <td class="s6">#REF!</td>
        <td class="s4">DESPESAS</td>
        <td class="s4">Orçamentárias</td>
        <td class="s5"></td>
        <td class="s6" colspan="2">#REF!</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3 bdleft" colspan="4">Rua Antônio da Rocha, s/nº - Centro</td>
        <td class="s5"></td>
        <td class="s4">Extras</td>
        <td class="s5"></td>
        <td class="s6">#REF!</td>
        <td class="s5"></td>
        <td class="s4">Extras</td>
        <td class="s5"></td>
        <td class="s6" colspan="2">#REF!</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3 bdleft" colspan="4">CEP: 39.318-000</td>
        <td class="s5"></td>
        <td class="s4">Inscrição Restos a Pagar</td>
        <td class="s5"></td>
        <td class="s6">0,00 </td>
        <td class="s5"></td>
        <td class="s4">Restos a Pagar</td>
        <td class="s5"></td>
        <td class="s6" colspan="2">#REF!</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s7 bdleft" colspan="4"></td>
        <td class="s8">TRANSFERÊNCIAS DEPÓSITOS</td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s10">#REF!</td>
        <td class="s8">TRANSFERÊNCIAS RETIRADAS</td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s10" colspan="2">#REF!</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft" colspan="4">EXERCÍCIO FINANCEIRO DE 2017</td>
        <td class="s12" colspan="3">SALDO ANT.</td>
        <td class="s13">#REF!</td>
        <td class="s12" colspan="3">SALDO ATUAL</td>
        <td class="s13" colspan="2"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft" colspan="4">MÊS DE REFERÊNCIA: ABRIL</td>
        <td class="s15" colspan="3">TOTAL:</td>
        <td class="s16">#REF!</td>
        <td class="s15" colspan="4">TOTAL:</td>
        <td class="s17">#REF!</td>
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

      <?php for ($iCont = 0; $iCont < 12; $iCont++): ?>
      <tr style='height:20px;'>
        <td class="s21 bdleft">53.034-6</td>
        <td class="s22">B.Brasil S/A FUNDEB 40%</td>
        <td class="s21">C/C</td>
        <td class="s21">119</td>
        <td class="s23">0,00 </td>
        <td class="s23">33.333,33 </td>
        <td class="s23">1.633,47 </td>
        <td class="s23">0,00 </td>
        <td class="s23">25.321,00 </td>
        <td class="s23">0,00 </td>
        <td class="s23">1.748,00 </td>
        <td class="s23">7.000,00 </td>
        <td class="s24">897,80 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s25 bdleft"></td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s26">100</td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s28">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s29 bdleft"></td>
        <td class="s29"></td>
        <td class="s29"></td>
        <td class="s21">101</td>
        <td class="s23">0,00 </td>
        <td class="s23">0,00 </td>
        <td class="s23">0,00 </td>
        <td class="s23">0,00 </td>
        <td class="s23">0,00 </td>
        <td class="s23">0,00 </td>
        <td class="s23">0,00 </td>
        <td class="s23">0,00 </td>
        <td class="s24">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s25 bdleft"></td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s26">102</td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s27">0,00 </td>
        <td class="s28">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s30 bdleft"></td>
        <td class="s31" colspan="3">Saldo Total</td>
        <td class="s31">0,00 </td>
        <td class="s31">33.333,33 </td>
        <td class="s31">1.633,47 </td>
        <td class="s31">0,00 </td>
        <td class="s31">25.321,00 </td>
        <td class="s31">0,00 </td>
        <td class="s31">1.748,00 </td>
        <td class="s31">7.000,00 </td>
        <td class="s32">897,80 </td>
      </tr>
      <?php endfor; ?>

      <tr style='height:20px;'>
        <td class="s33 bdleft" colspan="4">TOTAL GERAL</td>
        <td class="s33">#REF!</td>
        <td class="s33">#REF!</td>
        <td class="s33">#REF!</td>
        <td class="s33">#REF!</td>
        <td class="s33">#REF!</td>
        <td class="s33">#REF!</td>
        <td class="s33">#REF!</td>
        <td class="s33">#REF!</td>
        <td class="s34">#REF!</td>
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
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s36">FONTES:</td>
        <td class="s26">100</td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s37"></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s38"></td>
        <td class="s21">101</td>
        <td class="s29"></td>
        <td class="s29"></td>
        <td class="s29"></td>
        <td class="s39"></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s5"></td>
        <td class="s26">102</td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s37"></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s38"></td>
        <td class="s21">118</td>
        <td class="s29"></td>
        <td class="s29"></td>
        <td class="s29"></td>
        <td class="s39"></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s5"></td>
        <td class="s26">119</td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s25"></td>
        <td class="s37"></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s40"></td>
        <td class="s41">148</td>
        <td class="s42"></td>
        <td class="s42"></td>
        <td class="s42"></td>
        <td class="s43"></td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s40"></td>
        <td class="s44">TOTAL...:</td>
        <td class="s45"></td>
        <td class="s45"></td>
        <td class="s45"></td>
        <td class="s46"></td>
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
      <tr style='height:20px;'>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s7"></td>
        <td class="s8">CONTAS CORRENTES</td>
        <td class="s18"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s18"></td>
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
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s18"></td>
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
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s9"></td>
        <td class="s18"></td>
        <td class="s5"></td>
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

?>