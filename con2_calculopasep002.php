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
$oPeriodo = new Periodo($o116_periodo);
$aDecendios = DBDate::getDecendio($oPeriodo->getMesInicial(),$anousu);
$aDecendios[0][2] = "Depositar at� o dia 20";
$aDecendios[1][2] = "Depositar at� o dia 30";
$aDecendios[2][2] = "Depositar at� o dia 10 do m�s subsequente";

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);
if(count($aInstits) > 1){
  $oInstit = new Instituicao(db_getsession("db_instit"));
} else {
  foreach ($aInstits as $iInstit) {
    $oInstit = new Instituicao($iInstit);
  }
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
      <th>"C�LCULO PARA CONTRIBUI��O DO PASEP"</th>
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
      .ritz .waffle .s3 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s4 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Calibri',Arial; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #d8d8d8; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #bfbfbf; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 11pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
    </style>
  
  </head>
  <body>


  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <tbody>
      <tr style=''>
        <td class="s0 bdtop bdleft" colspan="2">C�LCULO PARA CONTRIBUI��O DO PASEP</td>
      </tr>
      <tr style=''>
        <td class="s0 bdleft" colspan="2">I - RECEITAS</td>
      </tr>
      <tr style=''>
        <td class="s0 bdleft" colspan="2">Inc. III, do art. 2�, da Lei n.� 9.715/98</td>
      </tr>
      <tr style=''>
        <td class="s1 bdleft" style="width:700px">Receitas Correntes (L�quida de dedu��es)</td>
        <td class="s2" style="width:172px">VALOR</td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1100.00.00.00 - Receitas Tribut�rias ?</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1200.00.00.00 - Receita de Contribui��es -</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1300.00.00.00 - Receita Patrimonial -</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1400.00.00.00 - Receita Agropecu�ria -</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1500.00.00.00 - Receita Industrial -</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1600.00.00.00 - Receita de Servi�os -</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1700.00.00.00 - Transfer�ncias Correntes ?</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">1900.00.00.00 - Outras receitas correntes -</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s1 bdleft">Sub-Total I -</td>
        <td class="s5">0,00</td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">2400.00.00.00 - Transfer�ncias de Capital</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s1 bdleft">Sub-Total II -</td>
        <td class="s5">0,00</td>
      </tr>
      <tr style=''>
        <td class="s1 bdleft">Total das Receitas (I) -</td>
        <td class="s5">0,00</td>
      </tr>
      <tr style=''>
        <td class="s0 bdleft" colspan="2">II - EXCLUS�ES DA RECEITA</td>
      </tr>
      <tr style=''>
        <td class="s6 bdleft">Base Legal </td>
        <td class="s6">VALOR</td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">Transfer�ncias de Conv�nios (� 7�, do art. 2�, da Lei n.� 9.715/98) -</td>
        <td class="s4"></td>
      </tr>
      <tr>
        <td class="s3 bdleft" dir="ltr">
          Contrato de repasse ou instrumento cong�nere com objeto definido (� 7�, do art. 2�, da Lei n.�
          <br/> 9.715/98)
        </td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">Transfer�ncias a outras Entidades de Direito P�blico Interno (art. 7�, da Lei n.� 9.715/98) -</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft" dir="ltr">
          Transfer�ncias efetuadas � Uni�o, aos Estados, ao Distrito Federal e a outros Munic�pios, bem
          <br>como �s autarquias dessas entidades (Solu��o de Consulta RFB n.� 31, de 28 de fevereiro de
          <br>2013 - 6� Regi�o Fiscal - D.O.U.: 05.03.2013)
        </td>
        <td class="s3" dir="ltr"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft" dir="ltr">
          Transfer�ncias efetuadas � Institui��es Multigovernamentais Nacionais (criadas e mantidas por
          <br>dois ou mais entes da Federa��o) de car�ter p�blico, criadas por lei. (Solu��o de Consulta RFB
          <br>n.� 31, de 28 de fevereiro de 2013 - 6� Regi�o Fiscal - D.O.U.: 05.03.2013)
        </td>
        <td class="s3" dir="ltr"></td>
      </tr>
      <tr style=''>
        <td class="s1 bdleft">Total das exclus�es da Receita (II) -</td>
        <td class="s5">0,00 </td>
      </tr>
      <tr style=''>
        <td class="s7 bdleft">III - TOTAL RECEITA L�QUIDA (BASE DE C�LCULO) (I-II) -</td>
        <td class="s8">0,00</td>
      </tr>
      <tr style=''>
        <td class="s9 bdleft">IV ? RETEN��ES DO PASEP NA FONTE</td>
        <td class="s6">VALOR</td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">FPM - Fundo de Participa��o dos Munic�pios</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">F.E.P. - Fundo Especial Petr�leo</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">ICMS - Desonera��o das Exporta��es - LC n.� 87/96</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">ITR - Imposto Territorial Rural</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">CFM - Depto Nacional de Produ��o Mineral</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">CIDE ? Contribui��es de Interven��o no Dom�nio Econ�mico</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">CFH - Cota parte Compensa��o Finan. Rec. H�dricos</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">FEX - Aux�lio Financeiro para Fomento Exporta��es / AFM - Apoio Financeiro aos Munic�pios</td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft" dir="ltr">
          Outras transfer�ncias correntes e de capital recebidas, se comprovada a reten��o na fonte, pela
          <br>Secretaria do Tesouro Nacional - STN, da contribui��o incidente sobre tais valores.
        </td>
        <td class="s4"></td>
      </tr>
      <tr style=''>
        <td class="s1 bdleft">TOTAL DOS VALORES RETIDOS (IV) -</td>
        <td class="s5">0,00 </td>
      </tr>
      <tr style=''>
        <td class="s6 bdleft">RESUMO</td>
        <td class="s10">0,00 </td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">a) Total da Receita L�quida (III) -</td>
        <td class="s5">0,00 </td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">b) 1% sobre total das Receitas (a*1%) -</td>
        <td class="s5">0,00</td>
      </tr>
      <tr style=''>
        <td class="s3 bdleft">c) PASEP retido na Fonte (IV) -</td>
        <td class="s5">0,00 </td>
      </tr>
      <tr style=''>
        <td class="s7 bdleft">RESULTADO DO C�LCULO (b-c)</td>
        <td class="s8">0,00 </td>
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
//echo $html;

?>