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

$mPDF = new mpdf('', 'A4-L', 0, '', 10, 10, 20, 15, 8, 11);


$header = <<<HEADER
<header>
  <table style="width:100%;text-align:center;font-family:sans-serif;padding-bottom:6px;">
    <tr>
      <td>{$oInstit->getDescricao()}</td>
    </tr>
    <tr>
      <th>"DEPOSITOS DECENDIAIS EDUCAÇÃO & SAÚDE"</th>
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
      .ritz .waffle .s18 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s12 { background-color : #ffffff; border-right : none; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s15 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : center; text-decoration : underline; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s11 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s16 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : center; text-decoration : underline; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s4 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s14 { background-color : #ffffff; border-left : none; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s0 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial Black',Arial; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s13 { background-color : #ffffff; border-left : none; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s3 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s7 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-style : italic; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; text-decoration : underline; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s19 { background-color : #ffffff; border-bottom : 1px SOLID #000000; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s9 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s17 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s10 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; padding : 2px 3px 2px 3px; text-align : right; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s6 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-style : italic; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s1 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-style : italic; font-weight : bold; padding : 2px 3px 2px 3px; text-align : center; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s5 { background-color : #ffffff; border-right : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s8 { background-color : #ffffff; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 12pt; font-weight : bold; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }
      .ritz .waffle .s2 { background-color : #ffffff; border-bottom : 1px SOLID #000000; color : #000000; direction : ltr; font-family : 'Arial'; font-size : 10pt; padding : 2px 3px 2px 3px; text-align : left; vertical-align : bottom; white-space : nowrap; }</style>
  </head>
  <body>
  <div class="ritz grid-container" dir="ltr">
    <table class="waffle" cellspacing="0" cellpadding="0">
      <thead>
      <tr>
        <th id="0C0" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C1" style="width:129px" class="column-headers-background">&nbsp;</th>
        <th id="0C2" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C3" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C4" style="width:21px" class="column-headers-background">&nbsp;</th>
        <th id="0C5" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C6" style="width:134px" class="column-headers-background">&nbsp;</th>
        <th id="0C7" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C8" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C9" style="width:22px" class="column-headers-background">&nbsp;</th>
        <th id="0C10" style="width:100px" class="column-headers-background">&nbsp;</th>
        <th id="0C11" style="width:134px" class="column-headers-background">&nbsp;</th>
        <th id="0C12" style="width:107px" class="column-headers-background">&nbsp;</th>
        <th id="0C13" style="width:100px" class="column-headers-background">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      <tr style='height:20px;'>
        <td class="s2">&nbsp;</td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s3"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s3"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s2"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s4 bdleft" colspan="4">DE 01/01/2012 A 10/01/2012</td>
        <td class="s5"></td>
        <td class="s4" colspan="4">DE 11/01/2012 A 20/01/2012  </td>
        <td class="s5"></td>
        <td class="s4" colspan="4">DE 21/01/2012 A 30/01/2012</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s6 bdleft" colspan="3">Depositar até o dia 20</td>
        <td class="s7">&quot;Cheque&quot;</td>
        <td class="s5"></td>
        <td class="s6" colspan="3">Depositar até o dia 30</td>
        <td class="s7">&quot;Cheque&quot;</td>
        <td class="s5"></td>
        <td class="s6" colspan="3">Depositar até o dia 10 do mês subsequente</td>
        <td class="s7">&quot;Cheque&quot;</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft">IMPOSTOS</td>
        <td class="s3"></td>
        <td class="s9">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s8">IMPOSTOS</td>
        <td class="s3"></td>
        <td class="s9">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s8">IMPOSTOS</td>
        <td class="s3"></td>
        <td class="s9">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">11120200</td>
        <td class="s11">IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11120200</td>
        <td class="s11">IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11120200</td>
        <td class="s11">IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">11120430</td>
        <td class="s11">IRRF</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11120430</td>
        <td class="s11">IRRF</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11120430</td>
        <td class="s11">IRRF</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">11120800</td>
        <td class="s11">ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11120800</td>
        <td class="s11">ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11120800</td>
        <td class="s11">ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">11130500</td>
        <td class="s11">ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11130500</td>
        <td class="s11">ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">11130500</td>
        <td class="s11">ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="4">&nbsp;</td>
        <td class="s5"></td>
        <td class="s5" colspan="4"></td>
        <td class="s5"></td>
        <td class="s5" colspan="4"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s12 softmerge bdleft">
          <div class="softmerge-inner" style="width: 226px; left: -1px;">TRANSF.CONTITUCIONAIS</div>
        </td>
        <td class="s13"></td>
        <td class="s9">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s12 softmerge">
          <div class="softmerge-inner" style="width: 232px; left: -1px;">TRANSF.CONTITUCIONAIS</div>
        </td>
        <td class="s13"></td>
        <td class="s14">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s12 softmerge">
          <div class="softmerge-inner" style="width: 232px; left: -1px;">TRANSF.CONTITUCIONAIS</div>
        </td>
        <td class="s13"></td>
        <td class="s14">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">17210102</td>
        <td class="s11">FPM</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17210102</td>
        <td class="s11">FPM</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17210102</td>
        <td class="s11">FPM</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">17210105</td>
        <td class="s11">ITR</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17210105</td>
        <td class="s11">ITR</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17210105</td>
        <td class="s11">ITR</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">17213600</td>
        <td class="s11">ICMS EXP.</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17213600</td>
        <td class="s11">ICMS EXP.</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17213600</td>
        <td class="s11">ICMS EXP.</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">17220101</td>
        <td class="s11">ICMS EST.</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17220101</td>
        <td class="s11">ICMS EST.</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17220101</td>
        <td class="s11">ICMS EST.</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">17220102</td>
        <td class="s11">IPVA</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17220102</td>
        <td class="s11">IPVA</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17220102</td>
        <td class="s11">IPVA</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">17220104</td>
        <td class="s11">IPI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17220104</td>
        <td class="s11">IPI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">17220104</td>
        <td class="s11">IPI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="4">&nbsp;</td>
        <td class="s5"></td>
        <td class="s5" colspan="4"></td>
        <td class="s5"></td>
        <td class="s5" colspan="4"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s8 bdleft" colspan="2">OUT.REC.CORRENTES</td>
        <td class="s9">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s8" colspan="2">OUT.REC.CORRENTES</td>
        <td class="s9">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s8" colspan="2">OUT.REC.CORRENTES</td>
        <td class="s9">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">19113800</td>
        <td class="s11">Multas IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19113800</td>
        <td class="s11">Multas IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19113800</td>
        <td class="s11">Multas IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">19113900</td>
        <td class="s11">Multas ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19113900</td>
        <td class="s11">Multas ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19113900</td>
        <td class="s11">Multas ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">19114000</td>
        <td class="s11">Multas ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19114000</td>
        <td class="s11">Multas ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19114000</td>
        <td class="s11">Multas ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">19311100</td>
        <td class="s11">Dív.Ativa IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19311100</td>
        <td class="s11">Dív.Ativa IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19311100</td>
        <td class="s11">Dív.Ativa IPTU</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">19311200</td>
        <td class="s11">Dív.Ativa ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19311200</td>
        <td class="s11">Dív.Ativa ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19311200</td>
        <td class="s11">Dív.Ativa ITBI</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s10 bdleft">19311300</td>
        <td class="s11">Dív.Ativa ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19311300</td>
        <td class="s11">Dív.Ativa ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
        <td class="s5"></td>
        <td class="s10">19311300</td>
        <td class="s11">Dív.Ativa ISSQN</td>
        <td class="s10">0,00</td>
        <td class="s5"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s5 bdleft" colspan="4">&nbsp;</td>
        <td class="s5"></td>
        <td class="s5" colspan="4"></td>
        <td class="s5"></td>
        <td class="s5" colspan="4"></td>
      </tr>
      <tr style='height:20px;'>
        <td class="s3 bdleft"></td>
        <td class="s3"></td>
        <td class="s15">Educ.</td>
        <td class="s16">Saúde</td>
        <td class="s5"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s15">Educ.</td>
        <td class="s16">Saúde</td>
        <td class="s5"></td>
        <td class="s3"></td>
        <td class="s3"></td>
        <td class="s15">Educ.</td>
        <td class="s16">Saúde</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft">5.921-8 </td>
        <td class="s11">Tributos Mun.</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">5.921-8 </td>
        <td class="s11">Tributos Mun.</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">5.921-8 </td>
        <td class="s11">Tributos Mun.</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft">38.007-5</td>
        <td class="s11">FPM</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">38.007-5</td>
        <td class="s11">FPM</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">38.007-5</td>
        <td class="s11">FPM</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft">38.016-4</td>
        <td class="s11">ITR</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">38.016-4</td>
        <td class="s11">ITR</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">38.016-4</td>
        <td class="s11">ITR</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft">283.142-2</td>
        <td class="s11 softmerge">
          <div class="softmerge-inner" style="width: 126px; left: -1px;">ICMS Des.Export.</div>
        </td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">283.142-2</td>
        <td class="s11 softmerge">
          <div class="softmerge-inner" style="width: 131px; left: -1px;">ICMS Des.Export.</div>
        </td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">283.142-2</td>
        <td class="s11 softmerge">
          <div class="softmerge-inner" style="width: 131px; left: -1px;">ICMS Des.Export.</div>
        </td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft">3612-4</td>
        <td class="s11">ICMS Est. &amp; IPI</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">3612-4</td>
        <td class="s11">ICMS Est. &amp; IPI</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
        <td class="s5"></td>
        <td class="s11">3612-4</td>
        <td class="s11">ICMS Est. &amp; IPI</td>
        <td class="s10">0,00</td>
        <td class="s17">0,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s11 bdleft">1927-8</td>
        <td class="s11">IPVA</td>
        <td class="s18">0,00</td>
        <td class="s19">0,00</td>
        <td class="s5"></td>
        <td class="s11">1927-8</td>
        <td class="s11">IPVA</td>
        <td class="s18">0,00</td>
        <td class="s19">0,00</td>
        <td class="s5"></td>
        <td class="s11">1927-8</td>
        <td class="s11">IPVA</td>
        <td class="s18">0,00</td>
        <td class="s19">0,00</td>
      </tr>
      <tr style='height:20px;'>
        <td class="s2 bdleft"></td>
        <td class="s2"></td>
        <td class="s18">0,00</td>
        <td class="s19">0,00</td>
        <td class="s5"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s18">0,00</td>
        <td class="s19">0,00</td>
        <td class="s5"></td>
        <td class="s2"></td>
        <td class="s2"></td>
        <td class="s18">0,00</td>
        <td class="s19">0,00</td>
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