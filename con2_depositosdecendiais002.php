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
    <?php for ($nCount = 0; $nCount < 3; $nCount++): ?>
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
          <td class="s0 bdtop bdleft" colspan="4">DE 01/01/2012 A 10/01/2012</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s1 bdleft" colspan="3">Depositar at� o dia 20</td>
          <td class="s2">&quot;Cheque&quot;</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s3 bdleft" colspan="2">IMPOSTOS</td>
          <td class="s4">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11120200</td>
          <td class="s7">IPTU</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11120430</td>
          <td class="s7">IRRF</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11120800</td>
          <td class="s7">ITBI</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">11130500</td>
          <td class="s7">ISSQN</td>
          <td class="s6">0,00</td>
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
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17210105</td>
          <td class="s7">ITR</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17213600</td>
          <td class="s7">ICMS EXP.</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17220101</td>
          <td class="s7">ICMS EST.</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17220102</td>
          <td class="s7">IPVA</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">17220104</td>
          <td class="s7">IPI</td>
          <td class="s6">0,00</td>
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
          <td class="s6 bdleft">19113800</td>
          <td class="s7">Multas IPTU</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19113900</td>
          <td class="s7">Multas ITBI</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19114000</td>
          <td class="s7">Multas ISSQN</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19311100</td>
          <td class="s7">D�v.Ativa IPTU</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19311200</td>
          <td class="s7">D�v.Ativa ITBI</td>
          <td class="s6">0,00</td>
          <td class="s5"></td>
        </tr>
        <tr style='height:20px;'>
          <td class="s6 bdleft">19311300</td>
          <td class="s7">D�v.Ativa ISSQN</td>
          <td class="s6">0,00</td>
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
          <td class="s7 bdleft">5.921-8 </td>
          <td class="s7">Tributos Mun.</td>
          <td class="s6">0,00</td>
          <td class="s11">0,00</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">38.007-5</td>
          <td class="s7">FPM</td>
          <td class="s6">0,00</td>
          <td class="s11">0,00</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">38.016-4</td>
          <td class="s7">ITR</td>
          <td class="s6">0,00</td>
          <td class="s11">0,00</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">283.142-2</td>
          <td class="s7 softmerge">
            <div class="softmerge-inner" style="width: 131px; left: -1px;">ICMS Des.Export.</div>
          </td>
          <td class="s6">0,00</td>
          <td class="s11">0,00</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">3612-4</td>
          <td class="s7">ICMS Est. &amp; IPI</td>
          <td class="s6">0,00</td>
          <td class="s11">0,00</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s7 bdleft">1927-8</td>
          <td class="s7">IPVA</td>
          <td class="s12">0,00</td>
          <td class="s13">0,00</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s14 bdleft"></td>
          <td class="s14"></td>
          <td class="s12">0,00</td>
          <td class="s13">0,00</td>
        </tr>
        </tbody>
      </table>
    </div>
    <?php endfor; ?>
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