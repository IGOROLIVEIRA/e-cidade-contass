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

$mPDF = new mpdf('', 'A4-L', 0, '', 15, 15, 20, 15, 5, 11);


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
      .ritz .waffle .s4 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #d8d8d8; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s3 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-style : italic; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s19 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s21 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #d8d8d8; border-bottom : 0; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #ffffff; border-bottom : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #ffffff; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s16 { background-color : #ffffff; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s20 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 14pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #d8d8d8; border-bottom : 0; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s15 { background-color : #ffffff; border-bottom : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s17 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s18 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-bottom : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #ffffff; border-bottom : 0; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
    </style>
  </head>
  <body>
  
  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
        <th id="0C0" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C1" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C2" style="width:236px" class="column-headers-background">&nbsp;</th>
        <th id="0C3" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C4" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C5" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C6" style="width:273px" class="column-headers-background">&nbsp;</th>
        <th id="0C7" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C8" style="width:100px" class="column-headers-background">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <tr style='height:20px;'>
        <td class="s4 bdleft"></td>
        <td class="s5" colspan="4">BANCO RETIRADA</td>
        <td class="s5" colspan="4">BANCO DEP�SITO</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft">Data</td>
        <td class="s5">Red.</td>
        <td class="s5">Conta/Descri��o</td>
        <td class="s5">Fonte</td>
        <td class="s5">R$</td>
        <td class="s5">Red.</td>
        <td class="s5">Conta/Descri��o</td>
        <td class="s5">Fonte</td>
        <td class="s5">R$</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s6 bdleft">12/10/2016</td>
        <td class="s6">4964</td>
        <td class="s7 softmerge">
          <div class="softmerge-inner" style="width: 233px; left: -1px;">3.028-7 B.BRASIL S/A C/C - FPM</div>
        </td>
        <td class="s6">102</td>
        <td class="s8">1.000.000,00 </td>
        <td class="s6">4965</td>
        <td class="s7">3.028-7 B.BRASIL S/A APLIC - FPM</td>
        <td class="s6">102</td>
        <td class="s8">1.000.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">12/10/2016</td>
        <td class="s9">4534</td>
        <td class="s10">3.016-4 B.BRASIL S/A C/C - ITR</td>
        <td class="s9">100</td>
        <td class="s11">345,67 </td>
        <td class="s9">4535</td>
        <td class="s10">3.016-4 B.BRASIL S/A C/C - ITR</td>
        <td class="s9">100</td>
        <td class="s11">345,67 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s6 bdleft">12/10/2016</td>
        <td class="s6">4964</td>
        <td class="s7 softmerge">
          <div class="softmerge-inner" style="width: 233px; left: -1px;">3.028-7 B.BRASIL S/A C/C - FPM</div>
        </td>
        <td class="s12">102</td>
        <td class="s13">150.000,00 </td>
        <td class="s6">2232</td>
        <td class="s7 softmerge">
          <div class="softmerge-inner" style="width: 270px; left: -1px;">283.142-2 B.BRASIL C/C - SA�DE 15%</div>
        </td>
        <td class="s12">102</td>
        <td class="s13">150.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft"></td>
        <td class="s14"></td>
        <td class="s15" colspan="2">SubTotal=</td>
        <td class="s16">1.150.345,67 </td>
        <td class="s15" colspan="3">SubTotal=</td>
        <td class="s16">1.150.345,67 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s6 bdleft">12/13/2016</td>
        <td class="s6">4964</td>
        <td class="s7 softmerge">
          <div class="softmerge-inner" style="width: 233px; left: -1px;">3.028-7 B.BRASIL S/A C/C - FPM</div>
        </td>
        <td class="s6">101</td>
        <td class="s8">50.000,00 </td>
        <td class="s6">2238</td>
        <td class="s7 softmerge">
          <div class="softmerge-inner" style="width: 270px; left: -1px;">6.133-6 B.BRASIL S/A C/C - EDUCA��O 25%</div>
        </td>
        <td class="s6">101</td>
        <td class="s8">50.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">12/13/2016</td>
        <td class="s9">3254</td>
        <td class="s10 softmerge">
          <div class="softmerge-inner" style="width: 233px; left: -1px;">58.024-4 B.BRASIL S/A C/C - FUNDEB</div>
        </td>
        <td class="s9">118</td>
        <td class="s11">60.000,00 </td>
        <td class="s9">2240</td>
        <td class="s10 softmerge">
          <div class="softmerge-inner" style="width: 270px; left: -1px;">38.024-5 B.BRASIL S/A C/C - FUNDEB 60%</div>
        </td>
        <td class="s9">118</td>
        <td class="s11">60.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s6 bdleft">12/13/2016</td>
        <td class="s6">3254</td>
        <td class="s7 softmerge">
          <div class="softmerge-inner" style="width: 233px; left: -1px;">58.024-4 B.BRASIL S/A C/C - FUNDEB</div>
        </td>
        <td class="s12">119</td>
        <td class="s13">40.000,00 </td>
        <td class="s6">2241</td>
        <td class="s7 softmerge">
          <div class="softmerge-inner" style="width: 270px; left: -1px;">39.040-7 B.BRASIL S/A C/C - FUNDEB 40%</div>
        </td>
        <td class="s12">119</td>
        <td class="s13">40.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft"></td>
        <td class="s17"></td>
        <td class="s18" colspan="2">SubTotal=</td>
        <td class="s19">150.000,00 </td>
        <td class="s18" colspan="3">SubTotal=</td>
        <td class="s19">150.000,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s2 bdleft"></td>
        <td class="s2"></td>
        <td class="s20" colspan="2">TOTAL GERAL =</td>
        <td class="s21">1.300.345,67 </td>
        <td class="s2"></td>
        <td class="s20" colspan="2">TOTAL GERAL =</td>
        <td class="s21">1.300.345,67 </td>
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
db_fim_transacao();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();



?>