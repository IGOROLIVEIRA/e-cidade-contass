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

include("vendor/mpdf/mpdf/mpdf.php");
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");

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
      <th>PREFEITURA MUNICIPAL DE BOTUMIRIM</th>
    </tr>
    <tr>
      <th>ANEXO I</th>
    </tr>
    <tr>
      <td style="text-align:right;font-size:10px;font-style:oblique;">Período: De 01/01/2016 a 30/06/2016</td>
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
.ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 14pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-style : italic; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s3 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s4 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s5 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s6 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s7 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s8 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s9 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s10 { background-color : #d8d8d8; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s11 { background-color : #d8d8d8; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s12 { background-color : #d8d8d8; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s13 { background-color : #d8d8d8; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s14 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s15 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #ff0000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s16 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s17 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s18 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s19 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #ff0000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s20 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s21 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
.ritz .waffle .s22 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
</style>

</head>
<body>

  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th id="0C0" style="width:40px" class="column-headers-background">&nbsp;</th>
          <th id="0C1" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C2" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C3" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C4" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C5" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C6" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C7" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C8" style="width:100px" class="column-headers-background">&nbsp;</th>
          <th id="0C9" style="width:100px" class="column-headers-background">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr style='height:20px;'>
          <td class="s3 bdleft bdtop" colspan="10">&nbsp;</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s4 bdleft" colspan="10">DEMONSTRATIVO DA APLICAÇÃO NA MANUTENÇÃO E DESENVOLVIMENTO DO ENSINO</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s4 bdleft" colspan="10">(ART. 212 DA CF, LEIS FEDERAIS Ns. 9.394/96 e 11.494/07, EC 53/06)</td>
        </tr>
        <tr style='height:20px;'>
          <td class="s5 bdleft" colspan="10">&nbsp;</td>
        </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">01 - Receitas </td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">A - Impostos:</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">11120101</td>
            <td class="s6" colspan="7">Imposto s/a Propriedade Territorial Rural ? Munic.Conv.</td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">11120200</td>
            <td class="s12" colspan="7">Imposto sobre a Propriedade Predial e Territorial Urbana ? IPTU</td>
            <td class="s13">424,83 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">11120431</td>
            <td class="s6" colspan="7">Imposto de Renda Retido nas Fontes ? IRRF (Trab.Assalariado)</td>
            <td class="s9">64.258,59 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">11120434</td>
            <td class="s12" colspan="7">Imposto de Renda Retido nas Fontes ? IRRF (Outros Rendimentos)</td>
            <td class="s13">9.537,92 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">11120800</td>
            <td class="s6" colspan="7">Imposto sobre Transmissão Inter-Vivos de Bens Imóveis ? ITBI</td>
            <td class="s9">2.508,49 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">11130500</td>
            <td class="s12" colspan="7">Imposto sobre Serviço de Qualquer Natureza ? ISS</td>
            <td class="s13">60.046,78 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">Subtotal</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s3 bdleft" colspan="9">&nbsp;</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">B - Transferências Correntes:</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">17210102</td>
            <td class="s6" colspan="7">Cota-parte do FPM </td>
            <td class="s9">3.778.438,56 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">17210103</td>
            <td class="s12" colspan="7">Cota-parte do FPM - 1%  de Dezembro</td>
            <td class="s13">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">17210104</td>
            <td class="s6" colspan="7">Cota-parte do FPM - 1%  de Julho</td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">17210105</td>
            <td class="s12" colspan="7">Transferência do  ITR</td>
            <td class="s13">369,15 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">17213600</td>
            <td class="s6" colspan="7">Transferência Financ.? Lei Comp.n. 87/96 ? ICMS Exp.</td>
            <td class="s9">7.134,54 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">17220101</td>
            <td class="s12" colspan="7">Participação no ICMS</td>
            <td class="s13">1.129.362,03 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">17220102</td>
            <td class="s6" colspan="7">Imposto sobre IPVA</td>
            <td class="s9">93.896,37 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">17220104</td>
            <td class="s12" colspan="7">Cota-parte do Imposto sobre Produtos Industrializados ? IPI</td>
            <td class="s13">14.283,18 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">Subtotal</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s3 bdleft" colspan="9">&nbsp;</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">C - Outras Receitas Correntes</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">19110801</td>
            <td class="s6" colspan="7">Multas e Juros de Mora do ITR-Munic.Conv.</td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">19113800</td>
            <td class="s12" colspan="7">Multas e Juros de Mora do IPTU </td>
            <td class="s13">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">19113900</td>
            <td class="s6" colspan="7">Multas e Juros de Mora do ITBI</td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">19114000</td>
            <td class="s12" colspan="7"> Multas e Juros de Mora do ISS </td>
            <td class="s13">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">19130800</td>
            <td class="s6" colspan="7">Multas e Juros de Mora da Dívida Ativa do ITR-Munic.Conv.</td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">19131100</td>
            <td class="s12" colspan="7">Multas e Juros de Mora da Dívida Ativa do IPTU </td>
            <td class="s13">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">19131200</td>
            <td class="s6" colspan="7">Multas e Juros de Mora da Dívida Ativa do ITBI </td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">19131300</td>
            <td class="s12" colspan="7">Multas e Juros de Mora da Dívida Ativa do ISS </td>
            <td class="s13">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">19310400</td>
            <td class="s6" colspan="7">Receita da Dívida Ativa do ITR - Munic.Conveniado</td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">19311100</td>
            <td class="s12" colspan="7">Receita da Dívida Ativa do IPTU </td>
            <td class="s13">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s8">19311200</td>
            <td class="s6" colspan="7">Receita da Dívida Ativa do ITBI </td>
            <td class="s9">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s10 bdleft"></td>
            <td class="s11">19311300</td>
            <td class="s12" colspan="7">Receita da Dívida Ativa do ISS </td>
            <td class="s13">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">Subtotal</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s3 bdleft" colspan="9">&nbsp;</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">D - Deduções das Receitas (exceto FUNDEB)</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s7 bdleft"></td>
            <td class="s14">98XXXXXX</td>
            <td class="s6" colspan="7">Retificações</td>
            <td class="s15">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s16 bdleft"></td>
            <td class="s17">99XXXXXX</td>
            <td class="s18" colspan="7">Outras Deduções</td>
            <td class="s19">0,00 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft" colspan="9">Subtotal</td>
            <td class="s3"></td>
          </tr>
          <tr style='height:20px;'>
            <td class="s6 bdleft bdbottom" colspan="9">&nbsp;</td>
            <td class="s3 bdbottom"></td>
          </tr>

          <tr style='height:20px;'>
            <td class="s20 bdleft" colspan="9">02 ? Total das Receitas (A+B+C-D)</td>
            <td class="s21">5.160.260,44 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s20 bdleft" colspan="9">03 ? Valor Legal Mínimo (art. 212 da CF) 25 % =</td>
            <td class="s21">1.290.065,11 </td>
          </tr>
          <tr style='height:20px;'>
            <td class="s20 bdleft" dir="ltr" colspan="9">04 ? Aplicação na Manut. e Desenv. Ensino (Anexo II) % =</td>
            <td class="s22"></td>
          </tr>
        </tbody>
      </table>
    </div>

  </body>
</html>

<?php

$html = ob_get_contents();
ob_end_clean();

$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

?>