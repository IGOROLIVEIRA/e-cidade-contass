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

$mPDF = new mpdf('', '', 0, '', 15, 15, 20, 15, 5, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;border-bottom:1px solid #000;padding-bottom:6px;">
    <tr>
      <th>{$oInstit->getDescricao()}</th>
    </tr>
    <tr>
      <th>ANEXO I - B</th>
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
        <td class="s2">Exercício : 2013</td>
        <td class="s3 bdtop">Município : ICARAÍ DE MINAS</td>
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
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">1112.01.01</td>
        <td class="s9 softmerge">
          <div class="softmerge-inner" style="width: 436px; left: -1px;">Imposto sobre a Propriedade Territorial Rural ? Municípios Conveniados</div>
        </td>
        <td class="s10">0,00 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1112.02.00</td>
        <td class="s9">IPTU - Imposto sobre a Propriedade Predial e Territorial Urbana</td>
        <td class="s11">2.776,52 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1112.04.31</td>
        <td class="s9">Imposto de Renda Retido nas Fontes sobre os Rendimentos do</td>
        <td class="s12"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft"></td>
        <td class="s9">Trabalho</td>
        <td class="s10">211.539,30 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1112.04.34</td>
        <td class="s9">Imposto de Renda Retido nas Fontes sobre Outros Rendimentos</td>
        <td class="s10">20.327,46 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1112.08.00</td>
        <td class="s9">Imposto sobre Transmissão &#39;&#39;Inter-Vivos&#39;&#39; de Bens Imóveis e de</td>
        <td class="s12"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft"></td>
        <td class="s9">Direitos Reais sobre Imóveis</td>
        <td class="s10">8.727,04 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">00.1113.05.01</td>
        <td class="s14">Imposto sobre Serviços de Qualquer Natureza</td>
        <td class="s15">136.448,70 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16">379.819,02 </td>
      </tr>
      <tr style='height:20px;'>
        <td class="s7 bdleft" colspan="3">B - Taxas:</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1121.25.00</td>
        <td class="s9">Taxa Licença P/Func. Estab. Comercial, Industrial e Prest.</td>
        <td class="s12"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft"></td>
        <td class="s9">Serviços</td>
        <td class="s12"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1121.28.00</td>
        <td class="s9">Taxa de Funcionamento de Estabelecimento em Horário</td>
        <td class="s12"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft"></td>
        <td class="s9">Especial</td>
        <td class="s10">311,64</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s14 bdleft">00.1122.99.00</td>
        <td class="s14">Outras Taxas pela Prestação de Serviços</td>
        <td class="s15">5.887,48</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16">6.199,12</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s17 bdleft" colspan="3">D -  Transferências Correntes:</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1721.01.02</td>
        <td class="s9">Cota-Parte do Fundo de Participação dos Municípios</td>
        <td class="s10">8.583.724,90</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1721.01.05</td>
        <td class="s9">Cota-Parte do Imposto sobre a Propriedade Territorial Rural</td>
        <td class="s10">5.480,69</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1721.36.00</td>
        <td class="s9">Transferência Financeira do ICMS - Desoneração - LC 87/96</td>
        <td class="s10">13.581,72</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1722.01.01</td>
        <td class="s9">Cota-Parte do ICMS</td>
        <td class="s10">1.992.078,34</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1722.01.02</td>
        <td class="s9">Cota-Parte do Imposto sobre a Propriedade de Veículos</td>
        <td class="s12"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s13 bdleft"></td>
        <td class="s9">Automotores</td>
        <td class="s10">110.299,19</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1722.01.04</td>
        <td class="s9">Cota-Parte do IPI sobre Exportação</td>
        <td class="s10">35.976,02</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s9 bdleft">00.1722.01.13</td>
        <td class="s9">Cota-Parte da CIDE</td>
        <td class="s10">100,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s18 bdleft" colspan="3">&nbsp;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">Subtotal</td>
        <td class="s16">10.741.240,86</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s19 bdleft" colspan="2">TOTAL:</td>
        <td class="s20">11.127.259,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">2 - População do Município: 10.934 habitantes.</td>
        <td class="s18"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">3 - Percentual conforme população: 7,00 %</td>
        <td class="s18"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="2">4- Limite conforme art. 29A, CF/88</td>
        <td class="s16">778.908,13</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s21 bdleft" colspan="2">REPASSE MENSAL ==&gt;</td>
        <td class="s22">64.909,01</td>
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