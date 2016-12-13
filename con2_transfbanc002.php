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

$mPDF = new mpdf('', 'A4-L', 0, '', 10, 10, 20, 15, 5, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>TRANSFER�NCIAS BANC�RIAS</th>
    </tr>
    <tr>
      <td style="text-align:right;font-size:10px;font-style:oblique;">Per�odo: De {$DBtxt21} a {$DBtxt22}</td>
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
      .ritz .waffle .s4 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #d8d8d8; border-bottom : none; border-right : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-style : italic; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s16 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s18 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #d8d8d8; border-bottom : none; border-right : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #ffffff; border-bottom : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #ffffff; border-bottom : none; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-bottom : none; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s17 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 14pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #d8d8d8; border-bottom : none; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #ffffff; border-bottom : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s15 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #ffffff; border-bottom : none; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
    </style>
  </head>
  <body>
  
  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
        <th id="0C0" style="width:118px" class="column-headers-background">&nbsp;</th>
        <th id="0C1" style="width:83px" class="column-headers-background">&nbsp;</th>
        <th id="0C2" style="width:324px" class="column-headers-background">&nbsp;</th>
        <th id="0C3" style="width:87px" class="column-headers-background">&nbsp;</th>
        <th id="0C4" style="width:134px" class="column-headers-background">&nbsp;</th>
        <th id="0C5" style="width:138px" class="column-headers-background">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <tr style='height:20px;'>
        <td class="s3 bdleft"></td>
        <td class="s4" colspan="5">BANCOS</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s4 bdleft">Data</td>
        <td class="s4">Red.</td>
        <td class="s4">Conta/Descri��o</td>
        <td class="s4">Fonte</td>
        <td class="s4">Retiradas</td>
        <td class="s4">Depositos</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft">12/10/2016</td>
        <td class="s5">4964</td>
        <td class="s6">3.028-7 B.BRASIL S/A C/C - FPM</td>
        <td class="s5">102</td>
        <td class="s7">1.000.000,00 </td>
        <td class="s7">1.000.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft">12/10/2016</td>
        <td class="s8">4534</td>
        <td class="s9">3.016-4 B.BRASIL S/A C/C - ITR</td>
        <td class="s8">100</td>
        <td class="s10">345,67 </td>
        <td class="s10">345,67 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft">12/10/2016</td>
        <td class="s5">4964</td>
        <td class="s6">3.028-7 B.BRASIL S/A C/C - FPM</td>
        <td class="s11">102</td>
        <td class="s12">150.000,00 </td>
        <td class="s12">150.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft" colspan="4">SubTotal=</td>
        <td class="s14">1.150.345,67 </td>
        <td class="s14">1.150.345,67 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft">12/13/2016</td>
        <td class="s5">4964</td>
        <td class="s6">3.028-7 B.BRASIL S/A C/C - FPM</td>
        <td class="s5">101</td>
        <td class="s7">50.000,00 </td>
        <td class="s7">50.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft">12/13/2016</td>
        <td class="s8">3254</td>
        <td class="s9">58.024-4 B.BRASIL S/A C/C - FUNDEB</td>
        <td class="s8">118</td>
        <td class="s10">60.000,00 </td>
        <td class="s10">60.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft">12/13/2016</td>
        <td class="s5">3254</td>
        <td class="s6">58.024-4 B.BRASIL S/A C/C - FUNDEB</td>
        <td class="s11">119</td>
        <td class="s12">40.000,00 </td>
        <td class="s12">40.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s15 bdleft" colspan="4">SubTotal=</td>
        <td class="s16">150.000,00 </td>
        <td class="s16">150.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft" colspan="4">TOTAL GERAL =</td>
        <td class="s18">1.300.345,67 </td>
        <td class="s18">1.300.345,67 </td>
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